<?php

	class Leave_model extends CI_Model {


	function __consturct(){
	parent::__construct();
	
	}
    public function Add_HolidayInfo($data){
        $this->db->insert('holiday',$data);
    }

    // Add the application of leave with ID no ID
    public function Application_Apply($data){
        $this->db->insert('emp_leave',$data);
    }

    // Add Earn leave with ID no ID
    public function Add_Earn_Leave($data){
        $this->db->insert('earned_leave',$data);
    }

    // Update application with employee ID
    public function Application_Apply_Update($ids, $data){
        $this->db->where('id', $ids);
        $this->db->update('emp_leave', $data);         
    }
    public function Application_Apply_Update1($leaveID, $data1){
        $this->db->where('id', $leaveID);
        $this->db->update('emp_leave', $data1);         
    }
    public function Add_leave_Info($data){
        $this->db->insert('leave_types',$data);
    }
    public function Application_Apply_Approve($data){
        $this->db->insert('assign_leave', $data);
    }
    public function GetAllHoliInfo(){
        $sql = "SELECT * FROM `holiday`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetAllHoliInfoForCalendar(){
        $sql = "SELECT holiday_name AS `title`, from_date AS `start` FROM `holiday`";
        $query = $this->db->query($sql);
        $result = $query->result();
        return json_encode($result);
    }
    public function GetLeaveValue($id){
        $sql = "SELECT * FROM `holiday` WHERE `id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetEarneBalanceByEmCode($id){
        $sql = "SELECT `earned_leave`.*,
        `employee`.`em_id`,CONCAT(`first_name`, ' ', `last_name`) AS emname
        FROM `earned_leave`
        LEFT JOIN `employee` ON `earned_leave`.`em_id`=`employee`.`em_id`
        WHERE `earned_leave`.`em_id`='$id'";        
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetLeave($emid){
        $sql = "SELECT * FROM `emp_leave` WHERE `em_id`='$emid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetLeaveType($typeid){
        $sql = "SELECT * FROM `leave_types` WHERE `type_id`='$typeid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetFamilys($emid){
      $sql = "SELECT * FROM `em_familly` WHERE `em_id` = '$emid'";
        $query=$this->db->query($sql);
    $result = $query->result();
    return $result;          
    }
    public function GetleavetypeInfo(){
        $sql = "SELECT * FROM `leave_types` WHERE `status`='1' ORDER BY `type_id` DESC";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
    }
    public function GetleavetypeInfoid($id){
        $sql = "SELECT * FROM `leave_types` WHERE `status`='1' AND `type_id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetemassignLeaveType($emid,$id,$year){
        $sql = "SELECT `hour` FROM `assign_leave` WHERE `assign_leave`.`emp_id`='$emid' AND `type_id`='$id' AND `dateyear`='$year'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetTotalDay($type){
        $sql = "SELECT * FROM `assign_leave` WHERE `assign_leave`.`type_id`='$type'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetemLeaveType($id,$year){
        $sql = "SELECT `assign_leave`.*,
        `leave_types`.`name`
        FROM `assign_leave`
        LEFT JOIN `leave_types` ON `assign_leave`.`type_id`=`leave_types`.`type_id`
        WHERE `assign_leave`.`emp_id`='$id' AND `dateyear`='$year'
        ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
    }
    public function Does_leaveApprove_exists($emid) {
    $user = $this->db->dbprefix('emp_leave');
        $sql = "SELECT `em_id` FROM $user
    WHERE `em_id`='$emid' AND `leave_status` = 'Approve'";
    $result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function Does_leaveNotApprove_exists($emid) {
    $user = $this->db->dbprefix('emp_leave');
        $sql = "SELECT `em_id` FROM $user
    WHERE `em_id`='$emid' AND `leave_status` = 'Not Approve'";
    $result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function Does_leaveRejected_exists($emid) {
    $user = $this->db->dbprefix('emp_leave');
        $sql = "SELECT `em_id` FROM $user
    WHERE `em_id`='$emid' AND `leave_status` = 'Rejected'";
    $result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function GetEmLEaveReport($emid, $day, $year){
		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$dep_id = $basicinfo->dep_id;

        if($emid == "all") {
        if ($this->session->userdata('user_type') == 'RM')
		{
			$sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`leave_duration`) 
                    FROM emp_leave
                    WHERE  MONTH(start_date) = '$day' AND YEAR(start_date) = '$year') AS `total_duration`,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(start_date) = '$day' AND YEAR(start_date) = '$year' AND `em_region` = '$region'";
		}elseif ($this->session->userdata('user_type') == 'HOD')
		{
			$sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`leave_duration`) 
                    FROM emp_leave
                    WHERE  MONTH(start_date) = '$day' AND YEAR(start_date) = '$year') AS `total_duration`,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(start_date) = '$day' AND YEAR(start_date) = '$year' AND `dep_id` = '$dep_id' AND `em_region` = '$region'";
		}else{

        $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`leave_duration`) 
                    FROM emp_leave
                    WHERE  MONTH(start_date) = '$day' AND YEAR(start_date) = '$year') AS `total_duration`,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(start_date) = '$day' AND YEAR(start_date) = '$year'";

		}
    } else {

			if ($this->session->userdata('user_type') == 'RM')
			{
				$sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`leave_duration`) 
                    FROM emp_leave
                    WHERE  MONTH(start_date) = '$day' AND YEAR(start_date) = '$year') AS `total_duration`,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(start_date) = '$day' AND YEAR(start_date) = '$year' `em_region` = '$region'";
			}elseif ($this->session->userdata('user_type') == 'HOD')
			{
				$sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`leave_duration`) 
                    FROM emp_leave
                    WHERE  MONTH(start_date) = '$day' AND YEAR(start_date) = '$year') AS `total_duration`,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(start_date) = '$day' AND YEAR(start_date) = '$year' AND `dep_id` = '$dep_id' AND `em_region` = '$region'";
			}else{

				$sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`leave_duration`) 
                    FROM emp_leave
                    WHERE  MONTH(start_date) = '$day' AND YEAR(start_date) = '$year') AS `total_duration`,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(start_date) = '$day' AND YEAR(start_date) = '$year'";

			}


    }
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result; 
}
    public function GetLeaveToday($date){
    $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
        WHERE `apply_date`='$date'";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result; 
    }
    public function selectid($region_id){
    $sql    = "SELECT * FROM `em_region` WHERE `region_name`='$region_id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          $id = $result->region_id;

          $sql1    = "SELECT * FROM `em_branch` WHERE `region_id`='$id'";
          $query1  = $this->db->query($sql1);
          $result1 = $query1->row();
    return $result;
  }
    public function GetLeaveApply($id){
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id` 
      WHERE `emp_leave`.`id`='$id'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetLeaveApplyById($id){

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`middle_name`,`last_name`,`em_code`,`em_gender`,`em_region`,
      `leave_types`.*
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `leave_types`.`type_id`=`emp_leave`.`typeid`  
      WHERE `emp_leave`.`id`='$id'";

		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
		public function GetLeaveApplyByIDs($id){

			$sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`middle_name`,`last_name`,`em_code`,`em_gender`,`em_region`,
      `leave_types`.*
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `leave_types`.`type_id`=`emp_leave`.`typeid`  
      WHERE `emp_leave`.`id`='$id'";

			$query = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}
    public function GetLeaveRejectedById($id){
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`middle_name`,`last_name`,`em_code`,`em_gender`,`em_region`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`  
      WHERE `emp_leave`.`em_id`='$id' AND `emp_leave`.`leave_status` = 'Rejected'";

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;  
    }

    public function GetEarnedleaveBalance(){
         $id = $this->session->userdata('user_login_id');
  $basicinfo = $this->employee_model->GetBasic($id);
  $region = $basicinfo->em_region;
  $em_id = $basicinfo->em_id;
  if ($this->session->userdata('user_type')=='REGIONALHR') {
        $sql = "SELECT `earned_leave`.*, `employee`.`first_name`,`last_name`,`em_code` FROM `earned_leave` LEFT JOIN `employee` ON `earned_leave`.`em_id`=`employee`.`em_id` WHERE `earned_leave`.`hour` > 0 AND `employee`.`status`='ACTIVE' AND `employee`.`em_region` ='$region'";
    }
    else
    {
        $sql = "SELECT `earned_leave`.*, `employee`.`first_name`,`last_name`,`em_code` FROM `earned_leave` LEFT JOIN `employee` ON `earned_leave`.`em_id`=`employee`.`em_id` WHERE `earned_leave`.`hour` > 0 AND `employee`.`status`='ACTIVE'";
    }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
    }
    public function emEarnselectByLeave($emid){
        $sql = "SELECT * FROM `earned_leave` WHERE `em_id`='$emid'";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result; 
    }
    public function GetallApplication($emid){

    $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE `emp_leave`.`em_id`='$emid'";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result; 
    }
    public function AllLeaveAPPlication(){
    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $region = $basicinfo->em_region;
      $em_id = $basicinfo->em_id;

      if ($this->session->userdata('user_type')=='EMPLOYEE') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_id` ='$em_id'";

      }elseif ($this->session->userdata('user_type')=='DISPATCH') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_id` ='$em_id'";

      }elseif ($this->session->userdata('user_type')=='HOD') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`dep_id` ='$basicinfo->dep_id' AND `employee`.`em_region`='$region' ";

      }elseif ($this->session->userdata('user_type')=='RM') {

		  $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_region` ='$region'";
	  }elseif ($this->session->userdata('user_type')=='ACCOUNTANT') {

		  $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`isPMG` ='Approve'";
	  }
      else
      {
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      -- WHERE `emp_leave`.`leave_status`='Not Approve'";
      }
    
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result; 
    }
    public function getLeaveToBank($isPMG,$isACC)
	{
		$sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`middle_name`,`em_code`,
      `leave_types`.`type_id`,`name`,
      `bank_info`.*
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      LEFT JOIN  `bank_info` ON  `bank_info`.`em_id` = `emp_leave`.`em_id`
      WHERE  `emp_leave`.`isPMG` ='$isPMG' && `emp_leave`.`isACC` ='$isACC'";

		$query=$this->db->query($sql);
		$result = $query->result();
		return $result;
	}
    public function AllLeaveRejection($emid){
   
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,`em_region`,`district_to`,`region_to`,`village_to`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE `emp_leave`.`leave_status`='Rejected' AND `emp_leave`.`em_id` = '$emid'";
      
        $query=$this->db->query($sql);
    $result = $query->result();
    return $result; 
    }
    public function AllLeaveApproved(){
    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $region = $basicinfo->em_region;
      $em_id = $basicinfo->em_id;
      if ($this->session->userdata('user_type')=='REGIONALHR') {
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE `emp_leave`.`leave_status`='Approve' AND `employee`.`em_region` ='$region'";
      }
      elseif ($this->session->userdata('user_type')=='EMPLOYEE') {
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE `emp_leave`.`leave_status`='Approve' AND `employee`.`em_id` ='$em_id'";
      }
      else
      {
        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE `emp_leave`.`leave_status`='Approve'";
      }
    
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result; 
    }
    public function EmLeavesheet($emid){
      
    $sql = "SELECT `assign_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `assign_leave`
      LEFT JOIN `employee` ON `assign_leave`.`emp_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `assign_leave`.`type_id`=`leave_types`.`type_id`
      WHERE `assign_leave`.`emp_id`='$emid'";
        $query=$this->db->query($sql);
		$result = $query->result();
		return $result; 
    }
    public function Update_HolidayInfo($id,$data){
		$this->db->where('id', $id);
		$this->db->update('holiday',$data);         
    }
   public function Update_Leave_Status($id,$update){
    $this->db->where('id', $id);
    $this->db->update('emp_leave',$update);         
    }
    public function Update_leave_Info($id,$data){
		$this->db->where('type_id', $id);
		$this->db->update('leave_types',$data);         
    }
    public function Assign_Duration_Update($type,$data){
        $this->db->where('type_id', $type);
        $this->db->update('assign_leave', $data);         
    }
    public function DeletHoliday($id){
        $this->db->delete('holiday',array('id'=> $id));        
    }
    public function DeletType($id){
        $this->db->delete('leave_types',array('type_id'=> $id));        
    }
    public function DeletApply($id){
        $this->db->delete('emp_leave',array('id'=> $id));        
    }




    public function updateAplicationAsResolved($id, $data){
        $this->db->where('id', $id);
        $this->db->update('emp_leave', $data);         
    }  

    public function getLeaveTypeTotal($emid, $type){
        $sql = "SELECT SUM(`hour`) AS 'totalTaken' FROM `assign_leave` WHERE `assign_leave`.`emp_id`='$emid' AND `assign_leave`.`type_id`='$type'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function updateLeaveAssignedInfo($employeeID, $type, $data){
        
        $this->db->where('type_id', $type);
        $this->db->where('emp_id', $employeeID);
        $this->db->update('assign_leave', $data);         
    }

    public function UpdteEarnValue($emid,$data){
        $this->db->where('em_id', $emid);
        $this->db->update('earned_leave', $data);         
    }


    public function insertLeaveAssignedInfo($data){
        $this->db->insert('assign_leave', $data);
    }

    public function determineIfNewLeaveAssign($employeeId, $type){
         $sql = "SELECT * FROM `assign_leave` WHERE `assign_leave`.`emp_id` = '$employeeId' AND `assign_leave`.`type_id` = '$type'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function get_holiday_between_dates($day) {
        $sql = "SELECT * FROM `holiday` WHERE ('$day' = `holiday`.`from_date`) OR ('$day' BETWEEN `holiday`.`from_date` AND `holiday`.`to_date`)";
        $query = $this->db->query($sql);
        return $query->row();
    }
    }
?>    
