<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Box Number</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add Box Number</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Box_Application/BoxRental" class="btn btn-primary"><i class="fa fa-plus"></i> Box Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Box_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Box Application List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Add Box Number Form                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <form method="post" action="UpdateBoxFull">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <input type="hidden" name="cust_id" value="<?php echo $emslist ?>" class="form-control">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <label>Region</label>
                                  <select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                              </div>
                              <div class="col-md-6">
                                        <label>Region Branch</label>
                                        <select name="branch" value="" class="form-control custom-select"  id="branchdropo">  
                                            <option>Select Branch</option>
                                        </select>
                              </div>
                            </div>
                            <div class="row m-t-20">

                                    <div class="col-md-6" style="" id="box1">
                                    <label>Box Number</label>
                                    <input type="number" name="box_number" id="boxnumber" class="form-control">
                                </div>
                             <!--  <div class="col-md-6">
                                        <label>Box Numbers</label>
                                        <select name="box_number" value="" class="form-control custom-select" required id="boxnumber">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($box_numbers as $value): ?>
                                             <option value="<?php echo $value->box_id ?>"><?php echo $value->box_number ?></option>
                                            <?php endforeach; ?>
                                        </select>
                              </div> -->
                              </div>
                              <div class="row m-t-20">
                              <div class="col-md-6">
                                    <button type="submit" class="btn btn-sm btn-info">Save</button>
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

