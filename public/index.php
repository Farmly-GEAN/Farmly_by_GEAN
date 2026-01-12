<?php
// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define Base Path
define('BASE_PATH', __DIR__ . '/../');

// Get Page Request
$page = isset($_GET['page']) ? $_GET['page'] : 'landing';

switch ($page) {
    
    // --- LANDING PAGE ---
    case 'landing':
        require_once BASE_PATH . 'app/Views/landing.php';
        break;

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

    // --- SELLER DASHBOARD & PRODUCTS ---
    case 'seller_dashboard':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->index();
        break;

    // FIX: Show the Form (GET request)
    case 'seller_add_product':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->showAddProduct(); 
        break;

    // FIX: Process the Form (POST request)
    case 'seller_add_product_action':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->addProduct();
        break;

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

    case 'seller_edit_product':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->editProduct();
        break;

    case 'seller_update_product_action':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->updateProduct();
        break;

    // --- HOME (BUYER SHOP) ---
    case 'home':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;

    case 'shop': 
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;

    case 'product_detail':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->detail(); 
        break;

    case 'submit_review':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->submitReview();
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
    case 'view_order':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->orderDetails(); // Consolidating view logic
        break;

    // --- BUYER PROFILE ---
    case 'profile':
        require_once BASE_PATH . 'app/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;

    case 'update_buyer_profile':
        require_once BASE_PATH . 'app/Controllers/BuyerController.php';
        $controller = new BuyerController();
        $controller->updateProfile();
        break;

    case 'my_orders':
        require_once BASE_PATH . 'app/Controllers/BuyerController.php';
        $controller = new BuyerController();
        $controller->myOrders();
        break;

    case 'cancel_order':
        require_once BASE_PATH . 'app/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->cancelOrder();
        break;

    // --- ADMIN ROUTES ---
    case 'admin_login':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->login();
        break;

    case 'admin_dashboard':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;

    case 'admin_logout':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->logout();
        break;

    case 'admin_sellers':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageSellers();
        break;

    case 'admin_delete_seller':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteSeller();
        break;

    case 'admin_buyers':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageBuyers();
        break;

    case 'admin_delete_buyer':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteBuyer();
        break;

    case 'admin_products':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->manageProducts();
        break;

    case 'admin_delete_product':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->deleteProduct();
        break;

    case 'admin_orders':
        require_once BASE_PATH . 'app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->orders();
        break;

    default:
        require_once BASE_PATH . 'app/Views/landing.php';
        break;
}
?>