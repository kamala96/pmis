<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> FPL,RDP Delivery </h3>
        <div class="col-md-7 align-self-center">
           
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
   
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/registered_international_form" class="text-white"><i class="" aria-hidden="true"></i> Add FPL,RDP </a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/registered_international_List" class="text-white"><i class="" aria-hidden="true"></i>  FPL,RDP Transactions List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">  FPL,RDP Delivery
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="cardd">
                           <div class="card-body">

                            <div class="row">
                          <div class="col-md-12">
                              <h2 id="loadingtext"></h2>
                          </div>
                      </div>



                          <!--  <form method="POST" action="<?php echo base_url()?>unregistered/Save_registered_international"> -->
                               <div id="div1">
                                <div class="row">

                                  <div class="col-md-4">
                                <label>Registered Item:</label>
                            <input type="text" name="StampDetails" class="form-control" id="StampDetails"  required="required">
                                <span id="" style="color: red;"></span>
                                </div> 

                                <div class="form-group col-md-4">
                                    <label>Currency:</label>
                                    <select name="Currency" value="" class="form-control custom-select boxtype" required id="Currency">
                                            <option value="TZS">TZS</option>
                                            <option value="USD">USD</option>
                                        </select>
                                <span id="error1" style="color: red;"></span>
                                </div>

                               
                                 <div class="col-md-4">
                                <label>Amount:</label>
                                <!-- onkeyup="getPriceFrom()" -->
                            <input type="Number" name="Amount" class="form-control catweight" 
                            id="Amount"   required="required">
                                <span id="weight_error" style="color: red;"></span>
                                </div>

                                 <div class="col-md-4">
                                    <label>Customer Mobile</label>
                                    <!-- onkeyup="myFunction()" -->
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control"  required="required">
                                    <span id="errmobile" style="color: red;"></span>
                                </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="price" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                              
                                
                                </div>


                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" id="submitform" onclick="saveInformations()" class="btn btn-info disable">Save Information</button>
                                    </div>
                                </div>
                                </div>
                           <!-- </form> -->
                            </div>
                           </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>



<script type="text/javascript">

    function saveInformations(){

      var StampDetails   = $('#StampDetails').val();
      var Currency   = $('#Currency').val();
      var Amount   = $('#Amount').val();
      var price   = $('#totalPrice').val();
      var Barcode   = $('#Barcode').val();
      var emstype   = $('#boxtype').val();
      var emsCat = $('#tariffCat').val();
      var weight = $('#weight').val();
      var s_fname     = $('#s_fname').val();
      var s_address     = $('#s_address').val();
      var s_mobile    = $('#s_mobile').val();
      var addressselect    = $('#addressselect').val();
      var r_fname   = $('#r_fname').val();
      var r_address     = $('#r_address').val();
      var r_mobile    = $('#r_mobile').val();
      var rec_region   = $('#rec_region').val();
      var rec_dropp         = $('#rec_dropp').val()
      var addresrselect         = $('#addresrselect').val();
      var trans         = $('#trans').val();

       $('#loadingtext').html('Processing controll number, please wait............');
       $('#submitform').hide();

      $.ajax({
        type : "POST",
        url  : "<?php echo base_url('unregistered/Save_registered_international')?>",
        dataType : "JSON",
        data : {
         StampDetails:StampDetails,
         Currency:Currency,
         Amount:Amount,
         transport:trans,
         Barcode:Barcode,
         emstype:emstype,
         emsCat:emsCat,
         weight:weight,
         s_fname:s_fname,
         s_address:s_address,
         s_mobile:s_mobile,
         s_addressType:addressselect,
         r_fname:r_fname,
         r_address:r_address,
         r_mobile:r_mobile,
         rec_region:rec_region,
         rec_dropp:rec_dropp,
         price:price,
         r_addressType:addresrselect
      },
        success: function(response){
            // console.log(response)

         if (response['status'] == 'Success') {
            $('#loadingtext').html(response['message']);

             $('#div3').hide();
             $('#div2').hide();
             $('#div1').hide();

            setTimeout(function(){
                 // location.reload();
             },6000)

              $('#StampDetails').val('');
              $('#Currency').val('');
              $('#Amount').val('');

         }else{
            $('#submitform').hide();
            $('#loadingtext').html(response['message']);

             //setTimeout(function(){
                 $('#loadingtext').html('');
             //},6000)
         }

        }
    });

}


</script>


<?php $this->load->view('backend/footer'); ?>
