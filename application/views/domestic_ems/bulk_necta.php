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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Bulk Necta Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Bulk Necta Application</li>
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
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/necta_info" class="text-white"><i class="" aria-hidden="true"></i> Necta Transactions</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Necta/necta_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Necta Transanctions List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Necta/bulk_necta" class="text-white"><i class="" aria-hidden="true"></i> Bulk Necta </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Necta/bulk_necta_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Necta Bulk Transanctions List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Bulk Necta Application Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-12">
                              <h2 id="loadingtext"></h2>
                          </div>
                      </div>
                        <!-- <form action="posts_cargo_sender_info123" method="POST"> -->
                        <div class="carsd">

                           <div class="card-body">
                          
                     
                                <div class="row" id="div10">

                                    <div class="col-md-12">
                                        <input type="hidden" id="r_name" name="r_name" value="NECTA">
                                        <input type="hidden" id="r_region"
                                         name="r_region" value="Dar es Salaam">
                                        <input type="hidden" id="r_address" name="r_address" value="P.O. BOX 2624/32019">
                                        <input type="hidden" id="r_zipcode" name="r_zipcode" value="">
                                        <input type="hidden" id="r_phone" name="r_phone" value="255-22-2775966">
                                        <input type="hidden" id="r_email" name="r_email" value="esnecta@necta.go.tz">
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
                                    <button id="add_btn" class="btn btn-danger">Add Bulk Items</button>
                                  </div>
                              </form>
                               </div>

   
  
                                <br><br><br><br><br>
                               



                                </div>

                                <div id="div4" style="display: none;">
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Bulk Necta Payment Information</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12" id="aa11">
                                    <span id="majibu"></span>
                                    <p id="majib"></p>
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

                        <hr/>
                                <div class="row" id="div15"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-info btn-sm disable" id="btn_save" type="submit">Save Information</button>
                                    </div>
                                </div>

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
         '<div  class="col-md-5 " style="">'+
                     '<label>Necta Registration Number:</label>'+
                      ' <input type="text" name="fn" id="'+x+'" class="form-control" >'+
               
                                '</div>'+

                                 '<div class="col-md-5 " style="">'+
                                '<label>Category:</label>'+
                                '<select id="'+x+'" name="ln" class="form-control custom-select dest" >'+
                                       ' <option value="">--Select Category--</option>'+
                                        '<option value="ACSEE">FORM SIX(ACSEE)</option>'+
                                        '<option value="CSEE">FORM FOUR(CSEE)</option>'+
                                         '<option value="QT">QT</option>'+
                                    '</select>'+
                                '</div>'+
            '<button id="'+x+'" class="btn btn-danger deleteBtn1"><i class="glyphicon glyphicon-trash"></i> Remove</button>' +
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
    //$('.disable').attr("disabled", true);
    var formData = $('#test_form').serializeObject(); // serialize the form
    var obj;
    var myArray = new Array();
    var TotalOutstandingamount = 0;
    var TotalOutstandingvalue = 0;

    if(Array.isArray(formData.fn)) {
        for(var i = 0; i < formData.fn.length; i++) {
            obj = {};
            obj.item = formData.fn[i];
            obj.destination = formData.ln[i];

            TotalOutstandingamount =10  ; 
            TotalOutstandingvalue=10;
            myArray.push(obj)
      }
    } else if(formData.fn == null || formData.fn == ''){
     
        TotalOutstandingamount =0;
        TotalOutstandingvalue =10;
    }else {

        obj = {};
        obj.item = formData.fn;
        obj.destination = formData.ln;
        myArray.push(obj);
        TotalOutstandingamount =10; 
        TotalOutstandingvalue=0;
    }

    $('#loadingtext').html('Processing controll number, please wait............');
    $('#btn_save').hide();

        var NonweightArray   = myArray;
        var TotalNonweightamounts   = TotalOutstandingamount;
        var TotalNonweightvalues   = TotalOutstandingvalue;


        var r_name     = $('#r_name').val();
        var r_region     = $('#r_region').val();
        var r_address     = $('#r_address').val();
        var r_zipcode    = $('#r_zipcode').val();
        var r_phone   = $('#r_phone').val();
        var r_email     = $('#r_email').val();

         $.ajax({
             type : "POST",
             url  : "<?php echo base_url('Necta/Save_bulk_necta')?>",
             dataType : "JSON",
             data : {
                r_name:r_name,
                r_region:r_region,
                r_address:r_address,
                r_zipcode:r_zipcode,
                r_phone:r_phone,
                r_email:r_email,
                TotalNonweightamounts:TotalNonweightamounts,
                TotalNonweightvalues:TotalNonweightvalues,
                NonweightArray:JSON.stringify(NonweightArray) 
               }, 
               success: function(response){
                    if (response['status'] == 'Success') {
                        $('#btn_save').hide();
                         $('#loadingtext').html(response['message']);
                    }else{
                        $('#btn_save').hide();
                        $('#loadingtext').html(response['message']);
                    }

                    $('#btn_save').show();
                     $('#div10').hide();
                     $('#div15').hide();
                     // $('#aa11').html(data);
                     // $('#majib').html(data);
                     // $('#majibu').html(data);

             }
         });
         //return false;
        
});


function getCustomer() {

    var val = $('#box').val();
    if (val == 'Renewal Box') {

        $('#box1').show();
    }else{
         $('#box1').hide()
    }

};

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
