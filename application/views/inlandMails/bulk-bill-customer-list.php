<?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><b><i class="fa fa-university" aria-hidden="true"></i>  <?php echo $billtype;  ?> Bulk Bill Customer List</b></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><b><?php echo $billtype;  ?> Bulk Bill Customer List</b></li> 
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>

       
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12"> 
                    
                    <?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR"){ ?>
                      
                           <!--  <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bulk_bill_transaction_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i><?php echo $billtype;  ?> Bill Transactions Lists</a></button> -->

                             <?php if(@$billtype == 'Latter'){?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/latter_bulk_bill_transaction_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $billtype;  ?> Bill Transactions Lists</a></button>

                       <?php }elseif (@$billtype == 'Parcel') { ?>
                          <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Unregistered/parcel_mail_bulk_post_application_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $billtype;  ?> Bill Transactions Lists</a></button>

                       <?php } else{ ?>

                        <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bulk_bill_transaction_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $billtype;  ?> Bill Transactions Lists</a></button>

                       <?php } ?>
                       
                         
                         <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/mail_bulk_bill_customer_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i><?php echo $billtype;  ?> Bulk Bill Customer List</a></button>

                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bulk_bill_customer_form?AskFor=<?php echo @$billtype;?>" class="text-white"><i class="" aria-hidden="true"></i> Add <?php echo $billtype;  ?>  Bulk Bill Customer</a></button>

                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/mail_bulk_bill_customer_list?AskFor=<?php echo @$billtype;?>" class="text-white"><i class="" aria-hidden="true"></i><?php echo $billtype;  ?> Bulk Bill Customer List</a></button>

                       <?php if(@$billtype == 'Latter'){?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/latter_bulk_bill_transaction_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $billtype;  ?> Bill Transactions Lists</a></button>

                        <?php }elseif (@$billtype == 'Parcel') { ?>
                          <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Unregistered/parcel_mail_bulk_post_application_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $billtype;  ?> Bill Transactions Lists</a></button>

                       <?php }else{ ?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bulk_bill_transaction_list?AskFor=<?php echo $billtype;  ?>" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $billtype;  ?> Bill Transactions Lists</a></button>

                       <?php } ?>

                   <?php } ?>
                     
                </div>
            </div>


            
            
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-th-list" aria-hidden="true"></i>
                                <!-- <b><?php echo $billtype;  ?> Bill Customer List </b> -->
                                <span class="pull-right " ></span></h4>
                        </div>




   <div class="card-body">


                            <div class="col-md-12">
                        <form action="bill_bulk_customer_list_Search" method="POST">
                        <div class="input-group">
                           <input type="text" name="AskFor" class="form-control" value="<?php echo $billtype;  ?>" hidden="hidden">
                          <input type="text" name="custname" class="form-control " placeholder="Search Customer Name" >
                           <!-- <input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Select Date"> -->
                          <!-- <input type="text" name="month" class="form-control mydatetimepicker" placeholder="Select Month"> -->
                          <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                          <select class="form-control custom-select" name="region">
                            <option value="">--Select Region-</option>
                            <?php foreach ($region as $value) { ?>
                              <option><?php echo $value->region_name ?></option>
                            <?php } ?>
                          </select>
                        <?php }?>
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div> 

                  </div>






                        
                        <div class="card-body">
                            <div class="row">
                             
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                          <table id="table_id" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Acc. Number</th>
                                <th>Customer Name</th>
                                <th>Payment Type</th>
                                <th>Customer Address</th>
                                <th>Mobile Phone</th>                                
                                <th>Available Balance</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                             <?php if(isset($check) && ($check!==null)){?>
                               
                            
                            <?php foreach ($check as  $value) {
                            $customeracc = $value->acc_no;
                            $custprice = $this->Box_Application_model->get_bill_cust_details($customeracc);
                            ?>
                            <tr>
                                <td><?php echo $value->acc_no;?></td>
                                <td><?php echo $value->customer_name;?></td>
                                <td><?php echo $value->customer_type;?></td>
                                <td><?php echo $value->customer_address;?></td>
                                <td><?php echo $value->cust_mobile;?></td>
                                <td>
                                <?php
                                /*
                                if( $value->customer_type == "PostPaid" ){
                                    // echo number_format($value->price,2);
                                     $type = $value->acc_no;
                                $getPay1 = $this->Bill_Customer_model->getPayMAIL($type);
                                // echo number_format((@$getPay1->paidamount + $value->price),2);
                                }else{
                                    
                                $type = $value->acc_no;
                                $getPay1 = $this->Bill_Customer_model->getPayMAIL($type);
                                 
                                 if (empty($getPay1)) {
                                  // echo number_format($value->price,2);
                                 } else {
                                   //echo number_format(@$getPay1->paidamount);
                                 }
                                 
                                 //echo number_format($value->price,2);
                                
                                }*/
                                 echo number_format($custprice->price,2); 
                                ?>
                                </td>
                                
                                <td style="text-align:right;">
                                  <?php 
                                 $acc = $value->acc_no;
                                 $getStatus = $this->Bill_Customer_model->get_ems_billing_list3($acc);
                                 ?>

                                <?php if( $this->session->userdata('user_type') == "EMPLOYEE"|| $this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "AGENT"){ ?>

                                 <?php if($value->customer_type == "PostPaid"){?>

                                 <?php if($billtype == "Register" ){ ?>
                                    <a href="<?php echo base_url()?>unregistered/unregistered_bill_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                                  <?php }elseif ($billtype == "latter") { ?> 
                                      <a href="<?php echo base_url()?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                                  <?php }elseif ($billtype == "Parcel") { ?> 
                                      <a href="<?php echo base_url()?>unregistered/parcel_bill_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                                  <?php } else{?>
                                                                  <a href="<?php echo base_url()?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                               <?php } ?>
                                
                                 <?php }else{ ?>

                                 
                                 <?php if(empty($getStatus)){ ?>
                                    <button class="btn btn-warning btn-sm">No Service</button>
                                 <?php }else{?>

                                 <?php if(@$getStatus->status == "NotPaid"){ ?>
                                        <button class="btn btn-warning btn-sm">No Service</button>
                                 <?php }else{ ?>
                                  <?php if($billtype == "Register"){ ?>
                                    <a href="<?php echo base_url()?>unregistered/unregistered_bill_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                                    <?php }elseif ($billtype == "Latter") { ?> 
                                      <a href="<?php echo base_url()?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                                  <?php }elseif ($billtype == "Parcel") { ?>
                                      <a href="<?php echo base_url()?>unregistered/parcel_bill_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                                  <?php }else{?>
                                  <a href="<?php echo base_url()?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype; ?>" class="btn btn-info">Services</a>
                               <?php } ?>

                                <?php } ?>

                                <?php } ?>
                                
                                <?php } ?>

                                <?php }else{ ?>
                                

                                <?php if($value->customer_type == "PostPaid"){?>
                                    <?php if( $billtype == "Register" || $billtype == "Parcel" || $billtype == "latter"){ ?>

                                       <!--  <a href="<?php echo base_url()?>Bill_Customer/Credit_Customer_Prepare_bulk_Bill?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype;?>" class="btn btn-info">Genarate Bill</a> -->
                                    <?php } ?>
                                     <a href="<?php echo base_url()?>Bill_Customer/Credit_Customer_Prepare_bulk_Bill?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $billtype;?>" class="btn btn-info">Genarate Bill</a>
                                    
                                     <a href="<?php echo base_url()?>Box_Application/get_bill_ems_list?I=<?php echo base64_encode($value->acc_no) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Bill Payment Trend</a>

                                <?php }else{ ?>

                                
                                 <a href="<?php echo base_url()?>Box_Application/get_bill_ems_list?I=<?php echo base64_encode($value->acc_no) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Bill Payment Trend</a>

                                <?php } ?>
                                |
                                  <a href="<?php echo base_url()?>Bill_Customer/bulk_bill_customer_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Edit</a>
                                <?php }?> 
                                  
                            </td>
                            </tr>
                            <?php } ?>
                             <?php }else{?>

                                <tr>
                                    <td colspan="7">
                                        
                                    </td>
                                </tr>

                             <?php }?>
                            
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

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">
         <label >Customer Name: </label><input type="text" id="company" readonly style="border: none;" />  
         <!-- <label >Company Number: </label>  <input type="text" id="code" readonly /> -->
         <!-- <label id="code" ></label>  &amp; <label id="company" ></label></h4> -->
      </div>
      <div class="modal-body">
        <div id="boxesdata">   </div>
        <!-- <input type="text" id="code" readonly />
        <input type="text" id="company" readonly /> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" id="myModal2">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">
         <label >Customer Name: </label><input type="text" id="company" readonly style="border: none;" />  
         <!-- <label >Company Number: </label>  <input type="text" id="code" readonly /> -->
         <!-- <label id="code" ></label>  &amp; <label id="company" ></label></h4> -->
      </div>
      <div class="modal-body">
        <div id="boxesdata2">   </div>
        <!-- <input type="text" id="code" readonly />
        <input type="text" id="company" readonly /> -->
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
 
    var table = $('#table_id').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        order: [[6,"desc" ]],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>


<script type="text/javascript">
    $(document).ready( function () {
    // $('#table_id').DataTable({
    //     dom: 'Bfrtip',
    //     ordering:false,
    //     buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    // });

$(function () {
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var code = button.data('code'); // Extract info from data-* attributes
    var company = button.data('company'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var serial = button.data('serial');
    //var serial = $('#regionp').val();
    $.ajax({
     type: "POST",
     //url: "<?php echo base_url();?>Box_Application/GetBoxes",
      url: "<?php echo base_url();?>Bill_Customer/getControlNo",
     data:'crdid='+ serial,
     success: function(data){
         $("#boxesdata").html(data);
     }
 });
    var modal = $(this);
    modal.find('#code').val(code);
    modal.find('#company').val(company);
  });
});


$(function () {
  $('#myModal2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var code = button.data('code'); // Extract info from data-* attributes
    var company = button.data('company'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var serial = button.data('serial');
    //var serial = $('#regionp').val();
    $.ajax({
     type: "POST",
     //url: "<?php echo base_url();?>Box_Application/GetBoxes",
      url: "<?php echo base_url();?>Bill_Customer/get_NewControlNo",
     data:'crdid='+ serial,
     success: function(data){
         $("#boxesdata2").html(data);
     }
 });
    var modal = $(this);
    modal.find('#code').val(code);
    modal.find('#company').val(company);
  });
});

    //$(".cont").click(function(){
    $('#cont').click(function() {
    //e.preventDefault();
    
    var a = $(this).attr("data-control");
    
      $.ajax({
     
       url: "<?php echo base_url();?>Bill_Customer/getControlNo",
       method:"POST",
       data:{crdid:a},//'region_id='+ val,
       success: function(data){

            alert(data);
           // $("#myModal1").modal();
           // $('.result').html(data);

       }
   });

  });


    });
</script>

<script type="text/javascript">
$(document).ready(function(){
  
});
</script>

<?php $this->load->view('backend/footer'); ?>
