<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buyer Login</title>
    <link rel="stylesheet" href="../../../public/assets/CSS/Buyer_Login.css" />
  </head>
  <body>
    <header class="top-header">
      <a href="HomePage.php">
        <img
          src="../../../public/assets/images/Logo/Team Logo.png"
          alt="Farmly Logo"
          class="header-logo"
        />
      </a>
    </header>

    <div class="main-section">
      <div class="login-card">
        <h2 class="login-title">Buyer Login</h2>

        <form class="login-form" id="loginForm">
          <div class="form-field">
            <label>Email</label>
            <input
              type="text"
              id="email"
              placeholder="Enter your email"
              required
            />
          </div>

          <div class="form-field">
            <label>Password</label>
            <input
              type="password"
              id="password"
              placeholder="Enter your password"
              required
            />
          </div>

          <button type="submit" class="login-btn">LOGIN</button>

          <p id="message"></p>

          <p class="forgot">
            <a href="Forgot_Password.php">Forgot Password?</a>
          </p>

          <p class="create">
            Create a New Account?
            <a href="Buyer_Register.php"><b>Click Here!</b></a>
          </p>
        </form>
      </div>
    </div>

    <?php include 'Footer.php'; ?>
  </body>

 
</html>
