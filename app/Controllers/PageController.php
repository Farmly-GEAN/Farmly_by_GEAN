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


    
    // 4. Privacy Policy
    public function privacy() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../Views/Pages/privacy.php';
    }

    // 5. Seller Feedback Form View
    public function feedback() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Detect Role to customize the view
        $role = 'Guest';
        if (isset($_SESSION['seller_id']) || (isset($_SESSION['role']) && $_SESSION['role'] === 'seller')) {
            $role = 'Seller';
        } elseif (isset($_SESSION['user_id'])) {
            $role = 'Buyer';
        } else {
            // Guests shouldn't give feedback, redirect to login
            header("Location: index.php?page=login");
            exit();
        }

        require_once __DIR__ . '/../Views/Pages/feedback.php';
    }

    // 2. Handle Submission
    public function submitFeedback() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Determine who is sending it
            if (isset($_SESSION['seller_id']) || (isset($_SESSION['role']) && $_SESSION['role'] === 'seller')) {
                $user_id = $_SESSION['user_id']; // or seller_id
                $name    = $_SESSION['user_name'] ?? 'Seller';
                $role    = 'Seller';
            } elseif (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $name    = $_SESSION['user_name'] ?? 'Buyer';
                $role    = 'Buyer';
            } else {
                header("Location: index.php?page=login");
                exit();
            }

            $subject = $_POST['subject'];
            $message = $_POST['message'];

            // Save to DB
            if ($this->pageModel->submitFeedback($user_id, $name, $role, $subject, $message)) {
                header("Location: index.php?page=feedback&success=1");
            } else {
                header("Location: index.php?page=feedback&error=1");
            }
            exit();
        }
    }

    

    // Additional methods for admin to view messages and feedback can be added here

   public function home() {
        // Fetch the Welcome Message from DB
        $welcomeMessage = $this->pageModel->getSetting('home_welcome');
        
        // If DB is empty, use a default fallback
        if (!$welcomeMessage) {
            $welcomeMessage = "Welcome to Farmly - Fresh from the farm!";
        }

        require_once __DIR__ . '/../Views/home.php';
    }

   public function terms() {
        // 1. Fetch the content from DB
        $content = $this->pageModel->getSetting('terms_content');
        
        // 2. Fallback if empty
        if (!$content) $content = "Terms and Conditions are being updated.";

        require_once __DIR__ . '/../Views/Pages/terms.php';
    }

    public function submitContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Collect Form Data
            $name    = $_POST['name'] ?? 'Guest';
            $email   = $_POST['email'] ?? '';
            $subject = $_POST['subject'] ?? 'No Subject';
            $message = $_POST['message'] ?? '';

            if (!empty($email) && !empty($message)) {
                try {
                    // Insert into Database
                    // Note: Using 'contact_id' implicitly (auto-increment)
                    $sql = "INSERT INTO Contact (Name, Email, Subject, Message, Status, Created_At) 
                            VALUES (:name, :email, :subj, :msg, 'New', CURRENT_TIMESTAMP)";
                    
                    $stmt = $this->db->prepare($sql);
                    $result = $stmt->execute([
                        ':name'  => $name,
                        ':email' => $email,
                        ':subj'  => $subject,
                        ':msg'   => $message
                    ]);

                    if ($result) {
                        // Success
                        header("Location: index.php?page=contact_us&success=1");
                    } else {
                        // DB Error
                        header("Location: index.php?page=contact_us&error=db_failed");
                    }
                } catch (Exception $e) {
                     header("Location: index.php?page=contact_us&error=" . urlencode($e->getMessage()));
                }
            } else {
                // Validation Error
                header("Location: index.php?page=contact_us&error=empty_fields");
            }
            exit();
        }
    }


    // BUYER MESSAGES (INBOX)
  
    public function myMessages() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Security Check
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // 2. FETCH EMAIL (Crucial Step!)
        $stmt = $this->db->prepare("SELECT Buyer_Email FROM Buyer WHERE Buyer_ID = :id");
        $stmt->execute([':id' => $user_id]);
        $buyer_email = $stmt->fetchColumn();

        // Store in session so the View can show it in the debug box
        $_SESSION['user_email'] = $buyer_email;

        // 3. Get messages
        if ($buyer_email) {
            // This calls the Model function (ensure your Model has the LOWER() fix I mentioned earlier!)
            $my_messages = $this->pageModel->getMessagesByEmail($buyer_email);
        } else {
            $my_messages = [];
        }

        require_once __DIR__ . '/../Views/Buyer/my_messages.php';
    }

    public function sellerMessages() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // 1. Security Check: Must be logged in as Seller
        // (Adjust 'seller' to match your exact session role if different)
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'seller') {
            header("Location: index.php?page=seller_login");
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // 2. FETCH SELLER EMAIL
        // We look in the 'Seller' table instead of 'Buyer'
        $stmt = $this->db->prepare("SELECT Seller_Email FROM Seller WHERE Seller_ID = :id");
        $stmt->execute([':id' => $user_id]);
        $seller_email = $stmt->fetchColumn();

        // 3. Reuse the Model Function (It works for any email!)
        if ($seller_email) {
            $my_messages = $this->pageModel->getMessagesByEmail($seller_email);
        } else {
            $my_messages = [];
        }

        // 4. Load the Seller View
        require_once __DIR__ . '/../Views/Seller/my_messages.php';
    }

    public function legal() {
        // 1. Fetch from Database (using the key 'legal_notice' we made earlier)
        $content = $this->pageModel->getSetting('legal_notice');
        
        // 2. Fallback text
        if (!$content) $content = "© 2026 Farmly. All Rights Reserved.\n\nCompany Name: Farmly Inc.\nAddress: 123 Farm Lane, Tech City\nEmail: support@farmly.com";

        // 3. Load View
        require_once __DIR__ . '/../Views/Pages/legal.php';
    }

    public function faq() {
        $faqs = $this->pageModel->getAllFAQs(); 
        require_once __DIR__ . '/../Views/Pages/faq.php';
    }
}
?>