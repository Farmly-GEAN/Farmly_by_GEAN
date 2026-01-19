<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$headerInclude = null;
$footerInclude = __DIR__ . '/../Buyer/Buyer_Footer.php';

if (isset($_SESSION['seller_id']) || (isset($_SESSION['role']) && $_SESSION['role'] === 'seller')) {
    $headerInclude = __DIR__ . '/../Seller/Seller_Header.php';
    $footerInclude = __DIR__ . '/../Seller/Seller_Footer.php';
} 
elseif (isset($_SESSION['user_id'])) {
    $headerInclude = __DIR__ . '/../Buyer/Buyer_Header.php';
    $footerInclude = __DIR__ . '/../Buyer/Buyer_Footer.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; margin: 0; }
        .contact-wrapper { max-width: 800px; margin: 50px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h1 { text-align: center; color: #333; margin-bottom: 10px; }
        p.subtitle { text-align: center; color: #666; margin-bottom: 30px; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 8px; color: #444; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; }
        
        .btn-send { width: 100%; background: #27ae60; color: white; padding: 12px; font-size: 1.1rem; border: none; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .btn-send:hover { background: #219150; }

        .msg-success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .msg-error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }

        .simple-header { background: white; padding: 15px 40px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; }
        .home-link { color: #27ae60; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

    <?php if($headerInclude && file_exists($headerInclude)): ?>
        <?php include $headerInclude; ?>
    <?php else: ?>
        <div class="simple-header">
            <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" style="height: 60px;"></a>
            <a href="index.php?page=home" class="home-link">Back to Home</a>
        </div>
    <?php endif; ?>

    <div class="contact-wrapper">
        <h1>Contact Us</h1>
        <p class="subtitle">Have questions? Send us a message and we'll get back to you.</p>

        <?php if(isset($_GET['success'])): ?>
            <div class="msg-success">Message sent successfully! We will contact you shortly.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="msg-error">Failed to send message. Please try again later.</div>
        <?php endif; ?>

        <form action="index.php?page=submit_contact" method="POST">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="name" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label>Your Email</label>
                <input type="email" name="email" required placeholder="john@example.com">
            </div>

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" required placeholder="Order Inquiry, Technical Issue, etc.">
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea name="message" rows="6" required placeholder="How can we help you?"></textarea>
            </div>

            <button type="submit" class="btn-send">Send Message</button>
        </form>
    </div>

    <?php if($footerInclude && file_exists($footerInclude)) include $footerInclude; ?>

</body>
</html>