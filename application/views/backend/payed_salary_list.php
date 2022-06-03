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
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Salary_List" class="text-white"><i class="" aria-hidden="true"></i>  Payroll Salary List</a></button>
                    </div>
                </div> 

                <div class="row">

                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payroll List                     
                                </h4>
                            </div>
                            
                            <div class="card-body">
                                 
                            <table class="table table-bordered" width="100%">
                                <form method="POST" action="Payroll_Salary_list">
                                <tr>
                                    <td><select class="custom-select form-control" name="paye" required="required" id="dedtype">
                                        <option value="">--Select Deduction Type--</option>
                                        <option>P.A.Y.E</option>
                                        
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
                                    <td><select id="" class="form-control custom-select" name="region">
                                        <option>--Select Type--</option>
                                        <option value="">Tanzania Bara</option>
                                        <option value="Zanzibar">Tanzania Visiwani</option>
                                    </select></td>
                                    <td><button type="submit" class="btn btn-info"> Show  List</button></td>
                                </tr>
                                </form>
                            </table>
                        
                        <div class="">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" id="example4" width="100%" style="text-transform: uppercase;">
                                         <thead>
                                            <tr>
                                             <th>S/N</th>
                                             <th>PF NO.</th>
                                             <th>FULLNAME</th>
                                             <th>Month</th>
                                             <th>Year</th>
                                             <th>GROSS TAXABLE</th>
                                             <th>EMPLOYEE AMOUNT</th>
                                             <th>EMPLOYER AMOUNT</th>
                                             <th>TOTAL</th>
                                         </tr>
                                         </thead> 
                                         <tbody>
                                            <?php $i=1; foreach ($paye as $value) {?>
                                               
                                             <tr>
                                                 <td><?php echo $i;$i++; ?></td>
                                                 <td><?php echo $value->PFno; ?></td>
                                                 <td><?php echo $value->full_name; ?></td>
                                                 <td><?php echo $value->month; ?></td>
                                                 <td><?php echo $value->year; ?></td>
                                                 <td><?php echo number_format($value->gross_taxable,2); ?></td>
                                                 <td><?php echo number_format($value->paye_employee_amount,2); ?></td>
                                                 <td><?php echo number_format($value->paye_employer_amount,2);  ?></td>
                                                 <td><?php echo number_format($value->total,2); ?></td>
                                             </tr>

                                            <?php } ?>
                                         </tbody>
                                         <tfoot>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td><?php $sum =0; foreach ($paye as $value) {
                                                     $sum+=$value->gross_taxable;
                                                    
                                              } echo number_format($sum,2);?></td>
                                             <td><?php $sum =0; foreach ($paye as $value) {
                                                     $sum+=$value->paye_employee_amount;
                                                    
                                              } echo number_format($sum,2);?></td>
                                             <td><?php $sum =0; foreach ($paye as $value) {
                                                     $sum+=$value->paye_employer_amount;
                                                    
                                              } echo number_format($sum,2);?></td>
                                             <td><?php $sum =0; foreach ($paye as $value) {
                                                     $sum+=$value->total;
                                                    
                                              } echo number_format($sum,2);?></td>
                                         </tfoot> 
                                          
                                    </table>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
         var bank_name    = $('#bank_name').val();
         var dedtype    = $('#dedtype').val();

        $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Payroll_List?month="+month+"&year="+year+"&dedtype="+dedtype,
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

<?php $this->load->view('backend/footer'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        
    var table = $('#example4').DataTable( {
        ordering: false,
        orderCellsTop: true,
        "aaSorting": [[0,'asc']],
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>