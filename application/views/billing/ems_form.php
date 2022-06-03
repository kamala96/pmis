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
				<!--                    <a href="--><?php //echo base_url() ?><!--Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>-->
				<!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button> -->
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card card-outline-info">
					<div class="card-header">
						<h4 class="m-b-0 text-white"> Inland Mails
						</h4>
					</div>
					<div class="card-body">
						<form method="post" >

							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_login_details">Item Information</a>
								</li>
								<li class="nav-item">
									<a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Details Of Sender</a>
								</li>
								<li class="nav-item">
									<a class="nav-link inactive_tab1" id="list_contact_details" style="border:1px solid #ccc">Details Of Receiver</a>
								</li>
								<li class="nav-item">
									<a class="nav-link inactive_tab1" id="control_number_details" style="border:1px solid #ccc">Control Number Details</a>
								</li>
							</ul>

							<div class="tab-content" style="margin-top:16px;">
								<div class="tab-pane active" id="login_details">

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
													<option>--Select Sub Category--</option>
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
<!--											<td>-->
<!--												<label>Volumetric Weight</label>-->
<!--												<input type="text" name="volume_weight" class="form-control" id="volume" placeholder="">-->
<!--											</td>-->
											<td>
												<label>Destination To</label>
												<select class="form-control custom-select col-md-4" name="destination" id="destination">
													<option value="">--Select Destination--</option>
													<?php foreach ($region as $value):?>
														<option value="<?php echo $value->region_id?>"><?php echo $value->region_name?></option>
													<?php endforeach; ?>
												</select>
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
											<td colspan="3">
												&nbsp;
											</td>

										</tr>
										<tr>
											<td>
												<input type="hidden" id="step" name="step" class="form-control" value="Step1">
												<button type="submit" class="btn btn-info" id="item_info">Save Information</button>
											</td>

										</tr>
									</table>
								</div>
								<div  id="personal_details" style="display: none;">
									<table style="width: 100%;" cellpadding="4" cellspacing="5">
										<tr>
											<td>
												<label>Sender Full Name</label>
												<input type="text" name="fullname" id="fullname" class="form-control">
											</td>
											<td>
												<label>Sender Address</label>
												<input type="text" name="address" class="form-control" id="address" placeholder="">
											</td>

										</tr>
										<tr><td><span id="error_fullname" class="text-danger"></span></td>
											<td><span id="error_address" class="text-danger"></span></td>
										</tr>
										<tr>
											<td>
												<label>Sender Email Address</label>
												<input type="email" name="email" class="form-control" id="email" placeholder="">
											</td>
											<td>
												<label>Sender Mobile Number</label>
												<input type="text" name="mobile" class="form-control" id="mobile">
											</td>

										</tr>
										<tr><td><span id="error_email" class="text-danger"></span></td>
											<td><span id="error_mobile" class="text-danger"></span></td>
										</tr>
										<tr>
											<td colspan="3">
												&nbsp;
											</td>

										</tr>
										<tr>
											<td>
												<input type="hidden" id="step2" name="step" class="form-control" value="Step2">
												<input type="hidden" name="item_id" id="item_id" class="form-control">
												<button type="submit" class="btn btn-info" id="sender_info">Save Information</button>
											</td>

										</tr>
									</table>
								</div>
								<div  id="receiver_details" style="display: none;">
									<table style="width: 100%;" cellpadding="4" cellspacing="5">
										<tr>
											<td>
												<label>Receiver Full Name</label>
												<input type="text" name="rec_name" id="rec_name" class="form-control">
											</td>
											<td>
												<label>Receiver Address</label>
												<input type="text" name="rec_address" class="form-control" id="rec_address" placeholder="">
											</td>

										</tr>
										<tr><td><span id="error_rec_name" class="text-danger"></span></td>
											<td><span id="error_rec_address" class="text-danger"></span></td>
										</tr>
										<tr>
											<td>
												<label>Receiver Email Address</label>
												<input type="email" name="rec_email" class="form-control" id="rec_email" placeholder="">
											</td>
											<td>
												<label>Receiver Mobile Number</label>
												<input type="text" name="rec_mobile" class="form-control" id="rec_mobile">
											</td>

										</tr>
										<tr><td><span id="error_rec_email" class="text-danger"></span></td>
											<td><span id="error_rec_mobile" class="text-danger"></span></td>
										</tr>
										<tr>
											<td colspan="3">
												&nbsp;
											</td>

										</tr>
										<tr>
											<td>
												<input type="hidden" id="step3" name="step" class="form-control" value="Step3">
												<input type="hidden" name="item_id" id="rec_item_id" class="form-control">
												<button type="submit" class="btn btn-info" id="receiver_info">Save Information</button>
											</td>

										</tr>
									</table>
								</div>
								<div  id="control_details" style="display: none;">
									<div class="row m-t-5">
										<div class="col-md-12" id="price"></div>
									</div>
									<div class="row m-t-20">
										<div class="col-md-12">
										<button type="submit" class="btn btn-info" id="go_back">Go To Previous</button>
										</div>
									</div>

								</div>
							</div>
						</form>
						<hr/>
						<div class="table-responsive m-t-20">
							<table id="example4" class="table table-bordered table-striped text-nowrap" style="width: 100%;">
								<thead>
								<tr>
									<th>Item Category</th>
									<th>Tarrif Type</th>
									<th>Item Weight (gms)</th>
									<th>Amount Paid+VAT(Tsh.)</th>
									<th>Destination</th>
									<th>Bill Number</th>
									<th>Payment Date</th>
									<th>Receipt</th>
									<th>Status</th>
								</tr>
								</thead>
								<tbody>
									<?php foreach ($listItem as $value): ?>
									<tr>
										<td><?php echo $value->sub_category;?></td>
										<td><?php echo $value->pay_type;?></td>
										<td><?php 
											if ($value->item_weight == -1) {
												echo "Local delivery (unaddressed)";
											}
											elseif ($value->item_weight == -2) {
												echo "Local delivery (addressed)";
											}
											elseif ($value->item_weight == -3) {
												echo "Delivery in another town (un addressed)";
											}
											elseif ($value->item_weight == -4) {
												echo "Delivery in another town (addressed)";
											}
											elseif ($value->item_weight == -5) {
												echo "Single without enclosure";
											}else{
												echo $value->item_weight;
											}
										?>
										</td>
										<td><?php echo number_format($value->paidamount,2);?></td>
										<td><?php echo $value->region_name;?></td>
										<td><?php echo $value->billid;?></td>
										<td><?php echo $value->paymentdate;?></td>
										<td><?php echo $value->receipt;?></td>
										<td>
											<?php if (!empty($value->paymentdate)){
											 echo '<text style="color: green;"><b>PAID</b></text>';
											} else{
												echo '<text style="color: red;"><b>NOT PAID</b></text>';
											}
											?></td>
									</tr>
								    <?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<?php $this->load->view('backend/footer'); ?>

	<script type="text/javascript">
        $(document).ready(function(){
            $('#item_info').click(function () {


                if ($('#category').val() == ''){
                    var error_category = 'Item Category is required';
                    $('#error_category').text(error_category);
                    $('#category').addClass('has-error');
                    return false;

                // }else if($('#weight').val() == ''){
                //     var error_weight = 'Item Weight is required';
                //     $('#error_weight').text(error_weight);
                //     $('#weight').addClass('has-error');
                //     return false;
                }else if($('#volume').val() == ''){
                    var error_volume = 'Item Volume is required';
                    $('#error_volume').text(error_volume);
                    $('#volume').addClass('has-error');
                    return false;
                }else if($('#destination').val() == ''){
                    var error_destination = 'Item Destination is required';
                    $('#error_destination').text(error_destination);
                    $('#destination').addClass('has-error');
                    return false;
                }else if($('#stamp').val() == ''){
                    var error_stamp = 'Item Stamp is required';
                    $('#error_stamp').text(error_stamp);
                    $('#stamp').addClass('has-error');
                    return false;
                }else if($('#item_number').val() == ''){
                    var error_number = 'Item Weight is required';
                    $('#error_number').text(error_number);
                    $('#item_number').addClass('has-error');
                    return false;
                }
                else if($('#cat_list').val() == ''){
                    var error_volume = 'Sub Category is required';
                    $('#error_volume').text(error_volume);
                    $('#cat_list').addClass('has-error');
                    return false;
                }
                else{

                    var cat    = $('#category').val();
                    var weight = $('#weight').val();
                    var volume = $('#volume').val();
                    var destination = $('#destination').val();
                    var stamp = $('#stamp').val();
                    var item_number = $('#item_number').val();
                    var step       = $('#step').val();
                    var category_list   = $('#cat_list').val();
                    var pay_type   = $('#pay_type').val();
                    var measure   = $('#measure').val();
                    var measure1   = $('#measure1').val();
                    var measure2   = $('#measure2').val();
                    	//alert(measure1);
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Billing/Create_Inland_Ems')?>",
                        dataType: "JSON",
                        data: {category: cat, item_weight: weight,volume_weight:volume,destination:destination,stamp:stamp,
                            item_number:item_number,step:step,sub_category:category_list,pay_type:pay_type,measure:measure,measure1:measure1,measure2:measure2},

                        success: function (data) {

                            $('#list_login_details').removeClass('active active_tab1');
                            $('#list_login_details').removeAttr('href data-toggle');
                            $('#login_details').removeClass('active');
                            $('#list_login_details').addClass('inactive_tab1');
                            $('#list_personal_details').removeClass('inactive_tab1');
                            $('#list_personal_details').addClass('active_tab1 active');
                            //$('#list_personal_details').attr('href', '#personal_details');
                            //$('#list_personal_details').attr('data-toggle', 'tab');
                            //$('#personal_details').addClass('active in');
                            $('#item_id').val(data);
                            $('#rec_item_id').val(data);
                            $('#personal_details').show();


                        }
                    });
                    return false;
                }
            });

            $('#sender_info').click(function(){

                if ($('#fullname').val() == ''){
                    var error_fullname = 'Name is required';
                    $('#error_fullname').text(error_fullname);
                    $('#fullname').addClass('has-error');
                    return false;

                }else if($('#address').val() == ''){
                    var error_address = 'Address is required';
                    $('#error_address').text(error_address);
                    $('#address').addClass('has-error');
                    return false;
                }else if($('#email').val() == ''){
                    var error_email = 'Email is required';
                    $('#error_email').text(error_email);
                    $('#email').addClass('has-error');
                    return false;
                }else if($('#mobile').val() == ''){
                    var error_mobile = 'Mobile number is required';
                    $('#error_mobile').text(error_mobile);
                    $('#mobile').addClass('has-error');
                    return false;
                }else{

                    var fullname = $('#fullname').val();
                    var address  = $('#address').val();
                    var email    = $('#email').val();
                    var mobile   = $('#mobile').val();
                    var step     = $('#step2').val();
                    var item_id  = $('#rec_item_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Billing/Create_Inland_Ems')?>",
                        dataType: "JSON",
                        data: {fullname: fullname, address:address,email:email,mobile:mobile,step:step,item_id:item_id},
                        success: function (data) {

                            $('#list_personal_details').removeClass('active active_tab1');
                            $('#list_personal_details').removeAttr('href data-toggle');
                            $('#personal_details').removeClass('active');
                            $('#list_personal_details').addClass('inactive_tab1');
                            $('#list_contact_details').removeClass('inactive_tab1');
                            $('#list_contact_details').addClass('active_tab1 active');
                            $('#receiver_details').show();
                            $('#personal_details').hide();

                        }

                    });
                    return false;
                }
            });

            $('#receiver_info').click(function(){

                if ($('#rec_name').val() == ''){
                    var error_rec_name = 'Name is required';
                    $('#error_rec_name').text(error_rec_namename);
                    $('#rec_name').addClass('has-error');
                    return false;

                }else if($('#rec_address').val() == ''){
                    var error_rec_address = 'Address is required';
                    $('#error_rec_address').text(error_rec_address);
                    $('#rec_address').addClass('has-error');
                    return false;
                }else if($('#rec_email').val() == ''){
                    var error_rec_email = 'Email is required';
                    $('#error_email').text(error_rec_email);
                    $('#rec_email').addClass('has-error');
                    return false;
                }else if($('#rec_mobile').val() == ''){
                    var error_rec_mobile = 'Mobile number is required';
                    $('#error_rec_mobile').text(error_rec_mobile);
                    $('#rec_mobile').addClass('has-error');
                    return false;
                }else{

                    var fullname = $('#rec_name').val();
                    var address  = $('#rec_address').val();
                    var email    = $('#rec_email').val();
                    var mobile   = $('#rec_mobile').val();
                    var step     = $('#step3').val();
                    var item_id  = $('#item_id').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Billing/Create_Inland_Ems')?>",
                        dataType: "JSON",
                        data: {fullname: fullname, address:address,email:email,mobile:mobile,step:step,item_id:item_id},
                        success: function (data) {

                            $('#list_contact_details').removeClass('active active_tab1');
                            $('#list_contact_details').removeAttr('href data-toggle');
                            $('#personal_details').removeClass('active');
                            $('#list_contact_details').addClass('inactive_tab1');
                            $('#control_number_details').removeClass('inactive_tab1');
                            $('#control_number_details').addClass('active_tab1 active');
                            $('#receiver_details').hide();
                            $('#personal_details').hide();
                            $('#control_details').show();
                            $('#price').html(data);

                        }

                    });
                    return false;
                }
            });
            $('#go_back').click(function() {

                $('#list_personal_details').removeClass('active active_tab1');
                $('#list_personal_details').removeAttr('href data-toggle');
                $('#personal_details').removeClass('active in');
                $('#list_personal_details').addClass('inactive_tab1');
                $('#list_login_details').removeClass('inactive_tab1');
                $('#list_login_details').addClass('active_tab1 active');
                $('#list_login_details').attr('href', '#login_details');
                $('#list_login_details').attr('data-toggle', 'tab');
                $('#login_details').addClass('active in');
                $('#control_number_details').removeClass('active');
                $('#control_number_details').addClass('inactive_tab1');
                $('#control_details').hide();
				location.reload();
                $('#category').val('');
                $('#weight').val('');
                $('#volume').val('');
                $('#destination').val('');
                $('#stamp').val('');
                $('#item_number').val('');
                $('#step').val('');

                $('#rec_name').val('');
                $('#rec_address').val('');
                $('#rec_email').val('');
                $('#rec_mobile').val('');
                $('#step3').val('');
                $('#item_id').val('');

                $('#fullname').val('');
                $('#address').val('');
                $('#email').val('');
                $('#mobile').val('');
                $('#step2').val('');
                $('#rec_item_id').val('');


                return false;
            });

        });
	</script>
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
