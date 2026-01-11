<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    <style>
        .form-container { max-width: 600px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px; font-family: inherit; }
        .form-row { display: flex; gap: 20px; }
        .col-half { flex: 1; }
        .current-img { width: 100px; height: 100px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; margin-top: 5px; }
        label { font-weight: bold; color: #555; }
        .btn-update { width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 1rem; margin-top: 10px; }
        .btn-update:hover { background: #219150; }
    </style>
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>

    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Edit Product</h2>

            <?php
                // Handle ALL keys safely (Upper/Lower case)
                $p_id    = $product['Product_ID'] ?? $product['product_id'];
                $p_name  = $product['Product_Name'] ?? $product['product_name'];
                $p_cat   = $product['Category_Name'] ?? $product['category_name'] ?? '';
                $p_desc  = $product['Description'] ?? $product['description'];
                $p_price = $product['Price'] ?? $product['price'];
                $p_stock = $product['Stocks_Available'] ?? $product['stocks_available'];
                $p_img   = $product['Product_Image'] ?? $product['product_image'];
            ?>

            <div class="form-container">
                <form action="index.php?page=seller_update_product_action" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $p_id; ?>">

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($p_name); ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="col-half">
                            <div class="form-group">
                                <label>Price ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($p_price); ?>" required>
                            </div>
                        </div>
                        <div class="col-half">
                            <div class="form-group">
                                <label>Stock (kg/units)</label>
                                <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($p_stock); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id" class="form-control">
                            <?php foreach ($categories as $cat): ?>
                                <?php 
                                    $c_id   = $cat['Category_ID'] ?? $cat['category_id'];
                                    $c_name = $cat['Category_Name'] ?? $cat['category_name'];
                                    $selected = ($c_name == $p_cat) ? 'selected' : '';
                                ?>
                                <option value="<?php echo $c_id; ?>" <?php echo $selected; ?>>
                                    <?php echo htmlspecialchars($c_name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($p_desc); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Current Image</label><br>
                        <img src="<?php echo htmlspecialchars($p_img); ?>" class="current-img" onerror="this.src='assets/images/default.png';">
                    </div>

                    <div class="form-group">
                        <label>Change Image (Optional)</label>
                        <input type="file" name="product_image" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn-update">Update Product</button>
                </form>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/Seller_Footer.php'; ?>

</body>
</html>