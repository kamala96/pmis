
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Application Sent</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Ems Application Sent </li>
        </ol>
    </div>
</div>
<!-- Container fluid  -->
<!-- ============================================================== -->
<?php $regionlist = $this->employee_model->regselect(); ?>
<?php $ems_cat = $this->Box_Application_model->ems_cat(); ?>
<?php $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');  

    $id=$this->session->userdata('user_login_id'); $getInfo = $this->employee_model->GetBasic($id) ;
    ?>
<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">
          <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/document_parcel" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transaction</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                        <?php if($this->session->userdata('user_type') == "EMPLOYEE" ){ ?>
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_application_sent" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Sent to Backoffice</a></button>
                   <?php }?>
     </div>
 </div>

 <div class="row">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"> Ems Application List</h4>
            </div>
            <div class="card-body">
                <div class="card">
                   <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                           <table class="table table-bordered" style="width: 100%;">
                              
                              <input type="hidden" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>"/>
            <?php  if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {?>
<form action="Ems_Application_List" method="POST">
                                <tr>
                                    <th style="">
                                     <div class="input-group">
                                        
                                        <input type="text" name="date" class="form-control  mydatetimepickerFull" placeholder="Select Date">
                                        <input type="text" name="month" class="form-control  mydatetimepicker" placeholder="Select Month">
                                        <input type="submit" class="btn btn-success" style="" value="Search Date">

                                    </div>
                                </th>

                            </th>
                        </tr>
                        </form>
                      <?php }else { ?>
                        <?php if($this->session->userdata('user_type') == "SUPERVISOR" ){ ?>
                           <tr>
                                    <th style="">
                                     <label>Select Date:</label>
                                     <div class="input-group">

                                        <input type="text" name="" class="form-control  mydatetimepickerFull">
                                        <input type="hidden" name="" class="form-control date" value="Date">
                                        <!-- <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required"> -->
                                    </div>
                                </th>
                                <th>
                                 <label>Employee Name:</label>
                                 <div class="input-group">
                                    <select class="form-control custom-select emname">
                                      <option value="">--Select Employee--</option>
                                      <?php foreach($emselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th>
                            <th>
                                 <label>Agent Name:</label>
                                 <div class="input-group">
                                    <select class="form-control custom-select agname">
                                      <option value="">--Select Agent--</option>
                                      <?php foreach($agselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th>
                            <th>
                                 <label>&nbsp;</label>
                                 <div class="input-group">
                                    <input type="button" name="" class="btn btn-success BtnSuper" style="width: 100px;" id="" value="Search">
                                </div>
                            </th>
                        </tr>
                                  <?php }else{?>
                                     <tr>
                                <?php if($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP"){ ?>
                                    <form action="Ems_Application_List" method="POST">
                                    <th style="">
                                     <div class="input-group">

                                         <input type="text" name="date" class="form-control  mydatetimepickerFull" placeholder="Select Date">
                                        <input type="text" name="date2" class="form-control  mydatetimepickerFull" placeholder="Select Date  To">
                                        <input type="text" name="month" class="form-control  mydatetimepicker" placeholder="Select Month">
                                        <input type="text" name="month2" class="form-control  mydatetimepicker" placeholder="Select Month To">
                                        <select class="form-control custom-select" name="ems_type">
                                        <option>--Select Type--</option>
                                        <option value="EMS">EMS</option>
                                        <option value="LOAN BOARD">Loan Board</option>
                                    </select>
                                    <select id="years" class="form-control custom-select" name="year">
                                        <option>--Select Year--</option>
                                    </select>
                                    <select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    
                                        <button type="submit" class="btn btn-info">Search</button>
                                    </div>
                                </th>
                                </form>
                                <?php }else{?>
                        <?php }?>
                        </tr>
                                  <?php } ?>

                       
                      <?php } ?>

                    </table>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
</div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>

            <form method="POST" action="<?php echo base_url();?>Box_Application/send_to_back_office">

                <div class="table-responsive">

                    <span class="table1">

                        <table id="example4" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
								<?php if(empty($emslist)){?>
								<?php }else{ ?>
                                <!-- <tr><th colspan="9"></th><th colspan=""></th>
                                <th></th>
                                </tr> -->
								<?php }?>
                                 <tr>
                                    <th>Sender Name</th>
                                    <th>Registered Date</th>
                                    <th>Amount (Tsh.)</th>
                                    <th>Weight</th>
                                    <th>Region Origin</th>
                                    <th>Branch Origin</th>
                                    <th>Address Type</th>
                                    <th>Destination</th>
                                    <th>Bill Number</th>
                                    <th>Tracking Number</th>
                                    <th>Transfer Status</th>
                                    <th style="text-align: right;">Payment Status</th>
                                <?php if($this->session->userdata('user_type') == "ACCOUNTANT"){?>
                                <?php }else{ ?>
                                    <th>
                                <div class="form-check" style="padding-left:50px;" id="showCheck">
                                <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                <label class="form-check-label" for="remember-me">All</label>
                                </div>
                                    </th>
                                    <th>
                                       Action
                                    </th>
                                <?php } ?>
                                
                                </tr>
                            </thead>

                            <tbody class="">
                               <?php foreach ($emslist as  $value) {?>
                                   <tr>
                                      <td><a href="#" class="myBtn" data-sender_id="<?php echo $value->sender_id; ?>"><?php echo $value->s_fullname;?></a></td>
                                      <td><?php
                                      echo $value->date_registered;
                                      ?></td>
                                      <td><?php echo $value->paidamount; ?></td>
                                      <td><?php echo $value->weight;?></td>
                                      <td><?php echo $value->s_region;?></td>
                                      <td><?php echo $value->s_district;?></td>
                                      <td><?php echo $value->add_type;?></td>
                                      <td><?php echo $value->r_region;?></td>
                                      <td> 
                                        <?php if ($value->s_pay_type == "Cash") {
                                            echo $value->billid;
                                             if(empty($value->billid)){
                                                 $serial = $value->serial;
                                                 $amount = $value->paidamount;
                                                 $id = $value->sender_id;
                                                 $this->Box_Application_model->getControlNumber($serial,$amount,$id);
                                             }
                                            $serial = $value->serial;
                                                $amount = $value->paidamount;
                                                //$this->Box_Application_model->getUpdatePaymentEMS($serial,$amount);
                                        } else {
                                            echo strtoupper($value->s_pay_type);
                                        }
                                         ?>
                                      </td>
                                        <td>
                                    <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php
                                    echo $value->track_number;

                                    if ($value->s_pay_type== "Cash") {
                                     $trackno = $value->track_number;
                                    $controlno = $value->billid;
                                    $id = $value->sender_id;
                                    $this->Box_Application_model->update_tracking_number($id ,$controlno,$trackno);
                                    } else {
                                    // $trackno = $value->track_number;
                                    // $controlno = rand(1000000,2000000);
                                    // $id = $value->sender_id;
                                    // $this->Box_Application_model->update_tracking_number1($id ,$controlno,$trackno);
                                    }
                                    
                                    
                                    ?>
                                </a>

                            </td>
                            <td>
                                <?php if ($value->office_name == 'Received') {?>
                                    <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Successfully Transfer</button>
                                <?php }else{ ?>
                                   <button type="button" class="btn btn-danger btn-sm" disabled="disabled"> Pending To Back Office</button>
                               <?php }?>

                           </td>

                           <td style="text-align: right;">
                            <?php 
                            if ($value->s_pay_type == "Cash") {
                               if($value->status == 'NotPaid'){
                                echo "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
                            }else{
                             echo "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                         }
                            } else {
                               echo "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                            }
                            
                            ?>

                     </td>
                    <?php if($this->session->userdata('user_type') == "ACCOUNTANT"){?>
                                <?php }else{ ?>
                                    <td style = "text-align:center;">
                        <div class="form-check">"
                        <?php
                        if ($value->s_pay_type == "Cash") {
                            if ($value->status == 'Paid' && $value->office_name == 'Counter'){
                        echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }elseif($value->status == 'Bill' && $value->office_name == 'Counter'){
                          echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }else{
                             echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
                            <label class='form-check-label' for='remember-me'></label>";
                        }
                        } else {
                           if ($value->s_pay_type != 'Cash' && $value->office_name == 'Counter'){
                        echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                       
                        }else{
                             echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
                            <label class='form-check-label' for='remember-me'></label>";
                        }
                        }
                        
                        ?>
                        </div>
                        </td>
                        <td style = "text-align:center;">
                        <a href="#" class="btn btn-info btn-sm getDetails" data-sender_id="<?php echo $value->sender_id ?>" data-receiver_id="<?php echo $value->receiver_id ?>" data-s_fullname="<?php echo $value->s_fullname ?>" data-s_address="<?php echo $value->s_address ?>" data-sbranch="<?php echo $value->s_district ?>" data-rbranch="<?php echo $value->branch ?>" data-s_email="<?php echo $value->s_email ?>" data-s_mobile="<?php echo $value->s_mobile ?>" data-s_region="<?php echo $value->s_region ?>" data-r_fullname="<?php echo $value->fullname ?>" data-s_address="<?php echo $value->address ?>" data-r_email="<?php echo $value->email ?>" data-r_mobile="<?php echo $value->mobile ?>" data-r_region="<?php echo $value->r_region ?>" data-operator="<?php
                        $id = $value->operator;
                        $info = $this->employee_model->GetBasic($id);
                        echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name ?>" data-billid="<?php echo $value->billid ?>" data-channel="<?php echo $value->paychannel ?>">Details</a>
                        </td>
                                <?php } ?>
                    
</tr>
<?php } ?>

</tbody>
<footer>
  <?php if($this->session->userdata('status') != "Assign" && $this->session->userdata('user_type') == "EMPLOYEE"){?>
    <tr>
    <td colspan="14">
    <?php if(empty($emslist)){?>
        <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">End Shift >>></button></span>
    <?php }else{ ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        <span ><b>Total Amount ::</b>&nbsp;&nbsp;</span>
    <?php echo number_format($total->paidamount,2);?>
      <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift" disabled="disabled">End Shift >>></button></span>
    <span style="float: right;"><button type="submit" class="btn btn-info" disabled="disabled">Back Office >>></button>
    <button type="submit" class="btn btn-info" disabled="disabled" name="qr" value="qrcode">Print QR Code >>></button></span>
    <?php }?>
 </td>
</tr>
  <?php }else{?>
    <?php if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM"){?>
        <tr>
            <td>&nbsp;</td>
             <td style="font-size: 20px;"><text><b>Total Amount::</b></text></td>
              <td style="font-size: 20px;"><b> <?php echo number_format(@$total->paidamount,2);?></b></td>
                <td>&nbsp;</td>
                 <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                   <td>&nbsp;</td>
                     <td>&nbsp;</td>
        </tr>
        <?PHP }else{?>
             <tr>
    
    <td colspan="14">
    <?php if(empty($emslist)){?>
        <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">End Shift >>></button></span>
    <?php }else{ ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        <span ><b>Total Amount ::</b>&nbsp;&nbsp;</span>
    <?php echo number_format($total->paidamount,2);?>
      <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">End Shift >>></button></span>
    <span style="float: right;"><button type="submit" class="btn btn-info">Back Office >>></button>
        <button type="submit" class="btn btn-info" name="qr" value="qrcode">Print QR Code >>></button></span>
    <?php } ?>
 </td>
</tr>
        <?php } ?>
   
  <?php }?>

</footer>
</table>
<!-- <br><br>
<?php if(empty($emslist)){?>
								<?php }else{ ?>
                                <table style="width: 100%;">
  <tr>
    <td colspan="" style="text-align: right;"></td>
    <td colspan=""></td>
    <td colspan="">

 </td>
 <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){?>
  <td colspan="11" style="text-align: right;">
  <input type="hidden" class="id" name="emid" id="emid" value="<?php echo @$emid; ?>">
    <button type="submit" class="btn btn-info">End Day >>></button>
   <?php echo $this->session->set_flashdata('item'); ?>
                              <?php }else{ ?>

<td colspan="11" style="text-align: right;"><button type="submit" class="btn btn-info">Back Office >>> </button>
			</td>
<?php } ?></tr>
</table>
								<?php }?> -->

</span>

<span class="table2" style="display: none;">
<span class="results"></span>
</span>
</div>

<!-- <input type="hidden" name="emid" id="emid" value="<?php echo $emid; ?>"> -->
<input type="hidden" name="type" value="EMS">
</form>
</div>
</div>

</div>
</div>

</div>

</div>
</div>
<div class="modal fade" id="myModal" role="dialog" style="padding-top: 100px;">
<div class="modal-dialog modal-lg">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <form role="form" action="ems_action_receiver" method="post" onsubmit='disableButton()'>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <h3>Step 3 of 4  - Reciever Personal Details</h3>
            </div>

            <div class="col-md-6">
                <label>Full Name:</label>
                <input type="text" name="r_fname" id="r_fname" class="form-control" onkeyup="myFunction()" required="required">
            </div>
            <div class="col-md-6">
                <label>Address:</label>
                <input type="text" name="r_address" id="r_address" class="form-control" onkeyup="myFunction()" required="required">
            </div>
            <div class="col-md-6">
                <label>Email:</label>
                <input type="email" name="r_email" id="r_email" class="form-control" onkeyup="myFunction()">
            </div>
            <div class="col-md-6">
                <label>Mobile Number</label>
                <input type="mobile" name="r_mobile" id="r_mobile" class="form-control" onkeyup="myFunction()" required="required">
            </div>
            <div class="col-md-6">
                <label class="control-label">Region</label>
                <select name="region_to" value="" class="form-control custom-select" required id="rec_region" onChange="getRecDistrict();" required="required">
                    <option value="">--Select Region--</option>
                    <?Php foreach($regionlist as $value): ?>
                    <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label>Reciever Branch</label>
            <select name="district" value="" class="form-control custom-select"  id="rec_dropp" required="required">
                <option>--Select Branch--</option>
            </select>

        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <label>Selection Type</label>
            <select class="form-control custom-select wgt" name="weight_sel" onChange="getSelect();">
                <option value="same">Same Weight</option>
                <option value="diff">Different Weight</option>
            </select>
        </div>
    </div>
    <div class="row select" style="display: none;">
        <div class="col-md-6">
            <label>Ems Type</label>
                                    <select name="emsname" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
        </div>
        <div class="col-md-6">
            <label>Ems Tariff Category:</label>
                                    <select name="emscattype" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();">
                                        <option value="0">--Select Category--</option>
                                        <?Php foreach($ems_cat as $value): ?>
                                             <option value="<?php echo $value->cat_id ?>"><?php echo $value->cat_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
        </div>
        <div class="col-md-6">
           <label>Weight Step in KG:</label>
                            <input type="number" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()">
        </div>
    </div>
    <br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
   
</div>
<div class="row" style="float: right;padding-right: 30px;padding-bottom: 10px;">

    <input type="hidden" name="id" id="comid">
    <button type="submit" class="btn btn-info pull-left"><span class="glyphicon glyphicon-remove"></span>Save Information</button>
    <button type="submit" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
</div>
</form>
</div>
<div class="modal-footer">

</div>

</div>
</div>
    <div id="myModal1" class="modal fade" role="dialog" style="padding-top:200px; font-size:24px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">EMS Information</h2>
                </div>
                <div class="modal-body">
                <table class="table table-bordered table-striped" width="100%">
                        <tr>
                          <th colspan="2">SENDER INFORMATION</th>
                        </tr>
                        <tr><td>Fullname::</td><td><span class="sfname"></span></td></tr>
                        <tr><td>Address::</td><td><span class="saddress"></span></td></tr>
                        <tr><td>Email::</td><td><span class="semail"></span></td></tr>
                        <tr><td>Mobile::</td><td><span class="smobile"></span></td></tr>
                        <tr><td>Region::</td><td><span class="sregion"></span></td></tr>
                        <tr><td>Branch::</td><td><span class="sbranch"></span></td></tr>
                        <tr><th colspan="2"></th></tr>
                        <tr>
                          <th colspan="2">RECEIVER INFORMATION</th>
                        </tr>
                        <tr><td>Fullname::</td><td><span class="rfname"></span></td></tr>
                        <tr><td>Address::</td><td><span class="raddress"></span></td></tr>
                        <tr><td>Email::</td><td><span class="remail"></span></td></tr>
                        <tr><td>Mobile::</td><td><span class="rmobile"></span></td></tr>
                        <tr><td>Region::</td><td><span class="rregion"></span></td></tr>
                        <tr><td>Branch::</td><td><span class="rbranch"></span></td></tr>
                        <tr><th colspan="2"></th></tr>
                        <tr>
                          <th colspan="2">PAYMENT INFORMATION</th>
                        </tr>
                        <tr><td>Bill Number::</td><td><span class="billid"></span></td></tr>
                        <tr><td>Channel::</td><td><span class="channel"></span></td></tr>
                        <tr><th colspan="2"></th></tr>
                        <tr>
                          <th colspan="2">OPERATOR INFORMATION</th>
                        </tr>
                        <tr><td>Fullname::</td><td><span class="operator"></span></td></tr>
                      </table>
                </div>
                </div>
                </div>
                </div>
<div id="myModalEndDay" class="modal fade" role="dialog" style="padding-top:200px; font-size:24px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Ending Job Process</h2>
                </div>
                <div class="modal-body">
                  <h3 style="color:red;">You Cant End This Day Until She/He Complete Task</h3>
                </div>
                </div>
                </div>
                </div>
<div id="myModalEndDay2" class="modal fade" role="dialog" style="padding-top:200px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Ending Job Process</h2>
                </div>
                <div class="modal-body">
                  <form name="" action="<?php echo base_url();?>Employee/Assign_job" method="post">
                  <h3 style="color:red;">Successfully Transaction.</h3>
                  <?php $sup_service = $this->organization_model->get_services_super(); ?>
                  <label>Select Job To Assign[Day Task]</label>
                  <select class="custom-select form-control" name="job" required="required">
                    <option value="">--Select Job--</option>

                  <?php foreach($sup_service as $value){?>
                     <option><?php echo $value->serv_name; ?></option>
                  <?php } ?>
                  </select>
                <br><br>
                  <div class="" style="float: right;padding-bottom: 10px;">

    <input type="hidden" name="empid" id="empid">
    <button type="submit" class="btn btn-info pull-left"><span class="glyphicon glyphicon-remove"></span>Save Information</button>
    <button type="submit" class="btn btn-warning pull-left" data-dismiss="modal">Cancel</button>
</div>
</form>
                </div>

                </div>
                </div>
                </div>
                <script>
                $(document).ready(function(){
                    $(".getDetails").click(function(){
                        $(".sfname").html($(this).attr("data-s_fullname"));
                        $(".saddress").html($(this).attr("data-s_address"));
                        $(".semail").html($(this).attr("data-s_email"));
                        $(".smobile").html($(this).attr("data-s_mobile"));
                        $(".sregion").html($(this).attr("data-s_region"));
                        $(".rfname").html($(this).attr("data-r_fullname"));
                        $(".raddress").html($(this).attr("data-r_address"));
                        $(".remail").html($(this).attr("data-r_email"));
                        $(".rmobile").html($(this).attr("data-r_mobile"));
                        $(".rregion").html($(this).attr("data-r_region"));
                        $(".sbranch").html($(this).attr("data-sbranch"));
                        $(".rbranch").html($(this).attr("data-rbranch"));
                        $(".operator").html($(this).attr("data-operator"));
                        $(".channel").html($(this).attr("data-channel"));
                        $(".billid").html($(this).attr("data-billid"));

                        $("#myModal1").modal();
                        });
                        });
                        </script>
<!-- <script>
$('form').submit(function(){
    $(this).find('button[type=submit]').prop('disabled', true);
});
</script> -->
<script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 2019; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
</script>
<script>
function getPriceFrom() {

 var weight = $('#weight').val();
  var tariffCat  = $('#tariffCat').val();
if (weight == '') {

}else{
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}

    }
</script>
<script type="text/javascript">
function getEMSType() {

var tariffCat = $('.catid').val();
var weight = $('.catweight').val();

if (weight == '') {

}else{
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}

};
</script>
<script>
$(document).ready(function() {

    $(".BtnSubmit").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('#emid').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate1",
                 data:'date_time='+ datetime +'&emid='+ emid,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      ordering:false,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                       lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                       dom: 'lBfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                    }
                });
            });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnSuper").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('.emname').val();
     var emidag = $('.agname').val();
    
     console.log(datetime);
                // alert(datetime);
                $.ajax({

                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate1",
                 data:'date_time='+ datetime +'&emid='+ emid+'&emidag='+ emidag,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      ordering:false,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                       lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                       dom: 'lBfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                }
            });
        });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnSubmit1").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('#emid').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate2",
                 data:'date_time='+ datetime +'&emid='+ emid,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                      dom: 'Bfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                    }
                });
            });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnRegBra").on("click", function(event) {

     event.preventDefault();

     var region = $('#regiono').val();
     var branch = $('#branchdropo').val();
     //var date   = $('.date').val();
	 var emid = $('#emid').val();
     console.log(region);
                // alert(region);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSRegionBranch",
                 data:'region='+ region +'&branch='+ branch +'&emid='+ emid,
                 success: function(response) {

                    $('.table2').show();
                    $('.table1').hide();
                    $('.results').html(response);

                    $('#fromServer').DataTable( {
                      destroy: true,
                      ordering:false,
                      order: [[3,"desc" ]],
                      fixedHeader: false,
                      lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                      dom: 'lBfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
                  } );
                        //$('#fromServer').dataTable().clear();
                    }
                });
            });
});
</script>
<script type="text/javascript">
$('#boxtype').on('change', function() {
    if ($('#boxtype').val() == 'Individual') {
        $('#indv').show();
        $('#sectors').hide();
        $('#error1').html('');
    }if ($('#boxtype').val() == 'Government Ministries and Large Business/Inst.') {
        $('#sectors').show();
        $('#indv').hide();
        $('#error1').html('');
        $('#results').html($('#boxtype').val());
    }if ($('#boxtype').val() == 'Government Department') {
        $('#sectors').show();
        $('#indv').hide();
        $('#error1').html('');
        $('#results').html($('#boxtype').val());
    }if ($('#boxtype').val() == 'Religious/Education Inst,Small Business and NGOs') {
        $('#sectors').show();
        $('#indv').hide();
        $('#error1').html('');
        $('#results').html($('#boxtype').val());
    }if ($('#boxtype').val() == 'Primary Schools') {
        $('#sectors').show();
        $('#indv').hide();
        $('#error1').html('');
        $('#results').html($('#boxtype').val());
    }

//$('#showdiv' + this.value).show();
});
</script>
<script type="text/javascript">
function getRecDistrict() {
    var val = $('#rec_region').val();
    $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetBranch",
     data:'region_id='+ val,
     success: function(data){
         $("#rec_dropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
function getSelect() {
    var val = $('.wgt').val();
    if(val == 'same'){
        $('.select').hide();
    }else{
        $('.select').show();
    }
};
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
            $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select PostBox Category');
            }else{
                $('#div2').show();
                $('#div1').hide();
            }
        }
    });
    $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
    });
    $('#2step').on('click',function(){
        if ($('#fname').val() == '') {
            $('#errfname').html('This field is required');
        }else if($('#mname').val() == ''){
            $('#errmname').html('This field is required');
        }else if($('#lname').val() == ''){
            $('#errlname').html('This field is required');
        }else if($('#occu').val() == ''){
            $('#erroccu').html('This field is required');
        }else{
            $('#div2').hide();
            $('#div3').show();
        }
    });
    $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
    });
});

