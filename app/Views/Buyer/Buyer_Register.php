<?php
// UPDATED PATH: Go up 2 levels (../../) to get from 'Views/Buyer' to 'app', then down to 'Models/config'
require_once __DIR__ . '/../../Models/config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $password = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    if ($password !== $confirmPass) {
        $message = "Passwords do not match!";
    } else {
        // Check for existing user
        $stmt = $pdo->prepare("SELECT Buyer_ID FROM Buyer WHERE Buyer_Email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $message = "Email is already registered!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into Buyer table
            $sql = "INSERT INTO Buyer (Buyer_Name, Buyer_Email, Buyer_Phone, Buyer_Address, Buyer_Password, Gender, State, City) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$name, $email, $phone, $address, $hashed_password, $gender, $state, $city])) {
                header("Location: Buyer_Login.php?success=1");
                exit();
            } else {
                $message = "Error creating account.";
            }
        }
    }
}
?>



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
        <img src="../../../public/assets/images/Logo/Team Logo.png" alt="Farmly Logo" class="header-logo" />
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
