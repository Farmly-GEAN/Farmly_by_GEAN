<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css"> 
    <style>
        .cart-container { max-width: 900px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .cart-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .cart-table th, .cart-table td { padding: 15px; border-bottom: 1px solid #ddd; text-align: left; }
        .cart-img { width: 60px; height: 60px; object-fit: cover; border-radius: 5px; }
        .total-section { text-align: right; margin-top: 20px; font-size: 1.2rem; font-weight: bold; }
        .checkout-btn { background: #27ae60; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px; }
        .remove-btn { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; }
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
        <a href="index.php?page=home" class="nav-button">Back to Shop</a>
      </nav>
    </header>

    <div class="cart-container">
        <h2>Shopping Cart</h2>

        <?php if (!empty($items)): ?>
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
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <img src="assets/uploads/products/<?php echo htmlspecialchars(basename($item['product_image'])); ?>" 
                                     class="cart-img" onerror="this.src='assets/images/default.png';">
                                <?php echo htmlspecialchars($item['product_name']); ?>
                            </div>
                        </td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <form action="index.php?page=remove_from_cart" method="POST">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <button type="submit" class="remove-btn">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-section">
                <p>Grand Total: $<?php echo number_format($totalPrice, 2); ?></p>
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