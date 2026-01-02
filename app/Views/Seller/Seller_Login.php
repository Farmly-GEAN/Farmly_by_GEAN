<?php
session_start();
require_once __DIR__ . '/../../Models/config/db.php';

$message = "";

if (isset($_GET['success'])) {
    $message = "Shop registered successfully! Please login.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['seller_email'];
    $password = $_POST['seller_password'];

    // 1. Fetch Seller Data
    $stmt = $pdo->prepare("SELECT * FROM Seller WHERE Seller_Email = ?");
    $stmt->execute([$email]);
    $seller = $stmt->fetch();

    // 2. Verify Password
    // Note: Database column is 'seller_password', usually returned in lowercase by PDO
    if ($seller && password_verify($password, $seller['seller_password'])) {
        
        // 3. Set Session Variables
        $_SESSION['user_id'] = $seller['seller_id'];
        $_SESSION['user_name'] = $seller['seller_name'];
        $_SESSION['role'] = 'seller'; // Mark this user as a Seller
        
        // 4. Redirect to Dashboard
        // Assuming Seller_AddProduct.php is your main dashboard for now
        header("Location: Seller_AddProduct.php"); 
        exit();
        
    } else {
        $message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Login</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Seller_Login.css">
</head>
<body>
    <div class="login-card">
        <h2>Seller Portal Login</h2>
        
        <?php if($message): ?>
            <p style="color:red; text-align:center; font-weight: bold;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Email</label>
            <input type="email" name="seller_email" required placeholder="Enter email">

            <label>Password</label>
            <input type="password" name="seller_password" required placeholder="Enter password">

            <button type="submit">Login</button>
        </form>
        
        <p><a href="Seller_Register.php">Register New Shop</a></p>
        <p><a href="Forgot_Password.php">Forgot Password?</a></p>
    </div>
</body>
</html>