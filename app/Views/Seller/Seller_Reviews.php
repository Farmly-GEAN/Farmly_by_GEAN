<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Reviews</title>
    <link rel="stylesheet" href="../CSS/Seller_Reviews.css">
</head>
<body>

    <!-- Header -->
  <header>
        <div class="logo"><img src="../Logo/Team Logo.png" alt="Farmly"></div>
        <div class="profile">
        <a href="Profile.php" class="pro-btn">
    <img src="../Logo/user.png" alt="User Icon">
    
        </a>
        <a href="#" class="logout">Logout</a>
        </div>
    </header>
    <div class="container">

        <!-- Sidebar -->
        <aside class="sidebar">
            <a href="#">Add Products</a>
            <a href="#" class="active">Listed Products</a>
            <a href="#">Orders</a>
            <a href="#">Reviews</a>
        </aside>

        <!-- Reviews Section -->
        <main class="review-section">
            <h2>Reviews</h2>

            <table class="review-table">
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Review Message</th>
                </tr>

                <tr>
                    <td>Apple</td>
                    <td>Gaurav</td>
                    <td>Good</td>
                    <td>Fresh & good quality. Delivery was fast.</td>
                </tr>

                <tr>
                    <td>Carrot</td>
                    <td>Nishok</td>
                    <td>Excellent</td>
                    <td>Very fresh and crunchy. Will order again!</td>
                </tr>

                <tr>
                    <td>Spinach</td>
                    <td>Aakash</td>
                    <td>Average</td>
                    <td>Good quality but packaging was loose.</td>
                </tr>
            </table>
        </main>
    </div>

    <!-- Footer -->
   <?php include '../Header_Footer/Footer.php'; ?>

</body>
</html>
