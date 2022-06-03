<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Delivery Registered (RDP,FPL) Transaction  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Transaction </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                   <div class="card-header">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Box_Application/Ems_Application_Pending_Supervisor?I=<?php echo base64_encode($this->session->userdata('getempid')); ?>" class="text-white"><i class="" aria-hidden="true"></i>  Transaction Dashboard </a></button>

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
                       
                            <form class="row" method="post" action="<?php echo site_url('Ems_Domestic/track_deliver_int_report_results');?>">

                                <input type="hidden" name="emcode" class="form-control" value="<?php echo $this->session->userdata('getempcode'); ?>">

                                    <div class="form-group col-md-3 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <input type="date" name="todate" class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-md-3 m-t-10">
                                    <select class="form-control" required="required" name="status">
                                    <option value="all"> -- All -- </option>
                                    <option value="Paid"> Paid </option>
                                    <option value="NotPaid"> Not paid </option>
                                    </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>
                            

 <?php if(isset($list)){ ?>

 <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

<div class="panel-footer text-center">
<img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/>
<br>
<h3> <strong> <?php echo strtoupper($status); ?> DELIVERY (RDP,FPL) Transaction  </strong> </h3>
</div>
                                
<table  class="table table-hover table-bordered" cellspacing="0" width="100%">
<tr style="font-size:22px ;">
    <th><b>Operator Name: </b><?php echo $info->em_code; ?>  - <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </th>
     <th><b>Office : </b><?php echo $info->em_branch;?> </th>
</tr>
<tr style="font-size:22px ;" >
     <th colspan="2"><b>From : </b><?php echo $fromdate;?>  &nbsp; &nbsp; &nbsp;  <b>To:</b> </b><?php echo $todate;?> </th>
</tr>
<br>

</table>


                         

                               
                       <div class="table table-responsive">
                        <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                        <thead>
                                 
                                 <th> S/N </th>
                                 <th> Item</th>
                                 <th>Customer Mobile</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>
                                   <th>Control Number </th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   <th> Action </th>
                                   
                                  
                               </thead>
                               <tbody>
                                   <?php $sn=1; foreach ($list as $value) { ?>
                                       <tr>

                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->Customer_mobile; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php @$amount = $value->paidamount; @$sumamount[] = @$amount; echo number_format(@$amount,2); ?> </td>
                                           <td>  <?php  echo $value->billid;   ?>  </td>
                                           <td><?php echo $value->paychannel; ?></td>
                                           <td><?php echo $value->paymentdate; ?></td>
                                           <td><?php if($value->status == 'NotPaid'){?>
                                                <button class="btn btn-danger btn-sm" disabled="disabled">NOT PAID</button>
                                               <?php }else{?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">PAID</button>
                                               <?php } ?>
                                           </td>
                                            <td>  

                                            <button class="btn btn-info" data-toggle="modal" type="button" data-target="#edit_modal<?php echo $value->registered_international_id; ?>"> <i class="fa fa-pencil"></i>  </button>

                                            <button class="btn btn-info" data-toggle="modal" type="button" data-target="#cancel_modal<?php echo $value->registered_international_id; ?>"> <i class="fa fa-times-circle"></i>  </button>

                                            </td>

                                          
                                           
                                       </tr>
                                   <?php $sn++; ?>


                         <!-- Edit Task -->
                        <div class="modal fade" id="edit_modal<?php echo $value->registered_international_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Transaction | Control Number: <?php echo $value->billid;  ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                        <div class="modal-body"> 
            
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Ems_Domestic/update_delivery_int_transaction');?>">
                    
                    <input type="hidden" class="form-control"  name="serial" value="<?php echo $value->serial; ?>">

                    <div class="form-group row">
                    <div class="col-md-12">
                    <label> Item </label>
                    <input type="text" class="form-control"  name="item" value="<?php echo $value->item; ?>">
                    </div>
                    </div>
                    
                    <div class="form-group row">
                    <div class="col-md-12">
                    <label> Customer Mobile </label>
                    <input type="text" class="form-control"  name="mobile" value="<?php echo $value->Customer_mobile; ?>">
                    </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Update </button>
                    </div>
                    </div>
                            
                     </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- Edit End -->


                  <!-- Cancel Transaction -->
                        <div class="modal fade" id="cancel_modal<?php echo $value->registered_international_id; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Cancel Control Number: <?php echo $value->billid;  ?> | Serial: <?php echo $value->serial; ?> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                        <div class="modal-body"> 
            
                    <form class="form-horizontal m-t-20" method="post" action="<?php echo site_url('Ems_Domestic/cancel_delivery_int_transaction');?>">
                    
                    <input type="hidden" class="form-control"  name="serial" value="<?php echo $value->serial; ?>">


                    <div class="form-group row">
                    <div class="col-md-12">
                    <label> Reason </label>
                    <textarea class="form-control" name="reason" rows="5"> </textarea>
                    </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-12">
                    <button type="submit" class="btn btn-primary waves-effect waves-light"> Update </button>
                    </div>
                    </div>
                            
                     </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- Cancel End -->



                                   <?php } ?>

                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total: </td>
                                    <td><?php if(!empty(@$amount)) { echo number_format(array_sum(@$sumamount),2); } ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                   </tr>
                               </tbody>              
                        </table>
                        </div>
</div>
                               <?php } ?>
                               
                               
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
function printContent(el)
{
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>
    <?php $this->load->view('backend/footer'); ?>