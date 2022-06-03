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

                               <div style="display: none; font-size: 25px;background-color: #d22c19;color: white;" id="forMessage" class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <strong id="notifyMessage"></strong>
                        </div>

                        
                              <div>
                                <?php if(empty($sms)){ ?>
                            <?php }else{?>
                              <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong> <?php echo $sms; ?></strong>
                              </div>
                            <?php } ?>
                            </div>
                              <form method="POST" action="<?php echo base_url()?>Realestate/Save_Tenant_Information">
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
                                    <label>[Customer Name]</label>
                                    <!--  <input type="text" name="custname" id="custname" class="form-control custname"required ="required"> -->

                                     <input onchange="validateCustomer(this)" type="text" name="custname" class="form-control custname" id="custname" />
                                  </div>
                                  
                                <div class="form-group col-md-4">
                                    <label>[Mobile Number]</label>
                                    <input type="text" name="mobile_number" class="form-control"required ="required">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>[Address]</label>
                                    <input type="text" name="address" class="form-control"required ="required">
                                  </div>
                                  
                                  </div>

                                       <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[Tin number]</label>
                                    <input type="text" name="tin_number" class="form-control" >
                                  </div>
                                
                                <div class="form-group col-md-4">
                                    <label>[VRN]</label>
                                    <input type="text" name="vrn" class="form-control">
                                </div>
                               
                                  
                                  </div>

                                  <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                      <h3>Hall Informations</h3>
                                    </div>
                                  </div>
                                </div>
                                  <br>
                            <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[Region]</label>
                                    <select class="form-control custom-select rgid" onchange="getDistrict();" name="region"required ="required">
                                        <!-- <option>--Select Property Region--</option> -->
                                        <?php foreach ($regvalue as $value){?>
                                          <option value="<?php echo $value->region_id ?>"><?php echo $value->region_name ?></option>
                                        <?php } ?>
                                      </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[District]</label>
                                    <select class="form-control custom-select district" onchange="getHall();" name="district"required ="required">
                                        <!-- <option>--Select Property District--</option> -->
                                      </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[Hall Name]</label>
                                    <!-- <input type="text" name="estate_name" class="form-control"required ="required"> -->
                                     <select class="form-control custom-select hallname" onchange="getPrice();" name="estate_name"required ="required">
                                        <!-- <option>--Select Property District--</option> -->
                                      </select>
                                        <input type="hidden" name="status" class="form-control" value="Occupied">
                                  </div>
                                <!--   <div class="form-group col-md-4">
                                    <label>[Hall Status]</label>
                                    <select class="form-control custom-select" name="status"required ="required">
                                      <option>--Select Estate Status--</option>
                                      <option>Vacant</option>
                                      <option>Occupied</option>
                                    </select>
                                  </div> -->
                                
                                <div class="form-group col-md-4">
                                    <label>Add Additional Facility</label>
                                    <!-- <input type="text" name="floor" class="form-control"> -->
                                     <select class="form-control custom-select floor"  name="floor" onchange="getPrice();"  required ="required">
                                      <option>Nill</option>
                                       <option>Projector</option>
                                        
                                      </select>

                                        <!-- <input type="hidden" name="room_number" class="form-control" value="Nill"> -->
                                </div>
                                <div class="form-group col-md-4" style="display: none;" id="projdays">
                                    <label>[Facility Number of Days]</label>
                                    <input type="text" name="room_number" class="form-control room_number" onchange="getPrice();" value="0">
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
                                     <input type="hidden" name="payment_cycle" class="form-control" value="Custom">
                                    <label>[Start Date]</label>
                                    <input type="text" name="start_date" class="form-control mydatetimepickerFull start_date"required ="required">
                                  </div>
                                    <div class="form-group col-md-4">
                                    <label>[End Date]</label>
                                    <input type="text" name="end_date" class="form-control mydatetimepickerFull end_date" onchange="getPrice();"  required ="required">
                                  </div>
                                  <div class="form-group col-md-4"></div>

                                  <div class="form-group col-md-4">
                                      <input type="hidden" name="regions" class="form-control regions" >
                                        <input type="hidden" name="districts" class="form-control districts" >
                                    <label style="font-size:26px;">[Contract Number]</label>
                                    <input type="text" name="contarct_number" class="form-control Contract" required ="required" >
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label style="font-size:26px;">[Currency Type]</label>
                                    <select class="form-control custom-select currency" onchange="getPrice();" name="currency_type"required ="required">
                                      <!-- <option>--Select Currency Type--</option> -->
                                      <option>TSH</option>
                                      <option>USD</option>
                                    </select>
                                  </div>
                                
                                <div class="form-group col-md-4">
                                    <label style="font-size:26px; "><b>[Amount]</b></label>
                                    <input type="text" name="amount" class="form-control amount" readonly >
                                </div>
                             
                              
                                 
                                  <div class="form-group col-md-4">
                                    <input type="hidden" name="type" class="form-control" value="Hall">
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

 function getHall() {
    var district = $('.district').val();//Contract
    
      $.ajax({
     
      url: "<?php echo base_url();?>Realestate/getHall",
      method:"POST",
      data:{district:district},//'region_id='+ val,
      success: function(data){
          $(".hallname").html(data);

      }
  });

      getPrice();
      getregions();
      getdistricts();
      gethall();
      
};

