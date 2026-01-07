<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Fetch all products
    public function getAllProducts() {
        // MATCHES DB: Stocks_Available
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

    // 4. Check Stock (Used by OrderController)
    public function getStock($product_id) {
        // MATCHES DB: Stocks_Available
        $sql = "SELECT Stocks_Available FROM Product WHERE Product_ID = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Return 0 if product not found, otherwise return the integer value
        return $row ? $row['stocks_available'] : 0;
    }
}
?>