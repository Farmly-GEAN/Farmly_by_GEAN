<?php
// Adjust paths to go up one level to 'app' then down to Config/Models
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/BuyerModel.php';

class AuthController {
    
    // --- LOGIN LOGIC ---
    public function login() {
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Connect
            $database = new Database();
            $db = $database->getConnection();
            $buyerModel = new BuyerModel($db);

            // Find User
            $user = $buyerModel->getBuyerByEmail($email);

            if ($user && password_verify($password, $user['buyer_password'])) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user_id'] = $user['buyer_id'];
                $_SESSION['user_name'] = $user['buyer_name'];
                $_SESSION['role'] = 'buyer';

                header("Location: index.php?page=home");
                exit();
            } else {
                $message = "Invalid email or password.";
            }
        }

        // Load the View (Make sure the dot . is here!)
        require_once __DIR__ . '/../Views/Buyer/login.php';
    }

    // --- REGISTER LOGIC ---
    public function register() {
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 1. Collect Form Data
            $name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $state = $_POST['state'];
            $city = $_POST['city'];
            $password = $_POST['password'];
            $confirmPass = $_POST['confirm_password'];

            // 2. Validation
            if ($password !== $confirmPass) {
                $message = "Passwords do not match!";
            } else {
                $database = new Database();
                $db = $database->getConnection();
                $buyerModel = new BuyerModel($db);

                // 3. Check if email already exists
                if ($buyerModel->getBuyerByEmail($email)) {
                    $message = "Email is already registered!";
                } else {
                    // 4. Create User
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    if ($buyerModel->createBuyer($name, $email, $phone, $address, $hashed_password, $gender, $state, $city)) {
                        // Redirect to Login on Success
                        header("Location: index.php?page=login&msg=registered");
                        exit();
                    } else {
                        $message = "Error creating account (Database).";
                    }
                }
            }
        }

        // Load the View (Make sure the dot . is here!)
        require_once __DIR__ . '/../Views/Buyer/register.php';
    }

    // --- NEW LOGOUT LOGIC ---
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION = [];
        session_destroy();

        // BUYER goes to Landing Page
        header("Location: index.php?page=landing");
        exit();
    }
}
?>