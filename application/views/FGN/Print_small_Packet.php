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
    <tr><th>  <?php echo strtoupper(@$status); ?> SMALL PACKETS  </th>
    </tr>
  </table>
  </table>
      <table class="table" style="width: 100%; text-align: center;">
    <tr><th>   Despatch Number: <?php echo @$report->desp_no; ?>  Date : <?php echo @$report->despatch_date; ?></th>
    </tr>
     <tr><th>   From: <?php echo @$report->region_from; ?>  To: <?php echo @$report->region; ?> Weight: <?php echo @$report->weight; ?>KG</th>
    </tr>
  </table>
  <div class="page-wrapper">
 
                  <div class="container-fluid">
              

                <div class="row" style="font-size:22px ;">
                  <div class="col-lg-12">
                    <div class="card">
                    
                      <div class="card-body">


                              


                      <!-- <button class="btn btn-info div1" id="div1" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button> -->

                     <!--  <a href="
                               <?php echo base_url()?>Box_Application/download3?trn=<?php echo @$getbags->bag_number; ?>"data-bagno = "<?php echo @$getbags->bag_number; ?>" class="btn btn-primary">Wordocument
                                </a> -->

                          <br>

                        <div class="">
                          <div class="div2" id="div2">
                           
                         

                       <table style="width: 100%;font-size: 14px;" id="t01">
                         <thead>         

                            <tr>
                                    <th> S/N </th>
                                     <th>Barcode Number</th>
                                     <th>Origin Branch</th>
                                    <th>Destination Branch</th>
                                </tr>
                            </thead>

                            <tbody>
                              <?php $sn=1; ?>
                               <?php if(!empty(@$reports)){ foreach (@$reports as  $value) {?>
                                   <tr>
                                 
                                     <td> <?php echo $sn; ?> </td>
                                      <td> <?php  echo @$value->FGN_number; ?>  </td>
                                      <td><?php echo @$value->branch_from;?></td>
                                       <td><?php echo @$value->branch;?></td>
                                    </tr>
                              <?php $sn++; } }?>
                            </tbody>
                        </table>


                        <br>

                          <table style="border-bottom: solid; 1px;border-top: solid;1px;width: 100%;font-size: 14px;">
     
      <tr>
          <td></td>
          <td style="text-align: right;"></td>
      </tr>
        <tr>
          <td><br /></td>
          <td style="text-align: right;"><br /></td>
      </tr>
      
      <tr>
          <td>Prepared by <b><?php echo @$staff; ?></b></td>
          <td>Carried by ..........................</td>
      </tr>
        <tr>
          <td></td>
          <td style="text-align: right;"></td>
      </tr>
       
        <tr>
          <td><br /></td>
          <td style="text-align: right;"><br /></td>
      </tr>
      <tr>
          <td>Received by .........................</td>
          <td>Receiving Office Date Stamp:</td>
      </tr>
    
      <tr>
          <!--  <td>Remarks<?php echo @$remarks; ?></td> -->
          <td></td>
          <td style="text-align: right;"></td>
      </tr>
  </table>
  
<!--  <table style="border-bottom: solid; 1px;border-top: solid;1px;width: 100%;font-size: 14px;">
        <tr>

            <td></td>
        <td colspan="3">Remarks: 
        <br><br><br><br>
        </td>
        <td colspan="3">Receiving Office Date Stamp:
        <br><br><br><br>
        </td>
        </tr>

        <tr style="font-size:22px ;">
        <td>Prepared by <b><?php echo @$staff; ?></b></td>
        <td>Carried by ........................................... </td>
        <td colspan="6">Received by ...............................</td>
           
        </tr>
  </table> -->

  <br>




 </div>
                      
                      </div>
                      </div>
                      </div>

                      </div>
   


                           

                          </div> </div> </div> </body></html>


