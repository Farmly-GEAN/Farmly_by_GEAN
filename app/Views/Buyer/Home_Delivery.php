<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Delivery - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    
    <style>
        body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; color: #333; }

        /* Header */
        .site-header {
            background: white; padding: 15px 40px; display: flex; align-items: center; 
            justify-content: space-between; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            position: relative; min-height: 80px;
        }
        .logo img { height: 90px; width: auto; }
        
        .header-center {
            position: absolute; left: 50%; transform: translateX(-50%);
            font-size: 1.5rem; font-weight: 600; color: #2c3e50; text-transform: uppercase;
        }

        /* Shop Button Style */
        .back-link {
            color: #27ae60; text-decoration: none; font-weight: 600; font-size: 1rem;
            border: 1px solid #27ae60; padding: 8px 15px; border-radius: 5px; transition: 0.3s;
        }
        .back-link:hover { background-color: #27ae60; color: white; }

        /* Main Form Container */
        .details-container {
            max-width: 600px; margin: 40px auto; background: white; padding: 40px;
            border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Form Fields */
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        
        .form-input, .form-textarea {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;
            font-size: 1rem; box-sizing: border-box; transition: 0.3s;
        }
        .form-input:focus { border-color: #27ae60; outline: none; }

        /* Radio Payment Box */
        .radio-group {
            background: #fafafa; padding: 15px; border: 1px solid #eee; border-radius: 5px;
            display: flex; flex-direction: column; gap: 10px;
        }
        .radio-group label { margin: 0; font-weight: normal; cursor: pointer; display: flex; align-items: center; gap: 10px; }

        /* Button */
        .confirm-btn {
            width: 100%; background-color: #27ae60; color: white; padding: 15px;
            font-size: 1.1rem; font-weight: bold; border: none; border-radius: 8px;
            cursor: pointer; transition: 0.3s; margin-top: 10px;
        }
        .confirm-btn:hover { background-color: #219150; transform: translateY(-2px); }
    </style>
</head>
<body>

    <header class="site-header">
        <div class="logo">
             <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" alt="Logo"></a>
        </div>
        
        <div class="header-center">Delivery Details</div>
        
        <div class="header-right">
            <a href="index.php?page=home" class="back-link">Shop</a>
        </div>
    </header>

    <div class="details-container">
        <form action="index.php?page=place_order" method="POST">
            <input type="hidden" name="delivery_method" value="Home Delivery">
            <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($totalAmount); ?>">

            <div class="form-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-input" required 
                           value="<?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>">
                </div>
                <div style="flex: 1;">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-input" required placeholder="+1 234...">
                </div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-input" required 
                       value="<?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Delivery Address</label>
                <textarea name="address" class="form-textarea" rows="3" required placeholder="Street, Apartment, Building..."></textarea>
            </div>

            <div class="form-group" style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <label>City</label>
                    <input type="text" name="city" class="form-input" required>
                </div>
                <div style="flex: 1;">
                    <label>Postal Code</label>
                    <input type="text" name="postal_code" class="form-input" required>
                </div>
            </div>

            <div class="form-group">
                <label>Payment Method</label>
                <div class="radio-group">
                    <label><input type="radio" name="payment_method" value="Online Payment" required>Online Payment</label>
                    <label><input type="radio" name="payment_method" value="Cash on Delivery">Cash on Delivery</label>
                </div>
            </div>

            <button type="submit" class="confirm-btn">
                Confirm Order ($<?php echo number_format($totalAmount, 2); ?>)
            </button>
        </form>
    </div>

</body>
</html>