<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Loans Board Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems Loans Board Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Loan_Board/Loan_info" class="text-white"><i class="" aria-hidden="true"></i> Heslb Transactions</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Loan_Board/loan_board_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Heslb Transanctions List</a></button>

                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Loan_Board/Repost_Pending_Bills" class="text-white"><i class="" aria-hidden="true"></i> Repost Pending Bills</a></button>
                    
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Ems Loans Board Form
                        </h4>
                    </div>
                    <div class="card-body">
                            <form method="POST" action="<?php echo base_url()?>Loan_Board/Save_Heslb_Info" id="wixy">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="r_name" value="HESLB">
                                        <input type="hidden" name="r_region" value="Dar es Salaam">
                                        <input type="hidden" name="r_address" value="P.O.BOX 7608">
                                        <input type="hidden" name="r_zipcode" value="15471">
                                        <input type="hidden" name="r_phone" value="0225507910">
                                        <input type="hidden" name="r_email" value="info@heslb.go.tz">
                                    </div>
                                    <div class="col-md-3">
                                        <label>[Select Address]</label>
                                        <select class="form-control custom-select addtype" name="addtype" onchange="getBoxType();" style="height:43px;">
                                            <option>Physical</option>
                                            <option>Virtual</option>
                                        </select>
                                    </div>


                                    <div class="col-md-3 sfulname">
                                        <label>[Sender Full Name]</label>
                                        <input type="text" name="s_fullname" class="form-control s_fullname">
                                        <span style="color: red" class="s_fullnameerror"></span>
                                    </div>
                                    <div class="col-md-3 address">
                                        <label>[Sender Address]</label>
                                        <input type="text" name="s_address" class="form-control">
                                    </div>
                                    <div class="col-md-3 pn">
                                        <label>[Sender Mobile]</label>
                                        <input type="text" name="s_mobile" class="form-control pnn" >
                                        <span style="color: red" class="pnerror"></span>
                                    </div>

                                     <div class="col-md-3 pn1" style="display:none">
                                        <label>[Sender Mobile]</label>
                                        <input type="text" name="s_mobilev" class="form-control pnn1" onkeyup="ShowDetails();">
                                        <span style="color: red" class="pnerror1"></span>
                                    </div>


                                    <div class="col-md-3">
                                        <label>[Weight Step]</label>
                                        <input type="text" name="Weight" class="form-control price"  required="required">
                                        <!-- onkeyup="myFunction()" -->
                                        <span style="color: red" class="priceerror"></span>
                                    </div>

                                     <div class="col-md-3">
                                <label>Barcode:</label>
                                <input type="text" name="Barcode" class="form-control Barcode" id="Barcode" />

                                <span id="Barcode_error" style="color: red;"></span>
                                </div>


                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6 add1">
                                        
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="float: right;">
                                    <div class="col-md-12">
                                        <button  class="btn btn-info disabled" type="button" id="submitform"  >Save Information</button>
                                    </div>
                                </div>
                            </form>
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
     //$('.disabled').attr("disabled", true);

   }else{
      $('.priceerror').html('');
      $('.price').val(price);
      //$('.disabled').attr("disabled", false);
   }

 
}
 
</script>
<script type="text/javascript">
    $('#submitform').on('click',function(){

         // $('.disabled').attr("disabled", true);
          var prices = $('.price').val().replace(/[^\d.-]/g, '');
            var price = $('.price').val();
              var addtype = $('.addtype').val();
                var s_fullname = $('.s_fullname').val();
                var pnn = $('.pnn').val();
                var pnn1 = $('.pnn1').val();
                 var Barcode = $('.Barcode').val();
             // if (price == '') {
             //     $('.priceerror').html('Please input Weight in Kg');
             //     $('.s_fullnameerror').hide();
             //     $('.pnerror').hide();
             //     //$('.disabled').attr("disabled", false);
             //     //$('.submit').attr("disabled", true);
             //  }
              // else if(price > 0.5){
              //    $('.priceerror').html('Weight Maximum Limit is 0.5kg');
              //    $('.s_fullnameerror').hide();
              //    $('.pnerror').hide();
              //    $('.disabled').attr("disabled", false);

              //  }
               // else if(price < 0.5){
               //   $('.priceerror').html('');
               //   $('.price').val(prices);
               //   $('.s_fullnameerror').hide();
               //   $('.pnerror').hide();
               //   $('.disabled').attr("disabled", false);

               // }

                 if (Barcode == '') {
                 $('#Barcode_error').html('Please input Barcode Number');
                
              }

                else if (addtype == 'Physical') {
                 if (s_fullname == '') {
                 $('.s_fullnameerror').html('Please input Sender Name');
                 //$('.priceerror').hide();
                 //$('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }
              
                 else if (pnn == '') {
                 $('.pnerror').html('Please input Mobile Number');
                 $('.s_fullnameerror').hide();
                // $('.priceerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }
               else if (price == '') {
                 $('.priceerror').html('Please input Weight in Kg');
                 //$('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }
               else if(price > 0.5){
                 $('.priceerror').html('Weight Maximum Limit is 0.5kg');
                // $('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);

               }
               else if(price < 0.5){
                 $('.priceerror').html('');
                 $('.price').val(prices);
                 //$('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                  $('.disable').attr("disabled", true);
                 $('#wixy').submit()
                 //$('.disabled').attr("disabled", false);

             } else{
                //$('.disabled').attr("disabled", true);
                $('.priceerror').hide();
                //$('#submitform').submit()
                 //$('#wixy').submit()
              } 


              }
               else if (addtype == 'Virtual') {
                 
                 if (pnn1 == '') {
                 $('.pnerror1').html('Please input Mobile Number');
                 //$('.s_fullnameerror').hide();
                 //$('.priceerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }
               else if (price == '') {
                 $('.priceerror').html('Please input Weight in Kg');
                 //$('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }
               else if(price > 0.5){
                 $('.priceerror').html('Weight Maximum Limit is 0.5kg');
                // $('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);

               }
               else if(price < 0.5){
                 $('.priceerror').html('');
                 $('.price').val(prices);
                 //$('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                  $('.disable').attr("disabled", true);
                 $('#wixy').submit()
                 //$('.disabled').attr("disabled", false);

             } else{
                //$('.disabled').attr("disabled", true);
                $('.priceerror').hide();
                //$('#submitform').submit()
                 //$('#wixy').submit()
              } 
              }
              

                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              
                 
              
               else if (price == '') {
                 $('.priceerror').html('Please input Weight in Kg');
                 //$('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);
                 //$('.submit').attr("disabled", true);
              }  else if(price > 0.5){
                 $('.priceerror').html('Weight Maximum Limit is 0.5kg');
                // $('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);

               }
               else if(price < 0.5){
                 $('.priceerror').html('');
                 $('.price').val(prices);
                 //$('.s_fullnameerror').hide();
                 $('.pnerror').hide();
                 //$('.disabled').attr("disabled", false);
                  $('.disable').attr("disabled", true);
                 $('#wixy').submit()

             } else{
                //$('.disabled').attr("disabled", true);
                $('.priceerror').hide();
                //$('#submitform').submit()
                 //$('#wixy').submit()
              } 


            
        })
</script>
<script type="text/javascript">
    function getBoxType(){

        var addtype = $('.addtype').val();
        if( addtype == 'Virtual'){
            $('.sfulname').hide();
            $('.address').hide();
            $('.pn').hide();
             $('.pn1').show();
        }else{
            $('.sfulname').show();
            $('.address').show();
             $('.pn').show();
        }
    }
</script>
<script>
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
