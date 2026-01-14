<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Placed! - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        .success-card {
            max-width: 600px; margin: 60px auto; background: white; padding: 40px;
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;
        }
        .checkmark { font-size: 80px; color: #27ae60; display: block; margin-bottom: 20px; }
        .btn-home { 
            background: #27ae60; color: white; padding: 10px 20px; 
            text-decoration: none; border-radius: 5px; font-weight: bold; 
        }
        .btn-orders {
            background: #333; color: white; padding: 10px 20px; 
            text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 10px;
        }
    </style>
</head>
<body style="background: #f4f4f4;">

   

    <div class="success-card">
        <span class="checkmark">✔</span>
        <h1 style="color: #333;">Order Placed Successfully!</h1>
        <p style="color: #777; margin-bottom: 30px;">
            Thank you for shopping with Farmly. Your order #<?php echo $_GET['id'] ?? ''; ?> has been received.
        </p>
        
        <div>
            <a href="index.php?page=home" class="btn-home">Continue Shopping</a>
            <a href="index.php?page=my_orders" class="btn-orders">View My Orders</a>
        </div>
    </div>

    <?php include __DIR__ . '/Buyer_Footer.php'; ?>
</body>
</html>