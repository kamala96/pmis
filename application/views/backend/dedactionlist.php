<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 

<?php $regvalue = $this->organization_model->regselect(); ?>
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i>Salary Scales</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Salary Scales</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">
              <!--       <div class="col-lg-5">
                        <?php if (isset($EditSalaryScale)) { ?>
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Edit Salary Scales</h4>
                            </div>
                            
                            <?php echo validation_errors(); ?>
                            <?php echo $this->upload->display_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>
                            

                            <div class="card-body">
                                    <form method="post" action="<?php echo base_url();?>payroll/Add_Salary_Scale">

                                         <div class="form-body">
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Salary Scale</label>
                                                        <input type="text" name="salary_scale" id="amount" value="<?php echo $EditSalaryScale->scale_name ?>" class="form-control" placeholder=""equired>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Ammount</label>
                                                        <input type="number" name="amount" id="amount" value="<?php echo $EditSalaryScale->amount ?>" class="form-control" placeholder=""equired>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Increment</label>
                                                        <input type="number" name="increment" id="increment" value="<?php echo $EditSalaryScale->increment ?>" class="form-control" placeholder=""equired>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <input type="hidden" name="scaleId" value="<?php echo $EditSalaryScale->scaleId ?>" class="form-control">
                                            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                            <button type="button" class="btn btn-info">Cancel</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <?php } else { ?>                        

                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add Salary Scales</h4>
                            </div>
                            
                            <?php echo validation_errors(); ?>
                            <?php echo $this->upload->display_errors(); ?>
                            <?php echo $this->session->flashdata('feedback'); ?>
                            

                            <div class="card-body">
                                    <form method="post" action="<?php echo base_url();?>payroll/Add_Salary_Scale"" >
                                        <div class="form-body">
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Salary Scale</label>
                                                        <input type="text" name="salary_scale" id="amount" value="" class="form-control" placeholder=""required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Ammount</label>
                                                        <input type="number" name="amount" id="amount" value="" class="form-control" placeholder=""required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Increment</label>
                                                        <input type="number" name="increment" id="increment" value="" class="form-control" placeholder="" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                            <button type="reset" class="btn btn-info">Cancel</button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                        <?php }?>
                    </div> -->

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Salary Scale List</h4>
                            </div>
                            <?php echo $this->session->flashdata('delsuccess'); ?>
                            <div class="card-body">
                                <div class="table-responsive ">
                               <table id="employees123" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Scale Name</th>
                                                <th>Scale Amount</th>
                                                
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Scale Name</th>
                                                <th>Scale Amount</th>
                                                
                                            </tr>
                                        </tfoot>
                                        
                                        <tbody>
                                            <?php foreach ($othersDeductions as $value) { ?>
                                            <tr
                                                <td><?php echo $value->other_names;?></td>
                                                <td><?php echo $value->others_amount;?></td>
                                                
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
    <script>
    $('#employees123').DataTable({
        //"aaSorting": [[1,'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script>