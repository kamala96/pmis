<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
   <div class="message"></div>
   <div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-user-secret" style="color:#1976d2"></i> <?php echo @$basic->first_name .' '.@$basic->last_name; ?></h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </div>
</div>
<?php $degvalue = $this->employee_model->getdesignation(); ?>
<?php $depvalue = $this->employee_model->getdepartment(); ?>
<?php
if($this->session->userdata('user_type') =='SUPER ADMIN'){
    $usertype = $this->employee_model->getusertype_superadmin(); 
}else{
    $usertype = $this->employee_model->getusertype(); 
}

 

 ?>
<?php $empservices = $this->organization_model->get_services(); ?>
<?php $empSubservices = $this->organization_model->get_subservices(); ?>

<?php 
$dep_id = @$basic->dep_id;
$depvalue1 = $this->employee_model->getdepartment1($dep_id); ?>
<?php $regvalue = $this->employee_model->regselect(); ?>
<?php $branchvalue = $this->employee_model->branchselect(); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab" style="font-size: 14px;">  Personal Info </a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#address" role="tab" style="font-size: 14px;"> Address </a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#education" role="tab" style="font-size: 14px;"> Education</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#referee" role="tab" style="font-size: 14px;"> Referee</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#experience" role="tab" style="font-size: 14px;"> Experience</a> </li>
                    <!-- <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#bank" role="tab" style="font-size: 14px;"> Bank Account</a> </li> -->
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#document" role="tab" style="font-size: 14px;"> Document</a> </li>
                    <li class="nav-item"> <a class="nav-link" 
                       data-toggle="tab" href="#family23" role="tab" style="font-size: 14px;">Family</a> </li>                                
                       <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab" style="font-size: 14px;"> Change Password</a> </li>
                       <?php if ($this->session->userdata('user_type')=='ADMIN') {?>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#resetpassword" role="tab" style="font-size: 14px;"> Reset Password</a> </li>
                    <?php  }  ?>

                </ul>
                <!-- Tab panes -->

                <div class="tab-content">
                 <div class="tab-pane" id="password" role="tabpanel">
                    <div class="card-body">
                        <form class="row" action="Reset_Password" method="post" enctype="multipart/form-data">
                            <div class="form-group col-md-6 m-t-20">
                                <label>Old Password</label>
                                <input type="password" class="form-control" name="old" value="" placeholder="old password" required > 
                                <!-- minlength="6" -->
                            </div>
                            <div class="form-group col-md-6 m-t-20">
                                <label>Password</label>
                                <input type="password" onchange="verifyPassword(this)" class="form-control" name="new1" value="" > 
                                <!-- required minlength="6" -->
                                <span id="showPasswordMsg"></span>
                            </div>
                            <div class="form-group col-md-6 m-t-20">
                                <label>Confirm Password</label>
                                <input type="password" id="" name="new2" class="form-control " required > 
                                <!-- minlength="6" -->
                            </div>
                            <div class="form-actions col-md-12">
                                <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">                                                   
                                <button type="submit" id="passswordChecking" class="btn btn-info pull-right"> <i class="fa fa-check"></i> Save</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="resetpassword" role="tabpanel">
                    <div class="card-body">
                        <form class="row" action="Password_reset" method="post" enctype="multipart/form-data">
                            <div class="form-group col-md-6 m-t-20">
                                <label>Employee PF Number</label>
                                <input type="text" class="form-control" name="pfnumber" value="" placeholder="Enter PF Number" required> 
                            </div>
                            <div class="form-group col-md-6 m-t-20">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" value="" required> 
                            </div>

                            <div class="form-actions col-md-12">

                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="document" role="tabpanel">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="documents" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>File Title</th>
                                        <th>File </th>
                                        <th>Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php foreach($fileinfo as $value): ?>
                                    <tr>
                                        <td><?php echo $value->file_title ?></td>
                                        <td><a href="<?php echo base_url(); ?>assets/images/users/<?php echo $value->file_url ?>" target="_blank"><?php echo $value->file_url ?></a></td>
                                        <td><a href="" class="btn btn-info btn-sm">Edit</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>                                    
                <div class="card-body">
                    <form class="row" action="Add_File" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-6 m-t-5">
                            <label class="">File Title</label>
                            <input type="text" name="title"  class="form-control" required="" aria-invalid="false" minlength="5" required>
                        </div>
                        <div class="form-group col-md-6 m-t-5">
                            <label class="">File</label>
                            <input type="file" name="file_url"  class="form-control" required="" aria-invalid="false" required>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="em_id" value="<?php echo $basic->em_id; ?>">                                                   
                                <button type="submit" class="btn btn-info">Add File</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
           
        <div class="tab-pane" id="experience" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="experiences" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Company name</th>
                                    <th>Position </th>
                                    <th>Work Duration </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tbody>
                                 <?php foreach($experience as $value): ?>
                                    <tr>
                                        <td><?php echo $value->exp_company ?></td>
                                        <td><?php echo $value->exp_com_position ?></td>
                                        <td><?php echo $value->exp_workduration ?></td>
                                        <td class="jsgrid-align-center ">
                                         <div class="input-group">
                                            <a href="#" title="Edit" class="btn btn-sm btn-info waves-effect waves-light experience" data-id="<?php echo $value->id ?>"><i class="fa fa-pencil-square-o"></i>Edit</a> &nbsp;

                                            <form method="post" action="delete_experience">
                                               <input type="hidden" name="expid" value="<?php echo $value->id; ?>">
                                               <button class="btn btn-info btn-sm">Delete</button>
                                           </form>
                                       </div>
                                   </td>
                               </tr>
                           <?php endforeach; ?>
                       </tbody>
                   </table>
               </div>
           </div>                                     
           <div class="card-body">
            <form class="row" action="Add_Experience" method="post" enctype="multipart/form-data">
                <div class="form-group col-md-6 m-t-5">
                    <label> Company Name</label>
                    <input type="text" name="company_name" class="form-control form-control-line company_name"  placeholder="Company Name" required> 
                </div>
                <div class="form-group col-md-6 m-t-5">
                    <label>Position</label>
                    <input type="text" name="position_name" class="form-control form-control-line position_name" placeholder="Position" required> 
                </div>
                <div class="form-group col-md-6 m-t-5">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control form-control-line duty" placeholder="Address"  required> 
                </div>
                <div class="form-group col-md-6 m-t-5">
                    <label>Working Duration</label>
                    <input type="text" name="work_duration" class="form-control form-control-line working_period"  placeholder="Working Duration" required> 
                </div>

                <div class="form-actions col-md-12">
                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">                                                
                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="tab-pane" id="referee" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive ">
                <table id="referees" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Fullname</th>
                            <th>Occupation </th>
                            <th>Email </th>
                            <th>Mobile</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                     <?php foreach($referee as $value): ?>
                        <tr>
                            <td><?php echo $value->first_name.' '.$value->middle_name.' '.$value->last_name ?></td>
                            <td><?php echo $value->occupation ?></td>
                            <td><?php echo $value->email ?></td>
                            <td><?php echo $value->mobile ?></td>

                            <td class="jsgrid-align-center ">
                                <form action="Delete_Referee" method="post">
                                    <input type="hidden" name="ref_id" value="<?php echo $value->ref_id?>">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>                                    
