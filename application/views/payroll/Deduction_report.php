<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Payroll</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Payroll</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid"> 
                <div class="row m-b-10"> 
                    <div class="col-12">
<!--                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#TypeModal" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Add Payroll </a></button>-->
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Salary_List" class="text-white"><i class="" aria-hidden="true"></i>  Payroll Deduction List</a></button> -->
                    </div>
                </div> 

                <div class="row">

                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Deduction List                     
                                </h4>
                            </div>
                            
                            <div class="card-body">
                                 
                            <table class="table table-bordered" width="100%">
                                <form method="post" action="">
                                <tr>
                                    <td><select class="custom-select form-control" name="ded_type" required="required" id="ded_type">
                                        <option value="">--Select Type--</option>
                                                <option>KK REFUND</option>
                                                <option>SANLAM INSURANCE</option>
                                                <option>TEWUTA</option>
                                                <option>COTWU(T)</option>
                                                <option>KK SAVINGS</option>
                                                <option>W.A.D.U</option>
                                                <option>HOUSE RENT</option>
                                                <option>INSURANCE</option>
                                                <option>SALARY ARREARS</option>
                                                <option>ACTING ALLOWANCE</option>
                                                <option>FUEL ALLOWANCE</option>
                                                <option>PSSSF</option>
                                                <option>NHIF</option>
                                                <option>WCF</option>
                                                 <option>HESLB</option>
                                                <option>ZHESLB</option>
                                                <option>SHORT AND ACCESS</option>
                                                <option>HOUSE RECOVERY</option>
                                                <option>SALARY RECOVERY</option>
                                                <option>COURT ORDER</option>
                                                 <option>PURCHASE LOAN</option>
                                                <option>SUNDRY ALLOWANCE RECOVERY</option>
                                                <option>KK LOAN</option>
                                                <option>KK EMERGENCY LOAN</option>
                                                 <option>KK CHAPCHAP</option>
                                                <option>OVERTIME</option>
                                                <option>FUEL ALLOWANCE</option>
                                                <option>FUEL ALLOWANCE ARREAS</option>
                                                <option>TELEPHONE ALLOWANCE</option>
                                                <option>TELEPHONE ALLOWANCE ARREAS</option>

                                    </select></td>
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
                                    <td><button type="submit" class="btn btn-info" id="BtnSubmit">Generate Deduction Sheet </button></td>
                                </tr>
                                </form>
                            </table>
                        
            
  <div class="row">

                    <div class="col-12">
                      <div class="table-responsive display">
                                    <div id="salary">
                                    </div>
                                </div>
                            </div></div>


            
                            </div>
                        </div>
                    </div>
                </div>
                     <div class="row">

                    <div class="col-12">
                      <div class="table-responsive display">
                                    <div id="salary">
                                    </div>
                                </div>
                            </div></div>

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
         var month   = $('#month').val();
         var year    = $('#years').val();
         var ded_type    = $('#ded_type').val();
         if (ded_type == "") {

             $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Deduction_Report?month="+month+"&year="+year,
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

         }else{
             $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Deduction_Report?month="+month+"&year="+year+"&ded_type="+ded_type,
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
         }

        // $.ajax({
        //    url: "<?php echo base_url();?>Payroll/Salary_Report?month="+month+"&year="+year+"&bank_name="+bank_name,
        //    type:"GET",
        //    dataType:'',
        //    data:'data',          
        //   success: function(response) {
        //      // console.log(response);
             
        //      $('#salary').html(response);
        //    },
        //    error: function(response) {
            
        //    }
        //  });
      });
</script>


                  

<?php $this->load->view('backend/footer'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        
    var table = $('#example4').DataTable( {
        ordering: false,
        orderCellsTop: true,
        "aaSorting": [[0,'asc']],
        //"bPaginate": false,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>