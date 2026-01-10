<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmly - Home Page</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css" />
  </head>
  <body>
    <header class="site-header">
      <div class="logo">
        <a href="index.php?page=home">
          <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo" />
        </a>
      </div>

      <div class="search-container">
        <form action="index.php" method="GET">
          <input type="hidden" name="page" value="home">
          <input 
            type="text" 
            name="search" 
            class="search-bar" 
            placeholder="SEARCH PRODUCTS" 
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
          />
        </form>
      </div>

      <nav class="user-nav">
        <span style="margin-right: 15px; font-weight: bold; color: #2c3e50;">
            Hi, <?php echo htmlspecialchars($user_name); ?>
        </span>
        
        <a href="index.php?page=cart" class="nav-button">
          <img src="assets/images/Logo/shopping-bag.png" alt="Cart" class="nav-icon" />
          <span>CART</span>
        </a>

        <a href="index.php?page=profile" class="nav-button">
          <img src="assets/images/Logo/user.png" alt="Profile" class="nav-icon" />
          <span>PROFILE</span>
        </a>
        
        <a href="index.php?page=logout" class="nav-button" style="color: red;">
            <span>LOGOUT</span>
        </a>
      </nav>
    </header>

    <div class="main-container">
      
      <aside class="sidebar-nav">
        <ul>
          <li><a href="index.php?page=home"><b>All Products</b></a></li>
          <li><a href="index.php?page=home&category=Fruits"><b>Fruits</b></a></li>
          <li><a href="index.php?page=home&category=Vegetables"><b>Vegetables</b></a></li>
          <li><a href="index.php?page=home&category=Dairy"><b>Dairy Products</b></a></li>
        </ul>
      </aside>

      <main class="product-listing">
        
        <?php if (!empty($products) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    
                    <a href="index.php?page=product_detail&id=<?php echo $product['product_id']; ?>" style="text-decoration:none;">
                        <img 
                            src="<?php echo htmlspecialchars($product['product_image']); ?>" 
                            alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                            onerror="this.src='assets/images/default.png';"
                            style="cursor: pointer; transition: 0.3s;"
                            onmouseover="this.style.opacity='0.8'" 
                            onmouseout="this.style.opacity='1'"
                        />
                    </a>
                    
                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    
                    <p class="product-info">
                        <?php if($product['stocks_available'] > 0): ?>
                            <span style="color: green;"><?php echo $product['stocks_available']; ?> kg left</span>
                        <?php else: ?>
                            <span style="color: red; font-weight: bold;">OUT OF STOCK</span>
                        <?php endif; ?>
                        • 
                        <strong>$<?php echo number_format($product['price'], 2); ?></strong>
                    </p>
                    
                    <?php if($product['stocks_available'] > 0): ?>
                        <form action="index.php?page=add_to_cart" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="action" value="add">
                            <button type="submit" class="add-to-cart-btn">ADD TO CART</button>
                        </form>
                    <?php else: ?>
                        <button disabled style="background: #ccc; cursor: not-allowed; width: 100%; padding: 10px; border: none; border-radius: 5px; color: #666;">
                            Unavailable
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        
        <?php else: ?>
            <div style="text-align: center; width: 100%; margin-top: 50px;">
                <h3>No products found.</h3>
                <p>Try searching for something else or check back later!</p>
                <a href="index.php?page=home" style="color: green; text-decoration: underline;">View All Products</a>
            </div>
        <?php endif; ?>

      </main>
    </div>

    <?php include __DIR__ . '/Footer.php'; ?>
  </body>
</html>