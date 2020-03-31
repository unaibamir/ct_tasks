<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>
<style type="text/css">
    .blink_me {
  animation: blinker 3s linear infinite;
  color: yellow;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<div class="panel-header Center" style="text-align: center;">
  <a class="navbar-brand " href=""><?php echo $heading2; ?></a><div class="blink_me"><h5>Download Portal Manual</h5></div>
  <button onclick="window.location.href = 'https://gewportal.com/uploads/tasks/task-1169/reports/Job_Reporting_Portal_Manual.pdf';"class="btn"><i class="fa fa-download"></i> GEW-Portal User Manual</button>
</div>
   <div class="content">
     <div class="row">

      <div class="col-lg-4">
        <div class="card card-chart text-center">
         <img class="card-img-top" src="https://www.iconshock.com/image/Sophistique/Project_management/responsability_assignment" alt="Card image cap" style="width: 25%;">
         <div class="card-body center">
          <h3 class="card-title">Check Assign Task</h3>
          <p class="card-text">New Task job is waiting for you</p>
          <a href="./task/alert" class="btn btn-primary">Check Now</a>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-4">
      <div class="card card-chart text-center">
       <img class="card-img-top" src="https://cdn2.iconfinder.com/data/icons/news-1/65/_Daily_News-512.png" alt="Card image cap" style="width: 25%;">
       <div class="card-body ">
        <h3 class="card-title">View Daily Job Report</h3>
        <p class="card-text">Submit your Daily Task Report.</p>
        <a href="./report/daily" class="btn btn-primary">View Now</a>
      </div>
    </div>
  </div>
  
  
  <div class="col-lg-4  col-md-6">
    <div class="card card-chart text-center">
     <img class="card-img-top" src="https://pngimage.net/wp-content/uploads/2018/05/akademik-png-8.png" alt="Card image cap" style="width: 23%;">
     <div class="card-body ">
      <h3 class="card-title"><?php echo lang("monthly_job_summary_text"); ?></h3>
      <p class="card-text"><?php echo lang('monthly_job_summary_paragraph_text'); ?></p>
      <a href="#" class="btn btn-primary"><?php echo lang('submit_now_text'); ?></a>
    </div>
  </div>
</div>
   

</div>

<div class="row">

  <div class="col-lg-4">
    <div class="card card-chart text-center">
      <img class="card-img-top" src="http://pluspng.com/img-png/task-png-regular-report-task-icon-256.png" alt="Card image cap" style="width: 25%;">
      <div class="card-body center">
        <h3 class="card-title">Finished Job</h3>
        <p class="card-text">All Finished Task & Executed Task over a Month</p>
        <a href="#" class="btn btn-primary">Click here</a>
      </div>
    </div>
  </div>

<div class="col-lg-4 ">
    <div class="card card-chart text-center">
      <img class="card-img-top" src="https://www.perspectiverisk.com/wp-content/uploads/2016/08/email-attachment-300x229.png" alt="Card image cap" style="width: 27%;">
      <div class="card-body center">
        <h3 class="card-title">Make an Enquiry </h3>
        <p class="card-text">Write Email or make Request</p>
        <a href="#" class="btn btn-primary">Write Email</a>
      </div>
    </div>
  </div>

  <div class="col-lg-4  col-md-6">
    <div class="card card-chart text-center">
     <img class="card-img-top" src="https://icon-library.net/images/system-administrator-icon/system-administrator-icon-2.jpg" alt="Card image cap" style="width: 21%;">
     <div class="card-body ">
      <h3 class="card-title">View Your Profile</h3>
      <p class="card-text">Submit your Daily Task Report.</p>
      <a href="#" class="btn btn-primary">View Your Profile</a>
    </div>
  </div>
</div>


</div>
<!--
<div class="row">

  <div class="col-lg-6 ">
    <div class="card card-chart text-center">
      <img class="card-img-top" src="https://www.perspectiverisk.com/wp-content/uploads/2016/08/email-attachment-300x229.png"" alt="Card image cap" style="width: 27%;">
      <div class="card-body center">
        <h3 class="card-title">Make an Enquiry </h3>
        <p class="card-text">Write Email or make Request</p>
        <a href="#" class="btn btn-primary">Write Email</a>
      </div>
    </div>
  </div>

  <div class="col-lg-6  col-md-6">
    <div class="card card-chart text-center">
     <img class="card-img-top" src="https://icon-library.net/images/system-administrator-icon/system-administrator-icon-2.jpg" alt="Card image cap" style="width: 21%;">
     <div class="card-body ">
      <h3 class="card-title">View Your Profile</h3>
      <p class="card-text">Submit your Daily Task Report.</p>
      <a href="#" class="btn btn-primary">View Your Profile</a>
    </div>
  </div>
</div>


</div>

-->

</div>