<?php

	class FP_Application_model extends CI_Model{

		public function Itemize_foreign_parcel($region,$branch,$barcode){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT * FROM `foreign_parcel` WHERE (`status` = 'sent' OR `status` = 'Itemized'  ) AND `branch` = '$branch' AND `region`='$region' AND `Barcode`='$barcode'";

			$query=$db2->query($sql);
			$result = $query->result_array();
			return $result;
		}

		public function get_last_dpnumber($branch,$region){
	 		$db2 = $this->load->database('otherdb', TRUE);
			  $sql= "SELECT * FROM `foreign_parcel` 
			  WHERE `status` = 'Itemized' AND `branch` = '$branch' AND `region`='$region'
			  ORDER BY `itemized_date` DESC LIMIT 1";
			  $query  = $db2->query($sql);
			  $result = $query->row();
			  return $result;
		 } 

	 	public function get_Packet_byID($id){
	 		$db2 = $this->load->database('otherdb', TRUE);
			  $sql= "SELECT * FROM `foreign_parcel` 
			  WHERE `id` = '$id' LIMIT 1";
			  $query  = $db2->query($sql);
			  $result = $query->row();
			  return $result;
		}

		public function save_foreign_parcel($data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('foreign_parcel',$data);
		}

		public function pending_foreign_parcel_list($emid,$rec_branch){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT * FROM `foreign_parcel` WHERE `status` = 'pending' AND `branch` = '$rec_branch' AND `created_by`='$emid'";
			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public function pending_foreign_parcel_byBarcode($Barcode){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT * FROM `foreign_parcel` WHERE `Barcode` = '$Barcode'";
			$query=$db2->query($sql);
			$result = $query->result_array();
			return $result;
		}

		public function Update_foreign_parcelById($id,$data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('id',$id);
			$db2->update('foreign_parcel',$data);
		}

		public function Update_foreign_parcel($emid,$rec_branch){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->set('status','sent');
			$db2->where('branch', $rec_branch);
			$db2->where('created_by', $emid);
			$db2->where('status', 'pending');
			$db2->update('foreign_parcel');         
    	}

    	public function get_foreign_parcel_passed_to($empid='',$Barcode='',$status='',$office_name='',$pass_to_by=''){
			// $empid = $this->session->userdata('user_emid');
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `foreign_parcel` WHERE  1=1 ";

		if ($empid) $sql.= " and `pass_to` = '$empid' ";
		if ($Barcode) $sql.= " and `Barcode` = '$Barcode' ";
		if ($status) $sql.= " and `pass_to_status` = '$status' ";
		if ($office_name) $sql.= " and `office_name` = '$office_name' ";
		if ($pass_to_by) $sql.= " and `pass_to_by` = '$pass_to_by' ";

		//echo $sql;die();
		$query=$db2->query($sql);
		//$result = $query->result();
		$result = $query->result_array();
		return $result;
	}

	public function get_foreign_parcel_passed_to_date($empid='',$Barcode='',$status='',$office_name='',$pass_to_by='',$fromdate="",$todate=""){
			// $empid = $this->session->userdata('user_emid');
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `foreign_parcel` WHERE  1=1 ";

		if ($empid) $sql.= " and `pass_to` = '$empid' ";
		if ($Barcode) $sql.= " and `Barcode` = '$Barcode' ";
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


	}

?>