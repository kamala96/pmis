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
                          <a href="<?php echo base_url('Ems_International/despatch_out') ?>" class="despatch btn btn-info" style="padding-right: 10px;">Despatch Out International</a>
                        </div> 
                         <div class="btn-group btn-group-justified">
                           <a href="received_item_from_counter" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Counter & Branch</a>
                            </div>
                          
                          <div class="btn-group btn-group-justified">
                           <a href="received_item_from_out" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Region</a>
                              </div> 
                           <?php  if( $this->session->userdata('user_type') == "ADMIN") {?>
                            <div class="btn-group btn-group-justified">
                          <a href="pending_item_from_counter" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Item From Counter</a>
                             </div> 
                          <div class="btn-group btn-group-justified">
                            <a href="<?php echo base_url('Ems_International/received_item_from_counter');?>" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> International Received Item From Counter</a>
                               </div> 
                        <?php } ?>
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
                                <!-- <th>
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
              <table id="despatch" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th>Despatch Number</th>
                    <th>Number Of Bags</th>
                    <th>Destination Region</th>
                    <!-- <th>Destination Branch</th> -->
                    <th>Despatch Date</th>
                    <th>Transport Type</th>
                    <th>Transport Name</th>
                    <th>Registration Number</th>
                   <!--  <th>Despatch Status</th> -->
                    <th>Received By</th>
                  </tr>
                </thead>

                <tbody class="results">
                  <?php foreach ($despatch as $value) {?>
                    <tr>
                      <td><a href="bags_list_despatch?despno=<?php echo $value->desp_no ?>" data-despno = "<?php echo $value->desp_no; ?>" class=""><?php echo $value->desp_no; ?></a>
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
                      <td><?php echo $value->region_to; ?></td>
                      <!-- <td><?php echo $value->branch_to; ?></td> -->
                      <td><?php echo $value->datetime; ?></td>
                      <!--    <td><?php echo $value->region_to; ?></td> -->
                      <td><?php echo $value->transport_type; ?></td>
                      <td><?php echo $value->transport_name; ?></td>
                      <td><?php echo $value->registration_number; ?></td>
                      <!-- <td style="text-align: center;">
                        <?php 
                        $regionfrom = $this->session->userdata('user_region');
                        if ($value->region_from == $regionfrom && $value->despatch_status == 'Sent' ) {

                          echo "<button class='btn btn-info' type='button' disable>Bags Sent</button>";

                        }elseif (@$value->region_to == $regionfrom && $value->despatch_status == 'Sent') {

                          echo "<button class='btn btn-warning' type='button' disable>Pending Bag</button>";

                        }elseif ($value->region_from == $regionfrom && $value->despatch_status == 'Received') {

                          echo "<button class='btn btn-success' type='button' disable>Received Bag</button>";


                        }

                                                //echo $value->despatch_status;
                        ?>
                      </td> -->
                      <td><?php
                      $id = $value->received_by;
                      @$basicinfo = $this->employee_model->GetBasic($id); echo 'PF'.'    '.@$basicinfo->em_code.' '. @$basicinfo->first_name.' '.@$basicinfo->last_name;
                      ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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
                 url: "<?php echo base_url();?>Box_Application/Get_Despatch_Out_ByDate",
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
                 url: "<?php echo base_url();?>Box_Application/Get_Despatch_Out_ByMonth",
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
    var table = $('#despatchIn').DataTable( {
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
