<?php

class Parking_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    
    public function check_vehicle_existance($vehicle){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `parking` WHERE `vehicle_regno`='$vehicle' ORDER BY `parking_id` DESC LIMIT 1";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function exit_first($vehicle){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `parking` WHERE `vehicle_regno`='$vehicle' AND `status` = 'IN'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function check_vehicle_wallet_existance($vehicle){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `wallet_vehicle` WHERE `vehicle_regno`='$vehicle'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function check_vehicle_wallet_existance1($vehicle){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT `parking_wallet`.`wallet_id`,`paidamount`,`wallet_vehicle`.`vehicle_regno`    FROM `wallet_vehicle`  INNER JOIN `parking_wallet` ON `parking_wallet`.`wallet_id` = `wallet_vehicle`.`wallet_id`
    WHERE `vehicle_regno`='$vehicle' AND `parking_wallet`.`status` = 'Paid' ";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function check_vehicle_existance1($vehicle){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `parking` WHERE `vehicle_regno`='$vehicle' AND `status` = 'IN' ORDER BY `parking_id` DESC LIMIT 1";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function check_exit_vehicle($date){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT SUM(`cost`) AS `amount`,`payment_type` FROM `parking` WHERE date(`exit_time`) = '$date' AND `status` = 'EXIT' AND `cost` != 0 AND `payment_type`='CASH'";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
  public function check_controlno($date,$emid){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT * FROM `parking_transactions` WHERE date(`transactiondate`) = '$date' AND `emid` = '$emid' ORDER BY `t_id` DESC LIMIT 1";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
  public function vehicle_count($date){
    $db2 = $this->load->database('otherdb', TRUE);
    $sql    = "SELECT COUNT(`parking_id`) AS `number` FROM `parking` WHERE date(`exit_time`) = '$date' AND `status` = 'EXIT' AND `cost` != 0 AND `payment_type`='CASH'";

        $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }
public function update_vehicle_info($data,$id){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('parking_id', $id);
        $db2->update('parking', $data);
    }
  public function save_vehicle_info($parking){
      $db2 = $this->load->database('otherdb', TRUE);
      $db2->insert('parking',$parking);
      }
  public function save_wallet_vehicle_info($wallet){
      $db2 = $this->load->database('otherdb', TRUE);
      $db2->insert('wallet_vehicle',$wallet);
      }
  public function save_wallet_cust_info($cust){
      $db2 = $this->load->database('otherdb', TRUE);
      $db2->insert('parking_wallet',$cust);
      }
    public function get_vehicle_in_info(){
    $db2 = $this->load->database('otherdb', TRUE);
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');
    
    if($this->session->userdata('user_type') == "EMPLOYEE"){
      $sql    = "SELECT * FROM `parking` WHERE date(`entry_time`) = '$date' AND `status`= 'IN'  AND `operator_region` = '$region' AND `operator_branch` = '$branch' ORDER BY `parking_id` DESC";
    }else {
      $sql    = "SELECT * FROM `parking` WHERE date(`entry_time`) = '$date' AND `status`= 'IN' ORDER BY `parking_id` DESC";
    }
    
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public function get_vehicle_in_info_search($status,$datese,$month){
    $db2 = $this->load->database('otherdb', TRUE);
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');

    $month1 = explode('-', $month);
        $m = @$month1[0];
        $y = @$month1[1];
        
    if (!empty($datese)) {
        $sql    = "SELECT * FROM `parking` WHERE `status`= '$status' AND date(`entry_time`) = '$datese' ORDER BY `parking_id` DESC";
    } else {
        $sql    = $sql = "SELECT * FROM `parking` WHERE `status` = '$status' AND MONTH(`entry_time`) = '$m' AND YEAR(`entry_time`) = '$y'";
    }
    
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public function get_vehicle_in_info_search_sum($status,$datese,$month){
    $db2 = $this->load->database('otherdb', TRUE);

    $month1 = explode('-', $month);
        $m = @$month1[0];
        $y = @$month1[1];
        
    if (!empty($datese)) {
        $sql    = "SELECT SUM(`cost`) AS `amount` FROM `parking` WHERE `status`= '$status' AND date(`entry_time`) = '$datese' ORDER BY `parking_id` DESC";
    } else {
        $sql    = $sql = "SELECT SUM(`cost`) AS `amount` FROM `parking` WHERE `status` = '$status' AND MONTH(`entry_time`) = '$m' AND YEAR(`entry_time`) = '$y'";
    }
    
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function get_search_vehicle_in_info($date,$month){
    $db2 = $this->load->database('otherdb', TRUE);

    $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');

        if (!empty($date)) {
            $sql    = "SELECT * FROM `parking` WHERE date(`entry_time`) = '$date' AND `status`= 'IN'";
        } else {
            $sql    = "SELECT * FROM `parking` WHERE MONTH(`entry_time`) = '$month' AND DAY(`entry_time`) = '$day' AND `status`= 'IN'";
        }

    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public function get_vehicle_out_info(){
    $db2 = $this->load->database('otherdb', TRUE);

    $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');
    $sql    = "SELECT * FROM `parking` WHERE date(`exit_time`) = '$date' ORDER BY `parking_id` DESC";
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public function get_vehicle_associated_with_info($controlno){
    $db2 = $this->load->database('otherdb', TRUE);

    $sql    = "SELECT * FROM `parking`  WHERE `controlno` = '$controlno' AND `cost` != 0  ORDER BY `parking_id` DESC";
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }

  public function get_vehicle_associated_with_sum($controlno){
    $db2 = $this->load->database('otherdb', TRUE);

    $sql    = "SELECT SUM(`cost`) AS `total` FROM `parking`  WHERE `controlno` = '$controlno'  ORDER BY `parking_id` DESC";
    $query  = $db2->query($sql);
    $result = $query->row();
    return $result;
  }

  public function get_vehicle_out_info_exit($date){
    $db2 = $this->load->database('otherdb', TRUE);

    $sql    = "SELECT * FROM `parking` WHERE date(`exit_time`) = '$date' AND `status` = 'EXIT'";
    $query  = $db2->query($sql);
    $result = $query->result();
    return $result;
  }
  public function update_time_cash($id,$data){
    $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('parking_id', $id);
        $db2->where('status', 'IN');
        $db2->update('parking',$data);
      }
public function update_parking_control_no($id,$data){
    $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('parking_id', $id);
        $db2->update('parking',$data);
      }

    public  function get_to_day_vehicle_In(){

        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');

        $sql = "SELECT * FROM `parking` WHERE date(`entry_time`) = '$date' AND `status` = 'IN'";

        $query=$db2->query($sql);
        return $query->num_rows();
    }

    public  function get_to_day_vehicle_Out(){

        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');

        $sql = "SELECT * FROM `parking` WHERE date(`exit_time`) = '$date' AND `status` = 'EXIT'";

        $query=$db2->query($sql);
        return $query->num_rows();
    }

    public  function get_to_day_trans(){

        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');

        $sql = "SELECT * FROM `parking_transactions` WHERE date(`transactiondate`) = '$date'";

        $query=$db2->query($sql);
        return $query->num_rows();
    }
    public  function get_wallet_custom_trans(){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `parking_wallet`";

        $query=$db2->query($sql);
        return $query->num_rows();
    }
    public  function get_wallet_transactions(){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `parking_wallet` ORDER BY `wallet_id` DESC";
        $query  = $db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function getAllTransaction(){

        $regionfrom = $this->session->userdata('user_region');
        $db2 = $this->load->database('otherdb', TRUE);
        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $date = $today->format('Y-m-d');

        $sql = "SELECT * FROM `parking_transactions` WHERE `paidamount` != 0";

        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public  function getAllTransactionSearched($date,$status,$month){
        

        $db2 = $this->load->database('otherdb', TRUE);

        $month1 = explode('-', $month);
        $m = @$month1[0];
        $y = @$month1[1];

        if (empty($month)) {
           $sql = "SELECT * FROM `parking_transactions` WHERE `paidamount` != 0 AND `status` = '$status' AND date(`transactiondate`) = '$date'";
        } else {
           $sql = "SELECT * FROM `parking_transactions` WHERE `paidamount` != 0 AND `status` = '$status' AND MONTH(`transactiondate`) = '$m' AND YEAR(`transactiondate`) = '$y'";
        }
        
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getVehicleDataGraph(){
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT date(`entry_time`) as `year`, COUNT(`parking_id`) as `value` FROM `parking` WHERE `status` = 'EXIT' GROUP BY DAY(`entry_time`) ORDER BY date(`entry_time`) DESC";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function update_parking_transactions($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('serial', $serial);
        $db2->update('parking_transactions',$update);         
    }

    public function update_parking_transactions1($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('billid', $serial);
        $db2->update('parking_transactions',$update);         
    }
    public function update_parking_wallet_transaction($update,$serial){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('controlno', $serial);
        $db2->update('parking_wallet',$update);         
    }

    public function update_wallet_cust_info($cust,$walletid){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('wallet_id', $walletid);
        $db2->update('parking_wallet',$cust);         
    }

    public function checkValue_parking($controlno){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `parking_transactions` WHERE `billid`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function checkValue_parking_wallet($controlno){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `parking_wallet` WHERE `controlno`='$controlno'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_payment_info($wid){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `parking_wallet` WHERE `wallet_id`='$wid'";
        $query=$db2->query($sql);
        $result = $query->row();
        return $result;
    }

    public function get_veicle_wallet_info($wid){
        
        $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `wallet_vehicle` WHERE `wallet_id`='$wid'";
        $query=$db2->query($sql);
        $result = $query->result();
        return $result;
    }

    public function getUpdatePaymentParking($serial,$amount){
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
        //echo @$result->billid;

        if (@$result->status == '103' && @$result->receipt== '') {

             $paid = "NotPaid";
             $db2->set('status', $paid);
             $db2->set('billid', @$result->controlno);
             $db2->where('serial', @$serial1);
             $db2->update('parking_transactions');
            // echo "string";

        } else {

             $paid = "Paid";
             $db2->set('receipt', @$result->receipt);
            // //$db2->set('paidamount', @$result->amount);
             $db2->set('paychannel', @$result->channel);
             $db2->set('paymentdate', @$result->paydate);
             $db2->set('status', $paid);
             $db2->where('serial', @$serial1);
             $db2->update('parking_transactions');
            # code...
        }
        
       
}
}
?>