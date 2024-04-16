<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Monitoring</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script> <!-- Import Chart.js library -->
    <style>
        .chart-container {
            display: inline-block;
            width: 400px; /* Adjust the width as needed */
            margin-right: 20px; /* Adjust the margin as needed */
        }
    </style>
</head>
<body>
    <div class="chart-container">
        <canvas id="pieChart" width="400" height="400"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="pieChart1" width="400" height="400"></canvas>
    </div>
    <div class="chart-container">
        <canvas id="pieChart2" width="400" height="400"></canvas>
    </div>
    <script>
        // Function to fetch inventory data from PHP and render pie chart
        function fetchInventoryDataAndRenderChart(chartId) {
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    renderPieChart(data, chartId);
                })
                .catch(error => {
                    console.error('Error fetching inventory data:', error);
                });
        }

        // Function to render pie chart
        function renderPieChart(data, chartId) {
            const labels = data.map(item => item.item);
            const supplies = data.map(item => item.supply);

            const ctx = document.getElementById(chartId).getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Inventory Supply',
                        data: supplies,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.5)', // Red
                            'rgba(54, 162, 235, 0.5)', // Blue
                            'rgba(255, 206, 86, 0.5)' // Yellow
                            
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false
                }
            });
        }

        // Call the function to fetch data and render pie chart when the page loads
        fetchInventoryDataAndRenderChart('pieChart');
        fetchInventoryDataAndRenderChart('pieChart1');
        fetchInventoryDataAndRenderChart('pieChart2');
    </script>
</body>
</html>
