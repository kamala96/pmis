<?php

class Box_Application_model extends CI_Model{


	function __consturct(){
		parent::__construct();
    	//$this->db2 = $this->load->database('otherdb', TRUE);
	}

public function GetBasic($id){
			  $sql = "SELECT `employee`.*,
			  `designation`.*,
			  `department`.*
			  FROM `employee`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  WHERE `em_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;
			}
	public  function get_box_renters(){

		$db2 = $this->load->database('otherdb', TRUE);
		$query = $db2->get('box_tariff');
		$result = $query->result();
		return $result;

	}
	public function get_contract_list(){
		$query = $this->db->get('contract');
		$result = $query->result();
		return $result;
	}
	public function get_contract_lists()
	{
		$sql = "SELECT `contract`.*,
			  `contract_type`.*
			  FROM `contract`
			  LEFT JOIN `contract_type` ON `contract_type`.`cont_id`=`contract`.`cont_type`";
			  $query=$this->db->query($sql);
				$result = $query->result();
				return $result;
	}
	public  function ems_cat(){

		$db2 = $this->load->database('otherdb', TRUE);
		$query = $db2->get('ems_tariff_category');
		$result = $query->result();
		return $result;

	}
	public  function get_box_numbers1(){

		$db2 = $this->load->database('otherdb', TRUE);
		$query = $db2->get('box_numbers');
		$result = $query->result();
		return $result;

	}

	public function getValueForEdit($editId){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `box_numbers` WHERE `box_id`='$editId'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_region($id,$type){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`id` = '$id' AND `transactions`.`PaymentFor`= '$type'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_region_bag($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM bags WHERE bag_id = '$id'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_box_price($tariffcat){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `box_tariff_price` WHERE `btp_id`='$tariffcat'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public function get_bill_cust_details($cun){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `ems_bill_companies` WHERE `com_id`='$cun'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public function save_address_details($add){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('customer_address',$add);
	}
	public function save_location($data){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('location_management',$data);
	}
	public function Save_Customer_Info($data){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('credit_customer',$data);
	}
	public function save_contract($data){
		$this->db->insert('contract',$data);
	}
	public function Save_SupervisorJob($data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('supervisor_attendance',$data);
	}
	public function save_counter($data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('counters',$data);
	}
	public function save_counter_service($cs){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('counter_services',$cs);
	}
	public function save_bag($bag){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('bags',$bag);
	}
	public function get_contract_byId($id){

		$sql    = "SELECT `contract_type`.*,
			  `agreement_type`.*,
			  `contract`.*
			  FROM `contract`
			LEFT JOIN `contract_type` ON `contract_type`.`cont_id`=`contract`.`cont_type`
			LEFT JOIN `agreement_type` ON `agreement_type`.`contract_id`= `contract_type`.`cont_id` WHERE `contract`.`contid`='$id'";

		$query  = $this->db->query($sql);
		$result = $query->row();
		return $result;
	}
	public function save_despatch_info($data){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('despatch',$data);
	}
	public function Save_Derivery($data){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('deriver_info',$data);
	}
	public function save_box_number($boxs){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('box_numbers',$boxs);
	}
	public function Save_number_info($data){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('pre_post_number',$data);
	}
	public function save_services($data){
		$db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('emp_services',$data);
      }
	public function geTariffCategoryById($bt_id){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('bt_id',$bt_id);
		$db2->order_by('box_tariff_category');
		$query = $db2->get('box_tariff_price');

		foreach ($query->result() as $row) {
			$output .='<option value="'.$row->btp_id.'">'.$row->box_tariff_category.'</option>';
		}
		return $output;
	}
    public function get_services_byEmIds($id){

		  $db2 = $this->load->database('otherdb', TRUE);
          $sql = "SELECT `counter_services`.*, `emp_services`.*
          FROM `counter_services`
          LEFT JOIN `emp_services` ON `emp_services`.`serv_id`=`counter_services`.`serv_id`
           WHERE `counter_services`.`assign_to` = '$id' AND `counter_services`.`assign_status` = 'Assign'";
          $query  = $db2->query($sql);
          $result = $query->result();
          return $result;
      }
      public function get_services_shift(){

      	  $id = $this->session->userdata('user_login_id');
      	  $getInfo = $this->GetBasic($id);
		  $db2 = $this->load->database('otherdb', TRUE);
          $sql = "SELECT `counter_services`.*, `counters`.*
          FROM `counter_services`
          LEFT JOIN `counters` ON  `counters`.`counter_id` = `counter_services`.`c_id`
             WHERE `counters`.`counter_region` = '$getInfo->em_region' AND `counters`.`counter_branch` = '$getInfo->em_branch' AND `counter_services`.`cs_id` IN(SELECT MAX(`counter_services`.`cs_id`) FROM `counter_services` GROUP BY `counter_services`.`assign_to`) ORDER BY `counter_services`.`registered_date` DESC";
          $query  = $db2->query($sql);
          $result = $query->result();
          return $result;
      }
	  public function get_counter_byEmId($id){

		  $db2 = $this->load->database('otherdb', TRUE);
          $sql = "SELECT `counter_services`.*, `counters`.*
          FROM `counter_services`
          LEFT JOIN `counters` ON `counters`.`counter_id`=`counter_services`.`c_id`
           WHERE `counter_services`.`assign_to` = '$id' ORDER BY cs_id DESC LIMIT 1";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }
      public function check_counter_service($emid){

		  $db2 = $this->load->database('otherdb', TRUE);
          $sql = "SELECT `counter_services`.*, `counters`.*
          FROM `counter_services`
          LEFT JOIN `counters` ON `counters`.`counter_id`=`counter_services`.`c_id`
           WHERE `counter_services`.`assign_to` = '$emid' AND `counter_services`.`assign_status`='Assign' ORDER BY cs_id DESC LIMIT 1";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }
	   public function delete_servc_emp($emid){
		      $db2 = $this->load->database('otherdb', TRUE);
			  $db2->delete('counter_services',array('assign_to'=> $emid));
		  }
		  public function delete_entries($accno){
		      $db2 = $this->load->database('otherdb', TRUE);
			  $db2->delete('credit_customer',array('acc_no'=> $accno));
		  }
	public  function get_box_list(){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
		`customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
		LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX'  ORDER BY `transactions`.`id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_box_list_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff`.*,`box_tariff_price`.*,

		`customer_address`.*,`box_numbers`.* FROM `customer_details`
		LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`bt_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `box_tariff` ON `box_tariff`.`bt_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		WHERE `customer_details`.`details_cust_id` = '$id'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_box_payment_list_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
		`customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
		LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`CustomerID` = '$id'  ORDER BY `transactions`.`id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_list(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";



		}elseif($this->session->userdata('user_type') == 'RM'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN'){
			
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_list_international(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid' AND  `sender_info`.`type_ems` = 'International'
			ORDER BY `sender_info`.`sender_id` DESC ";



		}elseif($this->session->userdata('user_type') == 'RM'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' AND  `sender_info`.`type_ems` = 'International' ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND  `sender_info`.`type_ems` = 'International' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_ems_listSearch($date,$month){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$id = $emid;
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$d1date = date('d',strtotime($date));
				$m1date = date('m',strtotime($date));
				$y1date = date('Y',strtotime($date));

				$month1 = explode('-', $month);

				$day = @$month1[0];
				$year = @$month1[1];

		if ($this->session->userdata('user_type') == 'EMPLOYEE') {

			if (!empty($date) ) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

		   }else{

		   	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

		   }
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
			if (!empty($date) ) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' ORDER BY `sender_info`.`sender_id` DESC ";

		   }else{

		   	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

		   }
		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			if (!empty($date) ) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

		   }else{

		   	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

		   }
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}

