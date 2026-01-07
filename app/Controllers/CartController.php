<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/CartModel.php';

class CartController {
    private $db;
    private $cartModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cartModel = new CartModel($this->db);
    }

    // 1. Show the Cart Page
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $buyer_id = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($buyer_id);

        // Calculate Grand Total
        $grandTotal = 0;
        foreach ($cartItems as $item) {
            // Handle Case Sensitivity from DB
            $price = $item['price'] ?? $item['Price'] ?? 0;
            $qty   = $item['quantity'] ?? $item['Quantity'] ?? 0;
            $grandTotal += ($price * $qty);
        }

        require_once __DIR__ . '/../Views/Buyer/cart.php';
    }

    // 2. Add Item to Cart
    public function add() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $buyer_id = $_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            $this->cartModel->addToCart($buyer_id, $product_id, $quantity);

            header("Location: index.php?page=cart");
            exit();
        }
    }

    // 3. Remove Item from Cart
    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'])) {
            $cart_id = $_POST['cart_id'];
            $this->cartModel->removeFromCart($cart_id);
            
            header("Location: index.php?page=cart");
            exit();
        }
    }

    // 4. NEW: Update Quantity (Increase/Decrease)
    public function update() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id'], $_POST['action'])) {
            $cart_id = $_POST['cart_id'];
            $action = $_POST['action']; // 'increase' or 'decrease'
            $current_qty = (int)$_POST['current_qty'];

            // Calculate new quantity
            if ($action === 'increase') {
                $new_qty = $current_qty + 1;
            } else {
                $new_qty = $current_qty - 1;
            }

            // Only update if quantity is valid (at least 1)
            if ($new_qty >= 1) {
                $this->cartModel->updateQuantity($cart_id, $new_qty);
            }

            // Refresh Page
            header("Location: index.php?page=cart");
            exit();
        }
    }
}
?>