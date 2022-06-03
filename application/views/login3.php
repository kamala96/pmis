<?php $this->load->view('login_header');?>
<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

<div class="container" style="padding-top:10em;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-footer text-center" style="background-color:#c31f26;color: #fcd403;">
                    <img src="<?php echo base_url(); ?>assets/images/tpc.png" width="150" height="150">
                </div>
                <div class="panel-body">
                	<!-- <div style="text-align: center;">
                		  <img src="<?php echo base_url(); ?>assets/images/tcp.png" width="150" height="150">
                	</div> -->
					<br>
                        <form action="<?php  echo base_url('login/Login_Auth')?>" name="myForm" onsubmit="return validateForm()" method="post" >
		  	<div class="row" style="">
				<div class="col-md-12" style="color: #a94442;text-align: center;">
					<?php echo $this->session->flashdata('err_message');?>
				</div>
		  		<div class="col-md-12">
		  			<div class="form-group">
		  				<label for="username">Username:</label>
		  				<div class="inner-addon left-addon">
    <i class="glyphicon glyphicon-user"></i>
    <input type="text" class="form-control" id="username" placeholder="Enter username" name="email" style="height: 40px;" onkeyup="myFunction()">
		      <span id="errorUsername" style="color:#a94442;"></span>
</div>  
		    </div>
		  		</div>
		  	</div>
		    <div class="row">
		    	<div class="col-md-12">
		    		<div class="form-group" style="">
		      <label for="pwd">Password:</label>
		      <div class="inner-addon left-addon">
    <i class="glyphicon glyphicon-lock"></i>
    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" style="height: 40px;" onkeyup="myFunction1()">
		     <span id="errorPassword" style="color:#a94442;"></span>
</div>
		    </div>
		    	</div>
		    	
		    </div>
		    <br>
		   <div class="row">
		   	<div class="col-md-12">
		   		<div class="form-group" style="text-align: center;">
		   		<button type="submit" class="btn btn-default form-control" style="height: 40px;background-color: #fcd403;border-color: #fcd403;color: #c31f26;" ><i class="glyphicon glyphicon-log-in" style="color: #c31f26;"></i>&nbsp; Login</button>
					<br/><br/>
					<!-- <a href="<?php echo base_url('users/users') ?>" style="color: #c31f26;"> Please Register Here!!</a> -->
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
