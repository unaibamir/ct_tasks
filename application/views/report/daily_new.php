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

<!-- Dashboard for User -->
<div class="content">
	<div class="row">

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="title">Daily Report</h5>
				</div>
				<div class="card-body">
					<form action="<?php echo base_url("report/daily"); ?>" method="GET">
					<div class="row">
						<div class="col-md-3">
							<label>Select Task</label>
							<select class="form-control" id="task_id" name="task_id" style="padding: 10px 18px 10px 18px;">
								<option value="">Select Task</option>
								<?php
								if( !empty( $tasks ) ) {
									foreach ($tasks as $task) {
										if( empty( $task->t_title ) ) continue;
										$selected = $selected_task == $task->tid ? " selected " : "";
										echo '<option value="'.$task->tid.'" '.$selected.' >'.$task->t_title.'</option>';
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-3">
							<div class="form-group">
                                <label>Select Date</label>
                                <input type="text" name="report_date" value="<?php echo $selected_date; ?>" autocomplete="off" class="form-control text-left datepicker" id="report_date">
                            </div>
						</div>
						<div class="col-md-3 text-right font-weight-bold mt-3">
							<input type="submit" class="btn btn-info " value="Submit" style="background: #244973;">
							<a class="btn btn-info" href="<?php echo base_url("report/daily"); ?>">RESET</a>
							<?php if (!empty($reports)): ?>
								<a class="btn btn-info" href="<?php echo $export_url; ?>">Download/Export</a>
							<?php endif; ?>
						</div>
					</div>
					
					</form>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="table-list" class="table  table-bordered table-sm" cellspacing="0" width="100%">
							<thead class="thead-dark table-bordered">
								<tr>
									<th class="th-sm" width="80px">Task code</th>
									<th class="th-sm" width="150px;">Desctiption</th>
									<th class="th-sm" width="100px;">Given By</th>
									<th class="th-sm" width="100px;">Assigned</th>
									<th class="th-sm" width="100px;">Start date</th>
									<th class="th-sm" width="100px;">End Date</th>
									<th class="th-sm" width="100px;">Report Date</th>
									<th class="th-sm" width="60px;">Status</th>
									<th class="th-sm" width="250px;">Before</th>
									<th class="th-sm" width="250px;">After</th>
									<th class="th-sm" width="70px;">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!empty($reports)) {
									foreach ($reports as $key => $report) {

										if (empty($report->task)) {
											continue;
										}

										$t_given = !empty($report->task->given_by) ? $report->task->given_by : $report->task->created_by;
										$given_by_key = array_search($t_given, array_column($users, "id"));
										$assigned_user_key =  array_search($report->task->assignee, array_column($users, "id"));

										$start_date = date($this->config->item('date_format'), strtotime($report->task->start_date));
										$end_date = !empty($report->task->end_date) ? date($this->config->item('date_format'), strtotime($report->task->end_date)) : "";
										$report_date = date($this->config->item('date_format'), strtotime($report->created_at));
										?>
										<tr id="report-<?php echo $report->rid; ?>">
											<td><?php echo $report->task->t_code; ?></td>
											<td><?php echo substr($report->task->t_description, "0", "50"); ?> ...</td>
											<td><?php echo $users[$given_by_key]["first_name"] . " " . $users[$given_by_key]["last_name"]; ?></td>
											<td><?php echo $users[$assigned_user_key]["first_name"] . " " . $users[$assigned_user_key]["last_name"]; ?></td>
											<td><?php echo $start_date; ?></td>
											<td><?php echo $end_date; ?></td>
											<td><?php echo $report_date; ?></td>
											<td><?php echo getStatusText($report->task->t_status); ?></td>
											<td><?php echo $report->berfore; ?></td>
											<td><?php echo $report->after; ?></td>
											<td>
												<a href="<?php echo base_url("/report/history/" . $report->task->tid); ?>" class="btn btn-info btn-sm" style="padding: 5px; font-size: 10px;">
													View History
												</a>
											</td>
										</tr>
								<?php
									}
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