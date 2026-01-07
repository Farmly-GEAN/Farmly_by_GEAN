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
        .order-table td { padding: 15px 10px; border-bottom: 1px solid #eee; }
        
        .status-badge {
            padding: 5px 10px; border-radius: 12px; font-size: 0.85rem; font-weight: bold;
            text-transform: uppercase; display: inline-block;
        }
        .status-pending { background: #f39c12; color: white; }
        .status-completed { background: #27ae60; color: white; }
        .status-cancelled { background: #e74c3c; color: white; }

        @media (max-width: 768px) { .order-table { font-size: 0.9rem; } }
    </style>
</head>
<body>

    <header class="site-header">
        <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" class="logo" alt="Logo"></a>
        <a href="index.php?page=home" class="back-btn">Back to Shop</a>
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
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
            <p style="color: #777; font-size: 0.9rem; margin-top: 5px;">(Account ID: <?php echo $buyer_id; ?>)</p>
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
                            <th>Action</th> </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?php echo $order['order_id']; ?></td>
                                <td><?php echo date("d M Y", strtotime($order['order_date'])); ?></td>
                                <td><strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                                <td>
                                    <?php 
                                        $status = ucfirst(strtolower($order['order_status'])); 
                                        $class = 'status-pending';
                                        if($status == 'Completed') $class = 'status-completed';
                                        if($status == 'Cancelled') $class = 'status-cancelled';
                                    ?>
                                    <span class="status-badge <?php echo $class; ?>">
                                        <?php echo htmlspecialchars($status); ?>
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 0.85rem; color: #555;">
                                        <?php echo substr($order['shipping_address'], 0, 20) . '...'; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($status === 'Pending'): ?>
                                        <form action="index.php?page=cancel_order" method="POST" onsubmit="return confirm('Are you sure you want to cancel Order #<?php echo $order['order_id']; ?>?');">
                                            <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
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