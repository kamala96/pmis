<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Billing List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Ems Billing List</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                     <a href="<?php echo base_url() ?>Box_Application/EMS_Billing" class="btn btn-primary"><i class="fa fa-plus"></i> Add Company</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/ems_billing_list" class="text-white"><i class="" aria-hidden="true"></i> EMS BIlling Companies List</a></button>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Ems Billing List                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div class="table-responsive">
                             <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Control Number</th>
                                                <th>Amount</th>
                                                <th>Invoice Date</th>
                                                <!-- <th>Bill Date Created</th> -->
                                                <th>Invoice Details</th>
                                                <th>Receipt Number</th>
                                                <th>Date Payment</th>
                                                <th>Billing Status</th>
                                                <th>Action</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                 <tbody class="results">
                                 <?php foreach ($billing as  $value) {?>
                                      <tr>
                                      <td><?php 
                                            
                                      //echo $value->billid;
                                      ?></td>
                                      <td><?php echo number_format($value->paidamount,2);?></td>
                                      <td><?php echo @$value->invoice_date;?></td>
                                      <!-- <td><?php echo $value->transactiondate;?></td> -->
                                      <td><?php echo @$value->invoice_details;?></td>
                                      <td><?php echo $value->receipt; ?></td>
                                      <td><?php echo $value->paymentdate; ?></td>
                                      <td>
                                        <?php 
                                            if ($value->status == 'Paid') {
                                                echo "<button class = 'btn btn-success'>Paid</button>";
                                            }else{
                                                echo "<button class = 'btn btn-danger'>Not Paid</button>";
                                            }
                                        ?>
                                      </td>
                                      <td><a href="<?php echo base_url()?>Box_Application/invoice_sheet?cn=<?php echo $value->billid;?> && cun=<?php echo $value->invcust_id; ?>" class="btn btn-primary">Invoice Sheet</a></td>
                                    </tr>
                                 <?php } ?>
                                       
                                 </tbody>
                                    </table>
                                    </div>
                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

                </div>
           
            </div>
        </div>
<div class="modal fade" id="myModal" role="dialog" style="padding-top: 300px;">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <form role="form" action="issuepayment" method="post">
        <div class="modal-body">
            <h3>Please Enter Amount</h3>
            <div class="row">
                <div class="col-md-12">
                    <input type="number" name="amount" class="form-control" required="">
                </div>
            </div>
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
            <input type="hidden" name="id" id="comid">
            <button type="submit" class="btn btn-default pull-left"><span class="glyphicon glyphicon-remove"></span>Yes</button>
         <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
        </div>
        </form>
        </div>
        <div class="modal-footer">
            
        </div>
    
      </div>
    </div>
