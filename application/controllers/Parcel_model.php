<?php

	class Parcel_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}

    public function country_name(){
         $db2 = $this->load->database('otherdb', TRUE);

        $sql = "SELECT * FROM `parcel_international_tarrif`";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function checkValueParcInter($controlno){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `register_transactions` WHERE `billid`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }



        public function mail_tariff_price($itemname,$type,$weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `air_mails_tarrif` WHERE `category`='$itemname'  AND `type`='$type'
        AND `weight_step` >= '$weight'  ORDER BY `price_id` LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }



      public function getParcInter(){
      
      $db2 = $this->load->database('otherdb', TRUE);

  $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
           FROM   `sender_person_info`  
           INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
           INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id` 
            ";
         


        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    
    public function get_country_price($emsCat){
         $db2 = $this->load->database('otherdb', TRUE);

        $sql = "SELECT * FROM `parcel_international_tarrif` WHERE `tarrif_id` = '$emsCat'";

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }
   public function update_parcel_international_transactions($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('serial', $serial);
        $db2->update('register_transactions',$update);         
    } 

     public function delete_bulk_international_bysenderid($senderid){
          $db2 = $this->load->database('otherdb', TRUE);
        $db2->delete('sender_person_info',array('senderp_id'=> $senderid));
         $db2->delete('receiver_register_info',array('sender_id'=> $senderid));
          $db2->delete('register_transactions',array('register_id'=> $senderid));
      }


    public function update_parcel_international_transactions1($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('billid', $serial);
        $db2->update('register_transactions',$update);         
    }  
    public function get_code_dest_inter($region_to){

          $sql    = "SELECT * FROM `parcel_international_tarrif` WHERE `tarrif_id`='$region_to'";
                  $query  = $this->db->query($sql);
                  $result = $query->row();
          return $result;

          }

           public function check_paymentParcInter($ids){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `register_transactions` WHERE `register_id`='$ids'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

          public function GetListbulkPacelInternational($operator,$serial){
            //$info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');
            $db2 = $this->load->database('otherdb', TRUE);


           

                 $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`operator` = '$operator' 
                   AND `register_transactions`.`serial` = '$serial' 
                   AND date(`sender_person_info`.`sender_date_created`) = '$date'
                    ";
         

                  // WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Posts-Cargo' ORDER BY `sender_person_info`.`sender_date_created` DESC

               




        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
      }



    public function get_parcel_international_application_list(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function get_sum_parcel_international(){

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
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `register_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                    WHERE  (`register_transactions`.`status`) = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }

     public function search_application_list2($date,$month,$region,$branch,$status){

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
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' 
                  AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post'
                   AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {



                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND `sender_person_info`.`sender_region` = '$o_region' AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                  $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id` 
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{



                  if(!empty($date) && !empty($month) && !empty($region)  )
    {


       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

                   


    }
    elseif( !empty($month) && !empty($region)  )
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    else
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }





               
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    } 

    public function search_application_list($date,$month,$region,$branch){

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

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {


                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')  AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";


                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  
`receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   
`sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') 
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' 
ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

    public function get_parcel_post_sum_search2($date,$month,$region,$branch,$status){

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

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post'
                   AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount  
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post'
                   AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post' 
                  AND `sender_person_info`.`sender_region` = '$o_region' AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id` 
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  -- AND `sender_person_info`.`sender_type` = 'Parcels-Post'
                   AND  `register_transactions`.`status` = '$status' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{



                  if(!empty($date) && !empty($month) && !empty($region)  )
    {


       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year' 

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

                   


    }
    elseif( !empty($month) && !empty($region)  )
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    else
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`   
                  WHERE   `register_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }





               
                
            }
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 

    public function get_parcel_post_sum_search($date,$month,$region,$branch){

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
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`register_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
                  WHERE  MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year' 
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `register_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    }  





     public function get_air_mails_international_application_list(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            
            $id = $info->em_code;
            
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_international`.`region` = '$o_region' AND `air_mails_international`.`branch` = '$o_branch' AND `air_mails_international`.`Created_byId` = '$id'  ORDER BY `air_mails_international`.`date_created` DESC";

        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){
           $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_international`.`region` = '$o_region'    ORDER BY `air_mails_international`.`date_created` DESC";

        }else{
           $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  LIMIT 0";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_air_mails_international_application_list_search($date,$month,$region,$status){

            $db2 = $this->load->database('otherdb', TRUE);

            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
             $id = $info->em_code;

             

               $month1 = explode('-', $month);
                

                $day = @$month1[0];
                $year = @$month1[1];

                  $dates =  $date;

           

             $month3 = $day;

             if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" ||
              $this->session->userdata('user_type') == "SUPERVISOR" ||$this->session->userdata('user_type') == "RM"  || $this->session->userdata('user_type') == "ACCOUNTANT")
               {

                  if (!empty($month) || !empty($date) || !empty($region)) {
                
               

                     $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_international`.`region` = '$region' 

       
              ORDER BY `air_mails_international`.`date_created` DESC";

           
            }
             else
            {

               $sql = "SELECT * FROM `air_mails_international`
                    LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
                    WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_international`.`region` = '$o_region' AND `air_mails_international`.`Created_byId` = '$id'  
                      ORDER BY `air_mails_international`.`date_created` DESC";

            }

               

            }else{


                  if(!empty($date) && !empty($month) && !empty($region)  )
            
    {

       $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_international`.`region` = '$region' 

            AND  (date(`transactions`.`transactiondate`) = '$date')
                   AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'

       
              ORDER BY `air_mails_international`.`date_created` DESC";

    }
    elseif( !empty($month) && !empty($region)  )
    {

     
       $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_international`.`region` = '$region' 

           
                   AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'

       
              ORDER BY `air_mails_international`.`date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      
       $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_international`.`region` = '$region' 

            AND  (date(`transactions`.`transactiondate`) = '$date')
                 

       
              ORDER BY `air_mails_international`.`date_created` DESC";

    }
    else
    {

     
      $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_international`.`region` = '$region' 
       
              ORDER BY `air_mails_international`.`date_created` DESC";

    }
  }
   


            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }

 public function get_air_mails_domestic_application_list(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            
            $id = $info->em_code;
            
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_domestic`.`region` = '$o_region' AND `air_mails_domestic`.`branch` = '$o_branch' AND `air_mails_domestic`.`Created_byId` = '$id'  ORDER BY `air_mails_domestic`.`date_created` DESC";

        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == "ACCOUNTANT"){
           $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_domestic`.`region` = '$o_region'    ORDER BY `air_mails_domestic`.`date_created` DESC";

        }else{
           $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  LIMIT 0";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_air_mails_domestic_application_list_search($date,$month,$region,$status){

            $db2 = $this->load->database('otherdb', TRUE);

            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
             $id = $info->em_code;

                $month1 = explode('-', $month);
                

                $day = @$month1[0];
                $year = @$month1[1];

                  $dates =  $date;

           

             $month3 = $day;

             if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" ||
              $this->session->userdata('user_type') == "SUPERVISOR" ||$this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT")
               {

                  if (!empty($month) || !empty($date) || !empty($region)) {
                
               

                     $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_domestic`.`region` = '$region' 

       
              ORDER BY `air_mails_domestic`.`date_created` DESC";

           
            }
             else
            {

               $sql = "SELECT * FROM `air_mails_domestic`
                    LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
                    WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_domestic`.`region` = '$o_region' AND `air_mails_domestic`.`Created_byId` = '$id'  
                      ORDER BY `air_mails_domestic`.`date_created` DESC";

            }

               

            }else{


                  if(!empty($date) && !empty($month) && !empty($region)  )
            
    {

       $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_domestic`.`region` = '$region' 

            AND  (date(`transactions`.`transactiondate`) = '$date')
                   AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'

       
              ORDER BY `air_mails_domestic`.`date_created` DESC";

    }
    elseif( !empty($month) && !empty($region)  )
    {

     
       $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_domestic`.`region` = '$region' 

           
                   AND MONTH(`transactions`.`transactiondate`) = '$month3' AND YEAR(`transactions`.`transactiondate`) = '$year'

       
              ORDER BY `air_mails_domestic`.`date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      
       $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_domestic`.`region` = '$region' 

            AND  (date(`transactions`.`transactiondate`) = '$date')
                 

       
              ORDER BY `air_mails_domestic`.`date_created` DESC";

    }
    else
    {

     
      $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND  `transactions`.`status` = '$status'
            AND `air_mails_domestic`.`region` = '$region' 
       
              ORDER BY `air_mails_domestic`.`date_created` DESC";

    }
  }
   


            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }

 public function save_air_mails_international($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('air_mails_international',$data);
        }
        public function Save_air_mails_domestic($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('air_mails_domestic',$data);
        }



}