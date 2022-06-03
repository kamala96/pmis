<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Mails List</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Mails List</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <!-- <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid"> -->
        <div class="row m-b-10">
                <div class="col-12" style="padding-left: 20px;">
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
                    <a href="<?php echo base_url() ?>Dashboard/dashboard_backoffice" class="btn btn-primary"><i class=""></i> Back To Dashboard</a>
                    <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="" class="text-white"><i class="" aria-hidden="true"></i> Rental Box List</a></button> -->
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Mails List From Counter                      
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                                <div class="table-responsive m-t-20">
                                    <form action="<?php echo base_url('Billing/update_mails_status')?>" method="POST">
                            <table id="example4" class="table table-bordered table-striped text-nowrap" style="width: 100%;" cellspacing="4" cellpadding="4">
                                
                                <thead>
                                <tr>
                                    <th>Item Category</th>
                                    <th>Sub Category</th>
                                    <th>Destination</th>
                                    <th>Item Status</th>
                                    <th style="text-align: center;"></th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <th colspan="4"></th>
                                    <th style="text-align: center;">
                                        <div class="form-check">
                                            <label class="form-check-label" for="remember-me">Select All</label><br>
                                                     <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                                 </div>
                                                 <br>
                                        <button class="btn btn-sm btn-info" type="Submit">Submit</button></th>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($mails as $value): ?>
                                    <tr>
                                        <td><?php echo $value->item_category;?></td>
                                        <td><?php echo $value->sub_category;?></td>
                                        <td><?php echo $value->region_name;?></td>
                                        <td><?php echo $value->item_status;?></td>
                                        <td style="text-align: center;">
                                            
                                                <?php if ($value->item_status != 'Pending') {?>
                                                    <div class="form-check" class="form-check-input">
                                                   <input type="checkbox"  class="form-check-input" checked="checked" disabled="disabled">
                                                   </div>
                                               <?php }else{ ?>
                                                <div class="form-check" class="form-check-input">
                     <input type="checkbox" name="id[]" class="form-check-input checkSingle" id="remember-me" value="<?php echo $value->item_id?>">
                     <input type="hidden" name="status[]" value="<?php echo $value->item_status?>">
                     </div>
                 <?php }?>
                     
                  
             </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                   
                                </tbody>
                                
                            </table>
                            </form>
                        </div>
                            </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

            if ($('#boxcategory').val() == '--Select Category--') {
                $('#error2').html('Please Select PostBox Category');
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
        $('#div2').hide();
        $('#div3').show();
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });
});

//save data to databse
$('#btn_save').on('click',function(){
            var boxtype  = $('#boxtype').val();
            var fname   = $('#fname').val();
            var mname   = $('#mname').val();
            var lname   = $('#lname').val();
            var gender   = $('#gender').val();
            var occu     = $('#occu').val();
            var region   = $('#regionp').val();
            var district   = $('#branchdropp').val();
            var email   = $('#email').val();
            var phone   = $('#phone').val();
            var mobile   = $('#mobile').val();
            var residence   = $('#residence').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/Register_Box_Action')?>",
                dataType : "JSON",
                data : {boxtype:boxtype,fname:fname,mname:mname,lname:lname,gender:gender,occu:occu,region:region,district:district,email:email,phone:phone,mobile:mobile,residence:residence},
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
        });


</script>

<script type="text/javascript">
        function getDistrict() {
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
        function getTariffCategory() {
    var val = $('#tariff').val();
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
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
            $('#example4 thead tr:eq(1) th').not(":eq(4)").each( function (i) {
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
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>

<?php $this->load->view('backend/footer'); ?>

