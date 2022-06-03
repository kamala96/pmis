<?php

class Bill_Customer_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
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
    public function save_bill_customer($save)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('corperate_regional_bill_customer', $save);
    }
    public function save_credit_bill_customer($save)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('bill_credit_customer', $save);
    }
    public function save_credit_bill_branch_customer($save1)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('branch_bill_credit_customer', $save1);
    }
    public function save_region_branch($insert)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('bill_region_branch_service', $insert);
    }
    public function update_customer_price($custid,$cid)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('customer_id', $custid);
        $db2->update('corperate_regional_bill_customer',$cid);
    }
    public function update_credit_bill_customer($save,$I)
    {
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('credit_id', $I);
        $db2->update('bill_credit_customer',$save);
    }
    public function get_credit_customer(){

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
        

     if($this->session->userdata('user_type') == "ACCOUNTANT"){

          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `credit_customer` WHERE `customer_region` = '$o_region' AND `services_type` = 'EMS Postage'";
          
      }else {

          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region' 
          AND `customer_branch` = '$o_branch' AND `services_type` = 'EMS Postage'";

      }

    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }
  public function get_bill_cust_details_info($id){

    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `bill_credit_customer` WHERE `credit_id` = '$id'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function get_bill_cust_prepaid_details_info(){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `credit_id` FROM `bill_credit_customer` WHERE `customer_type` = 'PrePaid'";
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public function update_bill_cust_prepaid_details_info($crdtid){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "UPDATE `bill_credit_customer`
               INNER JOIN 
              (SELECT SUM(`transactions`.`paidamount`) as total,`transactions`.* FROM `transactions`
              WHERE `transactions`.`serial` LIKE '%Prepaid%'
                 AND `transactions`.`status` = 'NotPaid'
                AND `transactions`.`CustomerID` ='$crdtid'
              ORDER BY `transactions`.`transactiondate` desc
              ) AS `transactions1` ON `transactions1`.`CustomerID` = `bill_credit_customer`.`credit_id` 
    SET `price`= (`bill_credit_customer`.`price` - `transactions1`.`total`)
    WHERE `bill_credit_customer`.`services_type` = 'EMS Postage'
     AND `bill_credit_customer`.`customer_type` ='PrePaid'
      AND `bill_credit_customer`.`credit_id` ='$crdtid'";
    $query  = $db2->query($sql);
    //$result = @$query->row();
    //return $result;
  }

   public function get_bill_cust_info($id){  

    $sql = "SELECT `bill_credit_customer`.*,`transactions`.* FROM `transactions`
    INNER JOIN `bill_credit_customer` ON `transactions`.`CustomerID`=`bill_credit_customer`.`credit_id` 
    WHERE  `bill_credit_customer`.`credit_id` = '$id' AND `transactions`.`paymentFor` = 'EMSBILLING'
    AND (`customer_acc` LIKE '%PREPAID%' OR  `customer_acc` LIKE '%POSTPAID%')
    ORDER BY `transactions`.`transactiondate` DESC  LIMIT 1 
    ";


    $db2 = $this->load->database('otherdb', TRUE);
    //$sql    = "SELECT * FROM  `transactions` WHERE `CustomerID`='$id' LIMIT 1";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
    public  function get_credit_customer_list_byAccnoMonth($acc_no,$month,$date){
        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        
        $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];

        $id = $this->session->userdata('user_login_id');
                $info = $this->GetBasic($id);
                $o_region = $info->em_region;
                $o_branch = $info->em_branch;
        

            if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

                if(!empty($date)){

                    $sql = "SELECT DISTINCT `transactions`.`Barcode`,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' AND `sender_info`.`operator` = '$id'
                    ORDER BY `sender_info`.`date_registered` ASC, `sender_info`.`s_region` ASC";

                }else{

                    $sql = "SELECT DISTINCT `transactions`.`Barcode`,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
                    LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
                    LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
                    LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

                    WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `sender_info`.`operator` = '$id'
                     -- AND `transactions`.`isBill_Id` = 'No'
                    ORDER BY `sender_info`.`date_registered` ASC, `sender_info`.`s_region` ASC";

                }

            

        }else{

            if(!empty($date)){

            $sql = "SELECT DISTINCT `transactions`.`Barcode`,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date' 
             AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`date_registered` ASC, `sender_info`.`s_region` ASC";
            
            }else{

                $sql = "SELECT DISTINCT `transactions`.`Barcode`,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
            AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' 
            ORDER BY `sender_info`.`date_registered` ASC, `sender_info`.`s_region` ASC";

            }

        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

public  function get_credit_customer_list_byAccnoMonth00($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
    

      if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT DISTINCT `transactions`.`Barcode`,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
      LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
      ORDER BY `sender_info`.`date_registered` ASC ";

    }else{

      $sql = "SELECT DISTINCT `transactions`.`Barcode`,`sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' 
AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' ORDER BY `sender_info`.`date_registered` ASC ";

    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public  function get_credit_customer_list_byAccnoMonth0($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
    

      if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type` 
      LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'No'
      ORDER BY `sender_info`.`sender_id` DESC ";

    }else{

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,`transactions`.* FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND `transactions`.`isBill_Id` = 'No'
AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill'";

    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public  function get_credit_customer_MAIL_list_byAccnoMonth($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
    

      if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    LEFT JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    LEFT JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
             AND `sender_person_info`.`operator`='$id'
             ORDER BY `sender_person_info`.`sender_date_created` ASC
              ";


    }else{

        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    LEFT JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    LEFT JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   
              `sender_person_info`.`acc_no` = '$acc_no'  
              -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
          
             -- `AND sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             ORDER BY `sender_person_info`.`sender_date_created` ASC
              ";


    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public  function get_credit_customer_MAIL_list_byAccnoMonth_bill($acc_no,$month,$date){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
    

      if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        if(!empty($date)){
        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    LEFT JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    LEFT JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator`='$id'
             ORDER BY `sender_person_info`.`sender_date_created` ASC";
        }
        else
        {
        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    LEFT JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    LEFT JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
             AND `sender_person_info`.`operator`='$id'
             ORDER BY `sender_person_info`.`sender_date_created` ASC
              ";
        }


    }
    else
    {

        if(!empty($date)){
        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    LEFT JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    LEFT JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   
              `sender_person_info`.`acc_no` = '$acc_no'  
              -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date'
          
             -- `AND sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             ORDER BY `sender_person_info`.`sender_date_created` ASC
              ";
        }
        else 
        {
        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    LEFT JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    LEFT JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   
              `sender_person_info`.`acc_no` = '$acc_no'  
              -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
          
             -- `AND sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             ORDER BY `sender_person_info`.`sender_date_created` ASC
              ";
        }


    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }

public  function get_credit_customer_MAIL_bulk_list_byAccnoMonth($acc_no,$month,$Asked,$date){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
    

      if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        if(!empty($date)){

        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`
              ";
        } else {

       $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
            AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`
              ";


        }


    } else {

         if(!empty($date)){

        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   
              `sender_person_info`.`acc_no` = '$acc_no'  
              -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date'
            AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`";
            } else {

            $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   
              `sender_person_info`.`acc_no` = '$acc_no'  
              -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
            AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`";

            }


    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }


 public  function get_credit_customer_latter_list_byAccnoMonth($acc_no,$month,$Asked,$date){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
    

      if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        if(!empty($date)){

        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                   
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`";
        } else {
  
        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                   
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
             AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`
              ";

        }


    }else{

        if(!empty($date)){

        $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no'  
             AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`";
               // AND sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
            } else {

           $sql = "SELECT DISTINCT `register_transactions`.`Barcode`,`sender_person_info`.*,`register_transactions`.* 
                    FROM   `sender_person_info`  
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no'  
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
              AND `sender_person_info`.`sender_type` = '$Asked' GROUP BY `register_transactions`.`Barcode`";
            }


    }
    
    $query=$db2->query($sql);
    $result = $query->result();
    return $result;
  }

    public  function get_credit_customer_sum_byAccnoMonth($acc_no,$month,$date){
        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        
        $m = explode('-', $month);

                $day = @$m[0];
                $year = @$m[1];

        $id = $this->session->userdata('user_login_id');
                $info = $this->GetBasic($id);
                $o_region = $info->em_region;
                $o_branch = $info->em_branch;

        if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

            if(!empty($date)){

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND date(`sender_info`.`date_registered`) = '$date' 
            ORDER BY `sender_info`.`sender_id` DESC ";

        }else{
            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

            WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year'
            ORDER BY `sender_info`.`sender_id` DESC ";

        }

        }else{

            if(!empty($date)){

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND date(`sender_info`.`date_registered`) = '$date'  AND `transactions`.`status` = 'Bill' ";

        }else{
            

            $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
            LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
            LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
            LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
            WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' ";


        }
        
        }

        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }


public  function get_credit_customer_sum_byAccnoMonth11($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' 
      ORDER BY `sender_info`.`sender_id` DESC ";

    }else{

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill'";
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }


public  function get_credit_customer_sum_byAccnoMonth0($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'No'
      ORDER BY `sender_info`.`sender_id` DESC ";

    }else{

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'No'";
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }


  public  function get_credit_MAIL_customer_sum_byAccnoMonth($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
          
              ";

     

    }else{

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
            
              -- AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
            
              ";
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public  function get_credit_MAIL_customer_sum_byAccnoMonth_bill($acc_no,$month,$date){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        if(!empty($date)){

        $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date'
          
              ";

        }
        else 
        {

        $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
          
              ";
        }

         

     

    }else{


     if(!empty($date)){
     $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date'
            
              -- AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
            
              ";
     }
     else
    {

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
            
              -- AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
            
              ";
    }
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }


 public  function get_credit_MAIL_bulk_customer_sum_byAccnoMonth($acc_no,$month,$Asked,$date){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        if(!empty($date)){

         $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND DATE(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked' 
              ";
        } else {

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
             AND `sender_person_info`.`sender_type` = '$Asked' 
              ";

        }

     

    }else{

    if(!empty($date)){

      $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked'";
       } else {

        $sql = "SELECT `sender_person_info`.*,`receiver_register_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
            AND `sender_person_info`.`sender_type` = '$Asked'
            
              ";
       }
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }


 public  function get_credit_latter_customer_sum_byAccnoMonth($acc_no,$month,$Asked,$date){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

        if(!empty($date)){

         $sql = "SELECT `sender_person_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`
                     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked'";
            } else {

          $sql = "SELECT `sender_person_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`
                     INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
             AND `sender_person_info`.`acc_no` = '$acc_no'  
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
             AND `sender_person_info`.`sender_type` = '$Asked'";

            }

     

    }else{

    if(!empty($date)){

      $sql = "SELECT `sender_person_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`sender_type` = '$Asked'
             
              "; // -- AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'
        } else {

          $sql = "SELECT `sender_person_info`.*,`register_transactions`.* ,SUM(`register_transactions`.`paidamount`) AS `paidamount`
                    FROM   `sender_person_info`  
                    INNER JOIN  `register_transactions`  ON   `sender_person_info`.`senderp_id`   = `register_transactions`.`register_id`
                    
            WHERE   `sender_person_info`.`acc_no` = '$acc_no' 
             -- AND `register_transactions`.`bill_status` = 'BILLING'
             AND MONTH(`sender_person_info`.`sender_date_created`) = '$day' AND YEAR(`sender_person_info`.`sender_date_created`) = '$year'
            AND `sender_person_info`.`sender_type` = '$Asked'
             
              "; // -- AND `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch'

        }
            
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }


  public  function get_credit_customer_sum_byAccnoMonth2($acc_no,$month){
    $regionfrom = $this->session->userdata('user_region');
    $db2 = $this->load->database('otherdb', TRUE);
    
    $m = explode('-', $month);

        $day = @$m[0];
        $year = @$m[1];

    $id = $this->session->userdata('user_login_id');
        $info = $this->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

    if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `sender_info`.`sender_id`=`transactions`.`CustomerID`

      WHERE `sender_info`.`s_region` = '$o_region' AND `sender_info`.`s_district` = '$o_branch' AND `transactions`.`customer_acc` = '$acc_no' AND `transactions`.`status` = 'Bill' AND MONTH(`sender_info`.`date_registered`) = '$day' AND MONTH(`sender_info`.`date_registered`) = '$year' AND `transactions`.`isBill_Id` = 'Ye'
      ORDER BY `sender_info`.`sender_id` DESC ";

    }else{

      $sql = "SELECT `sender_info`.*,`receiver_info`.*,`ems_tariff_category`.*,SUM(`transactions`.`paidamount`) AS `paidamount` FROM `sender_info`
      LEFT JOIN `receiver_info` ON `receiver_info`.`from_id`=`sender_info`.`sender_id`
      LEFT JOIN `ems_tariff_category` ON `ems_tariff_category`.`cat_id`=`sender_info`.`cat_type`
      LEFT JOIN `transactions` ON `transactions`.`CustomerID`=`sender_info`.`sender_id`
      WHERE `transactions`.`customer_acc` = '$acc_no' AND MONTH(`sender_info`.`date_registered`) = '$day' AND YEAR(`sender_info`.`date_registered`) = '$year' AND `transactions`.`status` = 'Bill' AND `transactions`.`isBill_Id` = 'Ye'";
    
    }

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }




  
  public function check_credit_customer($AskFor){

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
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

    if(!empty($query)){
        return $query->result();
    }else{
        return 0;
    }
  }
  
  public function check_credit_customer2($AskFor){

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
    
    if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  AND `bill_credit_customer`.`services_type` = '$AskFor'   GROUP BY `bill_credit_customer`.`acc_no`  ";
       
    }elseif($this->session->userdata('user_type') == "ADMIN") {

      $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` LIMIT 10";

    }elseif ($this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR") {

       
       $sql = "SELECT `bill_credit_customer`.*,`transactions1`.*, FROM `bill_credit_customer` 
               LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
                LEFT JOIN  ( SELECT * FROM `transactions`
                WHERE `transactions`.`serial` LIKE '%Prepaid%' 
                ORDER BY `transactions`.`transactiondate` desc
                ) AS `transactions1` ON `transactions1`.`CustomerID` = `bill_credit_customer`.`credit_id` 
                  WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' 
                  AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' 
                  AND  `bill_credit_customer`.`services_type` = '$AskFor'
                   GROUP BY `bill_credit_customer`.`acc_no`";
    
    
    
    }else{

        $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` LIMIT 10";

      }


    $query  = $db2->query($sql);

    if(!empty($query)){
        return $query->result();
    }else{
        return 0;
    }
  }


 public function check_credit_customer_search_employee($AskFor,$region,$month,$date,$custname){

     $dates = $date;//->format('Y-m-d');
    //$date1 = $this->session->userdata('date');
        $d1date = date('d',strtotime($dates));
        $m1date = date('m',strtotime($dates));
        $y1date = date('Y',strtotime($dates));
        
        $month1 = explode('-', $month);

        $month3 = @$month1[0];
        $year = @$month1[1];


    $o_region =$region;// $this->session->userdata('user_region');
    $user_o_region = $this->session->userdata('user_region');
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
           WHERE `branch_bill_credit_customer`.`customer_region` = '$user_o_region'  AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor'  
           GROUP BY `bill_credit_customer`.`acc_no` ";

        }else{

             $sql  = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$user_o_region' AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor'  AND `bill_credit_customer`.`customer_name` LIKE '%$custname%' 

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

 public function check_credit_customer_search_employee0($AskFor,$region,$month,$date,$custname){

     $dates = $date;//->format('Y-m-d');
    //$date1 = $this->session->userdata('date');
        $d1date = date('d',strtotime($dates));
        $m1date = date('m',strtotime($dates));
        $y1date = date('Y',strtotime($dates));
        
        $month1 = explode('-', $month);

        $month3 = @$month1[0];
        $year = @$month1[1];


    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
    
    if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {

        if(empty($custname)){

             $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  
       AND `bill_credit_customer`.`services_type` = '$AskFor' 
      
        GROUP BY `bill_credit_customer`.`acc_no`  
       ORDER BY `bill_credit_customer`.`acc_no` ASC";

        }else{

             $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  
       AND `bill_credit_customer`.`services_type` = '$AskFor' 
       AND `bill_credit_customer`.`customer_name` LIKE '%$custname%' 
        GROUP BY `bill_credit_customer`.`acc_no`  
       ORDER BY `bill_credit_customer`.`acc_no` ASC";

        }

       
       
    }elseif($this->session->userdata('user_type') == "ADMIN") {

         if(empty($custname)){

              $sql = "SELECT * FROM `bill_credit_customer` WHERE  
           `bill_credit_customer`.`services_type` = '$AskFor' 
           AND `bill_credit_customer`.`customer_region` = '$region'
          
          GROUP BY `bill_credit_customer`.`acc_no`  
       ORDER BY `bill_credit_customer`.`acc_no` ASC";

        }else{

              $sql = "SELECT * FROM `bill_credit_customer` WHERE  
           `bill_credit_customer`.`services_type` = '$AskFor' 
           AND `bill_credit_customer`.`customer_region` = '$region'
           AND `bill_credit_customer`.`customer_name` LIKE '%$custname%'   
          GROUP BY `bill_credit_customer`.`acc_no`  
       ORDER BY `bill_credit_customer`.`acc_no` ASC";

        }

         


    }elseif ($this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR") {

         if(empty($custname)){

             $sql    = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor'  
           GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `branch_bill_credit_customer`.`acc_no` ASC";

        }else{

             $sql    = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor'  AND `bill_credit_customer`.`customer_name` LIKE '%$custname%' 

           GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `branch_bill_credit_customer`.`acc_no` ASC";

        }

       
      }


    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }




  
  public function check_credit_customer_search($AskFor,$region,$month,$date,$custname){

     $dates = $date;//->format('Y-m-d');
    //$date1 = $this->session->userdata('date');
        $d1date = date('d',strtotime($dates));
        $m1date = date('m',strtotime($dates));
        $y1date = date('Y',strtotime($dates));
        
        $month1 = explode('-', $month);

        $month3 = @$month1[0];
        $year = @$month1[1];


    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');
    $db2 = $this->load->database('otherdb', TRUE);
    
    if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "RM") {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE `customer_region` = '$o_region'  AND `bill_credit_customer`.`services_type` = '$AskFor'   GROUP BY `bill_credit_customer`.`acc_no`  ORDER BY `bill_credit_customer`.`acc_no` ASC";
       
    }elseif($this->session->userdata('user_type') == "ADMIN") {

if(!empty($custname) )
{

   if(!empty($date) && !empty($month) && !empty($region)  )
    {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
       AND MONTH(`created_date`) = '$month3' AND YEAR(`created_date`) = '$year'
     AND date(`created_date`) = '$dates' AND `customer_region` = '$region' AND `customer_name` LIKE '%$custname%'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

      

    }
    elseif( !empty($month) && !empty($region)  )
    {

     $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
       AND MONTH(`created_date`) = '$month3' AND YEAR(`created_date`) = '$year'
    AND `customer_region` = '$region' AND `customer_name` LIKE '%$custname%'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
     AND date(`created_date`) = '$dates' AND `customer_region` = '$region' AND `customer_name` LIKE '%$custname%'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }
    elseif(!empty($region))
    {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
        AND `customer_region` = '$region' AND `customer_name` LIKE '%$custname%'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }
    else
    {
      $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
        AND `customer_name` LIKE '%$custname%'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }

}
else
{

   if(!empty($date) && !empty($month) && !empty($region)  )
    {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
       AND MONTH(`created_date`) = '$month3' AND YEAR(`created_date`) = '$year'
     AND date(`created_date`) = '$dates' AND `customer_region` = '$region' 
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

      

    }
    elseif( !empty($month) && !empty($region)  )
    {

     $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
       AND MONTH(`created_date`) = '$month3' AND YEAR(`created_date`) = '$year'
    AND `customer_region` = '$region'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }
    elseif(!empty($date) &&  !empty($region)  )
    {

      $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
     AND date(`created_date`) = '$dates' AND `customer_region` = '$region'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }
    else
    {

       $sql    = "SELECT * FROM `bill_credit_customer` WHERE  `bill_credit_customer`.`services_type` = '$AskFor'
        AND `customer_region` = '$region'
      GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `bill_credit_customer`.`acc_no` ASC ";

    }

}

   

     

    }elseif ($this->session->userdata('user_type') == "AGENT" || $this->session->userdata('user_type') == "EMPLOYEE" || $this->session->userdata('user_type') == "SUPERVISOR") {

        $sql    = "SELECT `bill_credit_customer`.* FROM `bill_credit_customer`  
          LEFT JOIN `branch_bill_credit_customer` ON `branch_bill_credit_customer`.`acc_no` = `bill_credit_customer`.`acc_no` 
           WHERE `branch_bill_credit_customer`.`customer_region` = '$o_region' AND `branch_bill_credit_customer`.`customer_branch` = '$o_branch' AND `bill_credit_customer`.`services_type` = '$AskFor' GROUP BY `bill_credit_customer`.`acc_no` ORDER BY `branch_bill_credit_customer`.`acc_no` ASC";
      }


    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }







  public  function getPay($type){

    $db2 = $this->load->database('otherdb', TRUE);

    $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions`
    INNER JOIN `credit_customer` ON `transactions`.`CustomerID`=`credit_customer`.`credit_id` 
    WHERE `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`status` = 'Paid' AND `credit_customer`.`acc_no` = '$type' ORDER BY `transactions`.`id` DESC LIMIT 1";

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }

public  function getPayMAIL($type){

    $db2 = $this->load->database('otherdb', TRUE);

    $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions`
    INNER JOIN `credit_customer` ON `transactions`.`CustomerID`=`credit_customer`.`credit_id` 
    WHERE `transactions`.`PaymentFor` = 'MAILBILLING' AND `transactions`.`status` = 'Paid' AND `credit_customer`.`acc_no` = '$type' ORDER BY `transactions`.`id` DESC LIMIT 1";

    $query=$db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public  function get_ems_billing_list3($acc){

         $db2 = $this->load->database('otherdb', TRUE);

      $sql = "SELECT * FROM `transactions` WHERE `customer_acc` = '$acc' AND `PaymentFor` = 'EMSBILLING' ORDER BY `id` DESC LIMIT 1";
        
        $query=$db2->query($sql);
          $result = $query->row();
        return $result;
    }

    public  function get_ems_billing_list34($acc){

         $db2 = $this->load->database('otherdb', TRUE);

      $sql = "SELECT * FROM `transactions` WHERE `customer_acc` = '$acc' AND `PaymentFor` = 'EMSBILLING' AND `status` = 'Paid' ORDER BY `id` DESC LIMIT 1";
        
        $query=$db2->query($sql);
          $result = $query->row();
        return $result;
    }


    public function get_bill_customer(){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `bill_credit_customer` WHERE `services_type` = 'EMS Postage'";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function get_customer_bill_credit_by_id($crdtid){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `bill_credit_customer` WHERE `credit_id` = '$crdtid'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_bill_customer_by_id($cust){
      
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `corperate_regional_bill_customer` WHERE `customer_id` = '$cust'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_all_bill_customer_saved_to(){
      
       $db2 = $this->load->database('otherdb', TRUE);

       $o_region = $this->session->userdata('user_region');
       $o_branch = $this->session->userdata('user_branch');

        $sql = "SELECT `em_branch`.*,`em_region`.*,`bill_region_branch_service`.*,`corperate_regional_bill_customer`.* 
        FROM `em_branch` 
        INNER JOIN `em_region` ON `em_region`.`region_id` = `em_branch`.`region_id` 
        INNER JOIN `bill_region_branch_service` ON `bill_region_branch_service`.`region` = `em_region`.`region_id` 
        INNER JOIN `corperate_regional_bill_customer` ON `corperate_regional_bill_customer`.`customer_id` = `bill_region_branch_service`.`customer`  
        WHERE  `em_region`.`region_name` = '$o_region' AND `em_branch`.`branch_name` = '$o_branch'";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function GetBranchById($region_id){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `em_branch`.*,`em_region`.*  
               FROM `em_branch` 
               INNER JOIN `em_region`  ON  `em_region`.`region_id` = `em_branch`.`region_id`
               WHERE `em_region`.`region_id`='$region_id'";
      $query =  $db2->query($sql);
      $output ='<option value="">Select Branch</option>';
      foreach ($query->result() as $row) {
        $output .='<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
      }
       return $output;
      }

      public function get_register_bill_list(){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `payment_type` = 'Bill' ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' 
                     ";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                     
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill'";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

      public function get_register_BULK_bill_list($services_type){

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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `payment_type` = 'Bill' AND `sender_type` = '$services_type' ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' AND `sender_type` = '$services_type' 
                     ";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                     
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' AND `sender_type` = '$services_type'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                   
                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' AND `sender_type` = '$services_type'";
            }

        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;         
    }

     public function get_latter_bill_list(){

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

                $sql    = "SELECT `sender_person_info`.*
                   FROM   `sender_person_info`  
                  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `payment_type` = 'Bill' AND `register_type` = 'Ordinary Latter'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*
                   FROM   `sender_person_info`  
                 
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' AND `register_type` = 'Ordinary Latter' 
                     ";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*
                   FROM   `sender_person_info`  
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' AND `register_type` = 'Ordinary Latter'";

            }else{

                $sql    = "SELECT `sender_person_info`.*
                   FROM   `sender_person_info`  

                   WHERE date(`sender_person_info`.`sender_date_created`) = '$date' AND `payment_type` = 'Bill' AND `register_type` = 'Ordinary Latter'";
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

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`payment_type` = 'Bill'";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`payment_type` = 'Bill' AND date(`sender_person_info`.`sender_date_created`) = '$date'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id` 
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`   
                    WHERE  `sender_person_info`.`payment_type` = 'Bill' AND date(`sender_person_info`.`sender_date_created`) = '$date'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 



public function get_sum_BULK_register($services_type){

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
                    
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`payment_type` = 'Bill' AND `sender_type` = '$services_type' ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`payment_type` = 'Bill' AND `sender_type` = '$services_type'  AND date(`sender_person_info`.`sender_date_created`) = '$date'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id` 
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill' AND `sender_type` = '$services_type' ";

            }else{

                $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`   
                    WHERE  `sender_person_info`.`payment_type` = 'Bill' AND `sender_type` = '$services_type'  AND date(`sender_person_info`.`sender_date_created`) = '$date'";
            }

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
    $sql    = "SELECT `sender_person_info`.*,`receiver_register_info`.*
                   FROM   `sender_person_info`  
                   INNER JOIN  `receiver_register_info` ON  `receiver_register_info`.`sender_id` = `sender_person_info`.`senderp_id`
                
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_status` = 'Counter' AND `sender_person_info`.`operator` = '$ids' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill'";

    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;

  }

  public function check_latter_item_status($ids){

     $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

    $o_region = $this->session->userdata('user_region');
    $o_branch = $this->session->userdata('user_branch');

    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `sender_person_info`.*
                   FROM   `sender_person_info`  
                  
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_status` = 'Counter' AND `sender_person_info`.`operator` = '$ids' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill' AND `register_type` = 'Ordinary Latter'";

    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;

  }

   public function get_sum_latter(){

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

                $sql    = "SELECT `sender_person_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`operator` = '$emid' AND `sender_person_info`.`payment_type` = 'Bill' AND `sender_person_info`.`register_type` = 'Ordinary Latter' ";

            }elseif($this->session->userdata('user_type') == "SUPERVISOR"){

                $sql    = "SELECT `sender_person_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                     
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND `sender_person_info`.`sender_branch` = '$o_branch' AND `sender_person_info`.`payment_type` = 'Bill' AND date(`sender_person_info`.`sender_date_created`) = '$date'
                   AND `sender_person_info`.`register_type` = 'Ordinary Latter'";

            }elseif ($this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "ACCOUNTANT") {

                $sql    = "SELECT `sender_person_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                 
                   WHERE `sender_person_info`.`sender_region` = '$o_region' AND date(`sender_person_info`.`sender_date_created`) = '$date' AND `sender_person_info`.`payment_type` = 'Bill' AND `sender_person_info`.`register_type` = 'Ordinary Latter'";

            }else{

                $sql    = "SELECT `sender_person_info`.*,SUM(`sender_person_info`.`register_price`) AS paidamount 
                   FROM   `sender_person_info`  
                   
                    WHERE  `sender_person_info`.`payment_type` = 'Bill' AND date(`sender_person_info`.`sender_date_created`) = '$date'
                    AND `sender_person_info`.`register_type` = 'Ordinary Latter'";
            }

        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;         
    } 

   

  public  function get_bill_transactions_list(){

      $db2 = $this->load->database('otherdb', TRUE);
      $region = $this->session->userdata('user_region');
      
      if ($this->session->userdata('user_type') == "ACCOUNTANT") {

        $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  AND `credit_customer`.`customer_region` = '$region'  ORDER BY `transactions`.`billid` ASC";

      }elseif ($this->session->userdata('user_type') == "EMPLOYEE") {

        $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  AND `credit_customer`.`customer_region` = '$region'  ORDER BY `transactions`.`billid` ASC";

      }else{

        $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  ORDER BY `transactions`.`paymentdate` DESC";

      }
      
        
        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

    public  function get_bulk__bill_transactions_list($services_type){

      $db2 = $this->load->database('otherdb', TRUE);
      $region = $this->session->userdata('user_region');
      
      if ($this->session->userdata('user_type') == "ACCOUNTANT") {

        $sql = "SELECT `bill_credit_customer`.*,`transactions`.* FROM `transactions` 
       INNER JOIN `sender_person_info` ON `sender_person_info`.`senderp_id` = `transactions`.`CustomerID`
             INNER JOIN `bill_credit_customer` ON `bill_credit_customer`.`acc_no` = `sender_person_info`.`acc_no` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  AND `bill_credit_customer`.`customer_region` = '$region'   AND  `bill_credit_customer`.`services_type` = '$services_type' ORDER BY `transactions`.`billid` ASC";

      }else{

        $sql = "SELECT `bill_credit_customer`.*,`transactions`.* FROM `transactions` 
       INNER JOIN `sender_person_info` ON `sender_person_info`.`senderp_id` = `transactions`.`CustomerID`
             INNER JOIN `bill_credit_customer` ON `bill_credit_customer`.`acc_no` = `sender_person_info`.`acc_no`  
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0

       AND  `bill_credit_customer`.`services_type` = '$services_type'  ORDER BY `transactions`.`paymentdate` DESC";

      }
      
        
        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

   

    public  function get_bill_transactions_list_posta_global(){

      $db2 = $this->load->database('otherdb', TRUE);
      $region = $this->session->userdata('user_region');
      
      if ($this->session->userdata('user_type') == "ACCOUNTANT") {

        $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID` 
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  AND `ems_bill_companies`.`com_region` = '$region'  ORDER BY `transactions`.`billid` ASC";

      }else{

        $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
      INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID`  
      WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0  ORDER BY `transactions`.`paymentdate` DESC";

      }
      
        
        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

    public  function get_bill_transactions_list_search($cusname,$status){

         $db2 = $this->load->database('otherdb', TRUE);
         $region = $this->session->userdata('user_region');
          if ($this->session->userdata('user_type') == "ACCOUNTANT") {
            $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `credit_customer`.`customer_name` LIKE '%$cusname%' AND `transactions`.`status` = '$status'  AND `credit_customer`.`customer_region` = '$region' ORDER BY `transactions`.`billid` ASC";
          } 
           elseif ($this->session->userdata('user_type') == "EMPLOYEE") {

             $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `credit_customer`.`customer_name` LIKE '%$cusname%' AND `transactions`.`status` = '$status'  AND `credit_customer`.`customer_region` = '$region' ORDER BY `transactions`.`billid` ASC";

           }else {

            $sql = "SELECT `credit_customer`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `credit_customer` ON `credit_customer`.`credit_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `credit_customer`.`customer_name` LIKE '%$cusname%' AND `transactions`.`status` = '$status' ORDER BY `transactions`.`billid` ASC";
          }

        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

      public  function get_bulk_bill_transactions_list_search($cusname,$status,$services_type){

         $db2 = $this->load->database('otherdb', TRUE);
         $region = $this->session->userdata('user_region');
          if ($this->session->userdata('user_type') == "ACCOUNTANT") {
            $sql = "SELECT ` bill_credit_customer`.*,`transactions`.* FROM `transactions` 
             INNER JOIN `sender_person_info` ON `sender_person_info`.`senderp_id` = `transactions`.`CustomerID`
             INNER JOIN `bill_credit_customer` ON ` bill_credit_customer`.`acc_no` = `sender_person_info`.`acc_no` 
                
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND ` bill_credit_customer`.`customer_name` = '$cusname' AND `transactions`.`status` = '$status'  AND ` bill_credit_customer`.`customer_region` = '$region'
                AND  ` bill_credit_customer`.`services_type` = '$services_type' ORDER BY `transactions`.`billid` ASC";
          } else {


            $sql = "SELECT ` bill_credit_customer`.*,`transactions`.* FROM `transactions` 
                 INNER JOIN `sender_person_info` ON `sender_person_info`.`senderp_id` = `transactions`.`CustomerID`
             INNER JOIN `bill_credit_customer` ON ` bill_credit_customer`.`acc_no` = `sender_person_info`.`acc_no`  
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND ` bill_credit_customer`.`customer_name` = '$cusname' AND `transactions`.`status` = '$status'
                AND  ` bill_credit_customer`.`services_type` = '$services_type' ORDER BY `transactions`.`billid` ASC";
          }

        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }

    public  function get_bill_transactions_list_search_posta_global($cusname,$status){

         $db2 = $this->load->database('otherdb', TRUE);
         $region = $this->session->userdata('user_region');
          if ($this->session->userdata('user_type') == "ACCOUNTANT") {
            $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `ems_bill_companies`.`com_name` = '$cusname' AND `transactions`.`status` = '$status'  AND `ems_bill_companies`.`com_region` = '$region' ORDER BY `transactions`.`billid` ASC";
          } else {

            $sql = "SELECT `ems_bill_companies`.*,`transactions`.* FROM `transactions` 
                INNER JOIN `ems_bill_companies` ON `ems_bill_companies`.`com_id` = `transactions`.`CustomerID` 
                WHERE  `transactions`.`PaymentFor` = 'EMSBILLING' AND `transactions`.`paidamount` != 0 AND `ems_bill_companies`.`com_name` = '$cusname' AND `transactions`.`status` = '$status' ORDER BY `transactions`.`billid` ASC";
          }

        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }
    public function updatePaymentControlNumber($serial,$amount){

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
    curl_close ($ch);
    $result = json_decode($response);
      
      if (@$result->status == 103 && @$result->channel != '') {
           
           $db2 = $this->load->database('otherdb', TRUE);
           $db2->set('billid', @$result->controlno);
           $db2->set('status','Paid');
           $db2->set('receipt', @$result->receipt);
           $db2->set('paychannel', @$result->channel);
           $db2->set('paymentdate', @$result->paydate);
           $db2->where('serial',@$result->billid);
           $db2->update('transactions');

      }else{

           $db2 = $this->load->database('otherdb', TRUE);
           $db2->set('billid', @$result->controlno);
           $db2->set('status', 'NotPaid');
           $db2->where('serial',@$result->billid);
           $db2->update('transactions');

      }
    }


}
?>