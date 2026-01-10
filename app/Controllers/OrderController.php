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
            
            // --- Find the Seller ID from the cart items ---
            $seller_id = null;

            foreach($cartItems as $item) {
                $price = $item['price'] ?? $item['Price'] ?? 0;
                $qty = $item['quantity'] ?? $item['Quantity'] ?? 0;
                $totalPrice += ($price * $qty);

                // Capture Seller ID (Assuming items are from one seller or we take the first one)
                if ($seller_id === null) {
                    $seller_id = $item['Seller_ID'] ?? $item['seller_id'] ?? null;
                }
            }

            // --- Fetch Seller Details for Pickup View ---
            $seller_name = "Farmly Partner";
            $seller_address = "Warehouse Location"; // Default fallback

            if ($seller_id) {
                $sql = "SELECT Seller_Name, Seller_Address FROM Seller WHERE Seller_ID = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':id' => $seller_id]);
                $seller = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($seller) {
                    // Check mixed case keys just in case
                    $seller_name = $seller['Seller_Name'] ?? $seller['seller_name'];
                    $seller_address = $seller['Seller_Address'] ?? $seller['seller_address'];
                }
            }

            // Add Shipping Cost if Home Delivery
            if ($method === 'Home Delivery') {
                $totalPrice += 5.00; 
            }

            // C. Load the Confirmation View (Now has $seller_address defined!)
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
                // Now this will work because the previous page loaded correctly!
                $pickup_time = $_POST['time_slot'] ?? 'Anytime';
                $final_address_string = "PICKUP: " . ($_POST['seller_address_hidden'] ?? 'Farmly Warehouse') . " | Time: " . $pickup_time;
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
                    
                    // This function automatically deducts stock inside OrderModel
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

    // 4. View Past Order (Receipt Page)
    public function viewOrder() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        if (isset($_GET['id'])) {
            $order_id = $_GET['id'];
            
            // Fetch Order Data
            $order = $this->orderModel->getOrderById($order_id);
            $items = $this->orderModel->getOrderItems($order_id);

            // FIX: Check both Upper and Lower case keys to prevent "Undefined array key" error
            $db_buyer_id = $order['Buyer_ID'] ?? $order['buyer_id'] ?? null;

            // Security Check: Ensure this order belongs to the logged-in user!
            if (!$order || $db_buyer_id != $_SESSION['user_id']) {
                echo "Access Denied or Order Not Found.";
                exit();
            }

            // Load the View
            require_once __DIR__ . '/../Views/Buyer/view_order.php';
        } else {
            header("Location: index.php?page=profile");
        }
    }
}
?>