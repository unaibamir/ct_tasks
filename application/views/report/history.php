<?php
defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Main panel is starting from here -->

<div class="panel-header panel-header-sm">
</div>

<script src="https://cdn.tiny.cloud/1/xi0u55dl0cftjbp4pdbjakkge3tbtdza412p3l2gjyf5eya2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
	selector: '.tinymce',
	branding: false,
	menubar: false
});
</script>
<!-- Dashboard for User -->
<div class="content">
	<div class="row">

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5 class="title text-sm-center">GEW_<?php echo $task->user_code; ?>_<?php echo $task->t_code; ?> - Task History</h5>
				</div>
				<div class="card-body" style="background-color: white; ">

					<div class="row">

						<div class="col-lg-4 rounded  p-4" style="border-right: 2px solid; background: #19385b; ; color: white;">
							<div class="row ">
								<h2 class="text-sm-center text-primary ">Task Details </h2>

							</div>
							<div class="row ">
								<h6 class=" m-1">Task Code : </h6>
								<p class="card-text mx-1 m-1 text-warning">GEW_<?php echo $task->user_code; ?>_<?php echo $task->t_code; ?></p>
							</div>
							<div class="row ">
								<h6 class=" m-1 ">Task Description :</h6>
								<div class="col-md-12">
									<p class=" card-text text-warning"><?php echo $task->t_description; ?></p>
								</div>
							</div>
							<div class="row ">
								<h6 class=" m-1 ">Task Status :</h6>
								<p class="card-text mx-2 m-1 text-warning"><?php echo getStatusText($task->t_status); ?></p>
							</div>
							<div class="row ">
								<h6 class=" m-1">Given By : </h6>
								<p class="card-text mx-1 m-1 text-warning">
									<?php 
									if( !empty( $task->given_f ) ) {
                                        echo $task->given_f . " " . $task->given_l;
                                    } else {
                                        echo $task->created_by_f . " " . $task->created_by_l;
                                    }
                                    ?>
								</p>
							</div>
							<div class="row ">
								<h6 class="m-1">Follow Up :</h6>
								<p class="card-text mx-2 m-1 text-warning"><?php echo $task->follow; ?></p>
							</div>
							<div class="row ">
								<h6 class=" m-1">Start Date : </h6>
								<p class="card-text mx-1 m-1 text-warning"><?php echo date($this->config->item('date_format'), strtotime($task->start_date)); ?></p>
							</div>
							<div class="row ">
								<h6 class="m-1">End Date :</h6>
								<p class="card-text mx-2 m-1 text-warning"><?php echo !empty($task->end_date) ? date($this->config->item('date_format'), strtotime($task->end_date)) : ""; ?></p>
							</div>
							<div class="row ">
								<h6 class="m-1">Task Title :</h6>
								<p class="card-text mx-2 m-1 text-warning"><?php echo $task->t_title; ?></p>
							</div>

							<div class="row">
								<h6 class=" m-1 ">Task Files:</h6>
								<div class="col-md-12">
									<?php
									if (!empty($task_files)) {
										echo '<ul style="padding-left:0px;list-style: none;">';
										foreach ($task_files as $file) {
											?>
											<li>
												<a href="<?php echo $file["url"]; ?>" target="_blank">
													<img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png" width="40" height="40"> <?php echo $file["f_title"]; ?>
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
							<?php if( $currentUserGroup == "Manager" && $currentUser->cur_loc != 'Fujairah' ): ?>
								
								<div class="row" id="notes">

									<div class="col-md-12 p-0">
										<h6 class=" m-1 mt-3 ">Notes:</h6>

										<?php
										if( !empty($notes) ) {
											?>
											<div class="row">
												<div class="col-md-12" id="task-notes">
													<ul>
														<?php
														foreach ($notes as $note) {
															?>
															<li id="note-<?php echo $note->id;?>">
																<div class="note-actions">
																	<ul>
																		<li>
																			<!-- <a href="javascript:void(0);" data-note_id="<?php echo $note->id;?>" data-action="edit" class="edit-note">
																				<i class="far fa-edit"></i>
																			</a> -->
																			<a href="javascript:void(0);" data-note_id="<?php echo $note->id;?>" data-action="delete" class="delete-note">
																				<i class="fas fa-trash-alt"></i>
																			</a>
																		</li>
																	</ul>
																</div>
																<?php echo autop($note->note); ?>
															</li>
															<?php
														}
														?>
													</ul>
												</div>
											</div>	
											<?php
										}
										?>									

										<div class="row">
											<div class="col-md-12" id="create-note">
												<h6 class=" m-1 mt-3 ">Create New Note:</h6>
												<form action="<?php echo base_url('/task/save_task_note'); ?>" method="post">
													<textarea name="note" class="tinymce" rows="15" placeholder="Enter your note here"></textarea>
													<input type="submit" class="btn btn-info" value="Submit" name="save_note">
													<input type="hidden" name="task_id" value="<?php echo $task->tid; ?>">
													<input type="hidden" name="user_id" value="<?php echo $currentUser->id ?>">
													<input type="hidden" name="referrer" value="<?php echo $this->input->server('REDIRECT_URL'); ?>#notes">
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>

						</div>

						<div class="col-lg-8 rounded  p-4 table-striped">
							<form action="" method="get">
								<div class="row">
									<div class="col-md-3">
		                                <div class="form-group">
		                                    <label>Start Date</label>
		                                    <input type="text" name="start_date" autocomplete="off" style="background-color: #FFF;" class="form-control text-left" required id="start_date" value="<?php echo @$_GET["start_date"]?>">
		                                </div>
									</div>
									<div class="col-md-3">
		                                <div class="form-group">
		                                    <label>End Date</label>
		                                    <input type="text" name="end_date" autocomplete="off" style="background-color: #FFF;" class="form-control text-left" required id="end_date" value="<?php echo @$_GET["end_date"]?>">
		                                </div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="search" value="report_daily">
											<input type="submit" class="btn btn-info " value="Submit" style="background: #244973;margin-top: 23px;">
										</div>
									</div>
								</div>
							</form>

							<div class="row font-weight-bold text-danger border">
								<div class="col-md-1"><label>Date</label></div>
								<div class="col-md-5"><label>Update</label></div>
								<div class="col-md-1"><label>Status</label></div>
								<div class="col-md-3"><label>Reason</label></div>
								<div class="col-md-2"><label>Files</label></div>
							</div>

							<?php

							if( !empty( $dates_reports ) ) {
								foreach ($dates_reports as $date_report) {

									$report = $date_report["report"];

									?>
									<div class="row bg-light border-bottom ">
										<div class="col-md-1 text-info font-weight-bold border-right pt-5 pb-5 p-1">
											<?php echo $date_report["date"]; ?>
										</div>

										<?php if( !empty( (array) $report ) ) { ?>
											<div class="col-md-5 bg-light p-3 border-right">
													<p><?php echo nl2br($report->berfore); ?></p>
													<hr>
													<p><?php echo nl2br($report->after); ?></p>
											</div>


											<div class="col-md-1 text-primary t-3 text-sm-center border-right pt-5">
												<label><b><?php echo $report->status; ?></b></label>
											</div>

											<div class="col-md-3 text-primary t-3 text-sm-left border-right pt-5">
												<label><b><?php echo $report->reason; ?></b></label>
											</div>

											<div class="col-md-2 bg-light p-3 border-right ">
												<?php

												if (!empty( (array) $report->files )) {
													echo '<ul style="padding-left:0px;list-style: none;">';
													foreach ($report->files as $file) {
														?>
														<li style="margin-bottom: 5px;">
															<a href="<?php echo $file->url; ?>" target="_blank">
																<img src="https://freeiconshop.com/wp-content/uploads/edd/document-download-flat.png" width="40" height="40"> <?php echo $file->f_title; ?>
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
										<?php }
										else {
											echo '<div class="col-md-10 bg-light pt-5 border-right text-sm-left">'. $this->config->item('no_report_history') .'</div>';
										}
										?>
									</div>
									<?php
								}
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
<!-- Dashboard for User body-->