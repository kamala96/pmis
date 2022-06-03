<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> <?php echo $this->session->userdata('heading'); ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $this->session->userdata('heading'); ?></li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
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
                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=Ems" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Bill Transactions</a></button>
                    <!--  <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button> -->
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Incoming_Item" class="text-white"><i class="" aria-hidden="true"></i> Incoming Item</a></button> -->
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/bulk_document_parcel" class="text-white"><i class="" aria-hidden="true"></i> Bulk <?php echo $this->session->userdata('heading') ?> Transaction </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/transfered_item_list" class="text-white"><i class="" aria-hidden="true"></i> Transfered Item List </a></button>

                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> <?php echo $this->session->userdata('heading'); ?>  Form
                        </h4>
                    </div>
                    <div class="card-body">

                        <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>

                        <div class="card">
                            <form action="document_parcel_save" method="POST" id="wixy">
                                <div class="row col-md-12">
                                    <div class="col-md-3">
                                    <!-- <label>Barcode:</label> -->
                                    <input onchange="validateBarcode(this)" type="text" name="Barcode" placeholder="Barcode" class="form-control Barcode" id="Barcode" />

                                    <span id="Barcode_error" style="color: red;"></span>
                                </div>

                                <div class="col-md-3 ">
                                    <!-- <label>Weight:</label> -->
                                    <input onchange="getweight(this)" type="text" name="weight" placeholder="weight" class="form-control weight" id="weight" />

                                    <span id="weight_error" style="color: red;"></span>
                                     <input hidden type="text" name="hiddenweight" class="form-control hiddenweight" id="hiddenweight" />
                                     <!-- <button class="btn btn-info disables" type="button" id="refreshweight">Refresh</button>  -->
                                </div>

                                 <div class="col-md-1 ">
                                    <!-- <label></label> -->
                                    <!--  <input type="button" name="btn btn-info disables" class="form-control refreshweight" placeholder="Refresh" id="refreshweight" /> -->
                                   
                                     <button class="btn btn-info disables" type="button" id="refreshweight">Refresh</button> 
                                     <span id="refreshweight_error" style="color: red;"></span>
                                </div>

                                 <div class="col-md-1 ">
                                   
                                     <button class="btn btn-info disables" type="button" id="repeate">Repeat</button> 
                                </div>


                                </div>


                        <div style="display:none;" class="card-body" id='optionBox'>
                            <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Selection</h3>
                                </div>

                                

                                <div class="col-md-12" style="display:none;" id='optionBox'>
                                </div>



                                <div class="form-group col-md-4">
                                    <label>Ems Type</label>
                                    <select name="emsname" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                                <div class="col-md-4">
                                <label>Ems Tariff Category:</label>
                                    <select name="emscattype" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();">
                                        <option value="0">--Select Category--</option>
                                        <?Php foreach($ems_cat as $value): ?>
                                             <option value="<?php echo $value->cat_id ?>"><?php echo $value->cat_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>

                                 <div class="col-md-4">
                                <label>Weight Step in KG:</label>
                                <!-- <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"> -->
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()" />

                                 <!-- <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()" >
                                 min="0" onkeypress="return isNumberKey(event)" -->
                                <span id="weight_error" style="color: red;"></span>
                                </div>


                                </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                    <a href="#" class="btn btn-info" id="1step">Next Step</a>
                                    </div>
                                </div>


                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                                </div>


                                <div id="div2" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 4  - Sender Personal Details</h3>
                                </div>
                                <div class="col-md-3">
                                    <label><b><h4>Select Address:</h4></b></label>
                                    <select class="form-control custom-select address" id="addressselect" onchange="getAddress();" name="add_type_sender" required="required">
                                        <option value="0" >--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                     <span id="erroraddress" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3 virtual" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="s_mobilev" id="s_mobile" class="form-control pn1 s_mobilev" onkeyup="ShowDetails1();">
                                    <span id="s_mobilev_error" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control s_fname">
                                     <span id="s_fname_error" style="color: red;"></span>
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="s_address" id="s_address" class="form-control">
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="s_email" id="s_email" class="form-control">
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control s_mobile">
                                     <span id="s_mobile_error" style="color: red;"></span>
                                </div>
                            </div> 
                            <br>
                            <div class="row" id="divadd1">
                                <div class="col-md-6 add"></div>
                            </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-warning" id="1stepBack">Back Step</a>
                                        <a href="#" class="btn btn-info" id="2step">Next Step</a>
                                    </div>
                                </div>
                                </div>


                                <div id="div3" style="display: none;">
                                   <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 4  - Reciever Personal Details</h3>
                                </div>
                                <div class="col-md-3">
                                    <label><b><h4>Select Address:</h4></b></label>
                                    <select class="form-control custom-select address1" id="addresrselect" onchange="getAddress1();" name="add_type_receiver">
                                        <option value="0">--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                     <span id="erroraddress1" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 virtual1" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="r_mobilev" id="s_mobile" class="form-control pn r_mobilev" onkeyup="ShowDetails();">
                                    <span id="r_mobilev_error" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="r_fname" id="r_fname" class="form-control r_fname">
                                    <span id="r_fname_error" style="color: red;"></span>
                                    <!-- <span id="error_fname" style="color: red;"></span> -->
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="r_address" id="r_address" class="form-control">
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="r_email" id="r_email" class="form-control">
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="r_mobile" id="r_mobile" class="form-control r_mobile">
                                     <span id="r_mobile_error" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3 physical1" style="display: none;">
                                    <label class="control-label">Region</label>
                                    <select name="region_to" value="" class="form-control custom-select region_to" id="rec_region" onChange="getRecDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                          <span id="region_to_error" style="color: red;"></span>
                                        <!-- <span id="error_region" style="color: red;"></span> -->
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                  <label>District</label>
                                      <select name="district" value="" class="form-control custom-select district"  id="rec_dropp">
                                          <option value="">--Select District--</option>
                                      </select>
                                      <span id="district_error" style="color: red;"></span>
                              </div>
                                </div>
                                <br>
                            <div class="row" id="divadd">
                                <div class="col-md-6 add1"></div>
                            </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-warning" id="2stepBack">Back Step</a>
                                         <button class="btn btn-info disable" type="button" id="submitform">Save Information</button> 
                                        <!-- <button class="btn btn-info disable">Save Information</button> -->
                                    </div>
                                </div>
                                </div>

                                <div id="div4" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 4 of 4  - Payment Information</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <span id="majibu"></span>
                                </div>
                                </div>
                                </div>



                            </div>
                            </form>
                           </div>



                        </div>
                    </div>

                </div>

            </div>
        </div>






        <script type="text/javascript">
            
            function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

        </script>
