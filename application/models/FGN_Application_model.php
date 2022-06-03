<?php

class FGN_Application_model extends CI_Model{
	
	public function outside_small_parcket(){
	$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM fgn_small_packet WHERE status = 'pending' AND FGN_category = 'outside' AND created_by='$empid'";
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
	}

	public function add_small_packet($value,$region,$branch){
    $empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "INSERT INTO fgn_small_packet (FGN_number,region,branch,created_by) VALUES ('$value','$region','$branch','$empid')";
	$query=$db2->query($sql);
	return $query;
	}

	public function save_small_packet($packet){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('fgn_small_packet',$packet);
		$insert_id = $db2->insert_id();
		return  $insert_id;
	}

	public function pending_small_parcket($emid,$rec_branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'pending' AND `branch` = '$rec_branch' AND `created_by`='$emid'";
	$query=$db2->query($sql);
	//$result = $query->result();
	$result = $query->result_array();
	return $result;

	
	}

	public function pending_small_parcket_byBarcode_pending($FGN_number){ 
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `FGN_number` = '$FGN_number' AND `status` = 'pending'";
	$query=$db2->query($sql);
	//$result = $query->result();
	$result = $query->result_array();
	return $result;

	
	}

	public function pending_small_parcket_byBarcode($FGN_number){ 
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `FGN_number` = '$FGN_number'";
	$query=$db2->query($sql);
	//$result = $query->result();
	$result = $query->result_array();
	return $result;

	
	}

	public function itemize_small_parcket($region,$branch,$barcode){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE (`status` = 'sent' OR `status` = 'Itemized' OR `status` ='received' ) AND `branch` = '$branch' AND `region`='$region' AND `FGN_number`='$barcode'";
	$query=$db2->query($sql);
	//$result = $query->result();
	$result = $query->result_array();
	return $result;

	
	}

	public function get_last_dpnumber($branch,$region){
	 	$db2 = $this->load->database('otherdb', TRUE);
		  $sql= "SELECT * FROM `fgn_small_packet` 
								  WHERE `status` = 'Itemized' AND `branch` = '$branch' AND `region`='$region'
								   ORDER BY `itemized_date` DESC LIMIT 1";
				  $query  = $db2->query($sql);
				  $result = $query->row();
		  return $result;
		  } 


		  public function get_Packet_byID($FGN_small_packet_id){
	 	$db2 = $this->load->database('otherdb', TRUE);
		  $sql= "SELECT * FROM `fgn_small_packet` 
								  WHERE `FGN_small_packet_id` = '$FGN_small_packet_id' LIMIT 1";
				  $query  = $db2->query($sql);
				  $result = $query->row();
		  return $result;
		  } 

		  public function get_Packet_byNo($FGN_number){
			$db2 = $this->load->database('otherdb', TRUE);
			 $sql= "SELECT * FROM `fgn_small_packet` 
									 WHERE `FGN_number` = '$FGN_number' LIMIT 1";
					 $query  = $db2->query($sql);
					 $result = $query->row();
			 return $result;
			 } 


			 public function get_Packet_Delivery($FGN_number){
				$db2 = $this->load->database('otherdb', TRUE);
				 $sql= "SELECT * FROM `fgn_small_packet` 
				   INNER JOIN  `derivery_info`  ON   `derivery_info`.`Barcode`   = `fgn_small_packet`.`FGN_number`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                   WHERE `fgn_small_packet`.`FGN_number` = '$FGN_number' LIMIT 1";
						 $query  = $db2->query($sql);
						 $result = $query->row();
				         return $result;
				 } 



	 public function update_itemize_small_parcket($FGN_small_packet_id,$data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('FGN_small_packet_id',$FGN_small_packet_id);
			$db2->update('fgn_small_packet',$data);
		}


	  public function Update_small_packet($emid,$rec_branch){
	  		$db2 = $this->load->database('otherdb', TRUE);
	  		 $db2->set('status','sent');
		$db2->where('branch', $rec_branch);
		$db2->where('created_by', $emid);
		$db2->where('status', 'pending');
		$db2->update('fgn_small_packet');         
    }


      public function Update_small_packet_despatch($emid,$rec_branch,$despno){
	  		$db2 = $this->load->database('otherdb', TRUE);
	  		 $db2->set('despno',$despno);
		$db2->where('branch', $rec_branch);
		$db2->where('created_by', $emid);
		$db2->where('status', 'pending');
		$db2->update('fgn_small_packet');         
    }

