<?php
// Enable Error Reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define Base Path
define('BASE_PATH', __DIR__ . '/../');

// Get Page Request
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    // --- AUTH ---
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

    default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
}
?>