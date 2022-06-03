<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Bill Customer Registration</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Bill Customer Registration</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                 <div class="col-12">
                    <!-- <a href="<?php echo base_url() ?>Box_Application/EMS_Billing" class="btn btn-primary"><i class="fa fa-plus"></i> Add Company</a> -->
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/ems_billing_list" class="text-white"><i class="" aria-hidden="true"></i> EMS BIlling Companies List</a></button>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">  
                        <?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR"){ ?>
                         Credit Customer Registration List    
                        <?php }else{?>
                             Credit Customer Registration Form 
                        <?php }?>                 
                        </h4>
                    </div>
                     <?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR"){ ?>
                            <div class="card-body">
                                <table id="table_id" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Acc. Number</th>
                                <th>Customer Name</th>
                                <th>Payment Type</th>
                                <th>Customer Address</th>
                                <th>Mobile Phone</th>                                
                                <th>Amount(Tsh.)</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($credit as  $value) {?>
                            <tr>
                                <td><?php echo $value->acc_no;?></td>
                                <td><?php echo $value->customer_name;?></td>
                                <td><?php echo $value->customer_type;?></td>
                                <td><?php echo $value->customer_address;?></td>
                                <td><?php echo $value->cust_mobile;?></td>
                                <td>
                                <?php
                                if( $value->customer_type == "PostPaid" ){
                                    echo number_format($value->price,2);
                                }else{
                                 echo number_format($value->price,2);
                                }
                                ?>
                                </td>
                                
                                <td style="text-align:right;">

                                <?php if($value->customer_type == "PostPaid"){?>
                                
                                <a href="<?php echo base_url()?>Box_Application/Send?I=<?php echo base64_encode($value->credit_id) ?>" class="btn btn-info btn-sm">Services</a>
                                
                                <?php }else{ ?>
                                <?php 
                                 $acc = $value->acc_no;
                                 $getStatus = $this->billing_model->get_ems_billing_list3($acc);
                                 ?>
                                 <?php if(empty($getStatus)){ ?>
                                    <button class="btn btn-warning btn-sm">No Service</button>
                                 <?php }else{?>

                                    <?php if(@$getStatus->status == "NotPaid"){ ?>
                                        <button class="btn btn-warning btn-sm">No Service</button>
                                 <?php }else{ ?>
                                     <a href="<?php echo base_url()?>Box_Application/Send?I=<?php echo base64_encode($value->credit_id) ?>" class="btn btn-info btn-sm">Services</a>
                                 <?php } ?>

                                <?php } ?>
                                
                                <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                            </div>
                        <?php }else if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN"){?>
                              
                        <div class="card">
                           <div class="card-body">
                             <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
</div>
                <?php }else{?>
                  
                <?php }?>
                        <form method="post" action="Customer_Register">
                            <?php if(!empty($edit)){ ?>
                                 <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Service Type:</label>
                                    <select name="service_type" value="" class="form-control custom-select" required id="boxtype">
                                        <option><?php echo $edit->services_type; ?></option>
                                            <option>EMS Postage</option>
                                            <option>MAILS</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                <label>Customer Name:</label>
                                    <input type="text" name="cust_name" class="form-control" required="required" value="<?php echo $edit->customer_name; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                <label>Payment Type:</label>
                                    <select name="payment_type" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="<?php if( $edit->customer_type == "PostPaid"){ echo "PostPaid";}else{ echo "PrePaid";}?>"><?php echo $edit->customer_type; ?></option>
                                            <option value="PrePaid">Prepaid Payment</option>
                                            <option value="PostPaid">Postpaid Payment</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                <label>Customer Address:</label>
                                    <input type="text" name="cust_address" class="form-control" required="required" value="<?php echo $edit->customer_address; ?>">
                                </div>
                                <div class="col-md-6">
                                <label>Phone Number[ Mobile Number ]:</label>
                                    <input type="text" name="cust_mobile" class="form-control" required="required" value="<?php echo $edit->cust_mobile; ?>">
                                </div>
                                <div class="col-md-6">
                                <label>[ VRN ]:</label>
                                    <input type="text" name="rvn" class="form-control" required="required" value="<?php echo $edit->vrn; ?>">
                                </div>
                                <div class="col-md-6">
                                <label>[Tin Number ]:</label>
                                    <input type="text" name="tin_number" class="form-control" required="required" value="<?php echo $edit->tin_number; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                <label>Region:</label>
                                <input type="hidden" name="" class="form-control accno" value="<?php echo $edit->acc_no; ?>">
                                    <select class="form-control custom-select" onChange="GetBranch();" id="regiono">
                                        <option>--Select Region--</option>
                                        <?php foreach ($regionlist as $value) { ?>
                                        <option><?php echo $value->region_name; ?></option>
                                        <?php } ?>
                                    </select>
                                 </div>
                                 <div class="form-group col-md-6">
                                <!-- <label >Price:</label> -->
                                    <input type="hidden" name="price" class="form-control" required="required" value="<?php echo $edit->price; ?>">
                                    <input type="hidden" name="accno" class="form-control acc" required="required" value="<?php echo $edit->acc_no; ?>">
                                    <input type="hidden" name="crdtid" class="form-control acc" required="required" value="<?php echo $edit->credit_id; ?>">
                                </div>
                                <?php
                                $id = $this->session->userdata('user_login_id');
                                $basic = $this->employee_model->GetBasic($id); 
                                 if($this->session->userdata('user_type') =='ACCOUNTANT' && $basic->em_region == "Dar es Salaam" && $basic->em_branch == "Post Head Office" ){ ?>
                                    <div class="form-group col-md-6">
                                    <input type="hidden" name="category_type" class="form-control" required="required" value="Corporate">
                                </div>
                                <?php }else{?>
                                <div class="form-group col-md-6">
                                    <input type="hidden" name="category_type" class="form-control" required="required" value="Regional">
                                </div>
                            <?php }?>

                                
                                <div class="form-group col-md-12 branchdropo" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 dar" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mtw" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 tan" style="display: none;">
                                
                                </div>
                                <br><br>
                                <div class="form-group col-md-12 tab" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mwa" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 dod" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 sin" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 ruk" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kil" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mzi" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 moro" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 lin" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mbe" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 pwa" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 sim" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 man" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 gei" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kat" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 zan" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 ruv" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 song" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kig" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 iri" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 son" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mar" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 shi" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kag" style="display: none;">
                                

                                </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-info btn-sm"> Save Information</button>
                                    </div>
                                </div>
                            <?php }else{?>
                         
                                <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Service Type:</label>
                                    <select name="service_type" value="" class="form-control custom-select" required id="boxtype">
                                            <option>EMS Postage</option>
                                            <option>MAILS</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                <label>Customer Name:</label>
                                    <input type="text" name="cust_name" class="form-control" required="required">
                                </div>
                                <div class="form-group col-md-6">
                                <label>Payment Type:</label>
                                    <select name="payment_type" value="" class="form-control custom-select" required id="boxtype">
                                            <option value="PrePaid">Prepaid Payment</option>
                                            <option value="PostPaid">Postpaid Payment</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                <label>Customer Address:</label>
                                    <input type="text" name="cust_address" class="form-control" required="required">
                                </div>
                                <div class="col-md-6">
                                <label>Phone Number[ Mobile Number ]:</label>
                                    <input type="text" name="cust_mobile" class="form-control" required="required">
                                </div>
                                <div class="col-md-6">
                                <label>[ VRN ]:</label>
                                    <input type="text" name="rvn" class="form-control" required="required">
                                </div>
                                <div class="col-md-6">
                                <label>[Tin Number ]:</label>
                                    <input type="text" name="tin_number" class="form-control" required="required" >
                                </div>
                                <div class="form-group col-md-6">
                                <label>Region:</label>
                                    <select class="form-control custom-select" onChange="GetBranch();" id="regiono">
                                        <option>--Select Region--</option>
                                        <?php foreach ($regionlist as $value) { ?>
                                        <option><?php echo $value->region_name; ?></option>
                                        <?php } ?>
                                    </select>
                                 </div>
                                 <div class="form-group col-md-6">
                                <label>Price:</label>
                                    <input type="text" name="price" class="form-control" required="required">
                                </div>
                                <?php
                                $id = $this->session->userdata('user_login_id');
                                $basic = $this->employee_model->GetBasic($id); 
                                 if($this->session->userdata('user_type') =='ACCOUNTANT' && $basic->em_region == "Dar es Salaam" && $basic->em_branch == "Post Head Office" ){ ?>
                                    <div class="form-group col-md-6">
                                    <input type="hidden" name="category_type" class="form-control" required="required" value="Corporate">
                                </div>
                                <?php }else{?>
                                <div class="form-group col-md-6">
                                    <input type="hidden" name="category_type" class="form-control" required="required" value="Regional">
                                </div>
                            <?php }?>

                                
                                 <div class="form-group col-md-12 branchdropo" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 dar" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mtw" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 tan" style="display: none;">
                                
                                </div>
                                <br><br>
                                <div class="form-group col-md-12 tab" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mwa" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 dod" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 sin" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 ruk" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kil" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mzi" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 moro" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 lin" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mbe" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 pwa" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 sim" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 man" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 gei" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kat" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 zan" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 ruv" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 song" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kig" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 iri" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 son" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 mar" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 shi" style="display: none;">
                                
                                </div>
                                <div class="form-group col-md-12 kag" style="display: none;">
                                
                                </div>
                                
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-info"> Save Information</button>
                                    </div>
                                </div>
                                   <?php }?>
                        </form>

                            </div>
                           </div>

                        <?php }?>  
                        
                   </div>
                    </div>

                </div>
            </div>
            </div>
             <div id="myModal" class="modal fade" role="dialog" style="padding-top:200px; font-size:24px;">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">EMS Billing Control No.</h2>
                </div>
                <div class="modal-body">
                <span class="cn"></span>
                </div>
                </div>
                </div>
                </div>
