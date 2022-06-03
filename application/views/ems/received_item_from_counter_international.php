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
                          <?php $regionlist = $this->employee_model->regselect(); ?>
                        <div class="">
                          <a href="received_item_from_counter" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Received Item From Counter</a>
                          <a href="pending_item_from_counter" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Item From Counter</a>
                          <a href="<?php echo base_url('Ems_International/received_item_from_counter');?>" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> International Received Item From Counter</a>
                            <a href="<?php echo base_url('Box_Application/Receive_scanned_item');?>" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Receive Scanned</a>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered" style="width: 100%;">
                                  <input type="hidden" name="" id="emid" value="<?php echo @$emid; ?>">
                                  <?php if($this->session->userdata('user_type') == 'SUPERVISOR' || $this->session->userdata('user_type') == 'EMPLOYEE'){?>
                                    <tr>
                                        <th style="">
                                         <label>Select Date:</label>
                                         <div class="input-group">

                                            <input type="text" name="" class="form-control  mydatetimepickerFull">
                                            <input type="hidden" name="" class="form-control date" value="<?php echo $emid; ?>">
                                            <input type="button" name="" class="btn btn-success BtnSubmit1" style="" id="" value="Search Date" required="required">
                                        </div>
                                    </th>
                                  </tr>
                                  <?php }else{ ?>
                                    <tr>
                                        <th style="">
                                         <label>Select Date:</label>
                                         <div class="input-group">

                                            <input type="text" name="" class="form-control  mydatetimepickerFull">
                                            <input type="hidden" name="" class="form-control date" value="Date">
                                            <!-- <input type="button" name="" class="btn btn-success BtnSubmit" style="" id="" value="Search Date" required="required"> -->
                                        </div>
                                    </th>
                                    <th>
                                     <label>Region and Branch:</label>
                                     <div class="input-group">
                                        <select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                                <option value="">--Select Region--</option>
                                                <?Php foreach($regionlist as $value): ?>
                                                 <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <select name="branch" value="" class="form-control custom-select"  id="branchdropo">
                                                <option value="">--Select Branch--</option>
                                            </select>
                                    </div>
                                </th>
                                <th style="paddin-top:20px;">
                                  <div class="input-group" style="padding-top:32px;">
                                  <input type="button" name="" class="btn btn-info BtnSubmit" style="" id="" value="Search Information">
                                </div>
                                </th>
                            </tr>
                          <?php }?>
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
                              <th>Date Registered</th>
                              <th>Region Origin</th>
                              <th>Branch Origin</th>
                              <th>Destination</th>
							                <th>Destination Branch</th>
                              <th>Tracking Number</th>
                              <th>Status</th>
                              <th><div class="form-check" style="padding-left: 53px;" id="showCheck">
                                  <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                     <label class="form-check-label" for="remember-me">Select All</label>
                                   </div></th>
                            </tr>
                          </thead>

                          <tbody class="results">
                           <?php foreach ($emslist1 as  $value) {?>
                             <tr>
                               <td><?php echo strtoupper($value->s_fullname);?></td>
                               <td><?php echo $value->date_registered;?></td>
                               <!-- <td><?php echo number_format($value->paidamount,2);?></td> -->
                               <td><?php echo $value->s_region;?></td>
                                <td><?php echo $value->s_district;?></td>
                                <td><?php echo $value->country_name;?></td>
								                <td></td>
                            <td>
                              <a href="<?php echo base_url();?>Box_Application/item_qrcode?code=<?php echo base64_encode($value->track_number) ?>" target="_blank"><?php echo $value->track_number;?></a>
                              <!-- <?php echo $value->ems_qrcode_image;?> -->
                              <!-- <img src="<?php echo base_url(); ?>/assets/images/<?php echo $value->ems_qrcode_image?>" width='150' class="thumbnail" /> -->
                            </td>
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
                                <input type="checkbox" class='form-check-input' checked disabled="disabled">
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
                      <?php $region = $this->employee_model->regselect();?>
                      <input type="text" name="region" value="Dar es Salaam" class="form-control" readonly="readonly">
                    </td>
                   <td colspan="2">
                     <input type="text" name="district" value="GPO" class="form-control" readonly="readonly">
                    </td> 
                    <td colspan="2"><input type="text" name="weight" class="form-control" placeholder="bag weight" required="required"></td>
                    <td>&nbsp;</td>
                    <td style="" colspan="2">
                      <button type="submit" class="btn btn-info form-control" name="catname" value="close" style="color: white;">Close Bag  </button></td></tr>
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
$(document).ready(function() {
 // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(8),:eq(7)").each( function (i) {
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
