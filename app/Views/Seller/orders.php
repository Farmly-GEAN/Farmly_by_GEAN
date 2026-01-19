<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Orders - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    <style>
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .filter-form select { padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 1rem; cursor: pointer; background: white; }

        .order-card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-left: 5px solid #27ae60; }
        
        .card-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
        .order-id { font-size: 1.2rem; font-weight: bold; color: #2c3e50; }
        .order-date { color: #888; font-size: 0.9rem; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 15px; }
        .info-group label { display: block; font-size: 0.85rem; font-weight: bold; color: #777; margin-bottom: 5px; text-transform: uppercase; }
        .info-group p { margin: 0; color: #333; font-weight: 500; }
        
        .logistics-box { background: #e8f6f3; padding: 15px; border-radius: 5px; margin-top: 15px; border: 1px solid #d1f2eb; }
        .logistics-title { font-weight: bold; color: #16a085; display: block; margin-bottom: 5px; }
        .logistics-time { font-size: 1.1rem; color: #2c3e50; font-weight: bold; }

        .item-box { background: #f9f9f9; padding: 10px; border-radius: 5px; margin: 15px 0; border: 1px solid #eee; }
        .highlight { color: #27ae60; font-weight: bold; }

        .status-form { margin-top: 15px; display: flex; gap: 10px; align-items: center; background: #f1f1f1; padding: 10px; border-radius: 5px; }
        .status-select { padding: 8px; border-radius: 4px; border: 1px solid #ccc; flex: 1; }
        .btn-update { background: #27ae60; color: white; border: none; padding: 8px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-update:hover { background: #219150; }
    </style>
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            
            <div class="page-header">
                <h2>Incoming Orders</h2>
                
                <form action="index.php" method="GET" class="filter-form">
                    <input type="hidden" name="page" value="orders"> <select name="filter" onchange="this.form.submit()">
                        <option value="all" <?php echo (!isset($_GET['filter']) || $_GET['filter'] == 'all') ? 'selected' : ''; ?>>All Orders</option>
                        <option value="pending" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'pending') ? 'selected' : ''; ?>>Pending (To Pack)</option>
                        <option value="shipped" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                        <option value="delivered" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'delivered') ? 'selected' : ''; ?>>Delivered (Completed)</option>
                        <option value="cancelled" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                        <option value="last-30" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'last-30') ? 'selected' : ''; ?>>Last 30 Days</option>
                    </select>
                </form>
            </div>

            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <?php 
                        $o_id     = $order['Order_ID'] ?? $order['order_id'];
                        $o_date   = $order['Order_Date'] ?? $order['order_date'];
                        $o_status = $order['Status'] ?? $order['status'] ?? 'Pending';
                        
                        $b_name   = $order['Buyer_Name'] ?? $order['buyer_name'] ?? 'Guest';
                        $b_phone  = $order['Buyer_Phone'] ?? $order['buyer_phone'] ?? 'N/A';
                        $ship_addr = $order['Shipping_Address'] ?? $order['shipping_address'] ?? 'Pickup';
                        
                        $p_name   = $order['Product_Name'] ?? $order['product_name'] ?? 'Unknown Item';
                        $qty      = $order['Quantity'] ?? $order['quantity'] ?? 1;

                        $is_pickup = (stripos($ship_addr, 'Pickup') !== false);
                        if ($is_pickup) {
                            $logistics_type = "Customer Pickup";
                            $pickup_time = date("l, M d - 10:00 AM", strtotime($o_date . ' +1 day'));
                            $logistics_note = "Customer will arrive at farm location.";
                        } else {
                            $logistics_type = "Courier Pickup";
                            $pickup_time = date("l, M d - 05:00 PM", strtotime($o_date));
                            $logistics_note = "Have package ready for 3rd party courier.";
                        }
                    ?>
                    
                    <div class="order-card">
                        <div class="card-header">
                            <span class="order-id">Order #<?php echo $o_id; ?></span>
                            <span class="order-date">Placed: <?php echo date("F j, Y", strtotime($o_date)); ?></span>
                        </div>

                        <div class="item-box">
                            <strong>Item to Pack:</strong> 
                            <span class="highlight"><?php echo htmlspecialchars($p_name); ?></span> 
                            (Qty: <?php echo $qty; ?>)
                        </div>

                        <div class="logistics-box">
                            <span class="logistics-title"><?php echo $logistics_type; ?></span>
                            <div class="logistics-time">📅 <?php echo $pickup_time; ?></div>
                            <small style="color:#666;"><?php echo $logistics_note; ?></small>
                        </div>

                        <div class="info-grid">
                            <div class="info-group">
                                <label>Customer Contact</label>
                                <p><?php echo htmlspecialchars($b_name); ?></p>
                                <p style="color: #27ae60; font-weight:bold;"><?php echo htmlspecialchars($b_phone); ?></p>
                            </div>
                            <div class="info-group">
                                <label>Shipping Address</label>
                                <p><?php echo nl2br(htmlspecialchars($ship_addr)); ?></p>
                            </div>
                        </div>

                        <form action="index.php?page=seller_update_order" method="POST" class="status-form">
                            <input type="hidden" name="order_id" value="<?php echo $o_id; ?>">
                            
                            <strong>Update Status:</strong>
                            <select name="status" class="status-select">
                                <option value="Pending" <?php echo (stripos($o_status, 'Pending') !== false) ? 'selected' : ''; ?>>Pending</option>
                                <option value="Shipped" <?php echo (stripos($o_status, 'Ship') !== false) ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo (stripos($o_status, 'Deliver') !== false) ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo (stripos($o_status, 'Cancel') !== false) ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn-update">Update</button>
                        </form>
                    </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align:center; padding: 40px; color:#777; background:white; border-radius:8px;">
                    <h3>No orders found.</h3>
                    <p>No orders matched your selected filter.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>