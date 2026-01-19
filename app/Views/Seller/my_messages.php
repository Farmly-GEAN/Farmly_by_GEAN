

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Seller Inbox - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .inbox-container { width: 70%; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        h2 { border-bottom: 2px solid #eee; padding-bottom: 15px; color: #2c3e50; }
        
        .msg-card { border: 1px solid #eee; border-radius: 6px; margin-bottom: 20px; overflow: hidden; }
        .msg-header { background: #f8f9fa; padding: 15px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; }
        
        .msg-status { font-weight: bold; font-size: 0.85rem; padding: 4px 8px; border-radius: 4px; }
        .status-new { background: #e2e3e5; color: #333; }
        .status-replied { background: #d4edda; color: #155724; }
        .status-read { background: #d1ecf1; color: #0c5460; }

        .msg-body { padding: 20px; color: #555; }
        .admin-reply { background: #e8f8f5; padding: 15px; margin-top: 15px; border-left: 4px solid #27ae60; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
<?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <div class="inbox-container">
    <h2>Seller Inquiries & Support</h2>

    <?php if (!empty($my_messages)): ?>
        <?php foreach ($my_messages as $msg): ?>
            <?php 
                $subject = $msg['subject'] ?? $msg['Subject'] ?? '(No Subject)';
                $message = $msg['message'] ?? $msg['Message'] ?? '';
                $status  = $msg['status'] ?? $msg['Status'] ?? 'New';
                $reply   = $msg['admin_reply'] ?? $msg['Admin_Reply'] ?? '';
                $created_at = $msg['created_at'] ?? $msg['Created_At'] ?? date('Y-m-d');
                $date = date("M d, Y", strtotime($created_at));

                $statusClass = 'status-new';
                if ($status === 'Replied') $statusClass = 'status-replied';
                if ($status === 'Read') $statusClass = 'status-read';
            ?>

            <div class="msg-card">
                <div class="msg-header">
                    <div>
                        <strong>Subject:</strong> <?php echo htmlspecialchars($subject); ?>
                        <span style="color:#999; font-size:0.9rem; margin-left:10px;">(<?php echo $date; ?>)</span>
                    </div>
                    <span class="msg-status <?php echo $statusClass; ?>">
                        <?php echo htmlspecialchars($status); ?>
                    </span>
                </div>

                <div class="msg-body">
                    <p style="margin-top:0;"><strong>You asked:</strong></p>
                    <p><?php echo nl2br(htmlspecialchars($message)); ?></p>

                    <?php if (!empty($reply)): ?>
                        <div class="admin-reply">
                            <strong style="color: #27ae60;">Admin Reply:</strong><br>
                            <?php echo nl2br(htmlspecialchars($reply)); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; padding: 40px; color: #777;">You haven't sent any messages to Admin yet.</p>
    <?php endif; ?>
</div>

</div>

</div>



</body>
</html>