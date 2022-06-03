<?php

class MasterCancelation_Model extends CI_Model{

//////////TRANSACTION LIST
public function transaction($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql= "SELECT * FROM transactions WHERE billid='$code' OR Barcode='$code'";
$query  = $db2->query($sql);
$result = $query->result();
return $result;  
}

public function register_transaction($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql= "SELECT * FROM register_transactions WHERE billid='$code' OR Barcode='$code'";
$query  = $db2->query($sql);
$result = $query->result();
return $result;  
}

///GET CANCELATION REPORT

public function transaction_cancelation($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_login_id');
if ($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="PMG" || $this->session->userdata('user_type')=="CRM") {
$sql= "SELECT * FROM transactions_cancel WHERE DATE(transaction_canceleddate) BETWEEN '$fromdate' AND '$todate' ORDER BY transaction_canceleddate DESC";
} else {
$sql= "SELECT * FROM transactions_cancel WHERE DATE(transaction_canceleddate) BETWEEN '$fromdate' AND '$todate' AND canceledby='$empid' ORDER BY transaction_canceleddate DESC";
}
$query  = $db2->query($sql);
$result = $query->result();
return $result;  
}

public function register_transaction_cancelation($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_login_id');
if ($this->session->userdata('user_type') == 'SUPER ADMIN' || $this->session->userdata('user_type')=="BOP" || $this->session->userdata('user_type')=="PMG" || $this->session->userdata('user_type')=="CRM") {
$sql= "SELECT * FROM register_transactions_cancel WHERE DATE(transaction_canceleddate) BETWEEN '$fromdate' AND '$todate' ORDER BY transaction_canceleddate DESC";
} else {
$sql= "SELECT * FROM register_transactions_cancel WHERE DATE(transaction_canceleddate) BETWEEN '$fromdate' AND '$todate' AND canceledby='$empid' ORDER BY transaction_canceleddate DESC";
}
$query  = $db2->query($sql);
$result = $query->result();
return $result;  
}

///////////////GET TRANSACTION
public function get_transaction($transid){
$db2 = $this->load->database('otherdb', TRUE);
$sql= "SELECT * FROM transactions WHERE id='$transid'";
$query  = $db2->query($sql);
$result = $query->row();
return $result; 
}

public function get_register_transaction($transid){
$db2 = $this->load->database('otherdb', TRUE);
$sql= "SELECT * FROM register_transactions WHERE t_id='$transid'";
$query  = $db2->query($sql);
$result = $query->row();
return $result; 
}

/////////////////COPY TRANSACTION

public function copy_transaction($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('transactions_cancel',$data);
}

public function copy_register_transaction($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('register_transactions_cancel',$data);
}


//////////////////UPDATE TRANSACTION
public function update_transaction($transid,$data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('id',$transid);
$db2->update('transactions_cancel',$data);  
}

public function update_register_transaction($transid,$data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('t_id',$transid);
$db2->update('register_transactions_cancel',$data);  
}


/////////////////DELETE TRANSACTION
public function delete_transaction($transid){
$db2 = $this->load->database('otherdb', TRUE);
$sql= "DELETE FROM transactions WHERE id='$transid'";
$query  = $db2->query($sql);
return $query; 
}

public function delete_register_transaction($transid){
$db2 = $this->load->database('otherdb', TRUE);
$sql= "DELETE FROM transactions_cancel WHERE t_id='$transid'";
$query  = $db2->query($sql);
return $query; 
}


}