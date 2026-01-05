<?php
class CartModel {
    private $conn;
    private $table = "Cart";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Add item to cart (or update quantity if it exists)
    public function addToCart($buyer_id, $product_id, $quantity = 1) {
        // Check if item already exists
        $checkSql = "SELECT Cart_ID, Quantity FROM " . $this->table . " 
                     WHERE Buyer_ID = :buyer_id AND Product_ID = :product_id";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':buyer_id' => $buyer_id, ':product_id' => $product_id]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Update Quantity
            $new_qty = $existing['quantity'] + $quantity;
            $updateSql = "UPDATE " . $this->table . " SET Quantity = :qty WHERE Cart_ID = :cart_id";
            $updateStmt = $this->conn->prepare($updateSql);
            return $updateStmt->execute([':qty' => $new_qty, ':cart_id' => $existing['cart_id']]);
        } else {
            // Insert New Row
            $insertSql = "INSERT INTO " . $this->table . " (Buyer_ID, Product_ID, Quantity) 
                          VALUES (:buyer_id, :product_id, :qty)";
            $insertStmt = $this->conn->prepare($insertSql);
            return $insertStmt->execute([':buyer_id' => $buyer_id, ':product_id' => $product_id, ':qty' => $quantity]);
        }
    }

    // 2. Get all items for a specific buyer
    public function getCartItems($buyer_id) {
        $sql = "SELECT c.Cart_ID, c.Quantity, p.Product_Name, p.Price, p.Product_Image 
                FROM " . $this->table . " c 
                JOIN Product p ON c.Product_ID = p.Product_ID 
                WHERE c.Buyer_ID = :buyer_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
        return $stmt->fetchAll();
    }

    // 3. Remove item from cart
    public function removeFromCart($cart_id) {
        $sql = "DELETE FROM " . $this->table . " WHERE Cart_ID = :cart_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':cart_id' => $cart_id]);
    }
}
?>