<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-truck" style="color:#1976d2"> </i> Add Vehicle </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active"> Fleet Profile </li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
       <div class="row m-b-10">
                <div class="col-12">
                    
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>services/Fleet" class="text-white"><i class="" aria-hidden="true"></i> Add Vehilce  </a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Fleet/list_vehicle" class="text-white"><i class="" aria-hidden="true"></i> List Vehicles </a></button>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Vehicle Form
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
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

                           <form method="POST" action="<?php echo base_url('Fleet/save_vehicle');?>" enctype="multipart/form-data">

                                <div class="row">

                                <div class="col-md-3">
                                <label> Vehicle Image: </label>
                                <input type="file" name="image_url" class="form-control">
                                </div>

                                <div class="col-md-3">
                                <label> Vehicle Registration Number: </label>
                                <input type="text" name="regno" class="form-control" required>
                                </div> 

                                <div class="col-md-3">
                                <label> Vehicle Make: </label>
                                <input type="text" name="make" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Vehicle Model: </label>
                                <input type="text" name="model" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Chasis Number: </label>
                                <input type="text" name="chasis" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Engine Number: </label>
                                <input type="text" name="engine" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Engine Capacity (CC): </label>
                                <input type="text" name="capacity" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Vehicle Type: </label>
                                <input type="text" name="type" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Insurance Status: </label>
                                <input type="text" name="insurance" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Vehicle Status: </label>
                                <input type="text" name="status" class="form-control" required>
                                </div>

                                <div class="col-md-3">
                                <label> Year of Manufacture: </label>
                                <input type="date" name="manufacture" class="form-control" required>
                                </div>


                                <div class="col-md-3">
                                <label> Region: </label>
                                <select name="region" value="" class="form-control" required id="regiono" onChange="getDistrict();">
                                            <option value=""> Region </option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                </select>
                                </div>

                                <div class="col-md-3">
                                <label> Branch: </label>
                                <select name="branch" value="" class="form-control"  id="branchdropo">  
                                 <option> Branch </option>
                                </select>
                                </div>



                                </div>
                                <br>
                               

                                <div class="row"><!--
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-info disable">Save Information</button>
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
