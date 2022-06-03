<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Tenant Information</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Tenant Information</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12 row">
                     <div class="">
                   <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i>
                        <a href="<?php echo base_url(); ?>Realestate/Residential_list" class="text-muted m-b-0">Residential</a>
                    </button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i>
                         <a href="<?php echo base_url(); ?>Realestate/Land_list" class="text-muted m-b-0">Land</a>
                    </button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i>
                       <a href="<?php echo base_url(); ?>Realestate/Office_list" class="text-muted m-b-0">Offices</a>
                    </button>

                    
                </div>

                

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="">
                      <ul class="nav nav-tabs profile-tab" role="tablist">
                                <li class="nav-item"> <a class="nav-link active boxinfo" data-toggle="tab" href="#" role="tab" style=""> Tenant Information </a> </li>
                                
                                <li class="nav-item"> <a class="nav-link renewbox1" data-toggle="tab" href="#" role="tab" style=""> Renew Contract </a> </li>
                            <!--     <li class="nav-item"> <a class="nav-link addboxnumber" data-toggle="tab" href="#" role="tab" style=""> Allocate Box</a> </li>
                                <li class="nav-item"> <a class="nav-link lockreplacement1" data-toggle="tab" href="#profile" role="tab" style=""> Lock Replacement </a> </li>
                                <li class="nav-item"> <a class="nav-link keydeposite1" data-toggle="tab" href="#education" role="tab" style=""> Key Deposite</a> </li>
                                <li class="nav-item"> <a class="nav-link authority_card1" data-toggle="tab" href="#referee" role="tab" style=""> Box Rental Authority Card</a> </li> -->
                      </ul>
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


                    <div class="card-body">
                      <div class="infor">
                        <div class="card">
                           <div class="card-body">
                            <h4> Tenant Information </h4>

                  <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                    <?php } ?>
                            
                             <form method="POST" action="<?php echo base_url()?>Realestate/Save_Tenant_edited_information">
                                <div class="row">
                                  <div class="col-md-12" >
                                    <div style="border-bottom: dashed;">
                                      <!-- <h3>Edit Tenant Informations</h3> -->
                                    </div>
                                  </div>
                                </div>
                                  <br>

                            


                                <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[Customer Name]</label>
                                    <input type="text" name="custname" class="form-control" value="<?php echo $tenants->customer_name ; ?>"required ="required">
                                  </div>
                                  
                                <div class="form-group col-md-4">
                                    <label>[Mobile Number]</label>
                                    <input type="text" name="mobile_number" class="form-control"required ="required" value="<?php echo $tenants->mobile_number  ; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>[Address]</label>
                                    <input type="text" name="address" class="form-control"required ="required" value="<?php echo $tenants->address  ; ?>">
                                  </div>
                                  
                                  </div> 

                                   <?php if($type == "Land"){ ?>

                                 <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[VRN ]</label>
                                    <input type="text" name="vrn" class="form-control" value="<?php echo $tenants->vrn ; ?>"required ="required">
                                  </div>
                                  
                                <div class="form-group col-md-4">
                                    <label>[Tin Number]</label>
                                    <input type="text" name="tin_number" class="form-control"required ="required" value="<?php echo $tenants->tin_number  ; ?>">
                                </div>
                                
                                  
                                  </div>

                             <?php } ?>

                             <?php if($type == "Offices"){ ?>

                                 <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  <div class="form-group col-md-4">
                                    <label>[VRN ]</label>
                                    <input type="text" name="vrn" class="form-control" value="<?php echo $tenants->vrn ; ?>"required ="required">
                                  </div>
                                  
                                <div class="form-group col-md-4">
                                    <label>[Tin Number]</label>
                                    <input type="text" name="tin_number" class="form-control"required ="required" value="<?php echo $tenants->tin_number  ; ?>">
                                </div>
                                
                                  
                                  </div>

                             <?php } ?>



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
                                    <select class="form-control custom-select rgid" onchange="getDistrict();" name="region"required ="required">
                                      <?php if(!empty($reginal->region_name)){ ?>
                                        <option value="<?php echo $reginal->region_id; ?>"><?php echo $reginal->region_name; ?></option>

                                     <?php   }  ?>
                                     
                                        
                                        <?php foreach ($regvalue as $value){?>
                                          <option value="<?php echo $value->region_id; ?>"><?php echo $value->region_name; ?></option>
                                        <?php } ?>
                                      </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[District]</label>
                                    <select class="form-control custom-select district" name="district"required ="required">
                                      <?php if(!empty($reginal->region_name)){ ?>
                                       <option value="<?php echo $district->district_id; ?>"><?php echo $district->district_name; ?></option>

                                     <?php   }  ?>
                                       
                                        <!-- <option>--Select Property District--</option> -->
                                      </select>
                                  </div>
                                  <div class="form-group col-md-4">
                                    <label>[Estate Name]</label>
                                    <input type="text" name="estate_name" class="form-control"required ="required" value="<?php echo $tenants->estate_name; ?>">
                                  </div>
                                 
                                
                                
                              
                                  </div>

                                 
                                  <br>
                                <div class="row" style="padding-left: 15px;padding-right: 20px;">
                                  
                                  <div class="form-group col-md-4">
                                    <input type="hidden" name="estateid" class="form-control" value="<?php echo $tenants->estate_id; ?>">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <input type="hidden" name="tenantid" class="form-control" value="<?php echo $tenants->tenant_id; ?>">
                                  </div>
                                  <div class="form-group col-md-4">
                                    <input type="hidden" name="type" class="form-control" value="<?php echo $type; ?>">
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

                            <div class="card-body">
                            <h4>Payment Information</h4>
                            <table class="table table-bordered table-striped" style="width:100%;">
                              <tr>
                                <th style="width: 25%;">Contract Number</th>
                                 <th style="width: 25%;">Start Date</th>
                                 <th style="width: 25%;">End Date</th>
                                <th style="width: 25%;">Payment Cycle</th>
                                <th style="width: 25%;">Amount </th>

                                <th style="width: 25%;">Control Number</th>
                                <th style="width: 25%;">Receipt Number</th>
                                <th style="width: 25%;">Payment Date</th>
                                     <th style="width: 25%;" >Contract Status </th>
                            </tr>
                              <?php foreach (@$paymentlist as $value) { ?>
                                 <tr>
                                     <td style="width: 25%;"><?php echo $value->contract_number; ?></td>
                                      <td style="width: 25%;"><?php echo $value->start_date; ?></td>
                                        <td style="width: 25%;"><?php echo $value->end_date; ?></td>
                                       <td style="width: 25%;"><?php echo $value->payment_cycle; ?></td>
                                        <td style="width: 25%;"><?php echo $value->amount; ?></td>
                                    <td style="width: 25%;"><?php echo $value->billid; ?></td>
                                   <td style="width: 25%;"><?php echo $value->receipt; ?></td>
                                 </td><td style="width: 25%;"><?php echo $value->paymentdate; ?></td>
                               
                                 <td style="width: 25%;" colspan="2">
                                      <?php 
                                          $enddate =date('Y-m-d',strtotime($value->end_date));
                                         $today = date('Y-m-d');
                                          $diff = (strtotime($enddate) - strtotime($today)) / (60 * 60 * 24);
                                          //echo $diff;
                                           // echo $today;
                                         //$diff = $interval->days;
                                            if($diff >=0 ){ ?>
                                           <button class="btn btn-success" disabled="disabled">ACTIVE</button>
                                          <?php }else{ ?>
                                            <button class="btn btn-danger" disabled="disabled">EXPIRED</button>
                                          <?php } ?>
                                 </td>

                                

                             </tr>
                                 <?php } ?>
                              
                             
                            </table>
                            </div>
                           </div>
                        
                        

                        </div>
                        <div class="tab-pane renewbox" id="" style="display: none;">
                         <form method="POST" action="<?php echo base_url()?>Realestate/Update_contract_info">
                 <div class="row" style="padding-left: 15px;padding-right: 20px;">

                  

                                    <input type="text" name="tenant_id" id="tenant_id" value="<?php echo $paymentlist[0]->tenant_id; ?>"  hidden="hidden" />
                                     <input type="text" name="mobile" id="mobile" value="<?php echo $paymentlist[0]->mobile_number; ?>"  hidden="hidden" />
                                      <input type="text" name="estate_id" id="estate_id" value="<?php echo $paymentlist[0]->estate_id; ?>"  hidden="hidden" />
                                       <input type="text" name="region" id="region" value="<?php echo $paymentlist[0]->region; ?>"  hidden="hidden" />
                                         <input type="text" name="district" id="district" value="<?php echo $paymentlist[0]->district; ?>"  hidden="hidden" />
                                        <input type="text" name="type" id="type" value="<?php echo $type; ?>"  hidden="hidden" />


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



                        <br><br>
                         <h3 id="loadingtext" style="color: red;"></h3>
                          <h4 class="showvalue" id="showvalue"></h4>
                        <!-- <span class="showvalue"></span> -->
                       </div>
                       <div class="tab-pane allocatebox" id="" style="display: none;">
                        Box Allocation
                       </div>
                       <div class="tab-pane lockreplacement" id="" style="display: none;">
                        lock Replacement
                       </div>
                       <div class="tab-pane keydeposite" id="" style="display: none;">
                        Key Deposite
                       </div>
                       <div class="tab-pane authority_card" id="" style="display: none;">
                        Box Rental Authority Card
                       </div>
                    </div>
                  </div>
                </div>
            
            </div>
        </div>

