<?php

class Necta_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    
        public function Save_Receiver_Info($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('heslb_receiver_info',$data);
        }

        public function update_sender_international($last_id,$data){

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->where('hesld_id',$last_id);
            $db2->update('heslb_sender_info',$data);
        }


        public function get_bulk_necta_list(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
               $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `transactions`.`paidamount` != 0 AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM"){

                $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
              LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`paidamount` != 0 AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

               $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
              LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `transactions`.`paidamount` != 0 AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

                    $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
              LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND `transactions`.`paidamount` != 0  ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;

            
        }//

        public function get_necta_list(){

            $db2 = $this->load->database('otherdb', TRUE);

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $date = date('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {
               
               $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `transactions`.`paidamount` != 0 AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC";

            }elseif($this->session->userdata('user_type') == "RM"){

                $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`paidamount` != 0 AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date'
            ORDER BY `sender_info`.`sender_id` DESC ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `transactions`.`paidamount` != 0 AND date(`sender_info`.`date_registered`) = '$date' ORDER BY `sender_info`.`sender_id` DESC ";

            }else {

                    $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`rnumber`,`sender_info`.`add_type`,`ems_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`  
            
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND `transactions`.`paidamount` != 0  ORDER BY `sender_info`.`sender_id` DESC";

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;

            
        }//LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`

        public function get_necta_search($date,$month,$status){

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
                   
                   $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM"){

                if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`ems_tariff_category`.`cat_name`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;

            
        }

  public function get_bulk_necta_search($date,$month,$status){

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
                   
                   $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
           LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM"){

                if (!empty($date)) {
                   
                    $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                   $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
           LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
                    $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                   $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
           LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

            if (!empty($date)) {
                   
            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
           LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE  `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            } else {

            $sql = "SELECT `sender_info`.`s_fullname`,`date_registered`,`s_region`,`weight`,`track_number`,`ems_type`,`sender_info`.`add_type`,`receiver_info`.`r_region`,`transactions`.`paidamount`,`status`,`office_name`,`billid` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
           LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }

             $query = $db2->query($sql);
             $result = $query->result();
             return $result;

            
        }

        public function get_sum_necta_search($date,$month,$status){

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
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM"){

                if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

                    if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE  `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC ";

            }

            }

             $query = $db2->query($sql);
             $result = $query->row();
             return $result;

            
        }
        

          public function get_bulk_sum_necta_search($date,$month,$status){

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
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
             LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND `sender_info`.`operator` = '$id' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }
               

            }elseif($this->session->userdata('user_type') == "RM"){

                if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
             LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                  $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR" ){

                 if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
             LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

            }

            }else {

                    if (!empty($date)) {
                   
                   $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
             LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE  `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC";

               } else {

                 $sql = "SELECT `sender_info`.*,`receiver_info`.*,SUM(`transactions`.`paidamount`) AS paidamount FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`PaymentFor` = 'NECTA' AND `transactions`.`office_name` = 'Counter' AND MONTH(`sender_info`.`date_registered`) = '$mon' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = '$status' AND `transactions`.`paidamount` != 0
            ORDER BY `sender_info`.`sender_id` DESC ";

            }

            }

             $query = $db2->query($sql);
             $result = $query->row();
             return $result;

            
        }
        
        public function get_bulk_necta_sum(){

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
             LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`paidamount` != 0";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`paidamount` != 0";


            }elseif($this->session->userdata('user_type') == "RM"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status`= 'Paid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`paidamount` != 0";

            }else{

               $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                     FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`serial`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'NECTA'  AND `transactions`.`paidamount` != 0"; 

            }

            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
        } //LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`s_address`


 public function get_necta_sum(){

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
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `sender_info`.`operator` = '$id' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`paidamount` != 0";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`paidamount` != 0";


            }elseif($this->session->userdata('user_type') == "RM"){

                $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                    FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status`= 'Paid' AND `transactions`.`PaymentFor` = 'NECTA' AND `sender_info`.`s_region` = '$o_region' AND date(`sender_info`.`date_registered`) = '$date' AND `transactions`.`paidamount` != 0";

            }else{

               $sql = "SELECT  SUM(`transactions`.`paidamount`) AS `paidamount`
                     FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 

            WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'NECTA'  AND `transactions`.`paidamount` != 0"; 

            }

            $query = $db2->query($sql);
            $result = $query->row();
            return $result;
        } //LEFT JOIN `transactions` ON `transactions`.`serial`=`sender_info`.`s_address`



public function getBillPaymentUpdate($serial,$amount){
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
        //print_r($response.$error);
        curl_close ($ch);
        $result = json_decode($response);
        
        @$serial1 = @$result->billid;
        
         if (@$result->status == "102") {
          echo "Mussa1" ;
         } elseif (@$result->receipt == '' && @$result->status == "103") {
           // echo "Saida";
            $paid = "NotPaid";
            $db2->set('receipt', @$result->receipt);
            $db2->set('paychannel', @$result->channel);
            $db2->set('status', $paid);
            $db2->where('serial', @$serial1);
            $db2->update('transactions');
            

      } else{
            
            //echo "Hamrish";
            $paid = "Paid";
            $db2->set('receipt', @$result->receipt);
            $db2->set('paychannel', @$result->channel);
            $db2->set('paymentdate', @$result->paydate);
            $db2->set('status', $paid);
            $db2->where('serial', @$serial1);
            $db2->update('transactions');
        }
}

}
?>