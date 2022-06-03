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
    <tr><th> TRANSACTION SUMMARY </th>
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
      <tr><td style="text-align: right;"> Office Name: <?php echo $info->em_branch; ?> </td></tr>
      <tr><td style="text-align: right;font-size: 12px;"> </td></tr>
     
      
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
                                                       <table style="width: 100%;font-size: 14px;" id="t01">
                                                        <thead>
                            <tr>
                            <th> S/N </th>
                             <th> Date </th>
                            <th>  No.  </th>
                             <th> Postage  </th>
                             <th> Vat </th>
                             <th> Total </th>
                            </tr>
                            </thead>
                            <tbody>
                           
                            <?php
                            $sn = 1;
                            foreach($emslist as $data)
                            {
                            $date = $data->date;
                            $acc_no = $this->session->userdata('account');
                            $value = $this->E_reports_Model->get_transaction_summary($acc_no,$date);
                            ?>
                            
                            <tr>
                            <td>  <?php echo $sn; ?>  </td>
                            <td>  <?php echo date("d/m/Y",strtotime($date)); ?>  </td>
                            <td>  <?php $nooftrans=  $value->count_trans; echo $nooftrans;  $sum_no[] = $nooftrans; ?> </td>
                            <td> 
                            <?php 
                            //@$emsprice=$value->trans_amount;  
                             @$emsprice = (100*$value->trans_amount)/118; echo number_format($emsprice,2); 
                            $sumprice[] = @$emsprice;
                            ?>
                          </td>
                            <td> 
                            <?php @$amount = $value->trans_amount; 
                            @$emsvat = @$amount - @$emsprice;
                            $sumvat[] = @$emsvat;
                            echo number_format(@$emsvat,2);
                            ?> 
                            </td>
                            <td> 
                            <?php 
                            @$finalamount = $value->trans_amount; echo number_format($finalamount,2);
                            @$sumamount[] = @$finalamount;
                            ?>
                            </td>
                            </tr>
                            <?php $sn++; 
                            } 
                           ?>


                           <tr>
     
     <td></td>
     <td></td>
     <td> <strong> <?php echo number_format(array_sum($sum_no));?>  </strong> </td>
     <td>  <strong> <?php echo number_format(array_sum($sumprice),2);?>  </strong> </td>
     <td> <strong> <?php echo number_format(array_sum($sumvat),2);?>  </strong> </td>
       <td> <strong> 
        <?php 
       if(!empty(@$finalamount)){
       echo number_format(array_sum(@$sumamount),2); 
       }
       ?> <strong></td>
       </tr>

                            </tbody>
                                                        </table>
</body>
</html>