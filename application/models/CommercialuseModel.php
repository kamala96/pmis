<?php
class CommercialuseModel extends CI_Model{


public  function list_philatelic_stamp(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from commercialuse_stock where categoryid=1";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function list_stamp(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from commercialuse_stock where categoryid=2";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public  function list_locks(){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "SELECT * from commercialuse_stock where categoryid=3";
$query=$db2->query($sql);
$result = $query->result();
return $result;
}

public function save_stock($data){
$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('commercialuse_stock',$data);
}

public function update_stock($data,$stockid){
$db2 = $this->load->database('otherdb', TRUE);
$db2->where('commercial_stock_id', $stockid);
$db2->update('commercialuse_stock',$data); 
}

public function delete_stock($stockid){
$db2 = $this->load->database('otherdb', TRUE);
$sql = "delete from commercialuse_stock where commercial_stock_id='$stockid'";
$query=$db2->query($sql);
return $query;
}


}