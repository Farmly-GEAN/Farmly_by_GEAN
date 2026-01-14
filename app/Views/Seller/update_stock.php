<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Stock & Price - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/Seller_Dashboard.css">
</head>
<body>
<div class="container">
    <?php include __DIR__ . '/Seller_Header.php'; ?>
    
    <div class="content">
        <?php include __DIR__ . '/Seller_Sidebar.php'; ?>

        <main class="main">
            <h2>Update Stock / Price</h2>
            
            <?php if(isset($_GET['success'])): ?>
                <p style="color:green; font-weight:bold; margin-bottom:15px;"><?php echo htmlspecialchars($_GET['success']); ?></p>
            <?php elseif(isset($_GET['error'])): ?>
                <p style="color:red; font-weight:bold; margin-bottom:15px;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>

            <div class="toggle">
                <label><input type="radio" name="mode" onclick="location.href='index.php?page=seller_dashboard'"> Add Product</label>
                <label><input type="radio" name="mode" checked> Existing</label>
            </div>

            <form class="form" method="POST" action="index.php?page=seller_update_stock_action">
                <div class="select-product">
                    
                    <label>Filter by Category</label>
                    <select id="categorySelect" onchange="filterProducts()">
                        <option value="all">All Categories</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat['category_id']; ?>">
                                    <?php echo htmlspecialchars($cat['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>

                    <label>Select Product</label>
                    <select name="product_id" id="productSelect" required disabled>
                        <option value="" disabled selected hidden>First select a category...</option>
                    </select>

                    <label>Add Stock Quantity (kg)</label>
                    <input type="number" name="stock" placeholder="e.g. 50" required min="1">

                    <label>New Price (Optional)</label>
                    <input type="number" name="new_price" step="0.01" placeholder="Leave empty to keep current price">
                    
                    <button type="submit" class="add-btn">Update Product</button>
                </div>
            </form>
        </main>
    </div>
</div>
<?php include __DIR__ . '/Seller_Footer.php'; ?>

<script>
    const allProducts = <?php echo json_encode($products); ?>;

    function filterProducts() {
        const catSelect = document.getElementById("categorySelect");
        const prodSelect = document.getElementById("productSelect");
        const selectedCatID = catSelect.value;

        prodSelect.innerHTML = '<option value="" disabled selected hidden>Choose a product...</option>';
        
        let hasProducts = false;

        allProducts.forEach(product => {
            
            let pid = product.product_id || product.Product_ID;
            let catId = product.category_id || product.Category_ID;
            let pname = product.product_name || product.Product_Name;
            let pstock = product.stocks_available || product.Stocks_Available;
            let pprice = product.price || product.Price;

            if (selectedCatID === 'all' || catId == selectedCatID) {
                let option = document.createElement("option");
                option.value = pid;
                
                option.text = `${pname} (Stock: ${pstock}kg | Price: $${pprice})`;
                
                prodSelect.appendChild(option);
                hasProducts = true;
            }
        });

        if (hasProducts) {
            prodSelect.disabled = false;
        } else {
            let option = document.createElement("option");
            option.text = "No products in this category";
            prodSelect.add(option);
            prodSelect.disabled = true;
        }
    }

    window.onload = filterProducts;
</script>

</body>
</html>