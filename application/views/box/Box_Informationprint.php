<?php //$this->load->view('backend/header'); ?>

<!DOCTYPE html>
<html>
<head>
    <title> Tanzania Posts Corporation (TPC) </title>
    
</head>
<body style="text-align: center;font-family: monospace; background-size: 100%;">

<div class="page-wrapper">
    

    <!-- Container fluid  -->
    <!-- ============================================================== -->
    
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="">
                     <table class="table" style="width: 100%;">
        <th style="text-align: center;">
      <img src="assets/images/tcp.png" width="130" height="70">
        </th>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
              
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th> TAX INVOICE </th>
    </tr>
  </table>
                    </div>
                    <div class="card-body">
                      <div class="infor">
                        <div class="card">
                           <div class="card-body">
                            <h4 style="width:100%;font-size: 13px"> Box Customer Information </h4>


                            <table class="table  table-striped" style="width:100%;font-size: 11px;">
                              <!-- <tr><th style="width: 25%;">Description</th><th style="width: 25%;">Values Item</th><th style="width: 25%;">Description</th><th style="width: 25%;">Values Item</th></tr> -->
                              <tr><td style="width: 25%;"><b>Post Box Type</b></td><td style="width: 25%;border-bottom: solid;"><?php echo $inforperson->renter_name; ?></td><td style="width: 25%;"><b>Post Box Category</b></td><td style="width: 25%;border-bottom: solid;"><?php echo $inforperson->box_tariff_category; ?></td></tr>
                              
                            <tr>
                            <td><b>Customer Name</b></td><td style="width: 25%;border-bottom: solid;" colspan="">
                           
                            <?php echo $inforperson->cust_name; ?>
                         
                            </td>
                            </tr>
 

                            <tr>
                            <td><b>Representative Name</b></td><td style="width: 25%;border-bottom: solid;" colspan="">
                            
                         <?php echo $inforperson->first_name; ?>
                         <?php echo $inforperson->middle_name; ?>
                         <?php echo $inforperson->last_name; ?>
                            
                            </td>
                            </tr>

                            <tr>
                            <td style="width: 25%;"><b>Identity Type</b></td>
                            <td style="width: 25%;border-bottom: solid;">
                           
                            <?php echo $inforperson->iddescription; ?>
                                        
                            </select>
                           
                            </td>

                            <td style="width: 25%;"><b>Identity Number</b></td>
                            <td style="width: 25%;border-bottom: solid;">
                            <?php echo $inforperson->idnumber; ?>
                            </td>
                            </tr>


                            <tr><td style="width: 25%;"><b>Authority Card Number</b></td>
                            <td style="width: 25%;border-bottom: solid;">
                             <?php echo $inforperson->authority_card; ?>
                            </td>


                            <td style="width: 25%;"><b>Box Number</b></td>
                            <td style="width: 25%;border-bottom: solid;">
                                <?php echo $inforperson->box_number; ?>
                            </td>
                            </tr>




                              <tr><td style="width: 25%;"><b>Region</b></td><td style="width: 25%;border-bottom: solid;"><?php echo $inforperson->region; ?></td><td style="width: 25%;"><b>Branch</b></td><td style="width: 25%;border-bottom: solid;"><?php echo $inforperson->branch; ?></td></tr>
                              

                              <tr><td style="width: 25%;"><b>Phone</b></td>
                               <td style="width: 25%;border-bottom: solid;">
                                <?php echo $inforperson->phone; ?>
                               </td>
                               <td style="width: 25%;"><b>Mobile</b></td>
                               <td style="width: 25%;border-bottom: solid;">
                                 <?php echo $inforperson->mobile; ?>
                                </td>
                               </tr>
                            </table>

                  

                        
                            </div>

                            <div class="card-body">
                            <h4 style="width:100%;font-size: 13px">Box Payment Information</h4>
                            <table class="table table-bordered table-striped" style="width:100%;font-size: 11px;">
                                <thead>
                              <tr><th >Control Number</th>
                                <th >Receipt Number</th>
                                <th>Payment Date</th>
                                <th >Renew Date</th>
                                <th>TOTAL AMOUNT</th>
                                <th  >Amount(Tsh.) </th>
                                
                            </tr>
                            </thead>

                              <?php foreach ($paymentlist as $value) { ?>
                                <?php if (empty($value->paymentdate)) { ?>
                                <tbody>
                                 <tr><td ><?php echo $value->billid; ?>
                                   <td ><?php echo $value->receipt; ?>
                                 </td><td ><?php echo $value->paymentdate; ?></td>
                                 <td><?php 
                                           
                                           if (!empty($value->paymentdate)) {
                                            $maxyear=1;
                                            foreach ($Outstanding as $value) {
                                              if(date('Y', strtotime($value->paymentdate)) < $value->year){

                                                if($value->year != 'Authority Card' AND $value->year != 'Key Deposity' ){
                                                   $maxyear=$maxyear+1;
                                              }
                                              }
                                              
                                            }
                                            
                                             $yearOnly=date('Y', strtotime($value->paymentdate)) + $maxyear;
                                              echo  $year = '01-01-'.$yearOnly; 
                                           }
                                    
                                 ?></td>
                                 <td >TOTAL AMOUNT</td>

                                 

                                 <td  ><?php echo number_format($value->paidamount); ?></td>
                              

                             </tr>
                                 <?php } }?>
                              
                             

<!-- 
                                     <tr>
                                   
                                    <td colspan="4"></td>
                                      <td ></td>
                                        <td ></td>
                                          <td ></td>
                                    <td >
                                       
                                        <?php echo $values->year; ?>
                                    </td>
                                    <td><?php echo $values->amount; ?></td>
                               
                                  </tr> -->

                               <?php //} ?>
                               </tbody>
                              
                            </table>
                            </div>
                           </div>
                        
                        

                        </div>
                     
                     
                    </div>
                  </div>
                </div>
            
            </div>
        </div>


<?php //$this->load->view('backend/footer'); ?>

</body>
</html>

