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
                    <h3 class="text-themecolor"> EMS Revenue Collection Report  </h3>
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

                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Ems_Domestic/employee_reports_dashboard" class="text-white"><i class="" aria-hidden="true"></i>  Resport Dashboard </a></button>

                    </div>
                            
                            <div class="card-body">


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
                       
                            <form class="row" method="post" action="<?php echo site_url('E_reports/retrieve_ems_report');?>">
                                    <div class="form-group col-md-4 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" placeholder="Enter Full name" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <input type="date" name="todate" class="form-control" placeholder="Enter No." required="required">
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                    <select class="form-control" name="branch">
                                        <option value="all"> --  Select All Branch-- </option>
                                        <?php foreach($listbranch as $data){ ?>
                                        <option value="<?php echo $data->branch_id; ?>"> <?php echo $data->branch_name; ?> </option>
                                    <?php } ?>
                                    </select>
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
<h3> <strong> EMS Revenue Collection Report  </strong> <br> From :  <?php echo $fromdate; ?>  &nbsp; &nbsp; &nbsp;   To:  <?php echo $todate; ?> </h3>
</div>
                                



                         

                               
                                    <table class="table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr style="font-weight: bold !important;color: #000 !important;">
                                                <th>   </th>
                                                <th></th>
                                                <th colspan="2"> Domestic Posted </th>
                                                <th colspan="2"> International  </th>
                                                <th colspan="2"> PCUM Service  </th>
                                                <th colspan="2"> EMS CARGO  </th>
                                                <th colspan="2"> Domestic  </th>
                                                <th colspan="2"> International </th>
                                                <th colspan="2"> PCUM Service  </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                       <tr>

                                       <td>  </td>
                                       <td>  </td>

                                       <td> Cash </td>
                                       <td> </td>

                                       <td> Cash </td>
                                       <td> </td>

                                       <td>Cash </td>
                                       <td></td>

                                       <td>Cash </td>
                                       <td></td>

                                       <td> Billing </td>
                                       <td> </td>

                                       <td> Billing  </td>
                                       <td></td>

                                       <td> Billing  </td>
                                       <td></td>

                                       </tr>
                                     

                                       <tr>
                                        <td> S/No </td>
                                        <td> Office </td>
                                        <td> No </td> <td> Amount </td>
                                        <td> No </td> <td> Amount </td>
                                        <td> No </td> <td> Amount </td>
                                        <td> No </td> <td> Amount </td>
                                        <td> No </td> <td> Amount </td>
                                        <td> No </td> <td> Amount </td>
                                        <td> No </td> <td> Amount </td>
                                       </tr>
                                       
                                       <?php $sn=1; 
                                        foreach($emslist as $data){
                                        $branch = $data->branch_name;
                                        ?>
                                       <tr>
                                         <td> <?php echo $sn; ?> </td>
                                        <td> <?php echo $branch; ?> </td>

                                        <!--  Domestic Postage Cash -->
    <td> <?php @$count_postage= $this->E_reports_Model->count_domestic_postage($branch,$fromdate,$todate); 
    echo @$count_postage; 
    $sum_count_postage[] = @$count_postage; ?> 
    </td> 

    <td>
    <?php $cash_postage = $this->E_reports_Model->sum_domestic_postage($branch,$fromdate,$todate);  
    echo number_format(@$cash_postage->postage_amount,2);
    $sum_cash_postage[] = @$cash_postage->postage_amount;
    ?> 
   </td>
                                         <!-- END  Domestic Postage Cash -->

                                        <!--  International Cash -->
<td> <?php @$count_cash_int= $this->E_reports_Model->count_cash_internatioanl($branch,$fromdate,$todate); 
    echo @$count_cash_int; 
    $sum_count_cash_int[] = @$count_cash_int;
    ?> 
</td> 

<td> <?php $cash_int = $this->E_reports_Model->sum_cash_international($branch,$fromdate,$todate);  
echo number_format(@$cash_int->postage_amount,2);
$sum_cash_int[] = @$cash_int->postage_amount;
?> 
</td>
                                        <!--  End International Cash -->

                                        <!--  Pcum Cash -->
 <td> <?php @$count_cash_pcum= $this->E_reports_Model->count_cash_pcum($branch,$fromdate,$todate); 
 echo @$count_cash_pcum; 
$sum_count_cash_pcum[] = @$count_cash_pcum;
?>
</td> 
<td> <?php $cash_pcum = $this->E_reports_Model->sum_cash_pcum($branch,$fromdate,$todate);  
echo number_format(@$cash_pcum->postage_amount,2);
$sum_cash_pcum[] = @$cash_pcum->postage_amount;
?>  </td>
                                        <!--  End Pcum Cash -->

                                         <!--  Post Cargo Cash -->
    <td> <?php @$count_cash_pcargo= $this->E_reports_Model->count_cash_emscargo($branch,$fromdate,$todate); 
    echo @$count_cash_pcargo; 
    $sum_count_pcargo[] = @$count_cash_pcargo;
    ?>  
   </td> 

<td> <?php $cash_pcargo = $this->E_reports_Model->sum_cash_emscargo($branch,$fromdate,$todate); 
 echo number_format(@$cash_pcargo->postage_amount,2);
$sum_cash_pcargo[] = @$cash_pcargo->postage_amount;
?> 
</td>
                                         <!--  Post Cargo Cash -->

                                        <!--  Domestic Postage Bill -->
<td> <?php @$count_postage_bill = $this->E_reports_Model->count_domestic_bill_postage($branch,$fromdate,$todate); 
echo @$count_postage_bill; 
$sum_count_postage_bill[] = @$count_postage_bill;
?> </td> 
<td><?php $cash_postage_bill = $this->E_reports_Model->sum_domestic_bill_postage($branch,$fromdate,$todate);  
echo number_format(@$cash_postage_bill->postage_amount,2);
$sum_cash_postage_bill[] = @$cash_postage_bill->postage_amount;
?> </td>
                                        <!-- END  Domestic Postage Bill -->

                                        <!--  International Bill -->
    <td> <?php @$count_bill_int= $this->E_reports_Model->count_bill_internatioanl($branch,$fromdate,$todate); 
    echo @$count_bill_int; 
    $sum_count_bill_int[] = @$count_bill_int;
?> </td> 
<td> <?php $bill_int = $this->E_reports_Model->sum_bill_international($branch,$fromdate,$todate);  
echo number_format(@$bill_int->postage_amount,2);
$sum_bill_int[] = @$bill_int->postage_amount;
?> </td>
                                        <!--  End International Bill -->

                                        <!--  Pcum Bill -->
<td> <?php @$count_bill_pcum= $this->E_reports_Model->count_bill_pcum($branch,$fromdate,$todate); 
echo @$count_bill_pcum; 
$sum_count_bill_pcum[] = @$count_bill_pcum;
?> </td> 
<td> <?php $bill_pcum = $this->E_reports_Model->sum_bill_pcum($branch,$fromdate,$todate); 
 echo number_format(@$bill_pcum->postage_amount,2);
$sum_bill_pcum[] = @$bill_pcum->postage_amount;
?>  </td>
                                        <!--  End Pcum Bill -->

                                        
                                       </tr>
                                       <?php $sn++; } ?>


                                       <tr style="font-weight: bold;color: #000;">
                                        <td>  </td>
                                        <td> Total: </td>
        <td> <?php echo array_sum($sum_count_postage); ?> </td> <td> <?php echo number_format(array_sum($sum_cash_postage),2); ?> </td>
        <td> <?php echo array_sum($sum_count_cash_int); ?> </td> <td> <?php echo number_format(array_sum($sum_cash_int),2); ?> </td>
    <td> <?php echo array_sum($sum_count_cash_pcum); ?> </td> <td> <?php echo number_format(array_sum($sum_cash_pcum),2); ?> </td>
        <td> <?php echo array_sum($sum_count_pcargo); ?> </td> <td> <?php echo number_format(array_sum($sum_cash_pcargo),2); ?> </td>
         <td> <?php echo array_sum($sum_count_postage_bill); ?> </td> <td> <?php echo number_format(array_sum($sum_cash_postage_bill),2); ?> </td>
     <td> <?php echo array_sum($sum_count_bill_int); ?> </td> <td> <?php echo number_format(array_sum($sum_bill_int),2); ?> </td>
     <td> <?php echo array_sum($sum_count_bill_pcum); ?> </td> <td> <?php echo number_format(array_sum($sum_bill_pcum),2); ?> </td>
                                       </tr>

                                         <tr style="font-weight: bold;color: #000;">
                                        <td>  </td>
                                        <td colspan="15">
                                        Number of Transaction: 
<?php 
$alltrans = array_sum($sum_count_postage)+array_sum($sum_count_cash_int)+array_sum($sum_count_cash_pcum)+array_sum($sum_count_pcargo)+array_sum($sum_count_postage_bill)+array_sum($sum_count_bill_int)+array_sum($sum_count_bill_pcum);
echo number_format($alltrans);

?>
                                        </td>
                                       </tr>

                                       <tr style="font-weight: bold;color: #000;">
                                        <td>  </td>
                                        <td colspan="15">
                                        Revenue Generated: 
<?php 
$allrev = array_sum($sum_cash_postage) +  array_sum($sum_cash_int) + array_sum($sum_cash_pcum) + array_sum($sum_cash_pcargo) + array_sum($sum_cash_postage_bill) + array_sum($sum_bill_int) + array_sum($sum_bill_pcum);
echo number_format($allrev,2);

?>
                                        </td>
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