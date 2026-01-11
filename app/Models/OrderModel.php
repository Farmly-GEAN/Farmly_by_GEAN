<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create Order
    public function createOrder($buyer_id, $total_amount, $address) {
        $sql = "INSERT INTO Orders (Buyer_ID, Total_Amount, Order_Date, Order_Status, Shipping_Address) 
                VALUES (:buyer_id, :total, NOW(), 'Pending', :address) RETURNING Order_ID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id, ':total' => $total_amount, ':address' => $address]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['order_id'];
    }

    // 2. Add Item AND Deduct Stock
    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO Order_Details (Order_ID, Product_ID, Quantity, Price_Per_Unit) 
                VALUES (:order_id, :product_id, :qty, :price)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':order_id' => $order_id, ':product_id' => $product_id, ':qty' => $quantity, ':price' => $price]);
        $this->deductStock($product_id, $quantity);
    }

    // Helper: Deduct Stock
    private function deductStock($product_id, $quantity) {
        $sql = "UPDATE Product SET Stocks_Available = Stocks_Available - :qty WHERE Product_ID = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':qty' => $quantity, ':pid' => $product_id]);
    }

    // 3. Clear Cart
    public function clearCart($buyer_id) {
        $sql = "DELETE FROM Cart WHERE Buyer_ID = :buyer_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
    }

    // 4. Get Orders (Standard)
    public function getOrdersByBuyer($buyer_id) {
        $sql = "SELECT * FROM Orders WHERE Buyer_ID = :buyer_id ORDER BY Order_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Cancel Order
    public function cancelOrder($order_id, $buyer_id) {
        $checkSql = "SELECT Order_Status FROM Orders WHERE Order_ID = :oid AND Buyer_ID = :bid";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':oid' => $order_id, ':bid' => $buyer_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order || $order['order_status'] !== 'Pending') { return false; }

        $itemsSql = "SELECT Product_ID, Quantity FROM Order_Details WHERE Order_ID = :oid";
        $stmt = $this->conn->prepare($itemsSql);
        $stmt->execute([':oid' => $order_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($items as $item) {
            $restoreSql = "UPDATE Product SET Stocks_Available = Stocks_Available + :qty WHERE Product_ID = :pid";
            $updateStmt = $this->conn->prepare($restoreSql);
            $updateStmt->execute([':qty' => $item['quantity'], ':pid' => $item['product_id']]);
        }

        $cancelSql = "UPDATE Orders SET Order_Status = 'Cancelled' WHERE Order_ID = :oid";
        $cancelStmt = $this->conn->prepare($cancelSql);
        $cancelStmt->execute([':oid' => $order_id]);
        return true;
    }

    // 6. Get Seller Orders (With Filter)
    public function getSellerOrders($seller_id, $filter = 'all') {
        $sql = "SELECT o.Order_ID, o.Order_Date, o.Total_Amount, o.Order_Status AS Status, o.Shipping_Address,
                       b.Buyer_Name, b.Buyer_Phone,
                       p.Product_Name, od.Quantity
                FROM Orders o
                JOIN Order_Details od ON o.Order_ID = od.Order_ID
                JOIN Product p ON od.Product_ID = p.Product_ID
                JOIN Buyer b ON o.Buyer_ID = b.Buyer_ID
                WHERE p.Seller_ID = :sid";

        if ($filter == 'pending') { $sql .= " AND o.Order_Status = 'Pending'"; }
        elseif ($filter == 'shipped') { $sql .= " AND o.Order_Status = 'Shipped'"; }
        elseif ($filter == 'delivered') { $sql .= " AND o.Order_Status = 'Delivered'"; }
        elseif ($filter == 'cancelled') { $sql .= " AND o.Order_Status = 'Cancelled'"; }
        elseif ($filter == 'last-30') { $sql .= " AND o.Order_Date >= DATE_SUB(NOW(), INTERVAL 30 DAY)"; }

        $sql .= " ORDER BY o.Order_Date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 7. Update Status
    public function updateStatus($order_id, $status) {
        $sql = "UPDATE Orders SET Order_Status = :status WHERE Order_ID = :oid";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':status' => $status, ':oid' => $order_id]);
    }

    // 8. Get Order By ID
    public function getOrderById($order_id) {
        $sql = "SELECT * FROM Orders WHERE Order_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 9. Get Order Items
    public function getOrderItems($order_id) {
        $sql = "SELECT od.*, p.Product_Name, p.Product_Image, s.Seller_Name 
                FROM Order_Details od 
                JOIN Product p ON od.Product_ID = p.Product_ID 
                JOIN Seller s ON p.Seller_ID = s.Seller_ID
                WHERE od.Order_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 10. Filter Buyer Orders
    public function getFilteredOrders($buyer_id, $filter = 'all') {
        $sql = "SELECT * FROM Orders WHERE Buyer_ID = :bid";
        if ($filter == 'last-30') { $sql .= " AND Order_Date >= DATE_SUB(NOW(), INTERVAL 30 DAY)"; }
        elseif ($filter == 'year-2026') { $sql .= " AND YEAR(Order_Date) = 2026"; }
        $sql .= " ORDER BY Order_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':bid' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 11. Check if Buyer purchased a product (ROBUST FIX)
    public function hasPurchased($buyer_id, $product_id) {
        // Use LOWER() to ignore case sensitivity (e.g., 'Delivered' vs 'delivered')
        $sql = "SELECT COUNT(*) FROM Order_Details od
                JOIN Orders o ON od.Order_ID = o.Order_ID
                WHERE o.Buyer_ID = :bid 
                AND od.Product_ID = :pid 
                AND LOWER(o.Order_Status) = 'delivered'";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':bid' => $buyer_id, ':pid' => $product_id]);
        return $stmt->fetchColumn() > 0;
    }
}
?>