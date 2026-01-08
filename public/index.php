<?php
// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define Base Path
define('BASE_PATH', __DIR__ . '/../');

// Get Page Request
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    // --- BUYER AUTH ---
    case 'login':
        require_once BASE_PATH . 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'logout':
        require_once BASE_PATH . 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'register':
        require_once BASE_PATH . 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    // --- SELLER AUTH ---
    case 'seller_login':
        require_once BASE_PATH . 'app/Controllers/SellerAuthController.php';
        $controller = new SellerAuthController();
        $controller->login();
        break;

    case 'seller_register':
        require_once BASE_PATH . 'app/Controllers/SellerAuthController.php';
        $controller = new SellerAuthController();
        $controller->register();
        break;

    case 'seller_logout':
        require_once BASE_PATH . 'app/Controllers/SellerAuthController.php';
        $controller = new SellerAuthController();
        $controller->logout();
        break;

    // --- SELLER DASHBOARD (FIXED) ---
    // I REMOVED THE DUPLICATE PLACEHOLDER BLOCK THAT WAS HERE
    
    case 'seller_dashboard':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->index(); // Loads the "Add Product" page
        break;

    case 'seller_add_product':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->addProduct();
        break;

    // --- HOME ---
    case 'home':
        require_once BASE_PATH . 'app/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    // --- CART ---
    case 'cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->index();
        break;
        
    case 'add_to_cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->add();
        break;

    case 'remove_from_cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->remove();
        break;

    case 'update_cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->update();
        break;

    // --- ORDER ---
    case 'checkout':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->checkout();
        break;

    case 'place_order':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->placeOrder();
        break;
        
    case 'order_success':
        require_once BASE_PATH . 'app/Views/Buyer/order_success.php';
        break;

    case 'order_details':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->orderDetails();
        break;

    // --- PROFILE ---
    case 'profile':
        require_once BASE_PATH . 'app/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;

    case 'cancel_order':
        require_once BASE_PATH . 'app/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->cancelOrder();
        break;

        // --- SELLER FEATURES ---
    case 'seller_listed_products':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->listedProducts();
        break;

    case 'seller_delete_product':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->deleteProduct();
        break;

    case 'seller_orders':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->orders();
        break;

    case 'seller_update_order':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->updateOrderStatus();
        break;

    case 'seller_reviews':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->reviews();
        break;

        // --- SELLER STOCK UPDATE ---
    case 'seller_existing_product':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->existingProduct();
        break;

    case 'seller_update_stock_action':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->updateStock();
        break;

        case 'shop':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;

    // Product Detail Page
    case 'product_detail':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->detail(); 
        break;

        // --- PRODUCT DETAILS ---
    case 'product_detail':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->detail(); 
        break;

        // --- SELLER PROFILE ---
    case 'seller_profile':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->profile();
        break;

    case 'seller_update_profile_action':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->updateProfile();
        break;

    default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
}
?>