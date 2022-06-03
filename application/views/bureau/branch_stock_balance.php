<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-wpforms" style="color:#1976d2"> </i> Bureau De Change | Branch Stock </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home</a></li>
				<li class="breadcrumb-item active"> Bureau De Change  </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Services/Bureau" class="text-white"><i class="" aria-hidden="true"></i> Bureau De Change   </a></button>

             <!-- <button type="button" class="btn btn-primary"><i class="fa fa-share-square-o"></i>
            <a href="<?php echo base_url(); ?>Bureau/return_balance" class="text-white" onclick="return del();""><i class="" aria-hidden="true"></i> Return Balance / Close Session  </a> -->
            </button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>   Bureau De Change | Branch Balance </h4>
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


                            <?php if(!empty($list)){ ?>
                                    <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
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
                                     <?php $sn=1; foreach($list as $data){ 
                                     //$denominatedlist = $this->BureauModel->list_denominated_currency_branch_listed_specifi($data->requestcode,$data->currencyid);
                                     ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                             <td>
                                             <?php echo @$data->currency_desc; ?> 
                                            </td>
                                            <td> <?php echo @$data->currency_name; ?> </td>
                                            <td> <?php echo number_format(@$data->total,2); ?> </td>
                                            <td> <?php echo number_format(@$data->totalout,2); ?> </td>
                                            <td> <?php echo number_format(@$data->totaldiff,2); ?> </td>
                                        </tr>
                                    <?php $sn++;  ?>


                        <!-- <div class="modal fade" id="denomination_update_modal<?php echo $data->bureau_branch_stock_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Currency Denomination  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                        <div class="modal-body"> 

                    
                    <div class="row">
                    <div class="col-md-2"> <strong> S/N </strong> </div> <div class="col-md-4"> <strong> Currency </strong> </div> <div class="col-md-2"> <strong> Currency Value </strong> </div> <div class="col-md-2"> <strong> Quantity </strong> </div> <div class="col-md-2"> <strong> Total </strong> </div>
                    </div>
                     <hr>
                    <?php $serial=1; foreach($denominatedlist as $row){ 
                    ?>
                     <div class="row">
                     <div class="col-md-2">
                    <?php echo $serial; ?>
                    </div>
                    <div class="col-md-4">
                    <?php echo $row->currency_desc; ?>
                    </div>
                    <div class="col-md-2">
                    <?php echo number_format($row->currencyvalue); ?>
                    </div>
                    <div class="col-md-2">
                    <?php echo number_format($row->qty); ?>
                    </div>
                    <div class="col-md-2">
                    <?php echo number_format($row->qty*$row->currencyvalue); ?>
                    </div>
                    </div>
                     <hr>
                <?php $serial++; } ?>
                    
                  
                        </div>
                       </div>
                       </div>
                    </div> -->
              


                                    <?php } ?>
                   
                                    </tbody>
                                </table>
                                </div>
                           <?php } else {?>

                  

                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> You have no stock balance, Please request stock!  </strong> 
                    </div>  

                    

                    <?php } ?>

                 </div>





						
	    	</div>
		</div>
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
        if(confirm("Are you sure you want to return stock balance? if you agree stock balance will be empty"))
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
