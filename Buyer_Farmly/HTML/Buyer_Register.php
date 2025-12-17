<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Buyer</title>
    <link rel="stylesheet" href="../CSS/Buyer_Register.css">
</head>
<body>

<header class="top-header">
    <a href="HomePage.html">
        <img src="./Logo/Team Logo.png" alt="Farmly Logo" class="header-logo">
    </a>
</header>

<div class="main-section">
    <div class="register-card">

        <h2 class="register-title">Register - Buyer</h2>

        <form class="register-form" method="POST" action="/buyer/register">


            
            <div class="form-grid">

                <div class="form-field">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-field password-wrapper">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>

                <div class="form-field password-wrapper">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirmPassword" required>
                    <span class="toggle-password" onclick="toggleConfirmPassword()">👁️</span>
                </div>

                <div class="form-field">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>

                <div class="form-field">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required>
                </div>

                <div class="form-field wide">
                    <label>Address</label>
                    <textarea name="address" required></textarea>
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
                    <input type="text" name="state" required>
                </div>

                <div class="form-field">
                    <label>City</label>
                   <input type="text" name="city" required>
                </div>

            </div>

            <!-- Terms -->
            <div class="terms">
                <input type="checkbox" required>
                <span>I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></span>
            </div>

            <!-- Buttons -->
            <div class="button-section">
                <button class="create-btn">Create Account</button>
                <p class="already-text">Already have an account?
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

<?php include '../Header_Footer/footer.php'; ?>

</body>
</html>