</div>
<div class="card">

    <div class="card-body">
        <form class="row" action="Add_Referee" method="post" enctype="multipart/form-data" id="insert_education">
            <span id="error"></span>
            <div class="form-group col-md-4 m-t-5">
                <label>First Name</label>
                <input type="text" name="fname" class="form-control form-control-line" placeholder="First Name"  minlength="3" required> 
            </div>
            <div class="form-group col-md-4 m-t-5">
                <label>Middle name</label>
                <input type="text" name="mname" class="form-control form-control-line" placeholder="Middle Name" minlength="3" required> 
            </div>
            <div class="form-group col-md-4 m-t-5">
                <label>Last name</label>
                <input type="text" name="lname" class="form-control form-control-line" placeholder=" Last Name"  minlength="3" required> 
            </div>
            <div class="form-group col-md-4 m-t-5">
                <label>Occupation</label>
                <input type="text" name="occupation" class="form-control form-control-line" placeholder=" Occupation"   required> 
            </div>
            <div class="form-group col-md-4 m-t-5">
                <label>Email</label>
                <input type="email" name="email"  class="form-control form-control-line" placeholder="xxx@xx.com"> 
            </div>
            <div class="form-group col-md-4 m-t-5">
                <label>Mobile Number</label>
                <input type="text" name="mobile"  class="form-control form-control-line" placeholder="+255716XXXXXX"> 
            </div>
            <div class="form-actions col-md-6">
                <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
            </div>
        </form>
    </div>
