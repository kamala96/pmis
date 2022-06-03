<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?> 
         <div class="page-wrapper">
            <div class="row page-titles">
                <div class="col-md-8 align-self-center">
                    <h3 class="text-themecolor"> Performace Report of <?php echo @$ename; ?>  </h3>
                </div>
                <div class="col-md-4 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"> KPI </li>
                    </ol>
                </div>
            </div>
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">

                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">

                            <a href="<?php echo site_url('Contract/receiver_performance_reports');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Employee Performance Report </button> </a>

                            <a href="<?php echo site_url('Contract/general_receiver_performance_reports');?>"> <button type="button" class="btn btn-primary waves-effect waves-light">  <i class="fa fa-bars"></i> Employee General Performance Report </button> </a>
                        

                            </div>
                            
                            <div class="card-body">
                            
                            <?php 
                            
                            if(!empty($this->session->flashdata('smessage'))){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                      <span aria-hidden='true'>&times;</span>
                                      </button>";
                                      ?>
                                      <?php echo $this->session->flashdata('smessage'); ?>
                                      <?php
                            echo "</div>";
                            
                            }
                            
                            ?>
                            
                

                               <?php if(isset($list)){ ?>
                               <div class="table-responsive" id="defaulttable">
                                    <table id="example4" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> S/N </th>
                                                <th> Task </th>
                                                <th> Weight  </th>
                                                <th> Results </th>
                                                <th> Percentage </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $sn=1; $totalweight=0; $sumtotalmarks=0;
                                        foreach($list as $data){
                                        //$empid = $data->received_by;
                                        //$info = $this->ContractModel->get_employee_info($empid);
                                        ?>
                                            <tr>
                                                <td> <?php echo $sn; ?> </td>
                                                <td> <?php echo @$data->indicator_name; ?> </td>
                                                <td> <?php echo number_format(@$data->weight,1); $totalweight+=@$data->weight; ?> </td>
                                                <td> <?php echo number_format(@$data->rating,1); $sumtotalmarks+=@$data->rating; ?> </td>
                                                <td> <?php $rate = number_format(@$data->rating)/number_format(@$data->weight)*100; echo number_format($rate); ?> % </td>
                                            </tr>
                                        <?php  $sn++; } ?>  

                                        </tbody>

                                        <tr>
                                        <td></td>
                                        <td>Overall Results </td>
                                        <td><?php echo number_format(@$totalweight,1); ?></td>
                                        <td><?php echo number_format(@$sumtotalmarks,1); ?></td>
                        <td><?php $overalper = number_format(@$sumtotalmarks)/number_format(@$totalweight)*100; echo number_format(@$overalper); ?> % </td>
                                        </tr>

                                        
                                    </table>
                                </div>
                               <?php } ?>
                               
                               
                            </div>
                        </div>
                    </div>
                </div>
<script type="text/javascript">
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<script type="text/javascript">
$(document).ready(function() {

var table = $('#example4').DataTable( {
    order: [[1,"desc" ]],
    //orderCellsTop: true,
    fixedHeader: true,
    ordering:false,
    lengthMenu: [[-1,10, 25, 50,100, -1], ["All",10, 25, 50,100]],
    dom: 'lBfrtip',
    buttons: [
    'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );
} );
</script>

<script type="text/javascript">
    function getDistrict() {
        var region = $('#region').val();
        $.ajax({
           url: "<?php echo site_url('Contract/GetEmployee');?>",
           method:"POST",
     data:{region:region},//'region_id='+ val,
     success: function(data){
       $("#district").html(data);

   }
});
    };
</script>

<?php $this->load->view('backend/footer'); ?>