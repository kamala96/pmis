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
				<?php if(@$ask == "Discharge"){?>
				<button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap"  class="text-white"><i class="" aria-hidden="true"></i> Add Discharge </a></button>
				<?php }else{ ?>
                <?php if($this->session->userdata('user_type')=='ACCOUNTANT'){ ?>
                <?php } if($this->session->userdata('user_type')=='RM' || $this->session->userdata('user_type')=='HOD' || $this->session->userdata('user_type')=='SUPERVISOR'){ ?>
                 <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Disciplinary" class="text-white"><i class="" aria-hidden="true"></i>  Disciplinary List</a></button>
             <?php } else {?>
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>employee/Add_employee" class="text-white"><i class="" aria-hidden="true"></i> Add Employee</a></button>
                <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Disciplinary" class="text-white"><i class="" aria-hidden="true"></i>  Disciplinary List</a></button>
            <?php } ?>
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
                                <table id="example4" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Employee PF Number</th>
                                            <th>Employee Name</th>
                                            <th>Gender</th>
                                            <th>Region</th>
                                            <th>Branch </th>
                                            <th>Contact</th>
											<?php if(@$ask == "Discharge"){?>
											<th>Status</th>
											<?php }else{ ?>
											
                                            <th>Retirement Date</th>
                                            <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){ ?>
                                              <th>Status</th>
                                              <?php}else{?>
                                              <?php }?>
                                            <th style="text-align: right;">Action</th>
											<?php } ?>
                                        </tr>
                                    </thead>

                                    <tbody class="results">
                                     <?php foreach($employee as $value): ?>
                                        <tr>
                                           <td><?php echo $value->em_code; ?></td>
                                           <td title="<?php echo $value->first_name .' '.$value->last_name; ?>" style="text-transform: uppercase;">
                                            <?php echo $value->first_name .' '.$value->middle_name.'  '.$value->last_name; ?></td>
                                            <td><?php echo $value->em_gender; ?></td>
                                            <td><?php echo $value->em_region; ?></td>
                                            <td><?php echo $value->em_branch; ?></td>

                                            <td><?php echo $value->em_phone; ?></td>
											<?php if(@$ask == "Discharge"){?>
											<td><?php echo $value->status; ?></td>
											<?php }else{ ?>
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
                                                 echo "<text style='color:red;''>". $value->status.' ( '.$value->em_contact_end.' )'."</text>";
                                             } 
                                             else {
                                               echo '<text style="color:red;">   '.$monhtRemain.'   '.'Months Remaining To Retire</text>' ;
                                           }
                                       } else {
                                           echo $value->em_contact_end;
                                       }
                                       ?>
                                   </td>
                                   <?php if($this->session->userdata('user_type') == 'SUPERVISOR'){ ?>
                                              <td><?php 
											  if($value->assign_status == "ShiftEnd"){
                                                      echo "<button class='btn btn-success btn-sm'>Shift Ended</button>";
                                              }elseif($value->assign_status == "NotEnded" || $value->assign_status == "Assign"){
												  	  echo "<button class='btn btn-warning btn-sm'>Shift Not End</button>";
											  }else{
												  	  echo "<button class='btn btn-success btn-sm'>Shift Ended</button>";
											  }?>
											  </td>        <?php}else{?>
                                              <?php }?>
                                   <td class="jsgrid-align-center " style="text-align: right;">
                                    <?php if($this->session->userdata('user_type')=='ADMIN'){ ?>
                                        <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="<?php echo base_url(); ?>employee/Assign_Service?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn  btn-info btn-sm waves-effect waves-light">Job Assignment</a>
                                        
                                          <?php } elseif($this->session->userdata('user_type')=='SUPER ADMIN'
                                           || $this->session->userdata('user_type')=='HR-PAY'  ){ ?>

                                             <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                        <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url(); ?>employee/EmployeeDelete/<?php echo $value->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>
                                        <a href="<?php echo base_url();?>payroll/Create_Salary?I=<?php echo base64_encode($value->em_id); ?>" title="Add Salary" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-plus-square-o"></i>&nbsp;Add Salary</a>
                                        <a href="<?php echo base_url(); ?>employee/Assign_Service?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn  btn-info btn-sm waves-effect waves-light">Job Assignment</a>

                                    <?php } elseif($this->session->userdata('user_type')=='ACCOUNTANT' ){ ?>
                                      <!--   <a href="<?php echo base_url();?>Employee/Create_Salary?I=<?php echo base64_encode($value->em_id); ?>" title="Add Salary" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-plus-square-o"></i>&nbsp;Add Salary</a> -->
                                    <?php } elseif($this->session->userdata('user_type')=='RM' || $this->session->userdata('user_type')=='HOD' ){ ?>
                                      <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light">Vew Employee Profile</a>
                                  <?php } elseif($this->session->userdata('user_type')=='SUPERVISOR' ){ ?>
                                    <a href="<?php echo base_url(); ?>employee/Assign_Service?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn  btn-info btn-sm waves-effect waves-light">Job Assignment</a>
                                    <a href="<?php echo base_url(); ?>Box_Application/Ems_Application_Pending_Supervisor?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn  btn-success btn-sm waves-effect waves-light">Track Job</a>
                                <?php } else {?>
                                    <a href="<?php echo base_url(); ?>employee/view?I=<?php echo base64_encode($value->em_id); ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                    <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url(); ?>employee/EmployeeDelete/<?php echo $value->id;?>" title="Delete" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fa fa-trash-o"></i></a>

                                <?php }?>

                            </td>                                            
											<?php } ?>
                                            
                        </tr>
                    <?php endforeach; ?>
                    <!-- <tr><th colspan="8" style=""><?php echo $pagination; ?></th></tr> -->
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>
</div>
<!-- sample modal content -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content ">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="exampleModalLabel1">Discharge Notice</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <form method="post" action="add_Desciplinary" id="btnSubmit" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    
                                                        <div class="form-group">
                                                            <label class="control-label">Employee PF Number</label>
													<input type='text' name="emid" class="form-control" placeholder="PF Number" required="required"/>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Discharge Action</label>
                                                            <select class="form-control custom-select" name="status" required="required">
															    <option value="">--Select Discharge Action--</option>
                                                                <option value="DEATH">Death</option>
                                                                <option value="DISCIPLINARY">Disciplinary</option>
                                                                <option value="RESIGNATION">Resignation</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="control-label">Title</label>
                                                            <input type="text" name="title" value="" class="form-control" id="recipient-name1">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="control-label">Details</label>
                                                            <textarea class="form-control" value="" name="details" id="message-text1" rows="4"></textarea>
                                                        </div>
                                                    
                                                </div>
                                                <div class="modal-footer">
                                                   <input type="hidden" name="id" value="">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal -->
