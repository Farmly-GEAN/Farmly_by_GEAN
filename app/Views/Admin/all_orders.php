<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Orders - Admin</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .admin-table th, .admin-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        .admin-table th { background-color: #f8f9fa; color: #555; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; }
        .admin-table tr:hover { background-color: #f9f9f9; }

        /* Status Badges */
        .status { padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: bold; }
        .status-pending { background: #fff3e0; color: #e67e22; }
        .status-shipped { background: #e3f2fd; color: #3498db; }
        .status-delivered { background: #e8f5e9; color: #2ecc71; }
        .status-cancelled { background: #ffebee; color: #c62828; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <h2>All Orders</h2>
            <div class="user-info">Admin Panel</div>
        </header>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Buyer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $o): ?>
                    
                    <?php 
                        // SAFETY CHECK: Handle DB Case Sensitivity
                        $o_id     = $o['Order_ID'] ?? $o['order_id'];
                        $b_name   = $o['Buyer_Name'] ?? $o['buyer_name'] ?? 'Unknown';
                        $o_amount = $o['Total_Amount'] ?? $o['total_amount'];
                        $o_date   = $o['Order_Date'] ?? $o['order_date'];
                        $o_status = $o['Order_Status'] ?? $o['order_status'] ?? 'Pending';
                        
                        // Badge Logic
                        $badgeClass = 'status-pending';
                        if(stripos($o_status, 'Shipped') !== false) $badgeClass = 'status-shipped';
                        if(stripos($o_status, 'Delivered') !== false) $badgeClass = 'status-delivered';
                        if(stripos($o_status, 'Cancelled') !== false) $badgeClass = 'status-cancelled';
                    ?>

                    <tr>
                        <td>#<?php echo htmlspecialchars($o_id); ?></td>
                        <td><strong><?php echo htmlspecialchars($b_name); ?></strong></td>
                        <td style="color:#777; font-size:0.9rem;"><?php echo date('M d, Y', strtotime($o_date)); ?></td>
                        <td>$<?php echo htmlspecialchars($o_amount); ?></td>
                        <td>
                            <span class="status <?php echo $badgeClass; ?>">
                                <?php echo htmlspecialchars($o_status); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 30px;">No orders found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

</body>
</html>