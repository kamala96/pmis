<?php

	class Dashboard_model extends CI_Model{


	function __consturct(){
	parent::__construct();
	
	}
    public function insert_tododata($data){
        $this->db->insert('to-do_list',$data);
    }
    public function GettodoInfo($userid){
        $sql = "SELECT * FROM `to-do_list` WHERE `user_id`='$userid' ORDER BY `date` DESC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function update_transactions_real_estate($update,$serial1){

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->where('serial',$serial1);
            $db2->update('real_estate_transactions',$update);
        }
    public function save_transactions_real_estate($data){
            $this->db->insert('real_estate_transactions',$data);
        }

       public function save_tenant_payment_details($add){

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('tenant_payment_details',$add);
    }

public function save_tenant_customer_details($add){

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('tenant_customer_details',$add);
    }

 public function get_tenants_customer_details($id){
        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `tenant_customer_details` WHERE `tenant_id`='$id'";
                  $query  = $db2->query($sql);
                  $result = $query->result();
          return $result;
          } 

          public function get_tenants_payment_details($id){
        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `real_estate_transactions` WHERE `tenant_id`='$id'";
                  $query  = $db2->query($sql);
                  $result = $query->result();
          return $result;
          } 

          public function get_tenants_updated_payment_details($id){
        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `real_estate_transactions` WHERE `tenant_id`='$id' AND `status` != 'Paid'";
                  $query  = $db2->query($sql);
                  $result = $query->result();
          return $result;
          } 

           public function get_payment_details($serial){
        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `real_estate_transactions` WHERE `serial`='$serial'";
                  $query  = $db2->query($sql);
                  $result = $query->result();
          return $result;
          } 

           public function get_estate_information(){
        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `estate_information` ";
                  $query  = $db2->query($sql);
                  $result = $query->result();
          return $result;
          } 

           public function get_tenant_informations_by_estatename($type,$statename){
        
        $db2 = $this->load->database('otherdb', TRUE);


                 $sql = "SELECT  DISTINCT t3.`estate_name`,t1.*,t2.*,t3.*,t4.*
         FROM `estate_tenant_information` AS t1
        INNER JOIN (SELECT *
              FROM `estate_contract_information`
              JOIN (
               Select  max(estate_co_id) mlike
               from estate_contract_information
               GROUP BY `tenant_id`)  T
            on  estate_contract_information.estate_co_id = T.mlike ) AS t2 ON t1.`tenant_id` = t2.`tenant_id` 
          INNER JOIN `estate_information` AS t3 
                    ON t3.`estate_id` = t2.`estate_id`  
        --              INNER JOIN (SELECT *
        --       FROM `real_estate_transactions` as k
        --       JOIN (SELECT  MAX(`t_id`) mlikes
        --        FROM real_estate_transactions
        --       GROUP BY `tenant_id`)  Tz
        --      on k.t_id = Tz.mlikes  
        -- ) AS t4 ON t1.`tenant_id` = t4.`tenant_id`  
                   
 

            WHERE t3.`estate_type` = '$type' AND

           
            -- AND t3.`estate_name` = '$statename' 
            
               ORDER BY t2.`estate_co_id` DESC";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


    public function get_tenant_information_search_tenantName($type,$regid,$disid,$status,$estatus,$estate_name){
        
        $db2 = $this->load->database('otherdb', TRUE);

         $sql = "SELECT t1.*,t2.*,t3.*,t4.*
 FROM `estate_tenant_information` AS t1
INNER JOIN (SELECT *
      FROM `estate_contract_information`
      JOIN (
       Select  max(estate_co_id) mlike
       from estate_contract_information
       GROUP BY `tenant_id`)  T
    ON  estate_contract_information.estate_co_id = T.mlike ) AS t2 ON t1.`tenant_id` = t2.`tenant_id` 
  INNER JOIN `estate_information` AS t3 
            ON t3.`estate_id` = t2.`estate_id`  
--              INNER JOIN (SELECT *
--       FROM `real_estate_transactions` 
--       JOIN (SELECT  MAX(`t_id`) mlikes
--        FROM real_estate_transactions
--       GROUP BY `tenant_id`)  Tz
--      ON `real_estate_transactions`.t_id = Tz.mlikes  
-- ) AS t4 ON t1.`tenant_id` = t4.`tenant_id`  
            WHERE t3.`estate_type` = '$type'
              AND t3.`region` = '$regid'
               AND t3.`district` = '$disid'
                AND t3.`estate_status` = '$estatus'
                 AND t4.`status` = '$status' 
                 AND t3.`estate_name` = '$statename' 
               ORDER BY t2.`estate_co_id` DESC";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }




           public function get_tenant_payment_information($tenantid){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `real_estate_transactions` WHERE `tenant_id`='$tenantid'";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

          public function update_realestate_tenants_payments_details($update,$id){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('tenantid',$id);
        $db2->update('tenant_payment_details',$update);
    }

           public function get_realestate_tenants_payments_details_list(){
        $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `tenant_payment_details` WHERE  `transactionstatus` != 'Paid'";
                  $query  = $db2->query($sql);
                  $result = $query->result();
          return $result;
          } 


    public function getRegion_ById($regid){
        $sql = "SELECT * FROM `em_region` WHERE `region_id`='$regid'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getamount($tenant_id){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `estate_contract_information` WHERE `tenant_id` ='$tenant_id'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }


    public function get_cust_details($cuno){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT `estate_contract_information`.*,`estate_tenant_information`.*,`estate_information`.*,`real_estate_transactions`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
            INNER JOIN `real_estate_transactions` ON `real_estate_transactions`.`tenant_id` = `estate_tenant_information`.`tenant_id`  
            WHERE `estate_tenant_information`.`tenant_id`='$cuno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

     public function get_cust_detail_serial($tenant_id,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT `estate_contract_information`.*,`estate_tenant_information`.*,`estate_information`.*,`real_estate_transactions`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
            INNER JOIN `real_estate_transactions` ON `real_estate_transactions`.`tenant_id` = `estate_tenant_information`.`tenant_id`  
            WHERE `estate_tenant_information`.`tenant_id`='$tenant_id' AND `real_estate_transactions`.`serial`='$serial'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function checkValue_real_estate($controlno){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `real_estate_transactions` WHERE `billid`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_payment_information($controlno){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `partial_payment` WHERE `controlno`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getsumPayment($controlno){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT SUM(`amount`) AS `sum_amount` FROM `partial_payment` WHERE `controlno`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getsumPayments($controlno){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT SUM(`amount`) AS `sum_amount`,`receipt`,`date_created` FROM `partial_payment` WHERE `controlno`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }


    public function get_tenant_information($type){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT `estate_contract_information`.*,`estate_tenant_information`.*,`estate_information`.*,`real_estate_transactions`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
            INNER JOIN `real_estate_transactions` ON `real_estate_transactions`.`tenant_id` = `estate_tenant_information`.`tenant_id`  
            WHERE `estate_information`.`estate_type` = '$type' ORDER BY `real_estate_transactions`.`transactiondate` DESC";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

     public function get_tenant_informationsk($type,$regid){
        
        $db2 = $this->load->database('otherdb', TRUE);

        if(empty($regid)){

           $sql = "SELECT t1.*,t2.*,t3.*,t4.*
 FROM `estate_tenant_information` AS t1
INNER JOIN (SELECT *
      FROM `estate_contract_information`
      JOIN (
       Select  max(estate_co_id) mlike
       from estate_contract_information
       GROUP BY `tenant_id`)  T
    on  estate_contract_information.estate_co_id = T.mlike ) AS t2 ON t1.`tenant_id` = t2.`tenant_id` 
  INNER JOIN `estate_information` AS t3 
            ON t3.`estate_id` = t2.`estate_id`   INNER JOIN (SELECT *
      FROM `real_estate_transactions` as k
      JOIN (SELECT  MAX(`t_id`) mlikes
       FROM real_estate_transactions
      GROUP BY `tenant_id`)  Tz
     on k.t_id = Tz.mlikes  
) AS t4 ON t1.`tenant_id` = t4.`tenant_id`  
           
 

            WHERE t3.`estate_type` = '$type' 

               ORDER BY t2.`estate_co_id` DESC";

        }else{


         $sql = "SELECT t1.*,t2.*,t3.*,t4.*
 FROM `estate_tenant_information` AS t1
INNER JOIN (SELECT *
      FROM `estate_contract_information`
      JOIN (
       Select  max(estate_co_id) mlike
       from estate_contract_information
       GROUP BY `tenant_id`)  T
    on  estate_contract_information.estate_co_id = T.mlike ) AS t2 ON t1.`tenant_id` = t2.`tenant_id` 
  INNER JOIN `estate_information` AS t3 
            ON t3.`estate_id` = t2.`estate_id`   INNER JOIN (SELECT *
      FROM `real_estate_transactions` as k
      JOIN (SELECT  MAX(`t_id`) mlikes
       FROM real_estate_transactions
      GROUP BY `tenant_id`)  Tz
     on k.t_id = Tz.mlikes  
) AS t4 ON t1.`tenant_id` = t4.`tenant_id`  
           
 

            WHERE t3.`estate_type` = '$type' AND t3.`region` = '$regid'

               ORDER BY t2.`estate_co_id` DESC";
             }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


     public function GetEstateByDistrict($District){
        $db2 = $this->load->database('otherdb', TRUE);
            
            $db2->where('district',$District);
            $db2->where('estate_type','Residential');
            
            $db2->order_by('district');
            $query = $db2->get('estate_information');
            $output ='<option value="">Select Property</option>';
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->estate_name.'">'.$row->estate_name.'</option>';
            }
             return $output;
          }            
        

    public function get_tenant_informationss(){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT `estate_contract_information`.*,`estate_tenant_information`.*,`estate_information`.*,`real_estate_transactions`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
            INNER JOIN `real_estate_transactions` ON `real_estate_transactions`.`tenant_id` = `estate_tenant_information`.`tenant_id`  
            WHERE `estate_information`.`estate_type` != '' ORDER BY `estate_tenant_information`.`tenant_id` DESC";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

     public function getregionid($o_region){
          $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `em_region` WHERE `region_name`='$o_region' ";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    
    public function get_tenant_information_search($type,$regid,$disid,$status,$estatus){
        
        $db2 = $this->load->database('otherdb', TRUE);


        // $sql = "SELECT `estate_contract_information`.*,`estate_tenant_information`.*,`estate_information`.*,`transactions`.* FROM `estate_tenant_information`
        //     INNER JOIN `estate_contract_information` 
        //     ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
        //     INNER JOIN `estate_information` 
        //     ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
        //     INNER JOIN `transactions` ON `transactions`.`CustomerID` = `estate_tenant_information`.`tenant_id`  
        //     WHERE `estate_information`.`estate_type` = '$type' AND `transactions`.`PaymentFor` = 'REAL-ESTATE' AND `estate_information`.`region` = '$regid' AND `estate_information`.`district` = '$disid' AND `estate_information`.`estate_status` = '$estatus' AND `transactions`.`status` = '$status' ORDER BY `estate_tenant_information`.`tenant_id` DESC";

              $sql = "SELECT `estate_contract_information`.*,`estate_tenant_information`.*,`estate_information`.*,`real_estate_transactions`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
           INNER JOIN `real_estate_transactions` ON `real_estate_transactions`.`tenant_id` = `estate_tenant_information`.`tenant_id`  
            WHERE `estate_information`.`estate_type` = '$type'  AND `estate_information`.`region` = '$regid' AND `estate_information`.`district` = '$disid' AND `estate_information`.`estate_status` = '$estatus' AND `real_estate_transactions`.`status` = '$status' ORDER BY `real_estate_transactions`.`transactiondate` DESC";

            //$db2->query("SET sql_mode = '' ");

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

public function get_tenant_informations1($id){
        
        $db2 = $this->load->database('otherdb', TRUE);

        $sql = "SELECT `estate_tenant_information`.*,`estate_information`.* FROM `estate_tenant_information`
            INNER JOIN `estate_contract_information` 
            ON `estate_contract_information`.`tenant_id` = `estate_tenant_information`.`tenant_id`
            INNER JOIN `estate_information` 
            ON `estate_information`.`estate_id` = `estate_contract_information`.`estate_id`
             
            WHERE `estate_tenant_information`.`tenant_id` = '$id'  ORDER BY `estate_tenant_information`.`tenant_id` DESC LIMIT 1";

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }



    public function getDistrict_ById($disid){
        $sql = "SELECT * FROM `em_district` WHERE `district_id`='$disid'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }

     public function getPcumDistrict_ById($disid){
          $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `pcum_district` WHERE `district_id`='$disid'";
        $query= $db2->query($sql);
        $result = $query->row();
        return $result;
    }


    public function getdistrict(){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `pcum_district`";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetZonesById($objid){
        $db2 = $this->load->database('otherdb', TRUE);

        $sql    = "SELECT * FROM `district_zone_tarrif` WHERE `district_id`='$objid'";
                  $query  = $db2->query($sql);
            $output="<option>--Select Zone--</option>";
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->zone_id.'">'.$row->zone_name.'</option>';
            }
             return $output;
    }
    public function GetZonesCityById($zoneid,$districtid){

        $db2 = $this->load->database('otherdb', TRUE);

        $sql    = "SELECT DISTINCT(`town_city`) FROM `tarrif_zone_district_price` WHERE `zone_id`='$zoneid' AND `district_id` = '$districtid'";
                  $query  = $db2->query($sql);
            $output="<option>--Select Zone--</option>";
            foreach ($query->result() as $row) {
              $output .='<option>'.$row->town_city.'</option>';
            }
             return $output;

    }
    public function pcum_price($weight,$zoneid,$city,$distid){

        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `tarrif_zone_district_price` WHERE `zone_id`='$zoneid' AND `weight` >= $weight AND `town_city` = '$city' AND `district_id` = '$distid' ORDER BY `weight` ASC LIMIT 1 ";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;

    }
    public function activestaffsummary(){
        $sql = "SELECT count(`id`) as `value`,`em_region` FROM `employee` WHERE `status`='ACTIVE' AND `employee`.`em_role` != 'AGENT' GROUP BY `em_region` ORDER BY `em_region` ASC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function retiredstaffsummary(){
        $sql = "SELECT count(`id`) as `value`,`em_region` FROM `employee` WHERE `status`='RETIRED' GROUP BY `em_region` ORDER BY `em_region` ASC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getgraphdata(){
        $sql = "SELECT YEAR(`employee`.`em_joining_date`) as `year`, COUNT(`employee`.`id`) as `value` FROM `employee` WHERE `employee`.`status` = 'ACTIVE' AND `employee`.`em_role` != 'AGENT' GROUP BY YEAR(`employee`.`em_joining_date`) ORDER BY YEAR(`employee`.`em_joining_date`) DESC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function getregion(){
        $sql = "SELECT * FROM `em_region` ORDER BY `region_name` ASC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function countleaveon($rname){
        $sql = "SELECT count(`emp_leave`.`id`) as `leaveon`,`employee`.`em_region` FROM `employee` INNER JOIN `emp_leave` ON `emp_leave`.`em_id` = `employee`.`em_id` WHERE `emp_leave`.`leave_status` = 'Approve' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function expetedtoretire($rname){

        $date = date('Y');
        $sql = "SELECT COUNT(`employee`.`id`) as `year` FROM `employee` WHERE YEAR(`employee`.`em_birthday`)+60 = '$date' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT' ";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function expetedtoretire1($rname){
        $date = date('Y')+1;
        $sql = "SELECT COUNT(`employee`.`id`) as `year1` FROM `employee` WHERE YEAR(`employee`.`em_birthday`)+60 = '$date' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function expetedtoretire2($rname){
        $date = date('Y')+2;
        $sql = "SELECT COUNT(`employee`.`id`) as `year2` FROM `employee` WHERE YEAR(`employee`.`em_birthday`)+60 = '$date' AND `employee`.`em_region` = '$rname' AND `employee`.`em_role` != 'AGENT'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function countleaveoff($rname){
        $sql = "SELECT count(`emp_leave`.`id`) as `leaveoff`,`employee`.`em_region` FROM `employee` INNER JOIN `emp_leave` ON `emp_leave`.`em_id` = `employee`.`em_id` WHERE `emp_leave`.`leave_status` = 'Complete' AND `employee`.`em_region` = '$rname'";
        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }
    public function GetRunningProject(){
        $sql = "SELECT * FROM `project` WHERE `pro_status`='running' ORDER BY `id` DESC";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function GetHolidayInfo(){
        $sql = "SELECT * FROM `holiday` ORDER BY `id` DESC LIMIT 10";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	public function UpdateTododata($id,$data){
		$this->db->where('id', $id);
		$this->db->update('to-do_list',$data);		
	}  

     public function save_Emszero($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('emszero',$data);
        }

    public function get_Emszero_list(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            
            $id = $info->em_code;
            
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `emszero`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$o_region' AND `emszero`.`branch` = '$o_branch' AND `emszero`.`Created_byId` = '$id'  ORDER BY `emszero`.`date_created` DESC";

        }elseif($this->session->userdata('user_type') == 'RM'|| $this->session->userdata('user_type') == "ACCOUNTANT"){
           $sql = "SELECT * FROM `emszero`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$o_region'    ORDER BY `emszero`.`date_created` DESC LIMIT 0";

        }else{
           $sql = "SELECT * FROM `emszero`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `emszero`.`date_created` DESC LIMIT 0";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }

     public function get_EmsZero_list_search($date,$month,$region){

            $db2 = $this->load->database('otherdb', TRUE);

            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
             $id = $info->em_code;

                $month1 = explode('-', $month);
                

                $day = @$month1[0];
                $year = @$month1[1];


                if($this->session->userdata('user_type') == 'RM'|| $this->session->userdata('user_type') == "ACCOUNTANT"){

                     if (!empty($date) ){
                     $sql = "SELECT * FROM `emszero`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
                        
                        WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$o_region' AND ( date(`emszero`.`date_created`) = '$date')

                   
                          ORDER BY `emszero`.`date_created` DESC";

 // AND  ( MONTH(`Internet`.`date_created`) = '$day' AND YEAR(`Internet`.`Internet`) = '$year' ) 
            
                        }
                        else
                        {
                             $sql = "SELECT * FROM `emszero`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
                        WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$o_region' 
                        AND  ( MONTH(`emszero`.`date_created`) = '$day' AND YEAR(`emszero`.`date_created`) = '$year' ) 
                          ORDER BY `emszero`.`date_created` DESC";

                        }

                }
                else{


              if ((!empty($month) || !empty($date)) && !empty($region)) {
                
               

                   if (!empty($date)) {
                     $sql = "SELECT * FROM `emszero`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
                        
                        WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$region' AND ( date(`emszero`.`date_created`) = '$date')

                   
                          ORDER BY `emszero`.`date_created` DESC";

 // AND  ( MONTH(`Internet`.`date_created`) = '$day' AND YEAR(`Internet`.`Internet`) = '$year' ) 
            
                        }
                        else
                        {
                             $sql = "SELECT * FROM `emszero`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
                        WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$region' 
                        AND  ( MONTH(`emszero`.`date_created`) = '$day' AND YEAR(`emszero`.`date_created`) = '$year' ) 
                          ORDER BY `emszero`.`date_created` DESC";

                        }

            
            }
            else
            {
                 $sql = "SELECT * FROM `emszero`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`emszero`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `emszero`.`region` = '$o_region' AND `emszero`.`Created_byId` = '$id'  
              ORDER BY `emszero`.`date_created` DESC";

            }

            }

            $query = $db2->query($sql);
            $result = $query->result();
            return $result;
            
            
        }


    public  function get_ems_domestic_cash(){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND  `sender_info`.`s_region` = '$region' AND `sender_info`.`s_pay_type` = 'Cash' GROUP BY `sender_info`.`s_district`";

        }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash'  AND  `sender_info`.`s_region` = '$region' AND  `sender_info`.`s_district` = '$branch'  GROUP BY MONTH(`sender_info`.`date_registered`) ORDER BY MONTH(`sender_info`.`date_registered`)  ASC";


        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `sender_info`.`s_pay_type` = 'Cash' GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_ems_international(){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "SUPERVISOR") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`s_region`='$region'  GROUP BY `sender_info`.`s_district`";

        }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT"){

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' AND `sender_info`.`operator` = '$id' AND `sender_info`.`s_district`='$branch' AND `sender_info`.`s_region`='$region'  GROUP BY MONTH(`sender_info`.`date_registered`) ORDER BY MONTH(`sender_info`.`date_registered`)  ASC";


        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = 'EMS_INTERNATIONAL' GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function get_ems_domestic_bill(){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');
        $id = $this->session->userdata('user_login_id');

        if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "") {

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
            WHERE `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$region' AND (`sender_info`.`s_pay_type` = 'PrePaid' 
            OR `sender_info`.`s_pay_type` = 'PostPaid' ) 
            GROUP BY `sender_info`.`s_district`";

        }elseif($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR" || $this->session->userdata('user_type') == "AGENT"){

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
               LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
               LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
               LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
               WHERE `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$region' AND `sender_info`.`s_district` = '$branch' AND (`sender_info`.`s_pay_type` = 'PrePaid' OR `sender_info`.`s_pay_type` = 'PostPaid' ) GROUP BY MONTH(`sender_info`.`date_registered`) ORDER BY MONTH(`sender_info`.`date_registered`)  ASC";

        }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` WHERE `transactions`.`status` = 'Bill' AND (`sender_info`.`s_pay_type` = 'PrePaid' OR `sender_info`.`s_pay_type` = 'PostPaid' ) GROUP BY `sender_info`.`s_region`";
        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function generate_report_over_all($catType,$year,$Type,$date1,$date2,$reportType,$month1,$month2,$month,$dairly){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $id = $this->session->userdata('user_login_id');

        if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "PMG" || $this->session->userdata('user_type') == "CRM"  || $this->session->userdata('user_type') == "BOP"){

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  date(`sender_info`.`date_registered`) = '$dairly' AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";
                
                } 


                }
                
          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";
          }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  YEAR(`sender_info`.`date_registered`) = '$year'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_region`";

          }
        
        }elseif ($this->session->userdata('user_type') == "RM") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
        AND  date(`sender_info`.`date_registered`) = '$dairly' AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";
          }else{

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'  AND  `sender_info`.`ems_type` = '$catType' GROUP BY `sender_info`.`s_district`";

          }

        }elseif ($this->session->userdata('user_type')== "EMPLOYEE" || $this->session->userdata('user_type')== "AGENT") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

        } 

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
          }else{

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$Type'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'  AND  `sender_info`.`ems_type` = '$catType' AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

          }


        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


    public  function generate_report_other_all($catType,$year,$date1,$date2,$reportType,$month1,$month2,$month,$dairly){

        $db2 = $this->load->database('otherdb', TRUE);
        $region = $this->session->userdata('user_region');
        $id = $this->session->userdata('user_login_id');

        if($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "PMG" || $this->session->userdata('user_type') == "CRM"  || $this->session->userdata('user_type') == "BOP"){

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType' AND  date(`sender_info`.`date_registered`) = '$dairly'   GROUP BY `sender_info`.`s_region`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";
                
                } 


                }
                
          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_region`";
          }else{

            $sql = "SELECT `sender_info`.`s_region` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  YEAR(`sender_info`.`date_registered`) = '$year'   GROUP BY `sender_info`.`s_region`";

          }
        
        }elseif ($this->session->userdata('user_type') == "RM") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

        } 

        }elseif($reportType == "Dairly"){

        $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
        AND  date(`sender_info`.`date_registered`) >= '$dairly' AND  GROUP BY `sender_info`.`s_district`";

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 GROUP BY `sender_info`.`s_district`";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 GROUP BY `sender_info`.`s_district`";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   GROUP BY `sender_info`.`s_district`";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 GROUP BY `sender_info`.`s_district`";
          }else{

            $sql = "SELECT `sender_info`.`s_district` as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'   GROUP BY `sender_info`.`s_district`";

          }

        }elseif ($this->session->userdata('user_type')== "EMPLOYEE" || $this->session->userdata('user_type')== "AGENT") {
            

        if ($reportType == "Weekly") {
           
        $y1 = date('Y',strtotime($date1));
        $y2 = date('Y',strtotime($date2));

        if ($y1 == $y2) {

        $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
        LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
        LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
        WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
        AND  date(`sender_info`.`date_registered`) >= '$date1' AND  date(`sender_info`.`date_registered`) <= '$date2' 
        AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

        } 

        }elseif($reportType == "Quartery"){
        
                $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "3") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "4" && $mon2 == "6") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "9") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                }elseif ($mon1 == "10" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
                
                } 


                }
                

          }elseif ($reportType == "Mid Report") {
              
              $m1 = explode('-', $month1);
                $m2 = explode('-', $month2);

                $mon1 = @$m1[0];
                $mon2 = @$m2[0];
                $y1 = @$m1[1];
                $y2 = @$m2[1];

                if($y1 == $y2){

                    if ($mon1 == "1" && $mon2 == "6") {
                    
                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' 
                AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }elseif ($mon1 == "7" && $mon2 == "12") {
                    
                    $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) >= '$mon1' AND  MONTH(`sender_info`.`date_registered`) <= '$mon2' 
                AND  YEAR(`sender_info`.`date_registered`) = '$y1'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

                }

                }

          }elseif ($reportType == "Monthly") {
              
                $m1 = explode('-', $month);
                $mon1 = @$m1[0];
                $y1 = @$m1[1];

                $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  MONTH(`sender_info`.`date_registered`) = '$mon1' AND  YEAR(`sender_info`.`date_registered`) = '$y1'  
                 AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";
          }else{

            $sql = "SELECT MONTH(`sender_info`.`date_registered`) as year,COUNT(`sender_info`.`sender_id`) as value,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info` 
                LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id` 
                LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
                LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id` 
                WHERE `transactions`.`status` = 'Paid' AND `transactions`.`PaymentFor` = '$catType'  
                AND  YEAR(`sender_info`.`date_registered`) = '$year'   AND `sender_info`.`operator` = '$id'
        GROUP BY MONTH(`sender_info`.`date_registered`)";

          }


        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function GetDistrictById($region_id){
            
            $this->db->where('region_id',$region_id);
            $this->db->order_by('district_name');
            $query = $this->db->get('em_district');
            $output ='<option value="">Select Property District</option>';
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->district_id.'">'.$row->district_name.'</option>';
            }
             return $output;
          }

        public function RealEsateGetDistrictById($region_id){
            
            $this->db->where('region_id',$region_id);
            $this->db->order_by('district_name');
            $query = $this->db->get('em_district');
            $output ='<option value="">District</option>';
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->district_name.'">'.$row->district_name.'</option>';
            }
             return $output;
          }

          public function get_region_info($region_id){
          $sql = "SELECT * FROM em_region WHERE region_name='$region_id'";
          $query=$this->db->query($sql);
          $result = $query->row();
          return $result;
          }


    }
?>