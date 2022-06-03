<?php
class PostaStampModel extends CI_Model{

//////////////MAIN STOCK
public function stock_list($categoryid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_mainstock where categoryid='$categoryid' ORDER BY stock_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function save_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_mainstock',$data);
}

public function save_strongroom_stock($dataSave){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_strongroomstock',$dataSave);
}

public function save_branch_stock($dataSave){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_branchstock',$dataSave);
}


public function update_stock($data,$itemid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('stampstock_id', $itemid);
$db2->update('postastamp_mainstock',$data); 
}

public function update_request_stock_info($data,$requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('request_code', $requestcode);
$db2->update('postastamp_request',$data); 
}

public function update_strongroomstock($data,$id,$region){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('stock_productid', $id);
$db2->where('stock_region', $region);
$db2->update('postastamp_strongroomstock',$data); 
}

public function update_branchstock($data,$id,$region,$branch){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('stock_productid', $id);
$db2->where('stock_region', $region);
$db2->where('stock_branch', $branch);
$db2->update('postastamp_branchstock',$data); 
}

public function delete_stock($itemid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from postastamp_mainstock where stampstock_id='$itemid'";
$query=$db2->query($sql);
return $query;
}


public function save_selling_transaction($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_selling_transaction',$data);
}

public function save_request_information($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_request',$data);
}

public function save_request_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_requestitems',$data);
}

public function save_approved_history($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_approved_history',$data);
}

public function save_issued_request_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_requestitems_issued',$data);
}

//////////////////////////////////////////

/////////Get Strong Counter Stock, Branch Stock, StrongRoom Branch

