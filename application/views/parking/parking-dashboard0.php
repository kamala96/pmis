<?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/sidebar'); ?>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="page-wrapper">
      
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Parking Dashboard</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Parking Dashboard</li>
                </ol>
            </div>
        </div>
        <div class="message">
            
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class=""><img src="<?php echo base_url()?>assets/images/in-removebg-preview.png" width="50px;" height="50px;"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            <?php echo $countIn; ?>
                                        </h3>
                        <a href="<?php echo base_url(); ?>Parking/vehicle_in" class="text-muted m-b-0">Vehicle In To Day</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class=""><img src="<?php echo base_url()?>assets/images/vehicle-removebg-preview.png" width="50px;" height="50px;"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            <?php echo $countOutn; ?>
                                        </h3>
                        <a href="<?php echo base_url(); ?>Parking/vehicle_out" class="text-muted m-b-0">Vehicle Out To Day</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class=""><img src="<?php echo base_url()?>assets/images/transact-removebg-preview.png" width="50px;" height="50px;"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            <?php echo $countTrans; ?>
                                        </h3>
                        <a href="<?php echo base_url(); ?>Parking/transanctions" class="text-muted m-b-0">Day Transactions</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class=""><img src="<?php echo base_url()?>assets/images/wallet-removebg-preview.png" width="50px;" height="50px;"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">
                                            <?php echo $countWallet; ?>
                                        </h3>
                        <a href="<?php echo base_url(); ?>Parking/Customer_Wallet" class="text-muted m-b-0">Wallet Transactions</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <form method="POST" action="service_to_other"> 
           <!--  <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-th-list" aria-hidden="true"></i> Vehicle Graph Report<span class="pull-right " ></span></h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12">
                                  <div class="card">
                            
                            <div class="card-body">
                                <div class="example" data-text="" style="height: 500px;">
                       
                            <div class="cell">
                              <h5></h5>
                              <div class="panel">
                                    <div class="content" id="chart-container1">
                                        
                                    </div>
                            </div>
                          </div>
                        
                        </div>
                            </div>
                            </div>
                            </div>
                        </div>
                        </div>

                     </div>
                </div>
            </div> 
             -->
        </form>
         </div>
                          
    </div>
<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
    $('#table_id').DataTable({
        dom: 'Bfrtip',
        ordering:false,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    });
</script>

<script type="text/javascript">

FusionCharts.ready(function () {
            // chart instance
            var chart = new FusionCharts({
                type: "column3d",
                renderAt: "chart-container1", // container where chart will render
                width: "1650",
                height: "450",
                dataFormat: "json",
                dataSource: {
                    // chart configuration
                    chart: {
                        caption: "",
                                     yaxisname: "Vehicle (Number)",
                                     numbersuffix: "",
                                     theme: "fusion"
                    },
                    // chart data
                data: [
                
                <?php foreach($graph as $value){?>
                { label: "<?php echo $value->year; ?>", value: "<?php  echo $value->value;?>" },
               <?php } ?>

                ]
              }
            }).render();
        });
</script>    

<?php $this->load->view('backend/footer'); ?>
