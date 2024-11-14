<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-theme="default" data-topbar="light" data-bs-theme="light">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="22">
                    </span>
                </a>
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="22">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">

                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link collapsed" href="index.php">
                                <i class="ph-gauge"></i> <span data-key="t-dashboards">Dashboards</span>
                            </a>
                            <!-- <div class="collapse menu-dropdown" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="dashboard-analytics.html" class="nav-link" data-key="t-analytics"> Analytics </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="dashboard-crm.html" class="nav-link" data-key="t-crm"> CRM </a>
                                    </li>

                                </ul>
                            </div> -->
                        </li>
                        <a class="nav-link menu-link collapsed" href="manage_employees.php">
                            <i class="fa-solid fa-users"></i><span data-key="t-dashboards">Manage Employees</span>
                        </a>
                        <a class="nav-link menu-link collapsed" href="attendence.php">
                            <i class="fa-solid fa-calendar"></i> <span data-key="t-dashboards">Attendance</span>
                        </a>
                        <a class="nav-link menu-link collapsed" href="leave_request.php">
                            <i class="fa-regular fa-comment-dots"></i><span data-key="t-dashboards">Leave Requests</span>
                        </a>
                        <a class="nav-link menu-link collapsed" href="admin_logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i> <span data-key="t-dashboards">Logout</span>
                        </a>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>