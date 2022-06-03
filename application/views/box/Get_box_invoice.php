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
                      Box Invoice</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                       Box Invoice</li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    <div class="row ">
                    <!-- Column -->

                     <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>
                       <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_accessories_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Box Accessories</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Bulkboxes" class="text-white"><i class="" aria-hidden="true"></i> Bulk Boxes</a></button>

                         <div class="" >
                      <form method="post" action="<?php echo base_url();?>Box_Application/Gotobox">
                        <div class="input-group" >
                                        <input type="number" name="box_numbersearch" class="form-control">
                                      
                                        <input type="submit" class="btn btn-success" style="" id="" value="Goto Box" required="required"> 

                                        <!-- <button type="button" class="btn btn-primary " id="getboxdetails">Goto Box</button> -->

                                        <?php if(!empty($this ->session->flashdata('infor'))){ ?>
                                            <h3 id="info" style="padding-left:10px; color: red;">
                                                 <?php echo $this ->session->userdata('infor'); ?>
                                            </h3>
                  
                                          <!-- <strong> <?php echo $this ->session->userdata('message'); ?></strong>  -->
                                        
                                                        <?php }?>

                                         

                                    </div>

                  </form>
              </div>

                  <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "RM" ){ ?>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Get_Box_Invoice" class="text-white"><i class="" aria-hidden="true"></i>Print Box Invoice</a></button>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_Invoice" class="text-white"><i class="" aria-hidden="true"></i> Box List</a></button>

                     <?php } ?>
                </div>

                <div class="row" style="font-size:22px ;">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="">
                       <!--   <a href="despatched_bags_list" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Despatched Bags</a>
                          <a href="pending_bags_despatch_list" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Despatched Bags</a>
                        </div>  -->
                        <hr/>
                      </div>
                      <div class="card-body">
                         <form method="post" action="<?php echo base_url();?>Box_Application/Get_Box_Invoice">
                      <button class="btn btn-info" type="submit"><i class="fa fa-print"></i> Print</button>

                    

                          <br>

                        <div class="">
                          <div id="div1">
                           

                           <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;">
    
                          <tr>
                          <th colspan="6">
                         

                         <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px" style="display: block; margin-left: auto; margin-right: auto;"/>
                           <center>TANZANIA POSTS CORPORATION <br>
                                BOX INVOICE
                          </center>
                            

                          </th>
                          </tr>
                      </thead>
                      </table>
                         

                   <!--      <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;"> -->
                         <table style="width: 100%;font-size: 20px; border-bottom: solid; 1px;border-top: solid;1px;">
    <tr ><td style="width: 60%;">
      <table style="width: 100%;">
        <tr><td>FROM</td></tr>
        <tr><td>RM,<?php echo @$sender_region; ?></td></tr><br />
        <tr><td>Dear Sir/Madam</td></tr><br />
        <tr><td>
          <p>
            The annual rental fee for your private letter box/bag for  <?php echo date('Y'); ?> [January till December]
            as shown is due for payment.If not renewed within 21 days of inssuance of notice,it may result in loss of your letter box/bag without futher notice.
          </p>
          <p>The Management and staff of TPC would like to thank you for your continued support and we look forward to be of service to you.
          </p>
          <br />
          Date:<?php 
                   $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('d/m/Y');

            echo $date; ?>
          
        </td></tr>
     
      </table>
    </td>
    <td style="width: 40%;">
      <table style="width: 100%;">
        
       <tr><td >Name   </td><td style="text-transform: uppercase;">
        <input type="text" name="cust_name[]" id="cust_name" class="form-control cust_name">
          
        </td></tr>
      
      
      <tr><td style="">Customer Category  </td><td>
        <input type="text" name="box_tariff_category[]" id="box_tariff_category" class="form-control box_tariff_category">
          </td></tr>
      <tr><td style="">Box Number   </td><td>
        <input type="text" name="box_number[]"  class="form-control">
      </td>
      </tr>
      <tr><td style="">Box  Type  </td><td>
        <input type="text" name="box_type[]"  class="form-control">
      </td>
      </tr>
    
       <tr><td style="">Current Validity   </td><td>
        <input type="text" name="CurrentValidity[]"  class="form-control mydatetimepickerFull">
          </td></tr>
        <tr><td style="">Renew Period  From</td><td>
        <input type="text" name="RenewPeriod[]"  class="form-control mydatetimepickerFull">
          </td>
          </tr>
          <tr>
          <td style="">Renew Period Till : </td><td>
        <input type="text" name="tillPeriod[]"  class="form-control mydatetimepickerFull">
          </td></tr>
        
        <tr><td style="">Rental to be paid  </td><td>
        <input type="number" name="price[]"  class="form-control">
          </td></tr>
          <!-- <tr><td style="">VAT to be paid    </td><td>
        <input type="number" name="vat"  class="form-control">
          </td></tr> -->

        <!--   <tr><td style=""> </td><td>
             <input type="submit" class="btn btn-success" style="" id="" value="Print" required="required">
      
          </td></tr>
 -->
          
     
      
      </table>
    </td>
  </tr>
      
  </table><br />

 

 </div>
   <input type="button" class="btn btn-info" name="add" id="add" value="Add More">
                      
                      </div>
                      </div>
                      </form>
                      </div>

                      </div>
                            <!-- ============================================================== -->


                            <script type="text/javascript">
  $(document).ready(function(){

    var i = 1;

    $("#add").click(function(){
      i++;
      $('#div1').append('<table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%" style="border:2px;color:#000;font-size: 20px;font-weight: bold;"><tr> <th colspan="6"> <img src="<?php echo base_url(); ?>assets/images/tcp.png" height="100px" width="200px" style="display: block; margin-left: auto; margin-right: auto;"/><center>TANZANIA POSTS CORPORATION <br>BOX INVOICE </center></th</tr> </thead></table>'+
        '<table style="width: 100%;font-size: 20px; border-bottom: solid; 1px;border-top: solid;1px;"><tr><td style="width: 60%;"> <table style="width: 100%;"> <tr><td>FROM</td></tr> <tr><td>RM,<?php echo @$sender_region; ?></td></tr><br /><tr><td>Dear Sir/Madam</td></tr><br /><tr><td><p>The annual rental fee for your private letter box/bag for  <?php echo date('Y'); ?> [January till December]s shown is due for payment.If not renewed within 21 days of inssuance of notice,it may result in loss of your letter box/bag without futher notice.</p><p>The Management and staff of TPC would like to thank you for your continued support and we look forward to be of service to you.</p><br />Date:<?php $tz = 'Africa/Nairobi'; $tz_obj = new DateTimeZone($tz);$today = new DateTime("now", $tz_obj);$date = $today->format('d/m/Y'); echo $date; ?></td></tr></table> </td><td style="width: 40%;"> <table style="width: 100%;"><tr><td >Name   </td><td style="text-transform: uppercase;"><input type="text" name="cust_name[]" id="cust_name" class="form-control cust_name"> </td></tr><tr><td style="">Customer Category  </td><td><input type="text" name="box_tariff_category[]" id="box_tariff_category" class="form-control box_tariff_category"></td></tr><tr><td style="">Box Number   </td><td> <input type="text" name="box_number[]"  class="form-control"></td></tr><tr><td style="">Box  Type  </td><td><input type="text" name="box_type[]"  class="form-control"> </td></tr><tr><td style="">Current Validity   </td><td><input type="text" name="CurrentValidity[]"  class="form-control mydatetimepickerFull"></td></tr><tr><td style="">Renew Period  From</td><td><input type="text" name="RenewPeriod[]"  class="form-control mydatetimepickerFull"></td><tr><td style="">Renew Period Till : </td><td><input type="text" name="tillPeriod[]"  class="form-control mydatetimepickerFull"></td></tr><tr><td style="">Rental to be paid  </td><td><input type="number" name="price[]"  class="form-control"></td></tr> </table></td </tr></table><br />'
        
        );  
    });

    $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
    });
  });
</script>



                            <script>
  $(document).ready(function() {

    $("#wordsubmit").on("click", function(event) {

     event.preventDefault();

    var bagno ='<?php echo $getbags->bag_number; ?>';

     console.log(bagno);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/download",
                 data:'bagno='+ bagno,
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