//save data to databse
$('#btn_save').on('click',function(){

var boxtype   = $('#boxtype').val();
var tariffCat = $('#tariffCat').val();
var fname     = $('#fname').val();
var mname     = $('#mname').val();
var lname     = $('#lname').val();
var gender    = $('#gender').val();
var occu      = $('#occu').val();
var region    = $('#regionp').val();
var district   = $('#branchdropp').val();
var email     = $('#email').val();
var phone     = $('#phone').val();
var mobile    = $('#mobile').val();
var residence   = $('#residence').val();

if (district == '') {
    $('#errdistrict').html('This field is required');
}else if(residence == ''){
    $('#errresidence').html('This field is required');
}else if(email == ''){
    $('#erremail').html('This field is required');
}else if(phone == ''){
    $('#errphone').html('This field is required');
}else if(mobile == ''){
    $('#errmobile').html('This field is required');
}else{

    $.ajax({
        type : "POST",
        url  : "<?php echo base_url('Box_Application/Register_Box_Action')?>",
        dataType : "JSON",
        data : {boxtype:boxtype,fname:fname,mname:mname,lname:lname,gender:gender,occu:occu,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence,tariffCat:tariffCat},
        success: function(data){

            $('[name="vehicle_no"]').val("");
            $('[name="vehicle_id"]').val("");

            $('#div4').show();
            $('#div3').hide();
            $('#majibu').html(data);
               /// $('#Modal_Edit').modal('hide');
               show_product();
           }
       });
    return false;
}
});


