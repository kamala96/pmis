<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
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
                        <div class="card">

                <form method="post" action="<?php echo base_url() ?>Box_Application/Send_Action">
                    <input type="hidden" name="I" value="<?php echo $I; ?>">
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
                                <div class="col-md-12">
                                    <h3>Step 1 of 2  - Ems Selection</h3>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ems Type</label>
                                    <select name="emsname" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                                <div class="col-md-6">
                                <label>Ems Tariff Category:</label>
                                    <select name="emscattype" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();" required="required"> 
                                        <option value="">--Select Category--</option>
                                        <?Php foreach($ems_cat as $value): ?>
                                             <option value="<?php echo $value->cat_id ?>"><?php echo $value->cat_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>
                                 <div class="col-md-6">
                                <label>Weight Step in KG:</label>
                            <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()" required="required">
                                <span id="weight_error" style="color: red;"></span>
                                </div>
                                
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-info" id="1step">Next Step</button>
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
                                    <h3>Step 2 of 2  - Reciever Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Full Name:</label>
                                    <input type="text" name="fullname" id="r_fname" class="form-control" onkeyup="myFunction()">
                                    <span id="error_fname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Address:</label>
                                    <input type="text" name="address" id="r_address" class="form-control" onkeyup="myFunction()">
                                    <span id="error_address" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Email:</label>
                                    <input type="email" name="email" id="r_email" class="form-control" onkeyup="myFunction()">
                                    <span id="error_email" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="mobile" id="r_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="error_mobile" style="color: red;"></span>
                                </div>
                                 <div class="col-md-6">
                                    <label class="control-label">Region</label>
                                    <select name="region" value="" class="form-control custom-select" required id="rec_region" onChange="getRecDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="error_region" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Reciever Branch</label>
                                        <select name="branch" value="" class="form-control custom-select"  id="rec_dropp" required="required">  
                                            <option>--Select Branch--</option>
                                        </select>
                                        <span id="error_district" style="color: red;"></span>
                                </div>
                               
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning" id="2stepBack">Back Step</button>
                                        <button type="submit" class="btn btn-info disable">Save Information</button>
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
        </div>
<script>
function getPriceFrom() {

 var weight = $('#weight').val();
  var tariffCat  = $('#tariffCat').val();
if (weight == '') {

}else{
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
        
    }
</script>
<script type="text/javascript">
function getEMSType() {

var tariffCat = $('.catid').val();
var weight = $('.catweight').val();
    
if (weight == '') {

}else{

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
    $('#boxtype').on('change', function() {
        if ($('#boxtype').val() == 'Individual') {
            $('#indv').show();
            $('#sectors').hide();
            $('#error1').html('');
        }if ($('#boxtype').val() == 'Government Ministries and Large Business/Inst.') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Government Department') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Religious/Education Inst,Small Business and NGOs') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Primary Schools') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }
    
    //$('#showdiv' + this.value).show();
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){
        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select Ems tariff Category Type');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('This field is required');
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
        if ($('#s_fname').val() == '') {
            $('#errfname').html('This field is required');
        }else if($('#s_mobile').val() == ''){
            $('#errmobile').html('This field is required');
        
        }else{
        $('#div2').hide();
        $('#div3').show();
        }
  });
        $('#2stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
});

//save data to databse
$('#btn_save').on('click',function(){
            $('.disable').attr("disabled", true);
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
            }else if(rec_dropp == 0){
            $('#error_district').html('This field is required');
            }else{
                
             $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : {emstype:emstype,emsCat:emsCat,weight:weight,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,r_fname:r_fname,r_address:r_address,r_mobile:r_mobile,r_email:r_email,rec_region:rec_region,rec_dropp:rec_dropp},
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

