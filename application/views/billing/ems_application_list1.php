
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Application List</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Ems Application List </li>
        </ol>
    </div>
</div>
<!-- Container fluid  -->
<!-- ============================================================== -->
<?php $regionlist = $this->employee_model->regselect(); ?>
<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">
          <?php if($this->session->userdata('user_type') == "SUPERVISOR"){ ?>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Ems"> Ems Application</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>
          <?php }else{ ?>
		  <?php if($this->session->userdata('status') == "NotEnded" && $this->session->userdata('user_type') == "EMPLOYEE"){?>

		                 <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Ems"> Ems Application</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="#" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="#" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="#" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>

					<?php }else{ ?>

                      <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Ems"> Ems Application</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>

								<?php }?>

       <?php } ?>

     </div>
 </div>

 <div class="row">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"> Ems Application List  <span style="float: right;">
				<?php if($this->session->userdata('user_type') == 'EMPLOYEE'){ ?>
				<form method="POST" action="EndShift">
				<input type="hidden" name="emid" value="<?php echo $this->session->userdata('user_emid'); ?>"/>

				<button type="submit" class="btn btn-info">End Shift >>></button>
				</form>
				<?php } ?>
				</span>
            <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){ ?>
            <span style="float: right;"> <?php

            if (!empty(@$emid)) {
           echo "Employee Name :";
            @$id = @$emid;
            @$info = $this->employee_model->GetBasic($id); echo "[ PF:". '   '.@$info->em_code.'   '.@$info->first_name. '   '. @$info->middle_name.' '.@$info->last_name.  '  ]';
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "Assigned Job".'    [' ;
			foreach(@$getJob as $value){
				echo @$value->serv_name.' ,';

			}
			echo ']';
			echo '    ';
			echo @$getCounter->counter_name;

            }
			?>

      </span>


            <?php}else{?>

            <?php }?>
                </h4>
            </div>
            <div class="card-body">
                <div class="card">
                   <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" style="width: 100%;">
                              <input type="hidden" name="" id="emid" value="<?php echo @$emid; ?>">
                              
                                <tr>
                                    <th style="">
                                     <label>Select Date:</label>
                                     <div class="input-group">

                                        <input type="text" name="" class="form-control  mydatetimepickerFull">
                                        <input type="hidden" name="" class="form-control date" value="Date">
                                        <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required">
                                    </div>
                                </th>
                                <th>
                                 <label>Region and Branch:</label>
                                 <div class="input-group">
                                    <select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <select name="branch" value="" class="form-control custom-select"  id="branchdropo">
                                            <option>Select Branch</option>
                                        </select>
                                    <input type="button" name="" class="btn btn-success BtnRegBra" style="" id="" value="Search">
                                </div>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>

            <form method="POST" action="send_to_back_office">

                <div class="table-responsive">

                    <span class="table1">

                        <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                            <thead>
                              <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){?>
                              <?php }else{ ?>
								<?php if(empty($emslist)){?>
								<?php }else{ ?>
                                <tr><th colspan="9"></th><th colspan=""><div class="form-check" style="padding-left:60px;" id="showCheck">
                                <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                <label class="form-check-label" for="remember-me">All</label>
                                </div></th>
                                <th></th>
                                </tr>
								<?php }?>
                              <?php } ?>

                                 <tr>
                                    <th>Sender Name</th>
                                    <th>Registered Date</th>
                                    <th>Amount (Tsh.)</th>
                                    <th>Region Origin</th>
                                    <!-- <th>Branch Origin</th> -->
                                    <th>Destination</th>
                                    <!-- <th>Destination Branch</th> -->
                                    <th>Bill Number</th>
                                    <th>Tracking Number</th>
                                    <th>Transfer Status</th>
                                    <th style="text-align: right;">Payment Status</th>
                                    <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){?>
                              <?php }else{ ?>
                                    <th>
                                        Item Status
                                    </th>
                                    <th>
                                       Action
                                    </th>
                                  <?php } ?>
                                </tr>
                            </thead>

                            <tbody class="results">
                               <?php foreach ($emslist as  $value) {?>
                                   <tr>
                                      <td><a href="#" class="myBtn" data-sender_id="<?php echo $value->sender_id; ?>"><?php echo $value->s_fullname;?></a></td>
                                      <td><?php
                                      echo $value->date_registered;
                                      ?></td>
                                      <td><?php echo number_format($value->paidamount,2);?></td>
                                      <td><?php echo $value->s_region;?></td>
                                      <!-- <td><?php echo $value->s_district;?></td> -->
                                      <td><?php echo $value->r_region;?></td>
                                      <!-- <td><?php echo $value->branch;?></td> -->
                                      <td>
                          <?php if ($value->billid != '') {
                              echo "<a href='http://gw.posta.co.tz/api/qr/test.php?controlno=$value->billid'>".$value->billid."</a>";

                            $regionp = $value->s_region;
                            $rec_region = $value->r_region;
                            $source = $this->employee_model->get_code_source($regionp);
                            $dest = $this->employee_model->get_code_dest($rec_region);
                              @$bagsNo = $source->reg_code . $dest->reg_code;
                                 $last_id = $value->sender_id;
                                $first4 = substr($value->billid, 4);
                                $trackNo = $bagsNo.$first4;
                                            $data1 = array();
                                $data1 = array('track_number'=>$trackNo);

                                $this->billing_model->update_sender_info($last_id,$data1);
                                        }else{

      if ($value->billid == '' && $value->bill_status == 'PENDING' || $value->bill_status == 'SUCCESS' && $value->PaymentFor == 'EMS') {
                    $serial=$value->serial;
                    $paidamount=$value->paidamount;
                    $region=str_replace("'", '', $value->region);
                    $district=str_replace("'", '', $value->district);
                    $mobile = $value->Customer_mobile;
                    $renter = $value->cat_name;
                    $serviceId = $value->PaymentFor;

                    @$controNo = $this->Box_Application_model->getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId);
                      if (!empty($controNo->controlno)) {

                          $regionp = $value->s_region;
                          $rec_region = $value->r_region;
                          $source = $this->employee_model->get_code_source($regionp);
                            $dest = $this->employee_model->get_code_dest($rec_region);
                            $bagsNo = $source->reg_code . $dest->reg_code;
                            $last_id = $value->sender_id;
                          $first4 = substr($value->billid, 4);
                        $trackNo = $bagsNo.$first4;
                        $data1 = array();
                        $data1 = array('track_number'=>$trackNo);

                        $this->billing_model->update_sender_info($last_id,$data1);

                          echo $controNo->controlno;

                          }else{

                          }

                          }else{
                          echo strtoupper($value->s_pay_type);
                          }
                          }
                          ?>
                        </td>
                        <td>
                                    <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php
                                    echo $value->track_number;
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
                            <?php if($value->status == 'NotPaid'){
                                echo "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
                            }else{
                             echo "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                         }?>

                     </td>
                     <?php if($this->session->userdata('user_type') == "SUPERVISOR"){?>
                              <?php }else{ ?>
                    <td style = "text-align:center;">
                        <div class="form-check">"
                        <?php
                        if ($value->status == 'Paid' && $value->office_name == 'Counter'){
                        echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }elseif($value->status == 'Bill' && $value->office_name == 'Counter'){
                          echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }else{
                             echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }
                        ?>
                        </div>
                        </td>
                        <td style = "text-align:center;">
                        <a href="#" class="btn btn-info btn-sm getDetails" data-sender_id="<?php echo $value->sender_id ?>" data-receiver_id="<?php echo $value->receiver_id ?>" data-s_fullname="<?php echo $value->s_fullname ?>" data-s_address="<?php echo $value->s_address ?>" data-s_email="<?php echo $value->s_email ?>" data-s_mobile="<?php echo $value->s_mobile ?>" data-s_region="<?php echo $value->s_region ?>" data-r_fullname="<?php echo $value->fullname ?>" data-s_address="<?php echo $value->address ?>" data-r_email="<?php echo $value->email ?>" data-r_mobile="<?php echo $value->mobile ?>" data-r_region="<?php echo $value->r_region ?>" data-operator="<?php
                        $id = $value->operator;
                        $info = $this->employee_model->GetBasic($id);
                        echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name ?>" data-r_branch="<?php echo $value->branch ?>" data-s_branch="<?php echo $value->s_district ?>" data-billid="<?php echo $value->billid ?>" data-channel="<?php echo $value->paychannel ?>">Details</a>
                        </td>
                      <?php } ?>
</tr>
<?php } ?>

</tbody>
<tfooter>
<tr>
    <td colspan="9" style="text-align: right;">
      
    </td>
    <td><?php if(empty($emslist)){?>
                <?php }else{ ?>
                  <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){?>
  
  <input type="hidden" class="id" name="emid" id="emid" value="<?php echo @$emid; ?>">
    <button type="submit" class="btn btn-info">End Day >>></button>
   <?php echo $this->session->set_flashdata('item'); ?>
                              <?php }else{ ?>

<button type="submit" class="btn btn-info">Back Office >>> </button>
      
<?php } ?>
<?php }?>
</td>
    <td></td>
</tr>
</tfooter>
</table>
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
</div>
<div class="" style="float: right;padding-right: 30px;padding-bottom: 10px;">

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
                <h2 class="modal-title">EMS Item Information</h2>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
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
                        $(".sbranch").html($(this).attr("data-s_district"));
                        $(".rbrach").html($(this).attr("data-r_branch"));
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
                    // $('#fromServer').DataTable().ajax.reload();
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
    dom: 'Bfrtip',
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
<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
