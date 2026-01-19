<?php
// Smart "Back" Button Logic
if (session_status() === PHP_SESSION_NONE) session_start();

$backLink = 'index.php?page=home';
$backText = 'Back to Home';

// If Seller, change destination
if (isset($_SESSION['role']) && $_SESSION['role'] === 'seller') {
    $backLink = 'index.php?page=seller_dashboard';
    $backText = 'Back to Dashboard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Legal Notice - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; line-height: 1.6; color: #333; margin: 0; background: #f9f9f9; }
        .container { max-width: 800px; margin: 50px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 15px; }
        .content { white-space: pre-line; color: #555; }
        .back-btn { display: inline-block; margin-top: 20px; text-decoration: none; color: white; background: #27ae60; padding: 10px 20px; border-radius: 5px; }
        .back-btn:hover { background: #219150; }
    </style>
</head>
<body>

<div class="container">
    <h1>Legal Notice / Imprint</h1>
    
    <div class="content">
        <?php echo $content; ?>
    </div>

    <br>
    <a href="<?php echo $backLink; ?>" class="back-btn"><?php echo $backText; ?></a>
</div>

</body>
</html>