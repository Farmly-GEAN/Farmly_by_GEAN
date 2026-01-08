<aside class="sidebar">
    <a href="index.php?page=seller_dashboard" 
       class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_dashboard') ? 'active' : ''; ?>">
       Add Products
    </a>
    
    <a href="index.php?page=seller_listed_products" 
       class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_listed_products') ? 'active' : ''; ?>">
       Listed Products
    </a>
    
    <a href="index.php?page=seller_orders" 
       class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_orders') ? 'active' : ''; ?>">
       Orders
    </a>
    
    <a href="index.php?page=seller_reviews" 
       class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_reviews') ? 'active' : ''; ?>">
       Reviews
    </a>
    
    <a href="index.php?page=seller_profile" 
       class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'seller_profile') ? 'active' : ''; ?>">
       Profile
    </a>
</aside>