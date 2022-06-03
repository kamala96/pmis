<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> INVOICE SUMMARY  </title> 
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
    <tr><th>  <?php echo strtoupper(@$status); ?> INVOICE SUMMARY </th>
    </tr>
  </table>
  </table>
      <table class="table" style="width: 100%; text-align: center;">
    <tr><th>   From: <?php echo date("d/m/Y",strtotime($fromdate)); ?> To: <?php echo date("d/m/Y",strtotime($todate)); ?> </th>
    </tr>
  </table>
  <br>
  
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
      <tr>
          <td style="text-align: right;"> Printed date: <?php echo date('d/m/Y');?> </td>
      </tr>
  </table>
                            <table style="width: 100%;font-size: 11px;" id="t01">

                            <?php $gtotal=0; foreach($emslist as $data){ 
                            $region = $data->region_name;
                            $list = $this->E_reports_Model->list_pending_transaction($region,$fromdate,$todate,$status);

                            ?>

                            
                            <?php if($status=="Paid"){?>
                            <tr>
                            <th colspan="8">  <?php echo $region; ?>  </th>
                            </tr>
                            <?php } else { ?>
                            <tr>
                            <th colspan="6">  <?php echo $region; ?>  </th>
                            </tr>
                            <?php } ?>
                            

                            <tbody>
          
                            <tr>
                            <th>  S/N  </th>
                            <th>  Customer </th>
                             <th> Control Number  </th>
                            <th>  Amount   </th>
                             <th> Invoice Date   </th>
                             <th> Invoice Details </th>

                            <?php if($status=="Paid"){?>
                             <th> Payment date  </th>
                             <th> Pay Channel  </th>
                            <?php } ?>
                             
                            </tr>

                            <?php
                            $sn = 1;
                            $sumamount = 0;
                            foreach($list as $value)
                            {
                            $date = @$value->invoice_date;
                            $acc_no = $value->invcust_id;
                            $info= $this->Box_Application_model->get_bill_customer_details($acc_no);
                            ?>
                            <tr>
                            <td>  <?php echo $sn; ?>  </td>
                            <td>   <?php echo @$info->com_name; ?>  </td>
                            <td>  <?php echo @$value->billid; ?> </td>
                            <td>
                            <?php 
                            @$finalamount = $value->paidamount; echo number_format($finalamount,2);
                            $sumamount+=@$finalamount;
                            ?>
                             </td>
                             <td><?php echo date("d/m/Y",strtotime($date)); ?> </td>
                             <td><?php echo @$value->invoice_details;?></td>

                             <?php if($status=="Paid"){?>
                             <td><?php echo date("d/m/Y",strtotime(@$value->paymentdate)); ?> </td>
                             <td>  <?php echo @$value->paychannel; ?> </td>
                             <?php } ?>

                            </tr>
                            <?php $sn++; 
                             } 
                            ?>

 <?php if($status=="Paid"){?>
        <tr>
       <td></td>
       <td></td>
       <td> <strong> Total </strong> </td>
       <td> <strong> 
        <?php 
       if(!empty(@$sumamount)){
       echo number_format(@$sumamount,2); 
       }
       $gtotal+=@$sumamount;
       ?> <strong>
       </td>
       <td></td>
       <td></td>
       <td></td>
       <td></td>
       </tr>
<?php } else { ?>

        <tr>
       <td></td>
       <td></td>
       <td> <strong> Total </strong> </td>
       <td> <strong> 
        <?php 
       if(!empty(@$sumamount)){
       echo number_format(@$sumamount,2); 
       }
       $gtotal+=@$sumamount;
       ?> <strong>
       </td>
       <td></td>
       <td></td>
       </tr>

<?php } ?>
        


                           <?php } ?>

                       
                       <?php if($status=="Paid"){?>
                             <tr>
                              <td colspan="8">
                             <strong> General Amount of <?php echo @$status; ?> Invoice: <?php echo number_format(@$gtotal,2); ?> </strong>
                           </td></tr>
                        <?php } else { ?>
                         <tr>
                              <td colspan="6">
                             <strong> General Amount of <?php echo @$status; ?> Invoice: <?php echo number_format(@$gtotal,2); ?> </strong>
                           </td></tr>
                        <?php } ?>


                              

                           
                         

       

      

</tbody>
</table>
</body>
</html>