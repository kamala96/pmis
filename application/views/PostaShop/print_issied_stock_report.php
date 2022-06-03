<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> POSTA SHOP  </title>	
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
    <tr><th> POSTA SHOP | STOCK ISSUED REPORT (<?php echo $branch ?>) </th>
    </tr>
  </table>
        <table class="table" style="width: 100%; text-align: center;">
    <tr><th>   From: <?php echo date("d/m/Y",strtotime($fromdate)); ?> To: <?php echo date("d/m/Y",strtotime($todate)); ?> </th>
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
  
                            <table style="width: 100%;font-size: 12px;" id="t01">
                            <thead>
														<tr>
												     <th> S/N </th>
													   <th> Product Name  </th>
													   <th> Category  </th>
														 <th> Quantity  </th>
														 <th> Purchase Price </th>
														 <th> Total </th>
														</tr>
														</thead>
                            <tbody>
													  <?php
					                  $sn = 1; $sumqty=0;$sumprice=0;$sumtotal=0;
														foreach($list as $data){ ?>
					                  <tr>
					                  <td> <?php echo $sn; ?>  </td>>
														<td> <?php echo @$data->product_name; ?>  </td>
													  <td> <?php echo @$data->category_name; ?>  </td>
														<td> <?php echo number_format(@$data->qty); $sumqty+=@$data->qty; ?> </td>
														<td> <?php echo number_format(@$data->purchase_price,2); $sumprice+=@$data->purchase_price; ?> </td>
														<td> <?php $total = @$data->qty*@$data->purchase_price; echo number_format(@$total,2); $sumtotal+=@$total; ?> </td>
					                  </tr>
					                  <?php $sn++; } ?>

					                  <tr>
					                  <td></td>
					                  <td></td>
					                  <td></td>
					                  <td><?php echo number_format(@$sumqty); ?></td>
					                  <td><?php echo number_format(@$sumprice,2); ?></td>
					                  <td><?php echo number_format(@$sumtotal,2); ?></td>
					                  </tr>
														</tbody>
                            </table>


</body>
</html>
