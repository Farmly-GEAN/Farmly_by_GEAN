<?php
require_once __DIR__ . '/../Config/Database.php';

class PageController {
    
    // 1. About Us Page
    public function about() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        // Uses the header/footer logic inside the view
        require_once __DIR__ . '/../Views/Pages/about_us.php';
    }

    // 2. Contact Us Page
    public function contact() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        require_once __DIR__ . '/../Views/Pages/contact_us.php';
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

    // 5. Seller Feedback Form (Specific to Seller Footer)
    public function feedback() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // Security: Only sellers can see this
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
            header("Location: index.php?page=seller_login");
            exit();
        }

        require_once __DIR__ . '/../Views/Seller/feedback.php';
    }
}
?>