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
        
        .btn-cart { background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; transition: 0.3s; border: none; cursor: pointer; }
        .btn-cart:hover { background: #219150; }
        .back-link { display: block; margin-bottom: 20px; color: #666; text-decoration: none; }

        /* --- REVIEW SECTION STYLES --- */
        .reviews-container { max-width: 1000px; margin: 30px auto; }
        .review-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-bottom: 1px solid #eee; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .star-rating { color: #f39c12; letter-spacing: 2px; }
        .reviewer-name { font-weight: bold; color: #333; margin-right: 10px; }
        .review-date { font-size: 0.85rem; color: #888; }
        .review-comment { margin-top: 10px; color: #555; line-height: 1.5; }

        /* Review Form */
        .review-form { background: white; padding: 25px; border-radius: 10px; margin-top: 20px; border: 1px solid #ddd; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #555; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: inherit; }
        .btn-submit-review { background: #34495e; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-submit-review:hover { background: #2c3e50; }
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

            <form action="index.php?page=add_to_cart" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn-cart">Add to Cart</button>
            </form>
        </div>
    </div>

    <div class="reviews-container">
        <h2 style="border-bottom: 2px solid #27ae60; padding-bottom: 10px; display: inline-block; margin-bottom: 20px;">Customer Reviews</h2>

        <div class="review-list">
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card">
                        <div>
                            <?php 
                                $r_rating = $review['Rating'] ?? $review['rating'];
                                $r_name = $review['Buyer_Name'] ?? $review['buyer_name'] ?? 'Anonymous';
                                $r_date = $review['Review_Date'] ?? $review['review_date'];
                                $r_comment = $review['Comment'] ?? $review['comment'];
                            ?>
                            <span class="star-rating"><?php echo str_repeat("★", $r_rating) . str_repeat("☆", 5 - $r_rating); ?></span>
                            <span class="reviewer-name"><?php echo htmlspecialchars($r_name); ?></span>
                            <span class="review-date"><?php echo date('M d, Y', strtotime($r_date)); ?></span>
                        </div>
                        <div class="review-comment">
                            <?php echo htmlspecialchars($r_comment); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #777; font-style: italic; background:white; padding:20px; border-radius:8px;">No reviews yet. Be the first to review this product!</p>
            <?php endif; ?>
        </div>

        <div class="review-form">
            <h3>Write a Review</h3>
            <form action="index.php?page=submit_review" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                
                <div class="form-group">
                    <label>Rating</label>
                    <select name="rating" class="form-control" style="width: 150px;" required>
                        <option value="5">★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4 Stars)</option>
                        <option value="3">★★★☆☆ (3 Stars)</option>
                        <option value="2">★★☆☆☆ (2 Stars)</option>
                        <option value="1">★☆☆☆☆ (1 Star)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Your Comment</label>
                    <textarea name="comment" class="form-control" rows="4" placeholder="How was the product?" required></textarea>
                </div>

                <button type="submit" class="btn-submit-review">Submit Review</button>
            </form>
        </div>
    </div>

    <script>
        function changeImage(element) {
            var newSrc = element.src;
            var mainImg = document.getElementById("currentImage");
            mainImg.src = newSrc;
            document.querySelectorAll(".thumb").forEach(t => t.classList.remove("active"));
            element.classList.add("active");
        }
    </script>

</body>
</html>