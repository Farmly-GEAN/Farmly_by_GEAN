<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Products - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Add New Product</h2>
            
            <?php if(isset($_GET['success'])): ?>
                <p style="color:green; font-weight:bold;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php elseif(isset($_GET['error'])): ?>
                <p style="color:red; font-weight:bold;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <div class="toggle">
                <label><input type="radio" name="mode" checked> Add Product</label>
                <label><input type="radio" name="mode" onclick="location.href='index.php?page=seller_existing_product'"> Existing</label>
            </div>

            <form class="form" method="POST" action="index.php?page=seller_add_product" enctype="multipart/form-data">
                <div class="select-product">
                    <label>Category</label>
                    <select name="category_id" required>
                        <option value="" disabled selected hidden>Select Category</option>
                        <?php if(!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>"><?php echo htmlspecialchars($cat['category_name']); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <label>Product Name</label>
                    <input type="text" name="product_name" required>

                    <label>Stock (kg)</label>
                    <input type="number" name="stock" required>

                    <label>Price</label>
                    <input type="number" name="price" step="0.01" required>
                </div>

                <div class="upload-image">
                    <label>Main Product Image (Cover)</label>
                    <div class="upload-box">
                        <input type="file" name="product_image" required accept="image/*">
                    </div>

                    <label style="margin-top: 20px; display: block;">Additional Images (Gallery)</label>
                    <div class="upload-box" style="border-style: dotted; background-color: #fafafa;">
                        <input type="file" name="gallery_images[]" multiple accept="image/*">
                        <p style="font-size: 12px; color: #666; margin-top: 5px; text-align: center;">
                            Hold <strong>Ctrl</strong> (or Cmd) to select multiple files.
                        </p>
                    </div>

                    <button type="submit" class="add-btn">Add Product</button>
                </div>
            </form>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>