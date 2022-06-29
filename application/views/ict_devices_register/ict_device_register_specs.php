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

                <a href="<?php echo base_url('services/ict_register_categories'); ?>" class="btn btn-primary text-white"><i class="fa fa-list" aria-hidden="true"></i> Categories </a>

                <a href="<?php echo base_url('services/ict_category_specs'); ?>" class="btn btn-primary text-white <?php echo $current_tab == 'specs' ? 'active':''; ?>"><i class="fa fa-list" aria-hidden="true"></i> Specifications </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-12">

                <!-- Error Area Start -->
                <div id="error_message" class="alert alert-danger" role="alert" style="display:none;"></div>
                <div id="success_message" class="alert alert-info" role="alert" style="display:none;"></div>



                <!-- Form Area End -->
                <div class="collapse mb-2" id="DisplayAddICTRegisterSpecs">
                    <div class="card card-outline-info">

                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> Add New ICT Device Specifications</h4>
                        </div>

                        <div class="card-body">
                            <form id="addICTRegisterSpecs" method="post" action="javascript:void(0);">
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Category</label>
                                        <select name="category" id="category" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Specification Label</label>
                                        <input type="text" id="label" name="label" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Input Field</label>
                                        <select name="type" id="type" class="form-control">
                                            <option disabled selected>Please Select Input Field</option>
                                            <option value="text">Text Field</option>
                                            <option value="number">Number Field</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Input Name</label>
                                        <input type="text" id="name" name="name" class="form-control" >
                                    </div>
                                </div>                      
                                <div class="form-group">
                                    <button type="submit" id="btnSubmit" class="btn btn-primary"> Save </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Form End -->


                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> AVAILABLE LIST OF SPECIFICATIONS </h4>
                        <button class="btn btn-outline-primary float-right" data-toggle="collapse" data-target="#DisplayAddICTRegisterSpecs">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Specs
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="ICTRegisterCategoriesSpecsDataTable">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Label</th>
                                        <th>Input Field</th>
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
// Populate category dropdown list with ajax on page load
$(document).ready(function () {  
 $.ajax({  
     type: "GET",  
     url: "<?php echo base_url('services/get_all_ict_device_categories_ajax_dropdown'); ?>",  
     data: "{}",
     success: function (data) {  
        data = JSON.parse(data)
        var s = '<option disabled selected>Please Select a Category</option>'; 
        $.each(data, function(key, value) {
            s += '<option value="' + value.category_id + '">' + value.category_name + '</option>';
        });
        $("#category").html(s);  
    }  
});  
});

// load data into datatable
$(document).ready(function() {
    $('#ICTRegisterCategoriesSpecsDataTable').dataTable({
        "processing": true,
        "ajax": "<?php echo base_url('services/get_all_ict_category_specs_ajax'); ?>",
        "columns": [
        {data: 'category'},
        {data: 'label'},
        {data: 'input_field'},
        ],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});


// Ajax call to save ict devices
$(function () {
    $("#addICTRegisterSpecs").validate({
        rules: {
            category: {
                required: true,
                number: true,
            },
            label: {
                required: true,
            },
            type: {
                required: true,
            },
            name: {
                required: true,
            },
        },
        messages: {},

        submitHandler: function () {
            $("#isloading").show()
            var formdata = $('#addICTRegisterSpecs').serialize();
            $.ajax({
                url: "<?php echo base_url('services/add_ict_category_specs_ajax_call'); ?>",
                type: "POST",
                data: formdata,
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        // Reload a table
                        $('#ICTRegisterCategoriesSpecsDataTable').DataTable().ajax.reload();
                        
                        // Reset form
                        $("#addICTRegisterSpecs")[0].reset();

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
                        'An error occured, request not sent' + textStatus);
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
