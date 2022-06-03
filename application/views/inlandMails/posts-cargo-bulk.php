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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Posts Cargo Bulk Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posts Cargo Bulk Application</li>
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
                        <h4 class="m-b-0 text-white"> Posts Cargo Bulk Application Form
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




        

      <div  class="col-md-4 " style="">
                    <label>Cargo Description:</label>
                       <input type="text" name="cargo" id="cargo" class="form-control" >
                                </div>

                                 <div class="col-md-4 " style="">
                                <label>Price:</label>
                       <input type="text" name="price" id="price" class="form-control" >
                                </div>

                                <div class="col-md-4">
                                <label>Barcode:</label>
                                <input type="text" name="Barcode" class="form-control Barcode" id="Barcode" />

                                <span id="Barcode_error" style="color: red;"></span>
                                </div>


                                </div>



        <!-- <button id="save_btn" class="btn btn-success">Save</button> -->
        <!-- <button id="add_btn" class="btn btn-danger">Add Non Weighed Items</button> -->
   

  
                                
                            
                                    <hr />
                                <div class="row col-md-12"><!--
                                    <div class="col-md-6"></div> -->

                                    <div class="col-md-6">
                                        <button class="btn btn-info btn-sm" id="1step">Next Step</button>
                                    </div>
                                </div>
                                <br>
                                
                                </div>


                                <div id="div2" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 4  - Sender Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Full Name:</label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control" onkeyup="myFunction()">
                                    <span id="errfname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Address:</label>
                                    <input type="text" name="s_address" id="s_address" class="form-control" onkeyup="myFunction()">
                                    <span id="erraddress" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Email:</label>
                                    <input type="email" name="s_email" id="s_email" class="form-control" onkeyup="myFunction()">
                                    <span id="erremail" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="errmobile" style="color: red;"></span>
                                </div>


                            </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="1stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm" id="2step">Next Step</button>
                                    </div>
                                </div>
                                </div>


                                <div id="div3" style="display: none;">
                                   <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 4  - Reciever Personal Details</h3>
                                </div>
                              
                                 <div class="col-md-6">
                                    <label class="control-label">Region</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="rec_region" onChange="getRecDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="error_region" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                  <label>District</label>
                                      <select name="district" value="" class="form-control custom-select"  id="rec_dropp" required="required">
                                          <option value="">--Select District--</option>
                                      </select>
                                      <span id="error_district" style="color: red;"></span>
                              </div>
                                </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="2stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm disable" id="btn_save1" type="submit">Save Information</button>
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
        $('#1step').on('click',function(){
             var Barcode     = $('#Barcode').val();

            if(Barcode == ''){
                        $('.disable').attr("disabled", false);
                         $('#Barcode_error').html('Please input Barcode ');
                       

                     } 
                     else {
                         $('#div2').show();
                         $('#div1').hide();

                     }

        
               
        
  });
        $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
        $('#2step').on('click',function(){
        
        $('#div2').hide();
        $('#div3').show();
        
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });

});
//save data to databse
$('#btn_save1').on('click',function(){
            //$('.disable').attr("disabled", true);

            var cargo     = $('#cargo').val();
             var Barcode     = $('#Barcode').val();
            var price     = $('#price').val();
            var s_fname     = $('#s_fname').val();
            var s_address     = $('#s_address').val();
            var s_email     = $('#s_email').val();
            var s_mobile    = $('#s_mobile').val();
            var rec_region   = $('#rec_region').val();
            var rec_dropp   = $('#rec_dropp').val();

            if (cargo == '') {
            $('#error_cargo').html('This field is required');
            
            }else if (Barcode == '') {
            $('#Barcode_error').html('This field is required');
            
            }else{

             $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action_bulk')?>",
                 dataType : "JSON",
                 data : {s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,rec_region:rec_region,
                         rec_dropp:rec_dropp,cargo:cargo,price:price,Barcode:Barcode 
               }, beforeSend: function() {
                    //$("#loaderDiv").show();
                   //$("body").addClass("loading");
                      $("#btn_save1").addClass('button_loader').attr("value",""); 
                      //$('#loader').removeClass('hidden');
                    
                     },
                 success: function(data){
                   //$("#loaderDiv").hide();
                     //$("body").removeClass("loading"); 
                      $('#btn_save1').removeClass('button_loader').attr("value","\u2713");
                      $('#btn_save1').prop('disabled', true);
                       //$('#loader').addClass('hidden');

                     $('#div4').show();
                     $('#div3').hide();
                     $('#majibu').html(data);
                    /// $('#Modal_Edit').modal('hide');
                     //show_product();
                 }
             });
             return false;
        }
        });




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

<?php $this->load->view('backend/footer'); ?>
