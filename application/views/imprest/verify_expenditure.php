<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><img src="<?php echo base_url(); ?>assets/images/expend.png" width="20"> Expenditure</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Expenditure</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regvalue = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Imprest/Expenditure_List" class="text-white">
							<i class="" aria-hidden="true"></i> Expenditure List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Imprest Expenditure Request Application Form
                        </h4>
                    </div>
                    <div class="card-body" style="padding-left: 220px;padding-right: 220px;">
					<div class="card" style="">
					<div class="card-body" style="font-family: "Courier New", Courier, monospace;">
						<form action="<?php echo  base_url('imprest/update_expenditure_status')?>" method="post">
							<div class="row">

								<div class="col-md-6">
									<label>Ref:</label>
									<input type="text" name="refference" class="form-control"
										   value="<?php echo $expenditure->refferences ?>">
								</div>
								<div class="col-md-6">
									<label>Date</label>
									<input type="text" name="date" class="form-control" value="<?php echo $expenditure->date_created?>" readonly="readonly">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>From</label>
									<input type="text" name="from" class="form-control" readonly="readonly"  value="<?php echo $expenditure->exp_from; ?>" >
								</div>
								<div class="col-md-6">
									<label>To</label>
									<select name="to" class="form-control custom-select">
										<option><?php echo $expenditure->exp_to; ?></option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>USF</label>
									<select name="head_dep" class="form-control custom-select">
										<option><?php echo $expenditure->usf; ?></option>
									</select>
								</div>
							</div>
							<br>
							<div class="row m-t-40">
								<div class="col-md-12" style="padding-top: 15px;">
									<text>REF: <b>USER APPLICATION OF EXPENDITURE OF TSH.</b>
										<input type="text" name="amount_request" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;width: 60%;" value="<?php echo $expenditure->app_exp; ?>">	</text>
								</div>

							</div>
							<div class="row m-t-20">
								<div class="col-md-12">
									<text>Kindly approve expendicture of the sum of &nbsp;
										<input type="text" name="exp_sum" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;" value="<?php echo $expenditure->sum_exp; ?>">
										for &nbsp;<select name="expenditure_type" class="custom-select" style="border-top: 0px;border-left: 0px;border-right: 0px;width: 40%;"><option><?php echo $expenditure->exp_type; ?></option></select>
										for &nbsp;<input type="text" class="form-control" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;" value="<?php echo $expenditure->exp_for; ?>"><br><br>
										The expenditure was provided for in the annual departmental/unit activities.
									</text>
								</div>
							</div>
							<br><br><br>
							<div class="row">
								<div class="col-md-6">
									<text><b>Regards</b></text><br><br>
									<input type="text" name="regards" class="form-control" style="border-top: 0px;border-left: 0px;border-right: 0px;"
										   value="<?php echo $expenditure->regards; ?>" readonly="readonly">
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-md-6">
									<label>Select Status To Verify Expenditure</label>
									<select name="status"  class="form-control custom-select reason" onchange="getReason();">
										<option value="Approve">Approve</option>
										<option value="Rejected">Reject</option>
									</select>
								</div>
							</div>
							<div class="row m-t-20" style="display: none;" id="show">
								<div class="col-md-6">
									<label>Reason</label>
									<textarea name="reason" class="form-control"></textarea>
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-md-6">
									<input type="hidden" name="imp_id" value="<?php echo $expenditure->imp_id; ?>" class="form-control">
									<button type="submit" name="submit" class="btn btn-info">Approve Expenditure Request</button>
								</div>
							</div>
						</form
					</div>
					</div>
					</div>
                    </div>
                </div>
            </div>
        </div>



<script type="text/javascript">
        function getDistrict() {
    var val = $('#regionp').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdropp").html(data);
     }
 });
};
</script>
<script type="text/javascript">
    function getReason() {
       if ($('.reason').val() =='Rejected'){
           $('#show').show();
	   }else{
           $('#show').hide();
	   }

    };
</script>

<?php $this->load->view('backend/footer'); ?>

<script>
    $('#employees123').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
