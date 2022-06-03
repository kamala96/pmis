<!-- https://github.com/eboominathan/Basic-Crud-in-Full-Calendar-Using-Codeigniter-3.0.3/tree/master/fullcalendar
https://www.patchesoft.com/fullcalendar-with-php-and-codeigniter/
 -->
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>

<style>
    .fc-fri {
        background-color: #FFEB3B;
    }
    .fc-event, .fc-event-dot {
        background-color: #FF5722;
    }
    .fc-event {
        border: 0;
    }
    .fc-day-grid-event {
        margin: 0;
        padding: 0;
    }
    .dayWithEvent {
        background: #FFEB3B;
        cursor: pointer;
    }
</style>
         <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-bullhorn" style="color:#1976d2"></i>&nbsp;Leave Application</h3>
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
                    <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                        
                        <?php } else { ?>
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#holysmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Holiyday </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Application" class="text-white"><i class="" aria-hidden="true"></i>  Leave Application</a></button>
                        <?php } ?>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                 <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                        <h4 class="m-b-0 text-white">Leave Application Form</h4>
                                        <?php } else { ?>
                                            <h4 class="m-b-0 text-white">Employee Leave Application Details</h4>
                                        <?php }?>
                                
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                    <form method="post" action="Add_Applications" id="leaveapply" enctype="multipart/form-data">
                        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                        <h4 class="m-b-0 text-white">Leave Application Form</h4>
                                        <?php } else { ?>
                                             <input type="hidden" name="idem" value="<?php echo $application->id ?>">
                                        <?php }?>
                        <div class="modal-body">
                           
                            <input type="hidden" name="emid" value="<?php echo $employee->em_id ?>">
                             <input type="hidden" name="emgender" value="<?php echo $employee->em_gender ?>">
                        <div class="row">
                        <div class="col-md-6">
                                <div class="form-group">
                                <label>Leave Type</label>
                                <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                    <select class="form-control custom-select assignleave"  tabindex="1" name="typeid" id="leavetype" required>
                                    <option value="">Select Here..</option>
                                    <?php foreach($leavetypes as $value): ?>

                                    <option value="<?php echo $value->type_id ?>"><?php echo $value->name ?></option>

                                    <?php endforeach; ?>
                                </select>
                                <?php } else { ?>
                                    <select class="form-control custom-select assignleave"  tabindex="1" name="typeid" id="leavetype" readonly>
                                    <option value="<?php echo $application->typeid ?>"><?php echo $application->leave_type ?></option>
                                </select>
                                <?php }?>
                                
                                <span style="color: red;"><?php echo $this->session->flashdata('error_message'); ?></span>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group" style="padding-top: 35px;">
                                <span style="color: red;" id="total"></span>
                            </div>
                            
                         </div>
                        </div>
                        <div class="row">
                            <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label" id="hourlyFix">Start Date</label>
                                <input type="date" name="startdate" class="form-control" id="recipient-name1" required>
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="enddate" style="">
                                <label class="control-label">End Date</label>
                                <input type="date" name="enddate" class="form-control" id="" required>
                            </div>
                                </div>
                            <?php } else {?>
                                <div class="col-md-6">
                                <div class="form-group">
                                <label class="control-label" id="hourlyFix">Start Date</label>
                                <input type="text" name="startdate" class="form-control" id="recipient-name1" value="<?php echo $application->start_date ?>" required readonly>
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="enddate" style="">
                                <label class="control-label">End Date</label>
                                <input type="text" name="enddate" class="form-control" id="" value="<?php echo $application->end_date ?>" required readonly>
                            </div>
                                </div>

                            <?php }?>
                        
                        </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label class="control-label" id="hourlyFix">From</label>
                                <input type="text" name="from" class="form-control" id="" value="<?php echo $employee->em_region ?>">
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label class="control-label" id="hourlyFix">To (Select Region)</label>
                                 <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                    <select name="to" value="" class="form-control custom-select" required id="region" onChange="getDistrict();" required>
                                            <?Php foreach($regvalue as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php } else { ?>
                                        <select name="to" value="" class="form-control custom-select" required id="region" onChange="getDistrict();" required  readonly>
                                             <option value="<?php echo $application->to ?>"><?php echo $application->to ?></option>
                                        </select>
                                    <?php }?>
                                
                                </div>
                            </div>
                        </div>
                            
                            <div class="row">
                                 <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                      <div class="col-md-6">
                                    <div class="form-group">
                                <label class="control-label" id="hourlyFix">District To</label>
                                <select name="district" value="" class="form-control custom-select"  id="branchdrop">  
                                            <option>Select District</option>
                                        </select>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label class="control-label" id="hourlyFix">Village To</label>
                                <input type="text" name="village" class="form-control" required="required">
                                </div>
                                </div>
                                        <?php } else { ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label class="control-label" id="hourlyFix">District To</label>
                                <input type="text" name="district" class="form-control" value="<?php echo $application->district;?>" readonly>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                <label class="control-label" id="hourlyFix">Village To</label>
                                <input type="text" name="village" class="form-control" value="<?php echo $application->village;?>"  readonly>
                                </div>
                                </div>
                                <?php }?>
                            </div>
                                        
                                
                            <div class="form-group">
                                <label class="control-label">Comments</label>
                                <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                       <textarea class="form-control" name="reason" id="message-text1" required minlength="10"></textarea>   
                                        <?php } else { ?>
                                            <textarea class="form-control" name="reason" id="message-text1" required minlength="10" value="" readonly=""><?php echo $application->reason;?></textarea>   
                                        <?php }?>

                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                     <label>Employee Dependents</label>
                                     <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                 <th>Gender</th>
                                               <th>Title</th>
                                                <th>Age</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($family as $value): ?>

                                            <tr>
                                                <td><?php echo $value->first_name; ?></td>
                                                <td><?php echo $value->middle_name; ?></td>
                                                <td><?php echo $value->last_name; ?></td>
                                                <td><?php echo $value->gender; ?></td>
                                                <td><?php echo $value->title; ?></td>

                                                <?php
                                                        $dateProvided=$value->dateofbirth;
                                                        $yearOnly=date('Y', strtotime($dateProvided));
                                                        $age = date('Y') - $yearOnly;
                                                        //echo $age;
                                                        if ($age < 20 && $value->title == 'Child') {

                                                       
                                                    ?>
                                                    <td><?php echo $age; ?></td>
                                                    <td><img src="<?php echo base_url(); ?>assets/images/success.png?>"></td>
                                                    <?php }elseif ($value->title == 'Parents') {
                                                    ?>  
                                                  <td><?php echo $age; ?></td>
                                                    <td><img src="<?php echo base_url(); ?>assets/images/success.png?>"></td>

                                                <?php                                                        } else {?>
                                                    <td><?php echo $age; ?></td>
                                                    <td><img src="<?php echo base_url(); ?>assets/images/close.jpg?>"></td>
                                                            <?php
                                                        }
                                                ?>
                                            </tr>
                                             <?php endforeach; ?>
                                </tbody>
                            </table>              
                                    
                                </div>
                                <div class="col-md-12">
                                    <label>Fare Amount</label>
                                    <?php if ($application->leave_status == 'Approve') {?>
                                    <input type="number" name="fare_amount" value="<?php echo $application->fare_amount ?>" class="form-control"  readonly>
                                    <?php }else{ ?>
                                        <input type="number" name="fare_amount" value="" class="form-control" id="amount">
                                      <?php }?>  
                                    
                                </div>
                            </div>
                            
                        </div>
                        <script>
                        $(document).ready(function () {
                            $('#leaveapply input').on('change', function(e) {
                                e.preventDefault(e);

                                // Get the record's ID via attribute  
                                var duration = $('input[name=type]:checked', '#leaveapply').attr('data-value');

                                if(duration =='Half'){
                                    $('#enddate').hide();
                                    $('#hourlyFix').text('Date');
                                    $('#hourAmount').show();
                                }
                                else if(duration =='Full'){
                                    $('#enddate').hide();  
                                    $('#hourAmount').hide();  
                                    $('#hourlyFix').text('Start date');  
                                }
                                else if(duration =='More'){
                                    $('#enddate').show();
                                    $('#hourAmount').hide();
                                }
                            });
                        }); 
                        </script>
                        <div class="modal-footer">
                            <?php if ($application->leave_status == 'Approve') {?>
                                   
                                    <?php }else{ ?>
                    <a href="" title="Approve" class="btn btn-sm btn-info waves-effect waves-light Status" data-employeeId=<?php echo $application->em_id; ?>  data-id="<?php echo $application->id; ?>" data-value="Approve" data-duration="<?php echo $application->leave_duration; ?>" data-type="<?php echo $application->typeid; ?>">Approve</a>

                   <a href="" title="Reject" class="btn btn-sm btn-info waves-effect waves-light  Status" data-id = "<?php echo $application->id; ?>" data-value="Rejected" >Reject</a>
                                      <?php }?>  
                            <input type="hidden" name="id" class="form-control" id="recipient-name1" required>
                           
                        </div>
                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


 <script type="text/javascript">
        function getDistrict() {
    var val = $('#region').val();
     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Employee/selectdistrict",
     data:'region_id='+ val,
     success: function(data){
         $("#branchdrop").html(data);
     }
 });
};
</script>               
<script>
    $(document).ready(function () {

        $('.assignleave').on('change', function (e) {
            e.preventDefault();
            var selectedEmployeeID = $('.selectedEmployeeID').val();
            var leaveTypeID = $('.assignleave').val();
            console.log(selectedEmployeeID, leaveTypeID);
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
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".holiday").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#holidayform').trigger("reset");
                                                $('#holysmodel').modal('show');
                                                $.ajax({
                                                    url: 'Holidaybyib?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).done(function (response) {
                                                    console.log(response);
                                                    // Populate the form fields with the data returned from server
                                                    $('#holidayform').find('[name="id"]').val(response.holidayvalue.id).end();
                                                    $('#holidayform').find('[name="holiname"]').val(response.holidayvalue.holiday_name).end();
                                                    $('#holidayform').find('[name="startdate"]').val(response.holidayvalue.from_date).end();
                                                    $('#holidayform').find('[name="enddate"]').val(response.holidayvalue.to_date).end();
                                                    $('#holidayform').find('[name="nofdate"]').val(response.holidayvalue.number_of_days).end();
                                                    $('#holidayform').find('[name="year"]').val(response.holidayvalue.year).end();
                                                });
                                            });
                                        });
</script>
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".holidelet").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $.ajax({
                                                    url: 'HOLIvalueDelet?id=' + iid,
                                                    method: 'GET',
                                                    data: 'data',
                                                }).done(function (response) {
                                                    console.log(response);
                                                    $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                                                    window.setTimeout(function(){location.reload()},2000)
                                                    // Populate the form fields with the data returned from server
                                                });
                                            });
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
              'type': $(this).attr('data-type'),
              'fare_amount' : $('#amount').val()
          },
          success: function(response) {
            // console.log(response);
            $(".message").fadeIn('fast').delay(30000).fadeOut('fast').html(response);
            window.setTimeout(function(){location.reload()}, 30000);
          },
          error: function(response) {
            //console.error();
          }
      });
  });           
</script>

<?php $this->load->view('backend/footer'); ?>