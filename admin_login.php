<?php
session_start();

// Include the database connection file
include('databases/connection.php'); // Ensure this path is correct for your project

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the connection to the database was established
    if ($conn) {
        // Prepared statement with placeholders
        $query = 'SELECT * FROM useradmin WHERE user_name = :username AND password = :password LIMIT 1';
        $stmt = $conn->prepare($query);

        // Bind parameters to avoid SQL Injection
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Execute the query
        $stmt->execute();

        // Check if any rows are returned
        if ($stmt->rowCount() > 0) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $user = $stmt->fetch(); // Fetch a single row

            $_SESSION['user'] = $user;

            // Redirect to home.php
            header('Location: user_view.php');
            exit(); // Ensure no further code is executed
        } else {
            $error_message = 'Please make sure that username and password are correct.';
        }
    } else {
        $error_message = 'Database connection failed.';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Warehouse management system</title>
    <link rel="stylesheet" href="login.css" />
  </head>
  <body id="Loginbody">
    <?php if(!empty($error_message)){ ?>
        <div id="errormessage">
      <strong>Error:</strong><p><?= $error_message ?></p>
    </div>
      <?php } ?>
    
    
    <div class="container">
      <div class="loginheader">
        <h1>WMS</h1>
        <p>Admin-login</p>
      </div>    
      <div class="loginbody">
        <form class="Form" action="admin_login.php" method="POST" onsubmit="return resetForm()">
          <div class="LoginInputName">
            <label for="">Username</label>
            <input type="text" name="username" id="" placeholder="Username" />
          </div>
          <div class="LoginInputName">
            <label for="">Password</label>
            <input type="password" name="password" id="" placeholder="Password" />
          </div>

          <div>
            <button class="Loginbutton">Login</button>
          </div>
          <div>
            <button><a href="index.php">Back</a></button>
          </div>
          <img
            src="images/home-removebg-preview.png"
            alt="IMSlogo"
            class="image"
          />
          <div><p>WE MAKE IT EASY</p></div>
        </form>
        
      </div>
    </div>
    <script>
        function resetForm() {
            document.getElementById('myForm').reset();
            return false;
        }
    </script>
  </body>
</html>