<?php $this->load->view('backend/footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(8)").each( function (i) {
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
        order: [[0,"asc" ]],
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>

<script>
        // Populate the payroll table to generate the payroll for each individual
        $("#BtnSubmit").on("click", function(event){
            event.preventDefault();
            var em_code = $('#em_id').val();
            var em_gender = $('#em_gender').val();
            var region    = $('#regiono').val();
            var branch    = $('#branchdropo').val();
            $.ajax({
             url: "<?php echo base_url();?>Employee/Search?em_code="+em_code+"&em_gender="+em_gender+"&region="+region+"&branch="+branch,
             type:"GET",
             dataType:'',
             data:'data',          
             success: function(response) {
             // console.log(response);
             
             $('#employees123').html(response);
         },
         error: function(response) {

         }
     });
        });
    </script>


<!-- <script>
    $('#employees1234').DataTable({
        //"aaSorting": [[1,'desc']],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
</script> -->

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
<script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".disiplinary").click(function (e) {
                                                e.preventDefault(e);
                                                // Get the record's ID via attribute  
                                                var iid = $(this).attr('data-id');
                                                $('#btnSubmit').trigger("reset");
                                                $('#exampleModal').modal('show');
                                                $.ajax({
                                                    url: 'DisiplinaryByID?id=' + iid,
                                                    method: 'GET',
                                                    data: '',
                                                    dataType: 'json',
                                                }).done(function (response) {
                                                    console.log(response);
                                                    // Populate the form fields with the data returned from server
													$('#btnSubmit').find('[name="id"]').val(response.desipplinary.id).end();
                                                    $('#btnSubmit').find('[name="emid"]').val(response.desipplinary.em_id).end();
                                                    $('#btnSubmit').find('[name="warning"]').val(response.desipplinary.action).end();
                                                    $('#btnSubmit').find('[name="title"]').val(response.desipplinary.title).end();
                                                    $('#btnSubmit').find('[name="details"]').val(response.desipplinary.description).end();
												});
                                            });
                                        });
</script>
