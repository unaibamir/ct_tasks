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
          <table id="dtDynamicVerticalScrollExample" class="table  table-bordered table-sm" cellspacing="0"
          width="100%">
          <thead class="thead-dark table-bordered">
            <tr>
             <th class="th-sm">Shift
             </th>
             <th class="th-sm">Task code
             </th>
             <th class="th-sm">Desctiption
             </th>
             <th class="th-sm">given-By
             </th>
             <th class="th-sm">Follow up
             </th>
             <th class="th-sm">Start date
             </th>
             <th class="th-sm">End Date
             </th>
             <th class="th-sm"> Update</th>
             <th class="th-sm"> Status</th>
           </tr>
         </thead>
         <tbody>

          <?php
          if(!empty($morning))
          {
            $i = 0;
            foreach ($morning as $key => $value) {
              $rowSpan = '';
              if ($i == 0)
              {
                $i++;
                $rowSpan = '<td rowspan="'.count($morning).'" style="background-color: #597829; color: white;"> Morning</td>';
              }

              $start_date = date('Y/m/d',strtotime($value->start_date));
              $end_date = date('Y/m/d',strtotime($value->end_date));

              echo '<tr>';
              echo $rowSpan;
              echo '<td>'.$value->t_code.'</td>';
              echo '<td>'.$value->t_description.'</td>';
              echo '<td>'.$value->given.'</td>';
              echo '<td>'.$value->follow.'</td>';
              echo '<td>'.$start_date.'</td>';
              echo '<td>'.$end_date.'</td>';
              echo '<td>';
              if (!empty($value->morningReports['update']))
              {
                foreach ($value->morningReports['update'] as $updates) {
                  echo $updates;
                  echo '</br>';
                }
              }              
              echo '</td>';
              echo '<td>';
              //$morning[2]->morningReports['status']
              if (!empty($value->morningReports['status']))
              {
                foreach ($value->morningReports['status'] as $value) {
                  echo $value;
                  echo '</br>';
                }
              }    
              echo '</td>';
              echo '</tr>';
            }
          }

          if(!empty($evening))
          {
            $i = 0;
            foreach ($evening as $key => $value) {
              $rowSpan = '';
              if ($i == 0)
              {
                $i++;
                $rowSpan = '<td rowspan="'.count($evening).'" style="background-color: #0c2442;color: white;"> Evening</td>';
              }

              $start_date = date('Y/m/d',strtotime($value->start_date));
              $end_date = date('Y/m/d',strtotime($value->end_date));

              echo '<tr>';
              echo $rowSpan;
              echo '<td>'.$value->t_code.'</td>';
              echo '<td>'.$value->t_description.'</td>';
              echo '<td>'.$value->given.'</td>';
              echo '<td>'.$value->follow.'</td>';
              echo '<td>'.$start_date.'</td>';
              echo '<td>'.$end_date.'</td>';
              echo '<td>';
              if (!empty($value->eveningReports['update']))
              {
                foreach ($value->eveningReports['update'] as $updates) {
                  echo $updates;
                  echo '</br>';
                }
              }              
              echo '</td>';
              echo '<td>';
              if (!empty($value->eveningReports['status']))
              {
                foreach ($value->eveningReports['status'] as $value) {
                  echo $value;
                  echo '</br>';
                }
              }              
              echo '</td>';
              echo '</tr>';
            }
          }
          ?>
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th>Task code
        </th>
        <th>Desctiption
        </th>
        <th>Given-By
        </th>
        <th>Follow up
        </th>
        <th>Start date
        </th>
        <th>End Date
        </th>
        <th>Update</th>
      </tr>
    </tfoot>
  </table>

</div>
</div>
</div>
</div>
</div>
      <!-- Dashboard for User body-->