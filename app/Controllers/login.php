<?php
session_start(); 

require_once __DIR__ . '/../config/database.php';


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

        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $email;

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
