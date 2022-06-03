<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>  Regional Report </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Regional Report</li>
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
                        <h4 class="m-b-0 text-white"> Regional Report
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        <form action="Regional_report" method="POST">
                        <div class="input-group">
                          
                          <input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Select Date">
                          <input type="text" name="month" class="form-control mydatetimepicker" placeholder="Select Month">
                          <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                          <select class="form-control custom-select" name="region">
                            <option value="">--Select Region-</option>
                            <?php foreach ($region as $value) { ?>
                              <option><?php echo $value->region_name ?></option>
                            <?php } ?>
                          </select>
                        <?php }?>
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div>
                      <br />
                      <form action="Miscereneous" method="POST">
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                 <th>SN</th>
                                 <th>COST CENTER NAME</th>
                                   <th>LOCATION CODE</th>
                                   <th>COST CENTER CODE</th>
                                   <th>SERVICE NAME</th>
                                   <th>GFS CODE`</th>
                                   <th>GFS CODE DESCRITION</th>

                                   <th>PAID AMOUNT TSHS</th>
                                   <th>UNPAID AMOUNT TSHS</th>
                                   <th>TOTAL AMOUNT TSHS</th>
                                 
                               </thead>
                               <tbody style="font-size: 18px;;color:black;">
                                <tr>
                                  <td colspan="">1</td>
                                   <td colspan=""><?php echo $regionname;?></td>
                                   <td colspan="">088</td>
                                   <td colspan="">212A</td>
                                   <td colspan="">EMS POSTAGE</td>
                                   <td colspan="">1402921</td>
                                   <td colspan=""style="text-transform: uppercase">Document/Parcel</td>
                                   <td colspan=""><?php echo number_format($TotalPaidDomesticDocument->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidDomesticDocument->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidDomesticDocument->amount + $TotalUnPaidDomesticDocument->amount,2);?></td>
                                  
                                 </tr>

                                  <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1402921</td>
                                   <td colspan=""style="text-transform: uppercase">ems posta global bill</td>
                                   <td colspan=""><?php echo number_format($TotalPaidemspostaglobal->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidemspostaglobal->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidemspostaglobal->amount + $TotalUnPaidemspostaglobal->amount,2);?></td>
                                  
                                 </tr>
                                   <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1402921</td>
                                   <td colspan=""style="text-transform: uppercase">ems international</td>
                                   <td colspan=""><?php echo number_format($TotalPaidemsinternational->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidemsinternational->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidemsinternational->amount + $TotalUnPaidemsinternational->amount,2);?></td>
                                  
                                 </tr>

                                  <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1402921</td>
                                   <td colspan="" style="text-transform: uppercase">Loan Board(HESLB)</td>
                                   <td colspan=""><?php echo number_format($TotalPaidLoanBoard,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidLoanBoard,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidLoanBoard + $TotalUnPaidLoanBoard,2);?></td>
                                  
                                 </tr> 
                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368879</td>
                                   <td colspan="" style="text-transform: uppercase">Necta </td>
                                   <td colspan=""><?php echo number_format($TotalPaidNECTA->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidNECTA->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidNECTA->amount + $TotalUnPaidNECTA->amount,2);?></td>
                                 </tr>

                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1402942</td>
                                   <td colspan=""style="text-transform: uppercase">Pcum</td>
                                   <td colspan=""><?php echo number_format($TotalPaidPCUM->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidPCUM->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidPCUM->amount + $TotalUnPaidPCUM->amount,2);?></td>
                                 </tr>



                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1402931</td>
                                   <td colspan=""style="text-transform: uppercase">Ems Cargo</td>
                                   <td colspan=""><?php echo number_format($TotalPaidEmsCargo->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidEmsCargo->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidEmsCargo->amount + $TotalUnPaidEmsCargo->amount,2);?></td>
                                 </tr>

                                 <tr>  
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="" style=""></td>
                                   <td colspan=""></td>
                                   
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td>
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
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>




<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">MAIL</td>
                                   <td colspan="">14010375</td>
                                   <td colspan=""style="text-transform: uppercase">Domestic Register</td>
                                    <td colspan=""><?php echo number_format($TotalPaidDOMESTICREGISTER->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidDOMESTICREGISTER->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidDOMESTICREGISTER->amount + $TotalUnPaidDOMESTICREGISTER->amount,2);?></td>
                                 </tr>
                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">14010375</td>
                                   <td colspan=""style="text-transform: uppercase">International Register</td>
                                    <td colspan=""><?php echo number_format($TotalPaidINTERNATIONALREGISTER->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidINTERNATIONALREGISTER->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidINTERNATIONALREGISTER->amount + $TotalUnPaidINTERNATIONALREGISTER->amount,2);?></td>
                                 </tr>
                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">14010375</td>
                                   <td colspan=""style="text-transform: uppercase">Registered Bill</td>
                                    <td colspan=""><?php echo number_format($TotalPaidREGISTEREDBILL->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidREGISTEREDBILL->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidREGISTEREDBILL->amount + $TotalUnPaidREGISTEREDBILL->amount,2);?></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368865</td>
                                   <td colspan=""style="text-transform: uppercase">Sales Of Stamp</td>
                                   <td colspan=""><?php echo number_format($TotalPaidSTAMP->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidSTAMP->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidSTAMP->amount + $TotalUnPaidSTAMP->amount,2);?></td>
                                 </tr>
                                 


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                     <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1403963</td>
                                   <td colspan=""style="text-transform: uppercase">Private Box Rental Fees</td>
                                   <td colspan=""><?php echo number_format($TotalPaidPBOX->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidPBOX->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidPBOX->amount + $TotalUnPaidPBOX->amount,2);?></td>
                                 </tr>



<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140313264</td>
                                   <td colspan=""style="text-transform: uppercase">Authority Card Fees</td>
                                   
                                   <td colspan=""><?php echo number_format($TotalPaidAuthorityCard->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidAuthorityCard->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidAuthorityCard->amount + $TotalUnPaidAuthorityCard->amount,2);?></td>
                                 </tr>



<tr>
                                  <td colspan=""></td>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1403963</td>
                                   <td colspan=""style="text-transform: uppercase">Lock Replacement</td>
                                   <td colspan=""><?php echo number_format($TotalPaidKEYDEPOSITY->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidKEYDEPOSITY->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidKEYDEPOSITY->amount + $TotalUnPaidKEYDEPOSITY->amount,2);?></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">1403964</td>
                                   <td colspan=""style="text-transform: uppercase">Posts Cargo</td>
                                    <td colspan=""><?php echo number_format($TotalPaidCARGO->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidCARGO->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidCARGO->amount + $TotalUnPaidCARGO->amount,2);?></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368887</td>
                                   <td colspan="" style="text-transform: uppercase">Parcel Post Domestic</td>
                                   <td colspan=""><?php echo number_format($TotalPaidPARCELDOMESTIC->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidPARCELDOMESTIC->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidPARCELDOMESTIC->amount + $TotalUnPaidPARCELDOMESTIC->amount,2);?></td>
                                 </tr>

                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368887</td>
                                   <td colspan=""style="text-transform: uppercase">Parcel Post International</td>
                                    <td colspan=""><?php echo number_format($TotalPaidparcel_international->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidparcel_international->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidparcel_international->amount + $TotalUnPaidparcel_international->amount,2);?></td>
                                 </tr>

                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368887</td>
                                   <td colspan=""style="text-transform: uppercase">Small Packets Domestic</td>
                                     <td colspan=""><?php echo number_format($TotalPaidDSmallPackets->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidDSmallPackets->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidDSmallPackets->amount + $TotalUnPaidDSmallPackets->amount,2);?></td>
                                 </tr>

                                  <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368887</td>
                                   <td colspan=""style="text-transform: uppercase">Small Packets International</td>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">14036887</td>
                                   <td colspan=""style="text-transform: uppercase">Small Packets Delivery</td>
                                  <td colspan=""><?php echo number_format($TotalPaidDerivery->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidDerivery->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidDerivery->amount + $TotalUnPaidDerivery->amount,2);?></td>
                                 </tr>
                               <tr>  
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="" style=""></td>
                                   <td colspan=""></td>
                                   
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td>
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
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>






<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                    <td colspan=""style="text-transform: uppercase">Commission</td>
                                   <td colspan="">140368878</td>
                                   <td colspan=""style="text-transform: uppercase">Western Union</td>
                                      <td colspan=""><?php echo number_format($TotalPaidCOMM->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidCOMM->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidCOMM->amount + $TotalUnPaidCOMM->amount,2);?></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368870</td>
                                   <td colspan=""style="text-transform: uppercase">TPB agency</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140388883</td>
                                   <td colspan=""style="text-transform: uppercase">CRDB Agency</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>
                                  
                                 
                                   <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368875</td>
                                   <td colspan=""style="text-transform: uppercase">Interstate Mo Revenue </td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>


                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">140368882</td>
                                   <td colspan=""style="text-transform: uppercase">Mobile Money Transfer </td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>

                                   <tr>  
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="" style=""></td>
                                   <td colspan=""></td>
                                   
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td>
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
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>







<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">REAL ESTATE</td>
                                   <td colspan="">14010376</td>
                                   <td colspan=""style="text-transform: uppercase">Residential</td>
                                   <td colspan=""><?php echo number_format($TotalPaidResidential,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidResidential,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidResidential + $TotalUnPaidResidential,2);?></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">14010376</td>
                                   <td colspan=""style="text-transform: uppercase">Office</td>
                                     <td colspan=""><?php echo number_format($TotalPaidOffices,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidOffices,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidOffices + $TotalUnPaidOffices,2);?></td>
                                 </tr>


<tr>
                                  <td colspan=""></td>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">14010376</td>
                                   <td colspan=""style="text-transform: uppercase">Land</td>
                                    <td colspan=""><?php echo number_format($TotalPaidLand,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidLand,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidLand + $TotalUnPaidLand,2);?></td>
                                 </tr>

                                  <tr>  
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="" style=""></td>
                                   <td colspan=""></td>
                                   
                                   <td colspan="" style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>TOTAL</b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b>
                                    <?php
                                       $totalestate = $TotalPaidResidential + $TotalUnPaidResidential +$TotalPaidOffices + $TotalUnPaidOffices+ $TotalPaidLand + $TotalUnPaidLand ;

                                        $totalpaidestate = $TotalPaidResidential +$TotalPaidOffices + $TotalPaidLand ;

                                          $totalunpaidestate = $TotalUnPaidResidential + $TotalUnPaidOffices + $TotalUnPaidLand ;
                                  
                                     ?>
                                     
                                   <?php echo number_format($totalpaidestate,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;;color:black;"><b><?php echo number_format($totalunpaidestate,2);  ?></b></td>
                                   <td colspan=""style="border-top:5px solid red;border-bottom: 5px solid red;font-size: 18px;color:black; "><b><?php echo number_format($totalestate,2);  ?></b></td>
                                   
                                   </tr>


                                  <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>

                                 


<tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""style="text-transform: uppercase">Parking</td>
                                   <td colspan="">140368886</td>
                                   <td colspan=""style="text-transform: uppercase">Parking</td>
                                   <td colspan=""><?php echo number_format($TotalPaidparking->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidparking->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidparking->amount + $TotalUnPaidparking->amount,2);?></td>
                                 </tr>
                                   <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" colspan=""style="border-bottom: 5px solid red;font-size: 18px;;color:black;"></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>
                                     <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>


                               <tr>
                                  <td colspan=""></td>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">INTERNET</td>
                                   <td colspan="">140368884</td>
                                   <td colspan=""style="text-transform: uppercase">Internet Income</td>
                                   <td colspan=""><?php echo number_format($TotalPaidINTERNET->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidINTERNET->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidINTERNET->amount + $TotalUnPaidINTERNET->amount,2);?></td>
                                 </tr>

                                  <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" colspan=""style="border-bottom: 5px solid red;font-size: 18px;;color:black;"></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>
                                     <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>

                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">POST SHOPS</td>
                                   <td colspan="">140368874</td>
                                   <td colspan=""style="text-transform: uppercase">Post shop sales</td>
                                  <td colspan=""><?php echo number_format($TotalPaidPOSTASHOP->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidPOSTASHOP->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidPOSTASHOP->amount + $TotalUnPaidPOSTASHOP->amount,2);?></td>
                                 </tr>

                                  <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" colspan=""style="border-bottom: 5px solid red;font-size: 18px;;color:black;"></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>
                                     <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>

                                 <tr>
                                  <td colspan=""></td>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">POST BUS</td>
                                   <td colspan="">140368868</td>
                                   <td colspan=""style="text-transform: uppercase">Post Bus Revenue</td>
                                   <td colspan=""><?php echo number_format($TotalPaidPOSTABUS->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalUnPaidPOSTABUS->amount,2);?></td>
                                   <td colspan=""> <?php echo number_format($TotalPaidPOSTABUS->amount + $TotalUnPaidPOSTABUS->amount,2);?></td>
                                 </tr>

                                  <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" colspan=""style="border-bottom: 5px solid red;font-size: 18px;;color:black;"></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>
                                     <tr>
                                    <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 
                                   <td colspan="6" ></td> <!-- style="background-color:#000000; " -->
                                  <!--  <td colspan=""></td>
                                   
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td> -->
                                   
                                   </tr>

                                 <tr>
                                  <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan="">POSTA GIRO</td>
                                   <td colspan="">140368876</td>
                                   <td colspan=""style="text-transform: uppercase">Posta Giro</td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                 </tr>


                               </tbody>
                               <tfoot>
                                 <tr>
                                 
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   
                                   </tr>
                               </tfoot>
                           </table>
                           </div>
                           </form>
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
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
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
