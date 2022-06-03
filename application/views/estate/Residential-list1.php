<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<div class="page-wrapper">
	<div class="message"></div>
	<div class="row page-titles">
		<div class="col-md-5 align-self-center">
			<h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Real Estate</h3>
		</div>
		<div class="col-md-7 align-self-center">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active"><?php echo $this->session->userdata('heading'); ?></li>
			</ol>
		</div>
	</div>
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<?php $regvalue = $this->employee_model->regselect(); ?>

	<br/>
	<div class="container-fluid">

		<div class="row">
             
                    <?php 
                     $id = $this->session->userdata('user_login_id');
                      $basicinfo = $this->employee_model->GetBasic($id);
                      $sub_role = $basicinfo->em_sub_role;
                        ?>
           <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-bank"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                 
                                     </h3>
                        <a href="<?php echo base_url(); ?>Realestate/Residential_list" class="text-muted m-b-0">Residential</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                      <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-success"><i class="fa fa-archive"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                 
                                     </h3>
                        <a href="<?php echo base_url(); ?>Realestate/Land_list" class="text-muted m-b-0">Land</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><i class="fa fa-tasks"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                         <a href="<?php echo base_url(); ?>Realestate/Office_list" class="text-muted m-b-0">Offices</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <?php 
                     $id = $this->session->userdata('user_login_id');
                      $basicinfo = $this->employee_model->GetBasic($id);
                      $sub_role = $basicinfo->em_sub_role;
                        ?>


                    <?php 
                     $id = $this->session->userdata('user_login_id');
                      $basicinfo = $this->employee_model->GetBasic($id);
                      $sub_role = $basicinfo->em_sub_role;
                        ?>
                        
		</div>

    <div class="row">
      <div class="col-lg-12 col-md-12">
                        <div class="card" style="">
                          <div class="">
                            
                          </div>
                            <div class="card-body">
                              <a href="<?php echo base_url();?>Realestate/Add_Tenant_information" class="btn btn-info"><i class="fa fa-plus"></i>   Add Residential Information</a>
                              <br>
                              <br>
                              <div class="">
                                <form method="POST" action="<?php echo base_url()?>Realestate/Residential_list">
                                <table class="table table-bordered" width="100%">
                                  <tr>
                                    <td>
                                      <select class="form-control custom-select rgid" onchange="getDistrict();" name="regid">
                                        <option>--Select Property Region--</option>
                                        <?php foreach ($regvalue as $value){?>
                                          <option value="<?php echo $value->region_id ?>"><?php echo $value->region_name ?></option>
                                        <?php } ?>
                                      </select>
                                    </td>
                                    <td><select class="form-control custom-select district" name="disid">
                                        <option>--Select Property District--</option>
                                      </select></td>
                                      <td><select class="form-control custom-select" name="estatus">
                                        <option>--Select Property Status--</option>
                                        <option>Occupied</option>
                                        <option>Vacant</option>
                                      </select></td>
                                      <td><select class="form-control custom-select" name="status">
                                        <option>--Select Payment Status--</option>
                                        <option value="Paid">Paid</option>
                                        <option value="NotPaid">Not Paid</option>
                                      </select></td>
                                    <td>
                                      <button type="submit" class="btn btn-info" name="search" value="search">Search Here</button>
                                    </td>
                                  </tr>
                                </table>
                                </form>
                              </div>
                                 <div class="table-responsiveness" style="overflow-x: auto;">
                                   <table class="residential-list table table-bordered table-striped text-nowrap" width="100%" style="text-transform: uppercase;">
                                     <thead>
                                       <tr>
                                         <th>S/No</th>
                                         <th>Estate Name</th>
                                         <th>Tenant Name</th>
                                         <th>Contract Number</th>
                                         <th>Contract End</th>
                                         <th>Region</th>
                                         <th>District</th>
                                         <th>Estate Status</th>
                                         <th>Control No.</th>
                                         <th>Amount.</th>
                                         <th>Payment Status</th>
                                         <th>Actions</th>
                                       </tr>
                                     </thead>
                                     <tbody>

                                      <?php $i=1; foreach ($tenant as $value) {?>
                                       <tr>
                                         <td><?php echo $i; $i++; ?></td>
                                         <td><?php echo $value->estate_name;?></td>
                                         <td><?php echo $value->customer_name?></td>
                                         <td><?php echo $value->contract_number;?></td>
                                         <td><?php echo date('Y-m-d',strtotime($value->end_date));?></td>
                                         <td><?php $regid = $value->region; $reg = $this->dashboard_model->getRegion_ById($regid); echo $reg->region_name;?></td>
                                         <td><?php $disid =$value->district; $dis = $this->dashboard_model->getDistrict_ById($disid); echo $dis->district_name;?></td>
                                         <td><?php echo $value->estate_status;?></td>
                                         <td><?php echo $value->billid;?></td>
                                         <td><?php $controlno = $value->billid;
                                         $sum = $this->dashboard_model->getsumPayment($controlno);
                                         $diff = $value->amount-$sum->sum_amount;
                                         if ($diff <=0) {
                                           echo number_format($value->amount,2);
                                         } else {
                                           echo number_format($value->amount-$sum->sum_amount,2);
                                         }
                                         
                                          ?></td>
                                         <td>
                                          <?php if($diff <=0 ){ ?>
                                           <button class="btn btn-success" disabled="disabled">Paid</button>
                                          <?php }else{ ?>
                                            <button class="btn btn-danger" disabled="disabled">Not Paid</button>
                                          <?php }$type="Residential"; ?>
                                         </td>
                                         <td>
                                           <a href="Edit_Tenant_information?id=<?php echo $value->tenant_id; ?>&type=<?php echo $type; ?>" class="btn btn-warning">Edit</a> | 
                                           <a href="getPaymentTrend?controlno=<?php echo $value->billid; ?>" class="btn btn-info">Payment Trend</a>
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
  <script type="text/javascript">
    $(document).ready( function () {
    $('.residential-list').DataTable({
        dom: 'Bfrtip',
        ordering:false,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    });
</script>
<script type="text/javascript">
    function getDistrict() {
    var region_id = $('.rgid').val();
    
      $.ajax({
     
      url: "<?php echo base_url();?>Realestate/getDistrict",
      method:"POST",
      data:{region_id:region_id},//'region_id='+ val,
      success: function(data){
          $(".district").html(data);

      }
  });
};
</script>
<?php $this->load->view('backend/footer'); ?>