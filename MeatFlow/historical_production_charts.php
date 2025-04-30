<?php
include 'db.php';

// Fetch production batch data
$sql = "SELECT * FROM PRODUCTION_BATCH";
$result = $conn->query($sql);

$batchNames = [];
$productionCosts = [];
$productQualities = [];
$productionDates = [];

while ($row = $result->fetch_assoc()) {
    $batchNames[] = $row['BatchName'];
    $productionCosts[] = $row['ProductionCost'];
    $productQualities[] = $row['ProductQuality'];
    // Convert date to a format Chart.js understands
    $productionDates[] = date('Y-m-d', strtotime($row['ProductionDate']));
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Production Charts</title>
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
    <h2 style="text-align:center;">📊 Historical Production Visualizations 📊</h2>
    <div style="text-align:center;">
        <a href="historical_production.php">← Back to Historical Production</a>
    </div>

    <h3>Bar Chart: Batch Name vs. Production Cost</h3>
    <div class="chart-container">
        <canvas id="costChart"></canvas>
    </div>

    <h3>Line Chart: Production Date vs. Product Quality</h3>
    <div class="chart-container">
        <canvas id="qualityChart"></canvas>
    </div>

    
    <script>
        const batchNames = <?php echo json_encode($batchNames); ?>;
        const productionCosts = <?php echo json_encode($productionCosts); ?>;
        const productQualities = <?php echo json_encode($productQualities); ?>;
        const productionDates = <?php echo json_encode($productionDates); ?>;

        // Bar Chart: Batch Name vs. Production Cost
        new Chart(document.getElementById('costChart'), {
            type: 'bar',
            data: {
                labels: batchNames,
                datasets: [{
                    label: 'Production Cost',
                    data: productionCosts,
                    backgroundColor: '#4CAF50' // Green
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                 plugins: {
                    title: {
                        display: true,
                        text: 'Production Cost per Batch',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Line Chart: Production Date vs. Product Quality
        new Chart(document.getElementById('qualityChart'), {
            type: 'line',
            data: {
                labels: productionDates,
                datasets: [{
                    label: 'Product Quality',
                    data: productQualities,
                    borderColor: '#007BFF', // Blue
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Product Quality Over Time',
                        font: {
                            size: 16
                        }
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        
    </script>
    <div class="btn-container">
        <a href="historical_production.php">
            <button class="chart-btn">Back to Main Menu</button>
        </a>
    </div>
</body>
</html>
