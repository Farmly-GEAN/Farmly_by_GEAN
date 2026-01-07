<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - Farmly</title>
  
  <style>
    /* --- INTERNAL CSS (Matches your Sketch) --- */
    
    /* 1. Base Fonts & Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
    body { background-color: #ffffff; color: #333; min-height: 100vh; display: flex; flex-direction: column; }

    /* 2. Header Design */
    .site-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 40px;
        border-bottom: 2px solid #333; /* Thick border like sketch */
        position: relative;
    }

    /* Left side: Logo + Back Button */
    .header-left {
        display: flex;
        align-items: center;
        gap: 20px;
        z-index: 2; /* Ensures clickable */
    }

    .logo img { height: 50px; width: auto; }

    .back-btn {
        text-decoration: none;
        color: #333;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    .back-btn:hover { text-decoration: underline; }

    /* Center Text (Absolute centered) */
    .header-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        font-size: 1.5rem;
        font-weight: 300; /* Thin font like sketch */
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    /* 3. Main Layout */
    .checkout-container {
        display: grid;
        grid-template-columns: 1fr 1fr; /* 50% Left, 50% Right */
        gap: 50px;
        max-width: 1000px;
        margin: 60px auto;
        padding: 0 20px;
        width: 100%;
    }

    /* 4. Left Side: Delivery Buttons */
    .delivery-section {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .section-label {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 30px;
        font-family: 'Courier New', monospace; /* Typewriter style like sketch */
    }

    .delivery-form {
        display: flex;
        flex-direction: column;
        gap: 30px;
        width: 80%;
    }

    /* The Pill Buttons */
    .pill-btn {
        background: white;
        border: 2px solid #333;
        border-radius: 50px; /* Fully rounded ends */
        padding: 15px 30px;
        font-size: 1.2rem;
        font-family: 'Comic Sans MS', 'Segoe UI', sans-serif; /* Sketchy font feel */
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        width: 100%;
    }

    .pill-btn:hover {
        background: #333;
        color: white;
        transform: scale(1.02);
    }

    /* 5. Right Side: Order Summary Card */
    .summary-card {
        border: 2px solid #333;
        border-radius: 30px;
        padding: 30px;
        position: relative;
    }

    .summary-title {
        position: absolute;
        top: -12px;
        left: 30px;
        background: white;
        padding: 0 10px;
        font-family: 'Courier New', monospace;
        color: #666;
    }

    .items-list {
        max-height: 350px;
        overflow-y: auto;
        margin-bottom: 20px;
        padding-right: 5px;
    }

    /* The Product "Bubble" */
    .product-bubble {
        border: 2px solid #333;
        border-radius: 20px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .prod-img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }

    .prod-info h4 {
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }

    .prod-qty { color: #2980b9; font-size: 0.85rem; } /* Blue like sketch */
    .prod-price { color: #666; font-size: 0.85rem; }

    /* Totals Footer inside Card */
    .totals-section {
        margin-top: 20px;
        padding-top: 20px;
    }

    .math-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
    }

    .final-total {
        border-top: 2px solid #333;
        margin-top: 15px;
        padding-top: 15px;
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .checkout-container { grid-template-columns: 1fr; }
        .header-center { position: static; transform: none; margin-top: 10px; }
        .site-header { flex-direction: column; }
    }
  </style>
</head>
<body>

  <header class="site-header">
    <div class="header-left">
      <a href="index.php?page=home">
         <img src="assets/images/Logo/Team Logo.png" class="logo" alt="Logo" style="height: 50px;">
      </a>
      <a href="index.php?page=home" class="back-btn">&lt; BACK TO SHOP</a>
    </div>

    <div class="header-center">
      CHECKOUT PAGE
    </div>

    <div style="width: 150px;"></div>
  </header>


  <div class="checkout-container">
    
    <div class="delivery-section">
      <p class="section-label">Delivery Method</p>
      
      <form action="index.php?page=order_details" method="POST" class="delivery-form">
        
        <button type="submit" name="delivery_method" value="Home Delivery" class="pill-btn">
          Home Delivery
        </button>

        <button type="submit" name="delivery_method" value="Pickup" class="pill-btn">
          Pickup
        </button>

      </form>
    </div>


    <div class="summary-card">
      <span class="summary-title">Order Summary:</span>

      <div class="items-list">
        <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                
                <div class="product-bubble">
                    <img src="assets/uploads/products/<?php echo htmlspecialchars(basename($item['product_image'])); ?>" 
                         class="prod-img" 
                         onerror="this.src='assets/images/default.png';">
                    
                    <div class="prod-info">
                        <h4><?php echo htmlspecialchars($item['product_name']); ?></h4>
                        <div class="prod-qty">Quantity: <?php echo $item['quantity']; ?></div>
                        <div class="prod-price">Price per Piece: $<?php echo number_format($item['price'], 2); ?></div>
                    </div>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; padding: 20px;">Cart is empty.</p>
        <?php endif; ?>
      </div>

      <div class="totals-section">
        <div class="math-row">
            <span>Sub-Total:</span>
            <span>$<?php echo number_format($totalPrice, 2); ?></span>
        </div>
        <div class="math-row">
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