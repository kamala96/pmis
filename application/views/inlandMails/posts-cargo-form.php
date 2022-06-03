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

#btn_save1:focus{
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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Posts Cargo Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posts Cargo Application</li>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/posts_cargo" class="text-white"><i class="" aria-hidden="true"></i> Posts Cargo Transaction</a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/posts_cargo_application_list" class="text-white"><i class="" aria-hidden="true"></i> Posts Cargo Transactions List</a></button>

                       <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/posts_cargo_bulk" class="text-white"><i class="" aria-hidden="true"></i> Posts Cargo Bulk</a></button>

                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/posts_cargo_bulk_group" class="text-white"><i class="" aria-hidden="true"></i> Posts Cargo Group </a></button>
                        
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Posts Cargo Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- <form action="posts_cargo_sender_info123" method="POST"> -->
                        <div class="card">

                           <div class="card-body">


                            <div id="div1">
                     
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Posts Cargo Selection</h3>
                                </div>

                                <div id="test_form1" style=""class="col-md-12">
                                  <form id="test_form" >
                                       <!-- <div class="form-group col-md-6" style="display:none">
                                                                    
                                                            <select name="emsname" value="" class="form-control custom-select boxtype" required  >
                                                            <option value="nonweighed" selected >Non Weighed Items</option>
                                                                        </select>
                                                         <span id="error1" style="color: red;"></span>
                                                                </div> -->
                                      <div class="col-sm-12 col-md-12 col-lg-12">
                                        <br />
                                        <div id="input_wrapper"></div>
                                        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
                                        <button id="add_btn" class="btn btn-danger">Add Non Weighed Items</button>
                                      </div>
                                  </form>
                                   </div>

                                   <hr />
                                   <br /><br />

                                   <div id="test_form2" style="" class="col-md-12">
                                  <form id="test_form3" >
                                      <div class="col-sm-12 col-md-12 col-lg-12">
                                        <br />
                                        <div id="input_wrapper2"></div>
                                        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
                                        <button id="add_btn2" class="btn btn-danger">Add Other Items</button>
                                      </div>
                                  </form>
                                   </div>



                                                               
                                <hr />
                                   <br /><br />
                                   <br /><br />
                                   <div class="col-md-3">
                                <label>Barcode:</label>
                                <input type="text" name="Barcode" class="form-control Barcode" id="Barcode" />

                                <span id="Barcode_error" style="color: red;"></span>
                                </div>
                                
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
                                <div class="row col-md-12"><!--
                                    <div class="col-md-6"></div> -->

                                    <div class="col-md-6">
                                        <button class="btn btn-info btn-md" type="button" id="1step">Next Step</button>
                                    </div>
                                </div>
                                <br>
                                
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
                                        <button class="btn btn-warning btn-md" type="button" id="1stepBack">Back Step</button>
                                        <button class="btn btn-info btn-md" type="button" id="2step">Next Step</button>
                                    </div>
                                </div>
                            </div>


                                <div id="div3" style="display: none;">
                                 <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 4  - Reciever Personal Details</h3>
                                </div>

                                  <!-- <div class="row"> -->

                                 <div class="col-md-3">
                                    <label><b><h4>Select Address:</h4></b></label>
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


                               
                                <!-- </div> -->

                                <br />
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-md" id="2stepBack">Back Step</button>
                                        <button class="btn btn-info btn-md disable" id="btn_save" type="button">Save Information</button>
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
                                    <span id="majibu" style="font-weight: 70px;font-size: 24px;"></span>
                                </div>

                                 <div id="loaderDiv" style="display:none;">
                                    <?php $image='ajax-loader.gif';
                                    echo '<img src="'.base_url().'images/'.$image.'" style="width: 150px; height: 140px;" id="ajaxSpinnerImage" title="working..." >';
                                    ?>
                                 </div>
                                 <div class="overlay"></div>
                                  <div id="loader" class="lds-dual-ring hidden overlay2"></div>




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
   $(document).ready(function() {
    var x = 0;
    $('#save_btn').hide();
  
    $('#add_btn').click(function(e) {
    e.preventDefault();
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    $('#save_btn').show(); // show save button for form
  });

     $('#1step').on('click',function(e){
               e.preventDefault();
               if($('#Barcode').val() ==''){
                $('#Barcode_error').html('Please Input Barcode');

            }else{
        
                $('#div2').show();
                $('#div1').hide();
            }
        
  });
     $('#1stepBack').on('click',function(e){
             e.preventDefault();
        $('#div2').hide();
        $('#div1').show();
  });

       $('#2step').on('click',function(e){
                     e.preventDefault();

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
        $('#2stepBack').on('click',function(e){
             e.preventDefault();
        $('#div3').hide();
        $('#div2').show();
  });



        //save data to databse
$('#btn_save').on('click',function(){
    // e.preventDefault();
  $('.disable').attr("disabled", true);

       var formData = $('#test_form').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    var myArray = new Array();
     
     var TotalOutstandingamount = 0;
     var TotalOutstandingvalue = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj.item = formData.fn[i];
        obj.destination = formData.ln[i];

        TotalOutstandingamount =10  ; 
        TotalOutstandingvalue=10;
         myArray.push(obj)

      //console.log('single obj from  ', myArray);
      };
    }  else if(formData.fn == null || formData.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj);
     
        TotalOutstandingamount =0;
        TotalOutstandingvalue =10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj = {};
      obj.item = formData.fn;
      obj.destination = formData.ln;
        myArray.push(obj);
        TotalOutstandingamount =10; 
        TotalOutstandingvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalOutstandingamount ', TotalOutstandingamount);
       // console.log('object from form array ', myArray);

    var formData2 = $('#test_form3').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj1;
    var myArray2 = new Array();
     
     var TotalAccesoryamount = 0;
     var TotalAccesoryvalue = 0;
    if(Array.isArray(formData2.fn)) {
        for(var i = 0; i < formData2.fn.length; i++) {
        obj1 = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj1.boxtype = formData2.fn[i];
        obj1.weight = formData2.ln[i];

      
        TotalAccesoryamount =10 ; 
        TotalAccesoryvalue=10;
         myArray2.push(obj1);

      //console.log('single obj from  ', myArray);
      }
    }  else if(formData2.fn == null || formData2.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj)
     
        TotalAccesoryamount = 0;
        TotalAccesoryvalue = 10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj1 = {};
      obj1.boxtype = formData2.fn;
      obj1.weight = formData2.ln;
         myArray2.push(obj1);
     
        TotalAccesoryamount =10; 
        TotalAccesoryvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       
        //console.log('object from form array ', myArray);
        //console.log('object from form array ', myArray2);

            var OtheritemArray   = myArray2;
            var TotalOtheritemArrayamounts   = TotalAccesoryamount;
             var TotalOtheritemArrayvalues   = TotalAccesoryvalue;

            var NonweightArray   = myArray;
            var TotalNonweightamounts   = TotalOutstandingamount;
             var TotalNonweightvalues   = TotalOutstandingvalue;
           

            //var price   = $('.price1').val();
             //var Destination   = $('.Destination').val();
             //var weight = $('#weight').val();

            //var emstype   = $('#boxtype').val();
            //var emsCat = $('#tariffCat').val();
            

                       var senderselect     = $('#senderselect').val();
                        var Barcode     = $('#Barcode').val();
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
           
             $('#erroraddress1').hide();

                var address = $('.address1').val();
                if (address == 'physical') {
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     var region_to = $('.region_to').val();
                     var district = $('.district').val();
                       if(name == ''){
                        $('.disable').attr("disabled", false);
                         $('#r_fname_error').html('Please input Receiver Name ');

                     }
                    else if (mob == '') {
                        $('.disable').attr("disabled", false);
                     $('#r_mobile_error').html('Please input Mobile Number ');
                     $('#r_fname_error').hide();
                     }
                     
                     else if(region_to == ''){
                          $('.disable').attr("disabled", false);
                         $('#region_to_error').html('Please Select Region Name ');
                          $('#r_mobile_error').hide();

                     }  
                      else if(district == ''){
                        $('.disable').attr("disabled", false);
                         $('#district_error').html('Please Select Branch Name ');
                        $('#region_to_error').hide();


                     } else if(Barcode == ''){
                        $('.disable').attr("disabled", false);
                         $('#Barcode_error').html('Please input Barcode ');
                        $('#region_to_error').hide();


                     } 
                     else{//submit

                       // alert('hapa');

                       $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : { senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    s_mobilev:s_mobilev,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,Barcode:Barcode,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district,
                   TotalOtheritemArrayamounts:TotalOtheritemArrayamounts,TotalOtheritemArrayvalues:TotalOtheritemArrayvalues,OtheritemArray:JSON.stringify(OtheritemArray),
                  TotalNonweightamounts:TotalNonweightamounts,TotalNonweightvalues:TotalNonweightvalues,NonweightArray:JSON.stringify(NonweightArray) 
               }, beforeSend: function() {
                    //$("#loaderDiv").show();
                   //$("body").addClass("loading");
                      $("#btn_save").addClass('button_loader').attr("value",""); 
                      //$('#loader').removeClass('hidden');
                    
                     
                 },

                 success: function(data){


                   //$("#loaderDiv").hide();
                     //$("body").removeClass("loading"); 
                      $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);
                       //$('#loader').addClass('hidden');

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
                }else if(address == 'virtual') {
                    $('#erroraddress1').hide();
                     var mobv = $('.r_mobilev').val();
                     if (mobv == '') {
                        $('.disable').attr("disabled", false);
                     $('#r_mobilev_error').html('Please input Mobile Number ');
                     }  else{ //submit

                        //alert('hapa pia');

                        $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : { senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    s_mobilev:s_mobilev,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,Barcode:Barcode,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district,
                   TotalOtheritemArrayamounts:TotalOtheritemArrayamounts,TotalOtheritemArrayvalues:TotalOtheritemArrayvalues,OtheritemArray:JSON.stringify(OtheritemArray),
                  TotalNonweightamounts:TotalNonweightamounts,TotalNonweightvalues:TotalNonweightvalues,NonweightArray:JSON.stringify(NonweightArray) 
               }, beforeSend: function() {
                    //$("#loaderDiv").show();
                   //$("body").addClass("loading");
                      $("#btn_save").addClass('button_loader').attr("value",""); 
                      //$('#loader').removeClass('hidden');
                    
                     
                 },

                 success: function(data){


                   //$("#loaderDiv").hide();
                     //$("body").removeClass("loading"); 
                      $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);
                       //$('#loader').addClass('hidden');




                     // $('[name="vehicle_no"]').val("");
                     // $('[name="vehicle_id"]').val("");

                     $('#div4').show();
                     $('#div3').hide();
                     $('#majibu').html(data);
                    /// $('#Modal_Edit').modal('hide');
                     show_product();
                 }
             });
             return false;
                    }
               
                }
        });






    $('#input_wrapper').on('click', '.deleteBtn1', function(e) {
    e.preventDefault();
    var id = e.currentTarget.id; // set the id based on the event 'e'
    $('div[id='+'first'+id+']').remove(); //find div based on id and remove
    x--; // decrement the counter for form.
    
    if (x === 0) { 
        $('#save_btn').hide(); // hides the save button if counter is equal to zero
    }
  });
    
  
  function appendRow() {
    $('#input_wrapper').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+'first'+x+'" class="form-group" style="display:flex;">' +
         '<div  class="col-md-3 " style="">'+
                     '<label>Cargo Item:</label>'+
                '<select name="fn" id="'+x+'" class="form-control custom-select itemtype">'+
                                       ' <option value="">--Select Cargo Item--</option>'+
                                       ' <option >TV-14,21&28</option>'+
                                       ' <option >TV-28,65</option>'+
                                       ' <option>TV-STAND SMALL</option>'+
                                         ' <option>TV-STAND LARGE</option>'+  
                                       ' <option >SATELITE DISH</option>'+
                                       ' <option >UPS-BIG</option>'+
                                       ' <option>UPS-SMALL</option>'+
                                       ' <option>SCANNER</option>'+
                                       ' <option>COOKER SMALL</option>'+
                                       ' <option>COOKER LARGE</option>'+
                                       ' <option>FRIDGE SMALL</option>'+
                                       ' <option>FRIDGE LARGE</option>'+
                                       ' <option>WASHING MACHINE SMALL</option>'+
                                       ' <option>WASHING MACHINE LARGE</option>'+
                                       ' <option>SOFA SET LARGE-4 PIECES</option>'+
                                       ' <option>CUSSION PER PC</option>'+
                                       ' <option>PILLOWS 1 PC</option>'+
                                       ' <option>MATTRESS 3x6,4x6</option>'+
                                        ' <option>MATTRESS 5x6,6x6</option>'+
                                       ' <option>SOFA SET SMALL-3 PIECES</option>'+
                                       ' <option>PLASTIC TABLE 1 PC</option>'+
                                        '<option>PLASTIC CHAIR 1 PC</option>'+
                                        ' <option>WOODEN TABLE 1 PC</option>'+
                                       ' <option>WOODEN CHAIR 1 PC</option>'+
                                       '<option>AIR CONDITIONER</option>'+
                                       ' <option>PHOTOCOPY MACHINE SMALL SIZE</option>'+
                                       ' <option>PHOTOCOPY MACHINE LARGE SIZE</option>'+
                                       ' <option >WIND-SCREEN</option>'+
                                       ' <option >BATTERY NO 50-100</option>'+
                                       ' <option >TYPEWRITER</option>'+
                                       '<option >MONITOR</option>'+
                                       ' <option >PRINTER</option>'+
                                       ' <option >A BOX OF FLOWERS</option>'+
                                       ' <option >A BANCH OF BANANA</option>'+
                                       '<option >BED SMALL 3X6,4X4</option>'+
                                       ' <option >BED SMALL 5X6,6X6</option>'+
                                       ' <option >CUPBOARD SMALL</option>'+
                                       ' <option >CUPBOARD LARGE</option>'+
                                       ' <option>GASS KG 18KG</option>'+
                                       ' <option >GASS KG ABOVE 35KG</option>'+
                                        ' <option >OVENI KG20</option>'+
                                       ' <option >TABLE KG30</option>'+
                                       ' <option >COFFEE TABLE</option>'+
                                       ' <option >GENERETOR SMALL SIZE</option>'+
                                        '<option >GENERETOR BIG SIZE</option>'+
                                       ' <option >MOTORCYCLES</option>'+
                                       ' <option >MOTOCYCLES 3LIMS</option>'+
                                       ' <option >WOODEN STOOL</option>'+
                                       ' <option >WATER TANK 200,500</option>'+
                                       ' <option >WATER TANK 1000,1500</option>'+
                                    '</select>'+
                                '</div>'+

                                 '<div class="col-md-3 " style="">'+
                                '<label>Destination:</label>'+
                                '<select id="'+x+'" name="ln" class="form-control custom-select dest" onchange="getPriceFrom1()">'+
                                       ' <option value="">--Select Destination--</option>'+
                                        '<option value="DESTINATIONS">Morogoro</option>'+
                                        '<option value="DESTINATIONS">Korogwe</option>'+
                                        '<option value="DESTINATIONS">Tanga</option>'+
                                        '<option value="OTHERDESTINATIONS">Other Destinations</option>'+
                                    '</select>'+
                                '</div>'+
            '<button id="'+x+'" class="btn btn-danger btn-sm deleteBtn1"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
          '</div>' +
        '</div>'
        );
  }
  
});

