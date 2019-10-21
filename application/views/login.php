<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/apple-icon.png'); ?>">
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.png'); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>
    Gulf Environmdng & Co
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/css/now-ui-dashboard.css?v=1.3.0'); ?>" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo base_url('assets/demo/demo.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/demo/login.css'); ?>" rel="stylesheet"/>
</head>

<style type="text/css">
.invalid-feedback {
    /*display: block;*/
}
</style>
<body >
<div class="row m-4">
  <div class=" col-md-6 d-flex">
  <img src="<?php echo base_url('assets/img/logo.png'); ?>">
  </div>
</div>

<div class="container-fluid">

  <div class="d-flex justify-content-center h-100 ">
    <div class="card col-md-6">
      <div class="card-header">
        <h3>Gulf Enivronment Employee Login </h3>
     <!--   <div class="d-flex justify-content-end social_icon">
          <span><i class="fab fa-facebook-square"></i></span>
          <span><i class="fab fa-google-plus-square"></i></span>
          <span><i class="fab fa-twitter-square"></i></span>
        </div>

        -->
<?php $this->load->library('form_validation'); ?>
      </div>
      <div class="card-body">
      	<?php if($this->session->has_userdata('login_error')){ ?>
      		<div class="alert alert-danger">
      			<strong>Error! </strong> <?= $this->session->flashdata('login_error'); ?>
      		</div>
        <?php } ?>
      	<?php echo form_open('auth/login', array('id'=>'login_form'));?>
          <p style="color: white;"> Enter Your Employee Code & Password</p>
          <?php $error = form_error("username", "<div class='invalid-feedback'>", "</div>"); ?>
          <div class="input-group form-group">

            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user" style="color: white;"></i></span>
            </div>

            <input type="text" name="username" class="form-control <?php echo $error ? 'is-invalid': ''; ?> log" placeholder="Enter Your Employee" value="<?=set_value('username');?>"/>
            <?= $error ?>
            
          </div>

		  <?php $error = form_error("password", "<div class='invalid-feedback'>", "</div>"); ?>
          <div class="input-group form-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-key" style="color: white;"></i></span>
            </div>
            <input name="password" type="password" class="form-control <?php echo $error ? 'is-invalid': ''; ?> log" placeholder="Enter Your Password" value="<?=set_value('password');?>"/>
            <?= $error ?>

          </div>
         
          <div class="form-group d-flex justify-content-center">
            <a href="#" onclick="submitloginform();">
              <p>Login here</p>
            </a>
        </a>

          </div>
        <?php echo form_close();?>
      </div>
      <div class="card-footer">
        
        <div class="d-flex justify-content-center links" style="color: white;"  >
          <p href="#">Forgot your password?</p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6"><div class="footer-copyright text-center py-3">© 2019 Copyright:
    <a href="http://www.gulfenviro.ae/"> gulfenviro.ae</a>
  </div></div>
  <div class="col-md-3"></div>
</div>

  <!--   Core JS Files   -->
  <script src="<?php echo base_url('assets/js/core/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/popper.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/core/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/perfect-scrollbar.jquery.min.js'); ?>"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="<?php echo base_url('assets/js/plugins/chartjs.min.js'); ?>"></script>
  <!--  Notifications Plugin    -->
  <script src="<?php echo base_url('assets/js/plugins/bootstrap-notify.js'); ?>"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo base_url('assets/js/now-ui-dashboard.min.js?v=1.3.0'); ?>" type="text/javascript"></script>
  <!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="<?php echo base_url('assets/demo/demo.js'); ?>"></script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      demo.initDashboardPageCharts();

    });

    function submitloginform()
    {
    	//login_form
    	document.getElementById("login_form").submit();// Form submission

    }
  </script>
</body>

</html>