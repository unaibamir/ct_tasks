<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->

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
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "daily"); ?>" id="nav-task-daily" href="<?php echo task_list_link("daily"); ?>">
                                <kbd>Daily <span class="badge badge-light"><?php echo !empty($tasks_count[0]["total"])? $tasks_count[0]["total"] : 0; ?></span> </kbd>
                            </a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "weekly"); ?>" id="nav-task-weekly" href="<?php echo task_list_link("weekly"); ?>">
                                <kbd>Weekly <span class="badge badge-light"><?php echo !empty($tasks_count[1]["total"])? $tasks_count[1]["total"] : 0; ?></span> </kbd>
                            </a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "monthly"); ?>" id="nav-task-monthly" href="<?php echo task_list_link("monthly"); ?>">
                                <kbd>Monthly <span class="badge badge-light"><?php echo !empty($tasks_count[2]["total"])? $tasks_count[2]["total"] : 0; ?></span> </kbd>
                            </a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "one-time"); ?>" id="nav-task-one-time" href="<?php echo task_list_link("one-time"); ?>">
                                <kbd>One Time <span class="badge badge-light"><?php echo !empty($tasks_count[3]["total"])? $tasks_count[3]["total"] : 0; ?></span> </kbd>
                            </a>
                        </div>
                    </nav>
                    <?php if (!empty($tasks)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="table-list">
                                <thead class=" thead-dark text-primary">
                                    <tr>
                                        <th>Task Code</th>
                                        <th>Ttile</th>
                                        <th>Assigned To</th>
                                        <th>Given By</th>
                                        <th>Department</th>
                                        <th>Job Type</th>
                                        <th>Follow Up </th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($tasks as $task) {
                                            $t_given = !empty($task->given_by) ? $task->given_by : $task->created_by;
                                            $given_by_key = array_search($t_given, array_column($users, "id"));
                                            
                                            $assigned_user_key =  array_search($task->assignee, array_column($users, "id"));
                                            $follow_user_key =  array_search($task->reporter, array_column($users, "id"));
                                            
                                            $start_date = date($this->config->item('date_format'), strtotime($task->start_date));
                                            $end_date = !empty($task->end_date ) ? date($this->config->item('date_format'), strtotime($task->end_date)) : "";

                                            $task_title = strlen($task->t_title) > 25 ? substr($task->t_title, 0, 25) . "..." : $task->t_title;

                                            //task
                                            echo '<tr>';

                                            echo '<td><b>GEW</b>_<b>' . $users[$assigned_user_key]["username"] . "</b>_<b>" . $task->t_code . '</b>  </td>';
                                            echo '<td>' . $task_title . '</td>';

                                            echo '<td>' . $users[$assigned_user_key]["first_name"] . " " . $users[$assigned_user_key]["last_name"] . '</td>';

                                            echo '<td>' . $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"] . '</td>';

                                            echo '<td>' . $task->c_name . '</td>';
                                            echo '<td>' . $job_types[$task->parent_id] . '</td>';

                                            echo '<td>' . $users[$follow_user_key]["first_name"] . " " . $users[$follow_user_key]["last_name"] . '</td>';

                                            echo '<td>' . $start_date . '</td>';
                                            echo '<td>' . $end_date . '</td>';
                                            echo '<td>' . getStatusText($task->t_status) . '</td>';
                                            ?>
                                            <td>
                                                <a href="<?php echo base_url("/report/history/" . $task->tid); ?>" class="btn btn-info btn-sm">
                                                    View History
                                                </a>
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
