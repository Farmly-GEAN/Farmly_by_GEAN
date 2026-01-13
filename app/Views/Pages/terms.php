<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Terms and Conditions - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; color: #333; }
        
        .page-container {
            max-width: 800px; margin: 50px auto; background: white; padding: 60px;
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .page-title { text-align: center; color: #2c3e50; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        
        h3 { color: #27ae60; margin-top: 30px; }
        p, li { line-height: 1.6; color: #555; margin-bottom: 15px; }
        ul { margin-left: 20px; }
        
        .back-btn { 
            display: inline-block; margin-bottom: 20px; color: #777; text-decoration: none; font-weight: 600; 
        }
        .back-btn:hover { color: #27ae60; }
    </style>
</head>
<body>

    <header style="background: white; padding: 15px 40px; border-bottom: 1px solid #ddd; text-align: center;">
        <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" style="height: 60px;"></a>
    </header>

    <div class="page-container">
        <a href="index.php?page=home" class="back-btn">&larr; Back to Home</a>
        
        <h1 class="page-title">Terms and Conditions</h1>
        
        <p><strong>Last Updated: January 2026</strong></p>
        <p>Welcome to Farmly! By accessing or using our website, you agree to be bound by these Terms and Conditions.</p>

        <h3>1. Services Provided</h3>
        <p>Farmly is a platform that connects local farmers ("Sellers") with community members ("Buyers"). We facilitate the listing, ordering, and delivery of agricultural products.</p>

        <h3>2. User Responsibilities</h3>
        <ul>
            <li>You must provide accurate information when registering.</li>
            <li>You agree not to use the platform for any illegal activities.</li>
            <li>Buyers are responsible for being available during the scheduled pickup or delivery time.</li>
        </ul>

        <h3>3. Orders and Payments</h3>
        <p>All prices are set by the Seller. Payments can be made online or via Cash on Delivery (if supported). Farmly reserves the right to cancel orders if stock is unavailable.</p>

        <h3>4. Returns and Refunds</h3>
        <p>Due to the perishable nature of the products, returns are generally not accepted unless the item was damaged upon delivery. Please report issues within 24 hours.</p>

        <h3>5. Limitation of Liability</h3>
        <p>Farmly is not liable for the quality of produce, which is the sole responsibility of the Seller.</p>

        <br>
        <p><em>If you have questions regarding these terms, please contact us.</em></p>
    </div>

    <?php include __DIR__ . '/../Buyer/Buyer_Footer.php'; ?>
</body>
</html>