<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems International Application List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems International Application List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_International/International_Ems" class="text-white"><i class="" aria-hidden="true"></i>Add Ems Application</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_International/Ems_International_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                </div>
        </div>

            <div class="row">
              <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
                </div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
            </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Ems International Application List
                        </h4>
                    </div>
                    <div class="card-body" >
                      <div class="col-md-12">
                        <form action="Ems_International_Application_List" method="POST">
                        <div class="input-group">
                          
                          <input type="text" name="date" class="form-control mydatetimepickerFull" placeholder="Select Date">
                          <input type="text" name="month" class="form-control mydatetimepicker" placeholder="Select Month">
                          <?php if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP" || $this->session->userdata('user_type') == "CRM" ){ ?>
                          <select class="form-control custom-select" name="region">
                            <option value="">--Select Region-</option>
                            <?php foreach ($region as $value) { ?>
                              <option><?php echo $value->region_name ?></option>
                            <?php } ?>
                          </select>
                        <?php }?>
                          <button type="submit" class="btn btn-info">Search</button>
                        </div>
                        </form>
                      </div>
                      <form action="Miscereneous" method="POST">
                        <div class="table table-responsive">
                           <table class="table table-bordered International text-nowrap" width="100%" style="text-transform: capitalize;">
                               <thead>
                                   <th>Sender Name</th>
                                   <th>Registered date</th>
                                   <th>Item Number(Barcode)</th>
                                   <th>Amount(Tsh)</th>
                                   <th>EMS Type</th>
                                   <th>Weight</th>
                                   <th>Region Origin</th>
                                   <th>Destination</th>
                                   <th>Bill Number</th>
                                   <th>Channel</th>
                                   <th>Pay Date</th>
                                   <th>Payment Status</th>
                                   <th style="text-align: center;padding-right: 28px;">
                                     <div class="form-check" style="padding-left:60px;" id="showCheck">
                                      <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                      <label class="form-check-label" for="remember-me">All</label>
                                      </div>
                                   </th>
                                   <th style="text-align: center;">
                                     <div class="form-check" style="padding-left:60px;" id="showCheck1">
                                      <input type="checkbox"  class="form-check-input" id="checkAll1" style="">
                                      <label class="form-check-label" for="remember-me">All</label>
                                      </div>
                                   </th>
                               </thead>
                               <tbody>
                                   <?php foreach ($inter as $value) { ?>
                                       <tr>
                                           <td><?php echo $value->s_fullname; ?></td>
                                           <td><?php echo $value->date_registered; ?></td>
                                             <td><?php echo $value->serial; ?></td>
                                           <td><?php echo number_format($value->paidamount,2); ?></td>
                                           <td><?php echo $value->ems_type; ?></td>
                                           <td><?php echo $value->weight; ?></td>
                                           <td><?php echo $value->s_region; ?></td>
                                           <td><?php echo $value->country_name; ?></td>
                                           <td>
                                            <?php 

                                                
                                                  $serial = $value->serial;
                                                $amount = $value->paidamount;
                                                $this->Box_Application_model->getUpdatePaymentInternational($serial,$amount);
                                                
                                                echo $value->billid;
                                           ?> 
                                           </td>
                                           <td><?php echo $value->paychannel; ?></td>
                                           <td><?php echo $value->paymentdate; ?></td>
                                           <td><?php if($value->status == 'NotPaid'){?>
                                                <button class="btn btn-danger btn-sm" disabled="disabled">NOT PAID</button>
                                               <?php }else{?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">PAID</button>
                                               <?php } ?>
                                           </td>
                                           <td style="text-align: center;padding-left: 28px;">
                                              <div class="form-check">"
                                                <?php
                                                if ($value->status == 'Paid' && $value->office_name == 'Counter'){
                                                echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                                                    <label class='form-check-label' for='remember-me'></label>";
                                                }elseif($value->status == 'Bill' && $value->office_name == 'Counter'){
                                                  echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                                                    <label class='form-check-label' for='remember-me'></label>";
                                                }else{
                                                     echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;'>
                                                    <label class='form-check-label' for='remember-me'></label>";
                                                }
                                                ?>
                                                </div>
                                           </td>
                                           <td style="text-align: center;"><input type="checkbox" name=""></td>
                                       </tr>
                                   <?php } ?>
                                   
                               </tbody>
                               <tfoot>
                                 <tr>
                                  <td colspan="" style="text-align: center;">
                                    <button  class="btn btn-info" name="endshift" value="endshift">End Shift >>></button></td>
                                   <td colspan="" style="text-align: right;">Total Amount</td>
                                   <td colspan=""><?php echo number_format($sum->paidamount,2); ?></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                   <td colspan=""></td>
                                    <td colspan="" style="text-align: center;"><button class="btn btn-info">Back Office >>></button></td>
                                    <td colspan="" style="text-align: center;"><button class="btn btn-info" type="submit" name="qr" value="qr">QR Code >>></button></td>
                                   </tr>
                               </tfoot>
                           </table>
                           </div>
                           </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
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

<?php $this->load->view('backend/footer'); ?>
