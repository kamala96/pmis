<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>


<style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader-img.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}

#btn_save:focus{
  outline:none;
  outline-offset: none;
}

.button {
    display: inline-block;
    padding: 6px 12px;
    margin: 20px 8px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    background-image: none;
    border: 2px solid transparent;
    border-radius: 5px;
    color: #000;
    background-color: #b2b2b2;
    border-color: #969696;
}

.button_loader {
  background-color: transparent;
  border: 4px solid #f3f3f3;
  border-radius: 50%;
  border-top: 4px solid #969696;
  border-bottom: 4px solid #969696;
  width: 35px;
  height: 35px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  99% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  99% { transform: rotate(360deg); }
}



    /*Hidden class for adding and removing*/
    .lds-dual-ring.hidden {
        display: none;
    }

    /*Add an overlay to the entire page blocking any further presses to buttons or other elements.*/
    .overlay2 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,.8);
        z-index: 999;
        opacity: 1;
        transition: all 0.5s;
    }

    /*Spinner Styles*/
    .lds-dual-ring {
        display: inline-block;
        width: 80px;
        height: 80px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 64px;
        height: 64px;
        margin: 5% auto;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>


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
                                <form method="post" action="">
                                <tr>
                                   
                                    <td><select class="custom-select form-control" name="bank_name" required="required" id="bank_name">
                                        <option value="ALL">--Select Bank Name--</option>
                                                <option value="ALL">ALL</option>
                                                 <option value="CRDB">CRDB</option>
                                                <option value="NBC">NBC</option>
                                                <option value="DCB">DCB</option>
                                                <option value="BARCLAYS">BARCLAYS</option>
                                                <option value="NMB">NMB</option>
                                                <option value="TPB">TPB</option>
                                                <option value="AKIBA">AKIBA</option>
                                                <option value="PBZ">PBZ</option>
                                                <option value="EXIM">EXIM</option>
                                                <option value="BOA">BOA</option>
                                                <option value="UCHUMI BANK">UCHUMI BANK</option>
                                                <option value="AMANA BANK">AMANA BANK</option>
                                                <option value="STANBIC BANK">STANBIC BANK</option>
                                                <option value="STANDARD CHARTER">STANDARD CHARTER</option>

                                    </select></td>


                                     <td>
                                        <?php  $musedepvalue = $this->employee_model->getmusedepartment(); ?>
                                         <select name="musedept" value="" class="form-control custom-select" id="musedept" required>
                                        <option value="ALL">--Select Department--</option>
                                         <option value="ALL">ALL</option>
                                        <?Php foreach($musedepvalue as $value): ?>
                                        <option value="<?php echo $value->id ?>"><?php echo strtoupper($value->dep_name) ?></option>
                                        <?php endforeach; ?>
                                      
                                        </select>
                                    </select>
                                </td>


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
                                   

                                    <td><button type="submit" class="btn btn-info disable" id="BtnSubmit">Generate Salary Sheet To Bank</button></td>
                                </tr>
                                </form>
                            </table>
                        
                        <div class="table-responsive">
                                    <div id="salary">
                                        <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100% " style="">
                                        <thead>
                                            <tr>
                                                <th class="">S/N </th>
                                                <th>Employee PF Number</th>
                                                <th>Full names</th>
                                                <th>Titles</th>
                                                <th>Salary Scale</th>
                                                <th>Basic Salary</th>
                                                <th>Net Salary</th>
                                                <th>Department</th>
                                                <!-- <th>Total Paid</th> -->
                                               <th>Pay Date</th>
                                                <th>Status</th>
                                                <th class="jsgrid-align-center">Action</th>
                                            </tr>
                                        </thead>
                                        
										
                                        <tbody>

                                           <?php  $i =0; foreach($salary_info as $individual_info): ?>
                                            <tr>
                                                <td class=""><?php $i++; echo  $i;?></td>
                                                <td><?php echo $individual_info->em_code; ?></td>
                                                <td><?php echo strtoupper($individual_info->first_name.' '.$individual_info->middle_name.' '.$individual_info->last_name); ?></td>
                                                <td><?php  
                                                    @$des_id = $individual_info->des_id; 
                                                    @$desvalue = $this->employee_model->getdesignation1($des_id);
                                                    echo strtoupper(@$desvalue->des_name);
                                                ?></td>
                                                <td><?php echo   $individual_info->salary_scale; 
                                                ?></td>
                                                <td><?php echo number_format($individual_info->basic_payment,2); ?></td>
                                                <td><?php echo number_format($individual_info->net_payment,2); ?></td>
                                                <td>
                                                    <?php 
                                                    @$dep_id = $individual_info->dep_id;
                                                     @$depvalue1 = $this->employee_model->getdepartment1($dep_id);echo strtoupper(@$depvalue1->dep_name);
                                                ?></td>
                                                <td><?php echo $individual_info->paid_date; ?></td>
                                                <td><?php echo $individual_info->paid_status; ?></td>
                                    <td class="jsgrid-align-center ">
                    <a href="<?php echo base_url() ?>payroll/Salary_Slip_Create?I=<?php echo base64_encode($individual_info->em_id)?>&M=<?php echo base64_encode($individual_info->month)?>&Y=<?php echo base64_encode($individual_info->year)?>&S=<?php echo $individual_info->id?>" title="Generate" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-coy"></i>Generate Salary Slip</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    
                                </div>
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
        $('.disable').attr("disabled", true);
         var month   = $('#month').val();
         var year    = $('#years').val();
         var bank_name    = $('#bank_name').val();
          var musedept    = $('#musedept').val();
         if (bank_name == "ALL") {

             $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Report?month="+month+"&year="+year+"&musedept="+musedept,
           type:"GET",
           dataType:'',
           data:'data', 
            beforeSend: function() {
                                  $("#BtnSubmit").addClass('button_loader').attr("value",""); 
                                
                             },         
          success: function(response) {
             // console.log(response);
              $('#BtnSubmit').removeClass('button_loader').attr("value","\u2713");
             $('#BtnSubmit').prop('disabled', false);
             
             $('#salary').html(response);
           },
           error: function(response) {
            
           }
         });

         }else{
             $.ajax({
           url: "<?php echo base_url();?>Payroll/Salary_Report?month="+month+"&year="+year+"&bank_name="+bank_name+"&musedept="+musedept,
           type:"GET",
           dataType:'',
           data:'data',  
           beforeSend: function() {
                                  $("#BtnSubmit").addClass('button_loader').attr("value",""); 
                                
                             },         
          success: function(response) {
             // console.log(response);
              $('#BtnSubmit').removeClass('button_loader').attr("value","\u2713");
             $('#BtnSubmit').prop('disabled', false);
             
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