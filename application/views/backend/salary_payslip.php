<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Salary Payslip</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Salary Payslip</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regvalue = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
                    <a href="<?php echo base_url() ?>Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>
                    <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button> -->
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Salary Payslip                        
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <input type="hidden" name="salaryID" id="salaryID" value="<?php
                                $id = $basic->em_id;
                                $sid = $this->payroll_model->Get_SalaryID1($id);
                                echo @$sid->id;
                             ?>">
                            <input type="hidden" id="em_code" name="em_code" value="<?php echo $basic->em_id; ?>">
                            <table class="table" style="width: 100%;">
                                <tr>
                                    <td><select class="custom-select form-control" name="month" required="required" id="month">
                                        <option value="">--Select Salary Payslip Month--</option>
                                        <option>January</option>
                                        <option>February</option>
                                        <option>March</option>
                                        <option>April</option>
                                        <option>May</option>
                                        <option>June</option>
                                        <option>July</option>
                                        <option>August</option>
                                        <option>September</option>
                                        <option>October</option>
                                        <option>November</option>
                                        <option>December</option>
                                    </select></td>
                                    <td><select id="years" class="form-control custom-select" name="year">
                                        <option>--Select Salary Payslip Year--</option>
                                    </select></td>
                                    <td><button type="submit" class="btn btn-info" id="BtnSubmit">Filter Salary Payslip</button></td>
                                </tr>
                            </table>
                        </form>
                        <div id="salary"></div>
                    </div>
                </div>
            </div>
        </div>


                     
<?php $this->load->view('backend/footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(8)").each( function (i) {
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

<script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 2019; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
    </script>

    <script>
        // Populate the payroll table to generate the payroll for each individual
      $("#BtnSubmit").on("click", function(event){
        event.preventDefault();
         var em_code = $('#em_code').val();
         var month   = $('#month').val();
         var year    = $('#years').val();
         var salaryID    = $('#salaryID').val();
         var salaryID    = $('#salaryID').val();
        $.ajax({
           url: "<?php echo base_url();?>Payroll/Search?em_code="+em_code+"&month="+month+"&year="+year+"&salaryID="+salaryID,
           type:"GET",
           dataType:'',
           data:'data',          
          success: function(response) {
             // console.log(response);
             
             $('#salary').html(response);
           },
           error: function(response) {
            
           }
         });
      });
    </script>