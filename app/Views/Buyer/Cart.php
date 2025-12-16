<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmly - Cart</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/cart.css" />
  </head>
  <body>
    <header class="main-header">
      <img src="./Logo/Team Logo.png" class="small-logo" />
      <h2>My Cart</h2>
      <button class="home-btn" onclick="window.location.href='HomePage.php'">
        Home
      </button>
    </header>

    <!-- Main Section -->
    <div class="main-container">
      <!-- Products -->
      <div class="products-box">
        <h3 class="section-title">Products</h3>

        <div class="product-item">
          <img src="./images/Apple.png" class="product-icon" />
          <div class="product-details">
            <b>Apple</b>
            <div class="product-meta">
              <span class="qty">Qty: 1 kg</span>
              <span class="price">€1</span>
            </div>
          </div>
        </div>

        <div class="product-item">
          <img src="./images/Carrot.png" class="product-icon" />
          <div class="product-details">
            <b>Carrot</b>
            <div class="product-meta">
              <span class="qty">Qty: 1 kg</span>
              <span class="price">€1</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div class="summary-box">
        <h3>Order Summary</h3>
        <div class="summary-item">
          <span>Apple (1 × €1)</span>
          <span>€1</span>
        </div>
        <div class="summary-item">
          <span>Carrot (1 × €1)</span>
          <span>€1</span>
        </div>
        <hr />
        <div class="summary-item total">
          <span>Subtotal</span>
          <span>€2</span>
        </div>
        <a href="checkout.php" class="checkout-link">Proceed to Checkout</a>
      </div>
    </div>

    <?php include 'Footer.php'; ?>
  </body>
</html>
