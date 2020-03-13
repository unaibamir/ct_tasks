<div class="modal fade task-assign-popup-<?php echo $task->tid; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" style="margin:0;">
                    Assign Task: <strong>GEW_<?php echo $task->t_code; ?></strong>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid" style="font-size: 14px;">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            
                            <?php echo form_open_multipart('/task/assign', array('class' => 'task_assign_form')); ?>
                                
                                <div class="form-group row">
                                    <label for="task-code-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">Task Code</label>
                                    <div class="col-md-9 text-left">
                                        <input id="task-code-<?php echo $task->t_code; ?>" type="text" name="code" class="form-control" value="<?php echo $task->tid; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="title-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        Task Title <small>(max 100 characters)</small>
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <input type="text" id="title-<?php echo $task->t_code; ?>" name="title" class="form-control" value="<?php echo $task_title; ?>" placeholder="Add Title" required maxlength="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="comment-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">Task Description</label>
                                    <div class="col-md-9 text-left">
                                        <textarea class="form-control round" name="description" rows="7" id="comment-<?php echo $task->t_code; ?>" required placeholder="Add Task description here" style="border: 1px solid #e3e3e3;"><?php echo $task->t_description; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="start_date-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        Start Date
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <input type="text" name="start_date" autocomplete="off" style="background-color: #FFF;" class="form-control text-left start_date" required id="start_date-<?php echo $task->t_code; ?>" value="<?php echo $start_date; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="end_date-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        End Date
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <input type="text" name="end_date" autocomplete="off" style="background-color: #FFF;" class="form-control text-left end_date" id="end_date-<?php echo $task->t_code; ?>" value="<?php echo $end_date; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="given_by-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        Given By:
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <select class="form-control" id="given_by-<?php echo $task->t_code; ?>" name="given_by" required>
                                            <option value="">Select Given</option>
                                            <?php
                                            if (!empty($employees)) {
                                                foreach ($employees as $key => $user) {
                                                    $selected = !empty($task->given_by) && $task->given_by == $user->id ? " selected " : "";
                                                    echo '<option value="' . $user->id . '" '.$selected.' >' . $user->first_name . ' ' . $user->last_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="follow_up-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        Follow Up:
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <select class="form-control" id="follow_up-<?php echo $task->t_code; ?>" name="reporter" required>
                                            <option value="">Select a Person</option>
                                            <?php
                                            if (!empty($employees)) {
                                                foreach ($employees as $key => $user) {
                                                    $selected = !empty($task->reporter) && $task->reporter == $user->id ? " selected " : "";
                                                    echo '<option value="' . $user->id . '" '.$selected.' >' . $user->first_name . ' ' . $user->last_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sel1-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        Job Type / Task Categories
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <select class="form-control" id="sel1-<?php echo $task->t_code; ?>" name="parentId" required>
                                            <option value="1" <?php echo !empty($task->parent_id) && $task->parent_id == 1 ? "selected" : ""; ?> >Daily</option>
                                            <option value="2" <?php echo !empty($task->parent_id) && $task->parent_id == 2 ? "selected" : ""; ?> >Weekly</option>
                                            <option value="3" <?php echo !empty($task->parent_id) && $task->parent_id == 3 ? "selected" : ""; ?> >Monthly</option>
                                            <option value="4" <?php echo !empty($task->parent_id) && $task->parent_id == 4 ? "selected" : ""; ?> >One time</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="department-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">
                                        Select Department
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <select class="form-control department" id="department-<?php echo $task->t_code; ?>" name="department" required>
                                            <option value="">Select Department</option>
                                            <?php
                                            if (!empty($departments)) {
                                                foreach ($departments as $key => $value) {
                                                    $selected = !empty($task->department_id) && $task->department_id == $value->cid ? ' selected="selected" ' : '';
                                                    echo '<option value="' . $value->cid . '" '.$selected.' >' . $value->c_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="assignee-<?php echo $task->t_code; ?>" class="col-sm-3 col-form-label" style="color: #000;">Assign To</label>
                                    <div class="col-md-9 text-left">
                                        <select class="form-control assignee" id="assignee-<?php echo $task->t_code; ?>" name="assignee" required>
                                            <option value="">Select Given</option>
                                            <?php
                                            if (!empty($employees)) {
                                                foreach ($employees as $key => $value) {
                                                    $selected = !empty($task->assignee) && $task->assignee == $value->id ? ' selected="selected" ' : '';
                                                    echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->first_name . ' ' . $value->last_name . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group row">
                                    <label for="" class="col-sm-3 col-form-label" style="color: #000;">
                                        Attach File
                                    </label>
                                    <div class="col-md-9 text-left">
                                        <div class="repeater-fields">
                                            <div class="entry input-group col-xs-3">
                                                <input name="files[]" type="file" class="file-input">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-success btn-add">
                                                        <i class="now-ui-icons ui-1_simple-add"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group row">
                                    <div class="col-md-9 offset-3 text-left">
                                        <input type="submit" value="Update Task" class="btn btn-success btn-sm">
                                    </div>
                                </div>

                                <input type="hidden" name="task_id" value="<?php echo $task->tid; ?>">

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>