<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>


<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Request To</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Stampbureau</a></li>
				<li class="breadcrumb-item active"> Request To </li>
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
        <button type="button" class="btn btn-info"><i class=""></i><a href="<?php echo base_url()?>inventory/dashboard" class="text-white"><i class="" aria-hidden="true"></i> <<< Back To Dashboard </a></button>
 
			</div>
		</div>

		

  <div class="row">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fa fa-list" aria-hidden="true"></i>    Request To</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive ">
                                  
                                <table class="table table-bordered table-strip" id="kiwi">
                                            <thead>
                                                <tr>
                                                    <th>Requested Date</th>
                                                    <th>Stock Type</th>
                                                    <th>Stock Name</th>
                                                    <th>Quantity Requested</th>
                                                    <th style="text-align: right;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stockrequest as $value) { ?>
                                                    <tr>
                                                        <td><?php echo $value->requested_date ?></td>
                                                        <td><?php echo $value->CategoryName ?></td>
                                                        <td><?php echo $value->stock_name ?></td>
                                                        <td><?php echo $value->quantity_requested ?></td>
                                                        
                                                        <td style="text-align: right;">
                                                        <form action="status" method="POST">
                                                            <input type="hidden" name="rid" value="<?php echo $value->request_id; ?>">
                                                        <?php if ($value->request_status == 'isSent'){ ?>
                                                          
                                                           <button class="btn btn-warning btn-sm" disabled="disabled">Wait To Be Accepted</button>

                                                        <?php }elseif($value->request_status == 'isAccepted'){ ?>
                                                        <button type="submit" class="btn btn-warning btn-sm" name="receive" value="receive">Receive</button>
                                                          
                                                        <?php }elseif($value->request_status == 'isRejected'){ ?>
                                                          <a href="#" class="btn btn-danger btn-sm">Rejected</a>
                                                        <?php }elseif($value->request_status == 'isReceived'){ ?>
                                                          <a href="#" class="btn btn-success btn-sm">Already Issued</a>
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
	