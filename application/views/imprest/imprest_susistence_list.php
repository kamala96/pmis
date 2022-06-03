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
                   <a href="<?php echo base_url() ?>imprest/expenditure_Application" class="btn btn-primary"><i class="fa fa-plus"></i> Add Imprest Request</a>

                    <a href="<?php echo base_url() ?>imprest/expenditure_List" class="btn btn-primary"><i class="fa fa-list"></i> Imprest Request List</a>

                    <a href="<?php echo base_url() ?>imprest/imprest_subsistence_List" class="btn btn-primary"><i class="fa fa-list"></i> Imprest Subsistence Request List</a>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Imprest Subsistence List
                        </h4>
                    </div>
                    <div class="card-body" style="">
						<table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Expenditure Refferences</th>
								<th>Department</th>
								<th>Subsistence Amount</th>
								<th>Date Created</th>
								<th>Subsistence Status</th>
								<th style="text-align: right;"></th>
							</tr>
							</thead>
							
							<tbody>
							  <?php foreach ($imprest_expenditure as $value): ?>
							  <tr>
								  <td><?php echo $value->refferences; ?></td>
								  <td><?php echo $value->exp_from; ?></td>
								  <td><?php echo number_format($value->sum_exp,2); ?></td>
								  <td><?php echo $value->date_created; ?></td>
								  <td>
								  	<?php if($value->imps_status == 'isNON'){?>
								  		<button class="btn btn-primary btn-sm" class="button" disabled>Waiting For HOD Approve.</button>
								  	<?php }elseif($value->imps_status == 'isHOD'){?>
								  		<button class="btn btn-info btn-sm" class="button" disabled>Waiting For GMCRM/GMBOP/PMG Approve.</button>
								  	<?php }elseif($value->imps_status == 'isGMCRM' || $value->imps_status == 'isGMBOP' || $value->imps_status == 'isPMG'){?>
								  		<button class="btn btn-info btn-sm" class="button" disabled>Waiting For Accountant To Approve.</button>
								  	<?php }elseif($value->imps_status == 'isREJ'){?>
								  		<button class="btn btn-danger btn-sm" class="button" disabled>Imprest is Rejected.</button>
                                    <?php }elseif($value->imps_status == 'isACC'){?>
                                        <button class="btn btn-success btn-sm" class="button" disabled>Imprest is Already Paid.</button>
								  	<?php }else{ ?>
								  		<button class="btn btn-danger btn-sm" class="button" disabled>Imprest is Canceled.</button>
								  	<?php } ?>
								  </td>
								  <td style="text-align: right;">
								  	<?php if($this->session->userdata('user_type') == 'ACCOUNTANT' || $this->session->userdata('user_type') == 'CRM' || $this->session->userdata('user_type') == 'BOP' || $this->session->userdata('user_type') == 'PMG' || $this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'HOD'){?>

								  		<?php if($this->session->userdata('user_emid') == $value->em_id ){?>
								  			<?php if($value->imps_status == 'isNON'){?>
								  				<a href="<?php echo base_url()?>imprest/edit_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-warning btn-sm">Edit</a>
								  			<button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
								  			<input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
								  			<a href="<?php echo base_url()?>imprest/verify_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-info btn-sm">Verify</a>
								  			<?php }elseif($value->imps_status == 'isPMG' || $value->imps_status == 'isGMCRM' || $value->imps_status == 'isGMBOP'){?>
                                            <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                            <input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
                                            <?php }elseif($value->imps_status == 'isHOD'){?>
                                                <a href="<?php echo base_url()?>imprest/edit_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                            <input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
								  			<?php }elseif($value->imps_status == 'isREJ'){?>
								  				<a href="<?php echo base_url()?>imprest/edit_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-warning btn-sm">Edit</a>
								  			<button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
								  			<input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
								  			<?php }elseif($value->imps_status == 'isCAN'){?>
                                                <img src="<?php echo base_url()?>assets/images/close.jpg">
                                        <?php }elseif($value->imps_status == 'isACC'){?>
                                               <img src="<?php echo base_url()?>assets/images/success.png">
                                            <?php }elseif($value->imps_status == 'isCAN'){?>
                                                <img src="<?php echo base_url()?>assets/images/close.jpg">
                                            
								  			<?php }else{?>
								  				<a href="<?php echo base_url()?>imprest/verify_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-info btn-sm">Verify</a>
								  			<?php }?>
								  			
								  		<?php }else{?>
                                        <?php if($value->imps_status == 'isACC'){?>
                                            <img src="<?php echo base_url()?>assets/images/success.png">
                                        <?php }else{?>
                                            <a href="<?php echo base_url()?>imprest/verify_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-info btn-sm">Verify</a>
                                        <?php }?>
                                        <?php }?>
								  			
								  	<?php }else{ ?>

								  			<?php if($value->imps_status == 'isGMBOP'  || $value->imps_status == 'isGMCRM' || $value->imps_status == 'isPMG' || $value->imps_status == 'isHOD'){?>
								  				<a href="<?php echo base_url()?>imprest/edit_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-warning btn-sm">Edit</a>
								  			<button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
								  			<input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
								  			<?php }elseif($value->imps_status == 'isNON'){?>
                                                <a href="<?php echo base_url()?>imprest/edit_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                            <input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
								  			<?php }elseif($value->imps_status == 'isCAN'){?>
								  				<img src="<?php echo base_url()?>assets/images/close.jpg">
                                            <?php }elseif($value->imps_status == 'isACC'){?>
                                                <img src="<?php echo base_url()?>assets/images/success.png">
								  			<?php }elseif($value->imps_status == 'isREJ'){?>
                                                <a href="<?php echo base_url()?>imprest/edit_imprest_subsistence?I=<?php echo base64_encode($value->imps_id) ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                            <input type="hidden" id="leaveId" value="<?php echo $value->imps_id; ?>">
								  			<?php }else{?>
								  				
								  			<?php }?>

								  	<?php } ?>
								  </td>
							  </tr>
							  <?php endforeach;?>
							</tbody>
						</table>
					</div>
					</div>
                    </div>
                </div>
            </div>
        </div>

<div class="modal fade" id="myModal" role="dialog" style="padding-top: 300px;">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <form role="form" action="cancel_imprest_subsistence" method="post">
        <div class="modal-body">
            <h3 style="color: red;">Are you sure you want to cancel this Imprest !!!</h3>
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
            <input type="hidden" name="imps_id" id="idleave">
            <button type="submit" class="btn btn-default btn-default pull-left"><span class="glyphicon glyphicon-remove"></span>Yes</button>
         <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal">No</button>
        </div>
        </form>
        </div>
        <div class="modal-footer">
            
        </div>
    
      </div>
    </div>


<script>
$(document).ready(function(){
  $(".myBtn").click(function(){
    
     var text1 = $('#leaveId').val();
  
     $('#idleave').val(text1);
    
    $("#myModal").modal();
  });
});
</script>

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
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
        $('#example4 thead tr:eq(1) th').not(":eq(5)").each( function (i) {
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
