<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; color: #333; }
        
        .page-container {
            max-width: 800px; margin: 50px auto; background: white; padding: 50px;
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .page-title { text-align: center; color: #27ae60; margin-bottom: 30px; font-size: 2rem; font-weight: bold; }
        
        .content p { line-height: 1.8; font-size: 1.1rem; margin-bottom: 20px; color: #555; }
        
        .mission-box {
            background: #e8f5e9; border-left: 5px solid #27ae60; padding: 20px;
            margin: 30px 0; font-style: italic; color: #2e7d32;
        }

        .back-link {
            display: inline-block; margin-bottom: 20px; color: #27ae60; text-decoration: none; font-weight: 600;
        }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    
    <header style="background: white; padding: 15px 40px; border-bottom: 1px solid #ddd; text-align: center;">
        <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" style="height: 60px;"></a>
    </header>

    <div class="page-container">
        <a href="index.php?page=home" class="back-link">&larr; Back to Shop</a>

        <h1 class="page-title">About Farmly</h1>

        <div class="content">
            <p>Welcome to <strong>Farmly</strong>, your direct connection to fresh, locally sourced produce. We believe that everyone deserves access to healthy, organic food, and that farmers deserve fair prices for their hard work.</p>
            
            <div class="mission-box">
                "To bridge the gap between local farmers and community buyers, eliminating the middleman to ensure freshness and transparency."
            </div>
            
            <p><strong>Why Choose Us?</strong></p>
            <ul style="color: #555; line-height: 1.8; margin-bottom: 20px; margin-left: 20px;">
                <li>🌱 <strong>100% Organic & Fresh:</strong> Produce harvested often the same day it is delivered.</li>
                <li>🚜 <strong>Support Local:</strong> Your money goes directly to the farmers in your community.</li>
                <li>🚚 <strong>Convenience:</strong> Easy home delivery or pickup options to suit your schedule.</li>
            </ul>

            <p>Founded in 2025, Farmly has helped hundreds of local sellers bring their harvest straight to your table. We are committed to building a sustainable future, one vegetable at a time.</p>
        </div>
    </div>
    
    <?php include __DIR__ . '/../Buyer/Buyer_Footer.php'; ?>
</body>
</html>