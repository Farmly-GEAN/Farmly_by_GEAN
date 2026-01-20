<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css"> 
    <style>
        .cart-container { max-width: 900px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .cart-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .cart-table th, .cart-table td { padding: 15px; border-bottom: 1px solid #ddd; text-align: left; }
        .cart-img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
        .total-section { text-align: right; margin-top: 20px; font-size: 1.2rem; font-weight: bold; }
        .checkout-btn { background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; }
        .remove-btn { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }

        /* NEW STYLES FOR QTY BUTTONS */
        .qty-btn {
            width: 25px; height: 25px; border-radius: 50%; border: none; 
            cursor: pointer; font-weight: bold; display: inline-flex; 
            align-items: center; justify-content: center;
        }
        .btn-minus { background-color: #ddd; color: #333; }
        .btn-plus { background-color: #27ae60; color: white; }
        .qty-display { font-weight: bold; margin: 0 10px; min-width: 20px; text-align: center; display: inline-block; }
    </style>
</head>
<body>
    <header class="site-header">
      <div class="logo">
        <a href="index.php?page=home">
          <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo" />
        </a>
      </div>
      <nav class="user-nav">
        <a href="index.php?page=home" class="nav-button">Shop</a>
      </nav>
    </header>

    <div class="cart-container">
        <h2>Shopping Cart</h2>

        <?php if (!empty($cartItems)): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        
                    <?php 
                        $name = $item['product_name'] ?? $item['Product_Name'];
                        $price = $item['price'] ?? $item['Price'];
                        $qty = $item['quantity'] ?? $item['Quantity'];
                        $img = $item['product_image'] ?? $item['Product_Image'];
                        $cart_id = $item['cart_id'] ?? $item['Cart_ID'];
                    ?>

                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="assets/uploads/products/<?php echo htmlspecialchars(basename($img)); ?>" 
                                     class="cart-img" onerror="this.src='assets/images/default.png';">
                                <?php echo htmlspecialchars($name); ?>
                            </div>
                        </td>
                        <td>$<?php echo number_format($price, 2); ?></td>
                        
                        <td>
                            <div style="display: flex; align-items: center;">
                                <form action="index.php?page=update_cart" method="POST" style="margin:0;">
                                    <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                    <input type="hidden" name="current_qty" value="<?php echo $qty; ?>">
                                    <input type="hidden" name="action" value="decrease">
                                    <button type="submit" class="qty-btn btn-minus">-</button>
                                </form>

                                <span class="qty-display"><?php echo $qty; ?></span>

                                <form action="index.php?page=update_cart" method="POST" style="margin:0;">
                                    <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                    <input type="hidden" name="current_qty" value="<?php echo $qty; ?>">
                                    <input type="hidden" name="action" value="increase">
                                    <button type="submit" class="qty-btn btn-plus">+</button>
                                </form>
                            </div>
                        </td>

                        <td>$<?php echo number_format($price * $qty, 2); ?></td>
                        <td>
                            <form action="index.php?page=remove_from_cart" method="POST">
                                <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                <button type="submit" class="remove-btn">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-section">
                <p>Grand Total: $<?php echo number_format($grandTotal, 2); ?></p>
                <a href="index.php?page=checkout" class="checkout-btn">Proceed to Checkout</a>
            </div>

        <?php else: ?>
            <div style="text-align: center; padding: 40px;">
                <h3>Your cart is empty!</h3>
                <a href="index.php?page=home" style="color: green; text-decoration: underline;">Go add some products</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>