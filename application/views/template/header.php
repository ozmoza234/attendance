<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Attendance System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body data-topbar="light">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logo-sm.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo-light.png" alt="logo-light" height="20">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    <div class="dropdown d-inline-block">
                        <h4 class="text-center" style="margin-top: 24px;">Attendance System Company Name</h4>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                        <i class="ri-settings-2-line"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="#" class="waves-effect">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="waves-effect">
                                <i class="mdi mdi-account"></i>
                                <span>My Profile</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="mdi mdi-database"></i>
                                <span>Master</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="#">User</a></li>
                                <li><a href="#">Employee</a></li>
                                <li><a href="#">Division</a></li>
                                <!-- <li><a href="#">Work Hour</a></li> -->
                            </ul>
                        </li>

                        <li>
                            <a href="calendar.html" class=" waves-effect">
                                <i class="ri-calendar-2-line"></i>
                                <span>Attendance</span>
                            </a>
                        </li>

                        <li>
                            <a href="calendar.html" class=" waves-effect">
                                <i class="mdi mdi-logout-variant"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
                    <h5 class="m-0 me-2">Settings</h5>
                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>
                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>
                <div class="p-4">
                    <div class="mb-2">
                        <img src="<?= base_url() ?>assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
                    <div class="mb-2">
                        <img src="<?= base_url() ?>assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="<?= base_url() ?>assets/css/bootstrap-dark.min.css" data-appStyle="<?= base_url() ?>assets/css/app-dark.min.css">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
                    <div class="mb-2">
                        <img src="<?= base_url() ?>assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="<?= base_url() ?>assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>
                </div>
            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>


        <!-- apexcharts -->
        <script src="<?= base_url() ?>assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url() ?>assets/js/app.js"></script>


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">