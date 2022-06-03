<?php

class Miscellaneous_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    
        public function save_transactions($data1){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('transactions',$data1);
        }


         public function save_Miscellaneouss($data){
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('Miscellaneous',$data);
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
     
        public function check_payment_International($id,$type){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql    = "SELECT * FROM `transactions` WHERE `id`='$id' AND `PaymentFor` = '$type'";
        $query  = $db2->query($sql);
        $result = $query->row();
        return $result;
    }
        public function get_Miscellaneous_list(){

            $db2 = $this->load->database('otherdb', TRUE);
            $id2 = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id2);
            
            $id = $info->em_code;
            
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

if ($this->session->userdata('user_type') == 'EMPLOYEE' || $this->session->userdata('user_type') == 'AGENT' || $this->session->userdata('user_type') == 'SUPERVISOR') {
          $sql = "SELECT * FROM `Miscellaneous`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$o_region' AND `Miscellaneous`.`branch` = '$o_branch' AND `Miscellaneous`.`Created_byId` = '$id'  ORDER BY `Miscellaneous`.`date_created` DESC";

        }elseif($this->session->userdata('user_type') == 'RM'|| $this->session->userdata('user_type') == "ACCOUNTANT"){
           $sql = "SELECT * FROM `Miscellaneous`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$o_region'    ORDER BY `Miscellaneous`.`date_created` DESC LIMIT 0";

        }else{
           $sql = "SELECT * FROM `Miscellaneous`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
            
            WHERE `transactions`.`status` != 'OldPaid'  ORDER BY `Miscellaneous`.`date_created` DESC LIMIT 0";

        }


                    $query = $db2->query($sql);
                    $result = $query->result();
                    return $result;
            
            
        }
         public function get_Miscellaneous_list_search($date,$month,$region){

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
                     $sql = "SELECT * FROM `Miscellaneous`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
                        
                        WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$o_region' AND ( date(`Miscellaneous`.`date_created`) = '$date')

                   
                          ORDER BY `Miscellaneous`.`date_created` DESC";

 // AND  ( MONTH(`Miscellaneous`.`date_created`) = '$day' AND YEAR(`Miscellaneous`.`Miscellaneous`) = '$year' ) 
            
                        }
                        else
                        {
                             $sql = "SELECT * FROM `Miscellaneous`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
                        WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$o_region' 
                        AND  ( MONTH(`Miscellaneous`.`date_created`) = '$day' AND YEAR(`Miscellaneous`.`date_created`) = '$year' ) 
                          ORDER BY `Miscellaneous`.`date_created` DESC";

                        }

                }
                else{


              if ((!empty($month) || !empty($date)) && !empty($region)) {
                
               

                   if (!empty($date)) {
                     $sql = "SELECT * FROM `Miscellaneous`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
                        
                        WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$region' AND ( date(`Miscellaneous`.`date_created`) = '$date')

                   
                          ORDER BY `Miscellaneous`.`date_created` DESC";

 // AND  ( MONTH(`Miscellaneous`.`date_created`) = '$day' AND YEAR(`Miscellaneous`.`Miscellaneous`) = '$year' ) 
            
                        }
                        else
                        {
                             $sql = "SELECT * FROM `Miscellaneous`
                        LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
                        WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$region' 
                        AND  ( MONTH(`Miscellaneous`.`date_created`) = '$day' AND YEAR(`Miscellaneous`.`date_created`) = '$year' ) 
                          ORDER BY `Miscellaneous`.`date_created` DESC";

                        }

            
            }
            else
            {
                 $sql = "SELECT * FROM `Miscellaneous`
            LEFT JOIN `transactions` ON `transactions`.`serial`=`Miscellaneous`.`serial`
            WHERE `transactions`.`status` != 'OldPaid' AND `Miscellaneous`.`region` = '$o_region' AND `Miscellaneous`.`Created_byId` = '$id'  
              ORDER BY `Miscellaneous`.`date_created` DESC";

            }

            }

            $query = $db2->query($sql);
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


}
?>