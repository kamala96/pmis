<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar');
$domain = ".posta.co.tz";
$emid = $this->session->userdata('user_login_id');
setcookie("emid", $emid, 0, '/', $domain);
               // setcookie('emid',$emid,time() + (86400 * 30),$domain);
 ?>

      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
                    <?php 
                         $id = $this->session->userdata('user_login_id');
                         $basicinfo = $this->employee_model->GetBasic($id); 
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                           Posta Cash Menu </h3>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-address-card"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url('Posta_Cash/postacash_agents_dashboard');?>" class="text-muted m-b-0"> Agents </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->


<?php if($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type') == 'BOP' || $this->session->userdata('user_type') == 'PMG' || $this->session->userdata('user_type') == 'CRM'){ ?>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-list"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                            <a href="<?php echo base_url('Posta_Cash/postacash_transactions');?>" class="text-muted m-b-0"> Posta Cash Transactions </a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->

                     <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-list"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    
                                     </h3>
                                     
                            <a href="<?php echo base_url('Posta_Cash/postacash_commissions');?>" class="text-muted m-b-0"> Posta Cash Commissions </a>
                                 
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
