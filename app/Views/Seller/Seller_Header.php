<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css?v=2.2">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="logo">
        <a href="index.php?page=seller_dashboard" style="text-decoration:none;">
            <img src="assets/images/Logo/Team Logo.png" alt="Farmly" 
                 style="height: 50px; width: auto;" 
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';">
            <span style="display:none; font-weight:bold; color:#27ae60; font-size:24px;">🌱 FARMLY</span>
        </a>
    </div>

    <div class="profile">
        <a href="index.php?page=seller_profile" class="profile-btn">
            <img src="assets/images/Logo/user.png" alt="User" 
                 style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;"
                 onerror="this.src='https://cdn-icons-png.flaticon.com/512/1077/1077114.png'">
                 
            <span>Hi, <?php echo htmlspecialchars($_SESSION['seller_name'] ?? 'Seller'); ?></span>
        </a>

        <a href="index.php?page=logout" class="logout">Logout</a>
    </div>
</header>