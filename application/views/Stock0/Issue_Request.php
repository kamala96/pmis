<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Stock</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Issue Stock Request</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Box_Application/Stock" class="text-white"><i class="" aria-hidden="true"></i> Back Stock List</a></button>
            

                        <?php if($this->session->userdata('sub_user_type') == 'STORE'){ ?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Stock/Stock_Request_Incomming" class="text-white"><i class="" aria-hidden="true"></i> Strong Room Request</a></button>
                        <?php }elseif($this->session->userdata('sub_user_type') == 'STRONGROOM'){ ?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Stock/Stock_Request_Incomming" class="text-white"><i class="" aria-hidden="true"></i> Request From Branch</a></button>
                        <?php }elseif($this->session->userdata('sub_user_type') == 'BRANCH'){ ?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-list"></i><a href="<?php echo base_url(); ?>Stock/Stock_Request_Incomming" class="text-white"><i class="" aria-hidden="true"></i> Request From Counter</a></button>
                        <?php }?>
                    </div>
                </div>
               <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Issue Stock Request<span class="pull-right " ></span></h4>
                            </div>
                            <div class="card-body">

                                <form  method="POST" action="Issue_Process">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Stock Type </label>
                                    <select class="custom-select form-control" name="stock_type" readonly>
                                            <option><?php echo $requestbyId->stock_type;?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Stock Name </label>
                                        <input type="text"  name="stock_name" class="form-control form-control-line" value="<?php echo $requestbyId->stock_name;?>" required="required" readonly > 
                                    </div>
                                    
                                   <div class="form-group col-md-4">
                                        <label>Quantity </label>
                                       <input type="text"  name="quantity" class="form-control form-control-line" value="<?php echo $requestbyId->quantity_requested;?>" placeholder="" readonly> 
                                    </div>
                                     <input type="hidden"  name="request_id" class="form-control form-control-line" value="<?php echo $requestbyId->request_id;?>" placeholder="" readonly>
                                     <input type="hidden"  name="region" class="form-control form-control-line" value="<?php echo $requestbyId->requested_region;?>" placeholder="" readonly> 
                                     <input type="hidden"  name="branch" class="form-control form-control-line" value="<?php echo $requestbyId->requested_branch;?>" placeholder="" readonly> 
                                     <input type="hidden"  name="counter" class="form-control form-control-line" value="<?php echo $requestbyId->requested_counter;?>" placeholder="" readonly> 
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Issue</button>
                                        <button type="button" class="btn btn-info">Cancel</button>
                                    </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
    <script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
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
<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(600).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},600);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>
<script>
$( "#target" ).keyup(function() {
  //alert( "Handler for .keyup() called." );
});
</script>

<?php $this->load->view('backend/footer'); ?>

