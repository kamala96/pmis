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
                    
                      <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Form</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/bulk_pcum" class="text-white"> Bulk <i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transaction</a></button>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum_Transactions_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                     
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Incoming_Item?AskFor=PCUM" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Incoming Item To Deliver</a></button> -->

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>services/pcum_pass?AskFor=PCUM" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Pass to zone</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>services/pcum_passed_receive_list" class="text-white"><i class="" aria-hidden="true"></i> PCUM Passed receive</a></button>
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
                        <div class="casrd">
                            <!-- <form action="pcum_transactions_save" method="POST" id="wixy"> -->
                           <div class="card-body">

                             <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>

                         <div class="row">
                              <div class="col-md-12">
                                  <h2 id="loadingtext"></h2>
                              </div>
                          </div>


                            <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Selection</h3>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>[Select District]</label>
                                    <select name="district1" value="" class="form-control custom-select distid" required id="boxtype" onChange = "getEMSType();">
                                        <option value="">--Select District--</option>
                                            <?php foreach ($district as $value) {?>
                                               <option value="<?php echo $value->district_id ?>"><?php echo $value->district_name ?></option>
                                            <?php } ?>
                                            
                                        </select>
                                        <span id="distiderror" style="color: red;"></span>
                                </div>

                                <div class="col-md-3">
                                <label>[Zone Per District:]</label>
                                    <select name="zone" value="" class="form-control custom-select zone"  id="tariffCat" required="required" onChange = "getZoneCity();" >
                                        <option value="0">--Select Zone--</option>
                                        
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                <span id="zoneerror" style="color: red;"></span>
                                </div>
                                <div class="col-md-3">
                                <label>[Towcity Per Zone:]</label>
                                <select name="city" value="" class="form-control custom-select city"  id="tariffCatCity" required="required" >
                                        <option value="0">--Select Town City--</option>
                                        
                                </select>
                                <span id="error2" style="color: red;"></span>
                                <span id="cityerror" style="color: red;"></span>
                                </div>
                                <div class="col-md-3">
                                <label>Weight Step in KG:</label>
                                 <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control weight" id="weight" onkeyup="getPriceFrom()" />
                                <!-- <input type="text" name="weight" class="form-control weight" id="weight" onkeyup="getPriceFrom()"> -->
                                <span id="weight_error" style="color: red;"></span>
                                <!-- <span id="weight" style="color: red;"></span> -->
                               </div>

                                <div class="col-md-3">
                                <label>Barcode:</label>
                                <input 
                                onkeyup="validateBarcode(this)" 
                                onchange="validateBarcode(this)"
                                type="text" name="Barcode" class="form-control Barcode" id="Barcode" />

                                <span id="Barcode_error" style="color: red;"></span>
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
                                    <div class="col-md-12">
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
                                    <select class="form-control custom-select address" onchange="getAddress();" name="add_type_sender" id="senderselect">
                                        <option>--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                     <span id="select_error" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3 virtual" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="s_mobilev" id="s_mobile" class="form-control pn1 s_mobilev" onkeyup="ShowDetails1();">
                                    <span id="mobileverror" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control">
                                     <span id="s_fnameerror" style="color: red;"></span>
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="s_address" id="s_address" class="form-control">
                                     <span id="s_addresserror" style="color: red;"></span>
                                </div>

                             <!--    <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="s_email" id="s_email" class="form-control">
                                </div> -->

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control s_mobile">
                                      <span id="mobileerror" style="color: red;"></span>
                                </div>

                            </div>
                                <br>
                                 <div class="row" id="divadd">
                                <div class="col-md-12 add"></div>
                            </div>
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
                                    <select class="form-control custom-select address1" onchange="getAddress1();" name="add_type_receiver" required="required" id="receiverselect">
                                        <option value="0">--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                     <span id="erroraddress1" style="color: red;"></span>
                                    
                                </div>
                                <div class="col-md-3 virtual1" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="r_mobilev" id="r_mobilev" class="form-control pn r_mobilev" onkeyup="ShowDetails();">
                                     <span id="r_mobilev_error" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="r_fname" id="r_fname" class="form-control r_fname">
                                    <span id="error_fname" style="color: red;"></span>
                                    <span id="r_fname_error" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="r_address" id="r_address" class="form-control" onkeyup="ShowSave();">
                                    <span id="r_addresserror" style="color: red;"></span>
                                </div>
                             <!--    <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="r_email" id="r_email" class="form-control">
                                </div> -->
                                <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="r_mobile" id="r_mobile" class="form-control r_mobile">
                                     <span id="r_mobile_error" style="color: red;"></span>
                                </div>
                               <!--   <div class="col-md-3 physical1" style="display: none;">
                                    <label class="control-label">Region</label>
                                    <select name="region_to" value="" class="form-control custom-select region_to" id="rec_region" onChange="getRecDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="region_to_error" style="color: red;"></span>
                                </div> -->
                               <!--  <div class="col-md-3 physical1" style="display: none;">
                                  <label>District</label>
                                      <select name="district" value="" class="form-control custom-select district"  id="rec_dropp">
                                          <option value="">--Select District--</option>
                                      </select>
                                      <span id="district_error" style="color: red;"></span>
                              </div> -->
                                </div>
                                <div class="row" id="divadd1">
                                <div class="col-md-6 add1"></div>
                            </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-warning" id="2stepBack">Back Step</a>
                                        <button onclick="saveInformations()" type="submit" class="btn btn-info disable">Save Information</button>
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
                            <!-- </form> -->
                           </div>



                        </div>
                    </div>

                </div>

            </div>
        </div>




