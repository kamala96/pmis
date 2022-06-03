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
     
           <?php $word1 = 'resreal';  $word2 = 'Hallreal'; if(strpos($custinfo->serial, $word1) === false  ){ ?>
             <!-- && strpos($custinfo->serial, $word2) === false  -->
             <tr><td style="">VRN  :<?php echo @$custinfo->vrn; ?></td></tr>
             <tr><td style="">Tin :<?php echo @$custinfo->tin_number; ?></td></tr>

          <?php }//else{ ?>
            <!--  <tr><td style="">VRN  :<?php echo @$custinfo->vrn; ?></td></tr>
        <tr><td style="">Tin :<?php echo @$custinfo->tin_number; ?></td></tr>
 -->

         <?php  //} ?>

      
      </table>
    </td>
    <td>
      <table style="width: 100%;font-size: 14px;">
      <tr><td style="text-align: right;">Office Name : HEAD QUARTER CASHIER</td></tr>
      <tr><td style="text-align: right;">Office Code : 2100</td></tr>
      <tr><td style="text-align: right;">Date : <?php echo date('d/m/Y') ?></td></tr>
     
      
      </table>
    </td>
  </tr>
      
  </table>
  <br>
  <table style="width: 100%;">
      <tr><td></td><td style="text-align: right;font-size: 12px;">Invoice no: <?php echo $invoice; ?></td></tr>
      <tr><td></td><td style="text-align: right;font-size: 12px;">VRN : 10-009045-V</td></tr>
      <tr><td style="font-size: 14px;">DR: TANZANIA POSTS CORPORATION</td><td style="text-align: right;font-size: 12px;">Tin:100-206-072</td></tr>

  </table>
  <table style="width: 100%;font-size: 14px;border-bottom: solid; 1px;border-top: solid;1px;">
     <thead>
      <tr>
       <th>Particulars</th>
       <th>Currency</th>
       <!-- <th>Price</th>
       <th>Vat</th> -->
       <th style="text-align: right;">Amount</th>
       </tr>
     </thead>
     <tbody>
      
         <tr>
           <td width="60%">
            <?php
            $word1 = 'Hallreal';
           if(strpos($custinfo->serial, $word1) !== false ){
            $typehall='Hall';
            ?>

                  <text>Being Payment Of Conference Charge Bill From

           <?php }else{ ?>

                   <text>Being Payment Of Rent Charge Bill For the Month Of 
          <?php } ?>

           <?php 
           $monthstart = date('m',strtotime($custinfo->start_date));
           $monthend = date('m',strtotime($custinfo->end_date));
            $dateObj   = DateTime::createFromFormat('!m', $monthstart);
            $dateObjend   = DateTime::createFromFormat('!m', $monthend);
            $monthName = $dateObj->format('F');
            $monthNameend = $dateObjend->format('F');
            $year = date('Y',strtotime($custinfo->start_date));
            $yearend = date('Y',strtotime($custinfo->end_date));
            $date = date('d',strtotime($custinfo->start_date));
            $dateend = date('d',strtotime($custinfo->end_date));

            $start_date = $custinfo->start_date;
            $end_date = $custinfo->end_date;


             // $contract  = $this->dashboard_model->getamount($cuno);
             $payment_cycle=$custinfo->payment_cycle;
             $amount = $custinfo->amount;
             $Totalamount = 0;
             if ($payment_cycle == "Monthly") {

                   $Totalamount = $amount;
              
            } elseif($payment_cycle == "Quartery") {
              $Totalamount = $amount * 3;
              
            }elseif ($payment_cycle == "Semi Annual") {
                $Totalamount = $amount * 6;
              
            }elseif ($payment_cycle == "Custom") {
          $date1 = new DateTime($start_date);
                   $date2 = new DateTime($end_date);
                   $interval = $date1->diff($date2);

          $days = $interval->days + 1;
          $Totalamount = $amount * $days;
        }else{
                $Totalamount = $amount * 12;
              
            }
            
             $word1 = 'resreal';
              $word2 = 'Hallreal';
           if(strpos($custinfo->serial, $word1) !== false ){

                $witholding=(0);
                $vat=(0);
                $rentalfee=($Totalamount);
                $total=($Totalamount );

            }elseif ( @$typehall=='Hall') {
               $witholding=(0);
                $vat=(0);
                $rentalfee=($Totalamount);
                $total=($Totalamount );
        }else{

              $witholding=($Totalamount * 0.1);
              $vat=($Totalamount * 0.18);
              $rentalfee=($Totalamount - $witholding);
              $total=($rentalfee + $vat);

            }

            

            echo $monthName.' '.$date.','.$year?>  Up To <?php echo $monthNameend.' '.$dateend.','.$yearend ?>  </text></td>

           <!-- <td>Tsh.</td>
            <td><?php echo $value->item_price ?></td></td>
           <td><?php echo $value->item_vat ?></td></td> 
           <td style="text-align: right;">
           
             <?php 
              echo number_format($rentalfee,2);
             ?> 
           </td> -->

         </tr>
     
     </tbody>
     <tfoot>
      <tr><td colspan="2"></td></tr>
      <tr><td colspan="2"></td></tr>
      <tr><td>
        <?php if( @$typehall=='Hall') { ?>
                CONFERENCE:

        <?php }else{ ?>
                        RENT:
       <?php }?>

      
    </td>
        <td>Tsh.</td><td style="text-align: right;"><?php 
        echo number_format(@$Totalamount,2);
      ?></td></tr>
      <tr><td>VAT[VAT RATE = 18%]:</td><td>Tsh.</td><td style="text-align: right;"><?php 
        echo number_format(@$vat,2);
      ?></td></tr>
      <tr><td>TOTAL:</td><td>Tsh.</td><td style="text-align: right;"><b><?php
        echo number_format(@$Totalamount+@$vat,2); ?></b></td></tr>
       <tr><td>WITHOLDING TAX[RATE = 10%]:</td><td>Tsh.</td><td style="text-align: right;"><?php 
        echo number_format(@$witholding,2);
      ?></td></tr>
       <tr><td>PAYABLE TO TPC: </td><td>Tsh.</td><td style="text-align: right;"><b><?php
        echo number_format(@$total,2); ?></b></td></tr>
     </tfoot>
  </table>
  <br>
  <table style="width: 100%;">
      <tr><td>
          <text style="line-height: 30px;">Payments should be made to the Tanzania Post Corporation accounts through this control number <b><?php echo $cno; ?></text>
      </td></tr>
  </table>
  <br>
 <table style="width: 100%;">
      <tr><td><b>TRA Verification Code</b>&nbsp;&nbsp;<?php echo $signature->desc;?></td><td><img src="assets/images/<?php echo $qrcodename;?>" width="50" height="50"></td></tr>
  </table>
  <br>
  <table style="width: 100%;">
      <tr><td colspan="2"><b>Prepared by</b> <?php echo @$preparedby ?></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><b>Checked by .....................</b></td><td><b>Authorised by....................</b></td></tr>
  </table>
  
</body>
</html>