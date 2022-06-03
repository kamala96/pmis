<?php 

 
include('connection.php');

 $date = date('Y-m-d');
 $o_region = $_SESSION['o_region'];
 $o_branch = $_SESSION['o_branch'];

if ($_SESSION['role'] == 'EMPLOYEE' || $_SESSION['role'] == 'AGENT' || $_SESSION['role'] == 'SUPERVISOR') {

$sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`track_number`,`receiver_info`.`r_region`,`transactions`.`office_name`,`bag_status`,`id`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag'  AND `sender_info`.`s_district` = '$o_branch' AND date(`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

}elseif($_SESSION['role'] == 'RM'){

	$sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`track_number`,`receiver_info`.`r_region`,`transactions`.`office_name`,`bag_status`,`id`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag'  AND `sender_info`.`s_region` = '$o_region'  AND date(`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";
}else{

	$sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`track_number`,`receiver_info`.`r_region`,`transactions`.`office_name`,`bag_status`,`id`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";
}
$result = $conn->query($sql);
?>

     <?php  if ($result->num_rows > 0) {
	// output data of each row
	while($row = $result->fetch_assoc()) {?>
	<tr>
		<td width="50px;"><?php echo $row["s_fullname"];?></td>
		<td><?php echo $row["date_registered"];?></td>
		<td><?php echo $row["s_region"];?></td>
		<td><?php echo $row["r_region"];?></td>
		<td><?php echo $row["track_number"];?></td>
		<td>
                              <?php if ($row["office_name"] == 'Back' && $row["bag_status"] == 'isNotBag') {?>
                                <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Comming From Counter</button>
                              <?php }elseif($row["office_name"] == 'Received' && $row["bag_status"] == 'isNotBag'){ ?>
                                <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Item Received</button>
                              <?php }elseif($row["office_name"] == 'Back' && $row["bag_status"] == 'isBag'){ ?>
                                <button type="button" class="btn  btn-warning btn-sm" disabled="disabled">Is In Bag <?php ?></button>
                              <?php }elseif($row["office_name"] == 'Received' && $row["bag_status"] == 'isBag'){ ?>
                                <button type="button" class="btn  btn-success btn-sm" disabled="disabled">Item Received</button>
                              <?php }?>

                            </td>
                          <td style="padding-left:  65px;"><div class='form-check'>
                            <?php if ($row["office_name"] == 'Back' && $row["bag_status"] == 'isNotBag') {?>
                             
                             <input type='checkbox' name='I[]' class='form-check-input checkSingles' id='remember-me' value='<?php echo $row["id"] ?>'>
                             <label class='form-check-label' for='remember-me'></label>
                           <?php }elseif($row["office_name"] == 'Received' && $row["bag_status"] == 'isNotBag'){ ?>
                            <input type="checkbox" class='form-check-input' checked disabled="disabled">
                             <?php }elseif($row["office_name"] == 'Received' && $row["bag_status"] == 'isBag'){ ?>
                            <input type="checkbox" class='form-check-input' checked disabled="disabled">
                          <?php }?>

                        </div> 
                      </td>
	</tr>			    
<?php  }	}?>   
