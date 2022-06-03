<?php

class Ems_Cargo_model extends CI_Model{


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

    public function ems_cargo_price_check100($weight100){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `ems_cargo_tarrif` WHERE  `weight` >= '$weight100' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_ems_cargo_list(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

           $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;
            
        }


        public function get_ems_cargo_sum(){

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
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date'";


            }elseif($this->session->userdata('user_type') == "RM"|| $this->session->userdata('user_type') == "ACCOUNTANT"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status`= 'Paid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date'";

            }else{

               $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                     FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND date(`sender_info`.`date_registered`) = '$date'"; 

            }
            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
        }

        public function get_ems_cargo_search($date,$month,$status){

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
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

                if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
           $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'EMS-CARGO' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`s_district`,`weight`,`track_number`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid`,`paychannel`,`Barcode` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;

        }

        public function get_ems_cargo_sum_search($date,$month,$status){

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
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

                if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'EMS-CARGO' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'EMS-CARGO' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }

            }

             $query = $db2->query($sql);
             $result = $query->row();
             return $result;

            
        }
}
?>