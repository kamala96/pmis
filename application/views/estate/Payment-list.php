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
                              
                              <div class="">
                              </div>
                                 <div class="table-responsiveness">
                                   <table class="residential-list table table-bordered table-striped text-nowrap" width="100%" style="text-transform: uppercase;">
                                     <thead>
                                       <tr>
                                         <th>S/No</th>
                                         <th>Control No.</th>
                                         <th>Amount.</th>
                                         <th>Payment Channel</th>
                                         <th>Payment Receipt</th>
                                         <th>Payment Date</th>
                                       </tr>
                                     </thead>
                                     <tbody>

                                      <?php $i=1; foreach ($tenant as $value) {?>
                                       <tr>

                                         <td><?php echo $i; $i++; ?></td>
                                         <td><?php echo $value->controlno;?></td>
                                         <td><?php echo $value->amount;?></td>
                                         <td><?php echo $value->pay_channel;?></td>
                                         <td><?php echo $value->receipt;?></td>
                                         <td><?php echo $value->date_created;?></td>
                                         
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