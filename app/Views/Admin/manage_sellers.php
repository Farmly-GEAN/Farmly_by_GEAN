<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Sellers - Admin</title>
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
        
        .seller-info strong { display: block; color: #2c3e50; }
        .seller-info small { color: #7f8c8d; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <?php include __DIR__ . '/Admin_Sidebar.php'; ?>

    <main class="main-content">
        <header class="top-bar">
            <h2>Manage Sellers</h2>
            <div class="user-info">Admin Panel</div>
        </header>

        <?php if(isset($_GET['success'])): ?>
            <p style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:20px;">
                ✅ <?php echo htmlspecialchars($_GET['success']); ?>
            </p>
        <?php elseif(isset($_GET['error'])): ?>
            <p style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:20px;">
                ❌ <?php echo htmlspecialchars($_GET['error']); ?>
            </p>
        <?php endif; ?>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Seller Details</th>
                    <th>Contact Info</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sellers)): ?>
                    <?php foreach ($sellers as $s): ?>
                    
                    <?php 
                        
                        $s_id    = $s['Seller_ID'] ?? $s['seller_id'] ?? $s['id'] ?? 'N/A';
                        $s_name  = $s['Seller_Name'] ?? $s['seller_name'] ?? 'Unknown';
                        $s_email = $s['Seller_Email'] ?? $s['seller_email'] ?? 'No Email';
                        $s_phone = $s['Seller_Phone_Number'] ?? $s['seller_phone_number'] ?? $s['phone'] ?? 'N/A';
                        $s_addr  = $s['Seller_Address'] ?? $s['seller_address'] ?? 'No Address';
                    ?>

                    <tr>
                        <td>#<?php echo htmlspecialchars($s_id); ?></td>
                        <td class="seller-info">
                            <strong><?php echo htmlspecialchars($s_name); ?></strong>
                        </td>
                        <td class="seller-info">
                            <strong><?php echo htmlspecialchars($s_email); ?></strong>
                            <small><?php echo htmlspecialchars($s_phone); ?></small>
                        </td>
                        <td style="max-width: 250px; font-size: 0.9rem; color: #555;">
                            <?php echo htmlspecialchars($s_addr); ?>
                        </td>
                        <td>
                            <a href="index.php?page=admin_delete_seller&id=<?php echo $s_id; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Are you sure? This will delete the Seller AND all their products.');">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 30px;">No sellers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

</body>
</html>