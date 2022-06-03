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
                
                <div class="row">
                    <div class="col-12">

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Create Salary Form                     
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="">
                   <?php
                    @$salary_id = $salaryvalue->id;
                    $data['TaxAddition']= $this->payroll_model->getTaxAddition($salary_id);
                    $data['NonTaxAddition'] = $this->payroll_model->getNonTaxAddition($salary_id);
                    $data['NonTaxDeduction']= $this->payroll_model->getNonTaxDeduction($salary_id);
                    $data['TaxDeduction']= $this->payroll_model->getTaxDeduction($salary_id);
                    $data['LoanDeduction']= $this->payroll_model->getLoanDeduction1($salary_id);
                    $bankname = $this->employee_model->bankList();
                    ?>
                    <div class="row" style="">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                    <div class="tab-pane" id="salary" role="tabpanel">
                    <div class="card">
                    <div class="card-body">
                    
                    <form action="<?php echo base_url() ?>Payroll/Save_Salary" method="post" enctype="multipart/form-data">

                    <div class="row">
                    <div class="form-group col-md-12">
                                            <table class="table table-bordered">
                                                <tr><th colspan="2">
                                                <h3 class="card-title">Employee Basic Salary</h3>
                                                </th></tr>
                                                <tr>
                                                    <td><select name="salary_scale" value="" class="form-control custom-select" required id="regiono" onChange="getScale();" required="required">
                                        <option><?php if(!empty($salaryvalue->type_id)) echo $salaryvalue->type_id ?></option>
                                         <option value="">--Select Salary Scale --</option>  
                                             <option value="OS1">OS1</option>
                                             <option value="OS2">OS2</option>
                                             <option value="OS3">OS3</option>
                                             <option value="OS4">OS4</option>
                                             <option value="OS5">OS5</option>
                                             <option value="PS1">PS1</option>
                                             <option value="PS2">PS2</option>
                                             <option value="PS3">PS3</option>
                                             <option value="PS4">PS4</option>
                                             <option value="PS5">PS5</option>
                                             <option value="PS6">PS6</option>
                                             <option value="PS7">PS7</option>
                                             <option value="PS8">PS8</option>
                                             <option value="PS9">PS9</option>
                                             <option value="PS10">PS10</option>
                                             <option value="PSS1">PSS1</option>
                                             <option value="PSS2">PSS2</option>
                                             <option value="PSS3">PSS3</option>
                                        </select></td>
                                                    <td>
                                                     <select name="basic_amount" value="" class="form-control custom-select"  id="branchdropo" required="required"> 
                                                     <option><?php if(!empty($salaryvalue->total)) echo $salaryvalue->total ?></option> 
                                                        <option value="">--Select Amount--</option>
                                                    </select>
                                                   </td>
                                                    
                                                </tr>
                                                <tr><td colspan="3">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <?php if(!empty($salaryvalue->id)){ ?>    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                    <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Salary</button>
                                                </td></tr>
                                            </table>
                                       
                                    </div>
                                   
                                    </div> 
                                    
                            </form>
                            <?php 
                            $month = date('m');
                            if($month == "05"){ ?>
                             
                            <?php }else{?>
                                
                            <?php } ?>
                          
                             <form action="<?php echo base_url() ?>Payroll/Tax_relief" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <table class="table table-bordered">
                                                <tr><th colspan="2">
                                                    <h3 class="card-title">Tax Relief</h3>
                                                </th></tr>
                                                <tr>
                                                    <td>
                                                        <?php if (empty($taxttarif)) {?>
                                                           <input type="text" name="tax_relief" class="form-control" required="required" placeholder="Tax Relief">
                                                       <?php  }else{ ?>
                                                        <input type="text" name="tax_relief" class="form-control" required="required" placeholder="Tax Relief" value="<?php echo $taxttarif->amount;?>">
                                                         <input type="hidden" name="trid" class="form-control" required="required" placeholder="Tax Relief" value="<?php echo $taxttarif->tr_id;?>">
                                                       <?php } ?>
                                                    </td>
                                                <td colspan="3">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <?php if(!empty($salaryvalue->id)){ ?>    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                    <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Fund</button> | <button type="submit" name="remove" class="btn btn-danger" value="remove">Remove</button>
                                                </td></tr>
                                            </table>
                                       
                                    </div>
                                   
                                    </div> 
                                    
                            </form>
                            <form action="<?php echo base_url() ?>Payroll/Save_Assuarance" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-20">
                                            <table class="table table-bordered">
                                                <tr><th colspan="3"><h3 class="card-title">African Life Assuarance</h3></th></tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="fund_name" class="form-control" required="required" placeholder="Fund Name" value="AFRICAN LIFE ASSUARANCE" readonly="readonly">
                                                    </td>
                                                    <?php if(empty($Assuarance)){ ?>
                                                    <td>
                                                <input type="text" name="fund_percent" class="form-control" required="required" placeholder="Assuarance Amount">
                                                    </td>
                                                  
                                                    <?php }else{ ?>
                                                        <td>
                                                        <input type="text" name="fund_percent" class="form-control" required="required" value="<?php echo $Assuarance->ded_amount;?>">
                                                        <input type="hidden" name="assId" class="form-control" value="<?php echo $Assuarance->assur_id;?>">
                                                        </td>
                                                    <?php } ?>

                                                      <td>
                                                        <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo @$salaryvalue->total; ?>">
                                                        <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Assuarance</button> | <button class="btn btn-danger" name="remove" value="remove">Remove</button>
                                                    </td>
                                                </tr>

                                            </table>
                                       
                                    </div>
                                   
                                    </div> 
                                    
                            </form>
                            <form action="<?php echo base_url() ?>Payroll/Save_Fund" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-20">
                                            <table class="table table-bordered">
                                                <tr><th colspan="3"><h3 class="card-title">Employee Pension Funds</h3></th></tr>
                                                <tr>
                                                    <td><input type="text" name="fund_name" class="form-control" required="required" placeholder="Fund Name" value="PSSSF" readonly="readonly"></td>
                                                    <td>
                                                <input type="text" class="form-control" required="required" placeholder="Fund Percent" value="<?php echo number_format(@$PensionFund->fund_amount,2);?>" readonly="readonly">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger" name="delete" value="delete">Remove</button>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="fund_name" class="form-control" required="required" placeholder="Fund Name" value="PSSSF" readonly="readonly"></td>
                                                    <td>
                                                <input type="text" name="fund_percent" class="form-control" required="required" placeholder="Fund Percent" value="0.05" readonly="readonly">
                                                    </td>
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                    
                                                </tr>
                                                <tr><td colspan="3">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <?php if(!empty($salaryvalue->id)){ ?>    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                    <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Fund</button>
                                                </td></tr>
                                            </table>
                                       
                                    </div>
                                   
                                    </div> 
                                    
                            </form>
                             <form action="<?php echo base_url() ?>Payroll/Save_Addition" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                            
                            <table class="table table-bordered" id="dynamic_field"> 
                                <tr><th colspan="5"><h3 class="card-title">Tax Addition Allowance</h3></th></tr>
                                <?php 
                                    foreach ($data['TaxAddition'] as $value) {
                                ?>
                                    <tr><td><input type="text" name="" class="form-control" value="<?php echo $value->add_name; ?>" readonly></td><td><input type="text" name="" class="form-control" value="<?php echo $value->add_amount; ?>" readonly>
                                        <input type="hidden" name="" class="form-control addid" value="<?php echo $value->add_id; ?>"></td>
                                        <td>
                                        <input type="text" name="" class="form-control addid" value="<?php echo $value->start_month; ?>" readonly></td>
                                        <td>
                                        <input type="text" name="" class="form-control addid" value="<?php echo $value->end_month; ?>" readonly></td><td><button class="btn btn-danger remove" >Remove</button></td></tr>
                                <?php
                                    }
                                ?>

                        <tr>  
                        <td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" required="" /></td>
                        <td><input type="text" name="addition_amount" placeholder="Enter Addition Amount" class="form-control name_list" required="" /></td>  
                        <td><input type="text" name="startdate" placeholder="Start Month [year-month]" class="form-control mydatetimepickerFull"/></td>  
                        <td><input type="text" name="enddate" placeholder="End Month [year-month]" class="form-control mydatetimepickerFull"/></td>  
                                         <td><!-- <button type="button" name="add" id="add" class="btn btn-success">Add More</button> --></td>  
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <?php if(!empty($salaryvalue->id)){ ?>  
                                                     <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">   
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Addition</button>
                                        </td>
                                    </tr>  
                               </table>  
                        </div>
                                    </div>
                                    

                        </form> 
                       
                            <form action="<?php echo base_url() ?>Payroll/Non_Tax_Addition" method="post" enctype="multipart/form-data">
                                   
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                           
                               <table class="table table-bordered" id="dynamic_fieldNon"> 
                                <tr><th colspan="5"> <h3 class="card-title">Non Tax Addition Allowance</h3></th></tr>
                         <?php foreach ($sundry as $value) {?>
                        <tr>  
                        <td><input type="text" name="" disabled="disabled" value="<?php echo $value->add_name ?>" class="form-control name_list" required="" /></td>
                        <td><input type="text" name="" value="<?php echo $value->add_amount ?>" class="form-control name_list" required="" disabled="disabled" /></td>
                        <td><input type="text" name=""value="<?php echo @$value->start_month ?>" class="form-control name_list" required="" disabled="disabled" /></td> 
                        <td><input type="text" name=""value="<?php echo @$value->end_month ?>" class="form-control name_list" required="" disabled="disabled" /></td>  
                                         <td>
                                            <input type="hidden" name="addid"value="<?php echo $value->add_id ?>" class="form-control name_list" required="" />
                                            <button type="submit" name="delete" value="delete" class="btn btn-danger">Remove</button></td>  
                                    </tr>  
                        <?php } ?>
                        <tr>  
                        <td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" /></td>
                        <td><input type="text" name="addition_amount[]" placeholder="Enter Addition Amount" class="form-control name_list"  /></td>
                        <td><input type="text" name="start_month" placeholder="Start Month [year-month]" class="form-control mydatetimepickerFull"  /></td>  
                        <td><input type="text" name="end_month" placeholder="End Month [year-month]" class="form-control mydatetimepickerFull" /></td> 
                        <td></td>
                                          
                        </tr>  
                        <tr>
                            <td colspan="5">
                                <?php if(!empty($salaryvalue->id)){ ?>    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">  
                                                <?php } ?> 
                                                <input type="hidden" name="nonid" value="<?php echo @$sundry->add_id; ?>">
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Addition</button>
                            </td>
                        </tr>
                    </table>  

                        </form>
                         <form action="<?php echo base_url() ?>Payroll/Save_NonPdecuction" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                <h3 class="card-title">Trade Union Deduction</h3>
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                        <table class="table table-bordered"><tr><td><select name="deduction_name[]" class="form-control custom-select">
                            <option>COTWU(T)</option>
                            <option>TEWUTA</option>
                        </select></td><td>
                            <input type="text" name="deduction_amount[]" placeholder="Enter Deduction Percent" class="form-control name_list" required="required" value="0.02" readonly="readonly" />
                        </td><td></td> </tr></table>
                        </div>  
                        </div>
                        <div class="row">
                                         <div class="form-group col-md-12 m-t-5">
                                                    <?php if(!empty($salaryvalue->id)){ ?>   
                                                     <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Deduction</button>
                                            </div>
                                    </div>
                        </form>
                        <form action="<?php echo base_url() ?>Payroll/Save_NonPdecuction" method="post" enctype="multipart/form-data">
                           
                             <table class="table table-bordered" id="dynamic_field2">
                                <tr><th colspan="3">
                                    <h3 class="card-title">Makato ya hiari (W.A.D.U ,nk)</h3>
                                </th></tr>
                            <?php foreach ($data['NonTaxDeduction'] as  $value) {?>
                                <tr>  
                        <td><input type="text" name="" placeholder="Enter Deduction Name" class="form-control name_list"  value="<?php echo $value->ded_name; ?>" readonly/></td>
                        <td><input type="text" name="" placeholder="Enter Deduction Amount" class="form-control name_list" required="required" value="<?php echo $value->ded_amount; ?>" readonly/>
                            <input type="hidden" name="dedid" class="form-control sd" required="required" value="<?php echo $value->ded_id; ?>" readonly/></td>  
                            <td><button class="btn btn-danger" type="submit" name="delete" value="delete">Remove</button></td>  
                                    </tr>
                            <?php  
                            } ?>
                            
                        <!-- </table > -->
                            <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                             
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                                             <tr>
                        <td><input type="text" name="deduction_name[]" placeholder="Enter Deduction Name" class="form-control name_list" /></td>
                        <td><input type="text" name="deduction_amount[]" placeholder="Enter Deduction Amount" class="form-control name_list"  /></td>  
                            <td><button type="button" name="add" id="add2" class="btn btn-success">Add More</button></td>  
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <?php if(!empty($salaryvalue->id)){ ?>   
                                                     <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Deduction</button>
                                        </td>
                                    </tr> 
                               </table>         
                            </div>  
                        </div>
                        <div class="row">
                                         <div class="form-group col-md-12 m-t-5">
                                                    
                                            </div>
                                    </div>
                        </form>
                        <form action="<?php echo base_url() ?>Payroll/Save_Pdecuction" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                        
                        <table class="table table-bordered" id="dynamic_field4"> 
                            <tr><th colspan="3">
                                <h3 class="card-title">Makato ya mifuko mbali mbali</h3>
                            </th></tr>
                            <?php foreach ($data['TaxDeduction'] as  $value) {?>
                                <tr>  
                        <td><input type="text" name="" placeholder="Enter Deduction Name" class="form-control name_list" required="required" value="<?php echo $value->ded_name; ?>"/></td>
                        <td><input type="text" name="" placeholder="Enter Deduction Percent" class="form-control name_list" required="required" value="<?php echo $value->ded_amount; ?>"/>
                            <input type="hidden" name="" placeholder="Enter Deduction Percent" class="form-control dedid" required="required" value="<?php echo $value->ded_id; ?>"/></td>  
                            <td><button class="btn btn-danger" name="remove" value="remove" id="rm">Remove</button></td>  
                                    </tr>
                            <?php } ?>
                            <tr>  
                        <td><input type="text" name="percent_name[]" placeholder="Enter Deduction Name" class="form-control name_list" required="required" /></td>
                        <td><input type="text" name="percent_amount[]" placeholder="Enter Deduction Percent" class="form-control name_list" required="required" /></td>  
                            <td><button type="button" name="add" id="add4" class="btn btn-success">Add More</button></td>  
                                    </tr> 
                                    <tr>
                                        <td colspan="3">
                                            <?php if(!empty($salaryvalue->id)){ ?> 
                                                       <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Deduction</button>
                                        </td>
                                    </tr> 
                               </table>         
                                        </div>
                                                
                                    </div>
                                     <div class="row">
                                         <div class="form-group col-md-12 m-t-5">
                                                    
                                            </div>
                                    </div>
                        </form>
                    
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                    <table class="table table-bordered" id="dynamic_field3">
                        <tr><th colspan="4">
                            <h3 class="card-title">Makato ya mikopo</h3>
                        </th></tr>
                        <?php foreach ($data['LoanDeduction'] as $value) {?>
                            <?php if($value->status != 'COMPLETE'){?>
                    <form action="<?php echo base_url() ?>Payroll/Delete_Othersdecuction" method="post" enctype="multipart/form-data"> 
                            <tr>  
                    <td>
                        <input type="hidden" name="id" class="form-control name_list" value="<?php echo $value->others_id; ?>"/><input type="text" name="" placeholder="Enter Lander Name" class="form-control name_list" required="required" value="<?php echo $value->other_names; ?>"/></td>
                        <td><input type="text" name="" placeholder="Enter Loan Amount" class="form-control name_list" required="required" value="<?php echo $value->loan_amount ?>"/></td>
                        <td><input type="text" name="" placeholder="Enter Deduction Amount" class="form-control name_list" required="required" value="<?php echo $value->installment_Amount ?>" /></td><td colspan="2"><button class="btn btn-danger">Remove</button></td></tr> 
                         
                     <tr>
                     </form>
                        <?php  } ?>
                      <?php } ?> 
                <form action="<?php echo base_url() ?>Payroll/Save_Othersdecuction" method="post" enctype="multipart/form-data"> 
                    <td><input type="text" name="others_name[]" placeholder="Enter Lander Name" class="form-control name_list" required="required" /></td>
                        <td><input type="text" name="loan_amount[]" placeholder="Enter Loan Amount" class="form-control name_list" required="required" /></td>
                        <td><input type="text" name="loan_deduction_amount[]" placeholder="Enter Deduction Amount" class="form-control name_list" required="required" /></td><td><button type="button" name="add" id="add3" class="btn btn-success">Add More</button></td></tr> 
                        <tr><td colspan="4">
                            <?php if(!empty($salaryvalue->id)){ ?>
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Deduction</button>
                        </td></tr>
                               </table>
                                     </div>
                                    </div>
                                </form>
                           
                                <form action="<?php echo base_url() ?>Payroll/Save_BankInfo" method="post" enctype="multipart/form-data">
                                    <h3 class="card-title">Bank Information</h3>
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                                        <table class="table table-bordered" style="width: 100%;">
                                            <tr>
                                                <td><select class="custom-select form-control" name="bank_name" required="required">
                                                <option><?php echo @$bankinfo->bank_name; ?></option>
                                                <option value="">--Select Bank Name--</option>
                                                <?php foreach ($bankname as $value) {?>
                                                   <option><?php echo @$value->bank_nanme; ?></option>
                                                <?php }?>
                                                </select></td>
                                                <td><input type="text" name="acc_number" class="form-control" required="required" placeholder="Account Number" value="<?php echo @$bankinfo->account_number; ?>"></td>
                                                <td><input type="text" name="acc_name" class="form-control" required="required" placeholder="Account Holder Name" value="<?php echo @$bankinfo->holder_name; ?>"></td>
                                            </tr>
                                        </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                         <div class="form-group col-md-12 m-t-5">
                                             <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                             <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Bank Infomation</button>
                                            </div>
                                    </div>
                                </form>

                                <form action="<?php echo base_url() ?>Payroll/Save_non_percent_comm" method="post" enctype="multipart/form-data">
                                    <h3 class="card-title">Pending Commulative For Makato ya hiari (W.A.D.U ,nk)</h3>
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                                        
                                        <table class="table table-bordered" style="width: 100%;">
                                            <?php foreach ($commPending as $value) {?>
                                              
                                            <tr>
                                                <td><input type="text" name="" class="form-control" required="required" placeholder="Amount" value="<?php echo @$value->ded_name; ?>" readonly="readonly"></td>
                                                <td><input type="text" name="" class="form-control" required="required" placeholder="Amount" value="<?php echo @$value->ded_amount; ?>" readonly="readonly"></td>
                                                <input type="hidden" name="commid" value="<?php echo $value->ded_id; ?>">
                                                <td><button class="btn btn-danger" type="submit" name="remove" value="remove">Remove</button></td>
                                                
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td><select class="custom-select form-control" name="name">
                                                    <?php $salary_id= @$salaryvalue->id; $getValue = $this->payroll_model->commulative_value($salary_id); ?>
                                                <option value="">--Select name--</option>
                                                <?php foreach ($getValue as $value) {?>
                                                   <option><?php echo @$value->ded_name; ?></option>
                                                <?php }?>
                                                </select></td>
                                                <td><input type="text" name="amount" class="form-control"  placeholder="Amount"></td>
                                                <td></td>
                                                
                                            </tr>
                                        </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                         <div class="form-group col-md-12 m-t-5">
                                             <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                             <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Information</button>
                                            </div>
                                    </div>
                                </form>

                                <form action="<?php echo base_url() ?>Payroll/Save_percent_comm" method="post" enctype="multipart/form-data">
                                    <h3 class="card-title">Pending PSSSF</h3>
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                                        <table class="table table-bordered" style="width: 100%;">
                                             <?php foreach ($commPension as $value) {?>
                                              
                                            <tr>
                                            <td><input type="text" name="" class="form-control" required="required" placeholder="Amount" value="<?php echo @$value->fund_amount; ?>" readonly="readonly"></td>
                                                <input type="hidden" name="fundid" value="<?php echo $value->fund_id; ?>">
                                            <td>
                                                <button class="btn btn-danger" name="remove" value="remove"> Remove</button>
                                            </td>
                                                
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td><input type="text" name="amount" class="form-control"  placeholder="Amount"></td>
                                                <td>&nbsp;</td>
                                                
                                            </tr>
                                        </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                         <div class="form-group col-md-12 m-t-5">
                                             <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                             <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Information</button>
                                            </div>
                                    </div>
                                </form>
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        
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
                                   
                                </div>
                            </div>
                        </div>

<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" required="required"/></td><td><input type="text" name="addition_amount" placeholder="Enter Addition Amount" class="form-control name_list" required="required"/></td><td><input type="text" name="startdate" placeholder="Start Month [year-month]" class="form-control"/></td><td><input type="text" name="enddate" placeholder="End Month [year-month]" class="form-control"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#addNon').click(function(){  
           i++;  
           $('#dynamic_fieldNon').append('<tr id="row'+i+'"><td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" required="required"/></td><td><input type="text" name="addition_amount[]" placeholder="Enter Addition Amount" class="form-control name_list" required="required"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove1">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add7').click(function(){  
           i++;  
           $('#dynamic_field7').append('<tr id="row'+i+'"><td><input type="text" name="addition_name[]" placeholder="Enter Addition Name" class="form-control name_list" required="required"/></td><td><input type="text" name="addition_amount[]" placeholder="Enter Addition Amount" class="form-control name_list" required="required"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove7">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove7', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add2').click(function(){  
           i++;  
           $('#dynamic_field2').append('<tr  id="row'+i+'"><td><input type="text" name="deduction_name[]" placeholder="Enter Deduction Name" class="form-control name_list" required="required" /></td><td><input type="text" name="deduction_amount[]" placeholder="Enter Deduction Percent" class="form-control name_list" required="required" /></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add4').click(function(){  
           i++;  
           $('#dynamic_field4').append('<tr id="row'+i+'"><td><input type="text" name="percent_name[]" placeholder="Enter Deduction Name" class="form-control name_list" /></td><td><input type="text" name="percent_amount[]" placeholder="Enter Deduction Amount/Percent" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>
 <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add3').click(function(){  
           i++;  
           $('#dynamic_field3').append('<tr id="row'+i+'"><td><input type="text" name="others_name[]" placeholder="Enter Name" class="form-control name_list" /></td><td><input type="text" name="loan_amount[]" placeholder="Enter Loan Amount" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr><tr id="row'+i+'"><td><input type="text" name="loan_deduction_amount[]" placeholder="Enter Deduction Amount" class="form-control name_list" required="required" /></td><td colspan="2"></td></tr>');  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>


<script type="text/javascript">
        function getScale() {
    var val = $('#regiono').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Payroll/GetScale",
     data:'scale_name='+ val,
     success: function(data){
         $("#branchdropo").html(data);
     }
 });
};
</script>
<script type="text/javascript">
    $('.remove').click(function(){            
           var val = $('.addid').val();
           $.ajax({
             type: "POST",
             url: "<?php echo base_url();?>Payroll/Save_Addition",
             data:'addid='+ val,
             success: function(data){
                alert(data);
             }
         });
      });
</script>

<script type="text/javascript">
    $('#rm').click(function(){            
           var val = $('.dedid').val();
           $.ajax({
             type: "POST",
             url: "<?php echo base_url();?>Payroll/Save_Pdecuction",
             data:'dedid='+ val,
             success: function(data){
                alert(data);
             }
         });
      });
</script>
<script type="text/javascript">
    $('#delete').click(function(){   
        
            var val = $('.sd').val();
            $.ajax({
              type: "POST",
              url: "<?php echo base_url();?>Payroll/Save_NonPdecuction",
              data:'dedid='+ val,
              success: function(data){
                 alert(data);
              }
          });
      });
</script>



























































<script type="text/javascript">
    $(document).ready(function() {
    $("#checkedAll").change(function() {
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
                $("#checkedAll").prop("checked", true);
            }     
        }
        else {
            $("#checkedAll").prop("checked", false);
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
<script type="text/javascript">   
$(document).ready(function() {    
/*var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();

if(dd<10) {
    dd = '0'+dd
} 

if(mm<10) {
    mm = '0'+mm
} 

today = mm + '/' + dd + '/' + yyyy;*/
var d = new Date();
var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
var m = months[d.getMonth()];    
var y = d.getFullYear();    
//document.write(today);    
   var table = $('#example123').DataTable( {
        "aaSorting": [[9,'desc']],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Salary List'+'<br>'+ m +' '+ y,
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '50pt' )
                        .prepend(
                            '<img src="<?php echo base_url()?>assets/images/dRi_watermark.png" style="position:absolute;background-size:300px 300px; top:35%; left:27%;" />'
                        );
                    $(win.document.body)
                        //.css( 'border', 'inherit' )
                        .prepend(
                            '<footer class="footer" style="border:inherit"><img src="<?php echo base_url();?>assets/images/signature_vice.png" style="position:absolute; top:0; left:0;" /><img src="<?php echo base_url();?>assets/images/signature_ceo.png" style="position:absolute; top:0; right:0;height:30px;" /></footer>'
                        );
                    $(win.document.body).find( 'h1' )
                        .addClass( 'header' )
                        .css( 'display', 'inharit' )
                        .css( 'position', 'relative' )
                        .css( 'float', 'right' )
                        .css( 'font-size', '24px' )
                        .css( 'font-weight', '700' )
                        .css( 'margin-right', '15px' );
                    $(win.document.body).find( 'div' )
                        .addClass( 'header-top' )
                        .css( 'background-position', 'left top' )
                        .css( 'height', '100px' )
                        .prepend(
                            '<img src="<?php echo base_url()?>assets/images/dri_Logo.png" style="position:absolute;background-size:30%; top:0; left:0;" />'
                        );
                    $(win.document.body).find( 'div img' )
                        .addClass( 'header-img' )
                        .css( 'width', '300px' );
                    $(win.document.body).find( 'h1' )
                        .addClass( 'header' )
                        .css( 'font-size', '25px' );

                    $(win.document.body).find( 'table thead' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            margin: '20px',
                            background: '#e8e8e8',

                        });
 
                    $(win.document.body).find( 'table thead th' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            border: '1px solid #000',
                            padding: '15px 12px',
                            width: '8%'
                        });
 
                    $(win.document.body).find( 'table tr td' )
                        .addClass( 'compact' )
                        .css( {
                            color: '#000',
                            margin: '20px',
                            border: '1px solid #000'

                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(3)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '15%',
                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(1)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '1%',
                        });
 
                    $(win.document.body).find( 'table thead th:nth-child(2)' )
                        .addClass( 'compact' )
                        .css( {
                            width: '5%',
                        });
 
                    $(win.document.body).find( 'table thead th:last-child' )
                        .addClass( 'compact' )
                        .css( {
                            display: 'none',

                        });
 
                    $(win.document.body).find( 'table tr td:last-child' )
                        .addClass( 'compact' )
                        .css( {
                            display: 'none',

                        });
                }
            }
        ]
    } );
/*$("#example123 tfoot th").each( function ( i ) {
		
		if ($(this).text() !== '') {
	        var isStatusColumn = (($(this).text() == 'Status') ? true : false);
			var select = $('<select><option value=""></option></select>')
	            .appendTo( $(this).empty() )
	            .on( 'change', function () {
	                var val = $(this).val();
					
	                table.column( i )
	                    .search( val ? '^'+$(this).val()+'$' : val, true, false )
	                    .draw();
	            } );
	 		
			// Get the Status values a specific way since the status is a anchor/image
			if (isStatusColumn) {
				var statusItems = [];
				
                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### 
				table.column( i ).nodes().to$().each( function(d, j){
					var thisStatus = $(j).attr("data-filter");
					if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
				} );
				
				statusItems.sort();
								
				$.each( statusItems, function(i, item){
				    select.append( '<option value="'+item+'">'+item+'</option>' );
				});

			}
            // All other non-Status columns (like the example)
			else {
				table.column( i ).data().unique().sort().each( function ( d, j ) {  
					select.append( '<option value="'+d+'">'+d+'</option>' );
		        } );	
			}
	        
		}
    } );*/
  
} );
</script>
<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 6000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(600).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},600);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('#salary123').DataTable({
        "aaSorting": [[10,'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });   
</script>