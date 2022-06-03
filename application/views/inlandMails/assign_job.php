<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Assign Job</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Assign Job</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $countervalue = $this->employee_model->counterselect(); ?>
	<?php $empservices = $this->organization_model->get_services34(); ?>
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
                        <h4 class="m-b-0 text-white"> Assign Job
                        </h4>
                    </div>
                    <div class="card-body">
					<div class="table-responsive ">
					<form method = "POST" action="<?php echo base_url();?>Job_assign/Assign_Service_Action">
                        <div class="col-md-12">
                            <?php if(!empty($message)){ ?>
                            <div class="alert alert-success alert-dismissible">
                            <strong>Success!</strong> <?php echo $message; ?>
                          </div>
                          <?php } ?>
                        </div>
                        <input type="hidden" name="emid" value="<?php echo $emid; ?>"/>
						<div class="col-md-6">
						<label>Select Counter</label>
						<select name="counter" class="custom-select form-control" required="required">
							    <option value="">--Select Counter--</option>
								<?php foreach($countervalue as $value){ ?>
								<option value="<?php echo $value->counter_id; ?>"><?php echo $value->counter_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-md-12 m-t-30">
						<label>Assign Service</label>
						<br>

						<?php foreach ($empservices as $value1) {?>

							<?php echo $value1->serv_name?> :
							<input type="checkbox" name="serv_id[]" value="<?php echo $value1->serv_id?>" class="" style="padding-bottom: 50px;" 
							<?php 
							foreach ($service2 as $val){
								if ($value1->serv_id == $val->serv_id) {
									echo "checked";
									break;
								}else{

								}
							}
							?>>

						<?php } ?>
					</div>
					<div class="form-group col-md-12 m-t-30">
						<button type="submit" class="btn btn-info">Save Job</button>
					</div>
					</form>
                    </div>
                    </div>
                </div>
            </div>
        </div>

<script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 1900; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
    </script>
    <script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 1900; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#yearsTo").append(options);
    </script>
<?php $this->load->view('backend/footer'); ?>

