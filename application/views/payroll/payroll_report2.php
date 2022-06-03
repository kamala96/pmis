<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Payroll Report</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><i class="fa fa-university" aria-hidden="true"></i> Payroll Report</li>
                    </ol>
                </div>
            </div>
            
            <div class="container-fluid"> 
                <div class="row m-b-10"> 
                    <div class="col-12">
<!--                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#TypeModal" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Add Payroll </a></button>-->
                        <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="" class="text-white"><i class="" aria-hidden="true"></i>  Generate Payroll</a></button> -->
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payroll Report                     
                                </h4>
                                
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12" style="">
                                         <table class="table table-bordered" width="100%">
                                <form method="post" action="Payroll_report">
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
                                    <td><button type="submit" class="btn btn-info"> Show Report</button></td>
                                </tr>
                                </form>
                            </table>
                                    </div>
                                </div>
                                <div class="table-responsive">
                    <form method="post" action="<?php echo base_url() ?>payroll/Payslip_Create1">
                                    <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" >
                                        <thead>
                                            <tr style="text-transform: uppercase;">
                                                <th>SNO.</th>
                                                <th>PF Number</th>
                                                <th>Full names</th>
                                                <th>Basic Salary</th>
                                                <th>Gross Salary</th>
                                                <th>Net Salary</th>
                                                <th>Paye</th>
                                                <th>TEWUTA</th>
                                                <th>COTWU(T)</th>
                                                <th>KK REFUND</th>
                                                <th>SANLAM Insurance</th>
                                                <th>KK SAVINGS</th>
                                                <th>W.A.D.U</th>
                                                <th>HOUSE RENT</th>
                                                <th>INSURANCE</th>
                                                <th>SALARY ARREARS</th>
                                                <th>ACTING ALLOWANCE</th>
                                                <th>FUEL ALLOWANCE</th>
                                                <th>TELEPHONE ALLOWANCE ARREAS</th>
                                                <th>TELEPHONE ALLOWANCE</th>
                                                <th>FUEL ALLOWANCE ARREAS</th>
                                                <th>OVERTIME</th>
                                                <th>HESLB</th>
                                                <th>KK EMERGENCY LOAN</th>
                                                <th>KK LOAN</th>
                                                <th>SUNDRY ALLOWANCE RECOVERY</th>
                                                <th>PURCHASE LOAN</th>
                                                <th>ZHESLB</th>
                                                <th>COURT ORDER</th>
                                                <th>SALARY RECOVERY</th>
                                                <th>HOUSE RENT RECOVERY</th>
                                                <th>SHORT & ACCESS</th>
                                                <th>SUNDRY ALLOWANCE</th>
                                                <th>NHIF</th>
                                                <th>PSSSF</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                            <?php $i = 1; foreach (@$salary as $value) {?>
                                                <tr style="text-transform: uppercase;">
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $value->em_code; ?></td>
                                                    <td><?php echo $value->first_name.'  '.$value->middle_name. '  '.$value->last_name; ?></td>
                                                    <td><?php echo number_format($value->basic_salary,2); ?></td>
                                                    <td><?php echo number_format($value->gross_salary,2); ?></td>
                                                    <td><?php echo number_format($value->net_salary,2); ?></td>
                                                    <td><?php echo number_format($value->paye,2); ?> 
                                                    </td> 
                                                <td><?php echo number_format($value->tewuta,2); ?> 
                                                    </td> 
                                                    <td><?php echo number_format($value->cotwu,2); ?></td>
                                                    <td><?php $list2 = array();
                                                      foreach ($kkrefund as  $ref) {
                                                      $emid1 = mb_strtolower($value->em_id);
                                                       $emid= mb_strtolower($ref->em_id);
                                                      
                                                      if($emid1 == $emid )
                                                        {
                                                          $list2[] = $ref->add_amount;
                                                          echo number_format($ref->add_amount,2);
                                                        } 
                                                      # code...
                                                    } 
                                                    if(empty($list2)){
                                                        echo number_format(0,2);

                                                      }  ?></td>
                                                    <td><?php 
                                                    $africanlife ="AFRICAN LIFE ASSURANCE" ;
                                                    $emid12 = $value->em_id;
                                                    $month= $value->month;
                                                    $year = $value->year;
                                                   

                                                        $list = array();

                                                    foreach ($sanslam as $san) {
                                                     $emid1 = mb_strtolower($value->em_id);
                                                      $emid = mb_strtolower($san->em_id);
                                                     if($emid1 == $emid )
                                                        {
                                                          $list[] = $san->ded_amount;
                                                          echo number_format($san->ded_amount,2);
                                                        } //else{} 
                                                      # code...
                                                      }  if(empty($list)){
                                                        echo number_format(0,2);

                                                      } 
                                                      
                                                    ?></td>
                                                   
                                                    <td><?php echo number_format($value->kksaving,2); ?></td>
                                                    <td><?php echo number_format($value->wadu,2); ?></td>
                                                     <td><?php echo number_format($value->houserent,2); ?></td>
                                                    <td><?php echo number_format($value->insurance,2); ?></td>
                                                    <td><?php echo number_format($value->salaryarrers ,2); ?></td>
                                                     <td><?php echo number_format($value->actingallowance  ,2); ?></td>
                                                     <td><?php echo number_format($value->fuelallowance   ,2); ?></td>
                                                    <td>
                                                        <?php echo number_format($value->telephoneallowancearrears   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->telephoneallowance   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->fuelallowancearreas   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->overtime   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->heslb   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->emergencyloan   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->kkloan   ,2); ?>
                                                    </td>
                                                     <td>
                                                        <?php echo number_format($value->sundryallowancerecovery   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->purchaseloan   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->zheslb    ,2); ?>
                                                    </td>
                                                      <td>
                                                        <?php echo number_format($value->courtorder   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->salaryrecovery   ,2); ?>
                                                    </td>
                                                     <td>
                                                        <?php echo number_format($value->houserecovery   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->shortaccess   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->sundryallowance   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->nhif   ,2); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo number_format($value->psssf   ,2); ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                          <tfoot>
                                              <tr>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td><?php echo number_format(@$basicSalary,2); ?></td>
                                              <td><?php echo number_format(@$grossSalary,2); ?></td>
                                              <td><?php echo number_format(@$nsalary,2); ?></td>
                                              <td><?php echo number_format(@$paye,2); ?></td>
                                              <td><?php echo number_format(@$tewuta,2); ?></td>
                                              <td><?php echo number_format(@$cotwu,2); ?></td>
                                              <td><?php echo number_format(@$kktotal,2); ?></td>
                                              <td><?php echo number_format(@$sanslamtotal,2); ?></td>
                                              <td><?php echo number_format(@$kksaving,2); ?></td>
                                              <td><?php echo number_format(@$wadu,2); ?></td>
                                              <td><?php echo number_format(@$houserent,2); ?></td>
                                              <td><?php echo number_format(@$insurance,2); ?></td>
                                              <td><?php echo number_format(@$salaryarrers,2); ?></td>
                                              <td><?php echo number_format(@$actingallowance,2); ?></td>
                                              <td><?php echo number_format(@$fuelallowance,2); ?></td>
                                              <td><?php echo number_format(@$tala1,2); ?></td>
                                              <td><?php echo number_format(@$telephoneallowance,2); ?></td>
                                              <td><?php echo number_format(@$fuelallowancearreas,2); ?></td>
                                              <td><?php echo number_format(@$overtime,2); ?></td>
                                              <td><?php echo number_format(@$heslb,2); ?></td>
                                              <td><?php echo number_format(@$emergencyloan,2); ?></td>
                                              <td><?php echo number_format(@$kkloan,2); ?></td>
                                              <td><?php echo number_format(@$sundryallowancerecovery,2); ?></td>
                                              <td><?php echo number_format(@$purchaseloan,2); ?></td>
                                              <td><?php echo number_format(@$zheslb,2); ?></td>
                                              <td><?php echo number_format(@$courtorder,2); ?></td>
                                              <td><?php echo number_format(@$salaryrecovery,2); ?></td>
                                              <td><?php echo number_format(@$houserecovery,2); ?></td>
                                              <td><?php echo number_format(@$shortaccess,2); ?></td>
                                              <td><?php echo number_format(@$sundryallowance,2); ?></td>
                                              <td><?php echo number_format(@$nhif,2); ?></td>
                                              <td><?php echo number_format(@$psssf,2); ?></td>
                                              </tr>
                                          </tfoot>
                                    </table>
                                    </form>
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

<script type="text/javascript">
    $(document).ready(function() {

    var table = $('#example4').DataTable( {
          ordering: false,
                     bPaginate: true,
                    orderCellsTop: true,
        "aaSorting": [[1,'asc']],
        ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
        buttons: [
        { extend: 'copy', footer: true },
            { extend: 'excel', footer: true },
            { extend: 'csv', footer: true },
            { extend: 'pdf', footer: true }
            // 'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<?php $this->load->view('backend/footer'); ?>