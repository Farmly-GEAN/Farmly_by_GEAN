<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmly - Home Page</title>

    <!-- CSS File Link -->
    <link rel="stylesheet" href="../../../public/assets/CSS/HomePage.css" />
  </head>
  <body>
    <header class="site-header">
      <div class="logo">
        <a href="HomePage.php">
          <img src="../Logo/Team Logo.png" alt="Farmly Logo" />
        </a>
      </div>

      <div class="search-container">
        <form action="/search" method="get">
          <input type="text" class="search-bar" placeholder="SEARCH PRODUCTS" />
        </form>
      </div>

      <nav class="user-nav">
        <a href="cart.html" class="nav-button">
          <img
            src="../Logo/shopping-bag.png"
            alt="Cart Icon"
            class="nav-icon"
          />
          <span>CART</span>
        </a>

        <a href="profile.html" class="nav-button">
          <img src="../Logo/user.png" alt="Profile Icon" class="nav-icon" />
          <span>PROFILE</span>
        </a>
      </nav>
    </header>
    <!-- ================= END HEADER ================= -->

    <div class="main-container">
      <!-- Sidebar -->
      <aside class="sidebar-nav">
        <ul>
          <li>
            <a href="all-products.html"><b>All Products</b></a>
          </li>
          <li>
            <a href="fruits.html"><b>Fruits</b></a>
          </li>
          <li>
            <a href="vegetables.html"><b>Vegetables</b></a>
          </li>
          <li>
            <a href="dairy.html"><b>Dairy Products</b></a>
          </li>
        </ul>
      </aside>

      <!-- Product List -->
      <main class="product-listing">
        <div class="product-card">
          <img src="../HTML/images/Apple.png" alt="Red Apple" />
          <h3>Apple</h3>
          <p class="product-info">1kg • $2.99</p>
          <button class="add-to-cart-btn">ADD TO CART</button>
        </div>

        <div class="product-card">
          <img src="../HTML/images/Lettuce.png" alt="Fresh Lettuce" />
          <h3>Lettuce</h3>
          <p class="product-info">1 Head • $1.49</p>
          <button class="add-to-cart-btn">ADD TO CART</button>
        </div>

        <div class="product-card">
          <img src="../HTML/images/Carrot.png" alt="Carrots" />
          <h3>Carrots</h3>
          <p class="product-info">1 Bunch • $1.99</p>
          <button class="add-to-cart-btn">ADD TO CART</button>
        </div>

        <div class="product-card">
          <img src="../HTML/images/Milk.png" alt="Milk Bottle" />
          <h3>Fresh Milk</h3>
          <p class="product-info">1 Liter • $3.50</p>
          <button class="add-to-cart-btn">ADD TO CART</button>
        </div>
      </main>
    </div>

    <?php include 'Footer.php'; ?>
  </body>
</html>
