<?php

class Stock_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}

        public function Stock_List(){
            $sql = "SELECT * FROM `stock` WHERE `Stock_Categoryid`='1'" ;
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }
}
?>