<script type="text/javascript">
    $(document).ready( function () {
    $('#table_id').DataTable({
        dom: 'Bfrtip',
                      buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                      ]
    });

} );
</script>
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
        $('#div3').hide();
        $('#div2').show();
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
    var accno = $('.acc').val();
    
    
      $.ajax({
     
      url: "<?php echo base_url();?>Employee/GetBranch1",
      method:"POST",
      data:{region_id:region_id,accno:accno},//'region_id='+ val,
      success: function(data){

        if (region_id == "Arusha") {
            $(".branchdropo").show();
            $(".branchdropo").html(data);
        }else if(region_id == "Dar es Salaam"){
            $(".dar").show();
            $(".dar").html(data);
        }else if(region_id == "Mtwara"){
            $(".mtw").show();
            $(".mtw").html(data);
        }else if(region_id == "Tanga"){
            $(".tan").show();
            $(".tan").html(data);
        }else if(region_id == "Tabora"){
            $(".tab").show();
            $(".tab").html(data);
        }else if(region_id == "Mwanza"){
            $(".mwa").show();
            $(".mwa").html(data);
        }else if(region_id == "Dodoma"){
            $(".dod").show();
            $(".dod").html(data);
        }else if(region_id == "Singida"){
            $(".sin").show();
            $(".sin").html(data);
        }else if(region_id == "Rukwa"){
            $(".ruk").show();
            $(".ruk").html(data);
        }else if(region_id == "Kilimanjaro"){
            $(".kil").show();
            $(".kil").html(data);
        }else if(region_id == "Mzizima"){
            $(".mzi").show();
            $(".mzi").html(data);
        }else if(region_id == "Lindi"){
            $(".lin").show();
            $(".lin").html(data);
        }else if(region_id == "Mbeya"){
            $(".mbe").show();
            $(".mbe").html(data);
        }else if(region_id == "Morogoro"){
            $(".moro").show();
            $(".moro").html(data);
        }else if(region_id == "Shinyanga"){
            $(".shi").show();
            $(".shi").html(data);
        }else if(region_id == "Kagera"){
            $(".kag").show();
            $(".kag").html(data);
            $('.reg').val(region_id);
        }else if(region_id == "Mara"){
            $(".mar").show();
            $(".mar").html(data);
        }else if(region_id == "Songea"){
            $(".son").show();
            $(".son").html(data);
        }else if(region_id == "Iringa"){
            $(".iri").show();
            $(".iri").html(data);
        }else if(region_id == "Kigoma"){
            $(".kig").show();
            $(".kig").html(data);
        }else if(region_id == "Zanzibar"){
            $(".zan").show();
            $(".zan").html(data);
        }else if(region_id == "Ruvuma"){
            $(".ruv").show();
            $(".ruv").html(data);
        }else if(region_id == "Songwe"){
            $(".song").show();
            $(".song").html(data);
        }else if(region_id == "Katavi"){
            $(".kat").show();
            $(".kat").html(data);
        }else if(region_id == "Geita"){
            $(".gei").show();
            $(".gei").html(data);
        }else if(region_id == "Manyara"){
            $(".man").show();
            $(".man").html(data);
        }else if(region_id == "Pwani"){
            $(".dar").show();
            $(".dar").html(data);
        }else if(region_id == "Simiyu"){
            $(".sim").show();
            $(".sim").html(data);
        }else if(region_id == "Pwani"){
            $(".pwa").show();
            $(".pwa").html(data);
        }
        

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
$(document).ready(function() {

    $('.cnumber').on('click', function(event) {
        $('.cnumber').attr("disabled", true);
    event.preventDefault();
    

    var acc_no    = $(this).attr('data-accno');
    var total     = $(this).attr('data-total');

      $.ajax({
                 type: 'POST',
                 url: 'Generate_Control_Number2',
                 data:'acc_no='+ acc_no + '&total='+ total,
                 success: function(response) {
                        // $('.resultr').html(response);
                        //alert(response);
                        $('.cn').html(response);
                        $("#myModal").modal();

            }
        });
   });
});
</script>
<!-- <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script> -->
<?php $this->load->view('backend/footer'); ?>

