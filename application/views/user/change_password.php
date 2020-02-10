<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="panel-header panel-header-sm"></div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>

<script>
    function validatePassword() {
        var validator = $("#changePassword").validate({
            rules: {
                password: {
                	required : true,
                	minlength: 8
                },
                conform_password: {
                    equalTo: "#password",
                    required : true,
                	minlength: 8
                }
            }
        });
    }
 
    </script>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Change Password</h5>
                </div>
                <div class="card-body">
                	<div class="row">
	                	<div class="col-md-4 offset-md-4">
		                	<form action="<?php echo base_url('user/password_change'); ?>" method="POST" id="changePassword">
		                		<div class="col-md-12 font-weight-bold">
		                			<div class="mt-4 form-group">
		                				<label>New Password</label>
		                				<input type="password" id="password" name="password" class="form-control" placeholder="Password" required="required">
		                			</div>

		                			<div class="mt-4 form-group">
		                				<label>Confirm Password</label>
		                				<input type="password" id="conform_password" name="conform_password" class="form-control" placeholder="Confirm Password" required="required">
		                			</div>

		                			<div class=" mt-4">
		                				<input type="submit" class="btn btn-info btn-lg " value="Reset" style="background: #244973;" onClick="validatePassword();">
		                			</div>
		                		</div>

		                		<input type="hidden" name="user_id" value="<?php echo $currentUser->id ?>">
		                	</form>
	                	</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>