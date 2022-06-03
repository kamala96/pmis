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
                     Combine Dashboard Back Office</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                       Combine Dashboard Back Office</li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    <div class="row ">
                    <!-- Column -->

                    <div class="col-lg-4 col-md-6">
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
                                     
                                        <a href="<?php echo base_url(); ?>unregistered/despatch_in_combine" class="text-muted m-b-0">Total Combine Despatch In</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <div class="col-lg-4 col-md-6">
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
                                     
                                      <a href="<?php echo base_url(); ?>unregistered/despatch_out_combine" class="text-muted m-b-0">Despatch Out</a>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                 
                   <!-- Column -->
                   <div class="col-lg-4 col-md-6">
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
                                     
                                       <a href="<?php echo base_url(); ?>unregistered/total_combine_bags" class="text-muted m-b-0">Total Combine Bags </a>
                                 
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
                        <div class="">
                         <!-- <a href="despatched_bags_list" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Despatched Bags</a>
                          <a href="pending_bags_despatch_list" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Despatched Bags</a> -->
                        </div> 
                        <hr/>
                      </div>
                      <div class="card-body">
                      <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button> 
                      <br>

                        <div class="">
                          <div id="div1">
                           

                          <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                            <thead>

                              
                          <tr>
                          <th colspan="5">
                         

                         <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px" style="display: block; margin-left: auto; margin-right: auto;"/>
                           <center>TANZANIA POSTS CORPORATION <br>
                          Bag Items List
                          </center>
                            

                          </th>
                          </tr>

                          <tr>
                          <th colspan="2">
                          Bag Number: <?php echo $getbags->bag_number; ?>
                          </th>
                          <th>
                          Bag Type: EMS Bag
                          </th>
                          <th colspan="2" rowspan="2">
                         <p style="margin-top: -60px;">Dispatching Office Date Stamp</p>
                          </th>
                          </tr>

                          <tr>
                          <th colspan="2">
                          From: <?php echo $getbags->bag_region_from; ?>
                          </th>
                          <th>
                          To: <?php echo $getbags->bag_region; ?>
                          </th>
                          </tr>
                            
                          <tr>
                          <th colspan="2">
                          Weight: <?php echo $getbags->bag_weight; ?> Kgs
                          </th>
                          <th colspan="3">
                          Despatch No: <?php echo $getbags->despatch_no; ?>
                          </th>
                          </tr>
                         
                                 <tr>
                                    <th> S/No. </th>
                                    <th>Item Number</th>
                                    <th>Origin</th>
                                    <th>Destination</th>
                                    <th>Addl.Services</th>

                                    <!-- <th>
                                      <div class="form-check" style="padding-left:45px;" id="showCheck">
                                <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                <label class="form-check-label" for="remember-me">All</label>
                                </div>
                                    </th> -->
                                </tr>
                            </thead>

                            <tbody class="">
                              <?php $sn=1; ?>
                               <?php foreach ($getInfo as  $value) {?>
                                   <tr>
                                 
                                     <td> <?php echo $sn; ?> </td>
                                     <td> <?php  echo $value->track_number; ?>  </td>
                                      <td><?php echo $value->s_region;?></td>
                                      <td><?php echo $value->r_region;?></td>
                                      <td>              </td>
                                     
                                   
                            
                           
                    <!-- <td style = "text-align:center;">
                          <div class="form-check">"
                        <input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            
                        </div>
                        </td> -->
                        <!-- <td style = "text-align:center;">
                        <a href="#" class="btn btn-info btn-sm getDetails" data-sender_id="<?php echo $value->sender_id ?>" data-receiver_id="<?php echo $value->receiver_id ?>" data-s_fullname="<?php echo $value->s_fullname ?>" data-s_address="<?php echo $value->s_address ?>" data-s_email="<?php echo $value->s_email ?>" data-s_mobile="<?php echo $value->s_mobile ?>" data-s_region="<?php echo $value->s_region ?>" data-r_fullname="<?php echo $value->fullname ?>" data-s_address="<?php echo $value->address ?>" data-r_email="<?php echo $value->email ?>" data-r_mobile="<?php echo $value->mobile ?>" data-r_region="<?php echo $value->r_region ?>" data-operator="<?php
                        $id = $value->operator;
                        $info = $this->employee_model->GetBasic($id);
                        echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name ?>" data-r_branch="<?php echo $value->branch ?>" data-s_branch="<?php echo $value->s_district ?>" data-billid="<?php echo $value->billid ?>" data-channel="<?php echo $value->paychannel ?>">Details</a>
                        </td> -->
</tr>
<?php $sn++; } ?>
</tbody>
<!-- <footer>
    <tr>
    
    
    <td colspan="7">
      <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
    <span style="float: right;"><button type="submit" class="btn btn-info" name="qr" value="qrcode">Print QR Code >>></button>
        </span>
 </td>
</tr>

</footer> -->

<tr>
<td colspan="5">Remarks: 
<br><br><br><br>
</td>
</tr>

<tr>
<td>Despatched by ........................................</td>
<td>Carried by ........................................... </td>
<td colspan="3">Received by ...............................</td>
</tr>

<tr>
<td>Receiving Office Date Stamp:
<br><br><br><br>
</td>
</tr>

</table>

 </div>
                      
                      </div>
                      </div>
                      </div>

                      </div>
                            <!-- ============================================================== -->
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
            order: [[5,"desc" ]],
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
          
        }
      });

                            });

                          });
                        </script>
<script type="text/javascript">
$(document).ready(function() {
  
    var table = $('#example47').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[5,"desc" ]],
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
        order: [[5,"desc" ]],
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
        ordering:false,
        order: [[5,"desc" ]],
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
        order: [[5,"desc" ]],
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
        order: [[5,"desc" ]],
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

<script type="text/javascript">
function printContent(el)
{
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
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
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>
<?php $this->load->view('backend/footer'); ?>
