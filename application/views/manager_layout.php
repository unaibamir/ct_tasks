<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="<?php echo isset($_SESSION["site_lang"]) && $_SESSION["site_lang"] == "arabic" ? "ar" : "en";  ?>">

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
    <link href="<?php echo base_url('assets/css/datepicker.min.css'); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/custom.css?ver='.time()); ?>" rel="stylesheet" />

    <?php
    if( isset($_SESSION["site_lang"]) && !empty($_SESSION["site_lang"]) && $_SESSION["site_lang"] == "arabic" ) {
        ?>
        <link href="<?php echo base_url('assets/css/rtl.css?ver='.time()); ?>" rel="stylesheet" />
        <?php
    }
    ?>

    <script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>

    <script type="text/javascript">
        var base_url = "<?php echo base_url("/")?>";
        $('#myButton').click(function() {
            $.scrollTo($('#myDiv'), 1000);
        });
    </script>

    <script src="<?php echo base_url('assets/js/bootstrap-datepicker.min.js');?>"></script>
    <script>
        var datepicker = $.fn.datepicker.noConflict();
        $.fn.bootstrapBT = datepicker;

        
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body class="<?php echo isset($_SESSION["site_lang"]) && $_SESSION["site_lang"] == "arabic" ? "rtl" : "ltr";  ?>">
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
                    <?php if ($this->aauth->is_group_allowed('add_task', $currentUserGroup)) : ?>
                        <li>
                            <a href="<?php echo base_url('task/add'); ?>">
                                <i class="now-ui-icons gestures_tap-01 "></i>
                                <p><?php echo lang( 'add_new_task_text' ); ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('add_task', $currentUserGroup)) : ?>
                    <li>
                        <a href="<?php echo base_url('task/add/future'); ?>" >
                            <i class="now-ui-icons gestures_tap-01 "></i>
                            <p><?php echo lang( 'add_future_task_text' ); ?></p>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('all_task', $currentUserGroup)) : ?>
                    <li>
                        <a href="<?php echo base_url('task'); ?>" class="" role="button" aria-pressed="true">
                            <i class="now-ui-icons gestures_tap-01 "></i>
                            <p><?php echo lang( 'task_listing_text' ); ?></p>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('all_task', $currentUserGroup)) : ?>
                    <li>
                        <a href="<?php echo base_url('task/nov'); ?>" class="">
                            <i class="now-ui-icons gestures_tap-01 "></i>
                            <p><?php echo lang( 'nov_tasks_text' ); ?></p>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('view_employees', $currentUserGroup)) : ?>
                    <li>
                        <a href="<?php echo base_url('employee/'); ?>" class="" role="button" aria-pressed="true">
                            <i class="now-ui-icons gestures_tap-01 "></i>
                            <p><?php echo lang( 'view_employee_report_text' ); ?></p>
                        </a>
                    </li>
                    <?php endif; ?>


                    <?php if ($this->aauth->is_group_allowed('view_employees', $currentUserGroup)) : ?>
                    <li>
                        <a href="<?php echo base_url('employee/all'); ?>" class="" role="button" aria-pressed="true">
                            <i class="now-ui-icons gestures_tap-01 "></i>
                            <p><?php echo lang( 'employee_list_text' ); ?></p>
                        </a>
                    </li>
                    <?php endif; ?>                    

                    <?php if ($this->aauth->is_group_allowed('alert_tasks', $currentUserGroup)) : ?>
                        <li>
                            <a href="<?php echo base_url('task/alert'); ?>">
                                <i class="now-ui-icons users_single-02 "></i>
                                <p><?php echo lang( 'all_task_list_text' ); ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('daily_report', $currentUserGroup)) : ?>
                        <li>
                            <a href="<?php echo base_url('report/daily'); ?>">
                                <i class="now-ui-icons files_paper"></i>
                                <p><?php echo lang( 'daily_job_report_view_text' ); ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('monthly_report', $currentUserGroup)) : ?>
                        <li>
                            <a href="<?php echo base_url('report/monthly'); ?>">
                                <i class="now-ui-icons business_badge"></i>
                                <p><?php echo lang( 'monthly_job_summary_view_text' ); ?></p>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->aauth->is_group_allowed('alert_tasks', $currentUserGroup)) : ?>
                    <li>
                        <a href="<?php echo base_url('employee/all'); ?>">
                            <i class="now-ui-icons business_badge"></i>
                            <p><?php echo lang( 'employee_list_text' ); ?></p>
                        </a>                        
                    </li>
                    <?php endif; ?>


                    <?php if ($this->aauth->is_group_allowed('search', $currentUserGroup)) : ?>
                        <li style="background: #0c2442;border-right: 4px solid #eaebf0;">
                            <a href="<?php echo base_url('search'); ?>">
                                <i class="now-ui-icons ui-1_zoom-bold"></i>
                                <p><?php echo lang( 'advanced_search_text' ); ?></p>
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
                <div class="col-lg-2"> 
                        <div class=" navbar-wrapper">
                            <div class="navbar-toggle">
                                <button type="button" class="navbar-toggler">
                                    <span class="navbar-toggler-bar bar1"></span>
                                    <span class="navbar-toggler-bar bar2"></span>
                                    <span class="navbar-toggler-bar bar3"></span>
                                </button>
                            </div>
                            <a class="navbar-brand" href=""><?php echo $heading1?></a>

                            <!-- nav bar is updating from here -->
                      </div> 
             </div>

                    <div class="row">
                          <div class="row" >

