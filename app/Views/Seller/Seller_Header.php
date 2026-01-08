<header>
    <div class="logo">
        <a href="index.php?page=seller_dashboard">
            <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo" />
        </a>
    </div>

    <div class="profile">
        <a href="index.php?page=seller_profile" class="profile-btn">
            <img src="assets/images/Logo/user.png" alt="User Icon" />
            <span>Hi, <?php echo htmlspecialchars($_SESSION['seller_name'] ?? 'Seller'); ?></span>
        </a>

        <a href="index.php?page=seller_logout" class="logout">Logout</a>
    </div>
</header>