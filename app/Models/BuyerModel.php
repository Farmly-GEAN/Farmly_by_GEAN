<?php
class BuyerModel {
    private $conn;
    private $table_name = "Buyer";

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Find a buyer by email
    public function getBuyerByEmail($email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE Buyer_Email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    // 2. Create a new buyer 
    public function createBuyer($name, $email, $phone, $address, $password, $gender, $state, $city) {
        $sql = "INSERT INTO " . $this->table_name . " 
                (Buyer_Name, Buyer_Email, Buyer_Phone, Buyer_Address, Buyer_Password, Gender, State, City) 
                VALUES (:name, :email, :phone, :address, :password, :gender, :state, :city)";
        
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':state', $state);
        $stmt->bindParam(':city', $city);

        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>