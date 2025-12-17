<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Products</title>
<<<<<<< HEAD
    <link
      rel="stylesheet"
      href="../../../public/assets/CSS/Seller_Existingproduct.css"
    />
  </head>
  <body>
    <div class="container">
      <header>
        <div class="logo">
          <img
            src="../../../public/assets/images/Logo/Team Logo.png"
            alt="Farmly"
          />
=======
    <link rel="stylesheet" href="../../Seller_Farmly/CSS/Seller_Existing.css">
</head>
<body>

<div class="container">

    <header>
        <div class="logo"><img src="../../Seller_Farmly/Logo/Team Logo.png" alt="Farmly"></div>
        <div class="profile">
            <a href="Profile.php" class="pro-btn">
                <img src="../../Seller_Farmly/Logo/user.png" alt="User Icon">
            </a>
            <a href="#" class="logout">Logout</a>
>>>>>>> 29d0550fdb0e59dd08d870924d59062b4ea16b19
        </div>
        <div class="profile">
          <a href="Profile.php" class="pro-btn">
            <img src="../Logo/user.png" alt="User Icon" />
          </a>
          <a href="#" class="logout">Logout</a>
        </div>
      </header>

      <div class="content">
        <aside class="sidebar">
<<<<<<< HEAD
          <a href="Seller_AddProduct.php" class="active">Add Products</a>
          <a href="Seller_Existing.php">Listed Products</a>
          <a href="#">Orders</a>
          <a href="#">Reviews</a>
=======
            <a href="Seller_AddProduct.php" class="active">Add Products</a>
            <a href="Seller_Existing.php">Listed Products</a>
            <a href="">Orders</a>
            <a href="Seller_Reviews.php">Reviews</a>
>>>>>>> 29d0550fdb0e59dd08d870924d59062b4ea16b19
        </aside>

        <main class="main">
          <h2>Add Products / Existing</h2>

<<<<<<< HEAD
          <!-- FIXED TOGGLE -->
          <div class="toggle">
            <label>
              <input type="radio" name="mode" checked />
              Add Product
            </label>

            <label>
              <input
                type="radio"
                name="mode"
                onclick="location.href='Seller_Existing.php'"
              />
              Existing
            </label>
          </div>

          <div class="form">
            <div class="select-product">
              <label>Category</label>
              <select id="categorySelect">
                <option value="" disabled selected hidden>
                  Select a Category
                </option>
                <option value="vegetables">Vegetables</option>
                <option value="fruits">Fruits</option>
                <option value="dairy">Dairy Products</option>
              </select>

              <label>Select Product</label>
              <select id="productSelect">
                <option value="" disabled selected hidden>
                  Select a product Name
                </option>
              </select>

              <label>Add Stock (in KG)</label>
              <input type="number" placeholder="Enter stock" />

              <label>New Price</label>
              <input type="number" placeholder="Enter price" />
=======
            <div class="toggle">
    <label>
        <input type="radio" name="mode" checked>
        Add Product
    </label>

    <label>
        <input type="radio" name="mode" onclick="location.href='Seller_Existing.php'">
        Existing
    </label>
</div>
<form method="POST" action="/seller/product/add" enctype="multipart/form-data">

            <div class="form">
                <div class="select-product">
                    <label>Category</label>
                    <select name="category">
                        <option value="" disabled selected hidden>Select a Category</option>
                        <option value="vegetables">Vegetables</option>
                        <option value="fruits">Fruits</option>
                        <option value="dairy">Dairy Products</option>
                    </select>

                    <label>Select Product</label>
                    <select name="product_name">
                        <option value="" disabled selected hidden>Select a product Name</option>
                    </select>

                    <label>Add Stock (in KG)</label>
                    <input type="number" name="stock">

                    <label>New Price</label>
                    <input type="number" name="price">
                </div>

                <div class="upload-image">
                    <label>Upload Image</label>

                    <div class="upload-box">
                        <label for="fileUpload" class="upload-area" id="uploadArea">
                            <div class="upload-icon"></div>
                            <p>Click to upload<br><span>or drag & drop</span></p>
                        </label>

                        <input type="file" name="product_image">

                        <div class="preview-box" id="previewBox">
                            <img id="previewImg" src="" alt="" style="max-width:100%">
                        </div>
                    </div>

                    <button class="add-btn">Add Product</button>
                </div>
>>>>>>> 29d0550fdb0e59dd08d870924d59062b4ea16b19
            </div>

            <div class="upload-image">
              <label>Upload Image</label>

              <div class="upload-box">
                <label for="fileUpload" class="upload-area" id="uploadArea">
                  <div class="upload-icon"></div>
                  <p>Click to upload<br /><span>or drag & drop</span></p>
                </label>

                <input
                  type="file"
                  id="fileUpload"
                  accept="image/*"
                  style="display: none"
                />

                <div class="preview-box" id="previewBox">
                  <img id="previewImg" src="" alt="" style="max-width: 100%" />
                </div>
              </div>

              <button class="add-btn">Add Product</button>
            </div>
          </div>
        </main>
      </div>
    </div>

    <script>
      const productOptions = {
        vegetables: ["Tomato", "Potato", "Onion"],
        fruits: ["Apple", "Banana", "Mango"],
        dairy: ["Milk", "Cheese", "Butter"],
      };

      const categorySelect = document.getElementById("categorySelect");
      const productSelect = document.getElementById("productSelect");

      categorySelect.addEventListener("change", function () {
        const selectedCategory = this.value;

        productSelect.innerHTML = `<option value="" disabled selected hidden>Select a product Name</option>`;

        if (productOptions[selectedCategory]) {
          productOptions[selectedCategory].forEach((product) => {
            const option = document.createElement("option");
            option.textContent = product;
            option.value = product.toLowerCase();
            productSelect.appendChild(option);
          });
        }
      });
    </script>

<<<<<<< HEAD
    <?php include 'Seller_Footer.php'; ?>
  </body>
=======
<?php include '../../Seller_Farmly/Header_Footer/Footer.php'; ?>

</body>
>>>>>>> 29d0550fdb0e59dd08d870924d59062b4ea16b19
</html>
