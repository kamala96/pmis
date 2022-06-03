
<?php $this->load->view('login_header');?>
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

<div class="container" style="padding-top:10em;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
            <div class="panel-footer text-center" style="background-color:#c31f26;color: #fcd403;padding-bottom: 20px;">
                    <h4>Please Login To PMIS
                </div>
                <div class="panel-footer text-center" style="background-color:#fff;color: #fcd403;">
                    <img src="<?php echo base_url(); ?>assets/images/tcp.png" width="270">
                </div>
                <div class="panel-body">
                        <hr />
                        <?php if(!empty($this->session->flashdata('feedback'))){ ?>
                            <div class="message">
                            <strong>Danger! </strong><?php echo $this->session->flashdata('feedback')?>
                            </div>
                            <?php
                            }
                            ?>   

                         <form class="form-horizontal form-material" method="post" id="loginform" action="login/Login_Auth">
                    <div class="form-group">
                        <div class="col-xs-12">
                        <label for="username">Username:</label>
                        <div class="inner-addon left-addon">
                            <i class="glyphicon glyphicon-user"></i>
                           <input class="form-control" name="email" value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>" type="text" required placeholder="Enter Username" style="height: 40px;">
                        </div>  
                        </div>
                        </div>
                   <!--  <div class="form-group">
                        <div class="col-xs-12">
                            <label for="username">Password:</label>
                            <input class="form-control" name="password" value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" type="password" required placeholder="Password" style="">
                        </div>
                    </div> -->
            <div class="form-group" style="">
                <div class="col-xs-12">
              <label for="pwd">Password:</label>
              <div class="inner-addon left-addon">
                    <i class="glyphicon glyphicon-lock"></i>
                    <input class="form-control" name="password" value="<?php if(isset($_COOKIE['password'])) { echo $_COOKIE['password']; } ?>" type="password" required placeholder="Enter Password" style="height: 40px;">
                </div>
            </div>
            </div>
                
                 <br>                     
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <div class="form-group" style="text-align: center;padding-right: 15px;padding-left: 15px;">
                <button type="submit" class="btn btn-default form-control" style="height: 40px;background-color: #fcd403;border-color: #fcd403;color: #c31f26;" ><i class="glyphicon glyphicon-log-in" style="color: #c31f26;"></i>&nbsp; Login</button>
                   
            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('login_footer');?>
