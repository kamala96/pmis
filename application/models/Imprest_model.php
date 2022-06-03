<?php

class Imprest_model
	extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    public function getAllImprestExpenditure()
	{
		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$em_id = $basicinfo->em_id;
		$dep_name = $basicinfo->dep_name;

		if ($this->session->userdata('user_type') == 'EMPLOYEE'){
			$sql = "SELECT * FROM `imprest_expenditure_request` WHERE `em_id` = '$em_id' AND `imprest_expenditure_request`.`exp_status` != 'isCAN'";
		}elseif($this->session->userdata('user_type') == 'HOD'){
			$sql = "SELECT * FROM `imprest_expenditure_request` WHERE `exp_from`='$dep_name' AND `imprest_expenditure_request`.`exp_status` != 'isCAN'";
		}
		else{
			
			$sql = "SELECT * FROM `imprest_expenditure_request` WHERE `imprest_expenditure_request`.`exp_status` != 'isCAN'";
		}

		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	}
	public function getAllImprestSubsistence()
	{
		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$em_id = $basicinfo->em_id;
		$dep_name = $basicinfo->dep_name;

		if ($this->session->userdata('user_type') == 'EMPLOYEE'){

			$sql = "SELECT `imprest_request_form`.* ,`imprest_expenditure_request`.*
			FROM  `imprest_request_form`
			LEFT JOIN `imprest_expenditure_request` ON `imprest_expenditure_request`.`imp_id` = `imprest_request_form`.`imp_id` WHERE `imprest_expenditure_request`.`em_id` = '$em_id' AND `imprest_request_form`.`imps_status` != 'isCAN'";

		}elseif($this->session->userdata('user_type') == 'HOD'){
			
			$sql = "SELECT `imprest_request_form`.* ,`imprest_expenditure_request`.*
			FROM  `imprest_request_form`
			LEFT JOIN `imprest_expenditure_request` ON `imprest_expenditure_request`.`imp_id` = `imprest_request_form`.`imp_id` WHERE `imprest_expenditure_request`.`exp_from` = '$dep_name' AND `imprest_request_form`.`imps_status` != 'isCAN'";
		}
		else{
			
			$sql = "SELECT `imprest_request_form`.* ,`imprest_expenditure_request`.*
			FROM  `imprest_request_form`
			LEFT JOIN `imprest_expenditure_request` ON `imprest_expenditure_request`.`imp_id` = `imprest_request_form`.`imp_id` WHERE `imprest_request_form`.`imps_status` != 'isCAN'";

        }

		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;

	}
	public function save_expenditure_request($data)
	{
		$this->db->insert('imprest_expenditure_request',$data);
	}
	public function save_imprest_form_request($data)
	{
		$this->db->insert('imprest_request_form',$data);
	}
	public function edit_imprest_form_request($imps_id,$data)
	{
		$this->db->where('imps_id',$imps_id);
		$this->db->update('imprest_request_form',$data);
	}
	public function update_expenditure_request($imp_id,$data)
	{
		$this->db->where('imp_id',$imp_id);
		$this->db->update('imprest_expenditure_request',$data);
	}
	public function cancelImprestById($id,$data)
	{
		$this->db->where('imp_id',$id);
		$this->db->update('imprest_expenditure_request',$data);
	}
	public function cancelImprestubsistenceById($id,$data)
	{
		$this->db->where('imps_id',$id);
		$this->db->update('imprest_request_form',$data);
	}
	public function update_status($imp_id,$data)
	{
		$this->db->where('imp_id',$imp_id);
		$this->db->update('imprest_expenditure_request',$data);
	}
	public function update_status1($imp_id,$data1)
	{
		$this->db->where('imp_id',$imp_id);
		$this->db->update('imprest_expenditure_request',$data1);
	}
	public function update_status_imprest($imps_id,$data)
	{
		$this->db->where('imps_id',$imps_id);
		$this->db->update('imprest_request_form',$data);
	}
	public function getImprestById($id){
		$sql = "SELECT * FROM `imprest_expenditure_request` WHERE `imp_id`='$id'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
	public function check_imprest_paid($id){
		$sql = "SELECT * FROM `imprest_request_form` WHERE `imp_id`='$id'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
	public function findImprestSubsistenceById($id){
		$sql = "SELECT * FROM `imprest_request_form` WHERE `imps_id`='$id'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
	public function getImprestSubsistenceById($id){
		$sql = "SELECT * FROM `imprest_request_form` WHERE `imps_id`='$id'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
	public function getRefferences($year){

		$sql = "SELECT MAX(number) as number FROM `refferences_numbers` WHERE `refferences_numbers`.`year` = '$year' ORDER BY `refferences_numbers`.`reff_id` DESC";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
	public function addRefferences($number)
	{
		$this->db->insert('refferences_numbers',$number);
	}

	public function countimprest()
	{
		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$em_id = $basicinfo->em_id;
		$dep_name = $basicinfo->dep_name;

		if ($this->session->userdata('user_type') == 'EMPLOYEE'){

			$sql = "SELECT `imprest_request_form`.* ,`imprest_expenditure_request`.*
			FROM  `imprest_request_form`
			LEFT JOIN `imprest_expenditure_request` ON `imprest_expenditure_request`.`imp_id` = `imprest_request_form`.`imp_id` WHERE `imprest_expenditure_request`.`em_id` = '$em_id' AND `imprest_request_form`.`imps_status` != 'isCAN'";

		}elseif($this->session->userdata('user_type') == 'HOD'){
			
			$sql = "SELECT `imprest_request_form`.* ,`imprest_expenditure_request`.*
			FROM  `imprest_request_form`
			LEFT JOIN `imprest_expenditure_request` ON `imprest_expenditure_request`.`imp_id` = `imprest_request_form`.`imp_id` WHERE `imprest_expenditure_request`.`exp_from` = '$dep_name' AND `imprest_request_form`.`imps_status` != 'isCAN'";
		}
		else{
			
			$sql = "SELECT `imprest_request_form`.* ,`imprest_expenditure_request`.*
			FROM  `imprest_request_form`
			LEFT JOIN `imprest_expenditure_request` ON `imprest_expenditure_request`.`imp_id` = `imprest_request_form`.`imp_id` WHERE `imprest_request_form`.`imps_status` != 'isCAN'";

        }

		$query = $this->db->query($sql);
		return $query->num_rows();
	}
}
?>
