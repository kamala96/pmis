<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Contract Management </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Legal Section</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">

                    <?php if($this->session->userdata('user_type') == "ADMIN"){ ?>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>organization/Contract" class="text-white"><i class="" aria-hidden="true"></i> Contract Type</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>organization/Agreement" class="text-white"><i class="" aria-hidden="true"></i> Agreement Type</a></button>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Services/legal" class="text-white"><i class="" aria-hidden="true"></i> Contract List </a></button>
                     <?php } ?>

                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Contract List                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">


                        <?php if($this->session->flashdata('success')){ ?> 
                           <div class='alert alert-success alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong> <?php echo $this->session->flashdata('success'); ?>  </strong> 
                           </div>                         
                          <?php } ?>
                          
                          <?php if($this->session->flashdata('feedback')){ ?> 
                           <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                           </button>
                            <strong>  <?php echo $this->session->flashdata('feedback'); ?>  </strong> 
                           </div>                         
                          <?php } ?>


                        <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-animation="bounce" data-target=".bs-example-modal-lg">  <i class="fa fa-plus"></i> Add Contract </button>

                        <!--  Modal content -->
                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Add Contract </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                                                                    
                        
                        <form method="post" action="<?php echo site_url('Box_Application/contract_action'); ?>" enctype="multipart/form-data"> 
                                <div class="row">
                            
                                <div class="form-group col-md-6">
                                    <label>Contract Type</label>
                                    <select name="cont_type" class="custom-select form-control ag" required="" onChange="getAgreement();">
                                        <option value="">--Select Contract Type--</option>
                                        <?php foreach ($service as  $value) {?>
                                           <option value="<?php echo $value->cont_id ?>"><?php echo $value->cont_name ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                        <label>Agreement Type</label>
                                        <select name="agreement_type" value="" class="form-control custom-select agrId">  
                                            <option>--Select Service Type--</option>
                                        </select>

                                    </div>
                                <div class="form-group col-md-12">
                                <label>Parties Names</label>
                                    <input type="text" name="parties_name" class=" form-control" required="required">
                                </div>
                                <div class="form-group col-md-12">
                                <label>Mobile Number</label>
                                    <input type="text" name="mobile" class=" form-control" required="required" onkeypress="myFunction()" id="day13" >
                                    <span class="errorPhone" style="color: red;display: none;">This is not valid Phone number</span>

                                </div>
                                <div class="form-group col-md-12">
                                <label>Region</label>
                                    <select class="form-control custom-select" name="con_region" required="" >
                                        <option value="">--Select Region--</option>
                                    <?php foreach ($regionlist as $value) {?>
                                    <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                    <?php } ?>
                                    </select>
                                </div>

                                
                                </div>
                                <br>
                                <div class="row"><!-- 
                                    <div class="col-md-6"></div> -->
                                    <div class="col-md-6">
                                    <button class="btn btn-info btn-primary" type="submit">Save Information</button>
                                    </div>
                                </div>
                        </form> 



                                                                    
                        </div>
                        </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                         <!-- End -->


                            <div id="div1" class="table-responsive"> 
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Registered Date</th>
                                                <th>Contract Type</th>
                                                <th>Parties Name</th>
                                                <th>Mobile Number</th>
                                                <th>Region</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Mode Of Payment</th>
                                                <th>Price (Tsh.)</th>
                                                <th>Scanned Document</th>
                                                <th>Status</th>
                                                <th style="text-align: right;">Action</th>
                                               
                                            </tr>
                                        </thead>
                                        
                                 <tbody class="results">
                                   <?php foreach ($contract as  $value) {
                                    $id = $value->contid;
                                    ?>
                                    <tr>
                                        <td><?php echo $value->registered_date ?></td>
                                        <td><?php echo $value->cont_name;   if(!empty($value->agreement_type)){ echo " - ".$value->agreement_type; } ?> </td>
                                         <td><?php echo $value->parties_name;?></td>
                                         <td><?php echo $value->mobile ?></td>
                                         <td><?php echo $value->region ?></td>
                                        <td><?php 
                                        if ($value->start_date == '') {
                                            echo "Awaiting";
                                            } else {
                                                 echo date('jS \of F Y',strtotime($value->start_date));
                                            }
                                            
                                        ?>
                                        </td>
                                        <td><?php 

                                            if ($value->start_date == '') {
                                              echo "Awaiting"; 
                                            } else {
                                                 echo date('jS \of F Y',strtotime($value->end_date));
                                            }
                                        
                                        ?></td>
                                       
                                        
                                        <td><?php if(!empty($value->mode_payment)){ echo $value->mode_payment; } else { echo "Awaiting"; } ?></td>
                                        <td><?php echo number_format($value->cont_price) ?></td>
                                        
                                        <td>
                                            
                                           <?php  if(!empty($value->scann_docu)){ ?>
                                            <a href="<?php echo base_url(); ?>assets/images/users/<?php echo $value->scann_docu; ?>">

                                                View Contract
                                                    

                                            </a>
                                        <?php } else { ?>
                                      
                                      No attachment 

                                        <?php } ?>

                                        </td>
                                        
                                        <td>
                                            <?php 

                                              $startYear= $value->start_date;
                                              $year1=date('Y', strtotime($startYear));
                                              $year =date('Y', strtotime($startYear));
                                              $yearDays = 366;
                                              $todayDays =  date('z', strtotime($year1)) + 1;
                                              $dayDiff = $yearDays - $todayDays;
                                              
                                             if ($dayDiff == 100) {
                                                 echo "<button class='btn btn-info btn-sm'>Renew Contract</button>";
                                             }else{
                                                if ($value->status == 'ACTIVE') {
                                                echo "<button class='btn btn-info btn-sm'>Active Contract</button>";
                                                }elseif($value->status == 'CANCEL'){
                                                     echo "<button class='btn btn-info btn-sm'>Canceled Contract</button>";
                                                }elseif($value->status == 'IsPMG'){
                                                     echo "<button class='btn btn-info btn-sm'>PMG/GMCRM/GMBOP Signed</button>";
                                                }elseif($value->status == 'IsComplete'){
                                                     echo "<button class='btn btn-info btn-sm'>Completed Contract</button>";
                                                }else{

                                                    echo "<button class='btn btn-info btn-sm'>Signed By Legal</button>";
                                                }
                                             }
                                            ?>
                                            
                                        </td>
                                        <td style="text-align: right;">

                                            <!-- <input type="hidden" name="" class="contId" value="<?php echo $value->contid ?>"> -->
                                                <?php
                                                if ($value->status == 'CANCEL' ||  $value->status == 'IsComplete') {
                                                  
                                                } else {
                                                 
                                                 if($value->status=="IsPMG"){
                                                  ?>
                            <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#complete_modal<?php echo $value->contid; ?>">  <i class="fa fa-file-text-o"></i> Complete </button>
                                               <?php } ?>

                                             <?php if($value->status == 'ACTIVE' ||  $value->status == 'isLegal'){ ?>
                            <button title="Edit" class="btn btn-sm btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#update_modal<?php echo $value->contid; ?>">  <i class="fa fa-file-text-o"></i> Status </button>
                                             <?php } ?>


                                              <?php 
                                                }
                                                ?>

                            
                            <a href="<?php echo site_url('Box_Application/delete_selected_contract');?>?id=<?php echo $id;?>" onclick='return del();'> <button class="btn btn-info btn-xs"><i class="fa fa-trash-o"></i> Delete </button> </a>
 
                            <?php if($value->status=='IsComplete'){ ?>
                            <button title="Edit" class="btn btn-xs btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#edit_contract_modal<?php echo $value->contid; ?>">  <i class="fa fa-pencil-square-o"></i> Edit Contract </button>
                            <?php } ?>

                            <button title="Edit" class="btn btn-xs btn-info waves-effect waves-light" data-toggle="modal" type="button" data-target="#edit_updates_modal<?php echo $value->contid; ?>">  <i class="fa fa-pencil-square-o"></i> Edit </button>
                                            
                                        </td>
                                    </tr>


                                 
                                      <!-- Edit Status -->
                        <div class="modal fade" id="update_modal<?php echo $value->contid; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Update Contract Status </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                    <div class="modal-body"> 
            
                    <form role="form" action="<?php echo site_url('Box_Application/cancel_contract'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="conid" class="form-control" value="<?php echo $value->contid; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label>Contract Status</label>
                    <select class="custom-select form-control status" name="status">
                        <option value="CANCEL">Cancel</option>
                        <option value="isLegal">Signed By Legal Section</option>
                        <option value="isPMG">Signed By PMG/GMCRM/GMBOP</option>
                    </select>
                </div>
            </div>
        

        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
           

            <button class="btn btn-info btn-primary" type="submit"> Submit </button>

        </div>
        </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End Status -->


                  <!-- Complete Status -->
                        <div class="modal fade" id="complete_modal<?php echo $value->contid; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Complete Contract  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                    <div class="modal-body"> 
            
                    <form role="form" action="<?php echo site_url('Box_Application/cancel_contract'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="conid" class="form-control" value="<?php echo $value->contid; ?>">
                     <input type="hidden" name="status" class="form-control" value="<?php echo "isComplete"; ?>">
                </div>
            </div>
           

                                   <div class="form-group col-md-12">
                                        <label>Start Date </label>
                                        <input type="date" name="start_date" class="form-control" placeholder=""> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>End Date </label>
                                        <input type="date" name="end_date" class="form-control" placeholder=""> 
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Contract Year </label>
                                        <select name="contract_year" class="form-control custom-select">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Payment Mode </label>
                                        <select name="mode_payment" class="form-control custom-select">
                                            <option value="">--Select Payment Mode--</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Semiannual">Semiannual</option>
                                            <option value="Annual">Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Contract Price</label>
                                        <input type="number" name="cont_price" id=""  class="form-control" placeholder=""> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Scaned Contract ( Maximum Size 2MB -- PDF File Only )</label>
                                        <input type="file" name="image_url" id=""  class="form-control" placeholder="" > 
                                    </div>


            
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
           

            <button class="btn btn-info btn-primary" type="submit"> Submit </button>

        </div>
        </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End Status -->


                  <!-- Edit Contract Status -->
                        <div class="modal fade" id="edit_contract_modal<?php echo $value->contid; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Contract Information  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                    <div class="modal-body"> 
            
    <form role="form" action="<?php echo site_url('Box_Application/edit_contract_info'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            

                    <input type="hidden" name="conid" class="form-control" value="<?php echo $value->contid; ?>">
    

                                   <div class="form-group col-md-12">
                                        <label>Start Date </label>
                    <input class="form-control" name="start_date" type="text" onfocus="(this.type='date')" id="date" value="<?php echo $value->start_date;?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>End Date </label>
                    <input class="form-control" name="end_date" type="text" onfocus="(this.type='date')" id="date" value="<?php echo $value->end_date;?>">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Contract Year </label>
                                        <select name="contract_year" class="form-control custom-select">
                                            <option value="<?php echo $value->contract_year; ?>"> <?php echo $value->contract_year; ?> </option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Payment Mode </label>
                                        <select name="mode_payment" class="form-control custom-select">
                                            <option value="<?php echo $value->mode_payment; ?>"> <?php echo $value->mode_payment; ?> </option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Semiannual">Semiannual</option>
                                            <option value="Annual">Annual</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Contract Price</label>
                                        <input type="number" name="cont_price" id=""  class="form-control" placeholder="" value="<?php echo $value->cont_price; ?>"> 
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Scaned Contract ( Maximum Size 2MB -- PDF File Only )</label>
                                        <input type="file" name="image_url" id=""  class="form-control" placeholder="" > 
                                        <a href="<?php echo base_url(); ?>assets/images/users/<?php echo $value->scann_docu; ?>"> View Attachment </a>

                                    </div>

            
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
           
           

            <button class="btn btn-info btn-primary" type="submit"> Submit </button>

        </div>
        </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End of Editing Status -->

                 <!-- Edit Contract Only -->

                                   <!-- Edit Contract Status -->
                        <div class="modal fade" id="edit_updates_modal<?php echo $value->contid; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                               
                        <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel"> Edit Information  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                                        
                    <div class="modal-body"> 
            
    <form role="form" action="<?php echo site_url('Box_Application/update_contract_information'); ?>" method="post">
        <div class="modal-body">
            

                    <input type="hidden" name="conid" class="form-control" value="<?php echo $value->contid; ?>">
                            
                                <div class="form-group col-md-12">
                                    <label>Contract Type</label>
                                    <select name="cont_type" class="custom-select form-control ag2" required="" onChange="getAgreement2();">
                                        <option value="<?php echo $value->cont_type; ?>"><?php echo $value->cont_name; ?></option>
                                        <?php foreach ($service as  $data) {?>
                                           <option value="<?php echo $data->cont_id ?>"><?php echo $data->cont_name ?></option>
                                        <?php } ?>
                                        
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                        <label>Agreement Type</label>
                                        <select name="agreement_type" class="form-control custom-select agrId2">  
                                            <option value="<?php echo $value->agreement_type; ?>"> <?php echo $value->agreement_type; ?> </option>
                                        </select>

                             </div>

                                <div class="form-group col-md-12">
                                <label>Parties Names</label>
                                    <input type="text" name="parties_name"  value="<?php echo $value->parties_name; ?>" class="form-control" required="required">
                                </div>

                                <div class="form-group col-md-12">
                                <label>Mobile Number</label>
                                    <input type="text" name="mobile" class=" form-control" value="<?php echo $value->mobile; ?>"required="required" onkeypress="myFunction()" id="day13" >
                                    <span class="errorPhone" style="color: red;display: none;">This is not valid Phone number</span>

                                </div>
                                <div class="form-group col-md-12">
                                <label>Region</label>
                                    <select class="form-control custom-select" name="con_region" required="" >
                                        <option value="<?php echo $value->region; ?>"> <?php echo $value->region; ?> </option>
                                    <?php foreach ($regionlist as $data) {?>
                                    <option value="<?php echo $data->region_name ?>"><?php echo $data->region_name ?></option>
                                    <?php } ?>
                                    </select>
                                </div>
    


            
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
            <button class="btn btn-info btn-primary" type="submit"> Submit </button>

        </div>
        </form>
                      
                        </div>
                       </div>
                       </div>
                    </div>
                 <!-- End Status -->

                <!-- End of Contract-->




                                   <?php } ?>
                                 </tbody>
                                    </table>
                            </div>

                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

                </div>
           
            </div>
        </div>





<script type="text/javascript">
    $(document).ready(function() {
    $('#day13').on('keyup', function() {
  var textinsert = ($(this).val());
    var regex=/^[0-9]+$/;
    if (textinsert.match(regex))
    {
        $('.errorPhone').hide();
     return false;
    }else{
        $('.errorPhone').show();
    }
});
});
</script>

<script type="text/javascript">
      function del()
      {
        if(confirm("Are you sure you want to delete?"))
        {
            return true;
        }
        
        else{
            return false;
        }
      }
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

<script type="text/javascript">
        function getAgreement() {
     var agid = $('.ag').val();
     $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>organization/getAgreement",
      data:'ag_id='+ agid,
     success: function(data){
          $(".agrId").html(data);
      }
  });
};

function getAgreement2() {
     var agid2 = $('.ag2').val();
     $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>organization/getAgreement",
      data:'ag_id='+ agid2,
     success: function(data){
          $(".agrId2").html(data);
      }
  });
};
</script>


<?php $this->load->view('backend/footer'); ?>

