<?php

	class Login_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
	public function getUserForLogin($credential){			
    return $this->db->get_where('employee', $credential);
	}
	public function getdata(){
	$query =$this->db->get('users');
	$result=$query->result();
	return $result;
	}
	
	public function is_current_password_available($currentPassword, $email)
	{
		$this->db->select('id');
		$this->db->where('em_email', $email);
		$this->db->where('em_password', $currentPassword);
		$query = $this->db->get('employee');

		if($query->num_rows() > 0)
		return $query->row_array();
		else FALSE;
	}	

	public function update_pmis_login_password($newPassword, $emp_id, $date)
	{
		// $this->db->set('em_password', $newPassword);
		// $this->db->set('last_modified_password', $date);
		// $this->db->where('id', $emp_id);
		// $this->db->update('employee');

		$data = array('em_password' => $newPassword, 'last_modified_password' => $date);
		$where = array('id' => $emp_id);
		if($this->db->update('employee', $data, $where))
		{
			return TRUE;
		}
		return FALSE;
	}

	//**exists employee email check**//
    public function Does_email_exists($email) {
		$user = $this->db->dbprefix('users');
        $sql = "SELECT `email` FROM $user
		WHERE `email`='$email'";
		$result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function insertUser($data){
		$this->db->insert('users',$data);
	}
	public function insert_activity($data){
		$this->db->insert('emp_logs_activities',$data);
	}
	public function UpdateKey($data,$email){
		$this->db->where('email',$email);
		$this->db->update('users',$data);
	}
	public function update_activity($data1,$date,$em_id){
		$this->db->where('em_id',$em_id);
		$this->db->where('date_created',$date);
		$this->db->update('emp_logs_activities',$data1);
	}
	public function UpdatePassword($key,$data){
		$this->db->where('forgotten_code',$key);
		$this->db->update('users',$data);	    
	}	
	public function UpdateStatus($verifycode,$data){
		$this->db->where('confirm_code',$verifycode);
		$this->db->update('users',$data);	    
	}
	//**exists employee email check**//
    public function Does_Key_exists($reset_key) {
		$user = $this->db->dbprefix('users');
        $sql = "SELECT `forgotten_code` FROM $user
		WHERE `forgotten_code`='$reset_key'";
		$result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
	public function GetUserInfo($key){
		$user = $this->db->dbprefix('users');
        $sql = "SELECT `password` FROM $user
		WHERE `forgotten_code`='$key'";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;			
	}		
	public function GetuserInfoBycode($verifycode){
		$user = $this->db->dbprefix('users');
        $sql = "SELECT * FROM $user
		WHERE `confirm_code`='$verifycode'";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;			
	}	

	public function getLoginDetails($email,$password)
	{
		$sql = "SELECT * FROM `employee` WHERE `em_email` = '$email' AND `em_password` = '$password'";
		$query = $this->db->query($sql);
        $result = $query->row();
        return $result;
	}

	public function getLoginDeliveryDetails($email)
	{
		$sql = "SELECT * FROM `employee` WHERE `em_email` = '$email'";
		$query = $this->db->query($sql);
        $result = $query->row();
        return $result;
	}
}
?>