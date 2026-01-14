<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Buyers - Admin</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .admin-table th, .admin-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        .admin-table th { background-color: #f8f9fa; color: #555; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; }
        .admin-table tr:hover { background-color: #f9f9f9; }
        
        .btn-delete { 
            background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; 
            padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: bold; transition: 0.2s;
        }
        .btn-delete:hover { background: #c62828; color: white; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <h2>Manage Buyers</h2>
            <div class="user-info">Admin Panel</div>
        </header>

        <?php if(isset($_GET['success'])): ?>
            <p style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:20px;">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </p>
        <?php elseif(isset($_GET['error'])): ?>
            <p style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:20px;">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </p>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Buyer Name</th>
                    <th>Email / Phone</th>
                    <th>Shipping Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($buyers)): ?>
                    <?php foreach ($buyers as $b): ?>
                    
                    <?php 
                        // FIX: Handle Case Sensitivity (Check both Upper & Lower case keys)
                        $b_id    = $b['Buyer_ID'] ?? $b['buyer_id'] ?? $b['id'] ?? 'N/A';
                        $b_name  = $b['Buyer_Name'] ?? $b['buyer_name'] ?? 'Unknown';
                        $b_email = $b['Buyer_Email'] ?? $b['buyer_email'] ?? 'No Email';
                        $b_phone = $b['Buyer_Phone_Number'] ?? $b['buyer_phone_number'] ?? $b['Buyer_Phone'] ?? $b['buyer_phone'] ?? 'N/A';
                        $b_addr  = $b['Buyer_Address'] ?? $b['buyer_address'] ?? 'No Address';
                    ?>

                    <tr>
                        <td>#<?php echo htmlspecialchars($b_id); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($b_name); ?></strong>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($b_email); ?><br>
                            <small style="color:#777;"><?php echo htmlspecialchars($b_phone); ?></small>
                        </td>
                        <td style="max-width: 250px; font-size: 0.9rem; color: #555;">
                            <?php echo htmlspecialchars($b_addr); ?>
                        </td>
                        <td>
                            <a href="index.php?page=admin_delete_buyer&id=<?php echo $b_id; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Are you sure you want to remove this buyer?');">
                                Remove User
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 30px;">No buyers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

</body>
</html>