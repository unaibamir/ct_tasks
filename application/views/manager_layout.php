<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/apple-icon.png');?>">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.png');?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
     Gulf Environment & Waste fZE
 </title>
 <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/now-ui-dashboard.css?v=1.3.0'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />

    <script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <script type="text/javascript">
     $('#myButton').click(function() {
         $.scrollTo($('#myDiv'), 1000);
     });
 </script>

</head>

<body>
    <div class="wrapper ">
        <!-- Side-Bar is starting from here -->
        <div class="sidebar" data-color="blue">
            <div class="logo">
                <div class=" col-md-12 d-flex">
                    <img src="<?php echo base_url('assets/img/logo.png'); ?>" />
                </div>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li  style="background: #0c2442;border-right: 4px solid #eaebf0;">
                        <a href="<?php echo base_url('dashboard'); ?>">
                            <i class="now-ui-icons design_app"></i>
                            <p><?php echo $nav1; ?></p>
                        </a>
                    </li>
                    <?php if ($this->aauth->is_group_allowed('add_task', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('task/add'); ?>">
                                <i class="now-ui-icons gestures_tap-01 "></i>
                                <p>Add New Task</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('alert_tasks', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('task/alert'); ?>">
                                <i class="now-ui-icons users_single-02 "></i>
                                <p>New Task Alert</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('daily_report', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('report/daily'); ?>">
                                <i class="now-ui-icons files_paper"></i>
                                <p>Daily Report</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('monthly_report', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('report/monthly'); ?>">
                                <i class="now-ui-icons business_badge"></i>
                                <p>Job Summary Monthy View</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('finish_task', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('task/finish'); ?>">
                                <i class="now-ui-icons ui-1_bell-53"></i>
                                <p>Finish Task</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('enquiry_form', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('enquiry'); ?>">
                                <i class="now-ui-icons business_badge"></i>
                                <p>Enquiry Form</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('profile_user', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('user/'.$currentUser->username); ?>">
                                <i class="now-ui-icons users_single-02 "></i>
                                <p>Your Profile</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('all_task', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('task'); ?>">
                                <i class="now-ui-icons gestures_tap-01 "></i>
                                <p>Task Listing</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('view_employees', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('employee/'); ?>">
                                <i class="now-ui-icons users_single-02"></i>
                                <p>View Employees Report</p>
                            </a>
                        </li>
<!--
                        <li>
                            <a href="<?php echo base_url('employee/all'); ?>">
                                <i class="now-ui-icons users_single-02"></i>
                                <p>View All Employees</p>
                            </a>
                        </li>
-->
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('assign_task', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('task/assign'); ?>">
                                <i class="now-ui-icons education_glasses"></i>
                                <p>Task Assign</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('history_task', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('task/history'); ?>">
                                <i class="now-ui-icons business_badge"></i>
                                <p>Task History</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('forum', $currentUserGroup)): ?>
                        <li>
                            <a href="<?php echo base_url('forum'); ?>">
                                <i class="now-ui-icons ui-1_bell-53"></i>
                                <p>Dicussion Forum</p>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($this->aauth->is_group_allowed('search', $currentUserGroup)): ?>
                        <li style="background: #0c2442;border-right: 4px solid #eaebf0;">
                            <a href="<?php echo base_url('search'); ?>">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                                <p>Advance Search</p>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- Side-Bar is ENDING -->

        <div class="main-panel" id="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href=""><?php echo $heading1?></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <form action="">
                            <div class="input-group no-border">
                                <input type="text" value="" class="form-control" placeholder="Search...">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <i class="now-ui-icons ui-1_zoom-bold"></i>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <i class="now-ui-icons media-2_sound-wave"></i>
                                    <p><span class="d-lg-none d-md-block">Stats</span></p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons location_world"></i>
                                    <p><span class="d-lg-none d-md-block">Some Actions</span></p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo base_url('auth/logout')?>">Logout</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#pablo">
                                    <i class="now-ui-icons users_single-02"></i>
                                    <p><span class="d-lg-none d-md-block">Account</span></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->

            <?php echo $this->load->view($inc_page, '', true); ?>

            <footer class="footer">
                <div class="container-fluid">
                  <nav>
                    <ul>
                      <li>
                        <a href="http://www.gulfenviro.ae/">
                          GULF ENVIRONMENT & CO
                      </a>
                  </li>
                  <li>
                    <a href="http://www.gulfenviro.ae/">
                      News Alert
                  </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
              </a>
          </li>
      </ul>
  </nav>
  <div class="copyright" id="copyright">
    &copy;
    <script>
      document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
  </script>, Desgin & Code by
  <a href="http://www.gulfenviro.ae/" target="_blank">Amir Nisar</a>.
</div>
</div>
</footer>
</div>
</div>
    <!--   Core JS Files   -->
    <script src="<?php echo base_url('assets/js/core/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js');?>"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="<?php echo base_url('assets/js/plugins/chartjs.min.js');?>"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js');?>"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo base_url('assets/js/now-ui-dashboard.min.js?v=1.3.0');?>" type="text/javascript"></script>
    <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?php echo base_url('assets/demo/demo.js');?>"></script>
    <script src="<?php echo base_url('assets/js/script.js');?>"></script>
    <script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        //demo.initDashboardPageCharts();

        $('#table-list').DataTable();
    });
</script>
</body>
</html>