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
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum_Bill_Customer_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?>  Customer List </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Pcum_Bill_Transactions_List" class="text-white"><i class="" aria-hidden="true"></i> <?php echo $this->session->userdata('heading') ?> Transactions List</a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><?php echo $this->session->userdata('heading'); ?> Transactions List
                        </h4>
                    </div>

                    <form action="Pcum_Bill_Transactions_List?I=<?php echo base64_encode($I); ?>" method="POST">
                    <div class="row">
                        <div class="col-md-12">
                        
                    <table class="table table-bordered">
                              <tr>
                                <th><input type="text" name="date" class="form-control mydatetimepickerFull"></th>
                                <th><input type="text" name="month" class="form-control mydatetimepicker"></th>
                                 <th><button class="btn btn-info" type="submit" name="search" value="search">Search</button></th>
                              </tr>
                            </table>
                       </div>
                    </div>
                    <div class="card-body table-responsive">
                           <table class="table table-bordered International" width="100%" style="">
                               <thead>
                                   <th>Sender Name</th>
                                   <th>Receiver Name</th>
                                   <th>Registered date</th>
                                   <th>Track Number</th>
                                   <th>Amount(Tsh)</th>
                                   <th>Weight</th>
                                   <th>Region Origin</th>
                                   <th>Destination</th>
                                   <!-- <th>Bill Number</th>
                                   <th>Tracking Number</th> -->
                               </thead>
                               <tbody>
                                   <?php foreach ($cargo as $value) { ?>
                                       <tr>
                                           <td><?php echo $value->s_fullname; ?></td>
                                           <td><?php echo $value->fullname; ?></td>
                                             <td><?php echo $value->date_registered; ?></td>
                                              <td><?php echo $value->track_number; ?></td>
                                           <td><?php echo number_format($value->amount,2); ?></td>
                                           <td><?php echo $value->weight; ?></td>
                                           <td><?php echo $value->s_region; ?></td>
                                           <td><?php echo $value->branch; ?></td>
                                           <!-- <td>
                                            <?php
                                               echo $value->billid; 
                                             ?> 
                                           </td>
                                           <td><?php echo $value->track_number; ?></td> -->
                                           
                                       </tr>
                                   <?php } ?>
                               </tbody>
                               <?php if(!empty($sum)){ ?>
                                <tfoot>
                                 <tr>
                                   <td colspan="2"></td>
                                   <td><?php echo number_format(@$sum->total,2); ?></td>
                                   <td colspan="2"></td>
                                   <td colspan="">
                                    <?php if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN"){ ?>
                                    <a href="invoice_sheet?acc_no=<?php echo $I; ?>&&month=<?php echo $month; ?>" class="btn btn-info">Generate Invoice</a>
                                  <?php } ?>
                                  </td>
                                 </tr>
                               </tfoot>
                               <?php }?>
                               
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
