<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="panel-header panel-header-sm"></div>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title"><?php echo $heading1; ?></h5>
                </div>
                <div class="card-body">

					<form method="POST" action="<?php echo base_url('/admin/internal/task/report/save'); ?>">
						<div class="col-md-5 offset-md-3">
							<div class="">
								<div class="form-group">
									<label for="task"><strong>Select Task</strong></label>
									<select name="task_id" id="task" class="form-control">
										<option value="">Select Task</option>
										<?php foreach ($tasks as $task) {
											echo '<option value="'.$task->tid.'">';
												echo $task->t_code;
												echo ' - ';
												echo $task->t_title;
												echo ' - ';
												echo getStatusText($task->t_status);
											echo '</option>';
										} ?>
									</select>
								</div>

								<div class="form-group">
									<label for="date"><strong>Date</strong></label>
									<input type="text" name="date" id="date" class="datepickerBT form-control" autocomplete="off">
								</div>

								<div class="form-group">
									<label for="status"><strong>Status</strong></label>
									<div class="clearfix clear"></div>

									<label class="radio-inline">
                                        <input type="radio" name="status" id="task_status_y" value="Y" required />Y
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" id="task_status_n" value="N" >N
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" id="task_status_h" value="H" >H
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" id="task_status_c" value="C" >C
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="status" id="task_status_c" value="F" >F
                                    </label>
								</div>

								<div class="form-group">
									<label for="reason"><strong>Remarks / Reason</strong></label>
									<textarea name="reason" id="reason" class="form-control" rows="3" style="border: 1px solid #E3E3E3;"></textarea>
								</div>

								<div class="form-group">
									<label for="before"><strong>Before Break</strong></label>
									<textarea name="before" id="before" class="form-control" rows="3" style="border: 1px solid #E3E3E3;"></textarea>
								</div>

								<div class="form-group">
									<label for="after"><strong>After Break</strong></label>
									<textarea name="after" id="after" class="form-control" rows="3" style="border: 1px solid #E3E3E3;"></textarea>
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-info" value="Save" >
								</div>

							</div>
						</div>
					</form>

                </div>
            </div>
        </div>
    </div>
</div>