<?php
 include 'db.php';
 

 // Fetch farm locations and counts
 $sql = "SELECT FarmLocation, COUNT(*) as location_count FROM Farm GROUP BY FarmLocation";
 $result = $conn->query($sql);
 

 $data = array();
 if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
  $data[] = array(
  'location' => $row['FarmLocation'],
  'count' => $row['location_count']
  );
  }
 }
 

 $conn->close();
 ?>
 

 <!DOCTYPE html>
 <html>
 <head>
  <title>Farm Location Pie Chart</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 </head>
 <body>
 

  <div style="width: 600px; margin: auto;">
  <canvas id="farmLocationChart"></canvas>
  </div>
 

  <script>
  const ctx = document.getElementById('farmLocationChart').getContext('2d');
  const chartData = {
  labels: [<?php echo "'" . implode("','", array_column($data, 'location')) . "'"; ?>],
  datasets: [{
  label: 'Number of Farms',
  data: [<?php echo implode(",", array_column($data, 'count')); ?>],
  backgroundColor: [
  'rgba(255, 99, 132, 0.6)',
  'rgba(54, 162, 235, 0.6)',
  'rgba(255, 206, 86, 0.6)',
  'rgba(75, 192, 192, 0.6)',
  'rgba(153, 102, 255, 0.6)',
  'rgba(255, 159, 64, 0.6)'
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
  };
 

  const myChart = new Chart(ctx, {
  type: 'pie',
  data: chartData,
  options: {
  title: {
  display: true,
  text: 'Farm Distribution by Location'
  }
  }
  });
  </script>
 

 </body>
 </html>