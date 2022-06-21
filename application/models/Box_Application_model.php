<?php

class Box_Application_model extends CI_Model{


	function __consturct(){
		parent::__construct();
    	// $this->db2 = $this->load->database('otherdb', TRUE);
	}

	public function saveSenderInfo($info){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('sender_info',$info);
		$last_id = $db2->insert_id();
		return $last_id;
	}

	public function saveReceiverInfo($info){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('receiver_info',$info);
		$last_id = $db2->insert_id();
		return $last_id;
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




	public function updatestatus($serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('status', 'NotPaid');
		$db2->where('serial', $serial);
		$db2->update('transactions');
	}
	public function updatenullprice($serial,$emsCat,$weight){
		if($weight > 10){

			$weight10    = 10;
			$getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

			$vat10       = $getPrice->vat;
			$price10     = $getPrice->tariff_price;
			$totalprice10 = $vat10 + $price10;

			$diff   =  $weight - $weight10;

			if ($diff <= 0.5) {

				if ($emsCat == 1) {
					$totalPrice = $totalprice10 + 2300;
				} else {
					$totalPrice = $totalprice10 + 3500;
				}

			} else {

				$whole   = floor($diff);
				$decimal = fmod($diff,1);
				if ($decimal == 0) {

					if ($emsCat == 1) {
						$totalPrice = $totalprice10 + ($whole*1000/500)*2300;
					} else {
						$totalPrice = $totalprice10 + ($whole*1000/500)*3500;
					}

				} else {

					if ($decimal <= 0.5) {

						if ($emsCat == 1) {
							$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
						} else {
							$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
						}

					} else {

						if ($emsCat == 1) {
							$totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
						} else {
							$totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
						}
					}

				}
			}

		}else{

			$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
			$vat = $price->vat;
			$emsprice = $price->tariff_price;
			$totalPrice = $vat + $emsprice;
		}

		$db2 = $this->load->database('otherdb', TRUE);
	        $db2->set('paidamount', $totalPrice);//if 2 columns
	        $db2->set('status', 'NotPaid');
	        $db2->where('serial', $serial);
	        $db2->update('transactions');

	    }
	    public  function get_box_renters(){

	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$query = $db2->get('box_tariff');
	    	$result = $query->result();
	    	return $result;

	    }

	//TRANSFERED ITEMS
	    public function transfered_item_list($fromdate,$todate){

	    	$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
	    	$o_region = $this->session->userdata('user_region');
	    	$o_branch = $this->session->userdata('user_branch');
	    	$emid = $this->session->userdata('user_login_id');

	    	$tz = 'Africa/Nairobi';
	    	$tz_obj = new DateTimeZone($tz);
	    	$today = new DateTime("now", $tz_obj);
	    	$date = $today->format('Y-m-d');

	    	if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER') 
	    	{
	    		$sql= "SELECT * FROM `sender_info` 
	    		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
	    		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	    		WHERE DATE(`date_registered`) BETWEEN '$fromdate' AND '$todate'";
	    	}
	    	else
	    	{
	    		$sql= "SELECT * FROM `sender_info` 
	    		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
	    		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	    		WHERE `operator`='$emid' AND DATE(`date_registered`) BETWEEN '$fromdate' AND '$todate'";


	    	}

	    	$query  = $db2->query($sql);
	    	$result = $query->result();
	    	return $result;         
	    } 
	//TRANSFERED ITEMS

	//EMPLOYEE ITEMS NAME
	    public function check_sender($senderid){
        //HR DATABASE
	    	$db = $this->load->database('default', TRUE);
	    	$sql= "SELECT * FROM employee where em_id='$senderid'";
	    	$query  = $db->query($sql);
	    	$result = $query->row_array();
	    	return $result;         
	    } 
  //EMPLOYEE ITEMS NAME

	    public  function get_bulk_customer(){

	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$query = $db2->get('bulk_registration');
	    	$result = $query->result();
	    	return $result;

	    }

	    public  function get_bulk_customers2($id){

	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$db2->where('Id',$id);
	    	$query = $db2->get('bulk_registration');
	    	$result = $query->row();
	    	return $result;

	    }

	// public  function get_box_rental($boxnumber){

	// 	$db2 = $this->load->database('otherdb', TRUE);
	// 	$db2->where('box_number',$boxnumber);
	// 	$query = $db2->get('box_numbers');
	// 	$result = $query->row();
	// 	return $result;

	// }

	    public  function get_box_rental($boxnumber){
	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$id = $this->session->userdata('user_login_id');
	    	$info = $this->GetBasic($id);
	    	$o_region = $info->em_region;
	    	$o_branch = $info->em_branch;
		//$day = date('Y-m-d');

	    	if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR')
	    	{
	    		$db2->where('box_number',$boxnumber);
	    		$db2->where('region',$o_region);
	    		$db2->where('branch',$o_branch);
	    		$query = $db2->get('box_numbers');
	    		$result = $query->row();
	    	}
	    	elseif ( $this->session->userdata('user_type') == 'RM' )
	    	{
	    		$db2->where('box_number',$boxnumber);
	    		$db2->where('region',$o_region);
	    		$query = $db2->get('box_numbers');
	    		$result = $query->row();
	    	}

	    	elseif ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ) {

	    		$db2->where('box_number',$boxnumber);
	    		$query = $db2->get('box_numbers');
	    		$result = $query->row();

	    	}


	    	return $result;

	    }


	    public  function get_box_rental23($boxnumber,$region){
	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$id = $this->session->userdata('user_login_id');
	    	$info = $this->GetBasic($id);
	    	$o_region = $info->em_region;
	    	$o_branch = $info->em_branch;
		//$day = date('Y-m-d');

	    	if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR')
	    	{
	    		$db2->where('box_number',$boxnumber);
	    		$db2->where('region',$o_region);
	    		$db2->where('branch',$o_branch);
	    		$query = $db2->get('box_numbers');
	    		$result = $query->row();
	    	}
	    	elseif ( $this->session->userdata('user_type') == 'RM' )
	    	{
	    		$db2->where('box_number',$boxnumber);
	    		$db2->where('region',$o_region);
	    		$query = $db2->get('box_numbers');
	    		$result = $query->row();
	    	}

	    	elseif ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ) {

	    		$db2->where('box_number',$boxnumber);
	    		$db2->where('region',$region);
	    		$query = $db2->get('box_numbers');
	    		$result = $query->row();

	    	}


