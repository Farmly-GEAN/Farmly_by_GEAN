<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/CartModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';

class OrderController {
    private $db;
    private $cartModel;
    private $orderModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cartModel = new CartModel($this->db);
        $this->orderModel = new OrderModel($this->db);
    }

    // 1. Show Checkout Page (Review Cart & Address)
    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $buyer_id = $_SESSION['user_id'];
        
        // Fetch cart items to display summary
        $cartItems = $this->cartModel->getCartItems($buyer_id);
        
        if (empty($cartItems)) {
            header("Location: index.php?page=cart"); // Cannot checkout empty cart
            exit();
        }

        // Calculate Total
        $totalPrice = 0;
        foreach($cartItems as $item) {
            $totalPrice += ($item['price'] * $item['quantity']);
        }

        require_once __DIR__ . '/../Views/Buyer/checkout.php';
    }

    // 2. Process the "Place Order" Click
    public function placeOrder() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $buyer_id = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $address = $_POST['address']; // Get address from form
            
            // A. Get Items & Total
            $cartItems = $this->cartModel->getCartItems($buyer_id);
            $totalPrice = 0;
            foreach($cartItems as $item) {
                $totalPrice += ($item['price'] * $item['quantity']);
            }

            // B. Create Order
            $order_id = $this->orderModel->createOrder($buyer_id, $totalPrice, $address);

            // C. Move Items from Cart to Order_Details
            foreach($cartItems as $item) {
                $this->orderModel->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price']);
            }

            // D. Clear Cart
            $this->orderModel->clearCart($buyer_id);

            // E. Redirect to Success Page
            header("Location: index.php?page=order_success&id=" . $order_id);
            exit();
        }
    }
}
?>