public function get_counter_stock(){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
$sql = "SELECT * from postastamp_counterstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_counterstock.stock_categoryid 
WHERE postastamp_counterstock.stock_operator='$empid' ORDER BY stock_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_branch_stock(){
$db2 = $this->load->database('otherdb', TRUE);
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
$sql = "SELECT * from postastamp_branchstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_branchstock.stock_categoryid 
WHERE postastamp_branchstock.stock_branch='$branch' AND postastamp_branchstock.stock_region='$region' ORDER BY stock_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_strongroom_stock(){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT * from postastamp_strongroomstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_strongroomstock.stock_categoryid 
WHERE postastamp_strongroomstock.stock_region='$region' ORDER BY stock_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

////////////END OF MAIN STOCK

////////Request Code
public function request_stock_list(){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
if($this->session->userdata('sub_user_type')=="COUNTER"){
$sql = "SELECT * from postastamp_request WHERE request_status IN('Pending','ApprovedBySupervisor') AND created_by='$empid' ORDER BY request_created_at DESC";
} elseif($this->session->userdata('sub_user_type')=="BRANCH"){
$sql = "SELECT * from postastamp_request WHERE request_status IN('Pending','ApprovedBySupervisor','ApprovedByRM') AND created_by='$empid' ORDER BY request_created_at DESC";
} else {
//////////STRONGROOM
$sql = "SELECT * from postastamp_request WHERE request_status IN('Pending','ApprovedByRM','ApprovedByPMU') AND created_by='$empid' ORDER BY request_created_at DESC";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_request_full_information($requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_request WHERE request_code='$requestcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function check_item_strong_room_stock($value,$region){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_strongroomstock WHERE stock_productid='$value' AND stock_region='$region'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function check_item_branch_stock($value,$region,$branch){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_branchstock WHERE stock_productid='$value' AND stock_region='$region' AND stock_branch='$branch'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_request_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_requestitems 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_requestitems.stock_categoryid
WHERE request_code='$code'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function count_request_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_requestitems WHERE request_code='$code'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function list_available_stock_items(){
$db2 = $this->load->database('otherdb', TRUE);
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
if($this->session->userdata('sub_user_type')=="COUNTER"){
$sql = "SELECT * from postastamp_branchstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_branchstock.stock_categoryid
WHERE stock_branch='$branch' AND stock_region='$region'";
} elseif($this->session->userdata('sub_user_type')=="BRANCH"){
$sql = "SELECT * from postastamp_strongroomstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_strongroomstock.stock_categoryid
WHERE stock_region='$region'";
} else {
//////////STRONGROOM
$sql = "SELECT stampstock_id AS stock_productid, product_name AS stock_product_name, category_name from postastamp_mainstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_mainstock.categoryid";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_stamp_information($id){
$db2 = $this->load->database('otherdb', TRUE);
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
if($this->session->userdata('sub_user_type')=="COUNTER"){
$sql = "SELECT * from postastamp_branchstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_branchstock.stock_categoryid
WHERE stock_branch='$branch' AND stock_region='$region' AND stock_productid='$id'";
} elseif($this->session->userdata('sub_user_type')=="BRANCH"){
$sql = "SELECT * from postastamp_strongroomstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_strongroomstock.stock_categoryid
WHERE stock_region='$region' AND stock_productid='$id'";
} else {
//////////STRONGROOM
$sql = "SELECT price AS stock_price, categoryid AS stock_categoryid, product_name AS stock_product_name from postastamp_mainstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_mainstock.categoryid
WHERE stampstock_id='$id'";
}
$query=$db2->query($sql);
$result = $query->row();
return $result;
}


public function pending_stock_request(){
$db2 = $this->load->database('otherdb', TRUE);
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
if($this->session->userdata('sub_user_type')=="BRANCH"){
//////Branch Pending Requests
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedBySupervisor') AND branch='$branch' AND region='$region' AND request_send='ToBranch' ORDER BY request_created_at DESC";
} 
elseif($this->session->userdata('sub_user_type')=="STRONGROOM") {
//////////STRONGROOM
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedByRM') AND region='$region' AND request_send='ToStrongRoom' ORDER BY request_created_at DESC";
} 
elseif($this->session->userdata('user_type')=="SUPERVISOR"){
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('Pending') AND branch='$branch' AND region='$region' AND request_send IN('ToStrongRoom','ToBranch') ORDER BY request_created_at DESC";
}
elseif($this->session->userdata('user_type')=="RM"){
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('Pending','ApprovedBySupervisor') AND region='$region' AND request_send IN('ToStrongRoom','ToPMU') ORDER BY request_created_at DESC";
} 
elseif($this->session->userdata('sub_user_type')=="PMU") {
//////////PMU
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedByRM') AND request_send='ToPMU' ORDER BY request_created_at DESC";
} 
else {
/////////STAMP BUREAU STORE
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedByPMU') AND request_send='ToPMU' ORDER BY request_created_at DESC";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function count_pending_stock_request(){
$db2 = $this->load->database('otherdb', TRUE);
$branch = $this->session->userdata('user_branch');
$region = $this->session->userdata('user_region');
if($this->session->userdata('sub_user_type')=="BRANCH"){
//////Branch Pending Requests
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedBySupervisor') AND branch='$branch' AND region='$region' AND request_send='ToBranch' ORDER BY request_created_at DESC";
} 
elseif($this->session->userdata('sub_user_type')=="STRONGROOM") {
//////////STRONGROOM
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedByRM') AND region='$region' AND request_send='ToStrongRoom' ORDER BY request_created_at DESC";
} 
elseif($this->session->userdata('user_type')=="SUPERVISOR"){
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('Pending') AND branch='$branch' AND region='$region' AND request_send IN('ToStrongRoom','ToBranch') ORDER BY request_created_at DESC";
}
elseif($this->session->userdata('user_type')=="RM"){
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('Pending','ApprovedBySupervisor') AND region='$region' AND request_send IN('ToStrongRoom','ToPMU') ORDER BY request_created_at DESC";
} 
elseif($this->session->userdata('sub_user_type')=="PMU") {
//////////PMU
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedByRM') AND request_send='ToPMU' ORDER BY request_created_at DESC";
} 
else {
/////////STAMP BUREAU STORE
$sql = "SELECT * FROM postastamp_request WHERE request_status IN('ApprovedByPMU') AND request_send='ToPMU' ORDER BY request_created_at DESC";
}
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function main_stock_details($id){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_mainstock WHERE stampstock_id='$id'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function strongroom_stock_details($id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$sql = "SELECT * from postastamp_strongroomstock WHERE stock_productid='$id' AND stock_region='$region'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function branch_stock_details($id){
$db2 = $this->load->database('otherdb', TRUE);
$region = $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
$sql = "SELECT * from postastamp_branchstock WHERE stock_productid='$id' AND stock_region='$region' AND stock_branch='$branch'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function check_item_counter_stock($value,$operator){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_counterstock WHERE stock_productid='$value' AND stock_operator='$operator'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function update_counterstock($data,$id,$operator){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('stock_productid', $id);
$db2->where('stock_operator', $operator);
$db2->update('postastamp_counterstock',$data); 
}

public function save_counter_stock($dataSave){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postastamp_counterstock',$dataSave);
}

public function counter_stock_availability_list($id){
$db2 = $this->load->database('otherdb', TRUE);
$operator = $this->session->userdata('user_emid');
$sql = "SELECT * from postastamp_counterstock WHERE stock_operator='$operator' AND stock_productid='$id'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

////////////////////////Transaction
public function get_sales_transaction($fromdate,$todate){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$operator = $this->session->userdata('user_emid');
$sql = "SELECT customer,phone,receipt,tin,vrn,address,transaction_created_at,SUM(sale_price*sale_qty) AS total,COUNT(*) AS totalitems from postastamp_selling_transaction WHERE operator='$empid' AND DATE(transaction_created_at) BETWEEN '$fromdate' AND '$todate' GROUP BY receipt ORDER BY transaction_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_selling_transaction_items($receipt){
$db2 = $this->load->database('otherdb', TRUE);
$operator = $this->session->userdata('user_emid');
$sql = "SELECT * from postastamp_selling_transaction WHERE receipt='$receipt'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

 public function save_transactions($data){
 $db2 = $this->load->database('otherdb', TRUE);
 $db2->insert('transactions',$data);
 }

public function save_stamps($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('Stamp',$data);
}
///////////////End Transaction



///////////Payment transaction
public function payment_transaction_list($fromdate,$todate){
$empid = $this->session->userdata('user_emcode');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM `Stamp`LEFT JOIN `transactions` ON `transactions`.`serial`=`Stamp`.`serial` 
WHERE `Stamp`.`Created_byId` = '$empid' AND DATE(`Stamp`.`date_created`) BETWEEN '$fromdate' AND '$todate' ORDER BY `Stamp`.`date_created` DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

/////////////////End of Transaction

public function generate_control_number_today_transactions(){
$today = date("Y-m-d");
$db2 = $this->load->database('otherdb', TRUE);
$operator = $this->session->userdata('user_emid');
$sql = "SELECT SUM(sale_price*sale_qty) AS total from postastamp_selling_transaction WHERE operator='$empid' AND DATE(transaction_created_at) ='$today'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_branch_stock_balance(){
$region = $this->session->userdata('user_region');
$sql = "SELECT * FROM em_branch INNER JOIN em_region ON em_region.region_id=em_branch.region_id WHERE region_name='$region'";
$query = $this->db->query($sql);
$result = $query->result();
return $result;
}

public function list_stock_balance_of_branch($branch){
$region = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * FROM postastamp_branchstock 
INNER JOIN postastamp_category ON postastamp_category.category_id=postastamp_branchstock.stock_categoryid
WHERE stock_branch='$branch' AND stock_region='$region'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

//////////////////////STAMP API

public function get_stamp_receipt_information($receiptid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from postastamp_selling_transaction where receipt='$receiptid'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_stamp_receipt_transactions($receiptid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postastamp_selling_transaction WHERE receipt='$receiptid'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

/////////////////////END OF API

}