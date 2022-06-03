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
							
                                <a href="<?php echo site_url('Contract/performace_targets');?>" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> List Targets </a>
								
								<button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">  <i class="fa fa-plus"></i> Add Activity </button>
								
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
							
							
							
							
							<!--  Modal content -->
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add Activities </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
				        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/add_indicator');?>">
						
						    <input class="form-control" type="hidden" value="<?php echo $this->session->userdata('targetid'); ?>" name="targetid">

						    <input type="hidden" name="targetmarks" value="<?php echo $targetmarks; ?>" class="form-control">
							
							<div class="input_fields_container">
						 
							<div class="form-group row">
								<div class="col-6">
                                <input class="form-control" type="text" required="" placeholder="Enter Activity" name="name[]">
                                </div>
								<div class="col-3">
                                <input class="form-control" type="number" step="any" required="" placeholder="Enter Marks" name="weight[]">
                                </div>
								
								<div class="col-3">
                                 <button class="btn btn-primary add_more_button"> Add More Activity </button>
                                </div>
                            </div>
							
							</div>
							
							<div class="form-group row">
                                <div class="col-6">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" name="submitinfo"> <i class="flaticon-checked-1"></i> Submit </button>
                                </div>
                            </div>
                        </form>
																	
                        </div>
                        </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                         <!-- End -->
						 
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										$sumtotal=0;
										foreach($listindicators as $data){
										$id = $data->performance_indicators_id;
										//$status = $data->indicator_progress;
										$empid = $data->empid;
										$info = $this->ContractModel->get_employee_info($empid);
										$status = $data->indicator_progress;
										$name = $data->indicator_name; 
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> 
												<a href="<?php echo site_url('Contract/sub_activities');?>?I=<?php echo base64_encode($id); ?>">
												<?php echo $data->indicator_name; ?> 
												</a>
												</td>
												<td> <?php $sumtotal+=$data->weight; echo $data->weight; ?> </td>
												<td>
												<a href="<?php echo site_url('Contract/sub_activities');?>?I=<?php echo base64_encode($id); ?>">
												<?php @$activities = $this->ContractModel->count_sub_activities($id); echo @$activities; ?> 
												</a>
												</td>
												<td> <?php echo '<button class="btn btn-sm btn-info waves-effect waves-light">'.ucfirst($data->indicator_status).' </button>'; ?> </td>
												<td> <?php if($status==1){ echo '<button class="btn btn-sm btn-info waves-effect waves-light"> Un-assigned </button>'; } else { echo '<button class="btn btn-sm btn-info waves-effect waves-light"> Assigned </button>'; }?> </td>
                                                <td class="jsgrid-align-center ">
											
												 <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->performance_indicators_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
												 
												 <a href="<?php echo base_url('Contract/delete_indicator');?>?id=<?php echo $id; ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
												
												</td>
                                            </tr>
										<?php 
										$sn++;
										?>
										
										  <!-- Edit -->
				        <div class="modal fade" id="update_modal<?php echo $data->performance_indicators_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Activity  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
										
			        <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/update_indicator');?>">
					
		            <input type="hidden" class="form-control"  name="indicatorid" value="<?php echo $data->performance_indicators_id; ?>">
					
					
					        <div class="form-group row">
								<div class="col-12">
								<label> Activity </label>
                                <input class="form-control" type="text" required="" placeholder="Enter Indicator" name="name" value="<?php echo $data->indicator_name; ?>">
                                </div>
                            </div>
							
							<div class="form-group row">
							<div class="col-12">
								<label> Marks </label>
                                <input class="form-control" type="number" step="any" required="" placeholder="Enter Weight" name="weight" value="<?php echo $data->weight; ?>">
                             </div>
                            </div>

					 
			        <div class="form-group row">
                    <div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Update </button>
                    </div>
                    </div>
							
                     </form>
					  
						</div>
				       </div>
		               </div>
	                </div>
			     <!-- End -->
										
						
										<?php } ?>  

										<tr>
										<td> </td>
										<td> Total Marks: </td>
										<td> <?php echo $sumtotal; ?> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										<td> </td>
										</tr>
											
                                        </tbody>
                                    </table>
                                </div>
							   <?php } ?>
							   
                            </div>
                        </div>
                    </div>
                </div>
				
<script>
    $(document).ready(function() {
    var max_fields_limit      = 10; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div> <div class="form-group row"> <div class="col-6"> <input type="text" placeholder="Enter Activity" class="form-control" name="name[]"/> </div> <div class="col-3"> <input type="text" placeholder="Enter Marks" class="form-control" name="weight[]"/> </div> <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
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
		if(confirm("Are you sure you want to delete?"))
		{
			return true;
		}
		
		else{
			return false;
		}
	  }
	  
	  function reset()
	  {
		if(confirm("Are you sure you want to reset all key performance indicators?"))
		{
			return true;
		}
		
		else{
			return false;
		}
	  }
</script>
    <?php $this->load->view('backend/footer'); ?>