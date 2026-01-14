<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/CartModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/ProductModel.php'; 

class OrderController {
    private $db;
    private $cartModel;
    private $orderModel;
    private $productModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cartModel = new CartModel($this->db);
        $this->orderModel = new OrderModel($this->db);
        $this->productModel = new ProductModel($this->db); 
    }

    // 1. Show Checkout Page
    public function checkout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { 
            header("Location: index.php?page=login"); 
            exit(); 
        }

        $buyer_id = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($buyer_id);
        
        if (empty($cartItems)) { 
            header("Location: index.php?page=cart"); 
            exit(); 
        }
        $totalPrice = 0;
        foreach($cartItems as $item) {
            $price = $item['price'] ?? $item['Price'] ?? 0;
            $qty = $item['quantity'] ?? $item['Quantity'] ?? 0;
            $totalPrice += ($price * $qty);
        }

        require_once __DIR__ . '/../Views/Buyer/checkout.php';
    }

    // 2. Order Details 
    public function orderDetails() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }
        
        $buyer_id = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $deliveryMethod = $_POST['delivery_method'] ?? 'Home Delivery';
        
            $cartItems = $this->cartModel->getCartItems($buyer_id);
            $totalPrice = 0;
            $seller_id = null;

            foreach($cartItems as $item) {
                $price = $item['price'] ?? $item['Price'] ?? 0;
                $qty = $item['quantity'] ?? $item['Quantity'] ?? 0;
                $totalPrice += ($price * $qty);
                if ($seller_id === null) {
                    $seller_id = $item['Seller_ID'] ?? $item['seller_id'] ?? null;
                }
            }

            
            $totalAmount = $totalPrice;
            if ($deliveryMethod === 'Home Delivery') {
                $totalAmount += 5.00; 
            }
            $seller_name = "Farmly Partner";
            $seller_address = "Warehouse Location";

            if ($seller_id) {
                $sql = "SELECT Seller_Name, Seller_Address FROM Seller WHERE Seller_ID = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':id' => $seller_id]);
                $seller = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($seller) {
                    $seller_name = $seller['Seller_Name'] ?? $seller['seller_name'];
                    $seller_address = $seller['Seller_Address'] ?? $seller['seller_address'];
                }
            }
            if ($deliveryMethod === 'Home Delivery') {
                require_once __DIR__ . '/../Views/Buyer/Home_Delivery.php';
            } else {
                require_once __DIR__ . '/../Views/Buyer/PickUp.php';
            }
            
            
        } else {
        
            header("Location: index.php?page=checkout");
            exit();
        }
    }

    // 3. Place Order 
    public function placeOrder() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }
        
        $buyer_id = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cartItems = $this->cartModel->getCartItems($buyer_id);
            if (empty($cartItems)) { header("Location: index.php?page=cart"); exit(); }

            foreach($cartItems as $item) {
                $pid = $item['product_id'] ?? $item['Product_ID'];
                $qty = $item['quantity'] ?? $item['Quantity'];
                
                $currentStock = $this->productModel->getStock($pid);
                if ($currentStock < $qty) {
                    header("Location: index.php?page=cart&error=stock_low&pid=" . $pid);
                    exit();
                }
            }

            $method = $_POST['delivery_method'] ?? 'Home Delivery';
            $final_address_string = "";

            if ($method === 'Home Delivery') {
                $door = $_POST['door_no'] ?? '';
                $street = $_POST['street'] ?? ''; 
                if (isset($_POST['address'])) {
                    $final_address_string = $_POST['address'] . ", " . ($_POST['city'] ?? '') . " - " . ($_POST['postal_code'] ?? '');
                } else {
                    $city = $_POST['city'] ?? '';
                    $pin = $_POST['pincode'] ?? '';
                    $final_address_string = "$door, $street, $city - $pin";
                }
            } else {
                $pickup_time = $_POST['pickup_time'] ?? 'Anytime';
                $pickup_date = $_POST['pickup_date'] ?? 'Today';
                $final_address_string = "PICKUP: " . ($_POST['seller_address_hidden'] ?? 'Farmly Warehouse') . " | Date: $pickup_date | Time: " . $pickup_time;
            }

            $totalPrice = 0;
            foreach($cartItems as $item) {
                $price = $item['price'] ?? $item['Price'];
                $qty = $item['quantity'] ?? $item['Quantity'];
                $totalPrice += ($price * $qty);
            }
            if ($method === 'Home Delivery') $totalPrice += 5;

            $order_id = $this->orderModel->createOrder($buyer_id, $totalPrice, $final_address_string);

            if ($order_id) {
            
                foreach($cartItems as $item) {
                    $pid = $item['product_id'] ?? $item['Product_ID'];
                    $qty = $item['quantity'] ?? $item['Quantity'];
                    $price = $item['price'] ?? $item['Price'];
                    
                    $this->orderModel->addOrderItem($order_id, $pid, $qty, $price);
                }

                $this->orderModel->clearCart($buyer_id);

                header("Location: index.php?page=order_success&id=" . $order_id);
                exit();
            } else {
                echo "Error: Could not place order. Please try again.";
            }
        }
    }

    // 6. View Single Order
    public function viewOrder($order_id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $order = $this->orderModel->getOrderById($order_id);
        $db_buyer_id = $order['Buyer_ID'] ?? $order['buyer_id'] ?? null;
        
        if (!$order || $db_buyer_id != $_SESSION['user_id']) {
            echo "<h2>Error: Order not found or access denied.</h2>";
            echo "<p>Order ID: " . htmlspecialchars($order_id) . "</p>";
            echo "<a href='index.php?page=my_orders'>Back to Orders</a>";
            exit();
        }

        $items = $this->orderModel->getOrderItems($order_id);

        require_once __DIR__ . '/../Views/Buyer/view_order.php';
    }

    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $buyer_id = $_SESSION['user_id'];
        
        $orders = $this->orderModel->getOrdersByBuyer($buyer_id);

        foreach ($orders as &$order) {
        
            $oid = $order['Order_ID'] ?? $order['order_id'];
            
            $order['items'] = $this->orderModel->getOrderItems($oid);
        }
        unset($order); 

        require_once __DIR__ . '/../Views/Buyer/my_orders.php';
    }
}
?>