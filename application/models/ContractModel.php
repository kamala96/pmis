<?php
class ContractModel extends CI_Model{
	
public function get_performance_target_list($empid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_target WHERE empid='$empid'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}


public function get_performance_employee_target_list(){
	$usertype = $this->session->userdata('user_type');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$designationid = $this->session->userdata('designationid');
	$departmentid = $this->session->userdata('departmentid');
	$empid = $this->session->userdata('user_emid');
        
    $db2 = $this->load->database('otherdb', TRUE);

        if($this->session->userdata('user_type') =='RM'){
		$sql = "select * from performance_target WHERE usertype='RM' AND region='$region'";
	    }
	    elseif($this->session->userdata('user_type') =='HOD'){
        $sql = "select * from performance_target WHERE usertype='HOD' AND departmentID='$departmentid'";
	    } else {
	    $sql = "select * from performance_target WHERE empid='$empid'";
	    }
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function counter_get_performance_employee_target_list(){
	$usertype = $this->session->userdata('user_type');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$designationid = $this->session->userdata('designationid');
	$departmentid = $this->session->userdata('departmentid');
	$empid = $this->session->userdata('user_emid');
        
    $db2 = $this->load->database('otherdb', TRUE);

        if($this->session->userdata('user_type') =='RM'){
		$sql = "select SUM(marks) as totalmarks from performance_target WHERE usertype='RM' AND region='$region'";
	    }
	    elseif($this->session->userdata('user_type') =='HOD'){
        $sql = "select SUM(marks) as totalmarks from performance_target WHERE usertype='HOD' AND departmentID='$departmentid'";
	    } else {
	    $sql = "select SUM(marks) as totalmarks from performance_target WHERE empid='$empid'";
	    }
		$query = $db2->query($sql);
		$result = $query->row();
		return $result;
}

public function counter_target_activity_info($targetid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select SUM(weight) as totalmarks from performance_indicators WHERE performace_target_id='$targetid'";
$query = $db2->query($sql);
$result = $query->row();
return $result;
}


public function get_performance_employee_target_list_approved(){
	$usertype = $this->session->userdata('user_type');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$designationid = $this->session->userdata('designationid');
	$departmentid = $this->session->userdata('departmentid');
	$empid = $this->session->userdata('user_emid');
        
    $db2 = $this->load->database('otherdb', TRUE);

        if($this->session->userdata('user_type') =='RM'){
		$sql = "select * from performance_target WHERE usertype='RM' AND region='$region' AND target_progress='received'";
	    }
	    elseif($this->session->userdata('user_type') =='HOD'){
        $sql = "select * from performance_target WHERE usertype='HOD' AND departmentID='$departmentid' AND target_progress='received'";
	    } else {
	    $sql = "select * from performance_target WHERE empid='$empid'";
	    }
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_approved_performance_target_list($empid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_target WHERE empid='$empid' AND target_progress='received'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_performance_indicators_list(){
	    $db2 = $this->load->database('otherdb', TRUE);
		$usertype = $this->session->userdata('user_type');
		$empid = $this->session->userdata('user_emid');
		
		if($this->session->userdata('user_type') =='ADMIN')
		{
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id";
		}
		elseif($this->session->userdata('user_type') =='RM' || $this->session->userdata('user_type')=='HOD'){
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE from performance_indicators.empid='$empid'
		";	
		}
		elseif($this->session->userdata('user_type') =='CRM')
		{
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE role_indicator='$usertype'";
		}
		elseif($this->session->userdata('user_type') =='BOP'){
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE role_indicator='$usertype' OR role_indicator='RM'";	
		}
		else
		{
		//PMG
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE role_indicator='$usertype' OR role_indicator='HOD'";
		}
		
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function search_performance_indicators_list($target,$usertype){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE performace_target_id='$target' AND role_indicator='$usertype'
		";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function usertype_search_indicators_list($target,$usertype){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE performace_target_id='$target' AND role_indicator='$usertype'
		";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function assigned_indicators_list(){
	    $db2 = $this->load->database('otherdb', TRUE);
		$empid = $this->session->userdata('user_emid');
		$sql = "select * from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE performance_indicators.empid='$empid' AND indicator_progress=1 AND indicator_status='received'";	
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function assigned_employee_task($empid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_tasks
		INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id
		WHERE performance_tasks.provided_by='$empid' AND performance_tasks.task_status='assigned'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function display_subact_attached($taskid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_subtask_evidence 
        INNER JOIN performance_sub_activities ON performance_sub_activities.sub_activities_id=performance_subtask_evidence.sub_actid
		WHERE performance_subtask_evidence.task_id='$taskid'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function my_task($empid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_tasks
		INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id
		WHERE performance_tasks.received_by='$empid' AND performance_tasks.task_status='assigned'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function view_task_list($empid,$fromdate,$todate){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * from performance_tasks
		INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		INNER JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id
		WHERE performance_tasks.received_by='$empid' AND DATE(performance_task_evidence.rating_created_at) BETWEEN '$fromdate' AND '$todate'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_assigned_task_performance($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.provided_by, 
SUM(performance_indicators.weight) AS totalassigned, 
SUM(performance_task_evidence.rating) AS totalmarked,
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned' AND 
DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate'
GROUP BY performance_tasks.provided_by
ORDER BY performance_tasks.task_created_at DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function new_get_assigned_task_performance($fromdate,$todate,$empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.provided_by, 
performance_tasks.indicator_id,
performance_indicators.weight,
performance_indicators.indicator_name,
COUNT(*) as totalassigned,
SUM(performance_task_evidence.rating) AS totalmarks,
AVG(performance_task_evidence.rating) AS taskaverage,
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned' AND DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate' AND performance_tasks.provided_by='$empid'
GROUP BY performance_tasks.provided_by,performance_tasks.indicator_id
ORDER BY performance_tasks.task_created_at DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function received_get_assigned_task_performance($fromdate,$todate,$empid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.received_by,
performance_tasks.indicator_id,
performance_indicators.weight,
performance_indicators.indicator_name,
performance_task_evidence.rating,
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned' AND performance_tasks.received_by='$empid'
AND DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate'
ORDER BY performance_tasks.task_created_at DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function general_received_get_assigned_task_performance($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.received_by,
performance_tasks.indicator_id,
performance_indicators.weight,
performance_indicators.indicator_name,
performance_task_evidence.rating,
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned'
AND DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate'
ORDER BY performance_tasks.task_created_at DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function group_general_received_get_assigned_task_performance($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.received_by,
performance_tasks.indicator_id,
performance_indicators.weight,
performance_indicators.indicator_name,
SUM(performance_task_evidence.rating),
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned'
AND DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate'
GROUP BY performance_tasks.received_by
ORDER BY SUM(performance_task_evidence.rating) DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function general_report_assigned_task_performance($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.provided_by, 
performance_tasks.indicator_id,
performance_indicators.weight,
performance_indicators.indicator_name,
COUNT(*) as totalassigned,
SUM(performance_task_evidence.rating) AS totalmarks,
AVG(performance_task_evidence.rating) AS taskaverage,
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned' AND DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate'
GROUP BY performance_tasks.provided_by,performance_tasks.indicator_id
ORDER BY performance_tasks.task_created_at DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function individaul_general_report_assigned_task_performance($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT 
performance_tasks.provided_by,
COUNT(*) as totalassigned,
SUM(performance_task_evidence.rating) AS totalmarks,
AVG(performance_task_evidence.rating) AS taskaverage,
performance_tasks.task_created_at
FROM performance_tasks
INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_tasks.indicator_id
LEFT JOIN performance_task_evidence ON performance_task_evidence.task_id=performance_tasks.performance_task_id 
WHERE performance_tasks.task_status='assigned' AND DATE(performance_tasks.task_created_at) BETWEEN '$fromdate' AND '$todate'
GROUP BY performance_tasks.provided_by
ORDER BY performance_tasks.task_created_at DESC";
$query = $db2->query($sql);
$result = $query->result();
return $result;
}

public function find_reports($fromdate,$todate){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT received_by, SUM(rating) as totalscore, COUNT(*) as totaltasks from performance_tasks INNER JOIN performance_task_evidence ON 
		performance_task_evidence.task_id=performance_tasks.performance_task_id
        WHERE DATE(performance_task_evidence.rating_created_at) BETWEEN '$fromdate' AND '$todate' GROUP BY received_by ORDER BY totalscore DESC";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function count_tasks($empid,$year){
$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from performance_tasks WHERE received_by='$empid' AND YEAR(task_created_at)='$year' and task_status='assigned'";
		$query = $db2->query($sql);
		$result = $query->num_rows();
		return $result;
}

public function update_task_status($taskid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_tasks SET task_status='canceled' WHERE performance_task_id='$taskid'";
		$query = $db2->query($sql);
		return $query;
}

public function reset_assigned_tasks(){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update  performance_indicators SET indicator_progress=1";
		$query = $db2->query($sql);
		return $query;
}

public function update_target($targetid,$name,$marks){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_target SET target_name='$name', marks='$marks' WHERE performance_target_id='$targetid'";
		$query = $db2->query($sql);
		return $query;
}

public function view_target_activities($targetid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_indicators WHERE performace_target_id='$targetid'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function check_evidence($empid,$taskid,$subtaskid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_subtask_evidence WHERE attached_by='$empid' AND sub_actid='$subtaskid' AND task_id='$taskid'";
		$query = $db2->query($sql);
		$result = $query->num_rows();
		return $result;
}


public function view_sub_activities($activityid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_sub_activities WHERE indicator_id='$activityid'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function attach_view_sub_activities($activityid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_sub_activities 
		INNER JOIN performance_indicators ON performance_indicators.performance_indicators_id=performance_sub_activities.indicator_id
		INNER JOIN performance_tasks ON performance_tasks.performance_task_id=performance_subtask_evidence.task_id
        LEFT JOIN performance_subtask_evidence ON performance_subtask_evidence.sub_actid=performance_sub_activities.sub_activities_id
		WHERE performance_sub_activities.indicator_id='$activityid'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function update_indicator($indicatorid,$name,$weight){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_indicators SET indicator_name='$name',weight='$weight'
		WHERE performance_indicators_id='$indicatorid'";
		$query = $db2->query($sql);
		return $query;
}

public function update_status_indicator($indicatorid,$status){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_indicators SET indicator_status='$status' WHERE performance_indicators_id='$indicatorid'";
		$query = $db2->query($sql);
		return $query;
}

public function update_sub_activity($activityid,$name){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_sub_activities SET sub_activity_name='$name' WHERE sub_activities_id='$activityid'";
		$query = $db2->query($sql);
		return $query;
}

public function delete_target($targetid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "delete from performance_target WHERE performance_target_id='$targetid'";
		$query = $db2->query($sql);
		return $query;
}

public function delete_sub_activity($activityid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "delete from performance_sub_activities WHERE sub_activities_id='$activityid'";
		$query = $db2->query($sql);
		return $query;
}

public function delete_indicator($indicatorid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "delete from performance_indicators WHERE performance_indicators_id='$indicatorid'";
		$query = $db2->query($sql);
		return $query;
}

public function submit_task_rating($evidenceid,$rating,$empid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "insert into performance_task_evidence (task_id,	rated_by,rating) values ('$evidenceid','$empid','$rating')";
		$query = $db2->query($sql);
		return $query;
}

public function update_indicator_status($indicatorid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_indicators SET indicator_progress=1 WHERE performance_indicators_id='$indicatorid'";
		$query = $db2->query($sql);
		return $query;
}

public function update_approved_activity($activityid,$status){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_indicators SET indicator_status='$status' WHERE performance_indicators_id='$activityid'";
		$query = $db2->query($sql);
		return $query;
}

public function approve_target_selected($target,$status){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_target SET target_progress='$status' WHERE performance_target_id='$target'";
		$query = $db2->query($sql);
		return $query;
}


public function update_assigned_task($taskid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "update performance_indicators SET indicator_progress=0 WHERE performance_indicators_id='$taskid'";
		$query = $db2->query($sql);
		return $query;
}

public function list_user_type_active_target($usertype){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select distinct target_name,performance_target_id from performance_indicators 
		INNER JOIN performance_target ON performance_target.performance_target_id=performance_indicators.performace_target_id
		WHERE role_indicator='$usertype' AND target_status=1";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_target_creator_info($target){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * FROM performance_target WHERE performance_target_id='$target'";
		$query = $db2->query($sql);
		$result = $query->row();
		return $result;
}

public function get_single_target($target){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_target WHERE performance_target_id='$target'";
		$query = $db2->query($sql);
		$result = $query->row();
		return $result;
}

public function count_pending_targets(){
	    $db2 = $this->load->database('otherdb', TRUE);
		if($this->session->userdata('user_type') =='BOP'){
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending' AND deptid IN(106,100,114,27,28,116,118)";
		}
		elseif($this->session->userdata('user_type') =='PMG'){
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending' AND deptid IN(48,50,38,39,103,105,29)";
		}
		elseif($this->session->userdata('user_type') =='CRM'){
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending' AND deptid IN(112,51,52,66)";	
		}
		else
		{
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending'";	
		}
		$query = $db2->query($sql);
		$result = $query->num_rows();
		return $result;
}

public function list_pending_targets(){
	    $db2 = $this->load->database('otherdb', TRUE);
		if($this->session->userdata('user_type') =='BOP'){
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending' AND deptid IN(106,100,114,27,28,116,118)";
		}
		elseif($this->session->userdata('user_type') =='PMG'){
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending' AND deptid IN(48,50,38,39,103,105,29)";
		}
		elseif($this->session->userdata('user_type') =='CRM'){
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending' AND deptid IN(112,51,52,66)";	
		}
		else
		{
		$sql = "SELECT * FROM performance_target WHERE target_progress='pending'";	
		}
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function add_target($name,$empid,$tmarks){
	$db2 = $this->load->database('otherdb', TRUE);
	$usertype = $this->session->userdata('user_type');
	$region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
	$designationid = $this->session->userdata('designationid');
	$departmentid = $this->session->userdata('departmentid');

	if($this->session->userdata('user_type') =='ADMIN' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='CRM'){
	$sql = "insert into performance_target (target_name,empid,marks,usertype,deptid,region,branch,departmentID) values ('$name','$empid','$tmarks','$usertype','$designationid','$region','$branch','$departmentid')";
	}
	else
	{
	$sql = "insert into performance_target (target_name,empid,marks,target_progress,usertype,deptid,region,branch,departmentID) values ('$name','$empid','$tmarks','pending','$usertype','$designationid','$region','$branch','$departmentid')";
	}
	$query = $db2->query($sql);
	return $query;
}

public function count_target_activities($targetid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_indicators WHERE performace_target_id='$targetid'";
		$query = $db2->query($sql);
		$result = $query->num_rows();
		return $result;
}

public function get_indicator_full_information($indicatorid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_indicators WHERE performance_indicators_id='$indicatorid'";
		$query = $db2->query($sql);
		$result = $query->row();
		return $result;
}


public function count_sub_activities($activityid){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_sub_activities WHERE indicator_id='$activityid'";
		$query = $db2->query($sql);
		$result = $query->num_rows();
		return $result;
}


public function list_approved_activities($target){
	    $db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM performance_indicators WHERE performace_target_id='$target'";
		$query = $db2->query($sql);
		$result = $query->result();
		return $result;
}

public function add_indicator($name,$weight,$targetid,$usertype,$empid){
	$db2 = $this->load->database('otherdb', TRUE);
    if($this->session->userdata('user_type') =='ADMIN' || $this->session->userdata('user_type') =='BOP' || $this->session->userdata('user_type') =='PMG' || $this->session->userdata('user_type') =='CRM'){
	$sql = "insert into performance_indicators (indicator_name,performace_target_id,role_indicator,weight,empid) values ('$name','$targetid','$usertype','$weight','$empid')";	
	}
	else
	{
	$sql = "insert into performance_indicators (indicator_name,performace_target_id,role_indicator,weight,empid,indicator_status) values ('$name','$targetid','$usertype','$weight','$empid','pending')";	
	}
	$query = $db2->query($sql);
	return $query;
}

public function add_sub_activity($value,$activityid,$empid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "insert into performance_sub_activities (sub_activity_name,created_by,indicator_id) values ('$value','$empid','$activityid')";
	$query = $db2->query($sql);
	return $query;
}

public function add_assigned_task($providedby,$receivedby,$taskid){
	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "insert into performance_tasks (provided_by,received_by,indicator_id) values ('$providedby','$receivedby','$taskid')";
	$query = $db2->query($sql);
	return $query;
}


public function list_usertype(){
	    $sql ="select * from user_type where id IN(9,10,11,1)";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
}

public function assign_list_employees(){
		$region = $this->session->userdata('user_region');
		$branch = $this->session->userdata('user_branch');
        $departmentid = $this->session->userdata('departmentid');

	    if($this->session->userdata('user_type') =='BOP'){
	    $sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE' AND designation.des_name IN('M/EMS','M/CIS','RM','M/MKT','M/FAS','M/EB','AM/PSI')";
		}
		elseif($this->session->userdata('user_type') =='PMG')
		{
		$sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE' AND designation.des_name IN('GM/BOP','GM/CRM','H/S&I','H/IA&I','M/UPU-RTC','H/PMU','CS')";	
		}
		elseif($this->session->userdata('user_type') =='CRM')
		{
		$sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE' AND designation.des_name IN('M/HR','M/CP','M/CFA','H/REM')";	
		}
		elseif($this->session->userdata('user_type') =='RM')
		{

		//RM
		if($region=="Dar es Salaam"){
		$sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE' AND employee.em_region='$region' AND em_branch NOT IN('Posta Head Office','Post Head Office')";	
	    }
	    else
	    {
        $sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE' AND employee.em_region='$region'";
	    }

		}
		elseif($this->session->userdata('user_type') =='HOD')
		{
	    //HOD
		$sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE' AND employee.em_region='$region' AND employee.dep_id='$departmentid'";	
		}
		else
		{
	    //HOD
		$sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.status='ACTIVE'";	
		}
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
}

public function submit_evidence($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('performance_subtask_evidence',$data);
}

public function update_assigned_task_information($data,$taskid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('performance_task_id', $taskid);
$db2->update('performance_tasks',$data); 
}

public function get_employee_info($empid){
	    $sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.em_id='$empid'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
}

public function get_employee_info_by_emcode($emcode){
	    $sql ="select * from employee 
		INNER JOIN designation ON designation.id=employee.des_id
		where employee.em_code='$emcode'";
		$query = $this->db->query($sql);
		$result = $query->row();
		return $result;
}

public function GetEmployeeById($region){
            $sql = "SELECT * FROM employee INNER JOIN designation ON designation.id=employee.des_id WHERE em_region='$region'";
		    $query = $this->db->query($sql);
		    $result = $query->result();
			foreach ($result as $row) {
			  $name = @$row->des_name.': '.@$row->first_name.'  '.@$row->middle_name.'  '.@$row->last_name.'-'.@$row->em_region;
			  $output .='<option value="'.$row->em_id.'">'.@$name.'</option>';
			}
			 return $output;
}
	
	
	
}