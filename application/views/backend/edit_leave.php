<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Leave Edit</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Leave Application Edit</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regvalue = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
                    <a href="<?php echo base_url() ?>Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Leave Rejection Form                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?php echo base_url() ?>Leave/Edit_Application">
							<div class="row">
								<div class="col-md-6">
									<label>Employee Name</label>
									<select class="form-control custom-select" name="em_id" readonly>

										<option value="<?php echo $employee->em_id ?>"><?php echo $employee->first_name . '  '.$employee->middle_name.'  '.$employee->last_name ?></option>

									</select>
								</div>
								<div class="col-md-6">
									<label>Select Leave Type</label>
									<select class="form-control custom-select" name="leave_type">
										<option value="<?php echo $employee->type_id;?>"><?php echo $employee->name;?></option>
										<?php foreach ($leavetypes as $value) {?>
											<option value="<?php echo $value->type_id?>"><?php echo $value->name;?></option>
											<?php
										} ?>
									</select>
								</div>
							</div>
							<div class="row m-t-20">
								<div class="col-md-6">
									<label>Leave Start Date</label>
									<input type="text" name="startdate" class="form-control mydatetimepickerFull" id="recipient-name1" value="<?php echo $employee->start_date;?>">
								</div>
								<div class="col-md-6">
									<label>Leave Days(&nbsp;<span style="color: red;">Remaining Days is
                                        <?php
                                        $year = date('Y');
                                        $emid = $employee->em_id;
                                        $checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
                                        if (empty($checkDay1)) {
                                            echo 28;
                                        }else{
                                            echo $checkDay1->day;
                                        }
                                        
                                         ?>
                                    </span>&nbsp;)</label>
									<input type="text" name="enddate" class="form-control" id="day1" value="<?php echo $employee->leave_duration;?>" required="required" onkeypress="myFunction()">
                                    <input type="hidden" name="day" class="form-control"  value="<?php echo $employee->leave_duration;?>">
                                    <span class="day0error" style="color: red;display: none;"> There is no zero(0) or empty leave</span>
								</div>
							</div>
							<div class="row m-t-20">
								<div class="col-md-6">
									<label class="control-label">Region From</label>
									<input type="text" name="region_to" class="form-control" value="<?php echo $employee->em_region;?>" readonly>
								</div>
								<div class="col-md-6">
									<label class="control-label">Region To</label>
									<select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();" required="required">
										<option value="<?php echo $employee->region_to;?>"><?php echo $employee->region_to;?></option>
										<?Php foreach($regionlist as $value): ?>
											<option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="row m-t-20">
								<div class="col-md-6">
									<label>District To</label>
									<select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">
										<option value="<?php echo $employee->district_to;?>"><?php echo $employee->district_to;?></option>
									</select>
								</div>
								<div class="col-md-6">
									<label>Village To</label>
									<input type="text" name="village_to" class="form-control" value="<?php echo $employee->village_to;?>">
								</div>

							</div>
                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <label class="control-label">Reason</label>
                                    <textarea class="form-control" name="rejected_reason" id="message-text1"><?php echo $employee->reason?></textarea>
                                </div>
                            </div>
                                <?php if ($employee->name == 'Annual Leave'){ ?>
                            <div class="row m-t-20">
                                <div class="col-md-12">
                                    <label>Family Dependents</label>
                                    <br>
                                    <text><img src="<?php echo base_url(); ?>assets/images/close.jpg">
                                        - Not Supposed to pay &nbsp;&nbsp; <img src="<?php echo base_url(); ?>assets/images/success.png"> - Supposed to pay
                                    </text>
                                    <br>
                                    <table id="employeesFamily" class="display nowrap table table-bordered " cellspacing="0" width="100%">
                                        <thead>
                                        <tr style="background-color: antiquewhite;">
                                            <th>Full Name</th>
                                            <th>Date Of Birth</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th>Title</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($family)){ ?>
                                        <?php foreach($family as $value): ?>
                                        <tr>
                                            <td><?php echo $value->first_name . '  ' . $value->middle_name . ' ' . $value->last_name; ?></td>
                                            <td><?php echo $value->dateofbirth; ?></td>
                                            <td><?php echo $value->gender; ?></td>
                                            <td><?php
                                                        $dateProvided=$value->dateofbirth;
                                                        $yearOnly=date('Y', strtotime($dateProvided));
                                                        $monthOnly=date('m', strtotime($dateProvided));
                                                        $age = date('Y') - $yearOnly;
                                                        if ($value->title == 'Child' && $age == 0)
                                                        {
                                                            echo $age = date('m') - $monthOnly.' '.'Months'.'   '.'<img src="' .base_url().'assets/images/success.png'.'">';
                                                        }elseif ($value->title == 'Child' && $age > 18){
                                                                echo $age.'  '.'Years'.'   '.'<img src="'.base_url().'assets/images/close.jpg'.'">';
                                                            }else{
                                                                echo $age.'  '.'Years'.'   '.'<img src="' .base_url().'assets/images/success.png'.'">';
                                                            }
                                                        ?></td>
                                                    <td><?php echo $value->title; ?></td>

                                                </tr>
                                            <?php endforeach; ?>
                                        <?php }else{?>
                                            <tr>
                                                <td colspan="5" style="text-align: center;"><text style="color: red;">No Family</text></td>
                                            </tr>
                                        <?php }?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                                <div class="row m-t-20" style="" id="">
                                <div class="col-md-6">
                                    <label>Total Fare From Region To Region</label>
                                        <input type="number" name="amount" class="form-control" value="<?php echo $employee->fare_amount;?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Total Fare From District To Village</label>
                                    <input type="number" name="amount2" class="form-control"  value="<?php echo $employee->faredistrictvillage;?>">
                                </div>
                            </div>
                          <?php }?>
                             
                            <div class="row m-t-20 btnhide">
                                <div class="col-md-12">
                                    <input type="hidden" name="em_gender" value="<?php echo $employee->em_gender; ?>">
                                    <input type="hidden" name="leave_id" value="<?php echo $employee->id; ?>">
                                    <button type="submit" class="btn btn-primary">Save Leave Information</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="appmodel1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">Leave Application</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="post" action="Add_Applications" id="leaveapply" enctype="multipart/form-data">
                            <div class="modal-body">
                                    
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select class=" form-control custom-select selectedEmployeeID"  tabindex="1" name="emid" required>
                                        <?php foreach($employee as $value): ?>
                                        <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.' '.$value->last_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Leave Type</label>
                                    <select class="form-control custom-select assignleave fetchLeaveTotal"  tabindex="1" name="typeid" id="leavetype" required>
                                        <option value="">Select Here..</option>
                                        <?php foreach($leavetypes as $value): ?>

                                        <option value="<?php echo $value->type_id ?>"><?php echo $value->name ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                    <span style="color:red" id="total"></span>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="leave_type" class="form-control">
                                </div> 
                                <div class="form-group">
                                    <label class="control-label" id="hourlyFix">Start Date</label>
                                    <input type="text" name="startdate" class="form-control mydatetimepickerFull" id="recipient-name1" required>
                                </div>
                                <div class="form-group" id="enddate" style="">
                                    <label class="control-label">End Date</label>
                                    <input type="text" name="enddate" class="form-control mydatetimepickerFull" id="recipient-name1">
                                </div>
                                <div class="form-group" id="enddate" style="">
                                    <label class="control-label">Region To</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="region" onChange="getDistrict();">
                                            <option>Select Region</option>
                                            <?Php foreach($regvalue as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                        <label>Didtrict To</label>
                                       
                                        <input type="text" name="district_to" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Village To</label>
                                        <input type="text" name="village_to" class="form-control" required="" id="village_to">
                                    </div>

                                <div class="form-group">
                                    <label class="control-label">Reason</label>
                                    <textarea class="form-control" name="reason" id="message-text1"></textarea>                                                
                                </div>
                                                                       
                            </div>
                            <script>
                                $(document).ready(function () {
                                    $('#leaveapply input').on('change', function(e) {
                                        e.preventDefault(e);

                                        // Get the record's ID via attribute  
                                        var duration = $('input[name=type]:checked', '#leaveapply').attr('data-value');
                                        console.log(duration);

                                        if(duration =='Half'){
                                            $('#enddate').hide();
                                            $('#hourlyFix').text('Date');
                                            $('#hourAmount').show();
                                        }
                                        else if(duration =='Full'){
                                            $('#enddate').hide();  
                                            $('#hourAmount').hide();  
                                            $('#hourlyFix').text('Date');  
                                        }
                                        else if(duration =='More'){
                                            $('#enddate').show();
                                            $('#hourAmount').hide();
                                        }
                                    });
                                    $('#appmodel').on('hidden.bs.modal', function () {
                                        location.reload();
                                    });
                                });                                                          
                            </script>
                            <div class="modal-footer">
                                <input type="hidden" name="id" class="form-control" id="recipient-name1" required> 
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="appmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">Leave Application</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <?php echo validation_errors(); ?>
                               <?php echo $this->upload->display_errors(); ?>
                               
                               <?php echo $this->session->flashdata('formdata'); ?>
                               <?php echo $this->session->flashdata('feedback'); ?>

                            <form method="post" action="Add_Applications" id="leaveapply" enctype="multipart/form-data">
                            <div class="modal-body">
                                    
                                <div class="form-group">
                                    <label>Employee</label>
                                    <select class=" form-control custom-select selectedEmployeeID"  tabindex="1" name="emid" required>
                                        <?php foreach($employee1 as $value): ?>
                                        <option value="<?php echo $value->em_id ?>"><?php echo $value->first_name.' '.$value->last_name?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Leave Type</label>
                                    <select class="form-control custom-select assignleave fetchLeaveTotal"  tabindex="1" name="typeid" id="leavetype" required>
                                        <option value="">Select Here..</option>
                                        <?php foreach($leavetypes as $value): ?>

                                        <option value="<?php echo $value->type_id ?>"><?php echo $value->name ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                    <span style="color:red" id="total"></span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" id="hourlyFix">Start Date</label>
                                    <input type="text" name="startdate" class="form-control mydatetimepickerFull" id="recipient-name1" required>
                                </div>
                                <div class="form-group" id="enddate" style="">
                                    <label class="control-label">End Date</label>
                                    <input type="text" name="enddate" class="form-control mydatetimepickerFull" id="recipient-name1">
                                </div>
                                <div class="form-group" id="enddate" style="">
                                    <label class="control-label">Region To</label>
                                     <select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();">
                                            <option>Select Region</option>
                                            <?Php foreach($regvalue as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                        <label>Didtrict To</label>
                                        <select name="district_to" value="" class="form-control custom-select"  id="branchdropp">  
                                            <option>Select District</option>
                                        </select>
                                          
                                    </div>
                                    <div class="form-group">
                                        <label>Village To</label>
                                        <input type="text" name="village_to" class="form-control" required="" id="village_to">
                                    </div>
                                <div class="form-group">
                                    <label class="control-label">Reason</label>
                                    <textarea class="form-control" name="reason" id="message-text1"></textarea>                                                
                                </div>
                                                                               
                            </div>
                            <script>
                                $(document).ready(function () {
                                    $('#leaveapply input').on('change', function(e) {
                                        e.preventDefault(e);

                                        // Get the record's ID via attribute  
                                        var duration = $('input[name=type]:checked', '#leaveapply').attr('data-value');
                                        console.log(duration);

                                        if(duration =='Half'){
                                            $('#enddate').hide();
                                            $('#hourlyFix').text('Date');
                                            $('#hourAmount').show();
                                        }
                                        else if(duration =='Full'){
                                            $('#enddate').hide();  
                                            $('#hourAmount').hide();  
                                            $('#hourlyFix').text('Date');  
                                        }
                                        else if(duration =='More'){
                                            $('#enddate').show();
                                            $('#hourAmount').hide();
                                        }
                                    });
                                    $('#appmodel').on('hidden.bs.modal', function () {
                                        location.reload();
                                    });
                                });                                                          
                            </script>
                            <div class="modal-footer ">
                                <input type="hidden" name="id" class="form-control" id="recipient-name1" required> 
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

<script type="text/javascript">
    $(document).ready(function() {
    $('#day1').on('keyup', function() {
  var textinsert = ($(this).val());
if (textinsert <= 0) {
    $('.day0error').show();
     $('.btnhide').hide();
}else{
    var regex=/^[0-9]+$/;
    if (textinsert.match(regex))
    {
        // alert("Must input numbers");
        $('.btnhide').show();
        $('.day0error').hide();
        return false;
    }
 
}
   
});

});
</script>
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

<script>
    $(document).ready(function () {

        $('.fetchLeaveTotal').on('click', function (e) {
            e.preventDefault();
            var selectedEmployeeID = $('.selectedEmployeeID').val();
            var leaveTypeID = $('.assignleave').val();
            //console.log(selectedEmployeeID, leaveTypeID);
            $.ajax({
                url: 'LeaveAssign?leaveID=' + leaveTypeID + '&employeeID=' +selectedEmployeeID,
                method: 'GET',
                data: '',
            }).done(function (response) {
                //console.log(response);
                $("#total").html(response);
            });
        });
    });
</script>
        <script>
        /*DATETIME PICKER*/
          $("#bbbSubmit").on("click", function(event){
              event.preventDefault();
              var typeid = $('.typeid').val();
              var datetime = $('.mydatetimepicker').val();
              var emid = $('.emid').val();
              //console.log(datetime);
              $.ajax({
                  url: "GetemployeeGmLeave?year="+datetime+"&typeid="+typeid+"&emid="+emid,
                  type:"GET",
                  dataType:'',
                  data:'data',          
                  success: function(response) {
                      // console.log(response);
                      $('.leaveval').html(response);             
                  },
                  error: function(response) {
                    // console.log(response);
                  }
              });
          });			
        </script>  


        <script type="text/javascript">
        /*PARSE DURATION DATA*/
        $('.duration').on('input',function() {
            var day = parseInt($('.duration').val());
            var hour = 8;
            $('.totalhour').val((day * hour ? day * hour : 0).toFixed(2));
        });
        </script>
<script>
  $(".Status").on("click", function(event){
      event.preventDefault();
      // console.log($(this).attr('data-value'));
      $.ajax({
          url: "approveLeaveStatus",
          type:"POST",
          data:
          {
              'employeeId': $(this).attr('data-employeeId'),
              'lid': $(this).attr('data-id'),
              'lvalue': $(this).attr('data-value'),
              'duration': $(this).attr('data-duration'),
              'type': $(this).attr('data-type')
          },
          success: function(response) {
            // console.log(response);
            $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
            window.setTimeout(function(){location.reload()}, 3000);
          },
          error: function(response) {
            //console.error();
          }
      });
  });           
</script>

<script type="text/javascript">
            $(document).ready(function() {
                $(".leaveapp1").click(function(e) {
                    e.preventDefault(e);
                    // Get the record's ID via attribute
                    var iid = $(this).attr('data-id');
                    $('#leaveapply').trigger("reset");
                    $('#appmodel1').modal('show');

                    $.ajax({
                        url: 'LeaveAppbyid?id=' + iid ,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function(response) {
                        // console.log(response);
                        // Populate the form fields with the data returned from server
                        $('#leaveapply').find('[name="id"]').val(response.leaveapplyvalue.id).end();
                        $('#leaveapply').find('[name="emid"]').val(response.leaveapplyvalue.em_id).end();
                        $('#leaveapply').find('[name="applydate"]').val(response.leaveapplyvalue.apply_date).end();
                        $('#leaveapply').find('[name="typeid"]').val(response.leaveapplyvalue.typeid).end();
                        $('#leaveapply').find('[name="startdate"]').val(response.leaveapplyvalue.start_date).end();
                        $('#leaveapply').find('[name="enddate"]').val(response.leaveapplyvalue.end_date).end();
                        $('#leaveapply').find('[name="region_from"]').val(response.leaveapplyvalue.region_from).end();
                        $('#leaveapply').find('[name="region_to"]').val(response.leaveapplyvalue.region_to).end();
                        $('#leaveapply').find('[name="district_to"]').val(response.leaveapplyvalue.district_to).end();
                        $('#leaveapply').find('[name="village_to"]').val(response.leaveapplyvalue.village_to).end();
                        $('#leaveapply').find('[name="reason"]').val(response.leaveapplyvalue.reason).end();
                        $('#leaveapply').find('[name="status"]').val(response.leaveapplyvalue.leave_status).end();
                        $('#leaveapply').find('[name="leave_type"]').val(response.leaveapplyvalue.leave_type).end();

                        if(response.leaveapplyvalue.leave_type == 'Half day') {
                            $('#appmodel').find(':radio[name=type][value="Half Day"]').prop('checked', true).end();
                            $('#hourAmount').show().end();
                            $('#enddate').hide().end();
                        } else if(response.leaveapplyvalue.leave_type == 'Full Day') {
                            $('#appmodel').find(':radio[name=type][value="Full Day"]').prop('checked', true).end();
                            $('#hourAmount').hide().end();
                        } else if(response.leaveapplyvalue.leave_type == 'More than One day'){
                            $('#appmodel').find(':radio[name=type][value="More than One day"]').prop('checked', true).end();
                            $('#hourAmount').hide().end();
                            $('#enddate').show().end();
                        }

                        $('#hourAmountVal').val(response.leaveapplyvalue.leave_duration).show().end();
                    });
                });
            });
        </script>                     
<?php $this->load->view('backend/footer'); ?>

<script>
    $('#employees123').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>
