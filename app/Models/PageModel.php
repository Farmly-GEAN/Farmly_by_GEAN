<?php
class PageModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // --- USER ACTIONS ---

    // 1. Save Contact Us Message
    public function saveContactMessage($name, $email, $subject, $message) {
        $sql = "INSERT INTO Contact_Messages (Name, Email, Subject, Message) 
                VALUES (:name, :email, :subject, :msg)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':name' => $name, 
            ':email' => $email, 
            ':subject' => $subject, 
            ':msg' => $message
        ]);
    }

    // 2. Save Feedback/Complaint
    public function saveFeedback($user_id, $user_type, $subject, $message) {
        $sql = "INSERT INTO Platform_Feedback (User_ID, User_Type, Subject, Message) 
                VALUES (:uid, :utype, :subj, :msg)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':uid' => $user_id, 
            ':utype' => $user_type, 
            ':subj' => $subject, 
            ':msg' => $message
        ]);
    }

    // --- ADMIN ACTIONS ---

    // 3. Get All Contact Messages
    public function getAllContactMessages() {
        $sql = "SELECT * FROM Contact_Messages ORDER BY Created_At DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Get All Feedbacks
    public function getAllFeedbacks() {
        $sql = "SELECT * FROM Platform_Feedback ORDER BY Created_At DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>