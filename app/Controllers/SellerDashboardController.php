<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/ProductModel.php';
// We include these here so we don't forget them later
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/ReviewModel.php';

class SellerDashboardController {
    private $db;
    private $productModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Helper: Verify Seller Login
    private function checkSellerAuth() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            header("Location: index.php?page=seller_login");
            exit();
        }
    }

    // 1. Show Dashboard (Add Product Page)
    public function index() {
        $this->checkSellerAuth();
        $categories = $this->productModel->getCategories();
        require_once __DIR__ . '/../Views/Seller/add_product.php';
    }

    // 2. Handle Add Product Form (UPDATED for Multiple Images)
    public function addProduct() {
        $this->checkSellerAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller_id = $_SESSION['user_id'];
            $seller_name = $_SESSION['seller_name'];
            
            $category_id = $_POST['category_id'];
            $product_name = $_POST['product_name'];
            $stock = $_POST['stock'];
            $price = $_POST['price'];
            $description = "Fresh " . $product_name . " provided by " . $seller_name;

            // A. Handle MAIN Image (Required)
            $mainImagePath = null;
            $uploadDir = __DIR__ . '/../../public/assets/uploads/products/';
            
            // Create directory if it doesn't exist
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
                $fileExt = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
                $fileName = "main_" . time() . "_" . $seller_id . "." . $fileExt;
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
                    $mainImagePath = "assets/uploads/products/" . $fileName;
                } else {
                    header("Location: index.php?page=seller_dashboard&error=Main Image Upload Failed");
                    exit();
                }
            }

            // B. Insert Product & Get New ID
            // Note: Ensure your ProductModel addProduct now returns the ID!
            $newProductID = $this->productModel->addProduct($seller_id, $category_id, $product_name, $stock, $price, $mainImagePath, $description);

            if ($newProductID) {
                // C. Handle GALLERY Images (Optional)
                if (isset($_FILES['gallery_images'])) {
                    $galleryPaths = [];
                    $files = $_FILES['gallery_images'];
                    $count = count($files['name']); // Count how many files were selected

                    for ($i = 0; $i < $count; $i++) {
                        // Check for errors in individual files
                        if ($files['error'][$i] === 0) {
                            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                            // Unique name for each gallery image
                            $gName = "gallery_" . $newProductID . "_" . $i . "_" . time() . "." . $ext;
                            $gTarget = $uploadDir . $gName;
                            
                            if (move_uploaded_file($files['tmp_name'][$i], $gTarget)) {
                                $galleryPaths[] = "assets/uploads/products/" . $gName;
                            }
                        }
                    }

                    // Save to Database if any valid images were uploaded
                    if (!empty($galleryPaths)) {
                        $this->productModel->addGalleryImages($newProductID, $galleryPaths);
                    }
                }

                header("Location: index.php?page=seller_dashboard&success=Product and Images Added Successfully!");
            } else {
                header("Location: index.php?page=seller_dashboard&error=Database Error");
            }
            exit();
        }
    }

    // 3. Show Listed Products
    public function listedProducts() {
        $this->checkSellerAuth();
        $products = $this->productModel->getProductsBySeller($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/listed_products.php';
    }

    // 4. Delete Product
    public function deleteProduct() {
        $this->checkSellerAuth();
        if (isset($_GET['id'])) {
            $this->productModel->deleteProduct($_GET['id'], $_SESSION['user_id']);
        }
        header("Location: index.php?page=seller_listed_products");
        exit();
    }

    // 5. Show Orders
    public function orders() {
        $this->checkSellerAuth();
        $orderModel = new OrderModel($this->db);
        $orders = $orderModel->getSellerOrders($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/orders.php';
    }

    // 6. Update Order Status
    public function updateOrderStatus() {
        $this->checkSellerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderModel = new OrderModel($this->db);
            $order_id = $_POST['order_id'];
            $status = $_POST['status'];
            
            $orderModel->updateStatus($order_id, $status);
            header("Location: index.php?page=seller_orders");
            exit();
        }
    }

    // 7. Show Reviews
    public function reviews() {
        $this->checkSellerAuth();
        if(file_exists(__DIR__ . '/../Models/ReviewModel.php')) {
            require_once __DIR__ . '/../Models/ReviewModel.php';
            $reviewModel = new ReviewModel($this->db);
            $reviews = $reviewModel->getSellerReviews($_SESSION['user_id']);
        } else {
            $reviews = [];
        }
        require_once __DIR__ . '/../Views/Seller/reviews.php';
    }

    // 8. Show Existing Product (Update Stock) Page
    public function existingProduct() {
        $this->checkSellerAuth();
        
        // 1. Fetch Categories (NEW)
        $categories = $this->productModel->getCategories();

        // 2. Fetch Seller's Products
        $products = $this->productModel->getProductsBySeller($_SESSION['user_id']);
        
        require_once __DIR__ . '/../Views/Seller/update_stock.php';
    }

    // 9. Process Stock (and Price) Update
    public function updateStock() {
        $this->checkSellerAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['stock'];
            // Get price if set, otherwise null
            $new_price = !empty($_POST['new_price']) ? $_POST['new_price'] : null;
            $seller_id = $_SESSION['user_id'];

            if ($this->productModel->updateStock($product_id, $seller_id, $quantity, $new_price)) {
                header("Location: index.php?page=seller_listed_products&success=Product Updated Successfully!");
            } else {
                header("Location: index.php?page=seller_existing_product&error=Failed to update product.");
            }
            exit();
        }
    }
    

    // 10. Show Profile Page
    public function profile() {
        $this->checkSellerAuth();
        
        // We need the SellerModel to get current details
        // (Ensure you include SellerModel.php at the top of this file if not already there)
        require_once __DIR__ . '/../Models/SellerModel.php';
        $sellerModel = new SellerModel($this->db);
        
        $seller = $sellerModel->getSellerById($_SESSION['user_id']);
        
        require_once __DIR__ . '/../Views/Seller/profile.php';
    }

    // 11. Update Profile Action
    public function updateProfile() {
        $this->checkSellerAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../Models/SellerModel.php';
            $sellerModel = new SellerModel($this->db);

            $id = $_SESSION['user_id'];
            $name = $_POST['seller_name'];
            $phone = $_POST['seller_phone'];
            $address = $_POST['seller_address'];

            if ($sellerModel->updateProfile($id, $name, $phone, $address)) {
                // Update Session Name if it changed
                $_SESSION['seller_name'] = $name;
                header("Location: index.php?page=seller_profile&success=Profile Updated Successfully");
            } else {
                header("Location: index.php?page=seller_profile&error=Failed to update profile");
            }
            exit();
        }
    }
}
?>