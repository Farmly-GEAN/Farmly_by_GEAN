<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - User Messages</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; }
        .container { display: flex; min-height: 100vh; }
        
       
        .sidebar { width: 250px; background: #2c3e50; color: white; min-height: 100vh; }
        
        .main-content { flex: 1; padding: 30px; background: #f4f7f6; }
        
        .card { background: white; padding: 25px; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .card h3 { border-bottom: 2px solid #eee; padding-bottom: 15px; color: #2c3e50; margin-top: 0; font-size: 1.1rem; text-transform: uppercase; letter-spacing: 0.5px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; font-size: 0.95rem; }
        th { background: #f8f9fa; color: #555; font-weight: 600; }
        tr:hover { background-color: #f9f9f9; }
        
        .msg-date { color: #888; font-size: 0.85rem; width: 120px; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; display: inline-block; }
        .badge-Buyer { background: #d1ecf1; color: #0c5460; }
        .badge-Seller { background: #fff3cd; color: #856404; }
        .badge-Guest { background: #e2e3e5; color: #383d41; }
        
        .empty-state { padding: 20px; text-align: center; color: #777; font-style: italic; }
    </style>
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <div class="main-content">
        <h2 style="margin-bottom: 25px; color: #333;">Messages & Feedback</h2>

        <div class="card">
            <h3>Platform Feedback / Complaints</h3>
            <?php if (!empty($feedbacks)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User Type</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $fb): ?>
                            <?php 
                                
                                $date = $fb['Created_At'] ?? $fb['created_at'] ?? date('Y-m-d');
                                $type = $fb['User_Type'] ?? $fb['user_type'] ?? 'Guest';
                                $subj = $fb['Subject'] ?? $fb['subject'] ?? '(No Subject)';
                                $msg  = $fb['Message'] ?? $fb['message'] ?? '';
                            ?>
                            <tr>
                                <td class="msg-date"><?php echo date("M d, Y", strtotime($date)); ?></td>
                                <td><span class="badge badge-<?php echo $type; ?>"><?php echo $type; ?></span></td>
                                <td><?php echo htmlspecialchars($subj); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($msg)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">No feedback received yet.</div>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3>General Inquiries (Contact Us)</h3>
            <?php if (!empty($contacts)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $msg): ?>
                            <?php 
                                
                                $date  = $msg['Created_At'] ?? $msg['created_at'] ?? date('Y-m-d');
                                $name  = $msg['Name'] ?? $msg['name'] ?? 'Unknown';
                                $email = $msg['Email'] ?? $msg['email'] ?? '';
                                $subj  = $msg['Subject'] ?? $msg['subject'] ?? '(No Subject)';
                                $body  = $msg['Message'] ?? $msg['message'] ?? '';
                            ?>
                            <tr>
                                <td class="msg-date"><?php echo date("M d, Y", strtotime($date)); ?></td>
                                <td><?php echo htmlspecialchars($name); ?></td>
                                <td><a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a></td>
                                <td><?php echo htmlspecialchars($subj); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($body)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">No contact messages yet.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>