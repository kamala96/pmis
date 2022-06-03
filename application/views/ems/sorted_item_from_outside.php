<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h2 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp
        <?php
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                      SORTING ZONE</h2>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        Dashboard Back Office</li>
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
                                     echo $despatchInCount;
                                    ?>

                                     </h3>

                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_in" class="text-muted m-b-0">Total Despatch In</a>

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
                                      echo $despatchCount;
                                    ?>

                                     </h3>

                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_out" class="text-muted m-b-0">Total Despatch Out</a>

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

                                        <a href="<?php echo base_url(); ?>Box_Application/BackOffice" class="text-muted m-b-0">Total Item from Counter</a>

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

                                        <a href="<?php echo base_url(); ?>Box_Application/ems_bags_list" class="text-muted m-b-0">Total Bags</a>

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
                          <?php $regionlist = $this->employee_model->regselect(); ?>
                        <div class="">
                          <a href="received_item_from_counter" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Counter & Branch</a>
                          
                           <a href="received_item_from_out" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a>

                            <a href="<?php echo base_url('Box_Application/Sorted_item_from_out');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Sort Item From Region</a>

                              <a href="<?php echo base_url('Box_Application/Receive_scanned_item');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Bulk Delivery Scanned</a>
                              
                               <a href="<?php echo base_url('Box_Application/close_bag_items');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Bulk Bag Processing</a>

                           <?php  if( $this->session->userdata('user_type') == "ADMIN") {?>

                          <a href="pending_item_from_counter" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Item From Counter</a>

                            <a href="<?php echo base_url('Ems_International/received_item_from_counter');?>" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> International Received Item From Counter</a>
                            
                        <?php } ?>

                        
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-8">
                          <form action="<?php echo base_url()?>Box_Application/Sorted_item_from_outside_search" method="POST">
                                <table class="table table-bordered" style="width: 100%;">
                                  <input type="hidden" name="" id="emid" value="<?php echo @$emid; ?>">
                                  <?php if($this->session->userdata('user_type') == 'SUPERVISOR' || $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'RM'){?>
                                    <tr>
                                        <th style="">
                                          <div class="input-group">
                                        <input type="text" name="date" class="form-control  mydatetimepickerFull">
                                        <button type="submit" class="btn btn-success">Search Date</button>
                                    </div>

                                        <!--  <label>Select Date:</label>
                                         <div class="input-group">

                                            <input type="text" name="" class="form-control  mydatetimepickerFull">
                                            <input type="hidden" name="" class="form-control date" value="<?php echo $emid; ?>">
                                            <input type="button" name="" class="btn btn-success BtnSubmit1" style="" id="" value="Search Date" required="required">
                                        </div> -->
                                    </th>
                                    <th>
                                 <div class="input-group">
                                    <input type="text" name="month" class="form-control  mydatetimepicker month2">
                                    <button type="submit" class="btn btn-success">Search Month</button>

                                </div>
                            </th>
                                  </tr>
                                  <?php }else{ ?>
                                    <tr>
                                        <th style="">
                                         <label>Select Date:</label>
                                         <div class="input-group">

                                            <input type="text" name="date" class="form-control  mydatetimepickerFull">
                                            <!-- <input type="hidden" name="" class="form-control date" value="Date"> -->
                                            <!-- <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required"> -->
                                        </div>
                                    </th>
                                      <th style="">
                                         <label>Select Month:</label>
                                 <div class="input-group">
                                    <input type="text" name="month" class="form-control  mydatetimepicker month2">
                                </div>
                            </th>
                                    <th>
                                     <label>Region and Branch:</label>
                                     <div class="input-group">
                                        <select name="region"  class="form-control custom-select" required id="regiono" >
                                                <option value="">--Select Region--</option>
                                                <?Php foreach($regionlist as $value): ?>
                                                 <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                           <!--  <select name="branch" value="" class="form-control custom-select"  id="branchdropo">
                                                <option value="">--Select Branch--</option>
                                            </select> -->
                                    </div>
                                </th>
                                <th style="paddin-top:20px;">
                                  <div class="input-group" style="padding-top:32px;">
                                  <input type="submit" name="" class="btn btn-info BtnSubmit11" style="" id="" value="Search Information">
                                </div>
                                </th>
                            </tr>
                          <?php }?>
                        </table>
                           </form>
                    </div>
                     <div class="col-md-4">
                              <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                      <th style="text-transform: uppercase;"  >
                                         <div class="input-group">
                                         <span id="lblValue44" class="lblValue44 ">Assigne For Delivery: </span><br /></div>

                                <div class="input-group">
                                      <select class="form-control custom-select js-example-basic-multiple assignedoperator" id="assignedoperator"  name="operator">
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
                                         <span id="lblValue" class="lblValue ">Barcode scan: </span><br /></div>
                                     <div class="input-group">
                                        <input id="edValue" type="text" class="form-control col-md-8 edValue" onInput="edValueKeyPress()">
                                        <br /><br /></div>
                                       
                                         <div class="input-group">
                                         <span id="results" class="  results" style="color: red;"></span>
                                    </div>
                                </th>
                              
                             
                        </tr>
                        </table>
                            </div>
                </div>
                <?php if($this->session->userdata('message')){?>
                  <div class="alert alert-success alert-dismissible">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong><?php echo $this->session->flashdata('message'); ?></strong>
</div>
<?php }else{?>
  <?php } ?>
                         <div class="table-responsive" style="">
           <form method="POST" action="close_bags" enctype="multipart/form-data">
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
							  <?php if(empty($emslist1)){?>
							  <?php }else{?>
							  <tr>
                                  <th colspan="8"></th>
                                  <th>
                                    <!-- <div class="form-check" style="padding-left: 53px;" id="showCheck">
                                     <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                     <label class="form-check-label" for="remember-me">Select All</label>
                                   </div> -->
                                 </th>
                             </tr>
							  <?php }?>

                             <tr>
                              <th>Sender Name</th>
                              <th>Receiver Name</th>
                              <th>Date Registered</th>
                              <th>Region Origin</th>
                              <th>Branch Origin</th>
                              <th>Destination</th>
							                <th>Destination Branch</th>
                              <th>Tracking Number</th>
                              <th>Barcode Number</th>
                              <th>Status</th>
                              <th><div class="form-check" style="padding-left: 53px;" id="showCheck">
                                  <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                     <label class="form-check-label" for="remember-me">Select All</label>
                                   </div></th>
                            </tr>
                          </thead>

                          <tbody class="results1">
                           <?php foreach ($emslist1 as  $value) { $value = (object)$value;?>
                             <tr>
                               <td><?php echo strtoupper($value->s_fullname);?></td>
                                <td><?php echo strtoupper($value->fullname);?></td>
                               <td><?php echo $value->date_registered;?></td>
                               <!-- <td><?php echo number_format($value->paidamount,2);?></td> -->
                               <td><?php echo $value->s_region;?></td>
                                <td><?php echo $value->s_district;?></td>
                                <td><?php echo $value->r_region;?></td>
								 <td><?php echo $value->branch;?></td>
                            <td>
                              <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php echo $value->track_number;?></a>
                              <!-- <?php echo $value->ems_qrcode_image;?> -->
                              <!-- <img src="<?php echo base_url(); ?>/assets/images/<?php echo $value->ems_qrcode_image?>" width='150' class="thumbnail" /> -->
                            </td>
                            <td><?php echo $value->Barcode;?></td>

                            <td>

                              <?php if($value->office_name == 'Received'){ ?>
                                <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Item Received</button>
                              <?php }?>

                            </td>
                            <td style="padding-left:  65px;"><div class='form-check'>
                              <?php if ($value->office_name == 'Received' && $value->bag_status == 'isNotBag') {?>
                                <input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='<?php echo $value->id ?>'>
                                <!-- <input type="text" name="destreg" value="<?php echo $value->r_region ?>"> -->
                                <label class='form-check-label' for='remember-me'></label>
                              <?php }elseif($value->office_name == 'Back' && $value->bag_status == 'isNotBag'){ ?>
                                <input type="checkbox" class='form-check-input' disabled="disabled">
                              <?php }elseif($value->office_name == 'Received' && $value->bag_status == 'isBag'){ ?>
                                 <input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='<?php echo $value->id ?>'>
                                <!-- <input type="checkbox" class='form-check-input' checked disabled="disabled"> -->
                              <?php }?>

                            </div>
                          </td>
                    </tr>
                  <?php } ?>

                </tbody>
                <footer>
				<?php if(empty($emslist1)){?>
			<?php }else{?>
							  <tr>
                   <td colspan="2">
                      <?php $bagss = $this->Box_Application_model->bagundespatchedselect();?>
                    <select class="form-control custom-select" name="bagss" style="height: 40px;background-color: white;"  id="bagss"  onChange="getbags();">
                      <!-- <option value="">--Select Bag--</option> -->
                      <option value="New Bag">New Bag</option>
                      <?php foreach ($bagss as $value) {?>
                        <option value="<?php echo $value->bag_id; ?>"><?php echo $value->bag_number; ?></option>
                      <?php } ?>
                    </select>
                    </td>
                      <td colspan="1"><input type="text" name="weight" class="form-control" placeholder="bag weight" ></td>
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
                      <select name="district" value="" class="form-control custom-select" style="background-color: white;"  id="rec_dropp1" >
                                            <option value="">--Select Branch--</option>
                                        </select>
                    </td> 
                  
                  <!--   <td>&nbsp;</td> -->
                    <td style="" colspan="2">


                      <select name="action"  class="form-control custom-select" style="background-color: white;"   required="required">
                                            <option value="">--Select Action--</option>
                                            <option value="Close">Close Bag</option>
                                            <option value="Delivery">Pass For Delivery</option>
                                             <option value="exchage">Office of exchange</option>
                                         </select>
                    </td>

                     <!--  <button type="submit" class="btn btn-info form-control" name="catname" value="close" style="color: white;">Close Bag  </button></td> -->
                     <td style="" colspan="2">
                      <input type="hidden" name="Delivery" class="form-control" value="Delivery" >
                      <button type="submit" class="btn btn-info form-control" name="catname" value="close" style="color: white;">Submit</button></td></tr>
				<?php }?>

                </footer>
                  </table>
                    <input type="hidden" name="type" value="EMS">
                  </form>
        </div>
                      </div>
                      </div>
                      </div>

                            </div>
                            <!-- ============================================================== -->
                          </div>

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

                              }
                             
                             
                          };
                          </script>

                           <script type="text/javascript">
  function edValueKeyPress() {

    var date = $('#date').val();
                var month = $('#month').val();   

                 var region = $('#region').val();

                 //alert('kwanza');

    var assignedoperator = $('#assignedoperator').val();
    var operator = assignedoperator;
    var edValue = $('#edValue').val();
    var s = edValue;
    if(operator === ''){
        var txt2 = "Please Assign Operator First ";
        $('.results').html(txt2);
    

    }else{

var txt = "The barcode number is: " + s;
    var lblValue = $('#lblValue').val();
    $('.lblValue').html(txt);
    


        // $(document).ready(function(){
           
            if (s.length > 12) {
             $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Delivery_scanned",
                 data:'identifier='+ s + '&operator='+ operator,
                 success: function(response) {
                     console.log('Success:', response);
                  // $('.fromServer1').show();
                  // $('.despatchdiv').hide();
                   $('.results').html('');
                    $('.results').html(response.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue').html('Barcode scans:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';
                    //console.log(response.responseText);
                     // $('.edValue').html('');
                      // $('#edValue').val() = '';

                   // var responses = document.getElementById("results");
                   // responses.innerText = response;

                },
            error: function (e) {
                 $('.results').html('');
                 $('.results').html(e.responseText);
                    // var lblValue = document.getElementById("lblValue");
                    $('.lblValue').html('Barcode scanss:');
                   // lblValue.innerText = 'Barcode scan:';
                    var edValue = document.getElementById("edValue");
                    edValue.value = '';
                   console.log(e);

               


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
$(document).ready(function() {
 // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(9),:eq(10)").each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                .column(i)
                .search( this.value )
                .draw();
            }
        } );
    } );
    var table = $('#example4').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        ordering:false,
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


<script>
  $(document).ready(function() {

    $(".BtnSubmit").on("click", function(event) {

     event.preventDefault();
     var datetime = $('.mydatetimepickerFull').val();
     var region   = $('#regiono').val();
     var branch   = $('#branchdropo').val();

                 $.ajax({
                 type: "POST",
                  url: "<?php echo base_url();?>Box_Application/received_date_region_branch",
                  data:'date='+ datetime + '&region='+ region + '&branch='+ branch,
                  success: function(response) {
                    alert(response);
                 }
               });
      });
  });
</script>


  
  



<?php $this->load->view('backend/footer'); ?>
