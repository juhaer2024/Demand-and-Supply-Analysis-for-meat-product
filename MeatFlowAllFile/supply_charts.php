<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css"> <style>
        /* Optional: Style for the chart container */
        .chart-container {
            width: 80%;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <h2>🚚 Supply Charts 📦</h2>

    <?php
    include 'db.php';

    // SQL query to get the data
    $sql = "SELECT 
        d.DeliveryID AS SupplyID,
        d.DeliveryDate AS Date,
        d.DeliveryQuantity AS Quantity,
        d.DeliveryStatus AS Status,
        pb.BatchID AS BatchID,
        pb.BatchName AS BatchName,
        v.VendorName AS VendorName
    FROM DELIVERY d
    JOIN VENDOR v ON d.VendorID = v.VendorID
    JOIN PRODUCTION_BATCH pb ON d.BatchID = pb.BatchID
    ORDER BY d.DeliveryID DESC";

    $result = $conn->query($sql);

    // Prepare data for the charts
    $dates = [];
    $quantities = [];
    $statuses = [];
    $batches = [];
    $vendors = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dates[] = $row['Date'];
            $quantities[] = $row['Quantity'];
            $statuses[] = $row['Status'];
            $batches[] = $row['BatchName'];
            $vendors[] = $row['VendorName'];
        }
    } else {
        echo "<p>No data available to generate charts.</p>";
    }
    $conn->close();
    ?>

    <div class="chart-container">
        <canvas id="quantityChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="statusChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="batchChart"></canvas>
    </div>

    <div class="chart-container">
        <canvas id="vendorChart"></canvas>
    </div>

    <script>
    // Get the chart contexts
    const quantityCtx = document.getElementById('quantityChart').getContext('2d');
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const batchCtx = document.getElementById('batchChart').getContext('2d');
    const vendorCtx = document.getElementById('vendorChart').getContext('2d');

    // --- Quantity Chart ---
    new Chart(quantityCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Quantity Delivered',
                data: <?php echo json_encode($quantities); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Light green
                borderColor: 'rgba(75, 192, 192, 1)',       // Darker green
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Delivery Quantity Over Time',
                fontSize: 18
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    // --- Status Chart ---
    const statusCounts = {};
    <?php foreach ($statuses as $status) { ?>
        statusCounts['<?php echo $status; ?>'] = (statusCounts['<?php echo $status; ?>'] || 0) + 1;
    <?php } ?>
    const statusLabels = Object.keys(statusCounts);
    const statusData = Object.values(statusCounts);

    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Delivery Status',
                data: statusData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',    // Red
                    'rgba(54, 162, 235, 0.6)',   // Blue
                    'rgba(255, 206, 86, 0.6)',  // Yellow
                    'rgba(75, 192, 192, 0.6)', // Green
                    'rgba(153, 102, 255, 0.6)'  // Purple
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Delivery Status Distribution',
                fontSize: 18
            },
            legend: {
                position: 'top'
            }
        }
    });

    // --- Batch Chart ---
    const batchCounts = {};
    <?php foreach ($batches as $batch) { ?>
        batchCounts['<?php echo $batch; ?>'] = (batchCounts['<?php echo $batch; ?>'] || 0) + 1;
    <?php } ?>
    const batchLabels = Object.keys(batchCounts);
    const batchData = Object.values(batchCounts);

    new Chart(batchCtx, {
        type: 'bar',
        data: {
            labels: batchLabels,
            datasets: [{
                label: 'Deliveries by Batch',
                data: batchData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                  ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Deliveries per Batch',
                fontSize: 18
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

      // --- Vendor Chart ---
    const vendorCounts = {};
    <?php foreach ($vendors as $vendor) { ?>
        vendorCounts['<?php echo $vendor; ?>'] = (vendorCounts['<?php echo $vendor; ?>'] || 0) + 1;
    <?php } ?>
    const vendorLabels = Object.keys(vendorCounts);
    const vendorData = Object.values(vendorCounts);

    new Chart(vendorCtx, {
        type: 'doughnut',
        data: {
            labels: vendorLabels,
            datasets: [{
                label: 'Deliveries by Vendor',
                data: vendorData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                  ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Deliveries per Vendor',
                fontSize: 18
            },
            legend: {
                position: 'top'
            }
        }
    });

    </script>
    
</body>
</html>