$.fn.serializeObject = function(asString) {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {

       if($('#' + this.name).hasClass('date')) {
           this.value = new Date(this.value).setHours(12);
       }

       if (o[this.name] !== undefined) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   if (asString) {
       return JSON.stringify(o);
   }
   return o;
};
</script>

<script type="text/javascript">
   $(document).ready(function() {
    var x = 0;
    $('#save_btn').hide();
  
    $('#add_btn2').click(function(e) {
    e.preventDefault();
    appendRow(); // appen dnew element to form 
    x++; // increment counter for form
    $('#save_btn').show(); // show save button for form
  });

    $('#input_wrapper2').on('click', '.deleteBtn', function(e) {
    e.preventDefault();
    var id = e.currentTarget.id; // set the id based on the event 'e'
    $('div[id='+id+']').remove(); //find div based on id and remove
    x--; // decrement the counter for form.
    
    if (x === 0) { 
        $('#save_btn').hide(); // hides the save button if counter is equal to zero
    }
  });
    
 
  
  function appendRow() {
    $('#input_wrapper2').append(
        // '<label><span id="results" style=""> </span> Outstanding Balance</label>'+
        // '<br />'+
        '<div id="'+x+'" class="form-group" style="display:flex;">' +
           '<div class="form-group col-md-3">'+
                                   ' <label>Registered Type</label>'+
                                    '<select id="'+x+'" name="fn" value="" class="form-control custom-select boxtype" required  onchange="functionParcel();">'+
                                            '<option value="">--Select Type--</option>'+
                                            
                                            '<option value="fooditem">Food Items</option>'+
                                            '<option value="nonfooditem">Non Food Items</option>'+
                                            '<option value="hiringvehicles">Hiring Vehicles</option>'+
                                        '</select>'+
                                '<span id="error1" style="color: red;"></span>'+
                                '</div>'+

                                 '<div class="col-md-3 ">'+
                                '<label>Weight in kgs:</label>'+
                                // '<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '');" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"  />'+
                            '<input type="text" id="'+x+'" name="ln" class="form-control catweight" id="weight" onkeyup="getPriceFrom()">'+
                                '<span id="weight_error" style="color: red;"></span>'+
                                '</div>' +
            '<button id="'+x+'" class="btn btn-danger deleteBtn"><i class=""></i> Remove</button>' +
          '</div>' +
        '</div>');
  }
  
});

$.fn.serializeObject = function(asString) {
   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {

       if($('#' + this.name).hasClass('date')) {
           this.value = new Date(this.value).setHours(12);
       }

       if (o[this.name] !== undefined) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   if (asString) {
       return JSON.stringify(o);
   }
   return o;
};
</script>






<script type="text/javascript">
        function functionParcel() {
    var tariffCat  = $('.boxtype').val();
    if( tariffCat == 'nonweighed'){
        $('.destination').show();
        $('.item').show();
        $('.nodest').hide();
    }else{
        $('.destination').hide();
        $('.item').hide();
        $('.nodest').show();
    }
};
</script>
<script>
function getPriceFrom1() {

 var weight = $('.catweight').val();
  var tariffCat  = $('.boxtype').val();
  var destination  = $('.dest').val();
  var itemtype =  $('.itemtype').val();

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/posts_cargo_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,destination:destination,itemtype:itemtype},
                 success: function(data){
                      $('.price1').show();
                       $('.price').hide();
                    $('.price1').html(data);
                    

                 }
             });
};
</script>

