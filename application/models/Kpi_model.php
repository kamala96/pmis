<?php

class Kpi_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
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

        public function get_department($design){
                
              $sql = "SELECT `employee`.*,
              `designation`.*,
              `department`.*
              FROM `employee`
              LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
              LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
              WHERE `designation`.`des_name`='$design'";
                $query=$this->db->query($sql);
                $result = $query->row();
                return $result;

            }
            public function get_staff($deptid){
                
              $sql = "SELECT `employee`.*,
              `designation`.*,
              `department`.*
              FROM `employee`
              LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
              LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
              WHERE `department`.`id`='$deptid' AND `employee`.`em_role` != 'AGENT' AND `employee`.`status` = 'ACTIVE'";
                $query=$this->db->query($sql);
                $result = $query->result();
                return $result;

            }
        public function add_kpi_values($data){
            $this->db->insert('kpiobjective',$data);
            }
        public function add_kpi_who_to_see($data1){
            $this->db->insert(' who_to_see',$data1);
            }
        public function add_kpi_goal($data){
            $this->db->insert('objective_goals',$data);
            }
        public function add_kpi_goal_values($data){
            $this->db->insert('kpi_goals_form',$data);
            }
        public function get_all_kpi(){

            $id = $this->session->userdata('user_login_id');
            $info = $this->GetBasic($id);

            $design = $info->des_name;

                $sql = "SELECT `who_to_see`.*,`kpiobjective`.* FROM `kpiobjective` 
            INNER JOIN `who_to_see` ON `who_to_see`.`objective_id` = `kpiobjective`.`objective_id` WHERE `who_to_see`.`designation` = '$design' OR `who_to_see`.`designation` = '$id'";
          
          
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            } 
        public function general_kpi_report1($design){

                $des = trim($design);
                $sql = "SELECT `who_to_see`.*,`kpiobjective`.* FROM `kpiobjective` 
            INNER JOIN `who_to_see` ON `who_to_see`.`objective_id` = `kpiobjective`.`objective_id` WHERE `who_to_see`.`designation` = '$des'";
          
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;

            } 

            public function getDesignation($id){
                
              $sql = "SELECT `employee`.*,
              `designation`.*,
              `department`.*
              FROM `employee`
              LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
              LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`";

                $query=$this->db->query($sql);
                $result = $query->result();
                return $result;

            }

            public function get_desnation(){
                
              $sql = "SELECT distinct(designation) FROM who_to_see";

                $query=$this->db->query($sql);
                $result = $query->result();
                return $result;

            }

            public function get_all_kpi1(){

            $id = $this->session->userdata('user_login_id');
            $info = $this->GetBasic($id);

            $design = $info->des_name;
            
                $sql = "SELECT * FROM `kpiobjective`";
          
          
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            }  

            public function get_all_kpi_sum(){

            $id = $this->session->userdata('user_login_id');
            $info = $this->GetBasic($id);

            $design = $info->des_name;
            
                $sql = "SELECT `who_to_see`.*,SUM(`kpiobjective`.`marks`) AS `total` FROM `kpiobjective` 
            INNER JOIN `who_to_see` ON `who_to_see`.`objective_id` = `kpiobjective`.`objective_id` WHERE `who_to_see`.`designation` = '$design' OR `who_to_see`.`designation` = '$id'";
            
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            } 

        public function get_all_kpi_sum1(){

            $id = $this->session->userdata('user_login_id');
            $info = $this->GetBasic($id);

            $design = $info->des_name;
            
                $sql = "SELECT SUM(`kpiobjective`.`marks`) AS `total` FROM `kpiobjective`";
            
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            } 
        
        public function get_goals($kpid){

            $sql = "SELECT * FROM `objective_goals` WHERE `objective_id` = '$kpid'" ;
         
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            } 
        public function get_employee(){

            $sql = "SELECT `employee`.*,
              `designation`.*,
              `department`.*
              FROM `employee`
              LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
              LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`";
         
            $query=$this->db->query($sql);
            $result = $query->result();
            return $result;
            } 

        public function get_objective_by_id($kpid){

            $sql = "SELECT * FROM `kpiobjective` WHERE `objective_id` = '$kpid'" ;
         
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function get_kpi_goals($id){

            $sql = "SELECT * FROM `objective_goals` WHERE `goals_id` = '$id'" ;
         
            $query=$this->db->query($sql);
            $result = $query->row();
            return $result;
            }

        public function getSumMarks($kpid){

        $sql    = "SELECT SUM(`marks`) as `marks` FROM `objective_goals` WHERE `objective_goals`.`objective_id` = $kpid";

        $query=$this->db->query($sql);
        $result = $query->row();
        return $result;
    }  

    public function update_kpi_target($goalsid,$data)
    {
        $this->db->where('goals_id',$goalsid);
        $this->db->update('objective_goals',$data);
    }

    public function GetGoalsById($objid){

        $sql    = "SELECT * FROM `objective_goals` WHERE `objective_id`='$objid'";
                  $query  = $this->db->query($sql);
            $output="<option>--Select Goals/Target--</option>";
            foreach ($query->result() as $row) {
              $output .='<option value="'.$row->goals_id.'">'.$row->target_name.'              marks('.$row->marks.')'.'</option>';
            }
             return $output;
    }

    public function GetMarksById($objid){

        $sql    = "SELECT * FROM `kpiobjective` WHERE `objective_id`='$objid'";
                  $query=$this->db->query($sql);
                  $result = $query->row();
                  return $result;
    }

    public function get_goals_kpi($goalsid){

        $usertype = $this->session->userdata('user_type');
        $id = $this->session->userdata('user_login_id');
            $info = $this->GetBasic($id);

            $design = $info->des_name;

        $sql    = "SELECT * FROM `kpi_goals_form` WHERE `goals_id`='$goalsid' AND `user_type` = '$usertype' AND `designation` = '$design' OR `designation` = '$id'";
        $query=$this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function update_kpi($data,$id)
    {
        $this->db->where('kpi_id',$id);
        $this->db->update('kpi_goals_form',$data);
    }  

    public function update_objective($data,$objid)
    {
        $this->db->where('objective_id',$objid);
        $this->db->update('kpiobjective',$data);
    }  

    public function delete_objective($objId){
              $this->db->delete('kpiobjective',array('objective_id'=> $objId));
          }

    public function delete_kpi_target($goalsid){
              $this->db->delete('objective_goals',array('goals_id'=> $goalsid));
          }
}
?>