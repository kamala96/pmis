<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-external-link" style="color:#1976d2"> </i> Requests </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Officialuse/dashboard" >Home</a></li>
				<li class="breadcrumb-item active"> Official Use </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Officialuse/store_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Officialuse/requests" class="text-white"><i class="" aria-hidden="true"></i> My Requests </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Officialuse/track_store_request" class="text-white"><i class="" aria-hidden="true"></i> Track Requests </a></button>

             <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Officialuse/store_sendrequest" class="text-white"><i class="" aria-hidden="true"></i> Send Request </a></button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Track Request  </h4>
                </div>

                <div class="card-body">

                            <?php 
                            if(!empty($this->session->flashdata('message'))){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('message'); ?>
                                      <?php
                            echo "</div>";
                           }
                           ?>

                <form class="row" method="post" action="<?php echo site_url('Officialuse/track_store_request_results');?>">

                                    <div class="form-group col-md-3 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <input type="date" name="todate" class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-md-3 m-t-10">
                                    <select class="form-control" required="required" name="status">
                                    <option value="Pending"> Pending </option>
                                    <option value="ReceivedByRM"> Approved By RM </option>
                                    <option value="ReceivedByPMU"> Approved By PMU </option>
                                    <option value="Completed"> Completed </option>
                                     <option value="Canceled"> Canceled </option>
                                    </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                </form>



                                  <?php if(!empty($list)){ ?>
                                    <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th> Request Code </th>
                                            <th> Reason  </th>
                                            <th> Requested Date  </th>
                                            <th> Total of Items  </th>
                                            <th> Status </th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){
                                        $code = $data->request_code;
                                        $listitems = $this->OfficialuseModel->get_request_items($code);
                                        $listissued = $this->OfficialuseModel->get_issued_request_items($code);
                                        ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo $data->request_code; ?> </td>
                                            <td> <?php echo $data->request_desc; ?> </td>
                                            <td> <?php echo $data->request_created_at; ?> </td>
                                            <td> <?php echo number_format(@$this->OfficialuseModel->count_items($code)); ?> </td>
                                            <td> 
                                            <button class="btn btn-sm btn-info waves-effect waves-light">  <?php echo $data->request_status; ?> </button> 
                                            </td>
                                            <td>
                                             

                                             <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->request_code; ?>">  View Items </button>

                                              <?php if($data->request_status=="Completed"){?>
                                              <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#received_modal<?php echo $data->request_code; ?>">  Received Items </button>
                                              <?php } ?>


                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $data->request_code; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Request Items   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                    <div class="modal-body"> 

                    <div class="row">
                    <div class="col-md-2"> <strong> S/N </strong> </div> <div class="col-md-3"> <strong> Item </strong> </div>  <div class="col-md-3"> <strong> Unit </strong> </div> <div class="col-md-4"> <strong> Quantity </strong> </div>
                    </div>
                     <hr>
                    <?php $serial=1; foreach($listitems as $row){ ?>
                     <div class="row">
                     <div class="col-md-2">
                    <?php echo $serial; ?>
                    </div>
                    <div class="col-md-3">
                    <?php echo $row->item_name; ?>
                    </div>
                    <div class="col-md-3">
                    <?php echo $row->unit_name; ?>
                    </div>
                    <div class="col-md-4">
                    <?php echo number_format($row->item_qty); ?>
                    </div>
                    </div>
                     <hr>
                <?php $serial++; } ?>
                
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End -->


                  <!-- Edit -->
                        <div class="modal fade" id="received_modal<?php echo $data->request_code; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Received Items   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                    <div class="modal-body"> 

                    <div class="row">
                    <div class="col-md-2"> <strong> S/N </strong> </div> <div class="col-md-3"> <strong> Item </strong> </div> <div class="col-md-3"> <strong> Unit </strong> </div> <div class="col-md-4"> <strong> Quantity </strong> </div> 
                    </div>
                     <hr>
                    <?php $serial=1; foreach($listissued as $row){ ?>
                     <div class="row">
                     <div class="col-md-2">
                    <?php echo $serial; ?>
                    </div>
                    <div class="col-md-3">
                    <?php echo $row->item_name; ?>
                    </div>
                    <div class="col-md-3">
                    <?php echo $row->unit_name; ?>
                    </div>
                    <div class="col-md-4">
                    <?php echo number_format($row->itemqty); ?>
                    </div>
                    </div>
                     <hr>
                    <?php $serial++; } ?>
                
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End -->

                                     <?php } ?>
                   
                                    </tbody>
                                </table>
                                </div>
                <?php } ?>

                 </div>





						
	    	</div>
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
            $('.input_fields_container').append('<div> <div class="form-group row"> <div class="col-6"><select class="form-control" name="name[]" required=""><option value=""> Choose </option><?php foreach($listitems as $data){ ?><option value="<?php echo $data->item_id; ?>"> <?php echo $data->item_name; ?> </option><?php } ?></select></div><div class="col-4"><input type="number" name="qty[]" class="form-control" step="any" placeholder="Enter Quantity" required=""></div>  <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
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
