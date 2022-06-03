<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Small Packets Delivery Transaction List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Small Packets Delivery Transaction List</li>
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
                   <?php if($this->session->userdata('user_type') =='ACCOUNTANT' 
                  || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ ?>
               
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/small_packet_deriver_application_list" class="text-white"><i class="" aria-hidden="true"></i> Small Packet Delivery Transactions List</a></button>

<?php }else{?>
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/small_packet_derivery_form" class="text-white"><i class="" aria-hidden="true"></i> Small Packet Delivery Transaction</a></button>
               
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/small_packet_deriver_application_list" class="text-white"><i class="" aria-hidden="true"></i> Small Packet Delivery Transactions List</a></button>
                    <?php }?>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                    <h4 class="m-b-0 text-white"> Small Packets Delivery Transaction List
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
                          <form action="register_application_list" method="POST">
                            <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              
                              <tr style="background-color: oblique;">
                              <th>Customer Name</th>
                              <th>Date Registered</th>
                              <th>Price</th>
                              <th>Region Origin</th>
                              <th>Branch</th>
                              <th>Control No</th>
                              <th>Pay Status</th>
                              
                            </tr>
                          </thead>
                          
                        <tbody>
                            <?php foreach ($list as $value) {?>
                                <tr>
                                    <td><?php echo $value->customer_name; ?></td>
                                    <td><?php echo $value->datetime; ?></td>
                                    <td><?php echo number_format($value->amount,2); ?></td>
                                    <td><?php echo $value->region; ?></td>
                                    <td><?php echo $value->branch; ?></td>
                                    <td><?php  $paidamount=$value->paidamount;
                                            $serial=$value->serial;
                                             $this->Box_Application_model->getBillPayment($serial,$paidamount);echo $value->billid;?></td>
                                     
                                    <td><?php if( $value->status == "Paid"){?>
                                        <button class="btn btn-success btn-sm" disabled="disabled">Paid Amt</button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Not Paid</button>
                                        <?php } ?>
                                    </td>
                                    
                                </tr>
                           <?php } ?>
                        </tbody>
                     <tfoot>
                            <tr>
                              <td colspan="2" style="text-align: right;"><b>Total Price::</b></td>
                            
                            <td><?php echo number_format(@$sum->paidamount,2); ?></td>
                            <td colspan="4"></td>
                            </tr>
                            
                            
                        </tfoot>
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
