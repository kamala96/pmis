<?php

	class Dashboard_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
    public function insert_tododata($data){
        $this->db->insert('to-do_list',$data);
    }
    public function GettodoInfo($userid){
        $sql = "SELECT * FROM `to-do_list` WHERE `user_id`='$userid' ORDER BY `date` DESC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetRunningProject(){
        $sql = "SELECT * FROM `project` WHERE `pro_status`='running' ORDER BY `id` DESC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetHolidayInfo(){
        $sql = "SELECT * FROM `holiday` ORDER BY `id` DESC LIMIT 10";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	public function UpdateTododata($id,$data){
		$this->db->where('id', $id);
		$this->db->update('to-do_list',$data);		
	}  

    public  function get_ems_domestic_cash(){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash'  GROUP BY `sender_info`.`s_district`";
        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash' GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }      
    }
?>