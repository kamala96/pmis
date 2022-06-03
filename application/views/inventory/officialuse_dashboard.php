<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> Official Use Items   |  <i class="fa fa-chevron-circle-left" style="color:#1976d2"></i> <a href="<?php echo site_url('Services/Inventory'); ?>"> Inventory Dashboard </a>  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            Official Use Items
                        </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">
                    <!-- Column -->

        <?php if($this->session->userdata('sub_user_type') == 'PMU' || $this->session->userdata('user_type')=="ADMIN"){?>

<?php
@$nostock = $this->OfficialuseModel->pmucountnostorestock();
@$lowqty = $this->OfficialuseModel->pmucount_low_qty_storestock();
?>

<!-- Notifications -->
                <?php if(@$nostock==0){?>
                <div class="col-lg-12 col-md-12">
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                Your stock is empty, update your stock!
                </div>
                </div>
               <?php } ?>
                <?php if(!empty(@$lowqty)){?>
                <div class="col-lg-12 col-md-12">
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                You have <?php echo number_format(@$lowqty); ?> Items, Quantity is less or equal to five, Please update your Stock
                </div>
                </div>
               <?php } ?>
<!-- End of Notifications -->





                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-wpforms"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Officialuse/items'); ?>" class="text-muted m-b-0"> Items </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-wpforms"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Officialuse/units'); ?>" class="text-muted m-b-0"> Units </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-external-link"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                       <a href="<?php echo site_url('Officialuse/pending_requests');?>" class="text-muted m-b-0"> Pending Requests </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php } ?>
                    

       <?php if($this->session->userdata('sub_user_type') == 'PMU' || $this->session->userdata('sub_user_type') == 'STORE' || $this->session->userdata('user_type')=="ADMIN"){?>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-shopping-bag"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                       <a href="<?php echo site_url('Officialuse/stock'); ?>" class="text-muted m-b-0"> Stock </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        <?php } ?>





<?php if($this->session->userdata('sub_user_type') == 'STORE'){?>
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-paper-plane-o"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                       <a href="<?php echo site_url('Officialuse/store_requests');?>" class="text-muted m-b-0"> Approved Requests </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<?php } ?>

                </div>
            </div>

<?php $this->load->view('backend/footer'); ?>
