<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buyer Login</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Seller_Login.css" />
  </head>
  <body>
    <header class="top-header">
      <img
        src="../../../public/assets/images/Logo/Team Logo.png"
        alt="Farmly Logo"
        class="header-logo"
      />
    </header>

    <div class="main-section">
      <div class="login-card">
        <h2 class="login-title">Seller Login</h2>

        <form class="login-form">
          <div class="form-field">
            <label>Email</label>
            <input type="email" placeholder="Enter your email" required />
          </div>

          <div class="form-field">
            <label>Password</label>
            <input type="password" placeholder="Enter your password" required />
          </div>

          <button type="submit" class="login-btn">LOGIN</button>

          <p class="forgot">
            <a href="Forgot_Password.html">Forgot Password?</a>
          </p>

          <p class="create">
            Create a New Account?
            <a href="Buyer_Register.html"><b>Click Here!</b></a>
          </p>
        </form>
      </div>
    </div>
    <?php include 'Seller_Footer.php'; ?>
  </body>
</html>
