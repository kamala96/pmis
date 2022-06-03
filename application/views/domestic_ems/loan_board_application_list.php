<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Loan Board Application List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Loan Board Application List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Loan_Board/Loan_info" class="text-white"><i class="" aria-hidden="true"></i>Add Heslb Application</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Loan_Board/loan_board_transactions_list" class="text-white"><i class="" aria-hidden="true"></i> Heslb Application List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Loan Board Application List
                        </h4>
                    </div>
                    <div class="card-body">
                      <form action="loan_board_transactions_list" method="POST">
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
                      <div class="table-responsive">
                           <table class="table table-bordered International" width="100%" style="">
                               <thead>
                                   <th>Sender Name</th>
                                   <th>Registered date</th>
                                   <th>Amount(Tsh)</th>
                                   <th>EMS Type</th>
                                   <th>Weight</th>
                                   <th>Address Type</th>
                                   <th>Region Origin</th>
                                   <th>Branch Origin</th>
                                   <th>Destination</th>
                                   <th>Bill Number</th>
                                   <th>Tracking Number</th>
                                   <th>Barcode Number</th>
                                   <th>Payment Status</th>
                                   <th>Payment Channel</th>
                               </thead>
                               <tbody>
                                   <?php foreach (@$inter as $value) { ?>
                                       <tr>
                                           <td><?php echo $value->s_fullname; ?></td>
                                           <td><?php echo $value->date_registered; ?></td>
                                           <td><?php echo number_format($value->paidamount,2); ?></td>
                                           <td><?php echo $value->ems_type; ?></td>
                                           <td><?php echo $value->weight; ?></td>
                                           <td><?php echo $value->add_type; ?></td>
                                           <td><?php echo $value->s_region; ?></td>
                                           <td><?php echo $value->s_district; ?></td>
                                           <td><?php echo $value->r_region; ?></td>
                                           <td><?php
                                            echo $value->billid;
                                               
                                            ?>
                                           </td>
                                           <td><?php echo $value->track_number; ?></td>
                                           <td><?php echo @$value->Barcode; ?></td>
                                           <td><?php if($value->status == 'NotPaid'){?>

                                            <a href="<?php echo base_url('Loan_Board/updateControlNumber/'.$value->serial);?>" class="btn btn-danger btn-sm"><i class="fa fa fa-bars"></i> NOT PAID</a>

                                                <!-- <button class="btn btn-danger btn-sm" disabled="disabled">NOT PAID</button> -->

                                               <?php }else{?>
                                                <button class="btn btn-success btn-sm" disabled="disabled">PAID</button>
                                               <?php } ?>
                                           </td>
                                           <td><?php echo $value->paychannel; ?></td>
                                       </tr>
                                   <?php } ?>
                               </tbody>
                               <tfoot>
                                   <tr><td colspan="">&nbsp;</td>
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
                                   <td colspan=""></td>
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
