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
                              <form method="" action="">
                                <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                      <h3>Tenant Informations</h3>
                                    </div>
                                  </div>
                                </div>
                                  <br>
                                <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[First Name]</label>
                                    <input type="text" name="first_name" class="form-control" required ="required">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[Middle Name]</label>
                                    <input type="text" name="middle_name" class="form-control" required ="required">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[Last Name]</label>
                                    <input type="text" name="last_name" class="form-control" required ="required">
                                  </div>
                                
                                <div class="form-group col-md-4">
                                    <label>[Mobile Number]</label>
                                    <input type="text" name="mobile_number" class="form-control" required ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>[Address]</label>
                                    <input type="text" name="address" class="form-control" required ="required">
                                  </div>
                                  
                                  </div>

                                  <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                      <h3>Estate Informations</h3>
                                    </div>
                                  </div>
                                </div>
                                  <br>
                                <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[Region]</label>
                                    <select class="form-control custom-select rgid" onchange="getDistrict();" name="region" required ="required">
                                        <!-- <option>--Select Property Region--</option> -->
                                        <?php foreach ($regvalue as $value){?>
                                          <option value="<?php echo $value->region_id ?>"><?php echo $value->region_name ?></option>
                                        <?php } ?>
                                      </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[District]</label>
                                    <select class="form-control custom-select district" name="district" required ="required">
                                        <!-- <option>--Select Property District--</option> -->
                                      </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[Estate Status]</label>
                                    <select class="form-control custom-select" name="status" required ="required">
                                      <!-- <option>--Select Estate Status--</option> -->
                                      <option>Vacant</option>
                                      <option>Occupied</option>
                                    </select>
                                  </div>
                                
                                <div class="form-group col-md-4">
                                    <label>[Floor]</label>
                                    <input type="text" name="floor" class="form-control" >
                                </div>
                                <div class="form-group col-md-4">
                                    <label>[Room Number]</label>
                                    <input type="text" name="room_number" class="form-control" >
                                  </div>
                                  
                                  </div>

                                  <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                      <h3>Contract Informations</h3>
                                    </div>
                                  </div>
                                </div>
                                  <br>
                                <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[Contract Number]</label>
                                    <input type="text" name="contarct_number" class="form-control"required ="required">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[Currency Type]</label>
                                    <select class="form-control custom-select" name="status"required ="required">
                                      <!-- <option>--Select Currency Type--</option> -->
                                      <option>CASH</option>
                                      <option>USD</option>
                                    </select>
                                  </div>
                                
                                <div class="form-group col-md-4">
                                    <label>[Amount]</label>
                                    <input type="text" name="amount" class="form-control"required ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>[Payment Cycle]</label>
                                    <select class="form-control custom-select" name="status"required ="required">
                                      <!-- <option>--Select Payment Cycle--</option> -->
                                      <option>Monthly</option>
                                      <option>Quartery</option>
                                      <option>Semi Annual</option>
                                      <option>Annual</option>
                                    </select>
                                  </div>
                                  
                                  </div>
                                  <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                    </div>
                                    <br>
                                    <div style="padding-left: 15px;">
                                      <button class="btn btn-info">Save Information</button>
                                    </div>
                                  </div>
                                </div>
                              </form>
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