<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Box Rental Application Transaction  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Reports </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                   <div class="card-header">

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
                       
                            <form class="row" method="post" action="<?php echo site_url('Box_Application/box_rental_app_report_results');?>">

                                    <div class="form-group col-md-3 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" required="">
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-10">
                                         <input type="date" name="todate" class="form-control" required="">
                                    </div>

                                     <div class="form-group col-md-3 m-t-10">
                                    <select class="form-control" required="required" name="status">
                                    <option value="Paid"> Paid </option>
                                    <option value="NotPaid"> UnPaid </option>
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
<h3> <strong> <?php echo strtoupper($status); ?> BOX RENTAL APPLICATION TRANSACTIONS </strong> <br>
</h3>
<p style="font-weight: bold;font-size: 20px;"> <b>From : </b> <?php echo date("d/m/Y",strtotime($fromdate)); ?> &nbsp; &nbsp;  <b>To:</b> </b><?php echo date("d/m/Y",strtotime($todate)); ?> </p>
</div>
                                



                         

                               
                            <div class="table-responsive">
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Customer Name</th>
                                                 <th>Registered date</th>
                                                <th>Mobile No.</th>
                                                <th>Amount(Tsh.)</th>
                                                <th>Bill Number</th>
                                                <th>Region </th>
                                                 <th>Branch </th>
                                                <th>P.o.Box Number</th>
                                                <th>Payment Date</th>
                                                 <th>Payment Channel</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php $sn=1; foreach($list as $value): ?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
                                                <td> <?php echo $value->cust_name; ?> </td>
                                                <td><?php echo $value->transactiondate; ?></td>
                                                <!-- <td><?php echo $value->box_tariff_category; ?></td> -->
                                                <td><?php echo $value->Customer_mobile; ?></td>
                                                <td><?php @$amount = $value->paidamount; echo number_format(@$amount,2); $sumamount[] = $amount; ?></td>
                                                <td><?php echo $value->billid;  ?></td>
                                                

                                                   <?php $box_status =$this->Box_Application_model->box_status($value->details_cust_id); ?>

                                                   <td><?php echo $value->region; ?></td>
                                                   <td><?php echo $value->district; ?></td>

                                                <td>

                                                  <?php if (!is_null($box_status)){?>
                                                    <?php echo $box_status->box_number; ?>

                                                  <?php   }else{?>
                                                 <?php   }?>

                                                 </td>


                                                <td>
                                                <?php if ($value->paymentdate == '') {
                                                    
                                                }else{
                                                     echo date('d/m/Y', strtotime($value->paymentdate));
                                                }
                                                ?>
                                               </td>
                                                <td><?php echo $value->paychannel; ?></td>

                                             

                                            </tr>
                                            <?php $sn++; endforeach; ?>

                                            <tr>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> Total </td>
                                                <td> <?php if(!empty(@$amount)) { echo number_format(array_sum($sumamount),2); }?></td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
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