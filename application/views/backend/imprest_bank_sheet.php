<!DOCTYPE html>
<html>
<head>
    <title>Tanzania Posts Coparation</title>
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="text-align: center;font-family: monospace; background-image:url('assets/images/background.png');background-size: 100%;font-size: 10px;">
<div class="table-responsive" style="text-align: center;">
  <table class="" style="width: 100%;">
     <tr>
        <th><img src="assets/images/tcp.png" width="100" height="100"></th><th>&nbsp;</th><th><h1>Tanzania Posts Corporation</h1></th>
    </tr>
  </table>
  <h3>Employee Imprest Susistence To Bank</h3>
	<table class="text-nowrap" style="width: 100%;border: 1px solid;" cellpadding="2" cellspacing="0" >
		<thead>
		<tr ><th style="border: 1px solid;">PF Number</th><th style="border: 1px solid;">Full Name</th>
			<th style="border: 1px solid;">Net Ammount</th><th style="border: 1px solid;">Bank Name</th><th>Acc. Number</th></tr>
		</thead>
		<tbody>
		<?php foreach ($imprestList as $value) {?>

			<tr><td style="border: 1px solid;"><?php echo $value->em_code; ?></td><td style="border: 1px solid;"><?php echo $value->first_name.' '.$value->middle_name.' '.$value->last_name; ?></td>
				<td style="border: 1px solid;"><?php echo number_format($value->ac_code_vote_amount,2); ?></td>
				<td style="border: 1px solid;"><?php echo $value->bank_name; ?></td>
				<td style="border: 1px solid;"><?php echo $value->account_number; ?></td></tr>
			<?php
		}
		?>
		</tbody>
	</table>
</div> 
</body>
</html>
