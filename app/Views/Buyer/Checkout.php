<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout</title>
  
  <style>
    
    body {
        background-color: #f9f9f9;
        font-family: 'Segoe UI', sans-serif;
        color: #333;
        margin: 0;
    }

    .site-header {
        background: white;
        padding: 15px 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        position: relative;
        height: auto;
        min-height: 80px;
    }

    .logo img { 
        height: 90px;
        width: auto;
    }
    
    
    .header-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        text-transform: uppercase;
    }

    .back-link {
        color: #27ae60; 
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        border: 1px solid #27ae60;
        padding: 8px 15px;
        border-radius: 5px;
        transition: 0.3s;
    }
    .back-link:hover {
        background-color: #27ae60;
        color: white;
    }

    .checkout-container {
        max-width: 1000px;
        margin: 40px auto;
        background: white;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: grid;
        grid-template-columns: 1fr 1fr; 
        gap: 60px;
    }
    .section-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .delivery-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    
    .delivery-btn {
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        font-size: 1.1rem;
        font-weight: 600;
        color: #555;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .delivery-btn:hover {
        border-color: #27ae60;
        color: #27ae60;
        background-color: #f9fffb;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    
    .delivery-btn::after {
        content: '➔';
        font-size: 1.2rem;
        opacity: 0;
        transition: 0.3s;
    }
    .delivery-btn:hover::after {
        opacity: 1;
        transform: translateX(5px);
    }

    
    .summary-box {
        background-color: #fafafa;
        padding: 25px;
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .summary-list {
        max-height: 400px;
        overflow-y: auto;
        margin-bottom: 20px;
    }

    .summary-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #eee;
        align-items: center;
    }

    .summary-img {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        object-fit: cover;
        border: 1px solid #ddd;
    }

    .summary-details h4 {
        margin: 0;
        font-size: 0.95rem;
        color: #333;
    }

    .summary-details p {
        margin: 3px 0 0;
        font-size: 0.85rem;
        color: #777;
    }

    
    .totals-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
        color: #555;
    }

    .final-total {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #ddd;
        font-size: 1.2rem;
        font-weight: bold;
        color: #2c3e50;
    }
    @media (max-width: 768px) {
        .checkout-container { grid-template-columns: 1fr; gap: 40px; }
        .site-header { flex-direction: column; height: auto; padding: 15px; gap: 15px; }
        .header-center { position: static; transform: none; }
    }
  </style>
</head>
<body>

  <header class="site-header">
    <div class="logo">
      <a href="index.php?page=home">
         <img src="assets/images/Logo/Team Logo.png" alt="Logo">
      </a>
    </div>

    <div class="header-center">
      Checkout
    </div>

    <div class="header-right">
      <a href="index.php?page=home" class="back-link">Shop</a>
    </div>
  </header>

  <div class="checkout-container">
    
    <div class="delivery-section">
      <h3 class="section-title">Select Delivery Method</h3>
      
      <form action="index.php?page=order_details" method="POST" class="delivery-form">
        
        <button type="submit" name="delivery_method" value="Home Delivery" class="delivery-btn">
          <span>Home Delivery</span>
        </button>

        <button type="submit" name="delivery_method" value="Pickup" class="delivery-btn">
          <span>Pickup</span>
        </button>

      </form>
    </div>


    <div class="summary-section">
      <h3 class="section-title">Order Summary</h3>
      
      <div class="summary-box">
          <div class="summary-list">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                    <?php 
                       
                        $p_name = $item['Product_Name'] ?? $item['product_name'] ?? 'Item';
                        
                        
                        $raw_img = $item['Product_Image'] ?? $item['product_image'] ?? 'default.png';
                       
                        if (strpos($raw_img, 'assets/') === false) {
                            $p_img = "assets/uploads/products/" . basename($raw_img);
                        } else {
                            $p_img = $raw_img;
                        }

                        $price = $item['Price'] ?? $item['price'] ?? 0;
                        $qty = $item['Quantity'] ?? $item['quantity'] ?? 1;
                        $line_total = $price * $qty;
                    ?>
                    <div class="summary-item">
                        <img src="<?php echo htmlspecialchars($p_img); ?>" 
                             class="summary-img" 
                             onerror="this.src='assets/images/default.png';">
                        
                        <div class="summary-details">
                            <h4><?php echo htmlspecialchars($p_name); ?></h4>
                            <p>Qty: <?php echo $qty; ?> x $<?php echo number_format($price, 2); ?></p>
                        </div>
                        
                        <div style="margin-left: auto; font-weight: 600;">
                            $<?php echo number_format($line_total, 2); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="padding: 10px; color: #777;">Your cart is empty.</p>
            <?php endif; ?>
          </div>

          <div class="totals-row">
            <span>Sub-Total:</span>
            <span>$<?php echo number_format($totalPrice, 2); ?></span>
          </div>
          
          <div class="totals-row">
            <span>Shipping:</span>
            <span>Calculated Next Step</span>
          </div>

          <div class="final-total">
            <span>Total:</span>
            <span>$<?php echo number_format($totalPrice, 2); ?> + Ship</span>
          </div>
      </div>
    </div>

  </div>

</body>
</html>