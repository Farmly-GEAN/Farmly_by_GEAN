<aside class="sidebar">
    <div class="sidebar-header">
        <h3>Farmly Admin</h3>
        <small>Super User</small>
    </div>
    
    <nav class="nav-links">
        <a href="index.php?page=admin_dashboard" 
           class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'admin_dashboard') ? 'active' : ''; ?>">
           📊 Dashboard
        </a>

        <a href="index.php?page=admin_sellers" 
           class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'admin_sellers') ? 'active' : ''; ?>">
           👥 Manage Sellers
        </a>

        <a href="index.php?page=admin_buyers" 
           class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'admin_buyers') ? 'active' : ''; ?>">
           🛍️ Manage Buyers
        </a>

        <a href="index.php?page=admin_products" 
   class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'admin_products') ? 'active' : ''; ?>">
   🛒 Manage Products
</a>
       <a href="index.php?page=admin_orders" 
   class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'admin_orders') ? 'active' : ''; ?>">
   📦 All Orders
</a>

         <a href="index.php?page=admin_messages" 
       class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'admin_messages') ? 'active' : ''; ?>">
       ✉️ Messages & Feedback
    </a>
        <a href="index.php?page=admin_logout" class="logout">
           🔒 Logout
        </a>
    </nav>
</aside>