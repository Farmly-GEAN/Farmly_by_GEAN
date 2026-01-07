<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Placed! - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; text-align: center; padding: 50px; background-color: #f9f9f9; }
        .success-container { background: white; max-width: 600px; margin: 0 auto; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        h1 { color: #27ae60; margin-bottom: 10px; }
        p { color: #555; font-size: 1.1rem; }
        .btn { display: inline-block; padding: 12px 25px; margin-top: 20px; text-decoration: none; border-radius: 50px; font-weight: bold; transition: transform 0.2s; }
        .btn:hover { transform: scale(1.05); }
        .btn-home { background-color: #27ae60; color: white; border: 2px solid #27ae60; }
        .btn-profile { background-color: white; color: #333; border: 2px solid #333; margin-left: 10px; }
    </style>
</head>
<body>

    <div class="success-container">
        <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo" style="height: 80px; margin-bottom: 20px;">
        
        <h1>Order Placed Successfully!</h1>
        <p>Thank you for shopping with Farmly.</p>
        
        <?php if(isset($_GET['id'])): ?>
            <p style="margin-top: 10px; font-size: 1.2rem;">
                Your Order ID: <strong>#<?php echo htmlspecialchars($_GET['id']); ?></strong>
            </p>
        <?php endif; ?>
        
        <p style="font-size: 0.9rem; color: #888; margin-top: 5px;">
            You can track your order status in your profile.
        </p>

        <div style="margin-top: 30px;">
            <a href="index.php?page=home" class="btn btn-home">Continue Shopping</a>
            <a href="index.php?page=profile" class="btn btn-profile">View Order History</a>
        </div>
    </div>

</body>
</html>