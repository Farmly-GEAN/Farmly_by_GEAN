<?php
session_start();
require_once __DIR__ . '/../../Models/config/db.php';

// 1. Security Check: Ensure user is a Seller
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: Seller_Login.php");
    exit();
}

$seller_id = $_SESSION['user_id'];
$message = "";

// 2. Handle DELETE Request
if (isset($_POST['delete_product_id'])) {
    $delete_id = $_POST['delete_product_id'];
    
    // Secure delete: Only delete if the product belongs to the current seller
    $delSql = "DELETE FROM Product WHERE Product_ID = ? AND Seller_ID = ?";
    $delStmt = $pdo->prepare($delSql);
    
    if ($delStmt->execute([$delete_id, $seller_id])) {
        $message = "Product deleted successfully.";
    } else {
        $message = "Error deleting product.";
    }
}

// 3. Fetch Seller's Products (Joined with Category to get Category Name)
$sql = "SELECT p.*, c.Category_Name 
        FROM Product p 
        LEFT JOIN Category c ON p.Category_ID = c.Category_ID 
        WHERE p.Seller_ID = ? 
        ORDER BY p.Product_ID DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$seller_id]);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listed Products</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Seller_Listed_Products.css" />
    <style>
        /* Small fix for the message box */
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
  </head>
  <body>
    <header>
      <div class="logo">
        <img src="../../../public/assets/images/Logo/Team Logo.png" alt="Farmly" />
      </div>
      <div class="profile">
        <a href="Profile.php" class="pro-btn">
          <img src="../../../public/assets/images/Logo/user.png" alt="User Icon" />
        </a>
        <a href="../../Controllers/logout.php" class="logout">Logout</a>
      </div>
    </header>

    <div class="container">

        <aside class="sidebar">
            <a href="Seller_AddProduct.php">Add Products</a>
            <a href="Seller_Listed_Products.php" class="active">Listed Products</a>
            <a href="#">Orders</a>
            <a href="#">Reviews</a>
        </aside>

        <main class="product-section">
            <h2>Listed Products</h2>

            <?php if($message): ?>
                <div class="alert <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="../../../public/<?php echo htmlspecialchars($product['product_image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                             onerror="this.src='../../../public/assets/images/default.png';">

                        <div class="details">
                            <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product['product_name']); ?></p>
                            <p><strong>Quantity Listed:</strong> <?php echo htmlspecialchars($product['stocks_available']); ?> kg</p>
                            <p><strong>Price per Kg:</strong> ₹<?php echo htmlspecialchars($product['price']); ?></p>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category_name']); ?></p>
                        </div>

                        <div class="actions">
                            <button class="add-btn" style="opacity: 0.5; cursor: not-allowed;">Edit</button>
                            
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                                <input type="hidden" name="delete_product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" class="del-btn">DELETE</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; margin-top: 50px;">No products listed yet. <a href="Seller_AddProduct.php">Add one now!</a></p>
            <?php endif; ?>

        </main>
    </div>

    <?php include 'Seller_Footer.php'; ?>

</body>
</html>