<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Edit Family</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Family</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regvalue = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
<!--                    <a href="--><?php //echo base_url() ?><!--Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>-->
<!--                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="--><?php //echo base_url(); ?><!--leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button>-->
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Edit Family Form
                        </h4>
                    </div>
                    <div class="card-body">
						<form class="row" action="Save_family" method="post" enctype="multipart/form-data">
							<div class="form-group col-md-4 m-t-5">
								<label>First Name</label>

								<input type="text" name="first_name" class="form-control" value="<?php echo $family->first_name;?>">

							</div>
							<div class="form-group col-md-4 m-t-5">
								<label>Middle Name</label>
								<input type="text" name="middle_name" class="form-control" value="<?php echo $family->middle_name;?>">
							</div>
							<div class="form-group col-md-4 m-t-5">
								<label>Last Name</label>
								<input type="text" name="last_name" class="form-control" value="<?php echo $family->last_name;?>">
							</div>
							<div class="form-group col-md-4 m-t-5">
								<label>Date Of Birth</label>
								<input type="date" name="dob" id="example-email2" name="example-email" class="form-control" value="<?php echo $family->dateofbirth;?>">
							</div>
							<div class="form-group col-md-4 m-t-5">
								<label>Select Gender</label>
								<select name="gender" class="form-control custom-select" required="required">
									<option value="<?php echo $family->gender;?>"><?php echo $family->gender;?></option>
									<option value="M">Male</option>
									<option value="F">Female</option>
								</select>
							</div>
							<div class="form-group col-md-4 m-t-5">
								<label>Select Title</label>
							<select name="title" class="form-control custom-select" required="required" id="title" onChange="getType();">
								<option value="<?php echo $family->title;?>"><?php echo $family->title;?></option>
                                                             <option value="Parent">Parent</option>
                                                             <option value="Child">Child</option>
                                                              <option value="Spouse">Spouse</option>
                                                         </select>
                                                    </div>
													<div class="form-group col-md-4" id="attatch" style="display: none;">
														<label><span id="child"></span><span id="spouse"></span></label>
														<input type="file" name="image_url" class="form-control">
													</div>

							<div class="form-actions col-md-12">
								<input type="hidden" name="emid" value="<?php echo $family->em_id;?>">
								<input type="hidden" name="family_id" value="<?php echo $family->family_Id;?>">
								<button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save Information</button>
							</div>

						</form>
                    </div>
                </div>
            </div>
        </div>

<script type="text/javascript">
        function getType() {
        var type = $('#title').val();
        if (type == 'Child') {
            $('#attatch').show();
            $('#child').html('Attatch Birthcertificate');
            $('#spouse').html('');
        }else if(type == 'Spouse'){
            $('#attatch').show();
            $('#spouse').html('Attatch Marriage Certificate');
            $('#child').html('');
        }else{
            $('#attatch').hide();
        }
};
</script>   
<?php $this->load->view('backend/footer'); ?>

