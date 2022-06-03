<!DOCTYPE html>
<html>
<head>
    <title> Tanzania Posts Corporation (TPC) </title>
    
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">
<?php
foreach ($services as $data){
?>
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
          
           <td style="text-align: right;">BRANCH:  <?php echo strtoupper($data['branch']); ?></td>
      </tr>
  </table>
  
  <table style="width: 100%;font-size: 14px;">
    <tr><td>
    <strong> <?php echo strtoupper($data['fplno']); ?> </strong>
    </td>
    <td  style="text-align: right;">
     <img src="<?php echo './assets/'.$data['fplno'].'.png';?>"/> 
    </td>
    <td>
      <table style="width: 100%;font-size: 14px;">
      <tr><td style="text-align: right;"> <strong> 
	  <?php echo strtoupper($data['name']); ?> </strong></td></tr>
      <tr><td style="text-align: right;"> <?php echo 'BOX NUMBER '.$data['address']; ?></td></tr>
      </table>
    </td>
  </tr>
      
  </table>
 
  <table style="border-bottom: solid; 1px;width: 100%;font-size: 14px;">
      <tr><td style="font-size: 14px;"> <strong> <?php echo strtoupper($data['name']); ?> </strong> </td><td style="text-align: right;font-size: 12px;"> Date <?php echo date('d/m/Y');?></td></tr>

  </table>
<table style="width: 100%;font-size: 14px;">
    <tr>
    <td>
      <table style="width: 100%;font-size: 14px;">
      <tr><td > <strong> Customer </strong></td></tr>
      <tr><td > </td></tr>
      <tr><td > Signature ......................</td></tr>
      <tr><td > </td></tr>
      <tr><td  >Name ............................</td></tr>
      <tr><td > </td></tr>
      <tr><td  >Date ............................</td></tr>
      </table>
    </td>
    <td  style="text-align: right;">
   
    </td>
    <td>
      <table style="width: 100%;font-size: 14px;">
      <tr><td > <strong> Delivery officer </strong></td></tr>
      <tr><td > </td></tr>
      <tr><td > Signature ......................</td></tr>
      <tr><td > </td></tr>
      <tr><td  >PF.......Name....................</td></tr>
      <tr><td > </td></tr>
      <tr><td  >Date ............................</td></tr>
      </table>
    </td>
  </tr>
      
  </table>
  <text style="font-size: 14px;"> Collect your mail item, Identifier Number<strong> <?php echo $data['identifier']; ?> </strong>at the post office mentioned above. </text>
  
  <table style="width: 100%;">
    <tr>
    <td>
        <text style="text-align:left;font-size: 14px;"> Sincerely, </text><br />
      <text style="text-align:left;font-weight:bold;font-size: 15px;"> Posts Corporation </text>
</td>
</tr>
</table>
    

   <?php }?>
</body>
</html>