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

                         <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><i class="fa fa-tasks"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                    
                                     </h3>
                                     
                         <a href="<?php echo base_url(); ?>Realestate/Hall_list" class="text-muted m-b-0">Conference</a>
                                 
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
                              <a href="<?php echo base_url();?>Realestate/add_hall_information" class="btn btn-info"><i class="fa fa-plus"></i>   Add Conference Information</a>

                              <a href="<?php echo base_url();?>Realestate/Hall_Customer_list" class="btn btn-info"><i class="fa fa-plus"></i>   Conference  Information</a>

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
                                    <td><select class="form-control custom-select district" name="disid" onchange="getEstate();">
                                        <option>--Select Property District--</option>
                                      </select></td>

                                       <td>
                                      <select class="form-control custom-select estate_name"  name="estate_name">
                                        <option>--Select Property --</option>
                                       
                                      </select>
                                    </td>

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
                                         <th>Estate Name</th><!-- 
                                         <th>Tenant Name</th>
                                         <th>Contract Number</th>
                                         <th>Contract End</th>
                                          <th>Contract Status</th> -->
                                         <th>Region</th>
                                         <th>District</th>
                                         <th>Estate Status</th>
                                         <!-- <th>Control No.</th>
                                         <th>Monthly Payment</th>
                                          <th>Cycle Payment</th>
                                         <th>Payment Status</th> -->
                                         <th>Actions</th>
                                       </tr>
                                     </thead>
                                     <tbody>

                                      <?php $i=1; foreach ($tenant as $value) {?>
                                       <tr>
                                         <td><?php echo $i; $i++; ?></td>
                                         <td><?php echo $value->estate_name;?></td>
                                        

                                         <td><?php $regid = $value->region; $reg = $this->dashboard_model->getRegion_ById($regid); echo $reg->region_name;?></td>
                                         <td><?php $disid =$value->district; $dis = $this->dashboard_model->getDistrict_ById($disid); echo $dis->district_name;?></td>
                                         <td><?php echo $value->estate_status;?></td>
                                         
                                         
                                       
                                         <td>
                                            <a href="#myModal" class="btn btn-danger" data-toggle="modal" data-code='<?php echo $value->estate_name; ?>'
                                                data-tenant_id="<?php echo $value->estate_name; ?>"
                                                 data-company="<?php echo $value->estate_name; ?>">Customer Details</a>
                                           
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


    <div class="modal fade bs-example-modal-lg " tabindex="-1" id="myModal2"  >
  <div class="modal-dialog " style="max-width:1500px ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">
         <label >Tenant Name: </label><input type="text" id="company" readonly style="border: none;" />  
    <!--      <label >Company Number: </label>  <input type="text" id="code" readonly />
         <label id="code" ></label>  &amp; <label id="company" ></label></h4>
 -->      </div>
      <div class="modal-body ">
        <div id="boxesdata">   </div>

        <?php    ?>
        <!-- <input type="text" id="code" readonly />
        <input type="text" id="company" readonly /> -->
  <div class="" style="text-align: center;">

          <h3 style="text-decoration-color: red;">Please  Pay the outstanding Rental Amount<input type="text" id="amount" readonly style="border: none;"></h3>
          <h3> via previous Controlnumber<input type="text" id="currency_type"  readonly style="border: none;"> </h3>
          <h3> In order to renew Contract  </h3>
           
             
          

        </div>




      </div>
    </div>
  </div>
</div>


  <div class="modal fade bs-example-modal-lg " tabindex="-1" id="myModal"  >
  <div class="modal-dialog " style="max-width:1500px ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="mySmallModalLabel">
         <label >Tenant Name: </label><input type="text" name="custname" id="company" readonly style="border: none;" />  
         <!-- <label >Company Number: </label>  <input type="text" id="code" readonly /> -->
         <!-- <label id="code" ></label>  &amp; <label id="company" ></label></h4> -->
      </div>
      <div class="modal-body ">
        <div id="boxesdata">   </div>

        <?php    ?>
        <!-- <input type="text" id="code" readonly />
        <input type="text" id="company" readonly /> -->
   <form method="POST" action="<?php echo base_url()?>Realestate/Update_contract_info">
                 <div class="row" style="padding-left: 15px;padding-right: 20px;">

                  

                                    <input type="text" name="tenant_id" id="tenant_id"  hidden="hidden" />
                                     <input type="text" name="mobile" id="mobile" hidden="hidden" />
                                      <input type="text" name="estate_id" id="estate_id" hidden="hidden" />
                                       <input type="text" name="region" id="region" hidden="hidden" />
                                        <input type="text" name="district" id="district" hidden="hidden" />


                                  <div class="form-group col-md-4">
                                    <label style="font-size:26px;">[Contract Number]</label>
                                    <input type="text" name="contarct_number" id="contarct_number" class="form-control"  required ="required">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label style="font-size:26px;">[Currency Type]</label>
                                    <select class="form-control custom-select"  name="currency_type"required ="required">
                                      <!-- <option id="currency_type"></option> -->
                                      <option>TSH</option>
                                      <option>USD</option>
                                    </select>
                                  </div>
                                
                                <div class="form-group col-md-4">
                                    <label style="font-size:26px; "><b>[Amount per Month]</b></label>
                                    <input type="text" id="amount" name="amount" class="form-control"required ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label >[Payment Cycle]</label>
                                    <select class="form-control custom-select" name="payment_cycle"required ="required">
                                      <!-- <option>--Select Payment Cycle--</option> -->
                                      <option>Monthly</option>
                                      <option>Quartery</option>
                                      <option>Semi Annual</option>
                                      <option>Annual</option>
                                    </select>
                                  </div>
                                  <!-- <div class="form-group col-md-4">
                                    <label>[Monthly Range]</label>
                                    <input type="text" name="monthrange" class="form-control">
                                  </div> -->
                                  <div class="form-group col-md-4">
                                    <label>[Start Date]</label>
                                    <input type="text" id="start" name="start_date" class="form-control  " readonly required ="required">
                                    <!-- mydatetimepickerFull -->
                                  </div>
                                  <div class="form-group col-md-4">
                                    <input type="hidden" name="type" class="form-control" value="Residential">
                                  </div>
                                  </div>

                                   <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                    </div>
                                    <br>
                                    <div style="padding-left: 15px;">
                                      <button class="btn btn-info" type="submit">Save Information</button>
                                    </div>
                                  </div>
                                </div>
                              </form>




      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  
$(function () {
  $('#myModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var code = button.data('code'); // Extract info from data-* attributes
    var company = button.data('company'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

                                            
    var tenant_id = button.data('tenant_id');
    var mobile = button.data('mobile');
    var estate_id = button.data('estate_id');
    var region = button.data('region');
    var district = button.data('district');

    var contarct_number = button.data('contarct_number');
    var currency_type = button.data('currency_type');
    var amount = button.data('amount');
    var start = button.data('start');
    //var serial = $('#regionp').val();
 //    $.ajax({
 //     type: "POST",
 //     url: "<?php echo base_url();?>Box_Application/GetBoxes",
 //     data:'serial='+ serial,
 //     success: function(data){
 //         $("#boxesdata").html(data);
 //     }
 // });
    var modal = $(this);
    modal.find('#code').val(code);
    modal.find('#company').val(company);

     modal.find('#tenant_id').val(tenant_id);
    modal.find('#mobile').val(mobile);
     modal.find('#estate_id').val(estate_id);
    modal.find('#region').val(region);
     modal.find('#district').val(district);

      modal.find('#contarct_number').val(contarct_number);
    modal.find('#currency_type').val(currency_type);
    modal.find('#amount').val(amount);
     modal.find('#start').val(start);
  });
});

</script>

<script type="text/javascript">
  
$(function () {
  $('#myModal2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var code = button.data('code'); // Extract info from data-* attributes
    var company = button.data('company'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

                                            
    var tenant_id = button.data('tenant_id');
    var mobile = button.data('mobile');
    var estate_id = button.data('estate_id');
    var region = button.data('region');
    var district = button.data('district');

    var contarct_number = button.data('contarct_number');
    var currency_type = button.data('currency_type');
    var amount = button.data('amount');
     var amounts =' '+amount+'/=Tshs' ;
      var controlno =' '+currency_type+'' ;
    //var serial = $('#regionp').val();
 //    $.ajax({
 //     type: "POST",
 //     url: "<?php echo base_url();?>Box_Application/GetBoxes",
 //     data:'serial='+ serial,
 //     success: function(data){
 //         $("#boxesdata").html(data);
 //     }
 // });
    var modal = $(this);
    modal.find('#code').val(code);
    modal.find('#company').val(company);

     modal.find('#tenant_id').val(tenant_id);
    modal.find('#mobile').val(mobile);
     modal.find('#estate_id').val(estate_id);
    modal.find('#region').val(region);
     modal.find('#district').val(district);

      modal.find('#contarct_number').val(contarct_number);
    modal.find('#currency_type').val(controlno);
     modal.find('#amount').val(amounts);
  });
});

</script>

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

<script type="text/javascript">
    function getEstate() {
    var district = $('.district').val();
    
      $.ajax({
     
      url: "<?php echo base_url();?>Realestate/getEstate",
      method:"POST",
      data:{district:district},//'region_id='+ val,
      success: function(data){
          $(".estate_name").html(data);

      }
  });
};
</script>
<?php $this->load->view('backend/footer'); ?>