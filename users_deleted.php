<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$_SESSION['table'] = 'users'; // Updated to reflect the users table
$user = $_SESSION['user'];

// Include database connection
include('databases/connection.php');

// Initialize variables for displaying response messages if needed
$response_message = '';
$is_success = true;

// Fetch user data from the database
try {
    $stmt = $conn->prepare("SELECT id, first_name, last_name, email FROM user_backup"); // Updated SQL query
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>View Users - Inventory Management System</title>
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
    <div class="dashboard_sidebar" id="dashboard_sidebar">
  <h3 class="dashboard_logo" id="dashboard_logo">WMS</h3>
  <div class="dashboard_sidebar_user">
    <img src="images/char1.jpeg" alt="UserImage." id="UserImage" /><br />
  </div>
  <div class="dashboard_sidebar_menus">
    <ul class="dashboard_menu_lists">
      <li class="li_mainmenu showHideSubMenu">
        <a href="javascript:void(0);" class="showHideSubMenu">
          <i class="fi fi-br-user-add"></i>
          <span class="menuText">User</span>
          <i class="fi fi-br-angle-left menuIconArrow"></i>
        </a>
        <ul class="subMenus">
          <li><a class="submenuLink" href="user_view.php"><i class="fi fi-rr-circle circle"></i>View Users</a></li>
          <li><a class="submenuLink" href="users_add.php"><i class="fi fi-rr-circle circle"></i>Add Users</a></li>
          <li><a class="submenuLink" href="users_deleted.php"><i class="fi fi-rr-circle circle"></i>Previous Users</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
        <div class="dasboard_content_container" id="dasboard_content_container">
        <div class="dashboard_topNav">
  <a href="" id="togglebt"><i class="fi fi-br-menu-burger"></i></a>
  <a href="./databases/logout.php" id="Logoutbt"><i class="fi fi-br-power"></i> Log-out</a>
</div>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column column-12">
                            <h1 class="section_header"><i class="fi fi-br-user"></i>Previous Users</h1>
                        </div>
                    </div>

                    <?php if (!empty($response_message)): ?>
                        <div class="responseMessage">
                            <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_error' ?>">
                                <?= htmlspecialchars($response_message) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div id="userTableContainer">
                        <?php if ($is_success): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="5">No users found</td> <!-- Adjusted colspan -->
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($user['id']) ?></td>
                                                <td><?= htmlspecialchars($user['first_name']) ?></td>
                                                <td><?= htmlspecialchars($user['last_name']) ?></td>
                                                <td><?= htmlspecialchars($user['email']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="responseMessage">
                                <p class="responseMessage_error"><?= $response_message ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
