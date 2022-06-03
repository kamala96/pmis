<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-8 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>
                           Track Job of PF Number: <?php echo $info->em_code; ?>  - <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </h3>
                </div>
                <div class="col-md-4 align-self-center">
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
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
<a href="<?php echo base_url('Ems_Domestic/track_ems_emp_report');?>?I=<?php echo base64_encode($this->session->userdata('getempid')); ?>" class="text-muted m-b-0"> EMS Transaction </a> 
                                 
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
                                        
        <a href="<?php echo base_url('Ems_Domestic/track_mails_emp_report');?>?I=<?php echo base64_encode($this->session->userdata('getempid')); ?>" class="text-muted m-b-0">MAILS Transaction </a>

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
                                        
                   <a href="<?php echo base_url('Ems_Domestic/track_deliver_int_report');?>?I=<?php echo base64_encode($this->session->userdata('getpfno')); ?>" class="text-muted m-b-0"> Delivery Registered (RDP,FPL) </a>

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
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
<a href="<?php echo base_url('Ems_Domestic/track_emp_smallpacket_transaction');?>?I=<?php echo base64_encode($this->session->userdata('getempid')); ?>" class="text-muted m-b-0"> Small Packets Delivery (FGN) </a> 
                                 
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
                                    <div class="round align-self-center round-success"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
<a href="<?php echo base_url('Collection_Report/track_emp_collection_report');?>?I=<?php echo base64_encode($this->session->userdata('getempid')); ?>" class="text-muted m-b-0"> Collection Report </a> 
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                       
                    
                   
                </div>
            </div>               
<?php $this->load->view('backend/footer'); ?>