function getregions() {
    var region_id = $('.rgid').val();
    
      $.ajax({
     
      url: "<?php echo base_url();?>Realestate/getregions",
      method:"POST",
      data:{region_id:region_id},
      success: function(data){
          var  result = data.trim();
          $(".regions").val(result);

      }
  });
      
};

function getdistricts() {
    var district = $('.district').val();//Contract
    
      $.ajax({
     
      url: "<?php echo base_url();?>Realestate/getDistricts",
      method:"POST",
      data:{district:district},
      success: function(data){
         var  result = data.trim();
          $(".districts").val(result);

      }
  });
      
};

function gethall() {
    var hallname = $('.hallname').val();
       $(".hallname").val(hallname);
};


 function getcontaract() {
    var hallname = $('.hallname').val();
      var facility = $('.floor').val();
       var districtid = $('.districts').val();
       var rgid= $('.regions').val();
        var rst=rgid+'/'+districtid+'/'+hallname+'/';
       $(".Contract").val(rst);
};

 function getPrice() {
    var hallname = $('.hallname').val();
      var facility = $('.floor').val();
      var start_date = $('.start_date').val();
      var end_date = $('.end_date').val();
      var projectordays = $('.room_number').val();
       var district = $('.district').val();
       var currency= $('.currency').val();
       if(facility == 'Projector'){
                    $('#projdays').show();
                }else{
                    $('#projdays').hide();
                }
    
      $.ajax({
     
      url: "<?php echo base_url();?>Realestate/getHallPrice",
      method:"POST",
      data:{hallname:hallname,facility:facility,district:district,currency:currency,projectordays:projectordays,start_date:start_date,end_date:end_date},//'region_id='+ val,
      success: function(data){
      var  result = data.trim();
          $(".amount").val(result);
         


      }
  });
      getcontaract();

};



function validateCustomer(obj){
    var custname = $(obj).val();
     var custname = $('.custname').val();
    
   
   
        $.ajax({
            type : "POST",
            url  : "<?php echo base_url();?>Realestate/checkCustomerexist",
            data:'custname='+custname,
            dataType:'json',
            success: function(data){
                 
                if(data['status'] == 'available'){
                    $('#optionBox').hide();
                    $('#forMessage').show();
                    $('#notifyMessage').html(data['message']);
                }else{
                    $('#optionBox').show();
                    $('#forMessage').hide();
                    $('#notifyMessage').html('');
                }
            }
        });
    

}
</script>

<?php $this->load->view('backend/footer'); ?>