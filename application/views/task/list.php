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
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "daily");?>" id="nav-task-daily" href="<?php echo base_url("task/?view=daily"); ?>">Daily</a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "weekly");?>" id="nav-task-weekly" href="<?php echo base_url("task/?view=weekly"); ?>">Weekly</a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "monthly");?>" id="nav-task-monthly" href="<?php echo base_url("task/?view=monthly"); ?>">Monthly</a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "one-time");?>" id="nav-task-one-time" href="<?php echo base_url("task/?view=one-time"); ?>">One Time</a>
                        </div>
                    </nav>
                    <?php if (!empty($tasks)) : ?>
						<div class="table-responsive">
							<table class="table">
								<thead class=" text-primary">
									<tr>
										<th>Ttile</th>
										<th>Department</th>
										<th>Task Code</th>
										<th>Job Type</th>
										<th>Assigned To</th>
										<th>Given By</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tasks as $task) {
										$t_given = !empty( $task->given_by ) ? $task->given_by : $task->created_by;
										$given_by_key = array_search($t_given, array_column( $users, "id" ) );
										

										//task
										echo '<tr>';
										echo '<td>' . $task->t_title . '</td>';
										echo '<td>' . $task->c_name . '</td>';
										echo '<td>' . $task->t_code . '</td>';
										echo '<td>' . $job_types[$task->parent_id] . '</td>';
										echo '<td>' . "asd" . '</td>';
										echo '<td>' . $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"] . '</td>';
										echo '<td>' . $task->start_date . '</td>';
										echo '<td>' . $task->end_date . '</td>';
										echo '<td> - - - </td>';
										echo '</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					<?php else: ?>
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
<!-- Dashboard for User body-->




<footer class="footer">
	<div class="container-fluid">
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
			</script>, Desgin & Code by
			<a href="http://www.gulfenviro.ae/" target="_blank">Amir Nisar</a>.
		</div>
	</div>
</footer>