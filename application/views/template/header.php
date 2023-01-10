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
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet" type="text/css" media="all" />

    <!-- Icons Css -->
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" media="all" />

    <!-- App Css-->
    <link href="<?= base_url('assets/css/app.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" media="all" />

    <!-- DataTables -->
    <link href="<?= base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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
                                <img src="<?= base_url() ?>assets/images/logo-dark.png" alt="logo-dark" height="20" width="150">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo-light.png" alt="logo-light" height="20" width="150">
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
                            <a href="<?= base_url() ?>Auth" class="waves-effect">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>Profile" class="waves-effect">
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
                                <li><a href="<?= base_url() ?>User">Employee</a></li>
                                <li><a href="#">Division</a></li>
                                <!-- <li><a href="#">Work Hour</a></li> -->
                            </ul>
                        </li>
                        <li>
                            <a href="#" class=" waves-effect">
                                <i class="ri-calendar-2-line"></i>
                                <span>Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>" class="waves-effect">
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

        <!-- JAVASCRIPT -->
        <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url() ?>assets/js/app.js"></script>

        <!-- Data Tables -->
        <script src="<?= base_url() ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="<?= base_url() ?>assets/js/pages/datatables.init.js"></script>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">