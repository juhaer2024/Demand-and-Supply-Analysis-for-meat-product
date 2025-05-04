<?php
include 'db.php';

// Fetch production batch data
$sql = "SELECT * FROM PRODUCTION_BATCH";
$result = $conn->query($sql);

$batchNames = [];
$productionCosts = [];
$productYields = [];
$productionDates = [];

while ($row = $result->fetch_assoc()) {
    $batchNames[] = $row['BatchName'];
    $productionCosts[] = $row['ProductionCost'];
    $productYields[] = $row['ProductYield'];
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

    <?php
    // Get unique years from production dates
    $years = array_unique(array_map(function ($date) {
        return date('Y', strtotime($date));
    }, $productionDates));

    // Create a pie chart for each year
    foreach ($years as $year) {
        echo "<div class=\"chart-container\">
                <h3>Pie Chart: Batch Name vs. Product Yield for $year</h3>
                <canvas id=\"yieldPieChart_$year\"></canvas>
              </div>";
    }
    ?>

    <script>
        const batchNames = <?php echo json_encode($batchNames); ?>;
        const productionCosts = <?php echo json_encode($productionCosts); ?>;
        const productYields = <?php echo json_encode($productYields); ?>;
        const productionDates = <?php echo json_encode($productionDates); ?>;
        const years = <?php echo json_encode($years); ?>;

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

        // Create pie charts for each year
        years.forEach(year => {
            // Filter data for the current year
            const yearData = productionDates.reduce((acc, date, index) => {
                if (date.includes(year)) {
                    acc.labels.push(batchNames[index]);
                    acc.yields.push(productYields[index]);
                }
                return acc;
            }, { labels: [], yields: [] });

            // Create the pie chart
            new Chart(document.getElementById(`yieldPieChart_${year}`), {
                type: 'pie',
                data: {
                    labels: yearData.labels,
                    datasets: [{
                        label: 'Product Yield',
                        data: yearData.yields,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)',
                            'rgba(255, 159, 64, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        title: {
                            display: true,
                            text: `Product Yield per Batch in ${year}`,
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
        });
    </script>
    <div class="btn-container">
        <a href="historical_production.php">
            <button class="chart-btn">Back to Main Menu</button>
        </a>
    </div>
</body>
</html>
