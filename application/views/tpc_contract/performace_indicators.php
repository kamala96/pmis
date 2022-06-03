<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Key Performance Indicators </h3>
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
							
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">  <i class="fa fa-plus"></i> Add key performance indicator </button>
								
								 <?php if($this->session->userdata('user_type') =='ADMIN'){ ?>
								
								<button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-search-modal-lg">  <i class="fa fa-search"></i> Search User type key performance indicator </button>
								 
							    <a href="<?php echo base_url('Contract/reset_assigned_tasks');?>" onclick='return reset();'>	<button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-thumb-tack"></i> Reset key performance indicator </button> </a>
							
								 <?php } ?>
							
							
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
							
							
							
							
							<!--  Modal content -->
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add key performance indicator </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
				        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/add_indicator');?>">
						  
							<div class="form-group row">
								<div class="col-6">
								<label> Indicator </label>
                                <input class="form-control" type="text" required="" placeholder="Enter Indicator" name="name">
                                </div>
								<div class="col-6">
								<label> Weight </label>
                                <input class="form-control" type="number" step="any" required="" placeholder="Enter Weight" name="weight">
                                </div>
                            </div>
							
							<div class="form-group row">
							  <div class="col-md-6">
                                  <label>Performance Target</label>
                                      <select name="target" class="form-control"  required="required">
                                      <option value="">--Choose Target--</option>
									  <?php foreach($listtarget as $data){ ?>
									  <option value="<?php  echo $data->performance_target_id; ?>"> <?php echo $data->target_name; ?> </option>
									  <?php } ?>
                                      </select>
                              </div>
							  
							   <?php if($this->session->userdata('user_type') =='ADMIN'){ ?>
								<div class="col-6">
								<label> User Type </label>
                                 <select name="usertype" class="form-control">
                                      <option value="">--Choose User Type--</option>
									  <?php foreach($listusertype as $data){ ?>
									  <option value="<?php  echo $data->type_name; ?>"> <?php echo $data->type_name; ?> </option>
									  <?php } ?>
                                </select>
                                </div>
							   <?php } ?>
								
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
						 
						 
						 <!--  Modal content -->
                        <div class="modal fade bs-search-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Search key performance indicator </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
				        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/search_usertype_indicator');?>">

							<div class="form-group row">
							  <div class="col-md-6">
                                  <label>Performance Target</label>
                                      <select name="target" class="form-control"  required="required">
                                      <option value="">--Choose Target--</option>
									  <?php foreach($listtarget as $data){ ?>
									  <option value="<?php  echo $data->performance_target_id; ?>"> <?php echo $data->target_name; ?> </option>
									  <?php } ?>
                                      </select>
                              </div>
								<div class="col-6">
								<label> User Type </label>
                                 <select name="usertype" class="form-control"  required="required">
                                      <option value="">--Choose User Type--</option>
									  <?php foreach($listusertype as $data){ ?>
									  <option value="<?php  echo $data->type_name; ?>"> <?php echo $data->type_name; ?> </option>
									  <?php } ?>
                                </select>
                                </div>
                            </div>
							
							<div class="form-group row">
                                <div class="col-6">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" name="submitinfo" id="search"> <i class="flaticon-checked-1"></i> Submit </button>
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
												<th> Target name </th>
												<th> Key Performance Indicator  </th>
												<th> Weight(Score)  </th>
												<th> Created by  </th>
												<th> Role  </th>
												<th> Status </th>
												<th> Task progress </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listindicators as $data){
										$id = $data->performance_indicators_id;
										$status = $data->indicator_progress;
										$empid = $data->empid;
										$info = $this->ContractModel->get_employee_info($empid);
										$status = $data->indicator_status;
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <?php echo $data->target_name; ?> </td>
												<td> <?php echo $data->indicator_name; ?> </td>
												<td> <?php echo $data->weight; ?> </td>
												
												<td> <?php echo @$info->first_name.' '.@$info->middle_name.' '.@$info->last_name; ?> </td>
												<td> <?php echo $data->role_indicator; ?> </td>
												
												
												<td> <?php echo '<button class="btn btn-sm btn-info waves-effect waves-light">'.ucfirst($data->indicator_status).' </button>'; ?> </td>
												<td> <?php if($status==1){ echo '<button class="btn btn-sm btn-info waves-effect waves-light"> Un-assigned </button>'; } else { echo '<button class="btn btn-sm btn-info waves-effect waves-light"> Assigned </button>'; }?> </td>
                                                <td class="jsgrid-align-center ">
												
												   <?php if($this->session->userdata('user_type') !='ADMIN'){ 
												   if($status!='received'){
												   ?>
												  <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->performance_indicators_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
												   <?php }}?>
												   
												  
												  <?php if($this->session->userdata('user_type') =='ADMIN' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG'){ 
												  if($status=='pending'){
												  ?>
												  
												  <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#accept_modal<?php echo $data->performance_indicators_id; ?>">  Accept or Cancel </button>

												  <?php }} ?>												  
												 
												 
												  <?php if($this->session->userdata('user_type') =='ADMIN'){ ?>
												 <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->performance_indicators_id; ?>">  <i class="fa fa-pencil-square-o"></i> </button>
												 <a href="<?php echo base_url('Contract/delete_indicator');?>?id=<?php echo $id; ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
												  <?php } ?>
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
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Target  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
										
			        <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/update_indicator');?>">
					
		            <input type="hidden" class="form-control"  name="indicatorid" value="<?php echo $data->performance_indicators_id; ?>">
					
					
					        <div class="form-group row">
								<div class="col-12">
								<label> Key performance indicator </label>
                                <input class="form-control" type="text" required="" placeholder="Enter Indicator" name="name" value="<?php echo $data->indicator_name; ?>">
                                </div>
                            </div>
							
							<div class="form-group row">
							<div class="col-6">
								<label> Weight </label>
                                <input class="form-control" type="number" step="any" required="" placeholder="Enter Weight" name="weight" value="<?php echo $data->weight; ?>">
                             </div>
							  <div class="col-md-6">
                                  <label>Performance Target</label>
                                      <select name="targetid" class="form-control"  required="required">
                                      <option value="<?php echo $data->performace_target_id; ?>"> <?php echo $data->target_name; ?></option>
									  <?php foreach($listtarget as $tdata){ ?>
									  <option value="<?php  echo $tdata->performance_target_id; ?>"> <?php echo $tdata->target_name; ?> </option>
									  <?php } ?>
                                      </select>
                              </div>
                            </div>


                             <?php if($this->session->userdata('user_type') =='ADMIN'){ ?>
					            <div class="form-group row">
								<div class="col-12">
								<label> User Type </label>
                                 <select name="usertype" class="form-control"  required="required">
                                      <option value="<?php echo $data->role_indicator; ?>"> <?php echo $data->role_indicator; ?></option>
									  <?php foreach($listusertype as $rdata){ ?>
									  <option value="<?php  echo $rdata->type_name; ?>"> <?php echo $rdata->type_name; ?> </option>
									  <?php } ?>
                                </select>
                                </div>
                               </div>
							 <?php } ?>
					 
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
										
										
										  <!-- Edit -->
				        <div class="modal fade" id="accept_modal<?php echo $data->performance_indicators_id; ?>" aria-hidden="true">
	                    <div class="modal-dialog modal-lg">
		                <div class="modal-content">
			                                   
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Accept or Cancel key Performance indicator   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
										
			        <div class="modal-body"> 
			
			        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/update_status_indicator');?>">
					
		            <input type="hidden" class="form-control"  name="indicatorid" value="<?php echo $data->performance_indicators_id; ?>">

					            <div class="form-group row">
								<div class="col-12">
								<label> Accept or Cancel </label>
                                 <select name="status" class="form-control"  required="required">
                                      <option value=""> Choose status </option>
									  <option value="received"> Accept </option>
									  <option value="canceled"> Cancel </option>
                                </select>
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
							    <h3> Target: <?php echo $target; ?> [ <?php echo $usertype; ?> ] </h3>
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