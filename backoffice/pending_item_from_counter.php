
<?php include('connection.php'); ?>
<?php  $emid = base64_decode($_GET['em_id']);

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
	


   
    if (empty($_POST['receive'])) {
      # code...
    } else {

       $id = @$_POST['I'];
          if (empty($id)) {
           $warning =  "Please Select Atleast One Item";
          } else {
            for ($i=0; $i <@sizeof($id) ; $i++){
               $id[$i];

            $sql = 'UPDATE `transactions`
            SET `office_name`="Received"
            WHERE `id`= "'.$id[$i].'"';
            $retval = $conn->query($sql);
            
             if(! $retval ) {
                die('Could not update data: ' . mysql_error());
             }
             $success =  "Successfully Received";

            }
          }
    }

$date = date('Y-m-d');
    
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
                          <form action="search_item.php?em_id=<?php echo base64_encode($emid);?>&&ask=Pending" method="POST">

                            <table class="table table-bordered" style="width: 100%;">
                            	<thead>
                                <tr>
                                    <th style="">
                                     <div class="input-group">
                                        <input type="text" name="date" class="form-control  mydatetimepickerFull">
                                        
                                    <input type="text" name="month" class="form-control  mydatetimepicker month2">
                                    <?php if ($_SESSION['role'] == 'ADMIN') { ?>
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
                                    <?php }elseif($_SESSION['role'] == 'RM'){?>
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
                            <?php }if(!empty($success)){?>
                              <div class="alert alert-success alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Success!</strong> <?php echo @$success; ?>.
                            </div>
                            <?php } ?>
           <form method="POST" action="pending_item_from_counter.php?em_id=<?php echo base64_encode($_SESSION['em_id'])?>">
                             <table id="example4" class="display nowrap table table-hover  table-bordered" cellspacing="0" width="100%" style="text-transform: capitalize;">
                              <thead>
							  
                             <tr>
                              <th>Sender Name</th>
                              <th>Date Registered</th>
                              <th>Region Origin</th>
                              <th>Destination</th>
                              <th>Tracking Number</th>
                              <th>Status</th>
                              <th><div class="form-check" style="padding-left: 53px;" id="showCheck">
                                   <input type="checkbox"  class="form-check-input" id="checkAlls" style="">
                                   <label class="form-check-label" for="remember-me">Select All</label>
                                 </div></th>
                              
                            </tr>
                          </thead>
                          
                		<tbody>
                			<?php include_once('pending_item_from_counter_action.php'); ?>
                		</tbody>
                		<tfoot>
                			<tr>
                				<td colspan="6"></td>
                				<td colspan=""><button class="btn btn-success form-control" style="color: white;" name="receive" value="receive">Receive Item</button></td>
                			</tr>
                		</tfoot>
                  		</table>

                  </form>
        </div>
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
        lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100,500, "All"]],
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