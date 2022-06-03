<?php
class OfficialuseModel extends CI_Model{

public  function list_items(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from officialuse_items";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function list_units(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "select * from officialuse_unit";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function list_stock(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_stock 
INNER JOIN officialuse_items ON officialuse_items.item_id=officialuse_stock.itemid
INNER JOIN officialuse_unit ON officialuse_unit.unit_id=officialuse_stock.unitid";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function list_store_stock(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_storestock 
INNER JOIN officialuse_items ON officialuse_items.item_id=officialuse_storestock.itemid
INNER JOIN officialuse_unit ON officialuse_unit.unit_id=officialuse_storestock.unitid
WHERE storeman='$empid'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function list_my_requests(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request where created_by='$empid' and request_status IN('Pending','ReceivedByRM','ReceivedByPMU') and request_send='ToPMU' order by request_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function hod_list_my_requests(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request where created_by='$empid' and request_status IN('Pending','Completed') and request_send='ToStore' order by request_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function track_store_request_list($fromdate,$todate,$status){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request where created_by='$empid' and request_status='$status'and DATE(request_created_at) BETWEEN '$fromdate' AND '$todate' and request_send='ToPMU' ORDER BY request_created_at DESC";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function count_pending_requests(){
$region  = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);
if($this->session->userdata('user_type') =='RM'){
//REGIONAL MANAGER
$sql = "SELECT * from officialuse_request where region='$region' and request_status='Pending' and request_send='ToPMU'";
} elseif ($this->session->userdata('sub_user_type') == 'PMU') {
//PMU 
$sql = "SELECT * from officialuse_request where request_status='ReceivedByRM' and request_send='ToPMU'";
} elseif ($this->session->userdata('sub_user_type') == 'STORE') {
//STORE 
$sql = "SELECT * from officialuse_request where request_status='ReceivedByPMU' and request_send='ToPMU'";
} else {
//ADMINISTRATOR
$sql = "SELECT * from officialuse_request where request_status='ReceivedByRM' and request_send='ToPMU'";
}
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public  function list_pending_requests(){
$region  = $this->session->userdata('user_region');
$db2 = $this->load->database('otherdb', TRUE);
if($this->session->userdata('user_type') =='RM'){
//REGIONAL MANAGER
$sql = "SELECT * from officialuse_request where region='$region' and request_status='Pending' and request_send='ToPMU'";
} elseif ($this->session->userdata('sub_user_type') == 'PMU') {
//PMU 
$sql = "SELECT * from officialuse_request where request_status='ReceivedByRM' and request_send='ToPMU'";
} elseif ($this->session->userdata('sub_user_type') == 'STORE') {
//STORE 
$sql = "SELECT * from officialuse_request where request_status='ReceivedByPMU' and request_send='ToPMU'";
} else {
//ADMINISTRATOR
$sql = "SELECT * from officialuse_request where request_status='ReceivedByRM' and request_send='ToPMU'";
}
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function store_list_pending_requests(){
$region  = $this->session->userdata('user_region');
$branch  = $this->session->userdata('user_branch');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request where region='$region' and branch='$branch' and request_status='Pending' and request_send='ToStore'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function store_count_pending_requests(){
$region  = $this->session->userdata('user_region');
$branch  = $this->session->userdata('user_branch');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request where region='$region' and branch='$branch' and request_status='Pending' and request_send='ToStore'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function count_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request_items where requestcode='$code'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function item_qty_balance($itemid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_stock where itemid='$itemid'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function store_item_qty_balance($itemid){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_storestock where itemid='$itemid' and storeman='$empid'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_request_information($requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request where request_code='$requestcode'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function rm_requesthistory_information($requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_approvedhistory where requestcode='$requestcode' and approved_status='ReceivedByRM'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function pmu_requesthistory_information($requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_approvedhistory where requestcode='$requestcode' and approved_status='ReceivedByPMU'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}


public function check_item_storestock($itemid,$storeman){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_storestock where itemid='$itemid' and storeman='$storeman'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function check_item_storestock_info($itemid,$storeman){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_storestock where itemid='$itemid' and storeman='$storeman'";
$query=$db2->query($sql);
$result = $query->row();
return $result;
}

public function get_request_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_request_items 
inner join officialuse_items on officialuse_items.item_id=officialuse_request_items.request_itemid
inner join officialuse_unit on officialuse_unit.unit_id=officialuse_request_items.unitid
where requestcode='$code'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function get_issued_request_items($code){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_issueitems 
inner join officialuse_items on officialuse_items.item_id=officialuse_issueitems.itemid
inner join officialuse_unit on officialuse_unit.unit_id=officialuse_issueitems.unitid
where requestcode='$code'";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function save_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_items',$data);
}

public function save_approved_history($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_approvedhistory',$data);
}

public function save_units($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_unit',$data);
}

public function save_request($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_request',$data);
}

public function save_request_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_request_items',$data);
}

public function save_issued_request_items($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_issueitems',$data);
}

public function save_storestock_to_storeman($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_storestock',$data);
}

public function update_items($data,$itemid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('item_id', $itemid);
$db2->update('officialuse_items',$data); 
}

public function storestock_update_items($data,$itemid,$storeman){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('itemid', $itemid);
$db2->where('storeman', $storeman);
$db2->update('officialuse_storestock',$data); 
}

public function update_unit($data,$unitid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('unit_id', $unitid);
$db2->update('officialuse_unit',$data); 
}

public function delete_item($itemid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from officialuse_items where item_id='$itemid'";
$query=$db2->query($sql);
return $query;
}

public function delete_unit($unitid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from officialuse_unit where unit_id='$unitid'";
$query=$db2->query($sql);
return $query;
}


public function delete_stock($stockid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from officialuse_stock where stock_id='$stockid'";
$query=$db2->query($sql);
return $query;
}

public function save_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('officialuse_stock',$data);
}

public function update_stock($data,$stockid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('stock_id', $stockid);
$db2->update('officialuse_stock',$data); 
}

public function update_itemstock($data,$itemid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('itemid', $itemid);
$db2->update('officialuse_stock',$data); 
}

public function update_itemstorestock($data,$storestockid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('storestock_id', $storestockid);
$db2->update('officialuse_storestock',$data); 
}

public function update_requests($data,$requestcode){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('request_code', $requestcode);
$db2->update('officialuse_request',$data); 
}

/////////////////////STOCK NOTIFICATIONS
public function countnostorestock(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_storestock WHERE storeman='$empid'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function count_low_qty_storestock(){
$empid = $this->session->userdata('user_emid');
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_storestock WHERE qty<=5 and storeman='$empid'";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function pmucountnostorestock(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_stock";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

public function pmucount_low_qty_storestock(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from officialuse_stock WHERE balance_qty<=5";
$query=$db2->query($sql);
$result = $query->num_rows();
return $result;
}

}