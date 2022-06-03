<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-cubes" style="color:#1976d2"></i>Imprest Expenditure Request List</h3>
                </div>

                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Imprest Expenditure Request</li>
                    </ol>
                </div>
            </div>
            <div class="message"></div>
            <div class="row" style="padding-left:  10px;padding-bottom: 10px;">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a href="<?php echo base_url(); ?>employee/Imprest_Approved" class="text-white"><i class="" aria-hidden="true"></i> Approve List</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>employee/Imprest_Rejected" class="text-white"><i class="" aria-hidden="true"></i>  Rejected List</a></button>
                       
                </div>
            </div> 
            <div class="container-fluid">         
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white"> Imprest Expenditure Request List</h4>
                            </div>
                            <?php echo $this->session->flashdata('delsuccess'); ?>
                            <div class="card-body">
                                <?php if ($this->session->userdata('user_type')== 'ACCOUNTANT') {?>
                                     <div><a href="<?php echo base_url();?>Employee/Imprest_Bank?status=Yes" class="btn  btn-info">Prepare Imprest To Bank</a></div>
                                <?php
                                } ?>
                               
                                <div class="table-responsive ">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Employee PF Number</th>
                                                <th>Full Names</th>
                                                <th>Departmant</th>
                                                <th>Designation</th>
                                                <th>Registered Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Employee PF Number</th>
                                                <th>Full Names</th>
                                                <th>Departmant</th>
                                                <th>Designation</th>
                                                <th>Registered Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        
                                        <tbody>

                                            <?php foreach ($implestExpenditure as $value) { ?>
                                            <tr>
                                                <td><?php echo $value->em_code;?></td>
                                                <td><?php echo $value->first_name .' '.$value->last_name;?></td>
                                                <td> <?php echo $value->dep_name?></td>
                                                <td><?php  echo $value->des_name;
                                                ?></td>
                                                <td><?php echo $value->date_created;?></td>
                                                <td><?php echo $value->exp_status;?></td>
                                                <td class="jsgrid-align-center ">
                                                    <a href="<?php echo base_url();?>Employee/expenditure_approve?I=<?php echo base64_encode($value->em_id);?>&&Exp=<?php echo base64_encode($value->imp_id);?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                    <!-- <a onclick="return confirm('Are you sure to delete this data?')" href="<?php echo base_url();?>organization/Delete_region/<?php echo $value->region_id;?>" title="Delete" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-trash-o"></i></a> -->
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
    <script type="text/javascript">
    $(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#example4 thead tr').clone(true).appendTo( '#example4 thead' );
    $('#example4 thead tr:eq(1) th').not(":eq(6)").each( function (i) {
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
        fixedHeader: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
