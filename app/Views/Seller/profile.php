<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Farmly Seller</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Profile.css?v=2.0">
</head>
<body>

<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>My Profile</h2>

            <?php if(isset($_GET['success'])): ?>
                <div class="success-msg">
                    <span>✓</span> <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_GET['error'])): ?>
                <div class="error-msg">
                    <span>⚠️</span> <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>

            <?php
               
                $fullAddr = $seller['Seller_Address'] ?? $seller['seller_address'] ?? '';
                $door = ''; $street = ''; $city = ''; $pin = '';

                $parts = explode(',', $fullAddr);
                
                if (count($parts) >= 2) {
                    $door = trim($parts[0]);
                    $street = trim($parts[1]);
                    
                    if (isset($parts[2])) {
                        $lastPart = trim($parts[2]); 
                        $cityPin = explode('-', $lastPart);
                        $city = trim($cityPin[0] ?? $lastPart);
                        $pin = trim($cityPin[1] ?? '');
                    }
                } else {
                    $street = $fullAddr; 
                }
            ?>

            <div class="profile-card">
                <form action="index.php?page=seller_update_profile_action" method="POST">
                    
                    <div class="form-group">
                        <label>Store/Seller Name</label>
                        <input type="text" name="seller_name" class="form-control"
                               value="<?php echo htmlspecialchars($seller['Seller_Name'] ?? $seller['seller_name'] ?? ''); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" 
                               value="<?php echo htmlspecialchars($seller['Seller_Email'] ?? $seller['seller_email'] ?? $seller['email'] ?? ''); ?>" 
                               class="form-control readonly-input" readonly>
                        <span class="helper-text">Email cannot be changed. Contact support for assistance.</span>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="seller_phone" class="form-control"
                               value="<?php echo htmlspecialchars($seller['Seller_Phone_Number'] ?? $seller['seller_phone'] ?? ''); ?>" required>
                    </div>

                    <h3 style="margin-top:30px; margin-bottom:20px; font-size:1.1rem; color:#2c3e50; border-bottom:1px solid #eee; padding-bottom:10px;">
                        Warehouse Address
                    </h3>
                    
                    <div class="address-row">
                        <div class="col-half">
                            <div class="form-group">
                                <label>House / Door No.</label>
                                <input type="text" name="door_no" class="form-control" placeholder="e.g. 12B" value="<?php echo htmlspecialchars($door); ?>" required>
                            </div>
                        </div>
                        <div class="col-half">
                            <div class="form-group">
                                <label>Pincode</label>
                                <input type="text" name="pincode" class="form-control" placeholder="e.g. 10001" value="<?php echo htmlspecialchars($pin); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Street / Area</label>
                        <input type="text" name="street" class="form-control" placeholder="e.g. Main Street, Downtown" value="<?php echo htmlspecialchars($street); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" placeholder="e.g. New York" value="<?php echo htmlspecialchars($city); ?>" required>
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