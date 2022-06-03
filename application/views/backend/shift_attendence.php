<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Shift Attendence</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Shift Attendence</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $countervalue = $this->employee_model->counterselect(); ?>
	<?php $empservices = $this->organization_model->get_services(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <!-- <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button> -->
<!--                    <a href="--><?php //echo base_url() ?><!--Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>-->
<!--                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="--><?php //echo base_url(); ?><!--leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button>-->
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Shift Attendence
                        </h4>
                    </div>
                    <div class="card-body">
					<div class="table-responsive ">
                        <table class="table table-bordered assign" style="width: 100%;">
                            <thead>
                            <tr>
                                <th>Counter</th>
                                <th>Assign Date</th>
                                <th>Assign To</th>
                                <th>Counter Status</th>
                                <th>Shift Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($service2 as $value) { ?>
                                <tr>
                                    <td><?php echo $value->counter_name ?></td>
                                    <td><?php echo $value->registered_date; ?></td>
                                    <td><?php $id = $value->assign_to;$getInfo = $this->employee_model->GetBasic($id); echo 'PF ::'.'  '. $getInfo->em_code.'  '.$getInfo->first_name.'  '.$getInfo->middle_name.'   '.$getInfo->last_name ?></td>
                                     <td><?php echo $value->c_status ?></td>
                                    <td><?php $id = $value->assign_to;$getInfo = $this->employee_model->GetBasic($id);?>
                                               <div class="input-group">
                                               <?php if($getInfo->assign_status == "Assign"){ ?>

                                               
                                                     
                                               
                                                    <button class='btn btn-success btn-sm' disabled="disabled">Shift is ON</button>
                                                     || 
                                                     <form action="<?php echo base_url();?>Box_Application/EndShift" method="POST">
                                                         <input type="hidden" name="emid" value="<?php echo $value->assign_to; ?>">
                                                    <button class='btn btn-info btn-sm'>End Shift</button>
                                                </form>
                                                
                                               <?php }elseif ($getInfo->assign_status == "ShiftEnd") {?>
                                                   <button class='btn btn-success btn-sm' disabled="disabled">Shift is OFF</button> || 
                                                       <a class="btn btn-success btn-sm" href="<?php echo base_url(); ?>employee/Assign_Service?I=<?php echo base64_encode($value->assign_to) ?>">Assign Job</a>
                                               <?php }else{?>
                                                 <button class='btn btn-warning btn-sm' disabled="disabled">Shift NotEnd</button> || 
                                                 <form action="<?php echo base_url();?>Box_Application/EndShift" method="POST">
                                                    <input type="hidden" name="emid" value="<?php echo $value->assign_to; ?>">
                                                     <button class='btn btn-info btn-sm'>End Shift</button>
                                                 </form>
                                             </div>
                                                 
                                               <?php }?>
                                     </td>
                                </tr>
                           <?php } ?>
                           </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>

<script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 1900; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#years").append(options);
    </script>
    <script>
        var nowY = new Date().getFullYear(),
            options = "";

        for (var Y = nowY; Y >= 1900; Y--) {
            options += "<option>" + Y + "</option>";
        }

        $("#yearsTo").append(options);
    </script>

    <script type="text/javascript">
$(document).ready(function() {

var table = $('.assign').DataTable( {
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
            timeout: 600000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(1800).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},1800);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});

    </script>

<?php $this->load->view('backend/footer'); ?>

