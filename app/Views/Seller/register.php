<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Register.css">
</head>
<body>

<div class="main-section">
    <h2>Become a Seller</h2>
    
    <?php if(isset($error)): ?>
        <p style="color: red; text-align: center; font-weight: bold;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="index.php?page=seller_register" method="POST" enctype="multipart/form-data">
        
        <label>Store/Seller Name</label>
        <input type="text" name="seller_name" required placeholder="Farm or Store Name">

        <label>Email</label>
        <input type="email" name="seller_email" required placeholder="Business Email">

        <label>Phone Number</label>
        <input type="text" name="seller_phone" required placeholder="Phone Number">

        <label>Business Address</label>
        <textarea name="seller_address" required placeholder="Full Address"></textarea>

        <label>Store Profile Image</label>
        <input type="file" name="seller_image" accept="image/*" required>

        <label>Password</label>
        <input type="password" name="seller_password" required placeholder="Strong Password">

        <label>Confirm Password</label>
        <input type="password" name="confirm_password" required placeholder="Repeat Password">

        <button type="submit">Register Shop</button>
    </form>
    
    <p>Already a seller? <a href="index.php?page=seller_login">Login here</a></p>
</div>

</body>
</html>