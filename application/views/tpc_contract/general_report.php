<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> General Report  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> KPI </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
							
							 <a href="<?php echo site_url('Contract/task_performance_reports');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Performance Report </button> </a>

                            <a href="<?php echo site_url('Contract/general_reports');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> General Report </button> </a>
						

                            </div>
							
                            <div class="card-body">
							
							<?php 
                        
							if(!empty($this->session->flashdata('smessage'))){
							echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('smessage'); ?>
									  <?php
                            echo "</div>";
							
							}
                        
							?>
							
					<form class="row" method="post" action="<?php echo site_url('Contract/find_task_general_reports');?>">
                    
                    <div class="form-group col-md-4 m-t-10">
                    <input type="text" name="fromdate" class="form-control mydatetimepickerFull" placeholder="From Date" required>
                    </div>
									
					<div class="form-group col-md-4 m-t-10">
                    <input type="text" name="todate" class="form-control mydatetimepickerFull" placeholder="To Date" required>
                    </div>
									
                    <div class="form-group col-md-4 m-t-10">
                    <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                    </div>
                    </form>
							

                               <?php if(isset($listdata)){ ?>
							   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												<th> PF No. </th>
												<th> Name </th>
												<th> Designation </th>
                                                <th> Weight  </th>
                                                <th> Total Assigned </th>
                                                <th> Total Makrs </th>
                                                <th> Average </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1; $totalweight=0; $sumassigned=0;$sumtotalmarks=0;$sumvg=0;
										foreach($listdata as $data){
										$empid = $data['provided_by'];
                                        $info = $this->ContractModel->get_employee_info($empid);
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <?php echo @$info->em_code; ?> </td>
												<td> 
                                                <a href="<?php echo site_url('Contract/view_assigned_task_performance_reports');?>?I=<?php echo base64_encode(@$empid);?>&F=<?php echo base64_encode(@$fromdate); ?>&T=<?php echo base64_encode(@$todate); ?>">
                                                <?php echo @$info->first_name.' '.@$info->middle_name.' '.@$info->last_name; ?> 
                                                 <i class="fa fa-eye"></i>
                                                </a>
                                                </td>
												<td> <?php echo @$info->des_name; ?> </td>
                                                <td> <?php echo number_format(@$data['weight']); $totalweight+=@$data['weight']; ?> </td>
												<td> <?php echo number_format(@$data['totalassigned']); $sumassigned+=@$data['totalassigned']; ?> </td>
                                                <td> <?php echo number_format(@$data['totalmarks']); $sumtotalmarks+=@$data['totalmarks']; ?> </td>
                                                <td> <?php echo number_format(@$data['taskaverage']); $sumvg+=@$data['taskaverage']; ?> </td>
                                            </tr>
										<?php  $sn++; } ?>  

                                        </tbody>

                                        <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total Summation</td>
                                        <td><?php echo number_format(@$totalweight); ?></td>
                                        <td><?php echo number_format(@$sumassigned); ?></td>
                                        <td><?php echo number_format(@$sumtotalmarks); ?></td>
                                        <td><?php echo number_format(@$sumvg); ?></td>
                                        </tr>

                                        
                                    </table>
                                </div>
							   <?php } ?>
							   
							   
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
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

<?php $this->load->view('backend/footer'); ?>