</script>

<script type="text/javascript">
function getDistrict() {
    var val = $('#regionp').val();
    $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdropp").html(data);
     }
 });
};
</script>

<script type="text/javascript">
function getTariffCategory() {

 var val = $('#boxtype').val();
 $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/GetTariffCategory",
     data:'bt_id='+ val,
     success: function(data){
        $('#tariffCat').html(data);
        $('#indv').show();
        $('#error1').html('');
    }
});
};
</script>


<script type="text/javascript">
function getBoxnumber() {

    var val = $('#box_number').val();
    if (val == 0) {

    }else{

     $.ajax({
         type: "POST",
         url: "<?php echo base_url();?>Box_Application/UpdateBoxFull",
         data:'box_id='+ val,
         success: function(data){
     //$("#branchdropp").html(data);
 }
});

 }
};
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
    $("#checkAll3").change(function() {
        if (this.checked) {
            $(".checkSingle3").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle3").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle3").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle3").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll3").prop("checked", true);
            }
        }
        else {
            $("#checkAll3").prop("checked", false);
        }
    });
});
</script>
<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>
<script>
$(document).ready(function(){
  $(".myBtn").click(function(){

    var text1 = $(this).attr('data-sender_id');
    $('#comid').val(text1);
    $("#myModal").modal();
});
});
</script>
<script>
$(document).ready(function(){
  $(".myBtnEndDay").click(function(){

    //var text1 = $(this).attr('data-sender_id');
    var emid = $('.id').val();
     $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/send_to_back_office",
                 data:'emid='+ emid,
                 success: function(response) {
                    //$('.results').html(response);
                    if ($.trim(response) == "No") {
                       $("#myModalEndDay").modal();
                    }else{
                      $("#myModalEndDay2").modal();
                      $("#empid").val(emid);
                    }
                  }
                });

});
});
</script>
<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({

     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>
<!-- <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script> -->
<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