</div>
</div>

<div class="tab-pane" id="education" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive ">
                <table id="" class="display nowrap table table-hover table-striped table-bordered family" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Year From</th>
                            <th>Year To</th>
                            <th>Name Of School</th>
                            <th>Certification</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php foreach($education as $value): ?>
                        <tr>
                            <td><?php echo $value->yearFrom ?></td>
                            <td><?php echo $value->yearTo ?></td>
                            <td><?php echo $value->schoolname ?></td>
                            <td><?php echo $value->certification ?></td>

                            <td class="jsgrid-align-center ">
                                <a href="Edit_Education?I=<?php echo base64_encode($value->id)?>&Ei=<?php echo base64_encode($value->emp_id)?>" title="Edit" class="btn btn-sm btn-warning waves-effect waves-light"><i class="fa fa-pencil-square-o"></i> Edit Education</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>                                    
</div>
<div class="card">

    <div class="card-body">
        <form class="row" action="Add_Education" method="post" enctype="multipart/form-data" id="insert_education">
            <span id="error"></span>
            <div class="form-group col-md-6 m-t-5">
                <label>Year From</label>
                <select class="form-control custom-select" id="years" name="yearFrom">
                 <option>--Select Year--</option>      
             </select> 
         </div>
         <div class="form-group col-md-6 m-t-5">
            <label>Year To</label>
            <select class="form-control custom-select" id="yearsTo" name="yearTo">
             <option>--Select Year--</option>      
         </select> 
     </div>
     <div class="form-group col-md-6 m-t-5">
        <label>Name Of School</label>
        <input type="text" name="schoolname" class="form-control form-control-line" placeholder="Name Of School"  required> 
    </div>
    <div class="form-group col-md-6 m-t-5">
        <label>Certification</label>
        <input type="text" name="certification"  class="form-control form-control-line" placeholder="Certification"> 
    </div>

    <div class="form-actions col-md-6">
        <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
    </div>

</form>
</div>
</div>                                    
</div>
<div class="tab-pane" id="address" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <table id="" class="display nowrap table table-hover table-striped table-bordered family" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Address Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 <?php foreach($present as $value){ ?>
                    <tr>
                        <td><?php echo $value->address ?></td>
                        <td><?php echo $value->city ?></td>
                        <td><?php echo $value->country ?></td>
                        <td><?php echo $value->type ?></td>

                        <td class="jsgrid-align-center ">
                            <div class="input-group">
                                <a href="#" title="Edit" class="btn btn-sm btn-info waves-effect waves-light experience" data-id="<?php echo $value->id ?>"><i class="fa fa-pencil-square-o"></i>Edit</a> &nbsp;

                                <form method="post" action="delete_address">
                                   <input type="hidden" name="addid" value="<?php echo $value->id; ?>">
                                   <button class="btn btn-info btn-sm">Delete</button>
                               </form>
                           </div>
                       </td>
                   </tr>
               <?php }?>
           </tbody>
       </table>
       <br>
       <br>
       <hr>
       <form class="row" action="Parmanent_Address" method="post" enctype="multipart/form-data">
        <div class="form-group col-md-4 m-t-5">
            <label>Select Address Type</label>
            <select class="custom-select form-control" name="partype">
                <option>Present Address</option>
                <option>Permanent Address</option>
            </select>
        </div>
        <div class="form-group col-md-4 m-t-5">
            <label>City</label>
            <input type="text" name="parcity" class="form-control form-control-line" placeholder=""   required> 
        </div>
        <div class="form-group col-md-4 m-t-5">
            <label>Country</label>
            <input type="text" name="parcountry" class="form-control form-control-line" placeholder=""   required> 
        </div>
        <div class="form-group col-md-12 m-t-5">
            <label>Address</label>
            <textarea name="paraddress" value="<?php if(!empty($permanent->address)) echo $permanent->address  ?>" class="form-control" rows="3"  required></textarea>
        </div>


        <div class="form-actions col-md-12">
            <input type="hidden" name="emid" value="<?php echo $basic->em_id;?>">
            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
        </div>                                          
    </form>

</div>
</div>
</div>

