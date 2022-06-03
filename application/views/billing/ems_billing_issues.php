<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> EMS Billing Amount</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">EMS Billing Amount</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Box_Application/EMS_Billing" class="btn btn-primary"><i class="fa fa-plus"></i> Add Company</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/ems_billing_list" class="text-white"><i class="" aria-hidden="true"></i> EMS BIlling Companies List</a></button>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> EMS Billing Amount                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <div class="col-md-12">
                <?php if(empty($this->session->flashdata('message'))){ ?>
                <?php }else{ ?>
                     <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong><?php echo $this->session->flashdata('message'); ?></strong>
</div>
                <?php }?>
               
            </div>
                             <!-- <form role="form" action="issuepayment" method="post"> -->
        <form role="form" action="issueemspayment" method="post" id="formID">
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-6">
                  <label>Bill Amount[V.A.T EXCLUSIVE]:</label>
                    <input type="text" name="amount" class="form-control" required="">
                    <input type="hidden" name="commid" class="form-control" value="<?php echo $id; ?>">
                   
                </div>
                <div class="col-md-6">
                  <label>Invoice Date:</label>
                    <input type="text" name="datedue" class="form-control mydatetimepickerFull" required="">
                </div>
                <div class="col-md-6">
                  <label>EMS Postage Details:</label>
                    <input type="text" name="description" class="form-control" required="">
                </div>
            </div>
            <br>
            <div class="row" style="">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-remove"></span>Issue Billing</button>
         
                </div>
            </div>
        </div>
    </form>
        <div style="">
           
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
        </div>
        <!-- </form> -->
                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

                </div>
           
            </div>
        </div>

 <script>
    $(function(){
  $('.btnSave').on('click', function() {  
    $(this).prop('disabled', true);
    return true;
   // $("#formID").submit();
  });
});
</script> 

<?php $this->load->view('backend/footer'); ?>

