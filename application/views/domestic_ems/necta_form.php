<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Necta Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Necta Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/necta_info" class="text-white"><i class="" aria-hidden="true"></i> Necta Transactions</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/necta_delete_form" class="text-white"><i class="" aria-hidden="true"></i> Add/Delete Subject</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Necta/necta_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Necta Transanctions List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/bulk_necta" class="text-white"><i class="" aria-hidden="true"></i> Bulk Necta </a></button>
                    
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/necta_online_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Online Necta Registration </a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Necta Form
                        </h4>
                    </div>

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
                            <!-- <form method="POST" action="<?php echo base_url()?>Necta/Save_necta_Info" id="wixy"> -->
                                <div class="row" id="dataForm">
                                    <div class="col-md-12">
                                        <input type="hidden" id="r_name" name="r_name" value="NECTA">
                                        <input type="hidden" id="r_region" name="r_region" value="Dar es Salaam">
                                        <input type="hidden" id="r_address" name="r_address" value="P.O. BOX 2624/32019">
                                        <input type="hidden" id="r_zipcode" name="r_zipcode" value="">
                                        <input type="hidden" id="r_phone" name="r_phone" value="255-22-2775966">
                                        <input type="hidden" id="r_email" name="r_email" value="esnecta@necta.go.tz">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Registration Number</label>
                                        <input id="rnumber" type="text" name="rnumber" class="form-control rnumber" >
                                         <span style="color: red" class="rnumbererror"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label>[Select Address]</label>
                                        <select id="addtype" class="form-control custom-select addtype" name="addtype" onchange="getBoxType();" style="height:43px;">
                                            <option>Physical</option>
                                            <option>Virtual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 sfulname">
                                        <label>Sender Full Name</label>
                                        <input id="s_fullname" type="text" name="s_fullname" class="form-control s_fullname">
                                        <span style="color: red" class="s_fullnameerror"></span>
                                    </div>
                                    <div class="col-md-3 address">
                                        <label>Sender Address</label>
                                        <input id="s_address" type="text" name="s_address" class="form-control">
                                    </div>
                                    <div class="col-md-3 s_mobile" >
                                        <label>Sender Mobile</label>
                                        <input id="s_mobile" type="text" name="s_mobile" class="form-control pn" >
                                        <span style="color: red" class="pnerror"></span>
                                    </div>


                                     <div class="col-md-3">
                                <label>Barcode:</label> 
                                <input onkeyup="validateBarcode(this)" onchange="validateBarcode(this)" type="text" name="Barcode" class="form-control Barcode" id="Barcode" required="required" />

                                <span id="Barcode_error"  class="Barcode_error" style="color: red;"></span>
                                </div>
                                    <div class="col-md-3">
                                    <label>Category</label>
                                    <select id="category" class="form-control custom-select category" name="category" >
                                        <option value="">--Select Category--</option>
                                        <option value="ACSEE">FORM SIX(ACSEE)</option>
                                        <option value="CSEE">FORM FOUR(CSEE)</option>
                                         <option value="QT">QT</option>
                                    </select>
                                     <span style="color: red" class="categoryerror"></span>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 add1">
                                        
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="float: right;">
                                    <div class="col-md-12">
                                        <button  onclick="saveInformations()" class="btn btn-info" type="button" id="submitform">Save Information</button>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script>
function myFunction() {

 var price = $('.price').val().replace(/[^\d.-]/g, '');
 //var s = price.replace(/[^\d.-]/g, '');

   if(price > 0.5){

     $('.priceerror').html('Weight Maximum Limit is 0.5kg');
     $('.submit').attr("disabled", true);

   }else{
      $('.priceerror').html('');
      $('.price').val(price);
      $('.submit').attr("disabled", false);
   }

 
}


