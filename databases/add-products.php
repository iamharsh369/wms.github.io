<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the session variables are set
if (!isset($_SESSION['table']) || !isset($_SESSION['user'])) {
    die('Session table name or user is not set.');
}

$table_name = $_SESSION['table'];
$created_by = isset($_SESSION['user']['Id']) ? $_SESSION['user']['Id'] : null;

// Validate and sanitize input data
$product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
$stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]);
$company_name = filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_STRING);

// Check if required fields are filled
if (empty($product_name) || empty($company_name)) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Product name and company name are required.'
    ];
    header('Location: ../product-add.php');
    exit();
}

if ($stock === false) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Stock must be a non-negative integer.'
    ];
    header('Location: ../product-add.php');
    exit();
}

try {
    include('connection.php');
    
    // Ensure created_by is a numeric scalar value
    if (!is_numeric($created_by)) {
        throw new Exception('Invalid value for created_by.');
    }

    // Prepare the SQL query for inserting a new product
    $stmt = $conn->prepare("INSERT INTO $table_name (product_name, description, stock, company_name, created_by, created_at, updated_at) 
                            VALUES (:product_name, :description, :stock, :company_name, :created_by, NOW(), NOW())");
    $stmt->bindParam(':product_name', $product_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
    $stmt->bindParam(':company_name', $company_name);
    $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();
    
    // Set a success response
    $response = [
        'success' => true,
        'message' => 'Product "' . htmlspecialchars($product_name) . '" successfully added to the system.'
    ];
} catch (PDOException $e) {
    // Set an error response
    $response = [
        'success' => false,
        'message' => 'Database error: ' . htmlspecialchars($e->getMessage())
    ];
} catch (Exception $e) {
    // Handle general exceptions
    $response = [
        'success' => false,
        'message' => 'Error: ' . htmlspecialchars($e->getMessage())
    ];
}

// Store the response in the session and redirect
$_SESSION['response'] = $response;
header('Location: ../product-add.php');
exit();
?>
