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
    public function save_batch_date($save){
        $this->db->insert('batch_leave_date',$save);
    }

    // Add Earn leave with ID no ID
    public function Add_Earn_Leave($data){
        $this->db->insert('earned_leave',$data);
    }
    public function SaveBatchHRtoCRM($datas){
        $this->db->insert('leave_batch',$datas);
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
    public function SaveBatch($batch){
        $this->db->insert('batches',$batch);
    }
    public function insert_assign_leave($data1){
        $this->db->insert('assign_leave',$data1);
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
    
    public function getBatch(){

        $sql = "SELECT *
                FROM `batches` WHERE `batch_id` IN (
                SELECT MAX(`batch_id`)
                FROM `batches`
                GROUP BY `batch_no`) ORDER BY `batch_date` DESC";

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
    public function get_batch_status($batchNo){
        $sql = "SELECT * FROM `batches` WHERE `batch_no`='$batchNo' ORDER BY `batch_id` DESC LIMIT 1";
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
    public function GetemassignLeaveType($emid,$year){
        $sql = "SELECT * FROM `assign_leave` WHERE `assign_leave`.`emp_id`='$emid' AND `dateyear`='$year' 
               ORDER BY `id` DESC";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetleaveDuration($emid){
        $sql = "SELECT * FROM `emp_leave` WHERE `emp_leave`.`em_id`='$emid'";
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
      public function GetEmLEaveReport($emid, $fromdate, $todate,$Status){
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
        $region = $basicinfo->em_region;
        $dep_id = $basicinfo->dep_id;

        if($emid == "all") {

             if($Status == "all") {

             $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate' ";
            }else {
                  $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate' AND `leave_status`='$Status'";
            }

        }

         $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 


    }
    public function GetEmLEaveReport01($emid, $fromdate, $todate,$Status){
		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$dep_id = $basicinfo->dep_id;

        if($emid == "all") {
        if ($this->session->userdata('user_type') == 'RM')
		{
			 $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`)  BETWEEN '$fromdate' AND '$todate' AND `em_region` = '$region' AND `leave_status`='$Status'";

		}elseif ($this->session->userdata('user_type') == 'HOD')
		{
			 $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate' AND `dep_id` = '$dep_id' AND `em_region` = '$region' AND `leave_status`='$Status' ";
		}else{//admin

     $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate' AND `leave_status`='$Status'";

		}
    } else {

			if ($this->session->userdata('user_type') == 'RM')
			{
				 $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`)BETWEEN '$fromdate' AND '$todate' AND `em_region` = '$region'
                 AND `employee`.`em_id` = '$emid' AND `leave_status`='$Status'";
			}elseif ($this->session->userdata('user_type') == 'HOD')
			{
	 $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate' AND `dep_id` = '$dep_id' AND `em_region` = '$region'  AND `employee`.`em_id` = '$emid' AND `leave_status`='$Status'";
			}else{

                   $sql = "SELECT `emp_leave`.*,
                (SELECT SUM(`emp_leave`.`leave_duration`) AS `total_duration`
                    FROM `emp_leave`
                    WHERE   DATE(`emp_leave`.`start_date`) BETWEEN '$fromdate' AND '$todate') ,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  DATE(`emp_leave`.`start_date`)  BETWEEN '$fromdate' AND '$todate'  AND `employee`.`em_id` = '$emid' AND `leave_status`='$Status'";


				// $sql = "SELECT `emp_leave`.*,
    //             (SELECT SUM(`leave_duration`) 
    //                 FROM emp_leave
    //                 WHERE   DATE(start_date) BETWEEN '$fromdate' AND '$todate' AS `total_duration`,
    //                 `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
    //                 `leave_types`.`name`
    //             FROM `emp_leave`
    //                 LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
    //                 LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
    //             WHERE  DATE(start_date) BETWEEN '$fromdate' AND '$todate'";

			}


    }
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result; 
}

 public function GetEmLEaveReportOlD($emid, $day, $year){
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


public function GetEmLEaveBatch($emid, $day, $year){
    $id = $this->session->userdata('user_login_id');
    $basicinfo = $this->employee_model->GetBasic($id);
    $region = $basicinfo->em_region;
    $dep_id = $basicinfo->dep_id;

        $sql = "SELECT `emp_leave`.*,`leave_types`.*,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                    INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE MONTH(apply_date) = '$day' AND YEAR(apply_date) = '$year' AND `emp_leave`.`typeid` = '$emid' AND (`emp_leave`.`leave_status` = 'Approve' OR `emp_leave`.`leave_status`='Complete') AND `emp_leave`.`HRtoCRM` = 'No'";
    
    $query = $this->db->query($sql);
    $result = $query->result();
    return $result; 
}

  


public function GetEmLEaveByemcode($emcode,$batchNo){
    $id = $this->session->userdata('user_login_id');
    $basicinfo = $this->employee_model->GetBasic($id);
    $region = $basicinfo->em_region;
    $dep_id = $basicinfo->dep_id;

        $sql = "SELECT `emp_leave`.*,`leave_types`.*,`leave_batch`.*,
                    `employee`.`first_name`,`middle_name`,`last_name`,`em_code`,`des_id`,`dep_id`,`em_region`,
                    `leave_types`.`name`
                FROM `emp_leave`
                    INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
                     INNER JOIN `leave_batch` ON `leave_batch`.`typeid`=`leave_types`.`type_id`
                    INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
                WHERE  `employee`.`em_code` = '$emcode' AND (`emp_leave`.`leave_status` = 'Approve' OR `emp_leave`.`leave_status`='Complete') AND `emp_leave`.`HRtoCRM` = 'No' AND `leave_batch`.`batchNo`='$batchNo' LIMIT 1 ";
    
    $query = $this->db->query($sql);
    $result = $query->row();
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
    public function getLeaveDetails($id){
        $sql = "SELECT *  FROM `emp_leave` WHERE `emp_leave`.`id`='$id'";
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
     public function MyLeaveAPPlication(){

        $em_id = $this->session->userdata('user_login_id');

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_id` ='$em_id' AND `emp_leave`.`leave_status` != 'Canceled' ORDER BY `emp_leave`.`apply_date` DESC ";

      $query=$this->db->query($sql);
        $result = $query->result();
        return $result; 
     }

    public function AllLeaveAPPlication(){
    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $region = $basicinfo->em_region;
      $em_id = $basicinfo->em_id;

      if ($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='SUPERVISOR') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_id` ='$em_id' AND `emp_leave`.`leave_status` != 'Canceled' ORDER BY `emp_leave`.`apply_date` DESC ";

      }elseif ($this->session->userdata('user_type')=='HOD') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`dep_id` ='$basicinfo->dep_id' AND `employee`.`em_region`='$region' AND `emp_leave`.`leave_status` != 'Canceled' AND !(`emp_leave`.`des_name` = 'RM' OR `emp_leave`.`des_name` = 'M/MKT' OR `emp_leave`.`des_name` = 'M/EB' OR `emp_leave`.`des_name` = 'M/CIS' OR `emp_leave`.`des_name` = 'M/FAS' OR `emp_leave`.`des_name` = 'M/EMS' OR `emp_leave`.`des_name` = 'M/MLB' OR `emp_leave`.`des_name` = 'AM/PSI' OR `emp_leave`.`des_name` = 'AM/SB' OR `emp_leave`.`des_name` = 'GM/BOP' OR `emp_leave`.`des_name` = 'PPCI-POSTAGIRO' OR `emp_leave`.`des_name` = 'OMS-GM/BOP') AND !(`emp_leave`.`des_name` = 'M/HR' OR `emp_leave`.`des_name` = 'M/CF&A' OR `emp_leave`.`des_name` = 'M/CP' OR `emp_leave`.`des_name` = 'H/REM' OR `emp_leave`.`des_name` = 'OMS-GM/CRM')  ORDER BY `emp_leave`.`apply_date` DESC ";

      }elseif ($this->session->userdata('user_type')=='RM') {

		  $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_region` ='$region' AND `emp_leave`.`leave_status` != 'Canceled' AND !(`emp_leave`.`des_name` = 'RM' OR `emp_leave`.`des_name` = 'M/MKT' OR `emp_leave`.`des_name` = 'M/EB' OR `emp_leave`.`des_name` = 'M/CIS' OR `emp_leave`.`des_name` = 'M/FAS' OR `emp_leave`.`des_name` = 'M/EMS' OR `emp_leave`.`des_name` = 'M/MLB' OR `emp_leave`.`des_name` = 'AM/PSI' OR `emp_leave`.`des_name` = 'AM/SB' OR `emp_leave`.`des_name` = 'GM/BOP' OR `emp_leave`.`des_name` = 'PPCI-POSTAGIRO' OR `emp_leave`.`des_name` = 'OMS-GM/BOP') AND !(`emp_leave`.`des_name` = 'M/HR' OR `emp_leave`.`des_name` = 'M/CF&A' OR `emp_leave`.`des_name` = 'M/CP' OR `emp_leave`.`des_name` = 'H/REM' OR `emp_leave`.`des_name` = 'OMS-GM/CRM')  OR `emp_leave`.`em_id` ='$em_id' ORDER BY `emp_leave`.`apply_date` DESC";

	  }elseif ($this->session->userdata('user_type')=='ACCOUNTANT') {

		  $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
       WHERE `emp_leave`.`leave_status` != 'Canceled'  ORDER BY `emp_leave`.`apply_date` DESC";

	  }elseif ($this->session->userdata('user_type')=='PMG') {

      $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`des_name` = 'H/CIPA' OR `emp_leave`.`des_name` = 'H/S&I' OR `emp_leave`.`des_name` = 'H/IA&I' OR `emp_leave`.`des_name` = 'H/PMU' OR `emp_leave`.`des_name` = 'H/UPU-RTC' OR `emp_leave`.`des_name` = 'CS' OR `emp_leave`.`des_name` = 'GM/CRM' OR `emp_leave`.`des_name` = 'GM/BOP'  OR `emp_leave`.`des_name` = 'OMS-PMG' AND `emp_leave`.`leave_status` != 'Canceled'  ORDER BY `emp_leave`.`apply_date` DESC";

    }elseif ($this->session->userdata('user_type')=='BOP') {

      $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`des_name` = 'RM' OR `emp_leave`.`des_name` = 'M/MKT' OR `emp_leave`.`des_name` = 'M/EB' OR `emp_leave`.`des_name` = 'M/CIS' OR `emp_leave`.`des_name` = 'M/FAS' OR `emp_leave`.`des_name` = 'M/EMS' OR `emp_leave`.`des_name` = 'M/MLB' OR `emp_leave`.`des_name` = 'AM/PSI' OR `emp_leave`.`des_name` = 'AM/SB' OR `emp_leave`.`des_name` = 'GM/BOP' OR `emp_leave`.`des_name` = 'PPCI-POSTAGIRO' OR `emp_leave`.`des_name` = 'OMS-GM/BOP' AND `emp_leave`.`leave_status` != 'Canceled' ORDER BY `emp_leave`.`apply_date` DESC";
      
    }elseif ($this->session->userdata('user_type')=='CRM') {

      $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`des_name` = 'M/HR' OR `emp_leave`.`des_name` = 'M/CF&A' OR `emp_leave`.`des_name` = 'M/CP' OR `emp_leave`.`des_name` = 'H/REM' OR `emp_leave`.`des_name` = 'OMS-GM/CRM' AND `emp_leave`.`leave_status` != 'Canceled' ORDER BY `emp_leave`.`apply_date` DESC";
    }elseif ($this->session->userdata('user_type')=='HR' || $this->session->userdata('user_type')=='HR-PAY') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id` 
      WHERE `emp_leave`.`leave_status` != 'Canceled' AND !(`emp_leave`.`des_name` = 'RM' OR `emp_leave`.`des_name` = 'M/MKT' OR `emp_leave`.`des_name` = 'M/EB' OR `emp_leave`.`des_name` = 'M/CIS' OR `emp_leave`.`des_name` = 'M/FAS' OR `emp_leave`.`des_name` = 'M/EMS' OR `emp_leave`.`des_name` = 'M/MLB' OR `emp_leave`.`des_name` = 'AM/PSI' OR `emp_leave`.`des_name` = 'AM/SB' OR `emp_leave`.`des_name` = 'GM/BOP' OR `emp_leave`.`des_name` = 'PPCI-POSTAGIRO' OR `emp_leave`.`des_name` = 'OMS-GM/BOP') AND !(`emp_leave`.`des_name` = 'M/HR' OR `emp_leave`.`des_name` = 'M/CF&A' OR `emp_leave`.`des_name` = 'M/CP' OR `emp_leave`.`des_name` = 'H/REM' OR `emp_leave`.`des_name` = 'OMS-GM/CRM') ORDER BY `emp_leave`.`apply_date` DESC";

      }elseif ($this->session->userdata('user_type')=='ADMIN' ) {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id` 
      WHERE `emp_leave`.`leave_status` != 'Canceled' ORDER BY `emp_leave`.`apply_date` DESC";

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
      WHERE  `emp_leave`.`isPMG` ='$isPMG' AND `emp_leave`.`isACC` ='$isACC'";

		$query=$this->db->query($sql);
		$result = $query->result();
		return $result;
	}
    public function getBatchToBank($batchNo)
    {
        $sql = "SELECT `leave_batch`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`middle_name`,`em_code`,
      `leave_types`.`type_id`,`name`,
      `bank_info`.*
      FROM `leave_batch`
      LEFT JOIN `employee` ON `leave_batch`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `leave_batch`.`typeid`=`leave_types`.`type_id`
      LEFT JOIN  `bank_info` ON  `bank_info`.`em_id` = `leave_batch`.`em_id`
      WHERE  `leave_batch`.`batchNo` = '$batchNo' AND `leave_batch`.`fare_amount` != 0 ";

        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getApprover($batchNo)
    {
        $sql = "SELECT `batches`.*,
      `employee`.*
      FROM `batches`
      LEFT JOIN `employee` ON `batches`.`em_id`=`employee`.`em_id`
      WHERE  `batches`.`batch_no` = '$batchNo'";

        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getSum($batchNo)
    {
       $sql = "SELECT SUM(`leave_batch`.`fare_amount`) AS `fare_amount` 
            FROM `leave_batch` WHERE  `leave_batch`.`batchNo` = '$batchNo'";

        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function getSum2($batchNo)
    {
       $sql = "SELECT SUM(`leave_batch`.`faredistrictvillage`) AS `faredistrictvillage` 
            FROM `leave_batch` WHERE  `leave_batch`.`batchNo` = '$batchNo'";

        $query=$this->db->query($sql);
        $result = $query->row();
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
    public function updateDay($id,$update){
    $this->db->where('id', $id);
    $this->db->update('assign_leave',$update);         
    }
    public function updateLeaveDay($id,$data,$year){
    $this->db->where('emp_id', $id);
    $this->db->where('dateyear', $year);
    $this->db->update('assign_leave',$data);         
    }
   public function Update_Leave_Status($leaveid,$update1){
    $this->db->where('id', $leaveid);
    $this->db->update('emp_leave',$update1);         
    }
    public function comple_leave($id,$update){
    $this->db->where('id', $id);
    //$this->db->where('leave_status', 'Approve');
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
     public function Update_Batch($btchNo,$data){
        $this->db->where('batch_no', $btchNo);
        $this->db->update('batches', $data);         
    }
    public function Update_Batch_Remove($id,$data){
        $this->db->where('batch_id', $id);
        $this->db->update('leave_batch', $data);         
    }
     public function Update_Leave_StatusHRtoCRM($id,$data){
        $this->db->where('id', $id);
        $this->db->update('emp_leave', $data);         
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
    public function getdesignation1($emid){
          $sql    = "SELECT * FROM `employee` WHERE `em_id`='$emid'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          //$id = $result->des_id;

          return $result;
      }
       public function Search_Emid($pfno){

          $sql    = "SELECT * FROM `employee` WHERE `em_code`='$pfno'";
          $query  = $this->db->query($sql);
          $result = $query->row();

          return $result;
      }
      public function getdesignation2($des_id){

          $sql    = "SELECT * FROM `designation` WHERE `id`='$des_id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          //$id = $result->des_id;

          return $result;
      }
      public function getLeaveBatch($batchNo){
          $sql = "SELECT `leave_batch`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
       FROM `leave_batch`
       INNER JOIN `employee` ON `leave_batch`.`em_id`=`employee`.`em_id`
       INNER JOIN `leave_types` ON `leave_batch`.`typeid`=`leave_types`.`type_id`
        WHERE `leave_batch`.`batchNo`='$batchNo' ";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result; 
      }

public function leavecount(){
    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $region = $basicinfo->em_region;
      $em_id = $basicinfo->em_id;

      if ($this->session->userdata('user_type')=='EMPLOYEE' || $this->session->userdata('user_type')=='SUPERVISOR') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_id` ='$em_id' AND `emp_leave`.`leave_status` != 'Canceled'";

      }elseif ($this->session->userdata('user_type')=='HOD') {

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`dep_id` ='$basicinfo->dep_id' AND `employee`.`em_region`='$region' AND `emp_leave`.`leave_status` != 'Canceled'";

      }elseif ($this->session->userdata('user_type')=='RM') {

          $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `employee`.`em_region` ='$region' AND `emp_leave`.`leave_status` != 'Canceled'";
      }elseif ($this->session->userdata('user_type')=='ACCOUNTANT') {

          $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
       WHERE `emp_leave`.`leave_status` != 'Canceled'";
      }elseif ($this->session->userdata('user_type')=='PMG') {

      $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`des_name` = 'H/CIPA' OR `emp_leave`.`des_name` = 'H/S&I' OR `emp_leave`.`des_name` = 'H/A&I' OR `emp_leave`.`des_name` = 'H/PMU' OR `emp_leave`.`des_name` = 'H/UPU-RTC' OR `emp_leave`.`des_name` = 'CS' OR `emp_leave`.`des_name` = 'GM/CRM' OR `emp_leave`.`des_name` = 'GM/BOP' AND `emp_leave`.`leave_status` != 'Canceled'";
    }elseif ($this->session->userdata('user_type')=='BOP') {

      $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`des_name` = 'RM' OR `emp_leave`.`des_name` = 'M/MKT' OR `emp_leave`.`des_name` = 'M/EB' OR `emp_leave`.`des_name` = 'M/CIS' OR `emp_leave`.`des_name` = 'M/FAS' OR `emp_leave`.`des_name` = 'M/EMS' OR `emp_leave`.`des_name` = 'M/MLB' OR `emp_leave`.`des_name` = 'AM/PSI' OR `emp_leave`.`des_name` = 'AM/SB' OR `emp_leave`.`des_name` = 'GM/BOP' AND `emp_leave`.`leave_status` != 'Canceled'";
      
    }elseif ($this->session->userdata('user_type')=='CRM') {

      $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      INNER JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      INNER JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE  `emp_leave`.`des_name` = 'M/HR' OR `emp_leave`.`des_name` = 'M/CF&A' OR `emp_leave`.`des_name` = 'M/CP' OR `emp_leave`.`des_name` = 'H/REM' OR `emp_leave`.`des_name` = 'OMS-GM/CRM' AND `emp_leave`.`leave_status` != 'Canceled' ORDER BY `emp_leave`.`apply_date` DESC";

    }else{

        $sql = "SELECT `emp_leave`.*,
      `employee`.`em_id`,`first_name`,`last_name`,`em_code`,
      `leave_types`.`type_id`,`name`
      FROM `emp_leave`
      LEFT JOIN `employee` ON `emp_leave`.`em_id`=`employee`.`em_id`
      LEFT JOIN `leave_types` ON `emp_leave`.`typeid`=`leave_types`.`type_id`
      WHERE `emp_leave`.`leave_status` != 'Canceled'";

      }
    
       $query = $this->db->query($sql);
        return $query->num_rows();
    }
    }
?>    
