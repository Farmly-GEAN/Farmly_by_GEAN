<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Login</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Login.css">
</head>
<body>
    <div class="login-card">
        <h2>Seller Portal Login</h2>
        
        <?php if(isset($_GET['success'])): ?>
            <p style="color:green; text-align:center; font-weight: bold;">Shop registered successfully! Please login.</p>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <p style="color:red; text-align:center; font-weight: bold;"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?page=seller_login">
            <label>Email</label>
            <input type="email" name="seller_email" required placeholder="Enter email">

            <label>Password</label>
            <input type="password" name="seller_password" required placeholder="Enter password">

            <button type="submit">Login</button>
        </form>
        
        <p><a href="index.php?page=seller_register">Register New Shop</a></p>
        <p><a href="#">Forgot Password?</a></p>
    </div>
</body>
</html>