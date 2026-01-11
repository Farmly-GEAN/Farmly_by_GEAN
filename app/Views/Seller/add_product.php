<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    <style>
        .form-container { max-width: 600px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px; font-family: inherit; }
        .form-row { display: flex; gap: 20px; }
        .col-half { flex: 1; }
        label { font-weight: bold; color: #555; }
        .btn-submit { width: 100%; background: #27ae60; color: white; padding: 12px; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 1rem; margin-top: 10px; }
        .btn-submit:hover { background: #219150; }
    </style>
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>

    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Add New Product</h2>
            
            <?php if(isset($_GET['error'])): ?>
                <p style="color: red; background: #ffeaea; padding: 10px; border-radius: 5px;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <div class="form-container">
                <form action="index.php?page=seller_add_product_action" method="POST" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control" placeholder="e.g. Organic Apples" required>
                    </div>

                    <div class="form-row">
                        <div class="col-half">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <?php 
                                            $id = $cat['Category_ID'] ?? $cat['category_id'];
                                            $name = $cat['Category_Name'] ?? $cat['category_name'];
                                        ?>
                                        <option value="<?php echo $id; ?>">
                                            <?php echo htmlspecialchars($name); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-half">
                            <div class="form-group">
                                <label>Stock (Units/Kg)</label>
                                <input type="number" name="stock" class="form-control" placeholder="e.g. 50" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="e.g. 4.99" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Enter details about your product..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Main Product Image</label>
                        <input type="file" name="product_image" class="form-control" accept="image/*" required>
                    </div>

                    <div class="form-group">
                        <label>Gallery Images (Optional, Multiple)</label>
                        <input type="file" name="gallery_images[]" class="form-control" accept="image/*" multiple>
                    </div>

                    <button type="submit" class="btn-submit">Add Product</button>
                </form>
            </div>
        </main>
    </div>
</div>

<?php include __DIR__ . '/Seller_Footer.php'; ?>

</body>
</html>