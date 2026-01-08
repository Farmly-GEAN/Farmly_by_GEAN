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
    }

    // 1. Show Product List (Shop Page)
    public function index() {
        // If you have a search or category filter, handle it here
        if (isset($_GET['search'])) {
            $products = $this->productModel->searchProducts($_GET['search']);
        } elseif (isset($_GET['category'])) {
            $products = $this->productModel->getProductsByCategory($_GET['category']);
        } else {
            $products = $this->productModel->getAllProducts();
        }

        require_once __DIR__ . '/../Views/Buyer/product_list.php';
    }

    // 2. Show Single Product Detail
    public function detail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // A. Get Main Product Data
            $product = $this->productModel->getProductById($id);

            // B. Get Gallery Images
            $gallery = $this->productModel->getGalleryImages($id);

            if ($product) {
                // Load the view and pass variables
                require_once __DIR__ . '/../Views/Buyer/product_details.php';
            } else {
                echo "<h1>Product not found</h1>";
            }
        } else {
            // No ID provided? Go back home
            header("Location: index.php?page=home");
            exit();
        }
    }
}
?>