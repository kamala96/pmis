<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> Posta Shop Dashboard</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                        Posta Shop
                      </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">

                <?php if($this->session->userdata('sub_user_type')=="COUNTER"){ ?>

                    <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('Post_shop/Post_shop_form'); ?>" class="text-muted m-b-0">Posta Shop Form</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                <?php } ?>


                    <?php if($this->session->userdata('user_type') == 'SUPER ADMIN'){ ?>
                     <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-shopping-basket"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/product_categories'); ?>" class="text-muted m-b-0"> Product Categories </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-file-text"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/report_dashbaord'); ?>" class="text-muted m-b-0"> Report </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <?php } ?>


                    <?php if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'SUPERVISOR'){  ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-shopping-bag"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/productstock'); ?>" class="text-muted m-b-0"> Products (Stock) </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                    <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-send"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/list_pending_requests'); ?>" class="text-muted m-b-0"> Pending Request (<?php echo number_format(@$countpending); ?>) </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                  <?php } ?>


                <?php if($this->session->userdata('sub_user_type')=="COUNTER"){ ?>

                 <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-shopping-basket"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/counter_list_productstock'); ?>" class="text-muted m-b-0"> Stock </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                     <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-send"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/stock_request'); ?>" class="text-muted m-b-0"> Request Stock </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                  <!-- Column -->
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-shopping-cart"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                                        <a href="<?php echo site_url('PostaShop/saleproducts'); ?>" class="text-muted m-b-0"> Sale Products </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                <?php } ?>

                   
                   
                    
                </div>
            </div>

           
                  
<?php $this->load->view('backend/footer'); ?>
