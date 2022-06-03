<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Completed Tasks  </h3>
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
                             <h4 class="m-b-0 text-white"><i class="fa fa-file-text-o" aria-hidden="true"></i>  Performance report of 
							 <?php
							 echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; 
							 ?>
							 
							 <span class="pull-right " ></span></h4>
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

                               <?php if(isset($listtasks)){ ?>
							   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Activity </th>
												<th> Weight(Score)  </th>
												<th> Attachment </th>
												<th> Assigned by </th>
												<th> Designation </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listtasks as $data){
										$empid = $data->provided_by;
										$taskid = $data->performance_task_id;
										$id = $data->performance_indicators_id;
										$info = $this->ContractModel->get_employee_info($empid);
										$listattach = $this->ContractModel->display_subact_attached($taskid);
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <?php echo $data->indicator_name; ?> </td>
												<td> 
												<?php if(!empty($data->rating)){?>
												<?php $rating = $data->rating; 
												$sumrating[] = $rating;
												echo $rating;
												?> out of
												<?php }?>
												<?php echo $data->weight; ?> 
												</td>
												<td>
												<?php if(!empty($listattach)){?>
												 <button class="btn btn-info" data-toggle="modal" type="button" data-target="#viewattach_modal<?php echo $data->performance_task_id; ?>"> <i class="fa fa-file"></i> View Evidence  </button>
												<?php } ?>
												</td>
												<td> <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </td>
												<td> <?php echo $info->des_name; ?> </td>
                                            </tr>
										<?php 
										$sn++;
										?>	
						 
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
    <?php $this->load->view('backend/footer'); ?>