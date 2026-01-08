<!DOCTYPE html>
<html lang="en">
<head>
    <title>Incoming Orders - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Incoming Orders</h2>
            
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                
                <div class="order-card">
                    <div class="order-header">
                        <h3>Order #<?php echo $order['order_id']; ?></h3>
                        <span class="badge badge-<?php echo $order['order_status']; ?>">
                            <?php echo $order['order_status']; ?>
                        </span>
                    </div>

                    <div class="order-details">
                        <p><strong>Item:</strong> <?php echo htmlspecialchars($order['product_name']); ?> 
                           <span class="qty-text">(<?php echo $order['quantity']; ?> kg)</span>
                        </p>
                        
                        <p><strong>Buyer:</strong> <?php echo htmlspecialchars($order['buyer_name']); ?> 
                           <span class="buyer-info">| <?php echo htmlspecialchars($order['buyer_phone']); ?></span>
                        </p>
                        
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
                        
                        <?php if(isset($order['price_per_unit'])): ?>
                            <p><strong>Total:</strong> $<?php echo number_format($order['price_per_unit'] * $order['quantity'], 2); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <form method="POST" action="index.php?page=seller_update_order" class="status-form">
                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                        
                        <label>Update Status:</label>
                        <select name="status" class="status-select">
                            <option value="Pending" <?php if($order['order_status']=='Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Shipped" <?php if($order['order_status']=='Shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="Delivered" <?php if($order['order_status']=='Delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="Cancelled" <?php if($order['order_status']=='Cancelled') echo 'selected'; ?>>Cancel</option>
                        </select>
                        
                        <button type="submit" class="btn-update">Update</button>
                    </form>
                </div>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-orders">
                    <p>No orders received yet.</p>
                </div>
            <?php endif; ?>

        </main>
    </div>
</div>
<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>