<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buyer Login</title>
    <link rel="stylesheet" href="assets/CSS/Buyer_Login.css" />
  </head>
  <body>
    <header class="top-header">
      <a href="index.php?page=home">
        <img
          src="assets/images/Logo/Team Logo.png"
          alt="Farmly Logo"
          class="header-logo"
        />
      </a>
    </header>

    <div class="main-section">
      <div class="login-card">
        <h2 class="login-title">Buyer Login</h2>

        <form class="login-form" id="loginForm" method="POST" action="">
          <div class="form-field">
            <label>Email</label>
            <input
              type="text"
              name="email"
              id="email"
              placeholder="Enter your email"
              required
            />
          </div>

          <div class="form-field">
            <label>Password</label>
            <input
              type="password"
              name="password"
              id="password"
              placeholder="Enter your password"
              required
            />
          </div>

          <button type="submit" class="login-btn">LOGIN</button>

          <?php if(isset($message) && $message != ""): ?>
              <p style="color: red; text-align: center; margin-top: 10px;"><?php echo $message; ?></p>
          <?php endif; ?>

          <p class="forgot">
            <a href="#">Forgot Password?</a>
          </p>

          <p class="create">
            Create a New Account?
            <a href="index.php?page=register"><b>Click Here!</b></a>
          </p>
        </form>
      </div>
    </div>

    <?php  include 'Footer.php'; ?>
  </body>
</html>