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
      <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
        <?php 
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id); 
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                     <?php echo $this->session->userdata('service_type'); ?> Dashboard  Back Office</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        <?php echo $this->session->userdata('service_type'); ?> Dashboard  Delivery Office</li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    <div class="row ">
                    <!-- Column -->

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/in.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php
                                     echo $despin;   
                                    ?>
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>unregistered/despatch_in?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="text-muted m-b-0">Total Despatch In</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/sent.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php
                                      echo $despout;
                                    ?>
                                    
                                     </h3>
                                     
                                      <a href="<?php echo base_url(); ?>unregistered/despatch_out?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="text-muted m-b-0">Despatch Out</a>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/receiving.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                  									 echo $ems;
                  									 ?>
                                     </h3>
                                     <form id="from_counter" action="registered_domestic_dashboard?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST">
                                      <input type="text" hidden="hidden" name="status" value="Back" class="" >
                                       <input type="text" hidden="hidden" name="type" value="Back" class="" >
                                     
                                        <a href="javascript:{}" onclick="document.getElementById('from_counter').submit(); return false;" class="text-muted m-b-0">Item from Counter/Branch</a>
                                      </form>

                                
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/bag.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                   <?php 
                  									echo $bags;
                  									?>
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>unregistered/total_numbers_of_bags?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="text-muted m-b-0">Total Bags Number</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">

                            <div class="row">
                           <div class="col-md-12">

                        <?php $regionlist = $this->employee_model->regselect(); ?>

                                      <input type="text" hidden="hidden" name="status" value="BackReceive" class="" >
                                       <input type="text" hidden="hidden" name="type" value="BackReceive" class="" >
                                     </form>
                                     <form id="from_out" action="registered_domestic_Inward?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST">
                                      <input type="text" hidden="hidden" name="status" value="Back" class="" >
                                       <input type="text" hidden="hidden" name="type" value="Back" class="" >
                                     </form>

                                      <form id="receivedInward" action="registered_domestic_Inward?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST" >
                                      <input type="text" hidden="hidden" name="status" value="BackReceive" class="" >
                                       <input type="text" hidden="hidden" name="type" value="BackReceive" class="" >
                                     </form>
                                    

                                        <a href="javascript:{}" onclick="document.getElementById('received').submit(); return false;" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Counter & Branch</a>
                                      
                     

                           
                                        <a href="javascript:{}" onclick="document.getElementById('from_out').submit(); return false;"  class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a>

                                         <a href="javascript:{}" onclick="document.getElementById('receivedInward').submit(); return false;"  class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Sort Item From Region</a>

                                          <a href="Receive_scanned_item?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Bulk Delivery Scanned</a>
                              
                               <a href="close_bag_items?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Bulk Bag Processing</a>

                                      
                          
                           <!-- <a href="<?php echo base_url('Box_Application/received_item_from_out');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a> -->

      
                           

                        </div> 
                        
                        </div>
                        <hr/>


                         <div class="row">
                                <div class="col-md-6">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                      <th style="text-transform: uppercase;"  >
                                        <div class="input-group"> <span id="" class=" ">Bulk single scan: </span><br /></div>
                                       
                                <div class="input-group">
                                      
                                      <select class="form-control custom-select js-example-basic-multiple assignedoperator1" id="assignedoperator1"  name="operator1">
                                        <option value="">--Select Deliverer --</option>
                                      <?php foreach ($emselect as  $value) {?>
                                      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                                <!-- <div class="input-group"> -->
                                         <!-- <span id="lblValue44" class="lblValue44 ">Assign For Delivery: </span><br /></div> -->

                                 
                                </th>
                                    <th style="">
                                      <!-- <label>Scan Barcode :</label> -->
                                      <div class="input-group"> <span id="" class=" "> </span><br /></div>
                                      
                                     <div class="input-group">
                                        <input id="edValue1" type="text" class="form-control col-md-8 edValue1" onInput="edValueKeyPress1()">
                                        <br /><br /></div>
                                         <div class="input-group">
                                         <span id="lblValue1" class="lblValue1 ">Barcode scan: </span><br /></div>
                                       
                                         <div class="input-group">
                                         <span id="results1" class="  results1" style="color: red;"></span>
                                    </div>
                                </th>
                                
                        </tr>
                        </table>
                            </div>

                              <div class="col-md-6">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                      <th style="text-transform: uppercase;"  >
                                        <div class="input-group"> <span id="" class=" ">Bulk scan: </span><br /></div>
                                <div class="input-group">
                                      <select class="form-control custom-select js-example-basic-multiple assignedoperator" id="assignedoperator"  name="operator">
                                        <option value="">--Select Deliverer --</option>
                                      <?php foreach ($emselect as  $value) {?>
                                      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                                <!-- <div class="input-group"> -->
                                         <!-- <span id="lblValue44" class="lblValue44 ">Assign For Delivery: </span><br /></div> -->

                                 
                                </th>
                                    <th style="">
                                      <!-- <label>Scan Barcode :</label> -->
                                      <div class="input-group"> <span id="" class=" "> </span><br /></div>
                                     <div class="input-group">
                                        <input id="edValue" type="text" class="form-control col-md-8 edValue" onInput="edValueKeyPress()">
                                        <br /><br /></div>
                                         <div class="input-group">
                                         <span id="lblValue" class="lblValue ">Barcode scan: </span><br /></div>
                                       
                                         <div class="input-group">
                                         <span id="results" class="  results" style="color: red;"></span>
                                    </div>
                                </th>
                                <th>
                                    <div class="input-group">
                                         <button class="btn btn-info btn-md disable" id="submitform" type="button">Submit All</button>
                                         <!-- <a href="#"  class="btn btn-info btn-md" id="addmore">Submit All</a> -->
                                     </div>
                                    
                                </th>
                              
                             
                        </tr>
                        </table>
                            </div>
                   
                </div>

                <hr />
                         <div class="row">
                        <div class="col-md-12">
                           <br>
                                  <div id="div6" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class ="list" style="font-weight: 60px;font-size: 18px;"></span>
                                </div>
                                </div>
                            </div>
                </div>
            </div>
                      </div>
                      </div>
                      </div>

                            </div>
                            <!-- ============================================================== -->
                          </div> 

                            <script type="text/javascript">

                                 $('#submitform').on('click',function(){ 
           

             var serial  = $('.serial').val();
              var operator  = $('.operator').val();
             
            
             $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('Unregistered/Save_bulk_Delivery_scanned')?>",
                             //dataType : "JSON",
                             data : {serial:serial,operator:operator},
                             beforeSend: function() {
                                  $("#submitform").addClass('button_loader').attr("value",""); 
                                
                             },
                             success: function(data){
                                 $('#submitform').removeClass('button_loader').attr("value","\u2713");
                                 // $('#submitform').prop('disabled', true);
                                $('#results').html(data);
                                $('#div6').hide();
                                $('.list').html(''); 
                                
                             }
                         });
        
       
         });


                                 function Deletevalue(n) {
   
      var identifier  = n;
       // alert('imefika33 '+ n);


        var serial  = $('.serial').val();
    var assignedoperator = $('#assignedoperator').val();
    var operator = assignedoperator;
    
     $.ajax({
         type : 'POST',
         url  : '<?php echo base_url('Unregistered/delete_deliver_bulk_scanned_item')?>',
         
         data : {identifier:identifier,operator:operator,serial:serial},
         success: function(data){
             $('#div6').show();
             $('.list').html('');
            
              $('.list').html(data);
            
                  
               }
           });

        }

           function Deletevalue1(n) {
   
      var identifier  = n;
       // alert('imefika33 '+ n);


        var serial  = $('.serial1').val();
    var assignedoperator = $('#assignedoperator1').val();
    var operator = assignedoperator;
    
     $.ajax({
         type : 'POST',
         url  : '<?php echo base_url('Unregistered/delete_deliver_bulk_scanned_itemS')?>',
         
         data : {identifier:identifier,operator:operator,serial:serial},
         success: function(data){
             $('#div6').show();
             $('.list').html('');
            
              $('.list').html(data);
            
                  
               }
           });

        }
    </script>



