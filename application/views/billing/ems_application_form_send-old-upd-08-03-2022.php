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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                   <?php if($this->session->userdata('user_type') == "EMPLOYEE"){ ?>
                         <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions Lists List</a></button>


                       <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $this->session->userdata('askfor')?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Customer List</a></button>

                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_form" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Customer</a></button>

                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list" class="text-white"><i class="" aria-hidden="true"></i> Bill Transactions List</a></button>

                   <?php } ?>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Ems Application Form                       
                        </h4>
                    </div>
                    <div class="card-body">

                        <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>

                        <div class="card">

                <!-- <form method="post" action="<?php echo base_url() ?>Box_Application/Send_Action"> -->
                    <input type="hidden" name="I" class="form-control sender" value="<?php echo $I; ?>" id="sender">
                    <input type="hidden" name="acc_no" class="form-control acc_no" value="<?php echo $acc_no; ?>" id="acc_no" onkeyup="getPriceFrom();">
                    <input type="hidden" name="cbranch" class="form-control cbranch" value="<?php echo $this->session->userdata('user_branch'); ?>" id="cbranch">
                       <input type="hidden" name="AskFor" class="form-control AskFor" value="<?php echo $this->session->userdata('askfor'); ?>" id="AskFor">
                           <div class="card-body">
                            <div id="div1"> 
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

                                    <div id="first" >
                                    <div class="row " >
                                <div class="col-md-12">
                                    <!-- <h3>Ems Form</h3> -->
                                </div>

                                <div class="col-md-3">
                                    <label>Barcode:</label>
                                    <input 
                                    onkeyup="validateBarcode(this)" 
                                    onchange="validateBarcode(this)" type="text" name="Barcode" class="form-control Barcode" id="Barcode" />

                                    <span id="Barcode_error" style="color: red;"></span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Ems Type</label>
                                    <select  name="emsname" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                                <div class="col-md-3">
                                <label>Ems Tariff Category:</label>
                                    <select name="emscattype" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();" required="required"> 
                                        <option value="">--Select Category--</option>
                                        <?Php foreach($ems_cat as $value): ?>
                                             <option value="<?php echo $value->cat_id ?>"><?php echo $value->cat_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3">
                                <label>Weight Step in KG:</label>
                            <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()" required="required">
                                <span id="weight_error" style="color: red;"></span>
                                </div>

                                
                                
                                </div>
                                <br>

                                <div id="div3" >
                                 <div class="row">
                              
                                  <br /><br />
                                  <!-- <div class="row"> -->

                                 <div class="col-md-3">
                                    <label><b><h4>Select Receiver Address:</h4></b></label>
                                    <select class="form-control custom-select address1" onchange="getAddress1();" name="add_type_receiver" id="receiverselect">
                                        <option value="0">--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                    <span id="erroraddress1" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 virtual1" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="r_mobilev" id="r_mobilev" class="form-control pn1 r_mobilev" onkeyup="ShowDetails1();">
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
                                    <input type="text" name="r_address" id="r_address" class="form-control">
                                    <span id="r_addresserror" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical12" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="r_email" id="r_email" class="form-control" value="">
                                </div>
                                <div class="col-md-3 physical12" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="r_mobile" id="r_mobile" class="form-control r_mobile" value="">
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
                                        <span id="error_region" style="color: red;"></span>
                                         <span id="region_to_error" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical1" style="display: none;">
                                  <label>District</label>
                                      <select name="district" value="" class="form-control custom-select district"  id="rec_dropp">
                                          <option value="">--Select District--</option>
                                      </select>
                                      <span id="district_error" style="color: red;"></span>
                              </div>
                                </div><br />

                                <div class="row " id="divadd1">

                                <div class="col-md-6 add1"></div>
                            </div>


                               
                                <!-- </div> -->

                                </div>

                                 <div class="row col-md-12">
                                    <div class="col-md-6">
                                    <span class ="price1" id="price1" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>

                                 <div class="row col-md-12">
                                    <div class="col-md-6">
                                    <span class ="price" id="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>

                                    <hr />

                                <div id="savingBox" class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                     <div class="">
                                        <!-- <button class="btn btn-warning btn-md" id="1stepBack">Back Step</button> -->
                                         <a href="#"  class="btn btn-info btn-md" id="addmore">Add More</a>
                                        <button class="btn btn-info btn-md disable" id="submitform" type="button">Save Information</button>
                                    </div>
                                </div>
                                <br>

                                 <br>
                                  <div id="div6" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="list" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>




                                <div id="div4" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 2 -  Information</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <span id="majibu" style="font-weight: 70px;font-size: 24px;" ></span>
                                </div>
                                </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-md-6">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div> -->
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
function getPriceFrom() {

  var weight = $('#weight').val();
  var tariffCat  = $('#tariffCat').val();
  var acc_no  = $('#acc_no').val();
  var branch  = $('#cbranch').val();
if (acc_no == "POSTPAID-1651") {

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/customer_ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                    //$('#tariffCat').val("");
                 }
             });

}
else{
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,acc_no:acc_no},
                 success: function(data){
                    $('.price').html(data);
                    //$('#tariffCat').val("");
                 }
             });
}
        
    }
