<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css?v=2.2">
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Add New Product</h2>

            <form action="index.php?page=seller_add_product_action" method="POST" enctype="multipart/form-data" class="form">
                
                <div class="select-product">
                    <label>Product Name</label>
                    <input type="text" name="product_name" placeholder="e.g. Organic Carrots" required>

                    <label>Category</label>
                    <select name="category_id" required>
                        <option value="" disabled selected>Select Category</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['Category_ID']; ?>">
                                    <?php echo htmlspecialchars($cat['Category_Name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No categories found</option>
                        <?php endif; ?>
                    </select>

                    <label>Price (per kg/unit)</label>
                    <input type="number" name="price" step="0.01" placeholder="0.00" required>

                    <label>Stock Quantity</label>
                    <input type="number" name="stock" placeholder="Available Qty" required>

                    <label>Description</label>
                    <textarea name="description" rows="5" placeholder="Describe your product freshness, source, etc."></textarea>
                </div>

                <div class="upload-image">
                    <label>Main Product Image</label>
                    <div class="upload-box" onclick="document.getElementById('mainImage').click()">
                        <p>Click to Upload Main Image</p>
                        <input type="file" name="product_image" id="mainImage" hidden required>
                    </div>

                    <label style="margin-top: 20px;">Gallery Images (Optional)</label>
                    <div class="upload-box" style="border-style: dotted;" onclick="document.getElementById('galleryImages').click()">
                        <p>Click to Upload Multiple Images</p>
                        <input type="file" name="gallery_images[]" id="galleryImages" multiple hidden>
                    </div>

                    <button type="submit" class="add-btn">Publish Product</button>
                </div>

            </form>
        </main>
    </div>
</div>

</body>
</html>