	public function get_ems_sumSearch($date,$month){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$id = $emid;
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$d1date = date('d',strtotime($date));
				$m1date = date('m',strtotime($date));
				$y1date = date('Y',strtotime($date));

				$month1 = explode('-', $month);

				$day = @$month1[0];
				$year = @$month1[1];

		if ($this->session->userdata('user_type') == 'EMPLOYEE') {

			if (!empty($date) ) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		   }else{
		   	
		   	$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		   }
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR') {

			if (!empty($date) ) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch'";

		   }else{
		   	
		   	$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch'";

		   }
		}elseif($this->session->userdata('user_type') == 'ACCOUNTANT' || $this->session->userdata('user_type') == 'RM') {

			if (!empty($date) ) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date'";

		   }else{
		   	
		   	$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'";

		   }
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}
	public  function get_ems_listAcc($region,$date,$date2,$month,$month2,$year4,$type){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$d1date = date('d',strtotime($date));
				$m1date = date('m',strtotime($date));
				$y1date = date('Y',strtotime($date));

				$d2date = date('d',strtotime($date2));
				$m2date = date('m',strtotime($date2));
				$y2date = date('Y',strtotime($date2));

				$month1 = explode('-', $month);
				$month4 = explode('-', $month2);

				$day = @$month1[0];
				$year = @$month1[1];

				$day1 = @$month4[0];
				//$year2 = @$month4[1];

		if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM') {

			if (!empty($date) && !empty($date2)) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  ORDER BY `sender_info`.`sender_id` DESC ";


		   }else{

		   	if (!empty($month) && !empty($month2)) {

		   		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

		   	} else {

		   		if (!empty($month) || !empty($month2)) {
		   			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE  (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) = '$day' OR MONTH(`sender_info`.`date_registered`) = '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";
			
		   		} else {
		   			
		   	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) ORDER BY `sender_info`.`sender_id` DESC ";
		   		}
		   	}
		   }
			} else {
				
			if (!empty($date) && !empty($date2)) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type'  ORDER BY `sender_info`.`sender_id` DESC ";


		   }else{

		   	if (!empty($month) && !empty($month2)) {

		   		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE  (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

		   	} else {

		   		if (!empty($month)) {

		   	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`)= '$year') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

		   	} else {
		   			
		   	$sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`weight`,`s_region`,`s_district`,`track_number`,`sender_id`,`s_pay_type`,`receiver_info`.`r_region`,`transactions`.`office_name`,`paidamount`,`status`,`id`,`bill_status`,`billid` FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE  ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

		   		}
		   	}
		   }
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_list_incoming($trackno){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `receiver_info`.`r_region` = '$o_region' AND `receiver_info`.`branch` = '$o_branch' AND `sender_info`.`item_status` = 'Received' AND `sender_info`.`track_number` = '$trackno'";



		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `receiver_info`.`r_region` = '$o_region' AND `receiver_info`.`branch` = '$o_branch' AND `sender_info`.`item_status` = 'Received' AND `sender_info`.`track_number` = '$trackno'";

		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_item_from_bags($trn){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');


		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`isBagNo` = '$trn' ORDER BY `sender_info`.`sender_id` DESC ";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_list_pending(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'NotPaid') AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$id'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_list_pending_date($dateAssign){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		// $tz = 'Africa/Nairobi';
		// $tz_obj = new DateTimeZone($tz);
		// $today = new DateTime("now", $tz_obj);
		// $date = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'NotPaid') AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$dateAssign' AND `sender_info`.`operator` = '$id'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_list_by_emid($emid){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` != 'OldPaid' OR `transactions`.`status` != 'Cancel') AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";


		}elseif ($this->session->userdata('user_type') == 'EMPLOYEE') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` != 'OldPaid' OR `transactions`.`status` != 'Cancel') AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`date_registered` = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_pending_task($emid){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'NotPaid' OR `transactions`.`office_name` = 'Counter') AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function getEndingDate($emid,$date){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `supervisor_attendance` WHERE date(`endday_date`) = '$date' AND `supervisee_name` = '$emid' ";
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function getEndingDate1($emid){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `supervisor_attendance` WHERE  date(`endday_date`) = '$date'
		AND `supervisor_name` = '$emid' ";
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function check_derivery($sid){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `deriver_info` WHERE  `sender_id` = '$sid' ";
		$query=$db2->query($sql);
		$result = $query->row();

		return $result;
	}
	public  function get_credit_customer_list_byAccno($acc_no,$type){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

			WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			 ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
		}
	}
	public  function get_credit_customer_list_byAccnoMonth($acc_no,$type,$month){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		
		$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

			WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'  ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
		}
	}
	public  function getBillInformation($acc_no,$date_time,$type){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

			WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			AND `transactions`.`bill_status` = 'BILLING'
			AND  date(`sender_info`.`date_registered`) = '$date_time' AND `transactions`.`isBill_id` = 'No'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`


			WHERE `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			AND  date(`sender_info`.`date_registered`) = '$date_time' AND `transactions`.`bill_status` = 'BILLING' AND `transactions`.`isBill_id` = 'No'
			ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function getBillInformationMonth($acc_no,$month,$type,$year){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

			WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			AND  MONTH(`sender_info`.`date_registered`) = '$month' AND  YEAR(`sender_info`.`date_registered`) = '$year'
			AND `transactions`.`bill_status` = 'BILLING' AND `transactions`.`isBill_id` = 'No'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			WHERE `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no'
			AND  MONTH(`sender_info`.`date_registered`) = '$month' AND  YEAR(`sender_info`.`date_registered`) = '$year'
			AND `transactions`.`bill_status` = 'BILLING' AND `transactions`.`isBill_id` = 'No'
			ORDER BY `sender_info`.`sender_id` DESC";

		}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
	}

	public  function getSumVat($acc_no,$date_time,$type){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(item_vat) as item_vat,`sender_info`.* FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND date(`transactions`.`transactiondate`) = '$date_time'";

		}else{

			$sql = "SELECT SUM(item_vat) as item_vat FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no'
			AND date(`transactions`.`transactiondate`) = '$date_time'";

		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function getSumVatMonth($acc_no,$type,$month,$year){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(item_vat) as item_vat,`sender_info`.* FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND MONTH(`transactions`.`transactiondate`) = '$month'
			AND YEAR(`transactions`.`transactiondate`) = '$year'";

		}else{

			$sql = "SELECT SUM(item_vat) as item_vat FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND MONTH(`transactions`.`transactiondate`) = '$month'
			AND YEAR(`transactions`.`transactiondate`) = '$year'";

		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function getSumPrice($acc_no,$date_time,$type){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(item_price) as item_price FROM `transactions` LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no'
			AND date(`transactions`.`transactiondate`) = '$date_time'";

		}else{

			$sql = "SELECT SUM(item_price) as item_price FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no'
			AND date(`transactions`.`transactiondate`) = '$date_time'";
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function getSumPriceMonth($acc_no,$type,$month,$year){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(item_price) as item_price,`sender_info`.* FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND MONTH(`transactions`.`transactiondate`) = '$month'
			AND YEAR(`transactions`.`transactiondate`) = '$year'";

		}else{

			$sql = "SELECT SUM(item_price) as item_price FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND MONTH(`transactions`.`transactiondate`) = '$month'
			AND YEAR(`transactions`.`transactiondate`) = '$year'";

		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public  function getSumPriceTotal($acc_no,$date_time,$type){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(paidamount) as paidamount FROM `transactions` LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no'
			 AND date(`transactions`.`transactiondate`) = '$date_time'";

		}else{

			$sql = "SELECT SUM(paidamount) as paidamount FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no'
			AND date(`transactions`.`transactiondate`) = '$date_time'";
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}
	public  function getSumPriceTotalMonth($acc_no,$type,$month,$year){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(paidamount) as paidamount,`sender_info`.* FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND MONTH(`transactions`.`transactiondate`) = '$month'
			AND YEAR(`transactions`.`transactiondate`) = '$year'";

		}else{

			$sql = "SELECT SUM(paidamount) as paidamount FROM `transactions`
			LEFT JOIN 	`sender_info` ON `sender_info`.`sender_id` = `transactions`.`CustomerID`
			WHERE `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_pay_type` = '$type'
			AND `transactions`.`customer_acc` = '$acc_no' AND MONTH(`transactions`.`transactiondate`) = '$month'
			AND YEAR(`transactions`.`transactiondate`) = '$year'";

		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_credit_customer_list(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`

			WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`customer_type` = 'Bill'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			WHERE `sender_info`.`customer_type` = 'Bill'
			 ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_backoffice_list(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Back' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Back'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_item_received_list(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$o_branch'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_received_date_region_branch($date,$region,$branch){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					if (empty($date)) {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Received'
						AND `sender_info`.`s_region` = '$region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$district'
					  ORDER BY `sender_info`.`sender_id` DESC ";

					} else{

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Received'
						AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag'
						AND `sender_info`.`s_district` = '$o_branch'
						ORDER BY `sender_info`.`sender_id` DESC ";

					}

		}else{

			if (empty($date)) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Received'
				AND `sender_info`.`s_region` = '$region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$branch'
				ORDER BY `sender_info`.`sender_id` DESC ";

			} else {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Received'
				AND `sender_info`.`date_registered` = '$date' AND `transactions`.`bag_status` = 'isNotBag'
				ORDER BY `sender_info`.`sender_id` DESC ";

			}

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}

	public  function get_ems_per_date($year,$month,$day,$emid){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE YEAR(date_registered) = '$year' AND MONTH(date_registered) = '$month' AND DAY(date_registered) = '$day' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$emid' ORDER BY `transactions`.`id` DESC ";
		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE YEAR(date_registered) = '$year' AND MONTH(date_registered) = '$month' AND DAY(date_registered) = '$day'  ORDER BY `transactions`.`id` DESC ";
		}


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_per_Id($sid){

		
		$db2 = $this->load->database('otherdb', TRUE);
		
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE  `sender_info`.`sender_id` = '$sid'	";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_ems_per_date_by_emid($year,$month,$day,$emid){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'
		|| $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE YEAR(date_registered) = '$year' AND MONTH(date_registered) = '$month' AND DAY(date_registered) = '$day'
			AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `transactions`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' ORDER BY `transactions`.`id` DESC ";
		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_region_branch($region,$branch,$emid){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `sender_info`.`s_region` = '$region' AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC";
			
		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `sender_info`.`s_region` = '$region' AND `sender_info`.`s_district` = '$branch'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatch_out_per_date($year,$month,$day){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT *
			FROM `despatch`
			WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year'  ORDER BY `despatch`.`datetime` DESC";

		}else{

			$sql = "SELECT *
			FROM `despatch` WHERE  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC";

		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatch_in_per_date($year,$month,$day){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$date = date('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT *
			FROM `despatch`
			WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year'  ORDER BY `despatch`.`datetime` DESC";

		}else{

			$sql = "SELECT *
			FROM `despatch` WHERE  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC";

		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatch_out_per_month($year,$month1,$month2){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$date = date('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT *
			FROM `despatch`
			WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND MONTH(`despatch`.`datetime`) >= '$month1' AND  MONTH(`despatch`.`datetime`) <= '$month2'  ORDER BY `despatch`.`datetime` DESC";

		}else{

			$sql = "SELECT *
			FROM `despatch` WHERE  MONTH(`despatch`.`datetime`) >= '$month1' AND  MONTH(`despatch`.`datetime`) <= '$month2' ORDER BY `despatch`.`datetime`  DESC";

		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatch_in_per_month($year,$month1,$month2){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$date = date('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT *
			FROM `despatch`
			WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND MONTH(`despatch`.`datetime`) >= '$month1' AND  MONTH(`despatch`.`datetime`) <= '$month2'  ORDER BY `despatch`.`datetime` DESC";

		}else{

			$sql = "SELECT *
			FROM `despatch` WHERE  MONTH(`despatch`.`datetime`) >= '$month1' AND  MONTH(`despatch`.`datetime`) <= '$month2' ORDER BY `despatch`.`datetime`  DESC";

		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_back_list(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_international_back_list(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_back_list_admin(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_back_list_pending(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) != '$date'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) != '$date'  ORDER BY `sender_info`.`date_registered` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_back_list_per_date(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' ORDER BY `sender_info`.`date_registered` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_back_list2(){
		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`office_name` = 'Received' OR `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Despatch')  AND (`transactions`.`bag_status`= 'isNotBag' OR `transactions`.`bag_status`= 'isBag') AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`office_name` = 'Received' OR `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Despatch') AND (`transactions`.`bag_status`= 'isNotBag' OR `transactions`.`bag_status`= 'isBag') ORDER BY `sender_info`.`date_registered` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_bags_list(){
		$regionfrom = $this->session->userdata('user_region');

		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
				
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
			$sql = "SELECT `bag_number`,`bag_region_from`,`bag_region`,`date_created`,`bag_weight`,`bag_status` FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) = '$date' AND `ems_category` = 'Domestic' ORDER BY `bags`.`date_created` DESC";
		}else{
			$sql = "SELECT `bag_number`,`bag_region`,`bag_region_from`,`date_created`,`bag_weight`,`bags_status` FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) = '$date' AND `ems_category` = 'Domestic' ORDER BY `bags`.`bag_id` DESC";
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_pending_bags_list($date1,$month,$region){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
			$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch'  ORDER BY `bags`.`bag_id` DESC";
		}else{
			$sql = "SELECT `bag_number`,`bag_region`,`bag_region_from`,`date_created`,`bag_weight`,`bags_status`,`bag_branch` FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' ORDER BY `bags`.`bag_id` DESC ";
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatched_bags_list(){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
			$sql = "SELECT `bag_number`,`bag_region_from`,`bag_branch_from` FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'isDespatch' ORDER BY `bags`.`bag_id` DESC";
		}else{
			$sql = "SELECT `bag_number`,`bag_region_from`,`bag_branch_from`,`bag_region`,`bag_branch`,`bag_weight`,`bags_status`,`date_created` FROM `bags` WHERE  `bags`.`bags_status` = 'isDespatch' ORDER BY `bags`.`bag_id` DESC LIMIT 100";
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatched_bags_list_wakubwa($date,$month,$region){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			if (!empty($date)) {
				$sql = "SELECT * FROM `bags` WHERE date(`date_created`) = '$date'  AND `bags_status` = 'isDespatch' AND  `bags`.`bag_region` = '$o_region' AND `bags`.`bag_branch` = '$o_branch' ORDER BY `bags`.`bag_id` DESC";
			} elseif(!empty($month)){
				$sql = "SELECT * FROM `bags` WHERE MONTH(`date_created`) = '$day' AND YEAR(`date_created`) = '$year' AND `bags`.`bag_region_from` = '$region' AND `bags_status` = 'isDespatch' AND `bag_region` = '$o_region' ORDER BY `bags`.`bag_id` DESC";
			}
		}elseif($this->session->userdata('user_type') == 'RM'){

			if (!empty($date)) {
				$sql = "SELECT * FROM `bags` WHERE date(`date_created`) = '$date' AND `bags_status` = 'isDespatch' AND `bag_region` = '$o_region' ORDER BY `bags`.`bag_id` DESC";
			} elseif(!empty($month)){
				$sql = "SELECT * FROM `bags` WHERE MONTH(`date_created`) = '$day' AND YEAR(`date_created`) = '$year' AND `bags_status` = 'isDespatch' AND `bag_region` = '$o_region' ORDER BY `bags`.`bag_id` DESC";
			}
			
		}else{
			
			if (!empty($date)) {
				$sql = "SELECT * FROM `bags` WHERE date(`date_created`) = '$date' AND `bags`.`bag_region_from` = '$region' AND `bags_status` = 'isDespatch'";
			} elseif(!empty($month)){
				$sql = "SELECT * FROM `bags` WHERE MONTH(`date_created`) = '$day' AND YEAR(`date_created`) = '$year' AND `bags`.`bag_region_from` = '$region' AND `bags_status` = 'isDespatch'";
			}
			
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_box_numbers(){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('box_status','Vacance');
		$query = $db2->get('box_numbers');
		$result = $query->result();
		return $result;

	}

	public function update_box_numbers($box,$box_id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('box_id',$box_id);
		$db2->update('box_numbers',$box);
	}
	public function Update_SupervisorJob($data,$emid){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('assign_to',$emid);
		$db2->update('supervisor_attendance',$data);
	}
	public function update_number_info($ids,$data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('no_id',$ids);
		$db2->update('pre_post_number',$data);
	}
	public function update_bag($bag,$bagno){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('bag_number',$bagno);
		$db2->update('bags',$bag);
	}
	public function delete_bag($bagsNo){
		      $db2 = $this->load->database('otherdb', TRUE);
			  $db2->delete('bags',array('bag_number'=> $bagsNo));
		  }
	public function delete_despatch($despatchNo){
		      $db2 = $this->load->database('otherdb', TRUE);
			  $db2->delete('despatch',array('desp_no'=> $despatchNo));
		  }
	public function update_bags_list($id,$update){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('bag_id',$id);
		$db2->update('bags',$update);
	}
	public function update_despatch_list($id,$update){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('desp_no',$id);
		$db2->update('despatch',$update);
	}
	public function update_bags_list1($id,$update1){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('despatch_no',$id);
		$db2->update('bags',$update1);
	}
	public function update_box_number($boxupdate,$box_id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('box_id',$box_id);
		$db2->update('box_numbers',$boxupdate);
	}

	public function update_old_transactions($data1,$id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$id);
		$db2->update('transactions',$data1);
	}
	public function update_list($ids,$update2){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('isBagNo',$ids);
		$db2->update('transactions',$update2);
	}
	public function update_item_list($idc,$update2){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('sender_id',$idc);
		$db2->update('sender_info',$update2);
	}
	public function update_contract_item($data,$cont_id){
		$this->db->where('contid', $cont_id);
		$this->db->update('contract',$data);
	}
	public function update_contract($data,$cont_id){
		$this->db->where('cont_id', $cont_id);
		$this->db->update('contract',$data);
	}
	public function save_transactions($data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('transactions',$data);
	}
	public function save_invoice($datas){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('invoice',$datas);
	}
	public  function check_if_any($paytype){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM pre_post_number WHERE cust_type = '$paytype' ORDER BY no_id DESC LIMIT 1";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_bill_com_info($cId){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM credit_customer WHERE credit_id = '$cId' ";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function commission_agency_list(){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `commission_agency`.* FROM `commission_agency`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_commission_by_id($id,$service){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `commission_agency`.*,`transactions`.* FROM `commission_agency`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`commission_agency`.`com_id` WHERE `transactions`.`PaymentFor` = '$service' AND `transactions`.`CustomerID` = '$id'  ORDER BY `transactions`.`Id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function getPay($type){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "
		SELECT `credit_customer`.*,`transactions`.* FROM `transactions`
INNER JOIN `credit_customer` ON `transactions`.`CustomerID`=`credit_customer`.`credit_id` 
WHERE `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`status` = 'Paid' AND `credit_customer`.`acc_no` = '$type' ORDER BY `transactions`.`id` DESC LIMIT 1";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_Acc_no($zogo){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `credit_customer` 
WHERE `credit_customer`.`acc_no` = '$zogo' ORDER BY `credit_customer`.`credit_id` DESC LIMIT 1";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function getControNumber($acc_no,$date_time){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `transactions` WHERE `transactions`.`customer_acc` = '$acc_no'
		AND date(`transactions`.`transactiondate`) = '$date_time' AND `transactions`.`bill_status` = 'SUCCESS'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public  function getControNumberMonth($acc_no,$month,$year){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `transactions` 
		        WHERE `transactions`.`customer_acc` = '$acc_no'
		        AND MONTH(`transactions`.`transactiondate`) = '$month' 
		        AND YEAR(`transactions`.`transactiondate`) = '$year' AND `transactions`.`bill_status` = 'SUCCESS'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public  function get_customer_info($cust_id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
		`customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
		LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `customer_details`.`details_cust_id` ='$cust_id'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}
	

	public  function get_ems_report_Document_Day($year,$month,$day,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* 
		FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
		WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')  AND `sender_info`.`ems_type` = '$cate' AND YEAR(date(`sender_info`.`date_registered`)) = '$year' AND MONTH(date(`sender_info`.`date_registered`)) = '$month' AND DAY(date(`sender_info`.`date_registered`)) = '$day' AND  `sender_info`.`s_pay_type` = '$pay'  GROUP BY `sender_info`.`s_region`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	} 

	public  function get_ems_report_Document_Day_7($year,$month,$day,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* 
		FROM `sender_info` 
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
		INNER JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

		WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')  AND `sender_info`.`ems_type` = '$cate' AND YEAR(date(`sender_info`.`date_registered`)) = '$year' AND MONTH(date(`sender_info`.`date_registered`)) = '$month' AND DAY(date(`sender_info`.`date_registered`)) = '$day' AND  `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$o_region'  GROUP BY `sender_info`.`s_district`";
		
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Document_Year_7($year,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND  `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$o_region' GROUP BY `sender_info`.`s_district`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Document_MonthBtn_7($year,$monthf,$months,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND MONTH(`sender_info`.`date_registered`) >= '$monthf' AND MONTH(`sender_info`.`date_registered`) <= '$months' AND YEAR(`sender_info`.`date_registered`) <= '$year'  AND  `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$o_region'  GROUP BY `sender_info`.`s_district`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Document_Month_7($year,$day,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				
		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$day'  AND `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$o_region' GROUP BY `sender_info`.`s_district`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Document_Month($year,$day,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$day'  AND `sender_info`.`s_pay_type` = '$pay' GROUP BY `sender_info`.`s_region`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Document_MonthBtn($year,$monthf,$months,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND MONTH(`sender_info`.`date_registered`) >= '$monthf' AND MONTH(`sender_info`.`date_registered`) <= '$months' AND YEAR(`sender_info`.`date_registered`) <= '$year'  AND  `sender_info`.`s_pay_type` = '$pay'  GROUP BY `sender_info`.`s_region`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_report_Document_Year($year,$cate,$pay){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND  `sender_info`.`s_pay_type` = '$pay' GROUP BY `sender_info`.`s_region`";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Parcel_Day($parcel){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$parcel' GROUP BY date(`sender_info`.`s_region`)";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_report_Parcel($parcel){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$parcel'";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_ems_report_Document_count($document){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$document'";
		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function get_ems_report_parcel_count($parcel){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$parcel'";
		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function ems_cat_price($emsCat,$weight){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `ems_tariff_price` WHERE `cat_id`='$emsCat' 
		AND `tariff_weight` >= '$weight' LIMIT 1";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function ems_cat_price10($emsCat,$weight10){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `ems_tariff_price` WHERE `cat_id`='$emsCat' AND `tariff_weight` >= '$weight10' LIMIT 1";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function check_payment($id,$type){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `transactions` WHERE `id`='$id'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_Details($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `bags` WHERE `bag_id`='$id'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function getTrackNo($sid){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `sender_info` WHERE `sender_id`='$sid'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_customer_infos($I){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `credit_id`='$I'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	
	public function get_customer_infos_new($acc_no){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `acc_no`='$acc_no'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}

public function get_credit_customer(){

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

if ($this->session->userdata('user_type') == "ADMIN"  ) {
	$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `credit_id` IN(SELECT MAX(`credit_id`) FROM `credit_customer` GROUP BY `credit_customer`.`acc_no`) ORDER BY `created_date` DESC";

}elseif($this->session->userdata('user_type') == "ACCOUNTANT"){

	$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `customer_region` = '$o_region' AND `customer_branch` = '$o_branch' AND `credit_id` IN(SELECT MAX(`credit_id`) FROM `credit_customer` GROUP BY `credit_customer`.`acc_no`)  ORDER BY `created_date` DESC";
}else {

	$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `customer_region` = '$o_region' AND `customer_branch` = '$o_branch'  ORDER BY `created_date` DESC";

}

		
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public function get_credit_customer_byId($I){

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

	    $db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `credit_id` = '$I'";

		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_credit_customer_byAcc($acc){

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

	    $db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `customer_region` FROM `credit_customer` WHERE `acc_no` = '$acc' GROUP BY `customer_region`";

		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_credit_customer_byAcc1($acc){

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

	    $db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `customer_branch` FROM `credit_customer` WHERE `acc_no` = '$acc' GROUP BY `customer_region`";

		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function getCustomerInformation($acc_no){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `credit_customer` WHERE `acc_no` = '$acc_no'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_counter(){
		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `counters` WHERE `counter_region` = '$o_region' AND `counter_branch` = '$o_branch'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public function get_counters_byId($id){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `counters` WHERE `counter_id` = '$id'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_bag_number($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `bags` WHERE `despatch_no`='$id'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function get_sender_id($ids){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `transactions` WHERE `isBagNo`='$ids'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function qrcode_list(){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `bags` WHERE `bags`.`bags_status` != 'isDespatch'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function getSumPostPaid($type){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT SUM(paidamount) as paidamount FROM `transactions` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `transactions`.`customer_acc` = '$type'";

		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_ems_sum(){
		$id = $this->session->userdata('user_login_id');
				$info = $this->employee_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		}elseif($this->session->userdata('user_type') == 'RM'){
			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' ";
		}else{

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			 
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date'";
		}

		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
		public  function get_ems_sumACC($region,$date,$date2,$month,$month2,$year4){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$d1date = date('d',strtotime($date));
				$m1date = date('m',strtotime($date));
				$y1date = date('Y',strtotime($date));

				$d2date = date('d',strtotime($date2));
				$m2date = date('m',strtotime($date2));
				$y2date = date('Y',strtotime($date2));

				$month1 = explode('-', $month);
				$month4 = explode('-', $month2);

				$day = @$month1[0];
				$year = @$month1[1];

				$day1 = @$month4[0];

			if ($this->session->userdata('user_type') == 'RM' ||  $this->session->userdata('user_type') == 'ACCOUNTANT-HQ') {
					
			if (!empty($date) && !empty($date2)) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')";

		   }else{

		   	if ($month && $month2) {

		   	$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

		   	} else {
		   		
		   		if ($month || $month2) {

		   			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' OR  MONTH(`sender_info`.`date_registered`) >= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";
		   		} else {
		   			
		   			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date'))";
		   		}
		   	}

		   }
		}else{

			if (!empty($date) && !empty($date2)) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region'";

		   }else{

		   	if ($month && $month2) {

		   	$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'   AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

		   	} else {
		   		
		   		if ($month) {

		   			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND YEAR(`sender_info`.`date_registered`) = '$year') AND `sender_info`.`s_region` = '$region'";

		   		} else {
		   			
		   			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') ) AND `sender_info`.`s_region` = '$region'";
		   		}
		   	}
		}

			
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
		}
	}
	public function get_ems_sum1($year,$month,$day){

		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE YEAR(date_registered) = '$year' AND MONTH(date_registered) = '$month' AND DAY(date_registered) = '$day' AND `transactions`.`status` = 'Paid'";

		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_backoffice_sum(){
		$id = $this->session->userdata('user_login_id');
				$info = $this->employee_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$db2 = $this->load->database('otherdb', TRUE);
		$date = date('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
			$sql    = "SELECT SUM(paidamount) as paidamount FROM `transactions` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND date(`transactions`.`transactiondate`)= '$date' AND (`transactions`.`office_name` = 'Received' OR `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Despatch') AND `transactions`.`region` = '$o_region' AND `transactions`.`district`= '$o_branch'";
		}else{

			$sql    = "SELECT SUM(paidamount) as paidamount FROM `transactions` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'  AND (`transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received' OR `transactions`.`office_name` = 'Despatch') ";
		}
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_qrcode_item($code){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `sender_info` WHERE `sender_info`.`track_number` = '$code'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_sender_info($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `sender_info` WHERE `sender_info`.`sender_id` = '$id'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function take_bags_item_list($type,$bagno){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`isBagNo`='$bagno' AND `transactions`.`PaymentFor` = '$type'";

		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function take_bags_item_list_scann($trackno){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`isBagNo`='$trackno'";

		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function take_bags_desp_list($type,$despno){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `bags` WHERE `despatch_no`='$despno' && `service_type` = '$type'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatch_out_list(){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT *
			FROM `despatch`
			WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'Domestic' ORDER BY `despatch`.`datetime` DESC";

		}else{

			$sql = "SELECT *
			FROM `despatch` WHERE date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'Domestic' ORDER BY `despatch`.`datetime` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_despatch_in_list(){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
			$sql = "SELECT *
			FROM `despatch` WHERE region_to  = '$o_region' AND branch_to = '$o_branch' AND date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'Domestic'
			ORDER BY `despatch`.`desp_id` DESC";
		}else{
			$sql = "SELECT `despatch`.*
			FROM `despatch` WHERE date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'Domestic'
		    ORDER BY `despatch`.`desp_id` DESC";
		}


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function count_item_in_bag($bagno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `transactions` WHERE `isBagNo`='$bagno' AND `PaymentFor` = 'EMS'";
		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function count_ems(){
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		//$date = date('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`office_name`= 'Back'  AND `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  date(`sender_info`.`date_registered`) = '$date'";

		}else{

			$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`office_name`= 'Back' AND `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS' AND date(`sender_info`.`date_registered`) = '$date' ";
		}


		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function count_bags(){
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) = '$date' ORDER BY `bags`.`date_created` DESC";
		}else{
			$sql = "SELECT * FROM `bags` WHERE `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) = '$date' ORDER BY `bags`.`date_created` DESC";
		}


		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function count_despatch_out(){
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT *
			FROM `despatch`
			WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  date(`despatch`.`datetime`) = '$date'";
		}else{
			$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
		}


		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function count_despatch_in(){
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT * FROM `despatch`
			WHERE `despatch`.`region_to`  = '$o_region' AND `despatch`.`branch_to`  = '$o_branch' AND  date(`despatch`.`datetime`) = '$date'";
		}else{
			$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
		}


		$query  = $db2->query($sql);
		return $query->num_rows();
	}
	public function get_item_from_bags_list($bagno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`isBagNo`='$bagno'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function count_bags_desp_list($bagno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `transactions` WHERE `isBagNo`='$bagno'";
		$query  = $db2->query($sql);
		return $query->num_rows();
	}

	public function update_back_office($id,$data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$id);
		$db2->update('transactions',$data);
	}
	public function update_price($up,$acc_no){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('acc_no',$acc_no);
		$db2->update('credit_customer',$up);
	}
	public function update_transactions($update,$serial1){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial1);
		$db2->update('transactions',$update);
	}
	public function update_transactions_bill($update,$serial2){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$serial2);
		$db2->update('transactions',$update);
	}
	public function update_counter($data,$cid){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('counter_id',$cid);
		$db2->update('counters',$data);
	}
	public function update_sender_status($id,$data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('sender_id',$id);
		$db2->update('sender_info',$data);
	}
	public function get_details_by_id($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `sender_info`.`sender_id`='$id'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId){

		$AppID = 'POSTAPORTAL';

		$data = array(
			'AppID'=>$AppID,
			'BillAmt'=>$paidamount,
			'serial'=>$serial,
			'District'=>$district,
			'Region'=>$region,
			'service'=>$serviceId,
			'item'=>$renter,
			'mobile'=>$mobile
		);

		$url = "http://192.168.33.2/payments/paymentAPI.php";
		$ch = curl_init($url);
		$json = json_encode($data);
		curl_setopt($ch, CURLOPT_URL, $url);
		// For xml, change the content-type.
		curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

		// Send to remote and return data to caller.
		$response = curl_exec ($ch);
		$error    = curl_error($ch);
		$errno    = curl_errno($ch);
       // print_r($result->controlno);
		//print_r($response.$error);
		curl_close ($ch);
		$result = json_decode($response);
		//print_r($result->controlno);
		//return $result;
		if (@$result->controlno != '') {
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->set('bill_status', 'SUCCESS');
        $db2->set('billid', $result->controlno);//if 2 columns
        $db2->where('serial', $serial);
        $db2->update('transactions');
    }

        //print_r($result);

		//echo $result;
}

public function getBillPayment($AppID,$serial,$paidamount){

		
		$data = array(
			'AppID'=>$AppID,
			'serial'=>$serial,
			'BillAmt'=>$paidamount,
		);

		$url = "http://192.168.33.2/payments/paymentAPI.php";
		$ch = curl_init($url);
		$json = json_encode($data);
		curl_setopt($ch, CURLOPT_URL, $url);
		// For xml, change the content-type.
		curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

		// Send to remote and return data to caller.
		$response = curl_exec ($ch);
		$error    = curl_error($ch);
		$errno    = curl_errno($ch);
       // print_r($result->controlno);
		//print_r($response.$error);
		curl_close ($ch);
		$result = json_decode($response);
		//print_r($result->controlno);
		//return $result;
		if (@$result->controlno != '') {
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('receipt', @$result->receipt);
		$db2->set('paidamount', @$result->amount);
		$db2->set('paychannel', @$result->channel);
		$db2->set('paydate', @$result->paymentdate);
        $db2->set('billid', @$result->controlno);//if 2 columns
        $db2->where('serial', @$serial);
        $db2->update('transactions');
    }

        //print_r($result);

		//echo $result;
}
public function getBillGepgBillId_international($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

		$AppID = 'POSTAPORTAL';

		$data = array(
			'AppID'=>$AppID,
			'BillAmt'=>$paidamount,
			'serial'=>$serial,
			'District'=>$district,
			'Region'=>$region,
			'service'=>$serviceId,
			'item'=>$renter,
			'mobile'=>$mobile,
			'trackno'=>$trackno
		);

		$url = "http://192.168.33.2/payments/paymentAPI.php";
		$ch = curl_init($url);
		$json = json_encode($data);
		curl_setopt($ch, CURLOPT_URL, $url);
		// For xml, change the content-type.
		curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
		curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

		// Send to remote and return data to caller.
		$response = curl_exec ($ch);
		$error    = curl_error($ch);
		$errno    = curl_errno($ch);
       // print_r($result->controlno);
		//print_r($response.$error);
		curl_close ($ch);
		$result = json_decode($response);
		//print_r($result->controlno);
		//return $result;
		if (@$result->controlno != '') {
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->set('bill_status', 'SUCCESS');
        $db2->set('billid', $result->controlno);//if 2 columns
        $db2->where('serial', $serial);
        $db2->update('transactions');
    }

        //print_r($result);

		//echo $result;
}
}
?>
