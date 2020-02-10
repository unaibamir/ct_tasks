<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="panel-header panel-header-sm"></div>

<?php
$job_types = array(
    99 => "All",
    1 => "Daily",
    2 => "Weekly",
    3 => "Monthly",
    4 => "One Time"
);
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Tasks</h5>
                </div>
                <div class="card-body">
                	<?php if (!empty($tasks)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="table-list" style="width: 100%;">
                                <thead class="thead-dark table-bordered">
                                    <tr>
                                        <th class="th-sm" style="max-width: 90px">Task ID</th>
                                        <th class="th-sm" style="max-width: 90px">Task Code</th>
                                        <th class="th-sm">Title</th>
                                        <th class="th-sm">Assigned To</th>
                                        <th class="th-sm">Given By</th>
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

                                        $delete_url        	=   base_url("/admin/tasks/delete/".$task->tid);

                                        ?>
                                        <tr>
                                            <td><?php echo $task->tid; ?></td>
                                            <td><strong>GEW_<?php echo $users[$assigned_user_key]["username"] ."_". $task->t_code; ?></strong></td>
                                            <td><?php echo $task_title; ?></td>
                                            <td><?php echo $users[$assigned_user_key]["first_name"] . " " . $users[$assigned_user_key]["last_name"]; ?></td>
                                            <td><?php echo $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"]; ?></td>
                                            <td><?php echo $job_types[$task->parent_id]; ?></td>
                                            <td><?php echo $users[$follow_user_key]["first_name"] . " " . $users[$follow_user_key]["last_name"]; ?></td>
                                            <td><?php echo $start_date; ?></td>
                                            <td><?php echo $end_date; ?></td>
                                            <td><?php echo getStatusText($task->t_status); ?></td>
                                            <td>
                                            	<a href="#" class="btn btn-info btn-sm disabled" style="padding:5px;font-size:10px;">Edit</a>
                                            	<a href="<?php echo $delete_url; ?>" class="btn btn-danger btn-sm" style="padding:5px;font-size:10px;">Delete</a>
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