<?php

class AdminController {
    
    private $db;
    private $userModel;
    private $sellerModel;
    private $productModel;
    private $orderModel;
    private $pageModel;
    private $adminModel; // <--- ADD THIS LINE (1)

    public function __construct() {
        // 1. LOAD THE DATABASE FILE (This line was missing!)
        require_once __DIR__ . '/../Config/Database.php';

        $database = new Database();
        $this->db = $database->getConnection();
        
        // 2. Load Models
        require_once __DIR__ . '/../Models/UserModel.php';
        require_once __DIR__ . '/../Models/SellerModel.php';
        require_once __DIR__ . '/../Models/ProductModel.php';
        require_once __DIR__ . '/../Models/OrderModel.php';
        require_once __DIR__ . '/../Models/PageModel.php';
        require_once __DIR__ . '/../Models/AdminModel.php'; 
        
        // 3. Initialize Models
        $this->userModel = new UserModel($this->db);
        $this->sellerModel = new SellerModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->orderModel = new OrderModel($this->db);
        $this->pageModel = new PageModel($this->db);
        $this->adminModel = new AdminModel($this->db); 
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    // ========================
    // 1. AUTHENTICATION
    // ========================

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
                // Handle case-insensitive keys
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

    // ========================
    // 3. MANAGE SELLERS
    // ========================

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

    // ========================
    // 4. MANAGE BUYERS
    // ========================

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

    // ========================
    // 5. MANAGE PRODUCTS
    // ========================

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

    // ========================
    // 6. MANAGE ORDERS
    // ========================
    
    public function orders() {
        $this->checkAdminAuth();
        $stmt = $this->db->query("SELECT * FROM Orders ORDER BY Order_Date DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/Admin/all_orders.php';
    }

    // ========================
    // 7. VIEW ALL MESSAGES (The List)
    // ========================
    public function viewMessages() {
        $this->checkAdminAuth();

        // 1. Fetch Feedback (Assuming Feedback table exists)
        // If you deleted the Feedback table, comment out these lines:
        $feedbacks = [];
        try {
            $feedbacks = $this->db->query("SELECT * FROM Feedback ORDER BY Created_At DESC")->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) { /* Ignore if table missing */ }

        // 2. Fetch Contacts (The "Contact Us" Form Data)
        $contacts = $this->db->query("SELECT * FROM Contact ORDER BY Created_At DESC")->fetchAll(PDO::FETCH_ASSOC);

        // 3. SMART LOGIC: Check if the sender is a Buyer or Seller
        foreach ($contacts as &$msg) {
            $email = $msg['Email'] ?? $msg['email']; // Get email from Contact table
            $msg['user_role'] = 'Guest'; // Default

            if ($email) {
                try {
                    // FIX: Check Buyer Table using 'Buyer_Email'
                    $stmt = $this->db->prepare("SELECT COUNT(*) FROM Buyer WHERE Buyer_Email = :e");
                    $stmt->execute([':e' => $email]);
                    if ($stmt->fetchColumn() > 0) {
                        $msg['user_role'] = 'Buyer';
                    } else {
                        // FIX: Check Seller Table using 'Seller_Email'
                        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Seller WHERE Seller_Email = :e");
                        $stmt->execute([':e' => $email]);
                        if ($stmt->fetchColumn() > 0) {
                            $msg['user_role'] = 'Seller';
                        }
                    }
                } catch (Exception $e) {
                    // If tables/columns are missing, just keep as Guest
                    $msg['user_role'] = 'Guest';
                }
            }
        }
        unset($msg); // Clean up reference

        // Load the View you provided
        require_once __DIR__ . '/../Views/Admin/messages.php';
    }

    // ========================
    // 8. READ SINGLE MESSAGE
    // ========================
    public function viewMessage() {
        $this->checkAdminAuth();
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            header("Location: index.php?page=admin_messages");
            exit();
        }

        // FIX: Use 'contact_id' (lowercase) based on your Debug Report
        $stmt = $this->db->prepare("SELECT * FROM Contact WHERE contact_id = :id");
        $stmt->execute([':id' => $id]);
        $msg = $stmt->fetch(PDO::FETCH_ASSOC);

        // Mark as Read
        if ($msg && ($msg['status'] ?? 'New') === 'New') {
            $upd = $this->db->prepare("UPDATE Contact SET status = 'Read' WHERE contact_id = :id");
            $upd->execute([':id' => $id]);
        }

        require_once __DIR__ . '/../Views/Admin/read_message.php';
    }

    // ========================
    // 9. REPLY TO MESSAGE
    // ========================
    public function replyMessage() {
        $this->checkAdminAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['msg_id'];
            $reply = $_POST['reply_text'];

            // FIX: Update using 'contact_id'
            $stmt = $this->db->prepare("UPDATE Contact SET admin_reply = :r, status = 'Replied', replied_at = CURRENT_TIMESTAMP WHERE contact_id = :id");
            $stmt->execute([':r' => $reply, ':id' => $id]);

            header("Location: index.php?page=admin_view_message&type=contact&id=$id&success=replied");
            exit();
        }
    }
    
   
    // 10. MANAGE CONTENT (Terms, Legal, etc.)
    
    public function updateContent() {
        $this->checkAdminAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['content_type'];
            $value = $_POST['content_text'];

            // Upsert for PostgreSQL
            $sql = "INSERT INTO Site_Settings (Setting_Key, Setting_Value) 
                    VALUES (:key, :val) 
                    ON CONFLICT (Setting_Key) 
                    DO UPDATE SET Setting_Value = :val, Updated_At = CURRENT_TIMESTAMP";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':key' => $key, ':val' => $value]);

            header("Location: index.php?page=admin_content&success=1");
            exit();
        }
    }

   public function manageContent() {
        $this->checkAdminAuth();
        
        // Fetch current values to fill the textareas
        $home_welcome  = $this->adminModel->getSetting('home_welcome');
        $terms_content = $this->adminModel->getSetting('terms_content');
        $legal_content = $this->adminModel->getSetting('legal_notice');

        require_once __DIR__ . '/../Views/Admin/manage_content.php';
    }


    // ========================
    // MANAGE FAQ
    // ========================

    public function manageFAQ() {
        $this->checkAdminAuth();
        // Fetch all existing FAQs to show in a list
        $faqs = $this->adminModel->getAllFAQs();
        require_once __DIR__ . '/../Views/Admin/manage_faq.php';
    }

    public function addFAQ() {
        $this->checkAdminAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $q = $_POST['question'];
            $a = $_POST['answer'];
            
            $this->adminModel->addFAQ($q, $a);
            
            header("Location: index.php?page=admin_faq&success=added");
            exit();
        }
    }

    public function deleteFAQ() {
        $this->checkAdminAuth();
        if (isset($_GET['id'])) {
            $this->adminModel->deleteFAQ($_GET['id']);
        }
        header("Location: index.php?page=admin_faq&success=deleted");
        exit();
    }

    public function viewFeedback() {
        $this->checkAdminAuth();
        // Fetch from the NEW Feedback table
        $feedbacks = $this->db->query("SELECT * FROM Feedback ORDER BY Created_At DESC")->fetchAll(PDO::FETCH_ASSOC);
        require_once __DIR__ . '/../Views/Admin/view_feedback.php';
    }
   
   

    
}
?>