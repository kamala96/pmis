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
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-th-list" aria-hidden="true"></i> Vehicle Graph Report<span class="pull-right " ></span></h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                            <div class="col-md-12">
                                  <div class="card">
                            <div class="table-responsiveness" style="overflow-x: auto;">
                          <table id="table_id" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="text-transform: uppercase;">
                        <thead>
                            <tr>
                                <th>S/No</th>
                                <th>Contro No.</th>
                                <th>Bill Date</th>
                                <th>Amount(TSH)</th>
                                <th>Pay Channel</th>
                                <th>Pay Date</th>
                                <th>Receipt</th>
                                <th>Status</th>
                                <!-- <th style="text-align: right;">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($trans as  $value) {?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $value->billid;?></td>
                                <td><?php echo $value->transactiondate;?></td>
                                <td><?php echo number_format($value->paidamount,2);?></td>
                                <td><?php echo $value->paychannel;?></td>
                                <td><?php echo $value->paymentdate;
                                ?></td>
                                <td><?php echo $value->receipt;
                                    $serial = $value->serial;
                                                $amount = $value->paidamount;
                                                $this->parking_model->getUpdatePaymentParking($serial,$amount);
                                ?></td>
                                <td><?php echo $value->status;?></td>

                                <!-- <td style="text-align:right;">
                                </td> -->
                            </tr>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                    </div>
                            </div>
                        </div>
                        </div>

                     </div>
                </div>
            </div> 
            
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
