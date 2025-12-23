<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Views/Buyer/Buyer_Login.php");
    exit;
}

require_once __DIR__ . '/../Views/Buyer/HomePage.php';
