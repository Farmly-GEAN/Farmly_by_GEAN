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
        .msg-date { color: #888; font-size: 0.85rem; width: 100px; }
        .badge { padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: bold; display: inline-block; }
        .badge-Buyer { background: #d1ecf1; color: #0c5460; }
        .badge-Seller { background: #fff3cd; color: #856404; }
        .badge-Guest { background: #e2e3e5; color: #383d41; }
        .btn-view { background: #3498db; color: white; text-decoration: none; padding: 8px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; transition: 0.3s; display: inline-block; }
        .btn-view:hover { background: #2980b9; }
        .status-replied { color: #27ae60; font-weight: bold; font-size: 0.8rem; margin-left: 5px; }
    </style>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
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
                            <th>User Role</th>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedbacks as $fb): ?>
                            <?php 
                                
                                $date = $fb['Created_At'] ?? $fb['created_at'] ?? date('Y-m-d');
                                
                                
                                $userName = $fb['User_Name'] ?? $fb['user_name'] ?? 'Unknown';
                                $role     = $fb['User_Role'] ?? $fb['user_role'] ?? 'Guest';
                                $subj     = $fb['Subject']   ?? $fb['subject']   ?? '(No Subject)';
                                $msg      = $fb['Message']   ?? $fb['message']   ?? '';
                                
                               
                                $badgeClass = 'badge-Guest'; 
                                if (strcasecmp($role, 'Buyer') === 0) $badgeClass = 'badge-Buyer';
                                if (strcasecmp($role, 'Seller') === 0) $badgeClass = 'badge-Seller';
                            ?>
                            <tr>
                                <td class="msg-date"><?php echo date("M d, Y", strtotime($date)); ?></td>
                                
                                <td>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo htmlspecialchars($role); ?>
                                    </span>
                                </td>

                                <td>
                                    <strong><?php echo htmlspecialchars($userName); ?></strong>
                                </td>

                                <td><?php echo htmlspecialchars($subj); ?></td>
                                
                                <td>
                                    <button onclick="alert('<?php echo htmlspecialchars(addslashes($msg)); ?>')" class="btn-view" style="cursor:pointer; border:none;">
                                        Read
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding:20px; text-align:center; color:#777;">No feedback received yet.</div>
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
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $msg): ?>
                            <?php 
                                
                              $msg_id = $msg['message_id'] ?? $msg['contact_id'] ?? $msg['Contact_ID'];

                                $date = $msg['Created_At'] ?? $msg['created_at'] ?? date('Y-m-d');
                                $name = $msg['Name'] ?? $msg['name'] ?? 'Unknown';
                                $subj = $msg['Subject'] ?? $msg['subject'] ?? '(No Subject)';
                                $status = $msg['Status'] ?? $msg['status'] ?? 'New';
                            ?>
                            <tr>
    <td class="msg-date"><?php echo date("M d, Y", strtotime($date)); ?></td>
    
    <td>
        <strong><?php echo htmlspecialchars($name); ?></strong><br>
        
        <?php 
            
            $role = $msg['user_role'] ?? 'Guest'; 
            $badgeColor = '#e2e3e5; color:#383d41'; 
            
            if ($role === 'Buyer') {
                $badgeColor = '#d1ecf1; color:#0c5460'; 
            } elseif ($role === 'Seller') {
                $badgeColor = '#fff3cd; color:#856404'; 
            }
        ?>
        <span style="background: <?php echo $badgeColor; ?>; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight:bold;">
            <?php echo $role; ?>
        </span>
    </td>

    <td>
        <?php echo htmlspecialchars($subj); ?>
        <?php if($status === 'Replied') echo '<span class="status-replied">✓ Replied</span>'; ?>
    </td>
    
    <td><?php echo htmlspecialchars($status); ?></td>
    
    <td>
        <a href="index.php?page=admin_view_message&type=contact&id=<?php echo $msg_id; ?>" class="btn-view">
            Read / Reply
        </a>
    </td>
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