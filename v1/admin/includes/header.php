<?php
if(!isset ($_SESSION['admin'])){
  header("Location: /login?err=You_have_not_logged_in");

}else{
 $admin = selectContent($conn, "admin", ['hash_id'=>$_SESSION['admin']])[0];

 if($admin['verification'] == 0){
   header("Location: /login?err=You_have_not_been_verified");
 }

 if($admin['admin_status'] == 0){
   header("Location: /login?err=You_have_been_suspended");
 }

}

 ?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <title><?= $site_name ?> - <?= $page_title ?></title>

  <link rel="shortcut icon" href="/assets/img/favicon.png">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap">

  <link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">

  <link rel="stylesheet" href="/assets/plugins/fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="/assets/plugins/datatables/datatables.min.css">

  <link rel="stylesheet" href="/assets/css/style5.css">
</script>
</head>
<body>

<div class="main-wrapper">

  <div class="header">

  <div class="header-left">
    <a href="/dashboard" class="logo">
      <!-- <img src="/assets/img/logo.png" alt="Logo"> -->
      <h4><?= $site_name ?></h4>
    </a>
    <a href="/dashboard" class="logo logo-small">
      <!-- <img src="/assets/img/logo-small.png" alt="Logo" width="30" height="30"> -->
      <h4>T.S</h4>
    </a>
  </div>

  <a href="javascript:void(0);" id="toggle_btn">
    <i class="fas fa-align-left"></i>
  </a>

  <!-- <div class="top-nav-search">
    <form>
      <input type="text" class="form-control" placeholder="Search here">
      <button class="btn" type="submit"><i class="fas fa-search"></i></button>
    </form>
  </div> -->


  <a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
  </a>


  <ul class="nav user-menu">

    <li class="nav-item dropdown noti-dropdown">
      <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
        <i class="far fa-bell"></i> <span class="badge badge-pill">3</span>
      </a>
      <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
          <span class="notification-title">Notifications</span>
          <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
        </div>
        <div class="noti-content">
          <ul class="notification-list">
            <li class="notification-message">
              <a href="#">
                <div class="media d-flex">
                  <span class="avatar avatar-sm flex-shrink-0">
                    <img class="avatar-img rounded-circle" alt="User Image" src="/assets/img/profiles/avatar-02.jpg">
                  </span>
                  <div class="media-body flex-grow-1">
                    <p class="noti-details"><span class="noti-title">Carlson Tech</span> has approved <span class="noti-title">your estimate</span></p>
                    <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="#">
                <div class="media d-flex">
                  <span class="avatar avatar-sm flex-shrink-0">
                    <img class="avatar-img rounded-circle" alt="User Image" src="/assets/img/profiles/avatar-11.jpg">
                  </span>
                  <div class="media-body flex-grow-1">
                    <p class="noti-details"><span class="noti-title">International Software Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
                    <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="#">
                <div class="media d-flex">
                  <span class="avatar avatar-sm flex-shrink-0">
                    <img class="avatar-img rounded-circle" alt="User Image" src="/assets/img/profiles/avatar-17.jpg">
                  </span>
                  <div class="media-body flex-grow-1">
                    <p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone XR</span></p>
                    <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="#">
                <div class="media d-flex">
                  <span class="avatar avatar-sm flex-shrink-0">
                    <img class="avatar-img rounded-circle" alt="User Image" src="/assets/img/profiles/avatar-13.jpg">
                  </span>
                  <div class="media-body flex-grow-1">
                    <p class="noti-details"><span class="noti-title">Mercury Software Inc</span> added a new product <span class="noti-title">Apple MacBook Pro</span></p>
                    <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>
        <div class="topnav-dropdown-footer">
          <a href="#">View all Notifications</a>
        </div>
      </div>
    </li>


    <li class="nav-item dropdown has-arrow">
      <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
        <span class="user-img"><img class="rounded-circle" src="/<?= $dummy ?>" width="31" alt="Ryan Taylor"></span>
      </a>
      <div class="dropdown-menu">
        <div class="user-header">
          <div class="avatar avatar-sm">
            <img src="/<?= $dummy ?>" alt="User Image" class="avatar-img rounded-circle">
          </div>
          <div class="user-text">
            <h6><?= $admin['input_firstname']." ".$admin['input_lastname'] ?></h6>
            <p class="text-muted mb-0">Administrator</p>
          </div>
        </div>
        <!-- <a class="dropdown-item" href="/profile">My Profile</a>
        <a class="dropdown-item" href="inbox.html">Inbox</a> -->
        <a class="dropdown-item" href="/logout">Logout</a>
      </div>
    </li>

  </ul>

</div>


