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
    public function getdistrict(){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `pcum_district`";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetZonesById($objid){
        $db2 = $this->load->database('otherdb', TRUE);

        $sql    = "SELECT * FROM `district_zone_tarrif` WHERE `district_id`='$objid'";
                  $query  = $db2->query($sql);
            $output="<option>--Select Zone--</option>";
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->zone_id.'">'.$row->zone_name.'</option>';
            }
             return $output;
    }
    public function GetZonesCityById($zoneid,$districtid){

        $db2 = $this->load->database('otherdb', TRUE);

        $sql    = "SELECT * FROM `tarrif_zone_district_price` WHERE `zone_id`='$zoneid' AND `district_id` = '$districtid'";
                  $query  = $db2->query($sql);
            $output="<option>--Select Zone--</option>";
            foreach ($query->result() as $row) {
              $output .='<option>'.$row->town_city.'</option>';
            }
             return $output;

    }
    public function pcum_price($weight,$zoneid,$city){

        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `tarrif_zone_district_price` WHERE `zone_id`='$zoneid' AND `weight` >= $weight AND `town_city` = '$city' LIMIT 1 ";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;

    }
    public function activestaffsummary(){
        $sql = "SELECT count(`id`) as `value`,`em_region` FROM `employee` WHERE `status`='ACTIVE' AND `employee`.`em_role` != 'AGENT' GROUP BY `em_region` ORDER BY `em_region` ASC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function retiredstaffsummary(){
        $sql = "SELECT count(`id`) as `value`,`em_region` FROM `employee` WHERE `status`='RETIRED' GROUP BY `em_region` ORDER BY `em_region` ASC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getgraphdata(){
        $sql = "SELECT YEAR(`employee`.`em_joining_date`) as `year`, COUNT(`employee`.`id`) as `value` FROM `employee` WHERE `employee`.`status` = 'ACTIVE' AND `employee`.`em_role` != 'AGENT' GROUP BY YEAR(`employee`.`em_joining_date`) ORDER BY YEAR(`employee`.`em_joining_date`) DESC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getregion(){
        $sql = "SELECT * FROM `em_region` ORDER BY `region_name` ASC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function countleaveon($rname){
        $sql = "SELECT count(`emp_leave`.`id`) as `leaveon`,`employee`.`em_region` FROM `employee` INNER JOIN `emp_leave` ON `emp_leave`.`em_id` = `employee`.`em_id` WHERE `emp_leave`.`leave_status` = 'Approve' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function expetedtoretire($rname){

        $date = date('Y');
        $sql = "SELECT COUNT(`employee`.`id`) as `year` FROM `employee` WHERE YEAR(`employee`.`em_birthday`)+60 = '$date' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT' ";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function expetedtoretire1($rname){
        $date = date('Y')+1;
        $sql = "SELECT COUNT(`employee`.`id`) as `year1` FROM `employee` WHERE YEAR(`employee`.`em_birthday`)+60 = '$date' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function expetedtoretire2($rname){
        $date = date('Y')+2;
        $sql = "SELECT COUNT(`employee`.`id`) as `year2` FROM `employee` WHERE YEAR(`employee`.`em_birthday`)+60 = '$date' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function countleaveoff($rname){
        $sql = "SELECT count(`emp_leave`.`id`) as `leaveoff`,`employee`.`em_region` FROM `employee` INNER JOIN `emp_leave` ON `emp_leave`.`em_id` = `employee`.`em_id` WHERE `emp_leave`.`leave_status` = 'Complete' AND `employee`.`em_region` = '$rname'";
        $query=$this->db->query($sql);
        $result = $query->row();
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
        $id = $this->session->userdata('user_login_id');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash'  GROUP BY `sender_info`.`s_district`";

        }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash' AND `sender_info`.`operator` = '$id'  GROUP BY MONTH(`sender_info`.`date_registered`) ORDER BY MONTH(`sender_info`.`date_registered`)  ASC";


        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash' GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_ems_international(){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $id = $this->session->userdata('user_login_id');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  GROUP BY `sender_info`.`s_district`";

        }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`operator` = '$id'  GROUP BY MONTH(`sender_info`.`date_registered`) ORDER BY MONTH(`sender_info`.`date_registered`)  ASC";


        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_ems_domestic_bill(){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $id = $this->session->userdata('user_login_id');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND (`sender_info`.`s_pay_type` = 'PrePaid' OR `sender_info`.`s_pay_type` = 'PostPaid' )  GROUP BY `sender_info`.`s_district`";

        }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND (`sender_info`.`s_pay_type` = 'PrePaid' OR `sender_info`.`s_pay_type` = 'PostPaid' ) AND `sender_info`.`operator` = '$id'  GROUP BY MONTH(`sender_info`.`date_registered`) ORDER BY MONTH(`sender_info`.`date_registered`)  ASC";

        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND (`sender_info`.`s_pay_type` = 'PrePaid' OR `sender_info`.`s_pay_type` = 'PostPaid' ) GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function generate_report_over_all($catType,$year,$Type,$date1,$date2,$reportType,$month1,$month2,$month,$dairly){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $id = $this->session->userdata('user_login_id');

        if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "PMG" || $this->session->userdata('user_type') == "CRM"  || $this->session->userdata('user_type') == "BOP"){

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  date(`sender_info`.`date_registered`) = '$dairly' AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";
                
                } 


                }
                
          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";
          }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  YEAR(`sender_info`.`date_registered`) = '$year'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

          }
        
        }elseif ($this->session->userdata('user_type') == "RM") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
        AND  date(`sender_info`.`date_registered`) = '$dairly' AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";
          }else{

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

          }

        }elseif ($this->session->userdata('user_type')== "EMPLOYEE" || $this->session->userdata('user_type')== "AGENT") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

        } 

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
          }else{

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

          }


        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


    public  function generate_report_other_all($catType,$year,$date1,$date2,$reportType,$month1,$month2,$month,$dairly){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $id = $this->session->userdata('user_login_id');

        if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "PMG" || $this->session->userdata('user_type') == "CRM"  || $this->session->userdata('user_type') == "BOP"){

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType' AND  date(`sender_info`.`date_registered`) = '$dairly'   GROUP BY `sender_info`.`s_region`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";
                
                } 


                }
                
          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";
          }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  YEAR(`sender_info`.`date_registered`) = '$year'   GROUP BY `sender_info`.`s_region`";

          }
        
        }elseif ($this->session->userdata('user_type') == "RM") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
        AND  date(`sender_info`.`date_registered`) >= '$dairly' AND  GROUP BY `sender_info`.`s_district`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 GROUP BY `sender_info`.`s_district`";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 GROUP BY `sender_info`.`s_district`";
          }else{

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'   GROUP BY `sender_info`.`s_district`";

          }

        }elseif ($this->session->userdata('user_type')== "EMPLOYEE" || $this->session->userdata('user_type')== "AGENT") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

        } 

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
          }else{

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

          }


        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }            

    }
?>