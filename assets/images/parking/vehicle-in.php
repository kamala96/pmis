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
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-th-list" aria-hidden="true"></i> Vehicle List<span class="pull-right " ></span></h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                             
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                            <form action="vehicle_in" method="POST">
                            <table class="table-bordered" width="100%">
                                <tr>
                                    <th>
                                        <input type="text" name="date" class="form-control mydatetimepicker" placeholder="Select Date">
                                    </th>
                                    <th><input type="text" name="month" class="form-control mydatetimepickerFull" placeholder="Select Month"></th>
                                    <th>
                                 <button type="submit" class="btn btn-info form-control">Search Report</button>
                                    </th>
                                </tr>
                            </table>
                            </form>
                        <div class="table-responsiveness" style="overflow-x: auto;">
                          <table id="table_id" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" style="text-transform: uppercase;">
                        <thead>
                            <tr>
                                <th>S/No</th>
                                <th>Vehicle Regno</th>
                                <th>Vehicle Name</th>
                                <th>Vehicle Owner</th>
                                <th>Tin Number</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Payment Type</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <!-- <th style="text-align: right;">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach ($parking as  $value) {?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $value->vehicle_regno;?></td>
                                <td><?php echo $value->vehicle_name;?></td>
                                <td><?php echo $value->vehicle_owner;?></td>
                                <td><?php echo $value->tin_number;?></td>
                                <td><?php echo $value->entry_time;
                                ?></td>
                                <td><?php echo $value->exit_time;?></td>
                                <td><?php echo $value->payment_type;?></td>
                                <td><?php 

                                        $tz = 'Africa/Nairobi';
                                        $tz_obj = new DateTimeZone($tz);
                                        $today = new DateTime("now", $tz_obj);
                                        $date = $today->format('Y-m-d H:i:s');
                                        $date1 = $today->format('Y-m-d'); 

                                        if ($date1 == date('Y-m-d',strtotime($value->entry_time))) {

                                            $hr  = date('H',strtotime($date));
                                            $hre = date('H',strtotime($value->entry_time));

                                            $min  = date('i',strtotime($date));
                                            $mine = date('i',strtotime($value->entry_time));
                                                $diff =  $hr-$hre;

                                               if($diff == 0){

                                                if ($min-$mine >= 10) {
                                                    $cost = 400;
                                                }else {
                                                    $cost = 0;
                                                }
                                                
                                                $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                   echo number_format($value->cost,2);

                                               }elseif ($diff == 1) {
                                                   
                                                   if ($min-$mine >= 10) {
                                                     $cost = 400+400;
                                                   }else {
                                                     $cost = 400;
                                                   }

                                                   $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                   echo number_format($value->cost,2);
                                                    
                                                }elseif($diff == 2) {
                                                    if ($min-$mine >= 10) {
                                                    $cost = 400+400+400;
                                                   } else {
                                                     $cost = 400+400;
                                                   }

                                                   $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                  echo number_format($value->cost,2);
                                                }elseif($diff == 3){

                                                   if ($min-$mine >= 10) {
                                                     $cost = 400+400+400+400;
                                                   } else {
                                                     $cost = 400+400+400;
                                                   }

                                                   $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                   echo number_format($value->cost,2);
                                                }elseif($diff == 4){
                                                    //echo str_replace('-', '', $min-$mine);
                                                    if ($min-$mine >= 10) {
                                                     $cost = 400+400+400+400+400;
                                                   } else {
                                                     $cost = 400+400+400+400;
                                                   }

                                                   $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                   echo number_format($value->cost,2);
                                                }elseif($diff == 5){
                                                    if ($min-$mine >= 10) {
                                                    $cost = 400+400+400+400+400+400;
                                                   } else {
                                                    $cost = 400+400+400+400+400;
                                                   }

                                                   $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                   echo number_format($value->cost,2);
                                                }else{

                                                    $cost = 3000;
                                                    $id = $value->parking_id;
                                                    $data = array();
                                                    $data = array(
                                                        'cost'=>$cost);
                                                    $this->parking_model->update_time_cash($id,$data);
                                                   echo number_format($value->cost,2);
                                                }
                                                
                                            }
                                             ?>
                                </td>
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
         </div>
                          
    </div>
<script type="text/javascript">
    $(document).ready( function () {
    $('#table_id').DataTable({
        dom: 'Bfrtip',
        ordering:false,
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    });
</script>

<?php $this->load->view('backend/footer'); ?>
