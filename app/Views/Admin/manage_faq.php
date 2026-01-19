<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage FAQ - Admin</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    <style>
        .faq-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; }
        .faq-text h4 { margin: 0 0 5px 0; color: #2c3e50; }
        .faq-text p { margin: 0; color: #555; }
        .btn-delete { background: #e74c3c; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .btn-add { background: #27ae60; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 1rem; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h2>Manage FAQs</h2>
        </div>

        <div class="card" style="margin-bottom: 30px;">
            <h3>Add New Question</h3>
            <form action="index.php?page=admin_add_faq" method="POST">
                <input type="text" name="question" required placeholder="Question (e.g., How do I track my order?)">
                <textarea name="answer" rows="3" required placeholder="Answer..."></textarea>
                <button type="submit" class="btn-add">Post FAQ</button>
            </form>
        </div>

        <h3>Existing FAQs</h3>
        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $f): ?>
                <div class="faq-card">
                    <div class="faq-text">
                        <h4>Q: <?php echo htmlspecialchars($f['question'] ?? $f['Question']); ?></h4>
                        <p>A: <?php echo htmlspecialchars($f['answer'] ?? $f['Answer']); ?></p>
                    </div>
                    <a href="index.php?page=admin_delete_faq&id=<?php echo $f['faq_id'] ?? $f['FAQ_ID']; ?>" class="btn-delete" onclick="return confirm('Delete this FAQ?')">Delete</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:#777;">No FAQs posted yet.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>