// Chart.js Example for Demand Trends and Price Trends

// Demand Trends Chart
var ctx1 = document.getElementById('demand-chart').getContext('2d');
var demandChart = new Chart(ctx1, {
  type: 'line',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May'],
    datasets: [{
      label: 'Demand Trends',
      data: [50, 75, 100, 125, 150],
      borderColor: '#ff3c3c',
      backgroundColor: 'rgba(255, 60, 60, 0.2)',
      borderWidth: 2,
      fill: true
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        display: false
      }
    }
  }
});

// Price Trends Chart
var ctx2 = document.getElementById('price-chart').getContext('2d');
var priceChart = new Chart(ctx2, {
  type: 'line',
  data: {
    labels: ['January', 'February', 'March', 'April', 'May'],
    datasets: [{
      label: 'Price Trends',
      data: [300, 320, 340, 360, 380],
      borderColor: '#ff3c3c',
      backgroundColor: 'rgba(255, 60, 60, 0.2)',
      borderWidth: 2,
      fill: true
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        display: false
      }
    }
  }
});
