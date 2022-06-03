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
                   <div class="row">
        <div class="col-lg-4 col-md-4">
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
                         
                            <a href="<?php echo base_url(); ?>Box_Application/" class="text-muted m-b-0">Total Despatch Out</a>
                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row">
                        <div style="font-size: 25px;padding: 10px;color: black;" class="round align-self-center round-warning">
                            <i class="fa fa-microchip"></i>
                        </div>
                        <div class="m-l-10 align-self-center">
                            <h3 class="m-b-0">                                    
                        <?php
                          //echo $despatchCount;
                        ?>
                        
                         </h3>
                         
                            <a href="<?php echo base_url(); ?>Box_Application/close_bag_items_process" class="text-muted m-b-0">Bulk Bag Processing</a>
                     
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
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
                         
                            <a href="<?php echo base_url(); ?>Box_Application/despatch_bags_list" class="text-muted m-b-0">Total Bags</a>
                     
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
                         <div class="row">
                        <div class="col-md-12">

                          <form method="get" action="<?php echo base_url();?>Box_Application/Get_ems_despatch_bags_list_In_ByDate?>">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <th style="">
                                             <label>Select Date:</label>
                                             <div class="input-group">
                                                <input type="date" name="bagdate" class="form-control date">
                                              
                                                <input type="submit" class="btn btn-success" style="" id="" value="Search Date" required="required"> 

                                            </div>
                                        </th>
                                    </tr>
                                </table>
                          </form>

                </div>
            </div>
            <div class="col-md-12">
                <?php if(!empty($this ->session->flashdata('message'))){ ?>
                  <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  <strong> <?php echo $this ->session->userdata('message'); ?></strong> 
</div>
                <?php }else{?>
                  
                <?php }?>
                
               
              </div>
                
                <form method="POST" action="bags_despatch_process">
                    <div class="table-responsive row col-md-12">

                      <table id="example5" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Bag Number </th>
                            <th>Origion</th>
                            <!-- <th>Bag Branch Origion</th> -->
                            <th>Destination</th>
                            <th>Bag Branch Destination</th>
                            <th>Date Created</th>
                            <th>Weight</th>
                            <th>Status</th>

                            <?php if(empty($emsbags)){ ?>
							
							<?php }else{?>
                            <th>Action</th>
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

                                <a href="
                               <?php echo base_url()?>Box_Application/ems_item_list_bags?trn=<?php echo $value->bag_number; ?>"data-bagno = "<?php echo $value->bag_number; ?>" class="listitem">

                                <?php echo $value->bag_number;?>
                                  
                                </a>

                             </td>
                             <td><?php echo @$value->bag_region_from;?></td>
                             <!-- <td><?php echo @$value->bag_branch_from;?></td> -->
                             <td><?php echo $value->bag_region;?>
                            <td><?php echo $value->bag_branch;?></td>
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
                                <a href="
                               <?php echo base_url()?>Box_Application/ems_item_list_bags_update?trn=<?php echo $value->bag_number; ?>"data-bagno = "<?php echo $value->bag_number; ?>" class="btn btn-success">
                               Update     
                                </a>
                              <?php }else{ ?>
                                 <input type='text' class='form-control' name="despatched01" id='despatched01' placeholder="Despatched" disabled="disabled">
                              <?php }?>
                            </div> 
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
                    <footer>
    <tr>
        <td colspan="9">
          <input type="hidden" class="id" name="emid" id="emid" value="<?php echo $this->session->userdata('user_login_id'); ?>">
        <span style="float: right;"><button type="submit" class="btn btn-info" name="qr" value="qrcode">Print QR Code >>></button>
            </span>
     </td>
</tr>

