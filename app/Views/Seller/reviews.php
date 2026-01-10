<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Reviews - Seller Dashboard</title>
    <link rel="stylesheet" href="assets/CSS/Seller.css">
    <style>
        /* Reusing your Table Styles */
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #555; text-transform: uppercase; font-size: 0.85rem; }
        
        /* Star Rating */
        .stars { color: #f39c12; letter-spacing: 2px; }
        .comment-text { color: #555; font-style: italic; }
        .product-name { font-weight: bold; color: #27ae60; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

    <main class="main-content">
        <h2>⭐ Customer Feedback</h2>

        <div class="table-container">
            <?php if (!empty($reviews)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Product</th>
                            <th>Buyer</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reviews as $r): ?>
                        <tr>
                            <td class="stars">
                                <?php echo str_repeat("★", $r['Rating']) . str_repeat("☆", 5 - $r['Rating']); ?>
                            </td>
                            <td>
                                <div class="comment-text">"<?php echo htmlspecialchars($r['Comment']); ?>"</div>
                            </td>
                            <td>
                                <span class="product-name"><?php echo htmlspecialchars($r['Product_Name']); ?></span>
                            </td>
                            <td><?php echo htmlspecialchars($r['Buyer_Name']); ?></td>
                            <td style="color:#888; font-size:0.85rem;">
                                <?php echo date('M d, Y', strtotime($r['Review_Date'])); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; color: #777;">
                    <h3>No reviews yet.</h3>
                    <p>Deliver great products to get 5-star ratings!</p>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

</body>
</html>