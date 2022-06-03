<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Application</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Leave Application</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regvalue = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    
                    <a href="<?php echo base_url() ?>Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>
                    <?php if ($this->session->userdata('user_type')== 'HR' || $this->session->userdata('user_type')== 'ADMIN') {?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Batch" class="text-white"><i class="" aria-hidden="true"></i>&nbsp;&nbsp;Prepare Leave Batch</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/show_batch" class="text-white"><i class="" aria-hidden="true"></i>&nbsp;&nbsp;Show Leave Batch</a></button>
                    <?php }elseif ($this->session->userdata('user_type')== 'CRM' || $this->session->userdata('user_type')== 'PMG' || $this->session->userdata('user_type')== 'ACCOUNTANT') {?>
                       <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Show_Batch" class="text-white"><i class="" aria-hidden="true"></i>&nbsp;&nbsp;Show Leave Batch</a></button>
                    <?php } ?>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Application List
                        </h4>
                    </div>
                    <div class="card-body">
					 	
                        <div class="form-check" style="padding-right: 40px;  text-align: right;display: none;" id="showCheck">
                                                     <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div>
                        <div class="table-responsive ">
                            <form method="POST" action="">
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                         <th>Employee PF Number</th>
                                        <th>Employee Name</th>
                                        <!-- <th>Employee PF Number</th> -->
                                        <th>Leave Type</th>
                                        <th>Apply Date</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Duration</th>
                                        <th>Leave Status</th>
                                        <th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="8"></th>
                                        
                                                     
                                         <th>
                                            <div class="form-check" style="text-align: right;display: none;" id="showCheck2">
                                             <button type="Submit" class="btn btn-info btn-sm">Send To GMCRM</button>
                                             </div>
                                         </th>
                                    
                                    </tr>
                                </tfoot>
                                <tbody class="leave">
                                    <?php foreach($application as $value): ?>
                                    <tr style="vertical-align:top">
                                        <td><span><?php echo $value->em_code ?></span></td>
                                        <td><span><?php echo $value->first_name.' '.$value->last_name ?></span></td>
                                        <!-- <td><?php echo $value->em_code; ?></td> -->
                                        <td><?php
                                        $typeid = $value->typeid;
                                        $leaveById = $this->leave_model->GetLeaveType($typeid);
                                        echo $leaveById->name;

                                         ?></td>
                                        <td><!-- <?php echo date('jS \of F Y',strtotime($value->apply_date)); ?> -->
                                          <?php echo($value->apply_date); ?>
                                        </td>
                                        <td><?php echo $value->start_date; ?></td>
                                        <td>

                                        <?php 
                                            $currdate = date('Y-m-d');
                                            $enddate  = $value->end_date;
                                            if (  $currdate > $enddate && $value->leave_status == 'Approve') {
                                                  $id = $value->id;
                                                  $emid = $value->em_id;
                                                  $year = date('Y');
                                                  $checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
                                                  if (!empty($checkDay)) {
                                                      $update = array();
                                                      $update = array('leave_status'=>'Complete');
                                                      $this->leave_model->comple_leave($id,$update);
                                                      echo $value->end_date .'string'; 
                                                  }else{

                                                    
                                                    $data1 = array();
                                                    $data1 = array('emp_id'=>$value->em_id,'day'=>28,'dateyear'=>date('Y'));
                                                    $this->leave_model->insert_assign_leave($data1);

                                                    $checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
                                                   
                                                    $diff = $checkDay1->day - $value->leave_duration;

                                                    $update = array();
                                                    $update = array('day'=>$diff);

                                                    $id =  $checkDay1->id;
                                                    $this->leave_model->updateDay($id,$update);
                                                    echo $value->end_date; 
                                                  }
                                                  
                                                 }else if( $currdate > $enddate && $value->leave_status == 'Complete'){

                                                  $id = $value->id;
                                                  $emid = $value->em_id;
                                                  $year = date('Y');
                                                  $checkDay = $this->leave_model->GetemassignLeaveType($emid,$year);
                                                  if (!empty($checkDay)) {
                                                      echo $value->end_date; 
                                                  }else{

                                                    $data1 = array();
                                                    $data1 = array('emp_id'=>$value->em_id,'day'=>28,'dateyear'=>date('Y'));
                                                    $this->leave_model->insert_assign_leave($data1);

                                                    $checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
                                                   
                                                    $diff = @$checkDay1->day - $value->leave_duration;

                                                    $update = array();
                                                    $update = array('day'=>$diff);

                                                    $id =  @$checkDay1->id;
                                                    $this->leave_model->updateDay($id,$update);
                                                    echo $value->end_date; 
                                                  }

                                                 }else{
                                                 echo $value->end_date; 
                                                 }
                                        ?>
                                            
                                        </td>
                                        <td><?php echo $value->leave_duration . ' ' .'Days'; ?></td>
                                        <td>
                                    <?php if($value->leave_status =='Not Approve' && ($value->isHOD == 'Approve' || $value->isRM == 'Approve' || $value->isPMG == 'Approve' || $value->isGMCRM == 'Approve' || $value->isGMBOP == 'Approve')){ ?>
                                                <button class="btn btn-warning btn-sm" style="color: black;" disabled>Waiting For HR Approve</button>
                                    <?php }elseif($value->leave_status =='Approve' && ($value->isHOD == 'Approve' || $value->isRM == 'Approve' || $value->isPMG == 'Approve' || $value->isGMCRM == 'Approve' || $value->isGMBOP == 'Approve')){ ?>
                                                <button class="btn btn-success btn-sm" disabled>Leave is Approved</button>
                                            <?php }elseif($value->leave_status =='Rejected' && ($value->isHOD == 'Rejected' || $value->isRM == 'Rejected' || $value->isPMG == 'Rejected' || $value->isGMCRM == 'Rejected' || $value->isGMBOP == 'Rejected')){ ?>
                                                <button class="btn btn-danger btn-sm" disabled>Leave is Rejected</button>
                                    <?php }elseif($value->leave_status == 'Not Approve'){?>
                                            <?php if ($value->isHOD !='Approve' && $value->isRM !='Approve' && $value->isPMG !='Approve' && $value->isGMCRM !='Approve'  && $value->isGMBOP !='Approve') {?>
                                               <button class="btn btn-warning btn-sm" style="color: black;" disabled>Waiting For HOD/RM/GMCRM/GMBOP/PMG To Approve</button>
                                            <!-- <?php }elseif ($value->isPMG !='Approve' ) {?>
                                                <button class="btn btn-warning btn-sm" style="color: red;" disabled>Waiting For HOD To Approve</button>
                                            <?php }elseif ($value->isPMG !='Approve') {?>
                                                <button class="btn btn-warning btn-sm" style="color: red;" disabled>Waiting For PMG To Approve</button> -->
                                            <?php } ?>
                                            <!-- <button class="btn btn-warning btn-sm" style="color: red;" disabled>Waiting For Approve</button> -->
                                    <?php }elseif($value->leave_status == 'Complete'){?>
                                            <button  class="btn btn-primary btn-sm" disabled>Leave Is Complete</button>
                                            <?php }else{?>
                                            <!-- <?php echo $value->leave_status; ?> -->
                                             <button class="btn btn-success btn-sm" disabled>Leave is Approved</button>
                                        <?php } ?>
                                            
                                        </td>
										<td class="jsgrid-align-center">
                    <?php if($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='SUPERVISOR'){ ?>
                                            <?php if ($value->leave_status == 'Approve') {?>
                                            <img src="<?php echo base_url()?>assets/images/success.png">
                                        <?php
                                            } elseif ($value->leave_status == 'Complete') {?>
                                                <img src="<?php echo base_url()?>assets/images/success.png">
                                            <?php
                                            } elseif ($value->leave_status == 'Rejected') {?>
                                                
                                                <a href="<?php echo base_url()?>Leave/Rejected_Leave?I=<?php echo base64_encode($value->em_id)?>&&E=<?php echo base64_encode($value->id) ?>" title="Rejected" class="btn btn-info btn-sm" data-id="<?php echo $value->id; ?>" data-emid = "<?php echo $value->em_id; ?>">Edit</a>
                                                <input type="hidden" name="" id="leaveId" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="" id="idem" value="<?php echo $value->em_id ?>">
                                            <input type="hidden" name="" id="idday" value="<?php echo $value->leave_duration ?>">
                                                <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                           <?php }elseif($value->leave_status == 'Canceled') {?>
                                                <img src="<?php echo base_url()?>assets/images/close.jpg">
                                        <?php }elseif($value->leave_status == 'Not Approve') {?>

                                            <?php if(($value->isHOD == 'Approve' || $value->isRM == 'Approve' || $value->isPMG == 'Approve' || $value->isGMCRM == 'Approve' || $value->isGMBOP == 'Approve')){ ?>
                                                <input type="hidden" name="" id="leaveId" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="" id="idem" value="<?php echo $value->em_id ?>">
                                            <input type="hidden" name="" id="idday" value="<?php echo $value->leave_duration ?>">
                                                <button type="button" class="btn btn-danger btn-sm myBtn">Cancel</button>
                                            <?php }else{ ?>
                                            <a href="<?php echo base_url()?>Leave/Edit_Leave?I=<?php echo base64_encode($value->em_id)?>&&E=<?php echo base64_encode($value->id)?>" title="" class="btn btn-warning btn-sm">Edit</a> || 
                                            <input type="hidden" name="" id="leaveId" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="" id="idem" value="<?php echo $value->em_id ?>">
                                            <input type="hidden" name="" id="idday" value="<?php echo $value->leave_duration ?>">
                                                <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                            <?php }?>

                                            <?php } else{?>

                                            <?php
                                               }
                                             ?>
                        <?php }elseif ($this->session->userdata('user_type')=='HR' || $this->session->userdata('user_type')=='PMG' || $this->session->userdata('user_type')=='CRM' || $this->session->userdata('user_type')=='BOP' || $this->session->userdata('user_type')=='HOD' || $this->session->userdata('user_type')=='RM' || $this->session->userdata('user_type')=='ADMIN') { ?>


                                    <?php if($value->leave_status == 'Not Approve'){?>

                                        <?php if(($value->isHOD == 'Approve' || $value->isRM == 'Approve' || $value->isPMG == 'Approve' || $value->isGMCRM == 'Approve' || $value->isGMBOP == 'Approve') ){ ?>

                                           <?php if($this->session->userdata('user_type')=='HR'){?>
                                            <form method="post" action="Verify_Leave">
                                                        <a href="Verify_Leave?E=<?php echo base64_encode($value->id) ?>&&I=<?php echo base64_encode($value->em_id) ?>" class="btn btn-sm btn-info">Verify Leave</a>
                                                    </form>
                                        <?php }elseif( $this->session->userdata('user_emid') == $value->em_id){ ?>
                                            <input type="hidden" name="" id="leaveId" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="" id="idem" value="<?php echo $value->em_id ?>">
                                            <input type="hidden" name="" id="idday" value="<?php echo $value->leave_duration ?>">
                                                <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                          <?php }else{ ?>
                                                <a href="Verify_Leave?E=<?php echo base64_encode($value->id) ?>&&I=<?php echo base64_encode($value->em_id) ?>" class="btn btn-sm btn-info">Verify Leave</a>
                                            <?php }?>

                                            <?php }else{ ?>

                                            <?php if( $this->session->userdata('user_emid') == $value->em_id){ ?>
                                                <a href="<?php echo base_url()?>Leave/Edit_Leave?I=<?php echo base64_encode($value->em_id)?>&&E=<?php echo base64_encode($value->id)?>" title="" class="btn btn-warning btn-sm">Edit</a> || 
                                            <input type="hidden" name="" id="leaveId" value="<?php echo $value->id ?>">
                                            <input type="hidden" name="" id="idem" value="<?php echo $value->em_id ?>">
                                            <input type="hidden" name="" id="idday" value="<?php echo $value->leave_duration ?>">
                                                <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                            <?php }else{?>
                                            <form method="post" action="Verify_Leave">
                                                        <a href="Verify_Leave?E=<?php echo base64_encode($value->id) ?>&&I=<?php echo base64_encode($value->em_id) ?>" class="btn btn-sm btn-info">Verify Leave</a>
                                                    </form>
                                            <?php }?>
                                       
                                            <?php } ?>
                                <?php } elseif($value->leave_status == 'Rejected' && $this->session->userdata('user_emid')== $value->em_id){?>

                                    <div class="input-group">
                                        <a href="<?php echo base_url()?>Leave/Rejected_Leave?I=<?php echo base64_encode($value->em_id)?>&&E=<?php echo base64_encode($value->id) ?>" title="Rejected" class="btn btn-warning btn-sm" data-id="<?php echo $value->id; ?>" data-emid = "<?php echo $value->em_id; ?>">Edit</a> || 
                                                <input type="hidden" name="" id="leaveId" value="<?php echo $value->id ?>">
                                                <input type="hidden" name="" id="idem" value="<?php echo $value->em_id ?>">
                                                <input type="hidden" name="" id="idday" value="<?php echo $value->leave_duration ?>">
                                                <button type="button" class="btn btn-danger btn-sm myBtn" >Cancel</button>
                                    </div>
                                <?php } elseif($value->leave_status == 'Approve'){?>
                                <?php if($this->session->userdata('user_type')=='HR'){ ?>

                                    <form method="post" action="Verify_Leave">
                                                        <a href="Verify_Leave?E=<?php echo base64_encode($value->id) ?>&&I=<?php echo base64_encode($value->em_id) ?>" class="btn btn-sm btn-info">Verify Leave</a>
                                                    </form>
                                     <?php }else{?>               
                                    <img src="<?php echo base_url()?>assets/images/success.png">
                                <?php } ?>
                                <?php } elseif($value->leave_status == 'Complete'){?>
                                    <img src="<?php echo base_url()?>assets/images/success.png">
                                <?php } elseif($value->leave_status == 'Rejected'){?>
                                    <img src="<?php echo base_url()?>assets/images/close.jpg">
                                <?php }else{?>

                                <?php } ?>

                                                 
                                <?php}else{?>

                                <?php } ?>
                                </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="padding-top: 300px;">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
          <form role="form" action="Cancel_Leave" method="post">
        <div class="modal-body">
            <h3 style="color: red;">Are you sure you want to cancel this Leave !!!</h3>
        </div>
        <div style="float: right;padding-right: 30px;padding-bottom: 10px;">
            <input type="hidden" name="leaveId" id="idleave">
            <input type="hidden" name="em_id" id="emid">
            <input type="hidden" name="days" id="day">
            <button type="submit" class="btn btn-default btn-default pull-left"><span class="glyphicon glyphicon-remove"></span>Yes</button>
         <button type="button" class="btn btn-default btn-default pull-left" data-dismiss="modal">No</button>
        </div>
        </form>
        </div>
        <div class="modal-footer">
            
        </div>
    
      </div>
    </div>
  </div>
     

             

<script type="text/javascript">
        function getDistrict() {
    var val = $('#regionp').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/GetDistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdropp").html(data);
     }
 });
};
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


<script>
$(document).ready(function(){
  $(".myBtn").click(function(){
    
    var text1 = $('#leaveId').val();
    var text2 = $('#idem').val();
    var text3 = $('#idday').val();
    $('#idleave').val(text1);
    $('#emid').val(text2);
    $('#day').val(text3);
    $("#myModal").modal();
  });
});
</script>
<?php $this->load->view('backend/footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(8)").each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );

    var table = $('#example4').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        order: [[3,"desc" ]],
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
                       dom: 'lBfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

 <script>
            $(document).ready(function() {
                $("#BtnSubmit").on("click", function(event) {

                    event.preventDefault();
                    var leave = $('#emid').val();
                    var datetime = $('#date_from').val();
                    console.log(datetime);
                    $.ajax({
                        url: "Get_LeaveDetailsBatch?date_time=" + datetime + "&leaveType=" + leave,
                        type: "GET",
                        data: 'data',
                        success: function(response) {
                            $('.leave').html(response);
                            $('#showCheck').show();
                             $('#showCheck2').show();
                        }
                    });
                });
            });
        </script>




