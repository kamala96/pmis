<?php

class Notice_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    public function GetNotice(){

        $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $sub_role = $basicinfo->em_sub_role;
      $em_sect = $basicinfo->em_section_role;
      $dep_id = $basicinfo->dep_id;
      $em_region = $basicinfo->em_region;
      $em_branch = $basicinfo->em_branch;

        $sql = "SELECT * FROM `notice` WHERE (`notice`.`dep_id` = '$dep_id' OR `notice`.`dep_id` = 0 ) ORDER BY `notice`.`date` DESC;";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
        }
    public function Published_Notice($data){
        $this->db->insert('notice',$data);
    }
    public function GetNoticelimit(){
        $this->db->order_by('date', 'DESC');
		$query = $this->db->get('notice');
		$result =$query->result();
        return $result;        
    }
      public function GetParcellimit(){

        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
        $em_region = $basicinfo->em_region;

        $sql = "SELECT `parcel_info`.*,
        `sender_info`.*,
        `receiver_info`.*
        FROM `parcel_info`
        LEFT JOIN `sender_info` ON `sender_info`.`sender_id`= `parcel_info`.`sender_id`
        LEFT JOIN `receiver_info` ON `receiver_info`.`receiver_id`= `parcel_info`.`receiver_id`
        WHERE `sender_info`.`sender_region` = '$em_region' OR `receiver_info`.`receiver_region` = '$em_region'";

        $query=$this->db->query($sql);
        $result =$query->result();
        return $result;       
    }

    public function GetBulkList()
    {
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
        $em_region = $basicinfo->em_region;
        
        $sql = "SELECT * FROM `bulk` WHERE `region_from`='$em_region' OR `region_to`='$em_region'";
        $query=$this->db->query($sql);
        $result =$query->result();
        return $result; 
    }    
}
?>