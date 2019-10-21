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

<div class="content">
	<div class="row">

		<div class="col-lg-12">
			<div class="card card-chart text-center">

				<div class="card-body center">

					<table class="table text-left">
						<thead>
							<tr>
								<th class="text-center">Task Code</th>

								<th colspan="2">Task Title</th>
								<th colspan="2">Job Type</th>
								<th class="text-right">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($tasks)) : ?>
								<?php foreach ($tasks as $task) {
									//print_r($task->department_id);exit;
										//task
										echo '<tr>';
										echo '<td class="text-center">' . $task->t_code . '</td>';
										echo '<td colspan="2">' . $task->t_title . '</td>';
										echo '<td colspan="2">' . $departments[$task->department_id] . '</td>';
										echo '<td class="td-actions text-right">';
										echo '<a target="_blank" style="font-size: 12px;font-style: italic;margin: 5px;" href="' . base_url('report/add/' . $task->tid) . '">Task Form</a>';

										echo '<a target="_blank" style="font-size: 12px;font-style: italic;margin: 5px;" href="' . base_url('report/history/' . $task->tid) . '">Task History</a>';

										echo '<button data-id="' . $task->tid . '" type="button" rel="tooltip" data-toggle="popover" title="view Details" class="task-detail btn btn-success btn-simple btn-icon btn-sm">
                  <i class="now-ui-icons education_glasses"></i>
                  </button></td>';
										echo '</tr>';
									} ?>

							<?php endif; ?>
						</tbody>
					</table>

				</div>
			</div>
		</div>

	</div>


	<div id="taskDetailContainer"></div>


	<div class=" col-md-12 modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h5 class="title">Task Details Here</h5>
						</div>
						<div class="card-body">
							<!-- Form Start her-->
							<div class="row">
								<h3 class="m-4">Task Details </h3>
								<div class="col-md-10 ">
									<table class="table table-bordered">
										<thead class="thead-dark">
											<tr>
												<th scope="col"> Task Code </th>
												<th scope="col"> Date </th>
												<th colspan="2" scope="col">Add Your Comment</th>
												<th scope="col">Status-key</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td scope="row">24 / 09 / 2019</td>
												<td scope="row">24 / 09 / 2019</td>
												<td colspan="2">Sent to Recruitment companies the JD</td>
												<td>
													<form action="/">
														<input type="radio" name="status" value="yes"> Y<br>
														<input type="radio" name="status" value="hold"> H<br>
														<input type="radio" name="status" value="cancel">C<br>
														<input type="radio" name="status" value="Finished">F<br>
														<input type="submit" class="btn btn-info pull-left" value="Submit" style="background: #244973;">
													</form>
												</td>
											</tr>
											<tr>
												<td scope="row">24 / 09 / 2019</td>
												<td scope="row">24 / 09 / 2019</td>
												<td colspan="2">scheduled interview on 04.09.</td>
												<td>
													<form action="/">
														<input type="radio" name="status" value="yes"> Y<br>
														<input type="radio" name="status" value="hold"> H<br>
														<input type="radio" name="status" value="cancel">C<br>
														<input type="radio" name="status" value="Finished">F<br>


														<input type="submit" class="btn btn-info pull-left" value="Submit" style="background: #244973;">
													</form>
												</td>
											</tr>

											<tr>
												<td scope="row">24 / 09 / 2019</td>
												<td scope="row">24 / 09 / 2019</td>
												<td colspan="2"><textarea class="md-textarea form-control"></textarea></td>
												<td>
													<form action="/">
														<input type="radio" name="status" value="yes"> Y<br>
														<input type="radio" name="status" value="hold"> H<br>
														<input type="radio" name="status" value="cancel">C<br>
														<input type="radio" name="status" value="Finished">F<br>


														<input type="submit" class="btn btn-info pull-left" value="Submit" style="background: #244973;">
													</form>
												</td>
											</tr>
											<tr>
												<td scope="row">24 / 09 / 2019</td>
												<td scope="row">24 / 09 / 2019</td>
												<td colspan="2">Conducted interviews. Selected candidates. Gave offer.</td>

												<td>
													<input type="radio" name="status" value="yes"> Y<br>
													<input type="radio" name="status" value="hold"> H<br>
													<input type="radio" name="status" value="cancel">C<br>
													<input type="radio" name="status" value="Finished">F<br>
													<input type="submit" class="btn btn-info pull-left" value="Submit" style="background: #244973;">
												</td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>

							<button class="btn btn-primary btn-block" onclick="nowuiDashboard.showNotification('top','center')">Submit</button>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>