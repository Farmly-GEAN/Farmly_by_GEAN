<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Receipt #<?php echo $order['Order_ID'] ?? $order['order_id']; ?></title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f9f9f9; margin: 0; }
        
        /* Local Header */
        .site-header { background: white; padding: 10px 40px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 40px; }
        .logo img { height: 70px; width: auto; }
        .header-links a { text-decoration: none; color: #333; font-weight: bold; margin-left: 20px; }

        .receipt-container { max-width: 900px; margin: 0 auto 40px; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .receipt-header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        
        .item-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .item-table th { text-align: left; border-bottom: 2px solid #eee; padding: 10px 0; color: #777; }
        .item-table td { padding: 15px 0; border-bottom: 1px solid #eee; vertical-align: middle; }
        
        .status-delivered { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 15px; font-weight: bold; font-size: 0.9rem; }
        
        /* Rate Button */
        .btn-review {
            display: inline-block;
            text-decoration: none;
            background: #f1c40f;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn-review:hover { background: #f39c12; }
    </style>
</head>
<body>

    <header class="site-header">
        <div class="logo">
            <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo"></a>
        </div>
        <div class="header-links">
            <a href="index.php?page=profile">Back to Orders</a>
            <a href="index.php?page=home">Shop</a>
        </div>
    </header>

<?php
    // Safe Key Handling for Order Info
    $o_id     = $order['Order_ID'] ?? $order['order_id'];
    $o_date   = $order['Order_Date'] ?? $order['order_date'];
    $o_status = $order['Status'] ?? $order['status'] ?? $order['Order_Status'] ?? $order['order_status'];
    $o_total  = $order['Total_Amount'] ?? $order['total_amount'];
    $o_addr   = $order['Delivery_Address'] ?? $order['delivery_address'] ?? 'Pickup / As per record';
?>

<div class="receipt-container">
    <div class="receipt-header">
        <div>
            <h2 style="margin:0; color:#2c3e50;">Order #<?php echo $o_id; ?></h2>
            <div style="color: #777; margin-top: 5px;">Placed on <?php echo date("F j, Y", strtotime($o_date)); ?></div>
        </div>
        <div>
            <span class="status-delivered" style="background: <?php echo (stripos($o_status, 'Deliver') !== false) ? '#d4edda' : '#eee'; ?>; color: <?php echo (stripos($o_status, 'Deliver') !== false) ? '#155724' : '#555'; ?>;">
                <?php echo htmlspecialchars($o_status); ?>
            </span>
        </div>
    </div>

    <p><strong>Shipping to:</strong><br><?php echo nl2br(htmlspecialchars($o_addr)); ?></p>

    <table class="item-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th style="text-align: right;">Total</th>
                <?php if(stripos($o_status, 'Deliver') !== false): ?>
                    <th style="text-align: right;">Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item): ?>
                <?php 
                    // Safely Get Product Details
                    $p_name = $item['Product_Name'] ?? $item['product_name'] ?? 'Unknown Item';
                    $p_id   = $item['Product_ID'] ?? $item['product_id'] ?? 0;
                    
                    // CHECK ALL POSSIBLE PRICE KEYS
                    $price  = $item['Price'] ?? $item['price'] ?? $item['Item_Price'] ?? $item['item_price'] ?? 0;
                    
                    $qty    = $item['Quantity'] ?? $item['quantity'] ?? 1;
                ?>
            <tr>
                <td>
                    <strong><?php echo htmlspecialchars($p_name); ?></strong>
                </td>
                <td>$<?php echo number_format($price, 2); ?></td>
                <td>x<?php echo $qty; ?></td>
                <td style="text-align: right;">
                    $<?php echo number_format($price * $qty, 2); ?>
                </td>
                
                <?php if(stripos($o_status, 'Deliver') !== false): ?>
                    <td style="text-align: right;">
                        <a href="index.php?page=product_detail&id=<?php echo $p_id; ?>#review-section" class="btn-review">
                            ★ Rate
                        </a>
                    </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 30px; border-top: 2px solid #333; padding-top: 15px;">
        <span style="font-size: 1.3rem; font-weight: bold;">Grand Total: $<?php echo number_format($o_total, 2); ?></span>
    </div>

    <div style="text-align: center; margin-top: 40px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer;">Print Receipt</button>
    </div>
</div>

</body>
</html>
