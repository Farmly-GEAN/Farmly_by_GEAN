<?php
class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // 1. Create Order
    public function createOrder($buyer_id, $total_amount, $address) {
        $sql = "INSERT INTO Orders (Buyer_ID, Total_Amount, Order_Date, Order_Status, Shipping_Address) 
                VALUES (:buyer_id, :total, NOW(), 'Pending', :address)";
        
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute([':buyer_id' => $buyer_id, ':total' => $total_amount, ':address' => $address])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    // 2. Add Item (Using 'Price_Per_Unit')
    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        // FIXED: Column name changed to 'Price_Per_Unit'
        $sql = "INSERT INTO Order_Details (Order_ID, Product_ID, Quantity, Price_Per_Unit) 
                VALUES (:order_id, :product_id, :qty, :price)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':order_id' => $order_id, ':product_id' => $product_id, ':qty' => $quantity, ':price' => $price]);
        
        $this->deductStock($product_id, $quantity);
    }

    // Helper: Deduct Stock
    private function deductStock($product_id, $quantity) {
        $sql = "UPDATE Product SET Stocks_Available = Stocks_Available - :qty WHERE Product_ID = :pid";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':qty' => $quantity, ':pid' => $product_id]);
    }

    // 3. Clear Cart
    public function clearCart($buyer_id) {
        $sql = "DELETE FROM Cart WHERE Buyer_ID = :buyer_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
    }

    // 4. Get Orders By Buyer
    public function getOrdersByBuyer($buyer_id) {
        $sql = "SELECT * FROM Orders WHERE Buyer_ID = :buyer_id ORDER BY Order_Date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Cancel Order
    public function cancelOrder($order_id, $buyer_id) {
        $checkSql = "SELECT Order_Status FROM Orders WHERE Order_ID = :oid AND Buyer_ID = :bid";
        $stmt = $this->db->prepare($checkSql);
        $stmt->execute([':oid' => $order_id, ':bid' => $buyer_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order || $order['Order_Status'] !== 'Pending') { return false; }

        $itemsSql = "SELECT Product_ID, Quantity FROM Order_Details WHERE Order_ID = :oid";
        $stmt = $this->db->prepare($itemsSql);
        $stmt->execute([':oid' => $order_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($items as $item) {
            $restoreSql = "UPDATE Product SET Stocks_Available = Stocks_Available + :qty WHERE Product_ID = :pid";
            $updateStmt = $this->db->prepare($restoreSql);
            $updateStmt->execute([':qty' => $item['Quantity'], ':pid' => $item['Product_ID']]);
        }

        $cancelSql = "UPDATE Orders SET Order_Status = 'Cancelled' WHERE Order_ID = :oid";
        $cancelStmt = $this->db->prepare($cancelSql);
        $cancelStmt->execute([':oid' => $order_id]);
        return true;
    }

    // 6. Get Seller Orders (Using 'Price_Per_Unit')
    public function getSellerOrders($seller_id) {
        $sql = "SELECT 
                    o.Order_ID, 
                    o.Order_Date, 
                    o.Order_Status, 
                    p.Product_Name, 
                    od.Price_Per_Unit AS Price,  /* <--- FIXED: Aliasing it as Price for easier use */
                    od.Quantity,    
                    (od.Price_Per_Unit * od.Quantity) as Line_Total
                FROM Order_Details od
                JOIN Orders o ON od.Order_ID = o.Order_ID
                JOIN Product p ON od.Product_ID = p.Product_ID
                WHERE p.Seller_ID = :seller_id
                ORDER BY o.Order_Date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':seller_id' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 7. Update Status
    public function updateStatus($order_id, $status) {
        $sql = "UPDATE Orders SET Order_Status = :status WHERE Order_ID = :oid";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':status' => $status, ':oid' => $order_id]);
    }

    // 8. Get Order By ID
    public function getOrderById($order_id) {
        $sql = "SELECT * FROM Orders WHERE Order_ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 9. Get Order Items (Fixed Column Name)
    public function getOrderItems($order_id) {
        // CHANGED: p.Image -> p.Product_Image
        $sql = "SELECT 
                    od.*, 
                    p.Product_Name, 
                    p.Product_Image, /* <--- Fixed this column name */
                    s.Seller_Name 
                FROM Order_Details od 
                JOIN Product p ON od.Product_ID = p.Product_ID 
                JOIN Seller s ON p.Seller_ID = s.Seller_ID
                WHERE od.Order_ID = :id";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 10. Filter Buyer Orders
    public function getFilteredOrders($buyer_id, $filter = 'all') {
        $sql = "SELECT * FROM Orders WHERE Buyer_ID = :bid";
        if ($filter == 'last-30') { $sql .= " AND Order_Date >= DATE_SUB(NOW(), INTERVAL 30 DAY)"; }
        elseif ($filter == 'year-2026') { $sql .= " AND YEAR(Order_Date) = 2026"; }
        $sql .= " ORDER BY Order_Date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':bid' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 11. Check if Buyer purchased
    public function hasPurchased($buyer_id, $product_id) {
        $sql = "SELECT COUNT(*) FROM Order_Details od
                JOIN Orders o ON od.Order_ID = o.Order_ID
                WHERE o.Buyer_ID = :bid 
                AND od.Product_ID = :pid 
                AND LOWER(o.Order_Status) = 'delivered'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':bid' => $buyer_id, ':pid' => $product_id]);
        return $stmt->fetchColumn() > 0;
    }
}
?>