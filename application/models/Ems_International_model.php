<?php

class Ems_International_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    
        public function Save_Receiver_Info($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_international',$data);
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
        public function update_sender_international($last_id,$data){

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->where('sender_id',$last_id);
            $db2->update('sender_international',$data);
        }
        public function check_payment_International($id,$type){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `transactions` WHERE `id`='$id' AND `PaymentFor` = '$type'";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
        public function get_ems_international_list(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR") {

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            } else {

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC";

                
            }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_ems_international_list_search($date,$month,$region){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

                $month1 = explode('-', $month);
                

                $day = @$month1[0];
                $year = @$month1[1];


            if (empty($date)) {
                
                if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }
            if ($this->session->userdata('user_type') == "ACCOUNTANT"  || $this->session->userdata('user_type') == "RM" ) {

                  $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Counter' AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `sender_info`.`s_region` = '$o_region' ORDER BY `sender_info`.`sender_id` DESC";

            }


            else {

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Counter' AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `sender_info`.`s_region` = '$region' ORDER BY `sender_info`.`sender_id` DESC";
            }
            } else {
               
               if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND  date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }

             if ($this->session->userdata('user_type') == "ACCOUNTANT"  || $this->session->userdata('user_type') == "RM" ) {

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Counter' AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$o_region'  ORDER BY `sender_info`.`sender_id` DESC";

             }



            else {

                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Counter' AND  date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`s_region` = '$region'  ORDER BY `sender_info`.`sender_id` DESC";
            }
            }
            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }

            public function get_ems_international_Search_list_search($barcode){

            $db2 = $this->load->database('otherdb', TRUE);


                $sql = "SELECT `sender_info`.`serial` AS barcodes,`sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' 
                          AND (`sender_info`.`serial` = '$barcode' OR `transactions`.`billid` = '$barcode'
                       OR `transactions`.`Barcode` = '$barcode') ORDER BY `sender_info`.`sender_id` DESC";
            
            
            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }

         public function get_ems_international_search_sum_sarch($barcode){

            $db2 = $this->load->database('otherdb', TRUE);

           
                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                    FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    INNER JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' 
                             AND (`sender_info`.`serial` = '$barcode' OR `transactions`.`billid` = '$barcode'
                       OR `transactions`.`Barcode` = '$barcode') ORDER BY `sender_info`.`sender_id` DESC";
            
            
            $query = $db2->query($sql);
            $result = $query->row();
            return $result;

        }


        public function get_ems_international_sum_sarch($date,$month,$region){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

                $month1 = explode('-', $month);
                

                $day = @$month1[0];
                $year = @$month1[1];


            if (empty($date)) {
                
                if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }

             if ($this->session->userdata('user_type') == "ACCOUNTANT"  || $this->session->userdata('user_type') == "RM" ) {

                  $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `transactions`.`office_name` = 'Counter'";

             }


            else {

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$region'  AND  (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' ) AND `transactions`.`office_name` = 'Counter'";

            }
            } else {
               
               if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND  date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND  date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter' ORDER BY `sender_info`.`sender_id` DESC";

            }

            if ($this->session->userdata('user_type') == "ACCOUNTANT"  || $this->session->userdata('user_type') == "RM" ) {

                  $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter'";

            }


            else {

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    INNER JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$region'  AND  date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter'";
                
            }
            }
            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
            
            
        }
        public function get_ems_international_back_list(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
                $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

            } else {

                $sql = "SELECT `sender_info`.*,
                    `receiver_info`.*,`transactions`.*,`country_zone`.*
                    FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id`
                    LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
                    WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

                
            }
                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }

         public function get_ems_international_back_list_Search($date,$month,$region){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $today = $today->format('Y-m-d');

            $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == 'SUPERVISOR') {

            if(!empty($date)){

                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'  AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

           
                # code...
            }else{
                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'
            AND  MONTH(`sender_info`.`date_registered`) = '$day' AND  YEAR(`sender_info`.`date_registered`) = '$year' 
              AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

            
            }
        }elseif($this->session->userdata('user_type') == 'RM'){


                if(!empty($date)){

                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region'  AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

           
                # code...
            }else{
                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' 
            AND  MONTH(`sender_info`.`date_registered`) = '$day' AND  YEAR(`sender_info`.`date_registered`) = '$year' 
              AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

            }




            }else{

                if(!empty($date) && !empty($region)){
                     $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$region'  AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

           
            }else{
                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.*,`country_zone`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            LEFT JOIN `country_zone` ON `country_zone`.`country_id` = `receiver_info`.`r_region`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$region' 
            AND  MONTH(`sender_info`.`date_registered`) = '$day' AND  YEAR(`sender_info`.`date_registered`) = '$year' 
              AND `transactions`.`office_name` = 'Back' ORDER BY `sender_info`.`sender_id` DESC";

            }
        }
 
            

           
                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
 }


        public function get_ems_international_sum(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id'";

               }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`office_name` = 'Counter'";

               }elseif($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT"){

                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter'";
                }else{
                $sql = "SELECT SUM(`transactions`.`paidamount`) AS `paidamount` 
                            FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id` = `sender_info`.`sender_id`
                    LEFT JOIN `transactions` ON `transactions`.`CustomerID` = `sender_info`.`sender_id` WHERE `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `transactions`.`status` = 'Paid' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date'";
               }
            

                    $query = $db2->query($sql);
                    $result = $query->row();
                    return $result;
        }


        public  function get_pending_task_international($emid){

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
            WHERE (`transactions`.`status` = 'NotPaid' OR `transactions`.`office_name` = 'Counter') AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$emid'
            ORDER BY `sender_info`.`sender_id` DESC ";

        $query=$db2->query($sql);
        $result = $query->result();
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

    public  function get_ems_bags_international_list(){
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
            $sql = "SELECT * FROM `bags` WHERE `bags`.`bag_region_from` = '$o_region' AND `bags`.`bag_branch_from` = '$o_branch' AND `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) = '$date' AND `ems_category` = 'International' ORDER BY `bags`.`date_created` DESC";
        }else{
            $sql = "SELECT * FROM `bags` WHERE  `bags`.`bags_status` = 'notDespatch' AND date(`bags`.`date_created`) = '$date' AND `ems_category` = 'International' ORDER BY `bags`.`date_created` DESC";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_despatch_out_list_international(){

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
            WHERE `despatch`.`region_from`  = '$o_region' AND `despatch`.`branch_from`  = '$o_branch' AND  date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'International' ORDER BY `despatch`.`datetime` DESC";

        }else{

            $sql = "SELECT *
            FROM `despatch` WHERE date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'International' ORDER BY `despatch`.`datetime` DESC";

        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_despatch_in_list_international(){

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
            FROM `despatch` WHERE region_to  = '$o_region' AND branch_to = '$o_branch' AND date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'International'
            ORDER BY `despatch`.`desp_id` DESC";
        }else{
            $sql = "SELECT `despatch`.*
            FROM `despatch` WHERE date(`despatch`.`datetime`) = '$date' AND `despatch_type` = 'International'
            ORDER BY `despatch`.`desp_id` DESC";
        }


        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }
}
?>