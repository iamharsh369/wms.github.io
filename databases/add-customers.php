<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

// Include database connection
include('databases/connection.php');

// Initialize variables for displaying response messages if needed
$response_message = '';
$is_success = true;

// Fetch products from the database
$products = [];
try {
    $stmt = $conn->prepare("SELECT id, product_name, stock FROM products WHERE stock > 0");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $is_success = false;
    $response_message = 'Error fetching products: ' . htmlspecialchars($e->getMessage());
}

// Handle Customer Order Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'] ?? '';
    $customer_contact = $_POST['customer_contact'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $order_quantity = $_POST['order_quantity'] ?? 0;
    $location = $_POST['location'] ?? '';

    // Validate input
    if ($customer_name && $customer_contact && $product_id && $order_quantity > 0 && $location) {
        try {
            // Start a transaction
            $conn->beginTransaction();

            // Insert customer order
            $orderStmt = $conn->prepare("INSERT INTO customers (customer_name, customer_contact, product_id, stock, location) VALUES (?, ?, ?, ?, ?)");
            $orderStmt->execute([$customer_name, $customer_contact, $product_id, $order_quantity, $location]);

            // Update product stock
            $updateStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $updateStmt->execute([$order_quantity, $product_id]);

            // Commit transaction
            $conn->commit();

            $response_message = 'Order placed successfully!';
        } catch (PDOException $e) {
            $conn->rollBack();
            $is_success = false;
            $response_message = 'Error placing order: ' . htmlspecialchars($e->getMessage());
        }
    } else {
        $is_success = false;
        $response_message = 'Please fill in all fields and ensure the quantity is greater than 0.';
    }
}

// Pass data to the HTML form for display
include('add-supplier.php'); // Include HTML form
