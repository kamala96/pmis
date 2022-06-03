<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Necta Form</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems Necta Form</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/necta_delete_form" class="text-white"><i class="" aria-hidden="true"></i> Add/Delete Subject</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/necta_info" class="text-white"><i class="" aria-hidden="true"></i> Necta Transactions</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Necta/necta_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Necta Transanctions List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/bulk_necta" class="text-white"><i class="" aria-hidden="true"></i> Bulk Necta </a></button>
                    
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Add/Delete Subject
                        </h4>
                    </div>
                    <div class="card-body">
                            <form method="POST" action="<?php echo base_url()?>Necta/Save_necta_delete_Info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" name="r_name" value="NECTA">
                                        <input type="hidden" name="r_region" value="Dar es Salaam">
                                        <input type="hidden" name="r_address" value="P.O. BOX 2624/32019">
                                        <input type="hidden" name="r_zipcode" value="">
                                        <input type="hidden" name="r_phone" value="255-22-2775966">
                                        <input type="hidden" name="r_email" value="esnecta@necta.go.tz">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Registration Number</label>
                                        <input type="text" name="rnumber" class="form-control" required="required">
                                    </div>
                                    <div class="col-md-6">
                                        <label>[Select Address]</label>
                                        <select class="form-control custom-select addtype" name="addtype" onchange="getBoxType();" style="height:43px;">
                                            <option>Physical</option>
                                            <option>Virtual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 sfulname">
                                        <label>Sender Full Name</label>
                                        <input type="text" name="s_fullname" class="form-control">
                                    </div>
                                    <div class="col-md-6 address">
                                        <label>Sender Address</label>
                                        <input type="text" name="s_address" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Sender Mobile</label>
                                        <input type="text" name="s_mobile" class="form-control pn" onkeyup="ShowDetails();">
                                    </div>
                                    <div class="col-md-6">
                                    <label>Category</label>
                                    <select class="form-control custom-select" name="category" required="required">
                                        <option value="">--Select Category--</option>
                                        <option value="ACSEE">FORM SIX(ACSEE)</option>
                                        <option value="CSEE">FORM FOUR(CSEE)</option>
                                         <option value="QT">QT</option>
                                    </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12 add1">
                                        
                                    </div>
                                </div>
                                <hr>
                                <div class="row" style="float: right;">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-info">Save Information</button>
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
     $('.submit').attr("disabled", true);

   }else{
      $('.priceerror').html('');
      $('.price').val(price);
      $('.submit').attr("disabled", false);
   }

 
}
 
</script>
<script type="text/javascript">
    $('.submit').on('click',function(){
            $('.submit').attr("disabled", true);
        })
</script>

<script type="text/javascript">
    function getBoxType(){

        var addtype = $('.addtype').val();
        if( addtype == 'Virtual'){
            $('.sfulname').hide();
            $('.address').hide();
        }else{
            $('.sfulname').show();
            $('.address').show();
        }
    }
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
<?php $this->load->view('backend/footer'); ?>
