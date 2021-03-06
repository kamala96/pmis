<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> My Task  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> KPI </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
							
					<?php if($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='ADMIN' ||$this->session->userdata('user_type') =='RM' || $this->session->userdata('user_type') =='HOD' || $this->session->userdata('user_type') =='SUPER ADMIN'){ ?> 
					 
					 <a href="<?php echo site_url('Contract/approved_targets');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Assign task </button> </a>

					 <a href="<?php echo site_url('Contract/assigned_tasks');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Assigned tasks </button> </a>
					<?php }?>  

					 <a href="<?php echo site_url('Contract/my_tasks');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> My tasks </button> </a>
							
                            </div>
							
                            <div class="card-body">
							
							<?php 
							if(!empty($this->session->flashdata('message'))){
							echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('message'); ?>
									  <?php
                            echo "</div>";
							
							}
							?>

							<?php 
							if(!empty($this->session->flashdata('feedback'))){
							echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('feedback'); ?>
									  <?php
                            echo "</div>";
							
							}
							?>

                               <?php if(isset($listmytask)){ ?>
							   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Activity  </th>
												<th> Marks  </th>
												<th> Appraise  </th>
												<th> Sub-Activities  </th>
												<th> Attachment </th>
												<th> Assigned by </th>
												<th> Designation </th>
												<th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listmytask as $data){
										$id = $data->performance_indicators_id;
										$status = $data->indicator_progress;
										$name = $data->indicator_name; 
										$empid = $data->provided_by;
										$taskid = $data->performance_task_id;
										$listattach = $this->ContractModel->display_subact_attached($taskid);
                                        $info = $this->ContractModel->get_employee_info($empid);
                                        $list = $this->ContractModel->view_sub_activities($id);
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> 
                                                <a href="<?php echo site_url('Contract/approved_sub_activity');?>?activityid=<?php echo $id; ?>&&activityname=<?php echo $name; ?>">
												<?php echo $data->indicator_name; ?> </a> </td>
												<td> 
												<?php if(!empty($data->rating)){?>
												<?php echo $data->rating; ?> out of
												<?php }?>
												<?php echo $data->weight; ?> 
												</td>
												<td>

                                                <?php 
                                                //////Check Attachment
                                                if(!empty($listattach)){?> 

                                                <?php 
                                                /////Check Rating
                                                if(!empty($data->rating)){ 

                                                if(!empty($data->appraise)){
                                                echo @$data->appraise;
                                                } else {
                                                echo "Marked, You cannot add appraise";
                                                }

                                                } else { ?>


												<?php if(!empty($data->appraise)){ echo @$data->appraise; ?>
												<button class="btn btn-info" data-toggle="modal" type="button" data-target="#appraise_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-pencil"></i> Update Appraise </button>
												<?php } else { ?>
												<button class="btn btn-info" data-toggle="modal" type="button" data-target="#appraise_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-pencil"></i> Add Appraise </button>
												<?php } ?>

											   <?php } ?>


											 <?php } else { ?>

											 No Evidence, You cannot add appraise

											 <?php } ?>


												</td>
												<td>
												<a href="<?php echo site_url('Contract/approved_sub_activity');?>?activityid=<?php echo $id; ?>&&activityname=<?php echo $name; ?>">
												<?php @$activities = $this->ContractModel->count_sub_activities($id); echo @$activities; ?> 
												</a>
												</td>
												<td>  
                                                <?php if(!empty($listattach)){?> 
                                                <button class="btn btn-info" data-toggle="modal" type="button" data-target="#viewattach_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-file"></i> View Evidence  </button>
                                                <?php } else { ?> No attachment <?php }?>
												</td>
												<td> <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </td>
												<td> <?php echo $info->des_name; ?> </td>
												<td>
												
												
												 <button class="btn btn-info" data-toggle="modal" type="button" data-target="#attach_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-file"></i> Attach Evidence  </button>
												
												
												<?php if($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='ADMIN' ||$this->session->userdata('user_type') =='RM' ||$this->session->userdata('user_type') =='HOD' || $this->session->userdata('user_type') =='SUPER ADMIN'){ ?> 
					 
                                                 <button class="btn btn-info" data-toggle="modal" type="button" data-target="#assign_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-user"></i> Assign task </button>
												
												<?php }?>
												
												</td>
                                            </tr>
										<?php 
										$sn++;
										?>
										
						 <!-- Assign Task -->
				        <div class="modal fade" id="assign_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Assign Task | Taks: <?php echo $data->indicator_name; ?> | Weight: <?php echo $data->weight; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                        </div>
										
			            <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/assign_employee_task');?>">
					
		            <input type="hidden" class="form-control"  name="taskid" value="<?php echo $data->performance_indicators_id; ?>">

					<div class="form-group row">
					<div class="col-md-12">
					<select class="form-control custom-select js-example-basic-multiple"  style="width:100%;" name="receivedby">
                    <option value="">--Choose Employee--</option>
					<?php foreach($listemployee as $value){?>
					 <option value="<?php echo $value->em_id; ?>"> <?php echo $value->des_name.': '.$value->first_name.'  '.$value->middle_name.'  '.$value->last_name.'-'.$value->em_region;  ?> </option>
					<?php }?>
                    </select>
					</div>
					</div>
					
			        <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
							
                     </form>
					  
						</div>
				       </div>
		               </div>
	                </div>
			     <!-- Assign Task End -->
				 
				 
				  <!-- Attach Assign Task -->
				        <div class="modal fade" id="attach_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Attach Evidence | Taks: <?php echo $data->indicator_name; ?> | Weight: <?php echo $data->weight; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                        </div>
										
			            <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" enctype="multipart/form-data" action="<?php echo site_url('Contract/submit_attached_evidence');?>">
					
		            <input type="hidden" class="form-control"  name="taskid" value="<?php echo $data->performance_task_id; ?>">
                    
                    <div class="form-group row">
					<div class="col-md-12">
					<select class="form-control"  style="width:100%;" name="subtaskid">
                    <option value="">--Choose Sub Activity--</option>
					<?php foreach($list as $row){?>
					 <option value="<?php echo $row->sub_activities_id; ?>"> <?php echo $row->sub_activity_name;  ?> </option>
					<?php }?>
                    </select>
					</div>
					</div>


					<div class="form-group row">
					<div class="col-md-12">
                    <label> Attach Task Evidence  (PDF File Only )</label>
					<input type="file" class="form-control" name="image_url">
					</div>
					</div>
					
			        <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
							
                     </form>
					  
						</div>
				       </div>
		               </div>
	                </div>
			     <!-- Attach  Assign Task End -->


			     <!-- appraise_modal Assign Task -->
				        <div class="modal fade" id="appraise_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Appraise | Taks: <?php echo $data->indicator_name; ?> | Weight: <?php echo $data->weight; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                        </div>
										
			            <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/update_assigned_task_appraise');?>">
					
		            <input type="hidden" class="form-control"  name="taskid" value="<?php echo $data->performance_task_id; ?>">
                    

					<div class="form-group row">
					<div class="col-md-12">
                    <label> Appraise </label>
					<input type="number" class="form-control" name="appraise" min="0" max="<?php echo @$data->weight; ?>" step="any" value="<?php echo @$data->appraise; ?>">
					</div>
					</div>
					
			        <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit </button>
                    </div>
                    </div>
							
                     </form>
					  
						</div>
				       </div>
		               </div>
	                </div>
			     <!-- appraise_modal  Assign Task End -->

			     <!-- View Attach Assign Task -->
				        <div class="modal fade" id="viewattach_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Attachment  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
                        </div>
										
			            <div class="modal-body"> 
			    
			    <?php $serial=1; foreach($listattach as $row){ ?>
			         <div class="row">
			         <div class="col-md-2">
				    <?php echo $serial; ?>
					</div>
					<div class="col-md-6">
				    <?php echo $row->sub_activity_name; ?>
					</div>
					<div class="col-md-4">
				    <a href="<?php echo base_url();?>assets/images/task_evidence/<?php echo $row->attach_evidence; ?>" target="_tab">
				    <i class="fa fa-file"></i> View Evidence
				    </a>
					</div>
					</div>
					 <hr>
				<?php $serial++; } ?>
					  
						</div>
				       </div>
		               </div>
	                </div>
			     <!-- View Attach  Assign Task End -->
				 
				 
				
										
										<?php
										}
										?>  
											
                                        </tbody>
                                    </table>
                                </div>
							   <?php } ?>
							   
							   
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>
    <?php $this->load->view('backend/footer'); ?>