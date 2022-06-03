<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Single Call Note   </h3>
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
							
					<a href="<?php echo site_url('Mail_box/single_callnote');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Duplicate Call Note </button> </a>

					 <a href="<?php echo site_url('Mail_box/callnote');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Call Note Form</button> </a>
					
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
						
                          
					
						
						
						<!-- EMS Display Results -->
					<?php if(!empty($maillist)){ 
					//Check Delivered Status
					?>

													    <div class="table-responsive">
														<table id="example4" class="table table-striped table-bordered" cellspacing="0" width="100%">
														<thead>
														<tr>
												        <th> S/No </th>
													    <th> Created At </th>
													    <th> Name </th>
														<th> Barcode </th>
													    <th> Address  </th>
													     <!-- <th> Counter  </th> -->
													      <th> Local Number  </th>
														<th> Status </th>
														<th> Action  </th>
														</tr>
														</thead>
														<tbody>
													    <?php
					                                    $sn = 1;
														foreach($maillist as $data)
														{
														$status = 'Printed';
					                                    ?>
														
					                                    <tr>
					                                    <td>  <?php echo $sn; ?>  </td>
					                                    <td>  <?php echo $data->callnote_createdat; ?></td>
					                                     <td>  <?php echo $data->name; ?></td>
					                                    <td>  <?php echo $data->barcode; ?>  </td>
														<td>  <?php echo $data->address; ?>  </td>
														<!-- <td>  <?php echo 'Counter '.$data->counter; ?>  </td> -->
														<td>  <?php echo $data->fplno; ?>  </td>
														<td> 
														<?php 
                                                        if($status=='Printed')
														{
														echo '<button class="btn btn-success">Printed</button>';
														}
													     else
														{
														echo '<button class="btn btn-primary">Not Printed</button>'; 
														}
														?> 
														</td>
													    <td>  
                                                        <a href="<?php echo site_url('Mail_box/print_single_callnote');?>?id=<?php echo $data->callnote_id;?>" class="btn btn-primary"> <i class="fa fa-print"> Print  Call Note </i>  </a>
													    </td>
					                                    </tr>
					                                    <?php $sn++; 
														} 
					                                    ?>
														</tbody>
														</table>
														</div>	
                                                      					  								
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