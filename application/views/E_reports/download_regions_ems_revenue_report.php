<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> Revenue Collection Report  </title>	
<style>
#t01 th, 
#t01 td {
	border: 1px solid black;
	padding: 5px;
  width: 10px !important;
  word-break: break-all !important;
  table-layout: fixed !important;
}
#t01 {
	border: 1px solid black;
	border-collapse: collapse;
}

#t01 tr:before {
    display: inline-block;
    -webkit-transform: rotate(-90deg);
    transform: rotate(-90deg);
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
              <tr>
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th> REVENUE COLLECTION <?php echo strtoupper($report); ?> REPORT 
    </th>
    </tr>
  </table>

    <table class="table" style="width: 100%; text-align: center;">
    <tr><th> 
     <?php if($report=="Daily"){?>
      <?php echo date("d/m/Y",strtotime($date)); ?>
    
  <?php } elseif($report=="Weekly"){?>
     From: <?php echo date("d/m/Y",strtotime($fromdate)); ?> To: <?php echo date("d/m/Y",strtotime($todate)); ?>
    
  <?php } else{ ?>
   Month: <?php echo $month; ?> Year: <?php echo $year; ?> 
  <?php } ?>
    </th>
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
  
   <table style="width: 100%;font-size: 14px;">

      <tr>
          <td style="text-align: right;"> Printed date: <?php echo date('d/m/Y');?> </td>
      </tr>
  </table>
                         

                                      <table style="width: 100%;font-size: 14px;" id="t01" style="table-layout: fixed !important;">
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


                                       
                                       <?php
                                       foreach($emslist as $value){
                                       $regionid = $value->region_id;
                                       $regionbranch = $this->E_reports_Model->get_region_branch($regionid);
                                       ?>

                                       <tr>

                                       <td colspan="2"> <?php echo $value->region_name; ?> </td>
                                      

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
                                        <td> No </td> <td width="5%"> Amount </td>
                                        <td> No </td> <td width="5%"> Amount </td>
                                        <td> No </td> <td width="5%"> Amount </td>
                                        <td> No </td> <td width="5%"> Amount </td>
                                        <td> No </td> <td width="5%"> Amount </td>
                                        <td> No </td> <td width="5%"> Amount </td>
                                        <td> No </td> <td width="5%"> Amount </td>
                                       </tr>
                                        
                                        <?php 
                                        $sn =1;
                                        $sum_count_postage=0; $sum_cash_postage=0;
                                        $sum_count_cash_int=0; $sum_cash_int=0;
                                        $sum_count_cash_pcum=0; $sum_cash_pcum=0;
                                        $sum_count_pcargo=0; $sum_cash_pcargo=0;
                                        $sum_count_postage_bill=0; $sum_cash_postage_bill=0;
                                        $sum_count_bill_int=0; $sum_bill_int=0;
                                        $sum_count_bill_pcum=0; $sum_bill_pcum=0;
                                        foreach ($regionbranch as $data) { 
                                        $branch = $data->branch_name;
                                        ?>
                                        <tr>
                                         <td> <?php echo $sn; ?> </td>
                                        <td> <?php echo $branch; ?> </td>

                                        <!--  Domestic Postage Cash -->
    <td> <?php @$count_postage= $this->E_reports_Model->count_domestic_postage($branch,$fromdate,$todate,$date,$month,$year,$report); 
    echo @$count_postage; 
    $sum_count_postage+=@$count_postage; ?> 
    </td> 

    <td>
    <?php $cash_postage = $this->E_reports_Model->sum_domestic_postage($branch,$fromdate,$todate,$date,$month,$year,$report);  
    echo number_format(@$cash_postage->postage_amount,2);
    $sum_cash_postage+=@$cash_postage->postage_amount;
    ?> 
   </td>
                                         <!-- END  Domestic Postage Cash -->

                                        <!--  International Cash -->
<td> <?php @$count_cash_int= $this->E_reports_Model->count_cash_international($branch,$fromdate,$todate,$date,$month,$year,$report); 
    echo @$count_cash_int; 
    $sum_count_cash_int+=@$count_cash_int;
    ?> 
</td> 

<td> <?php $cash_int = $this->E_reports_Model->sum_cash_international($branch,$fromdate,$todate,$date,$month,$year,$report);  
echo number_format(@$cash_int->postage_amount,2);
$sum_cash_int+= @$cash_int->postage_amount;
?> 
</td>
                                        <!--  End International Cash -->

                                        <!--  Pcum Cash -->
 <td> <?php @$count_cash_pcum= $this->E_reports_Model->count_cash_pcum($branch,$fromdate,$todate,$date,$month,$year,$report); 
 echo @$count_cash_pcum; 
$sum_count_cash_pcum+=@$count_cash_pcum;
?>
</td> 
<td> <?php $cash_pcum = $this->E_reports_Model->sum_cash_pcum($branch,$fromdate,$todate,$date,$month,$year,$report);  
echo number_format(@$cash_pcum->postage_amount,2);
$sum_cash_pcum+=@$cash_pcum->postage_amount;
?>  </td>
                                        <!--  End Pcum Cash -->

                                         <!--  Post Cargo Cash -->
    <td> <?php @$count_cash_pcargo= $this->E_reports_Model->count_cash_emscargo($branch,$fromdate,$todate,$date,$month,$year,$report); 
    echo @$count_cash_pcargo; 
    $sum_count_pcargo+= @$count_cash_pcargo;
    ?>  
   </td> 

<td> <?php $cash_pcargo = $this->E_reports_Model->sum_cash_emscargo($branch,$fromdate,$todate,$date,$month,$year,$report); 
 echo number_format(@$cash_pcargo->postage_amount,2);
$sum_cash_pcargo+= @$cash_pcargo->postage_amount;
?> 
</td>
                                         <!--  Post Cargo Cash -->

                                        <!--  Domestic Postage Bill -->
<td> <?php @$count_postage_bill = $this->E_reports_Model->count_domestic_bill_postage($branch,$fromdate,$todate,$date,$month,$year,$report); 
echo @$count_postage_bill; 
$sum_count_postage_bill+= @$count_postage_bill;
?> </td> 
<td><?php $cash_postage_bill = $this->E_reports_Model->sum_domestic_bill_postage($branch,$fromdate,$todate,$date,$month,$year,$report);  
echo number_format(@$cash_postage_bill->postage_amount,2);
$sum_cash_postage_bill+= @$cash_postage_bill->postage_amount;
?> </td>
                                        <!-- END  Domestic Postage Bill -->

                                        <!--  International Bill -->
    <td> <?php @$count_bill_int= $this->E_reports_Model->count_bill_international($branch,$fromdate,$todate,$date,$month,$year,$report); 
    echo @$count_bill_int; 
    $sum_count_bill_int+= @$count_bill_int;
?> </td> 
<td> <?php $bill_int = $this->E_reports_Model->sum_bill_international($branch,$fromdate,$todate,$date,$month,$year,$report);  
echo number_format(@$bill_int->postage_amount,2);
$sum_bill_int+= @$bill_int->postage_amount;
?> </td>
                                        <!--  End International Bill -->

                                        <!--  Pcum Bill -->
<td> <?php @$count_bill_pcum= $this->E_reports_Model->count_bill_pcum($branch,$fromdate,$todate,$date,$month,$year,$report); 
echo @$count_bill_pcum; 
$sum_count_bill_pcum+= @$count_bill_pcum;
?> </td> 
<td> <?php $bill_pcum = $this->E_reports_Model->sum_bill_pcum($branch,$fromdate,$todate,$date,$month,$year,$report); 
 echo number_format(@$bill_pcum->postage_amount,2);
$sum_bill_pcum+= @$bill_pcum->postage_amount;
?>  </td>
                                        <!--  End Pcum Bill -->
                                        
                                       </tr>


                                       <?php $sn++; } ?>

                                       
                                       <tr style="font-weight: bold;color: #000;">
                                        <td>  </td>
                                        <td> Total: </td>
        <td> <?php echo $sum_count_postage; ?> </td> <td> <?php echo number_format($sum_cash_postage,2); ?> </td>
          <td> <?php echo  $sum_count_cash_int; ?> </td> <td> <?php echo number_format($sum_cash_int,2); ?> </td>
            <td> <?php echo $sum_count_cash_pcum; ?> </td> <td> <?php echo number_format($sum_cash_pcum,2); ?> </td>
              <td> <?php echo $sum_count_pcargo; ?> </td> <td> <?php echo number_format($sum_cash_pcargo,2); ?> </td>
                <td> <?php echo $sum_count_postage_bill; ?> </td> <td> <?php echo number_format($sum_cash_postage_bill,2); ?> </td>
                  <td> <?php echo $sum_count_bill_int; ?> </td> <td> <?php echo number_format($sum_bill_int,2); ?> </td>
                    <td> <?php echo $sum_count_bill_pcum; ?> </td> <td> <?php echo number_format($sum_bill_pcum,2); ?> </td>
                                       </tr>



                                        <tr style="font-weight: bold;color: #000;">
                                        <td>  </td>
                                        <td colspan="15">
                                        Number of Transaction: 
<?php 
$alltrans = $sum_count_postage+$sum_count_cash_int+$sum_count_cash_pcum+$sum_count_pcargo+$sum_count_postage_bill+$sum_count_bill_int+$sum_count_bill_pcum; 
echo number_format($alltrans);
?>
                                        </td>
                                       </tr>

                                       <tr style="font-weight: bold;color: #000;">
                                        <td>  </td>
                                        <td colspan="15">
                                        Revenue Generated: 
<?php 
$allrev = $sum_cash_postage+$sum_cash_int+$sum_cash_pcum+$sum_cash_pcargo+$sum_cash_postage_bill+$sum_bill_int+$sum_bill_pcum;
echo number_format($allrev,2);
?>
                                        </td>
                                       </tr>

                                     
                                       
                                   

                                       
                                       
                                       
                                       <?php }  ?>



                                        </tbody>
                                    </table>

</body>
</html>