<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>
                           Reports dashboard </h3>
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
                   if ($this->session->userdata('user_type') == 'SUPERVISOR') { ?>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                               <a href="<?php echo base_url('Ems_Domestic/employee_view_reports');?>" class="text-muted m-b-0"> EMS Reports </a> 
                                 
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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
										
                   <a href="<?php echo base_url('Ems_Domestic/employee_mail_view_reports');?>" class="text-muted m-b-0"> MAILS Reports </a>

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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Ems_Domestic/deliver_int_report');?>" class="text-muted m-b-0"> Delivery Registered (RDP,FPL) </a>

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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Ems_Domestic/employee_smallpacket_delivery');?>" class="text-muted m-b-0"> Small Packets Delivery (FGN) </a>

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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Collection_Report/report');?>" class="text-muted m-b-0"> Collection Report </a>

                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Column -->
                    <!-- Column -->
                    

                    <!--

                    <?php if ($this->session->userdata('departmentid')==7) { ?>

                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                               <a href="<?php echo base_url('E_reports/ems_reports');?>" class="text-muted m-b-0"> EMS Revenue Report </a> 
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                <?php } ?>
                -->

                    <!--
                     <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                       <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                   <a href="<?php echo base_url('E_reports/mail_reports');?>" class="text-muted m-b-0"> MAILS Reports </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                -->
                    
                    <!-- Column -->
                    <!-- Column -->

                   
				  <?php } ?>

                <?php if($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'){ ?>
                    
                    <div class="col-lg-3 col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                               <a href="<?php echo base_url('Ems_Domestic/employee_view_reports');?>" class="text-muted m-b-0"> EMS Reports </a> 
                                 
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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Ems_Domestic/employee_mail_view_reports');?>" class="text-muted m-b-0">MAILS Reports </a>

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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Ems_Domestic/deliver_int_report');?>" class="text-muted m-b-0"> Delivery Registered (RDP,FPL) </a>

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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Ems_Domestic/employee_smallpacket_delivery');?>" class="text-muted m-b-0"> Small Packets Delivery (FGN) </a>

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
                                    <div class="round align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>
                                        
                   <a href="<?php echo base_url('Collection_Report/report');?>" class="text-muted m-b-0"> Collection Report </a>

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
