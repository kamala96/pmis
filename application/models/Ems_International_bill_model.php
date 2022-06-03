<?php

class Ems_International_bill_model extends CI_Model{


    public function check_credit_customer(){

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $AskFor = "EMS INTERNATIONAL";
    $db2 = $this->load->database('otherdb', TRUE);
    
    if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  AND `bill_credit_customer`.`services_type` = '$AskFor'   GROUP BY `bill_credit_customer`.`acc_no`  ";
       
    }elseif($this->session->userdata('user_type') == "ADMIN") {

      $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` LIMIT 10";

    }elseif ($this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR") {

        $sql    = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` ";
      }else{

        $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` LIMIT 10";

      }


    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }


  public function check_credit_customer_search_employee($region,$month,$date,$custname){

     $dates = $date;//->format('Y-m-d');
    //$date1 = $this->session->userdata('date');
        $d1date = date('d',strtotime($dates));
        $m1date = date('m',strtotime($dates));
        $y1date = date('Y',strtotime($dates));
        
        $month1 = explode('-', $month);

        $month3 = @$month1[0];
        $year = @$month1[1];

        $AskFor = "EMS INTERNATIONAL";


    $o_region =$region;// $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
    
    if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {

        if(empty($custname)){

             $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  
       AND `bill_credit_customer`.`services_type` = '$AskFor' 
      
        GROUP BY `bill_credit_customer`.`acc_no` ";

        }else{

             $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  
       AND `bill_credit_customer`.`services_type` = '$AskFor' 
       AND `bill_credit_customer`.`customer_name` LIKE '%$custname%' 
        GROUP BY `bill_credit_customer`.`acc_no`";

        }

       
       
    }elseif($this->session->userdata('user_type') == "ADMIN") {

         if(empty($custname)){

              $sql = "SELECT * FROM `bill_credit_customer` WHERE  
           `bill_credit_customer`.`services_type` = '$AskFor' 
           AND `bill_credit_customer`.`customer_region` = '$region'
          
          GROUP BY `bill_credit_customer`.`acc_no`  
      ";

        }else{

              $sql = "SELECT * FROM `bill_credit_customer` WHERE  
           `bill_credit_customer`.`services_type` = '$AskFor' 
           AND `bill_credit_customer`.`customer_region` = '$region'
           AND `bill_credit_customer`.`customer_name` LIKE '%$custname%'   
          GROUP BY `bill_credit_customer`.`acc_no`  
     ";

        }

         


    }elseif ($this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR") {

         if(empty($custname)){

             $sql    = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region'  AND `bill_credit_customer`.`services_type` = '$AskFor'  
           GROUP BY `bill_credit_customer`.`acc_no` ";

        }else{

             $sql  = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' AND `bill_credit_customer`.`services_type` = '$AskFor'  AND `bill_credit_customer`.`customer_name` LIKE '%$custname%' 

           GROUP BY `bill_credit_customer`.`acc_no` ";

        }

       
      }else{

         if(empty($custname)){

              $sql = "SELECT * FROM `bill_credit_customer` WHERE  
           `bill_credit_customer`.`services_type` = '$AskFor' 
           AND `bill_credit_customer`.`customer_region` = '$region'
          
          GROUP BY `bill_credit_customer`.`acc_no`  
      ";

        }else{

              $sql = "SELECT * FROM `bill_credit_customer` WHERE  
           `bill_credit_customer`.`services_type` = '$AskFor' 
           AND `bill_credit_customer`.`customer_region` = '$region'
           AND `bill_credit_customer`.`customer_name` LIKE '%$custname%'   
          GROUP BY `bill_credit_customer`.`acc_no`  
     ";

        }
    }



    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

}