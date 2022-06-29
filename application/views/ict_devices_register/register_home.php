<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
	<!-- 	<div class="col-md-5 align-self-center">
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

                <a href="<?php echo base_url('services/ICT_Devices_Register'); ?>" class="btn btn-primary <?php echo $current_tab == 'dashboard' ? 'active':''; ?> text-white"><i class="fa fa-list" aria-hidden="true"></i> Dashboard </a>

                <a href="<?php echo base_url('services/ict_register_categories'); ?>" class="btn btn-primary text-white"><i class="fa fa-list" aria-hidden="true"></i> Categories </a>

                <a href="<?php echo base_url('services/ict_category_specs'); ?>" class="btn btn-primary text-white"><i class="fa fa-list" aria-hidden="true"></i> Specifications </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-12">

                <!-- Error Area Start -->
                <div id="error_message" class="alert alert-danger" role="alert" style="display:none;"></div>
                <div id="success_message" class="alert alert-info" role="alert" style="display:none;"></div>



                <!-- Form Area End -->
                <div class="collapse mb-2" id="DisplayAddICTRegister">
                    <div class="card card-outline-info">

                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> Add New ICT Device </h4>
                        </div>

                        <div class="card-body">
                            <form id="addICTRegister" method="post" action="javascript:void(0);">
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Device Category *</label>
                                        <select name="category" id="category" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Model Name *</label>
                                        <input type="text" id="model" name="model" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Device Serial Number *</label>
                                        <input type="text" id="serial" name="serial" class="form-control">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 form-group">
                                        <label>Device Asset Number</label>
                                        <input type="text" id="asset" name="asset" class="form-control" >
                                    </div>
                                </div>
                                <div class="alert alert-info" role="alert" id="infoDiv" style="display:none;"></div>                        
                                <div class="input-group mb-2" id="category_specs"></div>
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
                        <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> LIST OF AVAILABLE ICT DEVICES </h4>

                        <div class="btn-group float-right" role="group" aria-label="Basic example">
                          <button type="button" class="btn btn-outline-primary" data-toggle="collapse" data-target="#DisplayAddICTRegister"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Device</button>
                          <button type="button" class="btn btn-outline-primary" data-toggle="collapse" data-target="#DisplayAddICTRegisterr"> <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Send Devices</button>
                      </div>
                  </div>

                  <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="ICTRegisterDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Serial Number</th>
                                    <th scope="col">Asset Number</th>
                                    <th scope="col">Detailed Specifications</th>
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

// Display specs according to category
$(function() {
    $('#category').bind('change', function(ev) {
    // data: {valueType: value, html: encodeURIComponent($("#addhtml").html())}
    var value = $(this).val();

    $("#infoDiv" ).fadeIn("slow", function() {
        $("#category_specs").html("");
        $('#btnSubmit').prop('disabled', false);
    }).html("Searching for specifications......");

    $.ajax({
        type: "GET",
        url: "<?php echo base_url('services/get_ict_device_category_specs_ajax');?>",  
        data: {category: value},  
        tryCount : 0,
        retryLimit : 3,
        success: function (data) {
            if (!$.trim(data)){
                $("#infoDiv" ).html("Oops!, no response. Please add specifications for this category");
            }
            else
            {
                data = JSON.parse(data)
                var s = '';
                $.each(data, function(key, value) {
                    s += '<div class="input-group-prepend"><span class="input-group-text">' + value.spec_label + 
                    '</span></div><input type="' + value.spec_type + '" name="' + value.spec_name + '" id="' + 
                    value.spec_name + '" class="form-control">';
                });
                $( "#infoDiv" ).fadeOut("slow", function() {
                    $("#category_specs").html(s);
                    $('#btnSubmit').prop('disabled', false);
                });
            }
        },
        error : function(xhr, textStatus, errorThrown ) {
            if (textStatus == 'timeout') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                //try again
                $.ajax(this);
                return;
            }            
            return;
        }
        if (xhr.status == 500) {
            $("#infoDiv" ).html("Oops!, " + textStatus);
        } else {
            $("#infoDiv" ).html("Oops!, " + textStatus);
        }
    }
});
});
});

// load data into datatable
$(document).ready(function() {
    $('#ICTRegisterDataTable').dataTable({
        "processing": true,
        "ajax": "<?php echo base_url('services/get_all_ict_devices_ajax'); ?>",
        "columns": [
        {data: 'title'},
        {data: 'model'},
        {data: 'serial'},
        {data: 'asset'},
        {data: 'detailed_specs'},
        ],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});


// Ajax call to save ict devices
$(function () {
    $("#addICTRegister").validate({
        rules: {
            category: {
                required: true,
                number: true,
            },
            model: {
                required: true,
            },
            serial: {
                required: true,
            },
        },
        messages: {},

        submitHandler: function () {
            $("#isloading").show()
            var formdata = $('#addICTRegister').serialize();
            console.log(formdata)
            $.ajax({
                url: "<?php echo base_url('services/add_ict_device_ajax_call'); ?>",
                type: "POST",
                data: formdata,
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        // Reload a table
                        $('#ICTRegisterDataTable').DataTable().ajax.reload();
                        
                        // Reset form
                        $("#addICTRegister")[0].reset();

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


// $.ajax({
//     url : 'someurl',
//     type : 'POST',
//     data :  ....,   
//     tryCount : 0,
//     retryLimit : 3,
//     success : function(json) {
//         //do something
//     },
//     error : function(xhr, textStatus, errorThrown ) {
//         if (textStatus == 'timeout') {
//             this.tryCount++;
//             if (this.tryCount <= this.retryLimit) {
//                 //try again
//                 $.ajax(this);
//                 return;
//             }            
//             return;
//         }
//         if (xhr.status == 500) {
//             //handle error
//         } else {
//             //handle error
//         }
//     }
// });

</script>

<?php $this->load->view('backend/footer'); ?>
