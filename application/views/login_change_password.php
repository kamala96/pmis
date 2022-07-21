<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
    <div class="container">
      <div class="row align-items-center" style="height:100vh !important;">
        <form action="<?php echo base_url('login/change_password');?>" method="post">
            <div class="col-md-6 offset-md-3">
                <span class="anchor" id="formChangePassword"></span>
                <div class="mb-5">
                    <!-- form card change password -->
                    <div class="card card-outline-secondary">
                        <div class="card-header" style="background-color:#d22c19;color:white">
                            <h3 class="mb-0">Change Password</h3>
                        </div>
                        <div class="card-body">
                            <?php
                                if(validation_errors())
                                {
                                    echo "<div class='alert alert-danger'>".validation_errors()."</div>";
                                }

                                if($this->session->flashdata('error') ||$this->session->flashdata('hint'))
                                {
                                ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $this->session->flashdata('error');?>
                                    <?php echo $this->session->flashdata('hint');?>
                                </div>
                                <?php 
                                }
                            ?>
                            <form class="form" role="form" autocomplete="off">
                                <div class="form-group mb-3">
                                    <label for="inputPasswordOld">Current Password</label>
                                    <input type="email" name="password_reset_email" value="<?php echo $this->session->userdata('password_reset_email'); ?>" class="form-control" style="display:none;">
                                    <input type="password" name="oldpassword" class="form-control" id="inputPasswordOld">
                                </div>
                                <div class="form-group pass_show mb-3">
                                    <label for="inputPasswordNew">New Password</label>
                                    <input type="password" name="newpassword" class="form-control" id="inputPasswordNew">
                                    <!-- <span class="form-text small text-muted">
                                            The password must be 8-20 characters, and must <em>not</em> contain spaces.
                                        </span> -->
                                    </div>
                                    <div class="form-group pass_show mb-3">
                                        <label for="inputPasswordNewVerify">Confirm Password</label>
                                        <input type="password" name="passconfirm" class="form-control" id="inputPasswordNewVerify">
                                    <!-- <span class="form-text small text-muted">
                                            To confirm, type the new password again.
                                        </span> -->
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-success btn-lg float-right"style="background-color:#d22c19;color:white">Save Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- /form card change password -->
                </form>
            </div>
        </div>
    </body>
    </html>  