<script>
$(document).ready(function(){
  $(".myBtn").click(function(){
    
    var text1 = $('#leaveId').val();
    // var text2 = $('#idem').val();
    // var text3 = $('#idday').val();
    $('#comid').val(text1);
    // $('#emid').val(text2);
    // $('#day').val(text3);
    $("#myModal").modal();
  });
});
</script>
<script type="text/javascript">
    $('#boxtype').on('change', function() {
        if ($('#boxtype').val() == 'Individual') {
            $('#indv').show();
            $('#sectors').hide();
            $('#error1').html('');
        }if ($('#boxtype').val() == 'Government Ministries and Large Business/Inst.') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Government Department') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Religious/Education Inst,Small Business and NGOs') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }if ($('#boxtype').val() == 'Primary Schools') {
            $('#sectors').show();
            $('#indv').hide();
            $('#error1').html('');
            $('#results').html($('#boxtype').val());
        }
    
    //$('#showdiv' + this.value).show();
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
        }else if($('#regionp').val() == ''){
            $('#errregion').html('This field is required');
        }else if($('#branchdropp').val() == ''){
            $('#errdistrict').html('This field is required');
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

//save data to databse
$('#btn_save').on('click',function(){
    
            var emstype   = $('#boxtype').val();
            var emsCat = $('#tariffCat').val();
            var weight = $('#weight').val();
            var s_fname     = $('#s_fname').val();
            var s_address     = $('#s_address').val();
            var s_email     = $('#s_email').val();
            var s_mobile    = $('#s_mobile').val();
            var regionp      = $('#branchdropp').val();
            var branchdropp    = $('#regionp').val();
            var r_fname   = $('#r_fname').val();
            var r_address     = $('#r_address').val();
            var r_email     = $('#r_email').val();
            var r_mobile    = $('#r_mobile').val();
            var rec_region   = $('#rec_region').val();
            var rec_dropp         = $('#rec_dropp').val();

            if (r_fname == '') {
            $('#error_fname').html('This field is required');
            }else if(r_address == ''){
            $('#error_address').html('This field is required');
             }else if(r_mobile == ''){
            $('#error_mobile').html('This field is required');
            }else if(rec_region == 0){
            $('#error_region').html('This field is required');
            }else if(rec_dropp == 0){
            $('#error_district').html('This field is required');
            }else{
                
             $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : {emstype:emstype,emsCat:emsCat,weight:weight,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,regionp:regionp,branchdropp:branchdropp,r_fname:r_fname,r_address:r_address,r_mobile:r_mobile,r_email:r_email,rec_region:rec_region,rec_dropp:rec_dropp},
                 success: function(data){

                     $('[name="vehicle_no"]').val("");
                     $('[name="vehicle_id"]').val("");

                     $('#div4').show();
                     $('#div3').hide();
                     $('#majibu').html(data);
                    /// $('#Modal_Edit').modal('hide');
                     show_product();
                 }
             });
             return false;
        }
        });


</script>
<script type="text/javascript">
        function getCustomer() {

    var val = $('#box').val();
    if (val == 'Renewal Box') {

        $('#box1').show();
    }else{
         $('#box1').hide()
    }
     
};
</script>
<script type="text/javascript">
        function getSenderDistrict() {
    var val = $('#regionp').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
        function getRecDistrict() {
    var val = $('#rec_region').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#rec_dropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
     function getTariffCategory() {

     var val = $('#boxtype').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Box_Application/GetTariffCategory",
     data:'bt_id='+ val,
     success: function(data){
        $('#tariffCat').html(data);
        $('#indv').show();
        $('#error1').html('');
     }
 });
};
</script>
<script type="text/javascript">
    $(document).ready(function(){
        show_product(); //call function show all product


        //function show all product
        function show_product(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('products/recep_info')?>',
                async : true,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                            '<td>'+data[i].name+'</td>'+
                            '<td>'+data[i].mobile+'</td>'+
                            '<td>'+data[i].email+'</td>'+
                            '<td>'+data[i].country+'</td>'+
                            //'<td>'+data[i].centigrade+'</td>'+
                            //'<td>'+data[i].qrcode_image+'</td>'+
                            //'<td>'+data[i].status+'</td>'+
                            //'<td><a href="">'+data[i].DriverId+'</a></td>'+
                            //'<td><a href="">'+data[i].destinationId+'</a></td>'+
                            '</tr>';
                    }
                    $('#show_data').html(html);
                    $('#roles1').dataTable().clear();
                    $('#roles1').dataTable().draw();
                }

            });
        }

        
    });

</script>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
     // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
     // $('#example4 thead tr:eq(1) th').each( function (i) {
     //     var title = $(this).text();
     //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );
 
     //     $( 'input', this ).on( 'keyup change', function () {
     //         if ( table.column(i).search() !== this.value ) {
     //             table
     //                .column(i)
     //                 .search( this.value )
     //                 .draw();
     //        }
     //    } );
     // } );
 
    var table = $('#example4').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        order: [[3,"desc" ]],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<?php $this->load->view('backend/footer'); ?>

