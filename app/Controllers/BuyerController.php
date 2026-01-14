<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/UserModel.php';

class BuyerController {
    private $db;
    private $orderModel;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->orderModel = new OrderModel($this->db);
        $this->userModel = new UserModel($this->db);
    }

    // 1. Show Profile Page
    public function profile() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $buyer_id = $_SESSION['user_id'];
        
        // Fetch Buyer
        $sql = "SELECT * FROM Buyer WHERE Buyer_ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $buyer_id]);
        $buyer = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch Orders
        $orders = $this->orderModel->getBuyerOrders($buyer_id);

        require_once __DIR__ . '/../Views/Buyer/profile.php';
    }

    // 2. Handle Profile Update
    public function updateProfile() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user_id'];
            $name = $_POST['buyer_name'];
            $phone = $_POST['buyer_phone'];
            $address = $_POST['buyer_address'];

            if ($this->userModel->updateBuyerProfile($id, $name, $phone, $address)) {
                $_SESSION['user_name'] = $name;
                header("Location: index.php?page=profile&success=Profile Updated Successfully");
            } else {
                header("Location: index.php?page=profile&error=Failed to update profile");
            }
            exit();
        }
    }

    // 3. Show Detailed Order History (Amazon Style) - FIXED
    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $buyer_id = $_SESSION['user_id'];
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

        // 1. Fetch Orders
        $rawOrders = $this->orderModel->getFilteredOrders($buyer_id, $filter);
        
        // 2. Attach Items to each order (ROBUST ID CHECK)
        $orders = [];
        if (!empty($rawOrders)) {
            foreach ($rawOrders as $order) {
                // Check for 'Order_ID' OR 'order_id'
                $o_id = $order['Order_ID'] ?? $order['order_id'];
                
                // Fetch items for this specific order
                $order['items'] = $this->orderModel->getOrderItems($o_id);
                $orders[] = $order;
            }
        }

        require_once __DIR__ . '/../Views/Buyer/my_orders.php';
    }
}
?>
