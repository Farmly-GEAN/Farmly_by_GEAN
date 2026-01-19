<?php
// Smart Back Button
if (session_status() === PHP_SESSION_NONE) session_start();
$backLink = 'index.php?page=home';
$backText = 'Back to Home';
if (isset($_SESSION['role']) && $_SESSION['role'] === 'seller') {
    $backLink = 'index.php?page=seller_dashboard';
    $backText = 'Back to Dashboard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Frequently Asked Questions - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f9f9f9; padding: 40px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        
        .faq-item { border-bottom: 1px solid #eee; padding: 20px 0; }
        .faq-question { font-weight: bold; font-size: 1.1rem; color: #27ae60; cursor: pointer; display: flex; justify-content: space-between; }
        .faq-answer { margin-top: 10px; color: #555; line-height: 1.6; display: none; } /* Hidden by default */
        
        /* Simple toggle visual */
        .faq-question:after { content: '+'; font-weight: bold; }
        .active .faq-question:after { content: '-'; }
        .active .faq-answer { display: block; }
        
        .back-btn { display: inline-block; margin-top: 30px; text-decoration: none; color: white; background: #333; padding: 10px 20px; border-radius: 5px; }
    </style>
    <script>
        function toggleFAQ(element) {
            element.classList.toggle('active');
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Frequently Asked Questions</h1>

    <?php if (!empty($faqs)): ?>
        <?php foreach ($faqs as $f): ?>
            <div class="faq-item" onclick="toggleFAQ(this)">
                <div class="faq-question">
                    <?php echo htmlspecialchars($f['question'] ?? $f['Question']); ?>
                </div>
                <div class="faq-answer">
                    <?php echo nl2br(htmlspecialchars($f['answer'] ?? $f['Answer'])); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center;">No questions have been posted yet.</p>
    <?php endif; ?>

    <a href="<?php echo $backLink; ?>" class="back-btn"><?php echo $backText; ?></a>
</div>

</body>
</html>