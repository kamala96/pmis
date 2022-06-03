<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Assign Task </h3>
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
								
				   <?php if($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='ADMIN' ||$this->session->userdata('user_type') =='RM' ||$this->session->userdata('user_type') =='HOD'){ ?> 
					 
					 <a href="<?php echo site_url('Contract/approved_targets');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Assign task </button> </a>

					 <a href="<?php echo site_url('Contract/assigned_tasks');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Assigned tasks </button> </a>
					<?php }?>  

					 <a href="<?php echo site_url('Contract/my_tasks');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> My tasks </button> </a>

								
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
							
							
							
							
							
                            


							   <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> Target </th>
												<th> Marks </th>
												<th> Activities </th>
												 <th> Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listtarget as $data){
										$status = $data->target_status;
										$id = $data->performance_target_id;
										$name = $data->target_name;
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <a href="<?php echo site_url('Contract/view_approved_activities');?>?targetid=<?php echo $id; ?>&&targetname=<?php echo $name; ?>"> <?php echo $data->target_name; ?> </a>  </td>
												<td> <?php echo number_format($data->marks); ?></td>
												<td> 
												 <a href="<?php echo site_url('Contract/view_approved_activities');?>?targetid=<?php echo $id; ?>&&targetname=<?php echo $name; ?>">
												<?php @$activities = $this->ContractModel->count_target_activities($id); echo @$activities; ?> 
												</a>
												</td>
												<td> <?php echo '<button class="btn btn-sm btn-info waves-effect waves-light">'.ucfirst($data->target_progress).'</button>';?>  </td>
												
                                               
                                            </tr>
										<?php 
										$sn++;
										?>
										
				 
										<?php }?>  
											
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