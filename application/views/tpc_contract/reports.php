<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Reports  </h3>
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
							
							 <h4 class="m-b-0 text-white"><i class="fa fa-file-text-o" aria-hidden="true"></i>  Staff performance report <span class="pull-right " ></span></h4>
						
                      <!--						
					  <a href="<?php echo site_url('Contract/reports');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Best Performance </button> </a>
					  <a href="<?php echo site_url('Contract/individualreport');?>">	 <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Individual Performance </button> </a>
					-->	
                            </div>
							
                            <div class="card-body">
							
							<?php 
							if(!empty($this->session->flashdata('message'))){
							echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
									  <?php echo $this->session->flashdata('message'); ?>
									  <?php
                            echo "</div>";
							
							}
							?>
							
							<form class="row" method="post" action="<?php echo site_url('Contract/findbesttaff_report');?>">
                                    <div class="form-group col-md-4 m-t-10">
                                    <input type="date" name="fromdate" class="form-control" placeholder="Enter Full name" required="required">
                                    </div>
									
									<div class="form-group col-md-4 m-t-10">
                                         <input type="date" name="todate" class="form-control" placeholder="Enter No." required="required">
                                    </div>
									
                                    <div class="form-group col-md-4 m-t-10">
                                         <button type="submit" class="btn btn-info"> <i class="fa fa-search"></i> Search </button>
                                    </div>
                            </form>
							

                               <?php if(isset($listbeststaff)){ ?>
							   <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
												 <th> PF No. </th>
												<th> Name </th>
												<th> Designation </th>
												<th> Completed Tasks </th>
												<th> Total Score </th>
												<th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php 
										$sn=1;
										foreach($listbeststaff as $data){
										$empid = $data->received_by;
                                        $info = $this->ContractModel->get_employee_info($empid);
                                        $year = date("Y",strtotime($this->session->userdata('todate')));
										?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
												<td> <?php echo $info->em_code; ?> </td>
												<td> <?php echo $info->first_name.' '.$info->middle_name.' '.$info->last_name; ?> </td>
												<td> <?php echo $info->des_name; ?> </td>
												<td> <?php echo number_format($data->totaltasks); ?> out of 
												<?php 
												echo @$this->ContractModel->count_tasks($empid,$year);
												?> 
												</td>
												<td> <?php echo number_format($data->totalscore); ?> </td>
												<td>
												<a href="<?php echo site_url('Contract/view_task_list');?>?empid=<?php echo $empid?>&&fromdate=<?php echo $this->session->userdata('fromdate'); ?>&&todate=<?php echo $this->session->userdata('todate'); ?>"> <button class="btn btn-info"> <i class="fa fa-eye"></i> View Tasks </button> </a>
												</td>
                                            </tr>
										<?php 
										$sn++;
										?>
										<?php
										}
										?>  
											
                                        </tbody>
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