<?php
require_once __DIR__ . '/../Config/Database.php';
require_once __DIR__ . '/../Models/CartModel.php';
require_once __DIR__ . '/../Models/OrderModel.php';
require_once __DIR__ . '/../Models/ProductModel.php'; // Required for stock check

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
        $this->productModel = new ProductModel($this->db); // Initialized correctly
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
            
            // 1. Capture Delivery Method
            $deliveryMethod = $_POST['delivery_method'] ?? 'Home Delivery';
            
            // 2. Fetch Cart Items & Calculate Total
            $cartItems = $this->cartModel->getCartItems($buyer_id);
            $totalPrice = 0;
            $seller_id = null; // We need this to find the Pickup Address

            foreach($cartItems as $item) {
                $price = $item['price'] ?? $item['Price'] ?? 0;
                $qty = $item['quantity'] ?? $item['Quantity'] ?? 0;
                $totalPrice += ($price * $qty);

                // Capture Seller ID (Take the first one found)
                if ($seller_id === null) {
                    $seller_id = $item['Seller_ID'] ?? $item['seller_id'] ?? null;
                }
            }

            // 3. Add Shipping if needed
            $totalAmount = $totalPrice;
            if ($deliveryMethod === 'Home Delivery') {
                $totalAmount += 5.00; 
            }

            // 4. Fetch Seller Details (So Pickup Location works)
            $seller_name = "Farmly Partner";
            $seller_address = "Warehouse Location"; // Default

            if ($seller_id) {
                // Check if SellerModel is loaded, if not, do a direct query
                $sql = "SELECT Seller_Name, Seller_Address FROM Seller WHERE Seller_ID = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([':id' => $seller_id]);
                $seller = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($seller) {
                    $seller_name = $seller['Seller_Name'] ?? $seller['seller_name'];
                    $seller_address = $seller['Seller_Address'] ?? $seller['seller_address'];
                }
            }

            // === CRITICAL FIX START ===
            // Instead of loading order_details.php, we load the specific file based on choice
            if ($deliveryMethod === 'Home Delivery') {
                require_once __DIR__ . '/../Views/Buyer/Home_Delivery.php';
            } else {
                require_once __DIR__ . '/../Views/Buyer/PickUp.php';
            }
            // === CRITICAL FIX END ===
            
        } else {
            // If user tries to skip the checkout step, send them back
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
                // If using the single textarea from the new code:
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

    // 6. View Single Order (Receipt Page)
    public function viewOrder($order_id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        // 1. Fetch Order Details
        $order = $this->orderModel->getOrderById($order_id);

        // --- FIX START: Handle Case Sensitivity ---
        // We try to get 'Buyer_ID'. If not found, we try 'buyer_id'.
        $db_buyer_id = $order['Buyer_ID'] ?? $order['buyer_id'] ?? null;
        // --- FIX END ---

        // Security Check: Ensure order exists AND belongs to the logged-in user
        if (!$order || $db_buyer_id != $_SESSION['user_id']) {
            echo "<h2>Error: Order not found or access denied.</h2>";
            echo "<p>Order ID: " . htmlspecialchars($order_id) . "</p>";
            echo "<a href='index.php?page=my_orders'>Back to Orders</a>";
            exit();
        }

        // 2. Fetch Items in that order
        $items = $this->orderModel->getOrderItems($order_id);

        // Load the View
        require_once __DIR__ . '/../Views/Buyer/view_order.php';
    }

    public function myOrders() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?page=login"); exit(); }

        $buyer_id = $_SESSION['user_id'];
        
        $orders = $this->orderModel->getOrdersByBuyer($buyer_id);

        foreach ($orders as &$order) {
            // FIX: Check for both 'Order_ID' OR 'order_id' to prevent the error
            $oid = $order['Order_ID'] ?? $order['order_id'];
            
            // Pass the safe ID into the function
            $order['items'] = $this->orderModel->getOrderItems($oid);
        }
        unset($order); 

        require_once __DIR__ . '/../Views/Buyer/my_orders.php';
    }
}
?>