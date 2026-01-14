<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/BuyerModel.php';

class ProfileController {
    private $db;
    private $orderModel;
    private $buyerModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->orderModel = new OrderModel($this->db);
        $this->buyerModel = new BuyerModel($this->db);
    }

    // 1. Show Profile & Order History
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $buyer_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        
        // Get Order History
        $orders = $this->orderModel->getOrdersByBuyer($buyer_id);

        require_once __DIR__ . '/../Views/Buyer/profile.php';
    }

    // 2. NEW: Handle Order Cancellation
    public function cancelOrder() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Security Check: Must be logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $order_id = $_POST['order_id'];
            $buyer_id = $_SESSION['user_id'];

            // Try to cancel
            if ($this->orderModel->cancelOrder($order_id, $buyer_id)) {
                // Success: Redirect back to profile with success msg
                header("Location: index.php?page=profile&msg=cancelled");
            } else {
                // Failure: Redirect back with error (e.g., Order was not pending)
                header("Location: index.php?page=profile&err=cannot_cancel");
            }
            exit();
        }
    }
}
?>