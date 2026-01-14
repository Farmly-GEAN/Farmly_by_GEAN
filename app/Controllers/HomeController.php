<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class HomeController {
    private $db;
    private $productModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        // 1. FIX: Define $user_name here so the View can use it
        $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
        $buyer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // 2. Fetch Products
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $products = [];

        if ($search) {
            $products = $this->productModel->searchProducts($search);
        } elseif ($category) {
            $products = $this->productModel->getProductsByCategory($category);
        } else {
            $products = $this->productModel->getAllProducts();
        }

        // 3. Load the View
        require_once __DIR__ . '/../Views/Buyer/home.php';
    }
}
?>