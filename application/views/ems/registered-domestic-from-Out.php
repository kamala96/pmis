<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
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

                        <?php echo $this->session->userdata('service_type'); ?> Dashboard  Back Office</li>
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
                                     <form id="received" action="registered_domestic_dashboard?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST" >
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
                              
                               <a href="Unregister/close_bag_items?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Bulk Bag Processing</a>

                          
                           <!-- <a href="<?php echo base_url('Box_Application/received_item_from_out');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a> -->

                        </div> 
                        
                        </div>
                        <hr/>


                         <div class="row">
                          <div class="col-md-8 table table-responsive">
                            <?php if(!empty($message)){ ?>
                            <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> <?php echo $message;?>
                          </div>
                          <?php }elseif(!empty($errormessage)){?>
                            <div class="alert alert-warning alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Warning!</strong> <?php echo $errormessage; ?>
                          </div>
                          <?php }else{?>
                          <?php } ?>
                            <form action="registered_domestic_Inward?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST">
                               <input type="text" hidden="hidden" name="type"  value='<?php echo @$type; ?>' class="" >
                               <input type="text" hidden="hidden" name="status"  value='<?php echo @$status; ?>' class="" >
                              <table class="table table-bordered">
                              <tr>

                                <th><input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Choose Date"></th>
                                <th><input type="text" name="month" class="form-control mydatetimepicker" placeholder="Choose Month"></th>
                                <!-- <th><select class="form-control custom-select" name="status"  style="height: 42px;">
                                  <option value="Back">From Counter</option>
                                  <option value="BackReceive">Received</option>
                                </select></th> -->
                                 <th><button class="btn btn-info" type="submit" name="search" value="search">Search Item</button></th>
                              </tr>
                            </table>
                        </div>
                         <div class="col-md-4 table table-responsive">
                            <?php if($type!='BackReceive'){  ?>
                             <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                    <th style="">
                                      <!-- <label>Scan Barcode :</label> -->
                                     <div class="input-group">
                                        <input id="edValue" type="text" class="form-control col-md-8 edValue" onInput="edValueKeyPress()">
                                        <br /><br /></div>
                                        <div class="input-group">
                                         <span id="lblValue" class="lblValue ">Barcode scan: </span><br /></div>
                                         <div class="input-group">
                                         <span id="results1" class="  results1" style="color: red;"></span>
                                    </div>
                                </th>
                             
                        </tr>
                        </table>
                    <?php }else{  ?>

                         <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                      <th style="text-transform: uppercase;"  >
                                         <div class="input-group">
                                         <span id="lblValue44" class="lblValue44 ">Assigne For Delivery: </span><br /></div>

                                <div class="input-group">
                                      <select class="form-control custom-select js-example-basic-multiple assignedoperator2" id="assignedoperator2"  name="operator">
                                        <option value="">--Select Operator--</option>
                                      <?php foreach ($emselect as  $value) {?>
                                      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                                    <?php } ?>
                                  </select>
                              </div>
                                 
                                </th>
                                    <th style="">
                                      <!-- <label>Scan Barcode :</label> -->
                                       <div class="input-group">
                                         <span id="lblValue2" class="lblValue2 ">Barcode scan: </span><br /></div>
                                     <div class="input-group">
                                        <input id="edValue2" type="text" class="form-control col-md-8 edValue2" onInput="edValueKeyPress2()">
                                        <br /><br /></div>
                                       
                                         <div class="input-group">
                                         <span id="results2" class="  results2" style="color: red;"></span>
                                    </div>
                                </th>
                              
                             
                        </tr>
                        </table>

                <?php }  ?>
                            </div>






                             <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              

                                  <tr style="background-color: oblique;">
                              <th>Sender Name</th>
                              <th>Date Registered</th>
                              <th>Register Type</th>
                              <th>Weight</th>
                              <th>Price</th>
                              <th>Payment Type</th>
                             <th>Region Origin</th>
                              <th>Branch Origin</th>
                              <th>Destination Region</th>
                               <th>Destination Branch</th>
                             <!--  <th>Control No</th> -->
                              <th>Track No.</th>
                              <th>Item Status</th>
                              <!-- <th>Pay Status</th> -->
                              <th><div class="form-check" style="text-align: center;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                   <label class="form-check-label" for="remember-me"></label>
                                 </div></th>
                            </tr>

                               
                           
                          </thead>
                          
                        <tbody>
                            <?php foreach ($list as $value) {
                             
                           $value = (object)$value; ?>

                               <tr>
                                    <td><?php echo $value->sender_fullname; ?></td>
                                    <td><?php echo $value->sender_date_created; ?></td>
                                    <td><?php echo $value->register_type; ?></td>
                                    <td><?php echo $value->register_weght; ?></td>
                                  <td><?php echo number_format($value->register_price,2); ?></td>
                                    <td><?php echo $value->payment_type; ?></td>
                                    <td><?php echo $value->sender_region; ?></td>
                                    <td><?php echo $value->sender_branch; ?></td>

                                     <td><?php echo $value->receiver_region; ?></td>
                                      <td><?php echo $value->reciver_branch; ?></td>
                                    <!-- <td><?php echo $value->billid; ?></td> -->
                                    <td><?php echo $value->track_number; ?></td>
                                    <td><?php if( $value->sender_status == "Counter"){?>
                                        <button class="btn btn-primary " disabled="disabled">Front Office</button>
                                        <?php }if($value->sender_status == "Back"){ ?>
                                            <button class="btn btn-default " disabled="disabled">Back Office</button>
                                        <?php }if($value->sender_status == "Bag"){ ?>
                                            <button class="btn btn-info " disabled="disabled">Is In Bag</button>
                                        <?php }if($value->sender_status == "Despatch"){ ?>
                                            <button class="btn btn-danger " disabled="disabled">Despatched</button>
                                         <?php }if($value->sender_status == "Received"){ ?>
                                            <button class="btn btn-success " disabled="disabled">Despatched</button>
                                        <?php }if($value->sender_status == "Derivery"){ ?>
                                            <button class="btn btn-warning " disabled="disabled">Derived</button>
                                          <?php }if($value->sender_status == "BackReceive"){ ?>
                                            <button class="btn btn-warning" disabled="disabled">Received Back Office</button>
                                        <?php } ?>
                                    </td>
                                    <!-- <td><?php if( $value->status == "Paid"){?>
                                        <button class="btn btn-success btn-sm" disabled="disabled">Paid Amt</button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Not Paid</button>
                                        <?php } ?>
                                    </td> -->
                                    <td >
                                        <div class='form-check' style="text-align: center;">
                                       
                                        <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $value->senderp_id; ?>'>
                                        <label class='form-check-label' for='remember-me'></label>
                                      
                                    </div>
                                    </td>
                                </tr>



                             <?php }?>
                               
                         
                        </tbody>
                       
                          <tfoot>


                            <tr>
                              <?php if(@$type == "BackReceive"){ ?>
                                 <!-- <td colspan="2"></td> -->

                                <td colspan="2">
                      <?php $service_type= $this->session->userdata('service_type');
                      $bagss2 =  $this->unregistered_model->get_bags_number_mails($service_type);
                      //echo json_encode($bagss2).'  hii ikoje';
                      //$bagss = $this->Box_Application_model->bagundespatchedselect();?>
                    <select class="form-control custom-select" name="bagss" style="height: 40px;background-color: white;"  id="bagss"  onChange="getbags();">
                      <!-- <option value="">--Select Bag--</option> -->
                      <option value="New Bag">New Bag</option>
                      <?php foreach ($bagss2 as $valuess) {?>
                        <option value="<?php echo $valuess->bag_number; ?>"><?php echo $valuess->bag_number; ?></option>
                      <?php } ?>
                    </select>
                    </td>
                      <td colspan="2"><input type="text"  name="weight" id="weight" class="form-control" placeholder="Bag Weight in gms" ></td>
                    <td colspan="2">
                      <?php $region = $this->employee_model->regselect();?>
                    <select class="form-control custom-select" name="region" style="height: 40px;background-color: white;" onChange="getRecDistrict();" id="rec_region">
                      <option value="">--Select Region--</option>
                      <?php foreach ($region as $value) {?>
                        <option value="<?php echo $value->region_name; ?>"><?php echo $value->region_name; ?></option>
                      <?php } ?>
                    </select>
                    </td>
                   <td colspan="2">
                      <select name="district" value="" class="form-control custom-select" style="background-color: white;"  id="rec_dropp1">
                                            <option value="">--Select Branch--</option>
                                        </select>
                    </td>
                      <td style="" colspan="2">


                      <select name="action"  class="form-control custom-select" style="background-color: white;"   >
                                            <option value="">--Select Action--</option>
                                            <option value="Close">Close Bag</option>
                                            <option value="Delivery">Pass For Delivery</option>
                                             <option value="exchage">Office of exchange</option>
                                         </select>
                    </td> 
                  
                    <td>&nbsp;</td>
                    <?php }else{?>
                              <td colspan="11"></td>
                            <?php }?>
                    <td style="" colspan="2">
                       <?php if(@$type == "BackReceive"){ ?>
                      
                      <input type="hidden" name="Delivery" class="form-control" value="Delivery" >
                      <button type="submit" class="btn btn-info form-control" name="type" value="bagclose" style="color: white;">Submit</button>
                                  <!-- <button class="btn  btn-info" name="type" value="bagclose">Close Item Bag</button> -->
                                <?php }else{ ?>
                                <button class="btn  btn-info" name="type" value="receive">Receive Item</button>
                              <?php }?>
                            </td>

                      <!-- <button class="btn  btn-info" name="type" value="bagclose">Close Item Bag</button> -->
                     <!--  <button type="submit" class="btn btn-info form-control" name="catname" value="close" style="color: white;">Close Bag  </button></td> -->






                          <!--     <td colspan="11"></td>
                               <td><input type="text" name="bagno" class="form-control" placeholder="Bag Weight in gms" required=""></td>

                            <?php// }else{?>
                              <td colspan="12"></td>
                            <?php// }?>
                              <td>
                                <?php //if(@$type == "BackReceive"){ ?>
                                  <button class="btn  btn-info" name="type" value="bagclose">Close Item Bag</button>
                                <?php // }else{ ?>
                                <button class="btn  btn-info" name="type" value="receive">Receive Item</button>
                              <?php //}?> -->

                            </tr>
                          </tfoot>
                        <?php //}?>
                        </table>
                        </form>
                          </div>
                         </div>
                      </div>
                      </div>
                      </div>

                            </div>
                            <!-- ============================================================== -->
                          </div> 




                            <script type="text/javascript">
         // $(document).ready(function(){
  function edValueKeyPress() {

    var date = $('#date').val();
                var month = $('#month').val();   

                 var region = $('#region').val();

    var edValue = $('#edValue').val();
    var s = edValue;
    
var txt = "The barcode number is: " + s;
    var lblValue = $('#lblValue').val();
    $('.lblValue').html(txt);
    


        // $(document).ready(function(){
           
            if (s.length > 12) {
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Unregistered/Receive_scanned",
                 data:'identifier='+ s,
                 success: function(data) {
                    // console.log('Success:', data);
                  // $('.fromServer1').show();
                  // $('.despatchdiv').hide();
                    $('.results1').html(data.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue').html('Barcode scan:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';
                     // $('.edValue').html('');
                      // $('#edValue').val() = '';

                   // var responses = document.getElementById("results");
                   // responses.innerText = response;

                },
            error: function (e) {
                 $('.results1').html(e.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue').html('Barcode scan:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';
               // console.log(e);

               


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

            

        // });
   
}
// });
</script>    

 <script type="text/javascript">
  function edValueKeyPress2() {

    var date = $('#date').val();
                var month = $('#month').val();   

                 var region = $('#region').val();

                 //alert('kwanza');

    var assignedoperator = $('#assignedoperator2').val();
    var operator = assignedoperator;
    var edValue = $('#edValue2').val();
    var s = edValue;
    if(operator === ''){
        var txt2 = "Please Assign Operator First ";
        $('.results2').html(txt2);
    

    }else{

var txt = "The barcode number is: " + s;
    var lblValue = $('#lblValue2').val();
    $('.lblValue2').html(txt);
    


        // $(document).ready(function(){
           
            if (s.length > 12) {
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Unregistered/Delivery_scanned",
                 data:'identifier='+ s + '&operator='+ operator,
                 success: function(response) {
                    // console.log('Success:', response);
                  // $('.fromServer1').show();
                  // $('.despatchdiv').hide();
                   $('.results2').html('');
                    $('.results2').html(response.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue2').html('Barcode scans:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue2");
                    edValue.value = '';
                    //console.log(response.responseText);
                     // $('.edValue').html('');
                      // $('#edValue').val() = '';

                   // var responses = document.getElementById("results");
                   // responses.innerText = response;

                },
            error: function (e) {
                 $('.results2').html('');
                 $('.results2').html(e.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue2').html('Barcode scanss:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue2");
                    edValue.value = '';
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
