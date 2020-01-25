<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
        top: 11px !important;
    }

    thead {
        font-size: 10px;
    }

    th,
    td {
        font-size: 10px;
    }
</style>
<div class="panel-header panel-header-sm">
</div>
<?php
$job_types = array(
    99 => "All",
    1 => "Daily",
    2 => "Weekly",
    3 => "Monthly",
    4 => "One Time"
);
$job_type = isset($_GET["view"]) ? $_GET["view"] : "daily";
?>
<!-- Dashboard for User -->
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Task Listing</h5>
                </div>
                <div class="card-body">
    
                    <form action="<?php echo base_url("task");?>" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="month" value="<?php echo @$month_arg;?>" autocomplete="off" class="form-control text-left monthpicker" placeholder="Select Month" style="margin-top: 10px;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" class="form-control" style="margin-top: 10px;">
                                        <option value="">Please Select Status</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "all" ? "selected" : "" ?> value="all">All</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "in-progress" ? "selected" : "" ?> value="in-progress">In Progress</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "hold" ? "selected" : "" ?> value="hold">Hold</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "cancelled" ? "selected" : "" ?> value="cancelled">Cancelled</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "completed" ? "selected" : "" ?> value="completed">Finished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="type" id="job-type" class="form-control" style="margin-top: 10px;">
                                        <?php foreach ($job_types as $key => $type_name) {
                                            $selected = isset($_GET["type"]) && !empty($_GET["type"]) && $_GET["type"] == $key ? "selected" : "";
                                            ?>
                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $type_name; ?></option>
                                            <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="submit" class="btn btn-info " value="Submit" style="background: #244973;">
                                    <?php if( isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ) { ?>
                                        <a class="btn btn-info" href="<?php echo add_query_arg( "employee_id", $_GET["employee_id"], base_url("task") ); ?>">RESET</a>
                                    <?php } else { ?>
                                        <a class="btn btn-info" href="<?php echo base_url("task"); ?>">RESET</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if( isset($_GET["employee_id"]) && !empty($_GET["employee_id"]) ) {
                            ?><input type="hidden" name="employee_id" value="<?php echo $_GET["employee_id"]; ?>"><?php
                        }
                        ?>
                    </form>

                    <?php if (!empty($tasks)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="table-list" style="width: 100%;">
                                <thead class="thead-dark table-bordered">
                                    <tr>
                                        <th class="th-sm" style="max-width: 90px">Task Code</th>
                                        <th class="th-sm">Title</th>
                                        <th class="th-sm">Assigned To</th>
                                        <th class="th-sm">Given By</th>
                                        <th class="th-sm">Department</th>
                                        <th class="th-sm">Job Type</th>
                                        <th class="th-sm">Follow Up </th>
                                        <th class="th-sm">Start Date</th>
                                        <th class="th-sm">End Date</th>
                                        <th class="th-sm">Status</th>
                                        <th class="th-sm">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($tasks as $task) {
                                        $t_given            =   !empty($task->given_by) ? $task->given_by : $task->created_by;
                                        $given_by_key       =   array_search($t_given, array_column($users, "id"));
                                        
                                        $assigned_user_key  =   array_search($task->assignee, array_column($users, "id"));
                                        $follow_user_key    =   array_search($task->reporter, array_column($users, "id"));
                                        
                                        $start_date         =   date($this->config->item('date_format'), strtotime($task->start_date));
                                        $end_date           =   !empty($task->end_date ) ? date($this->config->item('date_format'), strtotime($task->end_date)) : "";
                                        $created_date       =   date($this->config->item('date_format'), strtotime($task->t_created_at));

                                        $task_title         =   strlen($task->t_title) > 25 ? substr($task->t_title, 0, 25) . "..." : $task->t_title;

                                        $history_url        =   base_url("/report/history/".$task->tid);

                                        ?>
                                        <tr>
                                            <td><strong>GEW_<?php echo $users[$assigned_user_key]["username"] ."_". $task->t_code; ?></strong></td>
                                            <td><?php echo $task_title; ?></td>
                                            <td><?php echo $users[$assigned_user_key]["first_name"] . " " . $users[$assigned_user_key]["last_name"]; ?></td>
                                            <td><?php echo $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"]; ?></td>
                                            <td><?php echo $task->c_name; ?></td>
                                            <td><?php echo $job_types[$task->parent_id]; ?></td>
                                            <td><?php echo $users[$follow_user_key]["first_name"] . " " . $users[$follow_user_key]["last_name"]; ?></td>
                                            <td><?php echo $start_date; ?></td>
                                            <td><?php echo $end_date; ?></td>
                                            <td><?php echo getStatusText($task->t_status); ?></td>
                                            <td>
                                                <a href="<?php echo $history_url; ?>" class="btn btn-info btn-sm" style="padding:5px;font-size:10px;">View History</a>

                                                <?php
                                                if( $task->t_status == "hold" ) {
                                                    ?>
                                                    <a href="javascript:void(0);" class="btn btn-success btn-sm lower-btn" data-toggle="modal" data-target=".task-popup-<?php echo $task->tid; ?>" style="padding:5px;font-size:10px;">Resume Task</a>
                                                    <?php
                                                }
                                                ?>
                                                <div class="modal fade task-popup-<?php echo $task->tid; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog model-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title h4" style="margin:0;">
                                                                    Resume Task: <strong>GEW_<?php echo $users[$assigned_user_key]["username"] ."_". $task->t_code; ?></strong>
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container-fluid" style="font-size: 14px;">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <form action="<?php echo base_url("/task/resume_submit"); ?>" method="post">
                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-3 col-form-label" style="color: #000;">End Date <br><small>(optional)</small></label>
                                                                                    <div class="col-md-9 text-left">
                                                                                        <input type="text" name="end_date" class="datepicker_min form-control" autocomplete="off" value="<?php echo $end_date; ?>">

                                                                                        <p><small>if the task already has an end date, it will be displayed here.</small></p>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <div class="col-md-12 text-right">
                                                                                        <input type="submit" value="Resume Task" class="btn btn-success btn-sm">
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="task_id" value="<?php echo $task->tid; ?>">

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else : ?>
                        <br>
                        <div class="col-md-4 offset-4">
                            <div class="alert alert-primary">
                                <span>
                                    <b> Sorry!</b> There are no tasks under this criteria.
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>


</div>
<!-- 


echo '<td>' . $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"] . '</td>'; 

echo '<td>' . $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"] . '</td>';

    Dashboard for User body-->




<footer class="footer">
    <!--    <div class="container-fluid">
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
            </script> Design & Code by
            <a href="http://www.gulfenviro.ae/" target="_blank">Amir Nisar</a>.
        </div>
    </div>

-->
</footer>
