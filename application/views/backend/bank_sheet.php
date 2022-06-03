<?php 
  ini_set('max_execution_time', 3000);
 ini_set('memory_limit','24');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tanzania Posts Coparation</title>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>
<body style="font-family: monospace; background-image:url('assets/images/background.png');background-size: 100%;font-size: 10px;">
<div class="table-responsive" style="text-align: center;">
  <table class="" style="width: 100%;">
     <tr>
        <th><img src="assets/images/tcp.png" width="100" height="100"></th><th>&nbsp;</th><th><h1>Tanzania Posts Corporation</h1></th>
    </tr>
  </table>
  <table class="table table-bordered text-nowrap" style="" cellpadding="4" cellspacing="0" style="width: 100%;">
      <thead>
          <tr style="text-transform: uppercase;"><th>SN.</th><th>PF Number</th><th>Full Name</th><th>Net Salary</th><th>Bank Name</th><th>Acc. Number</th><th>Back Code No.</th></tr>
      </thead>
      <tbody>
          <?php $i =0; foreach ($sheet_to_bank as $value) {?>

            <tr><td><?php  $i++; echo $i; ?></td><td><?php echo $value->emp_code; ?></td><td><?php echo strtoupper($value->holder_name); ?></td><td><?php echo number_format($value->net_payment,2); ?></td><td><?php echo $value->bank_name; ?></td><td><?php echo $value->account_number; ?></td><td><?php echo $value->bank_code; ?></td></tr>
        <?php
          }
          ?>
          <tr><td></td><td></td><td style="text-align: right;"><b>Total::</b></td><td><?php echo number_format($sum->total,2); ?></td><td></td><td></td><td></td></tr>
      </tbody>

  </table>

  
</div> 
<div class="row">
  <br><br><br>
</div>

<div class="row">
  <div class="col-md-6" style="text-align: left;">------------------------<br>Signature</div>
  <div class="col-md-6" style="text-align: right;">------------------------<br>Signature</div>
   
</div>
</body>
</html>