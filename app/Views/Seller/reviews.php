<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Reviews - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    <link rel="stylesheet" href="assets/CSS/Seller_Existingproduct.css" />
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    <div class="content">
        <?php include 'Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Customer Reviews</h2>
            <ul>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $r): ?>
                    <li style="background:white; padding:15px; margin-bottom:10px; border-bottom:1px solid #eee;">
                        <strong><?php echo htmlspecialchars($r['buyer_name']); ?></strong> on 
                        <em><?php echo htmlspecialchars($r['product_name']); ?></em>:
                        <p>"<?php echo htmlspecialchars($r['comment']); ?>"</p>
                    </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No reviews yet.</p>
                <?php endif; ?>
            </ul>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>