<script>
function ShowDetails() {
var pn = $('.pn').val();

 $.ajax({
                  type : "POST",
                 url  : "<?php echo base_url('Ems_Domestic/getVirtualBoxInfo')?>",
                 //dataType : "JSON",
                 data : {phone:pn},
                  success: function(data){
                     $('.add1').html(data);
                  }
              });
    }
</script>
<script>
function ShowDetails1() {
var pn = $('.pn1').val();

 $.ajax({
                  type : "POST",
                 url  : "<?php echo base_url('Ems_Domestic/getVirtualBoxInfo')?>",
                 //dataType : "JSON",
                 data : {phone:pn},
                  success: function(data){
                     $('.add').html(data);
                  }
              });
    }
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
    $(document).ready(function() {





        $('#1step').on('click',function(){

        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select Ems tariff Category Type');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('This field is required');
            }else if($('#Barcode').val() == ''){
                $('#Barcode_error').html('Please Input Barcode');
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
             if ($('#addressselect').val() == 0) {
                $('#erroraddress').html('Please Select Address Type');
        }else{
            //$('#erroraddress').hide();

                var address = $('.address').val();
                if (address == 'physical') {
                     var mob = $('.s_mobile').val();
                     var name = $('.s_fname').val();
                    if (mob == '') {
                     $('#s_mobile_error').html('Please input Mobile Number ');
                     }
                     else if(name == ''){
                         $('#s_fname_error').html('Please input Sender Name ');

                     }  
                     else{
                    $('#div2').hide();
                    $('#div3').show();
                    }
                }else if(address == 'virtual') {
                     var mobv = $('.s_mobilev').val();
                     if (mobv == '') {
                     $('#s_mobilev_error').html('Please input Mobile Number ');
                     }  else{
                    $('#div2').hide();
                    $('#div3').show();
                    }
               
                }



            // if ($('#addressselect').val() == 'physical') {
            //     $('#div2').hide();
            //    $('#div3').show();
               
            // }else if($('#addressselect').val() == 'virtual'){
               
            // }else{
            //     $('#div2').hide();
            //     $('#div3').show();
            // }
        }
        
       
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });

          $('#submitform').on('click',function(){
             if ($('#addresrselect').val() == 0) {
                $('#erroraddress1').html('Please Select Address Type');
        }else{
            //$('#erroraddress').hide();
            // $('#submitform').submit();

                var address = $('.address1').val();
                if (address == 'physical') {
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     var region_to = $('.region_to').val();
                     var district = $('.district').val();
                    if (mob == '') {
                     $('#r_mobile_error').html('Please input Mobile Number ');
                     }
                     else if(name == ''){
                         $('#r_fname_error').html('Please input Receiver Name ');

                     } 
                     else if(region_to == ''){
                         $('#region_to_error').html('Please Select Region Name ');

                     }  
                      else if(district == ''){
                         $('#district_error').html('Please Select Branch Name ');

                     } 
                     else{//submit
                         $('.disable').attr("disabled", true);

                           $('#wixy').submit()
                           // $('.disable').attr("disabled", true);
                    }
                }else if(address == 'virtual') {
                     var mobv = $('.r_mobilev').val();
                     if (mobv == '') {
                     $('#r_mobilev_error').html('Please input Mobile Number ');
                     }  else{ //submit
                         $('.disable').attr("disabled", true);

                    $('#wixy').submit()
                     //$('.disable').attr("disabled", true);
                    }
               
                }



            // if ($('#addressselect').val() == 'physical') {
            //     $('#div2').hide();
            //    $('#div3').show();
               
            // }else if($('#addressselect').val() == 'virtual'){
               
            // }else{
            //     $('#div2').hide();
            //     $('#div3').show();
            // }
        }
        
       
  });
});

