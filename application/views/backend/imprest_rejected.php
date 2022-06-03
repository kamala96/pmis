<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i>Imprest Subsistence Request List</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Imprest Subsistence Request</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="row" style="padding-left:  10px;padding-bottom: 10px;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>employee/Imprest_Approved" class="text-white"><i class="" aria-hidden="true"></i> Approve List</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Imprest_Rejected" class="text-white"><i class="" aria-hidden="true"></i>  Rejected List</a></button>
                       
                </div>
            </div> 
            <div class="container-fluid">         
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Imprest Subsistence Request</h4>
                            </div>
                            <?php echo $this->session->flashdata('delsuccess'); ?>
                            <div class="card-body">
                                <form class=""  action="<?php echo base_url()?>Employee/Imprest_ApproveO" method="post" enctype="multipart/form-data">
                                                <div class="row">
                                                <div class="form-group col-md-4 m-t-5">
                                                    <label>Subsistence Allowance Rate per day</label>
                                                    <input type="text" name="subsistence_allowance" value="<?php echo $imprestList->allowance_rate ?>" class="form-control form-control-line" placeholder="Rate Per Day" minlength=""> 
                                                </div>
                                                </div>
                                                <label><b>Details Of Safaris</b></label>
                                                <div class="row">
                                                    <div class="form-group col-md-4 m-t-5">
                                                    <label>Date Of Leaving Station</label>
                                                    <input type="date" name="leaving_date" value="<?php echo $imprestList->leaving_date ?>" class="form-control form-control-line" placeholder="Date Of Leaving" minlength=""> 
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                     <label>Date Of Returning</label>
                                                    <input type="date" name="date_returning" value="<?php echo $imprestList->returning_date ?>" class="form-control form-control-line" placeholder="Date Of Returning"> 
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                     <label>Visited Place</label>
                                                    <input type="text" name="place_visited" value="<?php echo $imprestList->place_visited ?>" class="form-control form-control-line" minlength="" placeholder="Place Visited"> 
                                                </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12 m-t-5">
                                                    <label>Reason/Purpose</label>
                                                    <textarea class="form-control" placeholder="Purpose of safari" name="safari_purpose" ><?php echo $imprestList->purporse_safari ?></textarea > 
                                                </div>
                                                </div>
                                                <label><b>Details Of Imprest Required</b></label>
                                                <div class="row">
                                                   <div class="form-group col-md-4 m-t-5">
                                                        <label>Subsistence Allowance Days.</label>
                                                    <input type="text" name="number0" class="form-control" style="" value="<?php echo $imprestList->number_of_days ?>" placeholder="Number of days">
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                        <label>Subsistence Allowance Amount in Tsh.</label>
                                                    <input type="text" name="number1" class="form-control" style="" placeholder="Amount Tshs." value="<?php echo $imprestList->sudsistence_amount ?>" >
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                        <label>Incidental Expenses Foreign 20%.</label>
                                                    <input type="text" name="number2" class="form-control" style="" value="<?php echo $imprestList->foreign_20 ?>" placeholder="Amount Tshs." >
                                                </div>
                                                </div>
                                                <div class="row">
                                                   <div class="form-group col-md-4 m-t-5">
                                                        <label>Bus/Train Fare.</label>
                                                    <input type="text" name="number3" class="form-control" value="<?php echo $imprestList->bus_train_fare ?>" style="" placeholder="Amount in Tsh.">
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                        <label>Air Ticket.</label>
                                                    <input type="text" name="number4" class="form-control" value="<?php echo $imprestList->air_ticket ?>" style="" placeholder="Amount Tshs." >
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                        <label>AC/Code/Vote to be charged</label>
                                                    <input type="text" name="number5" class="form-control" value="<?php echo $imprestList->ac_code_vote ?>" style="" placeholder="ACC/Code/Vote." >
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                        <label>AC/Code/Vote to be charged Amount</label>
                                                    <input type="text" name="number6" class="form-control" style="" value="<?php echo $imprestList->ac_code_vote_amount ?>" placeholder="Amount in Tsh." >
                                                </div>
                                                </div>
                                                <label><b>Details Of Safari Outside Tanzania</b></label>
                                                <div class="row">
                                                    <div class="form-group col-md-4 m-t-5">
                                                        <label>State House Authority No.</label>
                                                    <input type="text" name="number7" class="form-control" value="<?php echo $imprestList->state_no ?>" style="height: 45px;" >
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                                        <label>State House Authority Letter</label>
                                                    <br> 
                                                    <?php if(!empty($imprestList->state_letter)){?>
                                                   <a href="<?php echo base_url()?>assets/images/users/<?php echo $imprestList->state_letter ?>"> Download &nbsp;&nbsp;<?php echo $imprestList->state_letter ?></a>
                                               <?php } else {?>
                                                <text style="color: red;">No Letter</text>
                                               <?php }?>
                                                </div>
                                                <div class="form-group col-md-4 m-t-5">
                                            <label style="height: 35px;">Is this safari assisted by TPC/Donor</label>
                                                        <br>
                                                    <?php if ($imprestList->isAssisted == 'Yes') {?>
                                                       <label id="">&nbsp;&nbsp;<input type="checkbox" name="status" style="transform: scale(2);padding-top: 10px;" id="yes" value="" checked="checked"  />&nbsp;&nbsp; If Yes</label>
                                                    <?php
                                                    } else {
                                                    ?>
                                                       <label id=""><input type="checkbox" name="status" style="transform: scale(2);padding-top: 10px;"  id="" value="No"  checked="checked"  />&nbsp;&nbsp; If No</label>
                                                    <?php   
                                                    }
                                                    ?>
                                                    
                                                </div>
                                                </div>
                                                <div class="row" style="" id="">
                                                    <?php if ($imprestList->isAssisted == 'Yes') {?>
                                                    <div class="form-group col-md-12 m-t-5">
                                                        <label>Short Details and number of safari days in this current year</label>
                                                    <textarea class="form-control" placeholder="" name="comments" ></textarea>
                                                <?php } ?>
                                                </div>
                                                </div>
                                                <div class="row m-t-5" style="padding-left:  20px;">
                           <div class="col-md-6 m-t-15">
                                    <label>Reason</label>
                                    <textarea name="reason" class="form-control" readonly><?php echo $imprestList->reason; ?></textarea>
                                </div>

                                <div class="form-group col-md-12 m-t-20">
                                    <input type="hidden" name="id" value="<?php echo $imprestList->id_is; ?>">
                                    <input type="hidden" name="safari_id" value="<?php echo $imprestList->id_safari; ?>">
                                    <input type="hidden" name="imprest_id" value="<?php echo $imprestList->id_imprest; ?>">
                                    <input type="hidden" name="receive_id" value="<?php echo $imprestList->id_receive; ?>">
                                    <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save Information</button>
                                </div>
                                                 

                                                </div>
                                            </form>
                            </div>
                        </div>
                    </div>
                </div>
 <script type="text/javascript">
 $(document).ready(function () {
$('#yes').change(function () {
if (this.checked) {
$('#reason').hide();
$('#sio').hide();
}
else {
$('#reason').hide();
 $('#sio').show();
}
});

$('#no').change(function () {
if (this.checked) {
$('#reason').show();
$('#ndio').hide();
}
else
{
    $('#ndio').show();
    $('#reason').hide();
}
});
});
</script>

<script type="text/javascript">
 $(document).ready(function () {
$('#yes2').change(function () {
if (this.checked) {
$('#reason').hide();
$('#sio').hide();
}
else {
$('#reason').hide();
 $('#sio').show();
}
});

$('#no2').change(function () {
if (this.checked) {
$('#reason').show();
$('#ndio').hide();
}
else
{
    $('#ndio').show();
    $('#reason').hide();
}
});
});
</script>


    <?php $this->load->view('backend/footer'); ?>
    <script>
    $('#employeesFamily').DataTable({
        "aaSorting": [[1,'asc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(7)").each( function (i) {
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
        orderCellsTop: true,
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>


