<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>



<script src="<?php echo base_url(); ?>assets/dist/html2pdf.bundle.js"></script>

<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Received</h3>
        </div>
        <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Received</li>
                </ol>
        </div>
    </div>
                        <?php $usertype = $this->employee_model->getusertype(); 
                        ?>
                        <?php 
                        $id = $this->session->userdata('user_login_id');
                        $basicinfo = $this->employee_model->GetBasic($id);
                        $empid = $basicinfo->em_id;
                         ?>

    <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Stock/ReceivedList" class="text-white"><i class="" aria-hidden="true"></i>  Back To List</a>
                    </button>
                   
                </div>
            </div>
            <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="" aria-hidden="true"></i>Received Item<span class="pull-right " ></span></h4>
                        </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                               


                            <div id="app" class="container invoice">
                               
        <div class="row" id = "pdfprint">
                            
            <!-- content -->
            <div class="col-12 content py-4">
                <div class="line mt-4 mb-4"></div>
                <!-- header -->
                <div class="header">
                 
                <div align="left" style="font-size:0px;word-break:break-word;float:left;">
                                                                
                                                       <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:;line-height:22px;text-align:left;color:#525252; ">SN.<?php echo $serial?></div>
                                                   </div>
                                             <div align="center" style="font-size:0px;word-break:break-word;">

                                                 <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;">
                                                        TANZANIA POSTS CORPORATION
                                                </div>
                                                    <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;">
                                                        COUNTER IMPREST (Examination - Transfer - Renewal).
                                                   </div>
                                                   <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;">
                                                    (Strike out heading not required)
                                                </div>

                                            </div>

                                                <div align="right" style="font-size:0px;word-break:break-word;float:right;">
                                                       <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:;line-height:22px;text-align:left;color:#525252; "> <?php echo $request23->formno?></div>
                                                   </div>

                     <br/>
                      <br/>
                    <div class="row">
                    <div class="col-md-3" style="float:left;">
                                <div class="field">
                                   
                                    <input type="text" class="input-label form-control" placeholder="To" name="" value="" />
                                  
                                </div>
                                <div class="value">
                                <input type="text" class="input-label form-control" placeholder="" name="" value="<?php echo $to?>" />
                             
                                </div>
                     </div>

                     <div class="col-md-6">
                     </div>
                    
                     
                       
                   <div class="col-md-3" style="float:right;">
                                <div class="field">
                                <input type="text" class="input-label form-control"placeholder="From" readonly name="RequestedBy" hidden value="<?php echo $basicinfo->em_id; ?>" />
                                    <input type="text" class="input-label form-control"placeholder="From" readonly name=""  value="" />
                                </div>
                                <div class="value">
                                <input type="text" class="input-label form-control"placeholder="" readonly name="RequestedBy"  value="<?php echo $from?>" />
                                    <!-- <text class="form-control" readonly name="from"> <?php echo $basicinfo->first_name.' '.$basicinfo->last_name; ?></text> -->
                                </div>
                    </div>
                      
                    </div>
                </div>
               


   <!-- note -->
               <!-- <div class="row my-4">
                    <div class="col-md-12">
                                    <text>Signature of identity Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  " required><br><br>
                                        
                                    </text>
                                </div>
                     <div class="col-md-12">
                                    <text>Signature of Approving Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required><br><br>
                                        
                                    </text>
                                </div>
                </div>  -->
                <!-- end note -->


                <br />


     
                <div class="">
        <div class="">
            <input type="number" class="input-label form-control"   name="serialno" hidden value="<?php echo $serial?>" />
            <input type="text" class="input-label form-control"   name="issuedby" hidden value="<?php echo $empid ?> " /> 
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align:center;">Description</th>
                        <!-- <th style="text-align:center;">Rate</th> -->
                        <th style="text-align:center;">Quantity Required</th>
                        <th style="text-align:center;">Quantity Supplied</th>
                        <th style="text-align:center;">Unit Cost</th>
                        <th style="text-align:center;">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($request2 as $index =>$value):
                         //$numb = count($request2);
                        
                          ?>
                <tr>
                      
                <?php 
                       
                       
                       $stockname = $this->Stampbureau->geStockname($value->StockId);
                       $stockprice = $this->Stampbureau->geStockprice($value->StockId);
                       
                ?>      
                                           
                                         
                                            <td style="text-align:center;"><?php echo $stockname; ?>
                                            <input type="text" class="input-label form-control"   name="StockIdd[<?php echo $index;?>]" hidden value="<?php echo $value->StockId ?> " /> 
                                        </td>
                                            <td style="text-align:center;"><?php echo $value->QuantityReq; ?></td>
                                            <td style="text-align:center;"><?php echo $value->QuantitySupp; ?></td>

                                            <td style="text-align:center;"><?php echo $stockprice; ?></td>
                                            <td style="text-align:center;"><text ><?php echo $value->Totalamount; ?></text></td>
                                           
                                           
                    </tr>
                    
                   <?php  endforeach; ?>
                </tbody>
            </table>

        </div>

<br><br><br><br>
                       <div class="row">
                       <div class="col-md-8">
                                    <text>Issued by &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-4" value="<?php echo $to?>"style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        </text>
                                        </div> 
                            <div class="col-md-4" style="float: right;">
                                    <text>
                                         <!-- Checked by &nbsp;<input type="text" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                                        Date &nbsp;<input type="text" class="" name="for" value ="<?php echo $request23->issuedate?>" style="border-top: 0px;border-left: 0px;border-right: 0px; " required><br><br>
                                        </text>
                                    </div>   
                                    
                                
                                </div>       
                      <!-- <div class="col-md-12">
                                    <text>Received and taken on charge items detailied above to the value of Shs &nbsp;
                                        <input type="number" name="exp_sum" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        
                                        Cts &nbsp;<input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  " required><br><br>
                                        
                                    </text>
                    </div>  -->


                    <!-- <div class="col-md-12">
                                    <text>as per attached "Details of Temittance" Active AC 184 No&nbsp;
                                        <input type="text" name="exp_sum" class="col-md-4" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        
                                       
                                        <br><br>
                                    </text>
                    </div> 

                    <div class="col-md-12">
                                    <text>Signature of Receiving Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-4" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
                                        
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px; " required><br><br>
                                        
                                    </text>
                    </div> 
                 -->
                </div>
               
  

       </div>
            
            </div>
                               
            <!-- end content -->
        </div>


<form class="" method="post" action="<?php echo base_url();?>Stock/Receivestock" enctype="multipart/form-data">
   <input type="number" class="input-label form-control"   name="serialno" hidden value="<?php echo $serial?>" />

        <div class="col-md-2" style="float:right;">
                   <!-- <a href="<?php echo base_url();?>Stock/Receivestock?k=<?php echo base64_encode($serial); ?>" title="Receive Items" class="btn btn-sm btn-info waves-effect waves-light"> Receive</a>  -->
                  <button  class="btn btn-info " onclick="test()" ><i class="fa fa-check"></i>  Print PDF </button>
               </div>

</form>

                            </div>
                        </div>
                    </div>
                </div>
   
    </div>
      

</div>



<?php $this->load->view('backend/footer'); ?>




<script>
      function test() {
        // Get the element.
        var element = document.getElementById('pdfprint');

        // Generate the PDF.
        html2pdf().from(element).set({
          margin: 1,
          filename: 'pdfprint.pdf',
          html2canvas: { scale: 2 },
          jsPDF: {orientation: 'landscape', unit: 'in', format: 'letter', compressPDF: true}
        }).save();
      }
    </script>