<?php
class OrderModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Create the Main Order Record
    public function createOrder($buyer_id, $total_amount, $address) {
        // Status is 'Pending' by default
        $sql = "INSERT INTO Orders (Buyer_ID, Total_Amount, Order_Date, Order_Status, Shipping_Address) 
                VALUES (:buyer_id, :total, NOW(), 'Pending', :address) RETURNING Order_ID";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':buyer_id' => $buyer_id, 
            ':total' => $total_amount, 
            ':address' => $address
        ]);
        
        // Fetch the new Order ID to use for items
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['order_id'];
    }

    // 2. Save individual items to Order_Details table
    public function addOrderItem($order_id, $product_id, $quantity, $price) {
        $sql = "INSERT INTO Order_Details (Order_ID, Product_ID, Quantity, Price_Per_Unit) 
                VALUES (:order_id, :product_id, :qty, :price)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $product_id,
            ':qty' => $quantity,
            ':price' => $price
        ]);
    }

    // 3. Clear the User's Cart after successful order
    public function clearCart($buyer_id) {
        $sql = "DELETE FROM Cart WHERE Buyer_ID = :buyer_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
    }
}
?>