<?php
 include 'db.php';
 

 // Function to fetch historical price data
 function getHistoricalPriceData($conn, $search = '') {
  $sql = "SELECT ProductionDate, BatchName, UnitPrice FROM PRODUCTION_BATCH"; //changed
  if (!empty($search)) {
  $searchTerm = mysqli_real_escape_string($conn, $search);
  $sql .= " WHERE BatchName LIKE '%$searchTerm%' OR ProductionDate LIKE '%$searchTerm%'";
  }
  $sql .= " ORDER BY ProductionDate";
  $result = $conn->query($sql);
 

  $data = [];
  if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $data[] = [
  'ProductionDate' => $row['ProductionDate'],
  'BatchName' => $row['BatchName'],
  'UnitPrice' => $row['UnitPrice']
  ];
  }
  }
  return $data;
 }
 

 // Fetch data for the chart
 $search = isset($_GET['search']) ? $_GET['search'] : '';
 $historicalData = getHistoricalPriceData($conn, $search);
 

 // Prepare data for Chart.js
 $batchNames = array_unique(array_column($historicalData, 'BatchName')); //get unique batch names
 

 $conn->close();
 ?>
 

 <!DOCTYPE html>
 <html>
 <head>
  <title>Historical Market Price Charts</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
  .chart-container {
  width: 80%;
  margin: 20px auto;
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  </style>
 </head>
 <body>
  <h2>📈 Historical Market Price Charts 📈</h2>
 

  <h3>🔍 Search Historical Prices for Charts</h3>
  <form method="GET" action="">
  <input type="text" name="search" placeholder="Search by Batch Name or Production Date" value="<?php echo htmlspecialchars($search); ?>">
  <button type="submit">Search</button>
  </form>
 

  <hr>
 

  <?php foreach ($batchNames as $batchName): ?>
  <div class="chart-container">
  <h4><?php echo "Batch Name: " . htmlspecialchars($batchName); ?></h4>
  <canvas id="priceChart_<?php echo str_replace(' ', '_', $batchName); ?>"></canvas>
  </div>
  <?php endforeach; ?>
 

  <script>
  const historicalData = <?php echo json_encode($historicalData); ?>;
  const batchNames = <?php echo json_encode($batchNames); ?>;
 

  batchNames.forEach(batchName => {
  const ctx = document.getElementById(`priceChart_${batchName.replace(' ', '_')}`).getContext('2d');
  
  // Filter data for the current batch name
  const batchData = historicalData.filter(item => item.BatchName === batchName);
  const dates = batchData.map(item => item.ProductionDate);
  const prices = batchData.map(item => item.UnitPrice);
  
  new Chart(ctx, {
  type: 'line',
  data: {
  labels: dates,
  datasets: [{
  label: 'Unit Price Trend',
  data: prices,
  borderColor: 'rgb(255, 99, 132)',
  tension: 0.4,
  fill: false
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
  text: `Historical Unit Price Trend for ${batchName}`,
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
 </body>
 </html>
 