<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-money" style="color:#1976d2"></i>
                           Bureau De Change </h3>
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

                    <?php 
                     $checkbcl = $this->BureauModel->get_branch_bclno();
                     if(!empty($checkbcl->bcl)){
                     ?>

                    
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-cart-plus"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                          <a href="<?php echo site_url('Bureau/selling');?>" class="text-muted m-b-0"> Selling </a> 
                                 
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
                                    <div class="round align-self-center round-danger"><i class="fa fa-cart-arrow-down"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('Bureau/buying');?>" class="text-muted m-b-0"> Buying  </a>

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
                                        
                       <a href="<?php echo site_url('Bureau/branch_stock_currency_balance');?>" class="text-muted m-b-0"> Stock Balance  </a>

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
                                        
                       <a href="<?php echo site_url('Bureau/strong_room_stock_balance');?>" class="text-muted m-b-0"> Strong Room Balance  </a>

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
                                        
                       <a href="<?php echo site_url('Bureau/counter_currency_rates');?>" class="text-muted m-b-0"> Currency Rates  </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-send"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('Bureau/send_stock_request');?>" class="text-muted m-b-0"> Request Stock from Strong Room </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-send"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('Bureau/send_stock_branch_request');?>" class="text-muted m-b-0"> Request Stock from Bureau Branch  </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <?php } else {?>

                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">

                    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> BCL Number Not found! This branch has no permission to access Bureau De Change  </strong> 
                    </div>  

                     </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                    
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
