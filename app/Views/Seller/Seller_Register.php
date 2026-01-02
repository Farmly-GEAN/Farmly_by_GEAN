<?php
session_start();
// Adjust this path to point to your db.php file
require_once __DIR__ . '/../../Models/config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect Data from HTML Form
    $name = $_POST['seller_name'];
    $email = $_POST['seller_email'];
    $phone = $_POST['seller_phone'];
    $address = $_POST['seller_address'];
    $password = $_POST['seller_password'];
    $confirmPass = $_POST['confirm_password'];

    // 2. Validate Password
    if ($password !== $confirmPass) {
        $message = "Passwords do not match!";
    } else {
        // 3. Check if Email Already Exists
        $stmt = $pdo->prepare("SELECT Seller_ID FROM Seller WHERE Seller_Email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $message = "Email is already registered!";
        } else {
            // 4. Handle Image Upload
            $imagePath = null;
            
            // Check if file is uploaded without errors
            if (isset($_FILES['seller_image']) && $_FILES['seller_image']['error'] === 0) {
                // Define where to save the file
                $uploadDir = __DIR__ . '/../../../public/assets/uploads/sellers/';
                
                // Create folder if it doesn't exist
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Generate unique name: seller_TIME.jpg
                $fileExt = pathinfo($_FILES['seller_image']['name'], PATHINFO_EXTENSION);
                $fileName = "seller_" . time() . "." . $fileExt;
                $targetFile = $uploadDir . $fileName;

                // Move file from temp storage to our folder
                if (move_uploaded_file($_FILES['seller_image']['tmp_name'], $targetFile)) {
                    // Save this relative path to the database
                    $imagePath = "assets/uploads/sellers/" . $fileName; 
                } else {
                    $message = "Failed to upload image.";
                }
            }

            // 5. Insert into Database
            if (empty($message)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO Seller (Seller_Name, Seller_Email, Seller_Phone_Number, Seller_Address, Seller_Image_Url, Seller_Password) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                
                if ($stmt->execute([$name, $email, $phone, $address, $imagePath, $hashed_password])) {
                    // Success! Redirect to Login
                    header("Location: Seller_Login.php?success=1");
                    exit();
                } else {
                    $message = "Database error: Could not register seller.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Seller_Register.css">
</head>
<body>

<div class="main-section">
    <h2>Become a Seller</h2>
    
    <?php if($message): ?>
        <p style="color: red; text-align: center; font-weight: bold;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        
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
    
    <p>Already a seller? <a href="Seller_Login.php">Login here</a></p>
</div>

</body>
</html>