<?php
defined('BASEPATH') or exit('No direct script access allowed');
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
                <?php //dd($employee_user, false); ?>
                <div class="card-body">
                    <?php
                    $currentdate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                    echo ' <label class="text-warning font-weight-bold " >Current Date: </label> ' . date("d / m / Y", $currentdate) . '<br>';
                    echo '<label class="text-warning font-weight-bold " >Current Month : </label> ' . date(" F Y") . '   ' ?>
                    <!-- Form Start her-->
                    <?php echo form_open_multipart('task/save', array('id' => 'task_form')); ?>
                    <div class="row">
                        <div class="col-md-4 font-weight-bold ">
                            <div class="form-group">
                                <label>Task Codes</label>
                                <input type="text" name="code" class="form-control" placeholder="Task Code" value="<?php echo $last_task_id; ?>" readonly>
                                <!-- <p class="form-control">Task Code Will be auto generated</p> -->
                            </div>
                            <div class="form-group">
                                <label>Add Task Title <small>(max 100 characters)</small></label>
                                <input type="text" name="title" class="form-control" placeholder="Add Title" value="" required maxlength="100">
                            </div>
                            <div class="form-group">
                                <label>Task Description</label>
                                <textarea class="form-control round" name="description" rows="7" id="comment" required placeholder="Add Task description here" style="border: 1px solid #e3e3e3;"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 font-weight-bold">
                            
                            <div class="input-daterange">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" name="start_date" autocomplete="off" style="background-color: #FFF;" class="form-control text-left" required id="start_date">
                                </div>
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" name="end_date" autocomplete="off" style="background-color: #FFF;" class="form-control text-left" id="end_date">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sel1">Given By :</label>
                                <select class="form-control" id="given_by" name="given_by" required>
                                    <option value="">Select Given</option>
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
                                <label for="sel1">Follow Up :</label>
                                <select class="form-control" id="follow_up" name="reporter" required>
                                    <option value="">Select a Person</option>
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
                                <select class="form-control" id="sel1" name="parentId" required>
                                    <option value="1">Daily</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Monthly</option>
                                    <option value="4">One time</option>
                                </select>
                            </div>

                            <?php
                            if ($employee_id != "") {
                                ?>
                                <input type="hidden" name="department" value="<?php echo $employee_user->dept_id; ?>" readonly>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label for="sel1">Select Department</label>
                                    <div>
                                        <select class="form-control" id="department" name="department" <?php echo $employee_id != "" ? "disabled" : ""; ?> required>
                                        <option value="">Select Department</option>
                                        <?php
                                        if (!empty($departments)) {
                                            foreach ($departments as $key => $value) {
                                                $selected = isset($employee_user->dept_id) && $employee_user->dept_id == $value->cid ? ' selected="selected" ' : '';
                                                echo '<option value="' . $value->cid . '" '.$selected.' >' . $value->c_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <?php
                            if ($employee_id != "") {
                                ?>
                                <input type="hidden" name="assignee" value="<?php echo $employee_id; ?>" readonly>
                                <?php
                            } else {
                                ?>
                                <div class="form-group">
                                    <label for="sel1">Assign To</label>
                                    <div>
                                        <select class="form-control assignee" id="assignee" name="assignee" required>
                                        <option value="">Select Given</option>
                                        <?php
                                        if (!empty($employees)) {
                                            foreach ($employees as $key => $value) {
                                                $selected = $employee_id == $value->id ? ' selected="selected" ' : '';
                                                echo '<option value="' . $value->id . '" ' . $selected . '>' . $value->first_name . ' ' . $value->last_name . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class=" file-upload-wrapper mt-4">
                                <label>Attach File</label>
                                <!-- <input type="file" id="input-file-now" name="attachement" class="file-upload" /> -->
                                <br>
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