<?php if ($this->aauth->is_group_allowed('add_task', $currentUserGroup)) : ?>
<a href="<?php echo base_url('task/add'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'add_new_task_text' ); ?>
</a>
<?php endif; ?>

<?php if ($this->aauth->is_group_allowed('add_task', $currentUserGroup)) : ?>
<a href="<?php echo base_url('task/add/future'); ?>" class="btn btn-link" role="button" aria-pressed="true">
<?php echo lang( 'add_future_task_text' ); ?>
</a>
<?php endif; ?>


<!-- Manager Side Nav -->

<?php if ($this->aauth->is_group_allowed('all_task', $currentUserGroup)) : ?>
<a href="<?php echo base_url('task'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'task_listing_text' ); ?>
</a>
<?php endif; ?>

<?php if ($this->aauth->is_group_allowed('all_task', $currentUserGroup)) : ?>
<a href="<?php echo base_url('task/nov'); ?>" class="btn btn-link"><?php echo lang( 'nov_tasks_text' ); ?></a>
<?php endif; ?>

<?php if ($this->aauth->is_group_allowed('view_employees', $currentUserGroup)) : ?>

<a href="<?php echo base_url('employee/'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'view_employee_report_text' ); ?>
</a>

<?php endif; ?>


<?php if ($this->aauth->is_group_allowed('view_employees', $currentUserGroup)) : ?>
<a href="<?php echo base_url('employee/all'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'employee_list_text' ); ?>
</a>
<?php endif; ?>

<?php if ($this->aauth->is_group_allowed('alert_tasks', $currentUserGroup)) : ?>

<a href="<?php echo base_url('task/alert'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang("all_assigned_task_text"); ?>
</a>

<?php endif; ?>
<?php if ($this->aauth->is_group_allowed('daily_report', $currentUserGroup)) : ?>

<a href="<?php echo base_url('report/daily'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'daily_job_report_view_text' ); ?>
</a>

<?php endif; ?>
<?php if ($this->aauth->is_group_allowed('monthly_report', $currentUserGroup)) : ?>

<a href="<?php echo base_url('report/monthly'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'monthly_job_summary_view_text' ); ?>
</a>

<?php endif; ?>


<?php if ($this->aauth->is_group_allowed('alert_tasks', $currentUserGroup)) : ?>
<a href="<?php echo base_url('employee/all'); ?>" class="btn btn-link" role="button" aria-pressed="true">
    <?php echo lang( 'employee_list_text' ); ?>
</a>
<?php endif; ?>

<?php if ($this->aauth->is_group_allowed('monthly_report', $currentUserGroup)) : ?>

<a href="https://email22.secureserver.net" class="btn btn-link" role="button" aria-pressed="true">
Send An Email
</a>
<?php endif; ?>
                         </div> 
                </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="langselector" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons location_world"></i> <?php echo lang('change_lang_text'); ?>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="langselector">
                                    <a class="dropdown-item" href="<?php echo base_url('LanguageSwitcher/switchLang/english')?>">English</a>
                                    <a class="dropdown-item" href="<?php echo base_url('LanguageSwitcher/switchLang/arabic')?>">العربية</a>
                                </div>
                            </li>
                           
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons users_single-02"></i>
                                    <p><span class="d-lg-none d-md-block">Some Actions</span></p>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="<?php echo base_url('user/change_password')?>">Change Password</a>
                                    <a class="dropdown-item" href="<?php echo base_url('auth/logout')?>">Logout</a>
                                </div>
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
                <a href="http://www.gulfenviro.ae/">
                  Blog
              </a>
          </li>
          <li>
                <a href="https://email22.secureserver.net">
                    Send Email :developer@gulfenviro.ae <strong>Click Here</strong> 
              </a>
          </li>
      </ul>
  </nav>
  <div class="copyright" id="copyright">
    &copy;
    <script>
      document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
  </script>, Design & Code by
  <a href="http://www.gulfenviro.ae/" target="_blank">GEW Developer</a>.
</div>
</div>
</footer>
</div>
</div>

    <!--   Core JS Files   -->
    <script src="<?php echo base_url('assets/js/core/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js');?>"></script>

    <!-- Chart JS -->
    <!--  Notifications Plugin    -->
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo base_url('assets/js/now-ui-dashboard.min.js?v=1.3.0');?>" type="text/javascript"></script>
    <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script src="<?php echo base_url('assets/demo/demo.js');?>"></script>
    <script src="<?php echo base_url('assets/js/script.js?ver='.time());?>"></script>
    <script>
    $(document).ready(function() {
        // Javascript method's body can be found in assets/js/demos.js
        //demo.initDashboardPageCharts();

        //$('#table-list').DataTable();
    });
</script>
</body>
</html>