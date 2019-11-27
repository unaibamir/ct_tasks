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
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "daily"); ?>" id="nav-task-daily" href="<?php echo task_list_link("daily"); ?>"><kbd>Daily <span class="badge badge-light"><?php echo !empty($tasks_count["daily"])? $tasks_count["daily"][0]["total"] : 0; ?></span></kbd></a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "weekly"); ?>" id="nav-task-weekly" href="<?php echo task_list_link("weekly"); ?>"><kbd>Weekly <span class="badge badge-light"><?php echo !empty($tasks_count["weekly"])? $tasks_count["weekly"][0]["total"] : 0; ?></span></kbd></a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "monthly"); ?>" id="nav-task-monthly" href="<?php echo task_list_link("monthly"); ?>"><kbd>Monthly <span class="badge badge-light"><?php echo !empty($tasks_count["monthly"])? $tasks_count["monthly"][0]["total"] : 0; ?></span></kbd></a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "one-time"); ?>" id="nav-task-one-time" href="<?php echo task_list_link("one-time"); ?>"><kbd>One Time <span class="badge badge-light"><?php echo !empty($tasks_count["one_time"])? $tasks_count["one_time"][0]["total"] : 0; ?></span></kbd></a>
                        </div>
                    </nav>
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
                                    <b> Sorry!</b> There are no tasks under this job type
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