function saveInformations(){

      var price   = $('#totalPrice').val();
      var Barcode   = $('#Barcode').val();
      var emstype   = $('#boxtype').val();
      var emsCat = $('#tariffCat').val();
      var registerType = $('#regtype').val();
      var tariffCatCity = $('#tariffCatCity').val();
      var boxtypeDistrict = $('#boxtype').val();
      var weight = $('#weight').val();
      var s_fullname     = $('#s_fullname').val();
      var s_address     = $('#s_address').val();
      var s_mobile    = $('#s_mobile').val();
      var senderselect    = $('#senderselect').val();
      var r_fname   = $('#r_name').val();
      var r_address     = $('#r_address').val();
      var r_mobile    = $('#r_mobile').val();
      var rec_region   = $('#r_region').val();
      var r_zipcode   = $('#r_zipcode').val();
      var r_phone   = $('#r_phone').val();
      var r_email   = $('#r_email').val();
      var rec_dropp         = $('#rec_dropp').val()
      var receiverselect         = $('#receiverselect').val();
      var add_type_receiver         = $('#receiverselect').val();
      var add_type_sender         = $('#senderselect').val();
      var add_type_sender         = $('#senderselect').val();

      var rnumber         = $('#rnumber').val();
      var addtype         = $('#addtype').val();
      var category         = $('#category').val();

        //Price
        var Dpprice = $('.dprice').val();
        var dpvat = $('.dpvat').val();
        var DpTotalPrice = $('.dpTotalPrice').val();

        if ($('#rnumber').val() == '') {
            $('#rnumbererror').html('Please Select Ems tariff Category Type');
        }else if($('#addtype').val() == ''){
            $('#weight_error').html('Please Select address');
        }else if($('#Barcode').val() == ''){
            $('#Barcode_error').html('Please Input Barcode is required');
        }else if ($('#s_mobile').val() == '') {
            $('.pnerror').html('Please Input mobile is required');
        }else if ($('#s_fullname').val() == '') {

            $('#s_fullnameerror').html('Please Full name');

        }else if ($('#category').val() == '') {

            $('#categoryerror').html('Please input category');

        }else{

             $('#loadingtext').html('Processing controll number, please wait............');
             $('#submitform').hide();

            $.ajax({
        type : "POST",
        url  : "<?php echo base_url('Necta/Save_necta_Info')?>",
        dataType : "JSON",
        data : {
         Barcode:Barcode,
         rnumber:rnumber,
         addtype:addtype,
         emstype:emstype,
         emsCat:emsCat,
         Dpprice:Dpprice,
         dpvat:dpvat,
         DpTotalPrice:DpTotalPrice,
         registerType:registerType,
         tariffCatCity:tariffCatCity,
         boxtypeDistrict:boxtypeDistrict,
         add_type_receiver:add_type_receiver,
         add_type_sender:add_type_sender,
         weight:weight,
         s_fullname:s_fullname,
         s_address:s_address,
         s_mobile:s_mobile,
         senderselect:senderselect,
         r_fname:r_fname,
         r_address:r_address,
         r_mobile:r_mobile,
         rec_region:rec_region,
         rec_dropp:rec_dropp,
         price:price,
         r_zipcode:r_zipcode,
         r_phone:r_phone,
         r_email:r_email,
         category:category,
         receiverselect:receiverselect
      },
        success: function(response){

         if (response['status'] == 'Success') {
            $('#loadingtext').html(response['message']);

            $('.dprice').val('');
             $('.dpvat').val('');
             $('.dpTotalPrice').val('');

             $('#div3').hide();
             $('#div2').hide();
             $('#div1').hide();
             $('#dataForm').hide();

            setTimeout(function(){
                 // location.reload();
             },6000)

             $('#Barcode').val('');

         }else{
            $('#submitform').hide();
            $('#loadingtext').html(response['message']);

             $('#Barcode').val('');

             //setTimeout(function(){
                 $('#loadingtext').html('');
             //},6000)
         }

        }
    });

        }

}
 

    function validateBarcode(obj){
    var barcode = cleanBarcode($(obj).val());
    //update in the text input
    $(obj).val(cleanBarcode(barcode))
        
   
    if (barcode.length != 13) {
        $('#boxtype').attr('disabled','disabled');
        $('#weight').attr('disabled','disabled');
        $('#add_type_receiver').attr('disabled','disabled');
        $('#addmore').hide();
        $('#submitform').hide();
        $('#1step').hide();


        $('#forMessage').show();
        $('#notifyMessage').html('Tafadhali barcode haijakamilika = 13');
    }else{
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url();?>Loan_Board/checkBarcodeIsReuse",
            data:'barcode='+barcode,
            dataType:'json',
            success: function(data){
                // console.log(data)
                 
                if(data['status'] == 'available'){
                    $('#boxtype').attr('disabled','disabled');
                    $('#weight').attr('disabled','disabled');
                    $('#add_type_receiver').attr('disabled','disabled');
                    $('#addmore').hide();
                    $('#submitform').hide();
                    $('#1step').hide();


                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);
                }else{
                    //$('#optionBox').show();
                    $('#regtype').removeAttr('disabled');
                    $('#weight').removeAttr('disabled');
                    $('#boxtype').removeAttr('disabled');
                    $('#add_type_receiver').removeAttr('disabled');
                    $('#addmore').show();
                    $('#submitform').show();
                    $('#1step').show();


                    $('#forMessage').hide();
                    $('#notifyMessage').html('');
                }
            }
        });
    }

}

 function cleanBarcode(barcode){
        //remove any space from the string
        return  $.trim(barcode.replace(/ /g,''));
    }


    $('#submitform').on('click',function(){

         // $('.disabled').attr("disabled", true);
         
          
              var rnumber = $('.rnumber').val();
              var category = $('.category').val();
              var addtype = $('.addtype').val();
                var s_fullname = $('.s_fullname').val();
                var pn = $('.pn').val();
                  var pn1 = $('.pn1').val();
                var Barcode = $('.Barcode').val();
             
                if (addtype == 'Physical') {
                    if (rnumber == '') {
                 $('.rnumbererror').html('Please input Registration Number');
                
              }
                 else if (s_fullname == '') {
                 $('.s_fullnameerror').html('Please input Sender Name');
                  $('.rnumbererror').hide();
                
              }
              
                 else if (pn == '') {
                 $('.pnerror').html('Please input Mobile Number');
                 $('.s_fullnameerror').hide();
                
              }else if (category == '') {
                 $('.categoryerror').html('Please Select Category');
                 $('.pnerror').hide();
                
              } else if (Barcode == '') {
                 $('.Barcode_error').html('Please input Barcode Number');
                 $('.s_fullnameerror').hide();
                
              }
                else{
                //$('.disabled').attr("disabled", true);
                 $('.disable').attr("disabled", true);
               
                 $('#wixy').submit()
              } 


              }
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              
                else if (rnumber == '') {
                 $('.rnumbererror').html('Please input Registration Number');
                
              }
               else if (pn1 == '') {
                 $('.pnerror1').html('Please input Mobile Number');
                 $('.rnumbererror1').hide();
                 //$('.priceerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }else if (category == '') {
                 $('.categoryerror').html('Please Select Category');
                 $('.pnerror').hide();
                
              }else if (Barcode == '') {
                 $('.Barcode_error').html('Please input Barcode Number');
                 $('.rnumbererror').hide();
                
              }
               else{
                //$('.disabled').attr("disabled", true);
                //$('.priceerror').hide();
                //$('#submitform').submit()
                 $('.disable').attr("disabled", true);
                 $('#wixy').submit()
              } 


            
        })

    $('.submit').on('click',function(){
            $('.submit').attr("disabled", true);
        })

    function getBoxType(){

        var addtype = $('.addtype').val();
        if( addtype == 'Virtual'){
            $('.sfulname').hide();
            $('.address').hide();
             $('.s_mobile').hide();
             $('.s_mobile1').show();
        }else{
            $('.sfulname').show();
             $('.s_mobile1').hide();
             $('.s_mobile').show();
            $('.address').show();
        }
    }

function ShowDetails() {
var pn = $('.pn1').val();

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
<?php $this->load->view('backend/footer'); ?>
