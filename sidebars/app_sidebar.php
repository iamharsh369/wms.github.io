<div class="dashboard_sidebar" id="dashboard_sidebar">
  <h3 class="dashboard_logo" id="dashboard_logo">WMS</h3>
  <div class="dashboard_sidebar_user">
    <img src="images/char1.jpeg" alt="UserImage." id="UserImage" /><br />
  </div>
  <div class="dashboard_sidebar_menus">
    <ul class="dashboard_menu_lists">
    <!-- class="menuActive"   -->
     <li class="li_mainmenu">
        <a href="./home.php"
          ><i class="fi fi-rr-dashboard-panel"></i>
          <span class="menuText">Dashboard</span></a>
      </li>
      <li class="li_mainmenu showHideSubMenu">
        <a href="javascript:void(0);" class="showHideSubMenu" data-submenu="userSubMenu">
          <i class="fi fi-br-tags"></i>
          <span class="menuText">Products</span>
          <i class="fi fi-br-angle-left menuIconArrow"></i>
        </a>
        <ul id="userSubMenu" class="subMenus">
          <li><a class="submenuLink" href="product_view.php"><i class="fi fi-rr-circle circle"></i>View Products</a></li>
          <li><a class="submenuLink" href="product-add.php"><i class="fi fi-rr-circle circle"></i>Add Products</a></li>
        </ul>
      </li>

      <!-- <li class="li_mainmenu showHideSubMenu">
        <a href="javascript:void(0);" class="showHideSubMenu">
          <i class="fi fi-br-user-add"></i>
          <span class="menuText">Customer</span>
          <i class="fi fi-br-angle-left menuIconArrow"></i>
        </a>
        <ul class="subMenus">
          <li><a class="submenuLink" href="user_view.php"><i class="fi fi-rr-circle circle"></i>View Customer</a></li>
          <li><a class="submenuLink" href="add-supplier.php"><i class="fi fi-rr-circle circle"></i>Add Custtomer</a></li>
        </ul>
      </li> -->

    </ul>
  </div>
</div>