<div class="tab-pane active" id="home" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30">
                             <?php if(!empty($basic->em_image)){ ?>
                                <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->first_name ?>" title="<?php echo $basic->first_name ?>"/>                                   
                            <?php } ?>
                            <h4 class="card-title m-t-10"><?php echo $basic->first_name .' '.$basic->last_name; ?></h4>
                            <h6 class="card-subtitle"><?php echo $basic->des_name; ?></h6>
                            <!--                                    <input type="file" id="filecount" multiple="multiple">-->
                        </center>
                    </div>
                    <div>
                        <hr> </div>
                        <div class="card-body"> <small class="text-muted">Email address </small>
                            <h6><?php echo $basic->em_email; ?></h6> <small class="text-muted p-t-30 db">Phone</small>
                            <h6><?php echo $basic->em_phone; ?></h6> 
                            
                        </div>
                    </div>                                                    
                </div>
                <div class="col-md-8">
                    <form class="row" action="Update" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group col-md-4 m-t-10">
                            <label>Employee PF Number </label>
                            <input type="text" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control form-control-line" placeholder="ID" name="eid" value="<?php echo $basic->em_code; ?>" required > 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>First Name</label>
                            <input type="text" class="form-control form-control-line" placeholder="Your first name" name="fname" value="<?php echo $basic->first_name; ?>" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> minlength="3" required> 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Middle Name </label>
                            <input type="text" id="" name="mname" class="form-control form-control-line" value="<?php echo $basic->middle_name; ?>" placeholder="Your last name" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> minlength="3"> 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Last Name </label>
                            <input type="text" id="" name="lname" class="form-control form-control-line" value="<?php echo $basic->last_name; ?>" placeholder="Your last name" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> minlength="3" required> 
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Blood Group </label>
                            <select name="blood" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> value="<?php echo $basic->em_blood_group; ?>" class="form-control custom-select">
                                <option value="<?php echo $basic->em_blood_group; ?>"><?php echo $basic->em_blood_group; ?></option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Gender </label>
                            <select name="gender" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control custom-select">

                                <option value="<?php echo $basic->em_gender; ?>"><?php echo $basic->em_gender; ?></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4 m-t-10">
                            <label>Region</label>
                            <select name="region" value="" class="form-control custom-select" required id="region" onChange="getDistrict();">
                                <option value="<?php echo $basic->em_region; ?>"><?php echo $basic->em_region; ?></option>
                                <?Php foreach($regvalue as $value): ?>
                                <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Region Branch</label>
                        <select name="branch" value="" class="form-control custom-select"  id="branchdrop">  
                            <option value="<?php echo $basic->em_branch; ?>"><?php echo $basic->em_branch; ?></option>
                        </select>

                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Department</label>
                        <select onchange="getSections(this);" name="dept" value="" class="form-control custom-select" required>
                            <option value="<?php echo $basic->dep_id; ?>"><?php echo $basic->dep_name; ?></option>
                            <?Php foreach($depvalue as $value): ?>

                            <option value="<?php echo $value->id ?>"><?php echo $value->dep_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                 <div class="form-group col-md-4 m-t-10">
                        <label>Muse Department</label>
                        <?php $musedepvalue = $this->employee_model->getmusedepartment(); ?>
                        <?php  if(!empty($basic->muse_dept_id)){$musedepartmentvalue = $this->employee_model->getmusedepartmentvalue($basic->muse_dept_id);} ?>
                        <select name="musedept" value="" class="form-control custom-select" required>
                            <?php if(!empty($musedepartmentvalue)){ ?>
                                 <option value="<?php echo $musedepartmentvalue->id; ?>"><?php echo $musedepartmentvalue->dep_name; ?>                                   
                                 </option>

                                <?php } else{ ?>
                                     <option value="">--Select Muse Department--</option>

                                <?php }?>
                           
                            <?Php foreach($musedepvalue as $value): ?>
                            <option value="<?php echo $value->id ?>"><?php echo $value->dep_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php if($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='SUPERVISOR'){

                 ?>  
                 <div class="form-group col-md-4 m-t-10">
                        <label>Designation </label>
                        <select name="deg" class="form-control custom-select">
                            <option value="<?php echo $basic->des_id; ?>"><?php echo $basic->des_name; ?></option>
                            <?Php foreach($degvalue as $value): ?>
                            <option value="<?php echo $value->id ?>"><?php echo $value->des_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
             <?php } else { ?>                                                  
                    <div class="form-group col-md-4 m-t-10">
                        <label>Designation </label>
                        <select name="deg" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control custom-select">
                            <option value="<?php echo $basic->des_id; ?>"><?php echo $basic->des_name; ?></option>
                            <?Php foreach($degvalue as $value): ?>
                            <option value="<?php echo $value->id ?>"><?php echo $value->des_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php } ?>
            <?php if($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='SUPERVISOR'){ ?>
                <input type="hidden" class="form-control form-control-line" placeholder="Your first name" name="role" value="<?php echo $basic->em_role; ?>">
                <input type="hidden" name="em_section_role" value="<?php echo $basic->em_section_role ?>">
                                        <input type="hidden" name="em_sub_role" value="<?php echo $basic->em_sub_role ?>">

            <?php } else { ?> 
                <div class="form-group col-md-4 m-t-10">
                    <label>User Type </label>
                    <select name="role" class="form-control custom-select usertype1" required onChange = "getSuper();">
                        <option value="<?php echo $basic->em_role; ?>"><?php echo $basic->em_role; ?></option>
                        <option>Select Role</option>
                        <?Php foreach($usertype as $value): ?>
                        <option value="<?php echo $value->type_name ?>"><?php echo $value->type_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-4 m-t-10 super" style="display: none;" onChange = "getSubSuper();">
                <label>Supervisor Type</label>
                <select name="em_sub_role" class="form-control custom-select" required>
                    <option value="">--Select Supervisor Type--</option>
                    <option value="IntSupervisor">INTERNATIONAL SUPERVISOR</option>
                    <option value="DomSupervisor">DOMESTIC SUPERVISOR</option>
                </select>
            </div>
            <div class="form-group col-md-4 m-t-10 Subsuper" style="display: none;" onChange = "getSubSuper();">
                <label> Sub Supervisor Type</label>
                <select name="em_section_role" class="form-control custom-select" required>
                    <option value="">--Select Sub Supervisor Type--</option>
                    <option value="GPOSupervisor">GPO Supervisor</option>
                    <option value="HPOSupervisor">HPO Supervisor</option>
					<option value="HPOSupervisor">Branch Supervisor</option>
                </select>

            </div>
        <?php } ?>
        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>  <?php } else { ?> 
            <div class="form-group col-md-4 m-t-10">
                <label>Status </label>
                <select name="status" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control custom-select" required >
                    <option value="<?php echo $basic->status; ?>"><?php echo $basic->status; ?></option>
                    <option value="ACTIVE">ACTIVE</option>
                    <option value="INACTIVE">INACTIVE</option>
                </select>
            </div>
        <?php } ?>                                                  
        <div class="form-group col-md-4 m-t-10">
            <label>Date Of Birth </label>
            <input type="text" id="example-email2" name="dob" class="form-control mydatetimepickerFull"placeholder="" value="<?php echo $basic->em_birthday; ?>" required> 
        </div>
        <div class="form-group col-md-4 m-t-10">
            <label>NID Number </label>
            <input type="text" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> class="form-control"placeholder="NID Number" name="nid" value="<?php echo $basic->em_nid; ?>" minlength=""> 
        </div>
        <div class="form-group col-md-4 m-t-10">
            <label>Contact Number </label>
            <input type="text" class="form-control" placeholder="" name="contact" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> value="<?php echo $basic->em_phone; ?>" minlength="10" maxlength="15" required> 
        </div>
        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>  <?php } else { ?>                 
        <?php } ?>

        <div class="form-group col-md-4 m-t-10">
            <label>Date Of Joining </label>
            <input type="text" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> id="example-email2" name="joindate"  class="form-control mydatetimepickerFull" value="<?php echo $basic->em_joining_date; ?>" placeholder=""> 
        </div>
        <div class="form-group col-md-4 m-t-10">
            <label>Contract End Date</label>
            <input type="text" id="example-email2" name="leavedate" class="form-control mydatetimepickerFull" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> value="<?php echo $basic->em_contact_end; ?>" placeholder=""> 
        </div>
        <div class="form-group col-md-4 m-t-10">
            <label>Email </label>
            <input type="email" id="example-email2" name="email" class="form-control" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> value="<?php echo $basic->em_email; ?>" placeholder="email@mail.com" minlength="7" required> 
        </div>

        <div class="form-group col-md-4 m-t-10">
                <label>Sections </label>
                <select id='usersection' name="section" class="form-control custom-select">

                    <?php if (!empty($sectiondata)){ ?>

                        <option value="<?php echo $sectiondata['id'];?>" selected="selected"><?php echo $sectiondata['name'];?></option>

                    <?php }else{ ?>
                        <option selected="selected" disabled="disabled">Select section</option>
                    <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-4 m-t-10">
            <label>Sub-user Type </label>
            <select id='usersection' name="subuser_type" class="form-control custom-select">
                <option selected="selected" disabled="disabled">--Select--</option>
                
                <option <?php if ($basic->subuser_type == 'deriver'){ echo 'selected="selected"';}?> value="deriver">Derivery personel</option>

                <option <?php if ($basic->subuser_type == 'notassigned'){ echo 'selected="selected"';}?> value="deriver">Not assigned</option>

                <option <?php if ($basic->subuser_type == 'Posta mlangoni'){ echo 'selected="selected"';}?> value="Posta mlangoni">Posta Mlangoni</option>

                <option <?php if ($basic->subuser_type == 'Pcum'){ echo 'selected="selected"';}?> value="Pcum">Pcum</option>

                <option <?php if ($basic->subuser_type == 'EMS'){ echo 'selected="selected"';}?> value="EMS">EMS</option>

            </select>
        </div>


        <div class="form-group col-md-12 m-t-10">
         <?php if(!empty($basic->em_image)){ ?>
            <img src="<?php echo base_url(); ?>assets/images/users/<?php echo $basic->em_image; ?>" class="img-circle" width="150" />
        <?php } else { ?>
            <img src="<?php echo base_url(); ?>assets/images/users/user.png" class="img-circle" width="150" alt="<?php echo $basic->first_name ?>" title="<?php echo $basic->first_name ?>"/>                                   
        <?php } ?>
        <label>Image </label>
        <input type="file" <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?> readonly <?php } ?> name="image_url" class="form-control" value=""> 
    </div>

    <?php if($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='AGENT' ){ ?> 
        <!-- <div class="form-group col-md-12 m-t-10">
           <label><h2>Assigned Service</h2></label>
            <br>

            <?php foreach ($empservices as $value1) {?>

                <?php echo $value1->serv_name?> :
                <input type="checkbox" name="serv_id[]" value="<?php echo $value1->serv_id?>" class="" style="padding-bottom: 50px;" 
                <?php 
                foreach ($service2 as $val){
                    if ($value1->serv_id == $val->servc_id) {
                        echo "checked";
                        break;
                    }else{

                    }
                }
                ?>>

            <?php } ?>
        </div> -->

    <?php } else{?>
        <?php if($this->session->userdata('user_type')=='SUPERVISOR'){?> 
            
        <?php }elseif($this->session->userdata('user_type')=='ADMIN'){?> 
            <div class="form-group col-md-12 m-t-10">
                 <label><h2>Assign Service</h2></label>
                <br>

                <?php foreach ($empservices as $value1) {?>

                    <?php echo $value1->serv_name?> :
                    <input type="checkbox" name="serv_id[]" value="<?php echo $value1->serv_id?>" class="" style="padding-bottom: 50px;" 
                    <?php 
                    foreach ($service2 as $val){
                        if ($value1->serv_id == $val->servc_id) {
                            echo "checked";
                            break;
                        }else{

                        }
                    }
                    ?>>

                <?php } ?>
            </div>
            <div class="form-group col-md-12 m-t-10">
                <label><h2>Assign Authorization</h2></label>
                <br>

                <?php foreach ($empSubservices as $value2) {?>

                    <?php echo $value2->sub_name?> :
                    <input type="checkbox" name="em_sub_role" value="<?php echo $value2->sub_name?>" class="" style="padding-bottom: 50px;" 
                    <?php 
                   
                        if ($subrol == $value2->sub_name) {
                            echo "checked";
                        }
                    ?>>

                <?php } ?>
            </div>
           
        <?php } ?> 
    <?php } ?> 

     <div class="form-actions col-md-12">
                <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-info">Cancel</button>
            </div>
      
