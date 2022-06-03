<?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><b><i class="fa fa-university" aria-hidden="true"></i>  MAILS Bill Customer List</b></h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active"><b>MAILS Bill Customer List</b></li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    
                    <?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR"){ ?>
                        <?php if($this->session->userdata('askfor') == "MAILS"){ ?>
                            <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions Lists</a></button>
                        <?php }else{?>
                            <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_transactions_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions Lists</a></button>
                        <?php }?>
                         
                         <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Customer List</a></button>
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_form?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Customer</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Customer List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions List</a></button>

                   <?php } ?>
                     
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-th-list" aria-hidden="true"></i><b>MAILS Bill Customer List </b><span class="pull-right " ></span></h4>
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
                                <th>Amount(Tsh.)</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($check as  $value) {?>
                            <tr>
                                <td><?php echo $value->acc_no;?></td>
                                <td><?php echo $value->customer_name;?></td>
                                <td><?php echo $value->customer_type;?></td>
                                <td><?php echo $value->customer_address;?></td>
                                <td><?php echo $value->cust_mobile;?></td>
                                <td>
                                <?php
                                /*if( $value->customer_type == "PostPaid" ){
                                    // echo number_format($value->price,2);
                                     $type = $value->acc_no;
                                $getPay1 = $this->Bill_Customer_model->getPay($type);
                                 echo number_format((@$getPay1->paidamount + $value->price),2);
                                }else{
                                    
                                $type = $value->acc_no;
                                $getPay1 = $this->Bill_Customer_model->getPay($type);
                                 
                                 if (empty($getPay1)) {
                                   echo number_format($value->price,2);
                                 } else {
                                   echo number_format(@$getPay1->paidamount);
                                 }
                                 
                                 //echo number_format($value->price,2);
                                
                                }*/
                                ?>
                                </td>
                                
                                <td style="text-align:right;">
                                  <?php 
                                 $acc = $value->acc_no;
                                 $getStatus = '';//$this->Bill_Customer_model->get_ems_billing_list3($acc);
                                 ?>

                                <?php if( $this->session->userdata('user_type') == "EMPLOYEE"|| $this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "AGENT"){ ?>

                                 <?php if($value->customer_type == "PostPaid"){?>

                                 <?php if($this->session->userdata('askfor') == "MAILS"){ ?>
                                    <a href="<?php echo base_url()?>unregistered/unregistered_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $this->session->userdata('askfor'); ?>" class="btn btn-info">Services</a>
                                  <?php }else{?>
                                 <a href="<?php echo base_url()?>Box_Application/Send?I=<?php echo base64_encode($value->credit_id) ?>" class="btn btn-info">Services</a>
                               <?php } ?>
                                
                                 <?php }else{ ?>

                                 
                                 <?php if(empty($getStatus)){ ?>
                                    <button class="btn btn-warning btn-sm">No Service</button>
                                 <?php }else{?>

                                 <?php if(@$getStatus->status == "NotPaid"){ ?>
                                        <button class="btn btn-warning btn-sm">No Service</button>
                                 <?php }else{ ?>
                                  <?php if($this->session->userdata('askfor') == "MAILS"){ ?>
                                    <a href="<?php echo base_url()?>unregistered/unregistered_form?I=<?php echo base64_encode($value->credit_id) ?>" class="btn btn-info">Services</a>
                                  <?php }else{?>
                                 <a href="<?php echo base_url()?>Box_Application/Send?I=<?php echo base64_encode($value->credit_id) ?>" class="btn btn-info">Services</a>
                               <?php } ?>

                                <?php } ?>

                                <?php } ?>
                                
                                <?php } ?>

                                <?php }else{ ?>
                                

                                <?php if($value->customer_type == "PostPaid"){?>
                                    <?php if($this->session->userdata('askfor') == "MAILS"){ ?>
                                        <a href="<?php echo base_url()?>Bill_Customer/Prepare_Customer_Bills?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Genarate Bill</a>
                                    <?php }else{?>
                                        <a href="<?php echo base_url()?>Box_Application/Credit_Customer_Prepare_Bill?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Genarate Bill</a>
                                    <?php }?>
                                    |
                                     <a href="<?php echo base_url()?>Box_Application/get_bill_ems_list?I=<?php echo base64_encode($value->acc_no) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Bill Payment Trend</a>

                                <?php }else{ ?>

                                 <?php if (empty($getPay1)) {?>
                                   <a href="#" class="btn btn-info cont" data-control="<?php echo $value->credit_id; ?>">Control Num.</a> |
                                 <?php }else{?>
                                   
                                 <?php }?>
                                 <a href="<?php echo base_url()?>Box_Application/get_bill_ems_list?I=<?php echo base64_encode($value->acc_no) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Bill Payment Trend</a>

                                <?php } ?>
                                |
                                  <a href="<?php echo base_url()?>Bill_Customer/bill_customer_form?I=<?php echo base64_encode($value->credit_id) ?>&&AskFor=<?php echo $this->session->userdata('askfor')?>" class="btn btn-info">Edit</a>
                                <?php }?> 
                                  
                            </td>
                            </tr>
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
<script type="text/javascript">
    $(document).ready( function () {
    $('#table_id').DataTable({
        dom: 'Bfrtip',
        ordering:false,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    });
</script>

<script>
$(document).ready(function(){
  $(".cont").click(function(){
    
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

<?php $this->load->view('backend/footer'); ?>
