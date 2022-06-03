<!DOCTYPE html>
<html>
<head>
    <title>Tanzania Posts Coparation</title>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style>
		thead:before, thead:after { display: none; }
		tbody:before, tbody:after { display: none; }

		}
	</style>
</head>
<body style="font-family: monospace; background-image:url('assets/images/background.png');background-size: 100%;font-size: 10px;">
<div class="table-responsive">
  <table class="" style="width: 100%;text-align: center;">
     <tr>
        <th><img src="assets/images/tcp.png" width="100" height="100"></th><th>&nbsp;</th><th><h1>Tanzania Posts Corporation</h1></th>
    </tr>
  </table>
	<h3><span style="float: left;"><?php echo $batchNo1; ?></span><span style="float: right;;">Employee Annual Leaves Payment</span></h3>
  <br>
  <br>
  <table class="text-nowrap" style="width: 100%;border: 1px solid;" cellpadding="2" cellspacing="0" >
      <thead>
          <tr ><th style="border: 1px solid;">PF Number</th><th style="border: 1px solid;">Full Name</th>
			  <th style="border: 1px solid;">Net Ammount</th><th style="border: 1px solid;">Bank Name</th><th style="border: 1px solid;">Bank Code</th><th>Acc. Number</th></tr>
      </thead>
      <tbody>
          <?php foreach ($batch as $value) {?>

            <tr><td style="border: 1px solid;"><?php echo $value->em_code; ?></td><td style="border: 1px solid;"><?php echo $value->first_name.' '.$value->middle_name.' '.$value->last_name; ?></td>
				<td style="border: 1px solid;"><?php echo number_format($value->fare_amount + $value->faredistrictvillage,2); ?></td>
				<td style="border: 1px solid;"><?php echo $value->bank_name; ?></td>
        <td style="border: 1px solid;"><?php echo $value->bank_code; ?></td>
				<td style="border: 1px solid;"><?php echo $value->account_number; ?></td></tr>
        <?php
          }
          ?>
          <tr><td>&nbsp;</td><td>Total Amount</td><td><?php echo number_format($sum->fare_amount + $sum2->faredistrictvillage,2); ?></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
      </tbody>
  </table>
  <table>
    gfhdgfhjhjk
  </table>

</div> 
<br>
<div class="row">
  <div class="col-md-12">
    <?php foreach ($approver as $value) {?>
      <?php if($value->batch_status == "isHR"){ ?>
        <b>Prepared By HR:</b>
        <b><?php echo $value->first_name.' '.$value->last_name ?>,&nbsp;<?php echo $value->datetime ?></b><br><br>
      <?php }elseif($value->batch_status == "isCRM"){?>
        <b>Approved By GMCRM:</b>
        <b><?php echo $value->first_name.' '.$value->last_name ?>,&nbsp;<?php echo $value->datetime ?></b><br><br>
      <?php }elseif($value->batch_status == "isPMG"){?>
        <b>Approved By PMG:</b>
        <b><?php echo $value->first_name.' '.$value->last_name ?>,&nbsp;<?php echo $value->datetime ?></b><br><br>
      <?php }elseif($value->batch_status == "isACC"){?>
        <b>Approved By ACCOUNTANT:</b>
        <b><?php echo $value->first_name.' '.$value->last_name ?>,&nbsp;<?php echo $value->datetime ?></b>
      <?php }?>
    <?php } ?>
  </div>
</div>

  </div>
</div>
</body>
</html>
