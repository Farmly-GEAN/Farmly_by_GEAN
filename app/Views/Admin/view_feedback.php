<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Feedback - Admin</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    <style>
        /* TAG STYLES */
        .role-tag { padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }
        .tag-seller { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; } /* Yellow/Orange */
        .tag-buyer { background-color: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; } /* Blue */
        
        .feedback-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; border-left: 5px solid #ccc; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>
    
    <div class="main-content">
        <h2>User Feedback</h2>

        <?php if (!empty($feedbacks)): ?>
            <?php foreach ($feedbacks as $f): ?>
                <?php 
                    // Determine which class to use based on Role
                    $roleClass = ($f['User_Role'] === 'Seller') ? 'tag-seller' : 'tag-buyer';
                ?>
                <div class="feedback-card">
                    <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                        <strong><?php echo htmlspecialchars($f['Subject']); ?></strong>
                        
                        <span class="role-tag <?php echo $roleClass; ?>">
                            <?php echo htmlspecialchars($f['User_Role']); ?>
                        </span>
                    </div>
                    
                    <p style="margin: 5px 0; color:#555;"><?php echo nl2br(htmlspecialchars($f['Message'])); ?></p>
                    
                    <div style="margin-top:10px; font-size:0.85rem; color:#888;">
                        Sent by: <?php echo htmlspecialchars($f['User_Name']); ?> | 
                        Date: <?php echo $f['Created_At']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No feedback received yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>