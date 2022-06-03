<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Assigned Tasks </h3>
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
							
								 
				   <?php if($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='ADMIN' ||$this->session->userdata('user_type') =='RM' ||$this->session->userdata('user_type') =='HOD'){ ?> 
					 
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

                               <?php if(isset($listassignedtask)){ ?>
							   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Task  </th>
												<th> Marks  </th>
												<th> Appraise  </th>
												<th> Sub-Activities  </th>
												<th> Attachment </th>
												<th> Employee  </th>
												<th> Designation  </th>
												<th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listassignedtask as $data){
										$id = $data->performance_indicators_id;
										$status = $data->indicator_progress;
										$name = $data->indicator_name; 
										$empid = $data->received_by;
										$taskid = $data->performance_task_id;
										$listattach = $this->ContractModel->display_subact_attached($taskid);
                                        $info = $this->ContractModel->get_employee_info($empid);
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
												if(!empty($data->appraise)){
                                                echo @$data->appraise;
                                                } else {
                                                echo "No Appraise";
                                                } ?>
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

												<?php if(!empty($listattach)){?>

												<?php if(empty($data->rating)){ ?>
													<button class="btn btn-info" data-toggle="modal" type="button" data-target="#rating_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-keyboard-o"></i> Rating  </button>
												<?php }?>
												
												<?php } else {?>
                                                <a href="<?php echo site_url('Contract/unassigned_task');?>?taskid=<?php echo $data->performance_task_id;?>&&indicatorid=<?php echo $data->indicator_id;?>" onclick='return del();'> <button class="btn btn-info"> <i class="fa fa-times"></i> Un-assigned task </button> </a>
												<?php }?>
												
												</td>
                                            </tr>
										<?php 
										$sn++;
										?>
										
			        <!-- VIEW Attached Assign Task -->
				        <div class="modal fade" id="view_attach_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> View attached Evidence | Taks: <?php echo $data->indicator_name; ?> | Weight: <?php echo $data->weight; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
										
			            <div class="modal-body"> 
			
			            <iframe src="<?php echo base_url();?>assets/images/task_evidence/<?php echo $data->attach_evidence; ?>" frameborder="0" width="100%" height="600px"></iframe>
					  
						</div>
				       </div>
		               </div>
	                </div>
			     <!-- Attach  Assign Task End -->
				 
				 <!-- RATING Assign Task -->
				        <div class="modal fade" id="rating_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Rating | Taks: <?php echo $data->indicator_name; ?> | Weight: <?php echo $data->weight; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
										
			            <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" enctype="multipart/form-data" action="<?php echo site_url('Contract/submit_rating_task');?>">
					
		            <input type="hidden" class="form-control"  name="evidenceid" value="<?php echo $data->performance_task_id; ?>">

					<div class="form-group row">
					<div class="col-md-12">
                    <label> Rating (Maximum Score: <?php echo $data->weight; ?>)</label>
					<input type="number" class="form-control"  name="rating" min="0" max="<?php echo $data->weight; ?>" step="any">
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

			         <!-- View Attach Assign Task -->
				        <div class="modal fade" id="viewattach_modal<?php echo $data->performance_task_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Attachment  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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

     <script type="text/javascript">
	  function del()
	  {
		if(confirm("Are you sure you want to un-assigned task?"))
		{
			return true;
		}
		
		else{
			return false;
		}
	  }
     </script>

    <?php $this->load->view('backend/footer'); ?>