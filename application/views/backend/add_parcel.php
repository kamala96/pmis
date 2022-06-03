<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Bulk Information</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Bulk Information</li>
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
                        <a href="<?php echo base_url() ?>parcel/Delivery" class="btn btn-primary"><i class="fa fa-th-list"></i> Total Delivery Bulk</a>
                        <a href="<?php echo base_url() ?>parcel/Sent" class="btn btn-primary"><i class="fa fa-th-list"></i> Total Sent Bulk</a>
                        <a href="<?php echo base_url() ?>parcel/Intransit" class="btn btn-primary"><i class="fa fa-th-list"></i> Total Intransit Bulk</a>
                        <a href="<?php echo base_url() ?>parcel/Intransit" class="btn btn-primary"><i class="fa fa-th-list"></i> Total Outgoing Bulk</a>
                    </div>
                </div>
               <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><img src="<?php echo base_url();?>assets/images/parcel.png" width="20">&nbsp; Add New Bulk Information<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="Save_Info" enctype="multipart/form-data">
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>PF Number</label>
                                         <input type="text" name="pf_number" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Full Name</label>
                                         <input type="text" name="full_name" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Dispatch Number</label>
                                         <input type="text" name="dispatch_number" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Bags Number</label>
                                         <input type="text" name="bags_number" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Iterm Number</label>
                                         <input type="number" name="iterm_number" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                        <label>Region From</label>
                                        <select name="sender_region" value="" class="form-control custom-select"  id="regiono" onChange="getDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-4 m-t-10">
                                        <label>Region To</label>
                                        <select name="receiver_region" value="" class="form-control custom-select" id="regiono" onChange="getDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Transport Name</label>
                                         <input type="text" name="transport_name" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Car Registration Number</label>
                                         <input type="text" name="car_registration" class="form-control" required="required">
                                    </div>
                                    <div class="form-group col-md-4 m-t-10">
                                         <label>Transport Cost</label>
                                         <input type="number" name="transport_cost" class="form-control" required="required">
                                    </div>
                                    
                                
                                 <br><br>
                                    <div class="form-actions col-md-12 m-t-20">
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

