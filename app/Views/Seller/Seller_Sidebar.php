<aside class="sidebar">
    <div class="sidebar-profile">
        <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" 
             alt="Profile" 
             style="width: 80px; height: 80px; border-radius: 50%;">
             
        <p class="seller-name">
            <?php echo htmlspecialchars($_SESSION['seller_name'] ?? 'Seller'); ?>
        </p>
        <p class="seller-role">Seller Account</p>
    </div>
    
    <nav class="nav-menu">
        
        <a href="index.php?page=seller_dashboard" 
           class="nav-item <?php echo (!isset($_GET['page']) || $_GET['page'] == 'seller_dashboard') ? 'active' : ''; ?>">
           Dashboard Home
        </a>

        <a href="index.php?page=seller_add_product" 
           class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_add_product') ? 'active' : ''; ?>">
           Add Products
        </a>
        
        <a href="index.php?page=seller_listed_products" 
           class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_listed_products') ? 'active' : ''; ?>">
           Listed Products
        </a>
        
        <a href="index.php?page=seller_orders" 
           class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_orders') ? 'active' : ''; ?>">
           Orders
        </a>
        
        <a href="index.php?page=seller_reviews" 
           class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_reviews') ? 'active' : ''; ?>">
           Reviews
        </a>

        <a href="index.php?page=seller_messages" class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_messages') ? 'active' : ''; ?>">
     Seller Inbox
</a>
        
        <a href="index.php?page=seller_profile" 
           class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_profile') ? 'active' : ''; ?>">
           Profile
        </a>
        
        <a href="index.php?page=logout" class="nav-item logout">Logout</a>
    </nav>
</aside>