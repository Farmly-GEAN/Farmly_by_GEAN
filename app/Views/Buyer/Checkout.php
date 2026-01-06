<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Farmly - Checkout</title>
  <link rel="stylesheet" href="assets/CSS/checkout.css">
  
  <style>
      .address-box {
          width: 100%;
          height: 80px;
          margin-bottom: 15px;
          padding: 10px;
          border-radius: 5px;
          border: 1px solid #ccc;
          font-family: inherit;
      }
      .alert-empty { color: red; font-size: 0.9em; margin-bottom: 10px; display: block; }
  </style>
</head>

<body>
<header class="main-header">
  <img src="assets/images/Logo/Team Logo.png" class="small-logo">

  <button class="home-btn" onclick="window.location.href='index.php?page=home'">
    Home
  </button>

  <h2>Checkout</h2>
</header>

  <div class="container">

    <div class="left-box">
      <h3>Delivery Method</h3>
      
      <form action="index.php?page=place_order" method="POST">
          
          <label for="address"><strong>Shipping Address:</strong></label>
          <textarea name="address" class="address-box" placeholder="Enter full address for delivery..." required></textarea>

          <button type="submit" class="delivery-btn" style="background-color: #27ae60; color: white; cursor: pointer;">
            Confirm Home Delivery
          </button>
      </form>

      <div style="margin-top: 10px; text-align: center; color: #777;">
          <p>- OR -</p>
      </div>
      
      <form action="index.php?page=place_order" method="POST">
          <input type="hidden" name="address" value="PICKUP FROM STORE">
          <button type="submit" class="delivery-btn" style="background-color: #f39c12; color: white; cursor: pointer;">
            Pickup at Store
          </button>
      </form>
    </div>

    <div class="right-box">
      <h3>Order Summary</h3>

      <?php if (!empty($cartItems)): ?>
          <?php foreach ($cartItems as $item): ?>
              <div class="order-item">
                <img src="assets/uploads/products/<?php echo htmlspecialchars(basename($item['product_image'])); ?>" 
                     class="icon" 
                     onerror="this.src='assets/images/default.png';">
                
                <div>
                  <b><?php echo htmlspecialchars($item['product_name']); ?></b><br>
                  Quantity: <?php echo $item['quantity']; ?><br>
                  Price per piece: $<?php echo number_format($item['price'], 2); ?>
                </div>
              </div>
          <?php endforeach; ?>
      <?php else: ?>
          <p>Your cart is empty.</p>
      <?php endif; ?>

      <hr style="border: 1px solid #eee; margin: 10px 0;">

      <p>Sub-Total: <strong>$<?php echo number_format($totalPrice, 2); ?></strong></p>
      <p>Shipping: <strong>$5.00</strong></p> <p style="font-size: 1.2em; color: #27ae60;">
          <b>Total: $<?php echo number_format($totalPrice + 5, 2); ?></b>
      </p>
    </div>

  </div>

<?php  include 'Footer.php'; ?>

</body>
</html>