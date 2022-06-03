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
            <li class="breadcrumb-item active">Ems Application List</li>
        </ol>
    </div>
</div>
<!-- Container fluid  -->
<!-- ============================================================== -->
<?php $regionlist = $this->employee_model->regselect(); ?>
<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">
         <a href="<?php echo base_url() ?>Box_Application/Ems" class="btn btn-primary"><i class="fa fa-plus"></i> Ems Application</a>
         <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
         <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>
         <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Credit Customer</a></button>
         <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer_List" class="text-white"><i class="" aria-hidden="true"></i> EMS Credit Customer Lists</a></button>
     </div>    
 </div> 

 <div class="row">
    <div class="col-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white"> Ems Application List                       
                </h4>
            </div>
            <div class="card-body">
                <div class="card">
                   <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- <table class="table table-bordered" style="width: 100%;">
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
                                 <label>Month In Between:</label>
                                 <div class="input-group">
                                    <input type="text" name="" class="form-control mydatetimepicker month1">
                                    <input type="text" name="" class="form-control  mydatetimepicker month2">
                                     <input type="hidden" name="" class="form-control month" value="Month">
                                    <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date">
                                </div>
                            </th>
                        </tr>
                    </table> -->
                </div>
            </div>
            <form method="POST" action="send_to_back_office">
                <div class="table-responsive">

                    <span class="table1">

                        <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <!-- <tr><th colspan="11"></th><th colspan=""><div class="form-check" style="padding-left:60px;" id="showCheck">
                                <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                <label class="form-check-label" for="remember-me">All</label>
                                </div></th>
                                <th></th>
                                </tr> -->
                                 <tr>
                                    <th>Receiver Name</th>
                                    <th>Registered Date</th>
                                    <th>Price (Tsh.)</th>
                                    <th>Vat (Tsh.)</th>
                                    <th>Total (Tsh.)</th>
                                    <th>Region Origin</th>
                                    <th>Branch Origin</th>
                                    <th>Destination</th>
                                    <th>Destination Branch</th>
                                    <th>Tracking Number</th>
                                    <!-- <th>Transfer Status</th>
                                    <th>
                                        Item Status
                                    </th>
                                    <th>
                                       Action
                                    </th> -->
                                </tr>
                            </thead>

                            <tbody class="">
                               <?php foreach ($emslist as  $value) {?>
                                   <tr>
                                      <td><?php echo $value->fullname;?></td>
                                      <td><?php 
                                      echo $value->date_registered;
                                      ?></td>
                                      <td><?php echo number_format(@$value->paidamount,2);?></td>
                                      <td><?php echo number_format(@$value->paidamount,2);?></td>
                                      <td><?php echo number_format(@$value->paidamount,2);?></td>
                                      <td><?php echo $value->s_region;?></td>
                                      <td><?php echo $value->s_district;?></td>
                                      <td><?php echo $value->r_region;?></td>
                                      <td><?php echo $value->branch;?></td>
                                      
                                <td><?php 
                                    echo $value->track_number;
                                    ?>
                            </td>
                            <!-- <td>
                                <?php if (@$value->office_name == 'Received') {?>
                                    <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Successfully Transfer</button>
                                <?php }else{ ?>
                                   <button type="button" class="btn btn-danger btn-sm" disabled="disabled"> Pending To Back Office</button>
                               <?php }?>

                           </td>
                           
                    <td style = "text-align:center;">
                        <div class="form-check">"
                        <?php
                        if (@$value->status == 'Paid' && @$value->office_name == 'Counter'){
                        echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }elseif (@$value->office_name == 'Back'){
                             echo "<input type='checkbox' class='form-check-input' disabled='disabled' checked >";
                        }elseif (@$value->office_name == 'Received'){
                            echo "<input type='checkbox' class='form-check-input' disabled='disabled' checked >";
                        }else{ 
                             echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }
                        ?>
                        </div>
                        </td> -->
                        <!-- <td style = "text-align:center;">
                        <a href="#" class="btn btn-info btn-sm getDetails" data-sender_id="<?php echo $value->sender_id ?>" data-receiver_id="<?php echo $value->receiver_id ?>" data-s_fullname="<?php echo $value->s_fullname ?>" data-s_address="<?php echo $value->s_address ?>" data-s_email="<?php echo $value->s_email ?>" data-s_mobile="<?php echo $value->s_mobile ?>" data-s_region="<?php echo $value->s_region ?>" data-r_fullname="<?php echo $value->fullname ?>" data-s_address="<?php echo $value->address ?>" data-r_email="<?php echo $value->email ?>" data-r_mobile="<?php echo $value->mobile ?>" data-r_region="<?php echo $value->r_region ?>" data-operator="<?php echo $value->operator ?>">Details</a> 
                        </td>-->
</tr>
<?php } ?>

</tbody>
</table>
</span>

<span class="table2" style="display: none;">
<span class="results"></span>
</span>
</div>
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
                <h2 class="modal-title">EMS Information</h2>
                </div>
                <div class="modal-body">
                <div class="row"><div class="col-md-12"><b>Sender Information</b></div></div>
                <div class="row"><div class="col-md-12">Fullname: &nbsp;&nbsp;<span class="sfname"></span></div></div>
                <div class="row"><div class="col-md-12">address: &nbsp;&nbsp;<span class="saddress"></span></div></div>
                <div class="row"><div class="col-md-12">Email: &nbsp;&nbsp;<span class="semail"></span></div></div>
                <div class="row"><div class="col-md-12">Mobile: &nbsp;&nbsp;<span class="smobile"></span></div></div>
                <div class="row"><div class="col-md-12">Region: &nbsp;&nbsp;<span class="sregion"></span></div></div>
                <br>
                <div class="row"><div class="col-md-12"><b>Receiver Information</b></div></div>
                <div class="row"><div class="col-md-12">Fullname: &nbsp;&nbsp;<span class="rfname"></span></div></div>
                <div class="row"><div class="col-md-12">address: &nbsp;&nbsp;<span class="raddress"></span></div></div>
                <div class="row"><div class="col-md-12">Email: &nbsp;&nbsp;<span class="remail"></span></div></div>
                <div class="row"><div class="col-md-12">Mobile: &nbsp;&nbsp;<span class="rmobile"></span></div></div>
                <div class="row"><div class="col-md-12">Region: &nbsp;&nbsp;<span class="rregion"></span></div></div>
                <br>
                <div class="row"><div class="col-md-12"><b>Service Operator</b></div></div>
                <div class="row"><div class="col-md-12">Fullname: &nbsp;&nbsp;<span class="operator"></span></div></div>
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
                        $(".operator").html($(this).attr("data-operator"));
                        $("#myModal1").modal();
                        });
                        });
                        </script>
<script>
$('form').submit(function(){
    $(this).find('button[type=submit]').prop('disabled', true);
});
</script>

<script>
$(document).ready(function() {

    $(".BtnSubmit").on("click", function(event) {

     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var month1 = $('.month1').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);

                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_EMSDate1",
                 data:'date_time='+ datetime,'month1='+ datetime,
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

<?php $this->load->view('backend/footer'); ?>

<!-- Modal content-->
                
                