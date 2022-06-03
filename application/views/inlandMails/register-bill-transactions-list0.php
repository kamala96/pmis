<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Register Bill Transaction List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Register Bill Transaction List</li>
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
                  <?php if($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "AGENT"){ ?>
                         
                    <?php //if(@$askfor == "MAILS"){ ?>
                      <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Customer List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button>
                   <?php// }else{ ?>
                    <!-- <button type="button" class="btn btn-primary"><i class="fa fa-th-list"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Bill Register Customer List</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_form" class="text-white"><i class="" aria-hidden="true"></i> Add Cash Register Customer</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/register_application_list" class="text-white"><i class="" aria-hidden="true"></i> Register Cash Transactions List</a></button> -->
                   <?php// }?>
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Bill_Customer/bill_customer_form?AskFor=<?php echo $askfor;  ?>" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Register Customer</a></button>

                    <?php //if(@$askfor == "MAILS"){ ?>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Bill_Customer/register_bill_transaction_list?AskFor=<?php echo $askfor;?>" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button>
                   <?php// }else{ ?>
                    <!-- <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_form" class="text-white"><i class="" aria-hidden="true"></i> Add Cash Register Customer</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/register_application_list" class="text-white"><i class="" aria-hidden="true"></i> Register Cash Transactions List</a></button> -->
                   <?php// }?>

                   <?php } ?>
                   
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                    <h4 class="m-b-0 text-white"> Registered Transaction List
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
                          <form action="register_bill_transaction_list" method="POST">
                            <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              
                             <tr style="background-color: oblique;">
                              <th>Sender Name</th>
                              <th>Date Registered</th>
                              <th>Register Type</th>
                              <th>Weight</th>
                              <th>Price</th>
                              <th>Payment Type</th>
                              <th>Region Origin</th>
                              <th>Destination</th>
                             <!--  <th>Control No</th> -->
                              <th>Track No.</th>
                              <th>Item Status</th>
                              <!-- <th>Pay Status</th> -->
                              <th><div class="form-check" style="text-align: center;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                   <label class="form-check-label" for="remember-me"></label>
                                 </div></th>
                            </tr>
                          </thead>
                          
                        <tbody>
                            <?php foreach ($list as $value) {?>
                                <tr>
                                    <td><?php echo $value->sender_fullname; ?></td>
                                    <td><?php echo $value->sender_date_created; ?></td>
                                    <td><?php echo $value->register_type; ?></td>
                                    <td><?php echo $value->register_weght; ?></td>
                                    <td><?php echo number_format($value->register_price,2); ?></td>
                                    <td><?php echo $value->payment_type; ?></td>
                                    <td><?php echo $value->sender_region; ?></td>
                                    <td><?php echo $value->receiver_region; ?></td>
                                    <!-- <td><?php echo $value->billid; ?></td> -->
                                    <td><?php echo $value->track_number; ?></td>
                                    <td><?php if( $value->sender_status == "Counter"){?>
                                        <button class="btn btn-primary btn-sm" disabled="disabled">Front Office</button>
                                        <?php }if($value->sender_status == "Back"){ ?>
                                            <button class="btn btn-default btn-sm" disabled="disabled">Back Office</button>
                                        <?php }if($value->sender_status == "Bag"){ ?>
                                            <button class="btn btn-info btn-sm" disabled="disabled">Is In Bag</button>
                                        <?php }if($value->sender_status == "Despatch"){ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Despatched</button>
                                         <?php }if($value->sender_status == "Received"){ ?>
                                            <button class="btn btn-success btn-sm" disabled="disabled">Despatched</button>
                                        <?php }if($value->sender_status == "Derivery"){ ?>
                                            <button class="btn btn-warning btn-sm" disabled="disabled">Derived</button>
                                             <?php }if($value->sender_status == "BackReceive"){ ?>
                                            <button class="btn btn-warning btn-sm" disabled="disabled">Received Back Office</button>
                                        <?php } ?>
                                    </td>
                                    <!-- <td><?php if( $value->status == "Paid"){?>
                                        <button class="btn btn-success btn-sm" disabled="disabled">Paid Amt</button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Not Paid</button>
                                        <?php } ?>
                                    </td> -->
                                    <td >
                                        <div class='form-check' style="text-align: center;">
                                        <?php if( $value->sender_status == "Counter"){?>
                                        <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $value->senderp_id; ?>'>
                                        <label class='form-check-label' for='remember-me'></label>
                                        <?php }else{ ?>
                                          <input type='checkbox' class='form-check-input checkSingles' id='remember-me' checked="checked" disabled="disabled">
                                        <label class='form-check-label' for='remember-me'></label>
                                        <?php } ?>
                                         
                                    </div>
                                    </td>
                                </tr>
                           <?php } ?>
                        </tbody>
                        <?php if(empty($list)){ ?>
                        <?php }else{ ?>
                          <tfoot>
                            <td><button class="btn btn-danger btn-sm" name="shiftend" value="shiftend">Shift End</button></td>
                            <td colspan="3" style="text-align: right;"><b>Total Price::</b></td>
                            
                            <td><?php echo number_format($sum->paidamount,2); ?></td>
                            <td colspan="5"></td>
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
