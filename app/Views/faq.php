<div class="container">
    <h2>Frequently Asked Questions</h2>

    <?php if (!empty($faqs)): ?>
        <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <h3 class="question"><?php echo htmlspecialchars($faq['Question']); ?></h3>
                <p class="answer"><?php echo nl2br(htmlspecialchars($faq['Answer'])); ?></p>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No questions added yet.</p>
    <?php endif; ?>
</div>