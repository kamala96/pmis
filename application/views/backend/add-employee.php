<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Employee</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
    <?php $degvalue = $this->employee_model->getdesignation(); ?>
    <?php $depvalue = $this->employee_model->getdepartment(); ?>
    <?php $usertype = $this->employee_model->getusertype(); ?>
    <?php  ?>
    <?php $regvalue1 = $this->employee_model->branchselect(); ?>
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Employees" class="text-white"><i class="" aria-hidden="true"></i>  Employee List</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Disciplinary" class="text-white"><i class="" aria-hidden="true"></i>  Disciplinary List</a></button>
                    </div>
                </div>
               <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Add New Employee<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="Save" enctype="multipart/form-data">
                                     <div class="form-group col-md-3 m-t-20">
                                        <label>Employee PF Number </label>
                                        <input type="text" name="eid" class="form-control form-control-line" placeholder="PF number" required="required"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control form-control-line" placeholder="Your first name" minlength="2" required id="district-list"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Middle Name </label>
                                        <input type="text" id="" name="mname" class="form-control form-control-line" value="" placeholder="Your middle name" minlength="2"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Last Name </label>
                                        <input type="text" id="" name="lname" class="form-control form-control-line" value="" placeholder="Your last name" minlength="2" required> 
                                    </div>
                                   <div class="form-group col-md-3 m-t-20">
                                        <label>Gender </label>
                                        <select name="gender" class="form-control custom-select" required>
                                            <option value="">--Select Gender--</option>
                                            <option value="MALE">Male</option>
                                            <option value="FEMALE">Female</option>
                                        </select>
                                    </div>
                                     <div class="form-group col-md-3 m-t-20">
                                        <label>Marital Status </label>
                                        <select name="marital_status" class="form-control custom-select" required>
                                            <option value="">--Select Marital Status--</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Birth </label>
                                        <input type="date" name="dob" id="example-email2" name="example-email" class="form-control" placeholder="" required> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Blood Group </label>
                                        <select name="blood" class="form-control custom-select">
                                            <option>Select Blood Group</option>
                                            <option value="O+">O+</option>
                                            <option value="O-">O-</option>
                                            <option value="A+">A+</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B-">B-</option>
                                            <option value="AB+">AB+</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Region</label>
                                        <select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Region Branch</label>
                                        <select name="branch" value="" class="form-control custom-select"  id="branchdropo">  
                                            <option>Select Branch</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Department</label>
                                        <select name="dept" value="" class="form-control custom-select" required>
                                            <option value="">--Select Department--</option>
                                            <?Php foreach($depvalue as $value): ?>
                                             <option value="<?php echo $value->id ?>"><?php echo $value->dep_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Designation </label>
                                        <select name="deg" class="form-control custom-select" required>
                                            <option value="">--Select Designation--</option>
                                            <?Php foreach($degvalue as $value): ?>
                                            <option value="<?php echo $value->id ?>"><?php echo $value->des_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group col-md-3 m-t-20">
                                        <label>Role </label>
                                        <select name="role" class="form-control custom-select" required>
                                            
                                            <option>Select Role</option>
                                            <?Php foreach($usertype as $value): ?>
                                             <option value="<?php echo $value->type_name ?>"><?php echo $value->type_name ?></option>
                                              <?php endforeach; ?>
                                        </select>
                                    </div> -->
                                    
                                    
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>NIDA (National Identification)</label>
                                        <input type="text" name="nid" class="form-control" value="" placeholder="" minlength=""> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Mobile Number </label>
                                        <input type="text" name="contact" class="form-control" value="" placeholder="+255000000000" minlength="10" maxlength="15" required id="target"> 
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Joining </label>
                                        <input type="date" name="joindate" id="example-email2" name="example-email" class="form-control" placeholder="" > 
                                    </div>
                                    <!-- <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Leaving </label>
                                        <input type="date" name="leavedate" id="example-email2" name="example-email" class="form-control" placeholder=""> 
                                    </div> -->
                                    <!-- <div class="form-group col-md-3 m-t-20">
                                        <label>Username </label>
                                        <input type="text" name="username" class="form-control form-control-line" value="" placeholder="Username"> 
                                    </div> -->
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Email </label>
                                        <input type="email"  name="email" class="form-control" placeholder="email@mail.com" minlength="" required > 
                                    </div><!--
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Password </label>
                                        <input type="text" name="password" class="form-control" value="" placeholder="**********"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Confirm Password </label>
                                        <input type="text" name="confirm" class="form-control" value="" placeholder="**********"> 
                                    </div>-->
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Image </label>
                                        <input type="file" name="image_url" class="form-control" value=""> 
                                    </div>
                                    <div class="form-actions col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                        <button type="button" class="btn btn-info">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    <script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>

<script>
$( "#target" ).keyup(function() {
  //alert( "Handler for .keyup() called." );
});
</script>

<?php $this->load->view('backend/footer'); ?>

