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
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Posta Cash | Register Agent</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Posta Cash</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->

    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">

<button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Posta_Cash/register_agent" class="text-white"><i class="" aria-hidden="true"></i> Register Agent </a></button>

<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Posta_Cash/postacash_agents_dashboard" class="text-white"><i class="" aria-hidden="true"></i> Dashboard </a></button>
                    
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Register Agent
                        </h4>
                    </div>
                    <div class="card-body">

                         <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                          <?php } ?>
                          
                          <?php if($this->session->flashdata('feedback')){ ?> 
                           <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>                         
                          <?php } ?>


                        <form action="<?php echo site_url('Posta_Cash/save_agent_information');?>" method="post" enctype="multipart/form-data">


                                <div id="div1">

                                 <div class="form-group row errorOne" id="errorOne" style="display:none">
                                 <div class="col-sm-6">
                                 <span id="error1" style="color: red;"></span>
                                 </div></div>

                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 1 of 2  - Agent Information</h3> <hr>
                                </div>
                                </div>

                                <div class="row">
                                <div class="col-md-3">
                                    <label><h4>First Name*</h4></label>
                                    <input type="text" name="fname" id="fname" class="form-control fname" placeholder="Enter First name">
                                </div>

                                 <div class="col-md-3">
                                    <label><h4>Middle Name</h4></label>
                                    <input type="text" name="mname" id="mname" class="form-control mname" placeholder="Enter Middle Name">
                                </div>

                                 <div class="col-md-3">
                                    <label><h4>Last Name*</h4></label>
                                    <input type="text" name="lname" id="lname" class="form-control lname" placeholder="Enter Last Name">
                                </div>

                               
                                <div class="col-md-3">
                                    <label><h4>E-mail Address*</h4></label>
                                    <input type="email" name="email" id="email" class="form-control email" placeholder="Enter Valid E-mail Address">
                                </div>

                                </div>
                                
                                <hr>

                                <div class="row">
                                <div class="col-md-3">
                                    <label><h4>Phone Number*</h4></label>
                                    <input type="text" name="phone" id="phone" class="form-control phone" placeholder="Enter Valid Phone Number">
                                </div>
                            

                                <div class="col-md-3">
                                <label><h4>Region*</h4></label>
                                <select name="region" class="form-control region" required id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="col-md-3">
                                <label><h4>Branch*</h4></label>
                                <select name="branch" class="form-control branch"  id="branchdropo">  
                                 <option> Branch </option>
                                </select>
                                </div>

                                 <div class="col-md-3">
                                    <label><h4>Address*</h4></label>
                                    <input type="text" name="address" id="address" class="form-control address" placeholder="Enter Physical Address">
                                </div>

                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                <a href="#" class="btn btn-info" id="nextstep2" class="nextstep2"> Continue <i class="fa fa-chevron-right"></i>  </a>
                                    </div>
                                </div>

                                </div>


                               <div id="div2" style="display: none;">

                                <div class="form-group row errorTwo" id="errorTwo" style="display:none">
                                 <div class="col-sm-6">
                                 <span id="error2" style="color: red;"></span>
                                 </div></div>

                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 2  - Agent Attachments & Business Information</h3> <hr>
                                </div>
                                </div>

                                 <div class="row">
                                <div class="col-md-3">
                                    <label><h4>TIN Number*</h4></label>
                                    <input type="text" name="tinnumber" id="tin" class="form-control tin" placeholder="Enter TIN Number" required>
                                </div>

                                <div class="col-md-3">
                                    <label><h4>Business Licence Number*</h4></label>
                                    <input type="text" name="licencenumber" id="licencenumber" class="form-control licencenumber" placeholder="Enter Business Licence Number" required>
                                </div>


                                 <div class="col-md-3">
                                    <label><h4>National ID Number*</h4></label>
                                <input type="text" name="nationalidnumber" id="nationalid" class="form-control nationalid" placeholder="Enter National ID" required>
                                </div>

                                <div class="col-md-3">
                                    <label><h4>Upload Business Licence*</h4></label>
                                    <input type="file" name="licencefile" id="blicence" class="form-control blicence" required>
                                </div>


                                </div>
                                
                                <hr>

                                <div class="row">

                                <div class="col-md-3">
                                    <label><h4>Upload TIN Number*</h4></label>
                                    <input type="file" name="tinfile" id="tinfile" class="form-control tinfile" required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label><h4>Upload National ID*</h4></label>
                                    <input type="file" name="nationalidfile" id="nationalidfile" class="form-control nationalidfile" required>
                                </div>

                                </div>
                     
                                
                                <br>
                                <div class="row">
                                     <div class="col-md-6">
                                   <a href="#"  class="btn btn-warning back1" id="back1"> <i class="fa fa-chevron-left"></i>   Previous  </a>
                                   <button type="submit" class="btn btn-primary save" id="save"> <i class="fa fa-check"></i> Submit </button>
                                    </div>
                                </div>
                                
                                </div>


                           </form>
                           </div>
                       



                        </div>
                    </div>

                </div>

            </div>
        </div>

<script type="text/javascript">
$('#save').click(function() {
$('#error2').html('Tafadhali subiri, Taarifa za Posta Cash wakala zitapokelewa hivi punde!');
$('#errorTwo').show();
 });
</script>

<script type="text/javascript">
$('#nextstep2').click(function() {
   //check personal information
   var fname = $('.fname').val();
   var lname = $('.lname').val();
   var email = $('.email').val();
   var phone = $('.phone').val();
   var region = $('.region').val();
   var branch = $('.branch').val();


   if(fname == '' || lname=='' || email=='' || phone=='' || region=='' || branch==''){
    $('#error1').html('Please, Fill all Agent Information required(*) fields to continue');
    $('#errorOne').show();
    }
  else{
  $('#error1').hide();
  $('#div1').hide();
  $('#div2').show();
 }
 });


$('#back1').click(function() {
  $('#div2').hide();
  $('#div1').show();
});


$('#nextstep3').click(function() {
   //check personal information
   var manufacturer = $('.manufacturer').val();
   var year = $('.year').val();
   var vnumber = $('.vnumber').val();
   var vcolor = $('.vcolor').val();
   var vtype = $('.vtype').val();

   if(manufacturer == '' || year=='' || vnumber=='' || vcolor=='' || vtype==''){
    $('#error2').html('Please, Fill all Vehicle Information required(*) fields to continue');
    }
  else{
  $('#error2').hide();
  $('#step2').hide();
  $('#step3').show();
 }
 });

$('#back2').click(function() {
  $('#step3').hide();
  $('#step2').show();
});

$('#nextstep4').click(function() {
   //check personal information
   var photofile = $('.photofile').val();
   var licensefile = $('.licensefile').val();
   var cardfile = $('.cardfile').val();
   var clearfile = $('.clearfile').val();
   var vehiclefile = $('.vehiclefile').val();

   if(photofile == '' || licensefile=='' || cardfile=='' || clearfile=='' || vehiclefile==''){
    $('#error3').html('Please, Attach required(*) fields to continue');
    }
  else{
  $('#error3').hide();
  $('#step3').hide();
  $('#step4').show();
 }
 });

 $('#back3').click(function() {
  $('#step4').hide();
  $('#step3').show();
});

</script>


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
