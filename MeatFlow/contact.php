<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeatFlow | Contact Us</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="contact_style.css">

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
                <img src="logo.png" alt="MeatFlow" class="nav-logo">
                <ul class="nav-items"></ul>
            </div>
            <div class="nav-right">
                <div class="databaseicon">
                    <i class="fa-solid fa-database"></i>
                </div>
                <ul class="nav-items">
                    <li><a href="login.php" class="btn-secondary">Sign in</a></li>
                    <li><a href="home.php" class="btn-primary">Home</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <section class="contact-section">
            <h1>Contact Our Support Team</h1>
            <p>If you have any questions or need assistance, our support team is here to help. You can reach out to any of our representatives listed below.</p>

            <div class="support-grid">
                <div class="support-card">
                    <h3>Nabil</h3>
                    <p>ID: xxxxxxx</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: XXXXXXXXXXX</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: xxxxxxx@iub.edu.bd</p>   
                </div>  
                <div class="support-card">
                    <h3>Raisha</h3>
                    <p>ID: xxxxxxx</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: XXXXXXXXX</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: xxxxxxx@iub.edu.bd</p>
                </div>
                <div class="support-card">
                    <h3>Nupur</h3>
                    <p>ID: xxxxxxx</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: XXXXXXXXXXX</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: xxxxxxx@iub.edu.bd</p>
                </div>
                <div class="support-card">
                    <h3>Ramisa</h3>
                    <p>ID: xxxxxxx</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: XXXXXXXXXXX</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: xxxxxxx@iub.edu.bd</p>
                </div>
                <div class="support-card">
                    <h3>Juhaer</h3>
                    <p>ID: xxxxxxx</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: XXXXXXXXXXX</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: xxxxxxx@iub.edu.bd</p>
                </div>
                <div class="support-card">
                    <h3>Raihan</h3>
                    <p>ID: xxxxxxx</p>
                    <p><i class="fa-solid fa-phone"></i> Phone: XXXXXXXXXX</p>
                    <p><i class="fa-solid fa-envelope"></i> Email: xxxxxxx@iub.edu.bd</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 MeatFlow. All rights reserved.</p>
    </footer>
</body>
</html>
