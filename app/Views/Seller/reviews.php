<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Reviews - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    <style>
        .review-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #ddd; }
        
        .card-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .product-name { font-size: 1.1rem; font-weight: bold; color: #2c3e50; }
        .date { color: #888; font-size: 0.9rem; }
        
        .stars { color: #f1c40f; letter-spacing: 2px; margin-bottom: 10px; }
        .comment { color: #555; line-height: 1.5; font-style: italic; }
        .buyer { font-weight: bold; color: #27ae60; margin-top: 10px; display: block; font-size: 0.9rem; }
        
       
        .rating-5 { border-left-color: #27ae60; } 
        .rating-4 { border-left-color: #aadd28; }
        .rating-3 { border-left-color: #f1c40f; } 
        .rating-2 { border-left-color: #e67e22; }
        .rating-1 { border-left-color: #c0392b; } 
    </style>
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Customer Reviews</h2>

            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <?php 
                        
                        $rating = $review['Rating'] ?? $review['rating'] ?? 5;
                        
                        
                        $r_text = $review['Comment'] 
                               ?? $review['comment'] 
                               ?? $review['Review_Text'] 
                               ?? $review['review_text'] 
                               ?? $review['Review_text']
                               ?? '';

                        $p_name = $review['Product_Name'] ?? $review['product_name'] ?? 'Unknown Product';
                        $r_date = $review['Review_Date'] ?? $review['review_date'] ?? date('Y-m-d');
                        $b_name = $review['Buyer_Name'] ?? $review['buyer_name'] ?? 'Anonymous';

                        $stars = str_repeat("★", $rating) . str_repeat("☆", 5 - $rating);
                    ?>
                    <div class="review-card rating-<?php echo $rating; ?>">
                        <div class="card-header">
                            <span class="product-name"><?php echo htmlspecialchars($p_name); ?></span>
                            <span class="date"><?php echo date("M d, Y", strtotime($r_date)); ?></span>
                        </div>
                        
                        <div class="stars"><?php echo $stars; ?></div>
                        
                        <div class="comment">
                            "<?php echo htmlspecialchars($r_text); ?>"
                        </div>
                        
                        <span class="buyer">- by <?php echo htmlspecialchars($b_name); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #777;">
                    <h3>No reviews yet.</h3>
                    <p>Once customers rate your products, their feedback will appear here.</p>
                </div>
            <?php endif; ?>

        </main>
    </div>
</div>

<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>