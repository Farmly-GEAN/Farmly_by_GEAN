<?php
// Enable Error Reporting (Turn off in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Define Base Path for easier includes
define('BASE_PATH', __DIR__ . '/../');

// Get Page Request
$page = isset($_GET['page']) ? $_GET['page'] : 'login';

switch ($page) {
    case 'login':
        require_once BASE_PATH . 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;

    case 'register':
        require_once BASE_PATH . 'app/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    // --- UPDATED HOME CASE ---
    case 'home':
        require_once BASE_PATH . 'app/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

        // 1. Show Cart Page
    case 'cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->index();
        break;

    // 2. Add Item Action (No View, just logic)
    case 'add_to_cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->add();
        break;

    // 3. Remove Item Action (No View, just logic)
    case 'remove_from_cart':
        require_once BASE_PATH . 'app/Controllers/CartController.php';
        $controller = new CartController();
        $controller->remove();
        break;

        // 1. Show Checkout Page
    case 'checkout':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->checkout();
        break;

    // 2. Process Order
    case 'place_order':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->placeOrder();
        break;

    // 3. Success Page (Simple View)
    case 'order_success':
        echo "<div style='text-align:center; margin-top:50px;'>
                <img src='assets/images/Logo/Team Logo.png' width='100'>
                <h1 style='color:green;'>Order Placed Successfully!</h1>
                <p>Order ID: #" . htmlspecialchars($_GET['id']) . "</p>
                <a href='index.php?page=home' style='padding:10px; background:green; color:white; text-decoration:none; border-radius:5px;'>Continue Shopping</a>
              </div>";
        break;

        // 1. Show Checkout Page
    case 'checkout':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->checkout();
        break;

    // 2. Process Order
    case 'place_order':
        require_once BASE_PATH . 'app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->placeOrder();
        break;

    // 3. Success Page (Simple View)
    case 'order_success':
        echo "<div style='text-align:center; margin-top:50px;'>
                <img src='assets/images/Logo/Team Logo.png' width='100'>
                <h1 style='color:green;'>Order Placed Successfully!</h1>
                <p>Order ID: #" . htmlspecialchars($_GET['id']) . "</p>
                <a href='index.php?page=home' style='padding:10px; background:green; color:white; text-decoration:none; border-radius:5px;'>Continue Shopping</a>
              </div>";
        break;

    default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
}
?>