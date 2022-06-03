<!DOCTYPE html>
<html>
<head>
    <title> Bureau De Change Service Receipt </title>
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
     <tr>
        <th style="text-align: center;"><img src="assets/images/tcp.png" width="200" height="110"></th>
    </tr>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th>  Bureau De Change <?php echo @$transtype; ?> Receipt </th>
    </tr>
    <tr><td>Post Office: <?php echo @$empinfo->em_branch; ?> -  <?php echo @$empinfo->em_region; ?> </td></tr>
  </table>
  <br>
  <table style="border-bottom: solid; 1px;border-top: solid;1px;width: 100%;font-size: 14px;">
      <tr>
          <td>Telegraphic Address: POSTGEN</td>
          <td style="text-align: right;">OFFICE OF THE POSTMASTER GENERAL</td>
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
      
            
             <tr><td style="">Customer Name:  <?php echo @$info->customer_name; ?></td></tr>
             <tr><td style="">Customer Mobile: <?php echo @$info->customer_mobile; ?></td></tr>
      </table>

    </td>>
  </tr>
      
  </table>
  <br>
  <table style="width: 100%;">
     <tr><td></td><td style="text-align: right;font-size: 14px;">Printed Date: <?php echo date("d/m/Y"); ?></td></tr>
      <tr><td></td><td style="text-align: right;font-size: 14px;">Receipt No.: <?php echo @$info->receipt; ?></td></tr>
<tr><td></td><td style="text-align: right;font-size: 14px;">Transaction Date: <?php echo date("d/m/Y",strtotime(@$info->transaction_created_at)); ?> </td></tr>
      <tr><td style="font-size: 14px;"> TRANSACTION LIST </td><td style="text-align: right;font-size: 12px;">  </td></tr>

  </table>


  
                      <?php if(isset($list)){ ?>

                              <table style="width: 100%;font-size: 14px;" id="t01">
                               <thead>
                                   <tr>
                                   <th>S/N </th>
                                   <th> Currency </th>
                                   <th> Rate </th>
                                   <th> Exchange Amount</th>
                                   <th> Total </th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php $sn=1; foreach ($list as $value) { 
                                    ?>
                                           <tr>
                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo $value->currency_desc; ?></td>
                                           <td><?php $rate = $value->currency_rate; echo number_format($rate,2); ?></td>
                                           <td><?php $amount = $value->exchange_amount; echo number_format($amount,2); ?> </td>
                                           <td><?php $total = $rate * $amount; echo number_format($total,2); $sumtotal[] = $total; ?> </td>
                                       </tr>
                                   <?php $sn++; } ?>
                               </tbody>
                               <tr>
                               <td></td>
                                <td></td>
                                 <td></td>
                                  <td>Total: </td>
                                   <td><?php if(!empty($total)){ echo number_format(array_sum($sumtotal),2); }?></td>
                               </tr>
                           </table>
                         <?php } ?>




  <br>
  <!--
  <table style="width: 100%;">
      <tr><td>
          <text style="line-height: 30px;">Payments should be made to the Tanzania Post Corporation accounts through this Receipt number <b><?php echo $info->receipt; ?></text>
      </td></tr>
  </table>
  <br>
  -->

 <table style="width: 100%;">
      <tr><td><b>TRA Verification Code</b>&nbsp;&nbsp;<?php echo $signature->desc; ?></td><td><img src="assets/images/<?php echo $qrcodename;?>" width="50" height="50"></td></tr>
  </table>
  <br>
  <table style="width: 100%;">
      <tr><td colspan="2"><b>Prepared by</b> <?php echo @$preparedby ?></td></tr>
      <tr><td>&nbsp;</td></tr>
      <!-- <tr><td><b>Checked by .....................</b></td><td><b>Authorised by....................</b></td></tr> -->
  </table>
  
</body>
</html>