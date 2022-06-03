
<?php include('connection.php'); ?>
<?php  $emid = base64_decode($_GET['em_id']);
$date = date('Y-m-d');
$sql = "SELECT * FROM `employee` WHERE `em_id` = '$emid'";
$result = $conn2->query($sql);
 if ($result->num_rows > 0){
      	$row = $result->fetch_assoc() ;
     $_SESSION['role'] = $row['em_role'];
     $_SESSION['o_region'] = $row['em_region'];
     $_SESSION['o_branch'] = $row['em_branch'];
     $_SESSION['first_name'] = $row['first_name'];
     $_SESSION['middle_name'] = $row['middle_name'];
     $_SESSION['last_name'] = $row['last_name'];
     $_SESSION['em_image'] = $row['em_image'];
     $_SESSION['em_id'] = $row['em_id'];
     $o_region = $_SESSION['o_region'];
     $o_branch = $_SESSION['o_branch'];
      }

      if (@$_GET['ask'] == "Bagclose") {

        $id = @$_POST['I'];
        $weight = @$_POST['bag_weight'];
        if (empty($id)) {
          $warning = 'Please Select atleast one item to close in bag';
        } else {

            $rondom = substr(date('dHis'), 1);
            $billcode = '005';//bag code in tracking number
            echo $bagsNo = $billcode.$rondom;
            $status = "notDespatch";
            $cat = "Domestic";
            $isBag = "isBag";
           $sqlsave = "INSERT INTO `bags` (`bag_number`, `bag_region`, `bag_branch`, `date_created`, `service_type`, `bag_region_from`, `bag_branch_from`, `despatch_no`, `bags_status`, `qr_image`, `bag_weight`, `bag_created_by`, `bag_received_by`, `ems_category`) VALUES ('".$bagsNo."','','','".date("Y-m-d h:i")."','EMS','".$_SESSION['o_region']."','".$_SESSION['o_branch']."','','".$status."','','".$weight."','".$_SESSION['em_id']."','','".$cat."')";
             $conn->query($sqlsave);
              
           for ($i=0; $i <@sizeof($id) ; $i++){
               
               $cid = $id[$i];

                $sqlup = "UPDATE `transactions` SET `isBagNo`='".$bagsNo."',`bag_status`='".$isBag."' WHERE `id`='".$cid."'";
                $conn->query($sqlup);

                  
          $success = 'Successfully Bag Closed';
        }
      }

      } else {
        # code...
      }
      
      
