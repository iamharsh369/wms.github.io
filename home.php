<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$user = $_SESSION['user'];

// Include database connection
include('databases/connection.php');

// Initialize variables for displaying response messages if needed
$response_message = '';
$is_success = true;
$product_data = [];

// Fetch product data from the database
try {
    $stmt = $conn->prepare("SELECT product_name, stock FROM products");
    $stmt->execute();
    $product_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $is_success = false;
    $response_message = 'Error: ' . htmlspecialchars($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Inventory Management System</title>
    <link rel="stylesheet" href="login.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Add some basic styling for the chart container */
        #chartContainer {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div id="dashboardMaincontainer">
        <?php include('sidebars/app_sidebar.php'); ?>
        <div class="dasboard_content_container" id="dasboard_content_container">
            <?php include('sidebars/topnav.php'); ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <h1>Product Stock Overview</h1>
                    <div id="chartContainer">
                        <canvas id="stockChart"></canvas>
                    </div>
                    <?php if (!$is_success): ?>
                        <div class="responseMessage">
                            <p class="responseMessage_error"><?= $response_message ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Prepare data for the chart
        var productData = <?php echo json_encode($product_data); ?>;
        
        var labels = productData.map(function(item) {
            return item.product_name;
        });
        
        var data = productData.map(function(item) {
            return item.stock;
        });
        
        var ctx = document.getElementById('stockChart').getContext('2d');
        var stockChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stock Quantity',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
