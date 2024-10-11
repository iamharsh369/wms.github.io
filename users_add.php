<?php
  session_start();
  if(!isset($_SESSION['user'])) header('location: login.php');
  $_SESSION['table']='users';
  $user = ($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add User-Inventory management system</title>
    <link rel="stylesheet" href="login.css?v=<?= time(); ?>">
    <link
      rel="stylesheet"
      href="https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn-uicons.flaticon.com/2.5.1/uicons-regular-rounded/css/uicons-regular-rounded.css"
    />
  </head>
  <body>
    <div id="dashboardMaincontainer" id="dashboardMaincontainer">
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
                <h1 class="section_header"><i class="fi fi-br-plus"></i>Create User</h1>
              </div>
            </div>
            <div id="userAddFormContainer">
              <form action="databases/user-add.php" method="POST" class="appForm">
                <div class="appFormInputContainer">
                  <label for="first_name">First Name</label>
                  <input type="text" class="appFormInput" id="first_name" name="first_name">
                </div class="appFormInputContainer">
                <div>
                  <label for="last_name">Last Name</label>
                  <input type="text" class="appFormInput" id="last_name" name="last_name">
                </div>
                <div class="appFormInputContainer">
                  <label for="email">Email</label>
                  <input type="text" class="appFormInput" id="email" name="email">
                </div>
                <div class="appFormInputContainer">
                  <label for="password">Password</label>
                  <input type="text" class="appFormInput" id="password" name="password">
                </div>  
                <button type="submit" class="appBT"><i class="images/tick-inside-circle.png"></i>Add User</button>
              </form>
              <?php 
                if(isset($_SESSION['response'])){ 
                  $response_message = $_SESSION['response']['message'];
                  $is_success = $_SESSION['response']['success'];
                ?>
                <div class="responseMessage">
                  <p class="<?= $is_success ? 'responseMessage_success' : 'responseMessage_erroe' ?>">
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
