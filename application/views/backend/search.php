<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
         <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-user-secret" aria-hidden="true"></i> Employee</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ol>
                </div>
            </div>
            <!-- <div class="message"></div> -->
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <?php if($this->session->userdata('user_type')=='ACCOUNTANT' ){ ?>
                        
                        <?php } else {?>
                            <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>employee/Add_employee" class="text-white"><i class="" aria-hidden="true"></i> Add Employee</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Disciplinary" class="text-white"><i class="" aria-hidden="true"></i>  Disciplinary List</a></button>
                       <?php } ?>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"><i class="fa fa-user-o" aria-hidden="true"></i> Employee List</h4>
                            </div>
                            
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <?php $region = $this->employee_model->regselect(); ?>
                                    <table class="table table-bordered">
                            <form action="<?php echo base_url();?>Settings/Search" method="post">
                                    <tr><td><input type="text" name="em_id" placeholder="PF Number" class="form-control"></td><td><select name="em_gender" class="form-control">
                                        <option>--Select Gender--</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select></td><td><select name="region" value="" class="form-control custom-select" required id="regiono" onChange="getDistrict();">
                                            <option>--Select Region--</option>
                                            <?Php foreach($region as $value): ?>
                                             <option value="<?php echo $value->region_name ?>"><?php echo $value->region_name ?></option>
                                            <?php endforeach; ?>
                                        </select></td><td><select name="branch" value="" class="form-control custom-select"  id="branchdropo">  
                                            <option>--Select Branch--</option>
                                        </select></td><td><button type="submit" class="btn btn-info">Search Here</button>fghdtfghfghgghghhg</td></tr>
                                    </form>
                                    </table>
                                    <table id="employees123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Employee PF Number</th>
                                                <th>Employee Name</th>
                                                <th>Gender</th>
                                                <th>Region</th>
                                                <th>Branch </th>
                                                <th>Contact</th>
                                                <th>Retirement Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                               <tr>
                                                <th>Employee PF Number</th>
                                                <th>Employee Name</th>
                                                <th>Gender</th>
                                                <th>Region</th>
                                                <th>Branch </th>
                                                <th>Contact</th>
                                                <th>Retirement Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                           <?php foreach($employee as $value): ?>
                                            <tr>
                                                 <td><?php echo $value->em_code; ?></td>
                                                <td title="<?php echo $value->first_name .' '.$value->last_name; ?>">
                                            <?php echo $value->first_name .' '.$value->middle_name.'  '.$value->last_name; ?></td>
                                                <td><?php echo $value->em_gender; ?></td>
                                                <td><?php echo $value->em_region; ?></td>
                                                <td><?php echo $value->em_branch; ?></td>
                                                
                                                <td><?php echo $value->em_phone; ?></td>
                                                <td><?php 
                                                        $yearRetire=date('Y', strtotime($value->em_birthday)) + 60;
                                                        $monhtOnly=date('m', strtotime($value->em_birthday));

                                                         $yearNow = date('Y');
                                                         $Monthnow = date('m');
                                                         $yearDiff = $yearRetire - $yearNow;
                                                         if ($yearDiff <= 0) {
                                                            $monhtRemain = $monhtOnly-$Monthnow;
                                                            if ($monhtRemain <= 0) {
                                                               $id = $value->id;
                                                               $this->employee_model->UpdateRetired($id);
                                                            } else {
                                                                 echo '<text style="color:red;">   '.$monhtRemain.'   '.'Months Remaining To Retire</text>' ;
                                                            }
                                                         } else {
                                                             echo $value->em_contact_end;
                                                         }
                                                         ?>
                                                         </td>
                                                <td class="jsgrid-align-center ">
                                                     <?php if($this->session->userdata('user_type')=='ACCOUNTANT' ){ ?>
                                                        <a href="<?php echo base_url();?>Employee/Create_Salary?I=<?php echo base64_encode($value->em_id); ?>" title="Add Salary" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-plus-square-o"></i>&nbsp;Add Salary</a>
                                                        <?php } else {?>
                                                            <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                    <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url(); ?>employee/EmployeeDelete/<?php echo $value->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                                    <?php }?>
                                                    
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

<script type="text/javascript">
    function getDistrict() {
    var region_id = $('#regiono').val();
     $.ajax({
     
     url: "<?php echo base_url();?>Employee/GetBranch",
     method:"POST",
     data:{region_id:region_id},//'region_id='+ val,
     success: function(data){
         $("#branchdropo").html(data);

     }
 });
};
</script>