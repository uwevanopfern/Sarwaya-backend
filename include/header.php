<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 6/25/2019
 * Time: 10:52 AM
 */

$admin_id = $_SESSION['id'];
$admin_name = $_SESSION['name'];
$admin_email = $_SESSION['email'];
$admin_phone = $_SESSION['phone'];
$admin_role = $_SESSION['role'];
$admin_agency = $_SESSION['agency'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="title icon" type="image/png" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>sarwaya</title>
</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-md navbar-light">
    <button class="navabr-toggler ml-auto mb-2 bg-light" type="button" data-toggle="collapse" data-target="#myNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="myNavbar">
        <div class="container-fluid">
            <div class="row">
                <!-- sidebar -->
                <div class="col-xl-2 col-lg-3 col-md-4 sidebar fixed-top" style="background-color: #4775d1;">
                    <a href="#" class="navbar-brand d-block mx-auto text-center py-3 mb-4 bottom-border"
                       style="color: #ffffff;font-weight: bold">
                        Sarwaya
                    </a>
                    <ul class="navbar-nav flex-column mt-4">
                        <li class="nav-item">
                            <a href="home.php" class="nav-link p-2 mb-2" style="color: #ffffff;font-size: 11px;">
                                <i class="fas fa-home fa-lg mr-3" style="color: #ffffff;"></i>
                                Dashboard
                            </a>
                        </li>
<!--                        <li class="nav-item">-->
<!--                            <a href="cars.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">-->
<!--                                <i class="fas fa-car fa-lg mr-3" style="color: #ffffff;"></i>-->
<!--                                Manage Cars-->
<!--                            </a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a href="schedule.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">-->
<!--                                <i class="fas fa fa-calendar fa-lg mr-3" style="color: #ffffff;"></i>-->
<!--                                Schedule cars-->
<!--                            </a>-->
<!--                        </li>-->
<!--                        <li class="nav-item">-->
<!--                            <a href="anonymous.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">-->
<!--                                <i class="fas fa fa-car fa-lg mr-3" style="color: #ffffff;"></i>-->
<!--                                Anonymous booking-->
<!--                            </a>-->
<!--                        </li>-->
                        <li class="nav-item">
                            <a href="locations.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                <i class="fas fa-map-marker fa-lg mr-3" style="color: #ffffff;"></i>
                                Manage Locations
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- end of sidebar -->

                <!-- top navbar -->
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto fixed-top py-2 top-navbar">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <ul class="navbar-nav">
                            <?php
                            //admin role = 1, sees everything in get all group
                            //admin role = 0, sees reports in get all group
                            //admin role = 2, belongs on agency and sees every including manage staff
                            //admin role = 3, dont manage staff, all view reports
                            if($admin_role == 1){
                                ?>
                                <li class="nav-item">
                                    <a href="agency.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        Add agency
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="agency_reports.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        All agencies report
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="agency_time.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        Add agency time
                                    </a>
                                </li>
                            <?php }

                            if($admin_role == 0){
                                ?>
                                <li class="nav-item">
                                    <a href="agency_reports.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        All agencies report
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reports.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        <i class="fas fa-list fa-lg mr-3" style="color: #ffffff;"></i>
                                        Agency Reports
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reports_by_dates.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        Reports by dates
                                    </a>
                                </li>

                            <?php }

                            if($admin_role == 1 || $admin_role == 2){
                                ?>
                                <li class="nav-item">
                                    <a href="staff.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        Manage Staff
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reports.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        Agency Reports
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="reports_by_dates.php" class="nav-link p-2 mb-2 sidebar-link" style="color: #ffffff;font-size: 11px;">
                                        Reports by dates
                                    </a>
                                </li>
                            </ul>

                            <?php } ?>
                        </div>
                        <div class="col-md-3">
                            <ul class="navbar-nav">
                                <li class="nav-item icon-parent">
                                    <a href="#" class="nav-link text-light ml-6" style="font-size: small;font-size: 11px;">
                                        <i class="fas fa-user text-white fa-md "></i>
                                        <?php echo $admin_email;?>
                                    </a>
                                </li>
                                <li class="nav-item ml-md-auto">
                                    <a href="logout.php" class="nav-link ml-2">
                                        <i class="fas fa-sign-out-alt text-danger fa-lg"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end of top navbar -->
            </div>
        </div>
    </div>
</nav>
<!-- end of navbar --

<!-- modal -->
<div class="modal fade" id="sign-out">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Want to leave?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                Press logout to leave
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Stay Here</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Logout</button>
            </div>
        </div>
    </div>
</div>
<!-- end of modal -->