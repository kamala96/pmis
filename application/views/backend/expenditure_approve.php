<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i>Imprest Subsistence Request List</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Imprest Expenditure Request</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="row" style="padding-left:  10px;padding-bottom: 10px;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>employee/Imprest_Approved" class="text-white"><i class="" aria-hidden="true"></i> Approve List</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Imprest_Rejected" class="text-white"><i class="" aria-hidden="true"></i>  Rejected List</a></button>
                       
                </div>
            </div> 
            <div class="container-fluid">
				<div class="card card-outline-info">
					<div class="card-header">
						<h4 class="m-b-0 text-white"> Imprest Expenditure Request</h4>
					</div>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-2">

							</div>
							<div class="col-md-8" style="">
								<h4 class="card-title" style="text-align: center;">TANZANIA POSTS CORPORATION</h4>
								<form action="<?php echo  base_url('employee/expenditure_confirm')?>" method="post">
									<div class="row">

										<div class="col-md-6">
											<label>Ref:</label>
											<input type="text" name="refference" class="form-control"
												   value="<?php echo $implestExpenditure->refferences;?>" >
											<input type="hidden" name="imp_id" class="form-control"
												   value="<?php echo $implestExpenditure->imp_id;?>">
											<input type="hidden" name="em_code" class="form-control"
												   value="<?php echo $implestExpenditure->em_code;?>">
										</div>
										<div class="col-md-6">
											<label>Date</label>
											<input type="text" name="date" class="form-control" readonly value="<?php echo $implestExpenditure->date_created;?>" >
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label>From</label>
											<input type="text" name="from" class="form-control"
												   value="<?php echo $implestExpenditure->exp_from;?>" readonly>
										</div>
										<div class="col-md-6">
											<label>To</label>
											<select name="to" class="form-control custom-select" >
												<option><?php echo $implestExpenditure->exp_to;?></option>
												<option>PMG</option>
												<option>GMs</option>
											</select>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<label>USF</label>
											<select name="head_dep" class="form-control custom-select" >
												<option><?php echo $implestExpenditure->usf;?></option>
												<option>HOD</option>
												<option>HOU</option>
											</select>
										</div>
									</div>
									<br>
									<div class="row m-t-40">
										<div class="col-md-6" style="padding-top: 15px;">
											<text>REF: <b>USER APPLICATION OF EXPENDITURE OF TSH.</b>	</text>
										</div>
										<div class="col-md-6" style="">
											<input type="text" name="amount_request" value="<?php echo $implestExpenditure->app_exp;?>" class="form-control" style="border-top: 0px;border-left: 0px;border-right: 0px;" required >
										</div>
									</div>
									<div class="row m-t-20">
										<div class="col-md-12">
											<text>Kindly approve expendicture of the sum of &nbsp;
												<input type="text" name="exp_sum" value="<?php echo $implestExpenditure->sum_exp;?>" class="" style="border-top: 0px;border-left: 0px;border-right: 0px;" required >
												for &nbsp;<select name="expenditure_type" class="custom-select" style="border-top: 0px;border-left: 0px;border-right: 0px;" required ><option><?php echo $implestExpenditure->exp_type;?></option><option>Cost</option><option>Purchase</option><option>Travel</option></select>
												for &nbsp;<input type="text" class="form-control" name="for" value="<?php echo $implestExpenditure->exp_for;?>" style="border-top: 0px;border-left: 0px;border-right: 0px;" required ><br><br>
												The expenditure was provided for in the annual departmental/unit activities.
											</text>
										</div>
									</div>
									<br><br><br>
									<div class="row">
										<div class="col-md-6">
											<text><b>Regards</b></text><br><br>
											<input type="text" name="regards" readonly class="form-control" style="border-top: 0px;border-left: 0px;border-right: 0px;"
												   value="<?php echo 'PF'.' '.$basic->em_code.' '.$basic->first_name .' '.$basic->middle_name.' '. $basic->last_name; ?>">
										</div>
									</div>

									<?php if($this->session->userdata('user_type') =='HOD' || $this->session->userdata('user_type') =='HOU' ){?>
									<?php if($implestExpenditure->exp_status == 'Approved'){ ?>
										<br><br>
										<div class="row">
											<div class="col-md-6">
												<text>PMG/GM is :<b>APPROVED</b></text>
											</div>
										</div>
										<?php } else { ?>
									<br><br>
									<div class="row">
										<div class="col-md-6">
											<select class="form-control custom-select" name="status" id="reason1">
												    <option value="Yes">Approved</option>
												    <option value="No">NotApproved</option>
											</select>
										</div>
									</div>
										<br><br>
										<div class="row" style="display: none;" id="reasonbox">
											<div class="col-md-6">
												<label>Reason</label>
												<textarea name="reason" class="form-control"></textarea>
											</div>
										</div>
											<br><br>
											<div class="row">
												<div class="col-md-6">
													<button type="submit" name="submit" class="btn btn-info">Save Expenditure Request</button>
												</div>
											</div>
										<?php } ?>
									<?php }elseif($this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='GM' ){ ?>
										<?php if($implestExpenditure->isHOD == 'Yes'){ ?>
											<br><br>
											<div class="row">
												<div class="col-md-6">
													<text>Head Of Department/Unit is :<b>APPROVED</b></text>
												</div>
											</div>
											<br><br>
											<div class="row">
												<div class="col-md-6">
													<select class="form-control custom-select" name="status" id="reason1">
														<option value="Yes">Approved</option>
														<option value="No">NotApproved</option>
													</select>
												</div>
											</div>
											<br><br>
											<div class="row" style="display: none;" id="reasonbox">
												<div class="col-md-6">
													<label>Reason</label>
													<textarea name="reason" class="form-control"></textarea>
												</div>
											</div>
										<?php } ?>
										<br><br>
										<div class="row">
											<div class="col-md-6">
												<button type="submit" name="submit" class="btn btn-info">Save Expenditure Request</button>
											</div>
										</div>
									<?php } else{?>
										<br><br>
										<div class="row" style="" id="reasonbox">
											<div class="col-md-6">
												<label>Reason</label>
												<textarea name="reason" class="form-control"><?php echo $implestExpenditure->reasons; ?></textarea>
											</div>
										</div>
										<br><br>
										<div class="row">
											<div class="col-md-6">
												<button type="submit" name="submit" class="btn btn-info">Save Expenditure Request</button>
											</div>
										</div>
									<?php } ?>

								</form>
							</div>
							<div class="col-md-2">

							</div>
						</div>

					</div>
				</div>
				</div>
			</div>
 <script type="text/javascript">
 $(document).ready(function () {
$('#yes').change(function () {
if (this.checked) {
$('#reason').hide();
$('#sio').hide();
}
else {
$('#reason').hide();
 $('#sio').show();
}
});

$('#no').change(function () {
if (this.checked) {
$('#reason').show();
$('#ndio').hide();
}
else
{
    $('#ndio').show();
    $('#reason').hide();
}
});
});
</script>

<script type="text/javascript">
 $(document).ready(function () {
$('#yes2').change(function () {
if (this.checked) {
$('#reason').hide();
$('#sio').hide();
}
else {
$('#reason').hide();
 $('#sio').show();
}
});

$('#no2').change(function () {
if (this.checked) {
$('#reason').show();
$('#ndio').hide();
}
else
{
    $('#ndio').show();
    $('#reason').hide();
}
});
});
</script>


    <?php $this->load->view('backend/footer'); ?>
    <script>
    $('#employeesFamily').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(7)").each( function (i) {
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

    $('#reason1').on('change', function()
    {
        var saida = $('#reason1').val();
        //alert(saida);
        if (saida == 'No')
		{
		    $('#reasonbox').show();
		}else{
        $('#reasonbox').hide();
	}
    });
</script>


