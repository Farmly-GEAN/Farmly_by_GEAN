<?php

require_once __DIR__ . '/../../Models/Buyer.php';

class BuyerController
{
    public function register()
    {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            die("Passwords do not match");
        }

        Buyer::create($_POST);

        header("Location: /Views/Buyer_Login.php");
        exit;
    }

    public function login()
    {
        session_start();

        $buyer = Buyer::findByEmail($_POST['email']);

        if ($buyer && password_verify($_POST['password'], $buyer['password'])) {
            $_SESSION['buyer_id'] = $buyer['id'];
            header("Location: /Views/HomePage.php");
        } else {
            echo "Invalid login credentials";
        }
    }
}
