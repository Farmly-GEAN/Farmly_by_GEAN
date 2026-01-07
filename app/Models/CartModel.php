<?php
class CartModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Add item to cart (Insert or Update if exists)
    public function addToCart($buyer_id, $product_id, $quantity) {
        // A. Check if item already exists in this user's cart
        $sql = "SELECT * FROM Cart WHERE Buyer_ID = :buyer_id AND Product_ID = :product_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id, ':product_id' => $product_id]);
        
        if ($stmt->rowCount() > 0) {
            // B. If exists, Update quantity (Add to existing)
            $sql = "UPDATE Cart SET Quantity = Quantity + :qty WHERE Buyer_ID = :buyer_id AND Product_ID = :product_id";
        } else {
            // C. If new, Insert row
            $sql = "INSERT INTO Cart (Buyer_ID, Product_ID, Quantity) VALUES (:buyer_id, :product_id, :qty)";
        }
        
        // D. Execute the final query
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':buyer_id' => $buyer_id, 
            ':product_id' => $product_id, 
            ':qty' => $quantity
        ]);
    }

    // 2. Get all items in the cart
    public function getCartItems($buyer_id) {
        $sql = "SELECT c.Cart_ID, c.Quantity, p.Product_ID, p.Product_Name, p.Price, p.Product_Image 
                FROM Cart c
                JOIN Product p ON c.Product_ID = p.Product_ID
                WHERE c.Buyer_ID = :buyer_id
                ORDER BY c.Cart_ID DESC"; // Added ORDER BY to keep list stable
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':buyer_id' => $buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Remove item
    public function removeFromCart($cart_id) {
        $sql = "DELETE FROM Cart WHERE Cart_ID = :cart_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cart_id' => $cart_id]);
    }

    // 4. Update Quantity (Set specific amount)
    // Used for the + and - buttons in the cart
    public function updateQuantity($cart_id, $quantity) {
        if ($quantity < 1) return; // Prevent setting it to 0 or negative
        
        $sql = "UPDATE Cart SET Quantity = :qty WHERE Cart_ID = :cart_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':qty' => $quantity, ':cart_id' => $cart_id]);
    }
}
?>