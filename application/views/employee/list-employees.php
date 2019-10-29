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
</style>
<?php
$job_types = array(
	1 => "Daily",
	2 => "Weekly",
	3 => "Monthly",
	4 => "One Time"
);
?>
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
								<tr class="">
									<th scope="col" style=""></th>
									<th scope="col" style="">Dept.</th>
									<th scope="col" style="">Emp. Code</th>
									<th scope="col" style="">Full Name</th>
									<th scope="col" style="">First Name</th>
									<th scope="col" style="">Second Name</th>
									<th scope="col" style="">Nationality</th>
									<th scope="col" style="">Job Title</th>
									<th scope="col" style="">Company Email</th>
									<th scope="col" style="">Personal Email</th>
									<th scope="col" style="">Com Mob No</th>
									<th scope="col" style="">Personal Mob No</th>
									<th scope="col" style="">Current Location</th>
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
											<td><?php echo $employee->department; ?></td>
											<td><?php echo $employee->username; ?></td>
											<td><?php echo $employee->first_name . ' ' . $employee->last_name; ?></td>
											<td><?php echo $employee->first_name; ?></td>
											<td><?php echo $employee->last_name; ?></td>
											<td><?php echo $employee->nationality; ?></td>
											<td><?php echo $employee->job_title; ?></td>
											<td><?php echo $employee->company_email; ?></td>
											<td><?php echo $employee->email; ?></td>
											<td><?php echo $employee->com_mob_no; ?></td>
											<td><?php echo $employee->per_mon_no; ?></td>
											<td><?php echo $employee->cur_loc; ?></td>
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
