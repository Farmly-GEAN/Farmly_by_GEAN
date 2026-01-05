<?php
class ProductModel {
    private $conn;
    private $table = "Product";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllProducts($search = "", $category = "") {
        // Basic query
        $sql = "SELECT p.*, c.Category_Name 
                FROM " . $this->table . " p
                LEFT JOIN Category c ON p.Category_ID = c.Category_ID
                WHERE p.Stocks_Available > 0";
        
        $params = [];

        // Add Search Filter
        if (!empty($search)) {
            $sql .= " AND p.Product_Name ILIKE ?";
            $params[] = "%$search%";
        }

        // Add Category Filter
        if (!empty($category)) {
            $sql .= " AND c.Category_Name = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY p.Product_ID DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
?>