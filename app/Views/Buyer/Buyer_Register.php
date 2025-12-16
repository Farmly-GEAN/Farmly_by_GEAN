<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Buyer</title>
    <link
      rel="stylesheet"
      href="../../../public/assets/CSS/Buyer_Register.css"
    />
  </head>
  <body>
    <header class="top-header">
      <a href="HomePage.html">
        <img src="./Logo/Team Logo.png" alt="Farmly Logo" class="header-logo" />
      </a>
    </header>

    <div class="main-section">
      <div class="register-card">
        <h2 class="register-title">Register - Buyer</h2>

        <form class="register-form">
          <!-- Landscape Grid -->
          <div class="form-grid">
            <div class="form-field">
              <label>Email</label>
              <input type="email" placeholder="Enter your email" required />
            </div>

            <div class="form-field password-wrapper">
              <label>Password</label>
              <input
                type="password"
                id="password"
                placeholder="Enter a strong password"
                required
              />
              <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <div class="form-field password-wrapper">
              <label>Confirm Password</label>
              <input
                type="password"
                id="confirmPassword"
                placeholder="Re-enter password"
                required
              />
              <span class="toggle-password" onclick="toggleConfirmPassword()"
                >👁️</span
              >
            </div>

            <div class="form-field">
              <label>Full Name</label>
              <input type="text" placeholder="Your full name" required />
            </div>

            <div class="form-field">
              <label>Phone Number</label>
              <input
                type="tel"
                placeholder="Enter your phone number"
                required
              />
            </div>

            <div class="form-field wide">
              <label>Address</label>
              <textarea
                placeholder="Full residential address"
                required
              ></textarea>
            </div>

            <div class="form-field">
              <label>Gender</label>
              <select required>
                <option value="">Select Gender</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
              </select>
            </div>

            <div class="form-field">
              <label>State</label>
              <input type="text" placeholder="State" required />
            </div>

            <div class="form-field">
              <label>City</label>
              <input type="text" placeholder="City" required />
            </div>
          </div>

          <!-- Terms -->
          <div class="terms">
            <input type="checkbox" required />
            <span
              >I agree to the <a href="#">Terms & Conditions</a> and
              <a href="#">Privacy Policy</a></span
            >
          </div>

          <!-- Buttons -->
          <div class="button-section">
            <button class="create-btn">Create Account</button>
            <p class="already-text">
              Already have an account?
              <a href="Buyer_Login.php" class="login-link">Login</a>
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

    <?php include 'Footer.php'; ?>
  </body>
</html>
