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
        // A. Save to Order Details
        $sql = "INSERT INTO Order_Details (Order_ID, Product_ID, Quantity, Price_Per_Unit) 
                VALUES (:order_id, :product_id, :qty, :price)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':order_id' => $order_id, ':product_id' => $product_id, ':qty' => $quantity, ':price' => $price]);

        // B. Deduct Stock from Product Table
        $this->deductStock($product_id, $quantity);
    }

    // Helper: Deduct Stock
    private function deductStock($product_id, $quantity) {
        // MATCHES DB: Stocks_Available
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

    // 4. Get Orders
    public function getOrdersByBuyer($buyer_id) {
        $sql = "SELECT * FROM Orders WHERE Buyer_ID = :buyer_id ORDER BY Order_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Cancel Order AND Restore Stock
    public function cancelOrder($order_id, $buyer_id) {
        // A. Verify it is pending
        $checkSql = "SELECT Order_Status FROM Orders WHERE Order_ID = :oid AND Buyer_ID = :bid";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':oid' => $order_id, ':bid' => $buyer_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order || $order['order_status'] !== 'Pending') {
            return false;
        }

        // B. Get items to restore
        $itemsSql = "SELECT Product_ID, Quantity FROM Order_Details WHERE Order_ID = :oid";
        $stmt = $this->conn->prepare($itemsSql);
        $stmt->execute([':oid' => $order_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // C. Restore Stock
        foreach($items as $item) {
            // MATCHES DB: Stocks_Available
            $restoreSql = "UPDATE Product SET Stocks_Available = Stocks_Available + :qty WHERE Product_ID = :pid";
            $updateStmt = $this->conn->prepare($restoreSql);
            $updateStmt->execute([':qty' => $item['quantity'], ':pid' => $item['product_id']]);
        }

        // D. Cancel Order
        $cancelSql = "UPDATE Orders SET Order_Status = 'Cancelled' WHERE Order_ID = :oid";
        $cancelStmt = $this->conn->prepare($cancelSql);
        $cancelStmt->execute([':oid' => $order_id]);
        
        return true;
    }
}
?>