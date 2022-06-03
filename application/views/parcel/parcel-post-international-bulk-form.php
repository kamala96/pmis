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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Parcel Post International Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Parcel Post International</li>
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
                     <?php if($this->session->userdata('user_type') =='ACCOUNTANT' 
                  || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ ?>
               
                  <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>parcel/international_parcel_list" class="text-white"><i class="" aria-hidden="true"></i> Parcel International Transaction List</a></button>

<?php }else{?>
       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>parcel/international_parcel_form" class="text-white"><i class="" aria-hidden="true"></i> Add Parcel International Transaction</a></button>

        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>parcel/international_bulk_parcel_form" class="text-white"><i class="" aria-hidden="true"></i> Add Bulk Parcel International Transaction</a></button>

        
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>parcel/international_parcel_list" class="text-white"><i class="" aria-hidden="true"></i> Parcel International Transaction List</a></button>
                         <?php }?>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Bulk Parcel Post Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="parcel_post_sender_info" method="POST" id="wixy">
                        <div class="card">

                           <div class="card-body">

                            <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>
                        
                            <!-- <div id="div1">
                     
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Parcel Post Selection</h3>
                                </div>
                                <div class="col-md-3">
                                <label>Parcel Selection:</label>
                                 <select class="form-control custom-select trans" id="trans" name="transport" required>
                                   <option value="0">--Parcel Type--</option>
                                   <option value="Land">INLAND PARCELS POST</option>
                                   <option value="Water">PARCEL SUBJECTED TO PORT CHARGES</option>
                                 </select>
                                 <span id="transerror" style="color: red;"></span>
                                </div>

                                 <div class="form-group col-md-3">
                                    <label>Parcel Post Category Type</label>
                                    <select name="emsname" value="" class="form-control custom-select boxtype" id="boxtype" required  onchange="getPriceFrom();">
                                            <option value="0">--Select Category--</option>
                                            <option value="Ordinary">Ordinary Parcel</option>
                                            <option value="Cumbersome">Cumbersome/Fragile </option>
                                            <option value="Post">Parcel Post</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                                 <div class="col-md-3">
                                <label>Weight in kg:</label>
                             
                                 <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"  />
                                <span id="weight_error" style="color: red;"></span>
                                </div>
                                
                               

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <button class="btn btn-info" type="button" id="1step">Next Step</button>
                                    </div>
                                </div>
                                <br>
                                
                                </div> -->


                                <div id="div2" >
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 1 of 3  - Sender Personal Details</h3>
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

                            


                                                           <!-- <br> -->


                               <!--  <div class="col-md-3">
                                    <label>Full Name:</label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control" onkeyup="myFunction()">
                                    <span id="errfname" style="color: red;"></span>
                                </div>
                                <div class="col-md-3">
                                    <label>Address:</label>
                                    <input type="text" name="s_address" id="s_address" class="form-control" onkeyup="myFunction()">
                                    <span id="erraddress" style="color: red;"></span>
                                </div>
                                <div class="col-md-3">
                                    <label>Email:</label>
                                    <input type="email" name="s_email" id="s_email" class="form-control" onkeyup="myFunction()">
                                    <span id="erremail" style="color: red;"></span>
                                </div>
                                <div class="col-md-3">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="errmobile" style="color: red;"></span>
                                </div> -->

                                 <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <!-- <button class="btn btn-warning btn-sm" type="button" id="1stepBack">Back Step</button> -->
                                        <button class="btn btn-info btn-sm" type="button" id="2step">Next Step</button>
                                    </div>
                                </div>
                            </div>
                               

                                <!-- </div> -->


                                <div id="div3" style="display: none;">

                                   <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 2 of 3  - Reciever Personal Details</h3>
                                </div>



                                   <div id="div3687" class="col-md-12">
                                   <div class="row">

                                <div class="col-md-3">
                                <label>Item Number(Barcode):</label>
                                 <input 

                                 onkeyup="validateBarcode(this)" 
                                onchange="validateBarcode(this)" type="text" name="Item" class="form-control Item" id="Item" >
                                <span id="Item_error" style="color: red;"></span>
                                </div>
                               

                                 <div class="col-md-3">
                                    <label><b><h4>Select Address:</h4></b></label>
                                    <select class="form-control custom-select address1" onchange="getAddress1();" name="add_type_receiver" id="receiverselect">
                                        <option value="0">--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <!-- <option value="virtual">Virtual Box</option> -->
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
                               
                               
                            </div></div>

                                    
                                 <div id="div3767" class="col-md-12">
                                   <div class="row">
                               
                             <!--    <div class="col-md-3">
                                <label>Parcel Selection:</label>
                                 <select class="form-control custom-select trans" id="trans" name="transport" required>
                                   <option value="0">--Parcel Type--</option>
                                   <option value="Land">INLAND PARCELS POST</option>
                                   <option value="Water">PARCEL SUBJECTED TO PORT CHARGES</option>
                                 </select>
                                 <span id="transerror" style="color: red;"></span>
                                </div>

                                 <div class="form-group col-md-3">
                                    <label>Parcel Post Category Type</label>
                                    <select name="emsname" value="" class="form-control custom-select boxtype" id="boxtype" required  onchange="getPriceFrom();">
                                            <option value="0">--Select Category--</option>
                                            <option value="Ordinary">Ordinary Parcel</option>
                                            <option value="Cumbersome">Cumbersome/Fragile </option>
                                            <option value="Post">Parcel Post</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                                 <div class="col-md-3">
                                <label>Weight in kg:</label>
                                 <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"  />
                                <span id="weight_error" style="color: red;"></span>
                                </div> -->


                                  <div class="col-md-3">
                                <label>Country Selection:</label>
                                    <select name="country" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();">
                                        <option value="0">--Select Country--</option>
                                        <?Php foreach($country as $value): ?>
                                             <option value="<?php echo $value->tarrif_id ?>"><?php echo $value->country ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>
                                
                                 <div class="col-md-3">
                                <label>Weight Step in KG:</label>
                            <!-- <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"  />

                                <span id="weight_error" style="color: red;"></span>
                                </div>

                                 <div class="col-md-3">
                                <label>Advice of Payment:</label>
                                 <input type="Number" name="Additional" class="form-control Additional" id="Additional" onkeyup="getPriceFrom2()" >
                                <span id="Additional_error" style="color: red;"></span>
                                </div>

                                




                            </div>
                        </div>
                        <br />
                                
                              

                                <div class="row " id="divadd">

                                <div class="col-md-6 add1"></div>
                            </div>


                               
                                <!-- </div> -->
                                 <br>
                          
                                <div class="row">
                                    <div class="col-md-6" style="float: right;">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>

                                <br/>
                                <div class="col-md-12">
                                    <br />
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning " type="button" id="2stepBack">Back Step</button>
                                        <a href="#"  class="btn btn-info" id="addmore">Add More</a>
                                        <!-- <button class="btn btn-info btn-sm disable" type="submit">Save Information</button> -->
                                         <button class="btn btn-info disable" type="button" id="submitform" >Save Information</button>
                                    </div>
                                </div>
                            </div>
                                </div>
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
                                    <h3>Step 4 of 4  - Payment Information</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <span class ="majibu" id="majibu" style="font-weight: 80px;font-size: 26px;"></span>
                                </div>
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

