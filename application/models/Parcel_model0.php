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
        $sql = "SELECT * FROM `parcel_international_transactions` WHERE `billid`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
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
        $db2->update('parcel_international_transactions',$update);         
    } 

    public function update_parcel_international_transactions1($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('billid', $serial);
        $db2->update('parcel_international_transactions',$update);         
    }  
    public function get_code_dest_inter($region_to){

          $sql    = "SELECT * FROM `parcel_international_tarrif` WHERE `tarrif_id`='$region_to'";
                  $query  = $this->db->query($sql);
                  $result = $query->row();
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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY  `sender_person_info`.`sender_date_created` DESC";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'  ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }elseif ($this->session->userdata('user_type') == "RM") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `parcel_international_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `parcel_international_transactions`.`status` = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";

            }elseif ($this->session->userdata('user_type') == "RM") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `parcel_international_transactions`.`status` = 'Paid' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                    WHERE  (`parcel_international_transactions`.`status`) = 'Paid' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = 'Parcels-Inter'";
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

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                  $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id` 
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{



                  if(!empty($date) && !empty($month) && !empty($region)  )
    {


       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

                   


    }
    elseif( !empty($month) && !empty($region)  )
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    else
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
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

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {


                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')  AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year')  AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' ORDER BY `sender_person_info`.`sender_date_created` DESC";


                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`parcel_international_transactions`.* 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  
`receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   
`sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
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

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount  
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' AND `sender_person_info`.`sender_region` = '$o_region' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id` 
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Post' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{



                  if(!empty($date) && !empty($month) && !empty($region)  )
    {


       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

                   


    }
    elseif( !empty($month) && !empty($region)  )
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                 
                   AND MONTH(`sender_person_info`.`sender_date_created`) = '$month3' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
                  AND `sender_person_info`.`sender_region` = '$region'
                  AND  (date(`sender_person_info`.`sender_date_created`) = '$date')
                   

                  ORDER BY `sender_person_info`.`sender_date_created` DESC";

    }
    else
    {

     
       $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`   
                  WHERE   `parcel_international_transactions`.`status` = '$status'
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

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'  AND `sender_person_info`.`operator` = '$emid'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }


            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }
                

            }elseif ($this->session->userdata('user_type') == "RM") {

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `sender_person_info`.`sender_region` = '$o_region' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year') AND `sender_person_info`.`sender_region` = '$o_region'
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                }

                
            }else{

                if (!empty($date)) {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  (date(`sender_person_info`.`sender_date_created`) = '$date')
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

                } else {

                   $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`parcel_international_transactions`.`paidamount`) AS paidamount 
                  FROM   `sender_person_info`  
                  INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  INNER JOIN  `parcel_international_transactions`  ON   `sender_person_info`.`senderp_id`   = `parcel_international_transactions`.`register_id`  
                  WHERE  MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year' 
                  AND `sender_person_info`.`sender_type` = 'Parcels-Inter' AND `parcel_international_transactions`.`status` = 'Paid' ORDER BY `sender_person_info`.`sender_date_created` DESC";

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

        }elseif($this->session->userdata('user_type') == 'RM'){
           $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_international`.`region` = '$o_region' AND   ORDER BY `air_mails_international`.`date_created` DESC";

        }else{
           $sql = "SELECT * FROM `air_mails_international`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_international`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `air_mails_international`.`date_created` DESC";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_air_mails_international_application_list_search($date,$month,$region){

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
              ORDER BY `air_mails_internationals`.`date_created` DESC";

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

        }elseif($this->session->userdata('user_type') == 'RM'){
           $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `air_mails_domestic`.`region` = '$o_region' AND   ORDER BY `air_mails_domestic`.`date_created` DESC";

        }else{
           $sql = "SELECT * FROM `air_mails_domestic`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`air_mails_domestic`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `air_mails_domestic`.`date_created` DESC";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_air_mails_domestic_application_list_search($date,$month,$region){

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