?>
<?php include('header.php');?>
<?php include('sidebar.php'); ?>
<div class="page-wrapper">
  <div class="message"></div>
  <div class="row page-titles">
    <div class="col-md-5 align-self-center">
      <h3 class="text-themecolor"><i class="fa fa-braille" style="color:#1976d2"></i>&nbsp 
        
                      <?php echo $_SESSION['role']; ?>  Dashboard Back Office</h3>
                    </div>
                    <div class="col-md-7 align-self-center">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">

                        Dashboard Back Office</li>
                      </ol>
                    </div>
                  </div>

                  <!-- Container fluid  -->
                  <!-- ============================================================== -->
                  <div class="container-fluid">
                   <br>
                    <div class="row ">
                    <!-- Column -->

                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="assets/images/in.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                
                                    $date = date('Y-m-d');
                                    if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

                                      $sql="SELECT * FROM `despatch` WHERE `region_to` = '".$_SESSION['o_region']."'  AND `despatch_status` = 'Sent' AND date(`datetime`) = '$date'";

                                    }elseif ($_SESSION['role'] == 'RM') {

                                       $sql="SELECT * FROM `despatch` WHERE `region_to` = '".$_SESSION['o_region']."' AND `despatch_status` = 'Sent' AND date(`datetime`) = '$date'";

                                    }else {

                                       $sql="SELECT * FROM `despatch` WHERE `despatch_status` = 'Sent' AND date(`datetime`) = '$date'";

                                    }
                                    
                  if ($result=mysqli_query($conn,$sql))
                    {
                    // Return the number of rows in result set
                    $rowcount=mysqli_num_rows($result);
                    printf($rowcount);
                    // Free result set
                    mysqli_free_result($result);
                    }
                   ?>
                                    
                                     </h3>
                                     
                                        <a href="despatch_in.php?em_id=<?php echo base64_encode($_SESSION['em_id'])?>" class="text-muted m-b-0">Total Despatch In</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                     <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="assets/images/sent.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                
                                    
                                    if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

                                      $sql="SELECT * FROM `despatch` WHERE `region_from` = '".$_SESSION['o_region']."' AND `branch_from` = '".$_SESSION['o_branch']."' AND `despatch_status` = 'Sent' AND date(`datetime`) = '$date'";

                                    }elseif ($_SESSION['role'] == 'RM') {

                                       $sql="SELECT * FROM `despatch` WHERE `region_from` = '".$_SESSION['o_region']."' AND `despatch_status` = 'Sent' AND date(`datetime`) = '$date'";

                                    }else {

                                       $sql="SELECT * FROM `despatch` WHERE `despatch_status` = 'Sent' AND date(`datetime`) = '$date'";

                                    }
                                    
                  if ($result=mysqli_query($conn,$sql))
                    {
                    // Return the number of rows in result set
                    $rowcount=mysqli_num_rows($result);
                    printf($rowcount);
                    // Free result set
                    mysqli_free_result($result);
                    }
                   ?>
                                    
                                     </h3>
                                     
                                        <a href="despatch_out.php?em_id=<?php echo base64_encode($_SESSION['em_id'])?>" class="text-muted m-b-0">Total Despatch Out</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="assets/images/receiving.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                    <?php 
                   //echo $ems;
                                    $date = date('Y-m-d');
                                    if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

                                      $sql="SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
                  INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                  WHERE `transactions`.`office_name`= 'Back'  AND `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'";

                                    }elseif ($_SESSION['role'] == 'RM') {

                                      $sql="SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
                  INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                  WHERE `transactions`.`office_name`= 'Back'  AND `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region'";

                                    }else {

                                      $sql="SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
                  INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                  WHERE `transactions`.`office_name`= 'Back'  AND `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND date(`sender_info`.`date_registered`) = '$date'";

                                    }
                                    
                  if ($result=mysqli_query($conn,$sql))
                    {
                    // Return the number of rows in result set
                    $rowcount=mysqli_num_rows($result);
                    printf($rowcount);
                    // Free result set
                    mysqli_free_result($result);
                    }
                   ?>
                                     </h3>
                                     
                                        <a href="index.php?em_id=<?php echo base64_encode($_SESSION['em_id'])?>" class="text-muted m-b-0">Total Item from Counter</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Column -->
                   <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round align-self-center round-warning"><img src="assets/images/bag.png" width="40"></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0">                                    
                                   <?php 
                
                                    $date = date('Y-m-d');
                                    if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

                                      $sql="SELECT * FROM `bags` WHERE `bag_region` = '".$_SESSION['o_region']."' AND `bag_branch` = '".$_SESSION['o_branch']."' AND `bags_status` = 'notDespatch' AND date(`date_created`) = '$date'";

                                    }elseif ($_SESSION['role'] == 'RM') {

                                       $sql="SELECT * FROM `bags` WHERE `bag_region` = '".$_SESSION['o_region']."' AND `bags_status` = 'notDespatch' AND date(`date_created`) = '$date'";

                                    }else {

                                       $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch' AND date(`date_created`) = '$date'";

                                    }
                                    
                  if ($result=mysqli_query($conn,$sql))
                    {
                    // Return the number of rows in result set
                    $rowcount=mysqli_num_rows($result);
                    printf($rowcount);
                    // Free result set
                    mysqli_free_result($result);
                    }
                   ?>
                                     </h3>
                                     
                                        <a href="bags_list_item.php?em_id=<?php echo base64_encode($emid);?>&&ask=Despatch" class="text-muted m-b-0">Total Bags</a>
                                 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                           <div class="col-md-12">

                           </div> 
                        
                        </div>
                        <hr/>
                         <div class="row">
                        <div class="col-md-12">
                          <form action="bags_list_item.php?em_id=<?php echo base64_encode($emid);?>&&ask=Search" method="POST">

                            <table class="table table-bordered" style="width: 100%;">
                            	<thead>
                                <tr>
                                    <th style="">
                                     <div class="input-group">
                                        <input type="text" name="date" class="form-control  mydatetimepickerFull">
                                        
                                    <input type="text" name="month" class="form-control  mydatetimepicker month2">
                                    
                                      <select class="form-control custom-select" required="" name="region" style="height: 45px;">
                                        <option value="">--Select Region--</option>
                                        <?php 
                        $sql = "SELECT * FROM em_region ";
                        
                        $result = $conn2->query($sql);
                        ?>

                             <?php  if ($result->num_rows > 0) {?>
                          // output data of each row
                          <?php while($row = $result->fetch_assoc()) {?>
                            <option><?php echo $row['region_name']; ?></option>
                            <?php } } ?>
                                      </select>
                                    <?php if($_SESSION['role'] == 'RM'){?>
                                      <select class="form-control custom-select" style="height: 45px;" required="" name="branch" style="height: 45px;">
                                        <option value="">--Select Branch--</option>
                                        <?php 
                        $sql = "SELECT `em_region`.*,`em_branch`.* FROM `em_region` 
                        INNER JOIN `em_branch` ON `em_branch`.`region_id` = `em_region`.`region_id`
                         WHERE `em_region`.`region_name` = '$o_region'";
                        
                        $result = $conn2->query($sql);
                        ?>

                             <?php  if ($result->num_rows > 0) {?>
                          // output data of each row
                          <?php while($row = $result->fetch_assoc()) {?>
                            <option><?php echo $row['branch_name']?></option>
                            <?php } } ?>
                                      </select>
                                    <?php } ?>
                                    <button type="submit" class="btn btn-success">Search Month</button>

                                </div>
                            </th>
                        </tr>
                        </table>

                    </form>
                </div>
            </div>
                       
                         <div class="table-responsive" style="">
                          <?php if(!empty($warning)){ ?>
                            <div class="alert alert-warning alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Warning!</strong> <?php echo @$warning; ?>.
                          </div>
                            <?php }if(!empty($_SESSION['success'])){?>
                              <div class="alert alert-success alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Success!</strong> <?php echo @$_SESSION['success']; ?>.
                            </div>
                            <?php } ?>
           <form method="POST" action="bags_list_item.php?em_id=<?php echo base64_encode($emid);?>&&ask=Despatch">
                             <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Number</th>
                            <th>Created Date</th>
                            <th>Origion</th>
                            <th>Destination</th>
                            <!-- <th>Total Item Number</th> -->
                            <th>Weight</th>
                            <th>Status</th>
                            <th>
                            <div class="form-check" style="padding-left: 53px;" id="showCheck">
                            <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                            <label class="form-check-label" for="remember-me">Select All</label>
                             </div>
                           </th> 
             
                         </tr>
                       </thead>
                          
                		<tbody>
                      <?php

                              if (@$_GET['ask'] == "Search") {

                                @$date1 = $_POST['date'];
                                @$month = $_POST['month'];
                                @$region = $_POST['region'];
                                @$_SESSION['region'] = $region;

                                $m = explode('-', $month);
                                 $day = @$m[0];
                                 $year = @$m[1];

                                if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

                                      $sql="SELECT * FROM `bags` WHERE `bag_region` = '".$_SESSION['o_region']."' AND `bag_branch` = '".$_SESSION['o_branch']."' AND `bags_status` = 'notDespatch'";

                                      if (!empty($date1) && !empty($region)) {
                                         $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch' AND date(`date_created`) = '$date1' AND `bag_region` = '$region' AND `bag_region_from` = '$o_region' AND `bag_branch_from` = '$o_branch' ORDER BY `bag_id` DESC";
                                       } elseif(!empty($month) && !empty($region)){
                                        $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'  AND `bag_region_from` = '$o_region' AND `bag_branch_from` = '$o_branch' AND MONTH(`date_created`) = '$day' AND YEAR(`date_created`) = '$year' ORDER BY `bag_id` DESC";
                                       }elseif(!empty($region)){
                                        $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'  AND `bag_region` = '$region' ORDER BY `bag_id` DESC";
                                       }else {
                                         $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch' AND `bag_region_from` = '$o_region' ORDER BY `bag_id` DESC";
                                       }

                                    }elseif ($_SESSION['role'] == 'RM') {


                                       if (!empty($date1) && !empty($region)) {
                                         $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch' AND date(`date_created`) = '$date1' AND `bag_region` = '$region' AND `bag_region_from` = '$o_region' ORDER BY `bag_id` DESC";
                                       } elseif(!empty($month) && !empty($region)){
                                          $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'  AND `bag_region` = '$region' AND MONTH(`date_created`) = '$day'  AND YEAR(`date_created`) = '$year' AND `bag_region_from` = '$o_region' ORDER BY `bag_id` DESC";
                                       }elseif(!empty($region)){
                                        $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'  AND `bag_region` = '$region' ORDER BY `bag_id` DESC";
                                       }else {
                                         $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch' AND `bag_region_from` = '$o_region' ORDER BY `bag_id` DESC";
                                       }

                                    }else {

                                       if (!empty($date1) && !empty($region)) {
                                         $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch' AND date(`date_created`) = '$date1' AND `bag_region` = '$region' ORDER BY `bag_id` DESC";
                                       } elseif(!empty($month) && !empty($region)){
                                        $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'  AND `bag_region` = '$region' AND MONTH(`date_created`) = '$day' AND YEAR(`date_created`) = '$year' ORDER BY `bag_id` DESC";
                                       }elseif(!empty($region)){
                                        $sql="SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'  AND `bag_region` = '$region' ORDER BY `bag_id` DESC";
                                       }else {
                                         $sql="SELECT `bag_id`,`bag_number`,`bag_region_from`,`date_created`,`bag_region`,`bag_weight`,`bags_status` FROM `bags` WHERE `bags_status` = 'notDespatch' AND date(`date_created`) = '$date' ORDER BY `bag_id`  DESC";
                                       }
                                    }


                              } elseif(@$_GET['ask'] == "Despatch") {

                                    $date = date('Y-m-d');
                                    $region_to = @$_POST['region'];
                                    @$_POST['transport_type'];
                                    @$_POST['transport_name'];
                                    @$_POST['reg_no'];
                                    @$_POST['transport_cost'];
                                    $bag_id = @$_POST['I'];

                                    if (empty(@$_POST['I'])) {
                                      # code...
                                    } else {
                                      $sqls = "SELECT * FROM `em_region` WHERE `region_name` = '$o_region'";
                                    $results = $conn2->query($sqls);
                                     //if ($result->num_rows > 0){
                                    $src = $results->fetch_assoc() ;
                                    $source = $src['reg_code'];

                                    $sqlss = "SELECT * FROM `em_region` WHERE `region_name` = '$region_to'";
                                    $resultss = $conn2->query($sqlss);
                                     //if ($result->num_rows > 0){
                                    $dst = $resultss->fetch_assoc() ;
                                    $dest = $dst['reg_code'];

                                    $rondom = substr(date('dHis'), 1);
                                    $billcode = '07';//bag code in tracking number
                                    @$despatchNo = $source.$dest.$billcode.$rondom;
                                    $status = "Sent";
                                    $domestic = "Domestic";

                                    $sqlsave = "INSERT INTO `despatch`(`desp_no`, `datetime`, `bag_no`, `region_from`, `branch_from`, `region_to`, `branch_to`, `transport_type`, `transport_name`, `registration_number`, `transport_cost`, `despatch_status`, `despatch_by`, `received_by`, `despatch_type`) VALUES ('".$despatchNo."','".date("Y-m-d h:i")."','','".$o_region."','".$o_branch."','".$region_to."','','".$_POST['transport_type']."','".$_POST['transport_name']."','".$_POST['reg_no']."','".$_POST['transport_cost']."','".$status."','".$_SESSION['em_id']."','','".$domestic."')";
                                     $conn->query($sqlsave);
                                     $bag_status = "isDespatch";
                                     for ($i=0; $i <@sizeof($bag_id) ; $i++){
                                        $cid = $bag_id[$i];

                                        $sqlup = "UPDATE `bags` SET `bags_status`='".$bag_status."',`despatch_no` = '".$despatchNo."'  WHERE `bag_id`='".$cid."'";
                                        $conn->query($sqlup);

                                     }
                                     echo 'Successfully Bag Despatch';
                                     
                                     // if ($conn->query($sqlsave) === TRUE) {
                                     //    echo "New record created successfully";
                                     //  } else {
                                     //    echo "Error: " . $sqlsave . "<br>" . $conn->error;
                                     //  }
                                    }
                                    
                                    if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

                                      $sql="SELECT * FROM `bags` WHERE `bag_region_from` = '$o_region' AND `bag_branch_from` = '$o_branch' AND `bags_status` = 'notDespatch'";

                                    }elseif ($_SESSION['role'] == 'RM') {

                                       $sql="SELECT * FROM `bags` WHERE `bag_region_from` = '$o_region' AND `bags_status` = 'notDespatch' ORDER BY `bag_id` DESC";

                                    }else {

                                       $sql="SELECT `bag_id`,`bag_number`,`bag_region_from`,`date_created`,`bag_region`,`bag_weight`,`bags_status` FROM `bags` WHERE `bags_status` = 'notDespatch' AND date(`date_created`) = '$date' ORDER BY `bag_id`  DESC";

                                    }
                              }
                              
                			
                              $result = $conn->query($sql);
                              ?>

                                   <?php  if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {?>
                                <tr>
                                  <td><?php echo $row["bag_number"];?></td>
                                  <td><?php echo $row["date_created"];?></td>
                                  <td><?php echo $row["bag_region_from"];?></td>
                                  <td><?php echo $row["bag_region"];?></td>
                                  <!-- <td> -->
                                    <!-- <?php 
                                    $sqla="SELECT * FROM `transactions` WHERE `isBagNo` = '".$row["bag_number"]."'";
                                if ($results=mysqli_query($conn,$sqla))
                                  {
                                  // Return the number of rows in result set
                                  $rowcount=mysqli_num_rows($results);
                                  printf($rowcount);
                                  // Free result set
                                  mysqli_free_result($results);
                                  }
                                  ?> -->
                                  <!-- </td> -->
                                  <td><?php echo $row["bag_weight"];?></td>
                                  <td><?php echo $row["bags_status"];?></td>
                                  
                                    <td style="padding-left:  65px;"><div class='form-check'>
                            
                             <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $row["bag_id"] ?>'>
                             <label class='form-check-label' for='remember-me'></label>
                         
                        </div> 
                            
                      </td>
                      </tr>         
                    <?php  }  }?>   

                		</tbody>
                		
                  		</table>

                  
        </div>
        <br><br>
        <?php if(@$_GET['ask'] == "Search"){ ?>
        <div class="row" style="padding-left: 10px;padding-right: 35px; text-align: left;">
        
                    <input type="hidden" name="region" class="form-control" value="<?php echo $_SESSION['region']; ?>">
                  
                 <div class="col-md-3">
                    <label>Transport Type</label>
                    <select name="transport_type" class="form-control custom-select type" onChange="transportType()">
                      <option>Office Truck</option>
                      <option>Public Truck</option>
                      <option>Public Buses</option>
                      <option>Sea Transport</option>
                      <option>Railway Transport</option>
                      <option>Air Transport</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label>Transport Name</label>
                    <input type="text" name="transport_name" class="form-control" >
                  </div>
                  <div class="col-md-3">
                    <label>Rigistration Number</label>
                    <input type="text" name="reg_no" class="form-control">
                  </div>
                  <div class="col-md-3 cost">
                    <label>Transport Cost</label>
                    <input type="text" name="transport_cost" class="form-control" >
                  </div>
                </div>
                <br>
                <div class="row" style="padding-left: 10px;padding-right: 35px;">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-info">Despatch Bags</button>
                  </div>
                </div>
              <?php } ?>
              </form>
                      </div>
                      </div>
                      </div>

                            </div>
                            <!-- ============================================================== -->
                          </div> 
 <script type="text/javascript">
$(document).ready(function() {
  
    var table = $('#example4').DataTable( {
        //orderCellsTop: true,
        fixedHeader: true,
        ordering: false,
        order: [[1,"desc" ]],
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "All"]],
        dom: 'lBfrtip',
        buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
        ]
      } );
  } );
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#checkAlls").change(function() {
      if (this.checked) {
        $(".checkSingles").each(function() {
          this.checked=true;
        });
      } else {
        $(".checkSingles").each(function() {
          this.checked=false;
        });
      }
    });

    $(".checkSingles").click(function () {
      if ($(this).is(":checked")) {
        var isAllChecked = 0;

        $(".checkSingles").each(function() {
          if (!this.checked)
            isAllChecked = 1;
        });

        if (isAllChecked == 0) {
          $("#checkAlls").prop("checked", true);
        }     
      }
      else {
        $("#checkAlls").prop("checked", false);
      }
    });
  });
</script>
<?php include('footer.php'); ?>