<script>
<script>
function getPriceFrom() {

 var weight = $('.catweight').val();
 var tariffCat  = $('.catid').val();
 //var emstype  = $('.boxtype').val();

 
 if (weight == '') {

 }else{if(tariffCat == '0'){
    $('#error2').html('Please Select Country');
 }else{

     $.ajax({
                  type : "POST",
                  url  : "<?php echo base_url('parcel/parcel_price_vat_international')?>",
                  //dataType : "JSON",
                  data : {weight:weight,tariffCat:tariffCat},
                  success: function(data){
                     $('.price').html(data);
                  }
              });
        }
    }

    }
</script>

<script>
function getPriceFrom2() {

 var weight = $('.catweight').val();
 var tariffCat  = $('.catid').val();
  var Additional  = $('.Additional').val();
 //var emstype  = $('.boxtype').val();

 if (weight == '') {

 }else{
    if(tariffCat == '0'){
    $('#error2').html('Please Select Country');
 }else{

     $.ajax({
                  type : "POST",
                  url  : "<?php echo base_url('parcel/parcel_price_vat_international_Additional')?>",
                  //dataType : "JSON",
                  data : {weight:weight,tariffCat:tariffCat,Additional:Additional},
                  success: function(data){
                     $('.price').html(data);
                  }
              });
        }
    }

    }
