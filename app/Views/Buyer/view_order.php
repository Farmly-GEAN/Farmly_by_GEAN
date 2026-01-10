<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Receipt - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Buyer.css">
    <style>
        .receipt-container { max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); font-family: 'Segoe UI', sans-serif; }
        .receipt-header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        
        /* Status Badges */
        .status-badge { padding: 5px 12px; border-radius: 15px; font-weight: bold; font-size: 0.9rem; text-transform: uppercase; }
        .status-Pending { background: #fff3cd; color: #856404; }
        .status-Shipped { background: #d1ecf1; color: #0c5460; }
        .status-Delivered { background: #d4edda; color: #155724; }
        .status-Cancelled { background: #f8d7da; color: #721c24; }
        
        .item-row { display: flex; align-items: center; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid #eee; }
        .item-details { flex-grow: 1; }
        .item-price { font-weight: bold; color: #27ae60; }
        
        .total-section { text-align: right; margin-top: 20px; font-size: 1.2rem; font-weight: bold; }
        .back-link { display: inline-block; margin-top: 30px; text-decoration: none; color: #555; background: #eee; padding: 8px 15px; border-radius: 5px; }
        .back-link:hover { background: #ddd; }
    </style>
</head>
<body>

    <div class="receipt-container">
        
        <?php 
            // SAFETY CHECK: Handle both Upper and Lower case keys from DB
            $o_id     = $order['Order_ID'] ?? $order['order_id'];
            $o_date   = $order['Order_Date'] ?? $order['order_date'];
            $o_status = $order['Order_Status'] ?? $order['order_status'];
            $o_addr   = $order['Shipping_Address'] ?? $order['shipping_address'];
            $o_total  = $order['Total_Amount'] ?? $order['total_amount'];
        ?>

        <div class="receipt-header">
            <div>
                <h2>Order #<?php echo htmlspecialchars($o_id); ?></h2>
                <p style="color:#777;"><?php echo date('F j, Y, g:i a', strtotime($o_date)); ?></p>
            </div>
            <div>
                <span class="status-badge status-<?php echo htmlspecialchars($o_status); ?>">
                    <?php echo htmlspecialchars($o_status); ?>
                </span>
            </div>
        </div>

        <div style="margin-bottom: 30px;">
            <strong>Shipping/Pickup Details:</strong><br>
            <p style="color:#555; margin-top:5px; background: #f9f9f9; padding: 10px; border-radius: 5px;">
                <?php echo htmlspecialchars($o_addr); ?>
            </p>
        </div>

        <h3>Items Ordered</h3>
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <?php 
                    // Handle item keys (Upper/Lower case safety)
                    $p_name = $item['Product_Name'] ?? $item['product_name'] ?? 'Unknown Item';
                    $qty    = $item['Quantity'] ?? $item['quantity'] ?? 0;
                    $price  = $item['Price_Per_Unit'] ?? $item['price_per_unit'] ?? 0;
                ?>
                <div class="item-row">
                    <div class="item-details">
                        <strong><?php echo htmlspecialchars($p_name); ?></strong><br>
                        <small>Qty: <?php echo $qty; ?></small>
                    </div>
                    <div class="item-price">
                        $<?php echo number_format($price * $qty, 2); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No items found for this order.</p>
        <?php endif; ?>

        <div class="total-section">
            Total Paid: $<?php echo number_format($o_total, 2); ?>
        </div>

        <a href="index.php?page=profile" class="back-link">← Back to My Orders</a>
    </div>

</body>
</html>