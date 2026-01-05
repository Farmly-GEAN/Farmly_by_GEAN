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

    default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
}
?>