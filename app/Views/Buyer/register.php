<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Buyer</title>
    <link rel="stylesheet" href="assets/CSS/Buyer_Register.css" />
  </head>
  <body>
    <header class="top-header">
      <a href="index.php?page=home">
        <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo" class="header-logo" />
      </a>
    </header>

    <div class="main-section">
      <div class="register-card">
        <h2 class="register-title">Register - Buyer</h2>

        <?php if(!empty($message)): ?>
            <p style="color: red; text-align: center; margin-bottom: 10px;"><?php echo $message; ?></p>
        <?php endif; ?>

        <form class="register-form" method="POST" action="">
          <div class="form-grid">
            <div class="form-field">
              <label>Email</label>
              <input type="email" name="email" placeholder="Enter your email" required />
            </div>

            <div class="form-field password-wrapper">
              <label>Password</label>
              <input type="password" name="password" id="password" placeholder="Enter a strong password" required />
              <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <div class="form-field password-wrapper">
              <label>Confirm Password</label>
              <input type="password" name="confirm_password" id="confirmPassword" placeholder="Re-enter password" required />
              <span class="toggle-password" onclick="toggleConfirmPassword()">👁️</span>
            </div>

            <div class="form-field">
              <label>Full Name</label>
              <input type="text" name="full_name" placeholder="Your full name" required />
            </div>

            <div class="form-field">
              <label>Phone Number</label>
              <input type="tel" name="phone" placeholder="Enter your phone number" required />
            </div>

            <div class="form-field wide">
              <label>Address</label>
              <textarea name="address" placeholder="Full residential address" required></textarea>
            </div>

            <div class="form-field">
              <label>Gender</label>
              <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <div class="form-field">
              <label>State</label>
              <input type="text" name="state" placeholder="State" required />
            </div>

            <div class="form-field">
              <label>City</label>
              <input type="text" name="city" placeholder="City" required />
            </div>
          </div>

          <div class="terms">
            <input type="checkbox" required />
            <span>I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></span>
          </div>

          <div class="button-section">
            <button type="submit" class="create-btn">Create Account</button>
            <p class="already-text">
              Already have an account?
              <a href="index.php?page=login" class="login-link">Login</a>
            </p>
          </div>
        </form>
      </div>
    </div>

    <script>
      function togglePassword() {
        let p = document.getElementById("password");
        p.type = p.type === "password" ? "text" : "password";
      }
      function toggleConfirmPassword() {
        let p = document.getElementById("confirmPassword");
        p.type = p.type === "password" ? "text" : "password";
      }
    </script>

    <?php include __DIR__ . '/Buyer_Footer.php'; ?>
  </body>
</html>