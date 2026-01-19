<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css"> 
    <style>
        
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; }
        .site-header { background: white; padding: 10px 40px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo img { height: 90px; width: auto; display: block; }
        .header-right { display: flex; align-items: center; gap: 20px; }
        .header-right a { text-decoration: none; color: #333; font-weight: bold; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .profile-grid { display: grid; grid-template-columns: 350px 1fr; gap: 30px; }
        .card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .card h2 { margin-top: 0; color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; font-size: 1.2rem; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; }
        .btn-update { width: 100%; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1rem; }
        .btn-update:hover { background: #219150; }
        .order-table { width: 100%; border-collapse: collapse; }
        .order-table th { text-align: left; padding: 12px; background: #f8f9fa; border-bottom: 2px solid #eee; color: #666; font-size: 0.9rem; }
        .order-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        .badge { padding: 5px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; white-space: nowrap; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-shipped { background: #d1ecf1; color: #0c5460; }
        .badge-delivered { background: #d4edda; color: #155724; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }
        .btn-view { text-decoration: none; color: #27ae60; font-weight: bold; font-size: 0.9rem; border: 1px solid #27ae60; padding: 4px 8px; border-radius: 4px; white-space: nowrap; }
        .btn-view:hover { background: #27ae60; color: white; }
        @media (max-width: 900px) { .profile-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

    <?php 
        $b_name  = $_SESSION['user_name'] ?? 'Guest';
        $b_email = ''; $b_phone = ''; $b_addr  = '';
        if (isset($buyer) && is_array($buyer)) {
            $b_name  = $buyer['Buyer_Name'] ?? $buyer['buyer_name'] ?? $b_name;
            $b_email = $buyer['Buyer_Email'] ?? $buyer['buyer_email'] ?? '';
            $b_phone = $buyer['Buyer_Phone'] ?? $buyer['buyer_phone'] ?? '';
            $b_addr  = $buyer['Buyer_Address'] ?? $buyer['buyer_address'] ?? '';
        }
    ?>

    <header class="site-header">
        <div class="logo">
            <a href="index.php?page=home">
                <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo">
            </a>
        </div>
        <div class="header-right">
            <span>Hi, <?php echo htmlspecialchars($b_name); ?></span>
            
            <a href="index.php?page=my_orders" style="margin-left: 15px;">My Orders</a>
            
            <a href="index.php?page=home">Shop</a>
            <a href="index.php?page=my_messages" class="btn-inbox" style="text-decoration:none;">Inbox</a>
            <a href="index.php?page=logout" style="color: #e74c3c;">Logout</a>
        </div>
    </header>

    <div class="container">
        <?php if(isset($_GET['success'])): ?>
            <div style="background:#d4edda; color:#155724; padding:15px; border-radius:5px; margin-bottom:20px;">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <div class="profile-grid">
            <div class="left-col">
                <div class="card">
                    <h2>Edit Profile</h2>
                    <form action="index.php?page=update_buyer_profile" method="POST">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="buyer_name" class="form-control" value="<?php echo htmlspecialchars($b_name); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email (Read Only)</label>
                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($b_email); ?>" disabled style="background:#eee;">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="buyer_phone" class="form-control" value="<?php echo htmlspecialchars($b_phone); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Default Address</label>
                            <textarea name="buyer_address" class="form-control" rows="4"><?php echo htmlspecialchars($b_addr); ?></textarea>
                        </div>
                        <button type="submit" class="btn-update">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="right-col">
                <div class="card">
                    <h2>Order History</h2>
                    <?php if (!empty($orders)): ?>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <?php 
                                        $o_id     = $order['Order_ID'] ?? $order['order_id'];
                                        $o_date   = $order['Order_Date'] ?? $order['order_date'];
                                        $o_total  = $order['Total_Amount'] ?? $order['total_amount'];
                                        $o_status = $order['Status'] ?? $order['status'] ?? $order['Order_Status'] ?? $order['order_status'];

                                        $cls = 'badge-pending';
                                        if(stripos($o_status, 'Ship') !== false) $cls = 'badge-shipped';
                                        if(stripos($o_status, 'Deliver') !== false) $cls = 'badge-delivered';
                                        if(stripos($o_status, 'Cancel') !== false) $cls = 'badge-cancelled';
                                    ?>
                                <tr>
                                    <td>#<?php echo $o_id; ?></td>
                                    <td><?php echo date("M d, Y", strtotime($o_date)); ?></td>
                                    <td>$<?php echo number_format($o_total, 2); ?></td>
                                    <td><span class="badge <?php echo $cls; ?>"><?php echo htmlspecialchars($o_status); ?></span></td>
                                    <td><a href="index.php?page=view_order&id=<?php echo $o_id; ?>" class="btn-view">Receipt</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div style="text-align:center; padding: 20px;">
                            <p style="color:#777;">You haven't placed any orders yet.</p>
                            <a href="index.php?page=home" style="color:#27ae60; font-weight:bold;">Start Shopping</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>