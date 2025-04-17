<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Dashboard</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
            <li class="breadcrumb-item">Dashboard</li>
        </ol>

        <div class="row">
            <!-- Pie Chart: In Use vs In Stock -->
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Inventory In Use vs In Stock
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="myPieChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donut Chart: Functional vs Lost vs Damaged -->
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Items in stock: Functional vs Lost vs Damaged
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="myDonutChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row: Bar and Line Charts -->
        <div class="row">
            <!-- Bar Chart -->
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Inventory Categories 
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChartAlt" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Line Chart -->
            <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-line me-1"></i>
                        Inventory Categories
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // PHP Data from backend
    var itemStates = <?php echo json_encode($itemStates); ?>;
    var itemCounts = <?php echo json_encode($itemCounts); ?>;
    var inUseCount = <?php echo json_encode($inUseCount); ?>;
    var inStockCount = <?php echo json_encode($inStockCount); ?>;

    // Donut Chart
    const ctxDonut = document.getElementById('myDonutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            labels: ['Functional', 'Lost', 'Damaged'],
            datasets: [{
                data: [itemStates.functional, itemStates.lost, itemStates.damaged],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1
        }
    });

    // Pie Chart
    const ctxPie = document.getElementById('myPieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['In Use', 'In Stock'],
            datasets: [{
                data: [inUseCount, inStockCount],
                backgroundColor: ['#ff6b6b', '#1cc88a'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1
        }
    });

    // Extract category names and counts
    const categoryLabels = itemCounts.map(item => item.category_name);
    const categoryData = itemCounts.map(item => item.item_count);

    // Bar Chart
    const ctxBarAlt = document.getElementById('barChartAlt').getContext('2d');
    new Chart(ctxBarAlt, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Item Count',
                data: categoryData,
                backgroundColor: '#36b9cc',
                borderColor: '#2c9faf',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1.5,
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });

    // Line Chart
    const ctxLine = document.getElementById('lineChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Item Count',
                data: categoryData,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: '#4e73df',
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#4e73df',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            aspectRatio: 1.5,
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });
</script>

<!-- Styling -->
<style>
    .chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 250px;
        width: 100%;
    }

    .chart {
        max-width: 100%;
        max-height: 100%;
    }

    .card-body {
        padding: 1rem;
    }
</style>

