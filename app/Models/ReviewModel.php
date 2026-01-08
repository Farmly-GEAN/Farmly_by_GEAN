<?php
class ReviewModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSellerReviews($seller_id) {
        $sql = "SELECT r.comment, p.Product_Name, b.Buyer_Name 
                FROM Review r
                JOIN Product p ON r.Product_ID = p.Product_ID
                JOIN Buyer b ON r.Buyer_ID = b.Buyer_ID
                WHERE r.Seller_ID = :sid
                ORDER BY r.Review_ID DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':sid' => $seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>