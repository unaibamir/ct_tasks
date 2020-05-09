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
        
    padding: 10px 3px;
height: 50px !important;

width: 27px !important;
font-size: 0.65em;
    }
    .table>tbody>tr>th {
        
    padding: 10px 5px;
height: 43px !important;
width: 27px !important;
font-size: 0.5em;
    }
    .table .thead-dark th {
    
    padding: 10px 3px;
height: 55px !important;
width: 27px !important;
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
                        
                    </div>

                    <form action="<?php echo base_url("employee/attendance");?>" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="month" value="<?php echo $month_arg;?>" autocomplete="off" class="form-control text-left monthpicker" placeholder="Select Month" style="margin-top: 10px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="submit" class="btn btn-info " value="Submit" style="background: #244973;">
                                <a class="btn btn-info" href="<?php echo $reset_url; ?>">RESET</a>
                                <?php if (!empty($users)): ?>
                                    <a class="btn btn-info" href="<?php echo $export_url; ?>">Download/Export</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if( isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ) {
                        ?><input type="hidden" name="employee_id" value="<?php echo $_GET["employee_id"]; ?>"><?php
                    }

                    if( isset($_GET["testing"]) ) {
                        ?><input type="hidden" name="testing" value="testing"><?php
                    }
                    ?>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-light">
                            <thead class="thead-dark">
                                <tr class="d-flex">
                                    <th scope="col" style=""></th>
                                    <th style="font-weight: 600; font-size: 9px; width: 50px !important;">Emp. Code</th>
                                    <th style="width: 100px!important;  font-size: 9px;">Name</th>
                                    <th style="width: 100px!important;  font-size: 9px;">Job Title</th>
                                    <th style="width: 100px!important;  font-size: 9px;">Dept.</th>
                                    <?php foreach ($month_dates as $date_dig => $date_alpha) {
                                    ?>
                                        <th scope="col" style="width: 55px; "><?php echo $date_alpha . "- " . $date_dig ?></th>
                                    <?php
                                    } ?>
                                    <th style="width: 55px;">TD</th>
                                    <th style="width: 55px;">H</th>
                                    <th style="width: 55px;">0</th>
                                    <th style="width: 55px;">1</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $date_format = $this->config->item('date_format');
                                $count = 1;
                                foreach ($users as $user) {
                                    ?>
                                    <tr class="d-flex" id="task-<?php echo $user->id; ?>">
                                        <td><?php echo $count; ?></td>
                                        <td style=" font-size: 9px; width: 50px !important;"><?php echo $user->username ?></td>
                                        <td style="width: 100px!important;  font-size: 9px;"><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                                        <td style="width: 100px!important;  font-size: 9px;"><?php echo $user->job_title; ?></td>
                                        <td style="width: 100px!important;  font-size: 9px;"><?php echo $user->c_name; ?></td>
                                        <?php
                                        $total_attendance = 0;
                                        foreach ($month_dates as $date_dig => $date_alpha) {
                                            $current_date   = $date_dig . date("/{$month_date}/{$year_date}");
                                            $current_date_2 = strtotime(date($date_dig . "-{$month_date}-{$year_date}"));
                                            $output         = "0";
                                            ?>
                                            <td style="width: 55px; ">
                                                <?php
                                                if( !empty($user->reports) ) {
                                                    foreach ($user->reports as $report_key => $report) {
                                                        $report_date    = date($date_format, strtotime($report->created_at));
                                                        if ($current_date == $report_date) {
                                                            $output = "1";
                                                            $total_attendance++;
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
                                        <td><span class="table-status"><?php echo $total_days; ?></span></td>
                                        <td><span class="table-status"><?php echo $holidays;  ?></span></td>
                                        <td><span class="table-status">
                                            <?php echo $total_days > $total_attendance ? $total_days - $total_attendance : "0" ;?>
                                        </span></td>
                                        <td><span class="table-status"><?php echo $total_attendance; ?></span></td>
                                    </tr>
                                    <?php
                                    $count++;
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