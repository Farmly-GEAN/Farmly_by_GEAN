<?php
class SellerModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ... (Keep existing functions like registerSeller, loginSeller, etc.) ...

    // 1. Get Total Earnings
    public function getTotalEarnings($seller_id) {
        // Sums up total amount of orders that contain this seller's products
        // Note: In a real complex app, we'd split order totals by product, but this is a good approximation for now
        $sql = "SELECT SUM(od.Quantity * od.Price_Per_Unit) as total
                FROM Order_Details od
                JOIN Product p ON od.Product_ID = p.Product_ID
                JOIN Orders o ON od.Order_ID = o.Order_ID
                WHERE p.Seller_ID = :sid AND o.Order_Status != 'Cancelled'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchColumn() ?: 0;
    }

    // 2. Get Total Orders Count
    public function getTotalOrdersCount($seller_id) {
        $sql = "SELECT COUNT(DISTINCT o.Order_ID) 
                FROM Orders o
                JOIN Order_Details od ON o.Order_ID = od.Order_ID
                JOIN Product p ON od.Product_ID = p.Product_ID
                WHERE p.Seller_ID = :sid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchColumn();
    }

    // 3. Get Total Products Count
    public function getTotalProductsCount($seller_id) {
        $sql = "SELECT COUNT(*) FROM Product WHERE Seller_ID = :sid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchColumn();
    }

    // 4. Get Seller Profile (Existing)
    public function getSellerById($id) {
        $sql = "SELECT * FROM Seller WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 5. Update Profile (Existing)
    public function updateProfile($id, $name, $phone, $address) {
        $sql = "UPDATE Seller SET Seller_Name = :name, Seller_Phone = :phone, Seller_Address = :addr WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':name' => $name, ':phone' => $phone, ':addr' => $address, ':id' => $id]);
    }
    
    // 6. Get Reviews (Existing)
    public function getSellerReviews($seller_id) {
        $sql = "SELECT r.*, p.Product_Name, b.Buyer_Name 
                FROM Reviews r
                JOIN Product p ON r.Product_ID = p.Product_ID
                JOIN Buyer b ON r.Buyer_ID = b.Buyer_ID
                WHERE p.Seller_ID = :sid
                ORDER BY r.Review_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>