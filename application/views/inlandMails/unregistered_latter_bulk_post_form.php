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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ordinary Latter Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ordinary Latter Application</li>
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
                    
                    <?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "RM"){ ?>
                   
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/mail_bulk_bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill  Customer List</a></button>
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button> -->
                  
                   
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($custinfo->credit_id) ?>&&AskFor=<?php echo $askfor; ?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bulk Bill Ordinary Latter </a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/latter_bulk_bill_transaction_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Ordinary Latter Transactions List</a></button>
                   
                         
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                      
                    
                   <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/mail_bulk_bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill  Customer List</a></button>
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button> -->
                  
                   
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($custinfo->credit_id) ?>&&AskFor=<?php echo $askfor; ?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bulk Bill Ordinary Latter </a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/latter_bulk_bill_transaction_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Ordinary Latter Bill Transactions List</a></button>
                   
                   <?php } ?>
                   
                     
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> 
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- <form action="register_sender_info?AskFor=<?php echo $askfor; ?>" method="POST" id="wixy"> -->
                         
                        <div class="card">

                           <div class="card-body">


                     


                                <div id="div1" style="display: none;" >
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 1 of 3  - Sender Personal Details</h3>
                                </div>

                                 <div class="col-md-3">
                                    <label><b><h4>Select Address:</h4></b></label>
                                    <select class="form-control custom-select address" onchange="getAddress();" name="add_type_sender" id="senderselect">
                                        <option>--Select Address--</option>
                                        <option value="physical" >Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                     <span id="select_error" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3 virtual" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="s_mobilev" id="s_mobilev" class="form-control pn1 s_mobilev" onkeyup="ShowDetails1();">
                                     <span id="mobileverror" style="color: red;"></span>
                                </div>
                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control" value="<?php echo @$custinfo->customer_name; ?>">
                                     <span id="s_fnameerror" style="color: red;"></span>
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="s_address" id="s_address" class="form-control"  value="<?php echo @$custinfo->customer_address; ?>">
                                    <span id="s_addresserror" style="color: red;"></span>
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="s_email" id="s_email" class="form-control" value="<?php echo @$custinfo->cust_email; ?>">
                                </div>

                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control s_mobile"  value="<?php echo @$custinfo->cust_mobile; ?>">
                                     <span id="mobileerror" style="color: red;"></span>

                                   
                                    <span id="errmobile" style="color: red;"></span>
                                </div>

                            </div>
                                <br>
                                 <div class="row" id="divadd1">
                                <div class="col-md-12 add"></div>
                            </div>


                                                           <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                       
                                        <a href="#" class="btn btn-info" id="1step">Next Step</a>
                                    </div>
                                </div>
                                </div>




                              <div id="div2" >
                     
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 2  - Ordinary Latter Selection</h3>
                                </div>
                                <div class="form-group col-md-3">
                                    <label> Type</label>
                                    <select name="emsname" value="" class="form-control custom-select boxtype" id="boxtype" required  onchange="functionParcel();">
                                            <option value="Ordinary Latter">Ordinary Latter</option>
                                            <!-- <option value="Parcel">Parcel</option> -->
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3">
                                <label>Weight in gms:</label>
                            
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control catweight" id="weight" required="required" />
                                <span id="weight_error" style="color: red;"></span>
                                </div>
                                  <div class="col-md-3">
                                <label>Quantity:</label>
                            
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="quantity" class="form-control quantity" id="quantity" onkeyup="getPriceFrom()"  />
                                <span id="weight_error" style="color: red;"></span>
                                </div>

                                <?php if(@$custinfo->customer_name == 'NBAA.'){ ?>
                                <div class="col-md-3" class="radio-inline">
                                 <!-- <label>Additional Service:</label><br /> --><br />
                                Within Region <input type="checkbox" name="inn" class="form-control inn" onchange="getPriceFrom()"> 
                                Out of Region <input type="checkbox" name="out"  class="form-control out" onchange="getPriceFrom()" >
                                </div>
                               <?php }?>
                                
                                </div>
                               
                                 <div id="div367" style="display:none" >
                                   <div class="row">
                               

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
                                    <input type="text" name="r_address" id="r_address" class="form-control">
                                    <span id="r_addresserror" style="color: red;"></span>
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
                                </div>
                                <div class="row " id="divadd">

                                <div class="col-md-6 add1"></div>
                            </div>


                               
                                </div>
                                 <br>
                                <div class="row">
                                    <div class="col-md-6" style="float: right;">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>


                                    
                                </div>
                                </div>

                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                     <div class="col-md-6">
                                        <span id="serialerror" style="color: red;"></span>
                                     <button  class="btn btn-info  " type="button" id="addmore"  >Add More</button>

                                     <button  class="btn btn-info disable " type="button" id="submitform" disabled="disabled" >Save Information</button>

                                       

                                      <form id="registered" action="<?php echo base_url()?>unregistered/save_register_bill_sender_bulk_info"  method="POST">
                                      <!-- <input type="text" hidden="hidden" name="status" value="Back" class="" > -->
                                       <input type="text" hidden="hidden" id="serial2" name="serial" value="" class="" >
                                        <input type="text" hidden="hidden" id="operator2" name="operator" value="Register" class="" >

                                           <input type="hidden" name="crdtid" id="crdtid" class="form-control" onkeyup="myFunction()" value="<?php echo @$custinfo->credit_id; ?>">
                            <input type="hidden" name="askfor" id="askfor" class="form-control" value="<?php echo @$askfor; ?>">
                            <input type="hidden" name="price" id="price" class="form-control" value="<?php echo @$custinfo->price; ?>">
                            <input type="hidden" name="accno" id="accno" class="form-control" value="<?php echo @$custinfo->acc_no; ?>">
                                     
                                        
                                      </form>
                                       


                                    </div>
                                </div>
                                <br>
                                
                                </div>


                                  <br>
                                  <div id="div6" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="list" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                            </div>

                               

                                <div id="div4" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 3  - Payment Information</h3>
                                </div>
                                </div>
                                <br />
                                <div class="row">
                                <div class="col-md-12">
                                    <br />
                                    <span class ="majibu" id="majibu" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
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

