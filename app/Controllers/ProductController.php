<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Models/ReviewModel.php'; 
require_once __DIR__ . '/../Models/OrderModel.php';  

class ProductController {
    private $db;
    private $productModel;
    private $reviewModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->productModel = new ProductModel($this->db);
        $this->reviewModel = new ReviewModel($this->db);
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 1. Show Product List
    public function index() {
        if (isset($_GET['search'])) {
            $products = $this->productModel->searchProducts($_GET['search']);
        } elseif (isset($_GET['category'])) {
            $products = $this->productModel->getProductsByCategory($_GET['category']);
        } else {
            $products = $this->productModel->getAllProducts();
        }

        $user_name = $_SESSION['user_name'] ?? 'Guest';
        require_once __DIR__ . '/../Views/Buyer/home.php';
    }

    // 2. Show Single Product Detail
    public function detail() {
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];

           
            $product = $this->productModel->getProductById($product_id);
            
            if (!$product) {
                echo "<h1>Product not found</h1>";
                return;
            }

            $gallery = $this->productModel->getGalleryImages($product_id);
    
            $reviews = $this->reviewModel->getReviewsByProduct($product_id);

            $can_review = false;
            if (isset($_SESSION['user_id'])) {
                $orderModel = new OrderModel($this->db);
                $can_review = $orderModel->hasPurchased($_SESSION['user_id'], $product_id);
            }

            $user_name = $_SESSION['user_name'] ?? 'Guest';
            require_once __DIR__ . '/../Views/Buyer/product_details.php';
            
        } else {
            header("Location: index.php?page=home");
            exit();
        }
    }

    // 3. Submit Review
    public function submitReview() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) { 
            header("Location: index.php?page=login"); 
            exit(); 
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $buyer_id   = $_SESSION['user_id'];
            $rating     = $_POST['rating'];
            $comment    = $_POST['comment'];

            if ($this->reviewModel->addReview($product_id, $buyer_id, $rating, $comment)) {
                header("Location: index.php?page=product_detail&id=$product_id&success=Review Posted!");
            } else {
                header("Location: index.php?page=product_detail&id=$product_id&error=Failed to post review");
            }
            exit();
        }
    }
}
?>