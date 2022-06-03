<?php

class Inventory_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}

        public function Stock_List(){

            $auth =  $this->session->userdata('sub_user_type');
             $auths = $this->session->userdata('user_type') ;
            $region = $this->session->userdata('user_region');
            $branch = $this->session->userdata('user_branch');
            $em_id = $this->session->userdata('user_emid');

            if ($auth == "PMU") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                  FROM `stock` 
                  INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid`" ;
            }elseif($auth == "STRONGROOM") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'PMU' AND `issued_region` = '$region'";

            }elseif($auth == "BRANCH") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch'";

            }elseif($auth == "COUNTER") {

            $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$id' AND `status` = 'Active' AND `exception` = 'True'  AND `quantity` != 0";
                    }else{
                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'BRANCH' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$em_id' AND `status` = 'Active' AND `exception` = 'False'  AND `quantity` != 0";
                    }
               

            }
           elseif($auths == "ADMIN") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                  FROM `stock` 
                  INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid`" ;
            }
            else{
                $sql = "SELECT `stock_category`.*,`stock`.* 
                  FROM `stock` 
                  INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` LIMIT 0"  ;
            }
            
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;

            }
        public function retured_Stock_List(){

            $auth =  $this->session->userdata('sub_user_type');
            $region = $this->session->userdata('user_region');
            $branch = $this->session->userdata('user_branch');
            $em_id = $this->session->userdata('user_emid');

            if ($auth == "PMU") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                  FROM `stock` 
                  INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid`" ;
            }elseif($auth == "STRONGROOM") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region'  AND  `status` = 'Returned'";

            }elseif($auth == "BRANCH") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch'";

            }elseif($auth == "COUNTER") {

            $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$id' AND `status` = 'Returned' AND `exception` = 'True' ";
                    }else{
                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'BRANCH' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$em_id' AND `status` = 'Returned' AND `exception` = 'False'";
                    }
               

            }
            
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;

            }
        public function Stock_Category_List(){
            $sql = "SELECT * FROM `stock_category`" ;
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }

        public function take_stock($stocktype,$stockname){
            $sql = "SELECT `stock_category`.*,`stock`.* 
            FROM `stock` 
            INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = '$stocktype' AND `stock`.`stampname` = '$stockname'" ;
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function take_stock_issued($stocktype,$stockname){

            $auth   =  $this->session->userdata('sub_user_type');
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            if ($auth == "BRANCH") {
                $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'STRONGROOM' AND `issued_region`= '$region' AND `issued_branch` = '$branch'" ;
            } elseif ($auth == "COUNTER") {
            
            $id = $this->session->userdata('user_emid');

            $get = $this->employee_model->GetBasic($id);

        if ($get->em_branch == "GPO"  || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO"  || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO"|| $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO"  || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO" || $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO" || $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO" || $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

            $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'PMU' AND `issued_region`= '$region'" ;

            }else{

                $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'BRANCH' AND `issued_region`= '$region' AND `issued_branch` = '$branch'" ;
            } 
        }
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function check_issued($stocktype,$stockname){

            $auth   =  $this->session->userdata('sub_user_type');
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');

            if ($auth == "STRONGROOM") {
               $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'PMU' AND `issued_region`= '$region'" ;
            }elseif ($auth == "BRANCH") {
                $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'STRONGROOM' AND `issued_region`= '$region' AND `issued_branch`= '$branch'" ;

            }elseif ($auth == "COUNTER") {
            
            $id = $this->session->userdata('user_emid');

            $get = $this->employee_model->GetBasic($id);

        if ($get->em_branch == "GPO"  || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO"  || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO"|| $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO"  || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO" || $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO" || $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO" || $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

            $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'STRONGROOM' AND `issued_region`= '$region' AND `issued_branch`= '$branch' AND `issued_counter` = 'Exception'" ;

            }else{

            $sql = "SELECT * FROM `stock_issued` WHERE `stock_type` = '$stocktype' AND `stampname` = '$stockname' AND `issuedby` = 'BRANCH' AND `issued_region`= '$region' AND `issued_branch`= '$branch' AND `requested_counter` = '$id'" ;
            }
            }

            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function get_request_incomming(){

            $auth =  $this->session->userdata('sub_user_type');
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            if($auth == 'PMU'){
               $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = 'STRONGROOM'" ;
            }elseif($auth == 'STRONGROOM'){
                $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = 'BRANCH' AND `stock_request`.`requested_region` = '$region' OR (`stock_request`.`exception` = 'True' AND `stock_request`.`requested_by` = 'COUNTER')" ;
            }elseif ($auth == 'BRANCH') {
                $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = 'COUNTER' AND `requested_region` = '$region' AND `requested_branch` = '$branch'" ;
            }
            
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }
        public function get_request_to(){

            $auth =  $this->session->userdata('sub_user_type');
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            $em_id =  $this->session->userdata('user_emid');

            if($auth == 'STRONGROOM'){
               $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = '$auth' AND `stock_request`.`requested_region` = '$region'" ;
            }elseif ($auth == 'BRANCH') {
                $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = '$auth' AND `stock_request`.`requested_region` = '$region' AND `requested_branch`= '$branch'" ;
            }elseif ($auth == 'COUNTER') {

            $id = $this->session->userdata('user_emid');

            $get = $this->employee_model->GetBasic($id);

            if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = '$auth' AND `stock_request`.`requested_region` = '$region' AND `requested_branch`= '$branch' AND `requested_counter`= '$id' AND `exception` = 'True'" ;

            }else{

                $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`requested_by` = '$auth' AND `stock_request`.`requested_region` = '$region' AND `requested_branch`= '$branch' AND `requested_counter`= '$em_id' AND `exception`= 'False'" ;
                }
                
                
            }
            
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }

        public function Save_Stock_Values($df){
            $this->db->insert('stock',$df);
            }
        public function sale_record_save($save){
            
            }
        public function add_issue($addi){
            $this->db->insert('stock_issued',$addi);
            }

        public function insert_stoct_request($data){
            $this->db->insert('stock_request',$data);
            }
        public function transactions_update($update,$serial1){
            $this->db->where('serial',$serial1);
            $this->db->update('transactions',$update);
            }
        public function transactions_save($data){
            $this->db->insert('transactions',$data);
           }
        public function Update_Stock_Values($df,$stid){
                $this->db->where('id', $stid);
                $this->db->update('stock',$df);
            }

        public function Update_Stock_Issued($is,$stids){
                $this->db->where('id', $stids);
                $this->db->update('stock_issued',$is);
            }
        public function Update_Stock_Issued_Values($df,$stids){
                $this->db->where('id', $stids);
                $this->db->update('stock_issued',$df);
            }

        public function Update_Request_status($data,$rid){
                $this->db->where('request_id', $rid);
                $this->db->update('stock_request',$data);
            }
        public function Update_Sale_Status($data,$id){
                $this->db->where('sale_id', $id);
                $this->db->update('sale_record',$data);
            }

        public function Stock_List_ById($stid){
            $sql = "SELECT `stock_category`.*,`stock`.* 
            FROM `stock` 
            INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock`.`id` = '$stid'" ;
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function Sold_Stock_List(){
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            $id =  $this->session->userdata('user_emid');

            $sql = "SELECT `sale_record`.*,`stock_issued`.*,`transactions`.*  
            FROM `sale_record` 
            INNER JOIN `stock_issued` ON `stock_issued`.`id` = `sale_record`.`stock_id` 
            INNER JOIN `transactions` ON `transactions`.`CustomerID` = `sale_record`.`sale_id`
             WHERE `transactions`.`PaymentFor` = 'SB' AND `sale_record`.`operator` = '$id'";
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }

        public function get_issued_stock($id){
            $sql = "SELECT * FROM `stock_issued` WHERE `id` = '$id'" ;
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }
        public function get_request_by_Id($rid){
            $sql = "SELECT `stock_category`.*,`stock_request`.* 
                  FROM `stock_request` 
                  INNER JOIN `stock_category` ON `stock_request`.`stock_type` = `stock_category`.`Stock_Category_Id` WHERE `stock_request`.`request_id` = '$rid'" ;
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function Count_Stock(){
            $auth =  $this->session->userdata('sub_user_type');
               $auths = $this->session->userdata('user_type') ;
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            $em_id =  $this->session->userdata('user_emid');
            if ($auth == "PMU") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                    FROM `stock` 
                    INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid`" ;
            }elseif($auth == "STRONGROOM") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'PMU' AND `issued_region` = '$region'";
                
            }elseif($auth == "BRANCH") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch'";
                
            }elseif($auth == "COUNTER") {

            $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$id' AND `status` = 'Active' AND `exception` = 'True'   AND `quantity` != 0";
                    }else{
                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'BRANCH' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$em_id' AND `status` = 'Active' AND `exception` = 'False'  AND `quantity` != 0";
                    }
               
            }elseif ($auths == "ADMIN") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                    FROM `stock` 
                    INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid`" ;
            }
             else{
                $sql = "SELECT `stock_category`.*,`stock`.* 
                  FROM `stock` 
                  INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` LIMIT 0"  ;
            }
            
            $query=$this->db->query($sql);
            return $query->num_rows();
            }

        public function Count_Cash(){

            $auth =  $this->session->userdata('sub_user_type');
            $auths = $this->session->userdata('user_type') ;
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            $em_id =  $this->session->userdata('user_emid');
            if ($auth == "PMU") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Cash'" ;
            }elseif($auth == "STRONGROOM") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'PMU' AND `issued_region` = '$region' AND `stock_type` = 'Cash'";
                
            }elseif($auth == "BRANCH") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `stock_type` = 'Cash' AND `issued_branch` = '$branch'";
                
            }elseif($auth == "COUNTER") {

                $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$id' AND `status` = 'Active' AND `exception` = 'True' AND `stock_type` = 'Cash'  AND `quantity` != 0";
                    }else{
                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'BRANCH' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$em_id' AND `status` = 'Active' AND `exception` = 'False' AND `stock_type` = 'Cash'  AND `quantity` != 0";
                    }

               
            }
              elseif ($auths == "ADMIN") {
                  $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Cash'" ;
            }
            else{
             $sql = "SELECT `stock_category`.*,`stock`.* 
                    FROM `stock` 
                    INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Cash' LIMIT 0" ;

            }
            
            $query=$this->db->query($sql);
            return $query->num_rows();
            }

        public function Count_Locks(){

            $auth =  $this->session->userdata('sub_user_type');
             $auths = $this->session->userdata('user_type') ;
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            $em_id =  $this->session->userdata('user_emid');
            if ($auth == "PMU") {
                $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Locks'" ;
            }elseif($auth == "STRONGROOM") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'PMU' AND `issued_region` = '$region' AND `stock_type` = 'Locks'";
                
            }elseif($auth == "BRANCH") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `stock_type` = 'Locks' AND `issued_branch` = '$branch'";
                
            }elseif($auth == "COUNTER") {

                $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$id' AND `status` = 'Active' AND `exception` = 'True' AND `stock_type` = 'Locks' AND `quantity` != 0";
                    }else{
                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'BRANCH' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$em_id' AND `status` = 'Active' AND `exception` = 'False' AND `stock_type` = 'Locks' AND `quantity` != 0";
                    }

            }
            elseif ($auths == "ADMIN") {
                $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Locks'" ;
            }
            else{
             $sql = "SELECT `stock_category`.*,`stock`.* 
                    FROM `stock` 
                    INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Locks' LIMIT 0" ;

            }
            $query=$this->db->query($sql);
            return $query->num_rows();
            }

        public function Count_Stampbureau(){

            $auth =  $this->session->userdata('sub_user_type');
              $auths = $this->session->userdata('user_type') ;
            $region =  $this->session->userdata('user_region');
            $branch =  $this->session->userdata('user_branch');
            $em_id =  $this->session->userdata('user_emid');
            if ($auth == "PMU") {
                $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Stamp' OR `stock_category`.`CategoryName` = 'Philatelic Stamp'" ;
            }elseif($auth == "STRONGROOM") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'PMU' AND `issued_region` = '$region' AND (`stock_type` = 'Stamp' OR `stock_type` = 'Philatelic Stamp')";
                
            }elseif($auth == "BRANCH") {

               $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND (`stock_type` = 'Stamp' OR `stock_type` = 'Philatelic Stamp') AND `issued_branch` = '$branch'";
                
            }elseif($auth == "COUNTER") {

            $id = $this->session->userdata('user_emid');

                    $get = $this->employee_model->GetBasic($id);

                    if ($get->em_branch == "GPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Dodoma-HPO" || $get->em_branch == "Geita-HPO" || $get->em_branch == "Iringa-HPO" || $get->em_branch == "Kagera-HPO" || $get->em_branch == "Katavi-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Kigoma-HPO" || $get->em_branch == "Kilimanjaro-HPO" || $get->em_branch == "Lindi-HPO" || $get->em_branch == "Manyara-HPO" || $get->em_branch == "Arusha-HPO" || $get->em_branch == "Mara-HPO" || $get->em_branch == "Mbeya-HPO" || $get->em_branch == "Morogoro-HPO" || $get->em_branch == "Mtwara-HPO" || $get->em_branch == "Mwanza-HPO" || $get->em_branch == "Njombe-HPO" || $get->em_branch == "Rukwa-HPO"|| $get->em_branch == "Ruvuma-HPO"|| $get->em_branch == "Shinyanga-HPO"|| $get->em_branch == "Simiyu-HPO"|| $get->em_branch == "Singida-HPO"|| $get->em_branch == "Songwe-HPO"|| $get->em_branch == "Tabora-HPO"|| $get->em_branch == "Tanga-HPO") {

                    $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'STRONGROOM' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$id' AND `status` = 'Active' AND `exception` = 'True' AND (`stock_type` = 'Stamp' OR `stock_type` = 'Philatelic Stamp')  AND `quantity` != 0";
                    
                    }else{

                        $sql = "SELECT * FROM `stock_issued` WHERE `issuedby` = 'BRANCH' AND `issued_region` = '$region' AND `issued_branch` = '$branch' AND `issued_counter` = '$em_id' AND `status` = 'Active' AND `exception` = 'False' AND (`stock_type` = 'Stamp' OR `stock_type` = 'Philatelic Stamp')  AND `quantity` != 0";
                    }

               
            }
             elseif ($auths == "ADMIN") {
                $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Stamp' OR `stock_category`.`CategoryName` = 'Philatelic Stamp'" ;
            }
             else{
             $sql = "SELECT `stock_category`.*,`stock`.* 
                FROM `stock` 
                INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Stamp' OR `stock_category`.`CategoryName` = 'Philatelic Stamp' LIMIT  0 1" ;

            }
            
            $query=$this->db->query($sql);
            return $query->num_rows();
            }

        public function Stamps_List_View(){
            $sql = "SELECT `stock_category`.*,`stock`.* 
            FROM `stock` 
            INNER JOIN `stock_category` ON `stock_category`.`Stock_Category_Id` = `stock`.`Stock_Categoryid` WHERE `stock_category`.`CategoryName` = 'Stamp' OR `stock_category`.`CategoryName` = 'Philatelic Stamp'" ;
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }

        public function getStockNameById($stid){
            $this->db->where('  Stock_Categoryid ',$stid);
            $this->db->order_by('stampname');
            $query = $this->db->get('stock');
            $output ='<option value="">--Select Stock Name--</option>';
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->stampname.'">'.$row->stampname.'</option>';
            }
             return $output;
          }

}
?>