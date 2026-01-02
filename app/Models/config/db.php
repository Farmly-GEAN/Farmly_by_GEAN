<?php


$host = 'localhost';
$db   = 'farmly';       // Your Database Name
$user = 'postgres';       // Your Database User
$pass = '27579Ni@';  // Your Database Password
$port = "5432";

$dsn = "pgsql:host=$host;port=$port;dbname=$db;";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // In a real app, log this error instead of showing it to the user
    die("Database connection failed: " . $e->getMessage());
}
?>