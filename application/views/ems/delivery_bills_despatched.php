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
                      Dashboard Back Office</h3>
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
                        <div class="btn-group btn-group-justified">
                          <a href="<?php echo base_url('Ems_International/despatch_in');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> International Despatch In</a>
                        </div> 
                        
                        <div class="btn-group btn-group-justified">
                          <a href="<?php echo base_url('Box_Application/delivery_bills_despatched');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Delivery Bills Despatched </a>
                        </div>

                        <hr/>
                      </div>
                      <div class="card-body">
                        <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" style="width: 100%;">
                                <tr>
                                    <th style="">
                                     <label>Select Date:</label>
                                     <div class="input-group">

                                        <input type="text" name="" class="form-control  mydatetimepickerFull">
                                        <input type="hidden" name="" class="form-control date" value="Date">
                                        <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required">
                                    </div>
                                </th>
                               <!--  <th>
                                 <label>Month In Between:</label>
                                 <div class="input-group">
                                    <input type="text" name="" class="form-control mydatetimepicker month1">
                                    <input type="text" name="" class="form-control  mydatetimepicker month2">
                                     <input type="hidden" name="" class="form-control month" value="Month">
                                    <input type="button" name="" class="btn btn-success BtnMonth" style="" id="" value="Search Month Between">
                                </div>
                            </th> -->
                        </tr>
                    </table>
                </div>
            </div>
          <div class="table-responsive despatch1" style="">
              
          <div class="">
            <form method="POST" action="despatch_action">
          <table id="despatchIn" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
            <thead>
                                              <tr>
                                                <th>Despatch Number</th>
                                                <th>Number Of Bags</th>
                                                <th>Region Source</th>
                                                <!-- <th>Branch Source</th> -->
                                                <th>Despatched Date</th>
                                                <th>Transport Type</th>
                                                <th>Transport Name</th>
                                                <th>Reg. Number</th>
                                                <th>Status</th>
                                                <!-- <th>
                                                  Created By
                                                </th> -->
                                                <th>
                                                  Actions
                                                </th>
                                              </tr>
                                            </thead>

                                            <tbody>
                                              <?php foreach ($despatchIn as $value) {?>
                                                <tr>
                                                  <td>
                                                   <a href="bags_list_despatch?despno=<?php echo $value->desp_no ?>" data-despno = "<?php echo $value->desp_no; ?>" class="">
                                                      
                                                      <?php echo $value->desp_no; ?>
                                                      
                                                    </a>
                                                  </td>
                                                  <td style="text-align: center;">
                                                    <?php 
                                                    $bagno = $value->desp_no;
                                                    $db2 = $this->load->database('otherdb', TRUE);
                                                    $db2->where('despatch_no',$bagno);
                                                    $db2->from("bags");
                                                    echo $db2->count_all_results();
                                                    ?>
                                                  </td>
                                                  <td><?php echo $value->region_from; ?></td> 
                                                  <!-- <td><?php echo $value->branch_from; ?></td>  -->
                                                  <td><?php echo $value->datetime; ?></td>
                                                  
                                                  <td><?php echo $value->transport_type; ?></td>
                                                  <td><?php echo $value->transport_name; ?></td>
                                                  <td><?php echo $value->registration_number; ?></td>
                                                <td style="text-align: center;">
                                                    <?php 
                                                    $regionfrom = $this->session->userdata('user_region');
                                                    if ($value->despatch_status == 'Sent') {

                                                      echo "<button class='btn btn-danger btn-sm' type='button' disable>Pending Receive</button>";

                                                    }else {

                                                      echo "<button class='btn btn-success btn-sm' type='button' disable>Successfully Received</button>";

                                                    }
                                                //echo $value->despatch_status;
                                                    ?>

                                                  </td>
                                                  <!-- <td><?php
                                                  $id = $value->despatch_by;
                                                  @$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.'   '.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
                                                  ?></td> -->
                                                  <td>
                                                    <?php 
                                                    $regionfrom = $this->session->userdata('user_region');
                                                    if ( $value->despatch_status == 'Sent' ) { ?>
                                                     <div class='form-check' style="padding-left: 53px;">
                                                      <input type='checkbox' name='I' class='form-check-input checkSingle4 checkd' id='remember-me' value='<?php echo $value->desp_no ?>'>
                                                      <label class='form-check-label' for='remember-me'></label>
                                                    </div>
                                                  <?php }else{?>

                                                    <div class='form-check' style="padding-left: 53px;">

                                                      <input type='checkbox' class='form-check-input checkSingle4' id='remember-me' checked="checked" disabled="disabled">
                                                      <label class='form-check-label' for='remember-me'></label>
                                                      
                                                    </div>

                                                  <?php }?>

                                                </td>
                                              </tr>
                                            <?php } ?>
                                          </tbody>
                                          <tfoot>
                                            <?php if(empty($despatchIn)){ ?>
                    <?php }else{?>
                                             <tr>
                                              <td colspan="8"></td>
                                              <td style="float: right;">
                                                <button type="submit" class="btn btn-info">Receive Bag</button>
                                              </td>
                                            </tr>
                                             <?php } ?>
                                          </tfoot>
                                        </table>
                                        <br><br>
										<!-- <?php if(empty($despatchIn)){ ?>
										<?php }else{?>
										<table class="table" style="width: 100%;">
                                           <tr><td colspan="9"></td><td style="float: right;"><button type="submit" class="btn btn-info">Receive Bag</button></td></tr>
                                        </table>
										<?php } ?> -->
                                        
                                      </form>
          </div>
          
        </div>
        <div class="table-responsive despatch2" style="display: none;">
              
          <div class="result">          
          </div>
        </div>
                      </div>

                                  </div>
                                </div>
                              </div>

                            </div>
                            <!-- ============================================================== -->
                          </div> 
<script>
$(document).ready(function() {

    $(".BtnSubmit").on("click", function(event) {
      
     event.preventDefault();


     var datetime = $('.mydatetimepickerFull').val();
     var month1 = $('.month1').val();
     var month2 = $('.month2').val();
     var date = $('.date').val();
     var month = $('.month').val();
     console.log(datetime);

                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_delivery_bills_In_ByDate",
                 data:'date_time='+ datetime,
                 success: function(response) {
                          
                        $('.despatch1').hide();
                        $('.despatch2').show();
                        $('.result').html(response);
                    }
                });
            });
});
</script>
<script>
$(document).ready(function() {

    $(".BtnMonth").on("click", function(event) {

     event.preventDefault();
     
     var month1 = $('.month1').val();
     var month2 = $('.month2').val();
     console.log(month1);
     console.log(month2);

                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_Despatch_In_ByMonth",
                 data:'month1='+ month1 +'&month2='+ month2,
                 success: function(response) {
                  
                         $('.despatch1').hide();
                         $('.despatch2').show();
                         $('.result').html(response);
                    }
                });
            });
});
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
            dom: 'Bfrtip',
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
        order: [[4,"desc" ]],
        dom: 'Bfrtip',
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
        order: [[4,"desc" ]],
        dom: 'Bfrtip',
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
        order: [[4,"desc" ]],
        dom: 'Bfrtip',
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
        order: [[4,"desc" ]],
        dom: 'Bfrtip',
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
        ordering:false,
        order: [[5,"desc" ]],
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

<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>
<?php $this->load->view('backend/footer'); ?>
