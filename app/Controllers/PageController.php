<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/PageModel.php'; 

class PageController {
    
    private $db;
    private $pageModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->pageModel = new PageModel($this->db);
    }
    
    // 1. About Us Page
    public function about() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../Views/Pages/about_us.php';
    }

    // 2. Contact Us Page
    public function contact() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../Views/Pages/contact_us.php';
    }


    public function submitContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? '';
            $message = $_POST['message'] ?? '';

            if($this->pageModel->saveContactMessage($name, $email, $subject, $message)) {
            
                header("Location: index.php?page=contact&success=1");
            } else {
               
                header("Location: index.php?page=contact&error=1");
            }
            exit();
        }
    }

    // 3. Terms & Conditions
    public function terms() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../Views/Pages/terms.php';
    }

    // 4. Privacy Policy
    public function privacy() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../Views/Pages/privacy.php';
    }

    // 5. Seller Feedback Form View
    public function feedback() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Security: Only sellers can see this
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
            header("Location: index.php?page=seller_login");
            exit();
        }

        require_once __DIR__ . '/../Views/Seller/feedback.php';
    }

    // 6. Handle Seller Feedback Form Submission
    public function submitFeedback() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = null;
            $user_type = 'Guest';

            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $user_type = 'Buyer';
            } elseif (isset($_SESSION['seller_id'])) {
                $user_id = $_SESSION['seller_id'];
                $user_type = 'Seller';
            }

            $subject = $_POST['subject'] ?? 'General Feedback';
            $message = $_POST['message'] ?? '';

            if($this->pageModel->saveFeedback($user_id, $user_type, $subject, $message)) {
                header("Location: index.php?page=seller_feedback&success=1");
            } else {
                header("Location: index.php?page=seller_feedback&error=1");
            }
            exit();
        }
    }
}
?>