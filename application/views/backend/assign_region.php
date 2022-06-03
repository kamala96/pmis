<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Assign Region</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Assign Region</li>
            </ol>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <?php $countervalue = $this->employee_model->counterselect(); ?>
	<?php $empservices = $this->organization_model->get_services34(); ?>
    <?php //$empservices = $this->organization_model->get_services(); ?>
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
                        <h4 class="m-b-0 text-white"> Assign Region
                        </h4>
                    </div>
                    <div class="card-body">
					<div class="table-responsive ">
					<form method = "POST" action="Assign_region_Action">
                        <div class="col-md-12">
                            <?php if(!empty($message)){ ?>
                            <div class="alert alert-success alert-dismissible">
                            <strong>Success!</strong> <?php echo $message; ?>
                          </div>
                          <?php } ?>
                        </div>
                        <!-- <input type="hidden" name="emid" value="<?php echo $emid; ?>"/> -->
						<div class="col-md-6">
						<label>Select Zone</label>
						<select name="zone_id" class="custom-select form-control" required="required">
							    <option value="">--Select Zone--</option>
								<?php foreach($service2 as $value){ ?>
								<option value="<?php echo $value->zone_id; ?>"><?php echo $value->zone_name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-md-12 m-t-30">
						<label>Assign Region</label>
						<br>

						<?php foreach ($region as $value1) {?>

							<?php echo $value1->region_name?> :
							<input type="checkbox" name="reg_code[]" value="<?php echo $value1->reg_code?>" class="" style="padding-bottom: 50px;" 
							<?php 
							// foreach ($service2 as $val){
							// 	if ($value1->serv_id == $val->serv_id) {
							// 		echo "checked";
							// 		break;
							// 	}else{

							// 	}
							// }
							?>>

						<?php } ?>
					</div>
					<div class="form-group col-md-12 m-t-30">
						<button type="submit" class="btn btn-info">Save </button>
					</div>
					</form>
                    </div>




                        <br>
                        <br>
                        
                        <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Zone Name</th>
                                                <th style="">Regions</th>
                                                 <th style="">Action</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="results">
                                           <?php foreach(@$service2 as $values): ?>
                                            <tr>
                                                <td><?php echo $values->zone_name;?></td>
                                                <td style="">
                                                    
                                            
                                            <?php 
                                            foreach(@$service as $values2){
                                                if ($values->zone_id == $values2->zone_id) {
                                            
                                            foreach ($region as $val){
                                             if ($values2->region_code == $val->reg_code) {
                                                echo $val->region_name ?>
                                                <input type="checkbox" name="reg_code[]" value="<?php echo $val->region_name?>" class="" style="padding-bottom: 50px;" checked>
                                            <?php }
                                            }}}
                                            ?>

                                                </td>
                                                 <td style="">
                                                    <div class="input-group" style="text-align: right;">
                                                    
                                                <form action="Delete_zoneto_region" method="post">
                                                    <input type="hidden" class="btn btn-danger" name="zone_id" value="<?php echo $values->zone_id;?>">
                                                    <button type="submit" >Delete</button>
                                                </form>
                                                </div>
                                                </td>
                                            </tr>
                                            <?php  endforeach; ?>
                                       
                                        </tbody>
                                    </table>




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

