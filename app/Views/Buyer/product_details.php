<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; display: flex; gap: 40px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        
        /* LEFT: GALLERY SECTION */
        .gallery-section { flex: 1; }
        .main-image { width: 100%; height: 400px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; margin-bottom: 15px; }
        
        .thumbnail-row { display: flex; gap: 10px; overflow-x: auto; }
        .thumb { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent; opacity: 0.7; transition: 0.3s; }
        .thumb:hover, .thumb.active { border-color: #27ae60; opacity: 1; transform: scale(1.05); }

        /* RIGHT: INFO SECTION */
        .info-section { flex: 1; }
        .category { color: #888; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .title { font-size: 32px; margin: 10px 0; color: #333; }
        .price { font-size: 24px; color: #27ae60; font-weight: bold; margin-bottom: 20px; }
        .description { line-height: 1.6; color: #555; margin-bottom: 30px; }
        
        .btn-cart { background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; transition: 0.3s; }
        .btn-cart:hover { background: #219150; }
        .back-link { display: block; margin-bottom: 20px; color: #666; text-decoration: none; }
    </style>
</head>
<body>

    <a href="index.php?page=home" class="back-link">← Back to Shop</a>

    <div class="container">
        <div class="gallery-section">
            <img id="currentImage" src="<?php echo htmlspecialchars($product['product_image']); ?>" class="main-image">

            <div class="thumbnail-row">
                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" class="thumb active" onclick="changeImage(this)">
                
                <?php if (!empty($gallery)): ?>
                    <?php foreach ($gallery as $imgUrl): ?>
                        <img src="<?php echo htmlspecialchars($imgUrl); ?>" class="thumb" onclick="changeImage(this)">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="info-section">
            <span class="category"><?php echo htmlspecialchars($product['category_name'] ?? 'Fresh'); ?></span>
            <h1 class="title"><?php echo htmlspecialchars($product['product_name']); ?></h1>
            <div class="price">$<?php echo number_format($product['price'], 2); ?> / kg</div>
            
            <p class="description">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </p>
            
            <p style="color: #666; margin-bottom: 20px;">
                Sold by: <strong><?php echo htmlspecialchars($product['seller_name'] ?? 'Farmly Seller'); ?></strong><br>
                Stock: <?php echo $product['stocks_available']; ?> kg available
            </p>

            <a href="index.php?page=add_to_cart&id=<?php echo $product['product_id']; ?>" class="btn-cart">Add to Cart</a>
        </div>
    </div>

    <script>
        function changeImage(element) {
            // Get URL from clicked thumbnail
            var newSrc = element.src;
            var mainImg = document.getElementById("currentImage");
            
            // Swap Source
            mainImg.src = newSrc;

            // Handle Active Class styling
            document.querySelectorAll(".thumb").forEach(t => t.classList.remove("active"));
            element.classList.add("active");
        }
    </script>

</body>
</html>