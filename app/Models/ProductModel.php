<?php
class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Get all products

   public function getAllProducts() {
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available, 
                       c.Category_Name,
                       s.Seller_Name as seller_name  /* <--- ADDED THIS */
                FROM Product p
                LEFT JOIN Category c ON p.Category_ID = c.Category_ID
                LEFT JOIN Seller s ON p.Seller_ID = s.Seller_ID /* <--- ADDED JOIN */
                ORDER BY p.Product_ID DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Search products
    public function searchProducts($keyword) {
        $searchTerm = "%" . $keyword . "%";
        
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available,
                       c.Category_Name
                FROM Product p
                LEFT JOIN Category c ON p.Category_ID = c.Category_ID
                WHERE (p.Product_Name LIKE :keyword OR p.Description LIKE :keyword)
                AND p.Stocks_Available > 0";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':keyword' => $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Filter by Category
    public function getProductsByCategory($category_name) {
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available,
                       c.Category_Name
                FROM Product p
                JOIN Category c ON p.Category_ID = c.Category_ID
                WHERE c.Category_Name = :cat_name
                AND p.Stocks_Available > 0";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':cat_name' => $category_name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Check Stock (KEPT THIS ONE, REMOVED DUPLICATE AT BOTTOM)
    public function getStock($product_id) {
        $sql = "SELECT Stocks_Available FROM Product WHERE Product_ID = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        $stock = $stmt->fetchColumn(); 
        return ($stock !== false) ? $stock : 0;
    }

    // 5. Get All Categories
    public function getCategories() {
        $sql = "SELECT * FROM Category ORDER BY Category_Name ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 6. Add New Product
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
        return $row ? ($row['product_id'] ?? $row['Product_ID']) : false;
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

    // 9. Update Stock
    public function updateStock($product_id, $seller_id, $quantity, $new_price = null) {
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

    // 10. Add Gallery Images
    public function addGalleryImages($product_id, $image_paths) {
        $sql = "INSERT INTO Product_Images (Product_ID, Image_Url) VALUES (:pid, :url)";
        $stmt = $this->conn->prepare($sql);
        foreach($image_paths as $path) {
            $stmt->execute([':pid' => $product_id, ':url' => $path]);
        }
    }

    // 11. Get Gallery Images
    public function getGalleryImages($product_id) {
        $sql = "SELECT Image_Url FROM Product_Images WHERE Product_ID = :pid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // 12. Get Single Product by ID
    public function getProductById($id) {
        $sql = "SELECT p.Product_ID as product_id, 
                       p.Product_Name as product_name, 
                       p.Price as price, 
                       p.Description as description,
                       p.Product_Image as product_image, 
                       p.Stocks_Available as stocks_available,
                       c.Category_Name as category_name, 
                       s.Seller_Name as seller_name
                FROM Product p
                LEFT JOIN Category c ON p.Category_ID = c.Category_ID
                LEFT JOIN Seller s ON p.Seller_ID = s.Seller_ID
                WHERE p.Product_ID = :pid";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 13. Add a Review
    public function addReview($product_id, $buyer_id, $rating, $comment) {
        $sql = "INSERT INTO Reviews (Product_ID, Buyer_ID, Rating, Comment, Review_Date) 
                VALUES (:pid, :bid, :rating, :comment, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pid' => $product_id,
            ':bid' => $buyer_id,
            ':rating' => $rating,
            ':comment' => $comment
        ]);
    }

    // 14. Get Reviews for a Product (Renamed from getProductReviews to match Controller)
    public function getReviews($product_id) {
        $sql = "SELECT r.*, b.Name as Buyer_Name 
                FROM Reviews r 
                JOIN Users b ON r.Buyer_ID = b.User_ID 
                WHERE r.Product_ID = :pid 
                ORDER BY r.Review_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 15. Check if User Already Reviewed
    public function hasReviewed($product_id, $buyer_id) {
        $sql = "SELECT * FROM Reviews WHERE Product_ID = :pid AND Buyer_ID = :bid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id, ':bid' => $buyer_id]);
        return $stmt->rowCount() > 0;
    }

    // 16. Get Seller Reviews (RESTORED - Needed for Seller Dashboard)
    public function getSellerReviews($seller_id) {
        $sql = "SELECT 
                    r.*, 
                    p.Product_Name, 
                    p.Product_Image, 
                    b.Name AS Buyer_Name 
                FROM Reviews r
                JOIN Product p ON r.Product_ID = p.Product_ID
                JOIN Users b ON r.Buyer_ID = b.User_ID
                WHERE p.Seller_ID = :sid
                ORDER BY r.Review_Date DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 18. Update Product Details
    public function updateProductDetails($product_id, $seller_id, $name, $description, $price, $stock, $category_id, $image_path = null) {
        if ($image_path) {
            $sql = "UPDATE Product 
                    SET Product_Name = :name, 
                        Description = :desc, 
                        Price = :price,
                        Stocks_Available = :stock,
                        Category_ID = :cat, 
                        Product_Image = :img 
                    WHERE Product_ID = :pid AND Seller_ID = :sid";
            $params = [
                ':name' => $name,
                ':desc' => $description,
                ':price' => $price,
                ':stock' => $stock,
                ':cat' => $category_id,
                ':img' => $image_path,
                ':pid' => $product_id,
                ':sid' => $seller_id
            ];
        } else {
            $sql = "UPDATE Product 
                    SET Product_Name = :name, 
                        Description = :desc, 
                        Price = :price,
                        Stocks_Available = :stock,
                        Category_ID = :cat 
                    WHERE Product_ID = :pid AND Seller_ID = :sid";
            $params = [
                ':name' => $name,
                ':desc' => $description,
                ':price' => $price,
                ':stock' => $stock,
                ':cat' => $category_id,
                ':pid' => $product_id,
                ':sid' => $seller_id
            ];
        }
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

} // End of Class
?>