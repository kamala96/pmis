<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
        <?php 
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id); 
                        //     if (!empty($id)) {
                        //         echo $basicinfo->em_role;
                        //        } ?>
                      Dashboard Back Office</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        Dashboard Back Office</li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    <div class="row ">
                    <!-- Column -->

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/in.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php
                                     echo $despatchInCount;   
                                    ?>
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_in" class="text-muted m-b-0">Total Despatch In</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/sent.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php
                                       echo $despatchCount;
                                    ?>
                                    
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/despatch_out" class="text-muted m-b-0">Total Despatch Out</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/receiving.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                   echo $ems;
                   ?>
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/BackOffice" class="text-muted m-b-0">Total Item from Counter</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="<?php echo base_url()?>assets/images/bag.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                   <?php 
                  echo $bags;
                  ?>
                                     </h3>
                                     
                                        <a href="<?php echo base_url(); ?>Box_Application/ems_bags_list" class="text-muted m-b-0">Total Bags</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="">
                         <a href="despatched_bags_list" class="btn btn-info " style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Despatched Bags</a>
                          <a href="pending_bags_despatch_list" class="btn btn-info" style="padding-right: 10px;"><i class="fa fa fa-bars"></i> Pending Despatched Bags</a>
                        </div> 
                        <hr/>
                      </div>
                      <div class="card-body">
                        <form method="POST" action="bags_despatch">

                    <div class="table-responsive row col-md-12">

                      <table id="example5" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Bag Number</th>
                            <th>Bag Region Origion</th>
                            <!-- <th>Bag Branch Origion</th> -->
                            <th>Bag Destination</th>
                             <th>Bag Branch Destination</th>
                            <th>Date Bag Created</th>
                            <th>Bag Weight</th>
                            <th>Bag Status</th>
							<?php if(empty($emsbags)){ ?>
							
							<?php }else{?>
							<th>
                              <div class="form-check" style="padding-left: 53px;" id="showCheck">
                               <input type="checkbox"  class="form-check-input" id="checkAll1" style="">
                               <label class="form-check-label" for="remember-me">Select All</label>
                             </div>
                           </th> 
							<?php }?>
                            
                         </tr>
                       </thead>

                       <tbody class="results">
                         <?php foreach ($emsbags as  $value) {?>
                           <tr>
                             <td>
                               <a href="#" data-bagno = "<?php echo $value->bag_number; ?>" class="listitem"><?php echo $value->bag_number;?></a>

                             </td>
                             <td><?php echo @$value->bag_region_from;?></td>
                             <!--<td><?php echo @$value->bag_branch_from;?></td> -->
                             <td><?php echo $value->bag_region;?>
                             <td><?php echo $value->bag_branch;?>
                             <input type="hidden" name="" class="reg" value="<?php echo $value->bag_region;?>">
                           </td>
                           <td><?php echo $value->date_created;?></td>
                           <td><?php echo $value->bag_weight; ?></td>
                           <td>
                             <?php 
							 if($value->bags_status == "notDespatch"){
								 echo "<button type='submit' class='btn btn-danger'>Pending</button>";
							 }else{
								 echo "<button type='submit' class='btn btn-success'>Despatched</button>";
							 }
							 //echo $value->bags_status;?>
                           </td>
                           <td>
                            <div class='form-check' style="padding-left: 53px;">
                              <?php if ( $value->bags_status == 'notDespatch') {?>
                                <input type='checkbox' name='I[]' class='form-check-input checkSingle1 checkd' id='remember-me' value='<?php echo $value->bag_id ?>'>
                                <label class='form-check-label' for='remember-me'></label>
                              <?php }else{ ?>
                                <input type='checkbox' class='form-check-input' id='remember-me' checked disabled="disabled">
                                <label class='form-check-label' for='remember-me'></label>
                              <?php }?>
                            </div> 
                          </td> 
                        </tr>
                      <?php } ?>

                    </tbody>

                  </table>
                  <input type="hidden" name="type" value="EMS">



                </div>
                <br><br>
				<?php if(empty($emsbags)){ ?>
							
							<?php }else{?>
							<div class="row" style="padding-left: 10px;padding-right: 35px; text-align: left;">
                  <div class="col-md-3">
                    <label>Bag Destination</label>
                    <?php $region = $this->employee_model->regselect();?>
                    <select class="form-control custom-select" name="region" style="height: 40px;" onChange="getRecDistrict();" id="rec_region">
                      <option value="">--Select Destination Region--</option>
                      <?php foreach ($region as $value) {?>
                        <option value="<?php echo $value->region_name; ?>"><?php echo $value->region_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                      <label>Despatch Branch</label>
                                        <select name="district" value="" class="form-control custom-select"  id="rec_dropp1" required="required">  
                                            <option>--Select Branch--</option>
                                        </select>
                                </div>
                  <div class="col-md-3">
                    <label>Transport Type</label>
                    <select name="transport_type" class="form-control custom-select type" onChange="transportType()">
                      <option>Office Truck</option>
                      <option>Public Truck</option>
                      <option>Public Buses</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Transport Name</label>
                    <input type="text" name="transport_name" class="form-control" required="required">
                  </div>
                  <div class="col-md-3">
                    <label>Rigistration Number</label>
                    <input type="text" name="reg_no" class="form-control" required="required">
                  </div>
                  <div class="col-md-3 cost" style="display: none;">
                    <label>Transport Cost</label>
                    <input type="text" name="transport_cost" class="form-control" >
                  </div>
                </div>
							<?php }?>
                
                <br>
                <div class="row" style="padding-left: 10px;padding-right: 35px;">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-info" name="despatch" value="despatch">Despatch Bags</button>
                  </div>
                </div>
              </form>
                      </div>
                      </div>
                      </div>

                      </div>
                            <!-- ============================================================== -->
<script type="text/javascript">
        function getRecDistrict() {
    var val = $('#rec_region').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetBranch",
     data:'region_id='+ val,
     success: function(data){
         $("#rec_dropp1").html(data);
     }
 });
};
</script>
                          </div> 
                          <script type="text/javascript">
                            $(document).ready(function(){
                              $("#show1").click(function(){
                                alert('mussa');
                              });
                            });
                          </script>    
                          <script>
                            function transportType() {
                              var ty = $('.type').val();

                              if (ty == '') {
                                alert('1');
                              }else if(ty == 'Public Truck' || ty == 'Public Buses'){
                                $('.cost').show();
                              }else{
                               $('.cost').hide();
                             }
                           }
                         </script>
                   

