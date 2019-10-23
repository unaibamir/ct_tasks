<?php
defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->

<style type="text/css">
  table.dataTable thead .sorting:after,
  table.dataTable thead .sorting:before,
  table.dataTable thead .sorting_asc:after,
  table.dataTable thead .sorting_asc:before,
  table.dataTable thead .sorting_asc_disabled:after,
  table.dataTable thead .sorting_asc_disabled:before,
  table.dataTable thead .sorting_desc:after,
  table.dataTable thead .sorting_desc:before,
  table.dataTable thead .sorting_desc_disabled:after,
  table.dataTable thead .sorting_desc_disabled:before {
    bottom: .5em;
  }

  thead {
    font-size: 10px;
  }
  th, td {
    font-size: 10px;
  }
  .dark{
    background: #b9b2b1;
  }

  .extra {
    display: none;
  }
  .monthlyView{

  }

  .calender{
    width: 100%;
  }

  .table-status{
    font-weight: 800;
    margin-left: 20px;
  }

</style>
<?php
$job_types = array(
  1 => "Daily",
  2 => "Weekly",
  3 => "Monthly",
  4 => "One Time"
);
?>
<div class="panel-header panel-header-sm">
</div>

<!-- Dashboard for User -->
<div class="content">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <!-- <h5 class="title"> Task Form</h5> -->
        </div>
        <div class="card-body">
          <div id="calendar"></div>

          <form>
            <div class="row">
              <div class="col-md-4 pr-1">
               <div class="form-group">
                <label>Employee Code</label>
                <input type="text" class="form-control" placeholder="admin Job" value="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Given By</label>
                <input type="text" class="form-control" placeholder="Person Name" value="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Follow Up</label>
                <input type="text" class="form-control" placeholder="admin Job" value="">
              </div>
            </div>
          </div>
          <div class="row">

            <div class="col-md-4 pr-1">
              <div class="form-group">
               <label >Start Date</label>
               <input type="date" name="bday" max="3000-12-31" 
               min="1000-01-01" class="form-control">
             </div>
           </div>
           <div class="col-md-4 pl-1">
            <div class="form-group">
             <label >End Date</label>
             <input type="date" name="bday" min="1000-01-01"
             max="3000-12-31" class="form-control">
           </div>
         </div>


       </div>
     </form>

     <h3 class="m-4">Monthly Job Summary View for Employee Only </h3>
  
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead class="thead-dark">
            <tr class="d-flex">
              <th scope="col" style="width: 100px;">Task Code</th>
              <th scope="col" style="width: 100px;">Task Title</th>
              <th scope="col" style="width: 300px;">Desctiption</th>
              <th scope="col" style="width: 100px;">Given By</th>
              <th scope="col" style="width: 100px;">Follow up</th>
              <th scope="col" style="width: 100px;">Job Type</th>
              <th scope="col" style="width: 100px;">Start Date</th>
              <th scope="col" style="width: 100px;">End Date</th>
              <?php foreach ($month_dates as $date_dig => $date_alpha) {
                ?>
                  <th scope="col" style="width: 60px;"><?php echo $date_alpha ."- ". $date_dig ?></th>
                <?php
              } ?>
            </tr>
          </thead>
          <tbody>
            
              <?php
              foreach ($tasks as $key => $task) {
                if( $currentUserGroup == "Employee" && $currentUser->id != $task->assignee ) {
                  continue;
                }
                $start_date = date('d/m/Y',strtotime($task->start_date));
                $end_date = date('d/m/Y',strtotime($task->end_date));
                ?>
                  <tr class="d-flex" id="task-<?php echo $task->tid; ?>">
                    <td style="width: 100px;"><?php echo $task->t_code; ?></td>
                    <td style="width: 100px;"><?php echo $task->t_title; ?></td>
                    <td style="width: 300px;"><?php echo $task->t_description; ?></td>
                    <td style="width: 100px;"><?php echo $task->given; ?></td>
                    <td style="width: 100px;"><?php echo $task->follow; ?></td>
                    <td style="width: 100px;"><?php echo $job_types[$task->parent_id]; ?></td>
                    <td style="width: 100px;"><?php echo $start_date; ?></td>
                    <td style="width: 100px;"><?php echo $end_date; ?></td>
                    <?php 
                    foreach ($month_dates as $date_dig => $date_alpha) {
                      ?>
                      <td style="width: 60px;">
                        <?php
                        $date1 = $date_dig.'/'.date('m/Y');
                        foreach ($currentMonthReports as $report_key => $report) {

                          $date2 = date('d/m/Y', strtotime($report->created_at));
                          if ( $report->task_id == $task->tid && $date1 == $date2 ) {
                            echo '<span class="table-status">'.$report->status.'</span>';
                          }
                        }
                        ?>
                      </td>
                      <?php
                    }
                    ?>
                  </tr>
                <?php
              }
              ?>
            
          </tbody>
        </table>
      </div>
  </div>
</div>
</div>
</div>
</div>
      <!-- Dashboard for User body-->