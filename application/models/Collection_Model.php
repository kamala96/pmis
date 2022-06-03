<?php

class Collection_Model extends CI_Model{


//////////////////////////EMS

public  function get_ems_employee_report($fromdate,$todate,$emid){

        $regionfrom = $this->session->userdata('user_region');
        //$emid = $this->session->userdata('user_login_id');
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

        }elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == 'SUPER ADMIN'){
            
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



    public  function get_ems_employee_bill_report($fromdate,$todate,$emid){

        $regionfrom = $this->session->userdata('user_region');
        //$emid = $this->session->userdata('user_login_id');
        $Region = $this->session->userdata('user_region');
    $Branch = $this->session->userdata('user_branch');
        $db2 = $this->load->database('otherdb', TRUE);

        if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND `sender_info`.`operator` = '$emid'
            AND `sender_info`.`s_region` = '$Region' AND `sender_info`.`s_district` = '$Branch'
      AND `transactions`.`status`='Bill' ORDER BY `sender_info`.`sender_id` DESC";


        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Bill' AND `sender_info`.`s_region` = '$Region' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC ";

        }elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPPORTER' || $this->session->userdata('user_type') == 'SUPER ADMIN'){
            
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
            FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

        }else{

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`transactions`.*
            FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`status` = 'Bill' AND `transactions`.`office_name` = 'Counter' AND date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate' ORDER BY `sender_info`.`sender_id` DESC";

        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


//////////////////////////EMS


/////////////////MAILS

public  function get_cash_mail_employee_report($fromdate,$todate,$emid){

        $regionfrom = $this->session->userdata('user_region');
        //$emid = $this->session->userdata('user_login_id');
        $Region = $this->session->userdata('user_region');
    $Branch = $this->session->userdata('user_branch');
        $db2 = $this->load->database('otherdb', TRUE);

        if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`status` = 'Paid' 
     AND `sender_person_info`.`sender_region` = '$Region' 
     AND `sender_person_info`.`sender_branch` = '$Branch'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`status` = 'Paid' 
     AND `sender_person_info`.`sender_region` = '$Region' 
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPER ADMIN'){
            
        $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`status` = 'Paid'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }else{

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`status` = 'Paid'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


public  function get_bill_mail_employee_report($fromdate,$todate,$emid){

        $regionfrom = $this->session->userdata('user_region');
        //$emid = $this->session->userdata('user_login_id');
        $Region = $this->session->userdata('user_region');
    $Branch = $this->session->userdata('user_branch');
        $db2 = $this->load->database('otherdb', TRUE);

        if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`bill_status` = 'BILLING' 
     AND `sender_person_info`.`sender_region` = '$Region' 
     AND `sender_person_info`.`sender_branch` = '$Branch'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT'){

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`bill_status` = 'BILLING' 
     AND `sender_person_info`.`sender_region` = '$Region' 
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPER ADMIN'){
            
        $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`bill_status` = 'BILLING'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }else{

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`bill_status` = 'BILLING'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }


////////////////Delivery Registered (RDP,FPL)
public function emp_list_registered_international_list_search($fromdate,$todate,$empid){
        $db2 = $this->load->database('otherdb', TRUE);
        //$empid = $this->session->userdata('user_emcode');
        $region = $this->session->userdata('user_region');
        $branch = $this->session->userdata('user_branch');

        if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
         $sql = "SELECT * FROM `registered_international` LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            WHERE DATE(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `registered_international`.`Created_byId` = '$empid'
            AND `transactions`.`status`='Paid'
             ORDER BY `registered_international`.`date_created` DESC";
          }
          elseif($this->session->userdata('user_type') == 'RM'){
          $sql = "SELECT * FROM `registered_international` LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            WHERE DATE(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `registered_international`.`region` = '$region' 
           AND `transactions`.`status`='Paid'
            ORDER BY `registered_international`.`date_created` DESC";
          }
          else{
          $sql = "SELECT * FROM `registered_international` LEFT JOIN `transactions` ON `transactions`.`serial`=`registered_international`.`serial`
            WHERE DATE(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' 
            AND `transactions`.`status`='Paid'
            ORDER BY `registered_international`.`date_created` DESC";
          }

        $query = $db2->query($sql);
        $result = $query->result();
        return $result;

        }

//////////////////// Small Packets Delivery (FGN)
 public function employee_smallpacket_delivery_application_list($fromdate,$todate,$empid){

            $db2 = $this->load->database('otherdb', TRUE);
            //$empid = $this->session->userdata('user_login_id');
            $region = $this->session->userdata('user_region');
            $branch = $this->session->userdata('user_branch');


              if ($this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "SUPERVISOR") {

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                   WHERE date(`derivery_info`.`datetime`) BETWEEN '$fromdate' AND '$todate' AND `derivery_info`.`operator` = '$empid' 
                   AND `derivery_transactions`.`status`='Paid'
                   ORDER BY `derivery_info`.`datetime` DESC";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE `derivery_info`.`region` = '$region' AND date(`derivery_info`.`datetime`) BETWEEN '$fromdate' AND '$todate' 
                    AND `derivery_transactions`.`status`='Paid'
                    ORDER BY `derivery_info`.`datetime` DESC";

            }else{

                $sql    = "SELECT `derivery_info`.*,`derivery_transactions`.* FROM   `derivery_info`  
                   INNER JOIN  `derivery_transactions`  ON   `derivery_transactions`.`register_id`   = `derivery_info`.`id_id`  
                    WHERE  date(`derivery_info`.`datetime`) BETWEEN '$fromdate' AND '$todate' 
                    AND `derivery_transactions`.`status`='Paid'
                    ORDER BY `derivery_info`.`datetime` DESC";
            }

          

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

public function get_country_info($countrycode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM country_zone where country_id='$countrycode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function box_status($reff_cust_id){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('reff_cust_id',$reff_cust_id);
        $query = $db2->get('box_numbers');
        $result = $query->row();
        return $result;
        
}

////////////////BOX APPLICATION
public  function get_box_listt($fromdate,$todate,$emcode){

          $o_region = $this->session->userdata('user_region');
          $o_branch = $this->session->userdata('user_branch');
          //$emid = $this->session->userdata('user_login_id');
          //$emcode = $this->session->userdata('user_emcode');
        $db2 = $this->load->database('otherdb', TRUE);


if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {


        $sql = "SELECT `customer_details`.*,`transactions`.*,`Outstanding`.* FROM `customer_details`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
        LEFT JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
        WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$o_region'
        AND `transactions`.`district` = '$o_branch' AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' 
        AND `Outstanding`.`Created_byId` = '$emcode' AND `transactions`.`status`='Paid' GROUP BY `transactions`.`billid`
        ORDER BY `transactions`.`transactiondate` DESC ";

        }elseif($this->session->userdata('user_type') == 'RM' || $this->session->userdata('user_type') == 'ACCOUNTANT') {

        $sql = "SELECT `customer_details`.*,`transactions`.*,`Outstanding`.* FROM `customer_details`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
        LEFT JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
        WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$o_region' AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate'
        AND `transactions`.`status`='Paid'
        ORDER BY `transactions`.`transactiondate` DESC ";

        }
        elseif($this->session->userdata('user_type') == 'ADMIN' || $this->session->userdata('user_type') == 'SUPER ADMIN')
        {
        
        $sql = "SELECT `customer_details`.*,`transactions`.*,`Outstanding`.* FROM `customer_details`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
        LEFT JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
        WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate'
        AND `transactions`.`status`='Paid'
        ORDER BY `transactions`.`transactiondate` DESC ";

        } else {

        $sql = "SELECT `customer_details`.*,`transactions`.*,`Outstanding`.* FROM `customer_details`
        LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`customer_details`.`details_cust_id`
        LEFT JOIN `Outstanding` ON `Outstanding`.`serial`=`transactions`.`serial`
        WHERE `transactions`.`PaymentFor` = 'POSTSBOX' AND `transactions`.`region` = '$o_region'
        AND `transactions`.`district` = '$o_branch' AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' 
        AND `transactions`.`status`='Paid'
        AND `Outstanding`.`Created_byId` = '$emcode'
        ORDER BY `transactions`.`transactiondate` DESC ";

        }

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

/////////////SALES OF STAMP
public function get_stamp_list($fromdate,$todate,$id){

$o_region = $this->session->userdata('user_region');
$o_branch = $this->session->userdata('user_branch');
//$emid = $this->session->userdata('user_login_id');
//$id = $this->session->userdata('user_emcode');

$db2 = $this->load->database('otherdb', TRUE);

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `Stamp`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Stamp`.`serial` WHERE `transactions`.`status` != 'OldPaid' 
            AND `Stamp`.`region` = '$o_region' 
            AND `Stamp`.`branch` = '$o_branch' 
            AND `Stamp`.`Created_byId` = '$id' 
            AND  `Stamp`.`serial`  LIKE '%STAMP%'  
            AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `Stamp`.`date_created` DESC";

        } elseif($this->session->userdata('user_type') == 'RM'|| $this->session->userdata('user_type') == "ACCOUNTANT"){
           $sql = "SELECT * FROM `Stamp`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Stamp`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' 
            AND `Stamp`.`region` = '$o_region' 
            AND  `Stamp`.`serial`  LIKE '%STAMP%'
            AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `Stamp`.`date_created` DESC";

        } else {
           $sql = "SELECT * FROM `Stamp`
           LEFT JOIN `transactions` ON `transactions`.`serial`=`Stamp`.`serial`
           WHERE `transactions`.`status` != 'OldPaid' 
           AND  `Stamp`.`serial`  LIKE '%STAMP%'   
           AND date(`transactions`.`transactiondate`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
           ORDER BY `Stamp`.`date_created` DESC";
        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
    }

///////////Lock Replacement Transaction
public function get_Keydeposity_list($fromdate,$todate,$id){

$db2 = $this->load->database('otherdb', TRUE);
$o_region = $this->session->userdata('user_region');
$o_branch = $this->session->userdata('user_branch');
//$emid = $this->session->userdata('user_login_id');
//$id = $this->session->userdata('user_emcode');


if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `Keydeposity`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' 
            AND `Keydeposity`.`region` = '$o_region' 
            AND `Keydeposity`.`branch` = '$o_branch' 
            AND `Keydeposity`.`Created_byId` = '$id'  
            AND date(`Keydeposity`.`date_created`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `Keydeposity`.`date_created` DESC";

        } elseif($this->session->userdata('user_type') == 'RM'){
           $sql = "SELECT * FROM `Keydeposity`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' 
            AND `Keydeposity`.`region` = '$o_region' 
            AND date(`Keydeposity`.`date_created`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `Keydeposity`.`date_created` DESC";

        } else {
           $sql = "SELECT * FROM `Keydeposity`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Keydeposity`.`serial`
            WHERE `transactions`.`status` != 'OldPaid'
            AND date(`Keydeposity`.`date_created`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `Keydeposity`.`date_created` DESC";

        }

                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
        }

/////Authorite Card
public function get_AuthorityCard_list($fromdate,$todate,$id){

$db2 = $this->load->database('otherdb', TRUE);
$o_region = $this->session->userdata('user_region');
$o_branch = $this->session->userdata('user_branch');
//$emid = $this->session->userdata('user_login_id');
//$id = $this->session->userdata('user_emcode');

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `AuthorityCard`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' 
            AND `AuthorityCard`.`region` = '$o_region' 
            AND `AuthorityCard`.`branch` = '$o_branch' 
            AND `AuthorityCard`.`Created_byId` = '$id'  
            AND DATE(`AuthorityCard`.`date_created`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `AuthorityCard`.`date_created` DESC";

        } elseif($this->session->userdata('user_type') == 'RM'){
           $sql = "SELECT * FROM `AuthorityCard`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' 
            AND `AuthorityCard`.`region` = '$o_region'
            AND DATE(`AuthorityCard`.`date_created`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `AuthorityCard`.`date_created` DESC";

        } else {
           $sql = "SELECT * FROM `AuthorityCard`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`AuthorityCard`.`serial`
            WHERE `transactions`.`status` != 'OldPaid'  
            AND DATE(`AuthorityCard`.`date_created`) BETWEEN '$fromdate' AND '$todate' AND `transactions`.`status`='Paid'
            ORDER BY `AuthorityCard`.`date_created` DESC";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }

////////////INTERNET
public function get_Internet_list($fromdate,$todate,$id){

            $db2 = $this->load->database('otherdb', TRUE);
            //$id2 = $this->session->userdata('user_login_id');
            //$info = $this->employee_model->GetBasic($id2);
            
            //$id = $info->em_code;
            
            //$o_region = $info->em_region;
            //$o_branch = $info->em_branch;

          $sql = "SELECT * FROM `Internet`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Internet`.`serial`
            WHERE `transactions`.`status` = 'Paid' AND `Internet`.`Created_byId` = '$id'  
            AND DATE(`Internet`.`date_created`) BETWEEN '$fromdate' AND '$todate'
            ORDER BY `Internet`.`date_created` DESC";

        $query = $db2->query($sql);
        $result = $query->result();
        return $result;
            
        }

///////////////SUPERVISOR EMPLOYEE LIST
public function supervisor_employee_list(){
$o_region = $this->session->userdata('user_region');
$departmentid = $this->session->userdata('departmentid');
$sql = "SELECT * FROM employee WHERE dep_id='$departmentid' AND em_region='$o_region' AND em_role='EMPLOYEE' AND status='ACTIVE'";
$query=$this->db->query($sql);
$result = $query->result();
return $result;

}

//////////////////////EMS CONSOLIDATED REPORT
public  function get_ems_consolidated_report($fromdate,$todate,$emid,$Region,$Branch,$status){

        $db2 = $this->load->database('otherdb', TRUE);

            $sql = "SELECT `sender_info`.`serial` AS barcode,`sender_info`.*,`receiver_info`.*,`transactions`.* FROM `sender_info`
            INNER JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            INNER JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE date(`sender_info`.`date_registered`) BETWEEN '$fromdate' AND '$todate'  AND `sender_info`.`operator` = '$emid'
            AND `sender_info`.`s_region` = '$Region' AND `sender_info`.`s_district` = '$Branch'
            AND `transactions`.`status`='$status' ORDER BY `sender_info`.`sender_id` DESC";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

public  function get_mails_consolidated_report($fromdate,$todate,$emid,$Region,$Branch,$status){

     $db2 = $this->load->database('otherdb', TRUE);

     $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
     FROM   `sender_person_info`  
     INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`  
     WHERE `sender_person_info`.`operator` = '$emid' AND 
     DATE(`sender_person_info`.`sender_date_created`) BETWEEN '$fromdate' AND '$todate' AND
     `register_transactions`.`bill_status` = '$status' 
     AND `sender_person_info`.`sender_region` = '$Region' 
     AND `sender_person_info`.`sender_branch` = '$Branch'
     ORDER BY `sender_person_info`.`senderp_id` DESC";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }
/////////////////////END OF EMS CONSOLIDATED REPORT

}