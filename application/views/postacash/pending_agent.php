<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Posta Cash | Pending Agents </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Posta Cash </li>
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

<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/pending_agent" class="text-white"><i class="" aria-hidden="true"></i> Pending Agents </a></button>

<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_agents_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>
								
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
							
				   <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Posta_Cash/approve_agent');?>">

                    <div class="form-group row">
                    <div class="col-sm-4">
                    <textarea placeholder="Enter Message/Feedback/Instructions" class="form-control" name="desc" rows="2"></textarea>
                    </div>

				    <div class="col-sm-4">
				     <select class="form-control" name="status" required>
					 <option value=""> Choose </option>
					 <option value="Active"> Accept Agent </option>
					  <option value="Rejected"> Reject Agent </option>
					 </select>
				    </div>
					<div class="col-4">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Submit  </button>
                    </div>
	                 </div> 
					 
					 <hr>
					 
							   <div class="table-responsive ">
                                <table class="table table-bordered International text-nowrap" width="100%">
                                        <thead>
                                            <tr>
								   <th width="5%"> <input type='checkbox' id='checkAll'> All </th>
                                   <th> S/N </th>
								   <th> Agent Name </th>
                                   <th> Agent No. </th>
                                   <th> E-mail </th>
                                   <th> Phone </th>
                                   <th> Region </th>
                                   <th> Branch </th>
                                   <th> Created at </th>
                                   <th> Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($list as $value){ ?>
                                           <tr>
										   <td> <input type='checkbox' name='agentid[]' value='<?php echo @$value->agent_id;?>'> </td>
                                           <td> <?php echo $sn; ?> </td>
                                           <td> 
                                           <a data-toggle="modal" data-target="#view_modal<?php echo $value->agent_id; ?>"> <i class="fa fa-eye"></i> 
                                           <?php echo @$value->agent_fname.' '.@$value->agent_mname.' '.@$value->agent_lname; ?> 
                                            </a>
                                            </td>
                                           <td> <?php echo @$value->agent_no; ?> </td>
                                           <td> <?php echo @$value->agent_email; ?> </td>
                                           <td> <?php echo @$value->agent_phone; ?> </td>
                                           <td> <?php echo @$value->agent_region; ?> </td>
                                           <td> <?php echo @$value->agent_branch; ?> </td>
                                           <td> <?php echo @$value->agent_registered_date; ?> </td>
                                           <td>
                                            <?php if($value->agent_status=="Active"){ ?>
                                            <button class="btn btn-success" disabled="disabled"> Active </button>
                                            <?php } else { ?>
                                            <button class="btn btn-danger" disabled="disabled"> <?php echo @$value->agent_status; ?></button>
                                            <?php } ?>
                                           </td>
											
                                            </tr>
										<?php  $sn++; ?> 

                        <div class="modal fade" id="view_modal<?php echo $value->agent_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Agent Information </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                        <div class="modal-body"> 

                        
                       <div class="row">

                       <div class="col-sm-6">
                       <h5 style="color:#cb0000"> Agent Details </h5>
                       <hr>
                     Name:  <?php echo @$value->agent_fname.' '.@$value->agent_mname.' '.@$value->agent_lname; ?>  <hr>
                     Agent No.: <?php echo @$value->agent_no; ?> <hr>
                     E-mail: <?php echo @$value->agent_email; ?> <hr>
                     Phone <?php echo @$value->agent_phone; ?> <hr>
                     Region: <?php echo @$value->agent_region; ?> <hr>
                     Branch: <?php echo @$value->agent_branch; ?> <hr>
                     National ID: <?php echo @$value->agent_nationalid; ?> <hr>
                      </div>

                      <div class="col-sm-6">
                    <h5 style="color:#cb0000"> Agent Attachment & Other Information </h5>
                    <hr>
                       
       Tin Number: <a href="<?php echo base_url();?>assets/images/poshacash_files/<?php echo @$value->agent_tin_number_file; ?>" target="_tab">
                    <i class="fa fa-file"></i> Preview  </a> <hr>
      Business Licence: <a href="<?php echo base_url();?>assets/images/poshacash_files/<?php echo @$value->agent_business_licence_file; ?>" target="_tab">
                    <i class="fa fa-file"></i> Preview  </a> <hr>
      National ID: <a href="<?php echo base_url();?>assets/images/poshacash_files/<?php echo @$value->agent_nida_file; ?>" target="_tab">
                    <i class="fa fa-file"></i> Preview  </a> <hr>

     
                       Tin Number: <?php echo @$value->agent_tin; ?>  <hr>
                       Business Licence: <?php echo @$value->agent_licencenumber; ?> <hr>
                       Registered Date: <?php echo @$value->agent_registered_date; ?> <hr>
                    
                      </div>

                      </div>
                      
                        </div>
                       </div>
                       </div>
                    </div>


									    <?php } ?>  
											
                                        </tbody>
                                    </table>
                                </div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
				

<script type="text/javascript">
$(document).ready(function(){

  // Check/Uncheck ALl
  $('#checkAll').change(function(){
    if($(this).is(':checked')){
      $('input[name="agentid[]"]').prop('checked',true);
    }else{
      $('input[name="agentid[]"]').each(function(){
         $(this).prop('checked',false);
      });
    }
  });

  // Checkbox click
  $('input[name="agentid[]"]').click(function(){
    var total_checkboxes = $('input[name="agentid[]"]').length;
    var total_checkboxes_checked = $('input[name="agentid[]"]:checked').length;

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

var table = $('.International').DataTable( {
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