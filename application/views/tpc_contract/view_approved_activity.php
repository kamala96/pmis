<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Activities [ <?php echo  $this->session->userdata('targetname'); ?>]  </h3>
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

						
                               

                            

                               <?php if(isset($listindicators)){ ?>
							   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Activity  </th>
												<th> Marks  </th>
												<th> Sub-Activities  </th>
												<th> Status </th>
												<th> Task progress </th>
												<th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listindicators as $data){
                                        $id = $data->performance_indicators_id;
										$status = $data->indicator_progress;
										$name = $data->indicator_name; 
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> 
                                                <a href="<?php echo site_url('Contract/approved_sub_activity');?>?activityid=<?php echo $id; ?>&&activityname=<?php echo $name; ?>">
												<?php echo $data->indicator_name; ?> </a> </td>
												<td> <?php echo $data->weight; ?> </td>
												<td>
												<a href="<?php echo site_url('Contract/approved_sub_activity');?>?activityid=<?php echo $id; ?>&&activityname=<?php echo $name; ?>">
												<?php @$activities = $this->ContractModel->count_sub_activities($id); echo @$activities; ?> 
												</a>
												</td>
												<td> <?php echo '<button class="btn btn-sm btn-info waves-effect waves-light">'.ucfirst($data->indicator_status).' </button>'; ?> </td>
												<td> <?php if($status==1){ echo '<button class="btn btn-sm btn-info waves-effect waves-light"> Un-assigned </button>'; } else { echo '<button class="btn btn-sm btn-info waves-effect waves-light"> Assigned </button>'; }?> </td>
												<td>

												
                                                 <button class="btn btn-info" data-toggle="modal" type="button" data-target="#assign_modal<?php echo $data->performance_indicators_id; ?>"> <i class="fa fa-user"></i> Assign task </button>
                                             
												</td>
                                            </tr>
										<?php 
										$sn++;
										?>
										
						 <!-- Assign Task -->
				        <div class="modal fade" id="assign_modal<?php echo $data->performance_indicators_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Assign Task | Taks: <?php echo $data->indicator_name; ?> | Marks: <?php echo $data->weight; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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
										
										<?php
										}
										?>  
											
                                        </tbody>
                                    </table>
                                </div>
							   <?php } ?>
							   
							 <!--  Search table -->
							 <?php if(isset($searchlistindicator)){ ?>
							   <div class="table-responsive" id="searchtable">
							    <h3> Target: <?php echo $target; ?>  </h3>
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Key Performance Indicator  </th>
												<th> Weight(Score)  </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($searchlistindicator as $data){
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <?php echo $data->indicator_name; ?> </td>
												<td> <?php echo $data->weight; ?> </td>
                                            </tr>
										<?php 
										$sn++;
										}?>  
											
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