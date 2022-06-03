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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Register Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Register Application</li>
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
                   
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill  Customer List</a></button>
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button> -->
                  
                   
                    <!--  <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_bill_bulk_form?I=<?php echo base64_encode($custinfo->credit_id) ?>&&AskFor=<?php echo $askfor; ?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bulk Bill Register </a></button> -->
                    <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button> -->
                   
                         
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>

                      
                    
                   <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill  Customer List</a></button>
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button> -->
                  
                   
                    <!--  <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_bill_bulk_form?I=<?php echo base64_encode($custinfo->credit_id) ?>&&AskFor=<?php echo $askfor; ?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bulk Bill Register </a></button> -->
                   <!--  <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button> -->
                   
                   <?php } ?>
                   
                     
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Register Bill Application Form
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
                        
                        <!-- <form action="register_sender_info?AskFor=<?php echo $askfor; ?>" method="POST" id="wixy"> -->
                         
                        <div class="carde">

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
<!-- 
                                <div class="col-md-3 physical" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="s_email" id="s_email" class="form-control" value="<?php echo @$custinfo->cust_email; ?>">
                                </div> -->

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
                                    <h3>Step 1 of 2  - Register Selection</h3>
                                </div>
                                 <div class="col-md-3">
                                <label>Barcode:</label>

                                <input onkeyup="validateBarcode(this)" onchange="validateBarcode(this)" type="text" name="Barcode" class="form-control Barcode" id="Barcode" />

                                <span id="Barcode_error" style="color: red;"></span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Registered Type</label>
                                    <select name="emsname" value="" class="form-control custom-select boxtype" id="boxtype" required  onchange="functionParcel();">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>
                                 <div class="col-md-3">
                                <label>Weight in gms:</label>
                            <!-- <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"> -->
                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()"  />
                                <span id="weight_error" style="color: red;"></span>
                                </div>

                                <div class="col-md-3 ad_fee" style="display: none;padding-right: 400px;">
                                <label>Ad Fee:</label><br>
                            <select name="ad_fee" value="" class="form-control custom-select ad_fees" >
                                            <option value="adfee">Ad Fee</option>
                                            <option value="nonadfee">Non Ad Fee</option>
                                        </select>
                                </div>

                                 

                                </div>
                               
                                 <div id="div367" >
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
                               <!--  <div class="col-md-3 physical1" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="r_email" id="r_email" class="form-control">
                                </div> -->
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
                                     <div class="col-md-10">
                                        <span id="serialerror" style="color: red;"></span>
                                    <!-- <a href="#"  class="btn btn-warning" id="1stepBack">Back Step</a> -->
                                    <a href="#"  class="btn btn-info" id="addmore">Add More</a>

                                    <!-- <a href="javascript:{}" onclick="document.getElementById('registered').submit(); return false;" class="btn btn-success">Save Information</a> -->

                   <!-- <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button' value="2"  id='Delete'>Delete </button> -->
                                     <!-- <button  class="btn btn-info disable " type="button" id="submitform" disabled="disabled" >Save Information</button> -->

                                   <!--   <button type="button" class="btn btn-info"><a href="<?php echo base_url() ?>unregistered/unregistered_bill_bulk_form?I=<?php echo $_GET['I']?>?AskFor=<?php echo $askfor;?>" class="text-white">Save Information</a></button> -->

                                      <button id="submitform" type="button" class="btn btn-info disable"><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Save Information</a></button>

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
                                    <div class="col-md-2">
                                        <h2 id="counterIterm">0</h2>
                                    </div>
                                </div>
                                <br>
                                
                                </div>


                                  <br>
                                  <div id="div6" style="display: block;">
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class ="list" style="font-weight: 60px;font-size: 18px;">
                                        <input type="hidden" id="serial" name="">
                                        <table style='width:100%;' class='table table-bordered'>
                                            <tr style='width:100%;color:#3895D3;'>
                                                <th><b>Receiver</b></th>
                                                <th><b>Sender</b></th>
                                                <th><b>Region Origin</b></th>
                                                <th><b>Branch Origin</b></th>
                                                <th><b>Destination Region</b></th>
                                                <th><b>Destination Branch</b></th>
                                                <th><b>Barcode Number</b></th>
                                                <th><b>Amount (Tsh.)</b></th>
                                                <th>Action</th>
                                            </tr>
                                            <tbody class="" id='emsListData'></tbody>
                                        </table>
                                        <table style='width:100%;' class='table table-bordered'>
                                            <tr>
                                                <th style="text-align:right;" colspan="7">TSH <span id="totalAmount">0</span></th>
                                            </tr>
                                        </table>
                                    </div>
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
            url  : "<?php echo base_url();?>Loan_Board/checkMailsBarcodeIsReuse",
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


  function Deletevalue(obj) {
     var transid = $(obj).attr('data-transid');
        var barcode = $(obj).attr('data-barcode');
        var senderid = $(obj).attr('data-senderid');
        var serial = $(obj).attr('data-serial');
        var itemAmount = $(obj).attr('data-item_amount');
        var snTag = $('#counterIterm').html();
        var totalAmount = parseFloat($('#totalAmount').html());

        $(obj).closest('.receiveRowTrans').remove();
   
          //var senderid  = $('.senders').val();
          //var serial  = $('.serial').val();
           //alert('imefika33');
        
         $.ajax({
             type : 'POST',
             url  : '<?php echo base_url('unregistered/delete_register_sender_bulk_info')?>',
             data : {senderid:senderid,serial:serial},
             success: function(data){
                 $('#counterIterm').html(parseInt(snTag) - 1);
                $('#totalAmount').html(totalAmount - parseFloat(itemAmount)); 
                 // $('#div6').show();
                 // $('.list').html('');
                
                 //  $('.list').html(data);
                
                      
                   }
               });

            }

    $(document).ready(function() {


        $('#1step').on('click',function(){


        if ($('#senderselect').val() == '--Select Address--') {
            $('#select_error').html('Please Select Address Type');
        }
        if($('#senderselect').val() == 'physical'  ){
            $('#divadd1').hide();
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
                 $('#div2').show();
                $('#div1').hide();
               
            }
            
           

        }
       
        if($('#senderselect').val() == 'virtual'  ){
            $('#divadd1').show();
             $('#select_error').html('');

            if($('.s_mobilev').val() ==''){
                $('#mobileverror').html('Please input Mobile Number');

            }else 
            {
               
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

         

        
  });
        $('#2stepBack').on('click',function(){
             $('#select_error').hide();
              $('#s_fnameerror').html('');
               $('#s_addresserror').html('');
                $('#mobileerror').html('');

        $('#div3').hide();
        $('#div2').show();
  });





         $('#submitformN').on('click',function(){
            $('.disable').attr("disabled", true);
             $('#2stepBack').prop('disabled', true);
             $('#addmore').prop('disabled', true);
            

             var serial  = $('.serial').val();
              var operator  = $('.operator').val();
               var askfor     = $('#askfor').val();
                var crdtid     = $('#crdtid').val();
                
                // if($('.serial').val() == ''){

                //   alert('hii 2');


                //      $('#serialerror').html('Please Add before Save information');

                // }else{
             
            
                 $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('unregistered/save_register_bill_sender_bulk_info')?>",
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



                                window.location.href = "<?php echo base_url() ?>unregistered/unregistered_bill_bulk_form?I=<?php echo base64_encode($custinfo->credit_id) ?>&&AskFor=<?php echo $askfor; ?>";
                                
                                
                             }
                         });
         //}
        
       
         });

           $('.Delete').on('click',function(){
             var senderid  = $('#senders').val();
              var serial  = $('.serial').val();
            // alert('imekubali huku');
             $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('unregistered/delete_register_sender_bulk_info')?>",
                             //dataType : "JSON",
                             data : {senderid:senderid,serial:serial},
                             success: function(data){
                                 $('#div6').show();
                                  $('.list').html(data);
                                 // $('.price').html('');
                                 // $('#div2').hide();
                                  // $('#div4').show();
                                // $('.majibu').html(data);
                                
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
            }
            else if($('#Barcode').val() == ''){
                $('#Barcode_error').html('Please Input Barcode is required');
            }else{

             if ($('#receiverselect').val() == 0) {
                $('#erroraddress1').html('Please Select Address Type');
            }else{


                $('#erroraddress1').hide();
                var address = $('.address1').val();

                    $('#divadd').hide();
                    
                     var mob = $('.r_mobile').val();
                     var name = $('.r_fname').val();
                     var region_to = $('.region_to').val();
                     var district = $('.district').val();
                    
                    if(name == ''){
                         $('#r_fname_error').html('Please input Receiver Name ');
                     }else if (mob == '') {
                         $('#r_mobile_error').html('Please input Mobile Number ');
                         $('#r_fname_error').hide();
                     }else if(region_to == ''){
                         $('#region_to_error').html('Please Select Region Name ');
                          $('#r_mobile_error').hide();
                     }else if(district == ''){
                         $('#district_error').html('Please Select Branch Name ');
                        $('#region_to_error').hide();
                     } else{

                        var ad_fee  = $('.ad_fees').val();
                        //var price   = $('.price1').val();
                        var emstype   = $('#boxtype').val();
                        //var emsCat = $('#tariffCat').val();
                        var weight = $('#weight').val();
                        var crdtid     = $('#crdtid').val();
                        var Barcode     = $('#Barcode').val();
                        var price     = $('#price').val();
                        var accno     = $('#accno').val();
                        var askfor     = $('#askfor').val();
                        var serial  = $('.serial').val();
                        var operator  = $('.operator').val();
                        var senderselect     = 'physical';
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
                         var counterIterm    = $('#counterIterm').html();
                         var totalAmount    = $('#totalAmount').html();


                         $('#loadingtext').html('Please wait............');

                         $('#addmore').hide();

                        $('#submitform').hide();
                        

                            $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('unregistered/register_bill_sender_bulk_info')?>",
                             dataType : "JSON",
                             data : {
                                weight:weight,
                                emstype:emstype,
                                ad_fee:ad_fee,
                                crdtid:crdtid,
                                price:price,
                                accno:accno,
                                Barcode:Barcode,
                                senderselect:senderselect,
                                s_fname:s_fname,
                                s_address:s_address,
                                s_mobile:s_mobile,
                                s_mobilev:s_mobilev,
                                receiverselect:receiverselect,
                                r_fname:r_fname,
                                r_address:r_address,
                                r_mobile:r_mobile,
                                r_mobilev:r_mobilev,
                                region_to:region_to,
                                district:district,
                                counterIterm:counterIterm,
                                totalAmount:totalAmount,
                                askfor:askfor,serial:serial},
                             success: function(response){
                                // console.log(response)

                                 if (response['status'] == 'Success') {
                                  $('#loadingtext').html(response['message']);
                                  $('#counterIterm').html(response['counter']);
                                  $('#totalAmount').html(response['balance']);
                                  $('#emsListData').append(response['messageData'])
                                  $('#serial').val(response['serial']);
                                  // $('.list').html(response['messageData']);
                                  $('#submitform').show();
                                 
                                }else{

                                }

                                 $('#addmore').show();
                                $('#submitform').show();


                                $('#Barcode').val('');
                                // $('#loadingtext').html('');
                                $('#div6').show();
                                // $('#emsListData').html(data);
                                $('.price').html('');
                                $('.ad_fees').val('');
                                $('#boxtype').val();
                                $('#weight').val('');
                                $('#serial2').val(serial);
                                $('#operator2').val(operator);
                                // $('#receiverselect').val('');
                                $('#r_fname').val('');
                                $('#r_address').val('');
                                $('#r_email').val('');
                                $('#r_mobile').val('');
                                $('#r_mobilev').val('');
                                $('#rec_region').val('');
                                $('#rec_dropp').val('');
                                 $('#weight').val('');
                             }
                         });

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
