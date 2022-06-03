<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
<?php $regvalue = $this->organization_model->regselect(); ?>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i>Branches</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Branches</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">
                    <div class="col-lg-5">
                        <?php if (isset($editbranch)) { ?>
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Edit Branche</h4>
                            </div>
                            
                            <?php echo validation_errors(); ?>
                            <?php echo $this->upload->display_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>
                            

                            <div class="card-body">
                                    <form method="post" action="<?php echo base_url();?>organization/Update_branch" enctype="multipart/form-data">
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

                                                        <label class="control-label">Branch Name</label>
                                                        <input type="text" name="branch_name" id="firstName" value="<?php  echo $editbranch->branch_name;?>" class="form-control" placeholder="">


                                                        <input type="hidden" name="branch_id" value="<?php  echo $editbranch->branch_id;?>">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->

                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        
                                                        <label class="control-label">BCL Number</label>
                                                        <input type="text" name="bclno" id="bclno" value="<?php  echo @$editbranch->bcl;?>" class="form-control">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->

                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" class="btn btn-info">Cancel</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <?php } else { ?>                        

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Branches</h4>
                            </div>
                            
                            <?php echo validation_errors(); ?>
                            <?php echo $this->upload->display_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>
                            



                            <div class="card-body">
                                    <form method="post" action="Save_branch" enctype="multipart/form-data">
                                        <div class="form-body">
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Select Name</label>
                                                        <select name="region_id" class="form-control custom-select" required>
                                            <!-- <option>Select Region</option>  -->
                                            <?php if(!empty($editregion->region_name)){ ?>
                                        <option value="<?php echo $reginal->region_id; ?>"><?php echo $reginal->region_name; ?></option>

                                     <?php   }  ?>
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
                                                        <label class="control-label">Branch Name</label>
                                                        <?php if(!empty($editbranch->branch_name)){ ?>
                                                            <input type="text" name="branch_name" id="firstName" value="<?php  echo $editbranch->branch_name;?>" class="form-control" placeholder="" minlength="3" >


                                                            <?php  }else{  ?>
                                                                <input type="text" name="branch_name" id="firstName" value="" class="form-control" placeholder="" minlength="3" required>
                                                            <?php }?>
                                                        
                                                    </div>
                                                </div>

                                                <!--/span-->
                                            </div>


                                             <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">BCL Number</label>
                                                        <input type="text" name="bclno" id="bclno" class="form-control">
                                                    </div>
                                                </div>
                                                <!--/span-->
                                            </div>
                                            <!--/row-->

                                            
                                            <!--/row-->
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" class="btn btn-info">Cancel</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <?php }?>
                    </div>

                    <div class="col-7">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Branches List</h4>
                            </div>
                            <?php echo $this->session->flashdata('delsuccess'); ?>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example23" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Branches Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Branches Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        
                                        <tbody>
                                            <?php foreach ($branches as $value) { ?>
                                            <tr>
                                                <td><?php echo $value->branch_name;?></td>
                                                <td class="jsgrid-align-center ">
                                                    <a href="<?php echo base_url();?>organization/branch_edit/<?php echo $value->branch_id;?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url();?>organization/Delete_branch/<?php echo $value->branch_id;?>" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <?php $this->load->view('backend/footer'); ?>