<script type="text/javascript">
  function edValueKeyPress() {

    var date = $('#date').val();
                var month = $('#month').val();   

                 var region = $('#region').val();

                 //alert('kwanza');
    var serial  = $('.serial').val();
    if (typeof(serial) == "undefined")serial='not';
    var assignedoperator = $('#assignedoperator').val();
    var operator = assignedoperator;
    var edValue = $('#edValue').val();
    var s = edValue;
    if(operator === ''){
        var txt2 = "Please Assign Operator First ";
        $('.results').html(txt2);
    

    }else{
         $('.results').html('');

var txt = "The barcode number is: " + s;
    var lblValue = $('#lblValue').val();
    $('.lblValue').html(txt);
    


        // $(document).ready(function(){
           
            if (s.length > 12) {
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Unregistered/deliver_bulk_scanned_item",
                 data:'identifier='+ s + '&operator='+ operator + '&serial='+ serial,
                 success: function(response) {
                    // console.log('Success:', response);
                    // $('.results').html(response.responseText);
                    $('.lblValue').html('Barcode scan:');
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';

                     $('#div6').show();
                     $('.list').html(response);
                    //console.log(response.responseText);
                     // $('.edValue').html('');
                      // $('#edValue').val() = '';

                   // var responses = document.getElementById("results");
                   // responses.innerText = response;

                },
            error: function (e) {
                 $('.results').html(e.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue').html('Barcode scan:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';
                     $('#div6').show();
                     $('.list').html(e);
                   //console.log(e);

               


            //    $.ajax({
            //      type: "POST",
            //      url: "<?php echo base_url();?>Box_Application/received_item_from_outside_search_list",
            //      data:'date='+ date,'month='+ month,'region='+ region
            //      success: function(data) {
            //         $('.results').html(response.responseText);
            //         $('.lblValue').html('Barcode scan:');
            //         var edValue = document.getElementById("edValue");
            //         edValue.value = '';
            //        //console.log(data);

            //     },
            // error: function (e) {
            //      $('.results').html(e.responseText);
            //         $('.lblValue').html('Barcode scan:');
            //         var edValue = document.getElementById("edValue");
            //         edValue.value = '';
            //         // $('.original2').show();
            //        // $('.original').hide();
            //     console.log(e);
            // }
            //   });




            }
              });
 }
}

            

       
   
}
// });
</script>        

