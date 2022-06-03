<?php
class PostaShopModel extends CI_Model{


public function list_productcategories(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from postashop_productcategory";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function list_productstock(){
$db2 = $this->load->database('otherdb', TRUE);
$region =  $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
if($this->session->userdata('user_type') == 'SUPER ADMIN'){
$sql = "SELECT * from postashop_productstock inner join postashop_productcategory on postashop_productstock.categoryid=postashop_productcategory.category_id
ORDER BY product_created_at DESC";
} elseif($this->session->userdata('user_type') == 'SUPERVISOR'){
$sql = "SELECT * from postashop_productstock inner join postashop_productcategory on postashop_productstock.categoryid=postashop_productcategory.category_id WHERE postashop_productstock.region='$region' AND postashop_productstock.branch='$branch'
ORDER BY product_created_at DESC";
} else {
$sql = "SELECT * from postashop_productstock inner join postashop_productcategory on postashop_productstock.categoryid=postashop_productcategory.category_id WHERE postashop_productstock.region='$region'
ORDER BY product_created_at DESC";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function list_counter_product_requested_lists(){
$db2 = $this->load->database('otherdb', TRUE);
$region =  $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
$sql = "SELECT * from postashop_productstock inner join postashop_productcategory on postashop_productstock.categoryid=postashop_productcategory.category_id WHERE postashop_productstock.region='$region' AND postashop_productstock.branch='$branch' ORDER BY product_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function save_request_information($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_request',$data);
}

public function save_request_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_requestedproducts',$data);
}

public function counter_list_productstock(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_counterstock 
inner join postashop_productcategory on postashop_counterstock.categoryid=postashop_productcategory.category_id 
WHERE postashop_counterstock.operator='$empid' ORDER BY product_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_transaction_list($fromdate,$todate){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
$region =  $this->session->userdata('user_region');
if($this->session->userdata('user_type') == 'SUPER ADMIN'){
$sql = "SELECT SUM(sale_price*sale_qty) AS total,count(selling_id) AS totalitems,customer,phone,address,region,branch,transaction_created_at,receipt from postashop_selling_transaction where date(transaction_created_at) BETWEEN '$fromdate' AND '$todate' GROUP BY receipt ORDER BY transaction_created_at DESC";
} else {
$sql = "SELECT SUM(sale_price*sale_qty) AS total,count(selling_id) AS totalitems,customer,phone,address,region,branch,transaction_created_at,receipt from postashop_selling_transaction where date(transaction_created_at) BETWEEN '$fromdate' AND '$todate' AND operator='$empid' GROUP BY receipt ORDER BY transaction_created_at DESC";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_product_information($id){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from postashop_productstock where productstock_id='$id'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_selling_transaction_items($receipt){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from postashop_selling_transaction where receipt='$receipt'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function counter_get_product_information($id){
$db2 = $this->load->database('otherdb', TRUE);
$empid = $this->session->userdata('user_emid');
$sql = "SELECT * from  postashop_counterstock where productid='$id' AND operator='$empid'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function delete_issued_stock_information($requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "DELETE FROM postashop_issuedstock WHERE requestcode='$requestcode'";
$query=$db2->query($sql);
return $query;
}


public function delete_category($itemid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from postashop_productcategory where category_id='$itemid'";
$query=$db2->query($sql);
return $query;
}

public function delete_stock($itemid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from postashop_productstock where productstock_id='$itemid'";
$query=$db2->query($sql);
return $query;
}

public function update_category($data,$itemid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('category_id', $itemid);
$db2->update('postashop_productcategory',$data); 
}

public function update_stock($data,$itemid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('productstock_id', $itemid);
$db2->update('postashop_productstock',$data); 
}

public function save_category($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_productcategory',$data);
}


public function save_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_productstock',$data);
}

public function save_selling_transaction($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_selling_transaction',$data);
}


public function count_get_pending_requests(){
$empid = $this->session->userdata('user_emid');
$region =  $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
$db2 = $this->load->database('otherdb', TRUE);
if($this->session->userdata('user_type') == 'SUPERVISOR'){
$sql = "SELECT * from postashop_request WHERE region='$region' AND branch='$branch' AND request_status='Pending'";
} else {
$sql = "SELECT * from postashop_request WHERE region='$region' AND request_status='Pending'";
}
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function count_pending_stock_issued_by_supervisor(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_request WHERE created_by='$empid' AND request_status='ApprovedBySupervisor'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function get_issued_approved_stock_request(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_request WHERE created_by='$empid' AND request_status='ApprovedBySupervisor'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function list_pending_requests(){
$empid = $this->session->userdata('user_emid');
$region =  $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
$db2 = $this->load->database('otherdb', TRUE);
if($this->session->userdata('user_type') == 'SUPERVISOR'){
$sql = "SELECT * from postashop_request WHERE region='$region' AND branch='$branch' AND request_status='Pending'";
} else {
$sql = "SELECT * from postashop_request WHERE region='$region' AND request_status='Pending'";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function my_list_pending_requests(){
$empid = $this->session->userdata('user_emid');
$region =  $this->session->userdata('user_region');
$branch = $this->session->userdata('user_branch');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_request WHERE created_by='$empid' AND request_status='Pending'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function counter_update_stock($data,$itemid){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('operator', $empid);
$db2->where('productid', $itemid);
$db2->update('postashop_counterstock',$data); 
}

public function get_request_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_requestedproducts WHERE requestcode='$code'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function count_request_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_requestedproducts WHERE requestcode='$code'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function count_approved_issued_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_issuedstock WHERE requestcode='$code'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function list_count_approved_issued_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_issuedstock WHERE requestcode='$code'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function product_stock_details($productid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_productstock WHERE productstock_id='$productid'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function update_branchstock($data,$id){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('productstock_id', $id);
$db2->update('postashop_productstock',$data); 
}

public function check_item_counter_stock($value,$operator){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_counterstock WHERE productid='$value' AND operator='$operator'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function update_counterstock($data,$id,$operator){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('productid', $id);
$db2->where('operator', $operator);
$db2->update('postashop_counterstock',$data); 
}

public function save_counter_stock($dataSave){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_counterstock',$dataSave);
}

public function get_request_full_information($requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_request WHERE request_code='$requestcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_issued_stock_report($fromdate,$todate,$region,$branch){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_issuedstock 
inner join postashop_productcategory on postashop_issuedstock.categoryid=postashop_productcategory.category_id 
WHERE postashop_issuedstock.branch='$branch' AND postashop_issuedstock.region='$region' AND 
DATE(postashop_issuedstock.product_created_at) BETWEEN '$fromdate' AND '$todate'
ORDER BY product_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function update_request_stock_info($data,$requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('request_code', $requestcode);
$db2->update('postashop_request',$data); 
}

public function save_issued_request_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('postashop_issuedstock',$data);
}

////////////////////////////get branch
 public function GetBranchById($region_id){
$sql    = "SELECT * FROM `em_region` WHERE `region_name`='$region_id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
				  $id = $result->region_id;

$this->db->where('region_id',$id);
$this->db->order_by('branch_name');
$query = $this->db->get('em_branch');
$output ='<option value="">Select Branch</option>';
foreach ($query->result() as $row) {
$output .='<option value="'.$row->branch_name.'">'.$row->branch_name.'</option>';
}
return $output;
}

///////////////////POSTASHOP API
public function get_postashop_receipt_information($receiptid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from postashop_selling_transaction where receipt='$receiptid'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_postashop_receipt_transactions($receiptid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_selling_transaction WHERE receipt='$receiptid'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}



public function list_administrator_issues(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from postashop_selling_transaction";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function update_adminstrator_stock($data,$itemid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('selling_id', $itemid);
$db2->update('postashop_selling_transaction',$data); 
}
////////////////END OF POSTASHOP API

}