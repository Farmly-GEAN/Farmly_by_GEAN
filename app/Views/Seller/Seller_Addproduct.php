<?php
session_start();
// Adjust path to your db.php
require_once __DIR__ . '/../../Models/config/db.php';

// 1. Security Check: specific check for Seller role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header("Location: Seller_Login.php");
    exit();
}

$message = "";

// 2. Fetch Categories for the dropdown
$catStmt = $pdo->query("SELECT * FROM Category ORDER BY Category_Name ASC");
$categories = $catStmt->fetchAll();

// 3. Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $seller_id = $_SESSION['user_id'];
    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name']; // This is now text input
    $stock = $_POST['stock'];
    $price = $_POST['price'];

    // Image Upload Logic
    $imagePath = null;
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $uploadDir = __DIR__ . '/../../../public/assets/uploads/products/';
        
        // Create folder if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileExt = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
        $fileName = "prod_" . time() . "_" . $seller_id . "." . $fileExt;
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
            $imagePath = "assets/uploads/products/" . $fileName;
        } else {
            $message = "Failed to upload image.";
        }
    }

    // Insert into Database
    if (empty($message)) {
        // Description is auto-generated for now
        $description = "Fresh " . $product_name . " from " . $_SESSION['user_name'];
        
        $sql = "INSERT INTO Product (Product_Name, Price, Stocks_Available, Category_ID, Seller_ID, Product_Image, Description) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$product_name, $price, $stock, $category_id, $seller_id, $imagePath, $description])) {
            $message = "Product added successfully!";
        } else {
            $message = "Error adding product.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Products</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Seller_Existingproduct.css" />
  </head>
  <body>
    <div class="container">
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

      <div class="content">
        <aside class="sidebar">
          <a href="Seller_AddProduct.php" class="active">Add Products</a>
          <a href="Seller_Listed_Products.php">Listed Products</a>
          <a href="#">Orders</a>
          <a href="#">Reviews</a>
        </aside>

        <main class="main">
          <h2>Add Products / Existing</h2>

          <?php if($message): ?>
            <p style="color: green; font-weight: bold; margin-bottom: 10px;"><?php echo $message; ?></p>
          <?php endif; ?>

          <div class="toggle">
            <label>
              <input type="radio" name="mode" checked />
              Add Product
            </label>
            <label>
              <input type="radio" name="mode" onclick="location.href='Seller_Listed_Products.php'" />
              Existing
            </label>
          </div>

          <form class="form" method="POST" enctype="multipart/form-data">
            
            <div class="select-product">
              <label>Category</label>
              <select id="categorySelect" name="category_id" required>
                <option value="" disabled selected hidden>Select a Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['category_id']; ?>">
                        <?php echo htmlspecialchars($cat['category_name']); ?>
                    </option>
                <?php endforeach; ?>
              </select>

              <label>Product Name</label>
              <input type="text" name="product_name" placeholder="Enter Product Name (e.g. Tomato)" required>

              <label>Add Stock (in KG)</label>
              <input type="number" name="stock" placeholder="Enter stock" required />

              <label>New Price</label>
              <input type="number" name="price" placeholder="Enter price" step="0.01" required />
            </div>

            <div class="upload-image">
              <label>Upload Image</label>

              <div class="upload-box">
                <label for="fileUpload" class="upload-area" id="uploadArea">
                  <div class="upload-icon"></div>
                  <p>Click to upload<br /><span>or drag & drop</span></p>
                </label>

                <input type="file" id="fileUpload" name="product_image" accept="image/*" style="display: none" required />

                <div class="preview-box" id="previewBox">
                  <img id="previewImg" src="" alt="" style="max-width: 100%; display: none;" />
                </div>
              </div>

              <button type="submit" class="add-btn">Add Product</button>
            </div>
          </form> </main>
      </div>
    </div>

    <script>
      // Cleaned up JS: Removed the old dropdown logic since we use a text input now.
      
      const fileUpload = document.getElementById("fileUpload");
      const previewImg = document.getElementById("previewImg");

      // Image Preview Logic
      fileUpload.addEventListener("change", function(event) {
          const file = event.target.files[0];
          if(file){
              const reader = new FileReader();
              reader.onload = function(e){
                  previewImg.src = e.target.result;
                  previewImg.style.display = "block";
              }
              reader.readAsDataURL(file);
          }
      });
    </script>

    <?php include 'Seller_Footer.php'; ?>
  </body>
</html>