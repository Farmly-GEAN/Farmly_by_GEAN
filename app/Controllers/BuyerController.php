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
        
      
        $sql = "SELECT * FROM Buyer WHERE Buyer_ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $buyer_id]);
        $buyer = $stmt->fetch(PDO::FETCH_ASSOC);

        
        $orders = $this->orderModel->getBuyerOrders($buyer_id);

        require_once __DIR__ . '/../Views/Buyer/profile.php';
    }

    // 2. Handling Profile Update
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

    // 3. Show Detailed Order History
    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $buyer_id = $_SESSION['user_id'];
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

        
        $rawOrders = $this->orderModel->getFilteredOrders($buyer_id, $filter);
        
       
        $orders = [];
        if (!empty($rawOrders)) {
            foreach ($rawOrders as $order) {
                
                $o_id = $order['Order_ID'] ?? $order['order_id'];
                
                
                $order['items'] = $this->orderModel->getOrderItems($o_id);
                $orders[] = $order;
            }
        }

        require_once __DIR__ . '/../Views/Buyer/my_orders.php';
    }
}
?>