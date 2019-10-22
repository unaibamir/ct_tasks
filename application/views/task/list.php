<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->

<div class="panel-header panel-header-sm">
</div>
<?php
$departments = array(
	1 => "Daily",
	2 => "Weekly",
	3 => "Monthly",
	4 => "One Time"
);

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
					<div class="table-responsive">

						<table class="table">
							<thead class=" text-primary">
								<tr>
									<th>Ttile</th>
									<th>Department</th>
									<th>Task Code</th>
									<th>Job Type</th>
									<th>Assigned To</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								<?php if (!empty($tasks)) : ?>
									<?php foreach ($tasks as $task) {

											//task
											echo '<tr>';
											echo '<td>' . $task->t_title . '</td>';
											echo '<td>' . $task->c_name . '</td>';
											echo '<td>' . $task->t_code . '</td>';
											echo '<td>' . $departments[$task->department_id] . '</td>';
											echo '<td>' . $task->first_name . " " .$task->last_name . '</td>';
											echo '<td>' . $task->start_date . '</td>';
											echo '<td>' . $task->end_date . '</td>';
											echo '<td> - - - </td>';
											echo '</tr>';
										} ?>

								<?php endif; ?>

							</tbody>
						</table>
					</div>

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