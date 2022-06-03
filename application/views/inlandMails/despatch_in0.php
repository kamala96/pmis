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
                                     
                                        <a href="<?php echo base_url(); ?>unregistered/registered_domestic_dashboard?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" class="text-muted m-b-0">Total Item from Counter</a>
                                 
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
                            <form action="despatch_in?Ask_for=<?php echo $this->session->userdata('service_type'); ?>" method="POST">
                              <table class="table table-bordered">
                              <tr>
                                <th><input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Choose Date" style="height: 42px;"></th>
                                <th><input type="text" name="month" class="form-control mydatetimepicker" placeholder="Choose Month" style="height: 42px;"></th>
                                <th><select class="form-control custom-select" name="status"  style="height: 42px;">
                                  <option value="">--Select Status--</option>
                                  <option value="Sent">Sent</option>
                                  <option value="Received">Received</option>
                                </select></th>
                                 <th><button class="btn btn-info" type="submit" name="search" value="search">Search Item</button></th>
                              </tr>
                            </table>
                             <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              <tr style="background-color: oblique;">
                              <th>S/No</th>
                               <th>Date Registered</th>
                              <th>Despatch Number</th>
                              <th>Region Origin</th>
                              <th>Branch Origin</th>
                              <th>Destionation</th>
                              <th>Number Of Bags</th>
                              <th style="text-align: center;">Status</th>
                             <th><div class="form-check" style="text-align: center;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                   <label class="form-check-label" for="remember-me"></label>
                                 </div></th>
                            </tr>
                              </thead>
                              
                              <tbody>
                                   <?php $i = 1; foreach ($list as $value) {?>
                                <tr>
                                  <td><?php echo $i++ ?></td>
                                   <td><?php echo $value->datetime; ?></td>
                                  <td><a href="bags_item_list_by_despatchno?despno=<?php echo base64_encode($value->desp_no ); ?>&& Ask_for=<?php echo $this->session->userdata('service_type') ?> && type=Despin" class="btn btn-info"><?php echo $value->desp_no ?></a></td>
                                  <td><?php echo $value->origin_region ?></td>
                                  <td><?php echo $value->branch_origin?></td>
                                  <td><?php echo $value->region_to ?></td>
                                  <td><?php  echo $value->item_number ?></td>
                                  <td style="text-align: center;">
                                    <?php if($value->despatch_status == "Sent"){ ?>
                                      <button class="btn btn-info" disabled="disabled">Despatched</button>
                                    <?php }else{?>
                                      <button class="btn btn-success" disabled="disabled">Received</button>
                                    <?php }?>
                                  </td>
                                  <td>
                                    <div class='form-check' style="text-align: center;">
                                        <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $value->desp_id ; ?>' style="zoom:2px;">
                                        <label class='form-check-label' for='remember-me'></label>
                                      
                                    </div>
                                  </td>
                                 
                                </tr>
                           <?php } ?>
                              </tbody>
                              <?php if(empty($list)){ ?>
                              <?php }else{ ?>
                                <tfoot>
                                <tr>
                                  <td colspan="7"></td>
                                  <td colspan="" style="text-align: center;"><button class="btn btn-info" name="receive" value="receive">Receive Item</button></td>
                                </tr>
                              </tfoot>
                              <?php }?>
                              
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
