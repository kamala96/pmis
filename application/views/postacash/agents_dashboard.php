<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i> Posta Cash Agents </h3>
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

                  <?php if($this->session->flashdata('feedback')){ ?> 
                           <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>                         
                      <?php } ?>

                    <div class="row">

                    

                     <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-home"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url('Posta_Cash/postacash_dashboard');?>" class="text-muted m-b-0"> Main Dashboard </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->

<?php if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'SUPERVISOR'){ ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-user-plus"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url('Posta_Cash/register_agent');?>" class="text-muted m-b-0"> Register Agent </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
<?php } ?>

<?php if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'SUPERVISOR' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'BOP' || $this->session->userdata('user_type') == 'PMG' || $this->session->userdata('user_type') == 'CRM'){ ?>

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-users"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>

                                        <a href="<?php echo base_url('Posta_Cash/registered_agent');?>" class="text-muted m-b-0"> Registered Agents </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-list"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>

<a href="<?php echo base_url('Posta_Cash/registered_agent_wallet_transactions');?>" class="text-muted m-b-0"> Agent Deposit Transactions </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
<?php } ?>


<?php if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'RM'){ ?>

                     <?php if(!empty(@$pendinagents)){ ?>
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-danger"><i class="fa fa-bell"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            
                                        </h3>

                                        <a href="<?php echo base_url('Posta_Cash/pending_agent');?>" class="text-muted m-b-0"> Pending Agents (<?php echo number_format(@$pendinagents);?>) </a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <?php } ?>
<?php } ?>
                    


                </div>
            </div> 
            
          
<?php $this->load->view('backend/footer'); ?>
