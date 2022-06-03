<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style>

	.active_tab1
	{
		background-color:#fff;
		color:#333;
		font-weight: 600;
	}
	.inactive_tab1
	{
		background-color: #f5f5f5;
		color: #333;
		cursor: not-allowed;
	}
	.has-error
	{
		border-color:#cc0000;
		background-color:#ffff99;
	}
</style>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Inland Mails</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active">Inland Mails</li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<?php $regvalue = $this->employee_model->regselect(); ?>
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
				<!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
			   <a href="--><?php //echo base_url() ?><!--Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Inland Mails</a>
			<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Box_Application/Inland_Mails_List" class="text-white"><i class="" aria-hidden="true"></i> Inland Mails List</a></button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-outline-info">
					<div class="card-header">
						<h4 class="m-b-0 text-white"> Inland Mails
						</h4>
					</div>
					<div class="card">
                           <div class="card-body">
                            <div id="div1"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 1 of 4  - Item Details</h3>
                                </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-12">
                                		<table class="" style="width: 35.5%;" cellspacing="4" cellpadding="5">
										<tr><td>
												<label>Select Tariff Type</label>
												<select name="pay_type" class="form-control col-md-4 custom-select" id="pay_type">
													<option>Economy</option>
													<option>Priority</option>
												</select>
											</td>
											<td width="25">&nbsp;</td>
											<td width="25">&nbsp;</td>
										</tr>
									</table>
									<table style="width: 100%;" cellpadding="4" cellspacing="5">
										<tr>
											<td>
												<label>Item Category</label>
												<select class="form-control custom-select col-md-4" name="category" id="category" onchange="getCategory();">
													<option value="">--Select Category--</option>
													<?php foreach ($category as $value):?>
														<option value="<?php echo $value->cat_name;?>"><?php echo $value->cat_name;?></option>
													<?php endforeach;?>
												</select>
											</td>
											<td>
												<label>Sub Category</label>
												<select name="sub_category" value="" class="form-control custom-select cat_lists"  id="cat_list" onchange="getList();">
													<option value="">--Select Sub Category--</option>
												</select>
											</td>
											<td>
												<label class="">Weight Step</label>
												<div id="divshow1">
												<div class="input-group">
													<select name="measure"  id="measure" class="input-group-prepend">
													<option>gms</option>
													<option>kg</option>
												</select>
												<input type="number" name="item_weght" class="form-control" id="weight" placeholder="">

												</div>
											</div>
											<div id="divshow" style="display: none;">
												<div class="input-group">
													<select name="measure1"  id="measure1" class="form-control custom-select">
													<option value="">--Select Weight Step--</option>
													<option value="a1">Local delivery (unaddressed)</option>
													<option value="b2">Local delivery (addressed)</option>
													<option value="c3">Delivery in another town (un addressed).</option>
													<option value="d4">Delivery in another town (addressed).</option>
												</select>
												</div>
											</div>
											<div id="divshow2" style="display: none;">
												<div class="input-group">
													<select name="measure2"  id="measure2" class="form-control custom-select">
													<option value="">--Select Weight Step--</option>
													<option value="e5">Single without enclosure</option>
												</select>
												</div>
											</div>
												
											</td>

										</tr>
										<tr>
											<td><span id="error_category" class="text-danger"></span></td>
											<td><span id="error_weight" class="text-danger"></span></td>
											<td><span id="error_volume" class="text-danger"></span></td>
										</tr>
										<tr>
											<td>
												<label>Destination To</label>
												<select class="form-control custom-select col-md-4" name="destination" id="destination">
													<option value="">--Select Destination--</option>
													<?php foreach ($region as $value):?>
														<option value="<?php echo $value->region_id?>"><?php echo $value->region_name?></option>
													<?php endforeach; ?>
												</select>
												<span id="error_measure2"></span>
											</td>
											<td>
												<label>Stamp</label>
												<input type="text" name="stamp" class="form-control" id="stamp">
											</td>
											<td colspan="">
												<label>Tracking Number</label>
												<input type="text" name="item_number" class="form-control" id="item_number">
											</td>
										</tr>

										<tr><td><span id="error_destination" class="text-danger"></span></td>
											<td><span id="error_stamp" class="text-danger"></span></td>
											<td><span id="error_number" class="text-danger"></span></td>
										</tr>
										<tr>
											<td>
												<button class="btn btn-info btn-sm" id="1step">Next Step</button>
											</td>

										</tr>
									</table>
                                	</div>
                                </div>
                                </div>


                                <div id="div2" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 2 of 4  - Sender Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Full Name:</label>
                                    <input type="text" name="s_fname" id="s_fname" class="form-control" onkeyup="myFunction()">
                                    <span id="errfname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Address:</label>
                                    <input type="text" name="s_address" id="s_address" class="form-control" onkeyup="myFunction()">
                                    <span id="erraddress" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Email:</label>
                                    <input type="email" name="s_email" id="s_email" class="form-control" onkeyup="myFunction()">
                                    <span id="erremail" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="s_mobile" id="s_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="errmobile" style="color: red;"></span>
                                </div>
                              
                                <div class="col-md-6">
                                    <label class="control-label">Region</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getSenderDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="errregion" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>District</label>
                                        <select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">  
                                            <option>--Select District--</option>
                                        </select>
                                        <span id="errdistrict" style="color: red;"></span>
                                </div>
                            </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="1stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm" id="2step">Next Step</button>
                                    </div>
                                </div>
                                </div>


                                <div id="div3" style="display: none;"> 
                                   <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 3 of 4  - Reciever Personal Details</h3>
                                </div>
                                <div class="col-md-6">
                                    <label>Full Name:</label>
                                    <input type="text" name="r_fname" id="r_fname" class="form-control" onkeyup="myFunction()">
                                    <span id="error_fname" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Address:</label>
                                    <input type="text" name="r_address" id="r_address" class="form-control" onkeyup="myFunction()">
                                    <span id="error_address" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Email:</label>
                                    <input type="email" name="r_email" id="r_email" class="form-control" onkeyup="myFunction()">
                                    <span id="error_email" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile Number</label>
                                    <input type="mobile" name="r_mobile" id="r_mobile" class="form-control" onkeyup="myFunction()">
                                    <span id="error_mobile" style="color: red;"></span>
                                </div>
                                 <div class="col-md-6">
                                    <label class="control-label">Region</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="rec_region" onChange="getRecDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                            <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="error_region" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>District</label>
                                        <select name="district" value="" class="form-control custom-select"  id="rec_dropp" required="required">  
                                            <option>--Select District--</option>
                                        </select>
                                        <span id="error_district" style="color: red;"></span>
                                </div>
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                        <button class="btn btn-warning btn-sm" id="2stepBack">Back Step</button>
                                        <button class="btn btn-info btn-sm" id="btn_save">Save Information</button>
                                    </div>
                                </div>
                                </div>

                                <div id="div4" style="display: none;"> 
                                <div class="row">
                                <div class="col-md-12">
                                    <h3>Step 4 of 4  - Payment Information</h3>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-md-12">
                                    <span id="majibu"></span>
                                </div>
                                </div>
                                </div>

                            </div>
                           </div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<?php $this->load->view('backend/footer'); ?>

	
	<script type="text/javascript">
        function getCategory() {
            var cat_name = $('#category').val();
            $.ajax({

                url: "<?php echo base_url();?>Billing/GetCatList",
                method:"POST",
                data:{cat_name:cat_name},//'region_id='+ val,
                success: function(data){
                    $("#cat_list").html(data);

                }
            });
        };
	</script>
	<script type="text/javascript">
        function getList() {
        	var cat_lists = $('.cat_lists').val();

           if (cat_lists == 'Advertising Mail') {

           	 $('#divshow').show();
           	 $('#measure').val('');
           	 $('#measure2').val('');
           	 $('#divshow1').hide();
           	 $('#divshow2').hide();

           }else if(cat_lists == 'Aerogramme&Post Cards'){

           	$('#divshow').hide();
           	 $('#divshow1').hide();
           	 $('#divshow2').show();
           	 $('#measure1').val('');
           	 $('#measure').val('');

           }
           else{

           	$('#divshow').hide();
           	$('#divshow1').show();
           	$('#divshow2').hide();
           	$('#measure1').val('');
           	$('#measure2').val('');
           }
        };
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
            $('#example4 thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

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


	<script type="text/javascript">
    $(document).ready(function() {
        $('#1step').on('click',function(){
        
            if ($('#category').val() == 0) {
                $('#error_category').html('Please Select Category Type');
            }else if($('#cat_list').val() == ''){
                $('#error_weight').html('Please Select Sub Category Type');
            }else{
                $('#div2').show();
                $('#div1').hide();
            }
  });
        $('#1stepBack').on('click',function(){
        $('#div2').hide();
        $('#div1').show();
  });
        $('#2step').on('click',function(){
        if ($('#s_fname').val() == '') {
            $('#errfname').html('This field is required');
        }else if($('#s_mobile').val() == ''){
            $('#errmobile').html('This field is required');
        }else if($('#regionp').val() == ''){
            $('#errregion').html('This field is required');
        }else if($('#branchdropp').val() == ''){
            $('#errdistrict').html('This field is required');
        }else{
        $('#div2').hide();
        $('#div3').show();
        }
  });
        $('#2stepBack').on('click',function(){
        $('#div3').hide();
        $('#div2').show();
  });
});

//save data to databse
$('#btn_save').on('click',function(){
    
            var emstype   = $('#boxtype').val();
            var emsCat = $('#tariffCat').val();
            var weight = $('#weight').val();
            var s_fname     = $('#s_fname').val();
            var s_address     = $('#s_address').val();
            var s_email     = $('#s_email').val();
            var s_mobile    = $('#s_mobile').val();
            var regionp      = $('#branchdropp').val();
            var branchdropp    = $('#regionp').val();
            var r_fname   = $('#r_fname').val();
            var r_address     = $('#r_address').val();
            var r_email     = $('#r_email').val();
            var r_mobile    = $('#r_mobile').val();
            var rec_region   = $('#rec_region').val();
            var rec_dropp         = $('#rec_dropp').val();

            if (r_fname == '') {
            $('#error_fname').html('This field is required');
            }else if(r_address == ''){
            $('#error_address').html('This field is required');
             }else if(r_mobile == ''){
            $('#error_mobile').html('This field is required');
            }else if(rec_region == 0){
            $('#error_region').html('This field is required');
            }else if(rec_dropp == 0){
            $('#error_district').html('This field is required');
            }else{
                
             $.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Box_Application/Register_Ems_Action')?>",
                 dataType : "JSON",
                 data : {emstype:emstype,emsCat:emsCat,weight:weight,s_fname:s_fname,s_address:s_address,s_email:s_email,s_mobile:s_mobile,regionp:regionp,branchdropp:branchdropp,r_fname:r_fname,r_address:r_address,r_mobile:r_mobile,r_email:r_email,rec_region:rec_region,rec_dropp:rec_dropp},
                 success: function(data){

                     $('[name="vehicle_no"]').val("");
                     $('[name="vehicle_id"]').val("");

                     $('#div4').show();
                     $('#div3').hide();
                     $('#majibu').html(data);
                    /// $('#Modal_Edit').modal('hide');
                     show_product();
                 }
             });
             return false;
        }
        });


</script>
