<?php
class ReviewModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. Get All Reviews for a specific Product
    public function getReviewsByProduct($product_id) {
        // Updated to select 'Comment' as 'Review_Text' so the View doesn't break
        $sql = "SELECT r.Review_ID, r.Product_ID, r.Buyer_ID, r.Rating, 
                       r.Comment AS Review_Text, r.Review_Date, 
                       b.Buyer_Name 
                FROM Reviews r 
                JOIN Buyer b ON r.Buyer_ID = b.Buyer_ID 
                WHERE r.Product_ID = :pid 
                ORDER BY r.Review_Date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':pid' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Add a New Review (FIXED COLUMN NAME)
    public function addReview($product_id, $buyer_id, $rating, $comment) {
        // Changed 'Review_Text' to 'Comment'
        $sql = "INSERT INTO Reviews (Product_ID, Buyer_ID, Rating, Comment, Review_Date) 
                VALUES (:pid, :bid, :rating, :text, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':pid' => $product_id,
            ':bid' => $buyer_id,
            ':rating' => $rating,
            ':text' => $comment
        ]);
    }

    // 3. Get Seller Reviews (For Dashboard)
    public function getSellerReviews($seller_id) {
        // Updated to select 'Comment' as 'Review_Text'
        $sql = "SELECT r.Review_ID, r.Rating, r.Comment AS Review_Text, r.Review_Date,
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