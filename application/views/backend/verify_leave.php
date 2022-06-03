<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Leave Application</li>
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
                    <a href="<?php echo base_url() ?>Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Leave Approve Form                       
                        </h4>
                    </div>
                    <div class="card-body">
						<form method="post" action="<?php echo base_url() ?>Leave/Leave_Application">
							<div class="row">
								<div class="col-md-6">
									<label>Employee Name</label>
									<select class="form-control custom-select" name="em_id" readonly>

											<option value="<?php echo $employee->em_id ?>"><?php echo $employee->first_name . '  '.$employee->middle_name.'  '.$employee->last_name ?></option>

									</select>
								</div>
								<div class="col-md-6">
									<label>Select Leave Type</label>
									<select class="form-control custom-select" name="leave_type">
											<option value="<?php echo $employee->type_id?>"><?php echo $employee->name;?></option>

									</select>
								</div>
							</div>
							<div class="row m-t-20">
								<div class="col-md-6">
									<label>Leave Start Date</label>
									<input type="text" name="startdate" class="form-control mydatetimepickerFull" id="recipient-name1" value="<?php echo $employee->start_date;?>">
								</div>
								<div class="col-md-6">
									<label>Leave Days</label>
									<input type="text" name="days" class="form-control" id="recipient-name1" value="<?php echo $employee->leave_duration;?>">
								</div>
							</div>
							<div class="row m-t-20">
								<div class="col-md-6">
									<label class="control-label">Region From</label>
									<input type="text" name="region_to" class="form-control" value="<?php echo $employee->em_region;?>" readonly>
								</div>
								<div class="col-md-6">
									<label class="control-label">Region To</label>
									<select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();" required="required">
										<option value="<?php echo $employee->region_to;?>"><?php echo $employee->region_to;?></option>
										<?Php foreach($regionlist as $value): ?>
											<option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="row m-t-20">
								<div class="col-md-6">
									<label>District To</label>
									<select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">
										<option value="<?php echo $employee->district_to;?>"><?php echo $employee->district_to;?></option>
									</select>
								</div>
								<div class="col-md-6">
									<label>Village To</label>
									<input type="text" name="village_to" class="form-control" value="<?php echo $employee->village_to;?>">
								</div>

							</div>
							<div class="row m-t-20">
								<div class="col-md-12">
									<label class="control-label">Reason</label>
									<textarea class="form-control" name="reason" id="message-text1"><?php echo $employee->reason;?></textarea>
								</div>
							</div>
							<?php if ($employee->name == 'Annual Leave'){ ?>
							<div class="row m-t-20">
								<div class="col-md-12">
									<label>Family Dependents</label>
									<br>
									<text><img src="<?php echo base_url(); ?>assets/images/close.jpg">
										- Not Supposed to pay &nbsp;&nbsp; <img src="<?php echo base_url(); ?>assets/images/success.png"> - Supposed to pay
									</text>
									<br>
									<table id="employeesFamily" class="display nowrap table table-bordered " cellspacing="0" width="100%">
										<thead>
										<tr style="background-color: antiquewhite;">
											<th>Full Name</th>
											<th>Date Of Birth</th>
											<th>Gender</th>
											<th>Age</th>
											<th>Title</th>
										</tr>
										</thead>
										<tbody>
										<?php if (!empty($family)){ ?>
										<?php foreach($family as $value): ?>
										<tr>
											<td><?php echo $value->first_name . '  ' . $value->middle_name . ' ' . $value->last_name; ?></td>
											<td><?php echo $value->dateofbirth; ?></td>
											<td><?php echo $value->gender; ?></td>
											<td><?php
														$dateProvided=$value->dateofbirth;
														$yearOnly=date('Y', strtotime($dateProvided));
														$monthOnly=date('m', strtotime($dateProvided));
														$age = date('Y') - $yearOnly;
														if ($value->title == 'Child' && $age == 0)
														{
															echo $age = date('m') - $monthOnly.' '.'Months'.'   '.'<img src="' .base_url().'assets/images/success.png'.'">';
														}elseif ($value->title == 'Child' && $age > 18){
																echo $age.'  '.'Years'.'   '.'<img src="'.base_url().'assets/images/close.jpg'.'">';
															}else{
																echo $age.'  '.'Years'.'   '.'<img src="' .base_url().'assets/images/success.png'.'">';
															}
														?></td>
													<td><?php echo $value->title; ?></td>

												</tr>
											<?php endforeach; ?>
										<?php }else{?>
											<tr>
												<td colspan="5" style="text-align: center;"><text style="color: red;">No Family</text></td>
											</tr>
										<?php }?>

										</tbody>
									</table>
								</div>
							</div>

								<div class="row m-t-20" style="" id="">
                                <div class="col-md-6">
                                    <label>Total Fare From Region To Region</label>
                                        <input type="number" name="amount" class="form-control" value="<?php echo $employee->fare_amount;?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Total Fare From District To Village</label>
                                    <input type="number" name="amount2" class="form-control"  value="<?php echo $employee->faredistrictvillage;?>">
                                </div>
                            </div>
                          <?php }?>
							<div class="row m-t-20">
									<div class="col-md-6">
										<label>Select Leave Status</label>
										<select name="status" class="form-control custom-select" id="saida" onchange="getDiv();">
											<option value="Approve">Approve</option>
											<option value="Rejected">Rejected</option>
										</select>
									</div>
								</div>
							<div class="row m-t-20" style="display: none;" id="reason">
								<div class="col-md-12">
									<label>Leave Rejection Reason</label>
									<textarea class="form-control" name="rejected_reason" id="message-text1"></textarea>
								</div>
							</div>
								<div class="row m-t-20">
									<div class="col-md-12">
										<input type="hidden" name="leave_id" value="<?php echo $employee->id; ?>">
										<button type="submit" class="btn btn-primary">Press To Approve Leave</button>
									</div>
								</div>
						</form>
					</div>
                </div>
            </div>
        </div>

		<script type="text/javascript">
            function getDistrict() {
                var val = $('#regionp').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>Employee/GetDistrict",
                    data:'region_id='+ val,
                    success: function(data){
                        $("#branchdropp").html(data);
                    }
                });
            };
		</script>
		<script type="text/javascript">
            function getDiv() {
				var div = $('#saida').val();
				if(div == 'Rejected'){
				    $('#reason').show();
				}else{
				    $('#reason').hide();
				}
            };
		</script>
<?php $this->load->view('backend/footer'); ?>


