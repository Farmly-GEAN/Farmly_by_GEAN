<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmly - Forgot Password</title>
    <link
      rel="stylesheet"
      href="../../../public/assets/CSS/Forgot_Password.css"
    />
  </head>
  <body>
    <div class="fp-page">
      <header class="farmly-header">
        <div class="logo-header">
          <img src="./Logo/Team Logo.png" alt="Farmly Logo" class="team-logo" />
        </div>
      </header>

      <form class="fp-form">
        <h2 class="fpform-heading">Forgot Password</h2>

        <div class="fp-field">
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required />
        </div>

        <div class="fp-field">
          <label for="new-password">New Password:</label>
          <input
            type="password"
            id="new-password"
            name="new-password"
            required
          />
        </div>

        <div class="fp-field">
          <label for="confirm-password">Confirm Password:</label>
          <input
            type="password"
            id="confirm-password"
            name="confirm-password"
            required
          />
        </div>
        <div class="button-container">
          <button type="submit" class="fpsubmit-button">
            <a href="HomePage.php">Update</a>
          </button>
          <button value="clear" type="Cancel" class="fpcancel-button">
            <a href="Buyer_Login.php">Cancel</a>
          </button>
        </div>
      </form>
    </div>

    <?php include 'Footer.php'; ?>
  </body>
</html>
