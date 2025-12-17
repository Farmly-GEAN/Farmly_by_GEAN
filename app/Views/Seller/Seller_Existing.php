<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Seller_Existingproduct.css">
</head>
<body>

<div class="container">

    
    <header>
        <div class="logo"><img src="../../../public/assets/images/Logo/Team Logo.png" alt="Farmly"></div>
        <div class="profile">
        <a href="Profile.php" class="pro-btn">
    <img src="../Logo/user.png" alt="User Icon">
    
</a>
            
            <a href="#" class="logout">
                <img src="../Logo/turn-off.png" alt="Logout Icon">
            </a>
        </div>
    </header>

    <div class="content">

    
        <aside class="sidebar">
            <a href="#" class="active">Add Products</a>
            <a href="#">Listed Products</a>
            <a href="#">Orders</a>
            <a href="#">Reviews</a>
        </aside>

      
        <main class="main">
            
            <h2>Add Products / Existing</h2>

            <div class="toggle">
    <label>
        <input type="radio" name="mode" onclick="location.href='Seller_AddProduct.php'">
        Add Product
    </label>

    <label>
        <input type="radio" name="mode" checked>
        Existing
    </label>
</div>


            <div class="form">

                <div class="select-product">

    <label>Category </label>
    <select id="categorySelect" required>
        <option value="" disabled selected hidden>Select a Category</option>
        <option value="vegetables">Vegetables</option>
        <option value="fruits">Fruits</option>
        <option value="dairy">Dairy Products</option>
    </select>

    <label>Select Product</label>
    <select id="productSelect">
        <option value="" disabled selected hidden>Select a product Name</option>
    </select>

    <label>Add Stock (in KG)</label>
    <input type="number" placeholder="Enter stock">

    <label>New Price</label>
    <input type="number" placeholder="Enter price">

    <button class="add-btn">Update Product</button>
</div>

                
        </main>

    </div>
</div>
<script>

const productOptions = {
        vegetables: ["Tomato", "Potato", "Onion"],
        fruits: ["Apple", "Banana", "Mango"],
        dairy: ["Milk", "Cheese", "Butter"]
    };

    const categorySelect = document.getElementById("categorySelect");
    const productSelect = document.getElementById("productSelect");

    categorySelect.addEventListener("change", function () {

        const selectedCategory = this.value;

        productSelect.innerHTML = `<option value="" disabled selected hidden>Select a product Name</option>`;
        
        if (productOptions[selectedCategory]) {
            productOptions[selectedCategory].forEach(product => {
                const option = document.createElement("option");
                option.textContent = product;
                option.value = product.toLowerCase();
                productSelect.appendChild(option);
            });
        }
    });
</script>


<?php include 'Seller_Footer.php'; ?>

</body>
</html>