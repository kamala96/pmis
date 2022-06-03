<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> Inventory </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">
                            Inventory
                        </li>
                    </ol>
                </div>
            </div>
             
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                    <div class="row">
                    <!-- Column -->
                    <?php if($this->session->userdata('sub_user_type') == 'PMU' || $this->session->userdata('sub_user_type') == 'STORE' || $this->session->userdata('user_type')=="ADMIN"){?>
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-wpforms"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                        
                                        </h3>
                                     
                                        <a href="<?php echo site_url('Officialuse/dashboard'); ?>" class="text-muted m-b-0"> Official use items </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-shopping-bag"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                       <a href="<?php echo site_url('Commercialuse/main_dashboard'); ?>" class="text-muted m-b-0"> Commercial Items </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                 <div class="col-lg-12 col-md-12">
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
                </button>
                Ooops..! You don't have permission to access this module, Please contact with administrator 
                </div>
                </div>
                <?php } ?>


                </div>
            </div>

<?php $this->load->view('backend/footer'); ?>
