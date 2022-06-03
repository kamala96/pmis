<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Cargo Transactions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems Cargo Transactions</li>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Cargo/ems_cargo_form" class="text-white"><i class="" aria-hidden="true"></i> Cargo Transaction</a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Cargo/ems_cargo_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Cargo Transactions List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Cargo Transactions Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="ems_cargo_sender_info" method="POST">
                        <div class="card">

                           <div class="card-body">
                            <div id="div1">
                     
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Cargo Price Check</h3>
                                </div>
                                 <div class="col-md-6 nodest">
                                <label>Weight in kgs:</label>
                            <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()">
                                <span id="weight_error" style="color: red;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row form-group"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                       <a href="#" class="btn btn-info" id="1step">Next Step</a>
                                    </div>
                                </div>

                                </div>

                                <div id="div2" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 4  - Sender Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label><b><h4>Select Address:</h4></b></label>
                                    <select class="form-control custom-select address" onchange="getAddress();" name="add_type_sender">
                                        <option>--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                </div>
                                 <div class="col-md-6 virtual" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="s_mobilev" id="s_mobile" class="form-control pn1" onkeyup="ShowDetails1();">
                                </div>
                                <div class="col-md-6 physical" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control">
                                </div>

                                <div class="col-md-6 physical" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="s_address" id="s_address" class="form-control">
                                </div>

                                <div class="col-md-6 physical" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="s_email" id="s_email" class="form-control">
                                </div>

                                <div class="col-md-6 physical" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control">
                                </div>

                            </div>
                                <br>
                                 <div class="row">
                                <div class="col-md-12 add"></div>
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
                                <div class="col-md-6">
                                    <label><b><h4>Select Address:</h4></b></label>
                                    <select class="form-control custom-select address1" onchange="getAddress1();" name="add_type_receiver">
                                        <option>--Select Address--</option>
                                        <option value="physical">Physical Box</option>
                                        <option value="virtual">Virtual Box</option>
                                    </select>
                                </div>
                                <div class="col-md-6 virtual1" style="display: none;">
                                    <label><h4>Mobile Number</h4></label>
                                    <input type="mobile" name="r_mobilev" id="s_mobile" class="form-control pn" onkeyup="ShowDetails();">
                                </div>
                                <div class="col-md-6 physical1" style="display: none;">
                                    <label><h4>Full Name:</h4></label>
                                    <input type="text" name="r_fname" id="r_fname" class="form-control">
                                    <span id="error_fname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6 physical1" style="display: none;">
                                    <label><h4>Address:</h4></label>
                                    <input type="text" name="r_address" id="r_address" class="form-control">
                                </div>
                                <div class="col-md-6 physical1" style="display: none;">
                                    <label><h4>Email:</h4></label>
                                    <input type="email" name="r_email" id="r_email" class="form-control">
                                </div>
                                <div class="col-md-6 physical1" style="display: none;">
                                    <label><h4>Mobile Number:</h4></label>
                                    <input type="mobile" name="r_mobile" id="r_mobile" class="form-control">
                                </div>
                                 <div class="col-md-6 physical1" style="display: none;">
                                    <label class="control-label">Region</label>
                                    <select name="region_to" value="" class="form-control custom-select" id="rec_region" onChange="getRecDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="error_region" style="color: red;"></span>
                                </div>
                                <div class="col-md-6 physical1" style="display: none;">
                                  <label>District</label>
                                      <select name="district" value="" class="form-control custom-select"  id="rec_dropp">
                                          <option value="">--Select District--</option>
                                      </select>
                              </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12 add1"></div>
                            </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                          <a href="#" class="btn btn-warning" id="2stepBack">Back Step</a>
                                        <button class="btn btn-info disable">Save Information</button>
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
                           </div>
                       </form>



                        </div>
                    </div>

                </div>

            </div>
        </div>



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
<script type="text/javascript">
    function getAddress() {
    var address = $('.address').val();

    if (address == 'physical') {
        $('.physical').show();
        $('.virtual').hide();
    }else{
        $('.physical').hide();
        $('.virtual').show();
    }
    
};
</script>
<script type="text/javascript">
    function getAddress1() {
    var address = $('.address1').val();

    if (address == 'physical') {
        $('.physical1').show();
        $('.virtual1').hide();
    }else{
        $('.physical1').hide();
        $('.virtual1').show();
    }
    
};
</script>
<script>
function getPriceFrom() {

 var weight = $('.catweight').val();
  var tariffCat  = $('.boxtype').val();
  var destination  = $('.dest').val();
  var itemtype =  $('.itemtype').val();

  if( weight >= 50){
    $('#weight_error').html('');
    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Ems_Cargo/cargo_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight},
                 success: function(data){
                    $('.price').html(data);
                 }
             });

  }else{
    $('#weight_error').html('Invalid Weight');
  }
    
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
        $('#1step').on('click',function(){

        
                $('#div2').show();
                $('#div1').hide();
        
  });
        $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
        $('#2step').on('click',function(){

          var rec_region   = $('#rec_region').val();
            var rec_dropp         = $('#rec_dropp').val();

            if(rec_region == 0){
            //$('#error_region').html('This field is required');
           }else if(rec_dropp == ''){
            //$('#error_district').html('This field is required');
            }else{}
        
        $('#div2').hide();
        $('#div3').show();
      
        
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
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
<?php $this->load->view('backend/footer'); ?>
