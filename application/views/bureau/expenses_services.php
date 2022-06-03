<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-wpforms" style="color:#1976d2"> </i> Expenses Service </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Home</a></li>
				<li class="breadcrumb-item active">   </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			   
            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">  <i class="fa fa-plus"></i> Add Service </button>
            
             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/bureau_accounts" class="text-white"><i class="" aria-hidden="true"></i> Accounts Dashboard  </a></button>

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/voucher_setting" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Expenses Service List </h4>
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
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add Service </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
                        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Bureau/save_expenses');?>">

                            <div class="input_fields_container">
                         
                            <div class="form-group row">

                                <div class="col-8">
                                <input class="form-control" type="text" required="" name="name[]" placeholder="Enter Service">
                                </div>
                                
                                <div class="col-2">
                                 <button class="btn btn-primary add_more_button"> Add </button>
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


                                    <div class="table-responsive">
                                     <table class="table table-bordered table-striped International text-nowrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th> Service </th>
                                            <th> Created at </th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo $data->account_name; ?> </td>
                                             <td> <?php echo $data->bureau_account_list_created_at; ?> </td>
                                            <td>

                                             <button title="Edit" class="btn btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $data->bureau_account_list_id; ?>">  <i class="fa fa-pencil-square-o"></i> Edit </button>
                                                 
                                              <a href="<?php echo base_url('Bureau/delete_account_expenses');?>?I=<?php echo base64_encode($data->bureau_account_list_id); ?>" onclick='return del();' title="Delete" class="btn btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete </a>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      
                                    <!-- Edit -->
                        <div class="modal fade" id="update_modal<?php echo $data->bureau_account_list_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Service  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                        <div class="modal-body"> 

                        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Bureau/update_expense');?>">

                        <input type="hidden" class="form-control"  name="id" value="<?php echo $data->bureau_account_list_id; ?>">

                                <div class="form-group row">
                                <div class="col-12">
                                <label> Service </label>
                                <input class="form-control" type="text" required="" name="name" value="<?php echo $data->account_name; ?>">
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
                   
                                    </tbody>
                                </table>
                                </div>


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
            $('.input_fields_container').append('<div> <div class="form-group row">  <div class="col-8"><input class="form-control" type="text" required="" name="name[]" placeholder="Enter Service"></div>  <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
        }
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
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

<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Bureau/get_bcl_branches",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>

<?php $this->load->view('backend/footer'); ?>
