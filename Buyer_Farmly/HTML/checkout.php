<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farmly - Checkout</title>
  <link rel="stylesheet" href="../../Buyer_Farmly/CSS/checkout.css">
</head>

<body>
<header class="main-header">
  <img src="./Logo/Team Logo.png" class="small-logo">

  <button class="home-btn" onclick="window.location.href='HomePage.php'">
    Home
  </button>


  <h2 class=>Checkout</h2>
</header>


  <!-- Main Content -->
  <div class="container">

    <!-- Delivery Method -->
    <div class="left-box">
      <h3>Delivery Method</h3>
<button class="delivery-btn" onclick="window.location.href='Order_Confirmation.php'">
  Home Delivery
</button>

<button class="delivery-btn" onclick="window.location.href='Order_Confirmation.php'">
  Pickup
</button>
    </div>

    <!-- Order Summary -->
    <div class="right-box">
      <h3>Order Summary</h3>

      <div class="order-item">
        <img src="./images/Apple.png" class="icon">
        <div>
          <b>Apple</b><br>
          Quantity: 20<br>
          Price per piece: €0.50
        </div>
      </div>

      <div class="order-item">
        <img src="./images/Carrot.png" class="icon">
        <div>
          <b>Carrot</b><br>
          Quantity: 20<br>
          Price per piece: €0.50
        </div>
      </div>

      <p>Sub-Total: €20</p>
      <p>Shipping: €20</p>
      <p><b>Total: €40</b></p>
    </div>

  </div>

  
<?php include '../Header_Footer/footer.php'; ?>
</body>
</html>
