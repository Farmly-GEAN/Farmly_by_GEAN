<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pick Up</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/PickUp.css" />
  </head>
  <body>
    <header class="site-header">
      <div class="logo">
        <a href="HomePage.php">
          <img src="./Logo/Team Logo.png" alt="Farmly Logo" />
        </a>
      </div>
      <div class="search-container">
        <form action="/search" method="get">
          <input type="text" class="search-bar" placeholder="SEARCH PRODUCTS" />
        </form>
      </div>

      <nav class="user-nav">
        <a href="cart.html" class="nav-button">
          <img src="./Logo/shopping-bag.png" alt="Cart Icon" class="nav-icon" />
          <span>CART</span>
        </a>

        <a href="profile.html" class="nav-button">
          <img src=".\Logo\user.png" alt="Profile Icon" class="nav-icon" />
          <span>PROFILE</span>
        </a>
      </nav>
    </header>

    <h2 class="title">Pick Up</h2>

    <div class="container">
      <label class="section-label">Schedule Delivery</label>

      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" />
      </div>

      <div class="form-group">
        <label for="time">Time:</label>
        <input type="time" id="time" />
      </div>

      <div class="form-group">
        <label for="note">Note:</label>
        <input type="text" id="note" placeholder="(optional)" />
      </div>

      <label class="section-label">Payment method:</label>

      <div class="payment-options">
        <label><input type="radio" name="payment" /> Online Payment</label>
        <label><input type="radio" name="payment" /> Cash on Delivery</label>
      </div>
      <div class="button-group">
        <button class="action-btn login-btn">Confirm to Continue</button>
      </div>
    </div>

    <?php include 'Footer.php'; ?>
  </body>
</html>
