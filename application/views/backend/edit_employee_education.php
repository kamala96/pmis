<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor"><i class="fa fa-clone" style="color:#1976d2"> </i> Edit Family</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Family</li>
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
<!--                    <a href="--><?php //echo base_url() ?><!--Leave/Application_Form" class="btn btn-primary"><i class="fa fa-plus"></i> Add Application</a>-->
<!--                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="--><?php //echo base_url(); ?><!--leave/Holidays" class="text-white"><i class="" aria-hidden="true"></i> Holiday List</a></button>-->
                </div>    
        </div> 

        <div class="row">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"> Edit Family Form
                        </h4>
                    </div>
                    <div class="card-body">
						<div class="table-responsive ">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Year From</th>
                                    <th>Year To</th>
                                    <th>Name Of School</th>
                                    <th>Certification</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($education as $value): ?>
                                <tr>
                                    <td><?php echo $value->yearFrom ?></td>
                                    <td><?php echo $value->yearTo ?></td>
                                    <td><?php echo $value->schoolname ?></td>
                                    <td><?php echo $value->certification ?></td>
                                   <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                                    <?php } else { ?>
                                    <td class="jsgrid-align-center ">
                                        <a href="Edit_Education?I=<?php echo base64_encode($value->id)?>&Ei=<?php echo base64_encode($value->emp_id)?>" title="Edit" class="btn btn-sm btn-warning waves-effect waves-light"><i class="fa fa-pencil-square-o"></i> Edit Education</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                     <form class="row" action="Add_Education" method="post" enctype="multipart/form-data" id="insert_education">
			                                	<span id="error"></span>
			                                    <div class="form-group col-md-6 m-t-5">
			                                        <label>Year From</label>
			                                        <select class="form-control custom-select" id="years" name="yearFrom">
			                                        	<option><?php echo $editeducation->yearFrom; ?></option>
                                                           <option>--Select Year--</option>      
                                                    </select> 
			                                    </div>
			                                    <div class="form-group col-md-6 m-t-5">
			                                        <label>Year To</label>
			                                        <select class="form-control custom-select" id="yearsTo" name="yearTo">
			                                        	<option><?php echo $editeducation->yearTo; ?></option>
                                                           <option>--Select Year--</option>      
                                                    </select> 
			                                    </div>
			                                    <div class="form-group col-md-6 m-t-5">
			                                        <label>Name Of School</label>
			                                        <input type="text" name="schoolname" class="form-control form-control-line" value="<?php echo $editeducation->schoolname; ?>"> 
			                                    </div>
			                                    <div class="form-group col-md-6 m-t-5">
			                                        <label>Certification</label>
			                                        <input type="text" name="certification" class="form-control form-control-line" placeholder="Certification" value="<?php echo $editeducation->certification; ?>"> 
			                                    </div>
			                                  <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                                                    <?php } else { ?>
			                                    <div class="form-actions col-md-6">
                                                    <input type="hidden" name="emid" value="<?php echo $basic->em_id; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $editeducation->id; ?>">
			                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
			                                    </div>
			                                    <?php } ?>
			                                </form>
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
<?php $this->load->view('backend/footer'); ?>

