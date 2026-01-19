<?php
class PageModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // ========================
    // USER ACTIONS 
    // ========================

    // 1. Save Contact Us Message
    public function saveContactMessage($name, $email, $subject, $message) {
        // FIX: Table name is 'Contact' (not Contact_Messages)
        $sql = "INSERT INTO Contact (Name, Email, Subject, Message, Status) 
                VALUES (:name, :email, :subject, :msg, 'New')";
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
        // FIX: Table name is 'Feedback' (not Platform_Feedback)
        $sql = "INSERT INTO Feedback (User_ID, User_Type, Subject, Message, Status) 
                VALUES (:uid, :utype, :subj, :msg, 'New')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':uid' => $user_id, 
            ':utype' => $user_type, 
            ':subj' => $subject, 
            ':msg' => $message
        ]);
    }

    // ========================
    // ADMIN ACTIONS 
    // ========================

    // 3. Get All Contact Messages
    public function getAllContactMessages() {
        // FIX: Table name is 'Contact'
        $sql = "SELECT * FROM Contact ORDER BY Created_At DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Get All Feedbacks
    public function getAllFeedbacks() {
        // FIX: Table name is 'Feedback'
        $sql = "SELECT * FROM Feedback ORDER BY Created_At DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function submitFeedback($user_id, $name, $role, $subject, $message) {
        $sql = "INSERT INTO Feedback (User_ID, User_Name, User_Role, Subject, Message) 
                VALUES (:uid, :name, :role, :sub, :msg)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':uid'  => $user_id,
            ':name' => $name,
            ':role' => $role,
            ':sub'  => $subject,
            ':msg'  => $message
        ]);
    }

    // ========================
    // FAQ and TERMS
    // ========================

    // 1. Fetch Site Settings
    public function getSetting($key) {
        // FIX: Changed '$this->conn' to '$this->db'
        $stmt = $this->db->prepare("SELECT Setting_Value FROM Site_Settings WHERE Setting_Key = :key");
        $stmt->execute([':key' => $key]);
        return $stmt->fetchColumn(); 
    }

    // 2. Fetch All FAQs for the Public Page
    public function getPublicFAQs() {
        // FIX: Changed '$this->conn' to '$this->db'
        $stmt = $this->db->query("SELECT Question, Answer FROM FAQ ORDER BY Created_At ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFAQsByGroup($group) {
        // FIX: Changed '$this->conn' to '$this->db'
        $sql = "SELECT Question, Answer FROM FAQ 
                WHERE Target_Group = :group OR Target_Group = 'General' 
                ORDER BY Created_At ASC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':group' => $group]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllFAQs() {
        // Fetch all FAQs ordered by newest first
        $stmt = $this->db->query("SELECT * FROM FAQ ORDER BY Created_At DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    // BUYER INBOX
    

    
    public function getMessagesByEmail($email) {
        // We use LOWER() to ensure case doesn't matter (e.g. User@test.com == user@test.com)
        $sql = "SELECT * FROM Contact 
                WHERE LOWER(Email) = LOWER(:e) 
                ORDER BY Created_At DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':e' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>