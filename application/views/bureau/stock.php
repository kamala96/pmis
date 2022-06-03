<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-wpforms" style="color:#1976d2"> </i> Bureau De Change | Opening Balance </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>Officialuse/dashboard" >Home</a></li>
				<li class="breadcrumb-item active"> Bureau De Change  </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
			   
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/add_strong_room_stock" class="text-white"><i class="" aria-hidden="true"></i> Add Stock </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/stock_transaction" class="text-white"><i class="" aria-hidden="true"></i> Stock Transactions  </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/currency_rates" class="text-white"><i class="" aria-hidden="true"></i> Currency Rates  </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/branch_stock" class="text-white"><i class="" aria-hidden="true"></i> Branch Stock Balance  </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-bell"></i><a href="<?php echo base_url(); ?>Bureau/stock_pending_request" class="text-white"><i class="" aria-hidden="true"></i> Pending Requests ( <?php echo number_format(@$countpending); ?> ) </a></button>


             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Services/StrongRoom/" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Strong Room | Opening Balance </h4>
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




                                    <div class="table-responsive">
                                     <table class="table table-bordered table-striped International text-nowrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">S/N</th>
                                            <th> Currency </th>
                                            <th> Currency Code </th>
                                            <th> Amount (Qty) </th>
                                            <th> Amount Out (Qty) </th>
                                            <th> Available Balance (Qty) </th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){ ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> 
                                             <a href="<?php echo base_url('Bureau/strong_room_stock_summary');?>?I=<?php echo base64_encode($data->currencyid); ?>">
                                             <?php echo @$data->currency_desc; ?> 
                                            </a>
                                            </td>
                                            <td> <?php echo @$data->currency_name; ?> </td>
                                            <td> <?php echo number_format(@$data->total,2); ?> </td>
                                            <td> <?php echo number_format(@$data->totalout,2); ?> </td>
                                            <td> <?php echo number_format(@$data->totaldiff,2); ?> </td>
                                        </tr>
                                    <?php $sn++; ?>
                                   
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
            $('.input_fields_container').append('<div> <div class="form-group row">  <div class="col-6"><select name="currency[]" class="form-control" required=""><option value=""> Choose </option><?php foreach ($listcurrency as $value){ ?><option value="<?php echo $value->currency_id; ?>"> <?php echo $value->currency_desc; ?></option><?php } ?></select></div><div class="col-4"><input class="form-control" type="number" required="" name="balance[]" placeholder="Amount"></div>  <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
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
