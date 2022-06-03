<?php
class Delivery_Model extends CI_Model{

public function get_single_mail_virtuebox($empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM sender_person_info  
INNER JOIN  receiver_register_info ON receiver_register_info.sender_id=sender_person_info.senderp_id
INNER JOIN  register_transactions  ON sender_person_info.senderp_id=register_transactions.register_id
INNER JOIN waiting_for_delivery ON waiting_for_delivery.senderid=sender_person_info.senderp_id
WHERE waiting_for_delivery.empid='$empid' AND waiting_for_delivery.status=1 AND waiting_for_delivery.wfd_type='single' AND waiting_for_delivery.service_type='mail'";
$query  = $db2->query($sql);
$result = $query->result();
return $result;
}

//check barcode number on waiting for deliverydate
public function track_waiting_info($barcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM waiting_for_delivery where barcode='$barcode'";
$query  = $db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function search_mail_bulk($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
        INNER JOIN  receiver_register_info ON  receiver_register_info.sender_id=sender_person_info.senderp_id
        INNER JOIN  register_transactions  ON   sender_person_info.senderp_id=register_transactions.register_id
	WHERE register_transactions.Barcode='$barcode'";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}

/*public function get_delivery_full_information($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
        INNER JOIN  receiver_register_info ON  receiver_register_info.sender_id=sender_person_info.senderp_id
        INNER JOIN  register_transactions  ON   sender_person_info.senderp_id=register_transactions.register_id
	WHERE register_transactions.Barcode='$barcode'";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}*/

public function get_delivery_full_information($senderid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM assign_derivery WHERE item_id='$senderid' AND d_status='Yes'";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}

public function check_bulk_callnote_information($barcode){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bulk_callnote WHERE barcode='$barcode'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
}

public function get_mail_info($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
        INNER JOIN  receiver_register_info ON  receiver_register_info.sender_id=sender_person_info.senderp_id
        INNER JOIN  register_transactions  ON   sender_person_info.senderp_id=register_transactions.register_id
	WHERE register_transactions.Barcode='$barcode'";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}

public function get_group_barcode_items($groupid){
    $db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bulk_callnote WHERE callnote_groupid='$groupid'";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
}

public function mail_check_barcode($code){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM register_transactions where Barcode='$code'";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}

public function delete_virtue_box($delete){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "DELETE FROM waiting_for_delivery where wfd_id='$delete'";
	$query  = $db2->query($sql);
	return $query;
}

///DELIVERY MAILS PART
public function add_delivery_info($senderid,$empid,$name,$phone,$identity,$identityno,$deliverydate){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "insert into assign_derivery (em_id,item_id,deliverer_name,phone,identity,identityno,d_status,operator,image,service_type,location,deriveryDate) 
	values('$empid','$senderid','$name','$phone','$identity','$identityno','Yes','$empid','','POS','','$deliverydate')";
	$query  = $db2->query($sql);
	return $query;
}

public function insert_delivery_information($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('assign_derivery', $data);
}

public function Update_delivery_information($UpdateDelivery,$senderid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('senderp_id', $senderid);
$db2->update('sender_person_info', $UpdateDelivery);
}

public function update_mail_sender_info_status($senderid){
	$db2 = $this->load->database('otherdb', TRUE);
    $sql = "UPDATE sender_person_info SET sender_status='Derivery' WHERE senderp_id='$senderid'";
	$query  = $db2->query($sql);
	return $query;	
}

public function update_mail_virtuebox_status($wfdi){
	$db2 = $this->load->database('otherdb', TRUE);
    $sql = "UPDATE waiting_for_delivery SET status=0 WHERE wfd_id='$wfdi'";
	$query  = $db2->query($sql);
	return $query;	
}
//END OF MAILS DELIVERY PART

}