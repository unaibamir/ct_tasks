<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
    th,
    td {
        font-size: 10px;
    }
    .dark {
        background: #b9b2b1;
    }
    .extra {
        display: none;
    }
    .monthlyView {}
    .calender {
        width: 100%;
    }
    .table-status {
        font-weight: 800;
        text-align: center;
        width: 100%;
        display: inline-block;
    }
    .table>tbody>tr>td {
        
    padding: 10px 5px;
height: 50px !important;

width: 29px !important;
font-size: 0.65em;
    }
    .table>tbody>tr>th {
        
    padding: 10px 5px;
height: 43px !important;
width: 27px !important;
font-size: 0.5em;
    }
    .table .thead-dark th {
    
    padding: 10px 5px;
height: 55px !important;
width: 29px !important;
font-size: 9px;
font-family: monospace;
border: 1px solid #e9e8e81f;
    }
.all-icons .font-icon-detail p {
    font-size: 1em;
    font-weight: bold;
    color: #5f5f5f;
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
                    <h5 class="title">Jobs Count</h5>
                </div>
                <div class="card-body all-icons">
                    <div class="row">
                        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6 text-danger">
                            <div class="font-icon-detail">
                                <h5 class="title"><?php echo !empty($tasks_count[0]["total"])? $tasks_count[0]["total"] : 0; ?></h5>
                                <p>Daily</p>
                            </div>
                        </div>
                        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6 text-danger ">
                            <div class="font-icon-detail">
                                <h5 class="title"><?php echo !empty($tasks_count[1]["total"])? $tasks_count[1]["total"] : 0; ?></h5>
                                <p>Weekly</p>
                            </div>
                        </div>
                        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6 text-danger">
                            <div class="font-icon-detail">
                                <h5 class="title"><?php echo !empty($tasks_count[2]["total"])? $tasks_count[2]["total"] : 0; ?></h5>
                                <p>Monthly</p>
                            </div>
                        </div>
                        <div class="font-icon-list col-lg-3 col-md-3 col-sm-4 col-xs-6 col-xs-6 text-danger">
                            <div class="font-icon-detail">
                                <h5 class="title"><?php echo !empty($tasks_count[3]["total"])? $tasks_count[3]["total"] : 0; ?></h5>
                                <p>One Time</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-lg-2">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">Monthly Job Summary View</h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                    <!-- <h3 class="m-4">Monthly Job Summary View </h3> -->
                    <div class="row ">
                        <?php //dd(var_export($employee, true)); ?>
                        <?php if( $employee ): ?>
                            <div class="col-md-3">
                                <h6 class=" m-1">Employee Code : </h6>
                                <p class="card-text mx-1 "><?php echo $employee->username; ?></p>
                            </div>
                            <div class="col-md-3">
                                
                                <h6 class="m-1">Employee Name:</h6>
                                <p class="card-text mx-2 ">
                                    <?php echo $employee->first_name; ?> <?php echo $employee->last_name; ?>
                                </p>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-3">
                            <h6 class="m-1">Current Date:</h6>
                            <?php

                            echo '<p class="car}d-text mx-2 ">' . date("d / m / Y", time() ) . '</p>';
                            ?>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo $export_url; ?>"  class="btn btn-primary btn-lg">
                                Download / Export
                            </a>
                            
                        </div>
                        
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-light">
                            <thead class="thead-dark">
                                <tr class="d-flex">
                                    <th scope="col"  style="width: 80px !important;  ">Job Code</th>
                                    <th scope="col"  style="width: 40px!important; font-size: 9px;  ">Task Code</th>
                                    <th  colspan="4" style="width: 139px !important; font-size: 9px;font-family: inherit; font-family: monospace; padding: 14px;">Task Title</th>
                                    <!-- <th scope="col" style="width: 300px;">Desctiption</th>
                                    <th style="width: 100px;">Job Types</th>
                                    <th style="width: 150px;">Department</th> -->
                                    <!-- <th style="width: 150px;">Job Category</th> -->
                                    <th scope="col" style="width: 64px !important; font-size: 9px;font-family: inherit;  font-family: monospace; padding: 14px;">Given By</th>
                                    <th scope="col" style="width: 65px !important; font-size: 9px;font-family: inherit;  font-family: monospace; padding: 14px;">Follow up</th>
                                    <th scope="col" style="width: 50px !important; font-size: 9px;font-family: inherit;  font-family: monospace; padding: 13px;">Job Type</th>
                                    <th scope="col" style="width: 60px !important; font-size: 9px;font-family: inherit;  font-family: monospace; padding: 14px;">Start Date</th>
                                    <th scope="col" style="width: 55px !important; font-size: 9px;font-family: inherit;  font-family: monospace; padding: 14px;">End Date</th>
                                    <!--        <th scope="col" style="width: 51px !important">Status</th> -->
                                    <?php foreach ($month_dates as $date_dig => $date_alpha) {
                                    ?>
                                    <th scope="col" style="width: 51px; "><?php echo $date_alpha . "- " . $date_dig ?></th>
                                    <?php
                                    } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $date_format = $this->config->item('date_format');
                                $counter = 1;
                                foreach ($tasks as $key => $task) {
                                    if ($currentUserGroup == "Employee" && $currentUser->id != $task->assignee) {
                                        continue;
                                    }
                                    $start_date = date($date_format, strtotime($task->start_date));
                                    $end_date = !empty($task->end_date) ? date($date_format, strtotime($task->end_date)) : "";
                                ?>
                                <tr class="d-flex" id="task-<?php echo $task->tid; ?>">
                                    <td style="font-weight: 600; font-size: 9px; width: 80px !important;">GEW-<?php echo $currentUser->username?>-<?php echo $counter; ?></td>
                                    <td style="width: 40px!important;  font-size: 9px;"><?php echo $task->t_code; ?></td>
                                    <td style="width: 139px !important; font-size: 9px;font-family: inherit;  "><?php echo $task->t_title; ?></td>
                                    <!-- <td style="width: 300px;"><?php echo $task->t_description; ?></td>
                                    <td style="width: 100px;"><?php echo $job_types[$task->parent_id]; ?></td>
                                    <td style="width: 150px;"><?php echo $task->c_name; ?></td> -->
                                    <!-- <td style="width: 150px;">Category HERE</td> -->
                                    <td style="width: 64px !important; font-size: 9px;font-family: inherit;"><?php echo $task->given; ?></td>
                                    <td style="width: 65px !important; font-size: 8px;font-family: inherit;"><?php echo $task->follow; ?></td>
                                    <td style="width: 50px !important; font-size: 9px;font-family: inherit;"><?php echo $job_types[$task->parent_id]; ?></td>
                                    <td style="width: 60px !important; font-size: 8px;font-family: inherit;"><?php echo $start_date; ?></td>
                                    <td style="width: 55px !important; font-size: 8px;font-family: inherit;"><?php echo $end_date; ?></td>
                                    <!--    <td style="width: 51px !important; font-size: 8px;font-family: inherit;"><?php echo getStatusText($task->t_status); ?></td>  -->
                                    <?php
                                    foreach ($month_dates as $date_dig => $date_alpha) {
                                    ?>
                                    <td style="width: 55px; ">
                                    <?php
                                        $current_date   = $date_dig . date("/{$month_date}/Y");
                                        $current_date_2 = strtotime(date($date_dig . "-{$month_date}-Y"));
                                        $start_date     = strtotime($task->start_date);
                                        $end_date       = strtotime($task->end_date);
                                        $output         = "-";
                                        if( !empty($task->reports) ) {
                                            foreach ($task->reports as $report_key => $report) {
                                                $report_date    = date($date_format, strtotime($report->created_at));
                                                if ($current_date == $report_date) {
                                                    $output = $report->status;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <?php echo '<span class="table-status">' . $output . '</span>'; ?>
                                    </td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                                $counter++;
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