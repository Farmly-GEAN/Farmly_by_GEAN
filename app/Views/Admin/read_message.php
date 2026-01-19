<!DOCTYPE html>
<html lang="en">
<head>
    <title>Read Message - Admin</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    
    <style>
        /* Internal Styles for Message View */
        .msg-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        
        .msg-header { border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .msg-meta { color: #7f8c8d; font-size: 0.9rem; margin-bottom: 10px; line-height: 1.5; }
        
        .msg-body { font-size: 1rem; line-height: 1.6; color: #2c3e50; background: #f9f9f9; padding: 20px; border-radius: 5px; border: 1px solid #eee; }
        
        .reply-section { margin-top: 30px; border-top: 2px solid #eee; padding-top: 20px; }
        textarea { width: 100%; padding: 15px; border: 2px solid #ddd; border-radius: 6px; min-height: 150px; font-family: "Segoe UI", sans-serif; resize: vertical; margin-bottom: 15px; }
        textarea:focus { border-color: #3498db; outline: none; }
        
        .btn-reply { background: #3498db; color: white; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-reply:hover { background: #2980b9; }
        
        .badge-replied { background: #27ae60; color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.75rem; margin-left: 10px; }
        
        .back-link { text-decoration: none; color: #7f8c8d; font-weight: bold; font-size: 0.9rem; }
        .back-link:hover { color: #34495e; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <div class="main-content">
        <div class="top-bar">
            <h2>
                <a href="index.php?page=admin_messages" class="back-link">← Back</a> 
                &nbsp;|&nbsp; Message Details
            </h2>
        </div>

        <?php if ($msg): ?>
            <?php 
                $current_type = $type ?? $_GET['type'] ?? 'contact';
                $safe_id = $msg['contact_id'] ?? $msg['Contact_ID'] ?? $msg['feedback_id'] ?? $msg['Feedback_ID'] ?? $msg['message_id'] ?? null;
                $subject = $msg['Subject'] ?? $msg['subject'] ?? '(No Subject)';
                $name    = $msg['Name'] ?? $msg['name'] ?? 'User';
                $email   = $msg['Email'] ?? $msg['email'] ?? 'No Email';
                $body    = $msg['Message'] ?? $msg['message'] ?? '';
                $status  = $msg['Status'] ?? $msg['status'] ?? 'New';
                
                $raw_date = $msg['Created_At'] ?? $msg['created_at'] ?? null;
                $date_display = $raw_date ? date("M d, Y H:i", strtotime($raw_date)) : 'Unknown Date';

                $admin_reply = $msg['Admin_Reply'] ?? $msg['admin_reply'] ?? '';
                $replied_at_raw = $msg['Replied_At'] ?? $msg['replied_at'] ?? null;
                $replied_date = $replied_at_raw ? date("M d, Y", strtotime($replied_at_raw)) : '';
            ?>

            <div class="msg-container">
                <div class="msg-header">
                    <h3 style="margin-top:0; color:#2c3e50;">
                        <?php echo htmlspecialchars($subject); ?>
                    </h3>
                    
                    <div class="msg-meta">
                        <strong>From:</strong> <?php echo htmlspecialchars($name); ?> 
                        &lt;<?php echo htmlspecialchars($email); ?>&gt;<br>
                        <strong>Date:</strong> <?php echo $date_display; ?>
                        
                        <?php if ($status === 'Replied'): ?>
                            <span class="badge-replied">✅ Replied</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="msg-body">
                    <?php echo nl2br(htmlspecialchars($body)); ?>
                </div>

                <div class="reply-section">
                    <?php if ($status === 'Replied'): ?>
                        <h4 style="color: #27ae60;">You replied on <?php echo $replied_date; ?>:</h4>
                        <div style="background: #e8f8f5; padding: 15px; border-radius: 5px; color: #155724; border: 1px solid #c3e6cb;">
                            <?php echo nl2br(htmlspecialchars($admin_reply)); ?>
                        </div>
                    <?php else: ?>
                        <h4 style="color: #34495e;">↩️ Send a Reply</h4>
                        <form action="index.php?page=admin_reply_message" method="POST">
                            
                            <input type="hidden" name="msg_id" value="<?php echo $safe_id; ?>">
                            <input type="hidden" name="msg_type" value="<?php echo $current_type; ?>">
                            
                            <textarea name="reply_text" placeholder="Type your reply here to send to the user..." required></textarea>
                            <button type="submit" class="btn-reply">Send Reply</button>
                        </form>
                    <?php endif; ?>
                </div>

            </div>
        <?php else: ?>
            <p style="padding: 20px; color: red;">Message not found or deleted.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>