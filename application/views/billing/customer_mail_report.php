<html>
<head>
    <title> Tanzania Posts Corporation (TPC) </title>  
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">
   <table class="table" style="width: 100%;">
     <tr>
        <th style="text-align: center;">
		<!-- <img src="assets/images/tcp.png" width="130" height="80"> -->
		 <!-- <img src="https://pmis.posta.co.tz/assets/images/tcp.png" height="100px" width="200px"/> -->
     <img src="assets/images/tcp.png" width="130" height="80">
		</th>
    </tr>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th>TRANSACTION SUMMARY </th>
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
  <br><br>
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
      <tr><td style="text-align: right;">Office Name : HEAD QUARTER CASHIER</td></tr>
      <tr><td style="text-align: right;">Date : <?php echo date('d/m/Y') ?></td></tr>
     <tr><td style="text-align: right;font-size: 12px;">VRN : 10-009045-V</td></tr>
      <tr> <td style="text-align: right;font-size: 12px;">Tin:100-206-072</td> </tr>
      </table>
    </td>
  </tr>
      
  </table>
  <br>
  <table style="width: 100%;">
      <!-- <tr><td></td><td style="text-align: right;font-size: 12px;">Invoice no: <?php echo $invoice; ?></td></tr> -->
      <tr><td style="font-size: 14px;">DR: TANZANIA POSTS CORPORATION</td></tr>
  </table>
  <table style="width: 100%;font-size: 10px;border-bottom: solid; 1px;border-top: solid;1px;">
     <thead>
      <tr>
      <td><strong>S/N<strong></td>
	   <td><strong>Addressee<strong></td>
       <td><strong>Barcode</strong></td>
       <td> <strong> Origin <strong></td>
       <td> <strong>Destination <strong></td>
	   <td> <strong>Registered Date <strong></td>
	   <td> <strong>Weight<strong> </td>
          <td> <strong> Postage<strong> </td>
         <td> <strong> Vat<strong> </td>
       <td> <strong>Total<strong></td>
       </tr>
     </thead>
     <tbody>
      <?php 
    $sn=1;
	  foreach ($emslist as $value) {?>
         <tr>
      <td>  <?php echo $sn; ?> </td>
		   <td>  <?php echo $value->receiver_fullname; ?> </td>
           <td> <?php echo $value->Barcode; ?> </td>
           <td> <?php echo $value->sender_region; ?> </td>
		   <td> <?php echo $value->reciver_branch; ?> </td>
		   <td> <?php echo date("d/m/y", strtotime($value->sender_date_created))?> </td>
		   <td> <?php echo $value->register_weght; ?> </td>
		   <td> 
       <?php @$emsprice = (100*$value->paidamount)/118; echo number_format($emsprice,2); 
       $sumprice[] = @$emsprice;
        ?> 
       </td>
       <td> 
      <?php @$amount = $value->paidamount; 
       @$emsvat = @$amount - @$emsprice;
       $sumvat[] = @$emsvat;
       echo number_format(@$emsvat,2);
       ?> 
       </td>
       <td>
        <?php 
        @$finalamount = $value->paidamount; echo number_format($finalamount,2);
        @$sumamount[] = @$finalamount;
         ?>
        </td>
         </tr>
     <?php $sn++; } ?>
     <tr>
       <td></td>
       <td></td>
       <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td></td>
     <td>  <strong> <?php echo number_format(array_sum($sumprice),2);?>  </strong> </td>
     <td> <strong> <?php echo number_format(array_sum($sumvat),2);?>  </strong> </td>
       <td> <strong> 
        <?php 
       if(!empty(@$finalamount)){
       echo number_format(array_sum(@$sumamount)); 
       }
       ?> <strong></td>
       </tr>
     </tbody>
     
  </table>
  <br>
  
  <!--
  <br>
  <table style="width: 100%;">
      <tr><td><b>Prepared by .....................</b></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><b>Checked by .....................</b></td><td><b>Authorised by....................</b></td></tr>
  </table>
-->
  
</body>
</html>