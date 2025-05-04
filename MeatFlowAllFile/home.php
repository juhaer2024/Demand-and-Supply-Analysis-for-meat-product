<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatFlow | Demand and Supply</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="home_style.css">
    <script defer src="scripts.js"></script>
    <style>
        /* Example styles for card hover effect */
        .feature-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .feature-section h2 {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }
        .box {
            width: 300px;
            height: 200px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            text-align: center;
            padding: 15px;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .box:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        .box h3 {
            margin: 20px 0 10px;
        }
        .box p {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            padding: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            font-size: 14px;
            text-align: center;
            transition: bottom 0.3s ease;
        }
        .box:hover p {
            bottom: 0;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .feature-section {
                flex-direction: column;
                align-items: center;
            }
            .box {
                width: 80%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                
                <ul class="nav-items"></ul>
            </div>
            <div class="nav-right">
                <div class="databaseicon">
                    <i class="fa-solid fa-database"></i>
                </div>
                <ul class="nav-items">
                    <li><a href="login2.php" class="btn-secondary">Sign in</a></li>
                    <li><a href="contact.php" class="btn-primary">Get in touch</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section id="hero" class="hero-section">
            <div class="hero-content">
                <h1>Demand and Supply<br>
                    <span class="highlight_h1">Meat Products</span>
                </h1>
                <p>Welcome to Meatflow, your trusted platform for understanding demand and supply of meat products,connecting with buyers, tracking prices.</p>
                 <h1>Explore Now</h1>
            </div>
        </section>

        <section class="feature-section">
            <h2>Features We Offer</h2>
            <div id="product_info" class="box">
                <h3>Product Information</h3>
                <p>View meat type, cuts, origin, and seasonality.</p>
            </div>
            <div id="historicalproduction" class="box">
                <h3>Historical Production</h3>
                <p>View yields, livestock numbers, production costs, and processing data.</p>
            </div>
            <div id="marketprice" class="box">
                <h3>Historical and Current Price Trends</h3>
                <p>Analyze past prices to understand market trends and plan effectively.</p>
            </div>
            <div id="consumer_demand" class="box">
                <h3>Consumer Demand</h3>
                <p>Explore consumption patterns, price elasticity, and regional preferences</p>
            </div>
            <div id="suuply" class="box">
                <h3>Real-time Supply Levels</h3>
                <p>Explore up-to-date supply insights</p>
            </div>
            <div id="directory" class="box">
                <h3>Buyers and Sellers Directory</h3>
                <p>Connect with buyers and sellers in your region to expand your network.</p>
            </div>
            <div id="personalized_recommendation" class="box">
                <h3>Personalized Recommendations</h3>
                <p>Receive tailored suggestions to maximize your crop yield and revenue.</p>
            </div>
            <div id="transport" class="box">
                <h3>Delivery Status</h3>
                <p>Explore for up-to-date supply insights</p>
            </div>
        </section>

        <section class="about-system-section">
            <h2>About MeatFlow</h2>
            <p>MeatFlow is a comprehensive platform designed to understand and explore demand and supply of meat products,assist farmers, slaughterhouse,vendors with real-time information, market trends, and personalized recommendations.</p>
        </section>
    </main>
    
    <footer>
        <p>&copy; 2025 MeatFlow. All rights reserved.</p>
    </footer>
</body>
