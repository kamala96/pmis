<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> TRANSACTION SUMMARY  </title> 
<style>
#t01 th, 
#t01 td {
  border: 1px solid black;
  padding: 5px;
}
#t01 {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">
   <table class="table" style="width: 100%;">
        <th style="text-align: center;">
    <!-- <img src="assets/images/tcp.png" width="130" height="80"> -->
      <img src="assets/images/tcp.png" height="100px" width="200px"/>
    </th>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th> COLLECTION TRANSACTION SUMMARY </th>
    </tr>
  </table>
  <br><br>
  
  <table style="border-bottom: solid; 1px;border-top: solid;1px;width: 100%;font-size: 14px;">
      <tr>
          <td>Telegraphic Address: POSTGEN</td>
          <td style="text-align: right;">POSTMASTER GENERAL</td>
      </tr>
      <tr>
          <td>Telex  : 41008 POSTGEN</td>
          <td style="text-align: right;">P.O.BOX  9551</td>
      </tr>
      <tr>
          <td>Telephone: (022)2118280 Fax (022)2113081</td>
          <td style="text-align: right;">DAR ES SALAAM</td>
      </tr>
      <tr>
          <td>Email: pmg@posta.co.tz</td>
          <td></td>
      </tr>
      <tr>
          <td>Website : www.posta.co.tz</td>
          <td></td>
      </tr>
  </table>

  <br>
  <table style="width: 100%;font-size: 14px;">
    <tr><td>
      <table style="width: 100%;font-size: 14px;">
        <tr><td>TO</td></tr>
      <tr><td style=""><?php if (!empty($custinfo->customer_name)) {
        echo @$custinfo->customer_name; 
      } else {
        echo @$custinfo->cust_name; 
      }
       ?></td></tr>
      
      <tr><td style="text-transform: uppercase;"><?php echo @$custinfo->customer_address . '  ' .@$custinfo->customer_region; ?></td></tr>
       <tr><td style="">VRN  :<?php echo @$custinfo->vrn; ?></td></tr>
        <tr><td style="">Tin :<?php echo @$custinfo->tin_number; ?></td></tr>
      </table>
    </td>
    <td>
      <table style="width: 100%;font-size: 14px;">
      <tr><td style="text-align: right;"> <b>Operator Name: </b> <?php echo $info->em_code; ?>  - <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </td></tr>
      <tr><td style="text-align: right;font-size: 12px;"> <b>Office : </b> <?php echo $info->em_branch;?> </td></tr>
     
      
      </table>
    </td>
  </tr>
      
  </table>
  <br>
  
   <table style="width: 100%;font-size: 14px;">
      <tr>
          <td style="text-align: right;"> Date: <?php echo date('d/m/Y');?> </td>
      </tr>
  </table>



<!-- EMS Cash -->
<?php if(!empty($emscashlist)){ ?>
 <table>
                                      
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Control Number  </th>
                                                <th> Barcode Number </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                      
                                    
                                       <?php  
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
                                                 //@$sumprice[] = @$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            //@$sumvat[] = @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 //@$sumamount[] = @$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>   </td>
                                        <td>  </td>
                                        <td> </td>
                                       </tr>   
                                      
                                    </table>
<?php } ?>

<!-- End of EMS Cash -->


