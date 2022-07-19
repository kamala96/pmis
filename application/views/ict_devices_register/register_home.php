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

        <!-- Add Pool Area Start -->
        <div class="row">            
            <div class="col-12">
                <div class="modal fade" id="poolModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">CREATING A POOL</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addPool" method="post" action="javascript:void(0);">
                                <div class="modal-body">
                                    <div class="alert alert-secondary" id="modalDevice" role="alert"></div>

                                    <textarea type="text" id="ids" name="ids" class="form-control" style="display:none;" required></textarea>
                                    
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Count</span>
                                        </div>
                                        <input type="number" id="modalCount" name="modalCount" min="1" class="form-control" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="totalAvailable">Loading ...</span>
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Destination</label>
                                        </div>
                                        <select class="custom-select" id="modalDestination" name="modalDestination" required>
                                            <option selected disabled>Choose...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary"> Add To a Pool</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Add Pool Area End -->

        <!-- Display Pool ---- Start -->
        <div class="row">            
            <div class="col-12">
                <div class="modal fade" id="displayPool" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="displayPoolLabel">Loading Contents ...</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm" id="poolDataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Specifications</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="confirmClicked" class="btn btn-primary">Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Display Pool  .....   End -->

        <!-- Form Area Start - Add ICT Register -->
        <div class="row">            
            <div class="col-12">
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
                                <div class="form-row" id="category_specs"></div>
                                <div class="form-group">
                                    <button type="submit" id="btnSubmit" class="btn btn-primary"> Save </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form End Area - Add ICT Register-->

        <!-- Display Devices - Start-->
        <div class="row">            
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i> LIST OF AVAILABLE ICT DEVICES </h4>
                        <div class="btn-group float-right" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#DisplayAddICTRegister">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Add New Device
                            </button>
                        </div>
                        <div class="btn-group float-right mr-2" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#displayPool">
                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <span id="poolCount"> Loading ... </span>
                            </button>
                        </div>
                        <!-- Notification Area Start -->
                        <div id="error_message" class="alert alert-warning" role="alert" style="display:none;"></div>
                        <div id="success_message" class="alert alert-info" role="alert" style="display:none;"></div>
                        <!-- Notification Area End -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-hover" id="ICTRegisterDataTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Model</th>
                                            <th scope="col">Serial Number</th>
                                            <th scope="col">Asset Number</th>
                                            <th scope="col">Detailed Specifications</th>
                                            <th scope="col">Manage</th>
                                            <th scope="col">Location</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!-- Display Devices - End-->

        <!-- Container fluid end -->
    </div>
    <!-- Page wrapper end -->
</div>

<script type="text/javascript">
    $(document).ready(function () { 

// Populate category dropdowns list with ajax on page load 
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
    $("#category_on_send").html(s);
}  
});
find_devices_in_a_pool()
});

    function find_devices_in_a_pool(){    
    // Count and load total devices available in a pool 
    $.ajax({  
       type: "GET",  
       url: "<?php echo base_url('services/count_devices_in_a_pool'); ?>",  
       data: "{}",
       success: function (data) {  
        data = JSON.parse(data);
        text = "No items";
        if(data == 1) text = '1 item';
        else text = data + ' items';
        $("#poolCount").html('(' + text + ') Pool');
    }  
});
}


// Display specifications according to the selected category
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
                $("#infoDiv" ).html("This category has no any specification!");
            }
            else
            {
                data = JSON.parse(data);
                var s = '';
                $.each(data, function(key, value) {
                    var required = value.spec_is_required == 1 ? 'required' : '';
                    s += ' <div class="col-sm-12 col-md-6 col-lg-6 input-group mb-3"><div class="input-group-prepend"><span class="input-group-text" id="' + value.spec_name + '">' + value.spec_label + '</span></div><input type="' + value.spec_type + '" name="' + value.spec_name + '" id="' + value.spec_name + '" class="form-control" aria-describedby="' + value.spec_name + '" '+ required + '></div>';
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


// ######## Get all devices according to the selected category
$(function() {
    $('#category_on_send').bind('change', function(ev) {
        var value = $(this).val();

        $("#infoDivInSendForm" ).fadeIn("slow", function() {
        // $("#category_specs").html("");
        // $('#btnSubmit').prop('disabled', false);
    }).html("Prepairing for search query......");

        $.ajax({
            type: "GET",
            url: "<?php echo base_url('services/get_all_devices_by_category_ajax');?>",  
            data: {category: value},  
            tryCount : 0,
            retryLimit : 3,
            success: function (data) {
                console.log(data);
                $( "#infoDivInSendForm" ).fadeOut("slow", function() {
                    // $("#category_specs").html(s);
                    // $('#btnSubmit').prop('disabled', false);
                });
            // }
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
            $("#infoDivInSendForm" ).html("Oops!, " + textStatus);
        } else {
            $("#infoDivInSendForm" ).html("Oops!, " + textStatus);
        }
    }
});
    });
});


// load data into datatable on page load
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
        {
            "mData": null,
            "bSortable": false,
            "mRender": function (data, type, full)
            {
                if(full.is_available)
                {
                    return '<button type="button" onclick="sendClicked(' + full.id + ')" class="btn btn-primary">'
                    + '<i class="fa fa-plus-circle"></i>' + ' Pool' + '</button>';
                }
                else
                {
                    return 'No action';
                }
            }
        },
        {data: 'where_located'},
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
            // console.log(formdata)
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
                        }, 6000);
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

