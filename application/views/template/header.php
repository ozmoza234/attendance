<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>PT. Rehobat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/images/logo-sm-rhb.png">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />

    <!-- Bootstrap Css -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" id="bootstrap-style" rel="stylesheet" type="text/css" media="all" />

    <!-- Icons Css -->
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" media="all" />

    <!-- App Css-->
    <link href="<?= base_url('assets/css/app.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" media="all" />
    <link href="<?= base_url('assets/css/fixedColumns.dataTables.min.css') ?>" id="app-style" rel="stylesheet" type="text/css" media="all" />

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
                                <img src="<?= base_url() ?>assets/images/logo-sm-rhb.png" alt="logo-sm" height="15">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo-lg-rhb.png" alt="logo-dark" height="20" width="115">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url() ?>assets/images/logo-sm.png" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url() ?>assets/images/logo-light.png" alt="logo-light" height="20" width="115">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                    <div class="dropdown d-inline-block">
                        <h5 class="text-center" style="margin-top: 24px;">Payroll Management System</h5>
                    </div>
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
                        <a href="<?= base_url() ?>Auth/dashboard" class="waves-effect">
                            <i class="mdi mdi-view-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-database-outline"></i>
                            <span>Human Resources</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="<?= base_url() ?>User">User</a></li>
                            <li><a href="<?= base_url() ?>Employee">Employee</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="ri-calendar-2-line"></i>
                            <span>Attendance</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="#" id='attBtn'>
                                    <span>Device Log</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('Attendance/indexE') ?>">Employee Log</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-currency-usd"></i>
                            <span>Finance</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="<?= base_url('Ump') ?>">
                                    <span>UMP</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <span>Salary</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="<?= base_url('Employee/salary') ?>">All Employee</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('Employee/op_kandang') ?>">Operator Kandang</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="#">Report</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-notebook-edit-outline"></i>
                            <span>SPL</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="#" id='attBtn'>
                                    <span>Form</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">Approval</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= base_url() ?>Auth/destroy" class="waves-effect">
                            <i class="mdi mdi-logout-variant"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url() ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url() ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/node-waves/waves.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>assets/js/app.js"></script>

    <!-- Data Tables -->
    <script src="<?= base_url() ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jszip.min.js"></script>
    <script src="<?= base_url() ?>assets/js/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>assets/js/vfs_fonts.js"></script>
    <script src="<?= base_url() ?>assets/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>assets/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>assets/js/dataTables.fixedColumns.min.js"></script>

    <!-- Swall Fire -->
    <script src="<?= base_url() ?>assets/js/sweetalert2.all.min.js"></script>

    <script src="<?= base_url() ?>assets/js/jquery.mask.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            $('#attBtn').on('click', function() {
                Swal.fire({
                    title: 'Warning!',
                    text: "Accessing this menu will cause lagging because of large data load. Is this okay?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!',
                    cancelButtonText: "No!",
                }).then(function(result) {
                    if (result.value) {
                        window.open('<?= base_url('Attendance') ?>', '_self');
                    }
                })
            })
        })
    </script>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">