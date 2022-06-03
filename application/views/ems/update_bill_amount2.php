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
                    <a href="<?php echo base_url() ?>Box_Application/Ems" class="btn btn-primary"><i class="fa fa-plus"></i> Ems Application</a>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_Application_List" class="text-white"><i class="" aria-hidden="true"></i> Ems Application List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button>

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
                            <div class="alert alert-success alert-dismissible fade show">
    <strong><?php echo $this->session->flashdata('message'); ?>!</strong>.
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
                            
                             <!-- <form role="form" action="issuepayment" method="post"> -->
        <form role="form" action="update_bill_action1" method="post" id="">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                  <label>Bill Amount:</label>
                    <input type="number" name="amount" class="form-control amount" required="">
                    <input type="hidden" name="commid" class="form-control" value="<?php echo $cId; ?>">
                    <span class="error" style="color: red;"></span>
                </div>
                <!-- <div class="col-md-6">
                  <label>Invoice Date:</label>
                    <input type="text" name="datedue" class="form-control amount mydatetimepickerFull" required="">
                </div>
                <div class="col-md-6">
                  <label>EMS Postage Details:</label>
                    <input type="text" name="description" class="form-control" required="">
                </div> -->
            </div>
            <br>
            <div class="row" style="text-align: left;">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-info btnSave" id=""><span class="glyphicon glyphicon-remove"></span>Save Amount</button>
         
                </div>
            </div>
        </div>
    </form>
        <div style="">
           
            <input type="hidden" name="id" value="<?php echo $cId; ?>">
            
        </div>
        <!-- </form> -->
                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

                </div>
           
            </div>
        </div>
<!-- <div class="modal fade" id="myModal" role="dialog" style="padding-top: 100px;">
    <div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <form role="form" action="issueemspayment" method="post" id="theform">
        <div class="modal-body">
            <h3 style="color: red;">Are sure you want to create bill of : <span class="amount"></span></h3>
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="commid" class="form-control comid" required="">
                    <input type="hidden" name="amount" class="form-control amount" required="">
                </div>
            </div>
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
            <input type="hidden" name="id" id="comid">
            <button type="submit" class="btn btn-default pull-left"><span class="glyphicon glyphicon-remove" id="btnsubmit" onclick="Save();"></span>Yes</button>
         <button type="button" class="btn btn-default pull-left " data-dismiss="modal">No</button>
        </div>
        </form>
        
        </div>
        <div class="modal-footer">
            
        </div>
    
      </div>
      
    </div> -->
 <script>
  $(function(){
  $('.btnSave').on('click', function() {  
  var text = $('.amount').val();
   if(text == ""){
	   
   }else{
	   $(this).prop('disabled', true);
   }

  });
});
</script> 
<script>
$(document).ready(function(){
  $(".myBtn").click(function(){
    
    var id =  $('.comid1').val();
    var amount = $('.amount').val();
    if ( amount == '' || amount == 0) {
      $('.error').html('Amount is not valid !!');
    }else{

      $('.comid').val(id);
      $('.amount').val(amount);
      $('.amount').html(amount);
      $("#myModal").modal();

    }
  });
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
 
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
<?php $this->load->view('backend/footer'); ?>

