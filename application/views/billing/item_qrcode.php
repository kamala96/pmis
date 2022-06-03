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
  <div class="row" style="text-align: center;"><div class="col-md-12"><h1> ITEM QR CODE</h1></div></div>
  <br><br><br>
   <div class="row">
    <div class="col-md-4">
        <img src="assets/images/<?php echo $item->ems_qrcode_image?>" width='300' class="thumbnail" />
  </div>
  </div>
  <div class="row">
    <div class="col-md-4">
     <label>&nbsp;<b><?php echo $item->track_number;?></b></label>
  </div>
  </div>
</body>
</html>
