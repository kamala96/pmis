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



                          <form action="find_small_packet_deriver_application_list" method="POST">
                             <table class="table table-bordered">
                              <tr>
                                <th><input type="text" name="fromdate" class="form-control mydatetimepickerFull" placeholder="From Date" required></th>
                                <th><input type="text" name="todate" class="form-control mydatetimepickerFull" placeholder="To Date" required></th>
                                

                                <!--<th><select class="form-control custom-select" name="status">
                                  <option value="">--Select Status--</option>
                                  <option>Paid</option>
                                  <option>NotPaid</option>
                                </select></th>
                                 <th>
                                   <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "SUPER ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                                    <select class="form-control custom-select" name="region">
                                      <option value="">--Select Region-</option>
                                      <?php foreach ($region as $value) { ?>
                                        <option><?php echo $value->region_name ?></option>
                                      <?php } ?>
                                    </select>
                                  <?php }?>

                                   
                                 </th>-->



                                 <th><button class="btn btn-info" type="submit" name="search" value="search">Search</button></th>
                              </tr>
                            </table>

                          </form>




                          <?php if(isset($list)){?>

                          <form action="register_application_list" method="POST">
                            <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
                              
                              <tr style="background-color: oblique;">
                              <th>S/N</th>
                              <th>Customer Name</th>
                              <th>Date Registered</th>
                              <th>Price</th>
                              <th>Region Origin</th>
                              <th>Branch</th>
                              <th>Barcode</th>
                              <th>Payment Channel</th>
                              <th>Control No</th>
                              <th>Pay Status</th>
                              
                            </tr>
                          </thead>
                          
                        <tbody>
                            <?php $sumamount =0; $sn=1; foreach ($list as $value) {?>
                                <tr>
                                   <td><?php echo $sn; ?></td>
                                    <td><?php echo $value->customer_name; ?></td>
                                    <td><?php echo $value->datetime; ?></td>
                                    <td><?php echo number_format($value->amount,2); ?></td>
                                    <td><?php echo $value->region; ?></td>
                                    <td><?php echo $value->branch; ?></td>
                                    <td><?php echo @$value->Barcode; ?></td>
                                     <td><?php echo $value->paychannel; ?></td>
                                    <td><?php  $paidamount=$value->paidamount;
                                            //$serial=$value->serial;
                                            //$this->Box_Application_model->getBillPayment($serial,$paidamount);
                                            // echo $value->billid;?>

<a href="#myModal" class="btn btn-sm" data-toggle="modal" data-code='<?php echo number_format($value->paidamount,2);  ?>'
                                              data-serial="<?php echo $value->billid; ?>" data-company="<?php echo $value->billid; ?>">
                                              <?php echo $value->billid; ?>
                                                
                                              </a>
                                              </td>
                                     
                                    <td><?php if( $value->status == "Paid"){?>
                                        <button class="btn btn-success btn-sm" disabled="disabled">Paid </button>
                                        <?php }else{ ?>
                                            <button class="btn btn-danger btn-sm" disabled="disabled">Not Paid</button>
                                        <?php } ?>
                                    </td>
                                    
                                </tr>
                           <?php $sn++; @$sumamount+=@$value->amount; } ?>
                        </tbody>
                     <tfoot>
                            <tr>
                              <td colspan="3" style="text-align: right;"><b>Total Price::</b></td>
                            
                            <td><?php echo number_format(@$sumamount,2); ?></td>
                            <td colspan="6"></td>
                            </tr>
                            
                            
                        </tfoot>
                        </table>
                        </form>
                      <?php } ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>



      
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">
         <label >Control Number: </label><input type="text" id="company" readonly style="border: none;" />  
         <label >Amount : </label>  <input type="text" id="code" readonly />
         <!-- <label id="code" ></label>  &amp; <label id="company" ></label></h4> -->
      </div>
      <div class="modal-body">
        <div id="boxesdata">   </div>
        <!-- <input type="text" id="code" readonly />
        <input type="text" id="company" readonly /> -->
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  
$(function () {
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var code = button.data('code'); // Extract info from data-* attributes
    var company = button.data('company'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var serial = button.data('serial');
    //var serial = $('#regionp').val();
    $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Unregistered/GetOthersmallpacketsbulkdetails",
     data:'serial='+ serial,
     success: function(data){
         $("#boxesdata").html(data);
     }
 });
    var modal = $(this);
    modal.find('#code').val(code);
    modal.find('#company').val(company);
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
