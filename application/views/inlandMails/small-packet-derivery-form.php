<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Small Packets Delivery</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Small Packets Delivery</li>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/small_packet_derivery_form" class="text-white"><i class="" aria-hidden="true"></i> Small Packet Delivery Transaction</a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/small_packet_deriver_application_list" class="text-white"><i class="" aria-hidden="true"></i> Small Packet Delivery Transactions List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Small Packets Delivery Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- <form action="save_small_packets_derivery" method="POST"> -->
                        <div class="carfd">

                           <div class="card-body">
                             <div class="row">
                          <div class="col-md-12">
                              <h2 id="loadingtext"></h2>
                          </div>
                      </div>

                            <div id="div1">

                                <div class="row form-group">

                                    <tr>
                                        <th colspan="7"></th>
                                        <th >
                                           <div class="col-md-3">
                                            <h4> <strong>Scan / Type barcode</strong> </h4>
                                              <input autocomplete="off" id="edValue" type="text" class="form-control edValue" oninput="getBarcodeData(this);" >
                                              <!-- onchange="getBarcodeData(this);" -->
                                            </div>
                                        </th>
                                    </tr>
                                    
                                </div>
                     
                                <div class="row">

                                <div class="col-md-3">
                                <label>Identifier:</label>
                                <input id="identifier" type="text" name="ident" class="form-control" required="required">
                                </div>
                                 <div class="col-md-3">
                                <label>Name Of Customer:</label>
                                 <input id="cname" type="text" name="name" class="form-control" required="required">
                                </div>
                                 <div class="col-md-3">
                                <label>Mobile Number:</label>
                                 <input id="mobile_number" type="text" name="mobile" class="form-control" required="required">
                                </div>
                                 <div class="form-group col-md-3">
                                <label>Amount:</label>
                                <!-- <input type="text" name="amount" class="form-control" required="required"> -->

                                <input id="hndlcharges" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="amount" class="form-control " required="required"/>


                                </div>
                                </div>
                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button onclick="saveInformations()" class="btn btn-info">Save Information</button>
                                    </div>
                                </div>
                                <br>
                                </div>

                            </div>
                           </div>
                       <!-- </form> -->

                       <br />
                       <form id="test_form" >
                            <div class="col-sm-12 col-md-12 col-lg-12" id="input_wrapper3"></div>
                       </form>



                        </div>
                    </div>

                </div>

            </div>
        </div>

<script>
// $(document).ready(function(){
var x = 0;

    function getBarcodeData(obj) {
        var barcode = $(obj).val();
        
        //prepare request to the server for 'receive' and 'tracing'
        if (barcode.length == 13) {
           
            appendRow(barcode); // appen dnew element to form 
             x++; // increment counter for form

            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>Packet_Application/getBarcodeData",
                data:{barcode:barcode},
                dataType:'json',
                success:function(response){
                    //console.log(response)
                    
                    if (response['status'] == 'Success') {
                        let data  = response['msg'];
                        //console.log(data)
                        $('#identifier').val(data['serial'])
                        $('#cname').val(data['addressedto'])
                        $('#mobile_number').val(data['phone'])
                        $('#hndlcharges').val(data['hndlcharges'])
                        //console.log(data['FGN_number'])
                    }else{

                    }

                },error:function(){

                }
            })
           
        }
    }

    function appendRow(barcode) {
                                $('#input_wrapper3').append(
                                    '<div id="'+x+'" class="form-group col-md-12" style="display:flex;">' +
                                      '<div>'+
                                      '<input type="text" id="'+x+'" class="form-control col-md-4 " value="Barcode No: '+(x+1)+'" name="fn"   placeholder=""/>'+
                                      '<input type="text" id="'+x+'" class="form-control col-md-4" value="'+barcode+'" name="bacode"   placeholder=""/>'+
                                      '<button id="'+x+'" class="btn btn-danger deleteBtn3 col-md-4"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
                                      '</div>' +
                                      '<div>'+
                                      
                                      '</div>' +
                                    '</div>');
                              }

                              $('#input_wrapper3').on('click', '.deleteBtn3', function(e) {
                                e.preventDefault();
                                var id = e.currentTarget.id; // set the id based on the event 'e'
                                $('div[id='+id+']').remove(); //find div based on id and remove
                                x--; // decrement the counter for form.
                                
                                if (x === 0) { 
                                    //$('#save_btn').hide(); // hides the save button if counter is equal to zero
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



function getPriceFrom() {

 var weight = $('.catweight').val();
  var tariffCat  = $('.boxtype').val();
  var trans  = $('.trans').val();
  
if (weight == '') {

}else{

    $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/parcel_post_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat,trans:trans},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
}
}

// });
</script>
<script type="text/javascript">
function getEMSType() {

var tariffCat = $('#boxtype').val();
var weight = $('.catweight').val();

if (weight == '') {

}else{

   $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('unregistered/small_packet_price')?>",
                 //dataType : "JSON",
                 data : {weight:weight,tariffCat:tariffCat},
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

<script type="text/javascript">

    function saveInformations(){

        var formData = $('#test_form').serializeObject(); 
        var obj;
        var myArray = new Array();
        var Total = 0;
        if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
        obj = {};
        obj.barcode = formData.bacode[i];
         myArray.push(obj);
         Total++;
        //console.log('single obj from  ', myArray);
        };
        } 

    var Barcodes  = myArray;
    console.log(' obj  ', Barcodes);
     console.log('Total ', Total);

      var StampDetails   = $('#StampDetails').val();
      var Currency   = $('#Currency').val();
      var Amount   = $('#Amount').val();
      var price   = $('#totalPrice').val();
      var edValue   = $('#edValue').val();
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
      var identifier         = $('#identifier').val();
      var cname         = $('#cname').val();
      var mobile_number  = $('#mobile_number').val();
      var hndlcharges  = $('#hndlcharges').val();
      if(edValue=='' || edValue.length < 13 ){

        $('#loadingtext').html('Please Scan or Input  Barcode number ');
       $('#submitform').hide();

      }else{
       $('#loadingtext').html('Processing controll number, please wait............');
       $('#submitform').hide();

      $.ajax({
        type : "POST",
        url  : "<?php echo base_url('unregistered/save_small_packets_derivery')?>",
        dataType : "JSON",
        data : {
        Total:Total,
         Barcodes:JSON.stringify(Barcodes),
         cname:cname,
         hndlcharges:hndlcharges,
         mobile_number:mobile_number,
         StampDetails:StampDetails,
         identifier:identifier,
         Currency:Currency,
         Amount:Amount,
         edValue:edValue,
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

              $('#identifier').val('');
              $('#cname').val('');
              $('#mobile_number').val('');
              $('#hndlcharges').val('');

         }else{
            $('#submitform').hide();
            $('#loadingtext').html(response['message']);

             //setTimeout(function(){
                 // $('#loadingtext').html('');
             //},6000)
         }

        }
    });
}

}


</script>
<?php $this->load->view('backend/footer'); ?>
