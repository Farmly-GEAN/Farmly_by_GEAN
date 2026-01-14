<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$isSeller = isset($_SESSION['role']) && $_SESSION['role'] === 'seller';
$homeLink  = $isSeller ? 'index.php?page=seller_dashboard' : 'index.php?page=home';
$backLabel = $isSeller ? 'Dashboard' : 'Shop';
$footerFile = $isSeller ? __DIR__ . '/../Seller/Seller_Footer.php' : __DIR__ . '/../Buyer/Buyer_Footer.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Privacy Policy - Farmly</title>
    <!-- <link rel="stylesheet" href="assets/CSS/HomePage.css"> -->
    <style>
        body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; color: #333; }
        
        .page-container {
            max-width: 800px; margin: 50px auto; background: white; padding: 60px;
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .page-title { text-align: center; color: #2c3e50; margin-bottom: 40px; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        
        h3 { color: #27ae60; margin-top: 30px; }
        p { line-height: 1.6; color: #555; margin-bottom: 15px; }

        /* Header Link Style */
        .header-back-link {
            color: #27ae60; text-decoration: none; font-weight: 600; font-size: 1rem;
        }
        .header-back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <header style="background: white; padding: 15px 40px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
        <a href="<?php echo $homeLink; ?>"><img src="assets/images/Logo/Team Logo.png" style="height: 90px;"></a>
        
        <a href="<?php echo $homeLink; ?>" class="header-back-link">&larr; <?php echo $backLabel; ?></a>
    </header>

    <div class="page-container">
        <h1 class="page-title">Privacy Policy</h1>
        
        <p>At Farmly, we value your privacy. This policy explains how we collect, use, and protect your personal information.</p>

        <h3>1. Information We Collect</h3>
        <p>We collect information you provide directly to us, such as your name, email address, phone number, and delivery address when you register or place an order.</p>

        <h3>2. How We Use Your Information</h3>
        <p>We use your data to:</p>
        <ul>
            <li>Process and deliver your orders.</li>
            <li>Communicate with you regarding updates or issues.</li>
            <li>Improve our platform and services.</li>
        </ul>

        <h3>3. Data Sharing</h3>
        <p>We share your delivery details (Name, Address, Phone) with the specific <strong>Seller</strong> fulfilling your order so they can complete the delivery. We do not sell your data to third-party advertisers.</p>

        <h3>4. Security</h3>
        <p>We implement security measures to protect your personal information. However, no internet transmission is completely secure.</p>

        <h3>5. Contact Us</h3>
        <p>If you have questions about this policy, please reach out via our Contact Us page.</p>
    </div>

    <?php include $footerFile; ?>
</body>
</html>