<script>

    function validateBarcode(obj){
    var barcode = $(obj).val();
   
    if (barcode.length != 14) {
        $('#boxtype').attr('disabled','disabled');
        $('#tariffCat').attr('disabled','disabled');
        $('#weight').attr('disabled','disabled');
        $('#receiverselect').attr('disabled','disabled');
        $('#savingBox').hide();
        $('#1step').hide();


        $('#forMessage').show();
        $('#notifyMessage').html('Tafadhali barcode haijakamilika = 14 for PCUM');
    }else{
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url();?>Loan_Board/checkBarcodeIsReuse",
            data:'barcode='+barcode,
            dataType:'json',
            success: function(data){
                 
                if(data['status'] == 'available'){
                    $('#boxtype').attr('disabled','disabled');
                    $('#tariffCat').attr('disabled','disabled');
                    $('#weight').attr('disabled','disabled');
                    $('#receiverselect').attr('disabled','disabled');
                    $('#savingBox').hide();
                    $('#1step').hide();


                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);
                }else{
                    //$('#optionBox').show();
                    $('#boxtype').removeAttr('disabled');
                    $('#tariffCat').removeAttr('disabled');
                    $('#weight').removeAttr('disabled');
                    $('#receiverselect').removeAttr('disabled');
                    $('#savingBox').show();
                    $('#1step').show();


                    $('#forMessage').hide();
                    $('#notifyMessage').html('');
                }
            }
        });
    }

}


