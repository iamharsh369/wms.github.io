<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Place Order - Inventory Management System</title>
    <link rel="stylesheet" href="login.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css" />
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css" />
    <style>
        .form-input, .form-textarea {
            width: 100%;
            padding: 8px;
            margin: 4px 0;
            box-sizing: border-box;
        }
        .form-submit {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
        .form-submit:hover {
            background-color: #45a049;
        }
        .responseMessage {
            margin-top: 20px;
        }
        .responseMessage_success {
            color: green;
        }
        .responseMessage_error {
            color: red;
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
                            <h1 class="section_header"><i class="fi fi-br-plus"></i>Place Order</h1>
                        </div>
                    </div>
                    <div id="orderAddFormContainer">
                        <form action="databases/add-customers.php" method="post" class="product-form">
                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" class="form-input" required />
                            
                            <label for="customer_name" class="form-label">Customer Name:</label>
                            <input type="text" id="customer_name" name="customer_name" class="form-input" required />
                            
                            <label for="customer_contact" class="form-label">Customer Contact:</label>
                            <input type="text" id="customer_contact" name="customer_contact" class="form-input" required />
                            
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" class="form-input" min="1" required />
                            
                            <input type="submit" class="form-submit" value="Place Order" />
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
    <script src="js/script.js?v=<?= time(); ?>"></script>
</body>
</html>