</form>
</div>
</div>
</div>
</div>
</div>
<div class="tab-pane" id="family23" role="tabpanel">
    <div class="card-body">
        <div class="card card-outline-info">
            <div class="card-body">
                <div class="table-responsive ">
                    <table id="employeesFamily" class="display nowrap table table-hover table-striped table-bordered " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Date Of Birth</th>
                                <th>Gender</th>
                                <th>Age</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                         <?php foreach($family as $value): ?>
                            <tr>
                                <td><?php echo $value->first_name . '  '.$value->middle_name.' '.$value->last_name; ?></td>
                                <td><?php echo $value->dateofbirth; ?></td>
                                <td><?php echo $value->gender; ?></td>
                                <td><?php
                                $dateProvided=$value->dateofbirth;
                                $yearOnly=date('Y', strtotime($dateProvided));
                                $monthOnly=date('m', strtotime($dateProvided));
                                $age = date('Y') - $yearOnly;
                                if ($age == 0)
                                {
                                    echo $age = date('m') - $monthOnly.' '.'Months';
                                }
                                else{
                                    echo $age.'  '.'Years';
                                }
                                ?></td>
                                <td><?php echo $value->title; ?></td>
                                <td class="jsgrid-align-center ">
                                    <div class="input-group">
                                        <a href="<?php echo base_url('employee/edit_person')?>?I=<?php echo base64_encode($value->family_Id);?>" class="btn btn-warning btn-sm">
                                            <i class="fa fa-pencil-square-o"></i> &nbsp;Edit</a> 
                                            <?php if($value->certificate == ''){?>

                                            <?php }else{?>
                                               &nbsp; | &nbsp;
                                               <a href="<?php echo base_url()?>assets/images/users/<?php echo $value->certificate; ?>" class="btn btn-info btn-sm" target="_blank"> View Certificate</a>
                                           <?php  } ?>

                                           <form action="<?php echo base_url('employee/delete_person')?>" method="post">
                                            <input type="hidden" name="family_id" value="<?php echo $value->family_Id ?>">

                                            <?php if ($this->session->userdata('user_type') == 'HR' || $this->session->userdata('user_type') == 'ADMIN'){ ?>
                                                &nbsp; | &nbsp;
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> &nbsp;Delete</button>
                                            <?php } ?>
                                        </form>
                                    </div>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!--                                --><?php //if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                <!--                                    -->
                <!--                                                    --><?php //} else { ?>
                    <form class="row" action="Save_family" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-4">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" required="required">

                        </div>
                        <div class="form-group col-md-4">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Date Of Birth</label>
                            <input type="text" name="dob" id="example-email2" name="example-email" class="form-control mydatetimepickerFull" placeholder="" required> 
                        </div>
                        <div class="form-group col-md-4">
                            <label>Select Gender</label>
                            <select name="gender" class="form-control" required="required">
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Select Title</label>
                            <select name="title" class="form-control" required="required" id="title" onChange="getType();">
                               <option value="Parent">Parent</option>
                               <option value="Child">Child</option>
                               <option value="Spouse">Spouse</option>
                           </select>
                       </div>
                       <div class="form-group col-md-4" id="attatch" style="display: none;">
                        <label><span id="child"></span><span id="spouse"></span></label>
                        <input type="file" name="image_url" class="form-control">
                    </div>
                    <!--                                                --><?php //if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                        <!--                                                    --><?php //} else { ?>
                            <div class="form-actions col-md-12">
                                <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">                                                   
                                <!--                                                     <input type="hidden" name="family_id" value="--><?php //echo $socialmedia->id ?><!--">-->
                                <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save Information</button>
                            </div>
                            <!--                                                    --><?php //} ?>
                        </form>
                        <!--                                            --><?php //}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Column -->
