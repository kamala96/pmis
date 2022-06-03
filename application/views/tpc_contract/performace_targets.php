<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Targets </h3>
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
                                <h4 class="m-b-0 text-white"> 
								
								<button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">  <i class="fa fa-plus"></i> Add Target </button>
								
								<?php if($this->session->userdata('user_type') =='ADMIN' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='CRM'){ ?>
								
							<a href="<?php echo site_url('Contract/list_pending_targets');?>" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Pending Targets  [ <?php echo number_format($totalpending)?> ] </a>
								
								<?php } ?>
								
							 </h4>
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
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add Target </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
				        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/add_target');?>">
						
						    <div class="input_fields_container">
						  
							<div class="form-group row">
								<div class="col-6">
                                <input class="form-control" type="text" required="" placeholder="Enter Target Name" name="name[]">
                                </div>
								<div class="col-3">
                                <input class="form-control" type="text" required="" placeholder="Enter Marks" name="marks[]">
                                </div>
								<div class="col-3">
                                <button class="btn btn-primary add_more_button" name="process" > Add More Target </button>
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
                               

                            


							   <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Target </th>
												<th> Marks </th>
												<th> Activities </th>
												 <th> Status </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										$sumtotal=0;
										foreach($listtarget as $data){
										$status = $data->target_status;
										$id = $data->performance_target_id;
										$name = $data->target_name;
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <a href="<?php echo site_url('Contract/view_activities');?>?I=<?php echo base64_encode($id); ?>"> <?php echo $data->target_name; ?> </a>  </td>
												<td> <?php $sumtotal+=$data->marks; echo number_format($data->marks); ?></td>
												<td> 
												 <a href="<?php echo site_url('Contract/view_activities');?>?I=<?php echo base64_encode($id); ?>">
												<?php @$activities = $this->ContractModel->count_target_activities($id); echo @$activities; ?> 
												</a>
												</td>
												<td> <?php echo '<button class="btn btn-sm btn-info waves-effect waves-light">'.ucfirst($data->target_progress).'</button>';?>  </td>
												
                                                <td class="jsgrid-align-center ">
												
												    <?php if($this->session->userdata('user_type') =='ADMIN'){ ?>
													
													<button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->performance_target_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
                                                    <a href="<?php echo base_url('Contract/delete_target');?>?id=<?php echo $id; ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
													
													<?php } else { ?>
												
												    <?php if($status!='received'){?>
													<button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->performance_target_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
                                                    <a href="<?php echo base_url('Contract/delete_target');?>?id=<?php echo $id; ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
													<?php }?>
													
													<?php } ?>
													
													
                                                </td>
                                            </tr>
										<?php $sn++; ?>
										
				    <!-- Edit -->
				        <div class="modal fade" id="update_modal<?php echo $data->performance_target_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Target  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
										
			        <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/update_target');?>">
					
		            <input type="hidden" class="form-control"  name="targetid" value="<?php echo $data->performance_target_id; ?>">

                     <div class="form-group row">
				    <div class="col-sm-12">
					<label> Name </label>
				     <input type="text" class="form-control" placeholder="Enter Target Name" name="name" value="<?php echo $data->target_name; ?>">
				    </div>
	                 </div>   
					 
					<div class="form-group row">
				    <div class="col-sm-12">
					<label> Marks </label>
				     <input type="text" class="form-control" placeholder="Enter Target Name" name="marks" value="<?php echo $data->marks; ?>">
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
										<td> 
										<?php 
										echo $sumtotal;
									    ?> 
									    </td>
										<td> </td>
										<td> </td>
										<td> </td>
										</tr>
											
                                        </tbody>
                                    </table>
                                </div>
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
            $('.input_fields_container').append('<div> <div class="form-group row"> <div class="col-6"> <input type="text" placeholder="Enter Target Name" class="form-control" name="name[]"/> </div> <div class="col-3"> <input type="text" placeholder="Enter Marks" class="form-control" name="marks[]"/> </div> <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
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
</script>

    <?php $this->load->view('backend/footer'); ?>