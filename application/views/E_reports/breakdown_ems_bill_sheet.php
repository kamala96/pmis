<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> TRANSACTION SUMMARY  </title> 
<style>
#t01 th, 
#t01 td {
  border: 1px solid black;
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
    <tr><th> BREAKDOWN TRANSACTION SUMMARY </th>
    </tr>
  </table>
  
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
      <tr><td style="text-align: right;"> Office Name: <?php echo $info->em_branch; ?> </td></tr>
      <tr><td style="text-align: right;font-size: 12px;"> </td></tr>
     
      
      </table>
    </td>
  </tr>
      
  </table>
  
   <table style="width: 100%;font-size: 14px;">
      <tr>
          <td style="text-align: right;"> Date: <?php echo date('d/m/Y');?> </td>
      </tr>
  </table>
      
      <table style="width: 100%;font-size: 10px;" id="t01">
                            
     <?php 
      $totalvat = 0;
      $totalprice = 0;
      $totalamount = 0;
      foreach($emslist as $data){
      $sender_region = $data->region;
      $acc_no = $this->session->userdata('account');
      $list = $this->E_reports_Model->breakdown_credit_customer_list_byAccnoMonth_list($acc_no,$sender_region,$month,$date);
      ?>

      <tr>
      <td colspan="9"> <strong>  <?php echo $data->region; ?> </strong>  <br><br> </td>
      </tr>
   
      <tr>
      <td><strong>S/N<strong></td>
      <td><strong>Addressee<strong></td>
      <td><strong>Barcode</strong></td>
      <td> <strong>Destination <strong></td>
      <td> <strong> Date <strong></td>
      <td> <strong>Weight<strong> </td>
      <td> <strong> Postage<strong> </td>
      <td> <strong> Vat<strong> </td>
      <td> <strong>Total<strong></td>
      </tr>


      <?php 
      $sn=1;
      $sumprice = 0;
      $sumvat = 0;
      $sumamount = 0;
      foreach ($list as $value) { ?>
       <tr>
       <td>  <?php echo $sn; ?> </td>
       <td style="width:10% !important;">  <?php echo $value->fullname; ?> </td>
       <td> <?php echo strtoupper(@$value->Barcode); ?> </td>
       <td> <?php echo $value->r_region; ?> </td>
       <td> <?php echo date("d/m/y", strtotime($value->date_registered))?> </td>
       <td> <?php echo $value->weight; ?> </td>
       <td> 
       <?php @$emsprice = (100*$value->paidamount)/118; echo number_format($emsprice,2); 
        $sumprice+=@$emsprice; 
        ?> 
       </td>
       <td> 
      <?php @$amount = $value->paidamount; 
       @$emsvat = @$amount - @$emsprice;
       $sumvat+=@$emsvat;
       echo number_format(@$emsvat,2);
       ?> 
       </td>
       <td>
        <?php 
        @$finalamount = $value->paidamount; echo number_format($finalamount,2);
        $sumamount+=@$finalamount;
        ?>
        </td>
         </tr>
     <?php  $sn++; } ?>

     <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td> <strong>  Subtotal </strong>  </td>
    <td> <strong>  <?php echo number_format(@$sumprice,2); ?> </strong>  </td>
    <td> <strong>  <?php echo number_format(@$sumvat,2); ?> </strong>  </td>
    <td> <strong>  <?php echo number_format(@$sumamount,2); ?> </strong>   </td>
     </tr>

      <?php 
      $totalvat+=@$sumvat;
      $totalprice+=@$sumprice;
      $totalamount+=@$sumamount;
       } 
       ?>

    <tr>
      <td colspan="9" style="background: #ccc;"> <br> </td>
    </tr>


    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td> <strong> Total </strong>  </td>
    <td> <strong> <?php echo number_format(@$totalvat,2); ?> </strong>  </td>
    <td> <strong> <?php echo number_format(@$totalprice,2); ?> </strong>  </td>
    <td><strong>   <?php echo number_format(@$totalamount,2); ?> </strong>  </td>
     </tr>

    
      </table>


</body>
</html>