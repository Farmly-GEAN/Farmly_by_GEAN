<?php
class SellerModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

  
    // AUTHENTICATION FUNCTIONS
   

    // 1. Register Seller
    public function register($name, $email, $phone, $address, $password, $imagePath = null) {
        
      
        $checkSql = "SELECT Seller_ID FROM Seller WHERE Seller_Email = :email";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->execute([':email' => $email]);
        
        if ($stmt->fetch()) {
            return false; 
        }

        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $sql = "INSERT INTO Seller (Seller_Name, Seller_Email, Seller_Phone_Number, Seller_Address, Seller_Password, Seller_Image_Url) 
                VALUES (:name, :email, :phone, :addr, :pass, :img)";
        
        $stmt = $this->conn->prepare($sql);
        
        return $stmt->execute([
            ':name'   => $name,
            ':email'  => $email,
            ':phone'  => $phone,
            ':addr'   => $address,
            ':pass'   => $hashed_password,
            ':img'    => $imagePath 
        ]);
    }

    // 2. Login Seller 
    public function login($email, $password) {
        $sql = "SELECT * FROM Seller WHERE Seller_Email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($seller) {
            
            $db_password = $seller['Seller_Password'] 
                        ?? $seller['seller_password'] 
                        ?? $seller['Password'] 
                        ?? $seller['password'] 
                        ?? null;

            if ($db_password && password_verify($password, $db_password)) {
                return $seller;
            }
        }
        return false;
    }

   
    // DASHBOARD STATS FUNCTIONS
    
    public function getTotalEarnings($seller_id) {
        $sql = "SELECT SUM(od.Quantity * od.Price_Per_Unit) as total
                FROM Order_Details od
                JOIN Product p ON od.Product_ID = p.Product_ID
                JOIN Orders o ON od.Order_ID = o.Order_ID
                WHERE p.Seller_ID = :sid AND o.Order_Status != 'Cancelled'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchColumn() ?: 0;
    }

    // 4. Get Total Orders Count
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

    // 5. Get Total Products Count
    public function getTotalProductsCount($seller_id) {
        $sql = "SELECT COUNT(*) FROM Product WHERE Seller_ID = :sid";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchColumn();
    }

  
    // PROFILE & REVIEWS FUNCTIONS
    

    // 6. Get Seller Profile
    public function getSellerById($id) {
        $sql = "SELECT * FROM Seller WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 7. Update Profile
    public function updateProfile($id, $name, $phone, $address) {
        $sql = "UPDATE Seller SET Seller_Name = :name, Seller_Phone = :phone, Seller_Address = :addr WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':name' => $name, ':phone' => $phone, ':addr' => $address, ':id' => $id]);
    }
    
    // 8. Get Reviews
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

    public function updatePasswordByEmail($email, $new_password) {
        $checkSql = "SELECT Seller_ID FROM Seller WHERE Email = :email";
        $stmt = $this->db->prepare($checkSql);
        $stmt->execute([':email' => $email]);
        if ($stmt->rowCount() == 0) return false;

        $sql = "UPDATE Seller SET Password = :pass WHERE Email = :email";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':pass' => $new_password, ':email' => $email]);
    }
}
?>