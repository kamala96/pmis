<!DOCTYPE html>
<html>
<head>
    <title>Tanzania Posts Coparetion</title>
    
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">
   <table class="table" style="width: 100%;">
     <tr>
        <th style="text-align: center;"><img src="assets/images/tcp.png" width="130" height="80"></th>
    </tr>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th>TAX INVOICE</th>
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
  <br><br>
  <table style="width: 100%;font-size: 14px;">
      <tr><td>TO</td><td></td></tr>
      <tr><td style=""><?php echo @$custinfo->customer_name; ?></td><td style="text-align: right;">Date : <?php echo date('d/m/Y') ?></td></tr>
      <tr><td></td><td style="text-align: right;">Office Code : 2100</td></tr>
      <tr><td style="text-transform: uppercase;"><?php echo @$custinfo->customer_region; ?></td><td style="text-align: right;">Office Name : HEAD QUARTER CASHIER</td></tr>
  </table>
  <br>
  <table style="width: 100%;">
      <tr><td></td><td style="text-align: right;font-size: 12px;">Invoice no: 174605</td></tr>
      <tr><td></td><td style="text-align: right;font-size: 12px;">VRN : 10-009045-Y</td></tr>
      <tr><td style="font-size: 14px;">DR: TANZANIA POSTS CORPORATION</td><td style="text-align: right;font-size: 12px;">Tin:<?php echo @$custinfo->tin_number; ?></td></tr>

  </table>
  <table style="width: 100%;font-size: 14px;border-bottom: solid; 1px;border-top: solid;1px;">
     <thead>
      <tr>
       <th>Particulars</th>
       <th>Currency</th>
       <!-- <th>Price</th>
       <th>Vat</th> -->
       <th>Amount</th>
       </tr>
     </thead>
     <tbody>
      <?php foreach ($emslist as $value) {?>
         <tr>
           <td width="60%"><?php echo $value->fullname ?></td>
           <td>Tsh.</td>
           <!-- <td><?php echo $value->item_price ?></td></td>
           <td><?php echo $value->item_vat ?></td></td> -->
           <td><?php echo number_format($value->paidamount,2) ?></td>
         </tr>
     <?php  } ?>
     
     </tbody>
     <tfoot>
      <tr><td colspan="2"></td></tr>
      <tr><td colspan="2"></td></tr>
      <tr><td>VAT[VAT RATE = 18%]</td><td>Tsh.</td><td><b><?php echo number_format($sum->paidamount*0.18,2) ?></b></td></tr>
       <tr><td>TOTAL::</td><td>Tsh.</td><td><b><?php echo number_format($sum->paidamount,2) ?></b></td></tr>
     </tfoot>
  </table>
  <!-- <table style="width: 100%;">
      <tr><td><?php //echo $invoice->invoice_details; ?></td><td style="text-align: center;">Tsh.</td><td style="text-align: right;"><?php //echo number_format($price,2); ?></td></tr>
  </table> -->
  <br>
  <!-- <br><br>
  <table style="width: 100%;">
      <tr><td>VAT[VAT RATE = 18%]</td><td style="text-align: center;padding-left: 90px;">Tsh.</td><td style="text-align: right;"><?php //echo number_format($vat,2); ?></td></tr>
  </table>
  <table style="width: 100%;border-bottom: solid; 1px;border-top: solid;1px;">
      <tr><td>TOTAL</td><td style="text-align: center;padding-left: 220px;">Tsh.</td><td style="text-align: right;"><?php //echo number_format($total,2); ?></td></tr>
  </table> -->
  <br>
  <table style="width: 100%;">
      <tr><td>
          <text style="line-height: 30px;">Payments should be made to the Tanzania Post Corporation accounts through using this control number <b><?php echo $cno; ?></b>,through bank example NMB,NBC,TPB,CRDB</text>
      </td></tr>
  </table>
  <br>
<!-- <table style="width: 100%;">
      <tr><td><b>TRA Signature</b>&nbsp;&nbsp;<?php //echo $signature->desc;?></td></tr>
  </table> -->
  <br>
  <table style="width: 100%;">
      <tr><td><b>Prepared by .....................</b></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><b>Checked by .....................</b></td><td><b>Authorised by....................</b></td></tr>
  </table>
  
</body>
</html>