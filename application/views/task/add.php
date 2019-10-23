<?php
defined('BASEPATH') or exit('No direct script access allowed');



/*
 [id] => 3
    [first_name] => Alice
      [last_name] => Wonder
    [email] => alice_manager@example.com
    [pass] => 9721a796dd679b9ffd50b672f2d66990654bfb6e233d89cef431b5f2814a1055
    [username] => alice_manager
    [banned] => 0
    [last_login] => 2019-10-05 16:10:28
    [last_activity] => 2019-10-05 16:10:28
    [date_created] => 2019-10-05 13:22:31
    [forgot_exp] => 
    [remember_time] => 
    [remember_exp] => 
    [verification_code] => 
    [totp_secret] => 
    [ip_address] => 127.0.0.1*/
?>
<!-- Main panel is starting from here -->

<div class="panel-header panel-header-sm">
</div>

<!-- Dashboard for User -->
<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="title">Add New Task</h5>
				</div>



				<?php
				$currentdate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
				echo ' <label class="text-warning font-weight-bold " >Current Date: </label> ' . date("d / m / Y", $currentdate) . '<br>';

				echo '<label class="text-warning font-weight-bold " >Current Month : </label> ' . date(" F Y") . '   ' ?>
				<div class="card-body">
					<!-- Form Start her-->
					<?php echo form_open('task/save', array('id' => 'task_form')); ?>
					<div class="row">

						<div class="col-md-4 font-weight-bold ">
							<div class="form-group">
								<label>Task Codes</label>
								<input type="text" name="code" class="form-control" placeholder="Task Code" value="<?php echo $task_code; ?>" readonly>
							</div>
							<div class="form-group">
								<label>Add Task Title</label>
								<input type="text" name="title" class="form-control" placeholder="Add Title" value="">
							</div>
							<div class="form-group">
								<label>Task Description</label>
								<textarea class="form-control round" name="description" rows="7" id="comment" placeholder="Add Task description here" style="border: 1px solid #e3e3e3;"></textarea>
							</div>

						</div>

						<div class="col-md-4 font-weight-bold">

							<div class="form-group">
								<label>Start Date</label>
								<input type="date" name="start_date" max="3000-12-31" min="1000-01-01" class="form-control">
							</div>
							<div class="form-group">
								<label>End Date</label>
								<input type="date" name="end_date" min="1000-01-01" max="3000-12-31" class="form-control">
							</div>
							<div class="form-group">
								<label for="sel1">Given By</label>
								<select class="form-control" id="sel1" name="given_by">
									<option>Select Given</option>
									<?php
									if (!empty($employees)) {
										foreach ($employees as $key => $value) {
											echo '<option value="' . $value->id . '" >' . $value->first_name . ' ' . $value->last_name . '</option>';
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="sel1">Follow Up</label>
								<select class="form-control" id="sel1" name="reporter">
									<option>Select a Person</option>
									<?php
									if (!empty($employees)) {
										foreach ($employees as $key => $value) {
											echo '<option value="' . $value->id . '" >' . $value->first_name . ' ' . $value->last_name . '</option>';
										}
									}
									?>
								</select>
							</div>
						</div>


						<div class="col-md-4 font-weight-bold">

							<div class="form-group">
								<label for="sel1">Job Type / Task Categories</label>
								<select class="form-control" id="sel1" name="parentId">
									<option value="1">Daily</option>
									<option value="2">Weekly</option>
									<option value="3">Monthly</option>
									<option value="4">One time</option>
								</select>
							</div>

							<div class="form-group">
								<label for="sel1">Select Department</label>
								<select class="form-control" id="sel1" name="department">
									<option>Select Department</option>
									<?php
									if (!empty($departments)) {
										foreach ($departments as $key => $value) {
											echo '<option value="' . $value->cid . '" >' . $value->c_name . '</option>';
										}
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label for="sel1">Assigned To</label>
								<select class="form-control" id="sel1" name="assignee">
									<option>Select Given</option>
									<?php
									if (!empty($employees)) {
										foreach ($employees as $key => $value) {
											echo '<option value="' . $value->id . '" >' . $value->first_name . ' ' . $value->last_name . '</option>';
										}
									}
									?>
								</select>
							</div>

							<div class=" file-upload-wrapper mt-4">
								<label>Attach File</label>
								<input type="file" id="input-file-now" name="attachement" class="file-upload" />
							</div>

						</div>

						<div class="col-md-12 text-right font-weight-bold">
							<div class=" mt-4">
								<input type="submit" class="btn btn-info btn-lg " value="Save" style="background: #244973;">
								<?php echo form_close(); ?>
								<!-- Form End here-->
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>


</div>