<!-- EMS Bill -->
<?php if(!empty($emsbilllist)){ ?>
 <table>
                                     
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
                                      
                                    
                                       <?php  
                                       $sn=1;
                                       foreach ($emsbilllist as  $value) {  ?>
                                        <tr>
                                        <td> <?php echo $sn; ?></td>
                                        <td>    <?php echo $value->s_fullname; ?>  </td>
                                         <td>   <?php echo $value->Barcode; ?>    </td>
                                          <td>  <?php echo $value->weight; ?>     </td>
                                           <td>   <?php echo $value->branch; ?>    </td>
                                            <td>   <?php @$emsprice = (100*$value->paidamount)/118; echo number_format(@$emsprice,2); 
                                                 //@$sumprice[] = @$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            //@$sumvat[] = @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 //@$sumamount[] = @$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       <td> <?php //if(!empty(@$sumprice)){ echo number_format(array_sum(@$sumprice),2); } ?> </td>
                                        <td> <?php //if(!empty(@$sumvat)){ echo number_format(array_sum(@$sumvat),2);  } ?> </td>
                                        <td> <?php //if(!empty(@$sumamount)){ echo number_format(array_sum(@$sumamount),2); } ?> </td>
                                       </tr>   
                                    
                                    </table>
                                  <?php } ?>

<!-- End of EMS Bill -->


<!--- Cash Mails -->
<?php if(!empty($mailcashlist)){ ?>
 <table>
                                     
                                            <tr>
                                                <th> S/N </th>
                                                 <th> Control Number  </th>
                                                <th> Barcode Number </th>
                                                <th> Weight </th>
                                                <th> Destination </th>
                                                <th> Postage </th>
                                                <th> VAT </th>
                                                <th> Total </th>
                                            </tr>
                                      
                                      
                                       <?php  
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
                                                 //@$sumprice[] = @$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            //@$sumvat[] = @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                // @$sumamount[] = @$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> <?php //if(!empty(@$sumprice)){ echo number_format(array_sum(@$sumprice),2); } ?> </td>
                                        <td> <?php //if(!empty(@$sumvat)){ echo number_format(array_sum(@$sumvat),2);  } ?> </td>
                                        <td> <?php //if(!empty(@$sumamount)){ echo number_format(array_sum(@$sumamount),2); } ?> </td>
                                       </tr>   
                                    
                                    </table>
<?php } ?>
<!-- End of Cash Mails -->


<!-- Mail bill Report -->
<?php if(!empty($mailbilllist)){ ?>
 <table>
                                        
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
                                       
                                     
                                       <?php  
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
                                                 //@$sumprice[] = @$emsprice;
                                        ?>     </td>
                                             <td>   
                                            <?php @$amount = $value->paidamount; 
                                            @$emsvat = @$amount - @$emsprice;
                                            //@$sumvat[] = @$emsvat;
                                             echo number_format(@$emsvat,2);?>   
                                            </td>
                                            <td>   <?php @$finalamount = $value->paidamount; echo number_format(@$finalamount,2);
                                                 //@$sumamount[] = @$finalamount;
                                        ?>   </td>
                                       </tr>
                                       <?php $sn++; } ?> 

                                       <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>  </td>
                                        <td>  </td>
                                        <td>  </td>
                                       </tr>   
                                     
                                    </table>
                                  <?php } ?>

<!-- End of Bill Report -->



<!--- Delivery Registered (RDP,FPL) -->
<?php if(!empty($deliveryintlist)){ ?>
 <table>
                    
                                 
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
                                   
                                  
                               
                        
                                   <?php $sn=1; foreach ($deliveryintlist as $value) { ?>
                                       <tr>

                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->item; ?></td>
                                           <td><?php echo $value->Customer_mobile; ?></td>
                                           <td><?php echo $value->region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php @$amount = $value->paidamount; 
                                           //@$sumamount[] = @$amount; 
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
                                    <td>Total: </td>
                                    <td> </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                       
</table>
<?php } ?>

<!-- End of Delivery Registered (RDP,FPL) -->


<!-- Small Packets Delivery (FGN) -->

<?php if(!empty($smallpacketlist)){ ?>
 <table>
                     
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
                                   
                                  
                           
                            
                                   <?php $sn=1; foreach ($smallpacketlist as $value) { ?>
                                       <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $value->customer_name; ?></td>
                                    <td><?php echo $value->datetime; ?></td>
                                    <td><?php @$amount = $value->amount; 
                                        //@$sumamount[] = @$amount; 
                                        echo number_format(@$amount,2); ?> </td>
                                    <td><?php echo $value->region; ?></td>
                                    <td><?php echo $value->branch; ?></td>
                                    <td><?php echo $value->paychannel; ?></td>
                                    <td>
                                    <?php  //$paidamount=$value->paidamount;
                                           // $serial=$value->serial;
                                            //$this->Box_Application_model->getBillPayment($serial,$paidamount);
                                             echo $value->billid;?>       
                                    </td>
                                    <td> <?php echo $value->status; ?> </td>  
                                    </tr>
                                   <?php $sn++; } ?>

                                   <tr>
                                    <td></td>
                                    <td></td>
                                    <td>Total: </td>
                                    <td> </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                   </tr>
                                      
                               </table>
                             <?php } ?>


<!-- End of Small Packets Delivery (FGN) -->


</body>
</html>