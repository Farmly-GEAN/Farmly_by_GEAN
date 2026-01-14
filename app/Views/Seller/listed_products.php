<!DOCTYPE html>
<html lang="en">
<head>
    <title>Listed Products - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css" />
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <header class="top-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 style="margin: 0;">My Listed Products</h2>
                <a href="index.php?page=seller_dashboard" class="btn-primary" style="text-decoration:none;">+ Add New Product</a>
            </header>

            <?php if(isset($_GET['success'])): ?>
                <p style="color: green; font-weight: bold; margin-bottom: 15px; background: #d4edda; padding: 10px; border-radius: 5px;">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </p>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($p['product_image']); ?>" width="50" height="50" style="border-radius:5px; object-fit: cover;" onerror="this.src='assets/images/default.png';">
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($p['product_name']); ?></strong>
                            </td>
                            <td>$<?php echo number_format($p['price'], 2); ?></td>
                            <td><?php echo $p['stocks_available']; ?> kg</td>
                            <td>
                                <a href="index.php?page=seller_edit_product&id=<?php echo $p['product_id']; ?>" 
                                   class="btn-edit">
                                   Edit
                                </a>

                                <a href="index.php?page=seller_delete_product&id=<?php echo $p['product_id']; ?>" 
                                   class="btn-delete"
                                   onclick="return confirm('Are you sure you want to delete this product?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" style="text-align:center; padding: 30px; color: #777;">No products listed yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>