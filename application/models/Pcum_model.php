<?php

class Pcum_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    public function ems_cargo_price_check($weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `ems_cargo_tarrif` WHERE  `weight` >= '$weight' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_customer_info($custId){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `pcum_bill` WHERE  `pcum_id` = '$custId'";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_bill_customer_list(){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `pcum_bill`";
        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;
    }
     public function get_pcum_bill_cust_details_info($pcum_id){

    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `pcum_bill` WHERE `pcum_id` = '$pcum_id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

    public function get_Pcum_Bill_Customer_by_id($id){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `pcum_bill` WHERE `pcum_id` = '$id'";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function ems_cargo_price_check100($weight100){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `ems_cargo_tarrif` WHERE  `weight` >= '$weight100' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function save_pcum_customer($data){

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('pcum_bill',$data);
    }

     public function update_pcum_customer($data,$pcum_id)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('pcum_id', $pcum_id);
        $db2->update('pcum_bill',$data);
    }

    public function get_pcum_list(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,s_pay_type,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,s_pay_type,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,s_pay_type,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

           $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,`weight`,s_pay_type,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'PCUM' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }

        public function pcum_bill_transactions(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE  `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

           $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`service_type` = 'PCUM' ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }

         public function pcum_sum_bill_transactions(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE  `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

           $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`service_type` = 'PCUM' ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }

        public function pcum_bill_transactions_by_customer($I){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE  `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

           $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }

          public function pcum_bill_sum_transactions_by_customer($I){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE  `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

           $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`

            WHERE `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }


        public function pcum_bill_transactions_search($date,$month){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
           
            $month1 = explode('-', $month);

                $mon = @$month1[0];
                $year = @$month1[1];


            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC";

            }

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region'  AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'  ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`amount`,`service_type`,`receiver_info`.`branch`,`receiver_info`.`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC";

            }
            
        }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }
        public function pcum_bill_transactions_search_by_customer($date,$month,$I){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
           
            $month1 = explode('-', $month);

                $mon = @$month1[0];
                $year = @$month1[1];


            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region'  AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`bill_cust_acc` = '$I'  ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`bill_cust_acc` = '$I'  ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if ($date) {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,s_pay_type,`amount`,`service_type`,`receiver_info`.`branch`,`fullname`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }
            
        }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }
        public function get_pcum_bill_sum_search($date,$month){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
           
            $month1 = explode('-', $month);

                $mon = @$month1[0];
                $year = @$month1[1];


            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC";

            }

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region'  AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'   ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' ORDER BY `sender_info`.`sender_id` DESC";

            }
            
        }

             $query = $db2->query($sql);
             $result = $query->row();
             return $result;
            
        }

        public function get_pcum_bill_sum_search_by_customer($date,$month,$I){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
           
            $month1 = explode('-', $month);

                $mon = @$month1[0];
                $year = @$month1[1];


            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'  AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region'  AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date'  AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'  AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date'  AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'  AND `sender_info`.`bill_cust_acc` = '$I'   ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if ($date) {

            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date'  AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            } else {
                
            $sql = "SELECT SUM(`sender_info`.`amount`) AS `total`,`receiver_info`.`branch`
            FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            WHERE `sender_info`.`service_type` = 'PCUM' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year'  AND `sender_info`.`bill_cust_acc` = '$I' ORDER BY `sender_info`.`sender_id` DESC";

            }
            
        }

             $query = $db2->query($sql);
             $result = $query->row();
             return $result;
            
        }

        public function get_pcum_transList($fromdate,$todate,$status){
            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                 $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` 
                 FROM `sender_info`
                 LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'PCUM' AND `sender_info`.`operator` = '$id' ";



                if (!empty($fromdate) && !empty($todate)) {
                    $sql.= " AND date(`sender_info`.`date_registered`) between '$fromdate' and '$todate' ";
                }

                if($status) $sql .="AND `transactions`.`status` = '$status' ";
                $sql .= "ORDER BY `sender_info`.`sender_id` DESC";

            }else{

                $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` 
                 FROM `sender_info`
                 LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
                WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'PCUM' ";



                if (!empty($fromdate) && !empty($todate)) {
                    $sql.= " AND date(`sender_info`.`date_registered`) between '$fromdate' and '$todate' ";
                }

                if($status) $sql .="AND `transactions`.`status` = '$status' ";
                $sql .= "ORDER BY `sender_info`.`sender_id` DESC";

            }

            //echo $sql;die();


            $query = $db2->query($sql);
             $result = $query->result();
             return $result;

        }

        public function get_pcum_transListSum($fromdate="",$todate=""){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            //$date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

            $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' ";


                if (!empty($fromdate) && !empty($todate)) {
                    $sql.= " AND date(`sender_info`.`date_registered`) between '$fromdate' and '$todate' ";
                }

                //if($status) $sql .="AND `transactions`.`status` = '$status' ";
                //$sql .= "ORDER BY `sender_info`.`sender_id` DESC";

            }else{
                
                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' ";


                if (!empty($fromdate) && !empty($todate)) {
                    $sql.= " AND date(`sender_info`.`date_registered`) between '$fromdate' and '$todate' ";
                }
            }


            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
        }

        public function get_pcum_sum(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

            $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'";


            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status`= 'Paid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'";

            }else{

               $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                     FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'PCUM' AND date(`sender_info`.`date_registered`) = '$date'"; 

            }
            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
        }

        public function get_pcum_search($date,$month,$status){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            //$date = date('Y-m-d');

            $month1 = explode('-', $month);

                $mon = @$month1[0];
                $year = @$month1[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
               if (!empty($date)) {  
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

                if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,s_pay_type,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
           $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,s_pay_type,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,`s_district`,`weight`,s_pay_type,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`operator`,`date_registered`,`s_region`,s_pay_type,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`add_type` as receiverboxtype,`receiver_info`.`fullname`,`receiver_info`.`branch`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`id`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;

        }

        public function get_pcum_sum_search($date,$month,$status){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            //$date = date('Y-m-d');

            $month1 = explode('-', $month);

                $mon = @$month1[0];
                $year = @$month1[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
               if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

                if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'PCUM' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'PCUM' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }

            }

             $query = $db2->query($sql);
             $result = $query->row();
             return $result;

            
        }
}
?>