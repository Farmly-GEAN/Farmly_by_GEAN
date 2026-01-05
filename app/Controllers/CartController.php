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

    // Show the Cart Page
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $items = $this->cartModel->getCartItems($_SESSION['user_id']);
        
        // Calculate Total Price Logic
        $totalPrice = 0;
        foreach($items as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        require_once __DIR__ . '/../Views/Buyer/cart.php';
    }

    // Handle "Add to Cart" Action
    public function add() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_id = $_POST['product_id'];
            $this->cartModel->addToCart($_SESSION['user_id'], $product_id);
            // Redirect back to home with a success message
            header("Location: index.php?page=home&msg=added");
        }
    }

    // Handle "Remove" Action
    public function remove() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cart_id = $_POST['cart_id'];
            $this->cartModel->removeFromCart($cart_id);
            header("Location: index.php?page=cart&msg=removed");
        }
    }
}
?>