//save data to databse

$('#btn_save').on('click',function(){
            $('.disable').attr("disabled", true);

            var price   = $('.price1').val();
            var emstype   = $('#boxtype').val();
            var emsCat = $('#tariffCat').val();
            var weight = $('#weight').val();
            var s_fname     = $('#s_fname').val();
            var s_address     = $('#s_address').val();
            var s_email     = $('#s_email').val();
            var s_mobile    = $('#s_mobile').val();
            //var regionp      = $('#regionp').val()
            //var branchdropp    = $('#branchdropp').val();;
            var r_fname   = $('#r_fname').val();
            var r_address     = $('#r_address').val();
            var r_email     = $('#r_email').val();
            var r_mobile    = $('#r_mobile').val();
            var rec_region   = $('#rec_region').val();
            var rec_dropp         = $('#rec_dropp').val();

            if (r_fname == '') {
            $('#error_fname').html('This field is required');
            }else if(r_address == ''){
            $('#error_address').html('This field is required');
             }else if(r_mobile == ''){
            $('#error_mobile').html('This field is required');
            }else if(rec_region == 0){
            $('#error_region').html('This field is required');
          }else if(rec_dropp == ''){
            $('#error_district').html('This field is required');
            }else{

             $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : {emstype:emstype,emsCat:emsCat,weight:weight,s_fname:s_fname,s_address:s_address,s_email:s_email,
                   s_mobile:s_mobile,r_fname:r_fname,r_address:r_address,r_mobile:r_mobile,r_email:r_email,rec_region:rec_region,
                   rec_dropp:rec_dropp,price:price},
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
        function getCustomer() {

    var val = $('#box').val();
    if (val == 'Renewal Box') {

        $('#box1').show();
    }else{
         $('#box1').hide()
    }

};
</script>
<script type="text/javascript">
        function getSenderDistrict() {
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
    function GetBranch() {
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
<script type="text/javascript">
    function getAddress() {
    var address = $('.address').val();

    if (address == 'physical') {
         $('#divadd1').hide();

        $('.physical').show();
        $('.virtual').hide();
    }else{
          $('#divadd1').show();
        $('.physical').hide();
        $('.virtual').show();
    }
    
};
</script>

<!-- <script type="text/javascript">
    
// Add event listener on keypress
document.addEventListener('keyup', (event) => {
  var name = event.key;
  var code = event.code;
  // alert(`Key pressed ${name} \r\n Key code value: ${code}`);

     //Loading the variable
      var weight = $('.weight').val();
      var mystr =name;//,000700,00070,000070,07000,700,00700,0070,00 weight;//'0000000020C90037,TEMP,data';


  if(code =='Comma'){
   // t the key name and key code on keydown
 // alert(`Key pressed ${name} \r\n Key code value: ${code}`);
  //Splitting it with : as the separator
var myarr = mystr.split(",");

//Then read the values from the array where 0 is the first
//Since we skipped the first element in the array, we start at 1
//var myvar = myarr[1] + ":" + myarr[2];
var myvar = myarr[0]/100;

// Show the resulting value
console.log(myvar);

                        $('#optionBox').hide();
                     $('#forMessage').show();
                    $('#notifyMessage').html('Weight is '+ myvar +'KG');
                    //document.getElementById("weight").value = myvar;
                     $('#weight').val(myvar);
                    $('#weight').attr("disabled","disabled");



  }
  // Aler
}, false);

</script> -->

<script type="text/javascript">
    


  function getweight2(obj){
    var weight = $(obj).val();
  // alert(`Key pressed ${name} \r\n Key code value: ${code}`);
  // Add event listener on keypress
//document.addEventListener('keyup', (event) => {

  //var name = event.key;
  //var code = event.code;

     //Loading the variable
      var weight = $('.weight').val();
      var mystr =weight;//,000700,00070,000070,07000,700,00700,0070,00 weight;//'0000000020C90037,TEMP,data';


  //if(code =='Comma'){
var myarr = mystr.split(",");
//var myvar = myarr[1] + ":" + myarr[2];
var myvar = myarr[0]/100;
console.log(myvar);

                        $('#optionBox').hide();
                     $('#forMessage').show();
                    $('#notifyMessage').html('Weight is '+ myvar +'KG');
                     $('#weight').val(myvar);
                    $('#weight').attr("disabled","disabled");


      
        // $.ajax({
        //     type : "POST",
        //     url  : "<?php echo base_url();?>Organization/getweightkg",
        //     data:'weight='+weight,
        //     dataType:'json',
        //     success: function(data){
                 
        //         if(data['status'] == 'success'){
        //             $('#optionBox').hide();
        //             $('#forMessage').show();
        //             $('#notifyMessage').html(data['message']);
        //         }else{
        //              $('#optionBox').hide();
        //             $('#forMessage').show();
        //             $('#notifyMessage').html(data['message']);
                    
        //             // $('#optionBox').show();
        //             // $('#forMessage').hide();
        //             // $('#notifyMessage').html(data['message']);
        //         }
        //     }
        // });



// }
   
//}, false);
};
 

</script>
<script type="text/javascript">
    function getAddress1() {
    var address = $('.address1').val();

    if (address == 'physical') {
          $('#divadd').hide();
        $('.physical1').show();
        $('.virtual1').hide();
    }else{
          $('#divadd').show();
        $('.physical1').hide();
        $('.virtual1').show();
    }
    
};

function validateBarcode(obj){
    var barcode = $(obj).val();
   
    if (barcode.length != 13) {
        $('#optionBox').hide();
        $('#forMessage').show();
       
       
        $('#notifyMessage').html('Tafadhali barcode haijakamilika = 13');
    }else{
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url();?>Loan_Board/checkBarcodeIsReuse",
            data:'barcode='+barcode,
            dataType:'json',
            success: function(data){
                 
                if(data['status'] == 'available'){
                    $('#optionBox').hide();
                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);
                }else{
                    $('#optionBox').show();
                    $('#forMessage').hide();
                    $('#notifyMessage').html('');
                }
            }
        });
    }

}

function getweight(obj){
    var weight = $(obj).val();

       var mystr =weight;//,000700,00070,000070,07000,700,00700,0070,00 weight;

var myarr = mystr.split(",");
//var myvar = myarr[1] + ":" + myarr[2];
var myvars = myarr[5];
var myvar = '';
if(myvars.length == 4){
     myvar = myvars/1000;

}
else if(myvars.length > 4){
     myvar = myvars/1000;
}else{  myvar = myvars/100;}
console.log(mystr);
console.log(myvar);

                        $('#optionBox').hide();
                     $('#forMessage').show();
                    $('#notifyMessage').html('Weight is '+ myvar +'KG');
                     $('#weight').val(myvar);
                      $('#hiddenweight').val(myarr);
                     
                    $('#weight').attr("disabled","disabled");
    


}


$('#refreshweight').on('click',function(){
     var weight = $('#hiddenweight').val();
       var mystr =weight;
     var myarr = mystr.split(",");
     myarr.splice(5,1);
//var myvar = myarr[1] + ":" + myarr[2];
var myvars = myarr[5];
var myvar = '';
if(myvars.length == 4){
     myvar = myvars/1000;

}
else if(myvars.length > 4){
     myvar = myvars/1000;
}else{ 
 myvar = myvars/100;}
//console.log(mystr);
//console.log(myvar);

                        $('#optionBox').hide();
                     $('#forMessage').show();
                    $('#notifyMessage').html('Weight is '+ myvar +'KG');
                     $('#weight').val(myvar);
                      $('#hiddenweight').val(myarr);
                     
                    $('#weight').attr("disabled","disabled");

    });

$('#repeate').on('click',function(){
    

                     $('#forMessage').hide();
                     $('#weight').val('');
                      $('#hiddenweight').val('');
                     
                    $('#weight').attr("disabled",false);

    });




// function arrayBufferToString(array) {
//   return String.fromCharCode.apply(null, new Uint8Array(array));
// }

// function myDevicePoll() {

// //var myDevicePoll = function() {
//   var size = 64;
//     var i = 0;
//     var connectionId = null;
// if (chrome.runtime.lastError) {console.log(chrome.runtime.lastError);}
//     chrome.hid.receive(connectionId, function(data) {
//         console.log("::" + connectionId);
//       if (data != null) {
//             // Convert Byte into Ascii to follow the format of our device
//             myText.value = arrayBufferToString(data);
//             console.log('Data: ' + myText.value);
//              $('#optionBox').hide();
//                      $('#forMessage').show();
//                     $('#notifyMessage').html('Ready to connect'+ myText.value);
//       }
//     setTimeout(myDevicePoll, 0);
//     });
// }

// function initializeHid() {
// // brackets are empty for purpose because permissions are given in manifest.json
//     chrome.hid.getDevices({}, function(devices) {
//         if (!devices || !devices.length) {
//           console.log('device not found');
//           if (chrome.runtime.lastError) {console.log(chrome.runtime.lastError);}
//           return;
//         }
//         console.log('Found device with deviceId: ' + devices[0].deviceId);
//          console.log('Found device with deviceId: ' + devices[1].deviceId);
//           console.log('Found device with deviceId: ' + devices[2].deviceId);
//         myHidDevice = devices[0].deviceId;

//         // Connect to the HID device
//         chrome.hid.connect(myHidDevice, function(connection) {
//             console.log('Connected to the HID device with connectionId: ' + connection.connectionId);
//           connectionId = connection.connectionId;

//             // Poll the USB HID Interrupt pipe
//             //pollHid();
//         });
//     });
// }



</script>

<script type="text/javascript">
    
//     var MY_HID_VENDOR_ID  = 0x09da; // 4660 in hexadecimal!
// var MY_HID_PRODUCT_ID = 0x8090;
// var DEVICE_INFO = {"vendorId": MY_HID_VENDOR_ID, "productId": MY_HID_PRODUCT_ID };

// var connectionId = null;

// function arrayBufferToString(array) {
//   return String.fromCharCode.apply(null, new Uint8Array(array));
// }

// var myDevicePoll = function() {
//   var size = 64;
//     var i = 0;
// if (chrome.runtime.lastError) {console.log(chrome.runtime.lastError);}
//     chrome.hid.receive(connectionId, function(data) {
//         console.log("::" + connectionId);
//       if (data != null) {
//             // Convert Byte into Ascii to follow the format of our device
//             myText.value = arrayBufferToString(data);
//             console.log('Data: ' + myText.value);
//              $('#optionBox').hide();
//                      $('#forMessage').show();
//                     $('#notifyMessage').html('Ready to connect'+ myText.value);
//       }
//     setTimeout(myDevicePoll, 0);
//     });
// }





// function initializeHid(pollHid) {
// // brackets are empty for purpose because permissions are given in manifest.json
//     chrome.hid.getDevices({}, function(devices) {
//         if (!devices || !devices.length) {
//           console.log('device not found');
//           if (chrome.runtime.lastError) {console.log(chrome.runtime.lastError);}
//           return;
//         }
//         console.log('Found device with deviceId: ' + devices[0].deviceId);
//          console.log('Found device with deviceId: ' + devices[1].deviceId);
//           console.log('Found device with deviceId: ' + devices[2].deviceId);
//         myHidDevice = devices[0].deviceId;

//         // Connect to the HID device
//         chrome.hid.connect(myHidDevice, function(connection) {
//             console.log('Connected to the HID device with connectionId: ' + connection.connectionId);
//           connectionId = connection.connectionId;

//             // Poll the USB HID Interrupt pipe
//             pollHid();
//         });
//     });
// }

// initializeHid(myDevicePoll);

// console.log("Trying to connect to HID USB ...");


// var myText = document.getElementById("weight");
// myText.value = "Ready";

//   $('#optionBox').hide();
//                      $('#forMessage').show();
//                     $('#notifyMessage').html('Ready to connect');

</script>

<?php $this->load->view('backend/footer'); ?>
