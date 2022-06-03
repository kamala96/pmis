<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Philatelic Stamp</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Philatelic Stamp</li>
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
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Stock/Otherlist" class="text-white"><i class="" aria-hidden="true"></i>  Back Others List</a></button>
                        
                    </div>
                </div>
               <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Other Stock<span class="pull-right " ></span></h4>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>
                            <div class="card-body">

                                <form class="row" method="post" action="Saveother" enctype="multipart/form-data">
                                     <div class="form-group col-md-3 m-t-20">
                                        <label>Issue Date </label>
                                        <input type="date" name="issuedate" class="form-control form-control-line" placeholder="Issue Date number" required="required"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>End Date</label>
                                        <input type="date" name="enddate" class="form-control form-control-line" placeholder="End Date"  required ="required"> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Stamp Name </label>
                                        <input type="text"  name="stampname" class="form-control form-control-line" value="" placeholder="Stamp Name" > 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Denomination </label>
                                        <input type="text" name="denomination" class="form-control form-control-line" value="" placeholder="Denomination" required> 
                                    </div>
                                   <div class="form-group col-md-3 m-t-20">
                                        <label>Quantity </label>
                                       <input type="number"  name="quantity" class="form-control form-control-line" value="" placeholder="Quantity"  required> 
                                    </div>
                                     <div class="form-group col-md-3 m-t-20">
                                        <label>Price Per Mint </label>
                                         <input type="number" id="" name="pricepermint" class="form-control form-control-line" value="" placeholder="Price Per Mint"  required> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Price Per Souverant Sheet </label>
                                        <input type="number" name="pricepersouverantsheet"  class="form-control" placeholder="Price Per Souverant Sheet" required> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Price Per F D Cover </label>
                                        <input type="number"  name="priceperfdcover" class="form-control form-control-line" value="" placeholder="Price Per F D Cover"  required> 
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

