<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems International  Application Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems International  Application Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/International_Ems" class="text-white"><i class="" aria-hidden="true"></i>Add Ems Application</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_International/Ems_International_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Ems International  Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                           <form method="POST" action="<?php echo base_url()?>Ems_International/Save_Ems_Info">
                               <div id="div1">
                                <div class="row">

                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Ems Selection</h3>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ems Type</label>
                                    <select name="emsname" value="" class="form-control custom-select boxtype" required id="boxtype">
                                            <option value="Document">Document</option>
                                            <option value="Parcel">Parcel</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                                <div class="col-md-6">
                                <label>Ems Country Tariff Category:</label>
                                    <select name="country" value="" class="form-control custom-select catid"  id="tariffCat" required="required" onChange = "getEMSType();">
                                        <option value="0">--Select Country--</option>
                                        <?Php foreach($country as $value): ?>
                                             <option value="<?php echo $value->country_id; ?>"><?php echo $value->country_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                <span id="error2" style="color: red;"></span>
                                </div>
                                 <div class="col-md-6">
                                <label>Weight Step in KG:</label>
                            <input type="text" name="weight" class="form-control catweight" id="weight" onkeyup="getPriceFrom()">
                                <span id="weight_error" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                <label>Item Number(Barcode):</label>
                            <input type="text" name="barcode" class="form-control catweight" id="barcode" >
                                <span id="barcode_error" style="color: red;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-info input-lg" id="1step">Next Step</a>
                                        
                                    </div>
                                </div>
                                
                                </div>


                                <div id="div2" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 4  - Sender Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Full Name:</label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control" onkeyup="myFunction()" required="required">
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
                                        <a href="#" class="btn btn-warning input-lg" id="1stepBack">Back Step</a>
                                        <a href="#" class="btn btn-info input-lg" id="2step">Next Step</a>
                                    </div>
                                </div>
                                </div>


                                <div id="div3" style="display: none;">
                                   <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 4  - Reciever Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Full Name:</label>
                                    <input type="text" name="r_fname" id="r_fname" class="form-control" onkeyup="myFunction()" required="required">
                                    <span id="error_fname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Address:</label>
                                    <input type="text" name="r_address" id="r_address" class="form-control" onkeyup="myFunction()">
                                    <span id="error_address" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Email:</label>
                                    <input type="email" name="r_email" id="r_email" class="form-control" onkeyup="myFunction()">
                                    <span id="error_email" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="r_mobile" id="r_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="error_mobile" style="color: red;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <a href="#" class="btn btn-warning btn-sm input-lg" id="2stepBack">Back Step</a>
                                        <button type="submit" class="btn btn-info disable">Save Information</button>
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
        </div>

<script>
function getPriceFrom() {

 var weight = $('.catweight').val();
 var tariffCat  = $('.catid').val();
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
    $(document).ready(function() {
        $('#1step').on('click',function(){

        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select Ems tariff Category Type');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('This field is required');
             }else if($('#barcode').val() == ''){
                $('#barcode_error').html('Please enter item number');
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

</script>

<?php $this->load->view('backend/footer'); ?>
