<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us - Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; color: #333; }
        
        .page-container {
            max-width: 700px; margin: 50px auto; background: white; padding: 50px;
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .page-title { text-align: center; color: #2c3e50; margin-bottom: 10px; }
        .sub-text { text-align: center; color: #777; margin-bottom: 40px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
        
        .form-input, textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; 
            box-sizing: border-box; font-family: inherit; font-size: 1rem;
        }
        
        .send-btn {
            width: 100%; background-color: #27ae60; color: white; padding: 15px;
            font-size: 1.1rem; font-weight: bold; border: none; border-radius: 5px; cursor: pointer;
            transition: 0.3s;
        }
        .send-btn:hover { background-color: #219150; }

        .contact-info {
            margin-top: 40px; text-align: center; border-top: 1px solid #eee; padding-top: 30px;
        }
        .contact-info p { margin: 10px 0; color: #555; }
    </style>
</head>
<body>

    <header style="background: white; padding: 15px 40px; border-bottom: 1px solid #ddd; text-align: center;">
        <a href="index.php?page=home"><img src="assets/images/Logo/Team Logo.png" style="height: 60px;"></a>
    </header>

    <div class="page-container">
        <h1 class="page-title">Contact Us</h1>
        <p class="sub-text">Have a question or need assistance? We'd love to hear from you.</p>

        <form onsubmit="event.preventDefault(); alert('Message sent! We will contact you shortly.');">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" class="form-input" placeholder="John Doe" required>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-input" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label>Subject</label>
                <select class="form-input">
                    <option>General Inquiry</option>
                    <option>Order Issue</option>
                    <option>Seller Support</option>
                </select>
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea rows="5" placeholder="How can we help you?" required></textarea>
            </div>

            <button type="submit" class="send-btn">Send Message</button>
        </form>

        <div class="contact-info">
            <p><strong>📍 Headquarters:</strong> 123 Green Street, Agriculture City</p>
            <p><strong>📞 Phone:</strong> +1 234 567 890</p>
            <p><strong>📧 Email:</strong> support@farmly.com</p>
        </div>
    </div>

    <?php include __DIR__ . '/../Buyer/Buyer_Footer.php'; ?>
</body>
</html>