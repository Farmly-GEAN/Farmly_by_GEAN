<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Feedback - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/SellerDashboard.css"> 
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; }
        
        .feedback-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 { color: #2c3e50; text-align: center; margin-bottom: 20px; }
        p { text-align: center; color: #666; margin-bottom: 30px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        
        .form-input, textarea {
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;
            font-size: 1rem; box-sizing: border-box; font-family: inherit;
        }
        
        .submit-btn {
            width: 100%; background-color: #27ae60; color: white; padding: 12px;
            font-size: 1rem; font-weight: bold; border: none; border-radius: 5px;
            cursor: pointer; transition: 0.3s;
        }
        .submit-btn:hover { background-color: #219150; }

        .back-link { display: block; text-align: center; margin-top: 20px; color: #777; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="feedback-container">
        <h2>We Value Your Feedback</h2>
        <p>Help us improve the Farmly Seller experience. Let us know if you faced any issues or have suggestions.</p>

        <form action="index.php?page=seller_dashboard" method="GET">
            <input type="hidden" name="page" value="seller_dashboard">
            <input type="hidden" name="success" value="Thank you! Your feedback has been sent.">

            <div class="form-group">
                <label>Subject</label>
                <select class="form-input" name="subject">
                    <option>Report a Bug</option>
                    <option>Suggestion</option>
                    <option>Account Issue</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Your Message</label>
                <textarea name="message" rows="5" placeholder="Type your feedback here..." required></textarea>
            </div>

            <button type="submit" class="submit-btn">Submit Feedback</button>
        </form>

        <a href="index.php?page=seller_dashboard" class="back-link">Cancel & Back to Dashboard</a>
    </div>

    <?php include __DIR__ . '/Seller_Footer.php'; ?>
</body>
</html>