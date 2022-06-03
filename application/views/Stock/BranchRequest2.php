    <p><?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>

<style>
        .line {
            border-bottom: 3px solid #000;
            width: 100%;
        }

        .line-light {
            width: 100%;
            border-bottom: 1px solid #949597;
        }

        .line-end {
            width: 100%;
            border-bottom: 3px solid #f0c29e;
        }

        .data {
            background-color: #dcdddf;
            padding-left: 45px;
        }

        .data .data-box {
            margin-top: 60px;
        }

        .data .data-box .data-separator {
            border-top: 1px solid #949597;
            width: 10%;
        }

        .content {
            background-color: #f1f1f1;
            padding-right: 45px;
        }

        .without-margin {
            margin: 0 !important;
        }

        /* To break in pages, please use this class */
        /* https://github.com/barryvdh/laravel-snappy/issues/2 */
        .page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
    </style>


   

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Stock</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Stock</li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <?php $degvalue = $this->employee_model->getdesignation(); ?>
        <?php $depvalue = $this->employee_model->getdepartment(); ?>
        <?php $usertype = $this->employee_model->getusertype(); ?>
        <?php  ?>
        <?php $regvalue1 = $this->employee_model->branchselect(); ?>
        <div class="container-fluid">
            <div class="row m-b-10"> 
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Stock/Stock" class="text-white"><i class="" aria-hidden="true"></i>  Back stock List</a></button>

                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i> Branch Request<span class="pull-right " ></span></h4>
                        </div>
                        <?php echo validation_errors(); ?>
                        <?php echo $this->upload->display_errors(); ?>

                        <?php echo $this->session->flashdata('formdata'); ?>
                        <?php echo $this->session->flashdata('feedback'); ?>
                        <div class="card-body">
                      <!-- mwanzo wa -->


    
    <div id="app" class="container invoice">
        <div class="row">
           
            <!-- content -->
            <div class="col-12 content py-4">
                <div class="line mt-4 mb-4"></div>
                <!-- header -->
                <div class="header">
                     <table  width="100%">

                                        <tr>
                                            
                                            <td align="center" style="font-size:0px;word-break:break-word;">

                                                 <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;color:#525252;">
                                                        TANZANIA POSTS CORPORATION
                                                </div>
                                                    <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;color:#525252;">
                                                       REQUISITION FOR STAMP, ETC.
                                                   </div>
                                                   <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;color:#525252;">
                                                    INDENTING OFFICE
                                                </div>

                                            </td>

                                                <td align="right" style="font-size:0px;word-break:break-word;float:right;">
                                                       <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:;line-height:22px;text-align:left;color:#525252; "> P93</div>
                                                   </td>

                                        </tr>
                    </table>
                     <br/>
                      <br/>
                    <div class="row">
                        <div class="col-4 from">
                            <span class="d-block font-weight-light">TO:<input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                           
                            <span class="d-block font-weight-light"><input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                            <span class="d-block font-weight-light"><input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                            <span class="d-block font-weight-light"><input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                            
                        </div>
                       
                         <div class="col-4 from" align="center">
                            <table>
                                <tr>
                                    <td style="border: 1px solid; width: 200px; height: 150px; ">
                                        

                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-4 to" align="right">
                           <span class="d-block font-weight-light">FROM:<input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                           
                            <span class="d-block font-weight-light"><input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                            <span class="d-block font-weight-light"><input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                            <span class="d-block font-weight-light"><input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required></span>
                            
                        </div>
                    </div>
                </div>
                <!-- end header -->

                <!-- note -->
                <div class="row my-4">
                    <div class="col-md-12">
                                    <text>Signature of identity Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required><br><br>
                                        
                                    </text>
                                </div>
                     <div class="col-md-12">
                                    <text>Signature of Approving Officer &nbsp;
                                        <input type="text" name="exp_sum" class="col-md-5" style="border-top: 0px;border-left: 0px;border-right: 0px;background-color: #f1f1f1;" required>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        Date &nbsp;<input type="Date" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required><br><br>
                                        
                                    </text>
                                </div>
                </div>
                <!-- end note -->

                <!-- items-header -->
                <div class="items-header">
                    <div class="row mt-4 items-header font-weight-bold">
                        <div class="col-12 my-2">
                            <div class="line"></div>
                        </div>
                        <div class="col-4">Description of Stock</div>
                        <div class="col-2 text-center">Rate</div>
                        <div class="col-2 text-center">No</div>
                        <div class="col-4 text-center">Amount</div>
                        
                    </div>


                     <div class="row mt-4 items-header font-weight-bold">
                        
                        <div class="col-4"></div>
                        <div class="col-2 text-center"></div>
                        <div class="col-2 text-center">(Quantity)</div>
                        <div class="col-2 text-right">Shs</div>
                        <div class="col-2 text-right">Cts</div>
                        <div class="col-12 my-2">
                            <div class="line"></div>
                        </div>
                    </div>


                </div>
                <!-- end items-header -->

                <!-- items -->
                <div class="items">
                    <div class="row mt-2 list-content">
                        <div class="col-4">
                            <input type="text" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required>
                        </div>
                        <div class="col-2 text-center" align="center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                         <div class="col-2 text-center" align="center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                        <div class="col-2 text-right" align="center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                        <div class="col-2 text-right" align="center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                    </div>
                    <div class="row">
                        <div class="col-12 my-2">
                            <div class="line-light"></div>
                        </div>
                    </div>
                   
                   
                     <div class="row mt-2 list-content">
                        <div class="col-4">
                            <input type="text" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required>
                        </div>
                        <div class="col-2 text-center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                         <div class="col-2 text-center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                        <div class="col-2 text-right"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                        <div class="col-2 text-right"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                    </div>
                    <div class="row">
                        <div class="col-12 my-2">
                            <div class="line-light"></div>
                        </div>
                    </div>

                      <div class="row mt-2 list-content">
                        <div class="col-4">
                            <input type="text" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required>
                        </div>
                        <div class="col-2 text-center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                         <div class="col-2 text-center"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                        <div class="col-2 text-right"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                        <div class="col-2 text-right"><input type="number" class="" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;  background-color: #f1f1f1;" required></div>
                    </div>
                    <div class="row">
                        <div class="col-12 my-2">
                            <div class="line-light"></div>
                        </div>
                    </div>
                  
                </div>
                <!-- end items -->

                <!-- values -->
                <div class="values">
                    <div class="row">
                        <div class="col-12 my-2">
                            <div class="line"></div>
                        </div>
                    </div>
                    <div class="row mt-2 list-content">
                        <div class="col-10 font-weight-bold">
                            SUBTOTAL
                        </div>
                        <div class="col-2 text-right font-weight-bold">$ 24.000</div>
                    </div>
                    <div class="row mt-2 list-content">
                        <div class="col-10">
                            Discount 10%
                        </div>
                        <div class="col-2 text-right">-($ 2.400)</div>
                    </div>
                    <div class="row mt-2 list-content">
                        <div class="col-10">
                            Taxes 19%
                        </div>
                        <div class="col-2 text-right">$ 4.104</div>
                        <div class="col-12 my-2">
                            <div class="line-end"></div>
                        </div>
                    </div>
                    <div class="row mt-2 list-content">
                        <div class="col-9">
                            <h3 class="font-weight-bold">TOTAL</h3>
                        </div>
                        <div class="col-3 text-right">
                            <h3 class="font-weight-bold">$ 25.704</h3>
                        </div>
                    </div>
                </div>
                <!-- end values -->

                <!-- signature -->
                <div class="signature my-4">
                    <div class="row">
                        <div class="col-4 offset-8 text-right">
                            <img src="/images/hj.png" alt="" class="img-fluid">
                        </div>
                        <div class="col-12 text-right">
                            <h4 class="font-weight-bold">Jhon Doe</h4>
                            <span class="d-block font-weight-light">CEO</span>
                        </div>
                    </div>
                </div>
                <!-- end signature -->

                <!-- gratitude -->
                <div class="gratitude text-center my-4">
                    <p class="text-muted">If you have any question about this invoice, please contact Jhon Doe to email jhon@mycompany.com, or to the mobile phone (057) 310 671 3456.</p>
                    <h2>Thank you</h2>
                </div>
                <!-- end gratitude -->

                <!-- pagination -->
                <div class="invoice-pagination text-right">
                    <p class="text-muted text-right">Page 1 of 1</p>
                </div>
                <!-- end pagination -->
            </div>
            <!-- end content -->
        </div>
    </div>

   
                        <!-- mwisho wa -->


                        </div>
                     </div>

                </div>
            </div> 
         </div>
                          
    </div>




    <script type="text/javascript">
        function getDistrict() {
            var region_id = $('#regiono').val();
            $.ajax({

               url: "<?php echo base_url();?>Employee/GetBranch",
               method:"POST",
         data:{region_id:region_id},//'region_id='+ val,
         success: function(data){
           $("#branchdropo").html(data);

       }
    });
        };
    </script>

    <script>
        $( "#target" ).keyup(function() {
      //alert( "Handler for .keyup() called." );
    });
    </script>

    <?php $this->load->view('backend/footer'); ?>

    </p>