<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
<?php $regvalue = $this->organization_model->regselect(); ?>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i>Box Branches</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Box Branches</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">
                    <div class="col-lg-5">

                          <?php 
                            if(!empty($this->session->flashdata('feedback'))){
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('feedback'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            ?>

                        <?php if (isset($editbranch)) { ?>
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Edit Box Branch</h4>
                            </div>
                            
                            <div class="card-body">
                                    <form method="post" action="<?php echo base_url();?>organization/Update_boxbranch" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Region Name</label>
                                                        <select name="region_id" class="form-control custom-select" required>
                                            <?php 
                                            $reg_id = $editbranch->region_id;$regedit = $this->organization_model->regedit($reg_id);
                                             ?>
                                            <option value="<?php echo $regedit->region_id; ?>">
                                            <?php 
                                            echo $regedit->region_name;
                                            ?>
                                            </option>
                                            <?Php foreach($regvalue as $value): ?>
                                             <option value="<?php echo $value->region_id ?>">
                                                <?php echo $value->region_name ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">

                                                        <label class="control-label">Box Branch Name</label>
                                                        <input type="text" name="branch_name" id="firstName" value="<?php  echo $editbranch->branch_name;?>" class="form-control" placeholder="">


                                                        <input type="hidden" name="branch_id" value="<?php  echo $editbranch->branch_id;?>">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->


                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Update </button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <?php } else { ?>                        

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Box Branch</h4>
                            </div>
                           

                            <div class="card-body">
                                    <form method="post" action="Save_boxbranch" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                            
                                            <label class="control-label">Select Region</label>
                                            <select name="region_id" class="form-control custom-select" required>
                                            <?php foreach($regvalue as $value): ?>
                                             <option value="<?php echo $value->region_id ?>">
                                                <?php echo $value->region_name ?>
                                            </option>
                                            <?php endforeach; ?>
                                            </select>

                                                    </div>
                                                </div>

                                                <!--/span-->
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Box Branch Name</label>
                                                        <input type="text" name="branch_name" id="firstName" value="" class="form-control" placeholder="" minlength="3" required>
                                                        
                                                    </div>
                                                </div>

                                                <!--/span-->
                                            </div>
                                            
                                            <!--/row-->
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <?php }?>
                    </div>

                    <div class="col-7">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Box Branches List</h4>
                            </div>
                            <?php echo $this->session->flashdata('delsuccess'); ?>
                            <div class="card-body">
                                <div class="table-responsive ">
                                     <table class="table table-bordered table-striped International text-nowrap" width="100%" style="text-transform: capitalize;">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Region</th>
                                                <th>Box Branch</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sn=1; foreach ($branches as $value) { ?>
                                            <tr>
                                                <td><?php echo $sn; ?></td>
                                                <td><?php echo $value->region_name;?></td>
                                                <td><?php echo $value->branch_name;?></td>
                                                <td class="jsgrid-align-center ">
                                                    <a href="<?php echo base_url();?>organization/boxbranch_edit/<?php echo $value->branch_id;?>" title="Edit" class="btn btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i> Edit </a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url();?>organization/Delete_boxbranch/<?php echo $value->branch_id;?>" title="Delete" class="btn btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i> Delete </a>
                                                </td>
                                            </tr>
                                            <?php $sn++; }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php $this->load->view('backend/footer'); ?>


<script type="text/javascript">
$(document).ready(function() {

var table = $('.International').DataTable( {
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
