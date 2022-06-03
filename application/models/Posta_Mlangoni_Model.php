<?php

class Posta_Mlangoni_Model extends CI_Model{

    public function check_barcode($barcode){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `register_transactions` WHERE `Barcode`='$barcode'";
    $query  = $db2->query($sql);
    $result = $query->row_array();
    return $result;
  }
	
    public  function bill_transactions_list($services_type){

      $db2 = $this->load->database('otherdb', TRUE);
      $region = $this->session->userdata('user_region');
      
      if ($this->session->userdata('user_type') == "ACCOUNTANT") {

        $sql = "SELECT `bill_credit_customer`.*,`transactions`.* FROM `transactions` 
       INNER JOIN `sender_person_info` ON `sender_person_info`.`senderp_id` = `transactions`.`CustomerID`
             INNER JOIN `bill_credit_customer` ON `bill_credit_customer`.`acc_no` = `sender_person_info`.`acc_no` 
      WHERE  `transactions`.`paidamount` != 0  AND `bill_credit_customer`.`customer_region` = '$region'   AND  `bill_credit_customer`.`services_type` = '$services_type' ORDER BY `transactions`.`billid` ASC";

      }else{

        $sql = "SELECT `bill_credit_customer`.*,`transactions`.* FROM `transactions` 
       INNER JOIN `sender_person_info` ON `sender_person_info`.`senderp_id` = `transactions`.`CustomerID`
             INNER JOIN `bill_credit_customer` ON `bill_credit_customer`.`acc_no` = `sender_person_info`.`acc_no`  
      WHERE  `transactions`.`paidamount` != 0

       AND  `bill_credit_customer`.`services_type` = '$services_type'  ORDER BY `transactions`.`paymentdate` DESC";

      }
      
        
        $query=$db2->query($sql);
          $result = $query->result();
        return $result;
    }
	
    public function postamlangoni_cat_price($type,$weight){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM postamlangoni_tariff 
		WHERE category='$type' AND tarif >= '$weight' LIMIT 1";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    } 
	
	
	
}