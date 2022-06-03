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
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
                    <a href="<?php echo base_url() ?>Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>
                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button>
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Leave Application Form                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="Leave_Application">
                            <div class="row">
                                        <div class="col-md-6">
                                            <label>Employee Name</label>
                                           <input type="text" name="em_id" readonly="readonly" class="form-control" value="<?php echo $employee->first_name.'  '.$employee->middle_name. '  '.$employee->last_name;?>">
                                                <input type="hidden" name="em_id" value="<?php echo $employee->em_id;?>" id="em_id">
                                           
                                        </div>
                                        <div class="col-md-6">
                                            <label>Select Leave Type</label>
                                            <select class="form-control custom-select" name="leave_type" onChange="getLeave();" id="leaveid" required="required">
                                                 <option value="">--Select Leave Type--</option>
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
                                   <input type="text" name="startdate" class="form-control mydatetimepickerFull" id="recipient-name1" required="required">
                                </div>
                                <div class="col-md-6">
                                    <label>Leave Days (&nbsp;<span style="color: red;">Annual Remaining Days is
                                        <?php
                                        
                                        $month = date('m');
                                        if ($month >= 07) {
                                            $year = date('Y')+1;
                                        } else {
                                            $year = date('Y');
                                        }
                                        
                                        $emid = $employee->em_id;
                                        $checkDay1 = $this->leave_model->GetemassignLeaveType($emid,$year);
                                        if (empty($checkDay1)) {
                                            echo 28;
                                        }else{
                                            echo $checkDay1->day;
                                        }
                                        
                                         ?>
                                    </span>&nbsp;)</label>
                                    <select name="days" class="custom-select form-control days2" id="days2">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                        <option>21</option>
                                        <option>22</option>
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                    </select>
                                    <!-- <input type="text" name="days" class="form-control" id="day1" required="required" value="" onkeypress="myFunction()">
                                    <span class="day0error" style="color: red;display: none;"> There is no zero(0) or empty leave</span> -->
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="control-label">Region To</label>
                                    <select name="region_to" value="" class="form-control custom-select" required id="regionp" onChange="getDistrict();" required="required">
                                            <option value="">--Select Region--</option>
                                            <?Php foreach($regionlist as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                                <div class="col-md-6">
                                    <label>District To</label>
                                        <select name="district_to" value="" class="form-control custom-select"  id="branchdropp" required="required">  
                                            <option>--Select District--</option>
                                        </select>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label>Village To</label>
                                        <input type="text" name="village_to" class="form-control" required="" id="village_to">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Reason</label>
                                    <textarea class="form-control" name="reason" id="message-text1"></textarea> 
                                </div>
                            </div>
                            <div class="row m-t-20" style="display: none;" id="leaveFare">
                                <div class="col-md-6">
                                    <label>Total Fare From Region To Region</label>
                                        <input type="number" name="amount" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Total Fare From District To Village</label>
                                    <input type="number" name="amount2" class="form-control">
                                </div>
                            </div>
                            <div class="row m-t-20 btnhide" style="" >
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Save Leave Information</button> | <button type="reset" class="btn btn-primary">Reset Leave Information</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


<!-- <script>
function myFunction() {
  var number = $('#day1').val();
  alert(number);
}
</script> -->
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
<script type="text/javascript">
        function getLeave() {
    var val = $('#leaveid').val();
    var em_id = $('#em_id').val();
     if ( val == 10) {
        $('#leaveFare').show();
    // }else if(val == 4){//Paternity Leave
    //      $("#days").html(data);

     }else{
        $('#leaveFare').hide();
     }

     $.ajax({
     type: "POST",
     url: "<?php echo base_url();?>Leave/Getleavedays",
     data:'leaveid='+ val+ '&em_id='+ em_id,
     success: function(data){
         $("#days2").html(data);
     }
});
}
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
