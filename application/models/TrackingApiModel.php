<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TrackingApiModel extends CI_Model 
{
	
//Get Employee ID
public function get_email_id($emid){
	$sql = "select * from employee where em_email='$emid'";
	$query=$this->db->query($sql);
	$result = $query->row();
	return $result;
}

public function get_em_details_id($emid){
	$sql = "select * from employee where em_id='$emid'";
	$query=$this->db->query($sql);
	$result = $query->row();
	return $result;
}


///Get delivery items
public function get_delivery_items($empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql ="SELECT * FROM waiting_for_delivery WHERE empid='$empid' AND status=1 AND assigned_status='received'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_single_delivery_items($empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql ="SELECT * FROM waiting_for_delivery WHERE empid='$empid' AND status=1 AND assigned_status='received' AND wfd_type='single'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}


public function get_group_delivery_items($empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql ="SELECT * FROM virtuedelivery_group WHERE virtuedelivery_group_created_by='$empid' AND virtuedelivery_status=1";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function count_group_delivery_items($groupid){
$db2 = $this->load->database('otherdb', TRUE);
$sql ="SELECT * FROM waiting_for_delivery WHERE groupid='$groupid'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}


////////EMS information
public function get_ems_information($barcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM sender_info
INNER JOIN receiver_info ON sender_info.sender_id=receiver_info.from_id 
INNER JOIN transactions ON transactions.CustomerID=sender_info.sender_id
WHERE transactions.Barcode='$barcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_transid_information($barcode,$transtype){
$db2 = $this->load->database('otherdb', TRUE);
if($transtype=='ems'){
$sql = "SELECT id as transid FROM `transactions` WHERE `Barcode` ='$barcode'";
} else {
$sql = "SELECT t_id as transid FROM `register_transactions` WHERE `Barcode` ='$barcode'";
}
$query=$db2->query($sql);
$result = $query->row();
return $result;
}


public function get_mails_information($barcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON  receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON   sender_person_info.senderp_id=register_transactions.register_id
	WHERE register_transactions.Barcode='$barcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}


///////////////
public function get_ems_virtuebox($barcode){
   $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_info
    INNER JOIN receiver_info ON sender_info.sender_id=receiver_info.from_id 
	INNER JOIN transactions ON transactions.CustomerID=sender_info.sender_id
	INNER JOIN waiting_for_delivery ON waiting_for_delivery.senderid=sender_info.sender_id
	WHERE waiting_for_delivery.barcode='$barcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}




///////////////
public function get_group_virtuebox($groupid){
	$db2 = $this->load->database('otherdb', TRUE);
	 $sql = "SELECT virtuedelivery_group_id,virtuedelivery_group_name,Count(waiting_for_delivery.barcode) as items FROM virtuedelivery_group
	 INNER JOIN waiting_for_delivery ON waiting_for_delivery.groupid=virtuedelivery_group.virtuedelivery_group_id
	 WHERE virtuedelivery_group.virtuedelivery_group_id='$groupid'";
 $query=$db2->query($sql);
 $result = $query->row();
 return $result;
 }

 
public function get_mail_virtuebox($barcode){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON sender_person_info.senderp_id=register_transactions.register_id
	INNER JOIN waiting_for_delivery ON waiting_for_delivery.senderid=sender_person_info.senderp_id
	WHERE waiting_for_delivery.barcode='$barcode'";
	$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function update_received_status_information($data,$barcode){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('barcode', $barcode);
$db2->update('waiting_for_delivery',$data);    
}

public function save_tracing($tracingData){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('tracing',$tracingData); 
}

public function get_verification_barcode_user($barcode,$empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM waiting_for_delivery WHERE barcode='$barcode' AND empid='$empid' AND receive_status='NotReceived'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_verification_barcode_user_received($barcode,$empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM waiting_for_delivery WHERE barcode='$barcode' AND empid='$empid' AND receive_status='Received'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

// INSERT GROUP
public function add_delivery_group($groupname,$empid,$groupno){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "insert into virtuedelivery_group (virtuedelivery_group_name,virtuedelivery_group_created_by,groupno,grouptype) 
	values('$groupname','$empid','$groupno','custom')";
	$query = $db2->query($sql);
	return $query;
}

//RETRIEVE GROUP ID
public function retrieve_delivery_group($groupno){
	$db2 = $this->load->database('otherdb', TRUE);
    $sql = "SELECT * FROM virtuedelivery_group WHERE groupno='$groupno'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;	
}

public function update_barcode_status_information($data,$barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('barcode', $barcode);
	$db2->update('waiting_for_delivery',$data);    
	}

	//Insert Delivery Information
public function add_delivery_info($senderid,$empid,$name,$phone,$identity,$identityno,$deliverydate,$image){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "insert into assign_derivery (em_id,item_id,deliverer_name,phone,identity,identityno,d_status,operator,image,service_type,location,deriveryDate) 
	values('$empid','$senderid','$name','$phone','$identity','$identityno','Yes','$empid','$image','POS','','$deliverydate')";
	$query = $db2->query($sql);
	return $query;
}



public function get_waiting_for_delivery($wfd_id){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM waiting_for_delivery WHERE wfd_id='$wfd_id'";
	$query=$db2->query($sql);
	$result = $query->row();
	return $result;
	}

	
public function get_Group_waiting_for_delivery($groupid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM waiting_for_delivery WHERE groupid='$groupid'";
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
	}

	
public function update_ems_sender_information($data,$sender_id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('sender_id', $sender_id);
	$db2->update('sender_info',$data);    
	}

	
public function update_mail_sender_information($data,$sender_id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('senderp_id', $sender_id);
	$db2->update('sender_person_info',$data);    
	}



///////////////////////////////////////MCT INTEGRATION

public function get_ems_barcode_full_details($barcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM sender_info
INNER JOIN receiver_info ON sender_info.sender_id=receiver_info.from_id 
INNER JOIN transactions ON transactions.CustomerID=sender_info.sender_id
WHERE transactions.Barcode='$barcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_ems_barcode_full_details_transactions($barcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM transactions WHERE Barcode='$barcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_ems_barcode_delivery_full_information($sender_id){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM assign_derivery WHERE item_id='$sender_id' AND d_status='Yes'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_full_barcode_tracing_information($transid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM tracing where transid='$transid' and type=0 and trans_type='' and status IN('Acceptance','IN','Received counter','RECEIVE','BAG','BAG receive','Delivered','Delivery')";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

//////////////////////////////


}
