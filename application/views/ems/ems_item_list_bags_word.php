
<?php include_once APPPATH.'html_to_doc.php';  ?>
 <!-- require_once APPPATH.'\third_party\PHPWord.php'; -->
 
 <!-- Initialize class  -->
<?php $htmltodoc = new HTML_TO_DOC();?>








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
                   

                <div class="row" style="font-size:22px ;">
                  <div class="col-lg-12">
                    <div class="card">
                     
                      <div class="card-body">
                      <button class="btn btn-info" onclick="printContent('div1')"><i class="fa fa-print"></i> Print</button>
                      <a href="
                               <?php echo base_url()?>Box_Application/download?trn=<?php echo $getbags->bag_number; ?>"data-bagno = "<?php echo $getbags->bag_number; ?>" class="btn btn-primary">Wordocument
                                </a>
                       <!-- <button class="btn btn-info" id="wordsubmit"><i class="fa fa-print"></i> Wordocument</button>  -->
                      <br>

                      <?php
                       $sn=1; $trlist='';
                                foreach (@$getInfo as  $value) {
                                 $trlist=$trlist. '  <tr>
                                 
                                     <td style=" border: 1px solid black;"> '.$sn.' </td>
                                     <td style=" border: 1px solid black;"> '.@$value->track_number.' </td>
                                      <td style=" border: 1px solid black;"> '.@$value->Barcode.'  </td>
                                      <td style=" border: 1px solid black;">'.@$value->s_region.'</td>
                                      <td style=" border: 1px solid black;" colspan="2">'.@$value->s_district.'</td>
                                      <td style=" border: 1px solid black;">'.@$value->r_region.'</td>
                                       <td style=" border: 1px solid black;" colspan="2">'.@$value->branch.'</td>
                                      <td style=" border: 1px solid black;">              </td></tr>';
                                      $sn++;
                                }
                                $GETSEAL =$this->Box_Application_model->get_item_from_bagsDESPATCHED($getbags->bag_number);
                                ?>
                                 <!-- <link href="'.base_url().'assets/css/style.css" rel="stylesheet" media="all"> -->


                       <?php $htmlContent =  '<div class="">
             <link href="'.base_url().'assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
             
                 <script src="'.base_url().'assets/plugins/jquery/jquery.min.js"></script>

                          <div id="div1">
                           
                                    <table  class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                           

                              
                          <tr>
                          <th colspan="3">
                          </th>
                          <th colspan="4">
                         

                         <img src="'.base_url().'assets/images/tcp.png" height="50px" width="100px" style="display: block; margin-left: auto; margin-right: auto;"/>
                           <center>TANZANIA POSTS CORPORATION <br>
                          Bag Items List
                          </center>
                            

                          </th>
                          <th colspan="2">
                          </th>
                          </tr>

                          <tr>
                          <th colspan="3">
                          Bag Number:'.@$getbags->bag_number. '
                          </th>
                           <th colspan="3">
                          Date:'.@$getbags->date_created. '
                          </th>
                          
                          <th colspan="4" rowspan="2">
                         <p style="margin-right: 60px;">Dispatching Office Date Stamp</p>
                          </th>
                          </tr>

                           <tr>
                          <th colspan="2">
                          Bag Type:EMS Bag
                          </th>
                          
                          </tr>

                          <tr>
                          <th colspan="3">
                          From: '.@$getbags->bag_region_from.'
                          </th>
                          <th colspan="3">
                          To: '.@$getbags->bag_branch.'
                          </th>
                          </tr>
                            
                          <tr>
                          <th colspan="3">
                          Weight: '.@$getbags->bag_weight.' Kgs
                          </th>
                          <th colspan="6">
                          Despatch No: '.@$getbags->despatch_no.'
                          </th>
                          </tr>
                          </table>
                           <table  class=" table table-hover table-bordered" cellspacing="0" width="100%">
                         
                                 <tr style="border:1px">
                                 </tr>
                                 </table>
                                 <br />
                       
<table  class="display  nowrap table table-hover table-bordered" cellspacing="0" width="100%" >
                             <thead>
                                 <tr style="border:1px">
                                    <th style=" border: 1px solid black;"> S/No. </th>
                                    <th style=" border: 1px solid black;">Item Number</th>
                                     <th style=" border: 1px solid black;">Barcode Number</th>
                                    <th style=" border: 1px solid black;">Origin Region</th>
                                     <th style=" border: 1px solid black;" colspan="2">Origin Branch</th>
                                    <th  style=" border: 1px solid black;">Destination</th>
                                    <th style=" border: 1px solid black;" colspan="2">Destination Branch</th>
                                    <th style=" border: 1px solid black;" >Addl.Services</th>

                                   
                                </tr>
                            </thead>

                            <tbody class="">'.@$trlist.'</table>
<br />

 <table  class=" table table-hover table-bordered" cellspacing="0" width="100%">
<tr style="font-size:22px ;" >
    <th colspan="4"><b>Seal No: </b>'. @$GETSEAL->Seal. '</th>
<th colspan="5">Remarks: 

</th>
</tr>
<br><br><br><br><br><br>

<tr style="font-size:22px ;">
<td colspan="3">Despatched by ........................................</td>
<td colspan="3">Carried by ........................................... </td>
<td colspan="3">Received by ...............................</td>
</tr>

<tr style="font-size:22px ;">
<td>Receiving Office Date Stamp:

</td>
</tr>

</table>

 
 </div>

 <script src="'.base_url().'assets/plugins/bootstrap/js/bootstrap.min.js"></script>
 <script src="'.base_url().'assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="'.base_url().'assets/export/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
                      
                      </div>'; 
    $htmltodoc->createDoc($htmlContent, @$getbags->bag_number,1);?>
                      </div>
                      </div>

                      </div>
                            <!-- ============================================================== -->

<!-- 
                            -->


                            <script>
  $(document).ready(function() {

    $("#wordsubmit").on("click", function(event) {

     event.preventDefault();

    var bagno ='<?php echo $getbags->bag_number; ?>';

     //console.log(bagno);
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
