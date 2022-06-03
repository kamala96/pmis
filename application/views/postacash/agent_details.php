<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-8 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Posta Cash Agent Details of <?php echo @$info->agent_fname.' '.@$info->agent_mname.' '.@$info->agent_lname; ?> | Agent No. <?php echo @$info->agent_no; ?></h3>
        </div>
        <div class="col-md-4 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posta Cash Agent</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">


<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/registered_agent" class="text-white"><i class="" aria-hidden="true"></i> Registered Agents </a></button>

<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_agents_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>


                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-body">

                         <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                          <?php } ?>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Agent Information</span></a> </li>

                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#attachment" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Agent Attachments</span></a> </li>

                                <?php if($this->session->userdata('user_type') == 'SUPER ADMIN'){ ?>

                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Account Details</span></a> </li>

                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Reset Password</span></a> </li>

                                <?php } ?>

                            </ul>
                            <!-- Tab panes -->

                            <div class="tab-content">
                                <div class="tab-pane active" id="home2" role="tabpanel">
                                <form action="<?php echo site_url('Posta_Cash/update_agent_information');?>" method="post" enctype="multipart/form-data">

                                <input type="hidden" name="agentid" value="<?php echo @$info->agent_id; ?>">

                                <br>
                                     
                                 <div class="row">
                                <div class="col-md-3">
                                    <label><h4>First Name*</h4></label>
                                    <input type="text" name="fname" id="fname" value="<?php echo @$info->agent_fname; ?>" class="form-control fname" placeholder="Enter First name" required>
                                </div>

                                 <div class="col-md-3">
                                    <label><h4>Middle Name</h4></label>
                                    <input type="text" name="mname" id="mname" value="<?php echo @$info->agent_mname; ?>" class="form-control mname" placeholder="Enter Middle Name">
                                </div>

                                 <div class="col-md-3">
                                    <label><h4>Last Name*</h4></label>
                                    <input type="text" name="lname" id="lname" value="<?php echo @$info->agent_lname; ?>" class="form-control lname" placeholder="Enter Last Name" required>
                                </div>

                               
                                <div class="col-md-3">
                                    <label><h4>E-mail Address*</h4></label>
                                    <input type="email" name="email" id="email" value="<?php echo @$info->agent_email; ?>" class="form-control email" placeholder="Enter Valid E-mail Address" required>
                                </div>

                                </div>
                                
                                <hr>

                                <div class="row">
                                <div class="col-md-3">
                                    <label><h4>Phone Number*</h4></label>
                                    <input type="text" name="phone" id="phone" value="<?php echo @$info->agent_phone; ?>" class="form-control phone" placeholder="Enter Valid Phone Number">
                                </div>
                            

                                <div class="col-md-3">
                                <label><h4>Region*</h4></label>
                                <select name="region" class="form-control region" required id="regiono" onChange="getDistrict();">
                                            <option value="<?php echo @$info->agent_region; ?>"> <?php echo @$info->agent_region; ?> </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="col-md-3">
                                <label><h4>Branch*</h4></label>
                                <select name="branch" class="form-control branch"  id="branchdropo">  
                                 <option value="<?php echo @$info->agent_branch; ?>"> <?php echo @$info->agent_branch; ?> </option>
                                </select>
                                </div>

                                 <div class="col-md-3">
                                    <label><h4>Address*</h4></label>
                                    <input type="text" name="address" value="<?php echo @$info->agent_address; ?>" id="address" class="form-control address" placeholder="Enter Physical Address">
                                </div>

                                </div>

                                <hr>


                                 <div class="row">
                                <div class="col-md-3">
                                    <label><h4>TIN Number*</h4></label>
                                    <input type="text" name="tinnumber" value="<?php echo @$info->agent_tin; ?>" id="tin" class="form-control tin" placeholder="Enter TIN Number" required>
                                </div>

                                <div class="col-md-3">
                                    <label><h4>Business Licence Number*</h4></label>
                                    <input type="text" name="licencenumber" value="<?php echo @$info->agent_licencenumber; ?>" id="licencenumber" class="form-control licencenumber" placeholder="Enter Business Licence Number" required>
                                </div>


                                 <div class="col-md-3">
                                    <label><h4>National ID Number*</h4></label>
                                <input type="text" name="nationalidnumber" value="<?php echo @$info->agent_nationalid; ?>" id="nationalid" class="form-control nationalid" placeholder="Enter National ID" required>
                                </div>

                                <div class="col-md-3">
                                    <label><h4>Upload New Business Licence*</h4></label>
                                    <input type="file" name="licencefile" id="blicence" class="form-control blicence">
                                </div>


                                </div>
                                
                                <hr>

                                <div class="row">

                                <div class="col-md-3">
                                    <label><h4>Upload New TIN Number*</h4></label>
                                    <input type="file" name="tinfile" id="tinfile" class="form-control tinfile">
                                </div>
                                
                                <div class="col-md-3">
                                    <label><h4>Upload New National ID*</h4></label>
                                    <input type="file" name="nationalidfile" id="nationalidfile" class="form-control nationalidfile">
                                </div>

                                </div>


                                <br>
                                <div class="row">
                                     <div class="col-md-6">
                                   <button type="submit" class="btn btn-primary save" id="save"> <i class="fa fa-check"></i> Update Information </button>
                                    </div>
                                </div>


                                 </form>

                                </div>


                                <div class="tab-pane  p-20" id="attachment" role="tabpanel">
