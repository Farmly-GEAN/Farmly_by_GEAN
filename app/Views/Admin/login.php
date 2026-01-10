<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - Farmly Control</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
</head>
<body class="admin-login-body">

    <div class="login-box">
        <div class="login-header">
            <h2>🛡️ Admin Control</h2>
            <p>Authorized Personnel Only</p>
        </div>

        <?php if(isset($error)): ?>
            <p class="error-msg"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?page=admin_login">
            <div class="input-group">
                <label>Email Access</label>
                <input type="email" name="email" placeholder="admin@farmly.com" required>
            </div>
            
            <div class="input-group">
                <label>Secure Key (Password)</label>
                <input type="password" name="password" placeholder="••••••" required>
            </div>

            <button type="submit" class="btn-login">Access Dashboard</button>
        </form>

        <a href="index.php?page=landing" class="back-link">← Back to Site</a>
    </div>

</body>
</html>