</footer>
                  </table>
                  <input type="hidden" name="type" value="EMS">

                </div>
                <br><br>
				<?php if(empty($emsbags)){ ?>
							
				<?php }else{?>

                <div class="row" style="padding-left: 10px;padding-right: 35px; text-align: left;">
                    <div class="col-md-3">
                     <label>Action Type</label>
                     <select name="type" class="form-control custom-select actiontype" onChange="Type()">
                      <option value="Despatch">Despatch</option>
                      <option value="combine">Send for combine</option>
                  </select>
              </div>
                </div>

				<div class="row despatched" style="padding-left: 10px;padding-right: 35px; text-align: left;" style="display:none">
                  <div class="col-md-3">
                    <label>Bag Destination</label>
                    <?php $region = $this->employee_model->regselect();?>
                    <select required="required" class="form-control custom-select" name="region" style="height: 40px;" onChange="getRecDistrict();" id="rec_region">
                      <option value="">--Select Destination Region--</option>
                      <?php foreach ($region as $value) {?>
                        <option value="<?php echo $value->region_name; ?>"><?php echo $value->region_name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                 <div class="col-md-3">
                    <label>Despatch Branch</label>
                      <select required="required" name="district" class="form-control custom-select"  id="rec_dropp1" required="required">  
                          <option>--Select Branch--</option>
                      </select>
                </div>
                  <div class="col-md-3">
                    <label>Transport Type</label>
                    <select name="transport_type" class="form-control custom-select type" onChange="transportType()">
                      <option>Office Truck</option>
                      <option>Public Truck</option>
                      <option>Public Buses</option>
                      <option>Sea Transport</option>
                      <option>Railway Transport</option>
                      <option>Air Transport</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Transport Name</label>
                    <input type="text" name="transport_name" class="form-control" >
                  </div>
                  <div class="col-md-3">
                    <label>Rigistration Number</label>
                    <input type="text" name="reg_no" class="form-control">
                  </div>
                  <div class="col-md-3 cost" style="display: none;">
                    <label>Transport Cost</label>
                    <input type="text" name="transport_cost" class="form-control" >
                  </div>
                  <div class="col-md-3 " style="display: block;">
                    <label>Seal</label>
                    <input type="text" name="Seal" class="form-control" >
                  </div>
                  <div class="col-md-3 " style="display: block;">
                    <label>Weight</label>
                    <input required="required" type="text" name="weight" class="form-control" >
                  </div>
                 
                </div>
				 <br>
                <div class="row" style="padding-left: 10px;padding-right: 35px;">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-info" name="despatch" value="despatch">Submit</button>
                  </div>
                </div>
							<?php }?>
             
               
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

                            function Type() {
                              var ty = $('.actiontype').val();

                              if (ty == '') {
                                alert('1');
                              }else if(ty == 'Despatch'){
                                $('.despatched').show();
                              }else{
                               $('.despatched').hide();
                             }
                           }
                        
                          $(document).ready(function(){

                            $(".ems1").click(function(){
                              $(".ems").show();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $(".ems12").click(function(){
                              $(".ems2").show();
                              $(".ems").hide();
                              $(".mails").hide();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $(".item").click(function(){
                              $(".ems").show();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $("#mails").click(function(){
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").show();
                              $(".emsbags").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });
                            $(".emsbags1").click(function(){
                              $(".emsbags").show();
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".itemlist").hide();
                              $(".despatch1").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });

                            $(".despatch").click(function(){
                              $(".despatch1").show();
                              $(".emsbags").hide();
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".itemlist").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                              $(".despatchIn1").hide();
                            });

                            $(".despatchIn").click(function(){
                              $(".despatch1").hide();
                              $(".despatchIn1").show();
                              $(".emsbags").hide();
                              $(".ems").hide();
                              $(".ems2").hide();
                              $(".mails").hide();
                              $(".itemlist").hide();
                              $(".bags_item_list").hide();
                              $(".bagsList").hide();
                            });

                            $(".listitem").click(function(){

                              var type = 'EMS';
                              var bagno = $(this).attr('data-bagno');
                              var reg   = $('.reg').val();
                              $.ajax({

                               url: "<?php echo base_url();?>Box_Application/bags_item_list",
                               method:"POST",
     data:{bagno:bagno,type:type},//'region_id='+ val,
     success: function(data){

      $('.listresults').html(data);

          //$(".itemlist").show();
          $(".bags_item_list").show();
          $(".emsbags").hide();
          $(".ems").hide();
          $(".ems2").hide();
          $(".mails").hide();
          $(".despatch1").hide();
          $(".bagsList").hide();
          $(".despatchIn1").hide();

          //$('#fromServer').dataTable().clear();
          $('#fromServer').DataTable( {
            orderCellsTop: true,
            destroy:true,
            order: [[5,"desc" ]],
            fixedHeader: true,
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );


        }
      });

                            });
                            $(".bagsList12").click(function(){

                              var type = 'EMS';
                              var despno = $(this).attr('data-despno');

                              $.ajax({

                               url: "<?php echo base_url();?>Box_Application/bags_list_despatch",
                               method:"POST",
     data:{despno:despno,type:type},//'region_id='+ val,
     success: function(data){

      $('.bagresults').html(data);

          //$(".itemlist").show();
          $(".bags_item_list").hide();
          $(".bagsList").show();
          $(".emsbags").hide();
          $(".ems").hide();
          $(".ems2").hide();
          $(".mails").hide();
          $(".despatch1").hide();
          $(".despatchIn1").hide();
          
        }
      });

                            });

                          });
                        </script>
<script type="text/javascript">
$(document).ready(function() {
  
    var table = $('#example47').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[5,"desc" ]],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
   
    var table = $('#example42').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[5,"desc" ]],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
  

    var table = $('#example5').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        ordering:false,
        order: [[5,"desc" ]],
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        dom: 'lBfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#despatch').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[5,"desc" ]],
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#despatchIn').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[5,"desc" ]],
        dom: 'Bfrtip',
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

    $(".BtnSubmit").on("click", function(event) {
     event.preventDefault();
     var datetime = $('.mydatetimepickerFull').val();
     
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
