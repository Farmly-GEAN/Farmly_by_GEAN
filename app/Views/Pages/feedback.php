<?php
if (session_status() === PHP_SESSION_NONE) session_start();


$role = 'Buyer'; 
$dashboardLink = 'index.php?page=home';
$footerFile = __DIR__ . '/../Buyer/Buyer_Footer.php'; 


if (isset($_SESSION['seller_id']) || (isset($_SESSION['role']) && $_SESSION['role'] === 'seller')) {
    $role = 'Seller';
    $dashboardLink = 'index.php?page=seller_dashboard';
    $footerFile = __DIR__ . '/../Seller/Seller_Footer.php'; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $role; ?> Feedback - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; }
        .feedback-container { max-width: 600px; margin: 50px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 20px; }
        p { text-align: center; color: #666; margin-bottom: 30px; }
        .msg-success { color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .msg-error { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        .form-input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; font-family: inherit; }
        .submit-btn { width: 100%; background-color: #27ae60; color: white; padding: 12px; font-size: 1rem; font-weight: bold; border: none; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .submit-btn:hover { background-color: #219150; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #777; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="feedback-container">
        <h2><?php echo $role; ?> Feedback</h2>
        <p>Help us improve your experience. Let us know if you have any issues.</p>

        <?php if(isset($_GET['success'])): ?>
            <div class="msg-success">Thank you! Your feedback has been sent to the Admin.</div>
        <?php endif; ?>
        <?php if(isset($_GET['error'])): ?>
            <div class="msg-error">Something went wrong. Please try again.</div>
        <?php endif; ?>

        <form action="index.php?page=submit_feedback" method="POST">
            <div class="form-group">
                <label>Subject</label>
                <select class="form-input" name="subject">
                    <option value="Suggestion">Suggestion</option>
                    <option value="Report a Bug">Report a Bug</option>
                    <option value="Account Issue">Account Issue</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Your Message</label>
                <textarea name="message" rows="5" placeholder="Type your feedback here..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Feedback</button>
        </form>

        <a href="<?php echo $dashboardLink; ?>" class="back-link">Back to Dashboard/Home</a>
    </div>

    <?php 
    if(file_exists($footerFile)) {
        include $footerFile; 
    }
    ?>
</body>
</html>