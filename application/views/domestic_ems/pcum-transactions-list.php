<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> <?php echo $this->session->userdata('heading'); ?></h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"><?php echo $this->session->userdata('heading'); ?></li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Form</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/bulk_pcum" class="text-white"> Bulk <i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transaction</a></button>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum_Transactions_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Incoming_Item?AskFor=PCUM" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Incoming Item To Deliver</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo $this->session->userdata('heading'); ?> Transactions List
                        </h4>
                    </div>

                    <form action="Pcum_Transactions_List" method="POST" autocomplete="off">
                    <div class="row">
                        <div class="col-md-12">
                        
                    <table class="table table-bordered">
                              <tr>
                                <th><input placeholder="From date" type="text" name="fromdate" class="form-control mydatetimepickerFull"></th>
                                <th><input placeholder="To date" type="text" name="todate" class="form-control mydatetimepickerFull"></th>
                                <th><select class="form-control custom-select" name="status" required="required">
                                  <option value="">--Select Status--</option>
                                  <option>Paid</option>
                                  <option>NotPaid</option>
                                </select></th>
                                 <th><button class="btn btn-info" type="submit" name="search" value="search">Search</button></th>
                              </tr>
                            </table>
                       </div>
                    </div>
                      </form>

                        <form action="Pcum_Sent_delivery" method="POST">
                    <div class="card-body table-responsive">
                           <table class="table table-bordered International" width="100%" style="">
                               <thead>
                                   <th>Operator</th>
                                    <th>Sender Name</th>
                                   <th>Receiver Name</th>
                                   <th>Registered date</th>
                                   <th>Amount(Tsh)</th>
                                   <th>Weight</th>
                                   <th>Region Origin</th>
                                   <th>Branch Origin</th>
                                   <th>Destination</th>
                                   <th>Receiver Box Type</th>
                                   <th>Bill Number</th>
                                   <th>Tracking Number</th>
                                   <th>Barcode Number</th>
                                   <th>Payment Status</th>
                                   <th>Payment Channel</th>
                                   <th>
                                <div class="form-check" style="padding-left:50px;" id="showCheck">
                                <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                <label class="form-check-label" for="remember-me">All</label>
                                </div>
                                    </th>
                               </thead>
                               <tbody>
                                   <?php foreach ($cargo as $value) { ?>
                                       <tr>
                                           <td><?php 
                                           $emd =$value->operator;
                                           $getInfo = $this->employee_model->GetBasic($emd);
                                                  echo 'PF.'.$getInfo->em_code.' '.$getInfo->first_name;
                                                  ?></td>
                                            <td><?php echo $value->s_fullname; ?></td>
                                           <td><?php echo $value->fullname; ?></td>
                                           <td><?php echo $value->date_registered; ?></td>
                                           <td><?php echo number_format($value->paidamount,2); ?></td>
                                           <td><?php echo $value->weight; ?></td>
                                           <td><?php echo $value->s_region; ?></td>
                                           <td><?php echo $value->s_district; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <td><?php echo $value->receiverboxtype; ?></td>
                                           <td>
                                            <?php
                                               echo $value->billid; 
                                             ?> 
                                           </td>
                                           <td><?php echo $value->track_number; ?></td>
                                            <td><?php echo $value->Barcode; ?></td>
                                           <td><?php if($value->status == 'NotPaid'){?>
                                                <button class="btn btn-danger btn-sm" disabled="disabled">NOT PAID</button>
                                               <?php }else{?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">PAID</button>
                                               <?php } ?>
                                           </td>
                                            <td><?php echo $value->paychannel; ?></td>
                                             <?php if($this->session->userdata('user_type') == "ACCOUNTANT"){?>
                                <?php }else{ ?>
                                    <td style = "text-align:center;">
                        <div class="form-check">"
                        <?php
                        if ($value->s_pay_type == "Cash") {
                            if ($value->status == 'Paid' && $value->office_name == 'Counter'){
                        echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }elseif($value->status == 'Bill' && $value->office_name == 'Counter'){
                          echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                        }else{
                             echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
                            <label class='form-check-label' for='remember-me'></label>";
                        }
                        } else {
                           if ($value->s_pay_type != 'Cash' && $value->office_name == 'Counter'){
                        echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle' id='remember-me' value='$value->id'>
                            <label class='form-check-label' for='remember-me'></label>";
                       
                        }else{
                             echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
                            <label class='form-check-label' for='remember-me'></label>";
                        }
                        }
                        
                        ?>
                        </div>
                        </td>
                                       </tr>
                                   <?php }} ?>
                               </tbody>

                               <tfoot>
  <?php if($this->session->userdata('status') != "Assign" && $this->session->userdata('user_type') == "EMPLOYEE"){?>
    <tr>
    <td colspan="14">
    <?php if(empty($emslist)){?>
        <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: right;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift">Sent For Delivery >>></button></span>
    <?php }else{ ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;
        <span ><b>Total Amount ::</b>&nbsp;&nbsp;</span>
    <?php echo number_format($sum->paidamount,2);?>
      <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: left;"><button type="submit" class="btn btn-info endshift" name="endshift" value="EndShift" disabled="disabled">End Shift >>></button></span>
    <span style="float: right;"><button type="submit" class="btn btn-info" disabled="disabled">Back Office >>></button>
    <button type="submit" class="btn btn-info" disabled="disabled" name="qr" value="qrcode">Print QR Code >>></button></span>
    <?php }?>
 </td>
</tr>
  <?php }else{?>
    <?php if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM"){?>
        <tr>
            <td>&nbsp;</td>
             <td>&nbsp;</td>
             <td style="font-size: 20px;"><text><b>Total Amount::</b></text></td>
              <td style="font-size: 20px;"><b> <?php echo number_format(@$sum->paidamount,2);?></b></td>
                <td>&nbsp;</td>
                 <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                   <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                   <td>&nbsp;</td>
                     <td>&nbsp;</td>
        </tr>
        <?PHP }else{?>
             <tr>
    
    <td colspan="16">
   
        <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
      <span style="float: right;"><button type="submit" class="btn btn-info endshift" name="endshift" value="delivery">Sent For Delivery >>></button></span>
    
 </td>
</tr>
        <?php } ?>
   
  <?php }   ?>

