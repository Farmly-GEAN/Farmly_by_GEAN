<?php
<<<<<<< HEAD
require_once '../config/db.php';
=======
session_start(); 

require_once __DIR__ . '/../config/database.php';

>>>>>>> bafaf0fa72af0563f4df08991e553a5be174e5bd

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

try {
    $pdo = db();

    $stmt = $pdo->prepare(
        "SELECT id, password FROM users WHERE email = :email"
    );
    $stmt->execute(['email' => $email]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
<<<<<<< HEAD
=======

        // ✅ SET SESSION HERE
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;

>>>>>>> bafaf0fa72af0563f4df08991e553a5be174e5bd
        echo json_encode([
            "success" => true,
            "message" => "Login successful"
        ]);
        exit;
    }

    echo json_encode([
        "success" => false,
        "message" => "Invalid email or password"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Server error"
    ]);
}
