<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Fetch all products
    public function getAllProducts() {
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available, 
                       c.Category_Name 
                FROM Product p
                LEFT JOIN Category c ON p.Category_ID = c.Category_ID";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Search products
    public function searchProducts($keyword) {
        $sql = "SELECT Product_ID as product_id, 
                       Product_Name as product_name, 
                       Price as price, 
                       Product_Image as product_image, 
                       Stocks_Available as stocks_available 
                FROM Product 
                WHERE Product_Name LIKE :keyword";
        
        $stmt = $this->conn->prepare($sql);
        $keyword = "%{$keyword}%";
        $stmt->execute([':keyword' => $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Filter by Category
    public function getProductsByCategory($category_name) {
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available 
                FROM Product p
                JOIN Category c ON p.Category_ID = c.Category_ID
                WHERE c.Category_Name = :cat_name";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cat_name' => $category_name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Check Stock (FIXED to prevent capitalization errors)
    public function getStock($product_id) {
        $sql = "SELECT Stocks_Available FROM Product WHERE Product_ID = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        
        // fetchColumn() gets the value directly, ignoring column name case
        $stock = $stmt->fetchColumn(); 
        
        // If stock is false (product not found), return 0. Otherwise return the number.
        return ($stock !== false) ? $stock : 0;
    }

    // 5. Get All Categories
    public function getCategories() {
        $sql = "SELECT * FROM Category ORDER BY Category_Name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 6. Add New Product (Returns ID)
    public function addProduct($seller_id, $category_id, $name, $stock, $price, $image_path, $description) {
        $sql = "INSERT INTO Product (Product_Name, Price, Stocks_Available, Category_ID, Seller_ID, Product_Image, Description) 
                VALUES (:name, :price, :stock, :cat_id, :sid, :img, :desc) RETURNING Product_ID";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':price' => $price,
            ':stock' => $stock,
            ':cat_id' => $category_id,
            ':sid' => $seller_id,
            ':img' => $image_path,
            ':desc' => $description
        ]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Postgres returns 'product_id', ensure capitalization matches your DB driver (usually lowercase)
        return $row ? $row['product_id'] : false;
    }

    // 7. Get Products by Seller
    public function getProductsBySeller($seller_id) {
        $sql = "SELECT * FROM Product WHERE Seller_ID = :sid ORDER BY Product_ID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 8. Delete Product
    public function deleteProduct($product_id, $seller_id) {
        $sql = "DELETE FROM Product WHERE Product_ID = :pid AND Seller_ID = :sid";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pid' => $product_id, ':sid' => $seller_id]);
    }

   // 9. Update Stock (AND optionally Price)
    public function updateStock($product_id, $seller_id, $quantity, $new_price = null) {
        // Build SQL dynamically based on whether Price is provided
        if ($new_price !== null && $new_price !== '') {
            $sql = "UPDATE Product 
                    SET Stocks_Available = Stocks_Available + :qty, 
                        Price = :price 
                    WHERE Product_ID = :pid AND Seller_ID = :sid";
            
            $params = [
                ':qty' => $quantity,
                ':price' => $new_price,
                ':pid' => $product_id,
                ':sid' => $seller_id
            ];
        } else {
            // Standard Stock Update (Price stays the same)
            $sql = "UPDATE Product 
                    SET Stocks_Available = Stocks_Available + :qty 
                    WHERE Product_ID = :pid AND Seller_ID = :sid";
            
            $params = [
                ':qty' => $quantity,
                ':pid' => $product_id,
                ':sid' => $seller_id
            ];
        }

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // 10. Add Gallery Images (For Seller)
    public function addGalleryImages($product_id, $image_paths) {
        $sql = "INSERT INTO Product_Images (Product_ID, Image_Url) VALUES (:pid, :url)";
        $stmt = $this->conn->prepare($sql);
        
        foreach($image_paths as $path) {
            $stmt->execute([':pid' => $product_id, ':url' => $path]);
        }
    }

    // 11. Get Gallery Images (For Buyer & Seller)
    public function getGalleryImages($product_id) {
        $sql = "SELECT Image_Url FROM Product_Images WHERE Product_ID = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // 12. Get Single Product by ID (NEW - For Detail Page)
    public function getProductById($id) {
        // Fetch product + category name + seller name
        // Use aliases (as product_id, etc.) if your view expects specific keys
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Description as description,
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available,
                       c.Category_Name, 
                       s.Seller_Name 
                FROM Product p
                LEFT JOIN Category c ON p.Category_ID = c.Category_ID
                LEFT JOIN Seller s ON p.Seller_ID = s.Seller_ID
                WHERE p.Product_ID = :pid";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>