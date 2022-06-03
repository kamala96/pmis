
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
<div class="message"></div>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Ems Item Incoming List</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Ems Item Incoming List </li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row m-b-10">
        <div class="col-12">
         <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Ems_Domestic/Incoming_Item?AskFor=EMS" class="text-white"><i class="" aria-hidden="true"></i> Incomming Item</a></button>

                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Ems_Domestic/Assigned_Delivery_Item?AskFor=EMS" class="text-white"><i class="" aria-hidden="true"></i> Assigned Item</a></button>

                      <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url()?>Ems_Domestic/Delivered_Item?AskFor=EMS" class="text-white"><i class="" aria-hidden="true"></i> Delivered Item</a></button>


                    <!--  <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i><a href="<?php echo base_url() ?>Box_Application/Credit_Customer" class="text-white"><i class="" aria-hidden="true"></i> Create Bill Customer</a></button>
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Box_Application/Ems_BackOffice" class="text-white"><i class="" aria-hidden="true"></i> Ems Back Office List</a></button> -->
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Ems_Domestic/Incoming_Item" class="text-white"><i class="" aria-hidden="true"></i> Incoming Item</a></button> -->
                     <!-- <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url() ?>Loan_Board/Loan_info" class="text-white"><i class="" aria-hidden="true"></i> LoanS Board(HESLB)</a></button> -->

     </div>
 </div>

 <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Delivered Item
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                          <form action="Assign_To" method="POST">
                            <div style="overflow-x: auto;">
                             <table id="example4" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                
                                 <tr>
                                    <td>Received By</td><td><?php echo $hovyo->deliverer_name ?></td>
                                </tr><tr>
                                    <td>Phone Number</td><td><?php echo $hovyo->phone ?></td>
                                </tr><tr>
                                    <td>Identity</td><td><?php echo $hovyo->identity?></td>
                                </tr><tr>
                                    <td>Identity No</td><td><?php echo $hovyo->identityno ?></td>
                                </tr>
                                <tr>
                                    <td>Street</td><td><?php echo $hovyo->location ?></td>
                                </tr><tr>
                                    <td>Signature</td><td>
                                        <img src="data:image/jpeg;base64,<?php echo $hovyo->image; ?>" alt="" width="80" height="80" />
                                        </td>
                                </tr>
                                    
                                </tr>

</table>
</div>
</form>
                        </div>
                        </div>
                    </div>

                </div>

            </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
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
    $("#checkAll3").change(function() {
        if (this.checked) {
            $(".checkSingle3").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle3").each(function() {
                this.checked=false;
            });
        }
    });

    $(".checkSingle3").click(function () {
        if ($(this).is(":checked")) {
            var isAllChecked = 0;

            $(".checkSingle3").each(function() {
                if (!this.checked)
                    isAllChecked = 1;
            });

            if (isAllChecked == 0) {
                $("#checkAll3").prop("checked", true);
            }
        }
        else {
            $("#checkAll3").prop("checked", false);
        }
    });
});
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
<?php $this->load->view('backend/footer'); ?>


