<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"> Download Revenue Collection Report  </h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> Reports </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">

                    <div class="card card-outline-info">
                   <div class="card-header">

                   
                     <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>E_reports/regions_revenue_ems_reports" class="text-white"><i class="" aria-hidden="true"></i>  Download Reports </a></button>

                    <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>E_reports/list_revenue_reports" class="text-white"><i class="" aria-hidden="true"></i>  Download History </a></button>

                    </div>
                            
                            <div class="card-body">


                         
                            <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Downloaded file </th>
                                                <th> Downloaded date </th>
                                                <th> Report Type </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                               <?php 
                                                $sn=1;
                                                foreach($list as $data)
                                                {
                                                ?>
                                                <tr>
                                                    <td> <?php echo $sn; ?> </td>
                                                    <td> <?php echo $data->attach; ?></td>
                                                    <td> <?php echo $data->created_at; ?> </td>
                                                    <td> <?php echo $data->type; ?> Report </td>
                                                    <td class="text-center">
                                                    <a href="<?php echo base_url('assets/revenue_collection_reports/');?><?php echo $data->attach; ?>" class="bs-tooltip btn btn-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="Download"> <i class="fa fa-download"></i> Download  </a>
                                                     
                                                    
                                                    
                                                    </td>
                                                    <?php $sn++; }  ; ?>   
                                                </tr>
                                        </tbody>
                                    </table>
     
                                
                           

                          
                               
                               
                            </div>
                        </div>
                    </div>
                </div>

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


    <?php $this->load->view('backend/footer'); ?>