<script type="text/javascript">
  $(".boxinfo").click(function(){
  $('.renewbox').hide();
  $('.infor').show();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".addboxnumber").click(function(){
  $('.renewbox').hide();
  $('.allocatebox').show();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').hide();
});
  $(".renewbox1").click(function(){
  $('.renewbox').show();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".lockreplacement1").click(function(){
  $('.renewbox').hide();
  $('.infor').hide();
  $('.lockreplacement').show();
  $('.keydeposite').hide();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".keydeposite1").click(function(){
  $('.renewbox').hide();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').show();
  $('.authority_card').hide();
  $('.allocatebox').hide();
});
  $(".authority_card1").click(function(){
  $('.renewbox').hide();
  $('.infor').hide();
  $('.lockreplacement').hide();
  $('.keydeposite').hide();
  $('.authority_card').show();
  $('.allocatebox').hide();
});
  $(".generate").click(function(){
    var cust_id = $('#cust_id').val();
     $('.generate').hide();
     $('#loadingtext').html('Please wait............');
     
    $.ajax({
                type : "POST",
                url  : "<?php echo base_url('Box_Application/RenewalBox')?>",
                //dataType : "JSON",
                data : {cust_id:cust_id},
                success: function(data){
                  $('.showvalue').html(data);
                   $('.generate').hide();
                   $('#loadingtext').hide();
                  // $('.renewbox').hide();
                  // $('.infor').show();
                  // $('.lockreplacement').hide();
                  // $('.keydeposite').hide();
                  // $('.authority_card').hide();

                  // $('.renewbox').hide();
                  // $('.infor').show();
                  // $('.lockreplacement').hide();
                  // $('.keydeposite').hide();
                  // $('.authority_card').hide();
                  // $('.allocatebox').hide();                  // $('.allocatebox').hide();
                }
            });

    //alert(cust_id);
});

</script>




<script type="text/javascript">
    $(document).ready(function() {
   
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

