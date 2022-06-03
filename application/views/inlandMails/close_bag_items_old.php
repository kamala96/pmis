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

                        <?php echo $this->session->userdata('service_type'); ?> Dashboard  Close Bag</li>
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
                                <div class="col-md-12">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                    
                  
                            <th style="text-transform: uppercase;" >
                                <div class="input-group">

                                     <?php $service_type= $this->session->userdata('service_type');
                      $bagss =  $this->unregistered_model->get_bags_number_mails11($service_type); ?>
                       <input type="text" hidden="hidden" name="service_type" value="<?php echo $service_type; ?>" class="service_type" id="service_type">
                    <select class="form-control custom-select bagss" name="bagss" style="height: 40px;background-color: white;"  id="bagss"  onChange="getbags();">
                                          <!-- <option value="">--Select Bag--</option> -->
                                          <option value="New Bag">New Bag</option>
                                          <?php foreach ($bagss as $value) {?>
                                            <option value="<?php echo $value->bag_id; ?>"><?php echo $value->bag_number; ?></option>
                                          <?php } ?>
                                        </select>
                              </div> </th>

                            <th style="text-transform: uppercase;"  >
                                <div class="input-group">
                                     <input type="text" name="weight" class="form-control weight" id="weight" placeholder="bag weight" required="required">
                              </div> <div class="input-group">
                                         <span id="weighterror" class="  weighterror" style="color: red;"></span>
                                    </div> </th>



                                      <th style="text-transform: uppercase;"  >
                                       
                                <div class="input-group">

                                     <?php $region = $this->employee_model->regselect();?>
                    <select class="form-control custom-select rec_region" name="region" style="height: 40px;background-color: white;" onChange="getRecDistrict();" id="rec_region">
                      <option value="">--Select Region--</option>
                      <?php foreach ($region as $value) {?>
                        <option value="<?php echo $value->region_name; ?>"><?php echo $value->region_name; ?></option>
                      <?php } ?>
                  </select>


                                      <!-- <select class="form-control custom-select js-example-basic-multiple assignedoperator" id="assignedoperator"  name="operator">
                                        <option value="">--Select Deliverer --</option>
                                      <?php foreach ($emselect as  $value) {?>
                                      <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                                    <?php } ?>
                                  </select> -->
                              </div>
                              <div class="input-group">
                                         <span id="rec_regionerror" class="  rec_regionerror" style="color: red;"></span>
                                    </div>
                               
                                </th>

                                  <th style="text-transform: uppercase;"  >
                                <div class="input-group">
                                     <select name="district" value="" class="form-control custom-select rec_dropp1" style="background-color: white;"  id="rec_dropp1" required="required">
                                            <option value="">--Select Branch--</option>
                                        </select>
                              </div> 
                           <div class="input-group">
                                         <span id="rec_dropp1error" class="  rec_dropp1error" style="color: red;"></span>
                                    </div></th>


                                    <th style="">
                                        <div class="input-group" > <!-- style="display:none" -->
                    <select class="form-control custom-select Nill" name="Nill"  style="height: 40px;background-color: white;"  onChange="getnil();" id="Nill">
                      <option value="">Not Nill</option>
                       <option value="Nill">Nill</option>
                     
                  </select>
                              </div>
                           <div class="input-group">
                                         <span id="Nillerror" class="  Nillerror" style="color: red;"></span>
                                    </div></th>

                                    <th style="">
                                      <!-- <label>Scan Barcode :</label> -->
                                       

                                     <div class="input-group" id="notNill" >
                                        <input id="edValue" type="text" class="form-control  edValue" onInput="edValueKeyPress()">
                                       </div> <br />

                                         <div class="input-group" id="notNill2">
                                         <span id="lblValue" class="lblValue ">Barcode scan: </span><br /></div>
                                       
                                         <div class="input-group">
                                         <span id="results" class="  results" style="color: red;"></span>
                                    </div>
                                </th>
                                <th>
                                    <div class="input-group">
                                         <button class="btn btn-info btn-md disable" id="submitform" type="button">Close Bag</button>
                                        
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
                                    <div class="col-md-12 ">
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

                              }
                             
                             
                          };
                          </script>


                             <script type="text/javascript">

                                 $('#submitform').on('click',function(){ 
           
            var bagss = $('#bagss').val();
             var serial  = $('.serial').val();
              // var operator  = $('.operator').val();
               var weight = $('#weight').val();
      var rec_dropp1 = $('#rec_dropp1').val();
    var rec_region = $('#rec_region').val();
     var Nill = $('#Nill').val();


     if(bagss != 'New Bag'){
        if(weight === ''){
        var txt2 = "Please Input weight ";
        $('.weighterror').html(txt2);
        
    }else{

    $('.weighterror').html('');
         $('.results').html('');
             
              // var bagss  = $('.bagss').val();
              var bagss = $('#bagss').val();
               var service_type = $('#service_type').val();
            
             $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('Unregistered/Save_bulk_closebag_scanned')?>",
                             //dataType : "JSON",
                             data : {serial:serial,weight:weight,region:rec_region,branch:rec_dropp1,bagss:bagss,service_type:service_type,Nill:Nill},
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

         }

    }else{

               if(rec_region === ''){
        var txt2 = "Please Select Region ";
        $('.rec_regionerror').html(txt2);
         $('.weighterror').html('');
         $('.rec_dropp1error').html('');
    

    }
    else if(rec_dropp1 === ''){
        var txt2 = "Please Select Branch ";
        $('.rec_dropp1error').html(txt2);
         $('.weighterror').html('');
          $('.rec_regionerror').html('');
    

    } else if(weight === ''){
        var txt2 = "Please Input weight ";
        $('.weighterror').html(txt2);
         $('.rec_dropp1error').html('');
          $('.rec_regionerror').html('');
       
    

    }
    else{
        $('.weighterror').html('');
         $('.rec_dropp1error').html('');
          $('.rec_regionerror').html('');
         $('.results').html('');
             
              // var bagss  = $('.bagss').val();
              var bagss = $('#bagss').val();
              var service_type = $('#service_type').val();
              
            
             $.ajax({
                             type : "POST",
                             url  : "<?php echo base_url('Unregistered/Save_bulk_closebag_scanned')?>",
                             //dataType : "JSON",
                             data : {serial:serial,weight:weight,region:rec_region,branch:rec_dropp1,bagss:bagss,service_type:service_type,Nill:Nill},
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

         }
     }
        
       
         });


                                 function Deletevalue(n) {
   
      var identifier  = n;
       // alert('imefika33 '+ n);


        var serial  = $('.serial').val();
    var assignedoperator = $('#assignedoperator').val();
    var operator = assignedoperator;
    
     $.ajax({
         type : 'POST',
         url  : '<?php echo base_url('Unregistered/delete_bag_close_bulk_scanned_item')?>',
         
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
                            function getnil() {
                              var Nill = $('.Nill').val();

                              if (Nill == 'Nill') {
                                $('#notNill').hide();
                                 $('#notNill2').hide();
                              }else{
                               $('#notNill').show();
                               $('#notNill2').show();
                             }
                           }
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
  function edValueKeyPress() { 

    //alert('du');

    var date = $('#date').val();
                var month = $('#month').val();   

                 var region = $('#region').val();

                 //alert('kwanza');
    var Nill  = $('.Nill').val();
     var serial  = $('.serial').val();
    var edValue = $('#edValue').val();
    var s = edValue;
if (typeof(serial) == "undefined")serial='not';
    
        

var txt = "The barcode number is: " + s;
    var lblValue = $('#lblValue').val();
    $('.lblValue').html(txt);
    


        // $(document).ready(function(){
           
            if (Nill !='Nill' ) {
                if (s.length > 12 ) {
               
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Unregistered/close_bag_bulk_scanned_item",
                 data:'identifier='+ s + '&weight='+ weight + '&serial='+ serial+ '&region='+ rec_region+ '&branch='+ rec_dropp1,
                  // data : {identifier:s,weight:weight,serial:serial,region:rec_region,branch:rec_dropp1},
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
 }}


            

       
   
}
// });
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
