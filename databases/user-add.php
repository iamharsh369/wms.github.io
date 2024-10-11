<?php
// Start the session.
session_start();

// Set the table name explicitly (using 'users' since this is a user creation form)
$table_name = 'users'; // Remove dynamic table assignment from session

// Get POST data and sanitize it
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Check if all fields are filled out
if(empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    $_SESSION['response'] = [
        'success' => false,
        'message' => 'Please fill in all fields.'
    ];
    header('Location: ../users_add.php');
    exit();
}

// Encrypt the password
$encrypted = password_hash($password, PASSWORD_DEFAULT);

// Adding the record.
try {
    // Prepare the SQL command using prepared statements to avoid SQL injection
    include('connection.php');
    
    // Use the correct table name 'users'
    $command = $conn->prepare("INSERT INTO $table_name (first_name, last_name, email, password, created_at, update_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $command->execute([$first_name, $last_name, $email, $encrypted]);

    $response = [
        'success' => true,
        'message' => "$first_name $last_name successfully added to the system."
    ];
} catch (PDOException $e) {
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
}

// Store the response in the session
$_SESSION['response'] = $response;

// Redirect to the user add page
header('Location: ../users_add.php');
exit(); // Always exit after a redirect
?>