<script type="text/javascript">


  function Deletevalue() {
   
                          var senderid  = $('.senders').val();
                          var serial  = $('.serial').val();
                           //alert('imefika33');
                        
                         $.ajax({
                             type : 'POST',
                             url  : '<?php echo base_url('unregistered/delete_later_sender_bulk_info')?>',
                             
                             data : {senderid:senderid,serial:serial},
                             success: function(data){
                                 $('#div6').show();
                                 $('.list').html('');
                                
                                  $('.list').html(data);
                                
                                      
                                   }
                               });
              
                            }

    $(document).ready(function() {

         $('#submitform').on('click',function(){ 
            $('.disable').attr("disabled", true);
             $('#2stepBack').prop('disabled', true);
             $('#addmore').prop('disabled', true);
            

             var serial  = $('.serial').val();
              var operator  = $('.operator').val();
               var askfor     = $('#askfor').val();
                var crdtid     = $('#crdtid').val();
                
            
                 $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('unregistered/save_later_bill_sender_bulk_info')?>",
                             //dataType : "JSON",
                             data : {serial:serial,operator:operator,askfor:askfor,crdtid:crdtid},
                             beforeSend: function() {
                                //$("#loaderDiv").show();
                               //$("body").addClass("loading");
                                  $("#submitform").addClass('button_loader').attr("value",""); 
                                  //$('#loader').removeClass('hidden');
                                
                             },
                             success: function(data){
                                 $('#submitform').removeClass('button_loader').attr("value","\u2713");
                                 $('#submitform').prop('disabled', true);
                                // $('.majibu').html(data);
                                 // $('.price').html('');
                                 // $('#div6').hide();
                                 //  $('#div2').hide();
                                 //  $('#div4').show();



                                window.location.href = "<?php echo base_url() ?>unregistered/unregistered_latter_bulk_post_form?I=<?php echo base64_encode($custinfo->credit_id) ?>&&AskFor=<?php echo $askfor; ?>";
                                
                                
                             }
                         });
         //}
        
       
         });

      


          $('#addmore').on('click',function(){
            $('.disable').attr("disabled", false);

        if ($('#boxtype').val() == 0) {
         $('#error1').html('Please Select  Type');
        }else{



            if ($('#quantity').val() == '') {
                $('#quantity_error').html('Please  Input Quantity');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('Please Input Weight in gms');
            }else{
                    
                   var quantity  = $('.quantity').val();
                        //var price   = $('.price1').val();
                        var emstype   = $('#boxtype').val();
                        //var emsCat = $('#tariffCat').val();
                        var weight = $('#weight').val();

                        var crdtid     = $('#crdtid').val();
                        var price     = $('#price').val();
                        var accno     = $('#accno').val();
                        var askfor     = $('#askfor').val();
                        var serial  = $('.serial').val();
                         var operator  = $('.operator').val();

                        var senderselect     = $('#senderselect').val();
                        var s_fname     = $('#s_fname').val();
                        var s_address     = $('#s_address').val();
                        var s_email     = $('#s_email').val();
                        var s_mobile    = $('#s_mobile').val();
                        var s_mobilev    = $('#s_mobilev').val();

                        var inn  = $('.inn').val();
                          var out  = $('.out').val();
                           if($('.inn').is(':checked')){inn ='onn'; }
                              if($('.out').is(':checked')){out ='onn'; }
                                              
                       
                        

                            $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('unregistered/latter_bill_sender_bulk_info')?>",
                             //dataType : "JSON",
                             data : {weight:weight,emstype:emstype,quantity:quantity,crdtid:crdtid,price:price,accno:accno,
                                inn:inn,out:out,
                                    senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    askfor:askfor,serial:serial},
                             success: function(data){
                                 $('#div6').show();
                                $('.list').html(data);
                                $('.price').html('');



                                    $('.quantity').val('');
                                    $('#boxtype').val();
                                    $('#weight').val('');

                                     $('#serial2').val(serial);
                                     $('#operator2').val(operator);
                      
                        
                                    
                                 }
                             
                         });




                     }
                


                    
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
        
        });


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

 var weight = $('.catweight').val();
  var tariffCat  = $('.boxtype').val();
  var quantity  = $('.quantity').val();

   var crdtid     = $('#crdtid').val();

   var inn  = $('.inn').val();
  var out  = $('.out').val();
   if($('.inn').is(':checked')){inn ='onn'; }
      if($('.out').is(':checked')){out ='onn'; }

if (weight == '' || quantity == '') {

}else{

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/latter_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,quantity:quantity,crdtid:crdtid,inn:inn,out:out},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}

    }
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
</script>

<script type="text/javascript">
//save data to databse
$('#btn_save').on('click',function(){
            $('.disable').attr("disabled", true);

             return false;
    
        });


</script>
<script type="text/javascript">
function getEMSType() {

var tariffCat = $('#boxtype').val();
var weight = $('.catweight').val();
var ad_fee  = $('.ad_fees').val();

if (weight == '' || ad_fee == '') {

}else{

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/uregister_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,ad_fee:ad_fee},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}

};
</script>
<script type="text/javascript">
    $('.boxtype').on('change', function() {
       var type = $('.boxtype').val();
      // $('.ad_fees').val('');
       if ( type == 'Parcel') {
         $('.ad_fee').show();
       }else{
         $('.ad_fee').hide();
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
