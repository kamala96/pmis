<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Consolidated Report  </h3>
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
                       
                            <form class="row" method="post" action="<?php echo site_url('Collection_Report/print_consolidated_report');?>">
                                    <div class="form-group col-md-4 m-t-10">
                                    <input type="text" name="fromdate" class="form-control mydatetimepickerFull" placeholder="From Date" required="required">
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                         <input type="text" name="todate" class="form-control mydatetimepickerFull" placeholder="To Date" required="required">
                                    </div>

                                    <div class="form-group col-md-4 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>


<?php if(isset($employeelist)){ ?>

 <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

<div class="panel-footer text-center">
<img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/>
<br>
<h3> <strong> CONSOLIDATED REPORT (TRANSACTION SUMMARY) </strong> </h3>
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

<?php } ?>



<!-- STRUCTURE OF REPORT -->

<?php if(!empty($employeelist)){ ?>


 <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">

<?php $sumreport=0; foreach($employeelist as $data){
///////EMS===cash-Paid bill-Bill
///////MAILS==cash-SUCCESS bill-BILLING
$emscashlist = $this->Collection_Model->get_ems_consolidated_report($fromdate,$todate,$data->em_id,$data->em_region,$data->em_branch,$status="Paid");
$emsbilllist = $this->Collection_Model->get_ems_consolidated_report($fromdate,$todate,$data->em_id,$data->em_region,$data->em_branch,$status="Bill");
$mailcashlist = $this->Collection_Model->get_mails_consolidated_report($fromdate,$todate,$data->em_id,$data->em_region,$data->em_branch,$status="SUCCESS");
$mailbilllist = $this->Collection_Model->get_mails_consolidated_report($fromdate,$todate,$data->em_id,$data->em_region,$data->em_branch,$status="BILLING");
?>
<tr>
<th colspan="8"> <?php echo @$data->first_name.' '.@$data->middle_name.' '.@$data->last_name; ?> | PF Number: <?php echo @$data->em_code; ?> | Branch: <?php echo @$data->em_branch; ?>  </th>
</tr>

                                           <!-- EMS CASH TRANSACTION LIST -->
                                            <tr>
                                            <th colspan="8"> EMS CASH TRANSACTION LIST </th>
                                            </tr>
                                      
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Control Number  </th>
                                                <th> Barcode </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                      
                                    
                                       <?php  
                                       $emscashpostage = 0;
                                       $emscashvat = 0;
                                       $emscashtotal = 0;
                                       $sn=1;
                                       foreach ($emscashlist as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo $value->billid; ?>  </td>
                                         <td>  
                                          <?php 
                                         if($value->PaymentFor=='EMS_INTERNATIONAL'){
                                         echo ucfirst($value->barcode); 
                                         }
                                         else{
                                         echo ucfirst($value->Barcode); 
                                           }

                                         ?> 
                                        </td>
                                          <td>  <?php echo $value->weight; ?>     </td>
                                           <td>   
                                            <?php 
                                            if($value->PaymentFor=='EMS_INTERNATIONAL'){
                                             $countrycode = $value->r_region;
                                             $countryinfo = $this->Collection_Model->get_country_info($countrycode);
                                             echo $countryinfo->country_name;
                                             }
                                             else{
                                           echo $value->branch; 
                                             }
                                             ?>    
                                          </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 @$emscashpostage+=@$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            $emscashvat+=@$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 $emscashtotal+=@$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total: </td>
                                        <td> <?php echo number_format(@$emscashpostage,2); ?>  </td>
                                        <td> <?php echo number_format(@$emscashvat,2); ?>   </td>
                                        <td> <?php echo number_format(@$emscashtotal,2); ?> </td>
                                       </tr>


<!-- END OF CASH TRANSACTION LIST -->


<!-- BILL EMS TRANSACTION LIST -->
                                           <tr>
                                            <th colspan="8"> EMS BILL TRANSACTION LIST </th>
                                            </tr>                        
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Customer Name  </th>
                                                <th> Barcode </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                      
                                    
                                       <?php 
                                       $emsbillpostage = 0;
                                       $emsbillvat = 0;
                                       $emsbilltotal = 0; 
                                       $sn=1;
                                       foreach ($emsbilllist as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo $value->s_fullname; ?>  </td>
                                         <td>   <?php echo $value->Barcode; ?>    </td>
                                          <td>  <?php echo $value->weight; ?>     </td>
                                           <td>   <?php echo $value->branch; ?>    </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 @$emsbillpostage+=@$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            @$emsbillvat+=@$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 @$emsbilltotal+=@$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total: </td>
                                        <td> <?php echo number_format(@$emsbillpostage,2); ?>  </td>
                                        <td> <?php echo number_format(@$emsbillvat,2); ?>   </td>
                                        <td> <?php echo number_format(@$emsbilltotal,2); ?> </td>
                                       </tr>


<!-- CASH MAIL TRANSACTION LIST -->

                                            <tr>
                                            <th colspan="8"> MAILS CASH TRANSACTION LIST </th>
                                            </tr>
                                     
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Control Number  </th>
                                                <th> Barcode </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                      
                                      
                                       <?php 
                                       $mailcashpostage = 0;
                                       $mailcashvat = 0;
                                       $mailcashtotal = 0;  
                                       $sn=1;
                                       foreach ($mailcashlist as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo $value->billid; ?>  </td>
                                         <td>   <?php echo $value->Barcode; ?>    </td>
                                          <td>  <?php echo $value->register_weght; ?>     </td>
                                           <td>   
                                            <?php
                                             if(is_numeric($value->reciver_branch)){
                                                 echo $value->receiver_region;
                                             }
                                             else{
                                               echo $value->reciver_branch; 
                                             }
                                              ?> 

                                            </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 @$mailcashpostage+=@$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            @$mailcashvat+= @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                @$mailcashtotal+=@$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total </td>
                                        <td> <?php echo number_format(@$mailcashpostage,2); ?> </td>
                                        <td> <?php echo number_format(@$mailcashvat,2); ?> </td>
                                        <td> <?php echo number_format(@$mailcashtotal,2); ?> </td>
                                       </tr>  
<!-- END OF CASH MAIL TRANSACTION LIST -->


<!-- BILL MAIL TRANSACTION LIST -->
                                            <tr>
                                            <th colspan="8"> MAILS BILL TRANSACTION LIST </th>
                                            </tr>
                                        
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Customer Name  </th>
                                                <th> Barcode </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                       
                                     
                                       <?php 
                                       $mailbillpostage = 0;
                                       $mailbillvat = 0;
                                       $mailbilltotal = 0;  
                                       $sn=1;
                                       foreach ($mailbilllist as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo $value->sender_fullname; ?>  </td>
                                         <td>   <?php echo $value->Barcode; ?>    </td>
                                          <td>  <?php echo $value->register_weght; ?>     </td>
                                           <td>   
                                            <?php
                                             if(is_numeric($value->reciver_branch)){
                                                 echo $value->receiver_region;
                                             }
                                             else{
                                               echo $value->reciver_branch; 
                                             }
                                              ?> 

                                            </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 @$mailbillpostage+=@$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            @$mailbillvat+=@$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 @$mailbilltotal+=@$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total </td>
                                        <td> <?php echo number_format(@$mailbillpostage,2); ?> </td>
                                        <td> <?php echo number_format(@$mailbillvat,2); ?> </td>
                                        <td> <?php echo number_format(@$mailbilltotal,2); ?> </td>
                                       </tr> 
<!-- END OF BILL MAIL TRANSACTION LIST -->

<!-- EMPLOYEE AMOUNT -->
 <tr>
<th colspan="8"> Employee Total Amount: 
<?php $alltotal = @$emscashtotal+@$emsbilltotal+@$mailcashtotal+@$mailbilltotal;
$sumreport+=$alltotal;
echo number_format(@$alltotal,2);
?> 
</th>
</tr>
<!-- END OF AMOUNT OF EMPLOYEE -->


<?php } ?>


<!-- EMPLOYEE AMOUNT -->
 <tr>
<th colspan="8"> Report Total Amount: 
<?php 
echo number_format(@$sumreport,2);
?> 
</th>
</tr>
<!-- END OF AMOUNT OF EMPLOYEE -->


 </table>



<?php } ?>




                          

</div>


<!-- End of Small Packets Delivery (FGN) -->
                                       
                                           
                                        
                                            
                            
                               
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