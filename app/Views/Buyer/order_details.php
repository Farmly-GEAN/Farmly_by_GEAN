<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Details - Farmly</title>
  
  <style>
    /* --- INTERNAL CSS --- */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
    body { background-color: #ffffff; color: #333; min-height: 100vh; display: flex; flex-direction: column; }

    /* HEADER */
    .site-header { display: flex; align-items: center; justify-content: space-between; padding: 15px 40px; border-bottom: 2px solid #333; position: relative; }
    .header-left { display: flex; align-items: center; }
    .logo img { height: 50px; width: auto; }
    .header-center { position: absolute; left: 50%; transform: translateX(-50%); font-size: 1.5rem; font-weight: 300; text-transform: uppercase; letter-spacing: 2px; }
    .header-right { display: flex; align-items: center; }
    .back-btn { text-decoration: none; color: #333; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }

    /* LAYOUT */
    .container { display: grid; grid-template-columns: 1fr 1fr; gap: 50px; max-width: 1000px; margin: 40px auto; padding: 0 20px; width: 100%; }

    /* FORMS */
    .section-label { font-size: 1.2rem; color: #666; margin-bottom: 20px; font-family: 'Courier New', monospace; font-weight: bold; }
    
    .input-group { margin-bottom: 15px; }
    .input-label { display: block; font-size: 0.9rem; margin-bottom: 5px; font-weight: 600; color: #555; }
    
    .text-input {
        width: 100%; padding: 12px;
        border: 2px solid #333; border-radius: 10px;
        font-size: 1rem; outline: none; transition: border-color 0.2s;
    }
    .text-input:focus { border-color: #27ae60; }

    /* Two inputs in one row */
    .row-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

    /* PICKUP STYLES */
    .store-info {
        border: 2px solid #333; border-radius: 20px; padding: 20px;
        background: #f9f9f9; line-height: 1.6; margin-bottom: 20px;
    }
    .store-name { color: #27ae60; font-weight: bold; font-size: 1.1rem; }

    .time-select {
        width: 100%; padding: 15px;
        border: 2px solid #333; border-radius: 10px;
        background: white; font-size: 1rem; cursor: pointer;
    }

    /* CONFIRM BTN */
    .confirm-btn {
        background: #27ae60; color: white;
        border: 2px solid #333; border-radius: 50px;
        padding: 15px 30px; font-size: 1.2rem; font-family: 'Comic Sans MS', 'Segoe UI', sans-serif;
        cursor: pointer; transition: all 0.2s; text-align: center; width: 100%; margin-top: 20px;
    }
    .confirm-btn:hover { transform: scale(1.02); box-shadow: 0 4px 10px rgba(0,0,0,0.2); }

    /* SUMMARY RIGHT */
    .summary-card { border: 2px solid #333; border-radius: 30px; padding: 30px; position: relative; height: fit-content; }
    .summary-title { position: absolute; top: -12px; left: 30px; background: white; padding: 0 10px; font-family: 'Courier New', monospace; color: #666; }
    .math-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-family: 'Courier New', monospace; font-size: 0.9rem; }
    .final-total { border-top: 2px solid #333; margin-top: 15px; padding-top: 15px; display: flex; justify-content: space-between; font-weight: bold; font-size: 1.2rem; }

    @media (max-width: 768px) { .container { grid-template-columns: 1fr; } .site-header { flex-direction: column; gap: 15px; } .header-center { position: static; transform: none; } }
  </style>
</head>
<body>

  <header class="site-header">
    <div class="header-left"><a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" class="logo" alt="Logo"></a></div>
    <div class="header-center">FINALIZE ORDER</div>
    <div class="header-right"><a href="index.php?page=home" class="back-btn">BACK TO HOME &gt;</a></div>
  </header>

  <div class="container">
    
    <div class="details-section">
      
      <form action="index.php?page=place_order" method="POST">
        <input type="hidden" name="delivery_method" value="<?php echo htmlspecialchars($method); ?>">

        <?php if ($method === 'Home Delivery'): ?>
            <p class="section-label">Shipping Details</p>
            
            <div class="row-inputs">
                <div class="input-group">
                    <label class="input-label">Door Number</label>
                    <input type="text" name="door_no" class="text-input" placeholder="e.g. 12B" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Pincode</label>
                    <input type="text" name="pincode" class="text-input" placeholder="123456" required>
                </div>
            </div>

            <div class="input-group">
                <label class="input-label">Street Name</label>
                <input type="text" name="street" class="text-input" placeholder="Main Street, West Avenue" required>
            </div>

            <div class="input-group">
                <label class="input-label">City / Town</label>
                <input type="text" name="city" class="text-input" placeholder="New York" required>
            </div>

            <div class="input-group">
                <label class="input-label">Landmark (Optional)</label>
                <input type="text" name="landmark" class="text-input" placeholder="Near Central Park">
            </div>

        <?php else: ?>
            <p class="section-label">Pickup Location</p>
            
            <div class="store-info">
                <div class="store-name"><?php echo htmlspecialchars($seller_name); ?></div>
                <p><?php echo htmlspecialchars($seller_address); ?></p>
            </div>
            
            <input type="hidden" name="seller_address_hidden" value="<?php echo htmlspecialchars($seller_address); ?>">

            <p class="section-label" style="margin-top: 20px;">Select Pickup Time</p>
            <select name="time_slot" class="time-select" required>
                <option value="" disabled selected>-- Choose a Time Slot --</option>
                <option value="09:00 AM - 11:00 AM">Morning (09:00 AM - 11:00 AM)</option>
                <option value="11:00 AM - 01:00 PM">Mid-Day (11:00 AM - 01:00 PM)</option>
                <option value="02:00 PM - 04:00 PM">Afternoon (02:00 PM - 04:00 PM)</option>
                <option value="04:00 PM - 06:00 PM">Evening (04:00 PM - 06:00 PM)</option>
            </select>
        <?php endif; ?>

        <button type="submit" class="confirm-btn">
            CONFIRM ORDER ($<?php echo number_format($method === 'Home Delivery' ? $totalPrice + 5 : $totalPrice, 2); ?>)
        </button>
      </form>

    </div>

    <div class="summary-card">
      <span class="summary-title">Final Total:</span>
      <div class="math-row">
          <span>Sub-Total:</span>
          <span>$<?php echo number_format($totalPrice, 2); ?></span>
      </div>
      <div class="math-row">
          <span>Shipping:</span>
          <span>$<?php echo $method === 'Home Delivery' ? '5.00' : '0.00'; ?></span>
      </div>
      <div class="final-total">
          <span>TOTAL TO PAY:</span>
          <span>$<?php echo number_format($method === 'Home Delivery' ? $totalPrice + 5 : $totalPrice, 2); ?></span>
      </div>
    </div>

  </div>

</body>
</html>