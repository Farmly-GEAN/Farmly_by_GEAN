<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/SellerModel.php';
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/PageModel.php';

class AdminController {
   
    private $db;
    private $userModel;
    private $sellerModel;
    private $productModel;
    private $orderModel;
    private $pageModel;

    public function __construct() {
        
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->userModel = new UserModel($this->db);
        $this->sellerModel = new SellerModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->orderModel = new OrderModel($this->db);
        $this->pageModel = new PageModel($this->db);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    
    // 1. AUTHENTICATION
    

        public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            header("Location: index.php?page=admin_dashboard");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

    
            $sql = "SELECT * FROM Admin WHERE Admin_Email = :email AND Admin_Password = :pass"; 
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email, ':pass' => $password]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                
                $id = $admin['Admin_ID'] ?? $admin['admin_id'];
                $name = $admin['Admin_Name'] ?? $admin['admin_name'];

                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['role'] = 'admin'; 
                $_SESSION['admin_logged_in'] = true; 
                
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
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION = [];
        session_destroy();
        header("Location: index.php?page=admin_login");
        exit();
    }

    // Check Admin Authentication
    private function checkAdminAuth() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=admin_login");
            exit();
        }
    }

    
    // 2. DASHBOARD
    

   public function dashboard() {
        $this->checkAdminAuth();
        
       
        $stmt = $this->db->query("SELECT COUNT(*) FROM Seller");
        $sellerCount = $stmt->fetchColumn();

        
        $stmt = $this->db->query("SELECT COUNT(*) FROM Buyer"); 
        $buyerCount = $stmt->fetchColumn();

        
        $stmt = $this->db->query("SELECT COUNT(*) FROM Product");
        $productCount = $stmt->fetchColumn();

        
        $stmt = $this->db->query("SELECT COUNT(*) FROM Orders");
        $orderCount = $stmt->fetchColumn();

       
        $stmt = $this->db->query("SELECT SUM(Total_Amount) FROM Orders");
        $revenue = $stmt->fetchColumn();

      
        $stats = [
            
            'total_sellers'  => $sellerCount,
            'total_orders'   => $orderCount,
            'total_products' => $productCount,

            
            'active_users'   => $buyerCount,  
            'total_users'    => $buyerCount,  
            'total_buyers'   => $buyerCount,  

            
            'total_revenue'  => $revenue ?? 0, 
            'revenue'        => $revenue ?? 0  
        ];

        require_once __DIR__ . '/../Views/Admin/dashboard.php';
    }

  
    // 3. MANAGE SELLERS
   

    public function manageSellers() {
        $this->checkAdminAuth();
        $stmt = $this->db->query("SELECT * FROM Seller");
        $sellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/Admin/manage_sellers.php';
    }

    public function deleteSeller() {
        $this->checkAdminAuth();

        if (isset($_GET['id'])) {
            $seller_id = $_GET['id'];
            $stmt = $this->db->prepare("DELETE FROM Seller WHERE Seller_ID = :id");
            if ($stmt->execute([':id' => $seller_id])) {
                header("Location: index.php?page=admin_sellers&success=Seller deleted successfully");
            } else {
                header("Location: index.php?page=admin_sellers&error=Failed to delete seller");
            }
        } else {
            header("Location: index.php?page=admin_sellers");
        }
        exit();
    }


    // 4. MANAGE BUYERS


    public function manageBuyers() {
        $this->checkAdminAuth();
        
        $stmt = $this->db->query("SELECT * FROM Buyer"); 
        $buyers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/Admin/manage_buyers.php';
    }

    public function deleteBuyer() {
        $this->checkAdminAuth();

        if (isset($_GET['id'])) {
            $buyer_id = $_GET['id'];
            
            $stmt = $this->db->prepare("DELETE FROM Buyer WHERE Buyer_ID = :id");
            if ($stmt->execute([':id' => $buyer_id])) {
                header("Location: index.php?page=admin_buyers&success=Buyer deleted successfully");
            } else {
                header("Location: index.php?page=admin_buyers&error=Failed to delete buyer");
            }
        } else {
            header("Location: index.php?page=admin_buyers");
        }
        exit();
    }


    // 5. MANAGE PRODUCTS
 

    public function manageProducts() {
        $this->checkAdminAuth();
        $products = $this->productModel->getAllProducts();
        require_once __DIR__ . '/../Views/Admin/manage_products.php';
    }

    public function deleteProduct() {
        $this->checkAdminAuth();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $this->db->prepare("DELETE FROM Product WHERE Product_ID = :id");
            if ($stmt->execute([':id' => $id])) {
                header("Location: index.php?page=admin_products&success=Product removed successfully");
            } else {
                header("Location: index.php?page=admin_products&error=Failed to remove product");
            }
        } else {
            header("Location: index.php?page=admin_products");
        }
        exit();
    }


    // 6. MANAGE ORDERS

    
    public function orders() {
        $this->checkAdminAuth();
        $stmt = $this->db->query("SELECT * FROM Orders ORDER BY Order_Date DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/Admin/all_orders.php';
    }


    // 7. VIEW MESSAGES


    public function viewMessages() {
        $this->checkAdminAuth();

      
        $contacts = $this->pageModel->getAllContactMessages();
        $feedbacks = $this->pageModel->getAllFeedbacks();

        require_once __DIR__ . '/../Views/Admin/messages.php';
    }

}
?>