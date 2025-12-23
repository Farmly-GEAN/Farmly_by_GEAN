<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buyer Login</title>
    <link
      rel="stylesheet"
      href="../../../public/assets/CSS/Seller_Register.css"
    />
  </head>
  <body>
    <header class="top-header">
      <img
        src="../../../public/assets/images/Logo/Team Logo.png"
        alt="Farmly Logo"
        class="header-logo"
      />
    </header>

    <div class="register-container">
      <div class="register-card">
        <div class="title-box">
          <h2>Register - Seller</h2>
        </div>

        <form>
          <div class="form-group">
            <label>Email</label>
            <input type="email" required />
          </div>

          <div class="form-group">
            <label>New Password</label>
            <input type="password" required />
          </div>

          <div class="form-group">
            <label>Name</label>
            <input type="text" required />
          </div>

          <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" />
          </div>

          <div class="form-group">
            <label>Add Profile</label>
            <div class="file-input-wrapper">
              <label for="profileUpload" class="custom-file-label"
                >ADD IMAGE</label
              >
              <input type="file" id="profileUpload" accept="image/*" />
            </div>
          </div>

          <div class="form-group">
            <label>Full Address</label>
            <input type="text" />
          </div>

          <div class="action-buttons">
            <a href="Seller_Login.html" class="btn-link"
              >Already has account? Login</a
            >

            <button type="submit" class="btn-register">Register</button>
          </div>
        </form>
      </div>
    </div>

    <?php include 'Seller_Footer.php'; ?>
  </body>
</html>
