<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Farmly</title>
    <style>
        /* --- INTERNAL CSS --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #ffffff; color: #333; min-height: 100vh; display: flex; flex-direction: column; }

        /* HEADER */
        .site-header { display: flex; align-items: center; justify-content: space-between; padding: 15px 40px; border-bottom: 2px solid #333; }
        .logo img { height: 50px; width: auto; }
        .back-btn { text-decoration: none; color: #333; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }

        /* MAIN CONTAINER */
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; width: 100%; }
        
        .profile-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 30px;
        }
        .page-title { font-size: 2rem; font-weight: 300; text-transform: uppercase; letter-spacing: 2px; }
        .logout-btn { 
            background: #e74c3c; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 0.9rem;
        }

        /* CARD STYLE */
        .card {
            border: 2px solid #333; border-radius: 20px; padding: 30px; margin-bottom: 30px;
            box-shadow: 5px 5px 0px #eee;
        }
        .card-title { font-family: 'Courier New', monospace; font-size: 1.2rem; margin-bottom: 20px; border-bottom: 1px dashed #ccc; padding-bottom: 10px; }

        /* ORDER TABLE */
        .order-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .order-table th { text-align: left; padding: 10px; background: #f9f9f9; border-bottom: 2px solid #333; font-family: 'Courier New', monospace; }
        .order-table td { padding: 15px 10px; border-bottom: 1px solid #eee; vertical-align: middle; }
        
        /* STATUS BADGES */
        .status-badge {
            padding: 5px 10px; border-radius: 12px; font-size: 0.85rem; font-weight: bold;
            text-transform: uppercase; display: inline-block;
        }
        .status-pending { background: #f39c12; color: white; }
        .status-shipped { background: #3498db; color: white; }
        .status-delivered { background: #27ae60; color: white; }
        .status-cancelled { background: #e74c3c; color: white; }

        /* BUTTONS */
        .btn-view {
            text-decoration: none; color: #2980b9; font-weight: bold; font-size: 0.9rem; 
            border: 1px solid #2980b9; padding: 5px 10px; border-radius: 5px; transition: 0.2s;
        }
        .btn-view:hover { background: #2980b9; color: white; }

        @media (max-width: 768px) { .order-table { font-size: 0.9rem; } }
    </style>
</head>
<body>

    <header class="site-header">
        <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" class="logo" alt="Logo"></a>
        <a href="index.php?page=home" class="back-link">Back to Shop</a>
    </header>

    <div class="container">
        
        <div class="profile-header">
            <h1 class="page-title">My Profile</h1>
            <a href="index.php?page=logout" class="nav-button" style="color: red; text-decoration: none; font-weight: bold;">
                LOGOUT
            </a>
        </div>

        <div class="card">
            <div class="card-title">User Information</div>
            <?php 
                $b_name = $user_name ?? $user['Buyer_Name'] ?? 'Guest';
                $b_id   = $buyer_id ?? $user_id ?? $user['Buyer_ID'] ?? 'N/A';
            ?>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($b_name); ?></p>
            <p style="color: #777; font-size: 0.9rem; margin-top: 5px;">(Account ID: #<?php echo $b_id; ?>)</p>
        </div>

        <div class="card">
            <div class="card-title">Order History</div>

            <?php if (!empty($orders)): ?>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            
                            <?php 
                                // SAFETY CHECK: Handle DB Column Case Sensitivity
                                $o_id = $order['order_id'] ?? $order['Order_ID'];
                                $o_date = $order['order_date'] ?? $order['Order_Date'];
                                $o_total = $order['total_amount'] ?? $order['Total_Amount'];
                                $o_status = $order['order_status'] ?? $order['Order_Status'];
                                $o_addr = $order['shipping_address'] ?? $order['Shipping_Address'];

                                // Status Color Logic
                                $class = 'status-pending';
                                if(stripos($o_status, 'Shipped') !== false) $class = 'status-shipped';
                                if(stripos($o_status, 'Delivered') !== false) $class = 'status-delivered';
                                if(stripos($o_status, 'Cancelled') !== false) $class = 'status-cancelled';
                            ?>

                            <tr>
                                <td>#<?php echo $o_id; ?></td>
                                <td><?php echo date("d M Y", strtotime($o_date)); ?></td>
                                <td><strong>$<?php echo number_format($o_total, 2); ?></strong></td>
                                <td>
                                    <span class="status-badge <?php echo $class; ?>">
                                        <?php echo htmlspecialchars($o_status); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="index.php?page=view_order&id=<?php echo $o_id; ?>" class="btn-view">
                                        View Receipt
                                    </a>
                                </td>
                                <td>
                                    <?php if (stripos($o_status, 'Pending') !== false): ?>
                                        <form action="index.php?page=cancel_order" method="POST" onsubmit="return confirm('Are you sure you want to cancel Order #<?php echo $o_id; ?>?');">
                                            <input type="hidden" name="order_id" value="<?php echo $o_id; ?>">
                                            <button type="submit" style="background:#e74c3c; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer; font-weight:bold;">
                                                Cancel
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: #ccc;">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #777; padding: 20px;">You haven't placed any orders yet.</p>
                <div style="text-align: center;">
                    <a href="index.php?page=home" style="color: #27ae60; font-weight: bold;">Start Shopping</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

</body>
</html>