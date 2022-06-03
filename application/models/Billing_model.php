<?php

class Billing_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}


		public  function getAllCategory(){
			$query = $this->db->get('category');
			$result = $query->result();
			return $result;

		}
		public  function getAllCategoryBill(){
			$sql = "SELECT  `transactions`.*,`item_sender`.*,`item_details`.*,`em_region`.* FROM `transactions` 
						LEFT JOIN `item_sender` ON `transactions`.`CustomerID` = 
						`item_sender`.`sender_id`
						LEFT JOIN `item_details` ON `item_details`.`item_id` = 
						`item_sender`.`item_id`
						LEFT JOIN `em_region` ON `item_details`.`destination` = 
						`em_region`.`region_id` WHERE `transactions`.`PaymentFor` = 'MAILS'";
			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;

		}
	    public function GetCatListByName($cat_name){

		$sql    = "SELECT * FROM `category` WHERE `cat_name`='$cat_name'";
		$query  = $this->db->query($sql);
		$result = $query->row();
		$cat_id = $result->cat_id;

		$this->db->where('cat_id',$cat_id);
		$query = $this->db->get('category_list');
		$output ='<option value="">--Select Sub Category--</option>';
		foreach ($query->result() as $row) {
			$output .='<option value="'.$row->list_name.'">'.$row->list_name.'</option>';
		}
		return $output;
	}
		public function save_item_details($data){
    		$this->db->insert('item_details',$data);
		}
		public function Save_Ems_Info_Int($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_international',$data);
        }
		public function save_company_details($data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('companies',$data);
		}
		public function save_ems_billing_company_details($data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('ems_bill_companies',$data);
		}

		public function save_mails_billing_company_details($data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('mails_bill_companies',$data);
		}
		public function save_commission_registration($data){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->insert('commission_agency',$data);
		}
		public function save_sender_details($data){
			$this->db->insert('item_sender',$data);
		}
		public function insert_logs($data){
			$this->db->insert('logs',$data);
		}
		public function save_transactions($data){
			$this->db->insert('transactions',$data);
		}
		public function save_receiver_details($data){
			$this->db->insert('item_receiver',$data);
		}
		public function getItemDetailsById($id){
			$sql    = "SELECT * FROM `item_details` WHERE `item_id`='$id'";
				$query  = $this->db->query($sql);
				$result = $query->row();
				return $result;
		}
		public function getSenderDetailsById($id){
			$sql    = "SELECT * FROM `item_sender` WHERE `item_id`='$id'";
			$query  = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}
		public function getNonBill($last_id,$type,$status){
			$sql    = "SELECT * FROM `transactions` WHERE `CustomerID `='$last_id' AND `transactionstatus`= '$status' AND `PaymentFor` = '$type'";
			$query  = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}
		public function getItemPriceByWeight($weight,$sub_cat){

			$sql2 = "SELECT * FROM `category_list` WHERE `list_name`='$sub_cat'";
			$query2  = $this->db->query($sql2);
			$result2 = $query2->row();
			$sub_cat_id = $result2->cat_list_id;

			$sql    = "SELECT * FROM `weight_step` WHERE `cat_list_id`='$sub_cat_id' AND `weight_range` >= '$weight' LIMIT 1";
			$query  = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}
		public function getItemPriceByWeight1($weight,$sub_cat){

			$sql2 = "SELECT * FROM `category_list` WHERE `list_name`='$sub_cat'";
			$query2  = $this->db->query($sql2);
			$result2 = $query2->row();
			$sub_cat_id = $result2->cat_list_id;

			$sql    = "SELECT * FROM `weight_step` WHERE `cat_list_id`='$sub_cat_id' AND `weight_range` = '$weight'";
			$query  = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}
		public function update_transactions($update,$serial1){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('serial',$serial1);
			$db2->update('transactions',$update);
		}
		public function update_transactionsere($update1,$id){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('id',$id);
			$db2->update('transactions',$update1);
		}

		public function update_Regtransactions($update1,$id){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('t_id',$id);
			$db2->update('register_transactions',$update1);
		}

		public function update_transactions_inter($update,$serial1){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('billid',$serial1);
			$db2->update('transactions',$update);
		}
		public function update_transactionsT($update,$serial1){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('billid',$serial1);
			$db2->update('transactions',$update);
		}
		public function update_sender_info($last_id,$data1){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('sender_id',$last_id);
			$db2->update('sender_info',$data1);
		}
		public function update_sender_info_mails($last_id,$data1){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('senderp_id',$last_id);
			$db2->update('sender_person_info',$data1);
		}
		public function update_amount($update,$acc){

			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('acc_no',$acc);
			$db2->update('credit_customer',$update);
		}
		public function update_transactions2($update,$serial){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('billid',$serial);
			$db2->update('transactions',$update);
		}
		public function mails_status_update($data,$item_id){
			$this->db->where('item_id',$item_id);
			$this->db->update('item_details',$data);
		}

		public function update_ems_billing_company_details($data,$com_id){
			$db2 = $this->load->database('otherdb', TRUE);
			$db2->where('com_id',$com_id);
			$db2->update('ems_bill_companies',$data);
		}


		public function checkValue($controlno){
			
			$db2 = $this->load->database('otherdb', TRUE);
		    $sql = "SELECT * FROM `transactions` WHERE `billid`='$controlno'";
		    $query=$db2->query($sql);
		    $result = $query->row();
		    return $result;
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
	public  function get_companies_list(){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT `companies`.*
			  FROM `companies` ";
			  
			  $query=$db2->query($sql);
			  $result = $query->result();
			  return $result;
		}
public  function get_ems_billing_companies_list(){

		     $db2 = $this->load->database('otherdb', TRUE);
		     $id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
				
				if($this->session->userdata('user_type') == "EMPLOYEE"){
					$sql = "SELECT *
			  FROM `ems_bill_companies` WHERE `ems_bill_companies`.`com_region` = '$o_region' AND `ems_bill_companies`.`com_branch` = '$o_branch' ORDER BY datecreated DESC";
				}elseif($this->session->userdata('user_type') == "ACCOUNTANT"){
					$sql = "SELECT *
			  FROM `ems_bill_companies` WHERE `ems_bill_companies`.`com_region` = '$o_region' ORDER BY datecreated DESC";
				}else{
					$sql = "SELECT *
			  FROM `ems_bill_companies` ORDER BY datecreated DESC";
				}
			 
			  
			  $query=$db2->query($sql);
			  $result = $query->result();
			  return $result;
		}
		public  function get_mails_billing_companies_list(){

		     $db2 = $this->load->database('otherdb', TRUE);
		     $id = $this->session->userdata('user_login_id');
				$info = $this->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
				
				if($this->session->userdata('user_type') == "EMPLOYEE"){
					$sql = "SELECT *
			  FROM `mails_bill_companies` WHERE `mails_bill_companies`.`com_region` = '$o_region' AND `mails_bill_companies`.`com_branch` = '$o_branch' ORDER BY datecreated DESC";
				}elseif($this->session->userdata('user_type') == "ACCOUNTANT"){
					$sql = "SELECT *
			  FROM `mails_bill_companies` WHERE `mails_bill_companies`.`com_region` = '$o_region' ORDER BY datecreated DESC";
				}else{
					$sql = "SELECT *
			  FROM `mails_bill_companies` ORDER BY datecreated DESC";
				}
			 
			  
			  $query=$db2->query($sql);
			  $result = $query->result();
			  return $result;
		}
public  function get_companies_byId($id){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT * FROM `companies` WHERE `com_id` = '$id'";
			  
			  $query=$db2->query($sql);
		      $result = $query->row();
			  return $result;
		}
		public  function get_ems_companies_byId($id){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT * FROM `ems_bill_companies` WHERE `com_id` = '$id'";
			  
			  $query=$db2->query($sql);
		      $result = $query->row();
			  return $result;
		}
		public  function get_mails_companies_byId($id){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT * FROM `mails_bill_companies` WHERE `com_id` = '$id'";
			  
			  $query=$db2->query($sql);
		      $result = $query->row();
			  return $result;
		}
public  function get_commission_agency_byId($id){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT * FROM `commission_agency` WHERE `com_id` = '$id'";
			  
			  $query=$db2->query($sql);
		      $result = $query->row();
			  return $result;
		}
public  function get_gilo_billing_list($id,$service){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT * FROM `transactions` WHERE `CustomerID` = '$id' AND `PaymentFor` = '$service'";
			  
			  $query=$db2->query($sql);
		      $result = $query->result();
			  return $result;
		}
	public  function get_ems_billing_list($id,$service){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
			 LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
			 WHERE `invoice`.`invcust_id` = '$id' AND `transactions`.`PaymentFor` = '$service' ORDER BY `transactions`.`transactiondate` DESC";
			  
			  $query=$db2->query($sql);
		      $result = $query->result();
			  return $result;
		}

		public  function get_mails_billing_list($id,$service){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
			 LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
			 WHERE `invoice`.`invcust_id` = '$id' AND `transactions`.`PaymentFor` = '$service' ORDER BY `transactions`.`transactiondate` DESC";
			  
			  $query=$db2->query($sql);
		      $result = $query->result();
			  return $result;
		}

		public  function get_invoice_details($cun,$cn){

		     $db2 = $this->load->database('otherdb', TRUE);

			 $sql = "SELECT `invoice`.*,`transactions`.* FROM `invoice`
			 LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `invoice`.`invoice_id`
			 WHERE `transactions`.`billid` = '$cn' AND `transactions`.`PaymentFor` = 'EMSBILLING'";
			  
			  $query=$db2->query($sql);
		      $result = $query->row();
			  return $result;
		}


		public  function get_ems_billing_list2($id){

		     $db2 = $this->load->database('otherdb', TRUE);

			$sql = "SELECT * FROM `transactions` WHERE `customer_acc` = '$id' AND `PaymentFor` = 'EMSBILLING'";
			  
			  $query=$db2->query($sql);
		      $result = $query->result();
			  return $result;
		}
		public  function get_ems_billing_list3($acc){

		     $db2 = $this->load->database('otherdb', TRUE);

			$sql = "SELECT * FROM `transactions` WHERE `customer_acc` = '$acc' AND `PaymentFor` = 'EMSBILLING' ORDER BY `id` DESC LIMIT 1";
			  
			  $query=$db2->query($sql);
		      $result = $query->row();
			  return $result;
		}
	public  function get_mails_list(){
			$sql = "SELECT  `transactions`.*,`item_sender`.*,`item_details`.*,`em_region`.* FROM `transactions` 
						LEFT JOIN `item_sender` ON `transactions`.`CustomerID` = 
						`item_sender`.`sender_id`
						LEFT JOIN `item_details` ON `item_details`.`item_id` = 
						`item_sender`.`item_id`
						LEFT JOIN `em_region` ON `item_details`.`destination` = 
						`em_region`.`region_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'MAILS'";
			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;

		}

		   public function save_logs($data){
            $db2 = $this->load->database('otherdb', TRUE);
             //$db2->query("SET sql_mode = '' ");
            $db2->insert('logs',$data);
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
		//$db2 = $this->load->database('otherdb', TRUE);
		$this->db->set('bill_status', 'SUCCESS');
        $this->db->set('billid', $result->controlno);//if 2 columns
        $this->db->where('serial', $serial);
        $this->db->update('transactions');
        //print_r($result);

		//echo $result;
	}
}
?>