</div>


<script type="text/javascript">
    //Verifying the password > 8

    function verifyPassword(obj){
        var paswordText = $(obj).val();
        //Regular expression for testing, alphanumeric
        //let regex = /^(?=\D*\d)(?=[^a-z]*[a-z])[0-9a-z]+$/i
        //let regex = /(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/i;
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/i;
        
        if (paswordText.length >= 8) {

            var isValid = regex.test(paswordText);

            if (!isValid){
                $('#passswordChecking').hide();
                $('#showPasswordMsg').html('Password must contain, at least one uppercase letter, one lowercase letter, one number and one special character (@$!%*?&)');
            }else{
                $('#passswordChecking').show();
                $('#showPasswordMsg').html('');
            }

        }else{
            $('#passswordChecking').hide();
            $('#showPasswordMsg').html('Please enter at least 8 characters.')
        }
        
    }

</script>




<script type="text/javascript">
    $(document).ready(function () {
        $('#yes').change(function () {
            if (this.checked) {
                $('#comments').show();
                $('#sio').hide();
            }
            else {
                $('#comments').hide();
                $('#sio').show();
            }
        });
        $('#no').change(function () {
            if (this.checked) {
                $('#comments').hide();
                $('#ndio').hide();
            }
            else
            {
                $('#ndio').show();
            }
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
               $("#branchdropo").val(data.trim());
           }
       });
    };