<div class="sidebar" id="sidebar">
  <div class="sidebar-inner slimscroll">
    <div id="sidebar-menu" class="sidebar-menu">
      <ul>
        <li class="menu-title">
          <span>Main Menu</span>
        </li>
        <li class="<?php if($page_title == "Dashboard"){echo "active";} ?>">
          <a href="/dashboard"><i class="fas fa-th-large"></i> <span> Dashboard</span> </a>
        </li>
        <li class="submenu <?php if($page_title == "Create Students" || $page_title == "Manage Students"){echo "active";} ?>">
          <a href="#"><i class="fas fa-user-graduate"></i> <span> Students</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="/create/students">Add Student</a></li>
            <li><a href="/students">Manage Student</a></li>
          </ul>
        </li>
        <li class="submenu <?php if($page_title == "Create Teachers" || $page_title == "Manage Teachers"){echo "active";} ?>">
          <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span> Teachers</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="/create/teachers">Add Teacher</a></li>
            <li><a href="/manage/teachers">Manage Teachers</a></li>
          </ul>
        </li>
        <li class="submenu <?php if($page_title == "Create Roles" || $page_title == "Manage Roles"){echo "active";} ?>">
          <a href="#"><i class="fas fa-building"></i> <span> Roles</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="/create/roles">Add Role</a></li>
            <li><a href="/manage/roles">Manage Roles</a></li>
          </ul>
        </li>
        <li class="submenu <?php if($page_title == "Create Class" || $page_title == "Manage Class"){echo "active";} ?>">
          <a href="#"><i class="fas fa-school"></i> <span> Class</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="/create/class">Add Class</a></li>
            <li><a href="/manage/class">Manage Class</a></li>
          </ul>
        </li>
        <li class="submenu <?php if($page_title == "Create Subjects" || $page_title == "Manage Subjects"){echo "active";} ?>">
          <a href="#"><i class="fas fa-book-reader"></i> <span> Subjects</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="/create/subjects">Add Subject</a></li>
            <li><a href="/manage/subjects">Manage Subjects</a></li>
          </ul>
        </li>
        <li class="<?php if($page_title == "Fees Record"){echo "active";} ?>">
          <a href="/fees/students"><i class="fas fa-book-open"></i> <span> Fees Records</span> </a>
        </li>
        <li class="menu-title">
          <span>Management</span>
        </li>
        <li class="submenu">
          <a href="#"><i class="fas fa-file-invoice-dollar"></i> <span> Accounts</span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="fees-collections.html">Fees Collection</a></li>
            <li><a href="expenses.html">Expenses</a></li>
            <li><a href="salary.html">Salary</a></li>
            <li><a href="add-fees-collection.html">Add Fees</a></li>
            <li><a href="add-expenses.html">Add Expenses</a></li>
            <li><a href="add-salary.html">Add Salary</a></li>
          </ul>
        </li>
        <li>
          <a href="holiday.html"><i class="fas fa-holly-berry"></i> <span>Holiday</span></a>
        </li>
        <li>
          <a href="fees.html"><i class="fas fa-comment-dollar"></i> <span>Fees</span></a>
        </li>
        <li>
          <a href="exam.html"><i class="fas fa-clipboard-list"></i> <span>Exam list</span></a>
        </li>
        <li>
          <a href="event.html"><i class="fas fa-calendar-day"></i> <span>Events</span></a>
        </li>
        <li>
          <a href="time-table.html"><i class="fas fa-table"></i> <span>Time Table</span></a>
        </li>
        <li>
          <a href="library.html"><i class="fas fa-book"></i> <span>Library</span></a>
        </li>
        <li class="menu-title">
          <span>Pages</span>
        </li>
        <li class="submenu">
          <a href="#"><i class="fas fa-shield-alt"></i> <span> Authentication </span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="login.html">Login</a></li>
            <li><a href="register.html">Register</a></li>
            <li><a href="forgot-password.html">Forgot Password</a></li>
            <li><a href="error-404.html">Error Page</a></li>
          </ul>
        </li>
        <li>
          <a href="blank-page.html"><i class="fas fa-file"></i> <span>Blank Page</span></a>
        </li>
        <li class="menu-title">
          <span>Others</span>
        </li>
        <li>
          <a href="sports.html"><i class="fas fa-baseball-ball"></i> <span>Sports</span></a>
        </li>
        <li>
          <a href="hostel.html"><i class="fas fa-hotel"></i> <span>Hostel</span></a>
        </li>
        <li>
          <a href="transport.html"><i class="fas fa-bus"></i> <span>Transport</span></a>
        </li>
        <li class="menu-title">
          <span>UI Interface</span>
        </li>
        <li>
          <a href="components.html"><i class="fas fa-vector-square"></i> <span>Components</span></a>
        </li>
        <li class="submenu">
          <a href="#"><i class="fas fa-columns"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="form-basic-inputs.html">Basic Inputs </a></li>
            <li><a href="form-input-groups.html">Input Groups </a></li>
            <li><a href="form-horizontal.html">Horizontal Form </a></li>
            <li><a href="form-vertical.html"> Vertical Form </a></li>
            <li><a href="form-mask.html"> Form Mask </a></li>
            <li><a href="form-validation.html"> Form Validation </a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="#"><i class="fas fa-table"></i> <span> Tables </span> <span class="menu-arrow"></span></a>
          <ul>
            <li><a href="tables-basic.html">Basic Tables </a></li>
            <li><a href="data-tables.html">Data Table </a></li>
          </ul>
        </li>
        <li class="submenu">
          <a href="javascript:void(0);"><i class="fas fa-code"></i> <span>Multi Level</span> <span class="menu-arrow"></span></a>
          <ul>
            <li class="submenu">
              <a href="javascript:void(0);"> <span>Level 1</span> <span class="menu-arrow"></span></a>
              <ul>
                <li><a href="javascript:void(0);"><span>Level 2</span></a></li>
                <li class="submenu">
                  <a href="javascript:void(0);"> <span> Level 2</span> <span class="menu-arrow"></span></a>
                  <ul>
                    <li><a href="javascript:void(0);">Level 3</a></li>
                    <li><a href="javascript:void(0);">Level 3</a></li>
                  </ul>
                </li>
                <li><a href="javascript:void(0);"> <span>Level 2</span></a></li>
              </ul>
            </li>
            <li>
              <a href="javascript:void(0);"> <span>Level 1</span></a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
