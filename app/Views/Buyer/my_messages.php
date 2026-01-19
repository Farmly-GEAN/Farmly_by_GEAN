

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Messages - Farmly</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f9f9f9; }
        .site-header { background: white; padding: 10px 40px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo img { height: 90px; width: auto; display: block; }
        .header-right { display: flex; align-items: center; gap: 20px; }
        .header-right a { text-decoration: none; color: #333; font-weight: bold; }
        .inbox-container { max-width: 900px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
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

<?php 
        $b_name  = $_SESSION['user_name'] ?? 'Guest';
        $b_email = ''; $b_phone = ''; $b_addr  = '';
        if (isset($buyer) && is_array($buyer)) {
            $b_name  = $buyer['Buyer_Name'] ?? $buyer['buyer_name'] ?? $b_name;
            $b_email = $buyer['Buyer_Email'] ?? $buyer['buyer_email'] ?? '';
            $b_phone = $buyer['Buyer_Phone'] ?? $buyer['buyer_phone'] ?? '';
            $b_addr  = $buyer['Buyer_Address'] ?? $buyer['buyer_address'] ?? '';
        }
    ?>

    <header class="site-header">
        <div class="logo">
            <a href="index.php?page=home">
                <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo">
            </a>
        </div>
        <div class="header-right">
            <span>Hi, <?php echo htmlspecialchars($b_name); ?></span>
            
            <a href="index.php?page=my_orders" style="margin-left: 15px;">My Orders</a>
            
            <a href="index.php?page=home">Shop</a>
            <a href="index.php?page=my_messages" class="btn-inbox" style="text-decoration:none;">Inbox</a>
            <a href="index.php?page=logout" style="color: #e74c3c;">Logout</a>
        </div>
    </header>

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
        <p style="text-align:center; padding: 40px; color: #777;">You haven't sent any messages yet.</p>
    <?php endif; ?>
</div>

</body>
</html>