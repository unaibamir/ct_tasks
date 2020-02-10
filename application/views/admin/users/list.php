<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>


<div class="panel-header panel-header-sm"></div>


<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Users List</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($users)) : ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm" id="table-list" style="width: 100%;">
                                <thead class="thead-dark table-bordered">
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Password</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($users as $user) {
                                        $delete_url = base_url("/admin/user/delete/".$user->id);
                                        //$change_password_url = base_url("/admin/user/change_pass/".$user->id);
                                        $department_key  =   array_search($user->dept_id, array_column($departments, "cid"));
                                        ?>
                                        <tr>
                                            <td><?php echo $user->id; ?></td>
                                            <td><?php echo $user->username; ?></td>
                                            <td><?php echo $user->first_name; ?></td>
                                            <td><?php echo $user->last_name; ?></td>
                                            <td><?php echo $user->email; ?></td>
                                            <td><?php
                                            if( array_key_exists($user->dept_id, $departments) ) {
                                                echo $departments[$department_key]->c_name;
                                            }
                                            ?></td>
                                            <td><?php echo $user->user_pass; ?></td>
                                            <td>
                                                <a href="#" class="btn btn-info btn-sm disabled" style="padding:5px;font-size:10px;">Edit</a>
                                                <a href="#" class="btn btn-info btn-sm disabled" style="padding:5px;font-size:10px;">Tasks</a>
                                                <a href="<?php echo $delete_url; ?>" class="btn btn-danger btn-sm disabled" style="padding:5px;font-size:10px;">Delete</a>

                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" style="padding:5px;font-size:10px;"data-toggle="modal" data-target=".user-change-pass-popup-<?php echo $user->id; ?>" >Change Password</a>

                                                <div class="modal fade user-change-pass-popup-<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog model-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title h4" style="margin:0;">
                                                                    Change Password
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="container-fluid" style="font-size: 14px;">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <form action="<?php echo base_url('user/password_change'); ?>" method="POST" id="changePassword">
                                                                                <div class="form-group row">
                                                                                    <label for="" class="col-sm-4 col-form-label" style="color: #000;">
                                                                                        New Password
                                                                                    </label>
                                                                                    <div class="col-md-8 text-left">
                                                                                        <input type="text" name="password" class="form-control" autocomplete="off" required="">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group row">
                                                                                    <div class="col-md-12 text-right">
                                                                                        <input type="submit" value="Change Password" class="btn btn-success btn-sm">
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="user_id" value="<?php echo $user->id; ?>">

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>