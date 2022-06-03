<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>


<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Transactions Message</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Stampbureau</a></li>
				<li class="breadcrumb-item active"> Transactions Message </li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<?php $regvalue = $this->employee_model->regselect(); 
    $auth =  $this->session->userdata('sub_user_type');?>
	<div class="container-fluid">
		<div class="row m-b-10">
			<div class="col-12">
        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>unregistered/unregistered_form" class="text-white"><i class="" aria-hidden="true"></i> Add Cash Register Customer</a></button>
                    <?php if($this->session->userdata('user_type') == "EMPLOYEE"){ ?>
                         <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>bill_customer/bill_customer_list" class="text-white"><i class="" aria-hidden="true"></i> Bill Register Customer List</a></button>
                    <?php }if($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"){ ?>
                       <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>bill_customer/bill_customer_form" class="text-white"><i class="" aria-hidden="true"></i> Add Bill Register Customer</a></button>
                   <?php } ?>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>unregistered/register_application_list" class="text-white"><i class="" aria-hidden="true"></i> Register Cash Transactions List</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>bill_customer/register_bill_transaction_list" class="text-white"><i class="" aria-hidden="true"></i> Register Bill Transactions List</a></button>
 
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>    Transactions Message</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive ">
                        <text style="font-size: 18px;"><?php echo $message;?> </text>
                     </div>
                 </div>





						
	    	</div>
		</div>
	</div>
  </div>

	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    
    var table = $('#kiwi').DataTable( {
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
<?php $this->load->view('backend/footer'); ?>
	