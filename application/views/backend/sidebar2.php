        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                        <?php 
                        $id = $this->session->userdata('user_login_id');
                        $basicinfo = $this->employee_model->GetBasic($id);
						// $dep_id = $basicinfo->dep_id;
						// $dep = $this->employee_model->getdepartment1($dep_id);
						
      //                   if (!empty($dep)) {
      //                       $dep_name = $dep->dep_name;
      //                   }else{}
                        ?>
                <div class="user-profile">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basicinfo->em_image ?>" alt="user" />
                        <!-- this is blinking heartbit-->
                        <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </div>

                    <!-- User profile text-->
                    <div class="profile-text">
                        <h5><?php echo $basicinfo->first_name.' '.$basicinfo->last_name; ?></h5>
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
                                <li><a href="<?php echo base_url();?>organization/Department">Department </a></li>
                                <li><a href="<?php echo base_url();?>organization/Designation">Designation</a></li>

                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi')?>">My Kpi</a>
                                        </li>
                                       
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
								<li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li>
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
                                <li><a href="<?php echo base_url();?>organization/add_counters">Counters</a></li>
                                
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
                        <li> <a class="has-arrow waves-effect waves-dark" href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($basicinfo->em_id); ?>" aria-expanded="false">
								<i class="mdi mdi-account-multiple"></i><span class="hide-menu">Employees </span></a>
                        </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
								<i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
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
                                        <?php if($basicinfo->em_id == "Kas1574"){ ?>

                                        <li>
                                            <a href="<?php echo base_url('kpi/kpi_form')?>">Kpi Form</a>
                                        </li>
                                       
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi1')?>">Objective List</a>
                                        </li>

                                        <?php }?>
                                       
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi')?>">My Kpi</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('kpi/kpi_report')?>">Kpi Report</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('kpi/general_kpi_report')?>">General Kpi Report</a>
                                        </li>
                                       
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
							   
                        <?php }elseif($this->session->userdata('user_type') =='ADMIN'
								){ ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
									<i class="fa fa-building-o"></i><span class="hide-menu">Organization </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo base_url();?>organization/Region">Region </a></li>
                                <li><a href="<?php echo base_url();?>organization/District">District </a></li>
                                <li><a href="<?php echo base_url();?>organization/Branches">Region Branches</a></li>
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
                                <li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a href="<?php echo base_url(); ?>Payroll/Salary_Scale">Salary Scale </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Salary_Type"> Payroll Type </a></li> -->
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Add Salary To Employee </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_Slips">Salary Slips</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Salary List </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payed_Salary"> Payslip Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Deductions_Report"> Deductions Report</a></li>
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
								
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        
                                        <li>
                                            <a href="<?php echo base_url('kpi/kpi_form')?>">Kpi Form</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi')?>">My Kpi</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('kpi/kpi_report')?>">Kpi Report</a>
                                        </li>
                                        
                                        <li>
                                            <a href="<?php echo base_url('kpi/general_kpi_report')?>">General Kpi Report</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi1')?>">Objective List</a>
                                        </li>
                                    </ul>
                                </li>
                                
                        <?php }elseif($this->session->userdata('user_type') =='CRM' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' ){ ?>
                       <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                        <span class="hide-menu"><img src="<?php echo base_url(); ?>assets/images/slip.png" width="20"> &nbsp;My Payroll </span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        <!-- <li><a href="<?php echo base_url(); ?>leave/Holidays"> Holiday </a></li> -->
                                        <li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip">
                                                Salary Payslip </a></li>
                                        <!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->
                                    </ul>
                                </li>
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><span class="hide-menu">
                                            <img src="<?php echo base_url(); ?>assets/images/expend.png" width="20">  &nbsp;Kpi</span></a>
                                    <ul aria-expanded="false" class="collapse">
                                        
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi')?>">My Kpi</a>
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
                                        
                                        <li>
                                            <a href="<?php echo base_url('kpi/my_kpi')?>">My Kpi</a>
                                        </li>
                                       
                                    </ul>
                                </li>
								<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
								<ul aria-expanded="false" class="collapse">
									<li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
									<li><a href="<?php echo base_url(); ?>leave/Leave_report"> Report </a></li>
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
										<li><a href="<?php echo base_url(); ?>Payroll/Salary_Payslip">
												Salary Payslip </a></li>
										<!-- <li><a href="<?php echo base_url(); ?>leave/EmLeavesheet"> Leave Sheet </a></li> -->
									</ul>
								</li>
							<?php }  elseif($this->session->userdata('user_type') =='DISPATCH' ){ ?>

                        <?php } else { ?>

                        <?php } ?>
                    <?php } ?>
						<?php if ($this->session->userdata('user_type') == 'HR-PAY'){?>
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                <i class="mdi mdi-rocket"></i><span class="hide-menu">Leave </span></a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="<?php echo base_url(); ?>leave/Application"> Leave Application </a></li>
                               
                            </ul>
                            </li> 
                                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Payroll </span></a>
                            <ul aria-expanded="false" class="collapse">
                                 <li><a href="<?php echo base_url(); ?>Payroll/Salary_Scale">Salary Scale </a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Salary_Type"> Payroll Type </a></li> -->
                                <li><a href="<?php echo base_url(); ?>employee/Employees">Add Salary To Employee </a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Salary_Slips">Salary Slips</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Salary_List"> Salary List </a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payed_Salary"> Payslip Report</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Payroll_Salary_list"> Paye List</a></li>
                                 <li><a href="<?php echo base_url(); ?>Payroll/Payroll_report"> Payroll Report</a></li>
                                <!-- <li><a href="<?php echo base_url(); ?>Payroll/Non_PercentD">Non Percentage Deduction</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Percent_Deduction">Percentage Deduction</a></li>
                                <li><a href="<?php echo base_url(); ?>Payroll/Loan_Deduction">Loan  Deduction</a></li> -->
                                 <li><a href="<?php echo base_url(); ?>Payroll/Paye_Chart">Paye Chart</a></li>
                                 <!-- <li><a href="<?php echo base_url(); ?>Payroll/Pension_Chart">Pension Fund Chart</a></li> -->
                            </ul>
                        </li>

						<?php } ?>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <span class="hide-menu"><img src="<?php echo base_url(); ?>assets/images/setting.png"> &nbsp;Posts Services </span></a>
                        <?php  $id = $basicinfo->em_id;
                            $data = $this->employee_model->get_services_byEmId($id);
							$data1 = $this->employee_model->get_services_byEmId1($id);
							//$getStatus = $this->Box_Application_model->get_super_status();

                         //echo json_encode($data) ;  
                            if ($basicinfo->dep_name == "EMS" || $basicinfo->dep_name == "MAILS") {


                                foreach ($data1 as $value) {
                                echo "<ul aria-expanded='false' class='collapse'>
                                 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
                                </ul>";
                            
                                }?>




                               <!-- foreach ($data1 as $value) { ?>

                                    <ul aria-expanded="false" class="collapse">
                             <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                            </ul> -->

								<!-- echo "<ul aria-expanded='false' class='collapse'>
								 <li><a href='"; echo base_url(); echo "Services/$value->serv_name'>$value->description</a></li>
								</ul>"; -->
							
								<?php 
                                
                            } else {

                            foreach ($data as $value) {
                            ?>
                            <ul aria-expanded="false" class="collapse">
                             <li><a href="<?php echo base_url(); ?>Services/<?php echo $value->serv_name ?>"><?php echo $value->description; ?></a></li>
                            </ul>
                            <?php
                            }
                            }
                           ?>
                           </li> 
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
