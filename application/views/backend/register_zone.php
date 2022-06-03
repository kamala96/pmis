<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Register Zone </h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Register Zone</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $regionlist = $this->employee_model->regselect(); ?>
    <div class="container-fluid">
        <div class="row m-b-10">
                <div class="col-12">
                    <a href="<?php echo base_url() ?>Organization/add_zone" class="btn btn-primary"><i class="fa fa-plus"></i> Create Zone</a>
                    
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Zone Form                       
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="card">
                           <div class="card-body">
                            <?php if (!empty($serviceById->zone_name)) {?>
                                 <form action="<?php echo base_url('Organization/add_zone_action')?>" method="POST">
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zone Name</label>
                                <input type="text" name="zone_name" class="form-control" required="required" value="<?php echo $serviceById->zone_name ?>">
                                </div>
                               </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="zone_id" value="<?php echo $serviceById->zone_id ?>">
                                   <button class="btn btn-info btn-sm" type="submit">Save Zone</button>
                                </div>
                                </div>
                                </div>
                        </form>
                            <?php }else{ ?>
                                 <form action="<?php echo base_url('Organization/add_zone_action')?>" method="POST">
                                <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    <label>Zone Name</label>
                                <input type="text" name="zone_name" class="form-control" required="required">
                                </div>
                               </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                <div class="form-group">
                                   <button class="btn btn-info btn-sm" type="submit">Save Zone</button>
                                </div>
                                </div>
                                </div>
                        </form>
                            <?php } ?>
                             

                        <br>
                        <br>
                        
                        <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Zone Name</th>
                                                <th style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php foreach(@$service as $values): ?>
                                            <tr>
                                                <td><?php echo $values->zone_name;?></td>
                                                <td style="">
                                                    <div class="input-group" style="text-align: right;">
                                                    <a href="add_zone?I=<?php echo base64_encode($values->zone_id)?>" class="btn btn-warning btn-sm">Edit</a> 
                                                <form action="deletezoneemp" method="post">
                                                    <input type="hidden" class="btn btn-danger" name="zone_id" value="<?php echo $values->zone_id;?>">
                                                    <button type="submit" >Delete</button>
                                                </form>
                                                </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                       
                                        </tbody>
                                    </table>
                            </div>
                           </div>
                        
                        

                        </div>
                    </div>

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

