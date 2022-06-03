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
                        <li class="breadcrumb-item active">Stock</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Box_Application/Stock" class="text-white"><i class="" aria-hidden="true"></i> Back Stock List</a></button>

                        
                    </div>
                </div>
               <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i>  Add New Stock Request<span class="pull-right " ></span></h4>
                            </div>
                            <div class="card-body">

                                <form  method="POST" action="Save_Request">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label>Stock Type </label>
                                        <select class="custom-select form-control" name="stock_type">
                                            <option>--Select Type--</option>
                                            <?php foreach ($category as $value) {?>
                                                <option><?php echo $value->CategoryName; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Stock Name </label>
                                        <input type="text"  name="stock_name" class="form-control form-control-line" required="required" > 
                                    </div>
                                    
                                   <div class="form-group col-md-4">
                                        <label>Quantity </label>
                                       <input type="text"  name="quantity" class="form-control form-control-line"  placeholder=""  required> 
                                    </div>
                                     
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                        <button type="button" class="btn btn-info">Cancel</button>
                                    </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered table-strip" id="example4">
                                            <thead>
                                                <tr>
                                                    <th>Requested Date</th>
                                                    <th>Stock Type</th>
                                                    <th>Stock Name</th>
                                                    <th>Quantity Requested</th>
                                                    <th>Quantity Issue </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stockrequest as $value) { ?>
                                                    <tr>
                                                        <td><?php echo $value->requested_date ?></td>
                                                        <td><?php echo $value->stock_type ?></td>
                                                        <td><?php echo $value->stock_name ?></td>
                                                        <td><?php echo $value->quantity_requested ?></td>
                                                        <td><?php echo $value->quantity_received ?></td>
                                                        <td>
                                                            <form action="Receive_Reject" method="POSt">
                                                                <input type="hidden" name="id" value="<?php echo $value->request_id ?>">
                                                                <?php if($value->quantity_received == 0){ ?>
                                                                <?php }else{?>
                                                                <button type="submit" class="btn btn-info">Receive</button >|<button type="submit" class="btn btn-danger">Reject</button>
                                                            <?php } ?>
                                                            </form>
                                                            </td>
                                                    </tr>
                                                <?php } ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

