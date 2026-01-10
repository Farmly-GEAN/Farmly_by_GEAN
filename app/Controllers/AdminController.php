<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/AdminModel.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->adminModel = new AdminModel($db);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ========================
    // 1. AUTHENTICATION
    // ========================

    public function login() {
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            header("Location: index.php?page=admin_dashboard");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $admin = $this->adminModel->login($email, $password);

            if ($admin) {
                // Check for both Uppercase (Postgres) and Lowercase (MySQL) keys
                $id = $admin['Admin_ID'] ?? $admin['admin_id'];
                $name = $admin['Admin_Name'] ?? $admin['admin_name'];

                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['role'] = 'admin'; 
                
                header("Location: index.php?page=admin_dashboard");
                exit();
            } else {
                $error = "Invalid Admin Credentials!";
                require_once __DIR__ . '/../Views/Admin/login.php';
            }
        } else {
            require_once __DIR__ . '/../Views/Admin/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=landing");
        exit();
    }

    // Helper: Check if User is Admin
    private function checkAdminAuth() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=admin_login");
            exit();
        }
    }

    // ========================
    // 2. DASHBOARD
    // ========================

    public function dashboard() {
        $this->checkAdminAuth();
        // Fetch Real Stats
        $stats = $this->adminModel->getDashboardStats();
        require_once __DIR__ . '/../Views/Admin/dashboard.php';
    }

    // ========================
    // 3. MANAGE SELLERS
    // ========================

    public function manageSellers() {
        $this->checkAdminAuth();
        $sellers = $this->adminModel->getAllSellers();
        require_once __DIR__ . '/../Views/Admin/manage_sellers.php';
    }

    public function deleteSeller() {
        $this->checkAdminAuth();

        if (isset($_GET['id'])) {
            $seller_id = $_GET['id'];
            if ($this->adminModel->deleteSeller($seller_id)) {
                header("Location: index.php?page=admin_sellers&success=Seller deleted successfully");
            } else {
                header("Location: index.php?page=admin_sellers&error=Failed to delete seller");
            }
        } else {
            header("Location: index.php?page=admin_sellers");
        }
        exit();
    }

    // ========================
    // 4. MANAGE BUYERS
    // ========================

    public function manageBuyers() {
        $this->checkAdminAuth();
        $buyers = $this->adminModel->getAllBuyers();
        require_once __DIR__ . '/../Views/Admin/manage_buyers.php';
    }

    public function deleteBuyer() {
        $this->checkAdminAuth();

        if (isset($_GET['id'])) {
            $buyer_id = $_GET['id'];
            if ($this->adminModel->deleteBuyer($buyer_id)) {
                header("Location: index.php?page=admin_buyers&success=Buyer deleted successfully");
            } else {
                header("Location: index.php?page=admin_buyers&error=Failed to delete buyer");
            }
        } else {
            header("Location: index.php?page=admin_buyers");
        }
        exit();
    }

    // ========================
    // 5. MANAGE PRODUCTS
    // ========================

    public function manageProducts() {
        $this->checkAdminAuth();
        $products = $this->adminModel->getAllProducts();
        require_once __DIR__ . '/../Views/Admin/manage_products.php';
    }

    public function deleteProduct() {
        $this->checkAdminAuth();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($this->adminModel->deleteProduct($id)) {
                header("Location: index.php?page=admin_products&success=Product removed successfully");
            } else {
                header("Location: index.php?page=admin_products&error=Failed to remove product");
            }
        } else {
            header("Location: index.php?page=admin_products");
        }
        exit();
    }

    // ========================
    // 6. MANAGE ORDERS
    // ========================
    
    public function orders() {
        $this->checkAdminAuth();
        $orders = $this->adminModel->getAllOrders();
        require_once __DIR__ . '/../Views/Admin/all_orders.php';
    }

    // REMOVED DUPLICATE DASHBOARD FUNCTION HERE
}
?>