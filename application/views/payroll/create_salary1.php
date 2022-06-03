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
                                    <!--Start of basic Salary!-->
                    <div class="row">
                    <div class="form-group col-md-12">
                                    <form action="<?php echo base_url() ?>Payroll/Save_Salary" method="post" enctype="multipart/form-data">
                                            <table class="table table-bordered">
                                                <tr style="background-color: #FFFFE0;"><th colspan="" width="50%">
                                                <h3 class="card-title">Basic Salary</h3>
                                                </th>
                                                <th width="50%"></th></tr>
                                                <tr>
                                                    <td><select name="salary_scale" value="" class="form-control custom-select" required id="regiono" onChange="getScale();" required="required" style="">
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
                                                     <select name="basic_amount" value="" class="form-control custom-select"  id="branchdropo" required="required" style=""> 
                                                     <option><?php if(!empty($salaryvalue->total)) echo $salaryvalue->total ?></option> 
                                                        <option value="">--Select Amount--</option>
                                                    </select>
                                                   </td>
                                                    
                                                </tr>
                                                <tr><td colspan="2">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <?php if(!empty($salaryvalue->id)){ ?>    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                    <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Basic Salary</button>
                                                </td></tr>
                                            </table>
                            </form>
                            </div>
                        </div> 

                        <!--End of Basic Salary!-->
                        <div class="row">
                        <div class="form-group col-md-12">
                            <form action="<?php echo base_url() ?>Payroll/Save_Addition" method="POST" >
                            <table class="table table-bordered" id=""> 
                                
                                <tr><th colspan="5" style="background-color: #FFFFE0;"><h3 class="card-title">Tax Addition Allowance(Allowance Zinazo Katwa Kodi)</h3></th></tr>
                                <?php 
                                    foreach ($TaxAddition as $value) {
                                ?>
                                    <tr><td><input type="text" name="addition_name1" class="form-control" value="<?php echo $value->add_name; ?>" style=""></td><td><input type="text" name="addition_amount1" class="form-control" value="<?php echo $value->add_amount; ?>" style="">
                                        </td>
                                        <td>
                                        <input type="text" name="startdate1" class="form-control mydatetimepickerFull" value="<?php echo $value->start_month; ?>" style=""></td>
                                        <td>
                                        <input type="text" name="enddate1" class="form-control mydatetimepickerFull" value="<?php echo $value->end_month; ?>" style=""></td><td><input type="hidden" name="addid" value="<?php echo $value->add_id; ?>"><input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"><input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">

                                            <button type="submit" class="btn btn-warning" name="edit" value="edit" style="">Update</button>

                                            |

                                            <button class="btn btn-danger" name="remove" value="remove" type="submit">Remove</button>
                                        </td></tr>
                                <?php
                                    }
                                ?>
                            
                        <tr>  
                        <td><input type="text" name="addition_name" placeholder="Enter Addition Name" class="form-control name_list" style=""/></td>
                        <td><input type="text" name="addition_amount" placeholder="Enter Addition Amount" class="form-control name_list" style="" /></td>  
                        <td><input type="text" name="startdate" placeholder="Start Month [year-month]" class="form-control mydatetimepickerFull" style=""/></td>  
                        <td><input type="text" name="enddate" placeholder="End Month [year-month]" class="form-control mydatetimepickerFull" style=""/>
                            </td>  
                                         <td><!-- <button type="button" name="add" id="add" class="btn btn-success">Add More</button> --></td>  
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <?php if(!empty($salaryvalue->id)){ ?>  
                                                     <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">   
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" class="btn btn-info" style="">Save Tax Addition</button>
                                        </td>
                                    </tr>  
                                   
                               </table> 
                                </form> 

                                <br>
                                <div class="row">
                                <div class="form-group col-md-12">
            <form action="<?php echo base_url() ?>Payroll/Non_Tax_Addition" method="post" enctype="multipart/form-data">
                                   
                    <table class="table table-bordered" id="dynamic_fieldNon"> 
                    <tr style="background-color: #FFFFE0;"><th colspan="5"> <h3 class="card-title">Non Tax Addition Allowance(Allownce Bila Kodi)</h3></th></tr>
                         <?php foreach ($NonTaxAddition as $value) {?>
                        <tr>  
                        <td><input type="text" name="addition_name1" value="<?php echo $value->add_name ?>" class="form-control name_list" /></td>
                        <td><input type="text" name="addition_amount1" value="<?php echo $value->add_amount ?>" class="form-control name_list" /></td>
                        <td><input type="text" name="start_month1" value="<?php echo @$value->start_month ?>" class="form-control mydatetimepickerFull"/></td> 
                        <td><input type="text" name="end_month1" value="<?php echo @$value->end_month ?>" class="form-control mydatetimepickerFull"/></td>  
                                         <td>
                                            <input type="hidden" name="addid"value="<?php echo $value->add_id ?>" class="form-control name_list" required="" />
                                           <button type="submit" name="edit" value="edit" class="btn btn-warning">Update</button>| <button type="submit" name="delete" value="delete" class="btn btn-danger">Remove</button></td>  
                                    </tr>  
                        <?php } ?>
                        <tr>  
                        <td><input type="text" name="addition_name" placeholder="Enter Addition Name" class="form-control name_list" /></td>
                        <td><input type="text" name="addition_amount" placeholder="Enter Addition Amount" class="form-control name_list"  /></td>
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
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Non Tax Addition</button>
                            </td>
                        </tr>
                    </table>  

                        </form>
                    </div>
                </div>
                <div class="row">
                                        <div class="form-group col-md-12 m-t-20">
                      <form action="<?php echo base_url() ?>Payroll/Save_Fund" method="post" enctype="multipart/form-data">
                                    
                                    
                                            <table class="table table-bordered">
                                                <tr style="background-color: #FFFFE0;"><th colspan="3"><h3 class="card-title">Pension Funds</h3></th></tr>
                                                <?php if(empty($PensionFund)){ ?>
                                                <?php }else{?>
                                                <tr>
                                                    <td><input type="text" name="" class="form-control" required="required" placeholder="Fund Name" value="PSSSF" readonly="readonly">

                                                    </td>
                                                    <td>
                                                <input type="text" class="form-control" placeholder="Fund Percent" value="<?php echo number_format(@$PensionFund->fund_amount,2);?>" readonly="readonly">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger" name="delete" value="delete">Remove</button>
                                                    </td>
                                                    
                                                </tr>
                                            <?php }?>
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
                                                    <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Pension Fund</button>
                                                </td></tr>
                                            </table>
                            </form> 
                            </div>
                        </div>

                        <div class="row">
                        <div class="form-group col-md-12 m-t-20">
                        <form action="<?php echo base_url() ?>Payroll/Save_Assuarance" method="post" enctype="multipart/form-data">
                                    
                                            <table class="table table-bordered">
                                                <tr style="background-color: #FFFFE0;"><th colspan="3"><h3 class="card-title">African Life Assuarance</h3></th></tr>
                                                <?php if(empty($AfricaAssurance)){ ?>
                                                <?php }else{?>
                                                    <tr>
                                                      
                                                    <td width="45%">
                                                        <input type="text" name="fund_name" class="form-control" required="required" placeholder="Fund Name" value="AFRICAN LIFE ASSUARANCE" readonly="readonly">
                                                    </td>
                                                        <td width="45%">
                                                        <input type="text" name="fund_percent" class="form-control" required="required" value="<?php echo $AfricaAssurance->ded_amount;?>">
                                                        <input type="hidden" name="assId" class="form-control" value="<?php echo $AfricaAssurance->assur_id;?>">
                                                        </td>
                                                    
                                                    <td width="10%">
                                                        <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo @$salaryvalue->total; ?>">
                                                        <button class="btn btn-danger" name="remove" value="remove">Remove</button>
                                                    </td>
                                                    </tr>
                                                <?php }?>
                                                <tr>
                                                    <td width="45%">
                                                        <input type="text" name="fund_name" class="form-control" required="required" placeholder="Fund Name" value="AFRICAN LIFE ASSUARANCE" readonly="readonly">
                                                    </td>
                                                        <td width="45%">
                                                <input type="text" name="fund_percent" class="form-control"  placeholder="Assuarance Amount">
                                                    </td>
                                                      <td width="10%">
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo @$salaryvalue->total; ?>">
                                                        <button  type="submit" style="" class="btn btn-info">Save Assuarance</button> 
                                                    </td>
                                                </tr>

                                            </table>
                                       
                                    
                            </form>

                            </div>
                                   
                        </div> 


                        <div class="row">
                        <div class="form-group col-md-12">
                        <form action="<?php echo base_url() ?>Payroll/Tax_relief" method="post" enctype="multipart/form-data">
                                    <table class="table table-bordered">
                                                <tr style="background-color: #FFFFE0;"><th colspan="2">
                                                    <h3 class="card-title">Tax Relief</h3>
                                                </th></tr>
                                                <?php if (empty($TaxRelif)) {?>
                                                 <?php  }else{ ?>
                                                <tr>
                                                    <td>
                                                        <input type="text" readonly="readonly" name="tax_relief" class="form-control" required="required" placeholder="Tax Relief" value="<?php echo $TaxRelif->amount;?>">
                                                         <input type="hidden" name="trid" class="form-control" required="required" placeholder="Tax Relief" value="<?php echo $TaxRelif->tr_id;?>">
                                                       
                                                    </td>
                                                <td colspan="3">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <?php if(!empty($salaryvalue->id)){ ?>    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                   <button type="submit" name="remove" class="btn btn-danger" value="remove">Remove</button>
                                                </td></tr>
                                                <?php } ?>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="tax_relief" class="form-control" required="required" placeholder="Tax Relief">
                                                        <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                        <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                         <button type="submit" style="" class="btn btn-info">Save Tax Relief</button>
                                                    </td>
                                                </tr>
                                            </table>
                                      
                            </form> 
                             </div>
                         </div> 
                         <div class="row">
                             <div class="col-md-12">
                         <form action="<?php echo base_url() ?>Payroll/Save_NonPdecuction" method="post" enctype="multipart/form-data">
                            
                                
                        <table class="table table-bordered">
                        <tr style="background-color: #FFFFE0;">
                            <th colspan="3"><h3 class="card-title">Trade Union Deduction</h3></th>
                        </tr>
                        <?php if(empty($TradeUnion)){ ?>
                        <?php }else{?>
                            <tr><td width="45%"><input type="text" readonly="readonly" class="form-control" name="" value="<?php echo $TradeUnion->ded_name; ?>"></td><td width="45%">
                            <input type="text" name="" class="form-control" readonly="readonly" value="<?php echo $TradeUnion->ded_amount; ?>">
                        </td><td width="10%">
                            <input type="hidden" name="dedid" class="form-control" readonly="readonly" value="<?php echo $TradeUnion->ded_id; ?>">
                            <button class="btn btn-danger" name="delete" value="delete">Remove</button>
                        </td> </tr>
                        <?php } ?>
                        <tr><td width="45%"><select name="deduction_name" class="form-control custom-select">
                            <option>COTWU(T)</option>
                            <option>TEWUTA</option>
                        </select></td><td width="45%">
                            <input type="text" name="deduction_amount" placeholder="Enter Deduction Percent" class="form-control name_list" required="required" value="0.02" readonly="readonly" />
                        </td><td width="10%"></td> </tr>
                        <tr>
                            <td colspan="3">
                                <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                <?php if(!empty($salaryvalue->id)){ ?>   
                                                     <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                <?php } ?> 
                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Trade Union</button>
                            </td>
                        </tr>
                    </table>
                        </form>
                        </div>
                         </div>
                         <br>
                         <div class="row">
                        <div class="form-group col-md-12">
                          <form action="<?php echo base_url() ?>Payroll/Save_NonPdecuction" method="post" enctype="multipart/form-data">
                           
                             <table class="table table-bordered" id="dynamic_field2">
                                <tr style="background-color: #FFFFE0;"><th colspan="3">
                                    <h3 class="card-title">Makato ya hiari (W.A.D.U ,nk)</h3>
                                </th></tr>
                            <?php foreach ($NonTaxDeduction as  $value) {?>
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
                             <tr>
                        <td><input type="text" name="deduction_name" placeholder="Enter Deduction Name" class="form-control name_list" /></td>
                        <td><input type="text" name="deduction_amount" placeholder="Enter Deduction Amount" class="form-control name_list"  /></td>  
                            <td></td>  
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <?php if(!empty($salaryvalue->id)){ ?>   
                                                     <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Makato ya hiari</button>
                                        </td>
                                    </tr> 
                               </table>  
                        </form>
                        <br>
                        <form action="<?php echo base_url() ?>Payroll/Save_Pdecuction" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12">
                        
                        <table class="table table-bordered" id="dynamic_field4"> 
                            <tr style="background-color: #FFFFE0;"><th colspan="3">
                                <h3 class="card-title">Makato ya mifuko mbali mbali</h3>
                            </th></tr>
                            <?php foreach ($TaxDeduction as  $value) {?>
                                <tr>  
                        <td><input type="text" name="" placeholder="Enter Deduction Name" class="form-control name_list"  value="<?php echo $value->ded_name; ?>"/></td>
                        <td><input type="text" name="" placeholder="Enter Deduction Percent" class="form-control name_list"  value="<?php echo $value->ded_amount; ?>"/>
                            <input type="hidden" name="dedid" placeholder="Enter Deduction Percent" class="form-control dedid" value="<?php echo $value->ded_id; ?>"/></td>  
                            <td><button class="btn btn-danger" name="remove" value="remove" id="rm">Remove</button></td>  
                                    </tr>
                            <?php } ?>
                            <tr>  
                        <td><input type="text" name="percent_name" placeholder="Enter Deduction Name" class="form-control name_list"  /></td>
                        <td><input type="text" name="percent_amount" placeholder="Enter Deduction Percent" class="form-control name_list"  /></td>  
                            <td></td>  
                                    </tr> 
                                    <tr>
                                        <td colspan="3">
                                            <?php if(!empty($salaryvalue->id)){ ?> 
                                                       <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Makato ya mifuko mbali mbali</button>
                                        </td>
                                    </tr> 
                               </table>         
                                        </div>
                                                
                                    </div>
                                     
                        </form>
                    
                        </div>  
                        </div>
                    <form action="<?php echo base_url() ?>Payroll/Save_Othersdecuction" method="post" enctype="multipart/form-data"> 
                    <table class="table table-bordered" id="dynamic_field3">
                        <tr style="background-color: #FFFFE0;"><th colspan="4">
                            <h3 class="card-title">Makato ya mikopo</h3>
                        </th></tr>
                        <?php foreach ($LoanDeduction as $value) {?>
                            <?php if($value->status != 'COMPLETE'){?>
                    
                            <tr>  
                    <td>
                        <input type="hidden" name="id" class="form-control name_list" value="<?php echo $value->others_id; ?>"/><input type="text" name="" placeholder="Enter Lander Name" class="form-control name_list"  value="<?php echo $value->other_names; ?>"/></td>
                        <td><input type="text" name="" placeholder="Enter Loan Amount" class="form-control name_list"  value="<?php echo $value->loan_amount ?>"/></td>
                        <td><input type="text" name="" placeholder="Enter Deduction Amount" class="form-control name_list" value="<?php echo $value->installment_Amount ?>" />
                            <input type="hidden" name="others_id" class="form-control name_list" value="<?php echo $value->others_id ?>" /></td><td colspan="2"><button class="btn btn-danger" name="delete" value="delete">Remove</button></td></tr> 
                         
                     </tr>
                        <?php  } ?>
                      <?php } ?> 
                    <tr>
                    <td><input type="text" name="others_name" placeholder="Enter Lander Name" class="form-control name_list"  /></td>
                        <td><input type="text" name="loan_amount" placeholder="Enter Loan Amount" class="form-control name_list"  /></td>
                        <td><input type="text" name="loan_deduction_amount" placeholder="Enter Deduction Amount" class="form-control name_list"  /></td><td></td></tr> 
                        <tr><td colspan="4">
                            <?php if(!empty($salaryvalue->id)){ ?>
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">    
                                                    <input type="hidden" name="sid" value="<?php echo $salaryvalue->id; ?>">
                                                    <input type="hidden" name="basic_amount" value="<?php echo $salaryvalue->total; ?>">
                                                <?php } ?> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Save Makato ya Mikopo</button>
                        </td></tr>
                               </table>
                                     
                                </form>
                </div>
                    </div>
                     <div class="row">
                    <div class="form-group col-md-12">
                    <form action="<?php echo base_url() ?>Payroll/Save_BankInfo" method="post" enctype="multipart/form-data">
                                    
                                   
                                        <table class="table table-bordered" style="width: 100%;">
                                            <tr style="background-color: #FFFFE0;"><th colspan="3">
                                                <h3 class="card-title">Bank Information</h3>
                                            </th></tr>
                                            <tr>
                                                <td><select class="custom-select form-control" name="bank_name" required="required">
                                                <option><?php echo @$BankInfomation->bank_name; ?></option>
                                              <!--   <option value="">--Select Bank Name--</option>
 -->


                                                <?php foreach ($bankname as $value) {?>
                                                   <option><?php echo @$value->bank_nanme; ?></option>
                                                <?php }?>
                                                </select></td>
                                                <td><input type="text" name="acc_number" class="form-control" required="required" placeholder="Account Number" value="<?php echo @$BankInfomation->account_number; ?>"></td>
                                                <td><input type="text" name="acc_name" class="form-control" required="required" placeholder="Account Holder Name" value="<?php echo @$BankInfomation->holder_name; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                             <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                <button style="display:none;"> <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Bank Infomation</button>
                                                </td>
                                            </tr>
                                        </table>
                                        </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-12">
                        <form action="<?php echo base_url() ?>Payroll/Save_non_percent_comm" method="post" enctype="multipart/form-data">
                            <table class="table table-bordered" style="width: 100%;">
                                            <tr style="background-color: #FFFFE0;"><th colspan="3">
                                                <h3 class="card-title">Pending Commulative For Makato ya hiari (W.A.D.U ,nk)</h3>
                                            </th></tr>
                                             <?php foreach ($commPendingSec as $value) {?>
                                              
                                            <tr>
                                                <td><input type="text" name="" class="form-control" required="required" placeholder="Amount" value="<?php echo @$value->ded_name; ?>" readonly="readonly"></td>
                                                <td><input type="text" name="" class="form-control" required="required" placeholder="Amount" value="<?php echo @$value->ded_amount; ?>" readonly="readonly"></td>
                                                <input type="hidden" name="commid" value="<?php echo $value->ded_id; ?>">
                                                <td><button class="btn btn-danger" type="submit" name="remove" style="display: none;"  value="remove">Remove</button></td>
                                                
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td><select class="custom-select form-control" name="name">
                                                <option value="">--Select name--</option>
                                                <?php foreach ($getValue as $value) {?>
                                                   <option><?php echo @$value->ded_name; ?></option>
                                                <?php }?>
                                                </select></td>
                                                <td><input type="text" name="amount" class="form-control"  placeholder="Amount"></td>
                                                <td></td>
                                                
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                             <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Information</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                        </div>
                    </div>
                    <form action="<?php echo base_url() ?>Payroll/Save_percent_comm" method="post" enctype="multipart/form-data">
                                    
                                    <div class="row">
                                        <div class="form-group col-md-12 m-t-5">
                                        <table class="table table-bordered" style="width: 100%;">
                                            <tr style="background-color: #FFFFE0;"><th colspan="2"><h3 class="card-title">Pending PSSSF</h3></th></tr>
                                             <?php foreach ($commPension as $value) {?>
                                              
                                            <tr>
                                            <td width="90%"><input type="text" name="" class="form-control" required="required" placeholder="Amount" value="<?php echo @$value->fund_amount; ?>" readonly="readonly"></td>
                                                <input type="hidden" name="fundid" value="<?php echo number_format($value->fund_id,2) ; ?>">
                                            <td width="10%">
                                                <button class="btn btn-danger" style="display: none;" name="remove" value="remove"> Remove</button>
                                            </td>
                                                
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td><input type="text" name="amount" class="form-control"  placeholder="Amount"></td>
                                                <td>&nbsp;</td>
                                                
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <input type="hidden" name="sid" value="<?php echo @$salaryvalue->id; ?>">
                                             <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>"> 
                                                <button <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> disabled <?php } ?> type="submit" style="" class="btn btn-info">Add Information</button>
                                                </td>
                                            </tr>
                                        </table>
                                        </div>
                                    </div>

                                </form>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    </div>
                </div>
                        
<?php $this->load->view('backend/footer'); ?>




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
            timeout: 600000,
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
