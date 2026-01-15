<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage FAQ - Admin</title>
    <style>
        
        textarea { width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 6px; font-family: "Segoe UI", sans-serif; resize: vertical; }
        input[type="text"] { width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 6px; margin-bottom: 10px; }
        
        .btn-green { background: #27ae60; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-green:hover { background: #219150; }

        .btn-red { background: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.9rem; }
        .btn-red:hover { background: #c0392b; }

        .faq-item { border-bottom: 1px solid #eee; padding: 15px 0; display: flex; justify-content: space-between; align-items: center; }
        .faq-item:last-child { border-bottom: none; }
        .faq-content h4 { margin: 0 0 5px 0; color: #2c3e50; }
        .faq-content p { margin: 0; color: #7f8c8d; font-size: 0.95rem; }

        .dashboard-container { display: flex; height: 100vh; width: 100%; }
        .main-content { flex: 1; padding: 30px; overflow-y: auto; background: #f0f2f5; }
    </style>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
</head>
<body>

<div class="dashboard-container">
    
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h2>Manage FAQs</h2>
            <div class="user-info">Admin Panel</div>
        </div>

        <div class="card" style="margin-bottom: 30px;">
            <h3>Add New Question</h3>
            <form action="index.php?page=admin_add_faq" method="POST">
                <label>Question:</label>
                <input type="text" name="question" placeholder="e.g., How do I reset my password?" required>
                
                <label>Answer:</label>
                <textarea name="answer" placeholder="Enter the answer here..." style="height: 100px;" required></textarea>
                
                <button type="submit" class="btn-green" style="margin-top: 15px;">Add FAQ</button>
            </form>
        </div>

        <div class="card">
            <h3>Existing Questions</h3>
            
            <?php if (!empty($faqs)): ?>
                <?php foreach ($faqs as $faq): ?>
                    <div class="faq-item">
                        <div class="faq-content">
                            <h4>Q: <?php echo htmlspecialchars($faq['Question'] ?? $faq['question']); ?></h4>
                            <p>A: <?php echo htmlspecialchars($faq['Answer'] ?? $faq['answer']); ?></p>
                        </div>
                        <div class="faq-actions">
                            <a href="index.php?page=admin_delete_faq&id=<?php echo $faq['FAQ_ID'] ?? $faq['faq_id']; ?>" 
                               class="btn-red"
                               onclick="return confirm('Are you sure you want to delete this?');">
                               Delete
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #999; font-style: italic;">No FAQs added yet.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>