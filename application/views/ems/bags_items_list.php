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
                            <a href="despatch_out" class="" style="padding-right: 10px;">DespatchOut</a>
                          <a href="despatch_in" class="" style="padding-right: 10px;">DespatchIn</a>
                          <a href="ems_back_list" data-bagno = "" class="">EMS Back List</a>
                          </div> 
                          <hr/>
                          </div>
                          <div class="card-body">
                           <form method="POST" action="close_bags">
                    <table id="fromServer" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Sender Name</th>
                           <th>Receiver Name</th>
                              <th>Date Registered</th>
                              <th>Region Origin</th>
                              <th>Branch Origin</th>
                              <th>Destination</th>
                              <th>Tracking Number</th>
                               <th>Barcode Number</th>
                              <!-- <th>Status</th> -->

                        </tr>
                      </thead>

                      <tbody>
                        <?php foreach ($bagslist as  $value) {?>
                             <tr>
                               <td><?php echo $value->s_fullname;?></td>
                               <td><?php echo $value->fullname;?></td>
                               <td><?php echo $value->date_registered;?></td>
                               <!-- <td><?php echo number_format($value->paidamount,2);?></td> -->
                               <td><?php echo $value->s_region;?></td>
                                <td><?php echo $value->s_district;?></td>
                                <td><?php echo $value->r_region;?></td>
                               <!-- <td>
                                <?php 
                                if ($value->billid == '' && $value->bill_status == 'PENDING') {
                                 $serial=$value->serial;
                                 $paidamount=$value->paidamount;
                                 $region=$value->region;
                                 $district=$value->district;
                                 $mobile = $value->Customer_mobile;
                                 $renter = $value->cat_name;
                                 $serviceId = $value->PaymentFor;

                                 $this->Box_Application_model->getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId);

                               }
                               echo $value->billid;
                               ?>
                             </td> -->
                             
                            <td>
                              <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php echo $value->track_number;?></a>
                              <!-- <?php echo $value->ems_qrcode_image;?> -->
                              <!-- <img src="<?php echo base_url(); ?>/assets/images/<?php echo $value->ems_qrcode_image?>" width='150' class="thumbnail" /> -->
                            </td>
                            <td><?php echo $value->Barcode;?></td>
                            <!-- <td>
                              <?php if ($value->office_name == 'Back' && $value->bag_status == 'isNotBag') {?>
                                <button type="button" class="btn  btn-success" disabled="disabled">Comming From Counter</button>
                              <?php }elseif($value->office_name == 'Received' && $value->bag_status == 'isNotBag'){ ?>
                                <button type="button" class="btn  btn-success" disabled="disabled">Item Received</button>
                              <?php }elseif($value->office_name == 'Back' && $value->bag_status == 'isBag'){ ?>
                                <button type="button" class="btn  btn-warning" disabled="disabled">Is In Bag <?php echo $value->isBagNo;?></button>
                              <?php }elseif($value->office_name == 'Received' && $value->bag_status == 'isBag'){ ?>
                                <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Item Received</button>
                              <?php }?>

                            </td>
                           -->
                    </tr>
                  <?php } ?>
                      </tbody>

                    </table>
                    <input type="hidden" name="type" value="EMS">
                  </form>
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
    $(".mails").hide();
    $(".emsbags").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".item").click(function(){
    $(".ems").show();
    $(".mails").hide();
    $(".emsbags").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $("#mails").click(function(){
    $(".ems").hide();
    $(".mails").show();
    $(".emsbags").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".emsbags1").click(function(){
    $(".emsbags").show();
    $(".ems").hide();
    $(".mails").hide();
    $(".itemlist").hide();
    $(".despatch1").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".despatch").click(function(){
    $(".despatch1").show();
    $(".emsbags").hide();
    $(".ems").hide();
    $(".mails").hide();
    $(".itemlist").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".despatchIn1").hide();
    $(".listItems").hide();
  });
  $(".despatchIn").click(function(){
    $(".despatch1").hide();
    $(".despatchIn1").show();
    $(".emsbags").hide();
    $(".ems").hide();
    $(".mails").hide();
    $(".itemlist").hide();
    $(".bags_item_list").hide();
    $(".bagsList").hide();
    $(".listItems").hide();
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
          $(".mails").hide();
          $(".despatch1").hide();
          $(".bagsList").hide();
          $(".despatchIn1").hide();
          $(".listItems").hide();
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
          $(".mails").hide();
          $(".despatch1").hide();
          $(".despatchIn1").hide();
          $(".listItems").hide();
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
    // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    // $('#example4 thead tr:eq(1) th').not(":eq(7),:eq(8)").each( function (i) {
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

    var table = $('#fromServer').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
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
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<script type="text/javascript">
    $(document).ready(function() {
    var table = $('#kimeo').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
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
