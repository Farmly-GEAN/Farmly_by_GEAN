<?php
class AdminModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Admin Login
    public function login($email, $password) {
        $sql = "SELECT * FROM Admin WHERE Admin_Email = :email AND Admin_Password = :pass";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email, ':pass' => $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Get Dashboard Stats (The function causing errors previously)
    public function getDashboardStats() {
        $stats = [];

        // Total Sales (Sum of Total_Amount)
        $sql = "SELECT SUM(Total_Amount) as total_sales FROM Orders";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['total_sales'] = $row['total_sales'] ?? 0;

        // Total Orders Count
        $sql = "SELECT COUNT(*) as total_orders FROM Orders";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['total_orders'] = $row['total_orders'] ?? 0;

        // Total Products Count
        $sql = "SELECT COUNT(*) as total_products FROM Product";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $stats['total_products'] = $row['total_products'] ?? 0;

        // Total Users (Buyers + Sellers)
        $sqlBuyer = "SELECT COUNT(*) as c FROM Buyer";
        $sqlSeller = "SELECT COUNT(*) as c FROM Seller";
        
        $stmtB = $this->conn->query($sqlBuyer);
        $stmtS = $this->conn->query($sqlSeller);
        
        $buyerCount = $stmtB->fetch(PDO::FETCH_ASSOC)['c'] ?? 0;
        $sellerCount = $stmtS->fetch(PDO::FETCH_ASSOC)['c'] ?? 0;
        
        $stats['total_users'] = $buyerCount + $sellerCount;

        return $stats;
    }

    // 3. Get All Sellers
    public function getAllSellers() {
        $sql = "SELECT * FROM Seller ORDER BY Seller_ID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Delete Seller
    public function deleteSeller($id) {
        $sql = "DELETE FROM Seller WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // 5. Get All Buyers
    public function getAllBuyers() {
        $sql = "SELECT * FROM Buyer ORDER BY Buyer_ID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 6. Delete Buyer
    public function deleteBuyer($id) {
        $sql = "DELETE FROM Buyer WHERE Buyer_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // 7. Get All Products (with Seller Name)
    public function getAllProducts() {
        $sql = "SELECT p.*, s.Seller_Name 
                FROM Product p 
                JOIN Seller s ON p.Seller_ID = s.Seller_ID 
                ORDER BY p.Product_ID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 8. Delete Product
    public function deleteProduct($id) {
        $sql = "DELETE FROM Product WHERE Product_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // 9. Get All Orders
    public function getAllOrders() {
        $sql = "SELECT o.*, b.Buyer_Name 
                FROM Orders o 
                JOIN Buyer b ON o.Buyer_ID = b.Buyer_ID 
                ORDER BY o.Order_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?> 