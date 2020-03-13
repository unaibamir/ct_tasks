<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Gewportal - Add User</title>

	<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />


	<script src="<?php echo base_url('assets/js/core/jquery.min.js');?>"></script>
</head>
<body>

	<header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">About</h4>
          <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-white">Contact</h4>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">
      <a href="#" class="navbar-brand d-flex align-items-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
        <strong>Album</strong>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>

	<div class="container">
    <div class="row">
        <div class="col-md-12">
            
            <?php echo form_open_multipart('admin/internal/user/save', array('class' => 'form-horizontal')); ?>
                <fieldset>

                    <!-- Form Name -->
                    <legend style="margin-bottom: 50px;">Add User</legend>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="first_name">First Name</label>
                        <div class="col-md-5">
                            <input id="first_name" name="first_name" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="last_name">Last Name</label>
                        <div class="col-md-5">
                            <input id="last_name" name="last_name" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Password input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="password">Password</label>
                        <div class="col-md-5">
                            <input id="password" name="password" type="password" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="username">User Name</label>
                        <div class="col-md-5">
                            <input id="username" name="username" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="email">Email</label>
                        <div class="col-md-5">
                            <input id="email" name="email" type="email" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="cur_loc">Current Location</label>
                        <div class="col-md-5">
                            <input id="cur_loc" name="cur_loc" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="per_mon_no">Personal Mobile No</label>
                        <div class="col-md-5">
                            <input id="per_mon_no" name="per_mon_no" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="company_email">Company Email</label>
                        <div class="col-md-5">
                            <input id="company_email" name="company_email" type="email" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="com_mob_no">Company Mobile No</label>
                        <div class="col-md-5">
                            <input id="com_mob_no" name="com_mob_no" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="job_title">Job Title</label>
                        <div class="col-md-5">
                            <input id="job_title" name="job_title" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    

                    <!-- Select Basic -->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="dept_id">Department</label>
                        <div class="col-md-5">
                            <select id="dept_id" name="dept_id" class="form-control">
                                <option>Please Select</option>
                                <?php foreach ($departments as $department) {
                                	echo '<option value="'.$department->cid.'">'.$department->c_name.'</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="nationality">Nationality</label>
                        <div class="col-md-5">
                            <input id="nationality" name="nationality" type="text" placeholder="" class="form-control input-md" required="">

                        </div>
                    </div>

                    <div class="form-group row">
					    <div class="col-sm-10">
					      <button type="submit" class="btn btn-primary">Add User</button>
					    </div>
					  </div>

                </fieldset>
            </form>
        </div>
    </div>
</div>
	
	<script src="<?php echo base_url('assets/js/core/bootstrap.min.js');?>"></script>
</body>
</html>