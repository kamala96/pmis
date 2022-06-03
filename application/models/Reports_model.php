<?php

class Reports_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    
        public function save_transactions($data1){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('transactions',$data1);
        }


         public function save_Internets($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('Internet',$data);
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

            public function GetRM(){
                
              $sql = "SELECT `employee`.*,
              `designation`.*,
              `department`.*
              FROM `employee`
              LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
              LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
              WHERE `em_role`='RM'";
                $query=$this->db->query($sql);
                $result = $query->result();
                return $result;

            }

            public function count_emsdespatch_in($o_region,$role){
              $db2 = $this->load->database('otherdb', TRUE);
              //$tz = 'Africa/Nairobi';
              //$tz_obj = new DateTimeZone($tz);
              //$today = new DateTime("now", $tz_obj);
              //$date = $today->format('Y-m-d');
             
              //$date= date('Y-m-d',strtotime("-1 days"));
              $date='2022-01-01';

              if($role == "RM") {
                $sql = "SELECT * FROM `despatch`
                WHERE `despatch`.`region_to`  = '$o_region'  AND  date(`despatch`.`datetime`) >= '$date'";
              }else{
                $sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) >= '$date'";
              }
              $query  = $db2->query($sql);
              return $query->num_rows();
            }

            
            public function count_yesterdayemsdespatch_in($o_region,$role){
              $db2 = $this->load->database('otherdb', TRUE);
              //$tz = 'Africa/Nairobi';
              //$tz_obj = new DateTimeZone($tz);
              //$today = new DateTime("now", $tz_obj);
              //$date = $today->format('Y-m-d');
             
              $date= date('Y-m-d',strtotime("-1 days"));
              //$date='2022-01-01';

              if($role == "RM") {
                $sql = "SELECT * FROM `despatch`
                WHERE `despatch`.`region_to`  = '$o_region'  AND  date(`despatch`.`datetime`) = '$date'";
              }else{
                $sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Sent' AND date(`despatch`.`datetime`) = '$date'";
              }
              $query  = $db2->query($sql);
              return $query->num_rows();
            }

            public function count_emsdespatch_in_received($o_region,$role){
              $db2 = $this->load->database('otherdb', TRUE);
              $tz = 'Africa/Nairobi';
              $tz_obj = new DateTimeZone($tz);
              $today = new DateTime("now", $tz_obj);
              //$date = $today->format('Y-m-d');
              $date='2022-01-01';

              if($role == "RM") {
                $sql = "SELECT * FROM `despatch`
                WHERE `despatch`.`region_to`  = '$o_region' AND `despatch`.`despatch_status`  = 'Received'
                 AND  date(`despatch`.`datetime`) >= '$date'";
              }else{
                $sql = "SELECT * FROM `despatch` WHERE `despatch`.`despatch_status` = 'Received' 
                AND date(`despatch`.`datetime`) >= '$date'";
              }
              $query  = $db2->query($sql);
              return $query->num_rows();
            }

            public function count_todayemsdespatch_in_received($o_region,$role){
              $db2 = $this->load->database('otherdb', TRUE);
              $tz = 'Africa/Nairobi';
              $tz_obj = new DateTimeZone($tz);
              $today = new DateTime("now", $tz_obj);
              $date = $today->format('Y-m-d');
              //$date='2022-01-01';

              if($role == "RM") {
                $sql = "SELECT * FROM   `tracing` 
                INNER JOIN  `transactions` ON  `tracing`.`transid` = `transactions`.`id` 
                INNER JOIN  `bags` ON  `transactions`.`isBagNo` = `bags`.`bag_number`
                WHERE `bags`.`bag_region`  = '$o_region' AND `bags`.`bags_status` = 'isReceived'
                AND  date(`tracing`.`doc`) = '$date' GROUP BY `bags`.`despatch_no`";

              }else{
                $sql = "SELECT * FROM   `tracing`
               INNER JOIN  `transactions` ON  `tracing`.`transid` = `transactions`.`id` 
                INNER JOIN  `bags` ON  `transactions`.`isBagNo` = `bags`.`bag_number`
                WHERE `bags`.`bags_status` = 'isReceived'
                AND  date(`tracing`.`doc`) = '$date' GROUP BY `bags`.`despatch_no`";
              }
              $query  = $db2->query($sql);
              return $query->num_rows();
            }

            public function count_maildespatch_in_received($o_region,$role){

              $db2 = $this->load->database('otherdb', TRUE);
              $tz = 'Africa/Nairobi';
              $tz_obj = new DateTimeZone($tz);
              $today = new DateTime("now", $tz_obj);
              //$date = $today->format('Y-m-d');
              $date='2022-01-01';
          
              if($role == 'RM' || $role == "ACCOUNTANT"){
          
                 $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                             FROM   `despatch_general`
                             INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                             WHERE date(`despatch_general`.`datetime`) >= '$date' AND `despatch_general`.`despatch_status` = 'Received' AND `despatch_general`.`region_to` = '$o_region' 
                             GROUP BY `despatch_general`.`desp_no`";
          
              }else{
          
                $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                             FROM   `despatch_general`
                             INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                             WHERE date(`despatch_general`.`datetime`) >= '$date' AND `despatch_general`.`despatch_status` = 'Received'  GROUP BY `despatch_general`.`desp_no`";
              }
          
              $query  = $db2->query($sql);
              return $query->num_rows();
            }


            public function count_todaymaildespatch_in_received($o_region,$role){

              $db2 = $this->load->database('otherdb', TRUE);
              $tz = 'Africa/Nairobi';
              $tz_obj = new DateTimeZone($tz);
              $today = new DateTime("now", $tz_obj);
              $date = $today->format('Y-m-d');
              //$date='2022-01-01';
          
              if($role == 'RM' || $role == "ACCOUNTANT"){

               
          
                 $sql = "SELECT * FROM   `tracing`
                 INNER JOIN  `register_transactions` ON  `tracing`.`transid` = `register_transactions`.`t_id`
                 INNER JOIN  `bags_mails` ON  `register_transactions`.`isBagNo` = `bags_mails`.`bag_number`
                 WHERE `bags_mails`.`bag_region_to`  = '$o_region' AND `bags_mails`.`bags_status` = 'isReceived'
                 AND  date(`tracing`.`doc`) = '$date' GROUP BY `bags_mails`.`despatch_no`";
          
              }else{
          
                
                $sql = "SELECT * FROM   `tracing`
                INNER JOIN  `register_transactions` ON  `tracing`.`transid` = `register_transactions`.`t_id`
                INNER JOIN  `bags_mails` ON  `register_transactions`.`isBagNo` = `bags_mails`.`bag_number`
                WHERE  `bags_mails`.`bags_status` = 'isReceived'
                AND  date(`tracing`.`doc`) = '$date' GROUP BY `bags_mails`.`despatch_no`";
              }
          
              $query  = $db2->query($sql);
              return $query->num_rows();
            }

            public function count_maildespatch_in($o_region,$role){

              $db2 = $this->load->database('otherdb', TRUE);
              $tz = 'Africa/Nairobi';
              $tz_obj = new DateTimeZone($tz);
              $today = new DateTime("now", $tz_obj);
              //$date = $today->format('Y-m-d');
              $date='2022-01-01';
          
              if($role == 'RM' || $role == "ACCOUNTANT"){
          
                 $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                             FROM   `despatch_general`  
                             INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                             WHERE date(`despatch_general`.`datetime`) >= '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`region_to` = '$o_region' 
                             GROUP BY `despatch_general`.`desp_no`";
          
              }else{
          
                $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                             FROM   `despatch_general`  
                             INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                             WHERE date(`despatch_general`.`datetime`) >= '$date' AND `despatch_general`.`despatch_status` = 'Sent'  GROUP BY `despatch_general`.`desp_no`";
              }
          
              $query  = $db2->query($sql);
              return $query->num_rows();
            }

            
            public function count_yesterdaymaildespatch_in($o_region,$role){

              $db2 = $this->load->database('otherdb', TRUE);
              $tz = 'Africa/Nairobi';
              $tz_obj = new DateTimeZone($tz);
              $today = new DateTime("now", $tz_obj);
              //$date = $today->format('Y-m-d');
              //$date='2022-01-01';
              $date= date('Y-m-d',strtotime("-1 days"));
          
              if($role == 'RM' || $role == "ACCOUNTANT"){
          
                 $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                             FROM   `despatch_general`  
                             INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                             WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`region_to` = '$o_region' 
                             GROUP BY `despatch_general`.`desp_no`";
          
              }else{
          
                $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                             FROM   `despatch_general`  
                             INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                             WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent'  GROUP BY `despatch_general`.`desp_no`";
              }
          
              $query  = $db2->query($sql);
              return $query->num_rows();
            }


             // public function branchselect(){
             //   $this->db->where('status','ACTIVE');
             //  $query = $this->db->get('em_branch');
             //  $result = $query->result();
             //  return $result;
             //  }

             


                public  function get_ems_employee_report($fromdate,$todate){

    $regionfrom = $this->session->userdata('user_region');
    $emid = $this->session->userdata('user_login_id');
    $Region = $this->session->userdata('user_region');
    $Branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
      INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND `sender_info`.`operator` = '$emid'
      AND `sender_info`.`s_region` = '$Region' AND `sender_info`.`s_district` = '$Branch'
      AND `transactions`.`status`='Paid' ORDER BY `sender_info`.`sender_id` DESC";


    }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

      $sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
      INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$Region' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC ";

    }elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER'){
      
      $sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.*
      FROM `sender_info`
      INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`status` = 'Paid' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

    }else{

      $sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.*
      FROM `sender_info`
      INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`status` = 'Paid' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

    }

    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }








             public function Checkintransactions($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `transactions` WHERE `billid` = '$controlno' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

              public function Checkintransactions1($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `register_transactions` WHERE `billid` = '$controlno' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

             public function Checkintransactions2($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `derivery_transactions` WHERE `billid` = '$controlno' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

            public function Checkintransactions3($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `parcel_international_transactions` WHERE  `billid` = '$controlno' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

             public function Checkintransactions4($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `parking_transactions` WHERE  `billid` = '$controlno' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
            public function Checkintransactions5($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `parking_wallet` WHERE `controlno` = '$controlno' ";
              $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

             public function Checkintransactions6($DB,$controlno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `real_estate_transactions` WHERE `billid` = '$controlno' ";
              $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }


             public function Checkintransactions12(){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `parking_wallet` WHERE `controlno` IS NULL LIMIT 0 ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

             public function GetCustomerList($DB){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber`!='NULL' AND `status`!='issent'";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
             public function GetRealEstateCustomerList($DB){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `estate_tenant_information` WHERE `mobile_number`IS NOT NULL AND `mobile_number`!=' '
                      AND `mobile_number` REGEXP '(([^[:digit:]])?[[:digit:]]){9,}'  
                      ORDER BY `estate_tenant_information`.`tenant_id`  DESC";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
            public function GetCustomerListbybox($DB,$boxno){
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL' AND `status`!='issent' AND `PostBoxNumber` LIKE '$boxno'";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

            public function GetAllCustomerList($DB){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsboxnotfy`";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
              public function GetAllCustomerLisWithNumber($DB){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

            public function GetAllCustomerLisWithNumber2($DB){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

            public function GetAllCustomeremsSender(){ 
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `sender_info` WHERE `s_mobile` !='NULL' ";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
           



            public function GetAllCustomerLisWithNumbercountsearch($DB,$name,$mobile,$box){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);

                if(!empty($name) && !empty($mobile) && !empty($box)  )
              {

                $sql = "SELECT COUNT(`id`) as `idadi` FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'
                 AND `PostBoxNumber` = '$box'AND `CustomerName`LIKE '%$name%'
                 AND `MobileNumber` = '$mobile'";

              }
              elseif( !empty($name) && !empty($mobile)  )
              {

                $sql = "SELECT COUNT(`id`) as `idadi`FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'
                 AND `CustomerName` LIKE '%$name%'
                 AND `MobileNumber` = '$mobile'";

              }
              elseif(!empty($name) &&  !empty($box)  )
              {

                $sql = "SELECT COUNT(`id`) as `idadi` FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'
                AND `CustomerName` LIKE '%$name%'
                 AND `PostBoxNumber` = '$box'";

              }
              else
              {
                 $sql = "SELECT COUNT(`id`) as `idadi` FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'  AND `CustomerName` LIKE '%$name%'";
              

              }
                
             
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }


              public function GetAllCustomerLisWithNumbersearch($DB,$name,$mobile,$box){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);

                if(!empty($name) && !empty($mobile) && !empty($box)  )
              {

                $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'
                 AND `PostBoxNumber` = '$box'AND `CustomerName`LIKE '%$name%'
                 AND `MobileNumber` = '$mobile'";

              }
              elseif( !empty($name) && !empty($mobile)  )
              {

                $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'
                 AND `CustomerName` LIKE '%$name%'
                 AND `MobileNumber` = '$mobile'";

              }
              elseif(!empty($name) &&  !empty($box)  )
              {

                $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'
                AND `CustomerName` LIKE '%$name%'
                 AND `PostBoxNumber` = '$box'";

              }
              elseif(!empty($name) )
              {

              $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'  AND `CustomerName` LIKE '%$name%'";

              }
              else
              {
                 $sql = "SELECT * FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'  LIMIT 10";
              

              }
                
             
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
             public function GetRealestateCustomerSms($DB){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsresend` WHERE `servicename` ='Realestate'";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
             public function GetRealestateCustomerSmscount($DB){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT COUNT(`id`) as `idadi`  FROM `smsresend` WHERE  `servicename` ='Realestate'";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
              public function GetAllCustomerLisWithNumbercount($DB){ //smsboxnotfy
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT COUNT(`id`) as `idadi`  FROM `smsboxnotfy` WHERE `MobileNumber` !='NULL'";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }
              public function GetAllCustomerListNONumber($DB){ //smsboxnotfy  COUNT( `id`) as idadi
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT * FROM `smsboxnotfy`WHERE `MobileNumber` IS NULL";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

             public function getcustomer($id){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `smsboxnotfy` WHERE  `id` = '$id' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }

            public function Update_boxcustomer($custom,$id)
    {
      $db2 = $this->load->database('otherdb', TRUE);
      $db2->where('id', $id);
      $db2->update('smsboxnotfy',$custom);
    }


              public function GetAllCustomerListNONumbercount($DB){ //smsboxnotfy  COUNT( `id`) as idadi
              $db2 = $this->load->database('otherdb', TRUE);
                
              $sql = "SELECT COUNT(`id`) as `idadi` FROM `smsboxnotfy`WHERE `MobileNumber` IS NULL";
                $query=$db2->query($sql);
                $result = $query->result();
                return $result;

            }

            public function updatesms($id){
          $db2 = $this->load->database('otherdb', TRUE);
          $db2->set('status', 'issent');
          $db2->where('id', $id);
          $db2->update('smsboxnotfy');
      }

       public function updateNotSentsms(){
          $db2 = $this->load->database('otherdb', TRUE);

          $db2->set('status', 'isNotsent');
           $db2->where('status', 'issent');
          $db2->update('smsboxnotfy');
      }
     
        public function check_payment_International($id,$type){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `transactions` WHERE `id`='$id' AND `PaymentFor` = '$type'";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
        public function get_Internet_list(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            
            $id = $info->em_code;
            
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `Internet`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Internet`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `Internet`.`region` = '$o_region' AND `Internet`.`branch` = '$o_branch' AND `Internet`.`Created_byId` = '$id'  ORDER BY `Internet`.`date_created` DESC";

        }elseif($this->session->userdata('user_type') == 'RM'){
           $sql = "SELECT * FROM `Internet`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Internet`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `Internet`.`region` = '$o_region' AND   ORDER BY `Internet`.`date_created` DESC";

        }else{
           $sql = "SELECT * FROM `Internet`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Internet`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `Internet`.`date_created` DESC";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_General_Paid_Report_list_search1($type,$date,$month,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

            if    (!empty($month) ) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) ) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              else  {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type%'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        } 

          public function get_Paid_Report_list_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

            if    (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type%'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' AND `region` = '$region' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

              elseif (!empty($month) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' AND `region` = '$region' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
            
            else
            {
                      $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' AND `region` = '$region' 
                AND `serial` LIKE '%$type%'  
                ORDER BY `transactiondate` DESC LIMIT 1";
            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        } 

         

      public function get_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);

                 if    ($season == 'Day') {


                 $sql ="SELECT `em_region`.`region_name` AS year,COUNT(`real_estate_transactions`.`serial`) AS value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type2%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) = '$yearday' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) = '$monthday' AND DAY(date(`real_estate_transactions`.`transactiondate`)) = '$dayday' GROUP BY `em_region`.`region_name` ";

                       
            }
            elseif ($season == 'Year') {

                        $sql ="SELECT `em_region`.`region_name` AS year,COUNT(`real_estate_transactions`.`serial`) as value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type2%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) = '$year' 
                        GROUP BY `em_region`.`region_name` ";
           
            }
                elseif ($season == 'MonthBtn') {

                     $sql ="SELECT `em_region`.`region_name` AS year,COUNT(`real_estate_transactions`.`serial`) as value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id `=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type2%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) >= '$monthf' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) <= '$months'
                        GROUP BY `em_region`.`region_name` ";


          

            }elseif ($season == 'DayBtn') 
                    {

                       $sql ="SELECT `em_region`.`region_name` AS year,COUNT(`real_estate_transactions`.`serial`) as value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type2%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND date(`real_estate_transactions`.`transactiondate`)  >= '$Dayfirst' AND date(`real_estate_transactions`.`transactiondate`) <= '$Daysecond' 
                        GROUP BY `em_region`.`region_name` ";

                    }
              else {

                $sql ="SELECT `em_region`.`region_name` AS year,COUNT(`real_estate_transactions`.`serial`) as value,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type2%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) = '$yearelse' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) >= '$dayelse' 
                        GROUP BY `em_region`.`region_name` ";

            }
    


          

                


            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }



      public function get_Daily_Paid_Report_list_Estate_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);

                 if    ($season == 'Day') {


                 $sql ="SELECT `real_estate_transactions`.`transactiondate` AS year,SUM(`real_estate_transactions`.`paidamount`) AS value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) = '$yearday' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) = '$monthday' AND DAY(date(`real_estate_transactions`.`transactiondate`)) = '$dayday' GROUP BY `real_estate_transactions`.`transactiondate` ";

                       
            }
            elseif ($season == 'Year') {

                          $sql ="SELECT `real_estate_transactions`.`transactiondate` AS year,SUM(`real_estate_transactions`.`paidamount`) AS value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) = '$year' 
                        GROUP BY `real_estate_transactions`.`transactiondate` ";
           
            }
                elseif ($season == 'MonthBtn') {

                       $sql ="SELECT `real_estate_transactions`.`transactiondate` AS year,SUM(`real_estate_transactions`.`paidamount`) AS value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) >= '$monthf' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) <= '$months'
                        GROUP BY `real_estate_transactions`.`transactiondate` ";


          

            }elseif ($season == 'DayBtn') 
                    {

                         $sql ="SELECT `real_estate_transactions`.`transactiondate` AS year,SUM(`real_estate_transactions`.`paidamount`) AS value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND date(`real_estate_transactions`.`transactiondate`)  >= '$Dayfirst' AND date(`real_estate_transactions`.`transactiondate`) <= '$Daysecond' 
                        GROUP BY `real_estate_transactions`.`transactiondate` ";

                    }
              else {

                  $sql ="SELECT `real_estate_transactions`.`transactiondate` AS year,SUM(`real_estate_transactions`.`paidamount`) AS value,`real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND YEAR(date(`real_estate_transactions`.`transactiondate`)) = '$yearelse' AND MONTH(date(`real_estate_transactions`.`transactiondate`)) >= '$dayelse' 
                        GROUP BY `real_estate_transactions`.`transactiondate` ";

            }
    


          

                


            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }


        




       public function get_General_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `derivery_info`.`region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearday' AND MONTH(date(`$DB`.`transactiondate`)) = '$monthday' AND DAY(date(`$DB`.`transactiondate`)) = '$dayday' GROUP BY `derivery_info`.`region` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                     $sql = "SELECT `derivery_info`.`region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$year'  GROUP BY `derivery_info`.`region` ";
            }
                elseif ($season == 'MonthBtn') {

                   $sql = "SELECT `derivery_info`.`region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`$DB`.`transactiondate`)) >= '$monthf' AND MONTH(date(`$DB`.`transactiondate`)) <= '$months' GROUP BY `derivery_info`.`region` ";

            }elseif ($season == 'DayBtn') 
                    {

                    $sql = "SELECT `derivery_info`.`region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond'  GROUP BY `derivery_info`.`region` ";

                    }
              else {

             $sql = "SELECT `derivery_info`.`region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearelse'  AND MONTH(date(`$DB`.`transactiondate`)) = '$dayelse' GROUP BY `derivery_info`.`region` ";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 




       public function get_General_Daily_Paid_Report_graph_derivery_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearday' AND MONTH(date(`$DB`.`transactiondate`)) = '$monthday' AND DAY(date(`$DB`.`transactiondate`)) = '$dayday' GROUP BY `$DB`.`transactiondate` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                     $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$year'  GROUP BY `$DB`.`transactiondate` ";
            }
                elseif ($season == 'MonthBtn') {

                  $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid'
            AND YEAR(date(`$DB`.`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`$DB`.`transactiondate`)) >= '$monthf' AND MONTH(date(`$DB`.`transactiondate`)) <= '$months' GROUP BY `$DB`.`transactiondate` ";

            }elseif ($season == 'DayBtn') 
                    {

                   $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid'
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond'  GROUP BY `$DB`.`transactiondate` ";

                    }
              else {

            $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB`
                     INNER JOIN  `derivery_info`  ON   `derivery_info`.`id_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearelse'  AND MONTH(date(`$DB`.`transactiondate`)) = '$dayelse' GROUP BY `$DB`.`transactiondate` ";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 


  public function get_General_Paid_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `sender_person_info`.`sender_region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearday' AND MONTH(date(`$DB`.`transactiondate`)) = '$monthday' AND DAY(date(`$DB`.`transactiondate`)) = '$dayday' GROUP BY `sender_person_info`.`sender_region` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                      $sql = "SELECT `sender_person_info`.`sender_region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$year'  GROUP BY `sender_person_info`.`sender_region` ";
            }
                elseif ($season == 'MonthBtn') {

                    $sql = "SELECT `sender_person_info`.`sender_region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`$DB`.`transactiondate`)) >= '$monthf' AND MONTH(date(`$DB`.`transactiondate`)) <= '$months' GROUP BY `sender_person_info`.`sender_region` ";

            }elseif ($season == 'DayBtn') 
                    {

                     $sql = "SELECT `sender_person_info`.`sender_region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond'  GROUP BY `sender_person_info`.`sender_region` ";

                    }
              else {

               $sql = "SELECT `sender_person_info`.`sender_region` AS year,COUNT(`$DB`.`serial`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' AND `$DB`.`serial` LIKE '%$type2%'
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearelse'  AND MONTH(date(`$DB`.`transactiondate`)) = '$dayelse' GROUP BY `sender_person_info`.`sender_region` ";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 




         public function get_General_Paid_Daily_Report_graph_person_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' 
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearday' AND MONTH(date(`$DB`.`transactiondate`)) = '$monthday' AND DAY(date(`$DB`.`transactiondate`)) = '$dayday' GROUP BY `$DB`.`transactiondate` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                       $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' 
            AND YEAR(date(`$DB`.`transactiondate`)) = '$year'  GROUP BY `$DB`.`transactiondate` ";
            }
                elseif ($season == 'MonthBtn') {

                    $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' 
            AND YEAR(date(`$DB`.`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`$DB`.`transactiondate`)) >= '$monthf' AND MONTH(date(`$DB`.`transactiondate`)) <= '$months' GROUP BY `$DB`.`transactiondate`";

            }elseif ($season == 'DayBtn') 
                    {

                     $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' 
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond'  GROUP BY `$DB`.`transactiondate` ";

                    }
              else {

               $sql = "SELECT `$DB`.`transactiondate` AS year,SUM(`$DB`.`paidamount`) as value FROM `$DB` 
                     INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`
            WHERE `$DB`.`status` = 'Paid' 
            AND YEAR(date(`$DB`.`transactiondate`)) = '$yearelse'  AND MONTH(date(`$DB`.`transactiondate`)) = '$dayelse' GROUP BY `$DB`.`transactiondate` ";


            }
    
            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 




          public function get_General_Paid_Report_docCollection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

            $db2 = $this->load->database('otherdb', TRUE);
            if($region=='ALL'){
            $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND  `PaymentFor` = 'EMS' AND `PaymentFor` != 'EMSBILLING' AND `PaymentFor` != 'EMS_INTERNATIONAL'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  GROUP BY `region` ";
            }else{
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
          WHERE `status` = '$status' AND  `PaymentFor` = 'EMS' AND `PaymentFor` != 'EMSBILLING' AND `PaymentFor` != 'EMS_INTERNATIONAL'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond' AND
            `region`='$region' GROUP BY `region` ";
            }

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        } 

         public function get_General_Paid_Report_Collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

            $db2 = $this->load->database('otherdb', TRUE);
            if($region=='ALL'){
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `PaymentFor` = '$type2'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
            }else{
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `PaymentFor` = '$type2'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond' AND
            `region`='$region'  ";
            }

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        } 

        public function get_General_Paid_Report_Consolidated_search($branch,$type2,$DB,$Dayfirst,$Daysecond,$status){

          $db2 = $this->load->database('otherdb', TRUE);
         
             $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
          WHERE `status` = '$status' AND `PaymentFor` = '$type2'
          AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond' AND
          `district`='$branch'";          

          $query=$db2->query($sql);
          $result = $query->row();
          return $result;
          
          
      } 


      public function get_EMS_General_Paid_Consolidated_report($region,$type2,$Dayfirst,$Daysecond,$status){

          $db2 = $this->load->database('otherdb', TRUE);
         
             $sql = "SELECT 
             SUM(`paidamount`) AS Totalamount,
             (SUM(`paidamount`) * 0.18) AS TotalVATamount,
             (SUM(`paidamount`) - (SUM(`paidamount`) * 0.18)) AS TotalExclamount,
             COUNT(`serial`) as Itemno,PaymentFor,region,district,status FROM `transactions`
             WHERE `status` IN ('Paid','Bill')
             AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond' AND

             `region`='$region' group by region,district,PaymentFor,status ";

              // WHERE `status` = '$status'

          // echo $sql;die();   

          $query=$db2->query($sql);
          $result = $query->result_array();
          return $result;
          
          
      } 


      public function get_EMS_General_Paid_Consolidated_branch_report($branch,$type2,$Dayfirst,$Daysecond,$status){

        $db2 = $this->load->database('otherdb', TRUE);
       
           $sql = "SELECT 
           SUM(`paidamount`) AS Totalamount,
           (SUM(`paidamount`) * 0.18) AS TotalVATamount,
           (SUM(`paidamount`) - (SUM(`paidamount`) * 0.18)) AS TotalExclamount,
           COUNT(`serial`) as Itemno,PaymentFor,region,district,status FROM `transactions`
           WHERE `status` IN ('Paid','Bill')
           AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond' AND

           `district`='$branch' group by district,PaymentFor,status ";

            // WHERE `status` = '$status'

        // echo $sql;die();   

        $query=$db2->query($sql);
        $result = $query->result_array();
        return $result;
        
        
    } 



        
        public function get_General_Parking_Paid_Report_Collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){
         
          $db2 = $this->load->database('otherdb', TRUE);
          if($region=='ALL'){
             $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
          WHERE `status` = '$status'
          AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
          }else{
            if($region=="Dar es salaam"){
              $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
              WHERE `status` = '$status'
              AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";

            }else{
             $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
          WHERE `status` = 'Notavailable' 
          AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
            }
          }

          $query=$db2->query($sql);
          $result = $query->row();
          return $result;
          
          
      } 


      
      public function get_General_Parking_Paid_Report_Consolidated_search($branch,$type2,$DB,$Dayfirst,$Daysecond,$status){
         
        $db2 = $this->load->database('otherdb', TRUE);
  
          if($branch=="GPO"){
            $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";

          }else{
           $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
        WHERE `status` = 'Notavailable' 
        AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
          }
        

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
        
        
    } 

        public function getRegionID($region){
          $db2 = $this->load->database('otherdb', TRUE);
				
          $sql = "SELECT * FROM `em_region` WHERE `region_name`='$region'";
            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
    
          }

          public function getBranchID($branch){
            $db2 = $this->load->database('otherdb', TRUE);
          
            $sql = "SELECT * FROM `em_branch` WHERE `branch_name`='$branch'";
              $query=$db2->query($sql);
              $result = $query->row();
              return $result;
      
            }


        public function get_Paid_Report_list_Estate_collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

          $db2 = $this->load->database('otherdb', TRUE);
         
          if($region=='ALL'){

            $sql ="SELECT COUNT(`real_estate_transactions`.`serial`) AS Itemno,SUM(`partial_payment`.`amount`) AS Totalamount   
             FROM `real_estate_transactions` 
             inner JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
            inner JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
              inner JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
              inner JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
             WHERE `estate_information`.`estate_type` LIKE '%$type2%'
             AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
             AND date(`partial_payment`.`date_created`) >= '$Dayfirst' 
             AND date(`partial_payment`.`date_created`) <= '$Daysecond' ";
   
          }else{
            $regions=$this->getRegionID($region);
            $region=$regions->region_id;
            $sql ="SELECT COUNT(`real_estate_transactions`.`serial`) AS Itemno,SUM(`partial_payment`.`amount`) AS Totalamount  
            FROM `real_estate_transactions` 
            inner JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
            inner JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
             inner JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
             inner JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
            WHERE `estate_information`.`estate_type` LIKE '%$type2%'
            AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
            AND date(`partial_payment`.`date_created`) >= '$Dayfirst' 
            AND date(`partial_payment`.`date_created`) <= '$Daysecond' 
            AND `estate_information`.`region`='$region' ";
            }

          $query=$db2->query($sql);
          if($query !== false)
          {
              $result = $query->row();
              return $result;
          }
          else
          {
              return false;
          }
          //$result = $query->row();
          //return $result;
          
          
      } 


      public function get_Paid_Report_list_Estate_consolidated_search($branch,$type2,$DB,$Dayfirst,$Daysecond,$status){

        $db2 = $this->load->database('otherdb', TRUE);
      
          $branchs=$this->getBranchID($branch);
          $branchid=$branchs->branch_id;
          $sql ="SELECT COUNT(`real_estate_transactions`.`serial`) AS Itemno,SUM(`partial_payment`.`amount`) AS Totalamount  
          FROM `real_estate_transactions` 
          inner JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
          inner JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
           inner JOIN `em_region` ON `em_region`.`region_id`=`estate_information`.`region`
           inner JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
          WHERE `estate_information`.`estate_type` LIKE '%$type2%'
          AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
          AND date(`partial_payment`.`date_created`) >= '$Dayfirst' 
          AND date(`partial_payment`.`date_created`) <= '$Daysecond' 
          AND `estate_information`.`district`='$branchid' ";
         

        $query=$db2->query($sql);
        if($query !== false)
        {
            $result = $query->row();
            return $result;
        }
        else
        {
            return false;
        }
        //$result = $query->row();
        //return $result;
        
        
    } 

         public function get_General_mail_cash_Paid_Report_Collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

            $db2 = $this->load->database('otherdb', TRUE);
            if($region=='ALL'){ 
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `serial` LIKE '%$type2%' AND `bill_status` = 'SUCCESS'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
            }else{
               $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
               INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
            WHERE `$DB`.`status` = '$status' AND `$DB`.`serial` LIKE '%$type2%' AND `$DB`.`bill_status` = 'SUCCESS'
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
            `sender_person_info`.`sender_region`='$region'  ";
            }

            $query=$db2->query($sql);
            if($query !== false)
            {
                $result = $query->row();
                return $result;
            }
            else
            {
                return false;
            }
            //$result = @$query->row();
           
            
            
        } 

        public function get_General_mail_cash_Paid_Report_Consolidated_search($branch,$type2,$DB,$Dayfirst,$Daysecond,$status){

          $db2 = $this->load->database('otherdb', TRUE);
        
             $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
             INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
          WHERE `$DB`.`status` = '$status' AND `$DB`.`serial` LIKE '%$type2%' AND `$DB`.`bill_status` = 'SUCCESS'
          AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
          `sender_person_info`.`sender_branch`='$branch'  ";
        

          $query=$db2->query($sql);
          if($query !== false)
          {
              $result = $query->row();
              return $result;
          }
          else
          {
              return false;
          }
          //$result = @$query->row();
         
          
          
      } 


          public function get_General_mail_delivery_Paid_Report_Collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status,$type){

            $db2 = $this->load->database('otherdb', TRUE);
            if($region=='ALL'){ //WHERE cast((product_id/10000) as int) = 110301  
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `serial` LIKE '%$type2%' AND `bill_status` = 'SUCCESS' AND (`paidamount` DIV '$type') = 'SUCCESS'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
            }else{
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `serial` LIKE '%$type2%' AND `bill_status` = 'SUCCESS'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond' AND
            `region`='$region'  ";
            }

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        } 

        
        public function get_General_mail_cash_BARCODE_Paid_Report_Consolidated_search($branch,$type2,$DB,$Dayfirst,$Daysecond,$status){

          $db2 = $this->load->database('otherdb', TRUE);
          

            $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
             INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
          WHERE `$DB`.`status` = '$status' AND `$DB`.`Barcode` LIKE '$type2%' AND `$DB`.`serial` LIKE '%register%' AND `$DB`.`bill_status` = 'SUCCESS'
          AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
          `sender_person_info`.`sender_branch`='$branch'  ";


          
          $query=$db2->query($sql);
          if($query !== false)
          {
              $result = $query->row();
              return $result;
          }
          else
          {
              return false;
          }
          
          
      } 


        public function get_General_mail_cash_BARCODE_Paid_Report_Collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

            $db2 = $this->load->database('otherdb', TRUE);
            if($region=='ALL'){ 
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `Barcode` LIKE '$type2%' AND `$DB`.`serial` LIKE '%register%' AND `bill_status` = 'SUCCESS'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
            }else{

              $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
               INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
            WHERE `$DB`.`status` = '$status' AND `$DB`.`Barcode` LIKE '$type2%' AND `$DB`.`serial` LIKE '%register%' AND `$DB`.`bill_status` = 'SUCCESS'
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
            `sender_person_info`.`sender_region`='$region'  ";


              
            }

            
            $query=$db2->query($sql);
            if($query !== false)
            {
                $result = $query->row();
                return $result;
            }
            else
            {
                return false;
            }
            
            
        } 

        public function get_General_mail_bill_Paid_Report_Collection_search_mail($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

          $db2 = $this->load->database('otherdb', TRUE);
          if($region=='ALL'){ 
             $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
          WHERE `status` = '$status' AND `PaymentFor` = '%$type2%' 
          AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
          }else{

            $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
             INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
          WHERE `$DB`.`status` = '$status' AND `PaymentFor` = '%$type2%'
          AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
          `sender_person_info`.`sender_region`='$region'  ";

          }

          $query=$db2->query($sql);
          if($query !== false)
          {
              $result = $query->row();
              return $result;
          }
          else
          {
              return false;
          }
          
          
      } 


         public function get_General_mail_bill_Paid_Report_Collection_search($region,$type2,$DB,$Dayfirst,$Daysecond,$status){

            $db2 = $this->load->database('otherdb', TRUE);
            if($region=='ALL'){ 
               $sql = "SELECT SUM(`paidamount`) AS Totalamount,COUNT(`serial`) as Itemno FROM `$DB`
            WHERE `status` = '$status' AND `serial` LIKE '%$type2%' AND `bill_status` = 'BILLING'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  ";
            }else{

              $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
               INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
            WHERE `$DB`.`status` = '$status' AND `$DB`.`serial` LIKE '%$type2%' AND `$DB`.`bill_status` = 'BILLING'
            AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
            `sender_person_info`.`sender_region`='$region'  ";

            }

            $query=$db2->query($sql);
            if($query !== false)
            {
                $result = $query->row();
                return $result;
            }
            else
            {
                return false;
            }
            
            
        } 

        public function get_General_mail_bill_Paid_Report_Consolidated_search($branch,$type2,$DB,$Dayfirst,$Daysecond,$status)
        {

          $db2 = $this->load->database('otherdb', TRUE);
          

            $sql = "SELECT SUM(`$DB`.`paidamount`) AS Totalamount,COUNT(`$DB`.`serial`) as Itemno FROM `$DB`
             INNER JOIN  `sender_person_info`  ON   `sender_person_info`.`senderp_id`   = `$DB`.`register_id`  
          WHERE `$DB`.`status` = '$status' AND `$DB`.`serial` LIKE '%$type2%' AND `$DB`.`bill_status` = 'BILLING'
          AND date(`$DB`.`transactiondate`) >= '$Dayfirst' AND date(`$DB`.`transactiondate`) <= '$Daysecond' AND
          `sender_person_info`.`sender_branch`='$branch'  ";


          $query=$db2->query($sql);
          if($query !== false)
          {
              $result = $query->row();
              return $result;
          }
          else
          {
              return false;
          }
          
          
      } 



          public function get_General_Paid_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) = '$yearday' AND MONTH(date(`transactiondate`)) = '$monthday' AND DAY(date(`transactiondate`)) = '$dayday' GROUP BY `region` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                      $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) = '$year'  GROUP BY `region` ";
            }
                elseif ($season == 'MonthBtn') {

                    $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`transactiondate`)) >= '$monthf' AND MONTH(date(`transactiondate`)) <= '$months' GROUP BY `region` ";

            }elseif ($season == 'DayBtn') 
                    {

                       $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  GROUP BY `region` ";

                    }
              else {

                $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) = '$yearelse'  AND MONTH(date(`transactiondate`)) = '$dayelse' GROUP BY `region` ";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 



          public function get_General_Paid_Daily_Report_graph_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid'  AND `receipt` IS NOT NULL
            AND YEAR(date(`transactiondate`)) = '$yearday' AND MONTH(date(`transactiondate`)) = '$monthday' AND DAY(date(`transactiondate`)) = '$dayday' GROUP BY date(`transactiondate`) ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                       $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `receipt` IS NOT NULL
            AND YEAR(date(`transactiondate`)) = '$year'  GROUP BY date(`transactiondate`) ";
            }
                elseif ($season == 'MonthBtn') {

                    $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `receipt` IS NOT NULL
            AND YEAR(date(`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`transactiondate`)) >= '$monthf' AND MONTH(date(`transactiondate`)) <= '$months' GROUP BY date(`transactiondate`) ";

            }elseif ($season == 'DayBtn') 
                    {

                       $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `receipt` IS NOT NULL
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  
            GROUP BY date(`transactiondate`) ";

                    }
              else {

                $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `receipt` IS NOT NULL
            AND YEAR(date(`transactiondate`)) = '$yearelse'  AND MONTH(date(`transactiondate`)) = '$dayelse' GROUP BY date(`transactiondate`) ";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 

          public function get_General_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) = '$yearday' AND MONTH(date(`transactiondate`)) = '$monthday' AND DAY(date(`transactiondate`)) = '$dayday' GROUP BY `transactiondate` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                      $sql = "SELECT COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) = '$year'  GROUP BY `transactiondate` ";
            }
                elseif ($season == 'MonthBtn') {

                    $sql = "SELECT COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`transactiondate`)) >= '$monthf' AND MONTH(date(`transactiondate`)) <= '$months' GROUP BY `transactiondate` ";

            }elseif ($season == 'DayBtn') 
                    {

                       $sql = "SELECT COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  GROUP BY `transactiondate` ";

                    }
              else {

                $sql = "SELECT COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'
            AND YEAR(date(`transactiondate`)) = '$yearelse'  AND MONTH(date(`transactiondate`)) = '$dayelse' GROUP BY `transactiondate`";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 


         public function get_General_Daily_Paid_Report_graph_noregion_search($season,$type2,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' 
            AND YEAR(date(`transactiondate`)) = '$yearday' AND MONTH(date(`transactiondate`)) = '$monthday' AND DAY(date(`transactiondate`)) = '$dayday' GROUP BY `transactiondate` ";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {
            $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' 
            AND YEAR(date(`transactiondate`)) = '$year'  GROUP BY `transactiondate` ";
            }
                elseif ($season == 'MonthBtn') {

                   $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' 
            AND YEAR(date(`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`transactiondate`)) >= '$monthf' AND MONTH(date(`transactiondate`)) <= '$months' GROUP BY `transactiondate` ";

            }elseif ($season == 'DayBtn') 
                    {

                       $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' 
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  GROUP BY `transactiondate` ";

                    }
              else {

               $sql = "SELECT `transactiondate` AS year,SUM(`paidamount`) as value FROM `$DB`
            WHERE `status` = 'Paid' 
            AND YEAR(date(`transactiondate`)) = '$yearelse'  AND MONTH(date(`transactiondate`)) = '$dayelse' GROUP BY `transactiondate`";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 

 public function get_General_Paid_Report_graph_double_search($season,$type2,$type1,$DB,$yearday,$monthday,$dayday,$Dayfirst,$Daysecond,$year,$yearMonthBtn,$monthf,$months,$yearelse,$dayelse){

            $db2 = $this->load->database('otherdb', TRUE);
               

            if    ($season == 'Day') {
                     $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%' OR `serial` LIKE '%$type1%'
            AND YEAR(date(`transactiondate`)) = '$yearday' AND MONTH(date(`transactiondate`)) = '$monthday' AND DAY(date(`transactiondate`)) = '$dayday' GROUP BY `region`";
            //ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif ($season == 'Year') {

                      $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'  OR `serial` LIKE '%$type1%'
            AND YEAR(date(`transactiondate`)) = '$year'  GROUP BY `region`";
            }
                elseif ($season == 'MonthBtn') {

                    $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'  OR `serial` LIKE '%$type1%'
            AND YEAR(date(`transactiondate`)) <= '$yearMonthBtn' AND MONTH(date(`transactiondate`)) >= '$monthf' AND MONTH(date(`transactiondate`)) <= '$months' GROUP BY `region`LIMIT 1";

            }elseif ($season == 'DayBtn') 
                    {

                       $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'  OR `serial` LIKE '%$type1%'
            AND date(`transactiondate`) >= '$Dayfirst' AND date(`transactiondate`) <= '$Daysecond'  GROUP BY `region`";

                    }
              else {

                $sql = "SELECT `region` AS year,COUNT(`serial`) as value FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type2%'  OR `serial` LIKE '%$type1%'
            AND YEAR(date(`transactiondate`)) = '$yearelse'  AND MONTH(date(`transactiondate`)) = '$dayelse' GROUP BY `region`";


            }
    
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        } 


         public function get_General_Paid_Report_list_search($type,$from,$to,$month,$DB,$year){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year2 = @$month1[1];

            if    (!empty($month)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year2' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
            elseif    (!empty($year)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' 
                AND `serial` LIKE '%$type%' 
                AND YEAR(`transactiondate`) = '$year' 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($from) && !empty($to) ) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) >='$from') AND  ( (`transactiondate`) <='$to') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              else {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' AND `serial` LIKE '%$type%'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

                 
            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        } 

        public function get_UNPaid_Report_list_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                 if  (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' AND `serial` LIKE '%$type%'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
                 elseif (!empty($date) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' AND `region` = '$region' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

              elseif (!empty($month) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' AND `region` = '$region' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
            
            else
            {
                      $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' AND `serial` LIKE '%$type%' 
                AND `region` = '$region' 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }

            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }


          public function get_General_UNPaid_Report_list_search($type,$from,$to,$month,$DB,$year){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year2 = @$month1[1];

                 if  (!empty($month) ) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' 
                AND `serial` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year2' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
             elseif  (!empty($year) ) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' 
                AND `serial` LIKE '%$type%' 
               AND YEAR(`transactiondate`) = '$year' 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($from) && !empty($to) ) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' 
            AND `serial` LIKE '%$type%' 
            AND  ( (`transactiondate`) >='$from') AND  ( (`transactiondate`) <='$to')  
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              else  {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' AND `serial` LIKE '%$type%'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              


            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
  public function get_Paid_Report_list_for_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

            if    (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' 
                AND `PaymentFor` = '$type' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' 
            AND `PaymentFor` = '$type' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' AND `PaymentFor` = '$type'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` = 'Paid' AND `region` = '$region' 
            AND `PaymentFor` = '$type' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

              elseif (!empty($month) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' AND `region` = '$region' 
                AND `PaymentFor` LIKE '%$type%' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
            
            else
            {
                      $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` = 'Paid' AND `region` = '$region' 
                AND `PaymentFor` = '$type'  
                ORDER BY `transactiondate` DESC LIMIT 1";
            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
        public function get_UNPaid_Report_list_for_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                 if  (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' 
                AND `PaymentFor` = '$type'
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' 
            AND `PaymentFor` = '$type' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' AND `PaymentFor` = '$type'
            ORDER BY `transactiondate` DESC LIMIT 1";

            }
                 elseif (!empty($date) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
            WHERE `status` != 'Paid' AND `region` = '$region' 
            AND `PaymentFor` = '$type' 
            AND  ( (`transactiondate`) = '$date%') 
            ORDER BY `transactiondate` DESC LIMIT 1";

            }

              elseif (!empty($month) && !empty($region)) {
                     $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' AND `region` = '$region' 
                AND `PaymentFor` = '$type' 
                AND  ( MONTH(`transactiondate`) = '$month2' AND YEAR(`transactiondate`) = '$year' ) 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }
            
            else
            {
                      $sql = "SELECT SUM(`paidamount`) AS amount FROM `$DB`
                WHERE `status` != 'Paid' AND `PaymentFor` = '$type'
                AND `region` = '$region' 
                ORDER BY `transactiondate` DESC LIMIT 1";
            }

            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
       

  public function get_Paid_Report_list_Sender_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];


            if    (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                       
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {

                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                      
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_info`.`s_region` = '$region'
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }

              elseif (!empty($month) && !empty($region)) {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                      
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_info`.`s_region` = '$region'
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
            
            else
            {
                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                      
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_info`.`s_region` = '$region'
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
        public function get_UNPaid_Report_list_Sender_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                if    (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                      
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                     
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {

                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_info`.`s_region` = '$region'
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }

              elseif (!empty($month) && !empty($region)) {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                       
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_info`.`s_region` = '$region'
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
            
            else
            {
                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `$DB`.`CustomerID`=`sender_info`.`sender_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_info`.`s_region` = '$region'
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }


            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
       

        public function get_Paid_Report_list_Estate_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];


            if    (!empty($month) && empty($region)) {
                     $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND  ( MONTH(`real_estate_transactions`.`transactiondate`) = '$month2' AND YEAR(`real_estate_transactions`.`transactiondate`) = '$year' )                    
                       group by `real_estate_transactions`.`billid`
                         ";// HAVING `real_estate_transactions`.`paidamount` <= SUM( `partial_payment`.`amount`)
            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND  (`real_estate_transactions`.`transactiondate`) = '$date%')                    
                       group by `real_estate_transactions`.`billid`
                         ";
                

            }
              elseif (empty($region)) {

                 $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)                  
                       group by `real_estate_transactions`.`billid`";

            }

                 elseif (!empty($date) && !empty($region)) {

                     $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                        AND `estate_information`.`region` = '$region'
                        AND  ( (`real_estate_transactions`.`transactiondate`) = '$date%')                 
                       group by `real_estate_transactions`.`billid`";


            }

              elseif (!empty($month) && !empty($region)) {

                 $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                        AND `estate_information`.`region` = '$region'
                         AND  ( MONTH(`real_estate_transactions`.`transactiondate`) = '$month2' AND YEAR(`real_estate_transactions`.`transactiondate`) = '$year' )                
                       group by `real_estate_transactions`.`billid`";

            }
            
            else
            {
                 $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                        AND `estate_information`.`region` = '$region'
                       group by `real_estate_transactions`.`billid`";

            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }




        public function get_General_Paid_Report_list_Estate_search($from,$to,$month,$DB,$year){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year2 = @$month1[1];


            if    (!empty($month) ) {
                     $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE  ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND  ( MONTH(`real_estate_transactions`.`transactiondate`) = '$month2' AND YEAR(`real_estate_transactions`.`transactiondate`) = '$year2' )                    
                       group by `real_estate_transactions`.`billid`
                         ";// HAVING `real_estate_transactions`.`paidamount` <= SUM( `partial_payment`.`amount`)
            }

             elseif    (!empty($year) ) {
                     $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE  ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND  (  YEAR(`real_estate_transactions`.`transactiondate`) = '$year' )                    
                       group by `real_estate_transactions`.`billid`
                         ";// HAVING `real_estate_transactions`.`paidamount` <= SUM( `partial_payment`.`amount`)
            }
                 elseif (!empty($from) && !empty($to) ) {
                     
            $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE  ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                 AND  ( (`real_estate_transactions`.`transactiondate`) >='$from') AND  ( (`real_estate_transactions`.`transactiondate`) <='$to')                    
                       group by `real_estate_transactions`.`billid`
                         ";
                

            }
              else {

                 $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)                  
                       group by `real_estate_transactions`.`billid`";

            }

                

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }



        

        public function get_General_UNPaid_Report_list_Estate_search($from,$to,$month,$DB,$year){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year2 = @$month1[1];

                if    (!empty($month)) {
                     $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                        AND  ( MONTH(`real_estate_transactions`.`transactiondate`) = '$month2' AND YEAR(`real_estate_transactions`.`transactiondate`) = '$year2' ) 
                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";


            }
            elseif    (!empty($year) ) {
                     $sql ="SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE  ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`)
                        AND  (  YEAR(`real_estate_transactions`.`transactiondate`) = '$year' )                    
                       group by `real_estate_transactions`.`billid`
                         HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";
            }
                 elseif (!empty($from) && !empty($to)  ) {
                     
            $sql =  "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                       AND  ( (`real_estate_transactions`.`transactiondate`) >='$from') AND  ( (`real_estate_transactions`.`transactiondate`) <='$to')  
                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";

                         

            }
              else{

                 $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";

                

            }

               
            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }
       


        public function get_UNPaid_Report_list_Estate_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                if    (!empty($month) && empty($region)) {
                     $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                        AND  ( MONTH(`real_estate_transactions`.`transactiondate`) = '$month2' AND YEAR(`real_estate_transactions`.`transactiondate`) = '$year' ) 
                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";


            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql =  "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                       AND  ( (`real_estate_transactions`.`transactiondate`) = '$date%')
                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";

                         

            }
              elseif (empty($region)) {

                 $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";

                

            }

                 elseif (!empty($date) && !empty($region)) {

                     $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                       AND  ( (`real_estate_transactions`.`transactiondate`) = '$date%')
                         AND `estate_information`.`region` = '$region'

                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";


                    
            }

              elseif (!empty($month) && !empty($region)) {

                 $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                         AND  ( MONTH(`real_estate_transactions`.`transactiondate`) = '$month2' AND YEAR(`real_estate_transactions`.`transactiondate`) = '$year' ) 
                         AND `estate_information`.`region` = '$region'

                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";



            }
            
            else
            {
                 $sql = "SELECT `real_estate_transactions`.`paidamount` ,`partial_payment`.`amount`   FROM `real_estate_transactions` 
                      LEFT JOIN `estate_contract_information` ON `real_estate_transactions`.`tenant_id`=`estate_contract_information`.`tenant_id`
                        LEFT JOIN `estate_information` ON `estate_information`.`estate_id`=`estate_contract_information`.`estate_id`
                        LEFT JOIN `partial_payment` ON `partial_payment`.`controlno`=`real_estate_transactions`.`billid`
                       WHERE `estate_information`.`estate_type` LIKE '%$type%'
                       AND ( `real_estate_transactions`.`billid` = `partial_payment`.`controlno`) 
                         AND `estate_information`.`region` = '$region'

                       group by `real_estate_transactions`.`billid`
                          HAVING `real_estate_transactions`.`paidamount` > SUM( `partial_payment`.`amount`)";


            }


            $query = $db2->query($sql);
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


        public function get_Paid_Report_list_Sender_person_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];


            if    (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                       LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                WHERE `transactions`.`status` = 'Paid' 
                AND `transactions`.`serial` LIKE '%$type%' 
                ORDER BY `transactions`.`transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {

                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_person_info`.`sender_region` = '$region'
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }

              elseif (!empty($month) && !empty($region)) {

                  $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_person_info`.`sender_region` = '$region'
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
            
            else
            {
  $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_person_info`.`sender_region` = '$region'
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }

          public function get_General_Paid_Report_list_Sender_person_search($type,$date,$month,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];


            if(!empty($month) ) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              else {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `sender_info` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                       LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

               

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
        public function get_UNPaid_Report_list_Sender_person_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                if    (!empty($month) && empty($region)) {
                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {

                $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {

                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_person_info`.`sender_region` = '$region'
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }

              elseif (!empty($month) && !empty($region)) {

               $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_person_info`.`sender_region` = '$region'
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
            
            else
            {
                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `sender_person_info`.`sender_region` = '$region'
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }


            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }

           public function get_General_UNPaid_Report_list_Sender_person_search($type,$date,$month,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                if(!empty($month) ) {
                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
                }
                 elseif(!empty($date) )  {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              else {

                $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `sender_person_info` ON `$DB`.`register_id`=`sender_person_info`.`senderp_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }

     public   function like_match($pattern, $subject)
      {
          $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
          return (bool) preg_match("/^{$pattern}$/i", $subject);
      }

        public function get_sender($db,$trackno){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `$db` WHERE `track_number`='$trackno'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

    public function get_sender_barcode($db,$Barcode){  
    $db2 = $this->load->database('otherdb', TRUE);
     $sql = "SELECT * FROM `$db`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`$db`.`sender_id`
      WHERE `transactions`.`Barcode` = '$Barcode' ";

     $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

   public function get_sender_person_barcode($db,$Barcode){  
    $db2 = $this->load->database('otherdb', TRUE);
     $sql = "SELECT * FROM `$db`
      LEFT JOIN `register_transactions` ON `register_transactions`.`register_id`=`$db`.`senderp_id`
      WHERE `register_transactions`.`Barcode` = '$Barcode' ";

     $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }


    public function get_senderbyID($db,$id){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `$db` WHERE `senderp_id`='$id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

   public function get_senderbyIDs($db,$id){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `$db` WHERE `id_id`='$id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

   public function get_senderINFObyID($db,$id){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `$db` WHERE `sender_id`='$id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

   public function get_receiver($db2,$sender_id){

    $db2 = $this->load->database('otherdb', TRUE);
     $sender_id= @$sender_id;
    $sql    = "SELECT * FROM `receiver_register_info` WHERE `sender_id` LIKE  CONVERT('$sender_id', UNSIGNED)";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
   public function get_receiverINFO($db2,$sender_id){

    $db2 = $this->load->database('otherdb', TRUE);
     $sender_id= @$sender_id;
    $sql    = "SELECT * FROM `receiver_info` WHERE `from_id` LIKE  CONVERT('$sender_id', UNSIGNED)";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
  
       


    public function get_Paid_Report_list_derivery_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];


            if    (!empty($month) && empty($region)) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                     LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                     LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `transactions`.`status` = 'Paid' 
                AND `transactions`.`serial` LIKE '%$type%' 
                ORDER BY `transactions`.`transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {

                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                     LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `derivery_info`.`region` = '$region'
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }

              elseif (!empty($month) && !empty($region)) {

                  $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND `derivery_info`.`region` = '$region'
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
            
            else
            {
  $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                     LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `derivery_info`.`region` = '$region'
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

            // $query = $db2->query($sql);
            // $result = $query->result();
            // return $result;

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }



         public function get_General_Paid_Report_list_derivery_search($type,$from,$to,$month,$DB,$year){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year2 = @$month1[1];


            if    (!empty($month) ) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year2' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
             elseif (!empty($year) ) {
                     $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  (  YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($from) && !empty($to)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                     LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`transactiondate`) >='$from') AND  ( (`transactiondate`) <='$to')  
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              else{

                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                     LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` = 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

                 

             

            $query=$db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }


        public function get_UNPaid_Report_list_derivery_search($type,$date,$month,$region,$DB){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year = @$month1[1];

                if    (!empty($month) && empty($region)) {
                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }


                 elseif (!empty($date) && empty($region)) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              elseif (empty($region)) {

                $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

                 elseif (!empty($date) && !empty($region)) {

                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND `derivery_info`.`region` = '$region'
                 AND  ( (`$DB`.`transactiondate`) = '$date%') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }

              elseif (!empty($month) && !empty($region)) {

               $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `derivery_info`.`region` = '$region'
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
            
            else
            {
                 $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND `derivery_info`.`region` = '$region'
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }


            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
       


        public function get_General_UNPaid_Report_list_derivery_search($type,$from,$to,$month,$DB,$year){

            $db2 = $this->load->database('otherdb', TRUE);
                $month1 = explode('-', $month);
                $month2 = @$month1[0];
                $year2 = @$month1[1];

                if    (!empty($month)) {
                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( MONTH(`$DB`.`transactiondate`) = '$month2' AND YEAR(`$DB`.`transactiondate`) = '$year2' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
              elseif    (!empty($year)) {
                      $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                AND  ( YEAR(`$DB`.`transactiondate`) = '$year' ) 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";
            }
                 elseif (!empty($from) && !empty($to) ) {
                     
            $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                       LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                 AND  ( (`transactiondate`) >='$from') AND  ( (`transactiondate`) <='$to') 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }
              else {

                $sql = "SELECT SUM(`$DB`.`paidamount`) AS amount FROM `$DB`
                      LEFT JOIN `derivery_info` ON `$DB`.`register_id`=`derivery_info`.`id_id`
                WHERE `$DB`.`status` != 'Paid' 
                AND `$DB`.`serial` LIKE '%$type%' 
                ORDER BY `$DB`.`transactiondate` DESC LIMIT 1";

            }

                 

            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
       


    public function getBillGepgBillId_International($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId){

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

    public  function get_item_received_list_international(){
        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        $id = $this->session->userdata('user_login_id');
                $info = $this->GetBasic($id);
                $o_region = $info->em_region;
                $o_branch = $info->em_branch;

        if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Received' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`bag_status` = 'isNotBag' AND `sender_info`.`s_district` = '$o_branch'
            ORDER BY `sender_info`.`sender_id` DESC ";

        }else{

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`bag_status` = 'isNotBag' AND `transactions`.`office_name` = 'Received'  ORDER BY `sender_info`.`sender_id` DESC";

        }
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


}
?>