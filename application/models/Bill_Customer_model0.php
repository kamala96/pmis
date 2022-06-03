<?php

class Bill_Customer_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
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
    public function save_bill_customer($save)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('corperate_regional_bill_customer', $save);
    }
    public function save_credit_bill_customer($save)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('bill_credit_customer', $save);
    }
    public function save_credit_bill_branch_customer($save1)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('branch_bill_credit_customer', $save1);
    }
    public function save_region_branch($insert)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('bill_region_branch_service', $insert);
    }
    public function update_customer_price($custid,$cid)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('customer_id', $custid);
        $db2->update('corperate_regional_bill_customer',$cid);
    }
    public function update_credit_bill_customer($save,$I)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('credit_id', $I);
        $db2->update('bill_credit_customer',$save);
    }
    public function get_credit_customer(){

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
        

     if($this->session->userdata('user_type') == "ACCOUNTANT"){

        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `credit_customer` WHERE `customer_region` = '$o_region' AND `services_type` = 'EMS Postage'";
          
      }else {

        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region' 
AND `customer_branch` = '$o_branch' AND `services_type` = 'EMS Postage'";

      }

    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }
  public function get_bill_cust_details_info($id){

    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `bill_credit_customer` WHERE `credit_id` = '$id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

public  function get_credit_customer_list_byAccnoMonth($acc_no,$month){
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

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'No'
      ORDER BY `sender_info`.`sender_id` DESC ";

    }else{

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND `transactions`.`isBill_Id` = 'No'
AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill'";

    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }

public  function get_credit_customer_sum_byAccnoMonth($acc_no,$month){
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
      LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'No'
      ORDER BY `sender_info`.`sender_id` DESC ";

    }else{

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'No'";
    
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
      LEFT JOIN `sender_info` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

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





  
  public function check_credit_customer($AskFor){

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
    
    if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  AND `bill_credit_customer`.`services_type` = '$AskFor'   GROUP BY `bill_credit_customer`.`acc_no`  ORDER BY `bill_credit_customer`.`acc_no` ASC";
       
    }elseif($this->session->userdata('user_type') == "ADMIN") {
      $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC";

    }elseif ($this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR") {

        $sql    = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `branch_bill_credit_customer`.`acc_no` ASC";
      }


    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public  function getPay($type){

    $db2 = $this->load->database('otherdb', TRUE);

    $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions`
    INNER JOIN `credit_customer` ON `transactions`.`CustomerID`=`credit_customer`.`credit_id` 
    WHERE `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`status` = 'Paid' AND `credit_customer`.`acc_no` = '$type' ORDER BY `transactions`.`id` DESC LIMIT 1";

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public  function get_ems_billing_list3($acc){

         $db2 = $this->load->database('otherdb', TRUE);

      $sql = "SELECT * FROM `transactions` WHERE `customer_acc` = '$acc' AND `PaymentFor` = 'EMSBILLING' ORDER BY `id` DESC LIMIT 1";
        
        $query=$db2->query($sql);
          $result = $query->row();
        return $result;
    }

    public function get_bill_customer(){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `bill_credit_customer` WHERE `services_type` = 'EMS Postage'";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_customer_bill_credit_by_id($crdtid){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `bill_credit_customer` WHERE `credit_id` = '$crdtid'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_bill_customer_by_id($cust){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `corperate_regional_bill_customer` WHERE `customer_id` = '$cust'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_all_bill_customer_saved_to(){
      
       $db2 = $this->load->database('otherdb', TRUE);

       $o_region = $this->session->userdata('user_region');
       $o_branch = $this->session->userdata('user_branch');

        $sql = "SELECT `em_branch`.*,`em_region`.*,`bill_region_branch_service`.*,`corperate_regional_bill_customer`.* 
        FROM `em_branch` 
        INNER JOIN `em_region` ON `em_region`.`region_id` = `em_branch`.`region_id` 
        INNER JOIN `bill_region_branch_service` ON `bill_region_branch_service`.`region` = `em_region`.`region_id` 
        INNER JOIN `corperate_regional_bill_customer` ON `corperate_regional_bill_customer`.`customer_id` = `bill_region_branch_service`.`customer`  
        WHERE  `em_region`.`region_name` = '$o_region' AND `em_branch`.`branch_name` = '$o_branch'";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function GetBranchById($region_id){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `em_branch`.*,`em_region`.*  
               FROM `em_branch` 
               INNER JOIN `em_region`  ON  `em_region`.`region_id` = `em_branch`.`region_id`
               WHERE `em_region`.`region_id`='$region_id'";
      $query =  $db2->query($sql);
      $output ='<option value="">Select Branch</option>';
      foreach ($query->result() as $row) {
        $output .='<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
      }
       return $output;
      }

      public function get_register_bill_list(){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `payment_type` = 'Bill'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' 
                     ";

            }elseif ($this->session->userdata('user_type') == "RM") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                     
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill'";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }


    public function get_sum_register(){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`payment_type` = 'Bill'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`payment_type` = 'Bill' AND date(`sender_person_info`.`sender_date_created`) = '$date'";

            }elseif ($this->session->userdata('user_type') == "RM") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id` 
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`   
                    WHERE  `sender_person_info`.`payment_type` = 'Bill' AND date(`sender_person_info`.`sender_date_created`) = '$date'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 

    public function check_item_status($ids){

     $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_status` = 'Counter' AND `sender_person_info`.`operator` = '$ids' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill'";

    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;

  }

  public  function get_bill_transactions_list(){

      $db2 = $this->load->database('otherdb', TRUE);
      $region = $this->session->userdata('user_region');
      
      if ($this->session->userdata('user_type') == "ACCOUNTANT") {

        $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  AND `credit_customer`.`customer_region` = '$region'  ORDER BY `transactions`.`billid` ASC";

      }else{

        $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  ORDER BY `transactions`.`paymentdate` DESC";

      }
      
        
        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

    public  function get_bill_transactions_list_posta_global(){

      $db2 = $this->load->database('otherdb', TRUE);
      $region = $this->session->userdata('user_region');
      
      if ($this->session->userdata('user_type') == "ACCOUNTANT") {

        $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  AND `ems_bill_companies`.`com_region` = '$region'  ORDER BY `transactions`.`billid` ASC";

      }else{

        $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID`  
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  ORDER BY `transactions`.`paymentdate` DESC";

      }
      
        
        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

    public  function get_bill_transactions_list_search($cusname,$status){

         $db2 = $this->load->database('otherdb', TRUE);
         $region = $this->session->userdata('user_region');
          if ($this->session->userdata('user_type') == "ACCOUNTANT") {
            $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `credit_customer`.`customer_name` = '$cusname' AND `transactions`.`status` = '$status'  AND `credit_customer`.`customer_region` = '$region' ORDER BY `transactions`.`billid` ASC";
          } else {

            $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `credit_customer`.`customer_name` = '$cusname' AND `transactions`.`status` = '$status' ORDER BY `transactions`.`billid` ASC";
          }

        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

    public  function get_bill_transactions_list_search_posta_global($cusname,$status){

         $db2 = $this->load->database('otherdb', TRUE);
         $region = $this->session->userdata('user_region');
          if ($this->session->userdata('user_type') == "ACCOUNTANT") {
            $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `ems_bill_companies`.`com_name` = '$cusname' AND `transactions`.`status` = '$status'  AND `ems_bill_companies`.`com_region` = '$region' ORDER BY `transactions`.`billid` ASC";
          } else {

            $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `ems_bill_companies`.`com_name` = '$cusname' AND `transactions`.`status` = '$status' ORDER BY `transactions`.`billid` ASC";
          }

        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }
    public function updatePaymentControlNumber($serial,$amount){

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
      
      if (@$result->status == 103 && @$result->channel != '') {
           
           $db2 = $this->load->database('otherdb', TRUE);
           $db2->set('billid', @$result->controlno);
           $db2->set('status','Paid');
           $db2->set('receipt', @$result->receipt);
           $db2->set('paychannel', @$result->channel);
           $db2->set('paymentdate', @$result->paydate);
           $db2->where('serial',@$result->billid);
           $db2->update('transactions');

      }else{

           $db2 = $this->load->database('otherdb', TRUE);
           $db2->set('billid', @$result->controlno);
           $db2->set('status', 'NotPaid');
           $db2->where('serial',@$result->billid);
           $db2->update('transactions');

      }
    }


}
?>