<script>
function getPriceFrom() {

 var weight = $('.catweight').val();
  var tariffCat  = $('.boxtype').val();
  var destination  = $('.dest').val();
  var itemtype =  $('.itemtype').val();

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/posts_cargo_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,destination:destination,itemtype:itemtype},
                 success: function(data){
                     $('.price').show();
                       $('.price1').hide();
                    $('.price').html(data);
                    
                 }
             });
};
</script>
<script type="text/javascript">
function getEMSType() {

var weight = $('.catweight').val();
  var tariffCat  = $('.boxtype').val();
  var destination  = $('.destination').val();
  var itemtype =  $('.itemtype').val();

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/posts_cargo_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,destination:destination,itemtype:itemtype},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
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
    $(document).ready(function() {
        
        
               
//});

//save data to databse
$('#btn_save').on('click',function(e){
     e.preventDefault();
            $('.disable').attr("disabled", true);

       var formData = $('#test_form').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj;
    var myArray = new Array();
     
     var TotalOutstandingamount = 0;
     var TotalOutstandingvalue = 0;
    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj.item = formData.fn[i];
        obj.destination = formData.ln[i];

        TotalOutstandingamount =10  ; 
        TotalOutstandingvalue=10;
         myArray.push(obj)

      //console.log('single obj from  ', myArray);
      };
    }  else if(formData.fn == null || formData.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj);
     
        TotalOutstandingamount =0;
        TotalOutstandingvalue =10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj = {};
      obj.item = formData.fn;
      obj.destination = formData.ln;
        myArray.push(obj);
        TotalOutstandingamount =10; 
        TotalOutstandingvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       //  console.log('TotalOutstandingamount ', TotalOutstandingamount);
       // console.log('object from form array ', myArray);

    var formData2 = $('#test_form3').serializeObject(); // serialize the form
    //var arr[]; //obj can be use to send to ajax call
    var obj1;
    var myArray2 = new Array();
     
     var TotalAccesoryamount = 0;
     var TotalAccesoryvalue = 0;
    if(Array.isArray(formData2.fn)) {
        for(var i = 0; i < formData2.fn.length; i++) {
        obj1 = {};

         //var $someArray = [["year" => formData.fn[i],"amount" => formData.ln[i]];
        // set the obj for submittion
        obj1.boxtype = formData2.fn[i];
        obj1.weight = formData2.ln[i];

      
        TotalAccesoryamount =10 ; 
        TotalAccesoryvalue=10;
         myArray2.push(obj1);

      //console.log('single obj from  ', myArray);
      }
    }  else if(formData2.fn == null || formData2.fn == '')
    {

        //obj = {};
      //obj.Year = formData.fn;
      //obj.Amount = formData.ln;
         //myArray.push(obj)
     
        TotalAccesoryamount = 0;
        TotalAccesoryvalue = 10;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
    else {

        obj1 = {};
      obj1.boxtype = formData2.fn;
      obj1.weight = formData2.ln;
         myArray2.push(obj1);
     
        TotalAccesoryamount =10; 
        TotalAccesoryvalue=0;
     //console.log('single obj from  ', myArray);
       //console.log('object from  array ', TotalOutstandingamount);
    }
        //console.log('years ', years);
       
        console.log('object from form array ', myArray);
        console.log('object from form array ', myArray2);

            var OtheritemArray   = myArray2;
            var TotalOtheritemArrayamounts   = TotalAccesoryamount;
             var TotalOtheritemArrayvalues   = TotalAccesoryvalue;

            var NonweightArray   = myArray;
            var TotalNonweightamounts   = TotalOutstandingamount;
             var TotalNonweightvalues   = TotalOutstandingvalue;
           

            //var price   = $('.price1').val();
             //var Destination   = $('.Destination').val();
             //var weight = $('#weight').val();

            //var emstype   = $('#boxtype').val();
            //var emsCat = $('#tariffCat').val();
            

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

           
             $('#erroraddress1').hide();

                var address = $('.address1').val();
                if (address == 'physical') {
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     var region_to = $('.region_to').val();
                     var district = $('.district').val();
                       if(name == ''){
                        $('.disable').attr("disabled", false);
                         $('#r_fname_error').html('Please input Receiver Name ');

                     }
                    else if (mob == '') {
                        $('.disable').attr("disabled", false);
                     $('#r_mobile_error').html('Please input Mobile Number ');
                     $('#r_fname_error').hide();
                     }
                     
                     else if(region_to == ''){
                         $('#region_to_error').html('Please Select Region Name ');
                          $('#r_mobile_error').hide();

                     }  
                      else if(district == ''){
                        $('.disable').attr("disabled", false);
                         $('#district_error').html('Please Select Branch Name ');
                        $('#region_to_error').hide();


                     } 
                     else{//submit

                       $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : { senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    s_mobilev:s_mobilev,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district,
                   TotalOtheritemArrayamounts:TotalOtheritemArrayamounts,TotalOtheritemArrayvalues:TotalOtheritemArrayvalues,OtheritemArray:JSON.stringify(OtheritemArray),
                  TotalNonweightamounts:TotalNonweightamounts,TotalNonweightvalues:TotalNonweightvalues,NonweightArray:JSON.stringify(NonweightArray) 
               }, beforeSend: function() {
                    //$("#loaderDiv").show();
                   //$("body").addClass("loading");
                      $("#btn_save").addClass('button_loader').attr("value",""); 
                      //$('#loader').removeClass('hidden');
                    
                     
                 },

                 success: function(data){


                   //$("#loaderDiv").hide();
                     //$("body").removeClass("loading"); 
                      $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);
                       //$('#loader').addClass('hidden');




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
                }else if(address == 'virtual') {
                    $('#erroraddress1').hide();
                     var mobv = $('.r_mobilev').val();
                     if (mobv == '') {
                        $('.disable').attr("disabled", false);
                     $('#r_mobilev_error').html('Please input Mobile Number ');
                     }  else{ //submit

                        $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : { senderselect:senderselect,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,
                                    s_mobilev:s_mobilev,receiverselect:receiverselect,r_fname:r_fname,r_address:r_address,r_email:r_email,
                                    r_mobile:r_mobile,r_mobilev:r_mobilev,region_to:region_to,district:district,
                   TotalOtheritemArrayamounts:TotalOtheritemArrayamounts,TotalOtheritemArrayvalues:TotalOtheritemArrayvalues,OtheritemArray:JSON.stringify(OtheritemArray),
                  TotalNonweightamounts:TotalNonweightamounts,TotalNonweightvalues:TotalNonweightvalues,NonweightArray:JSON.stringify(NonweightArray) 
               }, beforeSend: function() {
                    //$("#loaderDiv").show();
                   //$("body").addClass("loading");
                      $("#btn_save").addClass('button_loader').attr("value",""); 
                      //$('#loader').removeClass('hidden');
                    
                     
                 },

                 success: function(data){


                   //$("#loaderDiv").hide();
                     //$("body").removeClass("loading"); 
                      $('#btn_save').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save').prop('disabled', true);
                       //$('#loader').addClass('hidden');




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
               
                }

        }

                //emstype:emstype,emsCat:emsCat,weight:weight,price:price,

            
        
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

<?php $this->load->view('backend/footer'); ?>
