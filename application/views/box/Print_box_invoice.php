<!DOCTYPE html>
<html>
<head>
    <title> Tanzania Posts Corporation (TPC) </title>
    
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">

  <?php
foreach ($details as $data){
?>
   <table class="table" style="width: 100%;">
        <th style="text-align: center;">
		<!-- <img src="assets/images/tcp.png" width="130" height="80"> -->
		 <!-- <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px"/> -->
     <!-- <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px" style="display: block; margin-left: auto; margin-right: auto;"/> -->
      <img src="assets/images/tcp.png" width="130" height="70">
		</th>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th> TAX INVOICE </th>
    </tr>
  </table>
  <!-- <br> -->
 <!--  <table style="border-bottom: solid; 1px;border-top: solid;1px;width: 100%;font-size: 14px;">
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
  </table> -->
  <table style="width: 100%;font-size: 11px; border-bottom: solid; 1px;border-top: solid;1px;">
    <tr ><td style="width: 60%;">
      <table style="width: 100%;">
        <tr><td>FROM</td></tr>
        <tr><td>RM,<?php echo @$sender_region; ?></td></tr><br />
        <tr><td>Dear Sir/Madam</td></tr><br />
        <tr><td>
          <p>
            The annual rental fee for your private letter box/bag for  <?php echo date('Y'); ?> [January till December]
            as shown is due for payment.If not renewed within 21 days of inssuance of notice,it may result in loss of your letter box/bag without futher notice.
          </p>
          <p>The Management and staff of TPC would like to thank you for your continued support and we look forward to be of service to you.
          </p>
          Date:<?php 
                   $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('d/m/Y');

            echo $date; ?>
          
        </td></tr>
     
      </table>
    </td>
    <td style="width: 40%;">
      <table style="width: 100%;">
       <tr><td ><b>Name  </b> </td><td style="text-transform: uppercase;"><b>:<?php echo @$data['cust_name']; ?></b></td></tr>
      
      
      <tr><td style=""><b>Customer Category  </b></td><td><b>:<?php echo @$data['box_tariff_category']; ?></b></td></tr>
      <tr><td style=""><b>Box Number & Type  </b></td><td><b>:<?php echo 'POBOX '.@$data['box_number'].', '.@$data['box_type']; ?></b></td>
      </tr>
      
       <tr><td style=""><b>Current Validity   </b></td><td><b>:<?php echo @$data['CurrentValidity']; ?></td></tr>
        <tr><td style=""><b>Renew Period  </b></td><td><b>:<?php  echo @$data['RenewPeriod'].' Till '.@$data['tillPeriod'];?></b></td></tr>
     
        <tr><td style=""><b>Rental to be paid (VAT Inclusive)  </b></td><td><b>:<?php echo number_format(@$data['price']).' (VAT: '.number_format(@((@$data['price'] * 100)/118)*0.18,2);?></b></td></tr>
     
      
      </table>
    </td>
  </tr>
      
  </table>
  <!-- <br />
  <br /><br /><br /> -->
 

  <!-- 
  <br>
  
  <table style="width: 100%;">
      <tr><td><b>Prepared by .....................</b></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><b>Checked by .....................</b></td><td><b>Authorised by....................</b></td></tr>
  </table>
-->
  <?php }?>
</body>
</html>