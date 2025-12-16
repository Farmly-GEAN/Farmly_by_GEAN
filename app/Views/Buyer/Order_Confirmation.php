<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="../CSS/OrderConfirmation.css">
</head>
<body>
<header class="header">
    <div class="logo-section">
        <img src="./Logo/Team Logo.png" alt="Farmly Logo" class="logo">
    </div>

    <div class="icons">
        <div class="cart">
            <img src="../Logo/turn-off.png" class="icon-img" alt="">
            <span>Logout</span>
        </div>

        <div class="profile">
            <img src="./Logo/user.png" class="icon-img" alt="">
            <span>PROFILE</span>
        </div>
    </div>
</header>

<div class="order-box">
    <h2 class="order-title">Order Confirmation</h2>

    <div class="order-content">
        <p><strong>Order ID:</strong> </p>
        <p><strong>Address Confirmation:</strong></p>
        <p><strong>Payment Method:</strong> </p>
        <p><strong>Estimated Delivery Date / Pickup:</strong> </p>
    </div>

    <p class="thankyou">Thank you!</p>

    <div class="button-container">
        <button class="btn cancel">Cancel Order</button>
    <button class="btn continue" ><a href="HomePage.php">Continue</a>  </button>
</div>
</div> 
 <?php include '../Header_Footer/footer.php'; ?>
</body>
</html>