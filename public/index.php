<?php
// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define Base Path
define('BASE_PATH', __DIR__ . '/../');

// Get Page Request (Default to 'landing' instead of 'login')
$page = isset($_GET['page']) ? $_GET['page'] : 'landing';

switch ($page) {
    
    // --- LANDING PAGE (DEFAULT) ---
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

    // --- SELLER DASHBOARD ---
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

    // --- HOME (BUYER SHOP) ---
    case 'home':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->index();
        break;

    case 'shop': // Alias for home
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
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

    // --- BUYER PROFILE ---
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

    // --- PRODUCT DETAILS ---
    case 'product_detail':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->detail(); 
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

    // NEW: MANAGE SELLERS ROUTES (ADDED THIS SECTION)
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

    // MANAGE BUYERS
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

    // MANAGE PRODUCTS
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

        case 'view_order':
    require_once BASE_PATH . 'app/Controllers/OrderController.php';
    $controller = new OrderController();
    $controller->viewOrder();
    break;

    case 'submit_review':
        require_once BASE_PATH . 'app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->submitReview(); // This calls the function we added earlier
        break;

        case 'seller_reviews':
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->reviews();
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

        // In Buyer Routes
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


        case 'seller_add_product': // NEW ROUTE
        require_once BASE_PATH . 'app/Controllers/SellerDashboardController.php';
        $controller = new SellerDashboardController();
        $controller->showAddProduct();
        break;

        
    default:
        // If someone types a random ?page=xyz, show the landing page or 404
        require_once BASE_PATH . 'app/Views/landing.php';
        break;
}
?>