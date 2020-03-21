<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->

<div class="panel-header panel-header-sm">
</div>

<style>
    .card label {
        font-size: unset;
        margin-bottom: 0;
        padding-top: 0;
        color: #000;
        font-weight: bold;
    }
</style>


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


<div class="content">
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Advanced Search Filter </h5>
                   
                </div>
                <div class="card-body center">
                    <?php
                    if (isset($_GET["message"]) && $_GET["message"] == "alert_success") {
                    ?>
                        <div class="col-md-4 offset-4">
                            <div class="alert alert-success">
                                <span>
                                    <b> Great!!</b> Task report has been submitted.
                                </span>
                            </div>
                        </div>
                    <?php
                    }

                    ?>
                    

                    <form action="<?php echo base_url("task/alert"); ?>" method="GET">
                        <div class="row">
                            <div class="col-md-3  ">
                                 <div class="form-group">
                                       <h6>Select Month <small>  </small></h6>
                                    <input type="text" name="month" value="<?php echo @$month_arg; ?>" autocomplete="off" class="form-control text-left monthpicker" placeholder="Select Month" style="margin-top: 10px;">
                                </div> 
                            </div>
                            <div class="col-md-3">
                           <div class="form-group">
                                    <h6> Select Task Status <small>   </small></h6>
                                   
                                    <select name="status" class="form-control" style="margin-top: 10px;">
                                        <option value="">Please Select Status</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "all" ? "selected" : "" ?> value="all">All</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "in-progress" ? "selected" : "" ?> value="in-progress">In Progress</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "hold" ? "selected" : "" ?> value="hold">Hold</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "cancelled" ? "selected" : "" ?> value="cancelled">Cancelled</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "completed" ? "selected" : "" ?> value="completed">Finished</option>
                                        <option <?php echo isset($_GET["status"]) && $_GET["status"] == "pending" ? "selected" : "" ?> value="pending">Pending</option>
                                    </select>
                                </div> 
                            </div> 
                          <div class="col-md-3">
                                <div class="form-group">
                                    <h6>Select Task Type <small>  </small></h6>

                                       
                                    <select name="type" id="job-type" class="form-control" style="margin-top: 10px;">
                                        <?php foreach ($job_types as $key => $type_name) {
                                            if( isset($_GET["type"]) && !empty($_GET["type"]) && $_GET["type"] == $key ) {
                                                $selected = "selected";
                                            } else if( isset($_GET["type"]) && empty(isset($_GET["type"])) || !isset($_GET["type"]) && $key == 1 ) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
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
                                    <?php if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) { ?>
                                        <a class="btn btn-info" href="<?php echo add_query_arg("employee_id", $_GET["employee_id"], base_url("task/alert")); ?>">RESET</a>
                                    <?php } else { ?>
                                        <a class="btn btn-info" href="<?php echo base_url("task/alert"); ?>">RESET</a>
                                    <?php } ?>
                                </div>
                            </div>


                            <div class="col-md-12 ">
                                <div class="form-group mt-4">
                                    <div class="card-header">
                                        <h5 class="title">Current / Active Tasks <small> ( All In Progress ) </small> </h5>
                                    </div>
                                    

                                     <a href="<?php echo base_url("task/alert/?month=&status=&type=99"); ?>" class="btn btn-primary  " role="button" aria-pressed="true">All</a> 
                                    <a href="<?php echo base_url("task/alert/?month=&status=&type=1"); ?>" class="btn btn-primary   " role="button" aria-pressed="true">Daily</a>
                                    <a href="<?php echo base_url("task/alert/?month=&status=&type=2"); ?>" class="btn btn-primary  " role="button" aria-pressed="true">Weekly</a>
                                    <a href="<?php echo base_url("task/alert/?month=&status=&type=3"); ?>" class="btn btn-primary  " role="button" aria-pressed="true">Monthly</a>
                                     <a href="<?php echo base_url("task/alert/?month=&status=&type=4"); ?>" class="btn btn-primary  " role="button" aria-pressed="true">One Time</a>
                                    
                                       
                                 <!--   <select name="type" id="job-type" class="form-control" style="margin-top: 10px;">
                                        <?php foreach ($job_types as $key => $type_name) {
                                            if( isset($_GET["type"]) && !empty($_GET["type"]) && $_GET["type"] == $key ) {
                                                $selected = "selected";
                                            } else if( isset($_GET["type"]) && empty(isset($_GET["type"])) || !isset($_GET["type"]) && $key == 1 ) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                        ?>
                                            <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $type_name; ?></option>
                                        <?php
                                        } ?>
                                    </select> -->
                                </div>
                            </div> 


                        </div>
                        <?php
                        if (isset($_GET["employee_id"]) && !empty($_GET["employee_id"])) {
                        ?><input type="hidden" name="employee_id" value="<?php echo $_GET["employee_id"]; ?>"><?php
                                                                                                            }
                                                                                                                ?>
                    </form>

                    <?php if (!empty($tasks)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="table-list" style="width: 100%;">
                                <thead class="thead-dark table-bordered">
                                    <tr>
                                        <th class="text-center">Task Code</th>
                                        <th>Task Title</th>
                                        <th>Job Type</th>
                                        <th>Given</th>
                                        <th>Follow Up </th>
                                        <th>Status</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    $date_format = $this->config->item('date_format');
                                    foreach ($tasks as $task) {

                                        $t_given = !empty($task->given_by) ? $task->given_by : $task->created_by;
                                        $given_by_key = array_search($t_given, array_column($users, "id"));
                                        $follow_up_key = array_search($task->reporter, array_column($users, "id"));
                                        $assigned_user_key =  array_search($task->assignee, array_column($users, "id"));
                                        $follow_user_key =  array_search($task->reporter, array_column($users, "id"));
                                        $start_date = date($date_format, strtotime($task->start_date));
                                        $end_date = !empty($task->end_date) ? date($date_format, strtotime($task->end_date)) : "";

                                        $task_title = strlen($task->t_title) > 500 ? substr($task->t_title, 0, 500) . "..." : $task->t_title;

                                        //task
                                        echo '<tr>';
                                        echo '<td  ><span>GEW</span>_' . $users[$assigned_user_key]["username"] . "_<strong>" . $task->t_code . '</strong>  </td>';
                                        echo '<td>' . $task_title . '</td>';
                                        echo '<td>' . $job_types[$task->parent_id] . '</td>';
                                        echo '<td>' . $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"] . '</td>';
                                        echo '<td>' . $users[$follow_user_key]["first_name"] . " " . $users[$follow_user_key]["last_name"] . '</td>';
                                        echo '<td>' . getStatusText($task->t_status) . '</td>';
                                        echo '<td class="td-actions text-right">';

                                        if ($task->t_status == "completed" || $task->t_status == "cancelled" || $task->t_status == "hold") {
                                            if ($task->t_status == "hold") {
                                                //echo '<span style="font-size: 12px;font-style: italic;margin: 5px; color: #f96332;" >Resume</span>';
                                    ?>
                                                <a href="javascript:void(0);" class="" data-toggle="modal" data-target=".task-resume-popup-<?php echo $task->tid; ?>" style="padding:5px;font-size: 12px;font-style: italic;">Resume Task</a>
                                        <?php
                                            }
                                            //echo '<span style="font-size: 12px;font-style: italic;margin: 5px;" href="javascript:void(0);">Already </span>';
                                        } elseif ($task->reported) {
                                            echo '<a style="font-size: 12px;font-style: italic;margin: 5px;" href="javascript:void(0);">Already Reported</a>';
                                        } else {
                                            echo '<a style="font-size: 12px;font-style: italic;margin: 5px;" href="' . base_url('report/add/' . $task->tid) . '">Task Form</a>';
                                        }
                                        echo '<a style="font-size: 12px;font-style: italic;margin: 5px;" href="' . base_url('report/history/' . $task->tid) . '">Task History</a>';

                                        echo '<button data-id="' . $task->tid . '" type="button" title="view Details" class="btn btn-success btn-simple btn-icon btn-sm"  data-toggle="modal" data-target=".task-popup-' . $task->tid . '">
                                                <i class="now-ui-icons education_glasses"></i>
                                                </button>';
                                        ?>
                                        <div class="modal fade task-popup-<?php echo $task->tid; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h4" style="margin:0;">Task Code - <?php echo $task->t_code; ?> Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <!-- <div class="form-group row">
                                                                            <label for="" class="col-sm-3 col-form-label">Task Code</label>
                                                                            <div class="col-md-9 text-left"><?php echo $task->t_code; ?></div>
                                                                        </div> -->
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Task Title</label>
                                                                        <div class="col-md-9 text-left"><?php echo $task->t_title; ?></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Task Description</label>
                                                                        <div class="col-md-9 text-left"><?php echo $task->t_description; ?></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Task Status</label>
                                                                        <div class="col-md-9 text-left"><?php echo getStatusText($task->t_status); ?></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Type</label>
                                                                        <div class="col-md-9 text-left"><?php echo $job_types[$task->parent_id]; ?></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Given By</label>
                                                                        <div class="col-md-9 text-left"><?php echo $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"]; ?></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Follow Up</label>
                                                                        <div class="col-md-9 text-left"><?php echo $users[$follow_up_key]["first_name"] . " " . $users[$follow_up_key]["last_name"]; ?></div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Start Date</label>
                                                                        <div class="col-md-9 text-left">
                                                                            <?php echo date($date_format, strtotime($task->start_date)); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">End Date</label>
                                                                        <div class="col-md-9 text-left">
                                                                            <?php
                                                                            if (!empty($task->end_date)) {
                                                                                echo date($date_format, strtotime($task->end_date));
                                                                            } else {
                                                                                echo $this->config->item("no_end_date");
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="" class="col-sm-3 col-form-label">Files</label>
                                                                        <div class="col-md-9 text-left">
                                                                            <?php
                                                                            if (!empty($task->files)) {
                                                                                echo '<ul style="padding-left:16px;">';
                                                                                foreach ($task->files as $file) {
                                                                            ?>
                                                                                    <li>
                                                                                        <a href="<?php echo $file["url"]; ?>" target="_blank">
                                                                                            <?php echo $file["f_title"]; ?>
                                                                                        </a>
                                                                                    </li>
                                                                            <?php
                                                                                }
                                                                                echo '</ul>';
                                                                            } else {
                                                                                echo 'No Files Available';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade task-resume-popup-<?php echo $task->tid; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog model-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title h4" style="margin:0;">
                                                            Resume Task: <strong>GEW_<?php echo $users[$assigned_user_key]["username"] . "_" . $task->t_code; ?></strong>
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

                                    <?php
                                        echo '</td>';

                                        echo '</tr>';
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
                                    <b> Sorry!</b> There are no tasks under this Search.
                                </span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>