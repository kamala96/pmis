        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <?php

                $id = $this->session->userdata('user_login_id');
                $basicinfo = $this->employee_model->GetBasic($id);
                $basicinfos = $this->employee_model->GetBasic($id);
                $dep_id = $basicinfos->dep_id;
                $dep = $this->employee_model->getdepartment1($dep_id);
                
                if (!empty($dep))
                {
                    $dep_name = $dep->dep_name;
                }
                else
                {}
                ?> 
                
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img">

                         <?php if ($basicinfos->em_image){ ?>
                            <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basicinfos->em_image ?>" alt="user" />
                        <?php } ?>

                        <!-- this is blinking heartbit-->
                        <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </div>

                    <!-- User profile text-->
                    <div class="profile-text">

                        <!-- <h5><?php echo $basicinfos->first_name.' '.$basicinfos->last_name; ?></h5> -->

                        <h5><?php echo $basicinfo->first_name.' '.$basicinfo->last_name.' ('.$basicinfo->em_role.')'; ?></h5>

                       <!--  <a href="<?php echo base_url(); ?>settings/Settings" class="dropdown-toggle u-dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a> -->
                        <a href="<?php echo base_url(); ?>login/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li> <a href="<?php echo base_url(); ?>dashboard/Dashboard" ><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a></li>
                        <?php if($this->session->userdata('user_type')=='HR'){ ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Region">Region </a></li>
                                <li><a href="<?php echo base_url();?>organization/District">District </a></li>
                                <li><a href="<?php echo base_url();?>organization/Branches">Region Branches</a></li>
                                <li><a href="<?php echo base_url();?>organization/BoxBranches">Box Branches</a></li>
                                <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                                <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>

                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">

                                      <!-- <li> <a href="<?php echo base_url('Contract/performace_targets')?>"> Targets </a> </li>
                                          
                                        <li> <a href="<?php echo base_url('Contract/performace_indicators')?>"> Performace Indicators </a> </li>
                                       -->
                                        
                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks  </a>
                                        </li>

                                    <li> <a href="<?php echo base_url('Contract/reports')?>"> Results Reports </a> </li>

                                    <li> <a href="<?php echo base_url('Contract/task_performance_reports')?>"> Performace Report </a> </li>

                                    <li> <a href="<?php echo base_url('Contract/general_reports')?>"> General Report </a> </li>

                                    <li> <a href="<?php echo base_url('Contract/receiver_performance_reports')?>"> Employee Performance Report </a> </li>
                                       
                                    </ul>
                                </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Disciplinary">Discharge </a></li>
                                <!--<li><a href="<?php echo base_url(); ?>employee/Inactive_Employee">Inactive Employees </a></li>-->
                                <li><a href="<?php echo base_url(); ?>employee/Retired_Employee">Retired Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Agency_Employee">Agent Employee </a></li>
                            </ul>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
								<li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
								<li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
<!--								<li><a href="--><?php //echo base_url(); ?><!--leave/Earnedleave"> Earned Leave </a></li>-->
								<li><a href="<?php echo base_url(); ?>leave/Leave_report">Leave Report </a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa fa-dollar"></i><span class="hide-menu">My Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip"> Salary Payslip </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->

                            </ul>

                        </li>
                        
                        <?php } else { ?>
                         <?php if($this->session->userdata('user_type') =='SUPERVISOR'){ ?>
                         <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <!-- <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Services">Add Services</a></li>
                                
                            </ul> -->
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>Notice/All_notice">Notice</a></li>
                                
                            </ul>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/add_counters">Counter</a></li>
                                
                            </ul>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/add_zone">Zone</a></li>
                                
                            </ul>
                             <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Assign_zoneto_region">Zone Assignment</a></li>
                                
                            </ul>

                             <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/shift_attendence">Shift Attendence</a></li>
                                
                            </ul>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>employee/Agency_Employee">Employee Branch List</a></li>
                                
                            </ul>
                        </li>
                    <?php } ?>
                        <?php if($this->session->userdata('user_type') =='EMPLOYEE' || $this->session->userdata('user_type') =='SUPERVISOR' || $this->session->userdata('user_type') =='AGENT' || $this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfos->em_id); ?>" aria-expanded="false">
								<i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
								<i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->


                               <li><a href="<?php echo base_url(); ?>leave/My_leave"> &nbsp;My Leave </a></li>
                               

                                <!-- <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li> -->

                                <!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->
                            </ul>
                        </li> 
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
								<i class="fa fa-dollar"></i><span class="hide-menu">My Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip"> Salary Payslip </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->

                            </ul>

                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <?php if($basicinfos->em_id == "Kas1574"){ ?>

                                        <li>
                                            <a href="<?php echo base_url('kpi/kpi_form')?>">Kpi Form</a>
                                        </li>
                                       
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi1')?>">Objective List</a>
                                        </li>

                                        <?php }?>

                                        <li> <a href="<?php echo base_url('Contract/tpc_contract')?>"> TPC Contract </a> </li>
                                       
                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks </a>
                                        </li>

                                        <!--
                                        <li>
                                            <a href="<?php echo base_url('kpi/kpi_report')?>">Kpi Report</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('kpi/general_kpi_report')?>">General Kpi Report</a>
                                        </li>
                                    -->
                                       
                                    </ul>
                                </li>
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Imprest</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="<?php echo base_url('imprest/Expenditure_Application')?>">Add Imprest</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a>
                                        </li>
                                    </ul>
                                </li>
                                 <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="fa fa-dollar"></i><span class="hide-menu"> Reports </span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <?php if($this->session->userdata('user_type') !='ACCOUNTANT' && $this->session->userdata('user_type') !='ACCOUNTANT-HQ'){ ?>
                                  <li><a href="<?php echo base_url(); ?>Ems_Domestic/employee_reports_dashboard"> Employee Reports </a></li>
                                   <?php } ?>
                                   <li><a href="<?php echo base_url(); ?>Box_Application/Bill_Repost"> Bill Repost </a></li>
                                   <li><a href="<?php echo base_url(); ?>Services/tracing"> Tracing</a></li>
                                  <li><a href="<?php echo base_url(); ?>Services/mail_tracing"> Mails Tracing</a></li>

                                    <?php if($this->session->userdata('user_type') =='ACCOUNTANT'){ ?>

                                     <li><a href="<?php echo base_url(); ?>Reports/Collection_Reports"> Collection</a></li>


                                    <?php } ?>
                                      <?php if($this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ ?>

                                         <li><a href="<?php echo base_url(); ?>Reports/Collection_Reports"> Collection</a></li>
                                 <li><a href="<?php echo base_url(); ?>Reports/Service_Reports"> Service Report</a></li>
                               
                                  <li><a href="<?php echo base_url(); ?>Services/deliver_report"> Delivery Performance report</a></li>

                                  
                                    <?php } ?>


                                  <?php if ($this->session->userdata('user_type') =='SUPERVISOR'){ ?>

                                   <?php if($this->session->userdata('departmentid')==38){ ?>
                                   <li><a href="<?php echo base_url(); ?>E_reports/regions_revenue_ems_reports"> Revenue Collection </a></li>
                                   <?php } ?>

                                    <li><a href="<?php echo base_url(); ?>Services/deliver_report"> Delivery Performance report</a></li>


                                    <li><a href="<?php echo base_url(); ?>Box_Application/box_rental_app_report"> Box Rental Report </a></li>

                                      
                                  <?php } ?>

                                  <li><a href="<?php echo base_url(); ?>E_reports/billing_invoice_dashboard"> Billing Invoice </a></li>

                                  <li><a href="<?php echo base_url(); ?>Exedence/nontechnical_dashboard"> Incident Management </a></li>
                                  <li><a href="<?php echo base_url(); ?>Reports/proff_deliver_report">Proff of Delivery report</a></li>


                                  


                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip"> Salary Payslip </a></li> -->
                                <!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->

                            </ul>

                        </li>

                               
							   
                        <?php }elseif($this->session->userdata('user_type') =='ADMIN'
								){ ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
									<i class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Region">Region </a></li>
                                <li><a href="<?php echo base_url();?>organization/District">District </a></li>
                                <li><a href="<?php echo base_url();?>organization/Branches">Region Branches</a></li>
                                <li><a href="<?php echo base_url();?>organization/BoxBranches">Box Branches</a></li>
                                <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                                <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>
                                <li><a href="<?php echo base_url();?>organization/Services">Add Services</a></li>
                                <li><a href="<?php echo base_url();?>organization/Token">Generate Customer</a></li>
                                <li><a href="<?php echo base_url();?>organization/Contract">Contract Type</a></li>
                                <li><a href="<?php echo base_url();?>Notice/All_notice">Notice</a></li>
								<li><a href="<?php echo base_url();?>organization/shift_attendence">Supervisor Attendence</a></li>
                                <li><a href="<?php echo base_url();?>organization/zone_info">International Zone</a></li>
                                <li><a href="<?php echo base_url();?>organization/zone_country">Country Zone</a></li>
                                 <li><a href="<?php echo base_url();?>organization/pcum_zone">Pcum Zone</a></li>
                                  <li><a href="<?php echo base_url();?>organization/test_zone">Test Zone</a></li>
                                
                            </ul>
                        </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Discharge">Discharge </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Retired_Employee">Retired Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Agency_Employee">Agent Employee </a></li>
                            </ul>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Earnedleave"> Earned Leave </a></li> -->
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report">Leave Report </a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
										<span class="hide-menu"><img src="<?php echo base_url(); ?>assets/images/slip.png" width="20"> &nbsp;My Payroll </span></a>
									<ul aria-expanded="false" class="collapse">
										<li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip">Salary Payslip </a></li>
									</ul>
								</li>
                        <!-- <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Payroll </span></a>
                                <ul aria-expanded="false" class="collapse"> 
                                 <li><a href="<?php echo base_url(); ?>Payroll/Salary_Scale">Salary Scale </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Add Salary To Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_Slips">Salary Slips</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Salary List </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/salary_delete">Delete Salary</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payed_Salary"> Payslip Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Deductions_Report"> Deductions Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/kkportal_loan_process"> Loan Process</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payroll_Salary_list"> Paye List</a></li>
                                  <li><a href="<?php echo base_url(); ?>Payroll/Payroll_report"> Payroll Report</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Paye_Chart">Paye Chart</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Pension_Chart">Deductions Chart</a></li>
                            </ul>
                        </li>  -->
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Imprest</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="<?php echo base_url('imprest/Expenditure_Application')?>">Add Imprest</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a>
                                        </li>
                                    </ul>
                                </li>

                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Reports </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>Reports/Reports"> Financial Reports </a></li>
                                  <li><a href="<?php echo base_url(); ?>Reports/Transaction_report"> Transactions Report </a></li>
                                <li><a href="<?php echo base_url(); ?>Dashboard/Update"> Update Transactions </a></li>

                                <li><a href="<?php echo base_url(); ?>Reports/Transactions"> Transactions</a></li>
                                 <li><a href="<?php echo base_url(); ?>Reports/Service_Reports"> Service Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Ems_Domestic/employee_report"> Employee Reports </a></li>
                                 <li><a href="<?php echo base_url(); ?>Box_Application/Bill_Repost"> Bill Repost </a></li>
                                 <li><a href="<?php echo base_url(); ?>Services/tracing"> Tracing</a></li>
                                 <li><a href="<?php echo base_url(); ?>Services/mail_tracing"> Mails Tracing</a></li>
                                 <li><a href="<?php echo base_url(); ?>E_reports/regions_revenue_ems_reports"> Revenue Collection </a></li>
                                 <li><a href="<?php echo base_url(); ?>E_reports/billing_invoice_dashboard"> Billing Invoice </a></li>
                                  <li><a href="<?php echo base_url(); ?>Services/deliver_report"> Delivery Perfomance report</a></li>
                                  <li><a href="<?php echo base_url(); ?>Reports/proff_deliver_report">Proff of Delivery report</a></li>
                                  <li><a href="<?php echo base_url(); ?>Exedence/nontechnical_dashboard"> Incident Management </a></li>
                                  
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                               
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li> -->
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Sms Notifications</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="<?php echo base_url('Reports/oldboxnotfy')?>">Sms Dashboard</a>
                                        </li>
                                        <li>
                                            <!-- <a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a> -->
                                        </li>
                                    </ul>
                                </li>
								
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">

                                        <li> <a href="<?php echo base_url('Contract/tpc_contract')?>"> TPC Contract </a> </li>

                                        <li> <a href="<?php echo base_url('Contract/bop_pmg_contract')?>"> BOP & PMG Contract </a> </li>

                                       <li> <a href="<?php echo base_url('Contract/pmg_gmcrm_contract')?>"> PMG & GMCRM Contract </a> </li>

                                        <!--  <li> <a href="<?php echo base_url('Contract/performace_targets')?>"> Targets </a> </li> -->

                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks </a>
                                        </li>

                                       <!--  <li> <a href="<?php echo base_url('Contract/reports')?>"> Reports </a> </li> -->
                                       
                                    </ul>
                                </li>

                            <?php }elseif($this->session->userdata('user_type') =='SUPER ADMIN' ){ ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Region">Region </a></li>
                                <li><a href="<?php echo base_url();?>organization/District">District </a></li>
                                <li><a href="<?php echo base_url();?>organization/Branches">Region Branches</a></li>
                                <li><a href="<?php echo base_url();?>organization/BoxBranches">Box Branches</a></li>
                                <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                                <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>
                                <li><a href="<?php echo base_url();?>organization/Services">Add Services</a></li>
                                <li><a href="<?php echo base_url();?>organization/Token">Generate Customer</a></li>
                                <li><a href="<?php echo base_url();?>organization/Contract">Contract Type</a></li>
                                <li><a href="<?php echo base_url();?>Notice/All_notice">Notice</a></li>
                                <li><a href="<?php echo base_url();?>organization/shift_attendence">Supervisor Attendence</a></li>
                                <li><a href="<?php echo base_url();?>organization/zone_info">International Zone</a></li>
                                <li><a href="<?php echo base_url();?>organization/zone_country">Country Zone</a></li>
                                 <li><a href="<?php echo base_url();?>organization/pcum_zone">Pcum Zone</a></li>
                                  <li><a href="<?php echo base_url();?>organization/test_zone">Test Zone</a></li>
                                
                            </ul>
                        </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Discharge">Discharge </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Retired_Employee">Retired Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Agency_Employee">Agent Employee </a></li>
                            </ul>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Earnedleave"> Earned Leave </a></li> -->
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report">Leave Report </a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a href="<?php echo base_url(); ?>Payroll/Salary_Scale">Salary Scale </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Salary_Type"> Payroll Type </a></li> -->
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Add Salary To Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_Slips">Salary Slips</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Salary List </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/salary_delete">Delete Salary</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payed_Salary"> Payslip Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Deductions_Report"> Deductions Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/kkportal_loan_process"> Loan Process</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payroll_Salary_list"> Paye List</a></li>
                                  <li><a href="<?php echo base_url(); ?>Payroll/Payroll_report"> Payroll Report</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Paye_Chart">Paye Chart</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Pension_Chart">Deductions Chart</a></li>
                            </ul>
                        </li>
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Imprest</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="<?php echo base_url('imprest/Expenditure_Application')?>">Add Imprest</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a>
                                        </li>
                                    </ul>
                                </li>

                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Reports </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>Reports/Reports"> Financial Reports </a></li> -->
                                  <!-- <li><a href="<?php echo base_url(); ?>Reports/Transaction_report"> Transactions Report </a></li> -->
                                <!-- <li><a href="<?php echo base_url(); ?>Dashboard/Update"> Update Transactions </a></li> -->



                                <!-- <li><a href="<?php echo base_url(); ?>Reports/Transactions"> Transactions</a></li> -->
                                <li><a href="<?php echo base_url(); ?>Reports/Collection_Reports"> Collection</a></li>
                               
                                 <li><a href="<?php echo base_url(); ?>Reports/Service_Reports"> Service Report</a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Ems_Domestic/employee_report"> Employee Reports </a></li> -->
                                 <li><a href="<?php echo base_url(); ?>Box_Application/Bill_Repost"> Bill Repost </a></li>
                                 <li><a href="<?php echo base_url(); ?>Services/tracing"> Tracing</a></li>
                                 <li><a href="<?php echo base_url(); ?>Services/mail_tracing"> Mails Tracing</a></li>
                                 <!-- <li><a href="<?php echo base_url(); ?>E_reports/regions_revenue_ems_reports"> Revenue Collection </a></li> -->
                                 <li><a href="<?php echo base_url(); ?>E_reports/billing_invoice_dashboard"> Billing Invoice </a></li>
                                  <li><a href="<?php echo base_url(); ?>Services/deliver_report"> Delivery Performance report</a></li>
                                  <li><a href="<?php echo base_url(); ?>Reports/proff_deliver_report">Proff of Delivery report</a></li>
                                 
                                  <li><a href="<?php echo base_url(); ?>Exedence/nontechnical_dashboard"> Incident Management </a></li>
                                  
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                               
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li> -->
                            </ul>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Sms Notifications</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="<?php echo base_url('Reports/oldboxnotfy')?>">Sms Dashboard</a>
                                        </li>
                                        <li>
                                            <!-- <a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a> -->
                                        </li>
                                    </ul>
                                </li>
                                
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">

                                        <li> <a href="<?php echo base_url('Contract/tpc_contract')?>"> TPC Contract </a> </li>

                                        <li> <a href="<?php echo base_url('Contract/bop_pmg_contract')?>"> BOP & PMG Contract </a> </li>

                                       <li> <a href="<?php echo base_url('Contract/pmg_gmcrm_contract')?>"> PMG & GMCRM Contract </a> </li>

                                         <li> <a href="<?php echo base_url('Contract/performace_targets')?>"> Targets </a> </li>

                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks </a>
                                        </li>

                                        <li> <a href="<?php echo base_url('Contract/reports')?>"> Results Report </a> </li>

                                        <li> <a href="<?php echo base_url('Contract/task_performance_reports')?>"> Performace Report </a> </li>

                                        <li> <a href="<?php echo base_url('Contract/general_reports')?>"> General Report </a> </li>

                                <li> <a href="<?php echo base_url('Contract/receiver_performance_reports')?>"> Employee Performance Report </a> </li>
                                       
                                    </ul>
                                </li>
                                
                        <?php }elseif($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' ){ ?>
                       <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                        <span class="hide-menu"><img src="<?php echo base_url(); ?>assets/images/slip.png" width="20"> &nbsp;My Payroll </span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
                                        <li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip">Salary Payslip </a></li>
                                                
                                        <!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->
                                    </ul>
                                </li>
                                
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Reports </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>Reports/Reports"> Financial Reports </a></li> -->
                                <li><a href="<?php echo base_url(); ?>Reports/Service_Reports"> Service Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Reports/Collection_Reports"> Collection</a></li>

                                <!-- <li><a href="<?php echo base_url(); ?>E_reports/regions_revenue_ems_reports"> Revenue Collection </a></li> -->
                                <li><a href="<?php echo base_url(); ?>E_reports/billing_invoice_dashboard"> Billing Invoice </a></li>
                               <!--  <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                               
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li> -->


                                <?php if($this->session->userdata('user_type') =='BOP'){ ?>
                                <li><a href="<?php echo base_url(); ?>Exedence/nontechnical_dashboard"> Incident Management </a></li>
                                <?php } ?>

                            </ul>
                        </li>
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">

                                        <li> <a href="<?php echo base_url('Contract/tpc_contract')?>"> TPC Contract </a> </li>

                                       <?php if($this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG'){ ?>
                                        <li> <a href="<?php echo base_url('Contract/bop_pmg_contract')?>"> BOP & PMG Contract </a> </li>
                                        <?php } ?>


                                      <?php if($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='PMG'){ ?>
                                       <li> <a href="<?php echo base_url('Contract/pmg_gmcrm_contract')?>"> PMG & GMCRM Contract </a> </li>
                                       <?php } ?>

                                       <li> <a href="<?php echo base_url('Contract/performace_targets')?>"> Targets </a> </li>
                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks </a>
                                        </li>
                                       
                                    </ul>
                                </li>
                                <li> <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url();?>leave/My_leave" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/leave.png" width="20">  &nbsp;My Leave</span></a>
                                    
                                </li>
							<?php }  elseif($this->session->userdata('user_type') =='RM' || $this->session->userdata('user_type') =='HOD' ){ ?>
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
									<ul aria-expanded="false" class="collapse">
										<li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
										<li><a href="<?php echo base_url(); ?>employee/Disciplinary">Disciplinary </a></li>
										<li><a href="<?php echo base_url(); ?>employee/Inactive_Employee">Inactive User </a></li>
										<li><a href="<?php echo base_url(); ?>employee/Retired_Employee">Retired Employee </a></li>
									</ul>
								</li>
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        
                                         <li> <a href="<?php echo base_url('Contract/tpc_contract')?>"> TPC Contract </a> </li>

                                          <?php if($this->session->userdata('user_type') =='RM'){ ?>
                                        <li> <a href="<?php echo base_url('Contract/bop_pmg_contract')?>"> BOP & PMG Contract </a> </li>
                                        <?php } ?>

                                        <?php if($this->session->userdata('user_type') =='HOD'){ ?>
                                       <li> <a href="<?php echo base_url('Contract/pmg_gmcrm_contract')?>"> PMG & GMCRM Contract </a> </li>
                                       <?php } ?>

                                         <li> <a href="<?php echo base_url('Contract/performace_targets')?>"> Targets </a> </li>

                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks </a>
                                        </li>


                                       
                                    </ul>
                                </li>
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
								<ul aria-expanded="false" class="collapse">
									<li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
									<li><a href="<?php echo base_url(); ?>leave/Leave_report"> Leave Report </a></li>
								</ul>
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
											<img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Imprest</span></a>
									<ul aria-expanded="false" class="collapse">
										<li>
											<a href="<?php echo base_url('imprest/Expenditure_Application')?>">Add Imprest</a>
										</li>
										<li>
											<a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a>
										</li>
									</ul>
								</li>
								
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
										<span class="hide-menu"><img src="<?php echo base_url(); ?>assets/images/slip.png" width="20"> &nbsp;My Payroll </span></a>
									<ul aria-expanded="false" class="collapse">
										<!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
										<li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip">Salary Payslip </a></li>
										<!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->
									</ul>
								</li>
                                   <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Reports </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>Reports/Reports"> Financial Reports </a></li> -->
                                 <li><a href="<?php echo base_url(); ?>Reports/Collection_Reports"> Collection</a></li>
                                <li><a href="<?php echo base_url(); ?>Exedence/nontechnical_dashboard"> Incident Management </a></li>
                                <li><a href="<?php echo base_url(); ?>E_reports/billing_invoice_dashboard"> Billing Invoice </a></li>
                                 <li><a href="<?php echo base_url(); ?>Services/deliver_report"> Delivery Performance report</a></li>
                                   <li><a href="<?php echo base_url(); ?>Services/tracing"> Tracing</a></li>
                                <li><a href="<?php echo base_url(); ?>Services/mail_tracing"> Mails Tracing</a></li>
                               <!--  <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                               
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li> -->
                            </ul>
                        </li>
							<?php }  elseif($this->session->userdata('user_type') =='DISPATCH' ){ ?>

                        <?php } else { ?>

                        <?php } ?>
                    <?php } ?>
						<?php if ($this->session->userdata('user_type') == 'HR-PAY'){?>
                             <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Employees </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Discharge">Discharge </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Retired_Employee">Retired Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>employee/Agency_Employee">Agent Employee </a></li>
                            </ul>
                        </li>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/leavetypes"> Leave Type</a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                                <li><a href="<?php echo base_url(); ?>leave/Leave_days"> Upate Leave Day </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Earnedleave"> Earned Leave </a></li> -->
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report">Leave Report </a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a href="<?php echo base_url(); ?>Payroll/Salary_Scale">Salary Scale </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Salary_Type"> Payroll Type </a></li> -->
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Add Salary To Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_Slips">Salary Slips</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Salary List </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/salary_delete">Delete Salary</a></li> -->
                                <li><a href="<?php echo base_url(); ?>Payroll/Payed_Salary"> Payslip Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Deductions_Report"> Deductions Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/kkportal_loan_process"> Loan Process</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payroll_Salary_list"> Paye List</a></li>
                                  <li><a href="<?php echo base_url(); ?>Payroll/Payroll_report"> Payroll Report</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Paye_Chart">Paye Chart</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Pension_Chart">Deductions Chart</a></li>
                                   <li><a href="<?php echo base_url(); ?>Payroll/kkportal_loan_process"> Loan Process</a></li>
                            </ul>
                        </li>
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Imprest</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li>
                                            <a href="<?php echo base_url('imprest/Expenditure_Application')?>">Add Imprest</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url(); ?>imprest/expenditure_List">Imprest List</a>
                                        </li>
                                    </ul>
                                </li>

                                 <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">

                                        <li> <a href="<?php echo base_url('Contract/tpc_contract')?>"> TPC Contract </a> </li>

                                        <li> <a href="<?php echo base_url('Contract/bop_pmg_contract')?>"> BOP & PMG Contract </a> </li>

                                       <li> <a href="<?php echo base_url('Contract/pmg_gmcrm_contract')?>"> PMG & GMCRM Contract </a> </li>

                                         <li> <a href="<?php echo base_url('Contract/performace_targets')?>"> Targets </a> </li>

                                        <li>
                                            <a href="<?php echo base_url('Contract/my_tasks')?>"> My Tasks </a>
                                        </li>

                                        <li> <a href="<?php echo base_url('Contract/reports')?>"> Reports </a> </li>
                                       
                                    </ul>
                                </li>


						<?php } ?>


                         <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Consolidated</span></a>
                                    <ul aria-expanded="false" class="collapse">

                                     <?php if( $dep_name=='EMS HQ'){ ?>

                                         <!--  <li><a href="<?php echo base_url(); ?>Reports/Collection_Reports"> Collection</a></li>
                                          <li><a href="<?php echo base_url(); ?>Reports/Consolidated_Reports">Branch Consolidated Report</a></li> -->
                                           <li><a href="<?php echo base_url(); ?>Reports/EMS_Consolidated">EMS Consolidated</a></li>


                                     <?php }?>

                                     <?php if($this->session->userdata('user_type') =='SUPERVISOR') { ?>
                                          <!-- <li><a href="<?php echo base_url(); ?>Collection_Report/consolidated"> Consolidated Report </a></li> -->
                                           <li><a href="<?php echo base_url(); ?>Reports/EMS_Consolidated">EMS Consolidated</a></li>
                                        
                                     <?php }?>

                                     <?php if($this->session->userdata('user_type') =='SUPER ADMIN') { ?>
                                        
                                          <!-- <li><a href="<?php echo base_url(); ?>Reports/Consolidated_Reports">Branch Consolidated Report</a></li> -->

                                           <li><a href="<?php echo base_url(); ?>Reports/EMS_Consolidated">EMS Consolidated</a></li>

                                     <?php }?>


                                    <?php if($this->session->userdata('user_type') =='RM') { ?>
                                        
                                          <!-- <li><a href="<?php echo base_url(); ?>Reports/Consolidated_Reports">Branch Consolidated Report</a></li> -->

                                           <li><a href="<?php echo base_url(); ?>Reports/EMS_Consolidated">EMS Consolidated</a></li>

                                     <?php }?>
                                        
                                      
                                       
                                    </ul>
                        </li>


                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <span class="hide-menu"><img src="<?php echo base_url(); ?>assets/images/setting.png"> &nbsp;Posts Services </span></a>

                         <?php if($this->session->userdata('user_type') =='ADMIN') { ?>

                             <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url(); ?>Services/search_master">Search Master</a></li>
                                <li><a href="<?php echo base_url(); ?>Services/mail_search_master">Mail Search Master</a></li>
                            </ul>

                         <?php } ?>

                         
                        <?php $id = $basicinfos->em_id;
                            $data = $this->employee_model->get_services_byEmId($id);
							$data1 = $this->employee_model->get_services_byEmId1($id);
                            $section = $this->employee_model->getEmpDepartmentSections($id);
							//$getStatus = $this->Box_Application_model->get_super_status();

                            //echo json_encode($data) ;  
                            //echo json_encode($data1) ; 
                           // if ($basicinfos->dep_name == "EMS" || $basicinfos->dep_name == "MAILS") {

                             if ($section) {
                                   ?>
                              <!--   <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url(); ?>Services/<?php echo $section[0]['name']?>"><?php echo $section[0]['name']?></a></li>
                                </ul> -->

                                <ul aria-expanded="false" class="collapse">
                           <!--  <li><a href="<?php echo base_url(); ?>Services/<?php echo $section[0]['name']?>"><?php echo $section[0]['name']?></a></li> -->
                            <li><a href="<?php echo base_url(); ?>Services/<?php echo $section[0]['controller']?>"><?php echo $section[0]['name']?></a></li>
                                </ul>

                            <?php }

                            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ')
                            {

                                if(!empty($data))
                                   {

                                  foreach ($data as $value) {
                                   ?>
                                <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                                </ul>
                            <?php
                               }
                              }
                               if(!empty($data1))
                               {

                                  foreach ($data1 as $value) {
                            ?>
                                <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                                </ul>
                            <?php
                               }
                              }

                             }else{

                                if($this->session->userdata('user_type') =='EMPLOYEE' 
                                    || $this->session->userdata('user_type') =='AGENT' )
                                { 
                                     
                                  if(!empty($data1))
                               {

                                  foreach ($data1 as $value) {
                            ?>
                                <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                                </ul>
                            <?php
                               }
                              }

                                if(!empty($data))
                               {

                                foreach (@$data as $value) {
                                echo "<ul aria-expanded='false' class='collapse'>
                                 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
                                </ul>";
                            
                                }
                            }
                                }
                                else{
                                

                                if(!empty($data1) && !empty($data))
                               {
                                  foreach ($data1 as $value) {
                                    foreach ($data as $val){
                                    if ($value->serv_id == $val->servc_id) {
                                        echo "<ul aria-expanded='false' class='collapse'>
                                 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
                                </ul>";
                                    }
                                }                               
                            
                                }

                                 foreach ($data as $value) {
                                echo "<ul aria-expanded='false' class='collapse'>
                                 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
                                </ul>";
                            
                                }





                               }

                               elseif(empty($data1))
                               {
                                  foreach ($data as $value) {
                                echo "<ul aria-expanded='false' class='collapse'>
                                 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
                                </ul>";
                            
                                }

                               }
                               elseif(empty($data))
                               {

                                  foreach ($data1 as $value) {
                            ?>
                                <ul aria-expanded="false" class="collapse">
                            <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                                </ul>
                            <?php
                               }
                              }


                          }
                         }
                           ?>


                                 
                          
                              




                               <!-- foreach ($data1 as $value) { ?>

                                    <ul aria-expanded="false" class="collapse">
                             <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                            </ul> -->

								<!-- echo "<ul aria-expanded='false' class='collapse'>
								 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
								</ul>"; -->
							
								<?php 
                                
                          //  } else {

                           // foreach ($data as $value) {
                            ?>
                           <!--  <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                            </ul> -->
                            <?php
                           // }
                           // }
                           ?>
                           </li> 
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