function saveInformations(){

      var price   = $('#totalPrice').val();
      var Barcode   = $('#Barcode').val();
      var emstype   = $('#boxtype').val();
      var emsCat = $('#tariffCat').val();
      var tariffCatCity = $('#tariffCatCity').val();
      var boxtypeDistrict = $('#boxtype').val();
      var weight = $('#weight').val();
      var s_fname     = $('#s_fname').val();
      var s_address     = $('#s_address').val();
      var s_mobile    = $('#s_mobile').val();
      var addressselect    = $('#addressselect').val();
      var r_fname   = $('#r_fname').val();
      var r_address     = $('#r_address').val();
      var r_mobile    = $('#r_mobile').val();
      var rec_region   = $('#rec_region').val();
      var rec_dropp         = $('#rec_dropp').val()
      var addresrselect         = $('#addresrselect').val();
      var add_type_receiver         = $('#receiverselect').val();
      var add_type_sender         = $('#senderselect').val();

       $('#loadingtext').html('Processing controll number, please wait............');
       $('#submitform').hide();

        //Price
        var Dpprice = $('.dprice').val();
        var dpvat = $('.dpvat').val();
        var DpTotalPrice = $('.dpTotalPrice').val();

      $.ajax({
        type : "POST",
        url  : "<?php echo base_url('Ems_Domestic/pcum_transactions_save')?>",
        dataType : "JSON",
        data : {
         Barcode:Barcode,
         emstype:emstype,
         emsCat:emsCat,
         tariffCatCity:tariffCatCity,
         boxtypeDistrict:boxtypeDistrict,
         add_type_receiver:add_type_receiver,
         add_type_sender:add_type_sender,
         weight:weight,
         s_fname:s_fname,
         s_address:s_address,
         s_mobile:s_mobile,
         s_addressType:addressselect,
         r_fname:r_fname,
         r_address:r_address,
         r_mobile:r_mobile,
         rec_region:rec_region,
         rec_dropp:rec_dropp,
         price:price,
         r_addressType:addresrselect
      },
        success: function(response){
            // console.log(response)

         if (response['status'] == 'Success') {
            $('#loadingtext').html(response['message']);

            $('.dprice').val('');
             $('.dpvat').val('');
             $('.dpTotalPrice').val('');

             $('#div3').hide();
             $('#div2').hide();
             $('#div1').hide();

            setTimeout(function(){
                 // location.reload();
             },6000)

         }else{
            $('#submitform').hide();
            $('#loadingtext').html(response['message']);

             //setTimeout(function(){
                 $('#loadingtext').html('');
             //},6000)
         }

        }
    });

}




    function ShowSave() {
        $('#save').show();

    }
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
  $('#save').show();
   $('#mobilererror').html('');
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

 var zoneid = $('.zone').val();
 var city  = $('.city').val();
 var weight  = $('.weight').val();
var distid  = $('.distid').val();

if (weight == '') {

}else{

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Ems_Domestic/Pcum_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,zoneid:zoneid,city:city,distid:distid},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
     }
}
</script>
<script type="text/javascript">
function getEMSType() {

var districtid = $('.distid').val();

     $.ajax({
                  type : "POST",
                 url  : "<?php echo base_url('Ems_Domestic/get_Zones')?>",
                  //dataType : "JSON",
                  data : {districtid:districtid},
                  success: function(data){
                     $('.zone').html(data);
                  }
              });

};
</script>

