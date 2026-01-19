<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Login.css?v=5.0">
</head>
<body>

    <header class="top-header">
        <a href="index.php?page=home">
            <img src="assets/images/Logo/Team Logo.png" alt="Farmly" class="header-logo" 
                 onerror="this.style.display='none'">
        </a>
    </header>

    <section class="main-section">
        <div class="login-card">
            <h2 class="login-title">Seller Login</h2>
            
            <?php if(isset($_GET['success'])): ?>
                <p style="color:green; margin-bottom:15px; font-weight:600;">Shop registered successfully! Please login.</p>
            <?php endif; ?>

            <?php if(isset($error)): ?>
                <p style="color:red; margin-bottom:15px; font-weight:600;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?page=seller_login">
                
                <div class="form-field">
                    <label>Email Address</label>
                    <input type="email" name="seller_email" required placeholder="Enter your shop email">
                </div>

                <div class="form-field">
                    <label>Password</label>
                    <input type="password" name="seller_password" required placeholder="Enter your password">
                </div>

                <button type="submit" class="login-btn">Login</button>

            </form>
            
            <div class="create">
                <a href="index.php?page=seller_register">Register New Shop</a>
            </div>
            <div class="forgot">
                <a href="index.php?page=seller_forgot_password">Forgot Password?</a>
            </div>
        </div>
    </section>

   <?php include __DIR__ . '/Seller_Footer.php'; ?>

</body>
</html>