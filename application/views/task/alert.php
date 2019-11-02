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
			<div class="card card-chart text-center">

				<div class="card-body center">
					<nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "daily");?>" id="nav-task-daily" href="<?php echo base_url("task/alert/?view=daily"); ?>">Daily</a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "weekly");?>" id="nav-task-weekly" href="<?php echo base_url("task/alert/?view=weekly"); ?>">Weekly</a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "monthly");?>" id="nav-task-monthly" href="<?php echo base_url("task/alert/?view=monthly"); ?>">Monthly</a>
                            <a class="nav-item nav-link <?php echo job_type_state($job_type, "one-time");?>" id="nav-task-one-time" href="<?php echo base_url("task/alert/?view=one-time"); ?>">One Time</a>
                        </div>
                    </nav>
					<?php if (!empty($tasks)) : ?>
						<div class="table-responsive">
							<table class="table text-left">
								<thead>
									<tr>
										<th class="text-center">Task Code</th>
										<th colspan="2">Task Title</th>
										<th colspan="2">Job Type</th>
										<th colspan="2">Given</th>
										<th class="text-right">Actions</th>
									</tr>
								</thead>
								<tbody>
									
									<?php 
									foreach ($tasks as $task) {
										
										$t_given = !empty($task->given_by) ? $task->given_by : $task->created_by;
										$given_by_key = array_search($t_given, array_column($users, "id"));
										$follow_up_key = array_search($task->reporter, array_column($users, "id"));
										
										
										//task
										echo '<tr>';
										echo '<td class="text-center">' . $task->t_code . '</td>';
										echo '<td colspan="2">' . $task->t_title . '</td>';
										echo '<td colspan="2">' . $job_types[$task->parent_id] . '</td>';
										echo '<td colspan="2">' . $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"] . '</td>';
										echo '<td class="td-actions text-right">';
											if( $task->reported ) {
												echo '<a style="font-size: 12px;font-style: italic;margin: 5px;" href="javascript:void(0);">Already Reported</a>';
											} else {
												echo '<a target="_blank" style="font-size: 12px;font-style: italic;margin: 5px;" href="' . base_url('report/add/' . $task->tid) . '">Task Form</a>';
											}
											echo '<a target="_blank" style="font-size: 12px;font-style: italic;margin: 5px;" href="' . base_url('report/history/' . $task->tid) . '">Task History</a>';

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
																				<?php echo date( $this->config->item('date_format'), strtotime($task->start_date) ); ?>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label for="" class="col-sm-3 col-form-label">End Date</label>
																			<div class="col-md-9 text-left">
																				<?php echo date( $this->config->item('date_format'), strtotime($task->end_date) ); ?>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label for="" class="col-sm-3 col-form-label">Files</label>
																			<div class="col-md-9 text-left">
																				<?php
																				if( !empty( $task->files ) ) {
																					echo '<ul style="padding-left:16px;">';
																					foreach ( $task->files as $file) {
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
											<?php
										echo '</td>';
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