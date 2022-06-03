<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-fighter-jet" style="color:#1976d2"></i> Deductions</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Deduction</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Percent_Deduction" class="text-white"><i class="" aria-hidden="true"></i> Percentage Deduction</a></button>
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Payroll/Non_PercentD" class="text-white"><i class="" aria-hidden="true"></i> Non Percentange Deduction</a></button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Loan Deduction List  </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee PF Number</th>
                                        <th>Full Names</th>
                                        <th>Lander Name</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Installment Amount</th>
                                        <th>Outstanding</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach($NonPercentageDeduction as $value): ?>
                                    <tr>
                                         <td><?php echo $value->em_code; ?></td>
                                         <td><?php echo $value->first_name . ' '. $value->middle_name. ' '. $value->last_name; ?></td>
                                        <td><?php echo $value->other_names; ?></td>
                                        <td><?php echo $value->month ?></td>
                                        <td><?php echo $value->year ?></td>
                                         <td><?php echo number_format($value->installment_Amount,2); ?></td>
                                        <td><?php echo number_format($value->others_amount,2 )?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="leavemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Leave</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="Add_leaves_Type" id="leaveform" enctype="multipart/form-data">
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label class="control-label">Leave name</label>
                                <input type="text" name="leavename" class="form-control" id="recipient-name1" minlength="1" maxlength="35" value="" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Day</label>
                                <input type="text" name="leaveday" class="form-control" id="recipient-name1" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">status</label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" required>
                                    <option value="">Select Here</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="" class="form-control" id="recipient-name1">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


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


        <script type="text/javascript">
        $(document).ready(function () {
        $(".leavetype").click(function (e) {
        e.preventDefault(e);
        // Get the record's ID via attribute
        var iid = $(this).attr('data-id');
        $('#leaveform').trigger("reset");
        $('#leavemodel').modal('show');
        $.ajax({
        url: 'LeaveTypebYID?id=' + iid,
        method: 'GET',
        data: '',
        dataType: 'json',
        }).done(function (response) {
        console.log(response);
        // Populate the form fields with the data returned from server
                                                            $('#leaveform').find('[name="id"]').val(response.leavetypevalue.type_id).end();
        $('#leaveform').find('[name="leavename"]').val(response.leavetypevalue.name).end();
        $('#leaveform').find('[name="leaveday"]').val(response.leavetypevalue.leave_day).end();
        $('#leaveform').find('[name="status"]').val(response.leavetypevalue.status).end();
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

<?php $this->load->view('backend/footer'); ?>