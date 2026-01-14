<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Orders - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        body { background-color: #f2f2f2; font-family: 'Segoe UI', sans-serif; }
        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .page-title { font-size: 1.8rem; color: #333; }
        .filter-select { padding: 8px; border-radius: 5px; border: 1px solid #ccc; background: white; cursor: pointer; }

        /* ORDER CARD */
        .order-card { background: white; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 20px; overflow: hidden; }
        .card-header { background: #f0f2f2; padding: 15px 20px; display: flex; justify-content: space-between; color: #555; font-size: 0.9rem; border-bottom: 1px solid #ddd; }
        .header-col { display: flex; flex-direction: column; }
        .label { font-size: 0.75rem; text-transform: uppercase; margin-bottom: 3px; }
        .value { color: #333; font-weight: bold; }
        
        .card-body { padding: 20px; }
        .order-status { font-size: 1.2rem; font-weight: bold; margin-bottom: 15px; }
        .status-Delivered { color: #27ae60; }
        .status-Pending { color: #e67e22; }
        .status-Cancelled { color: #c0392b; }

        /* Product Rows */
        .product-row { display: flex; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .product-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        
        .p-img { width: 90px; height: 90px; object-fit: cover; border-radius: 5px; border: 1px solid #eee; }
        .p-details { flex: 1; }
        .p-name { font-size: 1.1rem; font-weight: bold; color: #007185; text-decoration: none; margin-bottom: 5px; display: block; }
        .p-name:hover { color: #c7511f; text-decoration: underline; }
        .p-meta { font-size: 0.9rem; color: #555; line-height: 1.5; }
        
        /* Actions */
        .p-actions { display: flex; flex-direction: column; gap: 8px; min-width: 180px; }
        .btn-action { text-align: center; text-decoration: none; padding: 8px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; border: 1px solid; transition: 0.2s; }
        
        /* Review Button Logic */
        .btn-review { background: white; border-color: #d5d9d9; color: #333; }
        .btn-review:hover { background: #f7fafa; }
        
        .btn-review-disabled { 
            background: #eee; border-color: #ccc; color: #999; cursor: not-allowed; pointer-events: none; 
        }

        .btn-view { background: #ffd814; border-color: #fcd200; color: #111; border: none; }
        .btn-view:hover { background: #f7ca00; }
        
        .btn-receipt { font-size: 0.85rem; color: #007185; text-decoration: none; margin-top: 5px; text-align: right; }
        .btn-receipt:hover { text-decoration: underline; color: #c7511f; }
        
        @media (max-width: 768px) { .card-header { flex-direction: column; gap: 10px; } .product-row { flex-direction: column; } .p-actions { width: 100%; flex-direction: row; } }
    </style>
</head>
<body>

    <header style="background: white; padding: 10px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" height="50"></a>
        <div>
            <a href="index.php?page=profile" style="text-decoration:none; color:#333; font-weight:bold; margin-right:20px;">My Profile</a>
            <a href="index.php?page=home" style="text-decoration:none; color:#333; font-weight:bold;">Shop</a>
        </div>
    </header>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Your Orders</h1>
            
            <form action="index.php" method="GET">
                <input type="hidden" name="page" value="my_orders">
                <label><strong>Filter:</strong></label>
                <select name="filter" class="filter-select" onchange="this.form.submit()">
                    <option value="all" <?php echo (!isset($_GET['filter']) || $_GET['filter'] == 'all') ? 'selected' : ''; ?>>All Orders</option>
                    <option value="last-30" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'last-30') ? 'selected' : ''; ?>>Last 30 Days</option>
                    <option value="year-2026" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'year-2026') ? 'selected' : ''; ?>>2026</option>
                </select>
            </form>
        </div>

        <?php if (!empty($orders)): ?>
            <?php foreach ($orders as $order): ?>
                <?php 
                    $o_id = $order['Order_ID'] ?? $order['order_id'];
                    $o_status = $order['Order_Status'] ?? $order['order_status'] ?? $order['Status'] ?? 'Pending';
                    $o_date = date("F j, Y", strtotime($order['Order_Date'] ?? $order['order_date']));
                    $o_total = number_format($order['Total_Amount'] ?? $order['total_amount'], 2);
                    
                    $is_delivered = (stripos($o_status, 'Deliver') !== false);
                ?>
                
                <div class="order-card">
                    <div class="card-header">
                        <div style="display: flex; gap: 40px;">
                            <div class="header-col">
                                <span class="label">ORDER PLACED</span>
                                <span class="value"><?php echo $o_date; ?></span>
                            </div>
                            <div class="header-col">
                                <span class="label">TOTAL</span>
                                <span class="value">$<?php echo $o_total; ?></span>
                            </div>
                            <div class="header-col">
                                <span class="label">SHIP TO</span>
                                <span class="value link" style="color:#007185; cursor:pointer;">
                                    <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Customer'); ?>
                                </span>
                            </div>
                        </div>
                        <div class="header-col" style="text-align: right;">
                            <span class="label">ORDER # <?php echo $o_id; ?></span>
                            <a href="index.php?page=view_order&id=<?php echo $o_id; ?>" class="btn-receipt">View Receipt</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="order-status status-<?php echo $o_status; ?>">
                            <?php echo htmlspecialchars($o_status); ?>
                        </div>

                        <?php if(isset($order['items']) && is_array($order['items'])): ?>
                            <?php foreach ($order['items'] as $item): ?>
                                <?php
                                    $p_id = $item['Product_ID'] ?? $item['product_id'];
                                    $p_name = $item['Product_Name'] ?? $item['product_name'] ?? 'Item';
                                    $p_img = $item['Product_Image'] ?? $item['product_image'] ?? 'assets/images/default.png';
                                    $seller_name = $item['Seller_Name'] ?? $item['seller_name'] ?? 'Farmly Seller';
                                    $price = $item['Price_Per_Unit'] ?? $item['price_per_unit'] ?? $item['Price'] ?? 0;
                                ?>
                                <div class="product-row">
                                    <a href="index.php?page=product_detail&id=<?php echo $p_id; ?>">
                                        <img src="<?php echo htmlspecialchars($p_img); ?>" class="p-img" onerror="this.src='assets/images/default.png';">
                                    </a>
                                    <div class="p-details">
                                        <a href="index.php?page=product_detail&id=<?php echo $p_id; ?>" class="p-name">
                                            <?php echo htmlspecialchars($p_name); ?>
                                        </a>
                                        <div class="p-meta">
                                            Sold by: <strong><?php echo htmlspecialchars($seller_name); ?></strong> <br>
                                            Price: $<?php echo number_format($price, 2); ?>
                                        </div>
                                    </div>
                                    <div class="p-actions">
                                        <?php if ($is_delivered): ?>
                                            <a href="index.php?page=product_detail&id=<?php echo $p_id; ?>#review-section" class="btn-action btn-review">
                                                Write a product review
                                            </a>
                                        <?php else: ?>
                                            <span class="btn-action btn-review-disabled">
                                                Delivered to Review
                                            </span>
                                        <?php endif; ?>
                                        
                                        <a href="index.php?page=product_detail&id=<?php echo $p_id; ?>" class="btn-action btn-view">
                                            Buy it again
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="padding:20px; text-align:center;">No orders found.</p>
        <?php endif; ?>
    </div>

    <?php include __DIR__ . '/Buyer_Footer.php'; ?>
</body>
</html>