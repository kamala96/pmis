<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Service Report </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Service Report</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
      <!--  <div class="row m-b-10">
              <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Internet/Internet_form" class="text-white"><i class="" aria-hidden="true"></i>Add Internet </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Internet/Internet_List" class="text-white"><i class="" aria-hidden="true"></i> Internet Transaction List</a></button>
                </div>
        </div> -->

            <div class="row">
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
                </div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Service Report
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        <form action="Service_report" method="POST">
                        <div class="input-group">
                          
                          <input type="text" name="from" class="form-control mydatetimepickerFull" placeholder="Select From Date">
                           <input type="text" name="to" class="form-control mydatetimepickerFull" placeholder="Select To Date">
                          <input type="text" name="month" class="form-control mydatetimepicker" placeholder="Select Month">
                          <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                           <select class="form-control custom-select" name="year">
                            <option value="">--Select Year-</option>
                            <option>2019</option>
                              <option>2020</option>
                               <option>2021</option>
                               <option>2022</option>
                            
                          </select>
                          <!--  <select class="form-control custom-select" name="region">
                            <option value="">--Select Region-</option>
                            <?php foreach ($region as $value) { ?>
                              <option><?php echo $value->region_name ?></option>
                            <?php } ?>
                          </select> -->
                        <?php }?>
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div>
                      <br />
                     
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                 
                                   <th>SERVICE NAME</th>
                                   <!-- <th>GFS CODE</th> -->
                                 
                                   <th>PAID AMOUNT TSHS</th>
                                   <th>UNPAID AMOUNT TSHS</th>
                                   <th>TOTAL AMOUNT TSHS</th>
                                 
                               </thead>
                               <tbody style="font-size: 18px;;color:black;">
                              

                                 <tr>  
                                  
                                   <td colspan="">EMS POSTAGE</td>
                                   
                                   <!-- <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td> -->
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>
                                    <?php
                                       $totalems = $TotalPaidDomesticDocument->amount + $TotalUnPaidDomesticDocument->amount + $TotalUnPaidemspostaglobal->amount + $TotalPaidemspostaglobal->amount + $TotalUnPaidemsinternational->amount + $TotalPaidemsinternational->amount + $TotalUnPaidLoanBoard + $TotalPaidLoanBoard + $TotalPaidNECTA->amount + $TotalUnPaidNECTA->amount +  $TotalPaidPCUM->amount + $TotalUnPaidPCUM->amount + $TotalPaidEmsCargo->amount + $TotalUnPaidEmsCargo->amount;

                                        $totalpaidems = $TotalPaidDomesticDocument->amount +  $TotalPaidemspostaglobal->amount + $TotalPaidemsinternational->amount  + $TotalPaidLoanBoard + $TotalPaidNECTA->amount  +  $TotalPaidPCUM->amount +  $TotalPaidEmsCargo->amount ;

                                          $totalunpaidems = $TotalUnPaidDomesticDocument->amount +  $TotalUnPaidemspostaglobal->amount + $TotalUnPaidemsinternational->amount  + $TotalUnPaidLoanBoard + $TotalUnPaidNECTA->amount  +  $TotalUnPaidPCUM->amount +  $TotalUnPaidEmsCargo->amount ;


                                  
                                     ?>
                                     
                                   <?php echo number_format($totalpaidems,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b><?php echo number_format($totalunpaidems,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "><b><?php echo number_format($totalems,2);  ?></b></td>
                                   
                                   </tr>


                                
                               <tr>  
                           
                                   <td colspan="">MAIL POSTAGE</td>
                                   
                                   <!-- <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td> -->
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>
                                    <?php
                                       $totalmail = $TotalPaidDOMESTICREGISTER->amount + $TotalUnPaidDOMESTICREGISTER->amount + $TotalPaidINTERNATIONALREGISTER->amount + $TotalUnPaidINTERNATIONALREGISTER->amount + $TotalPaidREGISTEREDBILL->amount + $TotalUnPaidREGISTEREDBILL->amount + $TotalPaidSTAMP->amount + $TotalUnPaidSTAMP->amount + $TotalPaidPBOX->amount + $TotalUnPaidPBOX->amount +  $TotalPaidAuthorityCard->amount + $TotalUnPaidAuthorityCard->amount + $TotalPaidKEYDEPOSITY->amount + $TotalUnPaidKEYDEPOSITY->amount
                                        + $TotalPaidCARGO->amount + $TotalUnPaidCARGO->amount + $TotalPaidPARCELDOMESTIC->amount +  $TotalUnPaidPARCELDOMESTIC->amount + $TotalPaidparcel_international->amount + $TotalUnPaidparcel_international->amount + $TotalPaidDSmallPackets->amount
                                        + $TotalUnPaidDSmallPackets->amount +  $TotalPaidDerivery->amount + $TotalUnPaidDerivery->amount;

                                          $totalunpaidmail =  $TotalUnPaidDOMESTICREGISTER->amount  + $TotalUnPaidINTERNATIONALREGISTER->amount  + $TotalUnPaidREGISTEREDBILL->amount + $TotalUnPaidSTAMP->amount  + $TotalUnPaidPBOX->amount  + $TotalUnPaidAuthorityCard->amount  + $TotalUnPaidKEYDEPOSITY->amount
                                         + $TotalUnPaidCARGO->amount  +  $TotalUnPaidPARCELDOMESTIC->amount + $TotalUnPaidparcel_international->amount 
                                        + $TotalUnPaidDSmallPackets->amount  + $TotalUnPaidDerivery->amount;

                                         $totalpaidmail = $TotalPaidDOMESTICREGISTER->amount + $TotalPaidINTERNATIONALREGISTER->amount  + $TotalPaidREGISTEREDBILL->amount  + $TotalPaidSTAMP->amount  + $TotalPaidPBOX->amount  +  $TotalPaidAuthorityCard->amount  + $TotalPaidKEYDEPOSITY->amount 
                                        + $TotalPaidCARGO->amount  + $TotalPaidPARCELDOMESTIC->amount  + $TotalPaidparcel_international->amount + $TotalPaidDSmallPackets->amount
                                       +  $TotalPaidDerivery->amount ;


                                       
                                  
                                     ?>
                                     
                                   <?php echo number_format($totalpaidmail,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b><?php echo number_format($totalunpaidmail,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "><b><?php echo number_format($totalmail,2);  ?></b></td>
                                   
                                   </tr>


                                

                                   <tr>  
                                   
                                   <td colspan="">COMMISION</td>
                                   
                                   <!-- <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td> -->
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>
                                    <?php
                                       $totalcomm = $TotalPaidCOMM->amount + $TotalUnPaidCOMM->amount ;

                                        $totalpaidcomm = $TotalPaidCOMM->amount ;

                                          $totalunpaidcom = $TotalUnPaidCOMM->amount;

                                          
                                  
                                     ?>
                                     
                                   <?php echo number_format($totalpaidcomm,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b><?php echo number_format($totalunpaidcom,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "><b><?php echo number_format($totalcomm,2);  ?></b></td>
                                   
                                   </tr>


                                 

                                  <tr>  
                                   
                                   <td colspan="">REAL ESTATE</td>
                                   
                                   <!-- <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td> -->
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>
                                    <?php
                                       $totalestate = $TotalUnPaidRealEstate + $TotalPaidRealEstate ;

                                        $totalpaidestate = $TotalPaidRealEstate ;

                                          $totalunpaidestate = $TotalUnPaidRealEstate ;

                                         
                                  
                                     ?>
                                     
                                   <?php echo number_format($totalpaidestate,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b><?php echo number_format($totalunpaidestate,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "><b><?php echo number_format($totalestate,2);  ?></b></td>
                                   
                                   </tr>


                                

<tr>
                                   <td colspan=""style="text-transform: uppercase">Parking</td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><?php echo number_format($TotalPaidparking->amount,2);?></td>
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"> <?php echo number_format($TotalUnPaidparking->amount,2);?></td>
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "> <?php echo number_format($TotalPaidparking->amount + $TotalUnPaidparking->amount,2);  ?></td>
                                 </tr>
                                 

                               <tr>
                               
                                   <!-- <td colspan="">INTERNET</td> -->
                                   <!-- <td colspan="">140368884</td> -->
                                   <td colspan=""style="text-transform: uppercase">Internet Income</td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><?php echo number_format($TotalPaidINTERNET->amount,2);?></td>
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"> <?php echo number_format($TotalUnPaidINTERNET->amount,2);?></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "> <?php echo number_format($TotalPaidINTERNET->amount + $TotalUnPaidINTERNET->amount,2);?></td>
                                 </tr>

                               
                                  

                                 <tr>
                                  
                                   <!-- <td colspan="">POST SHOPS</td> -->
                                   <!-- <td colspan="">140368874</td> -->
                                   <td colspan=""style="text-transform: uppercase">Post shop sales</td>
                                  <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><?php echo number_format($TotalPaidPOSTASHOP->amount,2);?></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"> <?php echo number_format($TotalUnPaidPOSTASHOP->amount,2);?></td>
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "> <?php echo number_format($TotalPaidPOSTASHOP->amount + $TotalUnPaidPOSTASHOP->amount,2); ?></td>
                                 </tr>

                                
                                      <tr>
                                   
                                 
                                  

                                 <tr>
                                  
                                   <!-- <td colspan="">POST BUS</td> -->
                                   <!-- <td colspan="">140368868</td> -->
                                   <td colspan=""style="text-transform: uppercase">Post Bus Revenue</td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><?php echo number_format($TotalPaidPOSTABUS->amount,2);?></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"> <?php echo number_format($TotalUnPaidPOSTABUS->amount,2);?></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "> <?php echo number_format($TotalPaidPOSTABUS->amount + $TotalUnPaidPOSTABUS->amount,2);?></td>
                                 </tr>


                                  <tr>
                                  
                                   <!-- <td colspan="">POST BUS</td> -->
                                   <!-- <td colspan="">140368868</td> -->
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;text-transform: uppercase;text-align:center;">TOTAL</td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black; "><?php 

                                       $totalpaidems = $TotalPaidDomesticDocument->amount +  $TotalPaidemspostaglobal->amount + $TotalPaidemsinternational->amount  + $TotalPaidLoanBoard + $TotalPaidNECTA->amount  +  $TotalPaidPCUM->amount +  $TotalPaidEmsCargo->amount ;

                                          $totalunpaidems = $TotalUnPaidDomesticDocument->amount +  $TotalUnPaidemspostaglobal->amount + $TotalUnPaidemsinternational->amount  + $TotalUnPaidLoanBoard + $TotalUnPaidNECTA->amount  +  $TotalUnPaidPCUM->amount +  $TotalUnPaidEmsCargo->amount ;

                                          $totalunpaidmail =  $TotalUnPaidDOMESTICREGISTER->amount  + $TotalUnPaidINTERNATIONALREGISTER->amount  + $TotalUnPaidREGISTEREDBILL->amount + $TotalUnPaidSTAMP->amount  + $TotalUnPaidPBOX->amount  + $TotalUnPaidAuthorityCard->amount  + $TotalUnPaidKEYDEPOSITY->amount
                                         + $TotalUnPaidCARGO->amount  +  $TotalUnPaidPARCELDOMESTIC->amount + $TotalUnPaidparcel_international->amount 
                                        + $TotalUnPaidDSmallPackets->amount  + $TotalUnPaidDerivery->amount;

                                         $totalpaidmail = $TotalPaidDOMESTICREGISTER->amount + $TotalPaidINTERNATIONALREGISTER->amount  + $TotalPaidREGISTEREDBILL->amount  + $TotalPaidSTAMP->amount  + $TotalPaidPBOX->amount  +  $TotalPaidAuthorityCard->amount  + $TotalPaidKEYDEPOSITY->amount 
                                        + $TotalPaidCARGO->amount  + $TotalPaidPARCELDOMESTIC->amount  + $TotalPaidparcel_international->amount + $TotalPaidDSmallPackets->amount
                                       +  $TotalPaidDerivery->amount ;
                                        $totalpaidestate = $TotalPaidRealEstate ;
                                          $totalunpaidestate = $TotalUnPaidRealEstate ;
                                           $totalpaidcomm = $TotalPaidCOMM->amount ;
                                          $totalunpaidcom = $TotalUnPaidCOMM->amount;


                                  $TOTALPAIDALL = $totalpaidems + $totalpaidmail + $totalpaidcomm +  $totalpaidestate + $TotalPaidparking->amount + $TotalPaidINTERNET->amount + $TotalPaidPOSTASHOP->amount + $TotalPaidPOSTABUS->amount ;

                                    $TOTALUNPAIDALL = $totalunpaidems + $totalunpaidmail +   $totalunpaidcom +  $totalunpaidestate + $TotalUnPaidparking->amount + $TotalUnPaidINTERNET->amount + $TotalUnPaidPOSTASHOP->amount + $TotalUnPaidPOSTABUS->amount ;

                                     $TOTALALL = $TOTALPAIDALL + $TOTALUNPAIDALL;

                                   echo number_format($TOTALPAIDALL,2);?></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"> <?php echo number_format($TOTALUNPAIDALL,2);?></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "> <?php echo number_format($TOTALALL,2);?></td>
                                 </tr>

                               
                                

                               </tbody>
                               <tfoot>
                                 <tr>
                                 
                                  
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   
                                   </tr>
                               </tfoot>
                           </table>
                           </div>
                          
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    //lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>

<script type="text/javascript">
$(document).ready(function() {
    $("#checkAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll").prop("checked", true);
            }
        }
        else {
            $("#checkAll").prop("checked", false);
        }
    });
});
</script>

<?php $this->load->view('backend/footer'); ?>
