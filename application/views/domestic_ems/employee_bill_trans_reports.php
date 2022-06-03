<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
<style type="text/css">  
table {
    border:solid #000 !important;
    border-width:1px 0 0 1px !important;
}
th, td {
    border:solid #000 !important;
    border-width:0 1px 1px 0 !important;
    padding: 3px !important;
    color: #000 !important;
}

</style>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> EMS Bill Transaction Report  </h3>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Ems_Domestic/employee_view_reports" class="text-white"><i class="" aria-hidden="true"></i>  Cash Transaction Report </a></button>
                    
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Ems_Domestic/employee_trans_bill_reports" class="text-white"><i class="" aria-hidden="true"></i>  Bill Transaction Report  </a></button>

                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Bill_Customer/bill_customer_list?AskFor=EMS Postage" class="text-white"><i class="" aria-hidden="true"></i>  Bill Receipt  </a></button>

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
                       
                            <form class="row" method="post" action="<?php echo site_url('Ems_Domestic/employee_bill_report_results');?>">
                                    <div class="form-group col-md-4 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" placeholder="Enter Full name" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <input type="date" name="todate" class="form-control" placeholder="Enter No." required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>
                            

 <?php if(isset($emslist)){ ?>

 <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

<div class="panel-footer text-center">
<img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/>
<br>
<h3> <strong> BILL TRANSACTIONS </strong> </h3>
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


                         

                               
                                    <table class="table-hover table-striped table-bordered" style="font-size: 13px !important;" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Customer Name  </th>
                                                <th> Barcode Number </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       <?php  
                                       $sn=1;
                                       foreach ($emslist as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo $value->s_fullname; ?>  </td>
                                         <td>   <?php echo $value->Barcode; ?>    </td>
                                          <td>  <?php echo $value->weight; ?>     </td>
                                           <td>   <?php echo $value->branch; ?>    </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 @$sumprice[] = @$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            @$sumvat[] = @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 @$sumamount[] = @$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td> <?php if(!empty(@$sumprice)){ echo number_format(array_sum(@$sumprice),2); } ?> </td>
                                        <td> <?php if(!empty(@$sumvat)){ echo number_format(array_sum(@$sumvat),2);  } ?> </td>
                                        <td> <?php if(!empty(@$sumamount)){ echo number_format(array_sum(@$sumamount),2); } ?> </td>
                                       </tr>   
                                        </tbody>
                                    </table>
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