	    	return $result;

	    }




	    public function get_bulk_customers($id){
	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$sql    = "SELECT * FROM `bulk_registration` WHERE  `serial` = '$id' LIMIT 1";
	    	$query  = $db2->query($sql);
	    	$result = $query->row();
	    	return $result;
	    }


	    public function GeEmployeeByBranch($brandname){

	    	$this->db->where('em_branch',$brandname);
	    	$this->db->order_by('em_branch');
	    	$query = $this->db->get('employee');
	    	$output ='<option value="">Select Employee</option>';
	    	foreach ($query->result() as $row) {

	    		$output .='<option value="'.$row->em_id.'">'.'PF.'.$row->em_code.' '.$row->first_name.' '.$row->last_name.'</option>';
	    	}
	    	return $output;
	    }       


	    public function get_box_renter_price($tariffCat){
	    	$db2 = $this->load->database('otherdb', TRUE);
	    	$sql    = "SELECT * FROM `box_tariff_price` WHERE  `btp_id` = '$tariffCat' LIMIT 1";
	    	$query  = $db2->query($sql);
	    	$result = $query->row();
	    	return $result;
	    }


	    public function get_contract_list(){
	    	$query = $this->db->get('contract');
	    	$result = $query->result();
	    	return $result;
	    }

	    public function delte_contract_selected($contid){
	    	$query = "DELETE FROM contract WHERE contid='$contid'";
	    	$result = $this->db->query($query);
	    	return $result;
	    }


	    public function get_contract_lists()
	    {
	    	$sql = "SELECT `contract`.*,
	    	`contract_type`.*
	    	FROM `contract`
	    	LEFT JOIN `contract_type` ON `contract_type`.`cont_id`=`contract`.`cont_type` ORDER BY `contract`.`contid` DESC";
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
	    public function get_region($id){

	    	$db2 = $this->load->database('otherdb', TRUE);

	    	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
	    	FROM `sender_info`
	    	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	    	LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
	    	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
	    	WHERE `transactions`.`id` = '$id'";

	    	$query=$db2->query($sql);
	    	$result = $query->row();
	    	return $result;
	    }

	    public function get_sender_info123($id){

	    	$db2 = $this->load->database('otherdb', TRUE);

	    	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
	    	FROM `sender_info`
	    	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`id` = '$id'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public function update_box_transaction_location($billid){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "UPDATE `transactions` pd 
		INNER JOIN `customer_details` pd2 ON (pd.`CustomerID`=pd2.`details_cust_id` )
		INNER JOIN `customer_address` pd3 ON (pd3.`add_cust_id`=pd2.`details_cust_id` )
		SET pd.`region` = pd3.`region`,pd.`district` = pd3.`district`
		WHERE   pd.`PaymentFor` ='POSTSBOX' AND  pd.`billid` = '$billid' ";

		$query=$db2->query($sql);
		$result = $query;
		return $result;
	}

	 // public function bagundespatchedselect(){
		//   $query = $this->db->get('bags');
		//   $result = $query->result();
		//   return $result;
		//   }



	public function bagundespatchedselect(){  
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		//$STARTdate = $today->format('2021-05-23');
		$STARTdate = date("2021-05-23");

		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$em_branch = $basicinfo->em_branch;

		$db2 = $this->load->database('otherdb', TRUE);//bag_created_by

		$sql = "SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'
		AND `bag_region_from`='$region' AND `bag_branch_from` = '$em_branch'
		AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic' 
		ORDER BY `bag_id` DESC ";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


			  /*public function bagundespatchedselect11(){  
		  	$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		//$STARTdate = $today->format('2021-05-23');
		$STARTdate = date("2021-05-23");

		  	$id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_branch = $basicinfo->em_branch;

		$db2 = $this->load->database('otherdb', TRUE);//bag_created_by

		$sql = "SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'
		AND `bag_region_from`='$region' AND `bag_branch_from` = '$em_branch'
		AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic' AND `bag_created_by` = '$id' 
		 ORDER BY `bag_id` DESC ";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}*/


	public function bagundespatchedselect11(){
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		//$STARTdate = $today->format('2021-05-23');
		$STARTdate = date("2021-05-23");

		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$em_branch = $basicinfo->em_branch;

		$db2 = $this->load->database('otherdb', TRUE);//bag_created_by

		$sql = "SELECT * FROM `bags` WHERE `bags_status` = 'notDespatch'
		AND `bag_region_from`='$region' AND `bag_branch_from` = '$em_branch'
		AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic' AND `bag_created_by` = '$id' 
		ORDER BY `bag_id` DESC ";

		$query=$db2->query($sql);
		$result = $query->result();
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
	
	public function check_if_any_item($sndid){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `assign_derivery` WHERE `item_id`='$sndid'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	// public function check_if_any_item($sndid){

	// 	$db2 = $this->load->database('otherdb', TRUE);
	// 	$sql    = "SELECT * FROM `deriver_info` WHERE `sender_id`='$sndid'";
	// 	$query  = $db2->query($sql);
	// 	$result = $query->row();
	// 	return $result;
	// }
	public function get_bill_customer_details($acc_no){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `ems_bill_companies` WHERE `com_id`='$acc_no'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}
	public function get_mails_bill_customer_details($acc_no){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `mails_bill_companies` WHERE `com_id`='$acc_no'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public function get_bill_cust_details($acc_no){

		$region = $this->session->userdata('user_region');
		$branch = $this->session->userdata('user_branch');

		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `bill_credit_customer` WHERE `acc_no` = '$acc_no' 
		-- AND `customer_region` = '$region' 
		 -- AND `customer_branch` = '$branch'
		 ";
		 $query  = $db2->query($sql);
		 $result = $query->row();
		 return $result;
		}

		public function extra_get_bill_cust_details($acc_no){
			$region = $this->session->userdata('user_region');
			$branch = $this->session->userdata('user_branch');
			$db2 = $this->load->database('otherdb', TRUE);
			$sql    = "SELECT * FROM branch_bill_credit_customer WHERE customer_region='$region' AND customer_branch='$branch' AND acc_no='$acc_no'";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		}

		public function get_delivery_info_by_id($sndid){

			$db2 = $this->load->database('otherdb', TRUE);
			$sql    = "SELECT * FROM `assign_derivery` WHERE `item_id` = '$sndid'";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		}

		public function get_delivery_info_by_barcode($barcode){

			$db2 = $this->load->database('otherdb', TRUE);
			$sql    = "SELECT * FROM `assign_derivery`
			INNER JOIN `waiting_for_delivery` ON `waiting_for_delivery`.`senderid`=`assign_derivery`.`item_id`
			WHERE  `waiting_for_delivery`.`barcode` = '$barcode'";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		}



		public function save_address_details($add){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('customer_address',$add);
		}

		public function save_box_cust_details($add){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('box_customer_details',$add);
		}

		public function save_box_payment_details($add){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('box_payment_details',$add);
		}
		public function get_box_customer_details($id){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql    = "SELECT * FROM `box_customer_details` WHERE `customer_id`='$id'";
			$query  = $db2->query($sql);
			$result = @$query->result();
			return $result;
		} 

		public function get_max_number(){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql= "SELECT MAX(`number`) AS `numbers` FROM `tracknumber` ";
			$query  = $db2->query($sql);
			$result = $query->result();
			return $result;
		} 

		public function get_last_number(){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql= "SELECT * FROM `tracknumber`  ORDER BY `date` DESC LIMIT 1";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		} 

		public function get_last_despatchnumber(){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql= "SELECT * FROM `despatchnumber`  ORDER BY `date` DESC LIMIT 1";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		} 
		public function get_last_despatchnumber_branch($branch){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql= "SELECT * FROM `despatchnumber` WHERE `branch`='$branch'  ORDER BY `date` DESC LIMIT 1";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		} 

		public function get_last_bagnumber(){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql= "SELECT * FROM `bagnumber`  ORDER BY `date` DESC LIMIT 1";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		} 

		public function get_last_bagnumber_branch($branch){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql= "SELECT * FROM `bagnumber` WHERE `branch`='$branch'   ORDER BY `date` DESC LIMIT 1";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		} 

		public function get_box_customer_details_list(){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql    = "SELECT * FROM `box_customer_details` WHERE `boxnumber` LIKE '%Box%'";
			$query  = $db2->query($sql);
			$result = $query->result();
			return $result;
		} 

		public function get_box_customer_payments_details_list(){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql    = "SELECT * FROM `box_customer_details` WHERE `transactionstatus` != 'Paid'";
			$query  = $db2->query($sql);
			$result = $query->result();
			return $result;
		} 

		public function save_bulk_boxes($Outstanding){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('bulk_boxes',$Outstanding);
		}

		public function save_Outstanding($Outstanding){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('Outstanding',$Outstanding);
		}

		public function save_posts_cargo($Outstanding){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('posts_cargo',$Outstanding);
		}

		public function save_location($data){

			$db2 = $this->load->database('otherdb', TRUE);
		 //$db2->query("SET sql_mode = '' ");
			$db2->insert('location_management',$data);
		}
		public function save_logs($data){

			$db2 = $this->load->database('otherdb', TRUE);
		 //$db2->query("SET sql_mode = '' ");
			$db2->insert('logs',$data);
		}
		public function Save_Customer_Info($data){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('credit_customer',$data);
		}

		public function save_customer_details($data){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('customer_details',$data);
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
		public function save_zone($data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('zones',$data);
		}
		public function save_counter_service($cs){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('counter_services',$cs);
		}

		public function save_zone_region($zn){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('zone_region',$zn);
		}

		public function save_zone_employee($zn){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('zone_employee',$zn);
		}

		public function delete_zone_employee($emid){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->delete('zone_employee',array('emid'=> $emid));
		}

		public function deleteBagInfo($bagno){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->delete('bags',array('bag_id'=> $bagno));
		}

		public function update_bags_info($update,$id){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('bag_id', $id);
			$db2->update('bags',$update);         
		}


		public function update_outstanding($updates,$id){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('id', $id);
			$db2->update('Outstanding',$updates);         
		}

		public function update_outstandings($year,$serial){
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "Update `Outstanding` set `year`='$year' where `serial`='$serial'";
			$query = $db2->query($sql);
			return $query;
		}


		public  function getBag($number){
			$db2 = $this->load->database('otherdb', TRUE);

			$sql = "SELECT * from bags where bag_number='$number'";

			$query=$db2->query($sql);
			$result = $query->row_array();
			return $result;
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
		public function Save_Derivery($save){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('deriver_info',$save);
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
			$sql = "SELECT `emp_services`.*,`taskjobassign`.*,`service_job_counter`.* FROM `taskjobassign` LEFT JOIN `service_job_counter` ON `service_job_counter`.`jobassign_id`=`taskjobassign`.`task_id` LEFT JOIN `emp_services` ON `emp_services`.`serv_id` = `service_job_counter`.`service_id` WHERE `taskjobassign`.`assign_to` = '$id' AND `taskjobassign`.`status` = 'ON' ";
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

		public function check_region_zone($id){

			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT *
			FROM `zone_region`
			WHERE `zone_id` = '$id'  ORDER BY `zone_id` DESC LIMIT 1";
			$query  = $db2->query($sql);
			$result = $query->row();
			return $result;
		}
    //   public function check_region($id){

		  // $db2 = $this->load->database('otherdb', TRUE);
    //       $sql = "SELECT *
    //       FROM `zone_region`
    //        WHERE `region_code` = '$id'  ORDER BY `zone_id` DESC LIMIT 1";
    //       $query  = $db2->query($sql);
    //       $result = $query->row();
    //       return $result;
    //   }

		public function check_region($id) {
			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT *
			FROM `zone_region`
			WHERE `region_code` = '$id'  ORDER BY `zone_id` DESC LIMIT 1";
			$result=$db2->query($sql);
			if ($result->row()) {
				return $result->row();
			} else {
				return false;
			}
		}


		public function check_employe_region1($id) {
			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$sql = "SELECT *
			FROM `zone_employee`
			WHERE `emid` = '$id' AND `region_name` ='$o_region'  ORDER BY `id` DESC LIMIT 1";
			$result=$db2->query($sql);
			if ($result->row()) {
				return $result->row();
			} else {
				return false;
			}
		}

		public function check_employe_region($id) {
			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$sql = "SELECT *
			FROM `zone_employee`
			LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`
			WHERE `emid` = '$id' 
			AND  `zones`.`zone_region` = '$o_region'
			AND  `zones`.`zone_branch` = '$o_branch'
			ORDER BY `id` DESC LIMIT 1";
			$result=$db2->query($sql);

			if ($result->row()){
				return $result->row();


				// if (!empty($result )){
				// 	return true;
			} else {
				return false;
			}
		}


		public function delete_zone_region($zone_id){
			$o_region = $this->session->userdata('user_region');
			$o_branch = $this->session->userdata('user_branch');



			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "DELETE  `zone_region`
			FROM `zone_region`
			LEFT JOIN `zones` ON `zone_region`.`zone_id`=`zones`.`zone_id`
			WHERE `zone_region`.`zone_id` = '$zone_id'
			AND  `zones`.`zone_region` = '$o_region'
			AND  `zones`.`zone_branch` = '$o_branch' ";
			$result=$db2->query($sql);

			$sql2 = "DELETE  `zone_employee`
			FROM `zone_employee`
			LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`
			WHERE `zone_employee`.`zone_id` = '$zone_id' 
			AND  `zones`.`zone_region` = '$o_region'
			AND  `zones`.`zone_branch` = '$o_branch'";

			$result=$db2->query($sql2);


		}


		public function delete_servc_emp($emid){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->delete('counter_services',array('assign_to'=> $emid));
		}

		public function delete_entries($accno){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->delete('branch_bill_credit_customer',array('acc_no'=> $accno));
		}
		public  function get_box_listt(){

			$o_region = $this->session->userdata('user_region');
			$o_branch = $this->session->userdata('user_branch');
            // $emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');


			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {


				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$o_region'
				AND `transactions`.`district` = '$o_branch' AND date(`transactions`.`transactiondate`) = '$date'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT') {

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$o_region' 
				AND date(`transactions`.`transactiondate`) = '$date' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
			{
				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX'
				AND date(`transactions`.`transactiondate`) = '$date'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}else
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$o_region' 
				AND date(`transactions`.`transactiondate`) = '$date' ORDER BY `transactions`.`transactiondate` DESC ";

			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function virtual_get_box_listt(){

			$o_region = $this->session->userdata('user_region');
			$o_branch = $this->session->userdata('user_branch');
            // $emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');


			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {


				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$o_region'
				AND `transactions`.`district` = '$o_branch' AND date(`transactions`.`transactiondate`) = '$date'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT') {

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX' AND `transactions`.`region` = '$o_region' 
				AND date(`transactions`.`transactiondate`) = '$date' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER')
			{
				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'
				AND date(`transactions`.`transactiondate`) = '$date'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}else
			{
				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX' AND `transactions`.`region` = '$o_region' 
				AND date(`transactions`.`transactiondate`) = '$date' ORDER BY `transactions`.`transactiondate` DESC ";

			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_box_listt_bill($billid){

			$o_region = $this->session->userdata('user_region');
			$o_branch = $this->session->userdata('user_branch');
            // $emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);




			$sql = "SELECT `customer_details`.*,`box_numbers`.*,`box_numbers`.`box_number` AS boxnumbers,
			`customer_details`.`boxnumber` AS boxinfo,`transactions`.* 
			FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			INNER JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' 
			AND `transactions`.`billid` = '$billid' AND `transactions`.`status` = 'Paid'   
			";



			$query=$db2->query($sql);
			$result = $query->row();
			return $result;
		}


		public function regselect1($o_region){
			$sql    = "SELECT * FROM `em_region` WHERE `region_name`='$o_region'";
			$query  = $this->db->query($sql);
			$result = $query->result();
			return $result;
		} 
		public  function get_box_listAdmin($region){

			$db2 = $this->load->database('otherdb', TRUE);

			$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
			`transactions`.* FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' ORDER BY `transactions`.`transactiondate` DESC ";


			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_ems_bags_list_in_per_date($bagdate){

			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
		//$day = date('Y-m-d');

			if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR')
			{
				$sql = "SELECT * FROM bags WHERE DATE(date_created) = '$bagdate' AND bag_region_from='$o_region' AND bag_branch_from='$o_branch' AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '')";
			}
			else
			{
				$sql = "SELECT * FROM bags WHERE DATE(date_created) = '$bagdate' AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '')";
			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_ems_bags_list_in_per_date_byuser($bagdate,$userid){

			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
		//$day = date('Y-m-d');

			if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR'){

				$sql = "SELECT * FROM bags WHERE DATE(date_created) = '$bagdate' AND bag_region_from='$o_region' AND bag_branch_from='$o_branch' AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') AND `bags`.`bag_created_by` = '$userid' ";
			}else{
				$sql = "SELECT * FROM bags WHERE DATE(date_created) = '$bagdate' AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') AND `bags`.`bag_created_by` = '$userid'";
			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public function get_combine_bags_ems_search($date,$month,$status){

			$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
			$o_region = $this->session->userdata('user_region');
			$o_branch = $this->session->userdata('user_branch');
			$emid = $this->session->userdata('user_login_id');
            // $service_type = $this->session->userdata('service_type');

			$m = explode('-', $month);
			$day = @$m[0];
			$year = @$m[1];


			if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

				if (!empty($date)) {
					$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
						WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
					FROM bags WHERE DATE(date_created) = '$date' AND bag_region_from='$o_region' AND bag_branch_from='$o_branch' 
					AND (`bags`.`type` = 'Combine' ) AND (`bags`.`bags_status` = '$status' )";




				} else {

					$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
						WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
					FROM bags 
					WHERE (MONTH(`bags`.`date_created`) = '$day' AND YEAR(`bags`.`date_created`) = '$year') 
					AND bag_region_from='$o_region' AND bag_branch_from='$o_branch' 
					AND (`bags`.`type` = 'Combine' ) AND (`bags`.`bags_status` = '$status' )";

				}

			}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

				if (!empty($date)) {

					$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
						WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number` 
					FROM bags WHERE DATE(date_created) = '$date' AND bag_region_from='$o_region'
              	 -- AND bag_branch_from='$o_branch' 
              	 AND (`bags`.`type` = 'Combine' ) AND (`bags`.`bags_status` = '$status' )";
              	} else {

              		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
              			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
              		FROM bags 
              		WHERE (MONTH(`bags`.`date_created`) = '$day' AND YEAR(`bags`.`date_created`) = '$year') 
              		AND bag_region_from='$o_region' 
              	  -- AND bag_branch_from='$o_branch' 
              	  AND (`bags`.`type` = 'Combine' ) AND (`bags`.`bags_status` = '$status' )";

              	}

              }else{


              	if (!empty($date)) {

              		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
              			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
              		FROM bags WHERE DATE(date_created) = '$date'
              -- AND bag_region_from='$o_region'
              	 -- AND bag_branch_from='$o_branch' 
              	 AND (`bags`.`type` = 'Combine' ) AND (`bags`.`bags_status` = '$status' )";

              	} else {

              		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
              			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
              		FROM bags 
              		WHERE (MONTH(`bags`.`date_created`) = '$day' AND YEAR(`bags`.`date_created`) = '$year') 
              	  -- AND bag_region_from='$o_region' 
              	  -- AND bag_branch_from='$o_branch' 
              	  AND (`bags`.`type` = 'Combine' ) AND (`bags`.`bags_status` = '$status' )";


              	}

              }

              $query  = $db2->query($sql);
              $result = $query->result();
              return $result;         
          } 


          public  function get_box_listsAdmin($region,$month,$date){

          	$id = $this->session->userdata('user_login_id');
          	$basicinfo = $this->employee_model->GetBasic($id);
          	if ($this->session->userdata('user_type') != 'ADMIN') {
          		$region = $basicinfo->em_region;
          	}

          	$em_branch = $basicinfo->em_branch;

		$dates = $date;//->format('Y-m-d');
		//$date1 = $this->session->userdata('date');
		$d1date = date('d',strtotime($dates));
		$m1date = date('m',strtotime($dates));
		$y1date = date('Y',strtotime($dates));

		$month1 = explode('-', $month);

		$month3 = @$month1[0];
		$year = @$month1[1];

		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') 
		{


			if(!empty($date) && !empty($month) && !empty($region)  )
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' 
				AND `transactions`.`region` = '$region' 	AND `transactions`.`district` = '$em_branch'
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif( !empty($month) && !empty($region)  )
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' AND `transactions`.`district` = '$em_branch'
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif(!empty($date) &&  !empty($region)  )
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' AND `transactions`.`district` = '$em_branch'
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			else
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' AND `transactions`.`district` = '$em_branch'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}



		}else{

			if(!empty($date) && !empty($month) && !empty($region)  )
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' 
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif( !empty($month) && !empty($region)  )
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif(!empty($date) &&  !empty($region)  )
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' 
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			else
			{

				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
				`transactions`.* FROM `customer_details`
				LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function update_virtual($virtuebox_id,$update){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('virtuebox_id',$virtuebox_id);
		$db2->update('virtuebox',$update);
	}



	public  function virtual_get_box_listsAdmin($region,$month,$date){

		$id = $this->session->userdata('user_login_id');
		$basicinfo = $this->employee_model->GetBasic($id);
		$region = $basicinfo->em_region;
		$em_branch = $basicinfo->em_branch;

		$dates = $date;//->format('Y-m-d');
		//$date1 = $this->session->userdata('date');
		$d1date = date('d',strtotime($dates));
		$m1date = date('m',strtotime($dates));
		$y1date = date('Y',strtotime($dates));

		$month1 = explode('-', $month);

		$month3 = @$month1[0];
		$year = @$month1[1];

		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {


			if(!empty($date) && !empty($month) && !empty($region)  )
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX' 
				AND `transactions`.`region` = '$region' 	AND `transactions`.`district` = '$em_branch'
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif( !empty($month) && !empty($region)  )
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region' AND `transactions`.`district` = '$em_branch'
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif(!empty($date) &&  !empty($region)  )
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region' AND `transactions`.`district` = '$em_branch'
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			else
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region' AND `transactions`.`district` = '$em_branch'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}



		}else{

			if(!empty($date) && !empty($month) && !empty($region)  )
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region' 
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif( !empty($month) && !empty($region)  )
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region'
				AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}
			elseif(!empty($date) &&  !empty($region)  )
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region' 
				AND date(`transactions`.`transactiondate`) = '$dates' ORDER BY `transactions`.`transactiondate` DESC ";

			}
			else
			{

				$sql = "SELECT * FROM `virtuebox`
				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region'
				ORDER BY `transactions`.`transactiondate` DESC ";

			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}



	public  function get_box_lists_invoice($region,$month,$date){

		$dates = $date;//->format('Y-m-d');
		//$date1 = $this->session->userdata('date');
		$d1date = date('d',strtotime($dates));
		$m1date = date('m',strtotime($dates));
		$y1date = date('Y',strtotime($dates));

		$month1 = explode('-', $month);

		$month3 = @$month1[0];
		$year = @$month1[1];

		$db2 = $this->load->database('otherdb', TRUE);



		if(!empty($date) && !empty($month) && !empty($region)  )
		{

			$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,MAX(`Outstanding`.`year`) AS maxyear,
			`transactions`.* FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			INNER JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'  
			AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
			AND date(`transactions`.`transactiondate`) = '$dates' GROUP BY `transactions`.`CustomerID`  ";

		}
		elseif( !empty($month) && !empty($region)  )
		{

			$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,MAX(`Outstanding`.`year`) AS maxyear,
			`transactions`.* FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			INNER JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'  
			AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
			GROUP BY `transactions`.`CustomerID`  ";

		}
		elseif(!empty($date) &&  !empty($region)  )
		{

			$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,MAX(`Outstanding`.`year`) AS maxyear,
			`transactions`.* FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			INNER JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'  

			AND date(`transactions`.`transactiondate`) = '$dates' GROUP BY `transactions`.`CustomerID`  ";

		}
		else
		{
			if($region == 'PHQ')  
			{
				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,MAX(`Outstanding`.`year`) AS maxyear,
				`transactions`.* FROM `customer_details`
				INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				INNER JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'  
				GROUP BY `transactions`.`CustomerID` LIMIT 0 ";


			}else{
				$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,MAX(`Outstanding`.`year`) AS maxyear,
				`transactions`.* FROM `customer_details`
				INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
				INNER JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
				WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region'  
				GROUP BY `transactions`.`CustomerID`  ";

			}



		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_box_invoice($CustomerID){

		
		$db2 = $this->load->database('otherdb', TRUE);



		$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,MAX(`Outstanding`.`year`) AS maxyear,
		`transactions`.* FROM `customer_details`
		INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		INNER JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
		WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`status` = 'Paid'AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`CustomerID` = '$CustomerID'  
		ORDER BY `transactions`.`transactiondate` DESC  ";

		
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public function get_box_rental_box_application($fromdate,$todate,$status){
		$db2 = $this->load->database('otherdb', TRUE);
		$region = $this->session->userdata('user_region');
		if($this->session->userdata('user_type') == 'ADMIN'){
			$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
			`transactions`.* FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			WHERE DATE(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status` = '$status' AND `transactions`.`PaymentFor` = 'POSTSBOX' ORDER BY `transactions`.`transactiondate` DESC";
		} else {
			$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
			`transactions`.* FROM `customer_details`
			INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
			WHERE DATE(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status` = '$status' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' ORDER BY `transactions`.`transactiondate` DESC";
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_box_listAdmins($region){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
		`transactions`.* FROM `customer_details`
		INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$region' ORDER BY `transactions`.`transactiondate` DESC LIMIT 0";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_virtual_box_listAdmins($region){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `virtuebox`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
		WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'VIRTUEBOX'  AND `transactions`.`region` = '$region' ORDER BY `transactions`.`transactiondate` DESC LIMIT 0";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}



	public  function get_box_listWeb(){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.`box_tariff_category`,
		`transactions`.* FROM `customer_details`
		INNER JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'POSTSBOX' ORDER BY `transactions`.`transactiondate` DESC";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public function box_status($reff_cust_id){

		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('reff_cust_id',$reff_cust_id);
		$query = $db2->get('box_numbers');
		$result = $query->row();
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

	public  function get_virtual_box_list_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM `virtuebox`
		WHERE `virtuebox_id` = '$id'";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public  function get_box_list_perperson2($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
		`customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
		LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `transactions`.`CustomerID` ='$id'  AND  `transactions`.`PaymentFor` ='POSTSBOX'";

		// $sql = "SELECT `customer_details`.*,`box_tariff`.*,`box_tariff_price`.*,

		// `customer_address`.*,`box_numbers`.* FROM `customer_details`
		// LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		// LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`bt_id`=`customer_details`.`cust_boxtype`
		// LEFT JOIN `box_tariff` ON `box_tariff`.`bt_id`=`customer_details`.`cust_boxtype`
		// LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		// WHERE `customer_details`.`details_cust_id` = '$id'";

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

	public  function get_virtual_box_payment_list_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `virtuebox`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`virtuebox`.`virtuebox_id`
		WHERE `transactions`.`PaymentFor` = 'VIRTUEBOX' AND `transactions`.`CustomerID` = '$id'  ORDER BY `transactions`.`id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_box_payment_paid_list_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
		`customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
		LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`CustomerID` = '$id'
		AND `transactions`.`status` = 'Paid'   ORDER BY `transactions`.`id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}



	public  function get_box_outstanding_list_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT *,MAX(`Outstanding`.`year`) as maxyear FROM `transactions` 
		LEFT JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
		WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`CustomerID` = '$id'
		AND `transactions`.`status` = 'Paid' AND `Outstanding`.`year` != 'Key Deposity'   
		AND `Outstanding`.`year` != 'Authority Card'   ORDER BY `Outstanding`.`year` ASC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_box_outstanding_last_perperson($id){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM `transactions`
		
		LEFT JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
		WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`CustomerID` = '$id'  ORDER BY `Outstanding`.`year` DESC LIMIT 1";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public function get_country_info($countrycode){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT * FROM country_zone where country_id='$countrycode'";
		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public  function get_ems_employee_report($fromdate,$todate){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$Region = $this->session->userdata('user_region');
		$Branch = $this->session->userdata('user_branch');
		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND `sender_info`.`operator` = '$emid'
			AND `sender_info`.`s_region` = '$Region' AND `sender_info`.`s_district` = '$Branch'
			AND `transactions`.`status`='Paid' ORDER BY `sender_info`.`sender_id` DESC";


		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$Region' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Paid' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

			//$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function track_ems_transaction_list($fromdate,$todate,$status,$empid){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND `sender_info`.`operator` = '$empid'
		AND `transactions`.`status`='$status' ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function mct_transaction_list($fromdate,$todate,$status){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND 
		`transactions`.`status`='$status' AND `sender_info`.`service_type`='MCT'
		ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function nectaonline_transaction_list($fromdate,$todate,$status){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND 
		`transactions`.`status`='$status' AND `transactions`.`paymentFor`='NECTA'
		AND `transactions`.`serial` LIKE '%ONLINE%'
		ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function getonline_transaction_bycontrol($controlnumber){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`billid`='$controlnumber' 
		ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}




	public  function helsbonline_transaction_list($fromdate,$todate,$status){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND 
		`transactions`.`status`='$status' AND `transactions`.`paymentFor`='LOAN BOARD'
		AND `transactions`.`serial` LIKE '%ONLINE%'
		ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_cash_mail_employee_report($fromdate,$todate){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$Region = $this->session->userdata('user_region');
		$Branch = $this->session->userdata('user_branch');
		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'SUCCESS' 
			AND `sender_person_info`.`sender_region` = '$Region' 
			AND `sender_person_info`.`sender_branch` = '$Branch'
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'SUCCESS' 
			AND `sender_person_info`.`sender_region` = '$Region' 
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'SUCCESS'
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}else{

			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'SUCCESS'
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public function track_mail_emp_transaction($fromdate,$todate,$status,$empid){

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
		FROM   `sender_person_info`  
		INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
		INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
		WHERE `sender_person_info`.`operator` = '$empid' AND 
		DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
		`register_transactions`.`bill_status` = '$status' 
		ORDER BY `sender_person_info`.`senderp_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public function status_track_mail_emp_transaction($fromdate,$todate,$status,$empid){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
		FROM   `sender_person_info`  
		INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
		INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
		WHERE `sender_person_info`.`operator` = '$empid' AND 
		DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
		`register_transactions`.`status` = '$status' 
		ORDER BY `sender_person_info`.`senderp_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_bill_mail_employee_report($fromdate,$todate){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$Region = $this->session->userdata('user_region');
		$Branch = $this->session->userdata('user_branch');
		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'BILLING' 
			AND `sender_person_info`.`sender_region` = '$Region' 
			AND `sender_person_info`.`sender_branch` = '$Branch'
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'BILLING' 
			AND `sender_person_info`.`sender_region` = '$Region' 
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'BILLING'
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}else{

			$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
			FROM   `sender_person_info`  
			INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
			INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
			WHERE `sender_person_info`.`operator` = '$emid' AND 
			DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
			`register_transactions`.`bill_status` = 'BILLING'
			ORDER BY `sender_person_info`.`senderp_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_employee_bill_report($fromdate,$todate){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$Region = $this->session->userdata('user_region');
		$Branch = $this->session->userdata('user_branch');
		$db2 = $this->load->database('otherdb', TRUE);

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND `sender_info`.`operator` = '$emid'
			AND `sender_info`.`s_region` = '$Region' AND `sender_info`.`s_district` = '$Branch'
			AND `transactions`.`status`='Bill' ORDER BY `sender_info`.`sender_id` DESC";


		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$Region' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

		}

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





		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_bill_list(){

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
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Bill'  AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";





		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_bill_forPickup_list($office_name,$barcode,$createdby){

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

		//AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD')

		//WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = '$office_name' AND date(`sender_info`.`date_registered`) = '$date' 

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
		FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`status` = 'Bill' OR `transactions`.`status` = 'Paid') AND `transactions`.`office_name` = '$office_name' ";

		if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode' ";
		//if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";
		if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby' ";

		$sql .=' ORDER BY `sender_info`.`sender_id` DESC';

		// echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_forPCUMlist($office_name,$barcode,$createdby){

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

		//AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD')

		//WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = '$office_name' AND date(`sender_info`.`date_registered`) = '$date' 

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
		FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'NotPaid' AND `transactions`.`office_name` = '$office_name' ";

		if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode' ";
		//if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";
		if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby' ";

		$sql .=' ORDER BY `sender_info`.`sender_id` DESC';

		// echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_bill_forInward_list($office_name,$barcode,$createdby){

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

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
		FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`office_name` = '$office_name' ";

		if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode' ";
		//if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";
		if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby' ";

		$sql .=' ORDER BY `sender_info`.`sender_id` DESC';

		//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_paid_list($barcode,$createdby){

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

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
		FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'NotPaid' ";

		if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode'";
		if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby'";

		$sql .=' ORDER BY `sender_info`.`sender_id` DESC';

		//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_list_sent(){

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
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";



		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
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
	public  function get_ems_list22(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date =date('Y-m-d',strtotime("-1 days"));// '2021-01-30';//$today->format('Y-m-d');//2021-01-30
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";



		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `sender_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_list2(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date =date('Y-m-d',strtotime("-1 days"));// '2021-01-30';//$today->format('Y-m-d');//2021-01-30
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			GROUP BY `sender_info`.`serial`  ";



		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' GROUP BY `sender_info`.`serial`  ";

		}elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
			
			$sql = "SELECT `sender_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' GROUP BY `sender_info`.`serial`  ";
		}else{

			$sql = "SELECT `sender_info`.*,`transactions`.*
			FROM `sender_info`
			INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
			WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' )AND (`sender_info`.`serial` != '' ) AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`date_registered` LIKE '%$date%' GROUP BY `sender_info`.`serial`  ";
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}




	public  function get_ems_bulk_receiver_list($serial){

		$db2 = $this->load->database('otherdb', TRUE);
		

		
		$sql = "SELECT `sender_info`.*,`receiver_info`.*
		FROM `sender_info`
		JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		WHERE `sender_info`.`serial` = '$serial'  ORDER BY `sender_info`.`sender_id` DESC";

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_bulk_list($serial){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date =date('Y-m-d',strtotime("-1 days"));// '2021-01-30';//$today->format('Y-m-d');//2021-01-30
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		
		$sql = "SELECT `sender_info`.*,`transactions`.*
		FROM `sender_info`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`office_name` = 'Counter' AND `transactions`.`billid` = '$serial' ORDER BY `sender_info`.`sender_id` DESC";

		

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



		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){

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
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}

	public function get_ems_bill_listSearch($date,$month){

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
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill'AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}


	public function get_ems_counter_list($office_name){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$id = $emid;

		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		//(`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND 

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`office_name`='$office_name' ORDER BY `sender_info`.`sender_id` DESC ";

			//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;

	}

	public function get_ems_Despatch_list($office_name){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$id = $emid;

		//(`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`office_name`='$office_name' 
		AND `transactions`.`pass_to`='$id' ORDER BY `sender_info`.`sender_id` DESC ";

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;

	}

	/*public function getTransactionsOfficeBybarcode($barcode,$office_name,$createdby,$pass_to){
		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$info = $this->GetBasic($emid);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		//(`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`office_name`='$office_name' ";

			if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode'";
			if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby'";
			if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";

			//AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'

			$sql .= " ORDER BY `sender_info`.`sender_id` DESC ";

			//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}*/

	public function getTransactionsOfficeBybarcode233($barcode,$office_name,$createdby,$pass_to){
		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$info = $this->GetBasic($emid);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		//(`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*,`country_zone`.`country_name` AS r_region2 FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE 1=1 ";

		if($office_name) $sql .= " AND `transactions`.`office_name`='$office_name'";
		if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode'";
		if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby'";
		if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";

			//AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'

		$sql .= " ORDER BY `sender_info`.`sender_id` DESC ";

			//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getTransactionsOfficeBybarcode($barcode,$office_name,$createdby,$pass_to){
		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$info = $this->GetBasic($emid);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		//(`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE 1=1 ";

		if($office_name) $sql .= " AND `transactions`.`office_name`='$office_name'";
		if($barcode) $sql .= " AND `transactions`.`Barcode`='$barcode'";
		if($createdby) $sql .= " AND `transactions`.`created_by`='$createdby'";
		if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";

			//AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'

		$sql .= " ORDER BY `sender_info`.`sender_id` DESC ";

			// echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getBagItemListBybagNumber($bagno){
		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$info = $this->GetBasic($emid);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		//`transactions`.`office_name`='$office_name' 

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*,`country_zone`.`country_name` AS r_region2 FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`isBagNo` = '$bagno' ";

			//if($bagno) $sql .= " AND `transactions`.`Barcode`='$barcode'";
			//if($createdby) $sql .= " AND `transactions`.`isBagBy`='$createdby'";
			//if($pass_to) $sql .= " AND `transactions`.`pass_to`='$pass_to'";

			//AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'

		$sql .= " ORDER BY `sender_info`.`sender_id` DESC ";

			//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function createbagNumber($todistrict,$fromdistrict){
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$CurrentDate = $today->format('Y');
		$Now = $today->format('Ymd');

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "select max(dc) as dc from bags where bag_branch ='".trim($todistrict)."' and bag_branch_from  = '".trim($fromdistrict)."' and year(date_created) = ".$CurrentDate;

		$query=$db2->query($sql);
		$result = $query->result_array();

		//$bagno = 'BAG-EMS-'.strtoupper(trim($todistrict)).'-'.date("Ymd/").'0';
		$bagno = strtoupper(trim($fromdistrict)).'-'.strtoupper(trim($todistrict)).'-'.$Now.'0';

		if($result) return array('num'=>$bagno .= $result[0]['dc'] +1,'dc'=>$result[0]['dc'] +1);
		else return array('num'=>$bagno .= $result[0]['dc'],'dc'=>$result[0]['dc']);
	}

	public function createDespatchNumber($fromdistrict,$todistrict){
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$CurrentDate = $today->format('Y');
		$Now = $today->format('Ymd');

		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "select max(dc) as dc from despatch where branch_from ='".trim($fromdistrict)."' and branch_to  = '".trim($todistrict)."' and year(despatch_date) = ".$CurrentDate;

		$query=$db2->query($sql);
		$result = $query->result_array();

		//$despatch_no = 'DESPATCH-EMS-'.strtoupper(trim($todistrict)).'-'.date("Ymd/").'0';
		$despatch_no = strtoupper(trim($fromdistrict)).'-'.strtoupper(trim($todistrict)).'-'.$Now.'0';

		if($result) return array('num'=>$despatch_no .= $result[0]['dc'] +1,'dc'=>$result[0]['dc'] +1);
		else return array('num'=>$despatch_no .= $result[0]['dc'],'dc'=>$result[0]['dc']);
	}

	public function get_ems_Inward_list($office_name){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$id = $emid;

		//(`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
		INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE  `transactions`.`office_name`='$office_name' AND `transactions`.`pass_to`='$id' ORDER BY `sender_info`.`sender_id` DESC ";

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;

	}

	public function get_ems_list_SearchData($fromdate,$todate,$barcode,$office_name,$pf){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);

		$id = ($pf)? $pf:$emid;

		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		if (!empty($fromdate) && !empty($todate) && !empty($office_name)) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND `transactions`.`office_name`='$office_name' ORDER BY `sender_info`.`sender_id` DESC ";

		}else if(!empty($pf) && !empty($barcode) && !empty($office_name)){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND `transactions`.`office_name`='$office_name' 
			AND `transactions`.`Barcode`='$barcode' ORDER BY `sender_info`.`sender_id` DESC";

		}

		   //echo $sql;die();
		

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;

	}

	public function getemid($code) {
		$user = $this->db->dbprefix('employee');
		$sql = "SELECT `em_id` FROM $user
		WHERE `em_code`='$code'";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;


	}

	public function get_ems_listSearchpf($date,$month,$pf){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$id = $pf;
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$d1date = date('d',strtotime($date));
		$m1date = date('m',strtotime($date));
		$y1date = date('Y',strtotime($date));

		$month1 = explode('-', $month);

		$day = @$month1[0];
		$year = @$month1[1];


		if (!empty($date) ) {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

		}
		
		

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}

	public function searchRealestateReceipt($cnumber){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select *,partial_payment.receipt as partial_receipt,
		partial_payment.date_created as partial_date_created  from partial_payment
		INNER JOIN real_estate_transactions on real_estate_transactions.billid= partial_payment.controlno
		INNER JOIN estate_tenant_information on estate_tenant_information.tenant_id= real_estate_transactions.tenant_id
		where  1=1 ";
		if($cnumber) $sql.= " and controlno = '$cnumber' ";

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function searchRealestatepartialReceipt($partial){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select *,partial_payment.receipt as partial_receipt,
		partial_payment.date_created as partial_date_created  from partial_payment
		INNER JOIN real_estate_transactions on real_estate_transactions.billid= partial_payment.controlno
		INNER JOIN estate_tenant_information on estate_tenant_information.tenant_id= real_estate_transactions.tenant_id
		where  1=1 ";
		if($partial) $sql.= " and partial_id = '$partial' ";

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public function searchTransaction($id,$barcode,$cnumber,$mobile){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from transactions where  1=1 ";

		if($id) $sql.= " and id = '$id' ";
		if($barcode) $sql.= " and Barcode = '$barcode' ";
		if($cnumber) $sql.= " and billid = '$cnumber' ";
		if($mobile) $sql.= " and Customer_mobile = '$mobile' ";

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	/*public function transTracingMaster($transid){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from tracing where  type = 0 ";

		if($transid) $sql.= " and transid = '$transid' ";

		$sql .= " order by doc desc";

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}*/

	public function transTracingMaster($transid,$createdby,$pass_to,$office_name,$status,$fromdate,$todate,$trans_type,$type){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from tracing where 1=1 ";

		if($transid) $sql.= " and transid = '$transid' ";
		if($trans_type) $sql.= " and trans_type = '$trans_type' ";
		if($createdby) $sql.= " and emid = '$createdby' ";
		if($pass_to) $sql.= " and pass_to = '$pass_to' ";
		if($office_name) $sql.= " and office_name = '$office_name' ";
		if($status) $sql.= " and status = '$status' ";
		if($type) $sql.= " and type != $type ";

		if (!empty($fromdate) && !empty($todate)) {
			$sql.= " and date(doc) between '$fromdate' and '$todate' ";
		}

		$sql .= " order by doc asc";

		//echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}


	public function NonBagtransTracingMaster($transid,$createdby,$pass_to,$office_name,$status,$fromdate,$todate,$trans_type='',$type,$description=''){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "select * from tracing where  1=1 ";

		if($transid) $sql.= " and transid = '$transid' ";
		if($trans_type) $sql.= " and trans_type = '$trans_type' ";
		if($createdby) $sql.= " and emid = '$createdby' ";
		if($pass_to) $sql.= " and pass_to = '$pass_to' ";
		if($office_name) $sql.= " and office_name = '$office_name' ";
		if($status) $sql.= " and status = '$status' ";
		if($type) $sql.= " and type != $type ";
		if($description) $sql.= " and type != $type ";

		if (!empty($fromdate) && !empty($todate)) {
			$sql.= " and date(doc) between '$fromdate' and '$todate' ";
		}

		$sql .= " order by doc asc";
		// echo $sql;die();

		$query=$db2->query($sql);
		$result = $query->result_array();
		return $result;
	}
	

	public function transanctionsData($transid){
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM sender_info 
		LEFT JOIN receiver_info ON sender_info.sender_id=receiver_info.from_id 
		LEFT JOIN transactions ON transactions.CustomerID = sender_info.sender_id 
		LEFT JOIN country_zone ON country_zone.country_id = receiver_info.r_region
		WHERE transactions.id='$transid' ";

		$query  = $db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function copyTransaction($data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('transactions_cancel',$data);
	}

	public function transactionDelete($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->delete('transactions',array('id'=> $id));
	}

	public function get_ems_bill_listSearchpf($date,$month,$pf){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$id = $pf;
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$d1date = date('d',strtotime($date));
		$m1date = date('m',strtotime($date));
		$y1date = date('Y',strtotime($date));

		$month1 = explode('-', $month);

		$day = @$month1[0];
		$year = @$month1[1];

		if ($this->session->userdata('user_type') == 'EMPLOYEE' ) {

			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill'  AND date(`sender_info`.`date_registered`) = '$date'  AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}


		}else{

			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill'AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ORDER BY `sender_info`.`sender_id` DESC ";

			}


		}



		
		

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}

	public function get_ems_listSearch_sent($date,$month){

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
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') ORDER BY `sender_info`.`sender_id` DESC ";

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

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*,`` FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}


	public function get_ems_listSearch22($date,$month){

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

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*,`` FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;

	}



	public function get_ems_listSearch2($date,$month){

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

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' GROUP BY `sender_info`.`serial`  ";

			}else{

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' GROUP BY `sender_info`.`serial`  ";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' GROUP BY `sender_info`.`serial`  ";

			}else{

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'GROUP BY `sender_info`.`serial`  ";

			}
		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

			if (!empty($date) ) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date' GROUP BY `sender_info`.`serial`  ";

			}else{

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'GROUP BY `sender_info`.`serial`  ";
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

			if (!empty($date) && !empty($month)) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
				AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}


			else if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date' 
				AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR') {

			if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch'";

			}
		}elseif($this->session->userdata('user_type') == 'ACCOUNTANT' || $this->session->userdata('user_type') == 'RM') {

			if (!empty($date) && !empty($month)) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
				AND `sender_info`.`operator` = '$id'";

			}


			else if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'";

			}
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}


	public function get_ems_bill_sumSearch($date,$month){

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

			if (!empty($date) && !empty($month)) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
				AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}


			else if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date' 
				AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR') {

			if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch'";

			}
		}elseif($this->session->userdata('user_type') == 'ACCOUNTANT' || $this->session->userdata('user_type') == 'RM') {

			if (!empty($date) && !empty($month)) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
				AND `sender_info`.`operator` = '$id'";

			}


			else if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'";

			}
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}

	public function get_ems_sumSearchpf($date,$month,$pf){

		$regionfrom = $this->session->userdata('user_region');
		//$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$id = $pf;
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$d1date = date('d',strtotime($date));
		$m1date = date('m',strtotime($date));
		$y1date = date('Y',strtotime($date));

		$month1 = explode('-', $month);

		$day = @$month1[0];
		$year = @$month1[1];

		

		if (!empty($date) && !empty($month)) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		}


		else if (!empty($date) ) {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date' 
			AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		}else{

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
			
			INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		}
		
		

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}

	public function get_ems_bill_sumSearchpf($date,$month,$pf){

		$regionfrom = $this->session->userdata('user_region');
		// $emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$id = $pf;
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$d1date = date('d',strtotime($date));
		$m1date = date('m',strtotime($date));
		$y1date = date('Y',strtotime($date));

		$month1 = explode('-', $month);

		$day = @$month1[0];
		$year = @$month1[1];

		if ($this->session->userdata('user_type') == 'EMPLOYEE' ) {

			if (!empty($date) && !empty($month)) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD')   AND  DAY(`sender_info`.`date_registered`) = '$date'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
				AND `sender_info`.`operator` = '$id'";

			}


			else if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD')  AND  DAY(`sender_info`.`date_registered`) = '$date' 
				AND `sender_info`.`operator` = '$id'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`operator` = '$id'";

			}

		}else{

			if (!empty($date) && !empty($month)) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
				AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}


			else if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  DAY(`sender_info`.`date_registered`) = '$date' 
				AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Bill' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}

		}
		
		

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}

	public function get_ems_sumSearch_sent($date,$month){

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

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` ,COUNT(`transactions`.`paidamount`) AS `number` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` ,COUNT(`transactions`.`paidamount`) AS `number` 
				FROM `sender_info` 
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";

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

	public function get_ems_sumSearch22($date,$month){

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

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR') {

			if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch'";

			}
		}elseif($this->session->userdata('user_type') == 'ACCOUNTANT' || $this->session->userdata('user_type') == 'RM') {

			if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'";

			}
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}


	public function get_ems_sumSearch2($date,$month){

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

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

			}
		}elseif($this->session->userdata('user_type') == 'SUPERVISOR') {

			if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_district` = '$o_branch'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$o_branch'";

			}
		}elseif($this->session->userdata('user_type') == 'ACCOUNTANT' || $this->session->userdata('user_type') == 'RM') {

			if (!empty($date) ) {

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date'";

			}else{

				$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
				FROM `sender_info` 

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE  `transactions`.`status` = 'Paid' AND (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `sender_info`.`s_region` = '$o_region'  AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'";

			}
		}

		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}

	public  function get_ems_listAcc_old($start_date, $end_date, $ems_type, $pay_type, $region)
	{ 
		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		
		// $tz = 'Africa/Nairobi';
		// $tz_obj = new DateTimeZone($tz);
		// $today = new DateTime("now", $tz_obj);
		// $dates = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		// $d1date = date('d',strtotime($date));
		// $m1date = date('m',strtotime($date));
		// $y1date = date('Y',strtotime($date));

		// $d2date = date('d',strtotime($date2));
		// $m2date = date('m',strtotime($date2));
		// $y2date = date('Y',strtotime($date2));

		// $month1 = explode('-', $month);
		// $month4 = explode('-', $month2);

		// $day = @$month1[0];
		// $year = @$month1[1];

		// $day1 = @$month4[0];
				//$year2 = @$month4[1];

		// if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT")
		if($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == "BOP")
		{
			if (!empty($start_date) && !empty($end_date))
			{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  ORDER BY `sender_info`.`sender_id` DESC ";
			}
			else
			{
				if (!empty($month) && !empty($month2))
				{
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
		}
		else
		{
			if (!empty($start_date) && !empty($end_date)) {

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

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";




					}
				}
			}
		}

		// $query=$db2->query($sql);
		// $result = $query->result();
		// return $result;
	}

	public  function get_ems_listAcc($start_date, $end_date, $pay_type, $region=false)
	{
		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');

		$otherdb = $this->load->database('otherdb', TRUE);

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$data = array();

		$otherdb->join('sender_info s', 's.sender_id = t.CustomerID', 'left');
		$otherdb->join('receiver_info r', 'r.from_id = s.sender_id', 'left');
		$otherdb->where('t.transactiondate >=', $start_date);
		$otherdb->where('t.transactiondate <=', $end_date);
		$otherdb->where('LENGTH(t.Barcode)', 13, FALSE);

		// If a region is selected
		if($region != false) $otherdb->where('t.region', $region);

		// Cash or bill for EMS | Document parcel
		if ($pay_type == "Cash") $otherdb->like('t.serial', 'EMS', 'after');
		else $otherdb->like('t.serial', 'EB', 'after');

		// Select only domestic transactions
		$otherdb->not_like('t.Barcode', 'ee16', 'after');

		$otherdb->limit(10);

		// Now query the results
		$query = $otherdb->get('transactions t');

		// Check if a query is successfully and have res
		if($query !== FALSE && $query->num_rows() > 0)
		{
			$data = $query->result();
			foreach ($data as $row) 
			{				
				$postage = $row->paidamount / 1.18;
				$vat = $postage * 0.18;
				$row->postage = number_format((float)$postage, 2, '.', '');
				$row->vat = number_format((float)$vat, 2, '.', '');
			}
		}
		return $data;
	}

	public  function get_ems_bill_listAcc($region,$date,$date2,$month,$month2,$year4,$type){

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

		if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT") {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
					INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month) || !empty($month2)) {
						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) = '$day' OR MONTH(`sender_info`.`date_registered`) = '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill'AND `sender_info`.`s_region` = '$o_region' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) ORDER BY `sender_info`.`sender_id` DESC ";
					}
				}
			}
		}
		else if ($this->session->userdata('user_type') == 'EMPLOYEE' ) {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`operator` = '$emid'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
					INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`operator` = '$emid' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month) || !empty($month2)) {
						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND `sender_info`.`operator` = '$emid' AND (MONTH(`sender_info`.`date_registered`) = '$day' OR MONTH(`sender_info`.`date_registered`) = '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill'AND `sender_info`.`operator` = '$emid' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) ORDER BY `sender_info`.`sender_id` DESC ";
					}
				}
			}
		} else {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type'  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
					INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE  (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' ) AND `transactions`.`status` = 'Bill'  AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month)) {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`)= '$year') AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND `transactions`.`status` = 'Bill'AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";




					}
				}
			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_listAdmin($branch,$date,$month,$type,$empcode,$date2,$month2,$year4){

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



		if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM'|| $this->session->userdata('user_type') == "ACCOUNTANT") {

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
				WHERE (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  AND `transactions`.`PaymentFor` = '$type' 
				AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
					INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE  (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month)) {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`)= '$year') AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received') AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

					}
				}
			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}
	public  function get_ems_listAcc2($region,$date,$date2,$month,$month2,$year4,$type){

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

		if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT") {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month) || !empty($month2)) {
						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) = '$day' OR MONTH(`sender_info`.`date_registered`) = '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) ORDER BY `sender_info`.`sender_id` DESC ";
					}
				}
			}
		} else {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type'  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE  (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month)) {

						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`)= '$year') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
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


	public  function get_ems_listAccs($region,$date,$date2,$month,$month2,$year4,$type){

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

		$d1date = date('d',strtotime($dates));
		$m1date = date('m',strtotime($dates));
		$y1date = date('Y',strtotime($dates));

		$d2date = date('d',strtotime($date2));
		$m2date = date('m',strtotime($date2));
		$y2date = date('Y',strtotime($date2));

		$month1 = explode('-', $month);
		$month4 = explode('-', $month2);

		$day = @$month1[0];
		$year = @$month1[1];

		$day1 = @$month4[0];
				//$year2 = @$month4[1];

		if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT") {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

					INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
					WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month) || !empty($month2)) {
						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
						WHERE  (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) = '$day' OR MONTH(`sender_info`.`date_registered`) = '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
						WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) ORDER BY `sender_info`.`sender_id` DESC ";
					}
				}
			}
		} else {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type'  ORDER BY `sender_info`.`sender_id` DESC ";


			}else{

				if (!empty($month) && !empty($month2)) {

					$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

					INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
					WHERE  (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

				} else {

					if (!empty($month)) {

						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
						WHERE  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`)= '$year') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

					} else {

						$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
						WHERE  ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date')) AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' ORDER BY `sender_info`.`sender_id` DESC ";

					}
				}
			}
		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_bulk_list2($region,$date,$date2,$month,$month2,$year4,$type){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$dates = $today->format('Y-m-d');
		$dateK =date('Y-m-d',strtotime("-1 days"));
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		$d1date = date('d',strtotime($dates));
		$m1date = date('m',strtotime($dates));
		$y1date = date('Y',strtotime($dates));

		$d2date = date('d',strtotime($date2));
		$m2date = date('m',strtotime($date2));
		$y2date = date('Y',strtotime($date2));

		$month1 = explode('-', $month);
		$month4 = explode('-', $month2);

		$day = @$month1[0];
		$year = @$month1[1];

		$day1 = @$month4[0];
				//$year2 = @$month4[1];

		if ($this->session->userdata('user_type') == 'ACCOUNTANT-HQ' || $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT") {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')  GROUP BY `sender_info`.`serial`  ";


			}

			elseif (!empty($month) && !empty($month2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' GROUP BY `sender_info`.`serial`  ";

			} 

			elseif (!empty($month) || !empty($month2)) {
				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE  (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `sender_info`.`s_region` = '$o_region' AND (MONTH(`sender_info`.`date_registered`) = '$day' OR MONTH(`sender_info`.`date_registered`) = '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' GROUP BY `sender_info`.`serial`  ";

			}
			else {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = '$type') AND `sender_info`.`s_region` = '$o_region'
				AND (`sender_info`.`serial` != '' ) AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`date_registered` LIKE '%$dateS%'  GROUP BY `sender_info`.`serial`  ";
			}




		} 


		else {

			if (!empty($date) && !empty($date2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type'  GROUP BY `sender_info`.`serial`  ";


			}

			elseif (!empty($month) && !empty($month2)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE  (MONTH(`sender_info`.`date_registered`) >= '$day' AND MONTH(`sender_info`.`date_registered`) <= '$day1' )  AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' GROUP BY `sender_info`.`serial`  ";

			} 

			elseif (!empty($month)) {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`

				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`)= '$year') AND `sender_info`.`s_region` = '$region' AND `transactions`.`PaymentFor` = '$type' GROUP BY `sender_info`.`serial`  ";

			} else {

				$sql = "SELECT `sender_info`.*,`transactions`.* FROM `sender_info`
				INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
				WHERE `transactions`.`status` != 'OldPaid' AND (`transactions`.`PaymentFor` = '$type') AND `sender_info`.`s_region` = '$region'
				AND (`sender_info`.`serial` != '' ) AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`date_registered` LIKE '%$dateK%'  GROUP BY `sender_info`.`serial` ";

			}




		}

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}





	public  function get_ems_list_incoming(){

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



		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='WaitingDelivery'
		AND  `receiver_info`.`r_region`='$o_region' AND  `receiver_info`.`branch`='$o_branch'";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_pcum_list_incoming_for_delivery(){

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
		if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == 'SUPERVISOR') {
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='WaitingDelivery'
			AND `transactions`.`PaymentFor` = 'PCUM'
			AND  `sender_info`.`s_region`='$o_region' AND  `sender_info`.`s_district`='$o_branch'";
		}
		elseif( $this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='WaitingDelivery'
			AND `transactions`.`PaymentFor` = 'PCUM'
			AND  `sender_info`.`s_region`='$o_region' ";
		}else{
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='WaitingDelivery'
			AND `transactions`.`PaymentFor` = 'PCUM'
			";

		}





		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_list_delivered(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$STARTdate = date('2021-05-23');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;



		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
		AND  `receiver_info`.`r_region`='$o_region' AND  `receiver_info`.`branch`='$o_branch'
		AND date(`sender_info`.`date_registered`) > '$STARTdate' 
		";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_list_exchange(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$STARTdate = date('2021-05-23');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;



		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Officeofexchange'
		AND date(`sender_info`.`date_registered`) > '$STARTdate' ";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_list_sent_toIps(){

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');

		$STARTdate = date('2021-05-23');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;



		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Senttoips'
		AND date(`sender_info`.`date_registered`) > '$STARTdate' 
		";


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_ems_list_delivered_Search($date,$month,$region){

		$m = explode('-', $month);

		$day = @$m[0];
		$year = @$m[1];

		$region = @$region;

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$today = $today->format('Y-m-d');




		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		$emid = $this->session->userdata('user_login_id');

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			if(!empty($date)){
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$o_region' AND  `receiver_info`.`branch`='$o_branch'
				AND date(`sender_info`.`date_registered`) = '$date' ";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$o_region' AND  `receiver_info`.`branch`='$o_branch'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

			}else{
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$o_region' AND  `receiver_info`.`branch`='$o_branch'
				AND date(`sender_info`.`date_registered`) = '$today'";


			}
		}elseif($this->session->userdata('user_type') == 'RM'){
			if(!empty($date)){
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$o_region' 
				AND date(`sender_info`.`date_registered`) = '$date'";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$o_region' 
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

			}else{
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$o_region' AND date(`sender_info`.`date_registered`) = '$today'";


			}


		}else{

			if(!empty($date)){
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$region' AND date(`sender_info`.`date_registered`) = '$date'";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$region' 
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

			}else{
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `receiver_info`.`r_region`='$region' AND date(`sender_info`.`date_registered`) = '$today'";


			}


		}




		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_pcum_list_delivered_Search($date,$month,$region){

		$m = explode('-', $month);

		$day = @$m[0];
		$year = @$m[1];

		$region = @$region;

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$today = $today->format('Y-m-d');




		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		$emid = $this->session->userdata('user_login_id');

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			if(!empty($date)){
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `sender_info`.`s_region`='$o_region' AND  `sender_info`.`s_district`='$o_branch'
				AND `transactions`.`PaymentFor` = 'PCUM'
				AND date(`sender_info`.`date_registered`) = '$date' ";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `sender_info`.`s_region`='$o_region' AND  `sender_info`.`s_district`='$o_branch'
				AND `transactions`.`PaymentFor` = 'PCUM'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

			}else{
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `sender_info`.`s_region`='$o_region' AND  `sender_info`.`s_district`='$o_branch'
				AND `transactions`.`PaymentFor` = 'PCUM'
				AND date(`sender_info`.`date_registered`) = '$today'";


			}
		}elseif($this->session->userdata('user_type') == 'RM'){
			if(!empty($date)){
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `sender_info`.`s_region`='$o_region'  AND `transactions`.`PaymentFor` = 'PCUM'
				AND date(`sender_info`.`date_registered`) = '$date'";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `sender_info`.`s_region`='$o_region'  AND `transactions`.`PaymentFor` = 'PCUM'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

			}else{
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND `transactions`.`PaymentFor` = 'PCUM'
				AND  `sender_info`.`s_region`='$o_region'  AND date(`sender_info`.`date_registered`) = '$today'";


			}


		}else{

			if(!empty($date)){
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND `transactions`.`PaymentFor` = 'PCUM'
				AND  `sender_info`.`s_region`='$o_region'  AND date(`sender_info`.`date_registered`) = '$date'";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND  `sender_info`.`s_region`='$o_region'  AND `transactions`.`PaymentFor` = 'PCUM'
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

			}else{
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Derivered'
				AND `transactions`.`PaymentFor` = 'PCUM'
				AND  `sender_info`.`s_region`='$o_region'  AND date(`sender_info`.`date_registered`) = '$today'";


			}


		}




		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}



	public  function get_ems_list_exchange_Search($date,$month){

		$m = explode('-', $month);

		$day = @$m[0];
		$year = @$m[1];

		$region = @$region;

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$today = $today->format('Y-m-d');




		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		$emid = $this->session->userdata('user_login_id');



		if(!empty($date)){
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date' ";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";

		}
		else{
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'";


		}







		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function sent_ips_ems_list_exchange_Search($date,$month){

		$m = explode('-', $month);

		$day = @$m[0];
		$year = @$m[1];

		$region = @$region;

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$today = $today->format('Y-m-d');




		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		$emid = $this->session->userdata('user_login_id');



		if(!empty($date)){
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Senttoips'
			AND date(`sender_info`.`date_registered`) = '$date' ";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Senttoips'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ";


		}
		else{
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Senttoips'
			AND date(`sender_info`.`date_registered`) = '$today'";


		}







		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_list_assignedfor_delivery(){

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

			if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

				$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            -- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

            WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
            AND  `assign_derivery`.`service_type`='EMS'
            AND  `receiver_info`.`r_region`='$o_region' 
            AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'   ) 
            ";



        }else{
        	$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
        	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            -- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

            WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
            AND  `assign_derivery`.`service_type`='EMS'
            AND  `receiver_info`.`r_region`='$o_region' AND  `receiver_info`.`branch`='$o_branch'";

        }

    }
    elseif ($this->session->userdata('user_type') == 'RM' ) {

    	$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
    	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            -- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

            WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
            AND  `assign_derivery`.`service_type`='EMS'
            AND  `receiver_info`.`r_region`='$o_region' ";

        }else{

        	$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
        	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            -- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

            WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
            AND  `assign_derivery`.`service_type`='EMS'
            ";

        }







        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_pcum_list_assignedfor_delivery(){

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

    		$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
    		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
    		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
    		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
    		LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

    		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
    		AND  `assign_derivery`.`service_type`='PCUM'
    		AND `transactions`.`PaymentFor` = 'PCUM'
    		AND  `sender_info`.`s_region`='$o_region' AND  `sender_info`.`s_district`='$o_branch'";

    	}elseif ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {
					// code...

    		$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
    		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
    		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
    		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
    		LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

    		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
    		AND  `assign_derivery`.`service_type`='PCUM'  AND `transactions`.`PaymentFor` = 'PCUM'
    		AND  `sender_info`.`s_region`='$o_region' ";
    	}else{

    		$sql = "SELECT `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
    		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
    		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
    		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
    		LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

    		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
    		AND  `assign_derivery`.`service_type`='PCUM'  AND `transactions`.`PaymentFor` = 'PCUM'
    		";

    	}






    	$query=$db2->query($sql);
    	$result = $query->result();
    	return $result;
    }



    public  function get_mails_list_incoming(){

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

    	$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
    	FROM   `sender_person_info`  
    	INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
    	INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
    	ORDER BY `sender_person_info`.`sender_date_created` DESC";


    	$query=$db2->query($sql);
    	$result = $query->result();
    	return $result;
    }

    public  function get_pcum_list_incoming(){

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

    	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
    	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
    	LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
    	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
    	WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'PCUM' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";


    	$query=$db2->query($sql);
    	$result = $query->result();
    	return $result;
    }

	public  function get_item_from_bags($trn){ // bags where bag_number bag_branch_from

		$regionfrom = $this->session->userdata('user_region');
		$emid = $this->session->userdata('user_login_id');
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d');
		//$STARTdate = $today->format('2021-05-23');
		$STARTdate = date('2021-05-23');
		//$date1 = $this->session->userdata('date');

		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch; 

		if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`isBagNo` = '$trn' ORDER BY `sender_info`.`sender_id` DESC ";
		}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE `transactions`.`isBagNo` = '$trn' AND `bags`.`bag_region_from` = '$o_region'
			ORDER BY `sender_info`.`sender_id` DESC ";



		}
		else{
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE `transactions`.`isBagNo` = '$trn' AND `bags`.`bag_branch_from`='$o_branch'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

		public  function get_item_from_bags_admin($trn,$o_region){ // bags where bag_number bag_branch_from

			$regionfrom = $this->session->userdata('user_region');
			$emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);
			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');
		//$STARTdate = $today->format('2021-05-23');
			$STARTdate = date('2021-05-23');
		//$date1 = $this->session->userdata('date');




			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE `transactions`.`isBagNo` = '$trn' AND `bags`.`bag_region_from` = '$o_region'
			ORDER BY `sender_info`.`sender_id` DESC ";





			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function get_item_from_bags0($trn){ // bags where bag_number

			$regionfrom = $this->session->userdata('user_region');
			$emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);
			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');
		//$STARTdate = $today->format('2021-05-23');
			$STARTdate = date('2021-05-23');
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


		public  function get_item_from_bagstwo($trn){

			$regionfrom = $this->session->userdata('user_region');
			$emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);
			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch; 
			if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
				$sql = "SELECT * from bags where bag_number='$trn'  ";
			}
			elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

				$sql = "SELECT * from bags where bag_number='$trn' AND `bags`.`bag_region_from` = '$o_region' ";



			}

			else{
				$sql = "SELECT * from bags where bag_number='$trn' AND `bags`.`bag_branch_from`='$o_branch' ";

			}





			$query=$db2->query($sql);
			$result = $query->row();
			return $result;
		}

		public  function get_item_from_bagsDESPATCHED($trn){

			$regionfrom = $this->session->userdata('user_region');
			$emid = $this->session->userdata('user_login_id');
			$db2 = $this->load->database('otherdb', TRUE);
			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');
		//$date1 = $this->session->userdata('date');

			$id = $this->session->userdata('user_login_id');
			$info = $this->employee_model->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			if( $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == 'SUPPORTER' ){
				$sql = "SELECT `despatch`.*,`bags`.*  FROM `despatch`
				LEFT JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
				WHERE `bags`.`bag_number`='$trn' ";
			}else{
				$sql = "SELECT `despatch`.*,`bags`.*  FROM `despatch`
				LEFT JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
				WHERE `bags`.`bag_number`='$trn' AND `bags`.`bag_branch_from`='$o_branch'";
			}





			$query=$db2->query($sql);
			$result = $query->row();
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
		public  function get_ems_list_pending_supervisor($emid){
			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date2 = $this->session->userdata('date');
			$date = date('Y-m-d');

			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE  `transactions`.`status` = 'NotPaid'  AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";


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
			WHERE (`transactions`.`status` = 'NotPaid' OR `transactions`.`office_name` = 'Counter') AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_pending_task1($emid){

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
			WHERE (`transactions`.`status` = 'NotPaid' OR `transactions`.`office_name` = 'Counter') AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
			ORDER BY `sender_info`.`sender_id` DESC ";

			$query=$db2->query($sql);
			return $query->num_rows();
		}
		public  function getEndingDate($emid,$date){

			$db2 = $this->load->database('otherdb', TRUE);
			$sql = "SELECT * FROM `supervisor_attendance` WHERE date(`endday_date`) = '$date' AND `supervisee_name` = '$emid' ";
			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}
		public  function getEndingDate1($emid,$date){

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

				WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill'
				ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill'
				ORDER BY `sender_info`.`sender_id` DESC";

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}
		}
		public  function get_credit_customer_sum_byAccno($acc_no,$type){
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

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

				WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'No'
				ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `sender_info`.`s_pay_type` = '$type' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'No'
				ORDER BY `sender_info`.`sender_id` DESC";

				$query=$db2->query($sql);
				$result = $query->row();
				return $result;
			}
		}
		public  function get_credit_customer_list_byAccnoMonth($acc_no,$month,$date){
			$regionfrom = $this->session->userdata('user_region');
			$empid = $this->session->userdata('user_emid');
			$db2 = $this->load->database('otherdb', TRUE);

			$m = explode('-', $month);

			$day = @$m[0];
			$year = @$m[1];

			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				if(!empty($date)){

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
					LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

					WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date'
					ORDER BY `sender_info`.`sender_id` DESC ";

				}else{

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
					LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

					WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year'
					 -- AND `transactions`.`isBill_Id` = 'No'
					 ORDER BY `sender_info`.`sender_id` DESC ";

					}



				}else{

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' 
						AND `transactions`.`status` = 'Bill'";

					}else{

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
						AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill'";

					}

				}

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public  function get_credit_customer_list_byAccnoMonth0($acc_no,$month,$date){
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

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
						LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

						WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`isBill_Id` = 'No'
						ORDER BY `sender_info`.`sender_id` DESC ";

					}else{

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
						LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

						WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'No'
						ORDER BY `sender_info`.`sender_id` DESC ";

					}



				}else{

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`isBill_Id` = 'No'
						AND `transactions`.`status` = 'Bill'";

					}else{

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND `transactions`.`isBill_Id` = 'No'
						AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill'";

					}

				}

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}

			public  function get_credit_customer_list_byAccnoMonth2($acc_no,$month){
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
					LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

					WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'Ye'
					ORDER BY `sender_info`.`sender_id` DESC ";

				}else{

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND `transactions`.`isBill_Id` = 'Ye'
					AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill'";


				}

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}
			public  function get_credit_customer_sum_byAccnoMonth($acc_no,$month,$date){
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

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

						WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' 
						ORDER BY `sender_info`.`sender_id` DESC ";

					}else{
						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

						WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year'
						ORDER BY `sender_info`.`sender_id` DESC ";

					}

				}else{

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`status` = 'Bill' ";

					}else{


						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' ";


					}

				}

				$query=$db2->query($sql);
				$result = $query->row();
				return $result;
			}

			public  function get_credit_customer_sum_byAccnoMonth0($acc_no,$month,$date){
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

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

						WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`isBill_Id` = 'No'
						ORDER BY `sender_info`.`sender_id` DESC ";

					}else{
						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

						WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'No'
						ORDER BY `sender_info`.`sender_id` DESC ";

					}

				}else{

					if(!empty($date)){

						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'No'";

					}else{


						$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'No'";


					}

				}

				$query=$db2->query($sql);
				$result = $query->row();
				return $result;
			}
			public  function get_credit_customer_sum_byAccnoMonth2($acc_no,$month){
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

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
					LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

					WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'Ye'
					ORDER BY `sender_info`.`sender_id` DESC ";

				}else{

					$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'Ye'";

				}

				$query=$db2->query($sql);
				$result = $query->row();
				return $result;
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
					ORDER BY `sender_info`.`sender_id` DESC";

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
			public function get_region_name($o_region){

				$sql    = "SELECT * FROM `em_region` WHERE `reg_code`='$o_region'";
				$query  = $this->db->query($sql);
				$result = $query->row();
				return $result;

			}

			public  function get_item_received_HPO_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`receiver_info`.`r_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received'
				AND `sender_info`.`s_region` = '$o_region'   AND  `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`bag_status` = 'isNotBag'

				AND  `zones`.`zone_region` = '$o_region'
				AND  `zones`.`zone_branch` = '$o_branch'
				AND (`zone_employee`.`emid` = '$id' )
				ORDER BY `sender_info`.`sender_id` DESC ";



				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public  function get_item_received_HPO_from_counter_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$today = $today->format('Y-m-d');

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`receiver_info`.`r_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`


				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received'
				AND `sender_info`.`s_region` = '$o_region'   AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )  
				AND `transactions`.`bag_status` = 'isNotBag'
				AND date(`sender_info`.`date_registered`) = '$today'

				AND  `zones`.`zone_region` = '$o_region'
				AND  `zones`.`zone_branch` = '$o_branch'
				AND (`zone_employee`.`emid` = '$id' )
				ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";




				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}

			public  function get_item_received_HPO_from_branch_list(){  


				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$today = $today->format('Y-m-d');



				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`receiver_info`.`r_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `bags`.`bags_status` = 'isReceived'
				AND `sender_info`.`s_region` = '$o_region'   AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
				AND `sender_info`.`item_status`!='Derivered'
				AND `sender_info`.`item_status`!='Assigned'
				AND `sender_info`.`item_status`!='WaitingDelivery'
				AND date(`sender_info`.`date_registered`) = '$today'


				AND  `zones`.`zone_region` = '$o_region'
				AND  `zones`.`zone_branch` = '$o_branch'
				AND (`zone_employee`.`emid` = '$id' )
				ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0 ";




				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public  function get_item_received_HPO_list_Search($date,$month,$region){
				$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];

				$region = @$region;

				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$today = $today->format('Y-m-d');


				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				if(!empty($date)){
					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

					LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`receiver_info`.`r_region`
					LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received'
					AND `sender_info`.`s_region` = '$o_region'   AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND `transactions`.`bag_status` = 'isNotBag'

					AND  `zones`.`zone_region` = '$o_region'
					AND  `zones`.`zone_branch` = '$o_branch'
					AND (`zone_employee`.`emid` = '$id' ) AND date(`sender_info`.`date_registered`) = '$date'
					ORDER BY `sender_info`.`sender_id` DESC ";

				}elseif (!empty($month)) {
					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

					LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`receiver_info`.`r_region`
					LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received'
					AND `sender_info`.`s_region` = '$o_region'  AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND `transactions`.`bag_status` = 'isNotBag'

					AND  `zones`.`zone_region` = '$o_region'
					AND  `zones`.`zone_branch` = '$o_branch'
					AND (`zone_employee`.`emid` = '$id' )
					AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
					ORDER BY `sender_info`.`sender_id` DESC ";

				}else{
					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

					LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`receiver_info`.`r_region`
					LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received'
					AND `sender_info`.`s_region` = '$o_region'   AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND `transactions`.`bag_status` = 'isNotBag'
					AND  `zones`.`zone_region` = '$o_region'
					AND  `zones`.`zone_branch` = '$o_branch'
					AND (`zone_employee`.`emid` = '$id' )AND date(`sender_info`.`date_registered`) = '$today'
					ORDER BY `sender_info`.`sender_id` DESC ";

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

				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$today = $today->format('Y-m-d');

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					if($o_branch == 'GPO'|| $o_branch == 'Post Head Office'){

						$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
						FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND (( `sender_info`.`s_region` = '$o_region' AND ( `sender_info`.`s_district` = '$o_branch'  OR  `sender_info`.`s_district` = 'Post Head Office' OR  `sender_info`.`s_district` = 'GPO'   ) ) 
							OR ( `sender_info`.`s_region` = 'Mzizima') )

						AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
						AND `transactions`.`bag_status` = 'isNotBag'
						AND date(`sender_info`.`date_registered`) = '$today'
						ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";




					}else{

						$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
						FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region'
						AND `sender_info`.`s_district` = '$o_branch' 
						AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
						AND `transactions`.`bag_status` = 'isNotBag'
						AND date(`sender_info`.`date_registered`) = '$today'
						ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

					}



				}elseif($this->session->userdata('user_type') == 'RM'){

					if($o_branch == 'GPO'|| $o_branch == 'Post Head Office'){

						$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
						FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND (( `sender_info`.`s_region` = '$o_region'  ) 
							OR ( `sender_info`.`s_region` = 'Mzizima') ) 
						AND date(`sender_info`.`date_registered`) = '$today'
						AND `transactions`.`bag_status` = 'isNotBag'AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
						ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";



					}else{

						$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
						FROM `sender_info`
						LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
						LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag'AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
						AND date(`sender_info`.`date_registered`) = '$today'
						ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

					}



				}else{

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received' AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) 	AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

				}

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public  function get_item_received_from_counter_Hpo_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region'  AND `sender_info`.`s_district` = '$o_branch' AND  `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`bag_status` = 'isNotBag'
					ORDER BY `sender_info`.`sender_id` DESC ";

				}elseif($this->session->userdata('user_type') == 'RM'){

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND  `transactions`.`PaymentFor` = 'EMS'
					ORDER BY `sender_info`.`sender_id` DESC ";

				}else{

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received' AND  `transactions`.`PaymentFor` = 'EMS'  ORDER BY `sender_info`.`sender_id` DESC";

				}

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public  function get_item_received_from_branch_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$today = $today->format('Y-m-d');

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
					AND `bags`.`bags_status` = 'isReceived' AND `sender_info`.`s_region` = '$o_region'  AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) 	AND date(`sender_info`.`date_registered`) = '$today'
					ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

				}elseif($this->session->userdata('user_type') == 'RM'){

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
					AND `bags`.`bags_status` = 'isReceived' AND `sender_info`.`s_region` = '$o_region'  
					AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
					AND date(`sender_info`.`date_registered`) = '$today'
					ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

				}else{

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
					AND `bags`.`bags_status` = 'isReceived' AND ( `transactions`.`PaymentFor` = 'EMS' ||  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
					AND date(`sender_info`.`date_registered`) = '$today'
					ORDER BY `sender_info`.`sender_id` DESC   LIMIT 0";

				}

				$query=$db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public  function get_item_received_from_outside_Region_hpo_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'

				AND `bags`.`bags_status` = 'isReceived' 

				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
			-- AND `receiver_info`.`r_region` = '$o_region' 

			AND ( `transactions`.`PaymentFor` = 'EMS' || `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  
    --            AND `sender_info`.`item_status`!='Derivered'
    --           AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 AND  `zones`.`zone_region` = '$o_region'
			 AND  `zones`.`zone_branch` = '$o_branch'
			 AND (`zone_employee`.`emid` = '$id' )

			 ORDER BY `sender_info`.`sender_id` DESC ";







			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}


			public  function get_item_sorted_from_outside_Region_hpo_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$today = $today->format('Y-m-d');




				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'

				AND `bags`.`bags_status` = 'isReceived' 

				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
			-- AND `receiver_info`.`r_region` = '$o_region' 

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  
			AND date(`sender_info`.`date_registered`) = '$today'
    --            AND `sender_info`.`item_status`!='Derivered'
    --           AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 AND  `zones`.`zone_region` = '$o_region'
			 AND  `zones`.`zone_branch` = '$o_branch'
			 AND (`zone_employee`.`emid` = '$id' )

			 ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";







			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}



			public  function get_item_received_from_outside_Region_list(){
				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
					FROM `sender_info`
					LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
					LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
					LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

					WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
					AND `bags`.`bags_status` = 'isReceived' 
					AND `transactions`.`office_name` = 'Back'
					AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch' 
		    -- AND `receiver_info`.`r_region` = '$o_region'  
			 -- AND `receiver_info`.`branch` = '$o_branch'  
			 AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')

			 AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 ORDER BY `sender_info`.`sender_id` DESC ";

			}elseif($this->session->userdata('user_type') == 'RM'){

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `bags`.`bags_status` = 'isReceived' 
			 -- AND `transactions`.`item_received_by` != ''
			 -- AND `receiver_info`.`r_region` = '$o_region' 
			 AND `despatch`.`region_to`  = '$o_region'
			 AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  
			 AND `sender_info`.`item_status`!='Derivered'
			 AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			-- LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			 -- AND `transactions`.`item_received_by` != ''

			 WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			 AND `bags`.`bags_status` = 'isReceived'  AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')

			 AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC";

			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_item_sorted_from_outside_Region_list(){
			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$today = $today->format('Y-m-d');



			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived' 
				AND `receiver_info`.`r_region` = '$o_region'  
				AND `receiver_info`.`branch` = '$o_branch'  AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')
				AND date(`sender_info`.`date_registered`) = '$today'

			 -- AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0 ";

			}elseif($this->session->userdata('user_type') == 'RM'){

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived' 
				AND `receiver_info`.`r_region` = '$o_region' 
				AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  
				AND date(`sender_info`.`date_registered`) = '$today'
			 -- AND `sender_info`.`item_status`!='Derivered'
			 -- AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived'  AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')
				AND date(`sender_info`.`date_registered`) = '$today'
			 -- AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC   LIMIT 0";

			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_item_received_from_outside_HPO_Region_list(){
			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;



			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`

				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`


				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `bags`.`bags_status` = 'isReceived'   	
				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
			-- AND `receiver_info`.`r_region` = '$o_region' 
			AND `transactions`.`office_name` = 'Back'

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')

			 -- AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 ORDER BY `sender_info`.`sender_id` DESC ";

			}elseif($this->session->userdata('user_type') == 'RM'){

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`

				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `bags`.`bags_status` = 'isReceived' 
				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
				AND `transactions`.`office_name` = 'Back'
			-- AND `receiver_info`.`r_region` = '$o_region'   
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') 
			   -- AND `sender_info`.`item_status`!='Derivered'
			 -- AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived'  AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')
			 -- AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC";

			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_item_sorted_from_outside_HPO_Region_list(){
			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$today = $today->format('Y-m-d');



			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`

				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`


				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived'   	
				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
			-- AND `receiver_info`.`r_region` = '$o_region' 

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')
			AND date(`sender_info`.`date_registered`) = '$today'

			 -- AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

			}elseif($this->session->userdata('user_type') == 'RM'){

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`

				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived' 
				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
			-- AND `receiver_info`.`r_region` = '$o_region'   
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') 
			AND date(`sender_info`.`date_registered`) = '$today'
			 --   AND `sender_info`.`item_status`!='Derivered'
			 -- AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived'  AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')
				AND date(`sender_info`.`date_registered`) = '$today'
			 -- AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 ORDER BY `sender_info`.`sender_id` DESC  LIMIT 0";

			}

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}




		public  function get_item_received_list_search($date,$month,$region){

			$m = explode('-', $month);

			$day = @$m[0];
			$year = @$m[1];

			$region = @$region;

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$today = $today->format('Y-m-d');


			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

				if(!empty($date)){

				if($o_branch == 'GPO' || $o_branch == 'Post Head Office'){ //|| $o_branch = 'Post Head Office'

				

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND (( `sender_info`.`s_region` = '$o_region' AND ( `sender_info`.`s_district` = '$o_branch'  OR  `sender_info`.`s_district` = 'Post Head Office' OR  `sender_info`.`s_district` = 'GPO'   ) ) 
					OR ( `sender_info`.`s_region` = 'Mzizima') )
				AND `transactions`.`bag_status` = 'isNotBag' 

				AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND date(`sender_info`.`date_registered`) = '$date'
				ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$o_branch' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND date(`sender_info`.`date_registered`) = '$date'
				ORDER BY `sender_info`.`sender_id` DESC ";


			}





		}elseif (!empty($month)) {

			if($o_branch == 'GPO' || $o_branch == 'Post Head Office'){

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND (( `sender_info`.`s_region` = '$o_region' AND ( `sender_info`.`s_district` = '$o_branch'  OR  `sender_info`.`s_district` = 'Post Head Office' OR  `sender_info`.`s_district` = 'GPO'   ) ) 
					OR ( `sender_info`.`s_region` = 'Mzizima') )
				AND `transactions`.`bag_status` = 'isNotBag' 

				AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
				ORDER BY `sender_info`.`sender_id` DESC ";

			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$o_branch' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
				AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
				ORDER BY `sender_info`.`sender_id` DESC ";


			}


		}else{
			if($o_branch == 'GPO' || $o_branch == 'Post Head Office'){

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received'AND (( `sender_info`.`s_region` = '$o_region' AND ( `sender_info`.`s_district` = '$o_branch'  OR  `sender_info`.`s_district` = 'Post Head Office' OR  `sender_info`.`s_district` = 'GPO'   ) ) 
					OR ( `sender_info`.`s_region` = 'Mzizima') ) 
				AND `transactions`.`bag_status` = 'isNotBag'  AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
				AND date(`sender_info`.`date_registered`) = '$today'
				ORDER BY `sender_info`.`sender_id` DESC ";
			}else{

				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$o_branch' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
				AND date(`sender_info`.`date_registered`) = '$today'
				ORDER BY `sender_info`.`sender_id` DESC ";

			}


		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag'AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}else{

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received' 
			AND `sender_info`.`s_region` = '$region'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND `sender_info`.`s_region` = '$region'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";


		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND `sender_info`.`s_region` = '$region' AND date(`sender_info`.`date_registered`) = '$today' ORDER BY `sender_info`.`sender_id` DESC";


		}




	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}




public  function get_item_received_from_ouside_list_hpo_search($date,$month,$region){

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

	$region = @$region;

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');


	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;



	if(!empty($date)){
		$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
		LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
		LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
		LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

		WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
		AND `bags`.`bags_status` = 'isReceived'
		AND `despatch`.`region_to`  = '$o_region'
		AND `despatch`.`region_from`  != '$o_region'
		AND `transactions`.`office_name` = 'Back'
			-- AND `receiver_info`.`r_region` = '$o_region' 

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') 
			 --   AND `sender_info`.`item_status`!='Derivered'
			 -- AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 AND (`zone_employee`.`emid` = '$id' )
			 AND  `zones`.`zone_region` = '$o_region'
			 AND  `zones`.`zone_branch` = '$o_branch'

			 AND date(`sender_info`.`date_registered`) = '$date'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `bags`.`bags_status` = 'isReceived' AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region' 
				AND `transactions`.`office_name` = 'Back'
				AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND (`zone_employee`.`emid` = '$id' )
			 --  AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'


			 AND  `zones`.`zone_region` = '$o_region'
			 AND  `zones`.`zone_branch` = '$o_branch'
			 AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}else{
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived' AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'  
				AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND (`zone_employee`.`emid` = '$id' )
			 --  AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			 -- AND `sender_info`.`item_status`!='WaitingDelivery'
			 --  AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			 AND  `zones`.`zone_region` = '$o_region'
			 AND  `zones`.`zone_branch` = '$o_branch'

			 AND date(`sender_info`.`date_registered`) = '$today'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}

			



			


			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function get_item_sorted_from_ouside_list_hpo_search($date,$month,$region){

			$m = explode('-', $month);

			$day = @$m[0];
			$year = @$m[1];

			$region = @$region;

			$tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$today = $today->format('Y-m-d');


			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;



			if(!empty($date)){
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
				LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Received'
				AND `bags`.`bags_status` = 'isReceived'
				AND `despatch`.`region_to`  = '$o_region'
				AND `despatch`.`region_from`  != '$o_region'
			-- AND `receiver_info`.`r_region` = '$o_region' 

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			AND (`zone_employee`.`emid` = '$id' )
			AND  `zones`.`zone_region` = '$o_region'
			AND  `zones`.`zone_branch` = '$o_branch'

			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
			LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND (`zone_employee`.`emid` = '$id' )
			AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			
			AND  `zones`.`zone_region` = '$o_region'
			AND  `zones`.`zone_branch` = '$o_branch'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			LEFT JOIN `zone_employee` ON `zone_employee`.`region_name`=`sender_info`.`s_region`
			LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`

			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND (`zone_employee`.`emid` = '$id' )
			AND `sender_info`.`item_status`!='Derivered' AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'

			AND  `zones`.`zone_region` = '$o_region'
			AND  `zones`.`zone_branch` = '$o_branch'

			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



		


		

		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}




	public  function get_item_received_from_ouside_list_search($date,$month,$region){

		$m = explode('-', $month);

		$day = @$m[0];
		$year = @$m[1];

		$region = @$region;

		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$today = $today->format('Y-m-d');


		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;

		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			if(!empty($date)){
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived'

				AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch' 
			 -- AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch'
			 AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			 AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 AND date(`sender_info`.`date_registered`) = '$date'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived' 
				AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			-- AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch' 

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Back'
			AND `bags`.`bags_status` = 'isReceived' 
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			-- AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')
			AND `transactions`.`office_name` = 'Back' 
			AND `bags`.`bags_status` = 'isReceived'
			 -- AND `receiver_info`.`r_region` = '$o_region'
			 AND `despatch`.`region_to`  = '$o_region'  
			 AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			 AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 AND date(`sender_info`.`date_registered`) = '$date'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived' 
			 -- AND `receiver_info`.`r_region` = '$o_region' 
			 AND `despatch`.`region_to`  = '$o_region'  
			 AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			 AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			 ORDER BY `sender_info`.`sender_id` DESC ";

			}else{
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived'  
			-- AND `receiver_info`.`r_region` = '$o_region'
			AND `despatch`.`region_to`  = '$o_region'   
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}else{

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Back'
			AND `bags`.`bags_status` = 'isReceived'
			AND `despatch`.`region_to`  = '$o_region' 
			 -- AND `receiver_info`.`r_region` = '$o_region'
			 AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			 AND `sender_info`.`item_status`!='Assigned'
			 AND `sender_info`.`item_status`!='WaitingDelivery'
			 AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			 AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


			}elseif (!empty($month)) {
				$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
				LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
				WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
				AND `transactions`.`office_name` = 'Back'
				AND `bags`.`bags_status` = 'isReceived' 
			-- AND `receiver_info`.`r_region` = '$o_region' 
			AND `despatch`.`region_to`  = '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";


		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Back'
			AND `bags`.`bags_status` = 'isReceived'  
			-- AND `receiver_info`.`r_region` = '$o_region' 
			AND `despatch`.`region_to`  = '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today' ORDER BY `sender_info`.`sender_id` DESC";


		}




	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_item_sorted_from_ouside_list_search($date,$month,$region){

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

	$region = @$region;

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');


	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' 
			AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' 
			AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch' 

			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')
			AND `transactions`.`office_name` = 'Received' 
			AND `bags`.`bags_status` = 'isReceived' 
			AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'
			AND `receiver_info`.`r_region` = '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `receiver_info`.`r_region` = '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `receiver_info`.`r_region` = '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}else{

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')
			AND `transactions`.`office_name` = 'Received' 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";


		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `receiver_info`.`r_region` = '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today' ORDER BY `sender_info`.`sender_id` DESC";


		}




	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_item_received_from_ouside_list_hpo_2search($date,$month,$region){

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

	$region = @$region;

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');


	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' 
			AND `transactions`.`office_name` = 'Back'
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' 
			AND `transactions`.`office_name` = 'Back'
			-- AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch' 
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' 
			AND `transactions`.`office_name` = 'Back'
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived'
			AND `transactions`.`office_name` = 'Back'
			AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND `transactions`.`office_name` = 'Back'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'   
			AND `transactions`.`office_name` = 'Back'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}else{

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region' 
			AND `transactions`.`office_name` = 'Back'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND `transactions`.`office_name` = 'Back'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";


		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND `transactions`.`office_name` = 'Back'
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today' ORDER BY `sender_info`.`sender_id` DESC";


		}




	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_item_sorted_from_ouside_list_hpo_2search($date,$month,$region){

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

	$region = @$region;

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');


	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' 
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' 
			-- AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch' 
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived' 
			AND `despatch`.`region_to`  = '$o_region'AND `despatch`.`branch_to` = '$o_branch'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'
			AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region' 
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'   
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}else{

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL')  AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";


		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			LEFT JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `transactions`.`office_name` = 'Received'
			AND `bags`.`bags_status` = 'isReceived'  AND `despatch`.`region_to`  = '$o_region'
			AND `despatch`.`region_from`  != '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL') AND `sender_info`.`item_status`!='Derivered'
			AND `sender_info`.`item_status`!='Assigned'
			AND `sender_info`.`item_status`!='WaitingDelivery'
			AND `sender_info`.`item_status`!='Senttoips'  AND `sender_info`.`item_status`!='Officeofexchange'
			AND date(`sender_info`.`date_registered`) = '$today' ORDER BY `sender_info`.`sender_id` DESC";


		}




	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_item_received_branch_list_search($date,$month,$region){

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

	$region = @$region;

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');


	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  ) AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch' AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'  AND `receiver_info`.`branch` = '$o_branch'AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND date(`sender_info`.`date_registered`) = '$date'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$o_region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND date(`sender_info`.`date_registered`) = '$today'
			ORDER BY `sender_info`.`sender_id` DESC ";

		}



	}else{

		if(!empty($date)){
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";


		}elseif (!empty($month)) {
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";


		}else{
			$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`fullname`,`transactions`.`id`,`office_name`,`bag_status`,`Barcode`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`

			LEFT JOIN `bags` ON `bags`.`bag_number`=`transactions`.`isBagNo`
			WHERE (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') 
			AND `bags`.`bags_status` = 'isReceived' AND `receiver_info`.`r_region` = '$region'  
			AND ( `transactions`.`PaymentFor` = 'EMS' OR  `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'  )
			AND date(`sender_info`.`date_registered`) = '$today' ORDER BY `sender_info`.`sender_id` DESC";


		}




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

public  function get_ems_per_date($date,$emid){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;
	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE date(`sender_info`.`date_registered`) = '$date'  AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$emid' ORDER BY `transactions`.`id` DESC ";
	}else{

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE date(`sender_info`.`date_registered`) = '$date'   ORDER BY `transactions`.`id` DESC ";
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

public  function get_ems_per_date_by_emid1($year,$month,$day,$emid){

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


public  function get_ems_bill_per_date_by_emid1($year,$month,$day,$emid){

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
	AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`status` ='Bill' AND `sender_info`.`s_district` = '$o_branch'
	AND `transactions`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' ORDER BY `transactions`.`id` DESC ";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}


public  function get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;
	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'
		|| $this->session->userdata('user_type') == 'SUPERVISOR') {

		$sql = "SELECT 
	`sender_info`.`date_registered`,`sender_info`.`track_number`,
	`sender_info`.`s_region`,`sender_info`.`s_district`,
	`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
	`sender_info`.`s_address`,`sender_info`.`s_email`,
	`sender_info`.`s_mobile`,`sender_info`.`operator`,
	`sender_info`.`s_status`,

	`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
	`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
	`receiver_info`.`mobile`,

	`$DB`.`billid`,
	`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


	FROM `sender_info`
	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

	WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
	AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
	AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
	AND `$DB`.`PaymentFor` LIKE '%$type%'
	ORDER BY `$DB`.`id` DESC ";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function get_details_per_date_by_emid_Sender1($type,$year,$month,$day,$emid,$DB){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;
	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'
		|| $this->session->userdata('user_type') == 'SUPERVISOR') {

		$sql = "SELECT 
	`sender_info`.`date_registered`,`sender_info`.`track_number`,
	`sender_info`.`s_region`,`sender_info`.`s_district`,
	`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
	`sender_info`.`s_address`,`sender_info`.`s_email`,
	`sender_info`.`s_mobile`,`sender_info`.`operator`,
	`sender_info`.`s_status`,

	`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
	`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
	`receiver_info`.`mobile`,

	`$DB`.`billid`,
	`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


	FROM `sender_info`
	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

	WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
	AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
	AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
	AND `$DB`.`PaymentFor` LIKE '%$type%'
	ORDER BY `$DB`.`id` DESC ";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;


	$sql = "SELECT 
	`sender_info`.`date_registered`,`sender_info`.`track_number`,
	`sender_info`.`s_region`,`sender_info`.`s_district`,
	`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
	`sender_info`.`s_address`,`sender_info`.`s_email`,
	`sender_info`.`s_mobile`,`sender_info`.`operator`,
	`sender_info`.`s_status`,

	`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
	`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
	`receiver_info`.`mobile`,

	`$DB`.`billid`,
	`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


	FROM `sender_info`
	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

	WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
	AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
	AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
	AND `$DB`.`PaymentFor` LIKE '%$type%'
	ORDER BY `$DB`.`id` DESC ";

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;


	$sql = "SELECT 
	`sender_info`.`date_registered`,`sender_info`.`track_number`,
	`sender_info`.`s_region`,`sender_info`.`s_district`,
	`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
	`sender_info`.`s_address`,`sender_info`.`s_email`,
	`sender_info`.`s_mobile`,`sender_info`.`operator`,
	`sender_info`.`s_status`,`sender_info`.`weight`,

	`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
	`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
	`receiver_info`.`mobile`,

	`$DB`.`billid`,
	`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


	FROM `sender_info`
	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

	WHERE   DAY(date(`sender_info`.`date_registered`)) >= '$day'AND MONTH(date(`sender_info`.`date_registered`)) >= '$month'
	AND YEAR(date(`sender_info`.`date_registered`)) >= '$year' 
	AND DAY(date(`sender_info`.`date_registered`)) <= '$day2'AND MONTH(date(`sender_info`.`date_registered`)) <= '$month2'
	AND YEAR(date(`sender_info`.`date_registered`)) <= '$year2'
	AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
	AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
	AND `$DB`.`PaymentFor` LIKE '%$type%'
	ORDER BY `$DB`.`id` DESC ";

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;


	$sql = "SELECT 
	`sender_info`.`date_registered`,`sender_info`.`track_number`,
	`sender_info`.`s_region`,`sender_info`.`s_district`,
	`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
	`sender_info`.`s_address`,`sender_info`.`s_email`,
	`sender_info`.`s_mobile`,`sender_info`.`operator`,
	`sender_info`.`s_status`,

	`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
	`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
	`receiver_info`.`mobile`,

	`$DB`.`billid`,
	`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


	FROM `sender_info`
	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

	WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
			-- AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' AND `$DB`.`item_received_by` = '$emid' 
			AND `$DB`.`PaymentFor` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_details_per_date_by_emid_Sender_serial($type,$year,$month,$day,$emid,$DB){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;

			$sql = "SELECT 
			`sender_info`.`date_registered`,`sender_info`.`track_number`,
			`sender_info`.`s_region`,`sender_info`.`s_district`,
			`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
			`sender_info`.`s_address`,`sender_info`.`s_email`,
			`sender_info`.`s_mobile`,`sender_info`.`operator`,
			`sender_info`.`s_status`,

			`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
			`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
			`receiver_info`.`mobile`,

			`$DB`.`billid`,
			`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

			WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
			AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_details_per_date_by_emid_Sender_serial1($type,$year,$month,$day,$emid,$DB){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`sender_info`.`date_registered`,`sender_info`.`track_number`,
			`sender_info`.`s_region`,`sender_info`.`s_district`,
			`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
			`sender_info`.`s_address`,`sender_info`.`s_email`,
			`sender_info`.`s_mobile`,`sender_info`.`operator`,
			`sender_info`.`s_status`,

			`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
			`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
			`receiver_info`.`mobile`,

			`$DB`.`billid`,
			`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

			WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
			AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_details_per_date_by_emid_Sender_serial22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`sender_info`.`date_registered`,`sender_info`.`track_number`,
			`sender_info`.`s_region`,`sender_info`.`s_district`,
			`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
			`sender_info`.`s_address`,`sender_info`.`s_email`,
			`sender_info`.`s_mobile`,`sender_info`.`operator`,
			`sender_info`.`s_status`,`sender_info`.`weight`,

			`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
			`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
			`receiver_info`.`mobile`,

			`$DB`.`billid`,
			`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

			WHERE  DAY(date(`sender_info`.`date_registered`)) >= '$day'AND MONTH(date(`sender_info`.`date_registered`)) >= '$month'
			AND YEAR(date(`sender_info`.`date_registered`)) >= '$year' 
			AND DAY(date(`sender_info`.`date_registered`)) <= '$day2'AND MONTH(date(`sender_info`.`date_registered`)) <= '$month2'
			AND YEAR(date(`sender_info`.`date_registered`)) <= '$year2'
			AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}



		public  function get_details_per_date_by_emid_Sender_serial11($type,$year,$month,$day,$emid,$DB){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`sender_info`.`date_registered`,`sender_info`.`track_number`,
			`sender_info`.`s_region`,`sender_info`.`s_district`,
			`sender_info`.`sender_id`,`sender_info`.`s_fullname`,
			`sender_info`.`s_address`,`sender_info`.`s_email`,
			`sender_info`.`s_mobile`,`sender_info`.`operator`,
			`sender_info`.`s_status`,

			`receiver_info`.`r_region`,`receiver_info`.`branch`,`receiver_info`.`receiver_id`,
			`receiver_info`.`fullname`,`receiver_info`.`address`,`receiver_info`.`email`,
			`receiver_info`.`mobile`,

			`$DB`.`billid`,
			`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`,`$DB`.`Barcode`


			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `$DB` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`

			WHERE YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$month' AND DAY(`sender_info`.`date_registered`) = '$day'
			-- AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' AND `$DB`.`item_received_by` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function get_details_per_date_by_emid_NoSender($type,$year,$month,$day,$emid,$DB){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'
				|| $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT 
			`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB`.`CustomerID` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		-- `$DB`.`operator`,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB`.`CustomerID` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`

		WHERE YEAR(transactiondate) = '$year' AND MONTH(transactiondate) = '$month' AND DAY(transactiondate) = '$day'
		AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
		AND `$DB`.`status` != 'Cancel' 
			-- AND `sender_info`.`operator` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";
		}
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_details_per_date_by_emid_GENERAL($type,$year,$month,$day,$emid,$DB,$DB1){

		$regionfrom = $this->session->userdata('user_region');

		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'
			|| $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT 
		`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB`.`serial` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		`$DB`.`CustomerID`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB`.`serial` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `$DB`.`serial`


		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
		AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
		AND `$DB`.`status` != 'Cancel' 
		AND `$DB`.`CustomerID` = '$emid' 
		AND `$DB`.`serial` LIKE '%$type%'
		ORDER BY `$DB`.`id` DESC ";
	}
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->query("SET sql_mode = '' ");
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;
	

	$sql = "SELECT 
	`transactions`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`transactions`.`region` as s_region ,
		`transactions`.`district` as s_district ,
		`transactions`.`serial` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		`transactions`.`CustomerID`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`transactions`.`Customer_mobile` as s_mobile ,
		

		`transactions`.`region` as r_region ,
		`transactions`.`district` as branch ,
		`transactions`.`serial` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`transactions`.`Customer_mobile` as mobile,

		`transactions`.`billid`,
		`transactions`.`office_name`,`transactions`.`status`,`transactions`.`id`,`transactions`.`paidamount`


		FROM `transactions`
			 -- INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `transactions`.`serial`


			 WHERE YEAR(`transactions`.`transactiondate`) = '$year' AND MONTH(`transactions`.`transactiondate`) = '$month' AND DAY(`transactions`.`transactiondate`) = '$day'
			 AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch'
			 AND `transactions`.`status` != 'Cancel' 
			 AND `transactions`.`CustomerID` = '$emid' 
			 AND `transactions`.`serial` LIKE '%$type%'
			 ORDER BY `transactions`.`id` DESC ";

			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}

			public  function get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1){

				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$sql = "SELECT 
				`transactions`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`transactions`.`region` as s_region ,
		`transactions`.`district` as s_district ,
		`transactions`.`serial` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		`transactions`.`CustomerID`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`transactions`.`Customer_mobile` as s_mobile ,
		

		`transactions`.`region` as r_region ,
		`transactions`.`district` as branch ,
		`transactions`.`serial` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`transactions`.`Customer_mobile` as mobile,

		`transactions`.`billid`,
		`transactions`.`office_name`,`transactions`.`status`,`transactions`.`id`,`transactions`.`paidamount`


		FROM `transactions`
			 -- INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `transactions`.`serial`


			 WHERE  DAY(date(`transactions`.`transactiondate`)) >= '$day'AND MONTH(date(`transactions`.`transactiondate`)) >= '$month'
			 AND YEAR(date(`transactions`.`transactiondate`)) >= '$year' 
			 AND DAY(date(`transactions`.`transactiondate`)) <= '$day2'AND MONTH(date(`transactions`.`transactiondate`)) <= '$month2'
			 AND YEAR(date(`transactions`.`transactiondate`)) <= '$year2'

			 -- YEAR(`transactions`.`transactiondate`) = '$year' AND MONTH(`transactions`.`transactiondate`) = '$month' AND DAY(`transactions`.`transactiondate`) = '$day'
			 AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch'
			 AND `transactions`.`status` != 'Cancel' 
			 AND `transactions`.`CustomerID` = '$emid' 
			 AND `transactions`.`serial` LIKE '%$type%'
			 ORDER BY `transactions`.`id` DESC ";

			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}


			public  function get_details_per_date_by_emid_registered_international($type,$year,$month,$day,$emcode,$DB,$DB1){

				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$sql = "SELECT 
				`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB1`.`id` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		-- `$DB1`.`Created_byId`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB1`.`id` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `$DB`.`serial`


		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
		AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
		AND `$DB`.`status` != 'Cancel' 
		AND `$DB1`.`Created_byId` = '$emcode' 
		AND `$DB`.`PaymentFor` LIKE '%$type%'
		ORDER BY `$DB`.`id` DESC ";
		
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_details_per_date_by_emid_registered_international22($type,$year,$month,$day,$year2,$month2,$day2,$emcode,$DB,$DB1){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		

		$sql = "SELECT 
		`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB1`.`id` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		-- `$DB1`.`Created_byId`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB1`.`id` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `$DB`.`serial`


		WHERE  DAY(date(`$DB`.`transactiondate`)) >= '$day'AND MONTH(date(`$DB`.`transactiondate`)) >= '$month'
		AND YEAR(date(`$DB`.`transactiondate`)) >= '$year' 
		AND DAY(date(`$DB`.`transactiondate`)) <= '$day2'AND MONTH(date(`$DB`.`transactiondate`)) <= '$month2'
		AND YEAR(date(`$DB`.`transactiondate`)) <= '$year2'

			-- YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
			AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' 
			AND `$DB1`.`Created_byId` = '$emcode' 
			AND `$DB`.`PaymentFor` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_details_per_date_by_emid_registered_international1($type,$year,$month,$day,$emcode,$DB,$DB1){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB1`.`id` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		-- `$DB1`.`Created_byId`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB1`.`id` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `$DB`.`serial`


		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
			-- AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' 
			AND `$DB`.`item_received_by` = '$emcode' 
			AND `$DB`.`PaymentFor` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function get_details_per_date_by_emid_RegisterBill($type,$year,$month,$day,$emid,$DB,$DB1){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB1`.`credit_id` as sender_id ,
		
		`$DB1`.`customer_name` as s_fullname ,
		`$DB1`.`created_by`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		`$DB1`.`customer_address` as s_address ,
		`$DB1`.`cust_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB1`.`credit_id` as receiver_id ,

		`$DB1`.`customer_name` as fullname ,
		`$DB1`.`customer_address` as address ,
		`$DB1`.`cust_email` as email ,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN `$DB1` ON `$DB1`.`credit_id` = `$DB`.`CustomerID`


		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
		AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
		AND `$DB`.`status` != 'Cancel' 
		AND `$DB1`.`created_by` = '$emid' 
		AND `$DB`.`serial` LIKE '%$type%'
		ORDER BY `$DB`.`id` DESC ";
		
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_details_per_date_by_emid_RegisterBill22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		

		$sql = "SELECT 
		`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB1`.`credit_id` as sender_id ,
		
		`$DB1`.`customer_name` as s_fullname ,
		`$DB1`.`created_by`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		`$DB1`.`customer_address` as s_address ,
		`$DB1`.`cust_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB1`.`credit_id` as receiver_id ,

		`$DB1`.`customer_name` as fullname ,
		`$DB1`.`customer_address` as address ,
		`$DB1`.`cust_email` as email ,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN `$DB1` ON `$DB1`.`credit_id` = `$DB`.`CustomerID`


		WHERE  DAY(date(`$DB`.`transactiondate`)) >= '$day'AND MONTH(date(`$DB`.`transactiondate`)) >= '$month'
		AND YEAR(date(`$DB`.`transactiondate`)) >= '$year' 
		AND DAY(date(`$DB`.`transactiondate`)) <= '$day2'AND MONTH(date(`$DB`.`transactiondate`)) <= '$month2'
		AND YEAR(date(`$DB`.`transactiondate`)) <= '$year2'
			-- YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
			AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' 
			AND `$DB1`.`created_by` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function get_details_per_date_by_emid_RegisterBill1($type,$year,$month,$day,$emid,$DB,$DB1){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB1`.`credit_id` as sender_id ,
		
		`$DB1`.`customer_name` as s_fullname ,
		`$DB1`.`created_by`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		`$DB1`.`customer_address` as s_address ,
		`$DB1`.`cust_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB1`.`credit_id` as receiver_id ,

		`$DB1`.`customer_name` as fullname ,
		`$DB1`.`customer_address` as address ,
		`$DB1`.`cust_email` as email ,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN `$DB1` ON `$DB1`.`credit_id` = `$DB`.`CustomerID`


		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
			-- AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' 
			AND `$DB`.`item_received_by` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}


		public  function get_details_per_date_by_emid_Commission($type,$year,$month,$day,$emid,$DB,$DB1){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;
			if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT'
				|| $this->session->userdata('user_type') == 'SUPERVISOR') {

				$sql = "SELECT 
			`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB`.`region` as s_region ,
		`$DB`.`district` as s_district ,
		`$DB`.`serial` as sender_id ,
		
		-- `$DB`.`customer_name` as s_fullname ,
		`$DB`.`CustomerID`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB`.`region` as r_region ,
		`$DB`.`district` as branch ,
		`$DB`.`serial` as receiver_id ,

		-- `$DB`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		`$DB`.`office_name`,`$DB`.`status`,`$DB`.`id`,`$DB`.`paidamount`


		FROM `$DB`
		INNER JOIN  `$DB1`  ON   `$DB1`.`serial`   = `$DB`.`serial`


		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
		AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
		AND `$DB`.`status` != 'Cancel' 
		AND `$DB`.`CustomerID` = '$emid' 
		AND `$DB`.`serial` LIKE '%$type%'
		ORDER BY `$DB`.`id` DESC ";
	}
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_details_per_date_by_emid_Parking212($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1){

	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;


	$sql = "SELECT 
	`$DB1`.`entry_time` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB1`.`operator_region` as s_region ,
		`$DB1`.`operator_branch` as s_district ,
		`$DB1`.`parking_id` as sender_id ,
		
		`$DB1`.`vehicle_owner` as s_fullname ,
		`$DB1`.`operator_id`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		-- `$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB1`.`operator_region` as r_region ,
		`$DB1`.`operator_branch` as branch ,
		`$DB1`.`vehicle_regno` as receiver_id ,

		`$DB1`.`vehicle_owner` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		-- `$DB`.`Customer_mobile` as mobile,

		`$DB1`.`controlno` as billid ,
		-- `$DB`.`office_name`,
		`$DB1`.`status`,`$DB1`.`parking_id` as id,`$DB1`.`cost` as paidamount


		FROM `$DB1`

		WHERE DAY(date(`$DB1`.`entry_time`)) >= '$day'AND MONTH(date(`$DB1`.`entry_time`)) >= '$month'
		AND YEAR(date(`$DB1`.`entry_time`)) >= '$year' 
		AND DAY(date(`$DB1`.`entry_time`)) <= '$day2'AND MONTH(date(`$DB1`.`entry_time`)) <= '$month2'
		AND YEAR(date(`$DB1`.`entry_time`)) <= '$year2'

			-- YEAR(`$DB1`.`entry_time`) = '$year' AND MONTH(`$DB1`.`entry_time`) = '$month' AND DAY(`$DB1`.`entry_time`) = '$day'
			AND `$DB1`.`operator_region` = '$o_region' AND `$DB1`.`operator_branch` = '$o_branch'
			AND `$DB1`.`status` != 'Cancel' 
			AND `$DB1`.`operator_id` = '$emid' 
			 -- AND `$DB1`.`serial` LIKE '%$type%'
			 ORDER BY `$DB1`.`parking_id` DESC ";

			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}

			public  function get_details_per_date_by_emid_Parking($type,$year,$month,$day,$emid,$DB,$DB1){

				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$sql = "SELECT 
				`$DB1`.`entry_time` as date_registered ,
		-- `derivery_info`.`track_number`,
		`$DB1`.`operator_region` as s_region ,
		`$DB1`.`operator_branch` as s_district ,
		`$DB1`.`parking_id` as sender_id ,
		
		`$DB1`.`vehicle_owner` as s_fullname ,
		`$DB1`.`operator_id`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		-- `$DB`.`Customer_mobile` as s_mobile ,
		

		`$DB1`.`operator_region` as r_region ,
		`$DB1`.`operator_branch` as branch ,
		`$DB1`.`vehicle_regno` as receiver_id ,

		`$DB1`.`vehicle_owner` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		-- `$DB`.`Customer_mobile` as mobile,

		`$DB1`.`controlno` as billid ,
		-- `$DB`.`office_name`,
		`$DB1`.`status`,`$DB1`.`parking_id` as id,`$DB1`.`cost` as paidamount


		FROM `$DB1`

		WHERE YEAR(`$DB1`.`entry_time`) = '$year' AND MONTH(`$DB1`.`entry_time`) = '$month' AND DAY(`$DB1`.`entry_time`) = '$day'
		AND `$DB1`.`operator_region` = '$o_region' AND `$DB1`.`operator_branch` = '$o_branch'
		AND `$DB1`.`status` != 'Cancel' 
		AND `$DB1`.`operator_id` = '$emid' 
			 -- AND `$DB1`.`serial` LIKE '%$type%'
			 ORDER BY `$DB1`.`parking_id` DESC ";

			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}

			public  function get_details_per_date_by_emid_Parking2($type,$year,$month,$day,$emid,$DB,$DB1){

				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$sql = "SELECT 
				`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		-- `$DB1`.`operator_region` as s_region ,
		-- `$DB1`.`operator_branch` as s_district ,
		`$DB`.`t_id` as sender_id ,
		
		 -- `$DB1`.`vehicle_owner` as s_fullname ,
		 `$DB`.`emid`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		-- `$DB`.`Customer_mobile` as s_mobile ,
		

		-- `$DB1`.`operator_region` as r_region ,
		-- `$DB1`.`operator_branch` as branch ,
		`$DB`.`t_id` as receiver_id ,

		-- `$DB1`.`vehicle_owner` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		-- `$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		-- `$DB`.`office_name`,
		`$DB`.`status`,`$DB`.`t_id` as id,`$DB`.`paidamount`


		FROM `$DB`

		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
			-- AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' 
			AND `$DB`.`emid` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`t_id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}

		public  function get_details_per_date_by_emid_Parking22($type,$year,$month,$day,$emid,$DB,$DB1){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;


			$sql = "SELECT 
			`$DB`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		-- `$DB1`.`operator_region` as s_region ,
		-- `$DB1`.`operator_branch` as s_district ,
		`$DB`.`t_id` as sender_id ,
		
		 -- `$DB1`.`vehicle_owner` as s_fullname ,
		 `$DB`.`emid`  as operator,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		-- `$DB`.`Customer_mobile` as s_mobile ,
		

		-- `$DB1`.`operator_region` as r_region ,
		-- `$DB1`.`operator_branch` as branch ,
		`$DB`.`t_id` as receiver_id ,

		-- `$DB1`.`vehicle_owner` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		-- `$DB`.`Customer_mobile` as mobile,

		`$DB`.`billid`,
		-- `$DB`.`office_name`,
		`$DB`.`status`,`$DB`.`t_id` as id,`$DB`.`paidamount`


		FROM `$DB`

		WHERE  DAY(date(`$DB`.`transactiondate`)) >= '$day'AND MONTH(date(`$DB`.`transactiondate`)) >= '$month'
		AND YEAR(date(`$DB`.`transactiondate`)) >= '$year' 
		AND DAY(date(`$DB`.`transactiondate`)) <= '$day2'AND MONTH(date(`$DB`.`transactiondate`)) <= '$month2'
		AND YEAR(date(`$DB`.`transactiondate`)) <= '$year2'
			-- AND `$DB`.`region` = '$o_region' AND `$DB`.`district` = '$o_branch'
			AND `$DB`.`status` != 'Cancel' 
			AND `$DB`.`emid` = '$emid' 
			AND `$DB`.`serial` LIKE '%$type%'
			ORDER BY `$DB`.`t_id` DESC ";

			$query=$db2->query($sql);
			$result = $query->result();
			return $result;
		}



		public  function get_details_per_date_by_emid_Derivery($type,$year,$month,$day,$emid,$DB){

			$regionfrom = $this->session->userdata('user_region');
			$db2 = $this->load->database('otherdb', TRUE);
			$id = $this->session->userdata('user_login_id');
			$info = $this->GetBasic($id);
			$o_region = $info->em_region;
			$o_branch = $info->em_branch;



			$sql = "SELECT 

			`derivery_info`.`datetime` as date_registered ,
		-- `derivery_info`.`track_number`,
		`derivery_info`.`region` as s_region ,
		`derivery_info`.`branch` as s_district ,
		`derivery_info`.`id_id` as sender_id ,
		`derivery_info`.`customer_name` as s_fullname ,
		`derivery_info`.`operator`,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`derivery_info`.`mobile` as s_mobile ,
		

		`derivery_info`.`region` as r_region ,
		`derivery_info`.`branch` as branch ,
		`derivery_info`.`id_id` as receiver_id ,
		`derivery_info`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`derivery_info`.`mobile` as mobile,

		`$DB`.`billid`,`$DB`.`status`,`$DB`.`t_id` as  id ,`$DB`.`paidamount`
		-- `$DB`.`office_name`,





		FROM `derivery_info`
		INNER JOIN  `$DB`  ON   `$DB`.`register_id`   = `derivery_info`.`id_id`

		WHERE YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
		AND `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch'
		AND `$DB`.`status` != 'Cancel' AND `derivery_info`.`operator` = '$emid' 
		AND `$DB`.`serial` LIKE '%$type%'
		ORDER BY `$DB`.`t_id` DESC ";
		
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_details_per_date_by_emid_Derivery22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		


		$sql = "SELECT 

		`derivery_info`.`datetime` as date_registered ,
		-- `derivery_info`.`track_number`,
		`derivery_info`.`region` as s_region ,
		`derivery_info`.`branch` as s_district ,
		`derivery_info`.`id_id` as sender_id ,
		`derivery_info`.`customer_name` as s_fullname ,
		`derivery_info`.`operator`,
		-- `derivery_info`.`sender_status` as s_status ,
		-- `derivery_info`.`sender_address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`derivery_info`.`mobile` as s_mobile ,
		

		`derivery_info`.`region` as r_region ,
		`derivery_info`.`branch` as branch ,
		`derivery_info`.`id_id` as receiver_id ,
		`derivery_info`.`customer_name` as fullname ,
		-- `derivery_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`derivery_info`.`mobile` as mobile,

		`$DB`.`billid`,`$DB`.`status`,`$DB`.`t_id` as  id ,`$DB`.`paidamount`
		-- `$DB`.`office_name`,





		FROM `derivery_info`
		INNER JOIN  `$DB`  ON   `$DB`.`register_id`   = `derivery_info`.`id_id`

		WHERE  DAY(date(`$DB`.`transactiondate`)) >= '$day'AND MONTH(date(`$DB`.`transactiondate`)) >= '$month'
		AND YEAR(date(`$DB`.`transactiondate`)) >= '$year' 
		AND DAY(date(`$DB`.`transactiondate`)) <= '$day2'AND MONTH(date(`$DB`.`transactiondate`)) <= '$month2'
		AND YEAR(date(`$DB`.`transactiondate`)) <= '$year2'
			 -- YEAR(`$DB`.`transactiondate`) = '$year' AND MONTH(`$DB`.`transactiondate`) = '$month' AND DAY(`$DB`.`transactiondate`) = '$day'
			 AND `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch'
			 AND `$DB`.`status` != 'Cancel' AND `derivery_info`.`operator` = '$emid' 
			 AND `$DB`.`serial` LIKE '%$type%'
			 ORDER BY `$DB`.`t_id` DESC ";

			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}

			public function getRegionbyname($bra){

				$sql = "SELECT 
				`em_region`.`region_id`
				FROM `em_region`
				WHERE `em_region`.`region_name`='$bra'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			}

			public function getBranchbyname($bra){

				$sql = "SELECT 
				`em_branch`.`branch_id`
				FROM `em_branch`
				WHERE `em_branch`.`branch_name`='$bra'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			}


			public  function get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB){

				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
				$region =$this->getRegionbyname($o_region);
				$district =$this->getBranchbyname($o_branch);
				$regioncode =$region->region_id;
				$districtcode =$district->branch_id;


				$sql ="SELECT  

				`real_estate_transactions`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`estate_information`.`region` as s_region ,
		`estate_information`.`district` as s_district ,

		`estate_contract_information`.`tenant_id` as sender_id ,

		`estate_tenant_information`.`customer_name` as s_fullname ,
		`estate_tenant_information`.`operator`,
		-- `derivery_info`.`sender_status` as s_status ,
		`estate_tenant_information`.`address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`estate_tenant_information`.`mobile_number` as s_mobile ,
		

		`estate_information`.`region` as r_region ,
		`estate_information`.`district` as branch ,
		`estate_contract_information`.`tenant_id` as receiver_id ,
		`estate_tenant_information`.`customer_name` as fullname ,
		`estate_tenant_information`.`address` as address ,
		-- `receiver_register_info`.`email`,
		`estate_tenant_information`.`mobile_number` as mobile,

		`real_estate_transactions`.`billid`,`real_estate_transactions`.`status`,
		`real_estate_transactions`.`t_id` as  id ,`real_estate_transactions`.`paidamount`
		-- `$DB`.`office_name`,






		FROM `real_estate_transactions`

		LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
		LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
		LEFT JOIN `estate_tenant_information` ON `real_estate_transactions`.`tenant_id`=`estate_tenant_information`.`tenant_id`

		WHERE `estate_information`.`estate_type` LIKE '%$type%'

		AND `estate_information`.`region` = '$regioncode'
		AND `estate_information`.`district` = '$districtcode'
		AND `estate_tenant_information`.`operator` = '$emid'
		AND `real_estate_transactions`.`status` != 'Cancel'

		AND  YEAR(`real_estate_transactions`.`transactiondate`) = '$year' AND MONTH(`real_estate_transactions`.`transactiondate`) = '$month' AND DAY(`real_estate_transactions`.`transactiondate`) = '$day'

		ORDER BY `real_estate_transactions`.`billid`";



		
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}


	public  function get_details_per_date_by_emid_RealEstate22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		$region =$this->getRegionbyname($o_region);
		$district =$this->getBranchbyname($o_branch);
		$regioncode =$region->region_id;
		$districtcode =$district->branch_id;

		
		$sql ="SELECT  

		`real_estate_transactions`.`transactiondate` as date_registered ,
		-- `derivery_info`.`track_number`,
		`estate_information`.`region` as s_region ,
		`estate_information`.`district` as s_district ,

		`estate_contract_information`.`tenant_id` as sender_id ,

		`estate_tenant_information`.`customer_name` as s_fullname ,
		`estate_tenant_information`.`operator`,
		-- `derivery_info`.`sender_status` as s_status ,
		`estate_tenant_information`.`address` as s_address ,
		-- `derivery_info`.`sender_email` as s_email ,
		`estate_tenant_information`.`mobile_number` as s_mobile ,
		

		`estate_information`.`region` as r_region ,
		`estate_information`.`district` as branch ,
		`estate_contract_information`.`tenant_id` as receiver_id ,
		`estate_tenant_information`.`customer_name` as fullname ,
		`estate_tenant_information`.`address` as address ,
		-- `receiver_register_info`.`email`,
		`estate_tenant_information`.`mobile_number` as mobile,

		`real_estate_transactions`.`billid`,`real_estate_transactions`.`status`,
		`real_estate_transactions`.`t_id` as  id ,`real_estate_transactions`.`paidamount`
		-- `$DB`.`office_name`,






		FROM `real_estate_transactions`

		LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
		LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
		LEFT JOIN `estate_tenant_information` ON `real_estate_transactions`.`tenant_id`=`estate_tenant_information`.`tenant_id`

		WHERE `estate_information`.`estate_type` LIKE '%$type%'

		AND `estate_information`.`region` = '$regioncode'
		AND `estate_information`.`district` = '$districtcode'
		AND `estate_tenant_information`.`operator` = '$emid'
		AND `real_estate_transactions`.`status` != 'Cancel'

		AND  DAY(date(`real_estate_transactions`.`transactiondate`)) >= '$day'AND MONTH(date(`real_estate_transactions`.`transactiondate`)) >= '$month'
		AND YEAR(date(`real_estate_transactions`.`transactiondate`)) >= '$year' 
		AND DAY(date(`real_estate_transactions`.`transactiondate`)) <= '$day2'AND MONTH(date(`real_estate_transactions`.`transactiondate`)) <= '$month2'
		AND YEAR(date(`real_estate_transactions`.`transactiondate`)) <= '$year2'


                         -- YEAR(`real_estate_transactions`.`transactiondate`) = '$year' AND MONTH(`real_estate_transactions`.`transactiondate`) = '$month' AND DAY(`real_estate_transactions`.`transactiondate`) = '$day'

                         ORDER BY `real_estate_transactions`.`billid`";




                         $query=$db2->query($sql);
                         $result = $query->result();
                         return $result;
                     }







                     public  function get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB){

                     	$regionfrom = $this->session->userdata('user_region');
                     	$db2 = $this->load->database('otherdb', TRUE);
                     	$id = $this->session->userdata('user_login_id');
                     	$info = $this->GetBasic($id);
                     	$o_region = $info->em_region;
                     	$o_branch = $info->em_branch;


                     	$sql = "SELECT 

                     	`sender_person_info`.`sender_date_created` as date_registered ,
                     	`sender_person_info`.`track_number`,
                     	`sender_person_info`.`sender_region` as s_region ,
                     	`sender_person_info`.`sender_branch` as s_district ,
                     	`sender_person_info`.`senderp_id` as sender_id ,
                     	`sender_person_info`.`sender_fullname` as s_fullname ,
                     	`sender_person_info`.`operator`,
                     	`sender_person_info`.`sender_status` as s_status ,
                     	`sender_person_info`.`sender_address` as s_address ,
                     	`sender_person_info`.`sender_email` as s_email ,
                     	`sender_person_info`.`sender_mobile` as s_mobile ,


                     	`receiver_register_info`.`receiver_region` as r_region ,
                     	`receiver_register_info`.`reciver_branch` as branch ,
                     	`receiver_register_info`.`receiver_id`,
                     	`receiver_register_info`.`receiver_fullname` as fullname ,
                     	`receiver_register_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`receiver_register_info`.`receiver_mobile` as mobile,

		`$DB`.`billid`,`$DB`.`status`,`$DB`.`t_id` as  id ,`$DB`.`paidamount`
		-- `$DB`.`office_name`,


		FROM `sender_person_info`

		INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
		INNER JOIN  `$DB`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`

		WHERE YEAR(`sender_person_info`.`sender_date_created`) = '$year' AND MONTH(`sender_person_info`.`sender_date_created`) = '$month' AND DAY(`sender_person_info`.`sender_date_created`) = '$day'
		AND `sender_person_info`.`sender_region` = '$o_region' 
		AND `sender_person_info`.`sender_branch` = '$o_branch'
		AND `$DB`.`serial` LIKE '%$type%'

		AND `$DB`.`status` != 'Cancel' AND `sender_person_info`.`operator` = '$emid' 
		ORDER BY `$DB`.`t_id` DESC ";
		
		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_details_per_date_by_emid_Sender_person22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;


		$sql = "SELECT 

		`sender_person_info`.`sender_date_created` as date_registered ,
		`sender_person_info`.`track_number`,
		`sender_person_info`.`sender_region` as s_region ,
		`sender_person_info`.`sender_branch` as s_district ,
		`sender_person_info`.`senderp_id` as sender_id ,
		`sender_person_info`.`sender_fullname` as s_fullname ,
		`sender_person_info`.`operator`,
		`sender_person_info`.`sender_status` as s_status ,
		`sender_person_info`.`sender_address` as s_address ,
		`sender_person_info`.`sender_email` as s_email ,
		`sender_person_info`.`sender_mobile` as s_mobile ,
		`sender_person_info`.`register_weght` as weight ,

		
		

		`receiver_register_info`.`receiver_region` as r_region ,
		`receiver_register_info`.`reciver_branch` as branch ,
		`receiver_register_info`.`receiver_id`,
		`receiver_register_info`.`receiver_fullname` as fullname ,
		`receiver_register_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`receiver_register_info`.`receiver_mobile` as mobile,

		`$DB`.`billid`,`$DB`.`status`,`$DB`.`t_id` as  id ,`$DB`.`paidamount`
		-- `$DB`.`office_name`,


		FROM `sender_person_info`

		INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
		INNER JOIN  `$DB`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`

		WHERE
		DAY(date(`sender_person_info`.`sender_date_created`)) >= '$day'AND MONTH(date(`sender_person_info`.`sender_date_created`)) >= '$month'
		AND YEAR(date(`sender_person_info`.`sender_date_created`)) >= '$year' 
		AND DAY(date(`sender_person_info`.`sender_date_created`)) <= '$day2'AND MONTH(date(`sender_person_info`.`sender_date_created`)) <= '$month2'
		AND YEAR(date(`sender_person_info`.`sender_date_created`)) <= '$year2'

			 -- YEAR(`sender_person_info`.`sender_date_created`) = '$year' AND MONTH(`sender_person_info`.`sender_date_created`) = '$month' AND DAY(`sender_person_info`.`sender_date_created`) = '$day'

			 AND `sender_person_info`.`sender_region` = '$o_region' 
			 AND `sender_person_info`.`sender_branch` = '$o_branch'
			 AND `$DB`.`serial` LIKE '%$type%'

			 AND `$DB`.`status` != 'Cancel' AND `sender_person_info`.`operator` = '$emid' 
			 ORDER BY `$DB`.`t_id` DESC ";

			 $query=$db2->query($sql);
			 $result = $query->result();
			 return $result;
			}



			public  function get_details_per_date_by_emid_Sender_person1($type,$year,$month,$day,$emid,$DB){

				$regionfrom = $this->session->userdata('user_region');
				$db2 = $this->load->database('otherdb', TRUE);
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$sql = "SELECT 

				`sender_person_info`.`sender_date_created` as date_registered ,
				`sender_person_info`.`track_number`,
				`sender_person_info`.`sender_region` as s_region ,
				`sender_person_info`.`sender_branch` as s_district ,
				`sender_person_info`.`senderp_id` as sender_id ,
				`sender_person_info`.`sender_fullname` as s_fullname ,
				`sender_person_info`.`operator`,
				`sender_person_info`.`sender_status` as s_status ,
				`sender_person_info`.`sender_address` as s_address ,
				`sender_person_info`.`sender_email` as s_email ,
				`sender_person_info`.`sender_mobile` as s_mobile ,


				`receiver_register_info`.`receiver_region` as r_region ,
				`receiver_register_info`.`reciver_branch` as branch ,
				`receiver_register_info`.`receiver_id`,
				`receiver_register_info`.`receiver_fullname` as fullname ,
				`receiver_register_info`.`r_address` as address ,
		-- `receiver_register_info`.`email`,
		`receiver_register_info`.`receiver_mobile` as mobile,

		`$DB`.`billid`,`$DB`.`status`,`$DB`.`t_id` as  id ,`$DB`.`paidamount`,`$DB`.`Barcode`
		


		FROM `sender_person_info`

		INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
		INNER JOIN  `$DB`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
		INNER JOIN  `event_management`  ON   `sender_person_info`.`track_number`   = `event_management`.`track_no`

		WHERE YEAR(`sender_person_info`.`sender_date_created`) = '$year' AND MONTH(`sender_person_info`.`sender_date_created`) = '$month' AND DAY(`sender_person_info`.`sender_date_created`) = '$day'
		AND `$DB`.`serial` LIKE '%$type%'

		AND `$DB`.`status` != 'Cancel' 
		AND `event_management`.`user` = '$emid' AND `event_management`.`status` = 'Received' 
		ORDER BY `$DB`.`t_id` DESC ";

			// `$DB`.`office_name`,
			//  AND `sender_person_info`.`sender_region` = '$o_region' 
			// AND `sender_person_info`.`sender_branch` = '$o_branch'
		
		$query=$db2->query($sql);
		$result = @$query->result();
		return $result;
	}


	public  function get_ems_per_date1($year,$month,$day,$emid){

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

	public  function get_ems_bill_per_date1($year,$month,$day,$emid){

		$regionfrom = $this->session->userdata('user_region');
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE YEAR(date_registered) = '$year' AND MONTH(date_registered) = '$month' AND DAY(date_registered) = '$day' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$emid'
			AND `transactions`.`status` = 'Bill' ORDER BY `transactions`.`id` DESC ";
		}else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE YEAR(date_registered) = '$year' AND MONTH(date_registered) = '$month' AND DAY(date_registered) = '$day'
			AND `transactions`.`status` = 'Bill'  ORDER BY `transactions`.`id` DESC ";
		}


		$query=$db2->query($sql);
		$result = $query->result();
		return $result;
	}

	public  function get_ems_per_date_by_emid($date,$emid){

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
		WHERE date(`sender_info`.`date_registered`) = '$date' 
		AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
		AND `transactions`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emid' ORDER BY `transactions`.`id` DESC ";
	}
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_ems_per_date_by_emidag($date,$emidag){

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
	WHERE date(`sender_info`.`date_registered`) = '$date' 

	AND `transactions`.`status` != 'Cancel' AND `sender_info`.`operator` = '$emidag' ORDER BY `transactions`.`id` DESC ";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_despatch_in_combine_ems_search($date,$month,$status){

	$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
	$o_region = $this->session->userdata('user_region');
	$o_branch = $this->session->userdata('user_branch');
	$emid = $this->session->userdata('user_login_id');
	$service_type = $this->session->userdata('service_type');

	$m = explode('-', $month);
	$day = @$m[0];
	$year = @$m[1];

	if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

		if (!empty($date)) {




			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
			FROM `despatch`
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_to` = '$o_region' AND `despatch`.`branch_to` = '$o_branch' 
			AND (`bags`.`type` = 'Combine' )";

		} else {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no`  ) AS `item_number`
			FROM `despatch` 
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE (MONTH(`despatch`.`datetime`) = '$day' AND YEAR(`despatch`.`datetime`) = '$year') AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_to` = '$o_region' AND `despatch`.`branch_to` = '$o_branch' 

			AND (`bags`.`type` = 'Combine' )";

		}

	}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

		if (!empty($date)) {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
			FROM `despatch`
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_to` = '$o_region' 
			AND (`bags`.`type` = 'Combine' )";

		} else {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no`  ) AS `item_number`
			FROM `despatch` 
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE (MONTH(`despatch`.`datetime`) = '$day' AND YEAR(`despatch`.`datetime`) = '$year') AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_to` = '$o_region' 

			AND (`bags`.`type` = 'Combine' )";

		}

	}else{


		if (!empty($date)) {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
			FROM `despatch`
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = '$status' 

			AND (`bags`.`type` = 'Combine' )";

		} else {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no`  ) AS `item_number`
			FROM `despatch` 
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE (MONTH(`despatch`.`datetime`) = '$day' AND YEAR(`despatch`.`datetime`) = '$year') AND `despatch`.`despatch_status` = '$status'  

			AND (`bags`.`type` = 'Combine' )";


		}


	}

	$query  = $db2->query($sql);
	$result = $query->result();
	return $result;         
}   


public function get_despatch_out_combine_ems_search($date,$month,$status){

	$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
	$o_region = $this->session->userdata('user_region');
	$o_branch = $this->session->userdata('user_branch');
	$emid = $this->session->userdata('user_login_id');
	$service_type = $this->session->userdata('service_type');

	$m = explode('-', $month);
	$day = @$m[0];
	$year = @$m[1];

	if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

		if (!empty($date)) {




			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
			FROM `despatch`
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_from` = '$o_region' AND `despatch`.`branch_from` = '$o_branch' 
			AND (`bags`.`type` = 'Combine' )";

		} else {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no`  ) AS `item_number`
			FROM `despatch` 
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE (MONTH(`despatch`.`datetime`) = '$day' AND YEAR(`despatch`.`datetime`) = '$year') AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_from` = '$o_region' AND `despatch`.`branch_from` = '$o_branch' 

			AND (`bags`.`type` = 'Combine' )";

		}

	}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

		if (!empty($date)) {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
			FROM `despatch`
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_from` = '$o_region' 
			AND (`bags`.`type` = 'Combine' )";

		} else {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no`  ) AS `item_number`
			FROM `despatch` 
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE (MONTH(`despatch`.`datetime`) = '$day' AND YEAR(`despatch`.`datetime`) = '$year') AND `despatch`.`despatch_status` = '$status' AND `despatch`.`region_from` = '$o_region' 

			AND (`bags`.`type` = 'Combine' )";

		}

	}else{


		if (!empty($date)) {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
			FROM `despatch`
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = '$status' 

			AND (`bags`.`type` = 'Combine' )";

		} else {

			$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
				WHERE `bags`.`despatch_no` = `despatch`.`desp_no`  ) AS `item_number`
			FROM `despatch` 
			INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
			WHERE (MONTH(`despatch`.`datetime`) = '$day' AND YEAR(`despatch`.`datetime`) = '$year') AND `despatch`.`despatch_status` = '$status'  

			AND (`bags`.`type` = 'Combine' )";


		}


	}

	$query  = $db2->query($sql);
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

	}else if($this->session->userdata('user_type') == 'RM'){

		$sql = "SELECT *
		FROM `despatch` 
		WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC";

	}else{

		$sql = "SELECT *
		FROM `despatch` WHERE   DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC";

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
		WHERE `despatch`.`region_to`  = '$o_region' AND `despatch`.`branch_to`  = '$o_branch' AND  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year'  ORDER BY `despatch`.`datetime` DESC";

	}else if($this->session->userdata('user_type') == 'RM'){

		$sql = "SELECT *
		FROM `despatch` 
		WHERE `despatch`.`region_to`  = '$o_region' AND `despatch`.`branch_to`  = '$o_branch' AND DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC";


	}else{

		$sql = "SELECT *
		FROM `despatch` WHERE  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC";

	}
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_despatch_way_in_per_date($year,$month,$day){

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

public  function get_despatch_in_delivery($year,$month,$day){

	$db2 = $this->load->database('otherdb', TRUE);
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;
	



	if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {



		$sql = "SELECT *
		FROM `despatch`
		WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year'  ORDER BY `despatch`.`datetime` DESC ";

		

	}else{

		$sql = "SELECT *
		FROM `despatch` WHERE  DAY(`despatch`.`datetime`) = '$day' AND  MONTH(`despatch`.`datetime`) = '$month' AND  YEAR(`despatch`.`datetime`) = '$year' ORDER BY `despatch`.`datetime`  DESC LIMIT 20";

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


public  function get_ems_back_list_Searchold($date,$month){
	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

				//$date = new DateTime($date, $tz_obj); AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL'
				//$date = $date->format('Y-m-d');

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		if(!empty($date)){
			if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){



				$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'   )
			AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND `transactions`.`district` = '$o_branch'  
			AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";
		}

	}elseif (!empty($month)){

		if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";
		}

				# code...
	}

	else{
		$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$today'   ORDER BY `sender_info`.`sender_id` DESC";

			
		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";
		}elseif (!empty($month)){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		else{
			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`sender_id` DESC";

			


		}

	}else{

		if(!empty($date)){



			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";


			// $sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			// FROM `sender_info`
			// LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			// -- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			// LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			// WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";


		}elseif (!empty($month)){
			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`date_registered` DESC";


		}
		else{

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.`serial` AS Barcode2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`date_registered` DESC";

			

		}

	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}



public  function get_ems_back_list_Search($date,$month){
	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

				//$date = new DateTime($date, $tz_obj); AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL'
				//$date = $date->format('Y-m-d');

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		if(!empty($date)){
			if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){



				$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL'
			AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'   )
			AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL'
			AND `transactions`.`district` = '$o_branch'  
			AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";
		}

	}elseif (!empty($month)){

		if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL'
			AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND `transactions`.`district` = '$o_branch' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";
		}

				# code...
	}

	else{
		$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$today'   ORDER BY `sender_info`.`sender_id` DESC";

			
		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";
		}elseif (!empty($month)){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		else{
			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`sender_id` DESC";

			


		}

	}else{

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";
		}elseif (!empty($month)){
			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`date_registered` DESC";


		}
		else{

			$sql = "SELECT `transactions`.`Barcode`,`receiver_info`.`r_region`,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` != 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`date_registered` DESC";

			

		}

	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_ems_back_list_international_Search($date,$month){
	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

				//$date = new DateTime($date, $tz_obj); AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'
				//$date = $date->format('Y-m-d');  country_name

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		if(!empty($date)){
			if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

				$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
				AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'   )
				AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";

			}else{

				$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND `transactions`.`district` = '$o_branch'  
			AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";
		}

	}elseif (!empty($month)){

		if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";
		}

				# code...
	}

	else{
		$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$today'   ORDER BY `sender_info`.`sender_id` DESC";

			
		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";
		}elseif (!empty($month)){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		else{
			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`sender_id` DESC";

			


		}

	}else{

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";
		}elseif (!empty($month)){
			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`date_registered` DESC";


		}
		else{

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`date_registered` DESC";

			

		}

	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_ems_back_list_international_Search2($date,$month){
	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

				//$date = new DateTime($date, $tz_obj); AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL'
				//$date = $date->format('Y-m-d');  country_name

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		if(!empty($date)){
			if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

				$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
				LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
				AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'   )
				AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";

			}else{

				$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
				FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND `transactions`.`district` = '$o_branch'  
			AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";
		}

	}elseif (!empty($month)){

		if($o_branch = 'GPO'|| $o_branch = 'Post Head Office'){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' 
			AND( `transactions`.`district` = '$o_branch'  OR  `transactions`.`district` = 'Post Head Office' OR  `transactions`.`district` = 'GPO'  )
			AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}else{

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";
		}

				# code...
	}

	else{
		$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$today'   ORDER BY `sender_info`.`sender_id` DESC";

			
		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";
		}elseif (!empty($month)){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		else{
			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`sender_id` DESC";

			


		}

	}else{

		if(!empty($date)){

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";
		}elseif (!empty($month)){
			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`date_registered` DESC";


		}
		else{

			$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			-- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			RIGHT  OUTER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`date_registered` DESC";

			

		}

	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_ems_back_list_Search1($date,$month){
	$regionfrom = $this->session->userdata('user_region');
	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$today = $today->format('Y-m-d');
	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	$m = explode('-', $month);

	$day = @$m[0];
	$year = @$m[1];

				//$date = new DateTime($date, $tz_obj);
				//$date = $date->format('Y-m-d');

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		if(!empty($date)){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'   ORDER BY `sender_info`.`sender_id` DESC";

		}elseif (!empty($month)){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

				# code...
		}

		else{
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$today'   ORDER BY `sender_info`.`sender_id` DESC";

			
		}



	}elseif($this->session->userdata('user_type') == 'RM'){

		if(!empty($date)){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";
		}elseif (!empty($month)){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

		}
		else{
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`sender_id` DESC";

			


		}

	}else{

		if(!empty($date)){

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";
		}elseif (!empty($month)){
			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`date_registered` DESC";


		}
		else{

			$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
			LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
			WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$today'  ORDER BY `sender_info`.`date_registered` DESC";

			

		}

	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}





public  function get_ems_back_list233(){
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

		$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

	}elseif($this->session->userdata('user_type') == 'RM'){

		$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

	}else{

		$sql = "SELECT `transactions`.`Barcode`,`sender_info`.`serial` AS Barcode2,`country_zone`.`country_name` AS r_region2,`sender_info`.*,`transactions`.`id`,`transactions`.`office_name`,`transactions`.`bag_status`,`transactions`.`isBagNo`,`receiver_info`.`fullname`,`receiver_info`.`r_region`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";

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
		WHERE `transactions`.`status` != 'OldPaid'  AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND `transactions`.`district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

	}elseif($this->session->userdata('user_type') == 'RM'){

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `transactions`.`region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`sender_id` DESC";

	}else{

		$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date'  ORDER BY `sender_info`.`date_registered` DESC";

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
		WHERE `transactions`.`status` = 'Paid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND  `transactions`.`PaymentFor` = 'EMS'  ORDER BY `sender_info`.`sender_id` DESC";

	}elseif($this->session->userdata('user_type') == 'RM'){

		$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` = 'Paid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' AND  `transactions`.`PaymentFor` = 'EMS'  ORDER BY `sender_info`.`sender_id` DESC";

	}else{

		$sql = "SELECT `sender_info`.`s_fullname`,`s_region`,`s_district`,`date_registered`,`track_number`,`receiver_info`.`r_region`,`branch`,`transactions`.`id`,`office_name`,`bag_status`
		FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`status` = 'Paid' AND  `transactions`.`office_name` = 'Back'  AND `transactions`.`bag_status`= 'isNotBag' AND date(`sender_info`.`date_registered`) = '$date' AND  `transactions`.`PaymentFor` = 'EMS' ORDER BY `sender_info`.`date_registered` DESC";

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
	$STARTdate1 = $today->format('2021-05-23');
	$STARTdate = date('2021-05-23');

	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic' 
		AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '')
		ORDER BY `bags`.`date_created` DESC";
	}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

		$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region'  AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic' 
		AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '')
		ORDER BY `bags`.`date_created` DESC";

	}
	else{
		$sql = "SELECT * FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic'
		AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') ORDER BY `bags`.`bag_id` DESC";
	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_ems_bags_listByUser($userid){
	$regionfrom = $this->session->userdata('user_region');

	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$date = $today->format('Y-m-d');
	$STARTdate1 = $today->format('2021-05-23');
	$STARTdate = date('2021-05-23');

	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	$sql = "SELECT * FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic'
	AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') 
	AND `bags`.`bag_created_by` = '$userid' ";

	$sql .= "ORDER BY `bags`.`bag_id` DESC";

			//echo $sql;die();

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public function get_ems_bags_list_by_despatch($despno){

	$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
	$o_region = $this->session->userdata('user_region');
	$o_branch = $this->session->userdata('user_branch');
	$emid = $this->session->userdata('user_login_id');

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$date = $today->format('Y-m-d');

	$service_type = $this->session->userdata('service_type');

	if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`bag_region` = '$o_region' AND `bags`.`bag_branch` = '$o_branch' AND `bags`.`despatch_no` = '$despno' ";

	}elseif($this->session->userdata('user_type') == "SUPERVISOR"){

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`bag_region` = '$o_region' AND `bags`.`bag_branch` = '$o_branch' AND `bags`.`despatch_no` = '$despno'";

	}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`bag_region` = '$o_region' AND `bags`.`despatch_no` = '$despno' ";

	}else{

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`despatch_no` = '$despno'";

	}

	$query  = $db2->query($sql);
	$result = $query->result();
	return $result;         
}

public function get_ems_bags_list_by_despatch_out($despno){

	$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
	$o_region = $this->session->userdata('user_region');
	$o_branch = $this->session->userdata('user_branch');
	$emid = $this->session->userdata('user_login_id');

	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$date = $today->format('Y-m-d');

	$service_type = $this->session->userdata('service_type');

	if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`despatch_no` = '$despno' ";

	}elseif($this->session->userdata('user_type') == "SUPERVISOR"){

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`despatch_no` = '$despno'";

	}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`bag_region_from` = '$o_region' AND `bags`.`despatch_no` = '$despno' ";

	}else{

		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE  `bags`.`despatch_no` = '$despno'";

	}

	$query  = $db2->query($sql);
	$result = $query->result();
	return $result;         
}

public  function get_ems_combine_bags_list(){
	$regionfrom = $this->session->userdata('user_region');

	$db2 = $this->load->database('otherdb', TRUE);
	$tz = 'Africa/Nairobi';
	$tz_obj = new DateTimeZone($tz);
	$today = new DateTime("now", $tz_obj);
	$date = $today->format('Y-m-d');
	$STARTdate1 = $today->format('2021-05-23');
	$STARTdate = date('2021-05-23');

	$id = $this->session->userdata('user_login_id');
	$info = $this->GetBasic($id);
	$o_region = $info->em_region;
	$o_branch = $info->em_branch;

	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number`
		FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic' 
		AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '')
		ORDER BY `bags`.`date_created` DESC";
	}else{
		$sql = "SELECT *, (SELECT COUNT(*) FROM `transactions` 
			WHERE `bags`.`bag_number` = `transactions`.`isBagNo`) AS `item_number` 
		FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND `ems_category` = 'Domestic'
		AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') ORDER BY `bags`.`bag_id` DESC";
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
		$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch'  ORDER BY `bags`.`date_created` DESC";
	}elseif($this->session->userdata('user_type') == 'RM'){
		$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bags_status` = 'notDespatch'  ORDER BY `bags`.`date_created` DESC";
	}else{
		$sql = "SELECT * FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' ORDER BY `bags`.`date_created` DESC ";
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
		$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'isDespatch' ORDER BY `bags`.`bag_id` DESC";
	}elseif($this->session->userdata('user_type') == 'RM'){
		$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bags_status` = 'isDespatch' ORDER BY `bags`.`bag_id` DESC";
	}else{
		$sql = "SELECT * FROM `bags` WHERE  `bags`.`bags_status` = 'isDespatch' ORDER BY `bags`.`bag_id` DESC";
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

	//Box customer information update
public function update_customer_box_info($dataBox,$boxid){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('box_id',$boxid);
	$db2->update('box_numbers',$dataBox);
}

public function update_customer_address_info($dataAddress,$custaddid){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('add_id',$custaddid);
	$db2->update('customer_address',$dataAddress);
}

public function update_customer_details_info($dataCust,$custid){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('details_cust_id',$custid);
	$db2->update('customer_details',$dataCust);
}



public function update_bulk_numbers($box,$id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('serial',$id);
	$db2->update('bulk_registration',$box);
}


public function update_assign_derivery($save,$last_id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('item_id',$last_id);
	$db2->update('assign_derivery',$save);
}
public function save_ems_billing_company_details_update($data,$comid){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('com_id',$comid);
	$db2->update('ems_bill_companies',$data);
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
public function update_despatch_list_byId($id,$update){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('desp_id',$id);
	$db2->update('despatch',$update);
}

public function get_ems_bags_desp_list($desp_id){

	$date = date('Y-m-d');
	$o_region = $this->session->userdata('user_region');
	$o_branch = $this->session->userdata('user_branch');



	$db2 = $this->load->database('otherdb', TRUE);
	$sql = "SELECT * FROM   `bags` 
	INNER JOIN `despatch` ON `bags`.`despatch_no` = `despatch`.`desp_no`
	WHERE `despatch`.`desp_id`='$desp_id' ";

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public function update_bag_status($despatch_no,$bagno,$update1){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('despatch_no',$despatch_no);
	$db2->where('bag_number',$bagno);
	$db2->update('bags',$update1);
}


public function update_bags_list1($despatch_no,$update1){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('despatch_no',$despatch_no);
	$db2->update('bags',$update1);
}


public function update_box_number($boxupdate,$box_id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('box_id',$box_id);
	$db2->update('box_numbers',$boxupdate);
}

public function update_box_number_details($boxupdate,$id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('reff_cust_id',$id);
	$db2->update('box_numbers',$boxupdate);
}

public function update_box_number_details00($boxupdate,$id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('customer_id',$id);
	$db2->update('box_customer_details',$boxupdate);
}

public function update_box_payments_details($boxupdate,$id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('CustomerID',$id);
	$db2->update('box_payment_details',$boxupdate);
}

public function save_box_number($data){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->insert('box_numbers',$data);
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

public function update_mct_transaction($data,$serial){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('serial', $serial);
	$db2->update('transactions',$data);
}

public function save_transactions($data){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->insert('transactions',$data);

	$insert_id = $db2->insert_id();
	return  $insert_id;
}
public function save_invoice($datas){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->insert('invoice',$datas);
}
public function save_delivery_info($data){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->insert('assign_derivery',$data);
}
public function update_delivery_info($data,$id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->where('item_id', $id);
	$db2->update('assign_derivery',$data);
}

public function delete_delivery_info($id){
	$db2 = $this->load->database('otherdb', TRUE);
	$db2->delete('assign_derivery',array('item_id'=> $id));
}

public  function check_reassign($item_id,$operator){

	$db2 = $this->load->database('otherdb', TRUE);

	$sql = "SELECT * FROM `assign_derivery` WHERE `item_id` = '$item_id' AND `em_id` = '$operator' LIMIT 1";

	$query=$db2->query($sql);
	$result = $query->row();
	return $result;
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


public  function delete_commission_agency_info($codeid){
	$db2 = $this->load->database('otherdb', TRUE);
		//$sql = "SELECT `commission_agency`.* FROM `commission_agency`";
	$sql = "DELETE FROM commission_agency WHERE com_id='$codeid'";
	$query=$db2->query($sql);
		//$result = $query->result();
	return $query;
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

		// $sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
		// `customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
		// LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
		// LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
		// LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
		// LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
		// WHERE `customer_details`.`details_cust_id` ='$cust_id'";

	$sql = "SELECT `customer_details`.*,`box_tariff_price`.*,
	`customer_address`.*,`box_numbers`.*,`transactions`.* FROM `customer_details`
	LEFT JOIN `box_tariff_price` ON `box_tariff_price`.`btp_id`=`customer_details`.`cust_boxtype`
	LEFT JOIN `customer_address` ON `customer_address`.`add_cust_id`=`customer_details`.`details_cust_id`
	LEFT JOIN `box_numbers` ON `box_numbers`.`reff_cust_id`=`customer_details`.`details_cust_id`
	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
	WHERE `transactions`.`CustomerID` ='$cust_id'  AND  `transactions`.`PaymentFor` ='POSTSBOX'";

	$query=$db2->query($sql);
	$result = $query->row();
	return $result;
}


public  function get_ems_report_Document_Day($year,$month,$day,$cate,$pay){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* 
		FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
		WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')  AND `sender_info`.`ems_type` = '$cate' AND YEAR(date(`sender_info`.`date_registered`)) = '$year' AND MONTH(date(`sender_info`.`date_registered`)) = '$month' AND DAY(date(`sender_info`.`date_registered`)) = '$day' AND  `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$region'  GROUP BY `sender_info`.`s_district`";

	}else {

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* 
		FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
		WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')  AND `sender_info`.`ems_type` = '$cate' AND YEAR(date(`sender_info`.`date_registered`)) = '$year' AND MONTH(date(`sender_info`.`date_registered`)) = '$month' AND DAY(date(`sender_info`.`date_registered`)) = '$day' AND  `sender_info`.`s_pay_type` = '$pay'  GROUP BY `sender_info`.`s_region`";

	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
} 


public  function get_ems_report_Document_Days($year,$month,$day,$cate){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* 
		FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
		WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')  AND `sender_info`.`ems_type` = '$cate' AND YEAR(date(`sender_info`.`date_registered`)) = '$year' AND MONTH(date(`sender_info`.`date_registered`)) = '$month' AND DAY(date(`sender_info`.`date_registered`)) = '$day' AND `sender_info`.`s_region` = '$region'  GROUP BY `sender_info`.`s_district`";

	}else {

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* 
		FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
		WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill')  AND `sender_info`.`ems_type` = '$cate' AND YEAR(date(`sender_info`.`date_registered`)) = '$year' AND MONTH(date(`sender_info`.`date_registered`)) = '$month' AND DAY(date(`sender_info`.`date_registered`)) = '$day' GROUP BY `sender_info`.`s_region`";

	}

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
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {
		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$day'  AND `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$region' GROUP BY `sender_info`.`s_district`";
	}else{
		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$day'  AND `sender_info`.`s_pay_type` = '$pay' GROUP BY `sender_info`.`s_region`";
	}
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}
public  function get_ems_report_Document_Months($year,$day,$cate){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {
		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$day'  AND `sender_info`.`s_region` = '$region' GROUP BY `sender_info`.`s_district`";
	}else{
		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND MONTH(`sender_info`.`date_registered`) = '$day'  GROUP BY `sender_info`.`s_region`";
	}
	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}
public  function get_ems_report_Document_MonthBtn($year,$monthf,$months,$cate,$pay){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND MONTH(`sender_info`.`date_registered`) >= '$monthf' AND MONTH(`sender_info`.`date_registered`) <= '$months' AND YEAR(`sender_info`.`date_registered`) <= '$year'  AND  `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$region' GROUP BY `sender_info`.`s_district`";

	}else{

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND MONTH(`sender_info`.`date_registered`) >= '$monthf' AND MONTH(`sender_info`.`date_registered`) <= '$months' AND YEAR(`sender_info`.`date_registered`) <= '$year'  AND  `sender_info`.`s_pay_type` = '$pay'  GROUP BY `sender_info`.`s_region`";
	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}

public  function get_ems_report_Document_MonthBtns($year,$monthf,$months,$cate){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND MONTH(`sender_info`.`date_registered`) >= '$monthf' AND MONTH(`sender_info`.`date_registered`) <= '$months' AND YEAR(`sender_info`.`date_registered`) <= '$year' AND `sender_info`.`s_region` = '$region' GROUP BY `sender_info`.`s_district`";

	}else{

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND MONTH(`sender_info`.`date_registered`) >= '$monthf' AND MONTH(`sender_info`.`date_registered`) <= '$months' AND YEAR(`sender_info`.`date_registered`) <= '$year'   GROUP BY `sender_info`.`s_region`";
	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}





public  function get_ems_report_Document_DaysBtns($year,$month,$day,$cate,$year1,$month1,$day1){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' 
		AND DAY(date(`sender_info`.`date_registered`)) >= '$day'AND MONTH(date(`sender_info`.`date_registered`)) >= '$month'
		AND YEAR(date(`sender_info`.`date_registered`)) >= '$year' 
		AND DAY(date(`sender_info`.`date_registered`)) <= '$day1'AND MONTH(date(`sender_info`.`date_registered`)) <= '$month1'
		AND YEAR(date(`sender_info`.`date_registered`)) <= '$year1'  
		AND `sender_info`.`s_region` = '$region'
		GROUP BY `sender_info`.`s_district`";

	}else{

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate'
		AND DAY(date(`sender_info`.`date_registered`)) >= '$day'AND MONTH(date(`sender_info`.`date_registered`)) >= '$month'
		AND YEAR(date(`sender_info`.`date_registered`)) >= '$year' 
		AND DAY(date(`sender_info`.`date_registered`)) <= '$day1'AND MONTH(date(`sender_info`.`date_registered`)) <= '$month1'
		AND YEAR(date(`sender_info`.`date_registered`)) <= '$year1'    
		GROUP BY `sender_info`.`s_region`";
	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_ems_report_Document_DaysBtns1($Dayfirst,$Daysecond,$cate){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' 
		AND date(`sender_info`.`date_registered`) >= '$Dayfirst'
		AND date(`sender_info`.`date_registered`) <= '$Daysecond' 
		AND `sender_info`.`s_region` = '$region'
		GROUP BY `sender_info`.`s_district`";

	}else{

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate'
		AND date(`sender_info`.`date_registered`) >= '$Dayfirst'
		AND date(`sender_info`.`date_registered`) <= '$Daysecond'    
		GROUP BY `sender_info`.`s_region`";
	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}




public  function get_ems_report_Document_Year($year,$cate,$pay){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND  `sender_info`.`s_pay_type` = '$pay' AND `sender_info`.`s_region` = '$region' GROUP BY `sender_info`.`s_district`";
	}else{

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' AND  `sender_info`.`s_pay_type` = '$pay' GROUP BY `sender_info`.`s_region`";
	}

	$query=$db2->query($sql);
	$result = $query->result();
	return $result;
}


public  function get_ems_report_Document_Years($year,$cate){

	$db2 = $this->load->database('otherdb', TRUE);
	$region = $this->session->userdata('user_region');
	if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

		$sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year'AND `sender_info`.`s_region` = '$region' GROUP BY `sender_info`.`s_district`";
	}else{

		$sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`ems_type`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND (`transactions`.`status` = 'Paid' OR `transactions`.`status` = 'Bill') AND `sender_info`.`ems_type` = '$cate' AND YEAR(`sender_info`.`date_registered`) = '$year' GROUP BY `sender_info`.`s_region`";
	}

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
	AND `tariff_weight` >= '$weight'  ORDER BY `price_id` LIMIT 1";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}

public function special_ems_cus_price($weight,$branch){
	  //$branch = $this->session->userdata('user_branch');
	$db2 = $this->load->database('otherdb', TRUE);
	$sql    = "SELECT * FROM `customer_ems_special_tariff_price` WHERE `branch`='$branch' 
	AND `tariff_weight` >= '$weight'  ORDER BY `price_id` LIMIT 1";
	$query  = $db2->query($sql);
	$result = $query->row();
	return $result;
}

public function get_senderinfo_senderID($senderid){

	$db2 = $this->load->database('otherdb', TRUE);
    //$sql    = "SELECT * FROM `sender_info` WHERE `track_number`='$trackno'";
	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
	FROM `sender_info`
	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
               -- LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
               WHERE  `transactions`.`CustomerID` = '$senderid'

               ";

               $query  = $db2->query($sql);
               $result = $query->row();
               return $result;
           }

           public function ems_catPriceWeight10($emsCat,$tranWeight){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `ems_tariff_price` WHERE `cat_id`='$emsCat' AND `tariff_weight` >= '$tranWeight' LIMIT 1";

           	$query  = $db2->query($sql);
           	$resultTarrif = $query->row();


           	if($tranWeight > 10){

           		$weight10    = 10;

           		$resData['vat']       = isset($resultTarrif->vat);
           		$resData['emsprice']     = isset($resultTarrif->tariff_price);

           		$totalprice10 = $resData['vat']  + $resData['emsprice'];

           		$diff   =  $tranWeight - $weight10;

           		if ($diff <= 0.5) {

           			if ($emsCat == 1) {
           				$resData['totalPrice'] = $totalprice10 + 2300;
           			} else {
           				$resData['totalPrice'] = $totalprice10 + 3500;
           			}

           		} else {

           			$whole   = floor($diff);
           			$decimal = fmod($diff,1);

           			if ($decimal == 0) {

           				if ($emsCat == 1) {
           					$resData['totalPrice'] = $totalprice10 + ($whole*1000/500)*2300;
           				} else {
           					$resData['totalPrice'] = $totalprice10 + ($whole*1000/500)*3500;
           				}

           			} else {

           				if ($decimal <= 0.5) {

           					if ($emsCat == 1) {
           						$resData['totalPrice'] = $totalprice10 + ($whole*1000/500)*2300 + 2300;
           					} else {
           						$resData['totalPrice'] = $totalprice10 + ($whole*1000/500)*3500 + 3500;
           					}

           				} else {

           					if ($emsCat == 1) {
           						$resData['totalPrice'] = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
           					} else {
           						$resData['totalPrice'] = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
           					}
           				}

           			}
           		}

	 //update
	//   $resData['vat']       = $resData['totalPrice'] * 0.18;
    //  $resData['emsprice']     = $resData['totalPrice'];
	//  $resData['totalPrice'] = $resData['emsprice'] + $resData['vat'];

           	}else{
           		$resData['vat'] = $resultTarrif->vat;
           		$resData['emsprice'] = $resultTarrif->tariff_price;
           		$resData['totalPrice'] = $resData['vat'] + $resData['emsprice'];
           	}

           	return $resData;
           }


           public function ems_cat_price10($emsCat,$weight10){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `ems_tariff_price` WHERE `cat_id`='$emsCat' AND `tariff_weight` >= '$weight10' LIMIT 1";
           	$query  = $db2->query($sql);
           	$result = $query->row();
           	return $result;
           }

           public function check_barcode($barcode){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `transactions` WHERE `Barcode`='$barcode'";
           	$query  = $db2->query($sql);
           	$result = $query->row_array();
           	return $result;
           }

           public function check_mails_barcode($barcode){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `register_transactions` WHERE `Barcode`='$barcode'";

           	$query  = $db2->query($sql);
           	$result = $query->row_array();
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
           public function getTrackNo1($sid){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `sender_person_info` WHERE `senderp_id`='$sid'";
           	$query  = $db2->query($sql);
           	$result = $query->row();
           	return $result;
           }
           public function get_customer_infos($I){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `bill_credit_customer` WHERE `credit_id`='$I'";
           	$query  = $db2->query($sql);
           	$result = $query->row();
           	return $result;
           }

           public function get_customer_infos1($I){
           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `bill_credit_customer` WHERE `acc_no`='$I'";
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

           public function delete_zone($zone_id){

           	$db2 = $this->load->database('otherdb', TRUE);
           	$db2->delete('zones',array('zone_id' => $zone_id ));

           }

           public function delete_zoneregionID($zone_id){

           	$db2 = $this->load->database('otherdb', TRUE);
           	$db2->delete('zone_region',array('zone_id' => $zone_id ));

           }

           public function get_zone(){
           	$id = $this->session->userdata('user_login_id');
           	$info = $this->employee_model->GetBasic($id);
           	$o_region = $info->em_region;
           	$o_branch = $info->em_branch;

           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql    = "SELECT * FROM `zones` WHERE `zone_region` = '$o_region' AND `zone_branch` = '$o_branch'";
           	$query  = $db2->query($sql);
           	$result = $query->result();
           	return $result;
           }

           public function check_zone_regionlist(){

           	$db2 = $this->load->database('otherdb', TRUE);
           	$sql = "SELECT `zone_region`.*, `zones`.*
           	FROM `zone_region`
           	LEFT JOIN `zones` ON `zone_region`.`zone_id`=`zones`.`zone_id`
          -- WHERE `zones`.`zone_id` !=''
          -- GROUP BY `zones`.`zone_id` ";
          $query  = $db2->query($sql);
          $result = $query->result();
          return $result;
      }

      public function check_zone_employlist($emid){

      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql = "SELECT `zone_employee`.*, `zones`.*
      	FROM `zone_employee`
      	LEFT JOIN `zones` ON `zone_employee`.`zone_id`=`zones`.`zone_id`
      	WHERE `zone_employee`.`emid` ='$emid'
      	-- GROUP BY `zones`.`zone_id` ";
      	$query  = $db2->query($sql);
      	$result = $query->result();
      	return $result;
      }



      public function GetEmployeeAssignedByDate($region_id){

      	$sql    = "SELECT * FROM `em_region` WHERE `region_name`='$region_id'";
      	$query  = $this->db->query($sql);
      	$result = $query->row();
      	$id = $result->region_id;

      	$this->db->where('region_id',$id);
      	$this->db->order_by('district_name');
      	$query = $this->db->get('em_district');
      	$output ='<option value="">--Select District--</option>';
      	foreach ($query->result() as $row) {
      		$output .='<option value="'.$row->district_name.'">'.$row->district_name.'</option>';
      	}
      	return $output;
      }

      public function get_counters_byId($id){

      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql    = "SELECT * FROM `counters` WHERE `counter_id` = '$id'";
      	$query  = $db2->query($sql);
      	$result = $query->row();
      	return $result;
      }
      public function get_zone_byId($zone_id){

      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql    = "SELECT * FROM `zones` WHERE `zone_id` = '$zone_id'";
      	$query  = $db2->query($sql);
      	$result = $query->row();
      	return $result;
      }

      public function get_region_byZoneId($zone_id){

      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql    = "SELECT * FROM `zone_region` WHERE `zone_id` = '$zone_id'";
      	$query  = $db2->query($sql);
      	$result = $query->result();
      	return $result;
      }

      public function get_bag_number($id){
      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql    = "SELECT * FROM `bags` WHERE `despatch_no`='$id'";
      	$query  = $db2->query($sql);
      	$result = $query->result();
      	return $result;
      }

      public function get_bag_itemlist($bag_number){
      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql    = "SELECT * FROM `transactions` WHERE `isBagNo`='$bag_number'";
      	$query  = $db2->query($sql);
      	$result = $query->result();
      	return $result;
      }

      public function get_bag_by_id($id){
      	$db2 = $this->load->database('otherdb', TRUE);
      	$sql    = "SELECT * FROM `bags` WHERE `bag_id`='$id'";
      	$query  = $db2->query($sql);
      	$result = $query->row();
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

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

      	}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
      		$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
      		FROM `sender_info` 
      		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' ";
      	}else{

      		$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
      		FROM `sender_info` 
      		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date'";
      	}

      	$query  = $db2->query($sql);
      	$result = $query->row();
      	return $result;
      }

      public function get_ems_bill_sum(){
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

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$id'";

      	}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
      		$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
      		FROM `sender_info` 
      		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' ";
      	}else{

      		$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
      		FROM `sender_info` 
      		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'EMS_LOANBOARD') AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date'";
      	}

      	$query  = $db2->query($sql);
      	$result = $query->row();
      	return $result;
      }

      public function get_ems_sum_sent(){
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

      		$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount`,COUNT(`transactions`.`paidamount`) AS `number` 
      		FROM `sender_info` 
      		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 

      		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";

      	}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
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


      public function get_ems_sum22(){
      	$id = $this->session->userdata('user_login_id');
      	$info = $this->employee_model->GetBasic($id);
      	$o_region = $info->em_region;
      	$o_branch = $info->em_branch;
      	$db2 = $this->load->database('otherdb', TRUE);
      	$tz = 'Africa/Nairobi';
      	$tz_obj = new DateTimeZone($tz);
      	$today = new DateTime("now", $tz_obj);
		$date = date('Y-m-d');//$today->format('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			
			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' ";
		}else{

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 

			LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date'";
		}

		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}



	public function get_ems_sum2(){
		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
		$o_region = $info->em_region;
		$o_branch = $info->em_branch;
		$db2 = $this->load->database('otherdb', TRUE);
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = date('Y-m-d');//$today->format('Y-m-d');

		if ( $this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			
			LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id'";

		}elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){
			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 
			
			LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region' ";
		}else{

			$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
			FROM `sender_info` 

			LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE (`transactions`.`PaymentFor` = 'EMS' OR `transactions`.`PaymentFor` = 'LOAN BOARD') AND `transactions`.`status` = 'Paid' AND date(`sender_info`.`date_registered`) = '$date'";
		}

		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}


	/*public  function get_ems_sumACC($region,$date,$date2,$month,$month2,$year4){

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
}*/


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


public  function get_ems_bill_sumACC($region,$date,$date2,$month,$month2,$year4){

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

				$day1 = @$month4[0];   //'status'=>'Bill',

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
							INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month || $month2) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' OR  MONTH(`sender_info`.`date_registered`) >= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";
							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$o_region'  AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date'))";
							}
						}

					}
				}if ($this->session->userdata('user_type') == 'EMPLOYEE' ) {
					
					if (!empty($date) && !empty($date2)) {

						$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
						FROM `sender_info` 
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`operator` = '$emid' AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
							INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `sender_info`.`operator` = '$emid'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month || $month2) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `sender_info`.`operator` = '$emid' AND (MONTH(`sender_info`.`date_registered`) >= '$day' OR  MONTH(`sender_info`.`date_registered`) >= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";
							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND `sender_info`.`operator` = '$emid'  AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date'))";
							}
						}

					}
				}else{

					if (!empty($date) && !empty($date2)) {

						$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
						FROM `sender_info` 
						INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region'";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
							INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill'   AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND YEAR(`sender_info`.`date_registered`) = '$year') AND `sender_info`.`s_region` = '$region'";

							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Bill' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') ) AND `sender_info`.`s_region` = '$region'";
							}
						}
					}


					$query=$db2->query($sql);
					$result = $query->row();
					return $result;
				}
			}



			public  function get_ems_sumAdmin($branch,$date,$month,$type,$empcode,$date2,$month2,$year4){

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
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
							INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'   AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";

						} else {

							if ($month) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND YEAR(`sender_info`.`date_registered`) = '$year') AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";

							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
								INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') ) AND `sender_info`.`s_district` = '$branch' AND `sender_info`.`operator` = '$empcode' AND( `transactions`.`office_name` = 'Back' OR `transactions`.`office_name` = 'Received')";
							}
						}
					}


					$query=$db2->query($sql);
					$result = $query->row();
					return $result;
				}
			}







			public  function get_ems_sumACC2($region,$date,$date2,$month,$month2,$year4){

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


			public  function get_ems_sumACCs($region,$date,$date2,$month,$month2,$year4){

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

				$d1date = date('d',strtotime($dates));
				$m1date = date('m',strtotime($dates));
				$y1date = date('Y',strtotime($dates));

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
						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month || $month2) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' OR  MONTH(`sender_info`.`date_registered`) >= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";
							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date'))";
							}
						}

					}
				}else{

					if (!empty($date) && !empty($date2)) {

						$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
						FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region'";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'   AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND YEAR(`sender_info`.`date_registered`) = '$year') AND `sender_info`.`s_region` = '$region'";

							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') ) AND `sender_info`.`s_region` = '$region'";
							}
						}
					}


					$query=$db2->query($sql);
					$result = $query->row();
					return $result;
				}
			}



			public  function get_ems_sumACCs02($region,$date,$date2,$month,$month2,$year4){

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

				$d1date = date('d',strtotime($dates));
				$m1date = date('m',strtotime($dates));
				$y1date = date('Y',strtotime($dates));

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
						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2')";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month || $month2) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND (MONTH(`sender_info`.`date_registered`) >= '$day' OR  MONTH(`sender_info`.`date_registered`) >= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";
							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') OR (DAY(`sender_info`.`date_registered`) = '$d2date' AND MONTH(`sender_info`.`date_registered`) = '$m2date' AND YEAR(`sender_info`.`date_registered`) = '$y2date'))";
							}
						}

					}
				}else{

					if (!empty($date) && !empty($date2)) {

						$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
						FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'  AND  (date(`sender_info`.`date_registered`) >= '$date' AND date(`sender_info`.`date_registered`) <= '$date2') AND `sender_info`.`s_region` = '$region'";

					}else{

						if ($month && $month2) {

							$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
							FROM `sender_info` 
							INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid'   AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND  MONTH(`sender_info`.`date_registered`) <= '$day1') AND YEAR(`sender_info`.`date_registered`) = '$year'";

						} else {

							if ($month) {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND (MONTH(`sender_info`.`date_registered`) >= '$day' AND YEAR(`sender_info`.`date_registered`) = '$year') AND `sender_info`.`s_region` = '$region'";

							} else {

								$sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
								FROM `sender_info` 
								INNER JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial` WHERE `transactions`.`PaymentFor` = 'EMS' AND `transactions`.`status` = 'Paid' AND ((DAY(`sender_info`.`date_registered`) = '$d1date' AND MONTH(`sender_info`.`date_registered`) = '$m1date' AND YEAR(`sender_info`.`date_registered`) = '$y1date') ) AND `sender_info`.`s_region` = '$region'";
							}
						}
					}


					$query=$db2->query($sql);
					$result = $query->row();
					return $result;
				}
			}


			public function get_ems_sum12($year,$month,$day){

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



			public function get_ems_sum1($date){

				$db2 = $this->load->database('otherdb', TRUE);
				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$date = $today->format('Y-m-d');

				$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`status` = 'Paid'";

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

			public function get_qrcode_item2($code){
				$db2 = $this->load->database('otherdb', TRUE);
				$sql    = "SELECT `sender_info`.*,`transactions`.*  FROM `sender_info`
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`Barcode` = '$code'";
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


			public function despatched_bags_item_list($bagno){

				$db2 = $this->load->database('otherdb', TRUE);
				$sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
				LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
				LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
				WHERE `transactions`.`isBagNo`='$bagno' ";

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

			public function take_bags_desp_not_received_list($type,$despno){
				$db2 = $this->load->database('otherdb', TRUE);
				$sql = "SELECT * FROM `bags` WHERE `bags_status` ='isReceived' && `despatch_no`='$despno' && `service_type` = '$type' && `bag_isopen` = 0";
				$query  = $db2->query($sql);
				$result = $query->result();
				return $result;
			}


			public function take_bags_desp_listtwo2($type,$despno){

				$db2 = $this->load->database('otherdb', TRUE);
		//$sql = "SELECT * FROM `bags` WHERE `despatch_no`='$despno' && `service_type` = '$type'";
				$sql="SELECT * FROM `bags` 
				INNER JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no` 
				where `bags`.`despatch_no`='$despno'";
				$query  = $db2->query($sql);
				$result = $query->row();
				return $result;
			}

			public function take_bags_desp_listtwo($type,$despno){

				$db2 = $this->load->database('otherdb', TRUE);
		//$sql = "SELECT * FROM `bags` WHERE `despatch_no`='$despno' && `service_type` = '$type'";
				$sql="SELECT * FROM `bags` 
				INNER JOIN `despatch` ON `despatch`.`desp_no` = `bags`.`despatch_no` 
				WHERE `bags`.`despatch_no`='$despno' LIMIT 1";
				$query  = $db2->query($sql);
				$result = $query->row();
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

				}else if($this->session->userdata('user_type') == 'RM'){

					$sql = "SELECT *
					FROM `despatch`
					WHERE `despatch`.`region_from`  = '$o_region'  AND  date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'Domestic' ORDER BY `despatch`.`datetime` DESC";

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

				}else if($this->session->userdata('user_type') == 'RM'){

					$sql = "SELECT `despatch`.*
					FROM `despatch` WHERE region_to  = '$o_region'  AND date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'Domestic'
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

			public function get_combine_despatch_in_ems_list(){

				$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
				$o_region = $this->session->userdata('user_region');
				$o_branch = $this->session->userdata('user_branch');
				$emid = $this->session->userdata('user_login_id');

				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$date = $today->format('Y-m-d');

				if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

					$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
						WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
					FROM `despatch`
					INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
					WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = 'Sent' AND `despatch`.`region_to` = '$o_region' AND `despatch`.`branch_to` = '$o_branch' 
					AND (`bags`.`type` = 'Combine' )
					GROUP BY `despatch`.`desp_no`";




				}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

					$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
						WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
					FROM `despatch`
					INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
					WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = 'Sent' AND `despatch`.`region_to` = '$o_region' 
					AND (`bags`.`type` = 'Combine' )
					GROUP BY `despatch`.`desp_no`";



				}else{

					$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
						WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
					FROM `despatch`
					INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
					WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = 'Sent'
					AND (`bags`.`type` = 'Combine' )
					GROUP BY `despatch`.`desp_no`";




				}

				$query  = $db2->query($sql);
				$result = $query->result();
				return $result;         
			}


			public function get_combine_despatch_out_ems_list(){

				$db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
				$o_region = $this->session->userdata('user_region');
				$o_branch = $this->session->userdata('user_branch');
				$emid = $this->session->userdata('user_login_id');

				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
				$date = $today->format('Y-m-d');

				if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

					$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
						WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
					FROM `despatch`
					INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
					WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = 'Sent' AND `despatch`.`region_from` = '$o_region' AND `despatch`.`branch_from` = '$o_branch' 
					AND (`bags`.`type` = 'Combine' )";




				}elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

					$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
						WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
					FROM `despatch`
					INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
					WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = 'Sent' AND `despatch`.`region_from` = '$o_region' 
					AND (`bags`.`type` = 'Combine' )";



				}else{

					$sql = "SELECT *, (SELECT COUNT(*) FROM `bags` 
						WHERE `bags`.`despatch_no` = `despatch`.`desp_no` AND (`bags`.`type` = 'Combine' )) AS `item_number`
					FROM `despatch`
					INNER JOIN `bags` ON `bags`.`despatch_no` = `despatch`.`desp_no`
					WHERE date(`despatch`.`datetime`)= '$date' AND `despatch`.`despatch_status` = 'Sent'
					AND (`bags`.`type` = 'Combine' )";




				}

				$query  = $db2->query($sql);
				$result = $query->result();
				return $result;         
			}




			public function count_item_in_bag($bagno){
				$db2 = $this->load->database('otherdb', TRUE);
				$sql    = "SELECT * FROM `transactions` WHERE `isBagNo`='$bagno' AND `PaymentFor` = 'EMS'";
				$query  = $db2->query($sql);
				return $query->num_rows();
			}
			public function count_ems_SEARCH($date,$month){
				$db2 = $this->load->database('otherdb', TRUE);
				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
		//$date = $today->format('Y-m-d');
		//$date = date('Y-m-d');
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					if(!empty($date)){

						$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`office_name`= 'Back'  AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  date(`sender_info`.`date_registered`) = '$date'";

					}
					else{

						$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`office_name`= 'Back'  AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' 
						AND  MONTH(`sender_info`.`date_registered`) = '$day' AND  YEAR(`sender_info`.`date_registered`) = '$year'";

					}



				}elseif($this->session->userdata('user_type') == 'RM'){
					if(!empty($date)){
						$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`office_name`= 'Back'   AND `sender_info`.`s_region` = '$o_region' AND  date(`sender_info`.`date_registered`) = '$date'";
					}else{

						$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
						WHERE `transactions`.`office_name`= 'Back'   AND `sender_info`.`s_region` = '$o_region' 
						AND  MONTH(`sender_info`.`date_registered`) = '$day' AND  YEAR(`sender_info`.`date_registered`) = '$year'";

					}
				}else{

					if(!empty($date)){

						$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`office_name`= 'Back'  AND date(`sender_info`.`date_registered`) = '$date' ";
					}else{

						$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
						INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`office_name`= 'Back' 
						AND  MONTH(`sender_info`.`date_registered`) = '$day' AND  YEAR(`sender_info`.`date_registered`) = '$year' ";

					}
				}


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
					WHERE `transactions`.`office_name`= 'Back'  AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  date(`sender_info`.`date_registered`) = '$date'";

				}elseif($this->session->userdata('user_type') == 'RM'){
					$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
					WHERE `transactions`.`office_name`= 'Back'   AND `sender_info`.`s_region` = '$o_region' AND  date(`sender_info`.`date_registered`) = '$date'";
				}else{

					$sql = "SELECT `sender_info`.`sender_id`,`transactions`.`office_name` FROM `sender_info`
					INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`office_name`= 'Back'  AND date(`sender_info`.`date_registered`) = '$date' ";
				}


				$query  = $db2->query($sql);
				return $query->num_rows();
			}


			public function count_bags_SEARCH($date,$month){
				$db2 = $this->load->database('otherdb', TRUE);
				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
		//$date = $today->format('Y-m-d');
		//$STARTdate = $today->format('2021-05-01');
				$STARTdate = date("2021-05-23");

				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;


				$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];


				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
					if(empty($date)){

						$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate'
						AND date(`bags`.`date_created`) = '$date' ORDER BY `bags`.`date_created` DESC";

					}
					else{

						$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' 
						AND MONTH(`bags`.`date_created`) = '$day' AND YEAR(`bags`.`date_created`) = '$year'
						AND date(`bags`.`date_created`) > '$STARTdate' ORDER BY `bags`.`date_created` DESC";

					}


				}else{
					if(empty($date)){
						$sql = "SELECT * FROM `bags` WHERE `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' AND date(`bags`.`date_created`) = '$date' ORDER BY `bags`.`date_created` DESC";
					}
					else{
						$sql = "SELECT * FROM `bags` WHERE `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate'
						AND MONTH(`bags`.`date_created`) = '$day' AND YEAR(`bags`.`date_created`) = '$year' 
						ORDER BY `bags`.`date_created` DESC";

					}
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
		//$STARTdate = $today->format('2021-05-01');
				$STARTdate = date("2021-05-23");

				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' 
					AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') ORDER BY `bags`.`date_created` DESC";

				}elseif($this->session->userdata('user_type') == "RM") {

					$sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region'  AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' 
					AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') ORDER BY `bags`.`date_created` DESC";


				}else{
					$sql = "SELECT * FROM `bags` WHERE `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) > '$STARTdate' 
					AND (`bags`.`type` = 'Normal' OR `bags`.`type` = '') ORDER BY `bags`.`date_created` DESC";
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

				}elseif($this->session->userdata('user_type') == "RM") {
					$sql = "SELECT *
					FROM `despatch`
					WHERE `despatch`.`region_from`  = '$o_region'  AND  date(`despatch`.`datetime`) = '$date'";


				}else{
					$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
				}


				$query  = $db2->query($sql);
				return $query->num_rows();
			}
			public function count_despatch_out_search($date,$month){
				$db2 = $this->load->database('otherdb', TRUE);
				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
		//$date = $today->format('Y-m-d');
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
				$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

					if(!empty($date)){

						$sql = "SELECT *
						FROM `despatch`
						WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  date(`despatch`.`datetime`) = '$date'";

					}
					else{
						$sql = "SELECT *
						FROM `despatch`
						WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' 
						AND  MONTH(`despatch`.`datetime`) = '$day' AND  YEAR(`despatch`.`datetime`) = '$year'";
					}

				}else{
					if(!empty($date)){
						$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
					}
					else{

						$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' 
						AND  MONTH(`despatch`.`datetime`) = '$day' AND  YEAR(`despatch`.`datetime`) = '$year'";

					}
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

				}elseif($this->session->userdata('user_type') == "RM") {
					$sql = "SELECT * FROM `despatch`
					WHERE `despatch`.`region_to`  = '$o_region'  AND  date(`despatch`.`datetime`) = '$date'";

				}else{
					$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
				}


				$query  = $db2->query($sql);
				return $query->num_rows();
			}


			public function count_despatch_in_SEARCH($date,$month){
				$db2 = $this->load->database('otherdb', TRUE);
				$tz = 'Africa/Nairobi';
				$tz_obj = new DateTimeZone($tz);
				$today = new DateTime("now", $tz_obj);
		//$date = $today->format('Y-m-d');
				$id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;

				$m = explode('-', $month);

				$day = @$m[0];
				$year = @$m[1];

				if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
					if(!empty($date)){

						$sql = "SELECT * FROM `despatch`
						WHERE `despatch`.`region_to`  = '$o_region' AND `despatch`.`branch_to`  = '$o_branch' AND  date(`despatch`.`datetime`) = '$date'";

					}
					else{

						$sql = "SELECT * FROM `despatch`
						WHERE `despatch`.`region_to`  = '$o_region' AND `despatch`.`branch_to`  = '$o_branch' 
						AND  MONTH(`despatch`.`datetime`) = '$day'AND  YEAR(`despatch`.`datetime`) = '$year'";

					}


				}else{
					if(!empty($date)){
						$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
					}else{
						$sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' 
						AND  MONTH(`despatch`.`datetime`) = '$day'AND  YEAR(`despatch`.`datetime`) = '$year'";

					}
				}


				$query  = $db2->query($sql);
				return $query->num_rows();
			}

			public function checkDeliveryItems($barcode,$operator){
				$db2 = $this->load->database('otherdb', TRUE);

				$sql = "select * from waiting_for_delivery  where 1=1 ";

				if($barcode) $sql .=" and barcode = '$barcode' ";
				if($operator) $sql .=" and empid = '$operator' ";
		//if($status) $sql .=" and status = $status";

				$query  = $db2->query($sql);
				$result = $query->result_array();
				return $result;
			}

			public function checkPendingDeliveryItems($operator,$assignedby){
		//AND waiting_for_delivery.wfd_type='pending'

				$db2 = $this->load->database('otherdb', TRUE);

				$sql = "SELECT * FROM sender_info INNER JOIN receiver_info ON sender_info.sender_id=receiver_info.from_id INNER JOIN transactions ON transactions.CustomerID=sender_info.sender_id INNER JOIN waiting_for_delivery ON waiting_for_delivery.senderid=sender_info.sender_id WHERE waiting_for_delivery.empid='$operator' 
				AND waiting_for_delivery.assignedby='$assignedby' AND waiting_for_delivery.status=1 AND waiting_for_delivery.service_type='ems'";

				$query  = $db2->query($sql);
				$result = $query->result_array();
				return $result;
			}

			public function checkDeliveringList($operator,$fromdate,$todate,$assignedby){
		//AND waiting_for_delivery.wfd_type='pending'
		//AND waiting_for_delivery.status= 1
				$db2 = $this->load->database('otherdb', TRUE);

				$sql = "SELECT * FROM sender_info INNER JOIN receiver_info ON sender_info.sender_id=receiver_info.from_id INNER JOIN transactions ON transactions.CustomerID = sender_info.sender_id INNER JOIN waiting_for_delivery ON waiting_for_delivery.senderid = sender_info.sender_id WHERE waiting_for_delivery.service_type='ems'";

				if($operator) $sql.= " and `waiting_for_delivery`.`empid`='$operator' ";

				if (!empty($fromdate) && !empty($todate)) {
					$sql.= " and date(`waiting_for_delivery`.`waiting_for_delivery_created_at`) between '$fromdate' and '$todate' ";
				}

				if($assignedby) $sql.= " and `waiting_for_delivery`.`assignedby`='$assignedby' ";

				$query  = $db2->query($sql);
				$result = $query->result_array();
				return $result;
			}

			public function getWaitingForDelivery($fromdate,$todate){
				$db2 = $this->load->database('otherdb', TRUE);
				$region = $this->session->userdata('user_region');

		/*$sql = "select * from waiting_for_delivery WHERE waiting_for_delivery.service_type='ems' AND DATE(`waiting_for_delivery`.`waiting_for_delivery_created_at`) 
		BETWEEN '$fromdate' AND '$todate';";*/

		if ($this->session->userdata('user_type') == 'SUPER ADMIN'|| $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP"){

			$sql="select *,
			sum(case when `waiting_for_delivery`.`status` = 1 then 1 else 0 end) pending,
			sum(case when `waiting_for_delivery`.`status` = 0 then 1 else 0 end) completed
			from waiting_for_delivery WHERE `waiting_for_delivery`.`service_type`='ems' AND DATE(`waiting_for_delivery`.`waiting_for_delivery_created_at`) 
			BETWEEN '$fromdate' AND '$todate' GROUP by `waiting_for_delivery`.`empid`";

		} else {

			$sql="select *,
			sum(case when `waiting_for_delivery`.`status` = 1 then 1 else 0 end) pending,
			sum(case when `waiting_for_delivery`.`status` = 0 then 1 else 0 end) completed
			from waiting_for_delivery 
			INNER JOIN sender_info ON waiting_for_delivery.senderid=sender_info.sender_id
			WHERE `waiting_for_delivery`.`service_type`='ems' AND DATE(`waiting_for_delivery`.`waiting_for_delivery_created_at`) 
			BETWEEN '$fromdate' AND '$todate' AND s_region='$region' GROUP by `waiting_for_delivery`.`empid`";

		}

		//echo $sql;die();

		$query  = $db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getWaitingForDeliveryByStatus($empid,$status,$fromdate,$todate){
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "select count(*) as total from waiting_for_delivery WHERE `waiting_for_delivery`.`service_type`='ems' AND DATE(`waiting_for_delivery`.`waiting_for_delivery_created_at`) 
		BETWEEN '$fromdate' AND '$todate' AND `waiting_for_delivery`.`empid` = '$empid' AND `waiting_for_delivery`.`status` = $status";

		//echo $sql;die();

		$query  = $db2->query($sql);
		$result = $query->result_array();
		return $result[0]['total'];
	}


	public function getDeliveryItems($fromdate,$todate){
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM sender_info 
		LEFT JOIN receiver_info ON sender_info.sender_id = receiver_info.from_id 
		LEFT JOIN transactions ON transactions.CustomerID = sender_info.sender_id 
		LEFT JOIN waiting_for_delivery ON waiting_for_delivery.senderid = sender_info.sender_id WHERE waiting_for_delivery.service_type='ems' AND DATE(`waiting_for_delivery`.`waiting_for_delivery_created_at`) BETWEEN '$fromdate' AND '$todate'";

		//echo $sql;die();

		$query  = $db2->query($sql);
		$result = $query->result_array();
		return $result;
	}

	public function getDeliveryItemsByStatus($empid,$status,$fromdate,$todate){
		$db2 = $this->load->database('otherdb', TRUE);

		$sql = "SELECT * FROM sender_info 
		LEFT JOIN receiver_info ON sender_info.sender_id = receiver_info.from_id 
		LEFT JOIN transactions ON transactions.CustomerID = sender_info.sender_id 
		LEFT JOIN waiting_for_delivery ON waiting_for_delivery.senderid = sender_info.sender_id WHERE waiting_for_delivery.service_type='ems' AND DATE(`waiting_for_delivery`.`waiting_for_delivery_created_at`) BETWEEN '$fromdate' AND '$todate' 
		AND `waiting_for_delivery`.`empid` = '$empid' AND `waiting_for_delivery`.`status` = $status ";

		//echo $sql;die();

		$query  = $db2->query($sql);
		//$result = $query->row_array();
		$result = $query->result_array();
		return $result;
	}

	//saving the data for delivery
	public function save_waiting_for_delivery($data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('waiting_for_delivery',$data);
	}

	public function delete_waiting_for_delivery($barcode){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->delete('waiting_for_delivery',array('barcode '=> $barcode));
	}

//for EMS
	public function get_item_ems_for_delivery($barcode){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`Barcode`='$barcode'";
		$query  = $db2->query($sql);
		$result = $query->result_array();
		return $result;
	}
//for Mail
	/*public function get_item_mail_for_delivery($barcode){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`Barcode`='$barcode'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}*/

	public function get_item_from_bags_list($bagno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`isBagNo`='$bagno'";
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;
	}



	public function get_item_from_bags_equary_list($userId){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`itemequary`='yes' ";

		if($userId) $sql.= " and `transactions`.`itemequaryby`='$userId' ";
		
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

	public function update_office_name($id,$data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$id);
		$db2->update('transactions',$data);
	}

	public function tracing($data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->insert('tracing',$data);
	}

	public function update_trace_data($createdby,$transid,$pass_to,$data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('emid',$createdby);
		$db2->where('pass_to',$pass_to);
		$db2->where('transid',$transid);
		$db2->where('status','IN');
		$db2->update('tracing',$data);
	}

	public function update_back_office_Barcode($Barcode,$data){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('Barcode',$Barcode);
		$db2->update('transactions',$data);
	}

	public function transfer_for_delivery($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='WaitingDelivery'
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`id`='$id'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	
	public function transfer_to_office_exchange($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='Officeofexchange'
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`id`='$id'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function transfer_to_Ips($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='Senttoips'
		WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`id`='$id'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function update_sender_info_byTrack($trackno){  
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='Derivered'
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`track_number`='$trackno'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function update_sender_person_info_mails($trackno){  
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_person_info`
		SET `sender_person_info`.`sender_status`='Derivery'
		WHERE  `sender_person_info`.`track_number`='$trackno'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function update_accept_sender_info_byTrack($trackno,$emid){  
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='Derivered'
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`track_number`='$trackno'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function update_accept_sender_person_info_mails($trackno,$emid){  
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_person_info`
		SET `sender_person_info`.`sender_status`='Derivery'
		WHERE  `sender_person_info`.`track_number`='$trackno'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}


	public function update_sender_person_info_mail_info($data,$trackno){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('track_number', $trackno);
		$db2->update('sender_person_info',$data);
	}





	public function update_assign_derivery_info_pos($trackno,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service){  
		
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d H:i:s');

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `assign_derivery`
		LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`assign_derivery`.`item_id`

		SET `assign_derivery`.`deliverer_name`='$receiver',
		`assign_derivery`.`phone`='$phone',
		`assign_derivery`.`identity`='$identity_type',
		`assign_derivery`.`identityno`='$identity_no',
		`assign_derivery`.`service_type`='$service',
		`assign_derivery`.`d_status`='Yes',
		`assign_derivery`.`operator`='$operator',
		`assign_derivery`.`image`='$image',
		`assign_derivery`.`location`='$location',
		`assign_derivery`.`deriveryDate`='$date'

		WHERE  `sender_info`.`track_number`='$trackno'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function Getemidbymail($em_email){

		$sql = "SELECT `em_id` FROM `employee` WHERE `em_email`='$em_email'   ORDER BY `em_code` DESC LIMIT 1";
		$query=$this->db->query($sql);
		$result = $query->row();
		return $result;

	}



	public function update_assign_derivery_Person_info_pos($trackno,$phone,$receiver,$identity_type,$identity_no,$operator,$image,$location,$service){  
		
		$tz = 'Africa/Nairobi';
		$tz_obj = new DateTimeZone($tz);
		$today = new DateTime("now", $tz_obj);
		$date = $today->format('Y-m-d H:i:s');

		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `assign_derivery`
		LEFT JOIN `sender_person_info` ON `sender_person_info`.`senderp_id`=`assign_derivery`.`item_id`

		SET `assign_derivery`.`deliverer_name`='$receiver',
		`assign_derivery`.`phone`='$phone',
		`assign_derivery`.`identity`='$identity_type',
		`assign_derivery`.`identityno`='$identity_no',
		`assign_derivery`.`service_type`='$service',
		`assign_derivery`.`d_status`='Yes',
		`assign_derivery`.`operator`='$operator',
		`assign_derivery`.`image`='$image',
		`assign_derivery`.`location`='$location',
		`assign_derivery`.`deriveryDate`='$date'

		WHERE  `sender_person_info`.`track_number`='$trackno'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}



	



	public function transfer_back_tosorting($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='Received'
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`sender_id`='$id'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}

	public function assigned_for_delivery($id){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "UPDATE `sender_info`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		SET `sender_info`.`item_status`='Assigned'
		WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`sender_id`='$id'";

		$query  = $db2->query($sql);
		//$result = $query->result();
		//return $result;
	}


	public function update_price($up,$acc_no){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('acc_no',$acc_no);
		$db2->update('credit_customer',$up);
	}
	public function update_price1($up,$acc_no){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('acc_no',$acc_no);
		$db2->update('bill_credit_customer',$up);
	}
	public function update_transactions($update,$serial1){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial1);
		$db2->update('transactions',$update);
	}

	public function update_transactions_for_sender($update,$id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$id);
		$db2->update('transactions',$update);
	}
	public function update_transactions_for_equary($update,$id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$id);
		$db2->update('transactions',$update);
	}

	public function update_transactions_bill($update,$serial2){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('id',$serial2);
		$db2->update('transactions',$update);
	}

	public  function get_transactions_row($track_number){

		$db2 = $this->load->database('otherdb', TRUE);
		

		$sql = "SELECT `transactions`.`id` As id FROM `sender_info`
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `sender_info`.`track_number` = '$track_number' ORDER BY `sender_info`.`sender_id` DESC LIMIT 1 ";


		$query=$db2->query($sql);
		$result = $query->row();
		return $result;

	}


	public function update_counter($data,$cid){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('counter_id',$cid);
		$db2->update('counters',$data);
	}

	public function update_zone($data,$zone_id){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('zone_id',$zone_id);
		$db2->update('zones',$data);
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

	public function get_ems_repost($controlno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`billid`='$controlno'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public function get_trans($controlno){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `transactions` 
		WHERE `billid`='$controlno'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public function get_invoice($serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `invoice` 
		WHERE `invcust_id`='$serial'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}


	public function get_emszero($serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT * FROM `emszero` 
		WHERE `serial`='$serial'";
		$query  = $db2->query($sql);
		$result = $query->row();
		return $result;
	}

	public function get_ems_repost_bySerial($serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info` 
		LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
		LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
		WHERE `transactions`.`serial`='$serial'";
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

		$json = json_encode($data);
 //create logs
		$value = array();
		$value = array('item'=>$renter,'payload'=>$json);
		$log=json_encode($value);
		$lg = array(
			'response'=>$log,
			'serial'=>$serial,
			'type'=>'SendtoGEPG',
			'service'=>$serviceId,
			'barcode'=>$mobile
		);
		$this->save_logs($lg);

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
public function getUpdatePayment($serial,$amount){
	$db2 = $this->load->database('otherdb', TRUE);

	$data = array(
		'AppID'=>'POSTAPORTAL',
		'serial'=>$serial,
		'BillAmt'=>$amount,
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
		curl_close ($ch);
		$result = json_decode($response);
		
		@$serial1 = @$result->billid;
		//print_r(@$result->receipt);

		if (@$result->status == '103' && @$result->receipt== '') {
			$paid = "NotPaid";
			$db2->set('status', $paid);
			$db2->set('billid', @$result->controlno);
			$db2->where('serial', @$serial1);
			$db2->update('register_transactions');
		} else {
			$paid = "Paid";
			$db2->set('receipt', @$result->receipt);
		 	// //$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
			$db2->where('serial', @$serial1);
			$db2->update('register_transactions');
	        # code...
		}
		

	}
	public function getUpdatePaymentInternational($serial,$amount){
		$db2 = $this->load->database('otherdb', TRUE);
		
		$data = array(
			'AppID'=>'POSTAPORTAL',
			'serial'=>$serial,
			'BillAmt'=>$amount,
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
		curl_close ($ch);
		$result = json_decode($response);
		
		@$serial1 = @$result->billid;
		//print_r(@$result->receipt);

		if (@$result->status == '103' && @$result->receipt== '') {
			$paid = "NotPaid";
			$db2->set('status', $paid);
			$db2->set('billid', @$result->controlno);
			$db2->where('serial', @$serial1);
			$db2->update('transactions');
		} else {
			$paid = "Paid";
			//echo @$result->controlno;
			$db2->set('receipt', @$result->receipt);
			$db2->set('billid', @$result->controlno);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
			$db2->where('serial', @$serial1);
			$db2->update('transactions');
	        # code...
		}
		

	}
	public function getUpdatePaymentEMS($serial,$amount){
		$db2 = $this->load->database('otherdb', TRUE);
		
		$data = array(
			'AppID'=>'POSTAPORTAL',
			'serial'=>$serial,
			'BillAmt'=>$amount,
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
		curl_close ($ch);
		$result = json_decode($response);
		
		@$serial1 = @$result->billid;
		//echo @$result->billid;

		if (@$result->status == '103' && @$result->receipt== '') {

			$paid = "NotPaid";
			$db2->set('status', $paid);
			$db2->set('billid', @$result->controlno);
			$db2->where('serial', @$serial1);
			$db2->update('transactions');
	        // echo "string";

		} else {

			$paid = "Paid";
			$db2->set('receipt', @$result->receipt);
		 	// //$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
			$db2->where('serial', @$serial1);
			$db2->update('transactions');
	        # code...
		}
		

	}

	public function Check_bill($serial)
	{
		$db2 = $this->load->database('otherdb', TRUE);

		$sql    = "SELECT *  FROM   `derivery_transactions`  WHERE `serial` = '$serial' AND `billid` IS NULL
		LIMIT 1";


		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;         

	}

	public function getBillPayment($serial,$paidamount){
		$db2 = $this->load->database('otherdb', TRUE);
		
		$check = $this->Check_bill($serial);

		if(!empty($check))
		{
			$data = array(
				'AppID'=>'POSTAPORTAL',
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
		 //print_r($result->paydate);
		// print_r($result->receipt);
		 //print_r(@$result->channel);
		  //print_r($result->amount);
		 //print_r($result->controlno);
		 //print_r($result->billid);
		//return $result;
		//if (@$result->controlno != '') {
		$paid = "Paid";
		@$serial1 = @$result->billid;
		
		if (@$result->status == "102") {

		} elseif (@$result->amount == '' && @$result->status == "103") {
			$paid = "NotPaid";
		// 	$db2 = $this->load->database('otherdb', TRUE);
			$db2->set('receipt', @$result->receipt);
		 	//$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
	        $db2->set('billid', @$result->controlno);//if 2 columns
	        $db2->where('serial', @$serial1);
	        $db2->update('derivery_transactions');
	        $db2->update('transactions');
	        $db2->update('register_transactions');
	        $db2->update('parcel_international_transactions');
	        $db2->update('real_estate_transactions');
	        $db2->update('parking_transactions');
	        $db2->update('parking_wallet');

	    } else{

		// //if (@$result->amount != 0) {
	    	$db2->set('receipt', @$result->receipt);
		 	//$db2->set('paidamount', @$result->amount);
	    	$db2->set('paychannel', @$result->channel);
	    	$db2->set('paymentdate', @$result->paydate);
	    	$db2->set('status', $paid);
	        $db2->set('billid', @$result->controlno);//if 2 columns
	        $db2->where('serial', @$serial1);
	        $db2->update('derivery_transactions');
	        $db2->update('transactions');
	        //$db2->update('derivery_transactions');
	    }
		// }


    //}

        //print_r($result);

		//echo $result;

	}



}

public function getBillPaymentrepost($controlno){
	$db2 = $this->load->database('otherdb', TRUE);
	$data = array(
		'AppID'=>'POSTAPORTAL',
		'BillAmt'=>0,
		'controlno'=>$controlno);

	$url = "http://192.168.33.2/payments/paymentRepostAPI.php";
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
		 //print_r($result->paydate);
		// print_r($result->receipt);
		 //print_r(@$result->channel);
		  //print_r($result->amount);
		 //print_r($result->controlno);
		 //print_r($result->billid);
		//return $result;
		//if (@$result->controlno != '') {
			//echo "123";
		$paid = "Paid";
		$serial1 = @$result->billid;
		
		if (@$result->status == "102") {

		} elseif (@$result->amount == '' && @$result->status == "103") {
			//echo "123456";
			$paid = "NotPaid";


			$update = array('billid'=>$result->controlno,'paymentdate'=>@$result->paydate,'receipt'=>@$result->receipt,'status'=>$paid,'paychannel'=>@$result->channel);
			$serial = $serial1;
			$this->update_transactions2($update,$serial);
			$this->update_register_transactions($update,$serial);
			$this->update_delivery_transactions1($update,$serial);
			$this->update_parcel_international_transactions1($update,$serial);
			$this->update_parking_transactions1($update,$serial);
			$this->update_parking_wallet_transaction($update,$serial);

		} elseif ( @$result->status == "103" && !empty($result->receipt)) {
		//echo "12345678";
			$update = array('billid'=>$result->controlno,'paymentdate'=>$result->paydate,'receipt'=>$result->receipt,'status'=>$paid,'paychannel'=>$result->channel);
			$serial = $serial1;
			$this->update_transactions2($update,$serial);
			$this->update_register_transactions($update,$serial);
			$this->update_delivery_transactions1($update,$serial);
			$this->update_parcel_international_transactions1($update,$serial);
			$this->update_parking_transactions1($update,$serial);
			$this->update_parking_wallet_transaction($update,$serial);

		}else{
	//echo "123456789";
		// //if (@$result->amount != 0) {

			if ( @$result->status != "104" ) {
				$paid = "NotPaid";

				$update = array('billid'=>$result->controlno,'paymentdate'=>@$result->paydate,'receipt'=>@$result->receipt,'status'=>$paid,'paychannel'=>@$result->channel);
				$serial = $serial1;
				$this->update_transactions2($update,$serial);
				$this->update_register_transactions($update,$serial);
				$this->update_delivery_transactions1($update,$serial);
				$this->update_parcel_international_transactions1($update,$serial);
				$this->update_parking_transactions1($update,$serial);
				$this->update_parking_wallet_transaction($update,$serial);
			}
		}
		
		
    //}

        //print_r($result);

		//echo $result;
		return $result;

	}
	

	public function update_transactions2($update,$serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial);
		$db2->update('transactions',$update);
	}
	public function update_register_transactions($update,$serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial);
		$db2->update('register_transactions',$update);
	}
	public function update_delivery_transactions1($update,$serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial);
		$db2->update('derivery_transactions',$update);
	}
	public function update_parcel_international_transactions1($update,$serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial);
		$db2->update('parcel_international_transactions',$update);
	}
	public function update_parking_transactions1($update,$serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial);
		$db2->update('parking_transactions',$update);
	}
	public function update_parking_wallet_transaction($update,$serial){
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->where('serial',$serial);
		$db2->update('parking_wallet',$update);
	}






	public function getBill_Repost_Payment($serial,$paidamount){
		$db2 = $this->load->database('otherdb', TRUE);
		



		$data = array(
			'AppID'=>'POSTAPORTAL',
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
		 //print_r($result->paydate);
		// print_r($result->receipt);
		 //print_r(@$result->channel);
		  //print_r($result->amount);
		 //print_r($result->controlno);
		 //print_r($result->billid);
		//return $result;
		//if (@$result->controlno != '') {
		$paid = "Paid";
		@$serial1 = @$result->billid;
		
		if (@$result->status == "102") {

		} elseif (@$result->amount == '' && @$result->status == "103") {
		 	//echo "Saida";
			$paid = "NotPaid";
		// 	$db2 = $this->load->database('otherdb', TRUE);
			$db2->set('receipt', @$result->receipt);
		 	//$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
	 //        //$db2->set('billid', @$result->controlno);//if 2 columns
			$db2->where('serial', @$serial);
			$db2->update('derivery_transactions');
			$db2->update('transactions');


		} else{
			
		// //if (@$result->amount != 0) {


			$db2->set('receipt', @$result->receipt);
		 	//$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
	 //        //$db2->set('billid', @$result->controlno);//if 2 columns
			$db2->where('serial', @$serial);
			$db2->update('derivery_transactions');
			$db2->update('register_transactions');
			$db2->update('transactions');
	        //$db2->update('derivery_transactions');
		}
		// }
		
		
    //}

        //print_r($result);

		//echo $result;




		
	}



	public function getBill_Ems_Repost_Payment($serial,$paidamount){
		$db2 = $this->load->database('otherdb', TRUE);
		



		$data = array(
			'AppID'=>'POSTAPORTAL',
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
		 //print_r($result->paydate);
		// print_r($result->receipt);
		 //print_r(@$result->channel);
		  //print_r($result->amount);
		 //print_r($result->controlno);
		 //print_r($result->billid);
		//return $result;
		//if (@$result->controlno != '') {
		$paid = "Paid";
		@$serial1 = @$result->billid;
		
		if (@$result->status == "102") {

		} elseif (@$result->amount == '' && @$result->status == "103") {
		 	//echo "Saida";
			$paid = "NotPaid";
		// 	$db2 = $this->load->database('otherdb', TRUE);
			$db2->set('receipt', @$result->receipt);
		 	//$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
	 //        //$db2->set('billid', @$result->controlno);//if 2 columns
			$db2->where('serial', @$serial);
			$db2->update('transactions');


		} else{
			
		// //if (@$result->amount != 0) {


			$db2->set('receipt', @$result->receipt);
		 	//$db2->set('paidamount', @$result->amount);
			$db2->set('paychannel', @$result->channel);
			$db2->set('paymentdate', @$result->paydate);
			$db2->set('status', $paid);
	 //        //$db2->set('billid', @$result->controlno);//if 2 columns
			$db2->where('serial', @$serial);
			$db2->update('transactions');
	        //$db2->update('derivery_transactions');
		}
		// }
		
		
    //}

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

		$json = json_encode($data);
 //create logs
		$value = array();
		$value = array('item'=>$renter,'payload'=>$json);
		$log=json_encode($value);
		$lg = array(
			'response'=>$log,
			'serial'=>$serial,
			'type'=>'SendtoGEPG',
			'service'=>$serviceId,
			'barcode'=>$trackno
		);


		$this->save_logs($lg);


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

public function getControlNumber1($serial,$amount,$id){

	$sid = $id;
	$track = $this->getTrackNo($sid);
	$track2 = $this->getTrackNo1($sid);

	$data = array(
		'AppID'=>'POSTAPORTAL',
		'serial'=>$serial,
		'BillAmt'=>$amount,
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
		curl_close ($ch);
		$result = json_decode($response);
		echo @$result->controlno;
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('billid', @$result->controlno);
		$db2->where('serial',@$result->billid);
		$db2->update('register_transactions');
	         //$db2->update('transactions');

		$track1 = substr(@$track->track_number,0, 4) . substr(@$result->controlno, 4);
		$db2->set('track_number', @$track1);
		$db2->where('sender_id',@$id);
		$db2->update('sender_info');

	        //$track3 = @$track2->track_number . substr(@$result->controlno, 4);
		$track3 = substr(@$track2->track_number,0, 4) . substr(@$result->controlno, 4);
		$db2->set('track_number', @$track3);
		$db2->where('senderp_id',@$id);
		$db2->update('sender_person_info');


	}

	public function update_tracking_number($id ,$controlno,$trackno){

		$track1 = substr(@$trackno,0, 4) . substr(@$controlno, 4);
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('track_number', @$track1);
		$db2->where('sender_id',@$id);
		$db2->update('sender_info');

	}
	public function update_tracking_number1($id ,$controlno,$trackno){
		$rondom = substr(date('dHis'), 1);
		$track1 =  $trackno.'4'.$rondom;
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('track_number', @$track1);
		$db2->where('sender_id',@$id);
		$db2->update('sender_info');

	}

	public function getControlNumberPAInter($serial,$amount,$id){

		$sid = $id;
		$track = $this->getTrackNo($sid);
		

		$data = array(
			'AppID'=>'POSTAPORTAL',
			'serial'=>$serial,
			'BillAmt'=>$amount,
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
		curl_close ($ch);
		$result = json_decode($response);
		    //echo @$result->controlno;
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('billid', @$result->controlno);
	         $db2->where('serial',@$result->billid);//register_transactions
	         $db2->update('register_transactions');
	         $db2->update('parcel_international_transactions');

	        //$track3 = @$track2->track_number . substr(@$result->controlno, 4);
	         $track3 = substr(@$track->track_number,0, 4) . substr(@$result->controlno, 4);
	         $db2->set('track_number', @$track3);
	         $db2->where('senderp_id',@$id);
	         $db2->update('sender_person_info');


	     }

	     public function getControlNumber($serial,$amount,$id){

	     	$sid = $id;
	     	$track = $this->getTrackNo($sid);
	     	$track2 = $this->getTrackNo1($sid);

	     	$data = array(
	     		'AppID'=>'POSTAPORTAL',
	     		'serial'=>$serial,
	     		'BillAmt'=>$amount,
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
		curl_close ($ch);

		$result = json_decode($response);
		    //echo @$result->controlno;
		$db2 = $this->load->database('otherdb', TRUE);
		$db2->set('billid', @$result->controlno);
		$db2->where('serial',@$result->billid);
	         //$db2->update('register_transactions');
		$db2->update('transactions');


	}


	public  function get_derivery_list_by_id($id){

		$sql = "SELECT  `sender_info`.*,`assign_derivery`.*,`receiver_info`.*,`transactions`.*,
			-- ,`ems_tariff_category`.*
			(SELECT COUNT(*) FROM `event_management` 
				WHERE `event_management`.`name` = `assign_derivery`.`serial` ) AS `Idadi`
			FROM `sender_info`
			LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            -- LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`

            WHERE `transactions`.`status` != 'OldPaid' AND  `sender_info`.`item_status`='Assigned'
            AND  `assign_derivery`.`service_type`='EMS' AND `assign_derivery`.`em_id` = '$id'
            GROUP BY  `assign_derivery`.`serial`
            ";


            $db2 = $this->load->database('otherdb', TRUE);



            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
        }

        public  function get_derivery_list_by_id0($id){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`assign_derivery`.*
        	FROM `sender_info`
        	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
        	LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        	LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`
        	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
        	WHERE  `assign_derivery`.`em_id` = '$id' AND `assign_derivery`.`service_type` = 'EMS'
        	AND  `sender_info`.`item_status`='Assigned' ";

			  // AND `transactions`.`PaymentFor` !='PCUM'AND `sender_info`.`item_status` != 'Derivered'


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public  function get_derivery_pcum_list_by_id($id){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`assign_derivery`.*
        	FROM `sender_info`
        	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
        	LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        	LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`
        	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
        	WHERE  `assign_derivery`.`em_id` = '$id' AND `sender_info`.`item_status` != 'Derivered' AND `assign_derivery`.`service_type` = 'PCUM'";


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public  function get_derivery_list_mails_by_id($id){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,`assign_derivery`.*
        	FROM   `sender_person_info`  
        	INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
        	INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
        	INNER JOIN  `assign_derivery`  ON   `assign_derivery`.`item_id`   = `sender_person_info`.`senderp_id`
        	WHERE  `assign_derivery`.`em_id` = '$id' AND `assign_derivery`.`service_type` = 'MAILS' AND `sender_person_info`.`sender_status` != 'Derivery'";


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public  function get_derivery_list_mails_by_emid($id,$type){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,`assign_derivery`.*
        	FROM   `sender_person_info`  
        	INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
        	INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
        	INNER JOIN  `assign_derivery`  ON   `assign_derivery`.`item_id`   = `sender_person_info`.`senderp_id`
        	WHERE  `assign_derivery`.`em_id` = '$id' AND `assign_derivery`.`service_type` = '$type' AND `sender_person_info`.`sender_status` != 'Derivery'";


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public  function get_new_derivery_list_mails_by_emid($id){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,`assign_derivery`.*
        	FROM   `sender_person_info`  
        	INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
        	INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
        	LEFT JOIN  `assign_derivery`  ON   `assign_derivery`.`item_id`   = `sender_person_info`.`senderp_id`
        	WHERE  `sender_person_info`.`operator` = '$id' AND `sender_person_info`.`sender_type` IN('Register') AND `sender_person_info`.`sender_status` != 'Derivery'";


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public  function get_client_pcum_list(){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "";


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public  function get_derivery_list_register_by_id($id){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`assign_derivery`.*
        	FROM `sender_info`
        	LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
        	LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        	LEFT JOIN `assign_derivery` ON `assign_derivery`.`item_id`=`sender_info`.`sender_id`
        	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
        	WHERE  `assign_derivery`.`em_id` = '$id' AND `sender_info`.`item_status` != 'Derivered'";


        	$query=$db2->query($sql);
        	$result = $query->result();
        	return $result;
        }


        public function save_AuthorityCards($data){
        	$db2 = $this->load->database('otherdb', TRUE);
        	$db2->insert('AuthorityCard',$data);
        }
        public function get_AuthorityCard_list(){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$id2 = $this->session->userdata('user_login_id');
        	$info = $this->employee_model->GetBasic($id2);

        	$id = $info->em_code;

        	$o_region = $info->em_region;
        	$o_branch = $info->em_branch;

        	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
        		$sql = "SELECT * FROM `AuthorityCard`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `AuthorityCard`.`region` = '$o_region' AND `AuthorityCard`.`branch` = '$o_branch' AND `AuthorityCard`.`Created_byId` = '$id'  ORDER BY `AuthorityCard`.`date_created` DESC";

        	}elseif($this->session->userdata('user_type') == 'RM'){
        		$sql = "SELECT * FROM `AuthorityCard`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `AuthorityCard`.`region` = '$o_region'    ORDER BY `AuthorityCard`.`date_created` DESC";

        	}else{
        		$sql = "SELECT * FROM `AuthorityCard`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `AuthorityCard`.`date_created` DESC";

        	}


        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;


        }
        public function get_AuthorityCard_list_search($date,$month,$region){

        	$db2 = $this->load->database('otherdb', TRUE);

        	$id2 = $this->session->userdata('user_login_id');
        	$info = $this->employee_model->GetBasic($id2);
        	$o_region = $info->em_region;
        	$o_branch = $info->em_branch;
        	$id = $info->em_code;

        	$month1 = explode('-', $month);


        	$day = @$month1[0];
        	$year = @$month1[1];


        	if (!empty($month) || !empty($date) || !empty($region)) {



        		$sql = "SELECT * FROM `AuthorityCard`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `AuthorityCard`.`region` = '$region' 


        		ORDER BY `AuthorityCard`.`date_created` DESC";

 // AND  ( MONTH(`AuthorityCard`.`date_created`) = '$day' AND YEAR(`AuthorityCard`.`AuthorityCard`) = '$year' ) 

        	}
        	else
        	{
        		$sql = "SELECT * FROM `AuthorityCard`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`
        		WHERE `transactions`.`status` != 'OldPaid' AND `AuthorityCard`.`region` = '$o_region' AND `AuthorityCard`.`Created_byId` = '$id'  
        		ORDER BY `AuthorityCard`.`date_created` DESC";

        	}

        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;


        }


        public function save_Keydepositys($data){
        	$db2 = $this->load->database('otherdb', TRUE);
        	$db2->insert('Keydeposity',$data);
        }
        public function save_Bulk($data){
        	$db2 = $this->load->database('otherdb', TRUE);
        	$db2->insert('bulk_registration',$data);
        }
        public function get_Keydeposity_list(){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$id2 = $this->session->userdata('user_login_id');
        	$info = $this->employee_model->GetBasic($id2);

        	$id = $info->em_code;

        	$o_region = $info->em_region;
        	$o_branch = $info->em_branch;

        	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
        		$sql = "SELECT * FROM `Keydeposity`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `Keydeposity`.`region` = '$o_region' AND `Keydeposity`.`branch` = '$o_branch' AND `Keydeposity`.`Created_byId` = '$id'  ORDER BY `Keydeposity`.`date_created` DESC";

        	}elseif($this->session->userdata('user_type') == 'RM'){
        		$sql = "SELECT * FROM `Keydeposity`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `Keydeposity`.`region` = '$o_region'    ORDER BY `Keydeposity`.`date_created` DESC";

        	}else{
        		$sql = "SELECT * FROM `Keydeposity`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `Keydeposity`.`date_created` DESC";

        	}


        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;


        }

        public function get_Bulk_list(){

        	$db2 = $this->load->database('otherdb', TRUE);
        	$id2 = $this->session->userdata('user_login_id');
        	$info = $this->employee_model->GetBasic($id2);

        	$id = $info->em_code;

        	$o_region = $info->em_region;
        	$o_branch = $info->em_branch;

        	if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
        		$sql = "SELECT * FROM `bulk_registration`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`bulk_registration`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `bulk_registration`.`region` = '$o_region' AND `bulk_registration`.`branch` = '$o_branch' AND `bulk_registration`.`Created_byId` = '$id'  ORDER BY `bulk_registration`.`date_created` DESC";

        	}elseif($this->session->userdata('user_type') == 'RM'){
        		$sql = "SELECT * FROM `bulk_registration`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`bulk_registration`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `bulk_registration`.`region` = '$o_region'    ORDER BY `bulk_registration`.`date_created` DESC";

        	}else{
        		$sql = "SELECT * FROM `bulk_registration`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`bulk_registration`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `bulk_registration`.`date_created` DESC";

        	}


        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;


        }

        public function get_Bulk_Boxes_list($serial){
        	$db2 = $this->load->database('otherdb', TRUE);
        	$sql = "SELECT `bulk_boxes`.* FROM `bulk_boxes`
        	WHERE `serial` = '$serial'  ";

        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;
        }

        public function get_Keydeposity_list_search($date,$month,$region){

        	$db2 = $this->load->database('otherdb', TRUE);

        	$id2 = $this->session->userdata('user_login_id');
        	$info = $this->employee_model->GetBasic($id2);
        	$o_region = $info->em_region;
        	$o_branch = $info->em_branch;
        	$id = $info->em_code;

        	$month1 = explode('-', $month);


        	$day = @$month1[0];
        	$year = @$month1[1];


        	if (!empty($month) || !empty($date) || !empty($region)) {



        		$sql = "SELECT * FROM `Keydeposity`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `Keydeposity`.`region` = '$region' 


        		ORDER BY `Keydeposity`.`date_created` DESC";

 // AND  ( MONTH(`Keydeposity`.`date_created`) = '$day' AND YEAR(`Keydeposity`.`Keydeposity`) = '$year' ) 

        	}
        	else
        	{
        		$sql = "SELECT * FROM `Keydeposity`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`
        		WHERE `transactions`.`status` != 'OldPaid' AND `Keydeposity`.`region` = '$o_region' AND `Keydeposity`.`Created_byId` = '$id'  
        		ORDER BY `Keydeposity`.`date_created` DESC";

        	}

        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;


        }

        public function get_Bulk_list_search($date,$month,$region){

        	$db2 = $this->load->database('otherdb', TRUE);

        	$id2 = $this->session->userdata('user_login_id');
        	$info = $this->employee_model->GetBasic($id2);
        	$o_region = $info->em_region;
        	$o_branch = $info->em_branch;
        	$id = $info->em_code;

        	$month1 = explode('-', $month);


        	$day = @$month1[0];
        	$year = @$month1[1];


        	if (!empty($month) || !empty($date) || !empty($region)) {



        		$sql = "SELECT * FROM `bulk_registration`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`bulk_registration`.`serial`

        		WHERE `transactions`.`status` != 'OldPaid' AND `bulk_registration`.`region` = '$region' 


        		ORDER BY `bulk_registration`.`date_created` DESC";

 // AND  ( MONTH(`Keydeposity`.`date_created`) = '$day' AND YEAR(`Keydeposity`.`Keydeposity`) = '$year' ) 

        	}
        	else
        	{
        		$sql = "SELECT * FROM `bulk_registration`
        		LEFT JOIN `transactions` ON `transactions`.`serial`=`bulk_registration`.`serial`
        		WHERE `transactions`.`status` != 'OldPaid' AND `bulk_registration`.`region` = '$o_region' AND `bulk_registration`.`Created_byId` = '$id'  
        		ORDER BY `bulk_registration`.`date_created` DESC";

        	}

        	$query = $db2->query($sql);
        	$result = $query->result();
        	return $result;


        }

        public  function get_senderinfo_byserial($serial){
        	$db2 = $this->load->database('otherdb', TRUE);
        	$db2->where('serial',$serial);
        	$query = $db2->get('transactions');
        	$result = $query->row();
        	return $result;

        }

        public function get_requestid_byserial($serial){

        	$db2 = $this->load->database('otherdb', TRUE);
    //$sql    = "SELECT * FROM `sender_info` WHERE `track_number`='$trackno'";
        	$sql = "SELECT *
        	FROM `sender_info`
        	LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
        	WHERE  `transactions`.`serial` = '$serial'

        	";

        	$query  = $db2->query($sql);
        	$result = $query->row();
        	return $result;
        }




    }
    ?>
