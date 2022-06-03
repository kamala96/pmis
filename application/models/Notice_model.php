<?php

class Notice_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    public function GetNotice(){

        $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $sub_role = $basicinfo->em_sub_role;
      $em_sect = $basicinfo->em_section_role;
      $dep_id = $basicinfo->dep_id;
      $em_region = $basicinfo->em_region;
      $em_branch = $basicinfo->em_branch;

        $sql = "SELECT * FROM `notice` WHERE (`notice`.`dep_id` = '$dep_id' OR `notice`.`dep_id` = 0 ) ORDER BY `notice`.`date` DESC;";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
        }
    public function Published_Notice($data){
        $this->db->insert('notice',$data);
    }
    public function GetNoticelimit(){
        $this->db->order_by('date', 'DESC');
		$query = $this->db->get('notice');
		$result =$query->result();
        return $result;        
    }
      public function GetParcellimit(){

        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
        $em_region = $basicinfo->em_region;

        $sql = "SELECT `parcel_info`.*,
        `sender_info`.*,
        `receiver_info`.*
        FROM `parcel_info`
        LEFT JOIN `sender_info` ON `sender_info`.`sender_id`= `parcel_info`.`sender_id`
        LEFT JOIN `receiver_info` ON `receiver_info`.`receiver_id`= `parcel_info`.`receiver_id`
        WHERE `sender_info`.`sender_region` = '$em_region' OR `receiver_info`.`receiver_region` = '$em_region'";

        $query=$this->db->query($sql);
        $result =$query->result();
        return $result;       
    }

    public function GetBulkList()
    {
        $id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
        $em_region = $basicinfo->em_region;
        
        $sql = "SELECT * FROM `bulk` WHERE `region_from`='$em_region' OR `region_to`='$em_region'";
        $query=$this->db->query($sql);
        $result =$query->result();
        return $result; 
    }  

    public function UpdatePayment($serial,$amount,$services){
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
        curl_close ($ch);
        $result = json_decode($response);
        
        @$serial1 = @$result->billid;
        //print_r(@$result->receipt);

        if ($result->status == '103' && @$result->receipt== '') {
            $paid = "NotPaid";
            $db2->set('billid', @$result->controlno);
             $db2->set('status', $paid);
             $db2->where('serial', @$serial1);
             $db2->update('transactions');
        } else {
            $paid = "Paid";
                $db2->set('receipt', @$result->receipt);
            // //$db2->set('paidamount', @$result->amount);
             $db2->set('paychannel', @$result->channel);
             $db2->set('paymentdate', @$result->paydate);
             $db2->set('status', $paid);
             $db2->where('serial', @$serial1);
             $db2->update('transactions');
            # code...
        }
        
       
}  
}
?>