<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> STORES COMBINED REQUISITION AND ISSUING NOTE (CRIN)  </title>	
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
    <tr><th> STORES COMBINED REQUISITION AND ISSUING NOTE (CRIN) </th>
    </tr>
  </table>
  
  
                            
                            <table style="width: 100%;font-size: 14px;" id="t01">

                            <tr>
                            <th colspan="2"> Region: <?php echo $info->em_region; ?>  </th>
                            <th> Branch: <?php echo $info->em_branch; ?></th>
                             <th> Date: <?php echo date("d/m/Y",strtotime($infor->request_created_at)); ?>  </th>
                            </tr>

                            <tr>
                            <td colspan="2"> <strong> Issuing Address</strong> <br> TPC-PMU <br> P.O Box 9551 <br> Dar es Salaam,Tanzania </td>
                            <td colspan="2"> <strong> Requested by: </strong> <br> Name: <?php echo 'PF '.$info->em_code.'-'.$info->first_name.' '.$info->middle_name.' '.$info->last_name; ?><br> Designation: <?php echo $info->des_name; ?></td>
                            </tr>

                            <tr>
                            <td colspan="4">  Please issue the following items:- </td>
                            </tr>

                            <thead>
														<tr>
												    <th width="5%"> S/N </th>
														<th> Description </th>
													   <th> Unit  </th>
														 <th> Quantity </th>
														</tr>
														</thead>
                            <tbody>
													 <?php  $sn = 1; foreach($list as $data){ ?>
														<tr>
					                  <td>  <?php echo $sn; ?>  </td>
														<td>  <?php echo $data->item_name; ?>  </td>
														<td>  <?php echo $data->unit_name; ?>  </td>
                            <td>  <?php echo $data->itemqty; $sumqty[] = $data->itemqty; ?>  </td>
					                  </tr>
					                 <?php $sn++; } ?>

                           <tr>
                           <td> </td>
                           <td> </td>
                           <td> Total: </td>
                           <td> <?php echo number_format(array_sum($sumqty)); ?></td>
                           </tr>

                           <tr>
                            <td colspan="2"> <strong> Approved By PMU</strong> <br> Name:  <?php echo 'PF '.$pmuinfo->em_code.'-'.$pmuinfo->first_name.' '.$rminfo->middle_name.' '.$pmuinfo->last_name; ?> <br> Designation: <?php echo $pmuinfo->des_name; ?> </td>
                            <td colspan="2"> <strong> Approved by RM: </strong> <br> Name: <?php echo 'PF '.$rminfo->em_code.'-'.$rminfo->first_name.' '.$rminfo->middle_name.' '.$rminfo->last_name; ?><br> Designation: <?php echo $rminfo->des_name; ?></td>
                            </tr>

														</tbody>
                            </table>
</body>
</html>