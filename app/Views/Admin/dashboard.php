<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    <style>
        /* Dashboard Card Styling */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; }
        .stat-info h3 { margin: 0; font-size: 2rem; color: #2c3e50; }
        .stat-info p { margin: 5px 0 0; color: #7f8c8d; font-weight: bold; font-size: 0.9rem; text-transform: uppercase; }
        .stat-icon { font-size: 2.5rem; opacity: 0.2; }
        
        .stat-sales { border-left: 5px solid #27ae60; }
        .stat-orders { border-left: 5px solid #3498db; }
        .stat-users { border-left: 5px solid #f39c12; }
        .stat-products { border-left: 5px solid #9b59b6; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <h2>Dashboard Overview</h2>
            <div class="user-info">Welcome, Admin</div>
        </header>

        <div class="stats-grid">
            
            <!-- <div class="stat-card stat-sales">
                <div class="stat-info">
                    <h3>$<?php echo number_format($stats['total_sales'], 2); ?></h3>
                    <p>Total Revenue</p>
                </div>
                <div class="stat-icon" style="color: #27ae60;">💰</div>
            </div> -->

            <div class="stat-card stat-orders">
                <div class="stat-info">
                    <h3><?php echo $stats['total_orders']; ?></h3>
                    <p>Total Orders</p>
                </div>
                <div class="stat-icon" style="color: #3498db;">📦</div>
            </div>

            <div class="stat-card stat-users">
                <div class="stat-info">
                    <h3><?php echo $stats['total_users']; ?></h3>
                    <p>Active Users</p>
                </div>
                <div class="stat-icon" style="color: #f39c12;">👥</div>
            </div>

            <div class="stat-card stat-products">
                <div class="stat-info">
                    <h3><?php echo $stats['total_products']; ?></h3>
                    <p>Products Listed</p>
                </div>
                <div class="stat-icon" style="color: #9b59b6;">🍎</div>
            </div>

        </div>

        <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="margin-top: 0;">Quick Actions</h3>
            <p>What would you like to manage today?</p>
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="index.php?page=admin_users" style="text-decoration: none; padding: 10px 20px; background: #34495e; color: white; border-radius: 5px;">Manage Users</a>
                <a href="index.php?page=admin_products" style="text-decoration: none; padding: 10px 20px; background: #34495e; color: white; border-radius: 5px;">Manage Products</a>
                <a href="index.php?page=admin_orders" style="text-decoration: none; padding: 10px 20px; background: #27ae60; color: white; border-radius: 5px;">View Orders</a>
            </div>
        </div>

    </main>
</div>

</body>
</html>