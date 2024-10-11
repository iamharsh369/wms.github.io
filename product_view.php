<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$_SESSION['table'] = 'products';
$user = $_SESSION['user'];

// Include database connection
include('databases/connection.php');

// Initialize variables for displaying response messages if needed
$response_message = '';
$is_success = true;

// Handle Delete Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $product_id = $_POST['product_id'] ?? '';

    if ($product_id) {
        try {
            // Delete the product from the database
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            
            $is_success = true;
            $response_message = 'Product deleted successfully.';
        } catch (PDOException $e) {
            $is_success = false;
            $response_message = 'Error: ' . htmlspecialchars($e->getMessage());
        }
    }
}

// Handle Update Stock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $product_id = $_POST['product_id'] ?? '';
    $new_stock = $_POST['new_stock'] ?? '';

    if ($product_id && is_numeric($new_stock)) {
        try {
            // Update the stock of the product in the database
            $stmt = $conn->prepare("UPDATE products SET stock = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$new_stock, $product_id]);

            $is_success = true;
            $response_message = 'Stock updated successfully.';
        } catch (PDOException $e) {
            $is_success = false;
            $response_message = 'Error: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        $is_success = false;
        $response_message = 'Invalid input for stock update.';
    }
}

// Fetch product data from the database
try {
    $stmt = $conn->prepare("SELECT id, product_name, description, stock, company_name FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>View Products - Inventory Management System</title>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #023047;
            color: white;
        }
        .responseMessage_success {
            color: green;
            margin-top: 20px;
        }
        .responseMessage_error {
            color: red;
            margin-top: 20px;
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
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fi fi-br-user"></i>View Products</h1>
                        </div>
                    </div>

                    <?php if (!empty($response_message)): ?>
                        <div class="responseMessage">
                            <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                <?= htmlspecialchars($response_message) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div id="productTableContainer">
                        <?php if ($is_success && !empty($products)): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Description</th>
                                        <th>Stock</th>
                                        <th>Company Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                                            <td><?= htmlspecialchars($product['description']) ?></td>
                                            <td><?= htmlspecialchars($product['stock']) ?></td>
                                            <td><?= htmlspecialchars($product['company_name']) ?></td>
                                            <td>
                                                <!-- Update Stock Form -->
                                                <form action="product_view.php" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <input type="number" name="new_stock" placeholder="New Stock" required>
                                                    <button type="submit">Update</button>
                                                </form>

                                                <!-- Delete Product Form -->
                                                <form action="product_view.php" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No products found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
