<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/ProductModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/ReviewModel.php';
require_once __DIR__ . '/../Models/SellerModel.php';

class SellerDashboardController {
    private $db;
    private $productModel;
    private $sellerModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->productModel = new ProductModel($this->db);
        $this->sellerModel = new SellerModel($this->db);
    }

    // Helper: Verify Seller Login
    private function checkSellerAuth() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
            header("Location: index.php?page=seller_login");
            exit();
        }
    }

    // 1. Show Dashboard HOME
    public function index() {
        $this->checkSellerAuth();
        $seller_id = $_SESSION['user_id'];

        // Stats
        $earnings = $this->sellerModel->getTotalEarnings($seller_id);
        $total_orders = $this->sellerModel->getTotalOrdersCount($seller_id);
        $total_products = $this->sellerModel->getTotalProductsCount($seller_id);
        
        // Recent Orders
        $orderModel = new OrderModel($this->db);
        $all_orders = $orderModel->getSellerOrders($seller_id, 'all'); 
        $recent_orders = array_slice($all_orders, 0, 5);

        require_once __DIR__ . '/../Views/Seller/dashboard_home.php';
    }

    // 1.5 Show "Add Product" Page (The Logic needed for the blank page fix)
    public function showAddProduct() {
        $this->checkSellerAuth();
        
        // Fetch categories to populate the dropdown
        $categories = $this->productModel->getCategories();
        
        // Load the view
        require_once __DIR__ . '/../Views/Seller/add_product.php';
    }

    // 2. Handle Add Product Form (POST Action)
    public function addProduct() {
        $this->checkSellerAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $seller_id = $_SESSION['user_id'];
            $category_id = $_POST['category_id'];
            $product_name = $_POST['product_name'];
            $stock = $_POST['stock'];
            $price = $_POST['price'];
            $description = $_POST['description'];

            // Handle MAIN Image
            $mainImagePath = null;
            $uploadDir = __DIR__ . '/../../public/assets/uploads/products/';
            
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
                $fileExt = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
                $fileName = "main_" . time() . "_" . $seller_id . "." . $fileExt;
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
                    $mainImagePath = "assets/uploads/products/" . $fileName;
                } else {
                    header("Location: index.php?page=seller_add_product&error=Image Upload Failed");
                    exit();
                }
            }

            // Insert Product
            $newProductID = $this->productModel->addProduct($seller_id, $category_id, $product_name, $stock, $price, $mainImagePath, $description);

            if ($newProductID) {
                // Handle Gallery Images
                if (isset($_FILES['gallery_images'])) {
                    $galleryPaths = [];
                    $files = $_FILES['gallery_images'];
                    $count = count($files['name']);

                    for ($i = 0; $i < $count; $i++) {
                        if ($files['error'][$i] === 0) {
                            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                            $gName = "gallery_" . $newProductID . "_" . $i . "_" . time() . "." . $ext;
                            $gTarget = $uploadDir . $gName;
                            
                            if (move_uploaded_file($files['tmp_name'][$i], $gTarget)) {
                                $galleryPaths[] = "assets/uploads/products/" . $gName;
                            }
                        }
                    }

                    if (!empty($galleryPaths)) {
                        $this->productModel->addGalleryImages($newProductID, $galleryPaths);
                    }
                }

                header("Location: index.php?page=seller_listed_products&success=Product Added Successfully");
            } else {
                header("Location: index.php?page=seller_add_product&error=Database Error");
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
        $seller_id = $_SESSION['user_id'];
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $orderModel = new OrderModel($this->db);
        $orders = $orderModel->getSellerOrders($seller_id, $filter);
        require_once __DIR__ . '/../Views/Seller/orders.php';
    }

    // 6. Update Order Status
    public function updateOrderStatus() {
        $this->checkSellerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderModel = new OrderModel($this->db);
            $orderModel->updateStatus($_POST['order_id'], $_POST['status']);
            header("Location: index.php?page=seller_orders");
            exit();
        }
    }

    // 7. Show Seller Reviews
    public function reviews() {
        $this->checkSellerAuth();
        $seller_id = $_SESSION['user_id'];
        $reviews = $this->sellerModel->getSellerReviews($seller_id);
        require_once BASE_PATH . 'app/Views/Seller/reviews.php';
    }

    // 8. Existing Product (Legacy/Simple Stock Update)
    public function existingProduct() {
        $this->checkSellerAuth();
        $categories = $this->productModel->getCategories();
        $products = $this->productModel->getProductsBySeller($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/update_stock.php';
    }

    // 9. Update Stock Action
    public function updateStock() {
        $this->checkSellerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $quantity = $_POST['stock'];
            $new_price = !empty($_POST['new_price']) ? $_POST['new_price'] : null;
            $seller_id = $_SESSION['user_id'];

            if ($this->productModel->updateStock($product_id, $seller_id, $quantity, $new_price)) {
                header("Location: index.php?page=seller_listed_products&success=Updated");
            } else {
                header("Location: index.php?page=seller_existing_product&error=Failed");
            }
            exit();
        }
    }

    // 10. Show Profile
    public function profile() {
        $this->checkSellerAuth();
        $seller = $this->sellerModel->getSellerById($_SESSION['user_id']);
        require_once __DIR__ . '/../Views/Seller/profile.php';
    }

    // 11. Update Profile Action
    public function updateProfile() {
        $this->checkSellerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['user_id'];
            $name = $_POST['seller_name'];
            $phone = $_POST['seller_phone'];
            
            $door = $_POST['door_no'];
            $street = $_POST['street'];
            $city = $_POST['city'];
            $pin = $_POST['pincode'];
            
            $final_address = "$door, $street, $city - $pin";

            if ($this->sellerModel->updateProfile($id, $name, $phone, $final_address)) {
                $_SESSION['seller_name'] = $name;
                header("Location: index.php?page=seller_profile&success=Profile Updated");
            } else {
                header("Location: index.php?page=seller_profile&error=Failed");
            }
            exit();
        }
    }

    // 13. Edit Product Form
    public function editProduct() {
        $this->checkSellerAuth();
        if (isset($_GET['id'])) {
            $product_id = $_GET['id'];
            $product = $this->productModel->getProductById($product_id);
            $categories = $this->productModel->getCategories();
            require_once __DIR__ . '/../Views/Seller/edit_product.php';
        } else {
            header("Location: index.php?page=seller_listed_products");
        }
    }

    // 14. Update Product Logic
    public function updateProduct() {
        $this->checkSellerAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $seller_id = $_SESSION['user_id'];
            
            $name = $_POST['product_name'];
            $category_id = $_POST['category_id'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            
            $imagePath = null;
            if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
                $uploadDir = __DIR__ . '/../../public/assets/uploads/products/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileExt = pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION);
                $fileName = "updated_" . time() . "_" . $product_id . "." . $fileExt;
                $targetFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
                    $imagePath = "assets/uploads/products/" . $fileName;
                }
            }

            if ($this->productModel->updateProductDetails($product_id, $seller_id, $name, $description, $price, $stock, $category_id, $imagePath)) {
                header("Location: index.php?page=seller_listed_products&success=Product Updated");
            } else {
                header("Location: index.php?page=seller_edit_product&id=$product_id&error=Update Failed");
            }
            exit();
        }
    }
}
?>