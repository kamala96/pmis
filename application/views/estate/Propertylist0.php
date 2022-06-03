<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<link href="<?php echo base_url(); ?>assets/css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />   

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
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i>Estate Property </h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active">Property 
                list </li>
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
			   
			<button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>Realestate/AddProperty" class="text-white"><i class="" aria-hidden="true"></i> Add  Property</a></button>

			
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>  Property List</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive ">
                        <table id="kiwi" class="table table-bordered table-property" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th >PHOTO</th>
                                <th>BUILDING/PLOT DETAILS</th>
                                <th>OTHER DETAILS</th>
                                <th >ACTION</th>
                            </tr>
                        </thead>
                        <tfoot>
                        
                        </tfoot>
                        <tbody>
                        <?php
                            foreach ($property as $value) {
                            

                            $id = $value->id;
                            $address = $value->address;
                            $PropertyUsage = $value->PropertyUsage;
                            $property_size =  $value->property_size;
                            $RegistrationNo =$value->RegistrationNo; 
                            $DateofReg = $value->DateofReg;
                           
                            $Status = $value->Status;
                            $image_path = $value->image_path;
                           
                            $Region = $value->Region;
                            $block =$value->block;
                            $lot = $value->lot;
                            $price_per_sqm = $value->price_per_sqm;

                          

                                
                                    echo '<tr style="width: 100%;">';
                                
                                echo ' <td style="width: 10%;">';
                                if($image_path != "no-image-land.png"){
                                    echo '<img src="'.base_url().'images/'.$image_path.'" style="width: 150px; height: 140px;">';
                                }else{
                                    echo '<img src="'.base_url().'images/no-image-land.png" style="width: 150px; height: 140px;">';
                                }
                                echo '</td> ';
                                echo '<td style="width: 40%;">';
                                echo ' <span>Property Name: </span> <span>'. $value->property_name.'</span><br>';
                                echo ' <span>Registration Number: </span> <span>'.$value->RegistrationNo.'</span><br>';
                                echo ' <span>Registration Date: </span> <span class="box-owner">'.$value->DateofReg.'</span><br>';
                                echo ' <span>Property Usage: </span> <span>'.$value->PropertyUsage.'</span><br>';
                                //echo ' <span>Property Type: </span> <span>'.$value->property_type.'</span><br>';
                                echo ' <span>Status: </span> <span>'.$value->Status.' </span> <br>';
                                
                                if($block == "" && $lot != ""){
                                    echo ' <span>Address: </span> <span> '.' lot '.$lot.' ,'.$address.' </span><br>';
                                }else if($lot == "" && $block != ""){
                                    echo ' <span>Address: </span> <span> block '.$block.' ,'.$address.' </span><br>';  
                                }else if($block == "" && $lot == ""){
                                    echo ' <span>Address: </span> <span> '.$address.' </span><br>';  
                                }
                                else{
                                    echo ' <span>Address: </span> <span> block '.$block.' lot '.$lot.' ,'.$address.' </span><br>';  
                                }
                                echo ' <span>Region: </span> <span>'.$value->Region.'  </span> <br>';
                                echo "</td>";

                                echo '<td style="width: 40%;">';
                                echo ' <span>Property Size: </span> <span>'.$value->property_size.'</span><span> '.sizeUnit($value->size_unit).'</span><br>';
                                echo ' <span>Property Value: </span> <span>TSHS '.number_format($value->PropertyValue).'</span><br>';
                                echo ' <span>Land Value: </span> <span>TSHS '.number_format($value->LandValue).'</span><br>';
                                
                                echo ' <span>Total price: </span> <span style="color:#1410e0;" class="price price2">TSHS '.number_format($value->Totalprice).'</span><br>';
                                echo ' <span>monthly Rent Vat Exclusive: </span> <span class="price ">TSHS '.number_format($value->monthly_paymentRent).'</span><br>';
                                echo "</td>";

                                echo '<td style="width: 5%;">';
                                echo '<a target="_blank" href="'.base_url().'Realestate/editproperty/'.$id.'" class="toolproperty btn btn-primary view" title="Edit Details" style="color:#fff;"> <i class="fa fa-pencil-square-o"></i> </a><br><br>';

                                echo '<button class="toolproperty btn btn-primary" title=" Property Details" onclick="showPropertyModal('.$id.');"><i class="fa fa-pencil-square-o"></i> </button><br>';

                                                     
                                echo "</td>";
                                echo "</tr>";
                            } 
                            
                        ?>                                                                                        
                        </tbody>
                        </table>
              

                     </div>
                 </div>





						
	    	</div>
		</div>
	</div>
  </div>

	</div>
</div>

<!-- modal -->
<div class="modal fade" id="updateProperty" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 1000px;">
    <div class="modal-content" style="width:100%;">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Property Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="property-body">
        <div class="modal-body">
    
         
        </div>
    </div>
  </div>
  </div>
</div>
<?php 
function sizeUnit($var){
    $var = $var;
 
     switch ($var) {
 
       case 0:
         $var = "Square meter";
         break;
 
       case 1:
         $var = "Hectare";
         break;
 
       default:
         $var = "Something went wrong";
         break;
     }
 
     return $var;
 } 

?>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#kiwi thead tr').clone(true).appendTo( '#kiwi thead' );
    $('#kiwi thead tr:eq(1) th').not(":eq(8)").each( function (i) {
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

    var table = $('#kiwi').DataTable( {
        orderCellsTop: true,
        order: [[0,"asc" ]],
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

   


} );

function showPropertyModal(id){    
      var id = id;            
      $('.property-body').load('<?php echo base_url(); ?>Realestate/Propertyprofile/' + id,function(){           
          $('#updateProperty').modal({show:true}); 
         
      });                    
  }
</script>








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
	