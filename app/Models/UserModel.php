<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function updateBuyerProfile($id, $name, $phone, $address) {
        $sql = "UPDATE Buyer 
                SET Buyer_Name = :name, 
                    Buyer_Phone = :phone, 
                    Buyer_Address = :address 
                WHERE Buyer_ID = :id";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':name' => $name,
            ':phone' => $phone,
            ':address' => $address,
            ':id' => $id
        ]);
    }

   
    public function updatePasswordByEmail($email, $new_password) {
        // Check if email exists first
        $checkSql = "SELECT User_ID FROM Users WHERE Email = :email";
        $stmt = $this->db->prepare($checkSql);
        $stmt->execute([':email' => $email]);
        if ($stmt->rowCount() == 0) return false;

        // Update Password
        $sql = "UPDATE Users SET Password = :pass WHERE Email = :email";
        $stmt = $this->db->prepare($sql);
    
        return $stmt->execute([':pass' => $new_password, ':email' => $email]);
    }
}
?>