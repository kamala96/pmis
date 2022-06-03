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
                     <?php echo $this->session->userdata('service_type'); ?> Delivery Dashboard </h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        <?php echo $this->session->userdata('service_type'); ?> Delivery Dashboard </li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                      


                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">

                            <div class="row">
                           <div class="col-md-12">

                        <?php $regionlist = $this->employee_model->regselect(); ?>

                                      <form id="waiting" action="registered_domestic_Delivery?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST" >

                                      <input type="text" hidden="hidden" name="status" value="WaitingDelivery" class="" >
                                       <input type="text" hidden="hidden" name="type" value="WaitingDelivery" class="" >
                                     </form>
                                     <form id="assigned" action="registered_domestic_Delivery?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST">
                                      <input type="text" hidden="hidden" name="status" value="Assigned" class="" >
                                       <input type="text" hidden="hidden" name="type" value="Assigned" class="" >
                                     </form>

                                      <form id="delivered" action="registered_domestic_Delivery?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST" >
                                      <input type="text" hidden="hidden" name="status" value="Derivery" class="" >
                                       <input type="text" hidden="hidden" name="type" value="Derivery" class="" >
                                     </form>
                                    

                                        <a href="javascript:{}" onclick="document.getElementById('waiting').submit(); return false;" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Incomming Item </a>

                           
                                        <a href="javascript:{}" onclick="document.getElementById('assigned').submit(); return false;"  class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Assigned Item</a>

                                         <a href="javascript:{}" onclick="document.getElementById('delivered').submit(); return false;"  class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Delivered Item</a>
                          
                           <!-- <a href="<?php //echo base_url('Box_Application/received_item_from_out');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a> -->

                        </div> 
                        
                        </div>
                        <hr/>


                         <div class="row">
                          <div class="col-md-12 table table-responsive">
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
                            <form action="registered_domestic_Delivery?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST">
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
                             <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              

                                  <tr style="background-color: oblique;">
                              <th>Sender Name</th>
                              <th>Date Registered</th>
                              <th> Type</th>
                              <th>Weight</th>
                             
                              <th>Payment Type</th>
                             <th>Region Origin</th>
                              <th>Branch Origin</th>
                              <th>Destination Region</th>
                               <th>Destination Branch</th>
                             <!--  <th>Control No</th> -->
                              <th>Track No.</th>
                              <!-- <th>Item Status</th> -->
                              <!-- <th>Pay Status</th> -->
                               <?php if (@$type != 'Derivery') {?>
                              <th><div class="form-check" style="text-align: center;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                   <label class="form-check-label" for="remember-me"></label>
                                 </div></th>
                               <?php }else{?><th>Action</th><?php }?>
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
                                 
                                    <td><?php echo $value->payment_type; ?></td>
                                    <td><?php echo $value->sender_region; ?></td>
                                    <td><?php echo $value->sender_branch; ?></td>

                                     <td><?php echo $value->receiver_region; ?></td>
                                      <td><?php echo $value->reciver_branch; ?></td>
                                    <!-- <td><?php echo $value->billid; ?></td> -->
                                    <td><?php echo $value->track_number; ?></td>
                                   <!--  <td><?php if( $value->sender_status == "Counter"){?>
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
                                    </td> -->
                                    <!-- <td><?php if( $value->status == "Paid"){?>
                                        <button class="btn btn-success btn-sm" disabled="disabled">Paid Amt</button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Not Paid</button>
                                        <?php } ?>
                                    </td> -->
                                     <?php if (@$type != 'Derivery') {?>
                                    <td >
                                        <div class='form-check' style="text-align: center;">
                                       
                                        <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $value->senderp_id; ?>'>
                                        <label class='form-check-label' for='remember-me'></label>
                                      
                                    </div>
                                    </td>
                                  <?php }else{?>
                                     
                                    <td>
                                       <a href="get_delivery_info?senderid=<?php echo @$value->senderp_id;?>" class="btn btn-info">Show Info</a>
                                      <!-- <button class="btn btn-success btn-sm" disabled="disabled">Show Info</button> -->
                                      </td><?php }?>
                                </tr>



                             <?php }?>
                               
                         
                        </tbody>
                       
                          <tfoot>


                            <tr>
                              <?php if(@$type == "WaitingDelivery"){ ?>
                                 <td colspan="6"></td>

                               
                           <td colspan="2">
                               <select class="form-control custom-select js-example-basic-multiple"  name="operator">
                                <option value="">--Select Operator--</option>
                              <?php foreach ($emselect as  $value) {?>
                              <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                            <?php } ?>
                          </select>

                            </td>
                              <td style="" colspan="2">


                              <select name="action"  class="form-control custom-select" style="background-color: white;"   >
                                                    <option value="">--Select Action--</option>
                                                    <option value="Assign">Assign To</option>
                                                    <option value="Return">Return</option>
                                                 </select>
                            </td> 
                          
                            <td>&nbsp;</td>

                          <?php }elseif(@$type == "Assigned"){ ?>
                                 <td colspan="6"></td>

                               
                           <td colspan="2">
                               <select class="form-control custom-select js-example-basic-multiple"  name="operator">
                                <option value="">--Select Operator--</option>
                              <?php foreach ($emselect as  $value) {?>
                              <option value="<?php echo $value->em_id; ?>"><?php echo $value->first_name.'  '.$value->middle_name.'  '.$value->last_name;  ?></option>
                            <?php } ?>
                          </select>

                            </td>
                              <td style="" colspan="2">


                             <select name="action"  class="form-control custom-select" style="background-color: white;"   >
                                            <option value="">--Select Action--</option>
                                            <option value="reasign">Reassign</option>
                                            <option value="Return">Return</option>
                                         </select>
                            </td> 
                          
                            <td>&nbsp;</td>
                            <?php }else{?>
                              <td colspan="11"></td>
                            <?php }?>
                          <td style="" colspan="2">
                             <?php if(@$type != "Derivery"){ ?>
                            
                            <button type="submit" class="btn btn-info form-control" name="type" value="wixy" style="color: white;">Submit</button>
                                 
                                <?php }else{ ?>
                               
                              <?php }?>
                            </td>

                   
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
