<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> DELIVERY ITEMS REPORT  </title>	
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
    <tr><th> DELIVERY LIST </th>
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
           <td style="text-align: right;">BRANCH:  <?php echo strtoupper(@$branch); ?></td>
      </tr>
  </table>
  
   <table style="width: 100%;font-size: 14px;">
      <tr>
          <td>FLP NO: <?php echo @$receipient->fplno;?> </td>
          <td style="text-align: right;" rowspan="2"> 
              <img src="<?php echo './assets/'.@$receipient->fplno.'.png' ;?>"/> 
          </td>
      </tr>
      <tr>
          <td>Office Name: <?php echo $info->em_branch;?> </td>
          <!-- <td style="text-align: right;"></td> -->
      </tr>
      <tr>
          <td>Delivery Agent Name: <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?>  </td>
          <!-- <td style="text-align: right;"></td> -->
      </tr>
      <tr>
          <td>Bulk Receipient: <?php echo @$receipient->receiver_fullname; ?> 
           </td>
           
          <td style="text-align: right;"> Date: <?php echo date('d/m/Y');?> </td>
      </tr>
       <tr>
          
           <td>BOX NUMBER: <?php echo @$receipient->address; ?>
           </td>
         
      </tr>
  </table>
                                                       <table style="width: 100%;font-size: 14px;" id="t01">
                                                        <thead>
														<tr>
												        <th> S/N </th>
														<th> Item Number  </th>
													    <th> Addressee  </th>
														</thead>
                                                         <tbody>
													    <?php
					                                    $sn = 1;
														foreach($emslist as $data)
														{
					                                    ?>
														
					                                    <tr>
					                                    <td>  <?php echo $sn; ?>  </td>
														<td>  <?php echo strtoupper($data->Barcode); ?>  </td>
														<td>  <?php echo $data->receiver_fullname; ?>  </td>
					                                    </tr>
					                                    <?php $sn++; 
														} 
					                                    ?>
														</tbody>
                                                        </table>



  <br>
  <table style="width: 100%;">
      <tr><td><b>Received by .....................</b></td><td><b>Signature .....................</b></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><b>ID Type .....................</b></td><td><b>ID Number....................</b></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><b>Delivery Number .................</b></td></tr>
  </table>

</body>
</html>