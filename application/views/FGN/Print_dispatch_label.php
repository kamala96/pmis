<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> SMALL PACKETS  </title> 
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
<?php foreach (@$reports as  $value){  ?>
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
    <tr><th>  <?php echo strtoupper(@$status); ?> FOREIGHN LETTER  </th>
    </tr>
  </table>
  </table>
      <table class="table" style="width: 100%; text-align: center;">
    <tr><th>   Despatch Number: <?php echo @$value->desp_no; ?> </th>
    </tr>
    <tr><th>   Date : <?php echo @$value->despatch_date; ?></th>
    </tr>
     <tr><th>   From: <?php echo @$value->branch_from; ?>  To: <?php echo @$value->branch_to; ?></th>
    </tr>
    <tr><th>   Weight: <?php echo @$value->weight; ?>KG</th>
    </tr>
  </table>
  <?php }  ?>
  </body></html>


