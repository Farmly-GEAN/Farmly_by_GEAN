<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seller Dashboard - Home</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); text-align: center; border-bottom: 4px solid #ddd; }
        
        .stat-card.money { border-bottom-color: #27ae60; }
        .stat-card.orders { border-bottom-color: #2980b9; }
        .stat-card.products { border-bottom-color: #f39c12; }

        .stat-number { font-size: 2.5rem; font-weight: bold; color: #333; margin: 10px 0; }
        .stat-label { color: #777; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; }

        .recent-section { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .section-title { font-size: 1.2rem; margin-bottom: 15px; color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; color: #777; font-size: 0.85rem; padding: 10px; border-bottom: 1px solid #eee; }
        td { padding: 12px 10px; color: #333; font-size: 0.95rem; border-bottom: 1px solid #f9f9f9; }
        .status-badge { padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: bold; }
        .status-Pending { background: #fff3cd; color: #856404; }
        .status-Delivered { background: #d4edda; color: #155724; }
        .status-Shipped { background: #d1ecf1; color: #0c5460; }
        .status-Cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Dashboard Overview</h2>
            
            <div class="stats-grid">
                <div class="stat-card money">
                    <div class="stat-label">Total Earnings</div>
                    <div class="stat-number">$<?php echo number_format($earnings, 2); ?></div>
                </div>
                <div class="stat-card orders">
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-number"><?php echo $total_orders; ?></div>
                </div>
                <div class="stat-card products">
                    <div class="stat-label">Active Products</div>
                    <div class="stat-number"><?php echo $total_products; ?></div>
                </div>
            </div>

            <div class="recent-section">
                <h3 class="section-title">Recent Orders</h3>
                <?php if (!empty($recent_orders)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_orders as $order): ?>
                                <?php 
                                    $o_id = $order['Order_ID'] ?? $order['order_id'];
                                    $o_date = date("M d", strtotime($order['Order_Date'] ?? $order['order_date']));
                                    $p_name = $order['Product_Name'] ?? $order['product_name'] ?? 'Item';
                                    $o_status = $order['Status'] ?? $order['status'] ?? 'Pending';
                                    
                                    // Calculate simplistic total for row (Qty * Price would be better, but Total_Amount works for order level)
                                    $total = $order['Total_Amount'] ?? 0; 
                                ?>
                                <tr>
                                    <td>#<?php echo $o_id; ?></td>
                                    <td><?php echo $o_date; ?></td>
                                    <td><?php echo htmlspecialchars($p_name); ?></td>
                                    <td>$<?php echo number_format($total, 2); ?></td>
                                    <td><span class="status-badge status-<?php echo $o_status; ?>"><?php echo $o_status; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div style="margin-top: 15px; text-align: right;">
                        <a href="index.php?page=seller_orders" style="color: #27ae60; text-decoration: none; font-weight: bold;">View All Orders &rarr;</a>
                    </div>
                <?php else: ?>
                    <p style="color:#888; text-align:center; padding:20px;">No orders yet.</p>
                <?php endif; ?>
            </div>

        </main>
    </div>
</div>

<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>