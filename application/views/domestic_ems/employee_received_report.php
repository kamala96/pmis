
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader-img.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}

#btn_save:focus{
  outline:none;
  outline-offset: none;
}

.button {
    display: inline-block;
    padding: 6px 12px;
    margin: 20px 8px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    background-image: none;
    border: 2px solid transparent;
    border-radius: 5px;
    color: #000;
    background-color: #b2b2b2;
    border-color: #969696;
}

.button_loader {
  background-color: transparent;
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #969696;
  border-bottom: 4px solid #969696;
  width: 35px;
  height: 35px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  99% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  99% { transform: rotate(360deg); }
}



    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }

    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,.8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }

    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>




<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>Received Transactions Reports</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Employee Received Transactions Report </li>
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

    $id=$this->session->userdata('user_login_id'); $getInfo = $this->employee_model->GetBasic($id);
    ?>
<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">

                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Ems_Domestic/employee_report" class="text-white"><i class="" aria-hidden="true"></i>  Transaction Report</a></button>
                    
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Ems_Domestic/employee_received_report" class="text-white"><i class="" aria-hidden="true"></i>  Transaction Received Report</a></button>


                     <!-- 
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button> -->

     </div>
 </div>

 <div class="row">
    <div class="col-12">
        <div class="card card-outline-info">
           
            <div class="card-body">
                <div class="card">
                   <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <form action="employee_report" method="POST"> -->

                            <table class="table table-bordered" style="width: 100%;">
                              
                              <input type="hidden" name="emid" class="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>"/>
           
                        <?php if($this->session->userdata('user_type') == "ADMIN" ){ ?>
                           <tr>
                                    <th style="">
                                     <label>Select Date:</label>
                                     <div class="input-group">

                                        <input type="text" name="date" class="form-control  mydatetimepickerFull" id="mydatetimepickerFull">
                                        <input type="hidden" name="" class="form-control date" value="Date">
                                        <!-- <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required"> -->
                                    </div>
                                </th>
                               <th>
                                 <label>Employee Name:</label>
                                 <div class="input-group">
                                    <select  name="emid" class="form-control custom-select emname">
                                      <option value="">--Select Employee--</option>
                                      <?php foreach($emselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th>
                           <!--  <th>
                                 <label>Agent Name:</label>
                                 <div class="input-group">
                                    <select class="form-control custom-select agname">
                                      <option value="">--Select Agent--</option>
                                      <?php foreach($agselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th> -->
                            <th>
                                 <label>&nbsp;</label>
                        <div class="">
                          <!--   <form id="org_reg" onsubmit="alert('form submitted')">
  <input type="button"  value="Register" id="org_reg_submit_button" class="reg_input" maxlength="100" onclick="org_reg_submit()">
  
</form> -->


                            <button class="btn btn-info btn-md disable BtnSuper" id="BtnSuper" type="button" >Search</button>
                           <!--  <button id="hellobutton">Hello</button>
                                    <input type="button" name="" class="btn btn-success BtnSuper456 disable" style="width: 100px;" id="" value="Search456">-->
                                </div> 
                            </th>
                        </tr>
                                  <?php }else{?>


                                      <tr>
                                    <th style="">
                                     <label>Select Date:</label>
                                     <div class="input-group">

                                        <input type="text" name="date" class="form-control  mydatetimepickerFull" id="mydatetimepickerFull">
                                        <input type="hidden" name="" class="form-control date" value="Date">
                                        <!-- <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required"> -->
                                    </div>
                                </th>
                              <!--   <th>
                                 <label>Employee Name:</label>
                                 <div class="input-group">
                                    <select class="form-control custom-select emname">
                                      <option value="">--Select Employee--</option>
                                      <?php foreach($emselect as $value){?>
                                      <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.'    '.$value->middle_name.'    '.$value->last_name ?></option>
                                    <?php }?>
                                    </select>
                                </div>
                            </th> -->
                          
                            <th>
                                 <label>&nbsp;</label>
                                 <div class="">
                                      <!-- <button class="btn btn-info btn-md disable BtnSuper" id="BtnSuper456" type="button">Search456</button> -->
                                      <button class="btn btn-info btn-md disable BtnSuper" id="BtnSuper" type="button" >Search</button>
                                    <!-- <input type="button" name="" class="btn btn-success  " style="width: 100px;" id="" value="Search"> -->
                                </div>
                            </th>
                        </tr>


                                  <?php }?>

                       

                    </table>
                <!-- </form> -->
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

            <form method="POST" action="send_to_back_office">

                <div class="table-responsive">

                    <span class="table1">

                        <table id="example4" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <?php if(empty($emslist)){?>
                                <?php }else{ //echo 'HIYO'.json_encode($emslist)
                             ?>

                                <!-- <tr><th colspan="9"></th><th colspan=""></th>
                                <th></th>
                                </tr> -->
                                <?php }?>
                                 <tr>
                                    <th>Sender Name</th>
                                    <th>Receiver Name</th>
                                    <th>Registered Date</th>
                                    <th>Amount (Tsh.)</th>
                                   <!--  <th>Weight</th> -->
                                    <th>Region Origin</th>
                                    <th>Branch Origin</th>
                                    <th>Destination Region</th>
                                     <th>Destination Branch</th>
                                    <!-- <th>Receiver Box Type</th> -->
                                    <th>Bill Number</th>
                                    <th>Tracking Number</th>
                                     <th>Barcode Number</th>
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

                               <!-- <?php if (!empty($emslist[0]->date_registered)) { }?> -->
                                <?php if (!empty($emslist)) { 
                                foreach ($emslist as  $value) { $value = (object)$value;?>
                                   <tr>
                                      <td>
                                       <!--  <a href="#" class="myBtn" data-sender_id="<?php echo $value->sender_id; ?>"><?php echo $value->s_fullname;?></a> -->

                                          <!-- <a href="#myModal" class="btn btn-sm" data-toggle="modal" data-code='<?php echo number_format($value->paidamount,2);  ?>'
                                              data-serial="<?php echo $value->billid; ?>" data-company="<?php echo $value->billid; ?>"> -->
                                              <?php echo $value->s_fullname; ?>
                                                
                                            <!--   </a> -->





                                      </td>
                                      <td><?php
                                      echo $value->fullname;
                                      ?></td>
                                      <td><?php
                                      echo $value->date_registered;
                                      ?></td>
                                      <td><?php echo $value->paidamount; ?></td>
                                      <!-- <td><?php echo $value->weight;?></td> -->
                                      <td><?php echo $value->s_region;?></td>
                                      <td><?php echo $value->s_district;?></td>
                                      <td><?php echo $value->r_region;?></td>
                                      <td><?php echo $value->branch;?></td>
                                      <!-- <td><?php echo $value->receivertype;?></td> -->
                                      <td><?php echo $value->billid;?></td>
                                     <!--  <td> 
                                        <?php if ($value->s_pay_type == "Cash") {
                                            echo $value->billid;
                                             if(empty($value->billid)){
                                                 $serial = $value->serial;
                                                 $amount = $value->paidamount;
                                                 $id = $value->id;
                                                 $this->Box_Application_model->getControlNumber($serial,$amount,$id);
                                             }
                                            $serial = $value->serial;
                                                $amount = $value->paidamount;
                                                $this->Box_Application_model->getUpdatePaymentEMS($serial,$amount);
                                        } else {
                                            echo strtoupper($value->s_pay_type);
                                        }
                                         ?>
                                      </td> -->
                                        <td>
                                    <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php
                                    echo $value->track_number;
                                    ?>
                                </a>

                            </td>
                             <td><?php echo $value->Barcode;?></td>
                            <td>
                                <?php if ($value->office_name == 'Received') {?>
                                    <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Successfully Received</button>
                                <?php }else{ ?>
                                   <button type="button" class="btn btn-danger btn-sm" disabled="disabled"> Back Office</button>
                               <?php }?>

                           </td>

                           <td style="text-align: right;">
                            <?php 
                             if($value->status == 'NotPaid'){
                                echo "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
                            }else{
                             echo "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                         }
                         //    if ($value->s_pay_type == "Cash") {
                         //       if($value->status == 'NotPaid'){
                         //        echo "<button class='btn btn-danger btn-sm' disabled>Not Paid</button>";
                         //    }else{
                         //     echo "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                         // }
                         //    } else {
                         //       echo "<button class='btn btn-success btn-sm' disabled>Paid</button>";
                         //    }
                            
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
                        echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name ?>" data-billid="<?php echo $value->billid ?>" 
                      
                        >Details</a>

                          <!-- data-channel="<?php echo $value->paychannel ?>" -->
                        </td>
                                <?php } ?>
                    
</tr>
<?php }} else{ ?>
  <tr>
<td colspan='15' style='color:red;text-align:center;'>No Transaction today</td></tr>";

<?php } ?>

</tbody>
<footer>
  <?php if($this->session->userdata('status') != "Assign" && $this->session->userdata('user_type') == "EMPLOYEE"){?>
    <tr>
    <td colspan="12">
    <?php if(empty($emslist)){?>
        <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">End Shift >>></button></span>
    <?php }else{ ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        <span ><b>Total Amount ::</b>&nbsp;&nbsp;</span>
    <?php echo number_format($total,2);?>
      <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <!-- <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift" disabled="disabled">End Shift >>></button></span> -->
    <!-- <span style="float: right;"><button type="submit" class="btn btn-info" disabled="disabled">Back Office >>></button> -->
    <!-- <button type="submit" class="btn btn-info" disabled="disabled" name="qr" value="qrcode">Print QR Code >>></button></span> -->
    <?php }?>
 </td>
</tr>
  <?php }else{?>
    <?php if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM"){?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
             <td style="font-size: 20px;"><text><b>Total Amount::</b></text></td>
              <td style="font-size: 20px;"><b> <?php echo number_format(@$total,2);?></b></td>
                <td>&nbsp;</td>
                 <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                   <td>&nbsp;</td>
                     <td>&nbsp;</td>
        </tr>
        <?PHP }else{?>
             <tr>
    
    <td colspan="12">
    <?php if(empty($emslist)){?>
        <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">End Shift >>></button></span>
    <?php }else{ ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span ><b>Total Amount ::</b>&nbsp;&nbsp;</span>
    <?php echo number_format($total,2);?>
      <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <!-- <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">End Shift >>></button></span> -->
    <!-- <span style="float: right;"><button type="submit" class="btn btn-info">Back Office >>></button> -->
        <!-- <button type="submit" class="btn btn-info" name="qr" value="qrcode">Print QR Code >>></button></span> -->
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


<!-- <script>
  function org_reg_submit(){
        alert("hi");
        document.getElementById("org_reg").submit();
}
</script> -->

<!-- <script type="text/javascript">
    

          $('.BtnSuper').on("click", edValueKeyPress() {
             alert('kwanza2');
         }
     );

  function edValueKeyPress() {
    //event.preventDefault();
  
                 alert('kwanza');

             }
         
         </script> -->
        <!--  <script>

function hello() {
alert('Hello');
}
document.getElementById("BtnSuper456").addEventListener("click", hello);
</script> -->
<script type="text/javascript">
$(document).ready(function() {



    $('.BtnSuper').on("click", function(event) {

     event.preventDefault();
      $('.disable').attr("disabled", true);


     var datetime = $('.mydatetimepickerFull').val();
     var emid = $('.emname').val();
     var emidag = $('.agname').val();

      var emids = $('.emid').val();

      if(typeof(emid) == "undefined"){
        //alert('hamna kitu');
          emid = $('.emid').val();
        // alert(emid);

      }
    
     //console.log(datetime);
                //alert(emname);
                $.ajax({

                 type: 'POST',
                 url: "<?php echo base_url();?>Ems_Domestic/employee_received_report_search",

                 data:'date='+ datetime +'&emid='+ emid+'&emidag='+ emidag,
                  beforeSend: function() {
                                //$("#loaderDiv").show();
                               //$("body").addClass("loading");
                                  $("#BtnSuper").addClass('button_loader').attr("value",""); 
                                  //$('#loader').removeClass('hidden');
                                
                             },
                 success: function(response) {

                    $('#BtnSuper').removeClass('button_loader').attr("value","\u2713");
                                 $('#BtnSuper').prop('disabled', false);

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
$(document).ready(function() {

     var table =$('#example4').DataTable( {
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

var table2 = $('#example42').DataTable( {
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



<script type="text/javascript">
  
$(function () {
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var code = button.data('code'); // Extract info from data-* attributes
    var company = button.data('company'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var serial = button.data('serial');
    //var serial = $('#regionp').val();
    $.ajax({
     type: "POST",
    
     url: "<?php echo base_url();?>Box_Application/GetBulk",
     data:'serial='+ serial,
     success: function(data){
         $("#boxesdata").html(data);
     }
 });
    var modal = $(this);
    modal.find('#code').val(code);
    modal.find('#company').val(company);
  });
});

</script>










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
     //var emid = $('.agname').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);
                 alert(datetime);
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
