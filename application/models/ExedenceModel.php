<?php
class ExedenceModel extends CI_Model{

public function get_excedence_service(){
		$db2 = $this->load->database('otherdb', TRUE);
        $sql = "select * from exedence_services where service_status=1";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
}

public function get_excedence_request(){
                $db2 = $this->load->database('otherdb', TRUE);
                $sql = "select * from exedence_requests where request_status=1";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;
}


public function count_pending_issues(){
        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $empid = $this->session->userdata('user_emid');
        $todaydate = date("Y-m-d");

         if($this->session->userdata('sub_user_type')=="TECHNICAL" || $this->session->userdata('user_type')=="RM"){
         $sql = "SELECT * from exedence_issues where issue_status='Pending' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="RM") {
          $sql = "SELECT * from exedence_issues where issue_status='Pending' AND region='$region' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="SUPER ADMIN") {
         $sql = "SELECT * from exedence_issues where issue_status='Pending' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } else {
         $sql = "SELECT * from exedence_issues where issue_status='Pending' AND createdby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         }

		$query=$db2->query($sql);
		$result = $query->num_rows();
		return $result;
}

public function count_received_issues(){
        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $empid = $this->session->userdata('user_emid');
         $todaydate = date("Y-m-d");

	 if($this->session->userdata('sub_user_type')=="TECHNICAL"){
         $sql = "SELECT * from exedence_issues where issue_status='Received' AND receivedby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="RM") {
         $sql = "SELECT * from exedence_issues where issue_status='Received' AND region='$region' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="SUPER ADMIN") {
         $sql = "SELECT * from exedence_issues where issue_status='Received' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } else {
         $sql = "SELECT * from exedence_issues where issue_status='Received' AND createdby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         }

		$query=$db2->query($sql);
		$result = $query->num_rows();
		return $result;
}

public function count_solved_issues(){
        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $empid = $this->session->userdata('user_emid');
         $todaydate = date("Y-m-d");


	 if($this->session->userdata('sub_user_type')=="TECHNICAL"){
         $sql = "SELECT * from exedence_issues where issue_status='Solved' AND receivedby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="RM") {
         $sql = "SELECT * from exedence_issues where issue_status='Solved' AND region='$region' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="SUPER ADMIN") {
         $sql = "SELECT * from exedence_issues where issue_status='Solved' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } else {
         $sql = "SELECT * from exedence_issues where issue_status='Solved' AND createdby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         }

		$query=$db2->query($sql);
		$result = $query->num_rows();
		return $result;
}

public function count_closed_issues(){
        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $empid = $this->session->userdata('user_emid');
        $todaydate = date("Y-m-d");


         if($this->session->userdata('sub_user_type')=="TECHNICAL"){
         $sql = "SELECT * from exedence_issues where issue_status='Closed' AND receivedby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="RM") {
         $sql = "SELECT * from exedence_issues where issue_status='Closed' AND region='$region' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="SUPER ADMIN") {
         $sql = "SELECT * from exedence_issues where issue_status='Closed' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } else {
         $sql = "SELECT * from exedence_issues where issue_status='Closed' AND createdby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         }

                $query=$db2->query($sql);
                $result = $query->num_rows();
                return $result;
}

public function count_cancelation_issues(){
        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $empid = $this->session->userdata('user_emid');
        $todaydate = date("Y-m-d");

         if($this->session->userdata('user_type')=="RM") {
         $sql = "SELECT * from exedence_issues where issue_status='PendingRequest' AND region='$region' AND request_type='Cancelation Incident' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="BOP") {
         $sql = "SELECT * from exedence_issues where issue_status='ApprovedByRM' AND request_type='Cancelation Incident' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } elseif ($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="SUPER ADMIN") {
         $sql = "SELECT * from exedence_issues where request_type='Cancelation Incident' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         } else {
         $sql = "SELECT * from exedence_issues where request_type='Cancelation Incident' AND createdby='$empid' AND DATE(exedence_issues.issue_created_at)='$todaydate'";
         }

                $query=$db2->query($sql);
                $result = $query->num_rows();
                return $result;
}


public function find_issues($fromdate,$todate,$region,$status,$request){
    $db2 = $this->load->database('otherdb', TRUE);
    $rmregion = $this->session->userdata('user_region');
    $empid = $this->session->userdata('user_emid');

    $qry = "SELECT * from exedence_issues 
    INNER JOIN exedence_services ON exedence_services.service_id=exedence_issues.serviceid
	WHERE ";

    if($this->session->userdata('sub_user_type')=="TECHNICAL"){

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(exedence_issues.issue_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }
    if($request != '') {
    $qry .= "exedence_issues.request_type='".$request."' AND ";
    }
    if($status != '') {
    if($status=="Pending"){
    $qry .= "exedence_issues.issue_status='".$status."' AND ";
    } else {
    $qry .= "exedence_issues.issue_status='$status' AND exedence_issues.receivedby='$empid' AND ";
    }
    }

    } elseif($this->session->userdata('user_type')=="RM"){

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(exedence_issues.issue_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }
    if($rmregion != '') {
    $qry .= "exedence_issues.region='".$rmregion."' AND ";
    }
    if($request != '') {
    $qry .= "exedence_issues.request_type='".$request."' AND ";
    }
    if($status != '') {
    $qry .= "exedence_issues.issue_status='".$status."' AND ";
    }

    } elseif($this->session->userdata('user_type')=="ADMIN" || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="SUPER ADMIN"){

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(exedence_issues.issue_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }
    if($region != '') {
    $qry .= "exedence_issues.region='".$region."' AND ";
    }
    if($request != '') {
    $qry .= "exedence_issues.request_type='".$request."' AND ";
    }
    if($status != '') {
    $qry .= "exedence_issues.issue_status='".$status."' AND ";
    }

    } else {

    if($fromdate != '' && $todate != '') {
    $qry .= "DATE(exedence_issues.issue_created_at) BETWEEN '$fromdate' AND '$todate' AND ";
    }
    if($status != '') {
     $qry .= "exedence_issues.issue_status='".$status."' AND ";
    }
    if($request != '') {
    $qry .= "exedence_issues.request_type='".$request."' AND ";
    }
    if($empid != '') {
     $qry .= "exedence_issues.createdby='".$empid."' AND ";
    }

    } 

    //$qry .= 'ORDER BY issue_created_at DESC';
    $qry .= '1 ORDER BY issue_created_at DESC';
    //$db2->order_by("issue_created_at", "desc");
    $query = $db2->query($qry);
    $result = $query->result();
    return $result;
}


public function update_issue($data,$issueid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('issue_id',$issueid);
$db2->update('exedence_issues',$data); 
}


public function save_issue($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('exedence_issues',$data);
}

public function save_issue_solution($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('exedence_issues_solution',$data);
}

public function user_info($empid){
    $sql = "select * from employee where em_id='$empid'";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result;
}

public function lists_charts($issueid){
$db2 = $this->load->database('otherdb', TRUE);
$qry = "SELECT * FROM exedence_issues_solution WHERE issueid='$issueid' order by solution_created_at ASC";
$query=$db2->query($qry);
$result = $query->result();
return $result;
}


////////////////////////////////////STATISTICS
public function get_incident_performance(){
        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $empid = $this->session->userdata('user_emid');

    if($this->session->userdata('sub_user_type')=="TECHNICAL"){
    $qry = "SELECT exedence_services.service_name as status,  COUNT(exedence_issues.issue_id) as value from exedence_issues 
    INNER JOIN exedence_services ON exedence_services.service_id=exedence_issues.serviceid WHERE exedence_issues.receivedby='$empid' GROUP BY exedence_services.service_name";
         } elseif ($this->session->userdata('user_type')=="RM") {
    $qry = "SELECT branch as status, COUNT(issue_id) as value from exedence_issues WHERE region='$region' GROUP BY branch";
         } else {
    $qry = "SELECT region as status, COUNT(issue_id) as value from exedence_issues GROUP BY region";
         }

                $query=$db2->query($qry);
                $result = $query->result();
                return $result;
}


///////////////////END OF STATISTICS



}