	public function pending_small_parcket_list($emid,$rec_branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'pending' AND `branch` = '$rec_branch' AND `created_by`='$emid'";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

	public function pending_small_parcket_list2($emid,$rec_branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet`
			INNER JOIN `fgndespatch` ON `fgndespatch`.`desp_no`=`fgn_small_packet`.`despno`
			 WHERE `status` = 'pending' AND `branch` = '$rec_branch' AND `created_by`='$emid'";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

	public function dispatched_small_parcket_list2($despno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `fgn_small_packet`
				INNER JOIN `fgndespatch` ON `fgndespatch`.`desp_no`=`fgn_small_packet`.`despno`
				 WHERE `desp_no` = '$despno' ";
		$query=$db2->query($sql);
		$result = $query->result();
		//$result = $query->result_array();
		return $result;
	
		
		}

		
	public function dispatched_label_list2($fromdate,$todate,$em_branch,$region){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `fgndespatch`
				 WHERE  `branch_from` = '$em_branch' 
		 AND `region_from`='$region'  AND  DATE(`despatch_date`) BETWEEN '$fromdate' AND '$todate' ";
		$query=$db2->query($sql);
		$result = $query->result();
		//$result = $query->result_array();
		return $result;
	
		
		}


		public function dispatched_label_listSingle($em_branch,$region,$emid){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT * FROM `fgndespatch`
					 WHERE  `branch_from` = '$em_branch' 
			 AND `region_from`='$region'  AND `despatch_by`='$emid' LIMIT 1";
			$query=$db2->query($sql);
			$result = $query->result();
			//$result = $query->result_array();
			return $result;
		
			
			}

			public function dispatched_label_listSingle_print($desp_no){
				$db2 = $this->load->database('otherdb', TRUE);
				$sql = "SELECT * FROM `fgndespatch`
						 WHERE  `desp_no` = '$desp_no' ";
				$query=$db2->query($sql);
				$result = $query->result();
				//$result = $query->result_array();
				return $result;
			
				
				}

	public function createfgnDespatchNumber($fromdistrict,$todistrict){
		$db2 = $this->load->database('otherdb', TRUE);

	  $sql = "select max(dc) as dc from fgndespatch where branch_from ='".trim($fromdistrict)."' and branch_to  = '".trim($todistrict)."'";

	  $query=$db2->query($sql);
		$result = $query->result_array();

		//$despatch_no = 'DESPATCH-EMS-'.strtoupper(trim($todistrict)).'-'.date("Ymd/").'0';
		$despatch_no = strtoupper(trim($fromdistrict)).'-'.strtoupper(trim($todistrict)).'-'.date("Ymd/").'0';

	  if($result) return array('num'=>$despatch_no .= $result[0]['dc'] +1,'dc'=>$result[0]['dc'] +1);
	  else return array('num'=>$despatch_no .= $result[0]['dc'],'dc'=>$result[0]['dc']);
	}

	public function save_fgndespatch_info($data){
	    //$db2 = $this->load->database('otherdb', TRUE);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('fgndespatch',$data);
	}



	public function sent_small_parcket_list($emid,$rec_branch){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'sent' AND `branch` = '$rec_branch' AND `created_by`='$emid'";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

		public function receive_small_parcket_list($region,$em_branch){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'sent' AND `branch` = '$em_branch' AND `region`='$region'";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

	public function passto_small_parcket_list($region,$em_branch){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPER ADMIN')  {
		$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'Itemized'  AND `region`='$region'";
	
    } else {

		$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'Itemized' AND `branch` = '$em_branch' AND `region`='$region'";
	}
	
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

	public function Dispatched_parcket_list($region,$em_branch){
		$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM `fgndespatch` WHERE  `branch_from` = '$em_branch' AND `region_from`='$region'
          ";
$query=$db2->query($sql);
$result = $query->result();
return $result;


}

	public function submitted_dispatched_small_parcket_list($region,$em_branch,$fromdate,$todate){
		$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);

$sql = "SELECT * FROM `fgndespatch` WHERE  `branch_from` = '$em_branch' 
		 AND `region_from`='$region'  AND  DATE(`despatch_date`) BETWEEN '$fromdate' AND '$todate' ";

$query=$db2->query($sql);
//$result = $query->result();
$result = $query->result_array();
return $result;


}


	public function submitted_itemized_small_parcket_list($region,$em_branch,$fromdate,$todate){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPER ADMIN')  {
		$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'Itemized' 
	         AND  DATE(`itemized_date`) BETWEEN '$fromdate' AND '$todate' ";
	
    } else {
		$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'Itemized' AND `branch` = '$em_branch' 
		AND `region`='$region'  AND  DATE(`itemized_date`) BETWEEN '$fromdate' AND '$todate' ";
	}

	

	$query=$db2->query($sql);
	//$result = $query->result();
	$result = $query->result_array();
	return $result;

	
	}

		public function Printed_itemized_small_parcket_list($region,$em_branch,$fromdate,$todate){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'Itemized' AND `branch` = '$em_branch' 
	         AND `region`='$region'  AND  DATE(`itemized_date`) BETWEEN '$fromdate' AND '$todate' ";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;
	
	}

	public function receive_small_parcket_array($region,$em_branch,$emid){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'received' AND `branch` = '$em_branch' AND `region`='$region' 
	        AND `received_by`='$emid'";
	$query=$db2->query($sql);
	//$result = $query->result();
	$result = $query->result_array();
	return $result;

	
	}

	public function small_parcket_array_byBarcode($FGN_number){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `FGN_number` = '$FGN_number' ";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

	public function small_parcket_array_byBarcode_unique($barcode,$region,$em_branch){
		$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM `fgn_small_packet` WHERE `FGN_number` = '$barcode'
		  AND `region_from` = '$region' AND `branch_from` = '$em_branch' ";
$query=$db2->query($sql);
$result = $query->result();
//$result = $query->result_array();
return $result;


}


	public function small_parcket_array_byBarcode2($FGN_number){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `FGN_number` = '$FGN_number' AND `status` = 'pending' ";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}


	public function get_small_parcket_passed_to($empid='',$FGN_number='',$status='',$office_name='',$pass_to_by=''){
			// $empid = $this->session->userdata('user_emid');
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `fgn_small_packet` WHERE  1=1 ";

		if ($empid) $sql.= " and `pass_to` = '$empid' ";
		if ($FGN_number) $sql.= " and `FGN_number` = '$FGN_number' ";
		if ($status) $sql.= " and `pass_to_status` = '$status' ";
		if ($office_name) $sql.= " and `office_name` = '$office_name' ";
		if ($pass_to_by) $sql.= " and `pass_to_by` = '$pass_to_by' ";

		//echo $sql;die();
		$query=$db2->query($sql);
		//$result = $query->result();
		$result = $query->result_array();
		return $result;
	}

	public function get_small_parcket_passed_to_date($empid='',$FGN_number='',$status='',$office_name='',$pass_to_by='',$fromdate="",$todate=""){
			// $empid = $this->session->userdata('user_emid');
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `fgn_small_packet` WHERE  1=1 ";

		if ($empid) $sql.= " and `pass_to` = '$empid' ";
		if ($FGN_number) $sql.= " and `FGN_number` = '$FGN_number' ";
		if ($status) $sql.= " and `pass_to_status` = '$status' ";
		if ($office_name) $sql.= " and `office_name` = '$office_name' ";
		if ($pass_to_by) $sql.= " and `pass_to_by` = '$pass_to_by' ";

		if (!empty($fromdate) && !empty($todate)) {
			$sql.= " and date(pass_to_date) between '$fromdate' and '$todate' ";
		}

		//echo $sql;die();
		$query=$db2->query($sql);
		//$result = $query->result();
		$result = $query->result_array();
		return $result;
	}

	public function get_new_international_senderperson_barcode($db,$trackno){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE  (`sender_person_info`.`acc_no` = '$trackno' OR `parcel_international_transactions`.`billid` = '$trackno' )   
                   AND  `parcel_international_transactions`.`status` = 'Paid'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }


		public function Itemize_small_parcket_list($region,$em_branch){
			$empid = $this->session->userdata('user_emid');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM `fgn_small_packet` WHERE `status` = 'received' AND `branch` = '$em_branch' AND  `region`='$region'";
	$query=$db2->query($sql);
	$result = $query->result();
	//$result = $query->result_array();
	return $result;

	
	}

	 public function delete_small_parcket($FGN_small_packet_id){
    $db2 = $this->load->database('otherdb', TRUE);
	  $db2->delete('fgn_small_packet',array('FGN_small_packet_id '=> $FGN_small_packet_id));
  }

   public function Update_small_packet_byID($FGN_small_packet_id,$status,$emid){
	  		$db2 = $this->load->database('otherdb', TRUE);
	  		 $db2->set('status',$status);
	  		 $db2->set('received_by',$emid);
		$db2->where('FGN_small_packet_id', $FGN_small_packet_id);
		$db2->where('status', 'sent');
		$db2->update('fgn_small_packet');         
    }

     public function Update_small_packet_byBarcode($FGN_number,$status,$emid){
	  		$db2 = $this->load->database('otherdb', TRUE);
	  		 $db2->set('status',$status);
	  		 $db2->set('received_by',$emid);
		$db2->where('FGN_number', $FGN_number);
		$db2->where('status', 'sent');
		$db2->update('fgn_small_packet');         
    }

	public function Update_small_packet_delivered_byBarcode($FGN_number,$emid){
		$db2 = $this->load->database('otherdb', TRUE);
		 $db2->set('status','completed');
		 $db2->set('delivered_by',$emid);
  $db2->where('FGN_number', $FGN_number);
  $db2->update('fgn_small_packet');
}

    public function Update_small_packet_receive_status_byID($FGN_small_packet_id,$status,$emid){
	  		$db2 = $this->load->database('otherdb', TRUE);
	  		 $db2->set('status',$status);
		$db2->where('FGN_small_packet_id', $FGN_small_packet_id);
		$db2->update('fgn_small_packet');         
    }


     public function update_small_packet_data($update,$id){
	    $db2 = $this->load->database('otherdb', TRUE);
	    $db2->where('FGN_small_packet_id',$id);
	    $db2->update('fgn_small_packet',$update);
	 }
	
	
	
}