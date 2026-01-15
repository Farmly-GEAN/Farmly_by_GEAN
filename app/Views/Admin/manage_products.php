<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Products - Admin</title>
    <link rel="stylesheet" href="assets/CSS/Admin.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .admin-table th, .admin-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        .admin-table th { background-color: #f8f9fa; color: #555; font-weight: 600; text-transform: uppercase; font-size: 0.85rem; }
        .admin-table tr:hover { background-color: #f9f9f9; }
        
        .product-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
        
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
            <h2>Manage Products</h2>
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
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Price / Stock</th>
                    <th>Seller</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                    
                    <?php 
                        
                        $p_id    = $p['Product_ID'] ?? $p['product_id'];
                        $p_name  = $p['Product_Name'] ?? $p['product_name'];
                        $p_price = $p['Price'] ?? $p['price'];
                        $p_stock = $p['Stocks_Available'] ?? $p['stocks_available'];
                        $s_name  = $p['Seller_Name'] ?? $p['seller_name'];
                        
                       
                        $p_img   = $p['Product_Image'] ?? $p['product_image'] ?? ''; 
                    ?>

                    <tr>
                        <td>
                            <?php if(!empty($p_img)): ?>
                                <img src="<?php echo htmlspecialchars($p_img); ?>" class="product-thumb" alt="Img">
                            <?php else: ?>
                                <span style="font-size:30px;">🥦</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($p_name); ?></strong>
                        </td>
                        <td>
                            $<?php echo htmlspecialchars($p_price); ?><br>
                            <small style="color:#666;"><?php echo htmlspecialchars($p_stock); ?> kg left</small>
                        </td>
                        <td>
                            <span style="background:#e3f2fd; color:#1565c0; padding:3px 8px; border-radius:10px; font-size:0.8rem;">
                                <?php echo htmlspecialchars($s_name); ?>
                            </span>
                        </td>
                        <td>
                            <a href="index.php?page=admin_delete_product&id=<?php echo $p_id; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Delete this product permanently?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding: 30px;">No products found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

</body>
</html>