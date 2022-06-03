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
                    <?php if ($this->session->userdata('user_type')== 'HR' || $this->session->userdata('user_type')== 'ADMIN') {?>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>leave/Batch" class="text-white"><i class="" aria-hidden="true"></i>&nbsp;&nbsp;Prepare Leave Batch</a></button>
                   <?php }elseif ($this->session->userdata('user_type')== 'CRM' || $this->session->userdata('user_type')== 'PMG' || $this->session->userdata('user_type')== 'ACCOUNTANT' || $this->session->userdata('user_type')== 'HR') {?>
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
						
                        <div class="table-responsive ">
                            <form method="POST" action="batch_status">
                                   <input type="hidden" name="batchNo" value="<?php echo $no; ?>">
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
                                        <th>Fare Amount</th>
                                        <th><div class="form-check" style="padding-right: 40px;  text-align: right;" id="showCheck">
                                                     <input type="checkbox"  class="form-check-input" id="checkAll" style="">
                                                     <label class="form-check-label" for="remember-me">Select All</label>
                                                 </div>
                                        </th>
                                    </tr>
                                </thead>
                                 <tbody class="leave">
                                    <?php foreach($batchNo as $value): ?>
                                    <tr style="vertical-align:top">
                                        <td><span><?php echo $value->em_code ?></span></td>
                                        <td>
                                             <a href="<?php echo base_url(); ?>Leave/leaveview?I=<?php echo base64_encode($value->em_code)?NO= base64_encode($value->batchNo); ?>"><span><?php echo $value->first_name.' '.$value->last_name ?></span></a>
                                            
                                        </td>
                                        <!-- <td><?php echo $value->em_code; ?></td> -->
                                        <td><?php
                                        $typeid = $value->typeid;
                                        $leaveById = $this->leave_model->GetLeaveType($typeid);
                                        echo $leaveById->name;

                                         ?></td>
                                        <td><?php echo date('jS \of F Y',strtotime($value->apply_date)); ?></td>
                                        <td><?php echo $value->start_date; ?></td>
                                        <td><?php echo $value->end_date; ?></td>
                                        <td><?php echo $value->leave_duration . ' ' .'Days'; ?></td>
                                        <td>
                                        <?php echo number_format($value->fare_amount + $value->faredistrictvillage); ?>
                                      </td>
                                        <td>
                                        <div>
                                            <input type="checkbox" name="I[]" class="form-check-input checkSingle" id="remember-me" value="<?php echo $value->batch_id; ?>">
                                         <label class='form-check-label' for='remember-me'></label>
                                     </div>
                                     </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="7"></th>
                                     
                                                     
                                         <th>
                                            <div class="form-check" style="float: right;" id="showCheck2">
                                            <?php if($this->session->userdata('user_type') == 'CRM'){?>
                                            <button type="Submit" class="btn btn-info btn-sm">Send To PMG</button>
                                            <button type="Submit" class="btn btn-info btn-sm" name="remove">Remove From Batch</button>
                                            
                                            <?php }elseif($this->session->userdata('user_type')== 'ACCOUNTANT' || $this->session->userdata('user_type')== 'ADMIN') {?>
                                               
                                            <button type="Submit" name="batch" value="batch" class="btn btn-info">Send Batch To PDF</button>
                                            <button type="Submit" class="btn btn-danger" name="remove" value="remove"> Remove From Batch</button>

                                            <?php }elseif($this->session->userdata('user_type')== 'PMG'){ ?>

                                            <button type="Submit" class="btn btn-info btn-sm">Send To ACCOUNTANT</button>
                                            <button type="Submit" class="btn btn-info btn-sm" name="remove">Remove From Batch</button>
                                            
                                            <?php } ?>
                                             </div>
                                         </th>
                                    
                                    </tr>
                                </tfoot>
                               
                            </table>
                            </form>
                        </div>
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
                            <div class="modal-footer">
                                <input type="hidden" name="id" class="form-control" id="recipient-name1" required>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            </form>
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


<?php $this->load->view('backend/footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    // $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    // $('#example4 thead tr:eq(1) th').not(":eq(8)").each( function (i) {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" class="form-control" placeholder="'+title+'" />' );

    //     $( 'input', this ).on( 'keyup change', function () {
    //         if ( table.column(i).search() !== this.value ) {
    //             table
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

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

 
    <script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 6000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(600).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},600);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>
