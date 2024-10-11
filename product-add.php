<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}
$_SESSION['table'] = 'products';
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add Product - Inventory Management System</title>
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
            background-color: #f2f2f2;
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
                            <h1 class="section_header"><i class="fi fi-br-plus"></i>Create Products</h1>
                        </div>
                    </div>
                    <div id="userAddFormContainer">
                    <form action="databases/add-products.php" method="post" class="product-form">
                        <label for="product_name" class="form-label">Product Name:</label>
                        <input type="text" id="product_name" name="product_name" class="form-input" required />
                        
                        <label for="description" class="form-label">Description:</label>
                        <textarea id="description" name="description" class="form-textarea"></textarea>
                        
                        <label for="stock" class="form-label">Stock:</label>
                        <input type="number" id="stock" name="stock" class="form-input" min="0" required />
                        
                        <label for="company_name" class="form-label">Company Name:</label>
                        <input type="text" id="company_name" name="company_name" class="form-input" required />
                        
                        <input type="submit" class="form-submit" value="Add Product" />
                    </form>
                        <?php if (isset($_SESSION['response'])) { 
                            $response_message = $_SESSION['response']['message'];
                            $is_success = $_SESSION['response']['success']; ?>
                            <div class="responseMessage">
                                <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                    <?= $response_message ?>
                                </p>
                            </div>
                        <?php unset($_SESSION['response']); } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
