<?php
include 'db.php';

// Fetch meat product data
$sql = "SELECT * FROM MEAT_PRODUCT";
$result = $conn->query($sql);

$names = [];
$prices = [];
$origins = [];

while ($row = $result->fetch_assoc()) {
    $names[] = $row['ProductName'];
    $prices[] = $row['ProductPrice'];
    $origins[] = $row['ProductOrigin'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meat Product Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
     <style>
        .chart-container {
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }

        /* Make it more responsive on smaller screens */
        @media (max-width: 600px) {
            .chart-container {
                width: 95%;
            }
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .chart-btn {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            margin: 10px;
        }

        .chart-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">📊 Meat Product Visualizations</h2>
    <div style="text-align:center;">
        <a href="productinfo.php">← Back to Meat Products</a>
    </div>

    <h3>Pie Chart: Meat Product Origin Distribution</h3>
    <div class="chart-container">
        <canvas id="pieChart"></canvas>
    </div>

    <h3>Bar Chart: Meat Product Name vs Price</h3>
    <div class="chart-container">
       <canvas id="barChart" style="margin-top: 40px;"></canvas>
    </div>

    <h3>Line Chart: Price Range of Meat Products</h3>
    <div class="chart-container">
        <canvas id="lineChart" style="margin-top: 40px;"></canvas>
    </div>

    <script>
        const names = <?php echo json_encode($names); ?>;
        const prices = <?php echo json_encode($prices); ?>;
        const origins = <?php echo json_encode($origins); ?>;

        // Generate dynamic colors for pie chart
        const generateColor = () => {
            return 'hsl(' + Math.random() * 360 + ', 100%, 50%)'; // Random HSL color
        };

        // Pie Chart (Origin distribution)
        const originCounts = {};
        origins.forEach(origin => {
            originCounts[origin] = (originCounts[origin] || 0) + 1;
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(originCounts),
                datasets: [{
                    label: 'Number of Products per Origin',
                    data: Object.values(originCounts),
                    backgroundColor: Object.keys(originCounts).map(() => generateColor())
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                 plugins: {
                    legend: {
                        position: 'top' //can be 'top', 'left', 'bottom', 'right', 'chartArea'
                    },
                },
            }
        });

        // Bar Chart (Prices of meat products)
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: 'Price in Tk.',
                    data: prices,
                    backgroundColor: '#36a2eb'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Line Chart (Prices trend across items)
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: names,
                datasets: [{
                    label: 'Price Trend',
                    data: prices,
                    borderColor: '#ff6384',
                    fill: false,
                    tension: 0.2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
     <div class="btn-container">
        <a href="productinfo.php">
            <button class="chart-btn">Back to Main Menu</button>
        </a>
    </div>
</body>
</html>
