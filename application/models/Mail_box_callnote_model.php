<?php

class Mail_box_callnote_model extends CI_Model{
	
	public function get_mail_bulk_callnote(){
	$empid =  $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON sender_person_info.senderp_id=register_transactions.register_id
	INNER JOIN bulk_callnote ON bulk_callnote.callnote_senderid=sender_person_info.senderp_id
	WHERE bulk_callnote.empid='$empid' AND bulk_callnote.callnote_type='pending' AND bulk_callnote.callnote_service='mails'";
	$query  = $db2->query($sql);
    $result = $query->result();
    return $result;
    }
	
	public function print_group_bulk_callnote($groupid){
	$empid =  $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON sender_person_info.senderp_id=register_transactions.register_id
	INNER JOIN bulk_callnote ON bulk_callnote.callnote_senderid=sender_person_info.senderp_id
	WHERE bulk_callnote.empid='$empid' AND bulk_callnote.callnote_type='bulk' AND bulk_callnote.callnote_service='mails' AND bulk_callnote.callnote_groupid='$groupid'";
	$query  = $db2->query($sql);
    $result = $query->result();
    return $result;
    }
	
    public function receipient_group_bulk_callnote($groupid){
	$empid =  $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON sender_person_info.senderp_id=register_transactions.register_id
	INNER JOIN bulk_callnote ON bulk_callnote.callnote_senderid=sender_person_info.senderp_id
	WHERE bulk_callnote.empid='$empid' AND bulk_callnote.callnote_type='bulk' AND bulk_callnote.callnote_service='mails' AND bulk_callnote.callnote_groupid='$groupid'";
	$query  = $db2->query($sql);
    $result = $query->row();
    return $result;
    }
	
	public function track_waiting_info($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bulk_callnote where barcode='$barcode'";
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }
	
	public function get_group_bulk_callnote(){
	$empid =  $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bulk_callnote_group where empid='$empid' ORDER BY callnote_groupid DESC";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    }
	
	public function count_group_bulk_callnote_items($groupid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bulk_callnote where callnote_groupid='$groupid'";
	$query = $db2->query($sql);
	$result = $query->num_rows();
	return $result;
    }//status
	
    public function search_mail_bulk($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON  receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON   sender_person_info.senderp_id=register_transactions.register_id
	WHERE register_transactions.Barcode='$barcode'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    }

    public function search_mail_bulk_paid($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM sender_person_info  
    INNER JOIN  receiver_register_info ON  receiver_register_info.sender_id=sender_person_info.senderp_id
    INNER JOIN  register_transactions  ON   sender_person_info.senderp_id=register_transactions.register_id
	WHERE register_transactions.Barcode='$barcode' AND register_transactions.status='Paid'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    } 
	
	public function get_callnote_groupid($groupno){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM bulk_callnote_group WHERE callnote_groupno='$groupno'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    } 

    public function get_callnote_byid($callnote_id){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `bulk_callnote` WHERE `callnote_id`='$callnote_id'";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    } 
    public function get_callnote_byBarcode($barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `bulk_callnote` WHERE `barcode`='$barcode' ORDER BY `callnote_id` DESC LIMIT 1";
	$query = $db2->query($sql);
	$result = $query->row();
	return $result;
    } 

     public function get_callnote_list($empid,$region,$branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `bulk_callnote` WHERE `empid`='$empid' AND `branch` = '$branch' 
	        AND `region`='$region' ORDER BY `callnote_id` DESC";
	$query = $db2->query($sql);
	$result = $query->result();
	return $result;
    } 

    	

    public function save_callnote($callnote){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('bulk_callnote',$callnote);
	}

	public function get_last_flpnumber($branch,$region,$counterletter){ //fplno
	 	$db2 = $this->load->database('otherdb', TRUE);
		  $sql= "SELECT * FROM `bulk_callnote` 
								  WHERE `branch` = '$branch' AND `region`='$region' AND `counter`='$counterletter' 
								  AND `callnote_type` != 'pending' AND `fplno` != ''
								   ORDER BY `callnote_id` DESC LIMIT 1";
				  $query  = $db2->query($sql);
				  $result = $query->row();
		  return $result;
		  } 

		  public function get_last_flpnumbers($branch,$region){ //fplno
	 	$db2 = $this->load->database('otherdb', TRUE);
		  $sql= "SELECT * FROM `bulk_callnote` 
								  WHERE `branch` = '$branch' AND `region`='$region' 
								  AND `callnote_type` != 'pending' AND `fplno` != ''
								   ORDER BY `callnote_id` DESC LIMIT 1";
				  $query  = $db2->query($sql);
				  $result = $query->row();
		  return $result;
		  } 

		  	public function getmailTracingCounter($barcode){
		$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT `register_transactions`.`t_id`,`tracing`.*
                   FROM   `tracing`  
                   INNER JOIN  `register_transactions`  ON   `tracing`.`transid`   = `register_transactions`.`t_id`  
                    WHERE `register_transactions`.`Barcode` = '$barcode' AND `tracing`.`status`='IN' 
                   ORDER BY `tracing`.`doc` DESC LIMIT 1";
		

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function getmailTracingCounterbylast_emid($emid){ //office_name
		$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT `register_transactions`.`t_id`,`tracing`.*
                   FROM   `tracing`  
                   INNER JOIN  `register_transactions`  ON   `tracing`.`transid`   = `register_transactions`.`t_id`  
                    WHERE `tracing`.`emid` = '$emid' AND `tracing`.`status`='IN' AND `tracing`.`office_name` LIKE '%Counter%' 
                   ORDER BY `tracing`.`doc` DESC LIMIT 1";
		

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	
	public function insert_callnote($empid,$barcode,$senderid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "INSERT INTO bulk_callnote (empid,barcode,callnote_senderid) VALUES('$empid','$barcode','$senderid')";
	$query = $db2->query($sql);
	return $query;
	}

	public function insert_callnotes($empid,$barcode,$senderid,$name,$address,$fplno){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "INSERT INTO bulk_callnote (empid,barcode,callnote_senderid,name,address,fplno) VALUES('$empid','$barcode','$senderid''$name','$address','$fplno')";
	$query = $db2->query($sql);
	return $query;
	}
	
    public function update_bulk_callnote($groupid,$senderid){//flpno
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "update `bulk_callnote` set `callnote_groupid`='$groupid', `callnote_type`='bulk' where `callnote_id`='$senderid'";
	$query = $db2->query($sql);
	return $query;
	}

	 public function update_bulk_callnotes($callnote_id,$data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('callnote_id',$callnote_id);
			$db2->update('bulk_callnote',$data);
		}
	
	public function update_printed_status($groupid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "update bulk_callnote_group set group_review='Printed' where callnote_groupid='$groupid'";
	$query = $db2->query($sql);
	return $query;
	}
	
	public function add_callnote_group($groupname,$empid,$groupno){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "INSERT INTO bulk_callnote_group (empid,callnote_groupname,callnote_groupno) VALUES('$empid','$groupname','$groupno')";
	$query = $db2->query($sql);
	return $query;
	}
	
	public function delete_callnote($delete){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "DELETE FROM bulk_callnote WHERE callnote_id='$delete'";
	$query = $db2->query($sql);
	return $query;
    }
	
	
	    
}
?>