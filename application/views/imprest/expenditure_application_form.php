<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><img src="<?php echo base_url(); ?>assets/images/expend.png" width="20"> Imprest Request</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Imprest Request</li>
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
                  <a href="<?php echo base_url() ?>imprest/expenditure_Application" class="btn btn-primary"><i class="fa fa-plus"></i> Add Imprest Request</a>

                    <a href="<?php echo base_url() ?>imprest/expenditure_List" class="btn btn-primary"><i class="fa fa-list"></i> Imprest Request List</a>
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
						<form action="<?php echo  base_url('imprest/add_expenditure')?>" method="post">
							<div class="row">

								<div class="col-md-6">
									<label>Ref:</label>
									<input type="text" name="refference" readonly="readonly" class="form-control"
										   value="<?php echo 'PF '. $basic->em_code.'/DF/'.$reff->number.'/'.date('Y') ?>">
								</div>
								<div class="col-md-6">
									<label>Date</label>
									<input type="text" name="date" class="form-control" value="<?php
									//echo date('d/m/Y')
									$month = date('m');
									$dateObj   = DateTime::createFromFormat('!m', $month);
									$monthName = $dateObj->format('F');
									echo date('d').' '.$monthName.','.date('Y');
									?>" readonly="readonly">
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>From</label>
									<input type="text" name="from" class="form-control" readonly="readonly"  value="<?php echo $basic->dep_name; ?>" >
								</div>
								<div class="col-md-6">
									<label>To</label>
									<select name="to" class="form-control custom-select">
										<option>PMG</option>
										<option>GMs</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label>USF</label>
									<select name="head_dep" class="form-control custom-select">
										<option>HOD</option>
										<option>HOU</option>
									</select>
								</div>
							</div>
							<br>
							<div class="row m-t-40">
								<div class="col-md-12" style="padding-top: 15px;">
									<text>REF: <b>USER APPLICATION OF EXPENDITURE OF TSH.</b>
										<input type="number" name="amount_request" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;width: 60%;" required>	</text>
								</div>

							</div>
							<div class="row m-t-20">
								<div class="col-md-12">
									<text>Kindly approve expendicture of the sum of &nbsp;
										<input type="number" name="exp_sum" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;" required>
										for &nbsp;<select name="expenditure_type" class="custom-select" style="border-top: 0px;border-left: 0px;border-right: 0px;width: 40%;" required><option>Cost</option><option>Purchase</option><option>Travel</option></select>
										for &nbsp;<input type="text" class="form-control" name="for" style="border-top: 0px;border-left: 0px;border-right: 0px;" required><br><br>
										The expenditure was provided for in the annual departmental/unit activities.
									</text>
								</div>
							</div>
							<br><br><br>
							<div class="row">
								<div class="col-md-6">
									<text><b>Regards</b></text><br><br>
									<input type="text" name="regards" class="form-control" style="border-top: 0px;border-left: 0px;border-right: 0px;"
										   value="<?php echo 'PF '. $basic->em_code .' '.$basic->first_name.' '. $basic->middle_name.' '.$basic->last_name ?>" readonly="readonly">
								</div>
							</div>
							<br><br>
							<div class="row">
								<div class="col-md-6">
									<button type="submit" name="submit" class="btn btn-info">Save Expenditure Request</button>
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