<script type="text/javascript">
  $(document).ready(function() {

    var table = $('#example5').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[4,"desc" ]],
        dom: 'B1frtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll").change(function() {
      if (this.checked) {
        $(".checkSingle").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingle").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingle").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingle").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAll").prop("checked", true);
        }     
      }
      else {
        $("#checkAll").prop("checked", false);
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAlls").change(function() {
      if (this.checked) {
        $(".checkSingles").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingles").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingles").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingles").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAlls").prop("checked", true);
        }     
      }
      else {
        $("#checkAlls").prop("checked", false);
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll1").change(function() {
      if (this.checked) {
        $(".checkSingle1").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingle1").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingle1").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingle1").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAll1").prop("checked", true);
        }     
      }
      else {
        $("#checkAll1").prop("checked", false);
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAll4").change(function() {
      if (this.checked) {
        $(".checkSingle4").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingle4").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingle4").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingle4").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAll4").prop("checked", true);
        }     
      }
      else {
        $("#checkAll4").prop("checked", false);
      }
    });
  });
</script>

<script>
  $(document).ready(function() {

    $("#BtnSubmit").on("click", function(event) {

     event.preventDefault();

     var datetime = $('.mydatetimepickerFull').val();
     console.log(datetime);
                // alert(datetime);
                $.ajax({
                 type: "POST",
                 url: "<?php echo base_url();?>Box_Application/Get_Despatch_List_Date",
                 data:'date_time='+ datetime,
                 success: function(response) {
                  $('.fromServer1').show();
                  $('.despatchdiv').hide();
                  $('.fromServer1').html(response);
                }
              });
              });
  });
</script>
<?php $this->load->view('backend/footer'); ?>