function sendClicked(id){
    $("#isloading").show()
    $("#addPool").trigger("reset");
    $('#modalDevice').text('');  
    $.ajax({
        url: "<?php echo base_url('services/get_similar_devices_ajax_call'); ?>",
        type: "post",
        data: {id: id},
        dataType: "json",
        success: function (response) {
            $("#isloading").hide()
            if (response.status) {
                var device = response.data.device
                var modalDevice = device.category_name + ' | ' + device.dev_model + ' | ' + device.dev_detailed_specs
                var modalCount = Number(response.data.total)
                var modalDestination = response.data.regions

                var ids_toArray = []
                var ids = response.data.ids
                $.each(ids, function(key, value) {
                    ids_toArray.push(value)
                });
                var ids_toArray = ids_toArray.toString()

                $('#poolModal').modal('show').on('shown.bs.modal', function () {
                    $('#modalDevice').text(modalDevice);                    
                    $("#ids").val(ids_toArray);
                    $('#totalAvailable').text('Available: ' + modalCount);

                    var input = document.getElementById("modalCount");
                    input.setAttribute("max",modalCount);
                    
                    $.each(modalDestination, function(key, value) {
                        $('#modalDestination')
                        .append($("<option></option>")
                            .attr("value", +value.reg_code)
                            .text('RM - ' + value.region_name));                  
                    });
                }) 
            } else {
                $("#isloading").hide()
                console.log("Problem ", data)
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#isloading").hide()
            console.error(errorThrown)
        }
    });
}


// Ajax save pool to temporary table
$(function () {
    $("#addPool").validate({
        rules: {
            ids: {required: true,},
            modalCount: {required: true, number: true,},
            modalDestination: {required: true, number: true,},
        },
        messages: {},

        submitHandler: function () {
            $("#isloading").show()
            var formdata = $('#addPool').serialize();
            // console.log(formdata)
            $.ajax({
                url: "<?php echo base_url('services/add_devices_to_pool_ajax'); ?>",
                type: "POST",
                data: formdata,
                dataType: "JSON",
                success: function (response) {
                    $('#poolModal').modal('hide')
                    $('#ICTRegisterDataTable').DataTable().ajax.reload();
                    find_devices_in_a_pool();
                    $("#isloading").hide();
                    if (response.status) {
                        console.log(response)
                        $('#success_message').fadeIn().html(response.data);
                        setTimeout(function () {
                            $('#success_message').fadeOut("slow");
                        }, 4000);
                    } else {
                        console.log(response)
                        $('#error_message').fadeIn().html(response.data);
                        setTimeout(function () {
                            $('#error_message').fadeOut("slow");
                        }, 6000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#poolModal').modal('hide')
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



// When pool modal is shown, request and append it with data
$('#displayPool').on('shown.bs.modal', function (e) {
    $('#displayPoolLabel').text('Devices in a Pool');
    $('#poolDataTable').dataTable({
        "processing": true,
        responsive: true,
        "pageLength": 5,
        "ajax": "<?php echo base_url('services/get_pool_data_ajax'); ?>",
        "columns": [
        {data: 'title'},
        {data: 'serial'},
        {data: 'specs'},
        {data: 'destination'},
        {
            "mData": null,
            "bSortable": false,
            "mRender": function (data, type, full)
            {
                return '<button type="button" onclick="removeClicked(' + full.id + ')" class="btn btn-primary">'
                    + '<i class="fa fa-trash-o"></i>' + '</button>';
            }
        },
        ],
    });
})

// When "displayPool" modal is closed, destroy datatable
$('#displayPool').on('hidden.bs.modal', function () {
    $('#poolDataTable').dataTable().fnDestroy();
});

function removeClicked(id){
    $("#isloading").show()
    $.ajax({
        url: "<?php echo base_url('services/remove_pool_ajax_call'); ?>",
        type: "post",
        data: {id: id},
        dataType: "json",
        success: function (response) {
            $('#poolDataTable').DataTable().ajax.reload();
            $('#ICTRegisterDataTable').DataTable().ajax.reload();
            find_devices_in_a_pool();
            $("#isloading").hide();
            // console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#isloading").hide()
            // console.error(errorThrown)
        }
    });
}

$(document).ready(function() {
    $("#confirmClicked").click(function(){
        $('#displayPool').modal('hide')
        $("#isloading").show()
        $.ajax({
            url: "<?php echo base_url('services/confirm_pool_ajax_call'); ?>",
            type: "post",
            data: {},
            success: function (response) {
                $('#ICTRegisterDataTable').DataTable().ajax.reload();
                find_devices_in_a_pool();
                $("#isloading").hide();
                console.log(response);
                if (response.status) {
                    $('#success_message').fadeIn().html(response.data);
                    setTimeout(function () {
                        $('#success_message').fadeOut("slow");
                    }, 6000);                    
                }else{
                    $('#error_message').fadeIn().html(response.data);
                    setTimeout(function () {
                        $('#error_message').fadeOut("slow");
                    }, 6000);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#isloading").hide();
                $('#error_message').fadeIn().html('An error occured, request not sent');
                setTimeout(function () {
                    $('#error_message').fadeOut("slow");
                }, 4000);
                console.error(errorThrown)
            }
        });
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
