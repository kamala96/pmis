<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<!-- <div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-external-link" style="color:#1976d2"> </i> Requests </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#" >Home </a></li>
				<li class="breadcrumb-item active"> Official Use </li>
			</ol>
		</div> -->
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">

                <a href="<?php echo base_url('services/ICT_Devices_Register'); ?>" class="btn btn-primary text-white"><i class="fa fa-list" aria-hidden="true"></i>Dashboard </a>

                <a href="<?php echo base_url('services/ict_register_categories'); ?>" class="btn btn-primary text-white <?php echo $current_tab == 'categories' ? 'active':''; ?>"><i class="fa fa-list" aria-hidden="true"></i> Categories </a>

                <a href="<?php echo base_url('services/ict_category_specs'); ?>" class="btn btn-primary text-white"><i class="fa fa-list" aria-hidden="true"></i> Specifications </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-12">

                <!-- Error Area Start -->
                <div id="error_message" class="alert alert-danger" role="alert" style="display:none;"></div>
                <div id="success_message" class="alert alert-info" role="alert" style="display:none;"></div>



                <!-- Form Area End -->
                <div class="collapse mb-2" id="DisplayAddICTRegisterCategory">
                    <div class="card card-outline-info">

                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> Add New Category </h4>
                        </div>

                        <div class="card-body">
                            <form id="addICTRegisterCategory" method="post" action="javascript:void(0);">
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>Category Name</label>
                                        <input type="text" id="category_name" name="category_name" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col form-group">
                                        <label>Category Decription</label>
                                        <textarea class="form-control" name="category_description" id="category_description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary"> Save </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Form End -->


                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> AVAILABLE CATEGORIES OF ICT DEVICES </h4>
                        <button class="btn btn-primary float-right" data-toggle="collapse" data-target="#DisplayAddICTRegisterCategory">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add New category
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="ICTRegisterCategoryDataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Further Decriptions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<script type="text/javascript">

// load data into datatable
$(document).ready(function() {
    $('#ICTRegisterCategoryDataTable').dataTable({
        "processing": true,
        "ajax": "<?php echo base_url('services/get_all_ict_device_categories_ajax'); ?>",
        "columns": [
        {data: 'title'},
        {data: 'date_created'},
        {data: 'description'},
        ],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});


// Ajax call to save ict devices
$(function () {
    $("#addICTRegisterCategory").validate({
        rules: {
            category_name: {
                required: true,
            },
        },
        messages: {},

        submitHandler: function () {
            $("#isloading").show()
            var formdata = $('#addICTRegisterCategory').serialize();
            $.ajax({
                url: "<?php echo base_url('services/add_ict_device_category_ajax_call'); ?>",
                type: "POST",
                data: formdata,
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        // Reload a table
                        $('#ICTRegisterCategoryDataTable').DataTable().ajax.reload();
                        
                        // Reset form
                        $("#addICTRegisterCategory")[0].reset();

                        // Hide loader
                        $("#isloading").hide()

                        // Close collapse
                        $('.collapse').collapse('hide')

                        $('#success_message').fadeIn().html(data.data);
                        setTimeout(function () {
                            $('#success_message').fadeOut("slow");
                        }, 4000);
                    } else {
                        $("#isloading").hide()
                        $('#error_message').fadeIn().html(data.data);
                        setTimeout(function () {
                            $('#error_message').fadeOut("slow");
                        }, 4000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#isloading").hide()
                    $('#error_message').fadeIn().html(
                        'An error occured, request not sent');
                    setTimeout(function () {
                        $('#error_message').fadeOut("slow");
                    }, 4000);
                }
            });
        }
    });
});
</script>

<?php $this->load->view('backend/footer'); ?>
