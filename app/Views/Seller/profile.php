<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Profile - Farmly Seller</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
    
    <style>
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 1rem; }
        
        /* Layout for Address Fields */
        .address-row { display: flex; gap: 15px; }
        .col-half { flex: 1; }

        .readonly-input { background-color: #f9f9f9; color: #777; cursor: not-allowed; }
        .helper-text { display: block; margin-top: 5px; color: #888; font-size: 0.85rem; }
        
        .btn-save {
            background-color: #27ae60;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-save:hover { background-color: #219150; }
        
        .success-msg { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
        .error-msg { background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
    </style>
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
            <?php if(isset($_GET['error'])): ?>
                <p class="error-msg">⚠️ <?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <?php
                // --- HELPER: Try to split existing address string back into parts ---
                // Expected Format in DB: "Door 12, Main St, New York - 10001"
                $fullAddr = $seller['Seller_Address'] ?? $seller['seller_address'] ?? '';
                $door = ''; $street = ''; $city = ''; $pin = '';

                // Simple parser: assumes comma separation. 
                // If it fails, the full address goes into 'Street' so user can fix it.
                $parts = explode(',', $fullAddr);
                
                if (count($parts) >= 2) {
                    $door = trim($parts[0]);
                    $street = trim($parts[1]);
                    
                    // Try to separate City and Pin (usually separated by ' - ')
                    if (isset($parts[2])) {
                        $lastPart = trim($parts[2]); // "New York - 10001"
                        $cityPin = explode('-', $lastPart);
                        $city = trim($cityPin[0] ?? $lastPart);
                        $pin = trim($cityPin[1] ?? '');
                    }
                } else {
                    $street = $fullAddr; // Fallback
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
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="seller_phone" class="form-control"
                               value="<?php echo htmlspecialchars($seller['Seller_Phone_Number'] ?? $seller['seller_phone'] ?? ''); ?>" required>
                    </div>

                    <h3 style="margin-top:20px; margin-bottom:15px; font-size:1.1rem; color:#333; border-bottom:1px solid #eee; padding-bottom:5px;">Warehouse Address</h3>
                    
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