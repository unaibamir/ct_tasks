<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->
<div class="panel-header panel-header-sm">
</div>
<!-- Dashboard for User -->
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title text-sm-center"><?php echo $task->t_code; ?> - Task Form</h5>
                    <?php
                    if (!empty($task->t_status) && $task->t_status != "in-progress") {
                        ?>
                        <div class="col-md-6 offset-3 text-sm-center">
                            <div class="alert alert-primary">
                                <span>
                                    <b> Sorry!</b> You cannot add report because of task status is <strong><?php echo getStatusText($task->t_status); ?></strong>
                                </span>
                            </div>
                        </div>
                        <?php
                    }

                    if (!$can_submit) {
                        ?>
                        <div class="col-md-6 offset-3 text-sm-center">
                            <div class="alert alert-primary">
                                <span>
                                    <b> Sorry!</b> You cannot add report because task due time is expired.
                                </span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    
                </div>
                <div class="card-body" style="">
                    <div class="row  m-1">
                        <div class="col-lg-2 rounded p-4 " style="border-right: 2px solid; background: #02300a;  color: white;">
                            <div class="row ">
                                <h3 class="text-sm-center text-primary ">Employee Record </h3>
                            </div>
                            <div class="row text-sm-center ">
                                <h6 class=" m-1">First Name : </h6>
                                <p class="card-text mx-1 text-warning"><?php echo $currentUser->first_name; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class="m-1">Last Name :</h6>
                                <p class="card-text mx-2 text-warning"><?php echo $currentUser->last_name; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class=" m-1">Employee Code : </h6>
                                <p class="card-text mx-1 text-warning"><?php echo $currentUser->username; ?></p>
                            </div>
                        </div>
                        <div class="col-lg-3 rounded  p-4" style="border-right: 2px solid; background: #19385b; ; color: white;">
                            <div class="row ">
                                <h2 class="text-sm-center text-primary ">Task Details </h2>
                            </div>
                            <div class="row ">
                                <h6 class=" m-1">Task Code : </h6>
                                <p class="card-text mx-1 text-warning"><?php echo $task->t_code; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class="m-1">Task Title :</h6>
                                <p class="card-text mx-2 text-warning"><?php echo $task->t_title; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class=" m-1">Given: </h6>
                                <p class="card-text mx-1 text-warning"><?php echo $task->given; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class="m-1">Follow Up:</h6>
                                <p class="card-text mx-2 text-warning"><?php echo $task->follow; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class="m-1">Assign To:</h6>
                                <p class="card-text mx-2 text-warning">
                                    <?php echo $currentUser->first_name; ?> <?php echo $currentUser->last_name; ?>
                                </p>
                            </div>
                            <div class="row ">
                                <h6 class=" m-1">Start Date : </h6>
                                <p class="card-text mx-1 text-warning"><?php echo date($this->config->item('date_format'), strtotime($task->start_date)); ?></p>
                            </div>
                            <div class="row ">
                                <h6 class="m-1">End Date :</h6>
                                <p class="card-text mx-2 text-warning"><?php echo !empty($task->end_date) ? date($this->config->item('date_format'), strtotime($task->end_date)) : ""; ?></p>
                            </div>
                            <div class="row ">
                                <h6 class="m-1">Task Status :</h6>
                                <p class="card-text mx-2 text-warning"><?php echo getStatusText($task->t_status); ?></p>
                            </div>
                            <div class="row ">
                                <h6 class=" m-1 ">Task Description :</h6>
                                <p class=" card-text m-2 text-warning"><?php echo $task->t_description; ?></p>
                            </div>
                        </div>
                        <div class="col-lg-6 rounded p-4" style="border-right: 2px solid; background: #19385b; ; color: white;">
                            <?php
                            if (!empty($task->t_status) && $task->t_status != "in-progress" || !$can_submit) {
                            ?>
                            <div class="no-task-report">
                                
                            </div>
                            <?php
                            }
                            ?>
                            <h3 class="text-divider text-primary"><span>Submit Task form</span></h4>
                            <?php
                            $currentdate = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                            echo ' <label class="text-warning font-weight-bold " >Current Date: </label> ' . date("d / m / Y", $currentdate) . '<br>';
                            echo '<label class="text-warning font-weight-bold " >Current Month : </label> ' . date(" F Y") . '   ' ?>
                            <?php echo form_open_multipart('report/save', array('id' => 'report_form', 'class' => 'form')); ?>
                            <div class="row">
                                <?php
                                $disabled = '';
                                $placeholderAfter = $placeholder = 'Add Comment Here... ';
                                if (!empty($alreadReported->berfore)) {
                                    $disabled = 'disabled';
                                    $placeholder = $alreadReported->berfore;
                                }
                                if (!empty($alreadReported->after)) {
                                    $disabled = 'disabled';
                                    $placeholderAfter = $alreadReported->after;
                                }
                                $status = "";
                                if (!empty($alreadReported->status)) {
                                    $status = $alreadReported->status;
                                }
                                ?>
                                <div class="col-md-10 task-report-status">
                                    <span class="text-warning"><strong>Status</strong></span>
                                    <div class="clearfix clear"></div>
                                    <label class="radio-inline text-warning">
                                        <input type="radio" name="status" id="task_status_y" value="Y" <?= $disabled ?> <?= ($status == 'Y') ? 'checked' : ''; ?> required />Y
                                    </label>
                                    <label class="radio-inline text-warning">
                                        <input type="radio" name="status" id="task_status_n" value="N" <?= $disabled ?> <?= ($status == 'N') ? 'checked' : ''; ?> />N
                                    </label>
                                    <label class="radio-inline text-warning">
                                        <input type="radio" name="status" id="task_status_h" value="H" <?= $disabled ?> <?= ($status == 'H') ? 'checked' : ''; ?> />H
                                    </label>
                                    <label class="radio-inline text-warning">
                                        <input type="radio" name="status" id="task_status_c" value="C" <?= $disabled ?> <?= ($status == 'C') ? 'checked' : ''; ?> />C
                                    </label>
                                    <label class="radio-inline text-warning">
                                        <input type="radio" name="status" id="task_status_c" value="F" <?= $disabled ?> <?= ($status == 'F') ? 'checked' : ''; ?> />F
                                    </label>
                                </div>
                                <div class="col-md-10 task-report-reason" style="">
                                    <span class="text-warning"><strong>Remarks</strong></span>
                                    <div class="clearfix clear"></div>
                                    <div class="input-group-prepend  ">
                                        <textarea name="reason" class="col-md-12" rows="3" <?= $disabled ?>></textarea>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <span class="text-warning"><strong>Befor Break</strong></span>
                                    <div class="input-group-prepend">
                                        <textarea name="befor" class="col-md-12" aria-label="With textarea" rows="5" placeholder=" <?= $placeholder ?>" <?= $disabled ?> required></textarea>
                                    </div>
                                    <span class="text-warning"><strong>After Break</strong></span>
                                    <div class="input-group-prepend  ">
                                        <textarea name="after" class="col-md-12" aria-label="With textarea" rows="5" placeholder=" <?= $placeholderAfter ?>" <?= $disabled ?> required></textarea>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group-prepend">
                                        <span class="text-warning m-2" id="inputGroupFileAddon01">Upload File</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="report-file" aria-describedby="inputGroupFileAddon01" name="report_file" <?= $disabled ?>>
                                        <label class="custom-file-label" for="report-file" id="report-file-label">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-4">
                                    <input type="hidden" name="task_id" value="<?php echo $task->tid; ?>" />
                                    <input type="submit" class="btn btn-info" value="Save" <?= $disabled ?> />
                                </div>
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
<!-- Dashboard for User body-->