<script type="text/javascript">
  function edValueKeyPress1() {

    var date = $('#date').val();
                var month = $('#month').val();   

                 var region = $('#region').val();

                 //alert('kwanza');
    var serial  = $('.serial1').val();
    if (typeof(serial) == "undefined")serial='not';
    var assignedoperator = $('#assignedoperator1').val();
    var operator = assignedoperator;
    var edValue = $('#edValue1').val();
    var s = edValue;
    if(operator === ''){
        var txt2 = "Please Assign Operator First ";
        $('.results1').html(txt2);
    

    }else{
         $('.results1').html('');

var txt = "The barcode number is: " + s;
    var lblValue = $('#lblValue1').val();
    $('.lblValue1').html(txt);
    


        // $(document).ready(function(){
           
            if (s.length > 12) {
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Unregistered/deliver_bulk_scanned_items",
                 data:'identifier='+ s + '&operator='+ operator + '&serial='+ serial,
                 success: function(response) {
                    // console.log('Success:', response);
                    // $('.results').html(response.responseText);
                    $('.lblValue1').html('Barcode scan:');
                    var edValue = document.getElementById("edValue1");
                    edValue.value = '';

                     $('#div6').show();
                     $('.list').html(response);
                    //console.log(response.responseText);
                     // $('.edValue').html('');
                      // $('#edValue').val() = '';

                   // var responses = document.getElementById("results");
                   // responses.innerText = response;

                },
            error: function (e) {
                 $('.results1').html(e.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue1').html('Barcode scan:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue1");
                    edValue.value = '';
                     $('#div6').show();
                     $('.list').html(e);
                   //console.log(e);

               


            //    $.ajax({
            //      type: "POST",
            //      url: "<?php echo base_url();?>Box_Application/received_item_from_outside_search_list",
            //      data:'date='+ date,'month='+ month,'region='+ region
            //      success: function(data) {
            //         $('.results').html(response.responseText);
            //         $('.lblValue').html('Barcode scan:');
            //         var edValue = document.getElementById("edValue");
            //         edValue.value = '';
            //        //console.log(data);

            //     },
            // error: function (e) {
            //      $('.results').html(e.responseText);
            //         $('.lblValue').html('Barcode scan:');
            //         var edValue = document.getElementById("edValue");
            //         edValue.value = '';
            //         // $('.original2').show();
            //        // $('.original').hide();
            //     console.log(e);
            // }
            //   });




            }
              });
 }
}

            

       
   
}
// });
</script>  



                           <script type="text/javascript">
                                  function getRecDistrict() {
                              var val = $('#rec_region').val();
                               $.ajax({
                               type: "POST",
                               url: "<?php echo base_url();?>Employee/GetBranch",
                               data:'region_id='+ val,
                               success: function(data){
                                   $("#rec_dropp1").html(data);
                               }
                           });
                          };
                          </script>

                            <script type="text/javascript">
                                  function getbags() {
                              var val = $('#bagss').val();
                              if(val != 'New Bag'){
                               // alert('New Bags');$('select[name="select-states"]').attr('disabled', 'disabled');.removeAttr('disabled');
                                 // $('#rec_region').hide()
                                 // $('#rec_dropp1').hide();
                                  $('#rec_region').attr('disabled', 'disabled');
                                 $('#rec_dropp1').attr('disabled', 'disabled');
                              }
                              else{
                                 // $('#rec_region').show();
                                 // $('#rec_dropp1').show();
                                  $('#rec_region').removeAttr('disabled');
                                 $('#rec_dropp1').removeAttr('disabled');
                                  $('#weight').removeAttr('disabled');

                                   $('#rec_dropp1').prop('disabled', false);
                                  $('#weight').prop('disabled', false);
                                 // $('#rec_dropp1').removeAttr('disabled');

                              }
                             
                             
                          };
                          </script>


                          <script type="text/javascript">
                            $(document).ready(function(){
                              $("#show1").click(function(){
                                alert('mussa');
                              });
                            });
                          </script>    
                          <script>
                            function transportType() {
                              var ty = $('.type').val();

                              if (ty == '') {
                                alert('1');
                              }else if(ty == 'Public Truck' || ty == 'Public Buses'){
                                $('.cost').show();
                              }else{
                               $('.cost').hide();
                             }
                           }
                         </script>
                         <script>
                          $(document).ready(function(){

                            $(".ems1").click(function(){
                              $(".ems").show();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $(".ems12").click(function(){
                              $(".ems2").show();
                              $(".ems").hide();
                              $(".mails").hide();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $(".item").click(function(){
                              $(".ems").show();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $("#mails").click(function(){
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").show();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $(".emsbags1").click(function(){
                              $(".emsbags").show();
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });

                            $(".despatch").click(function(){
                              $(".despatch1").show();
                              $(".emsbags").hide();
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".itemlist").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });

                            $(".despatchIn").click(function(){
                              $(".despatch1").hide();
                              $(".despatchIn1").show();
                              $(".emsbags").hide();
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".itemlist").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                            });

                            $(".listitem").click(function(){

                              var type = 'EMS';
                              var bagno = $(this).attr('data-bagno');
                              var reg   = $('.reg').val();
                              $.ajax({

                               url: "<?php echo base_url();?>Box_Application/bags_item_list",
                               method:"POST",
     data:{bagno:bagno,type:type},//'region_id='+ val,
     success: function(data){

      $('.listresults').html(data);

          //$(".itemlist").show();
          $(".bags_item_list").show();
          $(".emsbags").hide();
          $(".ems").hide();
          $(".ems2").hide();
          $(".mails").hide();
          $(".despatch1").hide();
          $(".bagsList").hide();
          $(".despatchIn1").hide();

          //$('#fromServer').dataTable().clear();
          $('#fromServer').DataTable( {
            orderCellsTop: true,
            destroy:true,
            order: [[3,"desc" ]],
            fixedHeader: true,
            dom: 'B1frtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );


        }
      });

                            });
                            $(".bagsList12").click(function(){

                              var type = 'EMS';
                              var despno = $(this).attr('data-despno');

                              $.ajax({

                               url: "<?php echo base_url();?>Box_Application/bags_list_despatch",
                               method:"POST",
     data:{despno:despno,type:type},//'region_id='+ val,
     success: function(data){

      $('.bagresults').html(data);

          //$(".itemlist").show();
          $(".bags_item_list").hide();
          $(".bagsList").show();
          $(".emsbags").hide();
          $(".ems").hide();
          $(".ems2").hide();
          $(".mails").hide();
          $(".despatch1").hide();
          $(".despatchIn1").hide();
          //$('#example47').dataTable().destroy();
          $('#example47').DataTable( {
        //orderCellsTop: true,
        destroy:true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
          

        }
      });

                            });

                          });
                        </script>



<script type="text/javascript">
$(document).ready(function() {
  
    var table = $('#example4').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        ordering: false,
        order: [[1,"desc" ]],
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        dom: 'lBfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
   
    var table = $('#example42').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[3,"desc" ]],
        dom: 'B1frtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
    // //$('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
    // $('#example5 thead tr:eq(1) th').not(":eq(7),:eq(8)").each( function (i) {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

    var table = $('#example5').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[3,"desc" ]],
        dom: 'B1frtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#despatch').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[3,"desc" ]],
        dom: 'B1frtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#despatchIn').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[3,"desc" ]],
        dom: 'B1frtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll").change(function() {
      if (this.checked) {
        $(".checkSingle").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingle").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingle").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingle").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAll").prop("checked", true);
        }     
      }
      else {
        $("#checkAll").prop("checked", false);
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAlls").change(function() {
      if (this.checked) {
        $(".checkSingles").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingles").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingles").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingles").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAlls").prop("checked", true);
        }     
      }
      else {
        $("#checkAlls").prop("checked", false);
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll1").change(function() {
      if (this.checked) {
        $(".checkSingle1").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingle1").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingle1").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingle1").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAll1").prop("checked", true);
        }     
      }
      else {
        $("#checkAll1").prop("checked", false);
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll4").change(function() {
      if (this.checked) {
        $(".checkSingle4").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingle4").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingle4").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingle4").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAll4").prop("checked", true);
        }     
      }
      else {
        $("#checkAll4").prop("checked", false);
      }
    });
  });
</script>

<script>
  $(document).ready(function() {

    $("#BtnSubmit").on("click", function(event) {

     event.preventDefault();

     var datetime = $('.mydatetimepickerFull').val();
     console.log(datetime);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_Despatch_List_Date",
                 data:'date_time='+ datetime,
                 success: function(response) {
                  $('.fromServer1').show();
                  $('.despatchdiv').hide();
                  $('.fromServer1').html(response);
                }
              });
              });
  });
</script>
<?php $this->load->view('backend/footer'); ?>