</script>
<script type="text/javascript">
function getEMSType() {

var tariffCat = $('.catid').val();
var weight = $('.catweight').val();
var acc_no  = $('#acc_no').val(); 
var branch  = $('#cbranch').val();

if (acc_no =="POSTPAID-1651") {

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/customer_ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                    //$('#tariffCat').val("");
                 }
             });

}
else{

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Ems_price_vat')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
                 success: function(data){
                    $('.price').html(data);
                    //$('#tariffCat').val("");
                 }
             });
    
}
     
};
</script>


<script type="text/javascript">

    function Deletevalue(obj) {
        var transId = $(obj).attr('data-transid');
        var senderid = $(obj).attr('data-senderid');
        //var senderid = $(obj).va('data-senderid');

        $.ajax({
             type : 'POST',
             url  : '<?php echo base_url('Ems_Domestic/delete_ems_document_bulk_info_data')?>',
             data : {
                transactionid:transId,
                senderid:senderid},
                 success: function(data){
                    $('.trans'+transId).remove();
                    //$.each(function())
                 }
           });

        }

      /*function Deletevalue() {
   
      var senderid  = $('.senders').val();
      var serial  = $('.serial').val();
       //alert('imefika33');
    
     $.ajax({
         type : 'POST',
         url  : '<?php echo base_url('Ems_Domestic/delete_ems_document_bulk_info')?>',
         
         data : {senderid:senderid,serial:serial},
         success: function(data){
             $('#div6').show();
             $('.list').html('');
            
              $('.list').html(data);
            
                  
               }
           });

        }*/




    $(document).ready(function() {


         $('#submitform').on('click',function(){ 
            $('.disable').attr("disabled", true);
             // $('#2stepBack').prop('disabled', true);
             $('#addmore').prop('disabled', true); 
            

             var AskFor  = $('.AskFor').val();
                var serial  = $('.serial').val();
              var operator  = $('.operator').val();
             
            
             $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('Ems_Domestic/save_bulk_bill_document_info')?>",
                             //dataType : "JSON",
                             data : {serial:serial,operator:operator,AskFor:AskFor},
                             beforeSend: function() {
                                //$("#loaderDiv").show();
                               //$("body").addClass("loading");
                                  $("#submitform").addClass('button_loader').attr("value",""); 
                                  //$('#loader').removeClass('hidden');
                                
                             },
                             success: function(data){
                                 $('#submitform').removeClass('button_loader').attr("value","\u2713");
                                 $('#submitform').prop('disabled', true);
                                $('#majibu').html(data);
                                 $('.price').html('');
                                 $('#div6').hide();
                                  $('#first').hide();
                                  $('#div4').show();

                                   // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=EMS%20Postage'));

                                
                                
                             }
                         });
        
       
         });

          
          $('#addmore').on('click',function(){
            $('#2stepBack').attr("disabled", true);
            $('#addmore').attr("disabled", true);
            $('.disable').attr("disabled", false);

            // alert("hiyoi");

        if ($('#boxtype').val() == 0) {
         $('#error1').html('Please Select PostBox Type');
        }else{



            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select Ems tariff Category Type');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('Please Input Weight in gms');
            }else if($('#Barcode').val() == ''){
                $('#Barcode_error').html('Please Input Barcode');
            }else{

             if ($('#receiverselect').val() == 0) {
                $('#erroraddress1').html('Please Select Address Type');
            }else{


                $('#erroraddress1').hide();
                var address = $('.address1').val();
                if (address == 'physical') {
                    $('#divadd').hide();
                    
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     var region_to = $('.region_to').val();
                     var district = $('.district').val();
                       if(name == ''){
                         $('#r_fname_error').html('Please input Receiver Name ');

                     }
                    // else if (mob == '') {
                    //  $('#r_mobile_error').html('Please input Mobile Number ');
                    //  $('#r_fname_error').hide();
                    //  }
                     
                     else if(region_to == ''){
                         $('#region_to_error').html('Please Select Region Name ');
                          $('#r_mobile_error').hide();

                     }  
                      else if(district == ''){
                         $('#district_error').html('Please Select Branch Name ');
                        $('#region_to_error').hide();


                     } 
                      else{

                    
                        var emstype   = $('#boxtype').val();
                        var emsCat = $('#tariffCat').val();
                        var weight = $('#weight').val();
                        var acc_no  = $('#acc_no').val();

                        var Barcode = $('#Barcode').val();

                        
                        var serial  = $('.serial').val();

                       


                        var sender     = $('#sender').val();
                      
                        
                        var receiverselect   = $('#receiverselect').val();
                        var r_fname   = $('#r_fname').val();
                        var r_address     = $('#r_address').val();
                        var r_email     = $('#r_email').val();
                        var r_mobile    = $('#r_mobile').val();
                        var r_mobilev    = $('#r_mobilev').val();
                        var region_to   = $('#rec_region').val();
                        var district         = $('#rec_dropp').val();
                        

                            $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('Ems_Domestic/document_parcel_bill_bulk_save')?>",
                             //dataType : "JSON",
                             data : {weight:weight,emstype:emstype,emsCat:emsCat,Barcode:Barcode,
                                    sender:sender,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district,serial:serial,acc_no:acc_no},
                             success: function(data){
                                 $('#div6').show();
                                $('.list').html(data);
                                $('.price').html('');

                                 $('#addmore').attr("disabled", false);


                                    
                                    $('#boxtype').val();
                                    $('#weight').val('');
                                    $('#tariffCat').val();
                      
                        
                                     // $('#receiverselect').val('');
                                    $('#r_fname').val('');
                                      $('#Barcode').val('');
                                     $('#r_address').val('');
                                     $('#r_email').val('');
                                    $('#r_mobile').val('');
                                     $('#r_mobilev').val('');
                                    $('#rec_region').val('');
                                     $('#rec_dropp').val('');
                             }
                         });




                     }
                }else if(address == 'virtual') {
                    $('#erroraddress1').hide();
                      $('#divadd').show();
                     var mobv = $('.r_mobilev').val();
                     if (mobv == '') {
                     $('#r_mobilev_error').html('Please input Mobile Number ');
                     }  else{ //submit

                        //$('.disable').attr("disabled", true);
                       // $('#wixy').submit()
                     //$('.disable').attr("disabled", true);

                            var emstype   = $('#boxtype').val();
                        var emsCat = $('#tariffCat').val();
                        var weight = $('#weight').val();
                         var Barcode = $('#Barcode').val();
                         var acc_no  = $('#acc_no').val();

                        
                        var serial  = $('.serial').val();

                       


                        var sender     = $('#sender').val();
                    
                        
                        var receiverselect   = $('#receiverselect').val();
                        var r_fname   = $('#r_fname').val();
                        var r_address     = $('#r_address').val();
                        var r_email     = $('#r_email').val();
                        var r_mobile    = $('#r_mobile').val();
                        var r_mobilev    = $('#r_mobilev').val();
                        var region_to   = $('#rec_region').val();
                        var district         = $('#rec_dropp').val();
                        

                            $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('Ems_Domestic/document_parcel_bill_bulk_save')?>",
                             //dataType : "JSON",
                             data : {weight:weight,emstype:emstype,emsCat:emsCat,Barcode:Barcode,
                                    sender:sender,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district,askfor:askfor,serial:serial,acc_no:acc_no},
                             success: function(data){
                                 $('#div6').show();
                                $('.list').html(data);
                                $('.price').html('');

                                 $('#addmore').attr("disabled", false);

                                    
                                    $('#boxtype').val();
                                    $('#weight').val('');
                                    $('#tariffCat').val();
                      
                        
                                     // $('#receiverselect').val('');
                                    $('#r_fname').val('');
                                     $('#Barcode').val('');
                                     $('#r_address').val('');
                                     $('#r_email').val('');
                                    $('#r_mobile').val('');
                                     $('#r_mobilev').val('');
                                    $('#rec_region').val('');
                                     $('#rec_dropp').val('');
                             }
                         });
                    }
               
                    }


                    }
                    }


                     


                }
                
          

        
       
             });
       
        
       
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
<!-- <script type="text/javascript">
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

</script> -->

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

function validateBarcode(obj){
    var barcode = $(obj).val();
   
    if (barcode.length != 13) {
        $('#boxtype').attr('disabled','disabled');
        $('#tariffCat').attr('disabled','disabled');
        $('#weight').attr('disabled','disabled');
        $('#receiverselect').attr('disabled','disabled');
        $('#savingBox').hide();


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
                    $('#boxtype').attr('disabled','disabled');
                    $('#tariffCat').attr('disabled','disabled');
                    $('#weight').attr('disabled','disabled');
                    $('#receiverselect').attr('disabled','disabled');
                    $('#savingBox').hide();


                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);
                }else{
                    //$('#optionBox').show();
                    $('#boxtype').removeAttr('disabled');
                    $('#tariffCat').removeAttr('disabled');
                    $('#weight').removeAttr('disabled');
                    $('#receiverselect').removeAttr('disabled');
                    $('#savingBox').show();


                    $('#forMessage').hide();
                    $('#notifyMessage').html('');
                }
            }
        });
    }

}
</script>


<?php $this->load->view('backend/footer'); ?>

