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
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Inventory</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active">Inventory</li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<?php $regvalue = $this->employee_model->regselect(); ?>

	<br/>
	<div class="container-fluid">

		<div class="row">
			<!-- <div class="col-lg-3 col-md-6">
                        <div class="card" style="background-color:rgb(93, 76, 200);">
                            <div class="card-body">
                            	<a href="<?php echo base_url(); ?>Box_Application/StampBureau" class="text-white">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-bank"></i></div>
                                    <div class="m-l-10 align-self-center">
                                       

                                        <b>Stamp bureau</b>
                                        </div>
                                </div>
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card" style="background-color:rgb(93, 76, 200);">
                        	<div class="card-body">
                        		 <a href="<?php echo base_url(); ?>Stock/Requisition_Form" class="text-white">
                            
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-info"><i class="fa fa-tasks"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        
                                       <b>Stock</b>
                                        </div>
                                       
                                </div>
                                 </a>
                            </div>
                        </div>
                    </div>
		</div>

		
	</div>

<script>
function getPriceFrom() {
	var pay_type = $('.pay_type').val();
	var category = $('.category').val();
	var catlist = $('.cat_lists').val();
	var measure = $('.measure').val();
	var weight = $('.weight').val();

	if (weight == '') {

	}else{

		$.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Billing/mailsPrices')?>",
                 //dataType : "JSON",
                 data : {weight:weight,measure:measure,catlist:catlist,category:category,pay_type:pay_type},
                 success: function(data){
                    $('.price').html(data);
                    //$('#tariffCat').val("");
                 }
             });
	}

  };
  function getAerogrammes() {
  	var pay_type = $('.pay_type').val();
  	var category = $('.category').val();
  	var catlist = $('.cat_lists').val();
  	var measure2 = $('.m2').val();

  	if (measure2 == '') {

  	}else{

  		$.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Billing/mailsPrices')?>",
                 //dataType : "JSON",
                 data : {measure2:measure2,catlist:catlist,category:category,pay_type:pay_type},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
  	}
	
  };
  function getAdvatising() {
  	var pay_type = $('.pay_type').val();
  	var category = $('.category').val();
  	var catlist = $('.cat_lists').val();
  	var measure1 = $('.m1').val();

  	if (measure1 == '') {

  	}else{
  		$.ajax({
                 type : "POST",
                 url  : "<?php echo base_url('Billing/mailsPrices')?>",
                 //dataType : "JSON",
                 data : {measure1:measure1,catlist:catlist,category:category,pay_type:pay_type},
                 success: function(data){
                    $('.price').html(data);
                 }
             });
  	}
	
  };
</script>

	<?php $this->load->view('backend/footer'); ?>

	<script type="text/javascript">
        $(document).ready(function(){
            $('#item_info').click(function () {


                if ($('#category').val() == ''){
                    var error_category = 'Item Category is required';
                    $('#error_category').text(error_category);
                    $('#category').addClass('has-error');
                    return false;
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
                    if (category_list == 'Advertising Mail'){

                    	$.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Billing/Create_Inland_Ems')?>",
                        dataType: "JSON",
                        data: {category: cat,volume_weight:volume,destination:destination,stamp:stamp,
                            item_number:item_number,step:step,sub_category:category_list,pay_type:pay_type,measure1:measure1},

                        success: function (data) {

                            $('#list_login_details').removeClass('active active_tab1');
                            $('#list_login_details').removeAttr('href data-toggle');
                            $('#login_details').removeClass('active');
                            $('#list_login_details').addClass('inactive_tab1');
                            $('#list_personal_details').removeClass('inactive_tab1');
                            $('#list_personal_details').addClass('active_tab1 active');
                            $('#item_id').val(data);
                            $('#rec_item_id').val(data);
                            $('#personal_details').show();


                        }
                    });
                    return false;

                    }else if(category_list == 'Aerogramme&Post Cards'){

                    	$.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Billing/Create_Inland_Ems')?>",
                        dataType: "JSON",
                        data: {category: cat,volume_weight:volume,destination:destination,stamp:stamp,
                            item_number:item_number,step:step,sub_category:category_list,pay_type:pay_type,measure2:measure2},

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

                    }else{

                    	$.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Billing/Create_Inland_Ems')?>",
                        dataType: "JSON",
                        data: {category: cat, item_weight: weight,volume_weight:volume,destination:destination,stamp:stamp,
                            item_number:item_number,step:step,sub_category:category_list,pay_type:pay_type,measure:measure},

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
           	 //$('#measure').val('');
           	 //$('#measure2').val('');
           	 $('#divshow1').hide();
           	 $('#divshow2').hide();

           }else if(cat_lists == 'Aerogramme&Post Cards'){

           	$('#divshow').hide();
           	 $('#divshow1').hide();
           	 $('#divshow2').show();
           	// $('#measure1').val('');
           	 //$('#measure').val('');

           }
           else{

           	$('#divshow').hide();
           	$('#divshow1').show();
           	 $('#divshow2').hide();
           	 //$('#measure1').val('');
           	 //$('#measure2').val('');
           }
        };
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
            // $('#example4 thead tr:eq(1) th').each( function (i) {
            //     var title = $(this).text();
            //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

            //     $( 'input', this ).on( 'keyup change', function () {
            //         if ( table.column(i).search() !== this.value ) {
            //             table
            //                 .column(i)
            //                 .search( this.value )
            //                 .draw();
            //         }
            //     } );
            // } );

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
