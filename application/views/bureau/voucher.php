<!DOCTYPE html>
<html>
<head>
    <title> <?php echo strtoupper(@$vouchertype); ?>  </title>
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
        <th style="text-align: center;"><img src="assets/images/tcp.png" width="200" height="100"></th>
    </tr>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th>  <?php echo strtoupper(@$vouchertype); ?> </th>
    </tr>
  </table>
  <br><br>
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
  <table style="width: 100%;">
      <tr><td></td><td style="text-align: right;font-size: 14px;">Printed Date.: <?php echo date("d/m/Y"); ?></td></tr>
      <tr><td></td><td style="text-align: right;font-size: 14px;">Transaction From:  <?php echo @$fromdate; ?>  To: <?php echo @$todate; ?></td></tr>
      <tr><td style="font-size: 14px;"> TRANSACTION LIST </td><td style="text-align: right;font-size: 12px;">  </td></tr>

  </table>


  
                      <?php if(isset($list)){ ?>

                              <table style="width: 100%;font-size: 14px;" id="t01">
                               <thead>
                                   <tr>
                                   <th>S/N </th>
                                   <th> <?php echo @$debit; ?> </th>
                                   <th> <?php echo @$credit; ?> </th>
                                   <th> Currency </th>
                                   <th> Amount</th>
                                   <th> Description </th>
                                   <th> Created at </th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php $sn=1; $sumamount=0; foreach($list as $value) {  ?>
                                           <tr>
                                           <td><?php echo $sn; ?></td>
                                           <td><?php echo @$value->debit; ?></td>
                                           <td><?php echo @$value->credit; ?></td>
                                           <td><?php echo @$value->currency; ?></td>
                                           <td><?php $sumamount+=$value->amount; echo number_format(@$value->amount,2); ?></td>
                                           <td><?php echo $value->description; ?> </td>
                                           <td><?php echo $value->account_created_at; ?> </td>
                                       </tr>
                                   <?php $sn++; } ?>
                               </tbody>
                               <tr>
                               <td></td>
                                <td></td>
                                 <td></td>
                                  <td>Total: </td>
                                   <td><?php echo number_format(@$sumamount,2); ?></td>
                                   <td></td>
                                   <td></td>
                               </tr>
                           </table>
                         <?php } ?>

 <br>
  <table style="width: 100%;">
      <tr><td colspan="2"><b>Prepared by</b> <?php echo @$preparedby ?></td></tr>
  </table>
  
</body>
</html>