<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile - Farmly Seller</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Profile.css">
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>My Profile</h2>

            <?php if(isset($_GET['success'])): ?>
                <p class="success-msg">✓ <?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php endif; ?>

            <div class="profile-card">
                <form action="index.php?page=seller_update_profile_action" method="POST">
                    
                    <div class="form-group">
                        <label>Store/Seller Name</label>
                        <input type="text" name="seller_name" value="<?php echo htmlspecialchars($seller['seller_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" value="<?php echo htmlspecialchars($seller['email'] ?? $seller['seller_email'] ?? ''); ?>" class="readonly-input" readonly>
                        <small class="helper-text">Email cannot be changed directly.</small>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="seller_phone" value="<?php echo htmlspecialchars($seller['seller_phone'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Warehouse / Store Address</label>
                        <textarea name="seller_address" required><?php echo htmlspecialchars($seller['seller_address'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn-save">Save Changes</button>
                </form>
            </div>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>