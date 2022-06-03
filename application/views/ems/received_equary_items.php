<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h2 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp
        <?php
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                      SORTING ZONE</h2>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        Dashboard Back Office</li>
                      </ol>
                    </div>
                  </div>
                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    <div class="row ">
                    <!-- Column -->

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/in.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    <?php
                                     echo $despatchInCount;
                                    ?>

                                     </h3>

                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_in" class="text-muted m-b-0">Total Despatch In</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/sent.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    <?php
                                      echo $despatchCount;
                                    ?>

                                     </h3>

                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_out" class="text-muted m-b-0">Total Despatch Out</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/receiving.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    <?php
									 echo $ems;
									 ?>
                                     </h3>

                                        <a href="<?php echo base_url(); ?>Box_Application/BackOffice" class="text-muted m-b-0">Total Item from Counter</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/bag.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                   <?php
									echo $bags;
									?>
                                     </h3>

                                        <a href="<?php echo base_url(); ?>Box_Application/ems_bags_list" class="text-muted m-b-0">Total Bags</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                          <?php $regionlist = $this->employee_model->regselect(); ?>
                        <div class="">
                          <a href="received_item_from_counter" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Counter & Branch</a>
                          
                           <a href="received_item_from_out" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a>

                            <a href="<?php echo base_url('Box_Application/Sorted_item_from_out');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Sort Item From Region</a>
                            
                             <a href="<?php echo base_url('Box_Application/Receive_scanned_item');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Receive Scanned</a>

                           <?php  if( $this->session->userdata('user_type') == "ADMIN") {?>

                          <a href="pending_item_from_counter" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Item From Counter</a>

                            <a href="<?php echo base_url('Ems_International/received_item_from_counter');?>" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> International Received Item From Counter</a>
                            
                        <?php } ?>

                        
                        </div>
                        <hr/>
                        
                <?php if($this->session->userdata('message')){?>
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong><?php echo $this->session->flashdata('message'); ?></strong>
                    </div>
                <?php }?>

                <div class="table-responsive original" style="">
                    <form method='POST' action='receive_action' enctype='multipart/form-data'><table id='fromServer1' class='display nowrap table table-bordered fromServer2 receiveTable' cellspacing='0' width='100%'>
                <thead>
                    <!--<tr>
                        <th colspan='6'></th>
                        <th>
                           <div class='input-group'>
                              <input id='edValue' type='text' class='form-control edValue' onInput='edValueKeyPress();' onChange='edValueKeyPress();'>
                              <br /><br /></div>
                              <div class='input-group'>
                               <span id='lblValue' class='lblValue'>Barcode scan: </span><br /></div>
                               <div class='input-group'>
                               <span id='results' class='results' style='color: red;'></span>
                          </div>
                        </th>
                    </tr>-->
                    <tr>
                        <th>S/No</th>
                        <th>Date registered</th>
                        <th>Branch Origin</th>
                        <th>Destination Origin</th>
                        <th>Barcode Number</th>
                        <th>Status</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
            <tbody class=''>

                <?php $count=1; ?>

               <?php foreach ($emsEquaryList as  $value) { 
                    $value = (object)$value;  ?>

                <tr class='receiveRow'>
                    <td><?php echo $count++ ?></td>
                    <td><?php echo $value->date_registered; ?></td>
                    <td><?php echo $value->s_region; ?></td>
                    <td><?php echo $value->r_region; ?></td>
                    <td><?php echo $value->Barcode; ?></td>
                    
                     <?php if ($value->office_name == 'Back'){ ?>
                        <td>BackOffice</td>
                    <?php }else if($value->office_name == 'Received'){ ?>
                         <td>Successfull Received</td>
                        
                    <?php } ?>

                    <!--<td>
                        <div class='form-check' style='padding-left: 53px;float:left'>
                        <input type='checkbox' name='I[]' class='form-check-input checkSingle ".$value->Barcode."' id='remember-me$key' value='".$value->id."'></div>
                        <div style='cursor: pointer;float:right' class='badge' data-itemid='".$value->id."' onclick='enquaryItem(this)'>Equary</div>
                    </td>-->
                </tr>
            <?php } ?>

            </tbody>
        </table>
           
                </div>
            </div>
            </div>
            </div>

                            </div>
                          </div>
<?php $this->load->view('backend/footer'); ?>
