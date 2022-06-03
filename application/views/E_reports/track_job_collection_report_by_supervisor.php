<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Collection Report  </h3>
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
                    
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Box_Application/Ems_Application_Pending_Supervisor?I=<?php echo base64_encode($this->session->userdata('getempid')); ?>" class="text-white"><i class="" aria-hidden="true"></i>  Transaction Dashboard </a></button>

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
                       
                            <form class="row" method="post" action="<?php echo site_url('Collection_Report/track_jobs_collection_report');?>">

                            <input type="hidden" name="empid" class="form-control" value="<?php echo @$empid; ?>">

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


 <?php if(isset($emscashlist) || isset($emsbilllist) || isset($mailcashlist) || isset($mailbilllist) || isset($deliveryintlist)  || isset($smallpacketlist) || isset($boxtranslist) || isset($stamptranslist) || isset($authoritetranslist) || isset($locktranslist) || isset($internettranslist)){ ?>

 <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
 <div class="table-responsive" id="div1">

<div class="panel-footer text-center">
<img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/>
<br>
<h3> <strong> COLLECTION TRANSACTION SUMMARY </strong> </h3>
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




                            <!-- EMS Cash -->
<?php if(!empty($emscashlist)){ ?>
 <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">

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
                                      
                                    </table>
<br>
<?php } ?>

<!-- End of EMS Cash -->


<!-- EMS Bill -->
<?php if(!empty($emsbilllist)){ ?>
<table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">   
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
                                    
                                    </table>
                                    <br>
                                  <?php } ?>

<!-- End of EMS Bill -->


<!--- Cash Mails -->
<?php if(!empty($mailcashlist)){ ?>
<table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">

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
                                    
                                    </table>
                                    <br>
<?php } ?>
<!-- End of Cash Mails -->


<!-- Mail bill Report -->
<?php if(!empty($mailbilllist)){ ?>
<table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">

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
                                     
                                    </table>
                                    <br>
                                  <?php } ?>

<!-- End of Bill Report -->



<!--- Delivery Registered (RDP,FPL) -->
<?php if(!empty($deliveryintlist)){ ?>
<table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                <tr>
                                <th colspan="10"> DELIVERY REGISTERED (RDP,FPL) TRANSACTION LIST </th>
                                </tr>
                    
                                  
                                <tr>
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
                                  </tr>
                                   
                                  
                               
                        
                                   <?php $sumdelivery=0; $sn=1; foreach ($deliveryintlist as $value) { ?>
                                       <tr>

                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->Customer_mobile; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php @$amount = $value->paidamount; 
                                           $sumdelivery+=@$amount; 
                                           echo number_format(@$amount,2); ?> </td>
                                           <td>  <?php  echo $value->billid;   ?>  </td>
                                           <td><?php echo $value->paychannel; ?></td>
                                           <td><?php echo $value->paymentdate; ?></td>
                                           <td><?php echo $value->status; ?> </td>
                                          
                                           
                                       </tr>
                                   <?php $sn++; } ?>

                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td> <?php echo number_format(@$sumdelivery,2); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                       
</table>
<br> 
<?php } ?>

<!-- End of Delivery Registered (RDP,FPL) -->


<!-- Small Packets Delivery (FGN) -->

<?php if(!empty($smallpacketlist)){ ?>
<table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">


                                <tr>
                                <th colspan="10"> SMALL PACKETS DELIVERY (FGN) TRANSACTION LIST </th>
                                </tr>
                     
                                <tr> 
                               <th> S/N </th>
                               <th>Customer Name</th>
                              <th>Date Registered</th>
                              <th>Price</th>
                              <th>Region Origin</th>
                              <th>Branch</th>
                              <th>Payment Channel</th>
                              <th>Control No</th>
                              <th>Pay Status</th>
                             </tr>
                                   
                                  
                           
                            
                                   <?php $sumpacket=0; $sn=1; foreach ($smallpacketlist as $value) { ?>
                                       <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $value->customer_name; ?></td>
                                    <td><?php echo $value->datetime; ?></td>
                                    <td><?php @$amount = $value->amount; 
                                        $sumpacket+=@$amount; 
                                        echo number_format(@$amount,2); ?> </td>
                                    <td><?php echo $value->region; ?></td>
                                    <td><?php echo $value->branch; ?></td>
                                    <td><?php echo @$value->paychannel; ?></td>
                                    <td>
                                    <?php  //$paidamount=$value->paidamount;
                                           // $serial=$value->serial;
                                            //$this->Box_Application_model->getBillPayment($serial,$paidamount);
                                             echo @$value->billid;?>       
                                    </td>
                                    <td> <?php echo $value->status; ?> </td>  
                                    </tr>
                                   <?php $sn++; } ?>

                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>  <?php echo number_format(@$sumpacket,2); ?> </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                      
                               </table>  <br>
                             <?php } ?>


<!-- Box or Physical Box -->
<?php if(!empty($boxtranslist)){?>

 <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                <tr>
                                <th colspan="12"> BOX TRANSACTION LIST </th>
                                </tr>

                                       
                                            <tr>
                                                <th>S/N</th>
                                                <th>Customer Name</th>
                                                <th>Registered date</th>
                                                <th>Mobile No.</th>
                                                <th>Amount(Tsh.)</th>
                                                <th>Bill Number</th>
                                                <th>Region </th>
                                                 <th>Branch </th>
                                                <th>Box Number</th>
                                                <th>Payment Date</th>
                                                <th>Payment Channel</th>
                                                <th> Pay Status </th>
                                            </tr>
                                        
                                
                                           <?php $sumbox=0; $sn=1; foreach($boxtranslist as $value){ 
                                            $box_status =$this->Collection_Model->box_status($value->details_cust_id); 
                                            ?>
                                            <tr>
                                                <td><?php echo $sn; ?> </td>
                                                <td><?php echo $value->cust_name; ?> </td>
                                                <td><?php echo $value->transactiondate; ?></td>
                                                <td><?php echo $value->Customer_mobile; ?></td>
                                                <td> <?php $amount = $value->paidamount; echo number_format($amount,2); 
                                                 $sumbox+=@$amount;
                                                 ?></td>
                                                <td> <?php  echo @$value->billid;  ?> </td>
                                                <td><?php echo $value->region; ?></td>
                                                <td><?php echo $value->district; ?></td>
                                                <td>

                                                  <?php if (!is_null(@$box_status)){?>
                                                    <?php echo @$box_status->box_number; ?>
                                                  <?php   } else { ?>
                                                 <?php   } ?>

                                                 </td>

                                                <td>
                                                <?php if (@$value->paymentdate == '') {
                                                    
                                                } else {
                                                     echo date('d/m/Y', strtotime($value->paymentdate));
                                                }
                                                ?>
                                               </td>
                                                <td><?php echo @$value->paychannel; ?></td>

                                                <td>
                                                <?php echo $value->status; ?>
                                                </td>

                                            </tr>
                                            <?php $sn++; } ?>

                                    <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>  <?php echo number_format(@$sumbox,2); ?> </td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                       
                                        
                                 </table> <br>


<?php } ?>

<!-- End of Physical Box -->



<?php if(!empty($stamptranslist)){?>

 <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                <tr>
                                <th colspan="11"> STAMP TRANSACTION LIST </th>
                                </tr>
                                   
                                   <th>S/N</th>
                                   <th>Operator</th>
                                   <th>Customer Mobile</th>
                                   <th>Stamp Details</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>
                                   <th>Bill Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Pay Status</th>
                                   
                           
                                   <?php $sumstamp=0; $sn=1; foreach ($stamptranslist as $value) { ?>
                                       <tr>
                                          <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->Operator; ?></td>
                                           <td><?php echo $value->Customer_mobile; ?></td>
                                           <td><?php echo $value->StampDetails; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php $amount = $value->paidamount; $sumstamp+=$amount; echo number_format($amount,2); ?></td>
                                           <td> <?php echo @$value->billid; ?> </td>
                                           <td><?php echo @$value->paychannel; ?></td>
                                           <td><?php echo @$value->paymentdate; ?></td>
                                           <td><?php echo $value->status; ?> </td>
                                          
                                           
                                       </tr>
                                   <?php $sn++; } ?>
                                   
                             
                                    <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>  <?php echo number_format(@$sumstamp,2); ?> </td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>

                           </table> <br>


<?php } ?>


<!-- Lock Replacement Transaction -->
<?php if(!empty($locktranslist)){ ?>
<table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                <tr>
                                <th colspan="11"> LOCK TRANSACTION LIST </th>
                                </tr>
                         
                                   <th> S/N </th>
                                   <th>Operator</th>
                                   <th>Operator Mobile</th>
                                   <th>Item</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>
                                   <th>Bill Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   
                                  
                           
                                   <?php $sumlock=0; $sn=1;  foreach($locktranslist as $value){ ?>
                                           
                                           <tr>
                                           <td> <?php echo $sn; ?></td>
                                           <td><?php echo 'PF '.$value->Operator; ?></td>
                                           <td><?php echo $value->Customer_mobile; ?></td>
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php $amount = $value->paidamount; $sumlock+=$amount; echo number_format($amount,2); ?></td>
                                           <td> <?php echo @$value->billid; ?> </td>
                                           <td><?php echo @$value->paychannel; ?></td>
                                           <td><?php echo @$value->paymentdate; ?></td>
                                           <td><?php echo $value->status; ?> </td>
                                           </tr>

                                   <?php $sn++; } ?>

                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>  <?php echo number_format(@$sumlock,2); ?> </td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                         

                           </table> <br>
<?php } ?>
<!-- eND Lock Replacement Transaction -->

<!-- AuthorityCard Transaction List -->
<?php if(!empty($authoritetranslist)){ ?>

 <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                <tr>
                                <th colspan="11"> AUTHORITECARD TRANSACTION LIST </th>
                                </tr>
                          
                                   <th> S/N</th>
                                   <th>Operator</th>
                                   <th>Operator Mobile</th>
                                   <th>Item</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>
                                   <th>Bill Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   
                        
                                   <?php $sumauthorite=0; $sn=1;  foreach($authoritetranslist as $value) { ?>
                                       <tr>
                                           <td><?php echo $sn; ?> </td>
                                           <td><?php echo 'PF '.$value->Operator; ?> </td>
                                           <td><?php echo $value->Customer_mobile; ?> </td>
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php $amount = $value->paidamount; $sumauthorite+=$amount; echo number_format($amount,2); ?></td>
                                           <td> <?php echo @$value->billid; ?> </td>
                                           <td><?php echo @$value->paychannel; ?></td>
                                           <td><?php echo @$value->paymentdate; ?></td>
                                           <td><?php echo $value->status; ?> </td> 
                                       </tr>
                                   <?php $sn++; } ?>

                                    <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>  <?php echo number_format(@$sumauthorite,2); ?> </td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                   
                            
                           </table>

<?php } ?>
<!-- End of AuthorityCard Transaction List -->


<!-- Internet Transaction List -->
<?php if(!empty($internettranslist)){ ?>

 <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">

                                <tr>
                                <th colspan="11"> INTERNET TRANSACTION LIST </th>
                                </tr>
                          
                                   <th> S/N</th>
                                   <th>Operator</th>
                                   <th>Operator Mobile</th>
                                   <th>Item</th>
                                   <th>Region</th>
                                   <th>Branch</th>
                                   <th>Amount</th>
                                   <th>Bill Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   
                        
                                   <?php $suminternet=0; $sn=1;  foreach($internettranslist as $value) { ?>
                                       <tr>
                                           <td><?php echo $sn; ?> </td>
                                           <td><?php echo 'PF '.$value->Operator; ?> </td>
                                           <td><?php echo $value->Customer_mobile; ?> </td>
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php $amount = $value->paidamount; $suminternet+=$amount; echo number_format($amount,2); ?></td>
                                           <td> <?php echo @$value->billid; ?> </td>
                                           <td><?php echo @$value->paychannel; ?></td>
                                           <td><?php echo @$value->paymentdate; ?></td>
                                           <td><?php echo $value->status; ?> </td> 
                                       </tr>
                                   <?php $sn++; } ?>

                                    <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td>  <?php echo number_format(@$suminternet,2); ?> </td>
                                    <td></td>
                                     <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                   
                            
                           </table>

<?php } ?>
<!-- End of Internet Transaction List -->



                         <?php if(isset($emscashlist) || isset($emsbilllist) || isset($mailcashlist) || isset($mailbilllist) || isset($deliveryintlist)  || isset($smallpacketlist) || isset($boxtranslist) || isset($stamptranslist) || isset($authoritetranslist) || isset($locktranslist) || isset($internettranslist)){ ?>

                             <br>
                              
                             <table class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <tr>
                               <th colspan="8"> Collection Amount: 
                             <?php $alltotal = @$emscashtotal+@$emsbilltotal+@$mailcashtotal+@$mailbilltotal+@$sumdelivery+@$sumpacket+@$sumbox+@$sumstamp+@$sumauthorite+@$sumlock+@$suminternet; 
                              echo number_format(@$alltotal,2);
                              ?> 
                             </th>
                              </tr>
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