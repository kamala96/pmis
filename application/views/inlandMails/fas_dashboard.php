<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> FAS Dashboard  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            FAS
                        </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">
                    <!-- Column -->


                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-qrcode"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                <?php  if ($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPER ADMIN') { ?>
                                <a href="<?php echo site_url('Services/Commission'); ?>" class="text-muted m-b-0"> Commission </a>
                                <?php } else { ?>
                                 <a href="<?php echo site_url('Box_Application/commission_agency_list'); ?>" class="text-muted m-b-0"> Commission </a>
                                <?php } ?>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-shopping-bag"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/postashop_dashboard'); ?>" class="text-muted m-b-0"> Posta Shop  </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-money"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Posta_Cash/postacash_dashboard'); ?>" class="text-muted m-b-0"> Posta Cash </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-wpforms"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Necta/necta_info'); ?>" class="text-muted m-b-0"> NECTA </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-print"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                        <a href="<?php echo site_url('photocopy/photocopy_form'); ?>" class="text-muted m-b-0"> Photocopy </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-clipboard"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Bureautrans/Bureau_form'); ?>" class="text-muted m-b-0"> Bureau Commission </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-clipboard"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Moneygram/Moneygram_form'); ?>" class="text-muted m-b-0"> Moneygram Commission </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-clipboard"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Insurance_commision/Insurance_commision_form'); ?>" class="text-muted m-b-0"> Insurance Commission </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-clipboard"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('BankingCommission/BankingCommission_form'); ?>" class="text-muted m-b-0"> Banking Agency Commission </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                 



                </div>
            </div>

<?php $this->load->view('backend/footer'); ?>
