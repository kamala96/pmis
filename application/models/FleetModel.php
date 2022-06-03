<?php
class FleetModel extends CI_Model{

	public function get_regions(){
	$region = $this->session->userdata('user_region');

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR' || $this->session->userdata('user_type') == 'RM') {
	$sql = "SELECT * FROM `em_region` WHERE `region_name`='$region'";
	}
	else{
        $sql = "SELECT * FROM `em_region` order by region_name asc";
	}
        $query  = $this->db->query($sql);
	$result = $query->result();
        return $result;
	}

	public function save_vehicle($img_url,$regno,$make,$model,$chasis,$engine,$capacity,$type,$insurance,$status,$region,$branch,$manufacture){
	$db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$sql = "insert into fleet_profile (photo,regno,make,model,chasis,engine,capacity,type,insurance,status,region,branch,operator,manufacture) values ('$img_url','$regno','$make','$model','$chasis','$engine','$capacity','$type','$insurance','$status','$region','$branch','$empid','$manufacture')";
	$query = $db2->query($sql);
	return $query;
        }

        public function s_vehicle($regno,$make,$model,$chasis,$engine,$capacity,$type,$insurance,$status,$region,$branch,$manufacture){
	$db2 = $this->load->database('otherdb', TRUE);
	$empid = $this->session->userdata('user_emid');
	$sql = "insert into fleet_profile (regno,make,model,chasis,engine,capacity,type,insurance,status,region,branch,operator,manufacture) values ('$regno','$make','$model','$chasis','$engine','$capacity','$type','$insurance','$status','$region','$branch','$empid','$manufacture')";
	$query = $db2->query($sql);
	return $query;
        }

    

    public function search_vehicle($region,$branch){
    $db2 = $this->load->database('otherdb', TRUE);
    $empid = $this->session->userdata('user_emid');
	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
	$sql = "SELECT * FROM fleet_profile WHERE region='$region' AND branch='$branch' AND operator='$empid'";
	}
	elseif($this->session->userdata('user_type') == 'RM'){
    $sql = "SELECT * FROM fleet_profile WHERE region='$region' AND branch='$branch'";
	}
	else{
    $sql = "SELECT * FROM fleet_profile WHERE region='$region' AND branch='$branch'";
	}
    
    $query = $db2->query($sql);
	$result = $query->result();
	return $result;
	}

	


}