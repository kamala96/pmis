<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
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
                            Dashboard Back Office</h3>
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

                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <a href="#" role="tab" id="mails">

                        <div class="card card-inverse card-info">
                            <div class="box bg-info text-center">
                                <h1 class="font-light text-white">
                                    <?php 
                                        $db2 = $this->load->database('otherdb', TRUE);
                                        $db2->where('PaymentFor','EMS');
                                        $db2->where('status','Paid');
                                        $db2->where('office_name','Back1');
                                        $db2->from("transactions");
                                        echo $db2->count_all_results();
                                    ?>
                                </h1>
                                <h6 class="text-white">Mails</h6>
                            </div>
                        </div>
                    </a>
                    </div>
                    <!-- Column -->
                     <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-success card-inverse">
                            <div class="box text-center">
                                <h1 class="font-light text-white">
                                    <?php 
                                        $db2 = $this->load->database('otherdb', TRUE);
                                        $db2->where('PaymentFor','EMS');
                                        $db2->where('status','Paid');
                                        $db2->where('office_name','Back1');
                                        $db2->from("transactions");
                                        echo $db2->count_all_results();
                                    ?>
                                </h1>
                                <h6 class="text-white">Delivery</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                    <a class="ems1"  href="#" role="tab">
                        <div class="card card-inverse card-danger">
                            <div class="box text-center">
                                <h1 class="font-light text-white">
                                     <?php 
                                          echo $ems;
                                    ?>
                                </h1>
                                <h6 class="text-white">Ems</h6>
                            </div>
                        </div>
                    </a>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                      <a class="emsbags1"  href="#" role="tab">
                        <div class="card card-inverse card-dark">
                            <div class="box text-center">
                                <h1 class="font-light text-white">
                                    <?php 
                                        echo $bags;
                                    ?>
                                </h1>
                                <h6 class="text-white">EMS Bags</h6>
                            </div>
                        </div>
                      </a>
                    </div>
                </div>

                  <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                            <div class="btn-group btn-group-justified">
                            <a href="#" class="despatch" style="padding-right: 10px;">DespatchOut</a>
                            <a href="#" class="despatchIn" style="padding-right: 10px;">DespatchIn</a>
                            <a href="#" data-bagno = "" class="ems1">EMSList</a>
                            <a href="#" class="emsbags1" style="padding-left: 10px;">BagsList</a>
                           <!--  <a href="#" class="btn btn-primary" style="padding-left: 5px;"></a> -->
                          </div> 
                          <hr/>
                          </div>
                          <div class="card-body">

                    <div class="table-responsive ems" style="display: none;">
                     
                    <form method="POST" action="close_bags">
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th colspan="10"></th>
                                                <th>
                                                    <div class="form-check" style="padding-left: 53px;" id="showCheck">
                                                     <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div>
                                                </th>
                                                <th>
                                                    <div class="form-check" style="padding-left: 53px;" id="showCheck">
                                                     <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Sender Name</th>
                                                <th>Receiver Name</th>
                                                <th>Date Registered</th>
                                                <th>Item Name</th>
                                                <th>Item Type</th>
                                                <th>Amount (Tsh.)</th>
                                                <th>Destination</th>
                                                <th>Bill Number</th>
                                                <th>Status</th>
                                                <th>Tracking Number</th>
                                                <th>
                                                    
                                                </th>
                                                <th>
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php foreach ($emslist as  $value) {?>
                                               <tr>
                                                   <td><?php echo $value->s_fullname;?></td>
                                                   <td><?php echo $value->fullname;?></td>
                                                   <td><?php echo date('Y-m-d',strtotime($value->date_registered));?></td>
                                                   <td><?php echo $value->ems_type;?></td>
                                                   <td><?php echo $value->cat_name;?></td>
                                                   <td><?php echo number_format($value->paidamount,2);?></td>
                                                   <td><?php echo $value->r_region;?></td>
                                                   <td>
                                                    <?php 
                                                    if ($value->billid == '' && $value->bill_status == 'PENDING') {
                                                     $serial=$value->serial;
                                                     $paidamount=$value->paidamount;
                                                     $region=$value->region;
                                                     $district=$value->district;
                                                     $mobile = $value->Customer_mobile;
                                                     $renter = $value->cat_name;
                                                     $serviceId = $value->PaymentFor;

                                                     $this->Box_Application_model->getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId);

                                                    }
                                                   echo $value->billid;
                                                   ?>
                                                   </td>
                                                   <td>
                                                    <?php if ($value->office_name == 'Back' && $value->bag_status == 'isNotBag') {?>
                                                    <button type="button" class="btn  btn-success" disabled="disabled">Comming From Counter</button>
                                                    <?php }elseif($value->office_name == 'Received' && $value->bag_status == 'isNotBag'){ ?>
                                                      <button type="button" class="btn  btn-success" disabled="disabled">Item Received</button>
                                                    <?php }elseif($value->office_name == 'Back' && $value->bag_status == 'isBag'){ ?>
                                                      <button type="button" class="btn  btn-warning" disabled="disabled">Is In Bag <?php echo $value->isBagNo;?></button>
                                                    <?php }?>
                                                      
                                                  </td>
                                                  <td>
                                                    <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php echo $value->track_number;?></a>
                                                    <!-- <?php echo $value->ems_qrcode_image;?> -->
                                                      <!-- <img src="<?php echo base_url(); ?>/assets/images/<?php echo $value->ems_qrcode_image?>" width='150' class="thumbnail" /> -->
                                                    </td>
                                                   <td style="padding-left:  65px;"><div class='form-check'>
                                                    <?php if ($value->office_name == 'Received' && $value->bag_status == 'isNotBag') {?>
                                                <input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='<?php echo $value->id ?>'>
                                                 <label class='form-check-label' for='remember-me'></label>
                                               <?php }elseif($value->office_name == 'Back' && $value->bag_status == 'isNotBag'){ ?>
                                                      <input type="checkbox" class='form-check-input' disabled="disabled">
                                                    <?php }elseif($value->office_name == 'Received' && $value->bag_status == 'isBag'){ ?>
                                                      <input type="checkbox" class='form-check-input' checked disabled="disabled">
                                                    <?php }?>
                                               
                                                 </div> 
                                                </td>
                                                 <td style="padding-left:  65px;"><div class='form-check'>
                                                    <?php if ($value->office_name == 'Back' && $value->bag_status == 'isNotBag') {?>
                                                     <input type="hidden" name="region[]" value="<?php echo $value->r_region;?>">
                                                <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $value->id ?>'>
                                                 <label class='form-check-label' for='remember-me'></label>
                                                    <?php }elseif($value->office_name == 'Received' && $value->bag_status == 'isNotBag'){ ?>
                                                      <input type="checkbox" class='form-check-input' checked disabled="disabled">
                                                    <?php }?>
                                               
                                                 </div> 
                                                </td>
                                               </tr>
                                           <?php } ?>
                                       
                                        </tbody>
                                        <footer>
                                           
                                            <tr><td colspan="8"></td>
                                                <?php $region = $this->employee_model->regselect();?>
                                                <td colspan="">
                                                    <select class="" name="region" style="height: 40px;">
                                                        <option value="">--Select Destination Region--</option>
                                                        <?php foreach ($region as $value) {?>
                                                            <option><?php echo $value->region_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td><input type="number" name="weight" class="form-control" placeholder="bag weight"></td>
                                                <td style="">
                                              <button type="submit" class="btn btn-info" name="catname" value="close">Close Bag  </button></td><td style="">
                                                
                                                <button type="submit" class="btn btn-info" name="catname" value="receive">Receive </button></td></tr>
                                        </footer>
                                    </table>
                                    <input type="hidden" name="type" value="EMS">
                                </form>
                                </div>
                                <div class="table-responsive listItems" style="">
                                    <table id="kimeo" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                             <tr>
                                                <th>Sender Name</th>
                                                <th>Receiver Name</th>
                                                <th>Item Name</th>
                                                <th>Registered Date</th>
                                                <th>Item Type</th>
                                                <th>Amount (Tsh.)</th>
                                                <th>Destination</th>
                                                <th>Bill Number</th>
                                                <th>Tracking Number</th>
                                            </tr>
                                        </thead>

                                        <tbody class="">
                                           <?php foreach ($bagslist as  $value) {?>
                                               <tr>
                                                   <td><a href="#" class="myBtn" data-sender_id="<?php echo $value->sender_id; ?>"><?php echo $value->s_fullname;?></a></td>
                                                   <td><?php echo $value->fullname;?></td>
                                                   <td><?php echo $value->ems_type;?></td>
                                                   <td><?php 
                                                   echo $value->date_registered;
                                                       //echo $value->date_registered;
                                                   ?></td>
                                                   <td><?php echo $value->cat_name;?></td>
                                                   <td><?php echo number_format($value->paidamount,2);?></td>
                                                   <td><?php echo $value->r_region;?></td>
                                                   <td>
                                                    <?php echo $value->billid;?>
                                                    </td>
                                            <td>
                                                <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php 
                                                    echo $value->track_number;
                                                ?>
                                                </a>

                                            </td>
                                            
                                     
                    </tr>
                <?php } ?>

            </tbody>
           
         </table>
                                </div>
                                <div class="table-responsive bags_item_list" style="display: none;">
                                    <form method="POST" action="close_bags">
                            <table id="fromServer" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sender Name</th>
                                                <th>Receiver Name</th>
                                                <th>Item Name</th>
                                                <th>Item Type</th>
                                                <th>Amount (Tsh.)</th>
                                                <th>Destination</th>
                                                <th>Bill Number</th>
                                              
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="listresults">
                                                                                   
                                        </tbody>
                                        
                                    </table>
                                    <input type="hidden" name="type" value="EMS">
                                </form>
                                </div>
                    
                        <div class="emsbags" style="display: none;">
                            
                          <form method="POST" action="bags_despatch">
                           
                        <div class="table-responsive row col-md-12">
                        
<table id="example5" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Bag Number</th>
                                                <th>Bag Origion</th>
                                                <th>Bag Destination</th>
                                                <th>Date Bag Created</th>
                                                <th>Total Item Number</th>
                                                <th>Bag Weight</th>
                                                <th>Bag QR Code</th>
                                                <th>
                                                    <div class="form-check" style="padding-left: 53px;" id="showCheck">
                                                     <input type="checkbox"  class="form-check-input" id="checkAll1" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div>
                                                </th> 
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php foreach ($emsbags as  $value) {?>
                                               <tr>
                                                   <td>
                                                     <a href="#" data-bagno = "<?php echo $value->bag_number; ?>" class="listitem"><?php echo $value->bag_number;?></a>
                                                     
                                                   </td>
                                                   <td><?php echo $value->bag_region_from;?></td>
                                                   <td><?php echo $value->bag_region;?>
                                                     <input type="hidden" name="" class="reg" value="<?php echo $value->bag_region;?>">
                                                   </td>
                                                   <td><?php echo $value->date_created;?></td>
                                                   <td>
                                                     <?php 
                                                     
                                                     $bagno = $value->bag_number;
                                                     $region = $value->bag_region;

                                        $db2 = $this->load->database('otherdb', TRUE);
                                        $sql    = "SELECT * FROM `transactions` WHERE `isBagNo`='$bagno' AND `PaymentFor` = 'EMS'";

                                        $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
                                          FROM `sender_info`
                                          LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                                          LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                                          LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                                          WHERE `isBagNo`='$bagno' AND `PaymentFor` = 'EMS' AND `receiver_info`.`r_region` = '$region'";
                                        $query  = $db2->query($sql);
                                        echo $query->num_rows();
                                        // $db2->where('PaymentFor','EMS');
                                        // $db2->where('isBagNo',$bagno);
                                        // $db2->from("transactions");
                                        // echo $db2->count_all_results();
                                    ?>
                                                   </td>
                                                   <td><?php echo $value->bag_weight; ?></td>
                                                  <td>
                                                     <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->bag_number) ?>" target="_blank"><?php echo $value->bag_number;?></a>
                                                  </td>
                                                   <td>
                                                    <div class='form-check' style="padding-left: 53px;">
                                                      <?php if ( $value->bags_status == 'notDespatch') {?>
                                                        <input type='checkbox' name='I[]' class='form-check-input checkSingle1 checkd' id='remember-me' value='<?php echo $value->bag_id ?>'>
                                                 <label class='form-check-label' for='remember-me'></label>
                                                      <?php }else{ ?>
                                                <input type='checkbox' class='form-check-input' id='remember-me' checked disabled="disabled">
                                                 <label class='form-check-label' for='remember-me'></label>
                                                    <?php }?>
                                                 </div> 
                                                </td> 
                                               </tr>
                                           <?php } ?>
                                       
                                        </tbody>
                                        
                                    </table>
                                    <input type="hidden" name="type" value="EMS">
                                      
                                             
                               
                                </div>
                                <br><br>
                                <div class="row" style="padding-left: 10px;padding-right: 35px; text-align: left;">
                                    <!-- <div class="col-md-3">
                                  <label>Bag Destination</label>
                                 <?php $region = $this->employee_model->regselect();?>
                                                    <select class="form-control custom-select" name="region" style="height: 40px;">
                                                        <option value="">--Select Destination Region--</option>
                                                        <?php foreach ($region as $value) {?>
                                                            <option><?php echo $value->region_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                </div> -->
                                <div class="col-md-3">
                                  <label>Transport Type</label>
                                <select name="transport_type" class="form-control custom-select type" onChange="transportType()">
                                    <option>Office Truck</option>
                                    <option>Public Truck</option>
                                    <option>Public Buses</option>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                  <label>Transport Name</label>
                                  <input type="text" name="transport_name" class="form-control" required="required">
                                </div>
                                <div class="col-md-3">
                                <label>Rigistration Number</label>
                                <input type="text" name="reg_no" class="form-control" required="required">
                               </div>
                                <div class="col-md-3 cost" style="display: none;">
                                  <label>Transport Cost</label>
                                   <input type="text" name="transport_cost" class="form-control" >
                                </div>
                                </div>
                                <br>
                                <div class="row" style="padding-left: 10px;padding-right: 35px;">
                                  <div class="col-md-12">
                                    <button type="submit" class="btn btn-info btn-sm">Despatch Bags</button>
                                  </div>
                                </div>
                          </form>
                          </div>
                          <div class="table-responsive despatch1" style="display: none;">
                      <form method="POST" action="despatch_action">
                            <table id="despatch" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Despatch Number</th>
                                                <th>Number Of Bags</th>
                                                <th>Despatch Date</th>
                                             <!--    <th>Bag Destination</th> -->
                                                <th>Transport Type</th>
                                                <th>Transport Name</th>
                                                <th>Registration Number</th>
                                                <th>Despatch Status</th>
                                               <!--  <th>
                                                    <div class="form-check" style="padding-left: 53px;" id="showCheck">
                                                     <input type="checkbox"  class="form-check-input" id="checkAll4" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div>
                                                </th>  -->
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <?php foreach ($despatch as $value) {?>
                                            <tr>
                                              <td><a href="#" data-despno = "<?php echo $value->desp_no; ?>" class="bagsList12"><?php echo $value->desp_no; ?></a>
                                                </td>
                                              <td style="text-align: center;">
                                                <?php 
                                                     $bagno = $value->desp_no;
                                                      $db2 = $this->load->database('otherdb', TRUE);
                                                      $db2->where('despatch_no',$bagno);
                                                      $db2->from("bags");
                                                      echo $db2->count_all_results();
                                                  ?>
                                              </td>
                                              <td><?php echo $value->datetime; ?></td>
                                            <!--    <td><?php echo $value->region_to; ?></td> -->
                                              <td><?php echo $value->transport_type; ?></td>
                                              <td><?php echo $value->transport_name; ?></td>
                                              <td><?php echo $value->registration_number; ?></td>
                                              <td style="text-align: center;">
                                              <?php 
                                                $regionfrom = $this->session->userdata('user_region');
                                                if ($value->region_from == $regionfrom && $value->despatch_status == 'Sent' ) {
                                                  
                                                  echo "<button class='btn btn-info btn-sm' type='button' disable>Bags Sent</button>";
                                                }if ($value->region_to == $regionfrom && $value->despatch_status == 'Sent') {
                                                  
                                                  echo "<button class='btn btn-info btn-sm' type='button' disable>Bags Pending</button>";

                                                }if ($value->region_to == $regionfrom && $value->despatch_status == 'Received') {
                                                  
                                                  echo "<button class='btn btn-success btn-sm' type='button' disable>Bags Received</button>";

                                                }if ($value->region_from == $regionfrom && $value->despatch_status == 'Received') {
                                                  
                                                  echo "<button class='btn btn-success btn-sm' type='button' disable>Bags Delivery</button>";
                                                }

                                                ?>
                                              </td>
                                             
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                       <!--  <footer>
                                            <tr><td colspan="8"></td><td style="text-align: center;"><button type="submit" class="btn btn-info btn-sm">Save Information</button></td></tr>
                                        </footer> -->
                          </table>
                        </form>
                          </div>
                          <div class="table-responsive bagsList" style="display: none;">
                            <table id="example47" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Bag Number</th>
                                                <th>Bag Source</th>
                                                <th>Bag Destination</th>
                                                <th>Date Bag Created</th>
                                                <th>Total Item Number</th>
                                                <th>Bag Received By</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="bagresults">
                                           
                                       
                                        </tbody>
                                        
                                    </table>
                          </div>
                          <div class="table-responsive despatchIn1" style="display: none;">
                               <form method="POST" action="despatch_action">
                            <table id="despatchIn" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Despatch Number</th>
                                                <th>Number Of Bags</th>
                                                <th>Despatched Date</th>
                                                <th>Despatch Source</th>
                                                <th>Transport Type</th>
                                                <th>Transport Name</th>
                                                <th>Registration Number</th>
                                                <th>Despatch Status</th>
                                               <th>
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                          <?php foreach ($despatchIn as $value) {?>
                                            <tr>
                                              <td><a href="#" data-despno = "<?php echo $value->desp_no; ?>" class="bagsList12"><?php echo $value->desp_no; ?></a>
                                                </td>
                                              <td style="text-align: center;">
                                                <?php 
                                                     $bagno = $value->desp_no;
                                                      $db2 = $this->load->database('otherdb', TRUE);
                                                      $db2->where('despatch_no',$bagno);
                                                      $db2->from("bags");
                                                      echo $db2->count_all_results();
                                                  ?>
                                              </td>
                                               <td><?php echo $value->datetime; ?></td>
                                               <td><?php echo $value->region_from; ?></td> 
                                              <td><?php echo $value->transport_type; ?></td>
                                              <td><?php echo $value->transport_name; ?></td>
                                              <td><?php echo $value->registration_number; ?></td>
                                              <td style="text-align: center;">
                                                <?php 
                                                $regionfrom = $this->session->userdata('user_region');
                                                if ($value->region_from == $regionfrom && $value->despatch_status == 'Sent' ) {
                                                  
                                                  echo "<button class='btn btn-info' type='button' disable>Bags Sent</button>";
                                                }if ($value->bag_region == $regionfrom && $value->despatch_status == 'Sent') {
                                                  
                                                  echo "<button class='btn btn-warning' type='button' disable>Pending Bag</button>";

                                                }if ($value->bag_region == $regionfrom && $value->despatch_status == 'Received') {
                                                  
                                                  echo "<button class='btn btn-success' type='button' disable>Received Bag</button>";

                                                }if ($value->bag_region == $regionfrom && $value->despatch_status == 'Received') {
                                                  
                                                  echo "<button class='btn btn-success' type='button' disable>Delivery Bag </button>";

                                                }
                                                //echo $value->despatch_status;
                                                 ?>
                                                  
                                                </td>
                                             <td>
                                               <?php 
                                                $regionfrom = $this->session->userdata('user_region');
                                                if ($value->region_from == $regionfrom && $value->despatch_status == 'Sent' ) { ?>
                                                   <div class='form-check' style="padding-left: 53px;">
                                                  <input type='checkbox' class='form-check-input' id='remember-me' checked disabled="disabled">
                                                 <label class='form-check-label' for='remember-me'></label>
                                               </div>
                                               <?php }elseif ($value->bag_region == $regionfrom && $value->despatch_status == 'Sent') {?>
                                                  
                                                  <div class='form-check' style="padding-left: 53px;">
                                                      
                                                        <input type='checkbox' name='I' class='form-check-input checkSingle4 checkd' id='remember-me' value='<?php echo $value->desp_no ?>'>
                                                 <label class='form-check-label' for='remember-me'></label>
                                                      
                                                 </div>

                                               <?php }elseif ($value->region_to == $regionfrom && $value->despatch_status == 'Received') { ?>
                                                  
                                                  <div class='form-check' style="padding-left: 53px;">
                                                  <input type='checkbox' class='form-check-input' id='remember-me' checked disabled="disabled">
                                                 <label class='form-check-label' for='remember-me'></label>
                                               </div>

                                               <?php }elseif ($value->region_from == $regionfrom && $value->despatch_status == 'Received') {?>
                                                  
                                                  <div class='form-check' style="padding-left: 53px;">
                                                  <input type='checkbox' class='form-check-input' id='remember-me' checked disabled="disabled">
                                                 <label class='form-check-label' for='remember-me'></label>
                                               </div>

                                               <?php }
                                                //echo $value->despatch_status;
                                                 ?>
                                                   
                                                 </td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                       <footer>
                                            <tr><td colspan="8"></td><td style="text-align: center;"><button type="submit" class="btn btn-info">Receive Bag</button></td></tr>
                                        </footer>
                          </table>
                        </form>
                          </div>
                          </div>
                        </div>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
            </div> 
<script type="text/javascript">
    $(document).ready(function(){
        $("#show1").click(function(){
            alert('mussa');
        });
    });
</script>    
<script>
function transportType() {
  var ty = $('.type').val();

  if (ty == '') {
    alert('1');
  }else if(ty == 'Public Truck' || ty == 'Public Buses'){
    $('.cost').show();
  }else{
   $('.cost').hide();
  }
}
</script>
<script>
$(document).ready(function(){
  
  $(".ems1").click(function(){
    $(".ems").show();
    $(".mails").hide();
    $(".emsbags").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".item").click(function(){
    $(".ems").show();
    $(".mails").hide();
    $(".emsbags").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $("#mails").click(function(){
    $(".ems").hide();
    $(".mails").show();
    $(".emsbags").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".emsbags1").click(function(){
    $(".emsbags").show();
    $(".ems").hide();
    $(".mails").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".despatch").click(function(){
    $(".despatch1").show();
    $(".emsbags").hide();
    $(".ems").hide();
    $(".mails").hide();
    $(".itemlist").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".despatchIn").click(function(){
    $(".despatch1").hide();
    $(".despatchIn1").show();
    $(".emsbags").hide();
    $(".ems").hide();
    $(".mails").hide();
    $(".itemlist").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".listItems").hide();
  });
  
   $(".listitem").click(function(){
     
    var type = 'EMS';
    var bagno = $(this).attr('data-bagno');
    var reg   = $('.reg').val();

     $.ajax({
     
     url: "<?php echo base_url();?>Box_Application/bags_item_list",
     method:"POST",
     data:{bagno:bagno,type:type},//'region_id='+ val,
     success: function(data){

          $('.listresults').html(data);

          //$(".itemlist").show();
          $(".bags_item_list").show();
          $(".emsbags").hide();
          $(".ems").hide();
          $(".mails").hide();
          $(".despatch1").hide();
          $(".bagsList").hide();
          $(".despatchIn1").hide();
          $(".listItems").hide();

          //$('#fromServer').dataTable().clear();
          $('#fromServer').DataTable( {
        orderCellsTop: true,
        destroy:true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );


     }
 });

});
   $(".bagsList12").click(function(){
    
    var type = 'EMS';
    var despno = $(this).attr('data-despno');
    
     $.ajax({
     
     url: "<?php echo base_url();?>Box_Application/bags_list_despatch",
     method:"POST",
     data:{despno:despno,type:type},//'region_id='+ val,
     success: function(data){

          $('.bagresults').html(data);
          
          //$(".itemlist").show();
          $(".bags_item_list").hide();
          $(".bagsList").show();
          $(".emsbags").hide();
          $(".ems").hide();
          $(".mails").hide();
          $(".despatch1").hide();
          $(".despatchIn1").hide();
          $(".listItems").hide();
          //$('#example47').dataTable().destroy();
          $('#example47').DataTable( {
        //orderCellsTop: true,
        destroy:true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
          

     }
 });

});
    
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
    // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    // $('#example4 thead tr:eq(1) th').not(":eq(7),:eq(8)").each( function (i) {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
 
    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

    var table = $('#example4').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
    // //$('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
    // $('#example5 thead tr:eq(1) th').not(":eq(7),:eq(8)").each( function (i) {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
 
    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

    var table = $('#example5').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#despatch').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#despatchIn').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#kimeo').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#checkAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll").prop("checked", true);
            }     
        }
        else {
            $("#checkAll").prop("checked", false);
        }
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#checkAlls").change(function() {
        if (this.checked) {
            $(".checkSingles").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingles").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingles").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingles").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAlls").prop("checked", true);
            }     
        }
        else {
            $("#checkAlls").prop("checked", false);
        }
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#checkAll1").change(function() {
        if (this.checked) {
            $(".checkSingle1").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle1").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle1").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle1").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll1").prop("checked", true);
            }     
        }
        else {
            $("#checkAll1").prop("checked", false);
        }
    });
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
    $("#checkAll4").change(function() {
        if (this.checked) {
            $(".checkSingle4").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle4").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle4").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle4").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll4").prop("checked", true);
            }     
        }
        else {
            $("#checkAll4").prop("checked", false);
        }
    });
});
</script>
<?php $this->load->view('backend/footer'); ?>
