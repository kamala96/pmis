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
                                    <div class=""><img src="<?php echo base_url()?>assets/images/vehicle-removebg-preview.png" width="50px;" height="50px;"></div>
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
                                    <div class=""><img src="<?php echo base_url()?>assets/images/in-removebg-preview.png" width="50px;" height="50px;"></div>
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
             
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-plus" aria-hidden="true"></i> Wallet Customer Registration<span class="pull-right " ></span></h4>
                        </div>
                        
                        <div class="card-body" style="">
                <form method="POST" action="Customer_Wallet">
                            <div class="row">
                            <div class="col-md-4">
                                <label>[Customer Type]</label>
                               <select class="form-control custom-select cust" name="cust_type" style="">
                                   <option value="">--Select Customer Type--</option>
                                   <option>Individual</option>
                                   <option>Company</option>
                               </select>
                            </div>
                             <div class="col-md-4 com">
                                <label>[Customer Name]</label>
                                <input type="text" name="comname" class="form-control" placeholder="Customer Name" />
                            </div>
                             <div class="col-md-4 com">
                                <label>[Tin Number]</label>
                                <input type="text" name="tin" class="form-control" placeholder="Tin Number" />
                            </div>
                             <div class="col-md-4 com">
                                <label>[Vrn]</label>
                                <input type="text" name="vrn" class="form-control" placeholder="Vrn" />
                            </div>
                            <div class="col-md-4 com">
                                <label>[Amount]</label>
                                <input type="text" name="amount" class="form-control" placeholder="Amount" />
                            </div>
                            <div class="col-md-4 com">
                                <label>[Mobile]</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Mobile" />
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-info">Save Customer Info</button>
                            </div>
                        </div>
                </form>
                        
                        </div>

                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-th-list" aria-hidden="true"></i> Wallet Customer List<span class="pull-right " ></span></h4>
                        </div>
                         <div class="card-body" style="">
                            <div class="table-responsiveness" style="overflow-x: auto;">
                                <table class="table table-bordered" width="100%" id="table_id" style="text-transform: capitalize;">
                                    <thead>
                                        <tr>
                                            <th width="">S/No.</th>
                                            <th width="">Customer Type</th>
                                            <th>Customer Name</th>
                                            <th>Mobile Number</th>
                                            <th>Tin Number</th>
                                            <th>Vrn</th>
                                            <th>Control number</th>
                                            <th>Amount(Tsh)</th>
                                            <th>Pyment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach ($wallet as $value) {?>
                                           <tr>
                                            <td><?php echo $i;$i++; ?></td>
                                            <td><?php echo $value->cust_type; ?></td>
                                            <td><?php echo $value->comp_name; ?></td>
                                            <td><?php echo $value->mobile; ?></td>
                                            <td><?php echo $value->tin_number; ?></td>
                                            <td><?php echo $value->vrn;?></td>
                                            <td><?php echo $value->controlno;?></td>
                                            <td><?php echo number_format($value->paidamount,2);?></td>
                                            <td><?php echo $value->status;?></td>
                                            <td>
                                                <a href="#" class="btn btn-warning">Edit</a>
                                                <?php if( $value->status == "Paid"){ ?>
                                                    <a href="#" class="btn btn-info">Add Vehicle</a>
                                                <?php }?>
                                            </td>
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
<script type="text/javascript">
function getType() {

    var custm = $('.cust').val();
    if (custm == 'Individual') {
        $('.indv').show();
        $('.com').hide();
    }else{
        $('.indv').hide();
        $('.com').show();
    }
   
};
</script>
<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
    submitHandler: function(form) {
        var formval = form;
        var url = $(form).attr('action');

        // Create an FormData object
        var data = new FormData(formval);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            // url: "crud/Add_userInfo",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 6000,
            success: function (response) {
                console.log(response);            
                $(".message").fadeIn('fast').delay(6000).fadeOut('fast').html(response);
                $('form').trigger("reset");
                window.setTimeout(function(){location.reload()},6000);
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
});
});
</script>
<?php $this->load->view('backend/footer'); ?>