</script>
<script type="text/javascript">
function getEMSType() {


 var tariffCat = $('.catid').val();
 var weight = $('.catweight').val();
 var emstype  = $('.boxtype').val();

 if (weight == '') {

 }else{

     $.ajax({
                  type : "POST",
                  url  : "<?php echo base_url('Ems_International/Ems_price_vat_international')?>",
                  //dataType : "JSON",
                  data : {weight:weight,tariffCat:tariffCat,emstype:emstype},
                  success: function(data){
                     $('.price').html(data);
                  }
              });
 }

};
function getPriceForm(){

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

    function Deletevalue() {
   
      var senderid  = $('.senders').val();
      var serial  = $('.serial').val();
       //alert('imefika33');
    
     $.ajax({
         type : 'POST',
         url  : '<?php echo base_url('parcel/delete_international_pacel_sender_bulk_info')?>',
         
         data : {senderid:senderid,serial:serial},
         success: function(data){
             $('#div6').show();
             $('.list').html('');
            
              $('.list').html(data);
            
                  
               }
           });

        }


    $(document).ready(function() {
        $('#1step').on('click',function(){

          if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) { 
                $('#error2').html('Please Select Country');
            }else if($('#weight').val() == ''){
              $('#error2').hide();
                $('#weight_error').html('Please input Weight');
            }else if($('#Additional').val() == ''){
              $('#weight_error').hide();
                $('#Additional_error').html('Please input Advice of Payment');
            }else if($('#Item').val() == ''){
              $('#weight_error').hide();
                $('#Item_error').html('Please Item Number (Barcode)');
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





         $('#submitform').on('click',function(){
             if ($('#receiverselect').val() == 0) {
                $('#erroraddress1').html('Please Select Address Type');
        }else{
                $('#erroraddress1').hide();

                var address = $('.address1').val();
                if (address == 'physical') {
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     // var region_to = $('.region_to').val();
                     // var district = $('.district').val();
                       if(name == ''){
                         $('#r_fname_error').html('Please input Receiver Name ');

                     }
                    else if (mob == '') {
                     $('#r_mobile_error').html('Please input Mobile Number ');
                     $('#r_fname_error').hide();
                     }
                     
                   
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

           $('#submitform').on('click',function(){ 
            $('.disable').attr("disabled", true);
             $('#2stepBack').prop('disabled', true);
             $('#addmore').prop('disabled', true);
            

             var serial  = $('.serial').val();
              var operator  = $('.operator').val();
             
            
             $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('parcel/save_parcel_international_application_bulk_info')?>",
                             //dataType : "JSON",
                             data : {serial:serial,operator:operator},
                             beforeSend: function() {
                                //$("#loaderDiv").show();
                               //$("body").addClass("loading");
                                  $("#submitform").addClass('button_loader').attr("value",""); 
                                  //$('#loader').removeClass('hidden');
                                
                             },
                             success: function(data){
                                 $('#submitform').removeClass('button_loader').attr("value","\u2713");
                                 $('#submitform').prop('disabled', true);
                                $('.majibu').html(data);
                                 $('.price').html('');
                                 $('#div3').hide();
                                 $('#div6').hide();
                                  $('#div2').hide();
                                  $('#div4').show();
                                
                                
                             }
                         });
        
       
         });




          $('#addmore').on('click',function(){
            $('#2stepBack').attr("disabled", true);
            $('.disable').attr("disabled", false);

        if ($('#boxtype').val() == 0) {
         $('#error1').html('Please Select PostBox Type');
        }else{



            if ($('#tariffCat').val() == 0) {
               // $('#error2').html('Please Select Ems tariff Category Type');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('Please Input Weight in gms');
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
                     
                       if(name == ''){
                         $('#r_fname_error').html('Please input Receiver Name ');

                     }
                    else if (mob == '') {
                     $('#r_mobile_error').html('Please input Mobile Number ');
                     $('#r_fname_error').hide();
                     }
                     
                    
                      else{//submit

                    //     $('.disable').attr("disabled", true);
                    //     $('#district_error').hide();


                    //       // $('#wixy').submit()
                    //        // $('.disable').attr("disabled", true);

                      
                        // var weight = $('#weight').val();
                        // var transport     = $('#trans').val();
                        // var emsname     = $('#boxtype').val();

                        var weight = $('.catweight').val();
                         var tariffCat  = $('.catid').val();
                          var Additional  = $('.Additional').val();
                             var Item  = $('.Item').val();

                        var serial  = $('.serial').val();

                       


                        var senderselect     = $('#senderselect').val();
                        var s_fname     = $('#s_fname').val();
                        var s_address     = $('#s_address').val();
                        var s_email     = $('#s_email').val();
                        var s_mobile    = $('#s_mobile').val();
                        var s_mobilev    = $('#s_mobilev').val();
                        //var regionp      = $('#regionp').val()
                        //var branchdropp    = $('#branchdropp').val();;
                        
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
                             url  : "<?php echo base_url('parcel/save_International_bulk_transactions')?>",
                             //dataType : "JSON",
                             data : {Item:Item,weight:weight,tariffCat:tariffCat,Additional:Additional,serial:serial,
                                    senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    s_mobilev:s_mobilev,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district},
                             success: function(data){
                                 $('#div6').show();
                                $('.list').html(data);
                                $('.price').html('');


                                    $('.trans').val('');
                                    $('#weight').val();
                                    $('#emsname').val('');
                      
                        
                                     // $('#receiverselect').val('');
                                    $('#r_fname').val('');
                                     $('#r_address').val('');
                                     $('#r_email').val('');
                                    $('#r_mobile').val('');
                                     $('#r_mobilev').val('');
                                    
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
                         var weight = $('.catweight').val();
                         var tariffCat  = $('.catid').val();
                          var Additional  = $('.Additional').val();
                          var Item  = $('#Item').val();

                        var serial  = $('.serial').val();
                       


                        var senderselect     = $('#senderselect').val();
                        var s_fname     = $('#s_fname').val();
                        var s_address     = $('#s_address').val();
                        var s_email     = $('#s_email').val();
                        var s_mobile    = $('#s_mobile').val();
                        var s_mobilev    = $('#s_mobilev').val();
                        //var regionp      = $('#regionp').val()
                        //var branchdropp    = $('#branchdropp').val();;
                        
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
                              url  : "<?php echo base_url('parcel/save_International_bulk_transactions')?>",
                             //dataType : "JSON",
                             data : {Item:Item,weight:weight,tariffCat:tariffCat,Additional:Additional,serial:serial,
                                    senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    s_mobilev:s_mobilev,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district},
                             success: function(data){
                                 $('#div6').show();
                                $('.list').html(data);
                                $('.price').html('');


                                    $('.trans').val('');
                                    $('#weight').val();
                                    $('#emsname').val('');
                      
                        
                                     // $('#receiverselect').val('');
                                    $('#r_fname').val('');
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

    function validateBarcode(obj){
    var barcode = $(obj).val();
   
    if (barcode.length != 13) {
        $('#Additional').attr('disabled','disabled');
        $('#trans').attr('disabled','disabled');
        $('#boxtype').attr('disabled','disabled');
        $('#weight').attr('disabled','disabled');
        $('#tariffCat').attr('disabled','disabled');
        $('#receiverselect').attr('disabled','disabled');
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
                 
                if(data['status'] == 'available'){
                    $('#Additional').attr('disabled','disabled');
                    $('#trans').attr('disabled','disabled');
                    $('#boxtype').attr('disabled','disabled');
                    $('#weight').attr('disabled','disabled');
                    $('#tariffCat').attr('disabled','disabled');
                    $('#receiverselect').attr('disabled','disabled');
                    $('#addmore').hide();
                    $('#submitform').hide();
                    $('#1step').hide();


                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);
                }else{
                    //$('#optionBox').show();
                    $('#Additional').removeAttr('disabled');
                    $('#trans').removeAttr('disabled');
                    $('#boxtype').removeAttr('disabled');
                    $('#weight').removeAttr('disabled');
                    $('#tariffCat').removeAttr('disabled');
                    $('#receiverselect').removeAttr('disabled');
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
</script>


<?php $this->load->view('backend/footer'); ?>
