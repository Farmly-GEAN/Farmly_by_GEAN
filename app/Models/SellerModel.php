<?php
class SellerModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Register (Your existing code)
    public function register($name, $email, $password, $phone, $address, $image_url) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO Seller (Seller_Name, Seller_Email, Seller_Password, Seller_Phone_Number, Seller_Address, Seller_Image_Url) 
                VALUES (:name, :email, :pass, :phone, :address, :img)";
        
        $stmt = $this->conn->prepare($sql);
        try {
            return $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':pass' => $hashed_password,
                ':phone' => $phone,
                ':address' => $address,
                ':img' => $image_url
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // 2. Login (Your existing code)
    public function login($email, $password) {
        $sql = "SELECT * FROM Seller WHERE Seller_Email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $seller = $stmt->fetch(PDO::FETCH_ASSOC);

        // Note: Array keys usually match DB column case or are lowercase depending on PDO settings.
        // We check both just in case.
        $db_pass = $seller['Seller_Password'] ?? $seller['seller_password'];

        if ($seller && password_verify($password, $db_pass)) {
            return $seller;
        }
        return false;
    }

    // 3. Get Seller Details by ID (NEW - For Profile Page)
    public function getSellerById($id) {
        $sql = "SELECT * FROM Seller WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Update Profile (NEW - Updates Name, Phone, Address)
    public function updateProfile($id, $name, $phone, $address) {
        $sql = "UPDATE Seller 
                SET Seller_Name = :name, 
                    Seller_Phone_Number = :phone, 
                    Seller_Address = :address 
                WHERE Seller_ID = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':address' => $address,
            ':id' => $id
        ]);
    }

    // 5. Change Password (Optional - Good for security)
    public function updatePassword($id, $new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE Seller SET Seller_Password = :pass WHERE Seller_ID = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pass' => $hashed_password, 
            ':id' => $id
        ]);
    }

    // 6. Get All Reviews for this Seller's Products
    public function getSellerReviews($seller_id) {
        $sql = "SELECT r.Rating, r.Comment, r.Review_Date, 
                       p.Product_Name, b.Buyer_Name 
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