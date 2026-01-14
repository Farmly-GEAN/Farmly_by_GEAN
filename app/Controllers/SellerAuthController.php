<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/SellerModel.php';

class SellerAuthController {
    private $db;
    private $sellerModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sellerModel = new SellerModel($this->db);
    }

    // 1. Seller Login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['seller_email'];
            $password = $_POST['seller_password'];

            $seller = $this->sellerModel->login($email, $password);

            if ($seller) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                
                // Set Session Variables
                $_SESSION['user_id'] = $seller['seller_id']; // Using 'user_id' to keep session key consistent
                $_SESSION['seller_name'] = $seller['seller_name']; // Specific to seller
                $_SESSION['role'] = 'seller'; // CRITICAL: This distinguishes them from buyers
                
                // Redirect to Dashboard
                header("Location: index.php?page=seller_dashboard");
                exit();
            } else {
                $error = "Invalid email or password.";
                require_once __DIR__ . '/../Views/Seller/login.php';
            }
        } else {
            // Show the login form
            require_once __DIR__ . '/../Views/Seller/login.php';
        }
    }

    // 2. Seller Registration
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['seller_name'];
            $email = $_POST['seller_email'];
            $phone = $_POST['seller_phone'];
            $address = $_POST['seller_address'];
            $password = $_POST['seller_password'];
            $confirmPass = $_POST['confirm_password'];

            // Validation: Passwords match?
            if ($password !== $confirmPass) {
                $error = "Passwords do not match!";
                require_once __DIR__ . '/../Views/Seller/register.php';
                return;
            }

            // Image Upload Handling
            $imagePath = null;
            if (isset($_FILES['seller_image']) && $_FILES['seller_image']['error'] === 0) {
                // Ensure this folder exists in your public directory
                $uploadDir = __DIR__ . '/../../public/assets/uploads/sellers/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileExt = pathinfo($_FILES['seller_image']['name'], PATHINFO_EXTENSION);
                $fileName = "seller_" . time() . "." . $fileExt;
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['seller_image']['tmp_name'], $targetFile)) {
                    $imagePath = "assets/uploads/sellers/" . $fileName; 
                } else {
                    $error = "Failed to upload image.";
                    require_once __DIR__ . '/../Views/Seller/register.php';
                    return;
                }
            }

            // Attempt Registration
            if ($this->sellerModel->register($name, $email, $password, $phone, $address, $imagePath)) {
                // Success
                header("Location: index.php?page=seller_login&success=1");
                exit();
            } else {
                $error = "Registration failed. Email might already exist.";
                require_once __DIR__ . '/../Views/Seller/register.php';
            }
        } else {
            // Show the register form
            require_once __DIR__ . '/../Views/Seller/register.php';
        }
    }

    // 3. Seller Logout
   public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION = [];
        session_destroy();

        header("Location: index.php?page=landing"); 
        exit();
    }

    

    // LISTED PRODUCTS
    public function listedProducts() {
        $this->checkSellerAuth();
        $products = $this->productModel->getProductsBySeller($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/listed_products.php';
    }

    public function deleteProduct() {
        $this->checkSellerAuth();
        if (isset($_GET['id'])) {
            $this->productModel->deleteProduct($_GET['id'], $_SESSION['user_id']);
        }
        header("Location: index.php?page=seller_listed_products");
        exit();
    }

    //  ORDERS
    public function orders() {
        $this->checkSellerAuth();
        require_once __DIR__ . '/../Models/OrderModel.php';
        $orderModel = new OrderModel($this->db);
        
        $orders = $orderModel->getSellerOrders($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/orders.php';
    }

    public function updateOrderStatus() {
        $this->checkSellerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../Models/OrderModel.php';
            $orderModel = new OrderModel($this->db);
            
            $order_id = $_POST['order_id'];
            $status = $_POST['status'];
            
            $orderModel->updateStatus($order_id, $status);
            header("Location: index.php?page=seller_orders");
            exit();
        }
    }

    // REVIEWS 
    public function reviews() {
        $this->checkSellerAuth();
        require_once __DIR__ . '/../Models/ReviewModel.php';
        $reviewModel = new ReviewModel($this->db);
        
        $reviews = $reviewModel->getSellerReviews($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/reviews.php';
    }
    public function forgotPassword() {
        require_once __DIR__ . '/../Views/Seller/forgot_password.php';
    }

    public function processResetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $pass1 = $_POST['new-password'];
            $pass2 = $_POST['confirm-password'];

            if ($pass1 !== $pass2) {
                $error = "Passwords do not match!";
                require_once __DIR__ . '/../Views/Seller/forgot_password.php';
                return;
            }

            $sellerModel = new SellerModel($this->db);
            
            $result = $sellerModel->updatePasswordByEmail($email, $pass1);

            if ($result) {
                header("Location: index.php?page=seller_login&success=password_reset");
            } else {
                $error = "Email not found.";
                require_once __DIR__ . '/../Views/Seller/forgot_password.php';
            }
        }
    }
}
?>