<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Delivery Form</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Home_Delivery.css" />
</head>
<body>
    <header class="site-header">
        <div class="logo">
            <a href="HomePage.html">
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
  <div class="page-container">
      <div class="register-box">
        <h2 class="register-heading">Home Delivery</h2>

        <form class="register-form">
          <div class="input-group">
            <label>Full Name:</label>
            <input type="text" placeholder="Enter full name">
          </div>

          <div class="input-group">
            <label>Mobile Number:</label>
            <input type="text" placeholder="Enter mobile number">
          </div>

          <div class="input-group">
            <label>Email:</label>
            <input type="email" placeholder="Enter email">
          </div>

          <div class="input-group">
            <label>City:</label>
            <input type="text" placeholder="Enter city">
          </div>

          <div class="input-group">
            <label>Postal Code:</label>
            <input type="text" placeholder="Enter postal code">
          </div>

          <div class="input-group">
            <label>Full Address:</label>
            <textarea placeholder="Enter full address"></textarea>
          </div>
          <label>Payment method:</label>
          <div class="payment">
                <label><input type="radio" name="pay"> Online Payment</label>
                <label><input type="radio" name="pay"> Cash on Delivery</label>
            </div>

          <div class="button-group">
            <button type="submit" class="action-btn login-btn">Confirm to Continue</button>
            </button>
          </div>
        </form>
      </div>
    </div>
   <?php include 'Footer.php'; ?>
  </body>
</html>