TIN Number:  <a href="<?php echo base_url();?>assets/images/poshacash_files/<?php echo @$info->agent_tin_number_file; ?>" target="_tab"> <i class="fa fa-file"></i> Download </a> <hr> 
Business Licence:  <a href="<?php echo base_url();?>assets/images/poshacash_files/<?php echo @$info->agent_business_licence_file; ?>" target="_tab"> <i class="fa fa-file"></i> Download </a> <hr> 
National ID:  <a href="<?php echo base_url();?>assets/images/poshacash_files/<?php echo @$info->agent_nida_file; ?>" target="_tab"> <i class="fa fa-file"></i> Download </a> <hr> 
                                </div>
                                <div class="tab-pane  p-20" id="profile2" role="tabpanel">
                    
                    <form action="<?php echo site_url('Posta_Cash/update_agent_account_details'); ?>" method="post">

                    <input type="hidden" name="agentid" value="<?php echo @$info->agent_id; ?>">

                    <div class="form-group row">
                    <div class="col-md-6">
                    <select class="form-control"  style="width:100%;" name="status" required>
                    <option value="<?php echo @$info->agent_status; ?>">
                    <?php 
                    if(@$info->agent_status=='Blocked'){
                    echo "Suspended";
                    } else {
                    echo @$info->agent_status; 
                     }
                    ?>
                    </option>
                    <option value="Active"> Active </option>
                    <option value="Blocked"> Suspended </option>
                    </select>
                    </div>
                    </div>
                   
                    <div class="row">
                    <div class="col-md-6">
                    <button type="submit" class="btn btn-primary save" id="save"> <i class="fa fa-check"></i> Update Account Details </button>
                    </div>
                    </div>
                    
                    </form>
                                </div>
                                <div class="tab-pane p-20" id="messages2" role="tabpanel">

                    <form action="<?php echo site_url('Posta_Cash/reset_agent_password'); ?>" method="post">

                    <input type="hidden" name="agentid" value="<?php echo @$info->agent_id; ?>">

                    <div class="form-group row">
                    <div class="col-md-6">
                    <input type="text" name="password" class="form-control" required placeholder="Enter New Password">
                    </div>
                    </div>
                   
                    <div class="row">
                    <div class="col-md-6">
                    <button type="submit" class="btn btn-primary save" id="save"> <i class="fa fa-check"></i> Reset Password </button>
                    </div>
                    </div>
                    
                    </form>


                                </div>
                            </div>
                    

                      




                    </div>
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

<?php $this->load->view('backend/footer'); ?>

