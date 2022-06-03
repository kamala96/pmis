<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Bulk Call Note  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Callnote </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
							
					 <a href="<?php echo site_url('Mail_box/bulk_callnote');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Bulk Call Note </button> </a>

					 <a href="<?php echo site_url('Mail_box/group_bulk_callnote');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Groups Bulk Call Note </button> </a>
					
                            </div>
							
                            <div class="card-body">
							
							<?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>						  
						  <?php } ?>
						  
						  <?php if($this->session->flashdata('feedback')){ ?> 
						   <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>						  
						  <?php } ?>
						
                          
						<form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Mail_box/find_barcode');?>">
						  
						    <div class="form-group row">
                                <div class="col-9">
                                <input class="form-control" type="text" required="" placeholder="Enter valid Barcode" name="code">
                                </div>


							  <div class="col-3">
                              <button type="submit" class="btn btn-primary waves-effect waves-light" name="search"> <i class="mdi mdi-file-find"></i> Search </button>
                               </div>
                            </div>
						
                        </form> <!-- End form -->	
						
						
						<!-- EMS Display Results -->
					<?php if(!empty($maillist)){ 
					//Check Delivered Status
					?>
					
					<form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Mail_box/create_callnote_group');?>">
					
					<input type="hidden" class="form-control" name="groupno" value="<?php echo rand(pow(10, 4-1), pow(10, 4)-1); ?>">
							 
                    <div class="form-group row">
				    <div class="col-md-3">
				     <input type="text" class="form-control" placeholder="Enter Bulk Call Note Group Name" name="groupname" required>
				    </div>

				     <div class="col-md-3">
				      <input type="number" name="address" class="form-control name_address" placeholder="Enter Box Number" required>
				    </div>

					<div class="col-6">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Create Group  </button>
                    </div>
	                 </div> 
													    <div class="table-responsive">
														<table id="example4" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
														<tr>
														<th width="5%"> <input type='checkbox' id='checkAll'> All </th>
												        <th> S/No </th>
													    <th> Receiver  </th>
													    <th> Sender  </th>
													    <th> Region Origin </th>
                                                        <th> Branch Origin  </th>
													    <th> Destination Region </th>
														<th> Destination Branch </th>
														<th> Barcode Number  </th>
														<th> Action  </th>
														</tr>
														</thead>
														<tbody>
													    <?php
					                                    $sn = 1;
														foreach($maillist as $data)
														{
														$id = $data->callnote_id;
														$senderid = $data->callnote_senderid;
														$barcode = $data->Barcode;
					                                    ?>
														
					                                    <tr>
														<td> <input type='checkbox' name='senderid[]' value='<?php echo $data->callnote_id;?>'> </td>
					                                    <td>  <?php echo $sn; ?>  </td>
					                                    <td>  <?php echo $data->receiver_fullname; ?></td>
					                                    <td>  <?php echo $data->sender_fullname; ?>  </td>
														 <td>  <?php echo $data->sender_region; ?>  </td>
														  <td>  <?php echo $data->sender_branch; ?>  </td>
														   <td>  <?php echo $data->receiver_region; ?>  </td>
														    <td>  <?php echo $data->reciver_branch; ?>  </td>
															 <td>  <?php echo strtoupper($data->Barcode); ?>  </td>
															  <td>  
                                                             <a href="<?php echo site_url('Mail_box/delete_callnote_item');?>?id=<?php echo $id;?>" onclick='return del();' class="btn btn-primary"> <i class="fa fa-trash-o"></i>  </a>
															  </td>
					                                    </tr>
					                                    <?php $sn++; 
														} 
					                                    ?>
														</tbody>
														</table>
														</div>	
                                                       </form>						  								
                    <?php } ?>					
					<!-- END EMS Display Results -->
                           
							   
							   
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
$(document).ready(function(){

  // Check/Uncheck ALl
  $('#checkAll').change(function(){
    if($(this).is(':checked')){
      $('input[name="senderid[]"]').prop('checked',true);
    }else{
      $('input[name="senderid[]"]').each(function(){
         $(this).prop('checked',false);
      });
    }
  });

  // Checkbox click
  $('input[name="senderid[]"]').click(function(){
    var total_checkboxes = $('input[name="senderid[]"]').length;
    var total_checkboxes_checked = $('input[name="senderid[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
       $('#checkAll').prop('checked',true);
    }else{
       $('#checkAll').prop('checked',false);
    }
  });
});
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