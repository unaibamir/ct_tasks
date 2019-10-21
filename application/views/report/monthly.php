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
                <input type="text" class="form-control" placeholder="admin Job" value="Follow Up Smart Camera">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Given By</label>
                <input type="text" class="form-control" placeholder="Person Name" value="Hussain">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Follow Up</label>
                <input type="text" class="form-control" placeholder="admin Job" value="Amir">
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
     <table class="table table-bordered">
      <thead class="thead-dark table-bordered">
        <tr>
          <th scope="col"> Task code </th>
          <th colspan="1" scope="col">Desctiption</th>
          <th scope="col">given-By</th>
          <th scope="col">Follow up</th>
          <th scope="col">Start-Date</th>
          <th scope="col">End Date</th>
          <th scope="col">Action</th>                
        </tr>
      </thead>
      <tbody id="myTable">
        <?php

        if(!empty($tasks))
        {
          foreach ($tasks as $key => $value) 
          {
            $taskType = 1;
            $dark = ($taskType)? '' : 'dark';
            $start_date = date('d/m/Y',strtotime($value->start_date));
            $end_date = date('d/m/Y',strtotime($value->end_date));
            echo '<tr class="'.$dark.'" id="'.$key.'" onclick="toggleSibling(this);" >';
            echo '<th scope="row">'.$value->t_code.'</th>';
            echo '<td>'.$value->t_description.'</td>';
            echo '<td>'.$value->given.'</td>';
            echo '<td>'.$value->follow.'</td>';
            echo '<td>'.$start_date.'</td>';
            echo '<td>'.$end_date.'</td>';
            echo '<td><a href="javascript:;">Monthly Detail</a></td>';
            echo '';
            echo '</tr>';

            echo '<tr class="extra monthlyView"><td colspan="7"><table class="calender">';

            echo '<tr>
            <th>Day: Status</th>
            <th>Day: Status</th>
            <th>Day: Status</th>
            <th>Day: Status</th>
            <th>Day: Status</th>
            <th>Day: Status</th>
            <th>Day: Status</th>
            </tr>';

            if (!empty($CurrentMonthDates))
            {
              foreach ($CurrentMonthDates as $key => $weeks) 
              {

                /*echo (empty($weeks['Mon']))? '<td></td>':'';
                echo (empty($weeks['Tue']))? '<td></td>':'';
                echo (empty($weeks['Wed']))? '<td></td>':'';
                echo (empty($weeks['Thu']))? '<td></td>':'';
                echo (empty($weeks['Fri']))? '<td></td>':'';
                echo (empty($weeks['Sat']))? '<td></td>':'';
                echo (empty($weeks['Sun']))? '<td></td>':'';*/
                foreach ($weeks as $name => $day) {
                  echo '<td>';
                  echo $name.'-'.$day;
                  if (!empty($currentMonthReports))
                  {
                    $date1 = $day.'/'.date('m/Y');
                    foreach ($currentMonthReports as $key => $report) {
                      $date2 = date('d/m/Y', strtotime($report->created_at));
                      if ($date1 == $date2)
                      {
                        echo '<span class="table-status">'.$report->status.'</span>';
                      }
                    }
                  }
                  echo '</td>';
                }
                echo '</tr>';
              }
            }
            echo '</table></td></tr>';
          }

        }
        ?>
      </tbody>
    </table>
  </div>
</div>
</div>
</div>
</div>
      <!-- Dashboard for User body-->