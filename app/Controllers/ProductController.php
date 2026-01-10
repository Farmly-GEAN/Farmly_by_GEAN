<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/ProductModel.php';

class ProductController {
    private $db;
    private $productModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new ProductModel($this->db);
        
        // Ensure session is started to access User Name
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 1. Show Product List (Shop Page)
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
            $id = $_GET['id'];

            // A. Get Main Product Data
            $product = $this->productModel->getProductById($id);

            // B. Get Gallery Images
            $gallery = $this->productModel->getGalleryImages($id);
            
            // C. NEW: Get Reviews
            $reviews = $this->productModel->getProductReviews($id);
            
            // Pass User Name here too
            $user_name = $_SESSION['user_name'] ?? 'Guest';

            if ($product) {
                // Determine the correct view file path
                if (file_exists(__DIR__ . '/../Views/Buyer/product_detail.php')) {
                    require_once __DIR__ . '/../Views/Buyer/product_detail.php';
                } elseif (file_exists(__DIR__ . '/../Views/Buyer/product_details.php')) {
                    require_once __DIR__ . '/../Views/Buyer/product_details.php';
                } else {
                    echo "Error: Product Detail View file not found.";
                }
            } else {
                echo "<h1>Product not found</h1>";
            }
        } else {
            header("Location: index.php?page=home");
            exit();
        }
    }

    // 3. Submit Review (NEW FUNCTION)
    public function submitReview() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $buyer_id   = $_SESSION['user_id'];
            $rating     = $_POST['rating'];
            $comment    = $_POST['comment'];

            // Prevent duplicates if needed, otherwise just add
            if (!$this->productModel->hasReviewed($product_id, $buyer_id)) {
                $this->productModel->addReview($product_id, $buyer_id, $rating, $comment);
            }

            // Redirect back to product details
            header("Location: index.php?page=product_detail&id=" . $product_id);
            exit();
        }
    }
}
?>