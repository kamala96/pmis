<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Pending Targets </h3>
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
								
								<a href="<?php echo site_url('Contract/performace_targets');?>" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> List Targets </a>
								
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
							
				   <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Contract/approve_target_status');?>">

                    <div class="form-group row">
				    <div class="col-sm-6">
				     <select class="form-control" name="status" required>
					 <option value=""> Choose Accept / Cancel to change target status </option>
					 <option value="received"> Accept </option>
					  <option value="canceled"> Cancel </option>
					 </select>
				    </div>
					<div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit  </button>
                    </div>
	                 </div> 
					 
					 <hr>
					 
							   <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											   <th width="5%"> <input type='checkbox' id='checkAll'> All </th>
                                                <th> S/N </th>
												<th> Target </th>
												<th> Marks </th>
												<th> Activities </th>
												<th> Employee </th>
												<th> PF Number </th>
												<th> Designation </th>
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
										$empid = $data->empid;
                                        $info = $this->ContractModel->get_employee_info($empid);
										?>
                                            <tr>
											   <td> <input type='checkbox' name='targetid[]' value='<?php echo $data->performance_target_id;?>'> </td>
                                                <td> <?php echo $sn; ?> </td>
												<td> <a href="<?php echo site_url('Contract/view_activities');?>?targetid=<?php echo $id; ?>&&targetname=<?php echo $name; ?>"> <?php echo $data->target_name; ?> </a>  </td>
												<td> <?php echo number_format($data->marks); ?></td>
												<td> 
												 <a href="<?php echo site_url('Contract/view_activities');?>?targetid=<?php echo $id; ?>&&targetname=<?php echo $name; ?>">
												<?php @$activities = $this->ContractModel->count_target_activities($id); echo @$activities; ?> 
												</a>
												</td>
												<td> <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </td>
												<td> <?php echo $info->em_code; ?> </td>
												<td> <?php echo $info->des_name; ?> </td>
												<td> <?php echo '<button class="btn btn-sm btn-info waves-effect waves-light">'.ucfirst($data->target_progress).'</button>';?>  </td>
											
                                            </tr>
										<?php 
										$sn++;
										?>
										<?php }?>  
											
                                        </tbody>
                                    </table>
                                </div>
								</form>
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
$(document).ready(function(){

  // Check/Uncheck ALl
  $('#checkAll').change(function(){
    if($(this).is(':checked')){
      $('input[name="targetid[]"]').prop('checked',true);
    }else{
      $('input[name="targetid[]"]').each(function(){
         $(this).prop('checked',false);
      });
    }
  });

  // Checkbox click
  $('input[name="targetid[]"]').click(function(){
    var total_checkboxes = $('input[name="targetid[]"]').length;
    var total_checkboxes_checked = $('input[name="targetid[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
       $('#checkAll').prop('checked',true);
    }else{
       $('#checkAll').prop('checked',false);
    }
  });
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