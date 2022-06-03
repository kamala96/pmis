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
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i>  Salary </li>
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
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Salary                      
                                </h4>
                            </div>
                            
                            <div class="card-body">
                                 <!-- <a href="updateLoans" class="btn btn-info">Update Loan</a> -->
                            <table class="table table-bordered" width="100%">
                                <form method="post" action="delete_month_salary">
                                <tr>
                                  <td>  <input type="text" name="secret" placeholder="Neno Siri" class="form-control"  value="" ></td>
                                    <td><select class="custom-select form-control" name="month" required="required" id="month">
                                        <option value="">--Select Salary  Month--</option>
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
                                    <td><select name="year" id="years" class="form-control custom-select" name="year">
                                        <option>--Select Salary  Year--</option>
                                    </select></td>
                                    <td><button type="submit" class="btn btn-info">Delete</button></td>
                                </tr>
                                </form>
                            </table>
                        
                    
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="modal fade" id="Salarymodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Salary Form</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="post" action="Add_Salary" id="salaryform" enctype="multipart/form-data">
                                    <div class="modal-body">
<!--			                                    <div class="form-group">
			                                     <label>Salary Type</label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="typeid" required>
                                                    <?php #foreach($typevalue as $value): ?>
                                                    <option value="<?php #echo $value->id ?>"><?php #echo $value->salary_type; ?></option>
                                                    <?php #endforeach; ?>
                                                </select>
			                                    </div> -->                                        
                                            <div class="form-group">
                                                <label class="control-label">Employee Id</label>
                                                <input type="text" name="emid" class="form-control" id="recipient-name1" value="" readonly>
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">Basic</label>
                                                <input type="text" name="basic" class="form-control" id="recipient-name1" value="">
                                            </div>
                                            <h4>Addition</h4>                                         
                                            <div class="form-group">
                                                <label class="control-label">Medical</label>
                                                <input type="text" name="medical" class="form-control" id="recipient-name1"  value="">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">House Rent</label>
                                                <input type="text" name="houserent" class="form-control" id="recipient-name1" value="">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">Bonus</label>
                                                <input type="text" name="bonus" class="form-control" id="recipient-name1" value="">
                                            </div>
                                            <h4>Deduction</h4>                                         
                                            <div class="form-group">
                                                <label class="control-label">Provident Fund</label>
                                                <input type="text" name="provident" class="form-control" id="recipient-name1" value="">
                                            </div>                                         
                                            <div class="form-group">
                                                <label class="control-label">Bima</label>
                                                <input type="text" name="bima" class="form-control" id="recipient-name1" value="" >
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Tax</label>
                                                <input type="text" name="tax" class="form-control" id="recipient-name1"  value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Others</label>
                                                <input type="text" name="others" class="form-control" id="recipient-name1"  value="">
                                            </div>                                          
                                        
                                    </div>
                                    <div class="modal-footer">                                       
                                    <input type="hidden" name="sid" value="" class="form-control" id="recipient-name1">                                       
                                    <input type="hidden" name="aid" value="" class="form-control" id="recipient-name1">                                       
                                    <input type="hidden" name="did" value="" class="form-control" id="recipient-name1">                                       
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    </form>
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
         if (bank_name == "") {

             $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Report?month="+month+"&year="+year,
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
           url: "<?php echo base_url();?>Payroll/Salary_Report?month="+month+"&year="+year+"&bank_name="+bank_name,
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

        $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Report?month="+month+"&year="+year+"&bank_name="+bank_name,
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




                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".SalarylistModal").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#salaryform').trigger("reset");
                                                $('#Salarymodel').modal('show');
                                                $.ajax({
                                                    url: 'GetSallaryById?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).done(function (response) {
                                                    console.log(response);
                                                    // Populate the form fields with the data returned from server
													$('#salaryform').find('[name="sid"]').val(response.salaryvalue.id).end();
													$('#salaryform').find('[name="aid"]').val(response.salaryvalue.addi_id).end();
													$('#salaryform').find('[name="did"]').val(response.salaryvalue.de_id).end();
                                                   /* $('#salaryform').find('[name="typeid"]').val(response.salaryvalue.type_id).end();*/
                                                    $('#salaryform').find('[name="emid"]').val(response.salaryvalue.emp_id).end();
                                                    $('#salaryform').find('[name="basic"]').val(response.salaryvalue.basic).end();
                                                    $('#salaryform').find('[name="medical"]').val(response.salaryvalue.medical).end();
                                                    $('#salaryform').find('[name="houserent"]').val(response.salaryvalue.house_rent).end();
                                                    $('#salaryform').find('[name="bonus"]').val(response.salaryvalue.bonus).end();
                                                    $('#salaryform').find('[name="provident"]').val(response.salaryvalue.provident_fund).end();
                                                    $('#salaryform').find('[name="bima"]').val(response.salaryvalue.bima).end();
                                                    $('#salaryform').find('[name="tax"]').val(response.salaryvalue.tax).end();
                                                    $('#salaryform').find('[name="others"]').val(response.salaryvalue.others).end();
												});
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
        //"bPaginate": false,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>