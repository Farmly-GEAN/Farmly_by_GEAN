<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Register.css?v=7.0">
</head>
<body>

    <header class="top-header">
        <a href="index.php?page=home">
            <img src="assets/images/Logo/Team Logo.png" alt="Farmly" class="header-logo" onerror="this.style.display='none'">
        </a>
    </header>

    <section class="main-section">
        <div class="login-card">
            
            <h2 class="login-title">Register New Shop</h2>
            
            <?php if(isset($error)): ?>
                <p style="color:red; margin-bottom:15px; font-weight:600;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form action="index.php?page=seller_register" method="POST" enctype="multipart/form-data">
                
                <div class="form-row">
                    <div class="form-field half">
                        <label>Store Name</label>
                        <input type="text" name="seller_name" required placeholder="e.g. Green Valley Farm">
                    </div>
                    <div class="form-field half">
                        <label>Email Address</label>
                        <input type="email" name="seller_email" required placeholder="business@example.com">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field half">
                        <label>Phone Number</label>
                        <input type="text" name="seller_phone" required placeholder="Mobile Number">
                    </div>
                    <div class="form-field half">
                        <label>Store Logo</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="seller_image" id="seller_image" accept="image/*" required>
                            <label for="seller_image" class="custom-file-label">Upload Logo</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field half">
                        <label>House / Door No.</label>
                        <input type="text" name="door_no" required placeholder="e.g. 12B">
                    </div>
                    <div class="form-field half">
                        <label>Pincode</label>
                        <input type="text" name="pincode" required placeholder="e.g. 10001">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-field half">
                        <label>City</label>
                        <input type="text" name="city" required placeholder="e.g. New York">
                    </div>
                    <div class="form-field half">
                        <label>Country</label>
                        <input type="text" name="country" required placeholder="e.g. USA">
                    </div>
                </div>

                <div class="form-field">
                    <label>Street Name / Area</label>
                    <input type="text" name="street" required placeholder="e.g. Main Street, Downtown">
                </div>

                <div class="form-row">
                    <div class="form-field half">
                        <label>Password</label>
                        <input type="password" name="seller_password" required placeholder="Strong Password">
                    </div>
                    <div class="form-field half">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" required placeholder="Repeat Password">
                    </div>
                </div>

                <button type="submit" class="login-btn">Register Shop</button>

            </form>
            
            <div class="create">
                Already have a shop? <a href="index.php?page=seller_login">Login here</a>
            </div>
        </div>
    </section>

    <?php include __DIR__ . '/Seller_Footer.php'; ?>

    <script>
        document.getElementById('seller_image').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : "Upload Logo";
            this.nextElementSibling.innerText = fileName;
        });
    </script>

</body>
</html>