<script type="text/javascript">
function getZoneCity() {

var zoneid = $('.zone').val();
var districtid = $('.distid').val();


     $.ajax({
                  type : "POST",
                 url  : "<?php echo base_url('Ems_Domestic/get_Zones_City')?>",
                  //dataType : "JSON",
                  data : {districtid:districtid,zoneid:zoneid},
                  success: function(data){
                     $('.city').html(data);
                  }
              });

};
</script>
<script type="text/javascript">
    $('#receiverselect').on('change', function() {
        if ($('#receiverselect').val() == '--Select Address--') {
            $('#receiverselect_error').html('Select Address');
        }
        if($('#receiverselect').val() == 'physical'  ){
             $('#receiverselect_error').html('');

            if($('#r_fname').val() ==''){
                $('#r_fnameerror').html('This field is required');
                 $('#r_addresserror').html('This field is required');

            }else if ($('#r_address').val() =='')
            {
                $('#r_addresserror').html('This field is required');
            }
            else
            {
                
                $('#save').show();

            }
            
           

        }
       
        if($('#receiverselect').val() == 'virtual'  ){
             $('#receiverselect_error').html('');
             $('#save').hide();

            if($('#r_mobilev').val() ==''){
                $('#mobilererror').html('This field is required');

            }else 
            {
               
               $('#save').show();
            }

        }

    //$('#showdiv' + this.value).show();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){

        if ($('#boxtype').val() == "") {
                $('#distiderror').html('Please Select District');
        }else{
            $('#distiderror').hide();

            if ($('.zone').val() == 0) {
                $('#zoneerror').html('Please Select Zone');
            }else if ($('.city').val() == 0) {
                $('#cityerror').html('Please Select Town City');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('This field is required');
            }else if($('#Barcode').val() == ''){
                $('#Barcode_error').html('Please Input Barcode is required');
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

        if ($('#senderselect').val() == '--Select Address--') {
            $('#select_error').html('Please Select Address Type');
        }
        if($('#senderselect').val() == 'physical'  ){
             $('#select_error').html('');

            if($('#s_fname').val() ==''){
                $('#s_fnameerror').html('Please Input Sender Name');

            }else if ($('#s_address').val() =='')
            {
                $('#s_addresserror').html('Please Input Address');
            }
            // else if($('.s_mobile').val() ==''){
            //     $('#mobileerror').html('Please input Mobile Number');

            // }
            else
            {
                $('#div2').hide();
                $('#div3').show();
               // $('#save').hide();
            }
            
           

        }
       
        if($('#senderselect').val() == 'virtual'  ){
             $('#select_error').html('');

            if($('.s_mobilev').val() ==''){
                $('#mobileverror').html('Please input Mobile Number');

            }else 
            {
               
                $('#div2').hide();
                $('#div3').show();
            }

        }
        
  });
        $('#2stepBack').on('click',function(){
             $('#select_error').hide();
              $('#s_fnameerror').html('');
               $('#s_addresserror').html('');
                $('#mobileerror').html('');

        $('#div3').hide();
        $('#div2').show();
  });




    $('#Olsubmitform').on('click',function(){
             if ($('#receiverselect').val() == 0) {
                $('#erroraddress1').html('Please Select Address Type');
        }else{
                $('#erroraddress1').hide();

                var address = $('.address1').val();
                if (address == 'physical') {
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     var region_to = $('.region_to').val();
                     var district = $('.district').val();
                       if(name == ''){
                         $('#r_fname_error').html('Please input Receiver Name ');

                     }
                    else if (mob == '') {
                     $('#r_mobile_error').html('Please input Mobile Number ');
                     $('#r_fname_error').hide();
                     }
                     
                     // else if(region_to == ''){
                     //     $('#region_to_error').html('Please Select Region Name ');
                     //      $('#r_mobile_error').hide();

                     // }  
                     //  else if(district == ''){
                     //     $('#district_error').html('Please Select Branch Name ');
                     //     $('#region_to_error').hide();

                     // } 
                     else{//submit

                        $('.disable').attr("disabled", true);
                        $('#district_error').hide();

                           $('#wixy').submit()
                           // $('.disable').attr("disabled", true);
                    }
                }else if(address == 'virtual') {
                    $('#erroraddress1').hide();
                     var mobv = $('.r_mobilev').val();
                     if (mobv == '') {
                     $('#r_mobilev_error').html('Please input Mobile Number ');
                     }  else{ //submit

                        $('.disable').attr("disabled", true);
                    $('#wixy').submit()
                     //$('.disable').attr("disabled", true);
                    }
               
                }



           
        }
        
       
  });






});

//save data to databse
$('#btn_save').on('click',function(){
            $('.disable').attr("disabled", true);

             return false;
    
        });


</script>


<script type="text/javascript">
    function getAddress() {
    var address = $('.address').val();

    if (address == 'physical') {
         $('#divadd').hide();

        $('.physical').show();
        $('.virtual').hide();
    }else{
          $('#divadd').show();
        $('.physical').hide();
        $('.virtual').show();
    }
    
};
</script>
<script type="text/javascript">
    function getAddress1() {
    var address = $('.address1').val();

    if (address == 'physical') {
          $('#divadd1').hide();
        $('.physical1').show();
        $('.virtual1').hide();
    }else{
          $('#divadd1').show();
        $('.physical1').hide();
        $('.virtual1').show();
    }
    
};
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
    $(document).ready(function(){
        show_product(); //call function show all product


        //function show all product
        function show_product(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('products/recep_info')?>',
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                            '<td>'+data[i].name+'</td>'+
                            '<td>'+data[i].mobile+'</td>'+
                            '<td>'+data[i].email+'</td>'+
                            '<td>'+data[i].country+'</td>'+
                            //'<td>'+data[i].centigrade+'</td>'+
                            //'<td>'+data[i].qrcode_image+'</td>'+
                            //'<td>'+data[i].status+'</td>'+
                            //'<td><a href="">'+data[i].DriverId+'</a></td>'+
                            //'<td><a href="">'+data[i].destinationId+'</a></td>'+
                            '</tr>';
                    }
                    $('#show_data').html(html);
                    $('#roles1').dataTable().clear();
                    $('#roles1').dataTable().draw();
                }

            });
        }


    });

</script>
<?php $this->load->view('backend/footer'); ?>
