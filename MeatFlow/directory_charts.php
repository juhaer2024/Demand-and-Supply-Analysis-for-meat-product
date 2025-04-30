<?php
include 'db.php';

// Count vendors by type
$sql = "SELECT VendorType, COUNT(*) as count FROM Vendor GROUP BY VendorType";
$result = $conn->query($sql);

$labels = [];
$data = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['VendorType'];
    $data[] = $row['count'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer/Seller Type Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: black;
            color: white;
            font-family: Arial;
            text-align: center;
            padding: 50px;
        }
        canvas {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            color: red;
        }
    </style>
</head>
<body>

    <h2>📊 Buyer/Seller Types: Buyers vs Sellers</h2>
    <canvas id="vendorChart" width="200" height="200"></canvas>

    <script>
        const ctx = document.getElementById('vendorChart').getContext('2d');
        const vendorChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Vendors',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: ['#4caf50', '#f44336'],
                    borderColor: '#000',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>