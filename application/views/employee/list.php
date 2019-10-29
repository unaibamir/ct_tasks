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
		bottom: .5em;
	}

	thead {
		font-size: 10px;
	}

	th,
	td {
		font-size: 10px;
	}

	.dark {
		background: #b9b2b1;
	}

	.extra {
		display: none;
	}

	.monthlyView {}

	.calender {
		width: 100%;
	}

	.table-status {
		font-weight: 800;
		margin-left: 20px;
	}
	.table > tbody > tr > td {
		padding: 10px 5px;
	}
	.table .thead-dark th {
		font-size: 1.25em;
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
					<!-- <h5 class="title"> Task Form</h5> -->
				</div>
				<div class="card-body">
					<div id="calendar"></div>

					<h3 class="m-4">Employees List</h3>

					<div class="table-responsives">
						<table class="table table-bordered table-hover" id="table-list">
							<thead class="thead-dark">
								<tr>
									<th style="width: 20px;">&nbsp;</th>
									<th style="width: 100px;">Emp. Code</th>
									<th style="width: 100px;">Employee Name</th>
									<th style="width: 100px;">Dept.</th>
									<th style="width: 100px;">Assign New Task</th>
									<th style="width: 100px;">Daily Jobs</th>
									<th style="width: 100px;">Task History</th>
									<th style="width: 100px;">Monthly Job Summary</th>
									<!-- <th style="width: 100px;">Finsihed Task</th> -->
									<th style="width: 100px;">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if( !empty( $employees ) ) {
									$count = 1;
									foreach ($employees as $key => $employee) {
										?>
										<tr class="" id="employee-<?php echo $employee->id; ?>">
											<td><?php echo $count; ?></td>
											<td><?php echo $employee->username; ?></td>
											<td><?php echo $employee->first_name . ' ' . $employee->last_name; ?></td>
											<td><?php echo $employee->c_name; ?></td>
											<td>
												<a href="<?php echo base_url("task/add/?employee_id=" . $employee->id);?>" class="btn btn-xs btn-info">
													Assing New Task
												</a>
											</td>
											<td>
												<a href="<?php echo base_url("report/daily/?employee_id=" . $employee->id);?>" class="btn btn-xs btn-info">
													Daily Job Report
												</a>
											</td>
											<td>
												<a href="<?php echo base_url("task/?employee_id=" . $employee->id);?>" class="btn btn-xs btn-info">
													View All Tasks
												</a>
											</td>
											<td>
												<a href="<?php echo base_url("report/monthly/?employee_id=" . $employee->id);?>" class="btn btn-xs btn-info">
													View Monthly Summary
												</a>
											</td>
											<!-- <td></td> -->
											<td>
												<a href="<?php echo base_url("task/add/?employee_id=" . $employee->id);?>" class="btn btn-xs btn-info">
													Add & Assign Task
												</a>
											</td>
										</tr>
										<?php
										$count++;
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