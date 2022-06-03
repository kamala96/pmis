<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-money" style="color:#1976d2"></i>
                           Accounts  | <a href="<?php echo site_url('Services/StrongRoom');?>" class="text-muted m-b-0"> Back to Dashboard </a> </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                      </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="font-size: 28">
                 <br>
                    <div class="row">
                    <!-- Column -->

                

                    
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-calculator"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                          <a href="<?php echo site_url('Bureau/payment_voucher');?>" class="text-muted m-b-0"> Payment Voucher </a> 
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
        
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-bar-chart-o"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('Bureau/receipt_voucher');?>" class="text-muted m-b-0"> Receipt Voucher  </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-pie-chart"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('Bureau/journal_voucher');?>" class="text-muted m-b-0"> Journal Voucher  </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-cog"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('Bureau/voucher_setting');?>" class="text-muted m-b-0"> Setting  </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    
                    <!-- Column -->
                    <!-- Column -->

                   <!--
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">

                                    <div class="round align-self-center round-info"><i class="fa fa-paper-plane"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="" class="text-muted m-b-0"> Transfer </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    -->
                    <!-- Column -->

                       
                    
                   
                </div>
            </div>               
<?php $this->load->view('backend/footer'); ?>
