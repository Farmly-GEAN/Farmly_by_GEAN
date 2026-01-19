<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Farmly</title>
    <link rel="stylesheet" href="assets/CSS/HomePage.css">
    <style>
        
        body, html { height: 100%; margin: 0; font-family: 'Segoe UI', sans-serif; }
        
        .hero-no-img {
            background: linear-gradient(135deg, #27ae60, #2c3e50);
            min-height: 100vh; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 20px;
            box-sizing: border-box; 
        }

        .hero-no-img h1 { 
            font-size: 4rem; 
            margin-bottom: 10px; 
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3); 
        }
        
        .hero-no-img p { 
            font-size: 1.5rem; 
            margin-bottom: 50px; 
            max-width: 700px; 
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3); 
            opacity: 0.9;
        }
        
        .action-cards {
            display: flex;
            gap: 30px; 
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            max-width: 1200px;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.98);
            padding: 40px 25px; 
            border-radius: 20px;
            width: 300px; 
            text-align: center;
            color: #333;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .card h2 { 
            color: #2c3e50; 
            margin-bottom: 20px; 
            font-size: 1.8rem;
        }
        
        .btn-landing {
            display: inline-block;
            padding: 12px 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: 0.3s;
            margin-bottom: 15px;
            width: 100%; 
            max-width: 200px;
            cursor: pointer;
        }
        
        
        .btn-buyer { 
            background-color: #27ae60; 
            color: white; 
            border: 2px solid #27ae60; 
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }
        .btn-buyer:hover { background-color: #219150; transform: scale(1.05); }
        .link-buyer { color: #27ae60; }

        
        .btn-seller { 
            background-color: #2c3e50;
            color: white; 
            border: 2px solid #2c3e50; 
            box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
        }
        .btn-seller:hover { background-color: #1a252f; transform: scale(1.05); }
        .link-seller { color: #2c3e50; }

        
        .btn-guest { 
            background-color: #e67e22;
            color: white; 
            border: 2px solid #e67e22; 
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
        }
        .btn-guest:hover { background-color: #d35400; transform: scale(1.05); }
        .link-guest { color: #e67e22; }

        .small-text {
            font-size: 0.9rem;
            color: #666;
        }
        .small-text a {
            font-weight: bold;
            text-decoration: none;
        }
        .small-text a:hover { text-decoration: underline; }

        .landing-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 40px;
            display: flex;
            align-items: center;
            box-sizing: border-box; 
        }
        
        .landing-logo img { 
            height: 80px; 
            width: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        
        @media (max-width: 768px) {
            .hero-no-img { padding-top: 100px;  }
            .hero-no-img h1 { font-size: 2.5rem; }
            .hero-no-img p { font-size: 1.1rem; }
            .card { width: 100%; max-width: 320px; margin-bottom: 20px; }
            .landing-logo img { height: 60px; }
            .landing-header { justify-content: center; padding: 10px; }
        }
    </style>
</head>
<body>

    <header class="landing-header">
        <a href="#" class="landing-logo">
            <img src="assets/images/Logo/Team Logo.png" alt="Farmly Logo">
        </a>
    </header>

    <div class="hero-no-img">
        <h1>Fresh from Farm to Table</h1>
        <p>The marketplace connecting local farmers directly with fresh food lovers.</p>

        <div class="action-cards">
            
            <div class="card">
                <h2>I want to Buy</h2>
                <a href="index.php?page=login" class="btn-landing btn-buyer">Shop Now</a>
                <span class="small-text">New? <a href="index.php?page=register" class="link-buyer">Register here</a></span>
            </div>

            <div class="card">
                <h2>I want to Sell</h2>
                <a href="index.php?page=seller_login" class="btn-landing btn-seller">Start Selling</a>
                <span class="small-text">New? <a href="index.php?page=seller_register" class="link-seller">Register here</a></span>
            </div>

            <div class="card">
                <h2>Just Browsing?</h2>
                <a href="index.php?page=home" class="btn-landing btn-guest">Visit as Guest</a>
                <span class="small-text">No account needed to <a href="index.php?page=home" class="link-guest">explore</a></span>
            </div>

        </div>
    </div>

</body>
</html>