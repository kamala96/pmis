<?php

class Organization_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
  public function regselect(){
    $query = $this->db->get('em_region');
    $result = $query->result();
    return $result;
  }
  public function countryselect(){
    $db2 = $this->load->database('otherdb', TRUE);
     $sql = "SELECT * FROM `country_zone`";
      $query=$db2->query($sql);
      $result = $query->result();
      return $result;
  }
  public function get_region_id($region){
    $sql    = "SELECT * FROM `em_region` WHERE `region_name`='$region'";
          $query  = $this->db->query($sql);
          $result = $query->row();
    return $result;
  }
  public function get_zone_country($emsCat){
          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `country_zone` WHERE `country_id`='$emsCat'";
          $query  = $db2->query($sql);
          $result = $query->row();
    return $result;
  }
  public function check_zone_name($zone_name,$district){
          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `district_zone_tarrif` WHERE `zone_name`='$zone_name' AND `district_id` = '$district'";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
  }
  public function selectbranch($reg_id){
    $sql    = "SELECT * FROM `em_branch` WHERE `region_id`='$reg_id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
    return $result;
  }
  public function get_supervisorType($usertype){
    $sql    = "SELECT * FROM `employee` WHERE `em_role`='$usertype'";
          $query  = $this->db->query($sql);
          $result = $query->row();
    return $result;
  }

  public function get_services_byId($id){
    $sql = "SELECT * FROM `emp_services` WHERE `serv_id`='$id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
    return $result;
  }
  public function get_contract_byIds($id){
    $sql    = "SELECT * FROM `contract_type` WHERE `cont_id`='$id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
    return $result;
  }
  public function get_subservices(){

        $sql = "SELECT * FROM `subroles` WHERE `sub_name` != 'ADMIN' ";
      
      $query=$this->db->query($sql);
      $result = $query->result();
      return $result;
  }
  public function get_sub_services_list(){

    $db2 = $this->load->database('otherdb', TRUE);
    $sql = "SELECT * FROM `sub_services`";
      
      $query=$db2->query($sql);
      $result = $query->result();
      return $result;
  }
   public function get_agreement_byIds($id){
    $sql    = "SELECT `contract_type`.*,`agreement_type`.* FROM `agreement_type`
     LEFT JOIN `contract_type` ON `contract_type`.`cont_id`=`agreement_type`.`contract_id`
     WHERE `ag_id`='$id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
    return $result;
  }
  public function branchselect(){
    $query = $this->db->get('em_branch');
    $result = $query->result();
    return $result;
  }
    public function boxbranchselect(){
    $sql    = "SELECT * FROM box_branch 
    INNER JOIN em_region ON em_region.region_id=box_branch.region_id ORDER BY branch_id DESC";
    $query  = $this->db->query($sql);
    $result = $query->result();
    return $result;
  }
  public function districtselect(){
    $query = $this->db->get('em_district');
    $result = $query->result();
    return $result;
  }
   public function get_services(){

    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $sub_role = $basicinfo->em_sub_role;
      $em_sect = $basicinfo->em_section_role;
      $dep_id = $basicinfo->dep_id;
      
        $sql = "SELECT * FROM `emp_services`";
      
      $query=$this->db->query($sql);
      $result = $query->result();
      return $result;
  }
  public function get_services34(){

    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $sub_role = $basicinfo->em_sub_role;
      $em_sect = $basicinfo->em_section_role;
      $dep_id = $basicinfo->dep_id;
      $db2 = $this->load->database('otherdb', TRUE);
        $sql = "SELECT * FROM `emp_services`";
      
    $query=$db2->query($sql);
      $result = $query->result();
      return $result;
  }
  public function get_services_super(){

    $id = $this->session->userdata('user_login_id');
      $basicinfo = $this->employee_model->GetBasic($id);
      $sub_role = $basicinfo->em_sub_role;
      $em_sect = $basicinfo->em_section_role;
      $dep_id = $basicinfo->dep_id;

    if ($this->session->userdata('user_type') == 'SUPERVISOR'){

        $sql = "SELECT * FROM `emp_services` WHERE `em_sub_role`= '$sub_role' AND `em_section_role`= '$em_sect'";

      }else{

        $sql = "SELECT * FROM `emp_services` WHERE `em_sub_role`!= '$sub_role' AND `em_section_role` != '$em_sect'";
      }
    
    $query=$this->db->query($sql);
      $result = $query->result();
      return $result;
  }
  public function get_contract(){
    $query = $this->db->get('contract_type');
    $result = $query->result();
    return $result;
  }
  public function get_zone_info(){
      $db2 = $this->load->database('otherdb', TRUE);
    $query = $db2->get('zone_info');
    $result = $query->result();
    return $result;
  }
  public function get_country_zone(){
      $db2 = $this->load->database('otherdb', TRUE);
    $query = $db2->get('country_zone');
    $result = $query->result();
    return $result;
  }
  public function get_agreement(){
    $query = $this->db->get('agreement_type');
    $result = $query->result();
    return $result;
  }
    public function depselect(){
        $query = $this->db->get('department');
        $result = $query->result();
        return $result;
        }
        public function Add_Region($data){
        $this->db->insert('em_region',$data);
      }
      public function Add_Branch($data){
        $this->db->insert('em_branch',$data);
      }
       public function Add_BoxBranch($data){
        $this->db->insert('box_branch',$data);
      }
      public function save_sub_services($save){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sub_services',$save);
      }
      public function save_customers($data){
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('billing_customers',$data);
      }
      public function Add_District($data){
        $this->db->insert('em_district',$data);
      }
       public function save_country_zone($data){
          $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('district_zone_tarriff',$data);
      }
      public function save_pcum_zone($data1){
          $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('tarrif_zone_district_price',$data1);
      }
      public function save_zone_info($data){
          $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('zone_info',$data);
      }
      public function Add_Department($data){
        $this->db->insert('department',$data);
      }
      public function region_delete($region_id){
        $this->db->delete('em_region',array('region_id' => $region_id ));
      }
      public function zone_delete($zoneId){

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->delete('zone_info',array('zone_id' => $zoneId ));

      }
      public function country_delete($countryId){

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->delete('country_zone',array('country_id' => $countryId ));

      }

      public function delete_counter($cid){

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->delete('counters',array('counter_id' => $cid ));

      }
      public function branch_delete($branch_id){
        $this->db->delete('em_branch',array('branch_id' => $branch_id ));
      }
      public function district_delete($district_id){
        $this->db->delete('em_district',array('district_id' => $district_id ));
      }
      public function department_delete($dep_id){
        $this->db->delete('department',array('id' => $dep_id ));
      }
      public function region_edit($region){
          $sql    = "SELECT * FROM `em_region` WHERE `region_id`='$region'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function get_zone_byZoneId($zoneId){

          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `zone_info` WHERE `zone_id`='$zoneId'";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }

      public function get_zone_country_price($zone,$weight,$emstype){

          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `zone_info` WHERE `zone_name`='$zone' AND `weight_step` >= '$weight' AND `ems_type` = '$emstype' LIMIT 1";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }

      public function get_ems_internation_special_tariff($weight){
          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `ems_internation_special_tariff_price` WHERE `weight` >= '$weight' LIMIT 1";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }

      public function get_zone_country_price10($zone,$weight10,$emstype){

          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `zone_info` WHERE `zone_name`='$zone' AND `weight_step` = '$weight10' AND `ems_type` = '$emstype' LIMIT 1";

          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }
      public function get_country_zone_Id($country_id){

          $db2 = $this->load->database('otherdb', TRUE);
          $sql    = "SELECT * FROM `country_zone` WHERE `country_id`='$country_id'";
          $query  = $db2->query($sql);
          $result = $query->row();
          return $result;
      }
      public function branch_edit($branch){
          $sql    = "SELECT * FROM `em_branch` WHERE `branch_id`='$branch'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
       public function boxbranch_edit($branch){
          $sql    = "SELECT * FROM `box_branch` WHERE `branch_id`='$branch'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function district_edit($district){
          $sql    = "SELECT * FROM `em_district` WHERE `district_id`='$district'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function regedit($reg_id){
          $sql    = "SELECT * FROM `em_region` WHERE `region_id`='$reg_id'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function department_edit($dep){
          $sql    = "SELECT * FROM `department` WHERE `id`='$dep'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function Does_region_exists($reg) {
    $user = $this->db->dbprefix('em_region');
        $sql = "SELECT `region_name` FROM $user
    WHERE `region_name`='$reg'";
    $result=$this->db->query($sql);
        if ($result->row()) {
            return $result->row();
        } else {
            return false;
        }
    }
      public function Update_Region($id, $data){
        $this->db->where('region_id',$id);
        $this->db->update('em_region',$data);
      }

      public function update_zone_info($data,$zone_id){
       $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('zone_id',$zone_id);
        $db2->update('zone_info',$data);
      }
       public function update_country_zone($data,$country_id){
       $db2 = $this->load->database('otherdb', TRUE);
        $db2->where('country_id',$country_id);
        $db2->update('country_zone',$data);
      }
      public function update_services($data,$service_id){
        $this->db->where('serv_id',$service_id);
        $this->db->update('emp_services',$data);
      }
       public function update_services2($data,$service_id){
        $db2 = $this->load->database('otherdb', TRUE);
        $this->db2->where('serv_id',$service_id);
        $this->db2->update('emp_services',$data);
      }
      public function update_contract_type($data,$service_id){
        $this->db->where('cont_id',$service_id);
        $this->db->update('contract_type',$data);
      }
      public function update_agreement_type($data,$service_id){
        $this->db->where('ag_id',$service_id);
        $this->db->update('agreement_type',$data);
      }
      public function Update_Branch($id, $data){
        $this->db->where('branch_id',$id);
        $this->db->update('em_branch',$data);
      }
       public function Update_BoxBranch($id, $data){
        $this->db->where('branch_id',$id);
        $this->db->update('box_branch',$data);
      }
      public function Update_Department($id, $data){
        $this->db->where('id',$id);
        $this->db->update('department',$data);
      }

      public function Add_Designation($data){
        $this->db->insert('designation',$data);
      }
    public function designation_delete($des_id){
        $this->db->delete('designation',array('id'=> $des_id));
    }

      public function designation_edit($des){
          $sql    = "SELECT * FROM `designation` WHERE `id`='$des'";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function get_services_byEmId($servId,$emid){
          $sql = "SELECT `servc_emp`.*, `emp_services`.* FROM `servc_emp` LEFT JOIN `emp_services` ON `emp_services`.`serv_id`=`servc_emp`.`servc_id` WHERE `servc_emp`.`emp_id` = $emid";
          $query  = $this->db->query($sql);
          $result = $query->row();
          return $result;
      }
      public function Update_Designation($id, $data){
        $this->db->where('id',$id);
        $this->db->update('designation',$data);
      }
    public function desselect(){
        $query = $this->db->get('designation');
        $result = $query->result();
        return $result;
    }  
    public function save_services($data){
        $this->db->insert('emp_services',$data);
      }
      public function save_contract_type($data){
        $this->db->insert('contract_type',$data);
      }  
	  public function save_agreement_type($data){
        $this->db->insert('agreement_type',$data);
      }
	  public  function supselect(){
		
		$db2 = $this->load->database('otherdb', TRUE);
		$sql = "SELECT `supervisor_attendance`.* FROM `supervisor_attendance` ORDER BY `endday_date` DESC";
		$query=$db2->query($sql);
		$result = $query->result();
		
		return $result;

	}

  public function GetAgreementById($id){

      $this->db->where('contract_id',$id);
      $this->db->order_by('agreement_name');
      $query = $this->db->get('agreement_type');
      $output ='<option value="">--Select Agreement Type--</option>';
      foreach ($query->result() as $row) {
        $output .='<option value="'.$row->agreement_name.'">'.$row->agreement_name.'</option>';
      }
       return $output;
      }
}
?>