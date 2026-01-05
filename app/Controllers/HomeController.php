<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class HomeController {
    
    public function index() {
        // 1. Security Check
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login");
            exit();
        }

        // 2. Get the User Name from Session
        // If the name is missing (e.g. old session), default to "Buyer"
        $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Buyer';

        // 3. Get Products
        $database = new Database();
        $db = $database->getConnection();
        $productModel = new ProductModel($db);

        $search = isset($_GET['search']) ? $_GET['search'] : "";
        $category = isset($_GET['category']) ? $_GET['category'] : "";

        $products = $productModel->getAllProducts($search, $category);

        // 4. Load View (Variable $user_name is automatically available in the view)
        require_once __DIR__ . '/../Views/Buyer/home.php';
    }
}
?>