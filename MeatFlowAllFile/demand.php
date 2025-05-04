<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Meat Demand Records</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> </head>
<body>

<h2>📋 Meat Demand Records</h2>

<div style="margin-bottom: 20px;">
    <a href="demand_form.php" class="button">➕ Add New Demand</a>
</div>

<h3>🔍 Search Demand Records</h3>
<form method="GET" action="">
    <input type="text" name="search" placeholder="Search by Year, Region, or Product">
    <button type="submit">Search</button>
</form>

<hr>

<table>
    <tr>
        <th>Year</th>
        <th>Region</th>
        <th>Product</th>
        <th>Demand (kg)</th>
        <th>Consumption Pattern</th>
        <th>Price Elasticity</th>
        <th>Actions</th>
    </tr>

    <?php
    $sql = "SELECT d.*, m.ProductName 
            FROM demand d 
            JOIN meat_product m ON d.ProductID = m.ProductID";

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
        $sql .= " WHERE d.Year LIKE '%$searchTerm%' 
                   OR d.Region LIKE '%$searchTerm%' 
                   OR m.ProductName LIKE '%$searchTerm%'";
    }

    $sql .= " ORDER BY d.DemandID DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['Year']) . "</td>
                <td>" . htmlspecialchars($row['Region']) . "</td>
                <td>" . htmlspecialchars($row['ProductName']) . "</td>
                <td>" . htmlspecialchars($row['Demand']) . "</td>
                <td>" . htmlspecialchars($row['ConsumptionPattern']) . "</td>
                <td>" . htmlspecialchars($row['PriceElasticity']) . "</td>
                <td>
                    <a href='demand_form.php?edit=" . $row['DemandID'] . "'>Update</a> |
                    <a href='delete_demand.php?id=" . $row['DemandID'] . "' onclick=\"return confirm('Delete this record?');\">Delete</a>
                </td>
            </tr>";
    }
    ?>
</table>

<hr>

<h2>📊 Demand Charts</h2>

<div style="width: 45%; display: inline-block;">
    <h3>Pie Chart: Demand Share by Product</h3>
    <canvas id="pieChart"></canvas>
</div>

<div style="width: 45%; display: inline-block;">
    <h3>Line Chart: Demand Over Years</h3>
    <canvas id="lineChart"></canvas>
</div>

<?php
// Fetch data for charts
// Pie Chart - Demand per Product
$piesql = "SELECT m.ProductName, SUM(d.Demand) as totalDemand 
            FROM demand d 
            JOIN meat_product m ON d.ProductID = m.ProductID 
            GROUP BY m.ProductName";
$pieresult = $conn->query($piesql);

$productNames = [];
$productDemands = [];

while ($row = $pieresult->fetch_assoc()) {
    $productNames[] = $row['ProductName'];
    $productDemands[] = $row['totalDemand'];
}

// Line Chart - Demand per Year
$linesql = "SELECT Year, SUM(Demand) as yearlyDemand FROM demand GROUP BY Year ORDER BY Year ASC";
$lineresult = $conn->query($linesql);

$years = [];
$yearlyDemands = [];

while ($row = $lineresult->fetch_assoc()) {
    $years[] = $row['Year'];
    $yearlyDemands[] = $row['yearlyDemand'];
}
?>

<script>
// Pie Chart
const pieCtx = document.getElementById('pieChart').getContext('2d');
const pieChart = new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($productNames); ?>,
        datasets: [{
            data: <?php echo json_encode($productDemands); ?>,
            backgroundColor: ['#4caf50', '#f44336', '#2196f3', '#ff9800', '#9c27b0'],
            borderColor: '#333',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        }
    }
});

// Line Chart
const lineCtx = document.getElementById('lineChart').getContext('2d');
const lineChart = new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($years); ?>,
        datasets: [{
            label: 'Total Demand (tons)',
            data: <?php echo json_encode($yearlyDemands); ?>,
            backgroundColor: '#4caf50',
            borderColor: '#4caf50',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    color: 'white'
                }
            },
            x: {
                ticks: {
                    color: 'white'
                }
            }
        },
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        }
    }
});
</script>

</body>
</html>

