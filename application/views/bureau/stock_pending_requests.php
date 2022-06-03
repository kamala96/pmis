<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-external-link" style="color:#1976d2"> </i>  Bureau De Change | Pending Requests </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home</a></li>
				<li class="breadcrumb-item active"> Bureau De Change </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">

             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/stock" class="text-white"><i class="" aria-hidden="true"></i> Stock  </a></button>
			
            <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Bureau/branch_stock" class="text-white"><i class="" aria-hidden="true"></i> Branch Stock Balance  </a></button>

            <button type="button" class="btn btn-primary"><i class="fa fa-bell"></i><a href="<?php echo base_url(); ?>Bureau/stock_pending_request" class="text-white"><i class="" aria-hidden="true"></i> Pending Requests ( <?php echo number_format(@$countpending); ?> ) </a></button>

            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".demo-example-modal-lg">  <i class="fa fa-plus"></i> Add Currency Request Denomination </button>


             <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Services/StrongRoom/" class="text-white"><i class="" aria-hidden="true"></i> Dashboard  </a></button>


			   
			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>    Pending Requests  </h4>
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
                        <div class="modal fade demo-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Currency Denomination </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
                        <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Bureau/save_denomination');?>">


                            <div class="form-group row">
                                <div class="col-8">
                                <label> Select Request </label>
                                <select name="requestcode" class="form-control" required="">
                                <option value=""> Choose </option>
    <?php foreach ($list as $value){ ?>
    <option value="<?php echo $value->request_code; ?>"> Request Code: <?php echo $value->request_code; ?> | BCLNO: <?php echo $value->bclno;?></option>
    <?php } ?>
                                </select>
                                </div>
                            </div>

                            <hr>

                            <div class="input_fields_container">
                         
                            <div class="form-group row">
                                <div class="col-4">
                                <select name="dcurrency[]" class="form-control" required="">
                                <option value=""> Choose </option>
                                <?php foreach ($listcurrency as $value){ ?>
                                <option value="<?php echo $value->currency_id; ?>"> <?php echo $value->currency_desc; ?></option>
                                <?php } ?>
                                </select>
                                </div>

                                <div class="col-3">
                                <input class="form-control" type="number" required="" name="dvalue[]" placeholder="Currency value">
                                </div>

                                <div class="col-3">
                                <input class="form-control" type="number" required="" name="dbalance[]" placeholder="Quantity">
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
                                            <th> Request Code </th>
                                            <th> Requested Date  </th>
                                            <th> Requested by </th>
                                            <th> Region  </th>
                                            <th> Branch  </th>
                                            <th> BCLNo.  </th>
                                            <th> Status </th>
                                            <th width="10%">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php $sn=1; foreach($list as $data){
                                        $empid = $data->requested_by;
                                        $info = $this->ContractModel->get_employee_info($empid);
                                        $code = $data->request_code;
                                        $listitems = $this->BureauModel->list_stock_request_currency($code);
                                        $denominatedlist = $this->BureauModel->list_denominated_currency($code);
                                        ?>
                                        <tr>
                                            <td> <?php echo $sn; ?> </td>                                           
                                            <td> <?php echo $data->request_code; ?> </td>
                                            <td> <?php echo $data->request_created_at   ; ?> </td>
                                            <td> <?php echo 'PF '.$info->em_code.'-'.$info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </td>
                                            <td> <?php echo $data->region; ?> </td>
                                            <td> <?php echo $data->branch; ?> </td>
                                             <td> <?php echo $data->bclno; ?> </td>
                                            <td> 
                                            <button class="btn btn-info waves-effect waves-light">  <?php echo $data->request_status; ?> </button> 
                                            </td>
                                            <td>

                                            <button title="Approve" class="btn btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#pmu_update_modal<?php echo $data->request_code; ?>">  <i class="fa fa-eye"></i> Approval Request </button>

                                             <?php if(!empty($denominatedlist)){?>
                                             <button title="Approve" class="btn btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#denomination_update_modal<?php echo $data->request_code; ?>">  <i class="fa fa-money"></i> Currency Denomination </button>
                                              <?php } ?>

                                            </td>
                                        </tr>
                                    <?php $sn++; ?>
                                      

                  <!-- PMU Approve -->
                        <div class="modal fade" id="pmu_update_modal<?php echo $data->request_code; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Approve Request   </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>             
                        <div class="modal-body"> 


          <div class='alert alert-danger alert-dismissible fade show notifyMessageTwo' role='alert' style="display:none;" id="notifyMessageTwo">
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
          <strong id="notifyMessageTwo" class="notifyMessageTwo"></strong>
          </div>

          




                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Bureau/save_approved_request');?>" id="formtest">
                    
                    <input type="hidden" class="form-control"  name="requestcode" value="<?php echo $data->request_code; ?>">
                    <input type="hidden" class="form-control"  name="createdby" value="<?php echo $data->requested_by; ?>">
                    
                    <div class="row">
                    <div class="col-md-2"> <strong> S/N </strong> </div> <div class="col-md-2"> <strong> Currency </strong> </div> <div class="col-md-2"> <strong> Required Amount </strong> </div> <div class="col-md-2"> <strong> Available Amount </strong> </div> <div class="col-md-4"> <strong> New Amount </strong> </div>
                    </div>
                     <hr>
                    <?php $serial=1; foreach($listitems as $row){ 
                    $balance = $this->BureauModel->strong_room_opening_balance_by_ID($row->currencyid);
                    ?>
                    <input type="hidden" class="form-control currencyid"  id="currencyid" name="currencyid[]" value="<?php echo $row->currencyid; ?>">

                     <div class="row MainApprovedRow">
                     <div class="col-md-2">
                    <?php echo $serial; ?>
                    </div>
                    <div class="col-md-2">
                    <?php echo $row->currency_desc; ?>
                    <input type="hidden" class="currencydesc" id="currencydesc" value="<?php echo @$row->currency_desc; ?>">
                    </div>
                    <div class="col-md-2">
                    <?php echo number_format($row->amount); ?>
                    <input type="hidden" class="requiredamount" id="requiredamount" value="<?php echo @$row->amount; ?>">
                    </div>
                    <div class="col-md-2">
                    <?php echo number_format(@$balance->totaldiff); ?>
                    <input type="hidden" class="balanceamount" id="balanceamount" value="<?php echo @$balance->totaldiff; ?>">
                    </div>
                     <div class="col-md-4">
                    <?php if(!empty(@$balance->totaldiff)){?>
                        <!-- id="approvedamount" -->
                    <input type="number" class="form-control approvedamount checkVerify" id="checkVerify" onchange="approvedAmount(this)"  name="qty[]" max="<?php echo $row->amount; ?>" placeholder="Enter Amount">
                   <?php } else { ?>
                   <input type="hidden" class="form-control"  name="qty[]">
                     <?php } ?>
                    </div>
                    </div>
                     <hr>
                <?php $serial++; } ?>


                    <div class="form-group row approvedoption" id="approvedoption">
                    <div class="col-md-6">
                    <select class="form-control"  style="width:100%;" name="status" required>
                    <option value=""> Choose </option>
                     <option value="canceled"> Cancel </option>
                     <option value="approved"> Approve </option>
                    </select>
                    </div>
                    </div>
                    
                    <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light approvedbutton" id="approvedbutton"> Submit </button>
                    </div>
                    </div>
                            
                     </form>
                    
                  
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- PMU Approved End -->


                 <!-- PMU Approve -->
                        <div class="modal fade" id="denomination_update_modal<?php echo $data->request_code; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Currency Request Denomination  </h5>
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
                     <a href="<?php echo base_url('Bureau/delete_denominated_stock');?>?I=<?php echo base64_encode($row->request_denomation_id); ?>" onclick='return del();' title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                    </div>
                    </div>
                     <hr>
                <?php $serial++; } ?>
                    
                  
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- PMU Approved End -->

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
    var max_fields_limit      = 100; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
        if(x < max_fields_limit){ //check conditions
            x++; //counter increment
            $('.input_fields_container').append('<div> <div class="form-group row">  <div class="col-4"><select name="dcurrency[]" class="form-control" required=""><option value=""> Choose </option><?php foreach ($listcurrency as $value){ ?><option value="<?php echo $value->currency_id; ?>"> <?php echo $value->currency_desc; ?></option><?php } ?></select></div><div class="col-3"><input class="form-control" type="number" required="" name="dvalue[]" placeholder="Currency value"></div><div class="col-3"><input class="form-control" type="number" required="" name="dbalance[]" placeholder="Quantity"></div>  <button href="#" class="remove_field btn btn-primary" style="margin-left:10px;">  X  </button>   </div> </div>'); //add input field
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
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<?php $this->load->view('backend/footer'); ?>

       <script>
        function approvedAmount(obj){
            var newAmount = parseFloat($(obj).val());
            var row = $(obj).closest('.MainApprovedRow');
            var availableBalance = parseFloat(row.find('#balanceamount').val());
            var requiredAmount = parseFloat(row.find('#requiredamount').val());
            var currency = row.find('.currencydesc').val();

            var message = "Your balance is: "+availableBalance+" on the currency of "+currency+" and required amount must be less or equal to "+requiredAmount+" and note that you cannot approval request if your stock balance is less than requested stock. Please check your balance before proceed to approval request. Thanks";

            var extramessage = "You cannot approve the request that is above available Stock/Balance";

            

            if (newAmount > availableBalance) {

            $('.notifyMessageTwo').show().html(extramessage);
            $('.approvedbutton').hide();
            $('.approvedoption').hide();
            
            
            $('.checkVerify').attr('disabled','disabled');
            $(obj).removeAttr('disabled');

            } else {

                $('.notifyMessageTwo').html('');
                $('.notifyMessageTwo').hide();
                $('.approvedamount').show();
                $('.approvedbutton').show();
                $('.approvedoption').show();
                $('.checkVerify').attr('disabled','disabled');
                $('.checkVerify').removeAttr('disabled','disabled');
                $(obj).removeAttr('disabled');
            }
           

              
        }
        </script>

