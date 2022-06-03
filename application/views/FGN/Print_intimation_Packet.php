<?php ini_set('memory_limit', '-1'); ?>
<!DOCTYPE html>
<html>
<head>
    <title> INTIMATION  </title> 
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
    <tr><th>  <?php echo strtoupper(@$status); ?> INTIMATION </th>
    </tr>
  </table>
  </table>
     

   <table class="table" style="width: 100%; text-align: left; border-top: solid;">
        
    <tr><th>  <b>SMALL PACKETS BY AIR</b> as under is awaiting collection at the Post Office and will be delivered on presentation of this form on the paymentof charges due subject to compliance with the conditions prescribed.</th>
    </tr>
   
    </tr>
  </table>
  <div class="page-wrapper">
 
                  <div class="container-fluid">
              
                <!--   style="font-size:22px ;" -->
                <div class="row" >
                  <div class="col-lg-12">
                    <div class="card">
                    
                      <div class="card-body">
                        <div class="">
                          <div class="div2" id="div2">
                           
                    

              <table class="table" style="width: 100%; text-align: left; border-top: dotted; 1px;">
                 <tr><th>   <br /></th></tr>
              <tr><th>   Item Number     </th>
                <th>   :<?php echo @$report->FGN_number; ?></th>
                <th> </th>
                <th>  </th>
                 <th>  </th>
                <th style="text-align: right;">  Date Stamp (Issue) </th>
              </tr>
               <tr><th>   Posted At     </th>
                <th>    :<?php echo @$report->postedat; ?> </th>
                <th>   </th>
                <th>    </th>
                <th>  <img src="<?php echo $barcodegenerator;?>"/>  </th>
                <th> </th> 
              </tr>
                 <tr><th>   P.O Charges due     </th>
                <th>    :<?php echo @$report->pocharges; ?> </th>
                <th>   </th>
                <th>   </th>
                <th>  </th>
                <th> </th> 
              </tr>

               <tr><th>    Handling Charges     </th>
                <th>    :<?php echo @$report->hndlcharges; ?> </th>
                <th>   </th>
                <th>   Demurrage Fee  </th>
                <th>   :<?php echo @$report->demurragefee; ?></th>
                <th> </th> 
              </tr>

              <tr><th>    Customs Fee     </th>
                <th>    :<?php echo @$report->customsfee; ?> </th>
                <th>   </th>
                <th>   Other Charges  </th>
                <th>   :<?php echo @$report->othercharges; ?></th>
                <th> </th> 
              </tr>

               <tr><th>    Addressed To     </th>
                <th>    :<?php echo @$report->addressedto; ?> </th>
                <th>   </th>
                <th>     </th>
                <th>  </th>
                <th style="text-align:right;"> Date Stamp (Delivery) </th> 
              </tr>

              <tr><th>    Delivery serial     </th>
                <th>    :<?php echo 'DP-'.@$report->serial; ?> </th>
                <th>   </th>
                <th>   Box Number  </th>
                <th>   :<?php echo @$report->boxnumber.' Mobile:'.@$report->phone; ?></th>
                <th><?php echo @$report->region.' '.@$report->branch; ?> </th> 
              </tr>
            
             
              
              
            </table>
             <table class="table" style="width: 100%; text-align: left;">
    <tr><th> Delivery against authority card No: <?php echo @$report->cardno; ?> </th>
    </tr>
  </table>   
            <table class="table" style="width: 100%; text-align: left;border-top: dotted; 1px;">
    <tr><th> Received in good condition the postal item described above </th>
    </tr>
  </table>     

                          <table class="table" style="border-bottom: dotted; 1px;width: 100%;font-weight: bold ;">
     
    
       <tr><td>   <br /></td></tr>
      
      <tr>
          <td>Customer Signature..........................</td>
          <td>Officer Signature..........................</td>
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
          <td>Customer Name .........................</td>
          <td>Officer Name .........................<?php //echo @$staff; ?></td>
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
          <td>Date .........................</td>
          <td>PF No. .......................<?php //echo @$pf; ?></td>
      </tr>

    
      <tr>
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


