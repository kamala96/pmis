<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Legal Section</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Legal Section</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">

                     <?php if($this->session->userdata('user_type') == "ADMIN"){ ?>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>organization/Contract" class="text-white"><i class="" aria-hidden="true"></i> Contract Type</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>organization/Agreement" class="text-white"><i class="" aria-hidden="true"></i> Agreement Type</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Services/legal" class="text-white"><i class="" aria-hidden="true"></i> Contract List </a></button>
                     <?php } ?>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Register Contract                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div id="div1"> 
                        <?php if (empty($id)) {?>
                        <form method="post" action="contract_action" enctype="multipart/form-data"> 
                                <div class="row">
                            
                                <div class="form-group col-md-4">
                                    <label>Contract Type</label>
                                    <select name="cont_type" class="custom-select form-control ag" required="" onChange="getAgreement();">
                                        <option value="">--Select Contract Type--</option>
                                        <?php foreach ($service as  $value) {?>
                                           <option value="<?php echo $value->cont_id ?>"><?php echo $value->cont_name ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                        <label>Agreement Type</label>
                                        <select name="agreement_type" value="" class="form-control custom-select agrId">  
                                            <option>--Select Service Type--</option>
                                        </select>

                                    </div>
                                <div class="form-group col-md-4">
                                <label>Parties Names</label>
                                    <input type="text" name="parties_name" class=" form-control" required="required">
                                </div>
                                <div class="form-group col-md-4">
                                <label>Mobile Number</label>
                                    <input type="text" name="mobile" class=" form-control" required="required" onkeypress="myFunction()" id="day13" >
                                    <span class="errorPhone" style="color: red;display: none;">This is not valid Phone number</span>

                                </div>
                                <div class="form-group col-md-4">
                                <label>Region</label>
                                    <select class="form-control custom-select" name="con_region" required="" >
                                        <option value="">--Select Region--</option>
                                    <?php foreach ($regionlist as $value) {?>
                                    <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                    <button class="btn btn-info btn-primary" type="submit">Save Information</button>
                                    </div>
                                </div>
                        </form> 
                       <?php }else{ ?>

                        <form method="post" action="contract_action" enctype="multipart/form-data"> 
                                <div class="row">
                            
                                <div class="form-group col-md-4">
                                    <label>Contract Type</label>
                                    <select name="cont_type" class="custom-select form-control ag" required="" onChange="getAgreement();">
                                        <option><?php echo $contItem->cont_name; ?></option>
                                        <option value="">--Select Contract Type--</option>
                                        <?php foreach ($service as  $value) {?>
                                           <option value="<?php echo $value->cont_id ?>"><?php echo $value->cont_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                 <div class="form-group col-md-4">
                                        <label>Agreement Type</label>
                                        <select name="branch" value="" class="form-control custom-select agrId">  
                                             <option><?php echo $contItem->agreement_type; ?></option>
                                            <option>--Select Service Type--</option>
                                        </select>

                                    </div>
                                <div class="form-group col-md-4">
                                <label>Parties Name</label>
                                    <input type="text" name="partie_name" class=" form-control" required="required" value="<?php echo $contItem->parties_name; ?>">
                                </div>
                               
                                <div class="form-group col-md-4">
                                <label>Mobile Number</label>
                                    <input type="text" name="mobile" class=" form-control" required="required" onkeypress="myFunction()" id="day13" value="<?php echo $contItem->mobile; ?>">
                                    <span class="errorPhone" style="color: red;display: none;">This is not valid Phone number</span>

                                </div>
                                <div class="form-group col-md-4">
                                <label>Region</label>
                                    <select class="form-control custom-select" name="con_region" required="" >
                                        <option><?php echo $contItem->region; ?></option>
                                        <option value="">--Select Region--</option>
                                    <?php foreach ($regionlist as $value) {?>
                                    <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                        <label>Start Date </label>
                                        <input type="text" name="start_date" id=""  class="form-control mydatetimepickerFull" placeholder="" required="" value="<?php echo $contItem->start_date ?>"> 
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Contract Year </label>
                                        <select name="contract_year" class="form-control custom-select">
                                            <option><?php echo $contItem->contract_year ?></option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Scaned Contract ( Maximum Size 2MB )</label>
                                        <input type="file" name="image_url" id=""  class="form-control" placeholder="" > 
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Payment Mode </label>
                                        <select name="mode_payment" class="form-control custom-select" required="">
                                            <option><?php echo $contItem->mode_payment ?></option>
                                            <option value="">--Select Payment Mode--</option>
                                            <option>Monthly</option>
                                            <option>Quarterly</option>
                                            <option>Semiannual</option>
                                            <option>Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Contract Price</label>
                                        <input type="number" name="cont_price" id=""  class="form-control" placeholder="" required="" value="<?php echo $contItem->cont_price ?>"> 
                                    </div>
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                    <input type="hidden" name="cont_id" id=""  class="form-control" placeholder="" required="" value="<?php echo $contItem->contid ?>">
                                    <button class="btn btn-info btn-primary" type="submit">Save Information</button>
                                    </div>
                                </div>
                        </form> 

                        <?php }?>
                                </div>

                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

                </div>
           
            </div>
        </div>


<script type="text/javascript">
        function getAgreement() {
     var agid = $('.ag').val();
     $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>organization/getAgreement",
      data:'ag_id='+ agid,
     success: function(data){
          $(".agrId").html(data);
      }
  });
};
</script>


<?php $this->load->view('backend/footer'); ?>

