<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> <?php echo $this->session->userdata('askfor')?> Billing List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Bill Transactions List</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                     <?php if($this->session->userdata('user_type') == "EMPLOYEE"){ ?>
                         <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions Lists List</a></button>
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_form?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Customer</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Customer List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_transactions_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions List</a></button>

                   <?php } ?>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Bill Transactions List                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <form action="bill_transactions_list" method="POST">
                            <table class="table table-bordered">
                              <tr>
                              <th><input type="text" name="controlno" class="form-control search" onkeyup="checkControlNo();"></th>
                              <!-- <th><button class="btn btn-info" type="submit" name="search" value="search">Search Transactions</button></th> -->
                              </tr>
                            </table>
                            </form>
                            <div class="table-responsive">
                             <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Acc Number</th>
                                                <th>Customer Name</th>
                                                <th>Control Number</th>
                                                <th>Amount</th>
                                                <th>Bill Date Created</th>
                                                <th>Invoice Number</th>
                                                <th>Receipt Number</th>
                                                <th>Date Payment</th>
                                                <td>Pay Channel</td>
                                                <th>Billing Status</th>
                                                
                                               
                                            </tr>
                                        </thead>
                                        
                                 <tbody class="results">
                                 <?php foreach ($billing as  $value) {?>
                                      <tr>
                                        <td><?php echo $value->acc_no;?></td>
                                        <td><?php echo $value->customer_name;?></td>
                                      <td><?php 
                                      
                                    if ($value->billid == '')          
                                     {
                                                     $serial=$value->serial;
                                                     $paidamount=$value->paidamount;

                           //$this->Bill_Customer_model->updatePaymentControlNumber($serial,$paidamount);
                       }else{
                        $serial=$value->serial;
                                                     $paidamount=$value->paidamount;

                           //$this->Bill_Customer_model->updatePaymentControlNumber($serial,$paidamount);
                       }
                                            
                                      echo $value->billid;
                                      ?></td>
                                      <td><?php echo number_format($value->paidamount,2);?></td>
                                      <td><?php echo $value->transactiondate;?></td>
                                      <td><?php echo $value->invoice_number;?></td>
                                      <td><?php echo $value->receipt; ?></td>
                                      <td><?php echo $value->paymentdate; ?></td>
                                      <td>
                                          <?php echo $value->paychannel; ?>
                                      </td>
                                      <td>
                                        <?php 
                                            if ($value->status == 'Paid') {
                                                echo "<button class = 'btn btn-success'>Paid</button>";
                                            }else{
                                                echo "<button class = 'btn btn-danger'>Not Paid</button>";
                                            }
                                        ?>
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
<div class="modal fade" id="myModal" role="dialog" style="padding-top: 300px;">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <form role="form" action="issuepayment" method="post">
        <div class="modal-body">
            <h3>Please Enter Amount</h3>
            <div class="row">
                <div class="col-md-12">
                    <input type="number" name="amount" class="form-control" required="">
                </div>
            </div>
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
            <input type="hidden" name="id" id="comid">
            <button type="submit" class="btn btn-default pull-left"><span class="glyphicon glyphicon-remove"></span>Yes</button>
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
        </div>
        </form>
        </div>
        <div class="modal-footer">
            
        </div>
    
      </div>
    </div>

<script type="text/javascript">
    $(document).ready(function() {
 
    var table = $('#example4').DataTable( {
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
    function checkControlNo() {
     var a = $('.search').val();

       $.ajax({
     
       url: "<?php echo base_url();?>Bill_Customer/searchControlno",
       method:"POST",
       data:{controlno:a},//'region_id='+ val,
       success: function(data){

       }
   });
}
</script>
<?php $this->load->view('backend/footer'); ?>

