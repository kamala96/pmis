<!DOCTYPE html>
<html>
<head>
    <title>Tanzania Posts Coparation</title>
</head>
<body style="text-align: center;font-family: monospace; background-image:url('assets/images/background.png');background-size: 100%;text-transform: uppercase;">
<div class="table-responsive" style="text-align: center;">
  <table class="table" style="width: 100%;">
     <tr>
        <th><img src="assets/images/tcp.png" width="100" height="100"></th><th>&nbsp;</th><th><h1>Tanzania Posts Corporation</h1></th>
    </tr>
  </table>
  <table class="table table-bordered table-striped">
      <thead>
          <tr><th>PF Number</th><th>Full Name</th><th>Net Salary</th><th>Bank Name</th><th>Acc. Number</th><th></th></tr>
      </thead>
      <tbody>
          <?php foreach ($sheet_to_bank as $value) {?>

            <tr><td><?php echo $value->emp_code; ?></td><td><?php echo $value->first_name.' '.$value->middle_name.' '.$value->last_name; ?></td><td><?php echo $value->net_payment; ?></td><td><?php echo $value->bank_name; ?></td><td><?php echo $value->account_number; ?></td><td></td></tr>
        <?php
          }
          ?>
      </tbody>
  </table>

</div> 
</body>
</html>