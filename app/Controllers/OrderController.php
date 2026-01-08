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

    // 1. Show Checkout Page (Step 1: Select Delivery Method)
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

        // Calculate subtotal for display
        $totalPrice = 0;
        foreach($cartItems as $item) {
            $price = $item['price'] ?? $item['Price'] ?? 0;
            $qty = $item['quantity'] ?? $item['Quantity'] ?? 0;
            $totalPrice += ($price * $qty);
        }

        require_once __DIR__ . '/../Views/Buyer/checkout.php';
    }

    // 2. Order Details (Step 2: Enter Address & Confirm)
    public function orderDetails() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }
        
        $buyer_id = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // A. Capture Delivery Method
            $method = $_POST['delivery_method'] ?? 'Home Delivery';
            
            // B. Recalculate Total Price
            $cartItems = $this->cartModel->getCartItems($buyer_id);
            $totalPrice = 0;
            foreach($cartItems as $item) {
                $price = $item['price'] ?? $item['Price'] ?? 0;
                $qty = $item['quantity'] ?? $item['Quantity'] ?? 0;
                $totalPrice += ($price * $qty);
            }

            // Add Shipping Cost if Home Delivery
            if ($method === 'Home Delivery') {
                $totalPrice += 5.00; 
            }

            // C. Load the Confirmation View
            require_once __DIR__ . '/../Views/Buyer/order_details.php';
        } else {
            // If accessed directly, go back to checkout
            header("Location: index.php?page=checkout");
            exit();
        }
    }

    // 3. Place Order (Step 3: Save to Database)
    public function placeOrder() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }
        
        $buyer_id = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cartItems = $this->cartModel->getCartItems($buyer_id);
            if (empty($cartItems)) { header("Location: index.php?page=cart"); exit(); }

            // --- A. Validate Stock ---
            foreach($cartItems as $item) {
                $pid = $item['product_id'] ?? $item['Product_ID'];
                $qty = $item['quantity'] ?? $item['Quantity'];
                
                $currentStock = $this->productModel->getStock($pid);
                if ($currentStock < $qty) {
                    header("Location: index.php?page=cart&error=stock_low&pid=" . $pid);
                    exit();
                }
            }

            // --- B. Prepare Address ---
            $method = $_POST['delivery_method'] ?? 'Home Delivery';
            $final_address_string = "";

            if ($method === 'Home Delivery') {
                $door = $_POST['door_no'] ?? '';
                $street = $_POST['street'] ?? '';
                $city = $_POST['city'] ?? '';
                $pin = $_POST['pincode'] ?? '';
                $final_address_string = "$door, $street, $city - $pin";
            } else {
                $final_address_string = "PICKUP: " . ($_POST['seller_address_hidden'] ?? 'Farmly Warehouse');
            }

            // --- C. Calculate Final Total ---
            $totalPrice = 0;
            foreach($cartItems as $item) {
                $price = $item['price'] ?? $item['Price'];
                $qty = $item['quantity'] ?? $item['Quantity'];
                $totalPrice += ($price * $qty);
            }
            if ($method === 'Home Delivery') $totalPrice += 5;

            // --- D. Create Order in DB ---
            $order_id = $this->orderModel->createOrder($buyer_id, $totalPrice, $final_address_string);

            if ($order_id) {
                // Add Items to Order_Details
                foreach($cartItems as $item) {
                    $pid = $item['product_id'] ?? $item['Product_ID'];
                    $qty = $item['quantity'] ?? $item['Quantity'];
                    $price = $item['price'] ?? $item['Price'];
                    
                    $this->orderModel->addOrderItem($order_id, $pid, $qty, $price);
                }

                // Clear Cart
                $this->orderModel->clearCart($buyer_id);

                // Redirect to Success
                header("Location: index.php?page=order_success&id=" . $order_id);
                exit();
            } else {
                echo "Error: Could not place order. Please try again.";
            }
        }
    }

   

}
?>