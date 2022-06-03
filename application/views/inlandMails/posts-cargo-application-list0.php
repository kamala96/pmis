<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Posts Cargo Transaction List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posts Cargo Transaction List</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <?php $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');  

    $id=$this->session->userdata('user_login_id'); $getInfo = $this->employee_model->GetBasic($id) ;
    ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/posts_cargo" class="text-white"><i class="" aria-hidden="true"></i> Posts Cargo Transaction</a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/posts_cargo_application_list" class="text-white"><i class="" aria-hidden="true"></i> Posts Cargo Transactions List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                    <h4 class="m-b-0 text-white"> Posts Cargo Transaction List
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
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
                          <form action="posts_cargo_application_list" method="POST">
                             <table class="table table-bordered">
                              <tr>
                                <th><input type="text" name="date" class="form-control mydatetimepickerFull"></th>
                                <th><input type="text" name="month" class="form-control mydatetimepicker"></th>
                                <th><select class="form-control custom-select" name="status" required="required">
                                  <option value="">--Select Status--</option>
                                  <option>Paid</option>
                                  <option>NotPaid</option>
                                </select></th>
                                 <th><button class="btn btn-info" type="submit" name="search" value="search">Search</button></th>
                              </tr>
                            </table>
                            <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              
                             <tr style="background-color: oblique;">
                              <th>Operator</th>
                                <th>Sender Name</th>
                              <th>Date Registered</th>
                             <th>Cargo</th>
                              <th>Payment Channel</th>
                              <th>Payment Receipt</th>
                              <th>Payment Amount</th>
                              <th>Region Origin</th>
                              <th>Destination</th>
                              <th>Control No</th>
                             <!--  <th>Track No.</th>
                              <th>Item Status</th> -->
                              <th>Pay Status</th>
                            <!--   <th><div class="form-check" style="text-align: center;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                   <label class="form-check-label" for="remember-me"></label>
                                 </div></th> -->
                            </tr>
                          </thead>
                        
                        <tbody><!-- <?php  echo json_encode($cargo); ?> -->

                            <?php  foreach ($list2 as $value) {?>
                                <tr>
                                    <td><?php echo 'PF '.$value->operator; ?></td>
                                     <td><?php echo $value->s_fullname; ?></td>
                                    <td><?php echo $value->date_registered; ?></td>
                                    <td>
                                      <?php
                                       
                                      foreach ($cargo as $value2) {
                                        $serialcargo=$value2->serial;
                                         $serialtransc=$value->serial;
                                         if($serialtransc == $serialcargo){

                                       echo ' <span>Posts Cargo Type: </span> <span>'. $value2->type.'</span><br>';
                                       echo ' <span>Item: </span> <span>'.$value2->item.'</span><br>';
                                       echo ' <span>Weight: </span> <span>'.$value2->weight.'</span><br>';
                                       echo ' <span>Price: </span> <span class="box-owner">'.number_format($value2->item_price,2).'</span><br>';

                                     }
                                     else{
                                       //echo ' <span>Price: </span> <span class="box-owner">';

                                     }


                                   }

                                      ?>

                                    </td>
                                   
                                    <td><?php echo $value->paychannel; ?></td>
                                     <td><?php echo $value->receipt; ?></td>
                                      <td><?php echo  number_format($value->paidamount,2); ?></td>
                                    <td><?php echo $value->s_region; ?></td>
                                    <td><?php echo $value->r_region; ?></td>
                                    <td><?php echo $value->billid;?> </td>
                                   <!--  <td><?php echo $value->track_number; ?></td> -->
                                  <!--   <td>
                                         <?php if($value->s_status == "Received"){ ?>
                                            <button class="btn btn-success btn-sm" disabled="disabled">Despatched</button>
                                        <?php }if($value->s_status == "Derivery"){ ?>
                                            <button class="btn btn-warning btn-sm" disabled="disabled">Derived</button>
                                             <?php }if($value->s_status == "NotReceived"){ ?>
                                            <button class="btn btn-warning btn-sm" disabled="disabled">Not Received</button>
                                        <?php } ?>
                                    </td> -->
                                    <td><?php if( $value->status == "Paid"){?>
                                        <button class="btn btn-success btn-sm" disabled="disabled">Paid </button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Not Paid</button>
                                        <?php } ?>
                                    </td>
                                  <!--   <td >
                                        <div class='form-check' style="text-align: center;">
                                        <?php if( $value->sender_status == "Counter" && $value->status == "Paid"){?>
                                        <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $value->senderp_id; ?>'>
                                        <label class='form-check-label' for='remember-me'></label>
                                        <?php }else{ ?>
                                          <input type='checkbox' class='form-check-input checkSingles' id='remember-me' checked="checked" disabled="disabled">
                                        <label class='form-check-label' for='remember-me'></label>
                                        <?php } ?>
                                         
                                    </div>
                                    </td> -->
                                </tr>
                           <?php } ?>
                        </tbody>
                        <?php if(empty($list)){ ?>
                        <?php }else{ ?>
                          <tfoot>
                            <td><button class="btn btn-danger btn-sm" name="shiftend" value="shiftend">Shift End</button></td>
                            <td colspan="3" style="text-align: right;"><b>Total Price::</b></td>
                            
                            <td><?php echo number_format($sum->paidamount,2); ?></td>
                            <td colspan="7"></td>
                            <td><button class="btn btn-info btn-sm" name="backofice" value="backofice">Send BackOffice</button>   <button class="btn btn-danger btn-sm" name="qrcode" value="qrcode">Print Qr code</button></td>
                        </tfoot>
                        <?php }?>
                        </table>
                        </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

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
<?php $this->load->view('backend/footer'); ?>
