<?php

class Unregistered_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
   public function unregistered_cat_price($type,$weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `register_tariff` WHERE `register_type`='$type' AND `tariff` >= '$weight' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
  public function get_bag_number_mails($last_id){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `sender_person_info` WHERE `senderp_id`='$last_id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
   public function get_despatch_number_mails($bagsNo){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `bags_mails` WHERE `bag_number`='$bagsNo'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
    public function parcel_post_land_cat_price($type,$weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `inland_parcel_post` WHERE `item_type`='$type' AND `weight_step` >= $weight LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function parcel_post_water_cat_price($type,$weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `port_parcel_post` WHERE `item_type`='$type' AND `weight_step` >= $weight LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function food_item_price($weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `food_items_price` WHERE  `weight_step` >= '$weight' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function nonfood_item_price($weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `non_food_items_price` WHERE  `weight_step` >= '$weight' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }  
    public function nonweighed_item_price($item,$tarrif){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `nonweighed_price` WHERE  `item_type` = '$item' AND `tarrif_type` = '$tarrif'";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }  
    public function small_packet_cat_price($type,$weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `small_packet_tarrif` WHERE `tarrif_type`='$type' AND `weight_step` >= '$weight' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    } 
  public function save_mails_bags($save){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('bags_mails',$save);
    } 
    public function save_despatch_number($love){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('despatch_general',$love);
    } 
  public function save_delivery_infomation($save){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('deriver_info',$save);
    } 
  public function save_despatch_info_mails($data){

    $db2 = $this->load->database('otherdb', TRUE);
    $db2->insert('mails_despatch',$data);
  }
  public function checkValueRegister($controlno){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `register_transactions` WHERE `billid`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function checkValueDerivery($controlno){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `derivery_transactions` WHERE `billid`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_dest_region($id){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id` WHERE `sender_person_info`.`senderp_id`= '$id'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_delivery_info($id){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT `sender_person_info`.*,`deriver_info`.*
                   FROM   `deriver_info`  
                   INNER JOIN  `sender_person_info` ON  `sender_person_info`.`senderp_id` = `deriver_info`.`sender_id` WHERE `sender_person_info`.`senderp_id`= '$id'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_bag_destination_region($id){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM   `bags_mails` WHERE `bags_mails`.`bag_id`= '$id'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_despatch_number_by_date($rec_region,$branch_to){

      $date = date('Y-m-d');
      $o_region = $this->session->userdata('user_region');
      $o_branch = $this->session->userdata('user_branch');

      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM   `despatch_general` WHERE `despatch_general`.`region_to`= '$rec_region' AND `despatch_general`.`branch_to`= '$branch_to' AND date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`branch_origin` = '$o_branch'";

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function get_bag_number_by_date($rec_region,$rec_branch){

      $tz = 'Africa/Nairobi';
      $tz_obj = new DateTimeZone($tz);
      $today = new DateTime("now", $tz_obj);
      $date = $today->format('Y-m-d');      
      $o_region = $this->session->userdata('user_region');
      $o_branch = $this->session->userdata('user_branch');

      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM   `bags_mails` WHERE `bags_mails`.`bag_region_to`= '$rec_region' AND `bags_mails`.`bag_branch_to`= '$rec_branch' AND date(`bags_mails`.`date_created`) = '$date' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bag_branch_origin` = '$o_branch'";

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
    public function update_register_transactions($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('billid', $serial);
        $db2->update('register_transactions',$update);         
    }
    public function update_bags_info($update,$id){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('bag_id', $id);
        $db2->update('bags_mails',$update);         
    }
    public function update_register_transactions1($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('serial', $serial);
        $db2->update('register_transactions',$update);         
    } 
    public function update_delivery_transactions($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('serial', $serial);
        $db2->update('derivery_transactions',$update);         
    }
    public function update_delivery_transactions1($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('billid', $serial);
        $db2->update('derivery_transactions',$update);         
    } 
  public function update_sender_info($last_id,$trackno){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('senderp_id', $last_id);
        $db2->update('sender_person_info',$trackno);         
    }
    public function update_bag_info($upbag,$bagsNo){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('bag_number', $bagsNo);
        $db2->update('bags_mails',$upbag);         
    }
    public function update_despatch_info($updes,$despno){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('desp_no', $despno);
        $db2->update('despatch_general',$updes);         
    }
     public function get_despatch_list(){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');
            $service_type = $this->session->userdata('service_type');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`branch_origin` = '$o_branch' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`service_type` = '$service_type'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`service_type` = '$service_type'";

            }else{

              $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`service_type` = '$service_type'";
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

    public function get_despatch_in_list(){

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

              $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`branch_to` = '$o_branch'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`region_to` = '$o_region' ";

            }else{

              $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' ";
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }
    public function get_number_of_bags(){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');
            $service_type = $this->session->userdata('service_type');


            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bag_branch_origin` = '$o_branch' AND `bags_mails`.`bags_status` = 'notDespatch' AND `bags_mails`.`service_category` = '$service_type'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bag_branch_origin` = '$o_branch' AND `bags_mails`.`bags_status` = 'notDespatch' AND `bags_mails`.`service_category` = '$service_type'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bags_status` = 'notDespatch' AND `bags_mails`.`service_category` = '$service_type'";

            }else{

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bags_status` = 'notDespatch' AND `bags_mails`.`service_category` = '$service_type'";
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_bags_list_by_despatch($despno){

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

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`bag_region_to` = '$o_region' AND `bags_mails`.`bag_branch_to` = '$o_branch' AND `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`bag_region_to` = '$o_region' AND `bags_mails`.`bag_branch_to` = '$o_branch' AND `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`bag_region_to` = '$o_region' AND `bags_mails`.`bag_branch_to` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";

            }else{

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_bags_list_by_despatch_out($despno){

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

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bag_branch_origin` = '$o_branch' AND `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bag_branch_origin` = '$o_branch' AND `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";

            }else{

              $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE  `bags_mails`.`despatch_no` = '$despno' AND `bags_mails`.`service_category` = '$service_type'";
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }
    public function get_number_of_bags_search($date,$month,$status){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');
            $service_type = $this->session->userdata('service_type');

             $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];


    if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bags_status` = '$status' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`bag_branch_origin` = '$o_branch' AND `bags_mails`.`service_category` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE (MONTH(`bags_mails`.`date_created`) = '$day' AND YEAR(`bags_mails`.`date_created`) = '$year') AND `bags_mails`.`bags_status` = '$status' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`service_category` = '$service_type'";

              }

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

              if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bags_status` = '$status' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`service_category` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE (MONTH(`bags_mails`.`date_created`) = '$day' AND YEAR(`bags_mails`.`date_created`) = '$year') AND `bags_mails`.`bags_status` = '$status' AND `bags_mails`.`bag_origin_region` = '$o_region' AND `bags_mails`.`service_category` = '$service_type'";

              }

            }else{


              if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE date(`bags_mails`.`date_created`)= '$date' AND `bags_mails`.`bags_status` = '$status' AND `bags_mails`.`service_category` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `sender_person_info` 
                      WHERE `bags_mails`.`bag_number` = `sender_person_info`.`sender_bag_number`) AS `item_number`
                      FROM `bags_mails` WHERE (MONTH(`bags_mails`.`date_created`) = '$day' AND YEAR(`bags_mails`.`date_created`) = '$year') AND `bags_mails`.`bags_status` = '$status' AND `bags_mails`.`service_category` = '$service_type'";

              }
              
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_despatch_out_search($date,$month,$status){

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

               $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`branch_origin` = '$o_branch' AND `despatch_general`.`service_type` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE (MONTH(`despatch_general`.`datetime`) = '$day' AND YEAR(`despatch_general`.`datetime`) = '$year') AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`branch_origin` = '$o_branch' AND `despatch_general`.`service_type` = '$service_type'";

              }

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

            if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`service_type` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE (MONTH(`despatch_general`.`datetime`) = '$day' AND YEAR(`despatch_general`.`datetime`) = '$year') AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`service_type` = '$service_type'";

              }

            }else{

              
            if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`service_type` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                     WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE (MONTH(`despatch_general`.`datetime`) = '$day' AND YEAR(`despatch_general`.`datetime`) = '$year') AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`service_type` = '$service_type'";

              }

                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

    public function get_despatch_in_search($date,$month,$status){

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

               $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`branch_to` = '$o_branch' AND `despatch_general`.`service_type` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE (MONTH(`despatch_general`.`datetime`) = '$day' AND YEAR(`despatch_general`.`datetime`) = '$year') AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`branch_to` = '$o_branch' AND `despatch_general`.`service_type` = '$service_type'";

              }

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

            if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                    
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`service_type` = '$service_type'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE (MONTH(`despatch_general`.`datetime`) = '$day' AND YEAR(`despatch_general`.`datetime`) = '$year') AND `despatch_general`.`despatch_status` = '$status' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`service_type` = '$service_type'";

              }

            }else{

              
            if (!empty($date)) {

               $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                      WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE date(`despatch_general`.`datetime`)= '$date' AND `despatch_general`.`despatch_status` = '$status'";

              } else {

                $sql = "SELECT *, (SELECT COUNT(*) FROM `bags_mails` 
                     WHERE `bags_mails`.`despatch_no` = `despatch_general`.`desp_no`) AS `item_number`
                      FROM `despatch_general` WHERE (MONTH(`despatch_general`.`datetime`) = '$day' AND YEAR(`despatch_general`.`datetime`) = '$year') AND `despatch_general`.`despatch_status` = '$status'";

              }

                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }      
   public function get_register_application_list(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = 'Register' ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Register'  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Register' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Register' ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 
public function get_small_packets_application_list(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = 'Small-Packets' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date'  AND `sender_person_info`.`sender_type` = 'Small-Packets' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Small-Packets' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Small-Packets' ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_posts_cargo_application_list(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = 'Posts-Cargo' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date'  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Posts-Cargo' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Posts-Cargo' ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 
public function get_posts_cargo_application()
{
   $db2 = $this->load->database('otherdb', TRUE);

             $sql    = "SELECT `posts_cargo`.*
                   FROM   `posts_cargo`  
                    ORDER BY `posts_cargo`.`id` DESC";

  
        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         

}

public function get_posts_cargo_application23($serial)
{
   $db2 = $this->load->database('otherdb', TRUE);

             $sql    = "SELECT `posts_cargo`.*
                   FROM   `posts_cargo`  
                    WHERE `posts_cargo`.`serial` = '$serial' ORDER BY `posts_cargo`.`id` DESC";

  
        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         

}

  public function get_posts_cargo_application_listed(){
            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');
            $db2 = $this->load->database('otherdb', TRUE);

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* 
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 

                   WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%' GROUP BY `transactions`.`serial`
                      AND `sender_info`.`s_region` = '$o_region' 
                       AND `sender_info`.`s_district` = '$o_branch'
                     ORDER BY `transactions`.`id` DESC LIMIT 0"; 

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* 
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 

                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%' GROUP BY `transactions`.`serial`
                      AND `sender_info`.`s_region` = '$o_region' 
                       AND `sender_info`.`s_district` = '$o_branch'
                     ORDER BY `transactions`.`id` DESC LIMIT 0"; 

                 

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 

                   -- INNER JOIN  `posts_cargo`  ON   `transactions`.`serial`   = `posts_cargo`.`serial` 
                     WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%' GROUP BY `transactions`.`serial`
                      AND `sender_info`.`s_region` = '$o_region' 
                     ORDER BY `transactions`.`id` DESC LIMIT 0"; 

                 
            }else{

                $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%' GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC LIMIT 0";

               



            }

         

           

                     // ,`posts_cargo`.* INNER JOIN  `posts_cargo`  ON   `transactions`.`serial`   = `posts_cargo`.`serial`




                     /*  $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Posts-Cargo' ORDER BY `sender_person_info`.`sender_date_created` DESC";*/

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
      }


    public function get_parcel_post_application_list(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date'  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function search_application_list($date,$month,$region,$branch,$status){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');


        
        
        $dates =  $date;

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

             $month3 = $day;
             

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post'
                  AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post'
                  AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region'AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{



                  if(!empty($date) && !empty($month) && !empty($region)  )
    {


       $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

                   


    }
    elseif( !empty($month) && !empty($region)  )
    {

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

       $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    else
    {

       $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }





               
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

     public function search_application_list_small_packets($date,$month,$status,$branch){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

     public function get_parcel_post_sum_search($date,$month,$region,$branch,$status){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

             $dates =  $date;

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

             $month3 = $day;
             

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status'ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

               if(!empty($date) && !empty($month) && !empty($region)  )
    {


       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

                   


    }
    elseif( !empty($month) && !empty($region)  )
    {

       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    else
    {

        $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  `sender_person_info`.`sender_type` = 'Parcels-Post' AND `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }





               
                
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 
    public function get_small_packets_sum_search($date,$month,$status,$branch){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = 'Small-Packets' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 
     public function search_application_list_posts_cargos($date,$month,$status,$branch){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                    $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                    AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'  AND `sender_info`.`operator` = '$emid' AND `transactions`.`status` = '$status'
                    AND (date(`sender_info`.`date_registered`) = '$date')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";



                } else {

                    $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                    AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'  AND `sender_info`.`operator` = '$emid' AND `transactions`.`status` = '$status'
                    AND (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";


                  

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                  $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                    AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'   AND `transactions`.`status` = '$status'
                    AND (date(`sender_info`.`date_registered`) = '$date')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";

                  

                } else {

                   $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                    AND `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch'  AND `transactions`.`status` = '$status'
                    AND (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";
                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                    $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                    AND `sender_info`.`s_region` = '$o_region'   AND `transactions`.`status` = '$status'
                    AND (date(`sender_info`.`date_registered`) = '$date')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";


                 

                } else {

                   $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                    AND `sender_info`.`s_region` = '$o_region'   AND `transactions`.`status` = '$status'
                    AND (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";


                 

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                      AND `transactions`.`status` = '$status'
                    AND (date(`sender_info`.`date_registered`) = '$date')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";


                  

                } else {

                    $sql    = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
                   FROM   `sender_info`  
                   INNER JOIN  `receiver_info` ON  `receiver_info`.`from_id` = `sender_info`.`sender_id`
                   INNER JOIN  `transactions`  ON   `sender_info`.`serial`   = `transactions`.`serial` 
                  
                    WHERE `transactions`.`status` != 'OldPaid' AND `transactions`.`serial` LIKE '%CARGO%'

                      AND `transactions`.`status` = '$status'
                    AND (MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year')

                     GROUP BY `transactions`.`serial` 
                     ORDER BY `transactions`.`id` DESC";


                 

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function search_application_list_posts_cargo($date,$month,$status,$branch){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function search_register_application_list($date,$month,$status,$branch,$region){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

        if(!empty($date) && !empty($month) && !empty($region)  )
        {
           $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id` 

                WHERE `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' 
                AND `sender_person_info`.`sender_region` = '$region'
                AND  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')
                 AND (date(`sender_person_info`.`sender_date_created`) = '$date')

                   ORDER BY `sender_person_info`.`sender_date_created` DESC";


            

        }
        elseif( !empty($month) && !empty($region)  )
        {

           $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id` 

                WHERE `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' 
                AND `sender_person_info`.`sender_region` = '$region'
                AND  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')
               

                   ORDER BY `sender_person_info`.`sender_date_created` DESC";


        }
        elseif(!empty($date) &&  !empty($region)  )
        {

           $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id` 

                WHERE `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' 
                AND `sender_person_info`.`sender_region` = '$region'
               
                 AND (date(`sender_person_info`.`sender_date_created`) = '$date')

                   ORDER BY `sender_person_info`.`sender_date_created` DESC";


        }
        else
        {

          $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id` 

                WHERE `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' 
                AND `sender_person_info`.`sender_region` = '$region'
                   ORDER BY `sender_person_info`.`sender_date_created` DESC";


        }


               
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

    public function get_register_sum_search($date,$month,$status,$branch,$region){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];
            $service_type = $this->session->userdata('service_type');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = 'Register' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }
    public function get_register_application_search_back($date,$month,$status){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];
            $service_type = $this->session->userdata('service_type');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }  
    public function get_post_cargo_sum_search($date,$month,$status,$branch){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $m = explode('-', $month);
            $day = @$m[0];
            $year = @$m[1];

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

              if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = 'Posts-Cargo' AND `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 
    public function get_parcel_post_delivery_application_list(){

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

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                   WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' AND `derivery_info`.`operator` = '$emid' ORDER BY `derivery_info`.`datetime` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' ORDER BY `derivery_info`.`datetime` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$o_region' AND date(`derivery_info`.`datetime`) = '$date' ORDER BY `derivery_info`.`datetime` DESC";

            }else{

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE  date(`derivery_info`.`datetime`) = '$date' ORDER BY `derivery_info`.`datetime` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }


     public function get_parcel_post_delivery_application_Searchlist($dates,$month,$status,$region){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');




                //$dates = $date;//->format('Y-m-d');
    //$date1 = $this->session->userdata('date');
        $d1date = date('d',strtotime($dates));
        $m1date = date('m',strtotime($dates));
        $y1date = date('Y',strtotime($dates));
        
        $month1 = explode('-', $month);

        $month3 = @$month1[0];
        $year = @$month1[1];


            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                   WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' AND `derivery_info`.`operator` = '$emid' ORDER BY `derivery_info`.`datetime` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' ORDER BY `derivery_info`.`datetime` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

               if(!empty($dates) )
                 {

                    $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                                 FROM   `derivery_info`  
                                 INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                                  WHERE  `derivery_transactions`.`status` = '$status' 
                                  AND `derivery_info`.`region` = '$o_region' AND date(`derivery_info`.`datetime`) = '$dates'
                                 
                                  ORDER BY `derivery_info`.`datetime` DESC";


                  }

                  else{

                       $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                           FROM   `derivery_info`  
                           INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                            WHERE  `derivery_transactions`.`status` = '$status' 
                            AND `derivery_info`.`region` = '$o_region' 
                            AND MONTH(`derivery_info`.`datetime`) = '$month3' AND YEAR(`derivery_info`.`datetime`) = '$year' 
                            ORDER BY `derivery_info`.`datetime` DESC";

                    }

            }else{



    if(!empty($dates) && !empty($month) && !empty($region)  )
    {

       $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' AND date(`derivery_info`.`datetime`) = '$dates'
                    AND MONTH(`derivery_info`.`datetime`) = '$month3' AND YEAR(`derivery_info`.`datetime`) = '$year' 
                    ORDER BY `derivery_info`.`datetime` DESC";


    

    }
    elseif( !empty($month) && !empty($region)  )
    {

      $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' 
                    AND MONTH(`derivery_info`.`datetime`) = '$month3' AND YEAR(`derivery_info`.`datetime`) = '$year' 
                    ORDER BY `derivery_info`.`datetime` DESC";


    }
    elseif(!empty($dates) &&  !empty($region)  )
    {

      $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' AND date(`derivery_info`.`datetime`) = '$dates'
                   
                    ORDER BY `derivery_info`.`datetime` DESC";


    }
    else
    {

      $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' 
                    ORDER BY `derivery_info`.`datetime` DESC";


    }

             
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }





    public function get_register_application_list_back(){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');
            $service_type= $this->session->userdata('service_type');

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = '$service_type'  AND `sender_person_info`.`sender_status` = 'Back'  ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Back'  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Back' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Back' ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_register_application_list_received(){

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

            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`    
                  WHERE `receiver_register_info`.`receiver_region` = '$o_region' AND `receiver_register_info`.`reciver_branch` = '$o_branch' 
                  AND ( `sender_person_info`.`sender_status` = 'Received' 
                  OR `sender_person_info`.`sender_status` = 'Derivery') 
                  AND `sender_person_info`.`sender_type` = '$service_type'  ORDER BY  `sender_person_info`.`sender_date_created` DESC";


            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql= "SELECT `sender_person_info`.*,`receiver_register_info`.*,
                `receiver_register_info`.`add_type` as receivertype
                ,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `receiver_register_info`.`receiver_region` = '$o_region' 
                   -- AND `receiver_register_info`.`sender_type` = '$service_type' 
                   AND ( `sender_person_info`.`sender_status` = 'Received' 
                   OR `sender_person_info`.`sender_status` = 'Derivery') 
                   ORDER BY `sender_person_info`.`sender_date_created` DESC ";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE  `sender_person_info`.`sender_type` = '$service_type' AND ( `sender_person_info`.`sender_status` = 'Received' OR `sender_person_info`.`sender_status` = 'Derivery') ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 
    public function get_register_application_list_received_seach($names,$number){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `receiver_register_info`.`receiver_region` = '$o_region' AND `receiver_register_info`.`reciver_branch` = '$o_branch' AND `sender_person_info`.`sender_type` = '$service_type'  AND (`sender_person_info`.`sender_status` = 'Received' OR `sender_person_info`.`sender_status` = 'Derivery') AND (`register_transactions`.`billid` = '$number' OR `sender_person_info`.`track_number` = '$number') ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `receiver_register_info`.`receiver_region` = '$o_region' AND `receiver_register_info`.`reciver_branch` = '$o_branch' AND `sender_person_info`.`sender_type` = '$service_type' AND (`sender_person_info`.`sender_status` = 'Received' OR `sender_person_info`.`sender_status` = 'Derivery') AND (`register_transactions`.`billid` = '$number' OR `sender_person_info`.`track_number` = '$number')  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `receiver_register_info`.`receiver_region` = '$o_region' AND `sender_person_info`.`sender_type` = '$service_type' AND (`sender_person_info`.`sender_status` = 'Received' OR `sender_person_info`.`sender_status` = 'Derivery') AND (`register_transactions`.`billid` = '$number' OR `sender_person_info`.`track_number` = '$number') ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{


                  $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE  `sender_person_info`.`sender_type` = '$service_type' AND (`sender_person_info`.`sender_status` = 'Received' OR `sender_person_info`.`sender_status` = 'Derivery') AND (`register_transactions`.`billid` = '$number' OR `sender_person_info`.`track_number` = '$number') ORDER BY `sender_person_info`.`sender_date_created` DESC";

                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 
    public function get_register_application_list_back_by_bagno($bagno){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `receiver_register_info`.`receiver_region` = '$o_region' AND `receiver_register_info`.`reciver_branch` = '$o_branch' AND `sender_person_info`.`sender_bag_number` = '$bagno' AND `sender_person_info`.`sender_type` = '$service_type'  AND (`sender_person_info`.`sender_status` = 'Bag' OR `sender_person_info`.`sender_status` = 'Received')  ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE  `receiver_register_info`.`receiver_region` = '$o_region' AND `receiver_register_info`.`reciver_branch` = '$o_branch' AND `sender_person_info`.`sender_bag_number` = '$bagno' AND `sender_person_info`.`sender_type` = '$service_type' AND (`sender_person_info`.`sender_status` = 'Bag' OR `sender_person_info`.`sender_status` = 'Received')  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `receiver_register_info`.`receiver_region` = '$o_region'  AND `sender_person_info`.`sender_bag_number` = '$bagno'  AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Bag' OR `sender_person_info`.`sender_status` = 'Received' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_bag_number` = '$bagno' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Bag' OR `sender_person_info`.`sender_status` = 'Received'  ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_register_application_list_back_by_bagno_out($bagno){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`sender_bag_number` = '$bagno' AND `sender_person_info`.`sender_type` = '$service_type'  AND (`sender_person_info`.`sender_status` = 'Bag' 
                  OR `sender_person_info`.`sender_status` = 'Received')   ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE `sender_person_info`.`sender_region` = '$o_region' 
                  AND `sender_person_info`.`sender_branch` = '$o_branch' 
                  AND `sender_person_info`.`sender_bag_number` = '$bagno' 
                  AND `sender_person_info`.`sender_type` = '$service_type' 
                  AND (`sender_person_info`.`sender_status` = 'Bag' 
                  OR `sender_person_info`.`sender_status` = 'Received')  
                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_bag_number` = '$bagno'  AND `sender_person_info`.`sender_type` = '$service_type' AND (`sender_person_info`.`sender_status` = 'Bag' 
                  OR `sender_person_info`.`sender_status` = 'Received')  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_bag_number` = '$bagno' AND `sender_person_info`.`sender_type` = '$service_type' AND (`sender_person_info`.`sender_status` = 'Bag' 
                  OR `sender_person_info`.`sender_status` = 'Received')   ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 
    
     public function get_register_application_list_back_received(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_status` = 'BackReceive'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id` 
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' 
                      AND `sender_person_info`.`sender_status` = 'BackReceive'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_status` = 'BackReceive'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.`add_type` as receivertype,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_status` = 'BackReceive'";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

    public function get_bags_list(){

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

                $sql    = "";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "";

            }else{

                $sql = "SELECT `bags_mails`.*,COUNT(`sender_person_info`.`senderp_id`) as `senderp_id` FROM `bags_mails` INNER JOIN `sender_person_info` ON `sender_person_info`.`sender_bag_number` = `bags_mails`.`bag_number`
                   WHERE date(`bags_mails`.`date_created`) = '$date'";
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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Register'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Register'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `register_transactions`.`status` = 'Paid'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                    WHERE  (`register_transactions`.`status`) = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Register'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }

    public function get_small_packets_sum_register(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Small-Packets'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Small-Packets'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Small-Packets'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                    WHERE  (`register_transactions`.`status`) = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Small-Packets'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }

    public function get_posts_cargo_sum_register(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Posts-Cargo'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Posts-Cargo'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Posts-Cargo'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                    WHERE  (`register_transactions`.`status`) = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Posts-Cargo'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }

    public function get_parcel_post_sum_register(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Parcels-Post'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Post'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Parcels-Post'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                    WHERE  (`register_transactions`.`status`) = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Post'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }
    public function get_parcel_post_sum_delivery(){

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

                $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                   WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' AND `derivery_info`.`operator` = '$emid' AND  (`derivery_transactions`.`status`) = 'Paid'  ORDER BY `derivery_info`.`datetime` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' AND  (`derivery_transactions`.`status`) = 'Paid' ORDER BY `derivery_info`.`datetime` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$o_region' AND date(`derivery_info`.`datetime`) = '$date' AND  (`derivery_transactions`.`status`) = 'Paid' ORDER BY `derivery_info`.`datetime` DESC";

            }else{

                $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE  date(`derivery_info`.`datetime`) = '$date' AND  (`derivery_transactions`.`status`) = 'Paid' ORDER BY `derivery_info`.`datetime` DESC";
            }


        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }


     public function get_parcel_post_sum_Search_delivery($dates,$month,$status,$region){

        $db2 = $this->load->database('otherdb', TRUE);

            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');




                //$dates = $date;//->format('Y-m-d');
    //$date1 = $this->session->userdata('date');
        $d1date = date('d',strtotime($dates));
        $m1date = date('m',strtotime($dates));
        $y1date = date('Y',strtotime($dates));
        
        $month1 = explode('-', $month);

        $month3 = @$month1[0];
        $year = @$month1[1];



            if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                   WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' AND `derivery_info`.`operator` = '$emid' AND  (`derivery_transactions`.`status`) = 'Paid'  ORDER BY `derivery_info`.`datetime` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$o_region' AND `derivery_info`.`branch` = '$o_branch' AND date(`derivery_info`.`datetime`) = '$date' AND  (`derivery_transactions`.`status`) = 'Paid' ORDER BY `derivery_info`.`datetime` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if(!empty($dates) )
                 {

                    $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount`
                                 FROM   `derivery_info`  
                                 INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                                  WHERE  `derivery_transactions`.`status` = '$status' 
                                  AND `derivery_info`.`region` = '$o_region' AND date(`derivery_info`.`datetime`) = '$dates'
                                 
                                  ORDER BY `derivery_info`.`datetime` DESC";


                  }

                  else{

                       $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount`
                           FROM   `derivery_info`  
                           INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                            WHERE  `derivery_transactions`.`status` = '$status' 
                            AND `derivery_info`.`region` = '$o_region' 
                            AND MONTH(`derivery_info`.`datetime`) = '$month3' AND YEAR(`derivery_info`.`datetime`) = '$year' 
                            ORDER BY `derivery_info`.`datetime` DESC";

                    }


            }else{


               if(!empty($dates) && !empty($month) && !empty($region)  )
    {

       $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' AND date(`derivery_info`.`datetime`) = '$dates'
                    AND MONTH(`derivery_info`.`datetime`) = '$month3' AND YEAR(`derivery_info`.`datetime`) = '$year' 
                    ORDER BY `derivery_info`.`datetime` DESC";


    

    }
    elseif( !empty($month) && !empty($region)  )
    {

      $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' 
                    AND MONTH(`derivery_info`.`datetime`) = '$month3' AND YEAR(`derivery_info`.`datetime`) = '$year' 
                    ORDER BY `derivery_info`.`datetime` DESC";


    }
    elseif(!empty($dates) &&  !empty($region)  )
    {

      $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' AND date(`derivery_info`.`datetime`) = '$dates'
                   
                    ORDER BY `derivery_info`.`datetime` DESC";


    }
    else
    {

      $sql    = "SELECT `derivery_info`.*,SUM(`derivery_transactions`.`paidamount`) AS `paidamount` 
                   FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id` 

                    WHERE  `derivery_transactions`.`status` = '$status' 
                    AND `derivery_info`.`region` = '$region' 
                    ORDER BY `derivery_info`.`datetime` DESC";


    }

               
            }


        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }


    public function get_sum_weight($bagNo){

        $db2 = $this->load->database('otherdb', TRUE);

        $sql    = "SELECT SUM(`sender_person_info`.`register_weght`) AS register_weght 
                   FROM   `sender_person_info`  WHERE `sender_bag_number` = '$bagNo' 
                   ";

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }


    public function check_payment($ids){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `register_transactions` WHERE `register_id`='$ids' AND `status` = 'Paid'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;

  }
  public function check_job_assign($ids){

     $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `taskjobassign` WHERE `assign_to`='$ids' AND date(`assign_date`) = '$date'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;

  }
  public function check_job_assign1($ids){

     $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `counter_services` WHERE `assign_to`='$ids' AND date(`registered_date`) = '$date' AND `assign_status` = 'Assign'";
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
    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_status` = 'Counter' AND `sender_person_info`.`operator` = '$ids' AND `register_transactions`.`status` = 'NotPaid' AND date(`sender_person_info`.`sender_date_created`) = '$date'";
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;

  }
  public function getTrackNo($ids){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `sender_person_info` WHERE `senderp_id`='$ids'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function count_ems(){
    $db2 = $this->load->database('otherdb', TRUE);
    $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');
    //$date = date('Y-m-d');
    $id = $this->session->userdata('user_login_id');
        //$info = $this->GetBasic($id);
        $o_region = $this->session->userdata('user_region');
        $o_branch = $this->session->userdata('user_branch');
        $service_type = $this->session->userdata('service_type');

    if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = '$service_type'  AND `sender_person_info`.`sender_status` = 'Back'  ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Back'  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Back' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$service_type' AND `sender_person_info`.`sender_status` = 'Back' ORDER BY `sender_person_info`.`sender_date_created` DESC";
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
    //$date = date('Y-m-d');
    $id = $this->session->userdata('user_login_id');
        //$info = $this->GetBasic($id);
        $o_region = $this->session->userdata('user_region');
        $o_branch = $this->session->userdata('user_branch');
        $service_type = $this->session->userdata('service_type');

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `bags_mails`.*,`sender_person_info`.*
                   FROM   `bags_mails`  
                   INNER JOIN  `sender_person_info` ON  `sender_person_info`.`sender_bag_number` = `bags_mails`.`bag_number`
                   WHERE date(`bags_mails`.`date_created`) = '$date' AND `bags_mails`.`bags_status` = 'notDespatch' AND `bags_mails`.`service_category` = '$service_type'";

    }else{

      $sql = "SELECT `bags_mails`.*
                   FROM   `bags_mails`  
                   WHERE date(`bags_mails`.`date_created`) = '$date' AND `bags_mails`.`bags_status` = 'notDespatch' AND `bags_mails`.`service_category` = '$service_type'";
    }


    $query  = $db2->query($sql);
    return $query->num_rows();
  }
  public function count_despatch(){

    $db2 = $this->load->database('otherdb', TRUE);
    $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');

    $id = $this->session->userdata('user_login_id');
    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $service_type = $this->session->userdata('service_type');

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                   FROM   `despatch_general`  
                   INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                   WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`branch_origin` = '$o_branch' AND `despatch_general`.`service_type` = '$service_type' ";

    }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){

       $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                   FROM   `despatch_general`  
                   INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                   WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`origin_region` = '$o_region' AND `despatch_general`.`service_type` = '$service_type'";

    }else{

      $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                   FROM   `despatch_general`  
                   INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                   WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`service_type` = '$service_type'";
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
    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $service_type = $this->session->userdata('service_type');

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                   FROM   `despatch_general`  
                   INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                   WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`branch_to` = '$o_branch' AND `despatch_general`.`service_type` = '$service_type'";

    }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){

       $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                   FROM   `despatch_general`  
                   INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                   WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`region_to` = '$o_region' AND `despatch_general`.`service_type` = '$service_type'";

    }else{

      $sql = "SELECT `despatch_general`.*,`bags_mails`.*
                   FROM   `despatch_general`  
                   INNER JOIN  `bags_mails` ON  `despatch_general`.`desp_no` = `bags_mails`.`despatch_no` 
                   WHERE date(`despatch_general`.`datetime`) = '$date' AND `despatch_general`.`despatch_status` = 'Sent' AND `despatch_general`.`service_type` = '$service_type'";
    }

    $query  = $db2->query($sql);
    return $query->num_rows();
  }
   public function count_item_received(){
    $db2 = $this->load->database('otherdb', TRUE);
    $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');
    //$date = date('Y-m-d');
    $id = $this->session->userdata('user_login_id');
        //$info = $this->GetBasic($id);
        $o_region = $this->session->userdata('user_region');
        $o_branch = $this->session->userdata('user_branch');

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
      WHERE `sender_person_info`.`sender_status`= 'BackReceive' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND  date(`sender_person_info`.`sender_date_created`) = '$date'";

    }else{

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_status` = 'BackReceive'";
    }


    $query  = $db2->query($sql);
    return $query->num_rows();
  }

  public function save_registered_international1($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('registered_international',$data);
        }

 public function get_registered_international_list(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            
            $id = $info->em_code;
            
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
             $today = new DateTime("now", $tz_obj);
             $date = $today->format('Y-m-d');

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `registered_international`.`region` = '$o_region' AND `registered_international`.`branch` = '$o_branch' AND `registered_international`.`Created_byId` = '$id'  ORDER BY `registered_international`.`date_created` DESC";

        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){
           $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `registered_international`.`region` = '$o_region'
            AND `registered_international`.`date_created` = '$date'
                ORDER BY `registered_international`.`date_created` DESC";

        }else{
           $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  LIMIT 0";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_registered_international_list_search($date,$month,$region){

            $db2 = $this->load->database('otherdb', TRUE);

            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
             $id = $info->em_code;

                $month1 = explode('-', $month);
                

                $month3 = @$month1[0];
                $year = @$month1[1];


              if (!empty($month) && !empty($date) && !empty($region)) {
                
               

                     $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `registered_international`.`region` = '$region'

            AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'
            AND date(`transactions`.`transactiondate`) = '$date'

       
              ORDER BY `registered_international`.`date_created` DESC";
 
            }
             if (!empty($month)  && !empty($region)) {
                
               

                     $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `registered_international`.`region` = '$region' 
             AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'


       
              ORDER BY `registered_international`.`date_created` DESC";
 
            }
             if (!empty($date) && !empty($region)) {
                
               

                     $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `registered_international`.`region` = '$region' 
            AND date(`transactions`.`transactiondate`) = '$date'
       
              ORDER BY `registered_international`.`date_created` DESC";
 
            }
            if (!empty($date) ) {
                
               

                     $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND date(`transactions`.`transactiondate`) = '$date'       
              ORDER BY `registered_international`.`date_created` DESC";
 
            }
            else
            {
                 $sql = "SELECT * FROM `registered_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `registered_international`.`region` = '$o_region' AND `registered_international`.`Created_byId` = '$id'  
              ORDER BY `registered_international`.`date_created` DESC";

            }

            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }
       

}
?>