</tfoot>
                              <!--  <tfoot>
                                   <tr><td colspan="">&nbsp;</td>
                                  
                                   <td colspan=""></td>
                                   <td colspan=""></td>
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
                                   </tr>
                               </tfoot> -->
                           </table>
                           </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

<script>
function getPriceFrom() {

 var weight = $('.catweight').val();
 var tariffCat  = $('.catid').val();
 var emstype  = $('.boxtype').val();

 if (weight == '') {

 }else{

     $.ajax({
                  type : "POST",
                  url  : "<?php echo base_url('Box_Application/Ems_price_vat_international')?>",
                  //dataType : "JSON",
                  data : {weight:weight,tariffCat:tariffCat,emstype:emstype},
                  success: function(data){
                     $('.price').html(data);
                  }
              });
        }

    }
</script>
<script type="text/javascript">
function getEMSType() {


 var tariffCat = $('.catid').val();
 var weight = $('.catweight').val();
 var emstype  = $('.boxtype').val();

 if (weight == '') {

 }else{

     $.ajax({
                  type : "POST",
                  url  : "<?php echo base_url('Box_Application/Ems_price_vat_international')?>",
                  //dataType : "JSON",
                  data : {weight:weight,tariffCat:tariffCat,emstype:emstype},
                  success: function(data){
                     $('.price').html(data);
                  }
              });
 }

};
function getPriceForm(){

};
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
    $("#checkAll3").change(function() {
        if (this.checked) {
            $(".checkSingle3").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle3").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle3").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle3").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll3").prop("checked", true);
            }
        }
        else {
            $("#checkAll3").prop("checked", false);
        }
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){

        if ($('#boxtype').val() == 0) {
                $('#error1').html('Please Select PostBox Type');
        }else{

            if ($('#tariffCat').val() == 0) {
                $('#error2').html('Please Select Ems tariff Category Type');
            }else if($('#weight').val() == ''){
                $('#weight_error').html('This field is required');
            }else{
                $('#div2').show();
                $('#div1').hide();
            }
        }
  });
        $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
        $('#2step').on('click',function(){
        if ($('#s_fname').val() == '') {
            $('#errfname').html('This field is required');
        }else if($('#s_mobile').val() == ''){
            $('#errmobile').html('This field is required');

        }else{
        $('#div2').hide();
        $('#div3').show();
        }
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });
});

</script>
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

<?php $this->load->view('backend/footer'); ?>
