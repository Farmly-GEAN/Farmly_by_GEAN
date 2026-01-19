<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Farmly - Forgot Password</title>
    <link rel="stylesheet" href="assets/CSS/Forgot_Password.css?v=1.0" />
</head>
<body>
    <div class="fp-page">
        <header class="farmly-header">
            <div class="logo-header">
                <a href="index.php?page=landing">
                    <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo" class="team-logo" />
                </a>
            </div>
        </header>

        <form class="fp-form" action="index.php?page=reset_password_action" method="POST">
            <h2 class="fpform-heading">Buyer Password Reset</h2>

            <?php if(isset($error)): ?>
                <p style="color: red; text-align: center;"><?php echo $error; ?></p>
            <?php endif; ?>

            <div class="fp-field">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
            </div>

            <div class="fp-field">
                <label for="new-password">New Password:</label>
                <input type="password" id="new-password" name="new-password" required />
            </div>

            <div class="fp-field">
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required />
            </div>

            <div class="button-container">
                <button type="submit" class="fpsubmit-button">Update</button>
                
                <a href="index.php?page=login" class="fpcancel-button" style="text-align:center; text-decoration:none; display:inline-block; line-height:1.5;">Cancel</a>
            </div>
        </form>
    </div>

    <?php include __DIR__ . '/Buyer_Footer.php'; ?>
</body>
</html>