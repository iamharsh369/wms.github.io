var SideBarOpen = true;

togglebt.addEventListener("click", () => {
  event.preventDefault();

  if (SideBarOpen) {
    dashboard_sidebar.style.width = "5%";
    dashboard_sidebar.style.transition = "0.5s all";
    dasboard_content_container.style.width = "9 0%";
    dashboard_logo.style.fontSize = "40px";
    UserImage.style.width = "60px";
    charname.style.fontSize = "15px";

    menuIcons = document.getElementsByClassName("menuText");

    for (var i = 0; i < menuIcons.length; i++) {
      menuIcons[i].style.display = "none";
    }
    console.log(document.getElementsByClassName("dash_board_menulists"));
    SideBarOpen = false;
    document.getElementsByClassName("dashboard_menu_lists")[0].style.textAlign =
      "center";
  } else {
    dashboard_sidebar.style.width = "15%";
    dashboard_sidebar.style.transition = "0.5s all";
    dasboard_content_container.style.width = "80%";
    dashboard_logo.style.fontSize = "80px";
    UserImage.style.width = "80px";
    charname.style.fontSize = "20px";

    menuIconss = document.getElementsByClassName("menuText");
    for (var i = 0; i < menuIcons.length; i++) {
      menuIcons[i].style.display = "  inline-block";
    }
    SideBarOpen = true;
  }
});

// Submenu show /hide function.
document.addEventListener("click", function (e) {
  let target = e.target;

  // If the clicked element is not a submenu or a parent item with submenu
  if (!target.closest(".showHideSubMenu")) {
    // Hide all submenus
    document.querySelectorAll(".subMenus").forEach(function (menu) {
      menu.style.display = "none";
      menu.style.maxHeight = "0";
      menu.style.opacity = "0";
    });
  }
});

document.addEventListener("hover", function (e) {
  let target = e.target;

  // Check if the clicked element is a menu item that should toggle its submenu
  if (target.classList.contains("showHideSubMenu")) {
    let submenuId = target.dataset.submenu;
    let submenu = document.getElementById(submenuId);

    // Close all other submenus
    document.querySelectorAll(".subMenus").forEach(function (menu) {
      if (menu.id !== submenuId) {
        menu.style.display = "none";
        menu.style.maxHeight = "0";
        menu.style.opacity = "0";
      }
    });

    // Toggle the clicked submenu
    if (submenu) {
      if (submenu.style.display === "block") {
        submenu.style.display = "none";
        submenu.style.maxHeight = "0";
        submenu.style.opacity = "0";
      } else {
        submenu.style.display = "block";
        submenu.style.maxHeight = "500px"; // Adjust as needed
        submenu.style.opacity = "1";
      }
    }
  }
});
