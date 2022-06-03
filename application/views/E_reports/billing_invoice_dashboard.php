<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-file-text-o" style="color:#1976d2"></i>
                           Billing Invoice </h3>
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
                                    <div class="round align-self-center round-danger"><i class="fa fa-file-text-o"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                          <a href="<?php echo site_url('E_reports/pending_invoice');?>" class="text-muted m-b-0"> EMS Invoice </a> 
                                 
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
                                    <div class="round align-self-center round-danger"><i class="fa fa-file-text-o"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                       <a href="<?php echo site_url('E_reports/mails_pending_invoice');?>" class="text-muted m-b-0"> Mails Invoice  </a>

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
