<?php

require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/BuyerModel.php';

class AuthController {
    
    // LOGIN LOGIC 
    public function login() {
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

           
            $database = new Database();
            $db = $database->getConnection();
            $buyerModel = new BuyerModel($db);

           
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

        
        require_once __DIR__ . '/../Views/Buyer/login.php';
    }

    //  REGISTER LOGIC 
    public function register() {
        $message = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $gender = $_POST['gender'];
            $state = $_POST['state'];
            $city = $_POST['city'];
            $password = $_POST['password'];
            $confirmPass = $_POST['confirm_password'];

            
            if ($password !== $confirmPass) {
                $message = "Passwords do not match!";
            } else {
                $database = new Database();
                $db = $database->getConnection();
                $buyerModel = new BuyerModel($db);

                
                if ($buyerModel->getBuyerByEmail($email)) {
                    $message = "Email is already registered!";
                } else {
                   
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    if ($buyerModel->createBuyer($name, $email, $phone, $address, $hashed_password, $gender, $state, $city)) {
                        
                        header("Location: index.php?page=login&msg=registered");
                        exit();
                    } else {
                        $message = "Error creating account (Database).";
                    }
                }
            }
        }

        
        require_once __DIR__ . '/../Views/Buyer/register.php';
    }

   
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION = [];
        session_destroy();

        
        header("Location: index.php?page=landing");
        exit();
    }

   
    public function forgotPassword() {
        require_once __DIR__ . '/../Views/Buyer/forgot_password.php';
    }

   
    public function processResetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $pass1 = $_POST['new-password'];
            $pass2 = $_POST['confirm-password'];

            if ($pass1 !== $pass2) {
                $error = "Passwords do not match!";
                require_once __DIR__ . '/../Views/Buyer/forgot_password.php';
                return;
            }

           
            $userModel = new UserModel($this->db); 
          
            $result = $userModel->updatePasswordByEmail($email, $pass1);

            if ($result) {
                header("Location: index.php?page=login&success=password_reset");
            } else {
                $error = "Email not found.";
                require_once __DIR__ . '/../Views/Buyer/forgot_password.php';
            }
        }
    }
}
?>