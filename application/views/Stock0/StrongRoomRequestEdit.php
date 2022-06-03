<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Request</h3>
        </div>
        <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Request</li>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Stock/Requisition_Form" class="text-white"><i class="" aria-hidden="true"></i>  Back Un Issued Requisition List</a>
                    </button>
                   
                </div>
            </div>
            <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Strong Room Request<span class="pull-right " ></span></h4>
                        </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                               


                            <div id="app" class="container invoice">
                               
        <div class="row">
                            
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
                                                         STORES COMBINED REQUISITION AND ISSUING NOTE(CRIN)
                                                   </div>
                                                   

                                            </div>

                                                <div align="right" style="font-size:0px;word-break:break-word;float:right;">
                                                       <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:;line-height:22px;text-align:left;color:#525252; "> S 64</div>
                                                   </div>

                     <br/>
                      <br/>
                    <div class="row">
                    <div class="col-md-3" style="float:left;">
                                <div class="field">
                                    <input type="text" class="input-label form-control" placeholder="To" hidden name="issuedby" value="PMUCODE" />
                                    <input type="text" class="input-label form-control" placeholder="To" name="" value="" />
                             
                                </div>
                                <div class="value">
                                    <textarea class="form-control" placeholder="Issuing Officer" readonly ></textarea>
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
                                    <textarea class="form-control" readonly placeholder="<?php echo $from?>" name="from"></textarea>
                                </div>
                    </div>
                      
                    </div>
                </div>
               

<br />



 <form class="" method="post" action="<?php echo base_url();?>Stock/IssueRequisition" enctype="multipart/form-data">
   
                <div class="">
        <div class="">
            <input type="number" class="input-label form-control"   name="serialno" hidden value="<?php echo $serial?>" />
            <input type="text" class="input-label form-control"   name="issuedby" hidden value="<?php echo $empid ?> " /> 
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="text-align:center;">Description of Stock</th>
                        <!-- <th style="text-align:center;">Rate</th> -->
                        <th style="text-align:center;">Quantity Requested</th>
                        <th style="text-align:center;">Quantity Supplied</th>
                        <th style="text-align:center;">Unit Amount</th>
                        <!-- <th style="text-align:center;">Cts</th> -->
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
                                            <td><?php echo $value->QuantityReq; ?></td>
                                            <td><input type="number" class="form-control" name="QuantitySupp[<?php echo $index;?>]"></td>

                                            <td style="text-align:center;"><?php echo $stockprice; ?></td>
                                            <!-- <td style="text-align:center;"><text >00</text></td> -->
                                           
                                           
                    </tr>
                    
                   <?php  endforeach; ?>
                </tbody>
            </table>

        </div>


       
                    <div class="col-md-2" style="float:right;">
                   
                        <button type="submit" class="btn btn-info "><i class="fa fa-check"></i>  Issue </button>
                    </div>
                
                </div>
                </form> 
  

       </div>
            
            </div>
                               
            <!-- end content -->
        </div>






                            </div>
                        </div>
                    </div>
                </div>
   
    </div>
        <!-- <form class="" method="post" action="" enctype="multipart/form-data">
       
                <div class="col-md-2" style="float:right;">
                   
                    <button type="submit" class="btn btn-info "><i class="fa fa-check"></i>  Issue 
                    </button>
                </div>
        </form>   -->

</div>
<?php $this->load->view('backend/footer'); ?>