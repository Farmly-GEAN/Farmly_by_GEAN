<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Update Buyer Profile
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
}
?>