</script>


<?php $this->load->view('backend/em_modal'); ?>                


<script type="text/javascript">
    function getType() {
        var type = $('#title').val();
        if (type == 'Child') {
            $('#attatch').show();
            $('#child').html('Attatch Birthcertificate');
            $('#spouse').html('');
        }else if(type == 'Spouse'){
            $('#attatch').show();
            $('#spouse').html('Attatch Marriage Certificate');
            $('#child').html('');
        }else{
            $('#attatch').hide();
        }
    };
</script>
<script type="text/javascript">
    function getSuper() {
        
        var user = $('.usertype1').val();
        if (user == 'SUPERVISOR') {
            $('.super').show();
        }else{
            $('.super').hide();
            $('.Subsuper').hide();
        }


    };

    function getSubSuper() {
        $('.Subsuper').show();

    };
</script>         
<script type="text/javascript">
    function getDistrict() {
        var val = $('#region').val();
        $.ajax({
           type: "POST",
           url: "<?php echo base_url();?>Employee/GetBranch",
           data:'region_id='+ val,
           success: function(data){
               $("#branchdrop").html(data);
           }
       });
    };
</script>      

<?php $this->load->view('backend/footer'); ?>
<script>
    $('#employeesFamily').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
<?php $this->load->view('backend/footer'); ?>
<script>
    $('.family').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var i = 1;
        $('#add_input').click(function() {
            i++;
            $('#dynamic').append('<tr id="row' + i + '"><td><input type="text" name="name[]" placeholder="Enter Name" class="form-control"/></td><td>&nbsp;</td><td><input type="text" name="amountLoan[]" placeholder="Enter Amount" class="form-control"/></td><td><button type="button" name="remove" id="' + i + '" class="btn_remove">Remove</button></td></tr>');
        });
        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
        $('#submit').click(function() {
            $.ajax({
                url: "insert.php",
                method: "POST",
                data: $('#add_me').serialize(),
                success: function(data) {
                    alert(data);
                    $('#add_me')[0].reset();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
                    $('#example4 thead tr:eq(1) th').not(":eq(3)").each( function (i) {
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

            <script type="text/javascript">
                $(document).ready(function() {
                    // Setup - add a text input to each footer cell
                    $('#example5 thead tr').clone(true).appendTo( '#example5 thead' );
                    $('#example5 thead tr:eq(1) th').not(":eq(3)").each( function (i) {
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

                    var table = $('#example5').DataTable( {
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

                $('#filecount').filestyle({

                    input : false,

                    buttonName : 'btn-danger',

                    iconName : 'glyphicon glyphicon-folder-close'

                });

            </script>

            <script type="text/javascript">
                $(document).ready(function() {

                    var table = $('#referees').DataTable( {
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>
            <script type="text/javascript">
                $(document).ready(function() {

                    var table = $('#documents').DataTable( {
                        orderCellsTop: true,
                        fixedHeader: true,
                        dom: 'Bfrtip',
                        buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                        ]
                    } );
                } );
            </script>
            <script type="text/javascript">
                $(document).ready(function() {

                    var table = $('#experiences').DataTable( {
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

                for (var Y = nowY; Y >= 1900; Y--) {
                    options += "<option>" + Y + "</option>";
                }

                $("#years").append(options);
            </script>
            <script>
                var nowY = new Date().getFullYear(),
                options = "";

                for (var Y = nowY; Y >= 1900; Y--) {
                    options += "<option>" + Y + "</option>";
                }

                $("#yearsTo").append(options);
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


function getSections(obj){
    var departId = $(obj).val();

    $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>Employee/getDepartmentSections",
        data:'departId='+departId,
        dataType:'json',
        success:function(res){
            if (res['status'] == 'Success') {
                $('#usersection').empty();
                $.each(res['msg'], function(index,data){

                    $('#usersection').append("<option value="+data['id']+"  >"+data['name']+"</option>");

                })
            }else{
                $('#usersection').empty();
            }

        },error:function(err){

        }
    })

}

    </script>
            <?php $this->load->view('backend/footer'); ?>