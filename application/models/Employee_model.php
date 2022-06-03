<?php

	class Employee_model extends CI_Model{


			function __consturct(){
			parent::__construct();

			}

			public function getEmpDepartmentSections($empid){
				$sql = "select * from dept_sections 
				inner join employee on employee.sectionid = dept_sections.id 
				where employee.em_id = '$empid' ";

				$query  = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}

			public function getEmployeeBySection($section){
				$sql = "select * from employee 
				where employee.sectionid = '$section' ";

				$query  = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}

			public function getDepartmentSections($departId='',$sectionid=''){
				$sql = 'select * from dept_sections where 1=1 ';

				if ($sectionid) $sql.=' and id = '.$sectionid;
				if ($departId) $sql.=' and departid = '.$departId;

				$query  = $this->db->query($sql);
				$result = $query->result_array();
				return $result;
			}

			public function getdesignation(){
			$query = $this->db->get('designation');
			$result = $query->result();
			return $result;
			}
			public function bankList(){
			$query = $this->db->get('bank_name');
			$result = $query->result();
			return $result;
			}
		  public function getdesignation1($des_id){
		  $sql    = "SELECT * FROM `designation` WHERE `id`='$des_id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;
		  }
		public  function counterselect(){
		$db2 = $this->load->database('otherdb', TRUE);
		$id = $this->session->userdata('user_login_id');
		$info = $this->employee_model->GetBasic($id);
				$o_region = $info->em_region;
				$o_branch = $info->em_branch;
		if ($this->session->userdata('user_type') == "ADMIN") {
			$sql    = "SELECT * FROM `counters` WHERE  `c_status`='NotAssign'";
		} else {
			$sql    = "SELECT * FROM `counters` WHERE `counter_region`='$o_region' AND `counter_branch`='$o_branch' AND `c_status`='NotAssign'";
		}
		
		
		
		$query  = $db2->query($sql);
		$result = $query->result();
		return $result;

	}
		  public function get_code_source($o_region){

		  $sql    = "SELECT * FROM `em_region` WHERE `region_name`='$o_region'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;

		  }

		  public function get_code_branch($o_branch){

		  $sql    = "SELECT * FROM `em_branch` WHERE `branch_name`='$o_branch'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;

		  }

		  public function Check_Exist($id){

		  $sql    = "SELECT * FROM `bank_info` WHERE `em_id`='$id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;
		  
		  }
		  public function get_code_dest($rec_region){
		  $sql    = "SELECT * FROM `em_region` WHERE `region_name`='$rec_region'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;
		  }
		  public function get_code_dest1($id){
		  $sql    = "SELECT * FROM `em_region` WHERE `region_id`='$id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;
		  }
		  public function getFamilyById($id){
			$sql    = "SELECT * FROM `em_familly` WHERE `family_Id`='$id'";
			$query  = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}

		 public function getusertype(){
			$sql    = "SELECT * FROM `user_type` WHERE `type_name`!='SUPER ADMIN'
			AND `type_name`!='PMG' AND `type_name`!='BOP' AND `type_name`!='CRM'
			AND `type_name`!='HR-PAY'AND `type_name`!='GM'";
			$query  = $this->db->query($sql);
			$result = $query->result();
			return $result;
		}

		   public function getusertype_superadmin(){
		  $query = $this->db->get('user_type');
		  $result = $query->result();
		  return $result;
		  }

		  public function Get_Branch($region){

			$sql    = "SELECT * FROM `em_region` 
			          inner join `em_branch` on `em_branch`.`region_id`=`em_region`.`region_id`
			          WHERE `region_name`='$region'";
					  $query  = $this->db->query($sql);
					  $result = $query->result();
					  
				 return $result;
			  }

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

		  public function GetBoxBranchById($region_id){

			$sql    = "SELECT * FROM `em_region` WHERE `region_name`='$region_id'";
					  $query  = $this->db->query($sql);
					  $result = $query->row();
					  $id = $result->region_id;
	
				$this->db->where('region_id',$id);
				$this->db->order_by('branch_name');
				$query = $this->db->get('box_branch');
				$output ='<option value="">Select Branch</option>';
				foreach ($query->result() as $row) {
				  $output .='<option value="'.$row->branch_name.'">'.$row->branch_name.'</option>';
				}
				 return $output;
			  }

		  public function GetBranchById1($reg,$acc){

		$sql    = "SELECT * FROM `em_region` WHERE `region_name`='$reg'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
				  $id = $result->region_id;

		$db2 = $this->load->database('otherdb', TRUE);

		$sql1    = "SELECT `branch_bill_credit_customer`.* FROM `branch_bill_credit_customer`  
           WHERE `branch_bill_credit_customer`.`acc_no` = '$acc' AND `branch_bill_credit_customer`.`customer_region` = '$reg' GROUP BY `branch_bill_credit_customer`.`customer_branch`";


		$query1  = $db2->query($sql1);


		$result1 = $query1->result();

			$this->db->where('region_id',$id);
			$this->db->order_by('branch_name');
			$query = $this->db->get('em_branch');
			
			$output = "<input type='hidden' name='region[]' value='$reg'/>";

			//customer list
			foreach ($result1 as $key => $value) {
				$customerList[$value->customer_branch]['name'] = $value->customer_branch;
			}

			foreach ($query->result() as $row) {

	 			if (isset($customerList[$row->branch_name]['name']) == $row->branch_name) {
	 					$output .= "&nbsp;<label>".$row->branch_name.'</label>  &nbsp;'."<input type='checkbox' id='vehicle1' name='branch[]' value='".$row->branch_name."' style='height:25px;width:25px;
	 			        padding: 10px;' checked>";
	 			}else{
	 					$output .= "&nbsp;<label>".$row->branch_name.'</label>  &nbsp;'."<input type='checkbox' id='vehicle1' name='branch[]' value='".$row->branch_name."' style='height:25px;width:25px;
	 			        padding: 10px;'>";
	 			}

			}


			 return $output;
			 
		  }


		  public function GetDistrictById($region_id){

			$sql    = "SELECT * FROM `em_region` WHERE `region_name`='$region_id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
				  $id = $result->region_id;

			$this->db->where('region_id',$id);
			$this->db->order_by('district_name');
			$query = $this->db->get('em_district');
			$output ='<option value="">--Select District--</option>';
			foreach ($query->result() as $row) {
			  $output .='<option value="'.$row->district_name.'">'.$row->district_name.'</option>';
			}
			 return $output;
		  }

		  public function selectbranch($regionresult){
		   $sql    = "SELECT * FROM `em_branch` WHERE `region_id`='$regionresult'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
			return $result;
		  }
		   public function selectbranch1($regionresult){
		   $sql    = "SELECT * FROM `em_branch` WHERE `region_id`='$regionresult'";
				  $query  = $this->db->query($sql);
				  $result = $query->result();
			return $result;
		  }
		  public function branchselect1($reg){
		   $sql    = "SELECT * FROM `em_region` WHERE `region_name`='$reg'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
				  $id = $result->region_id;

				  $sql1    = "SELECT * FROM `em_branch` WHERE `region_id`='$id'";
				  $query1  = $this->db->query($sql1);
				  $result1 = $query1->result();
			return $result1;
		  }
		  public function branchselect(){
			$query = $this->db->get('em_branch');
			$result = $query->result();
			return $result;
		  }
		  public function districtselect(){
			$query = $this->db->get('em_district');
			$result = $query->result();
			return $result;
		  }

		  public function regselect(){
		  //$query = $this->db->get('em_region');
		  $sql = "SELECT * FROM em_region ORDER BY region_name ASC";
		  $query  = $this->db->query($sql);
		  $result = $query->result();
		  return $result;
		  }

		   

		  public function getdepartment(){
			$query = $this->db->get('department');
			$result = $query->result();
			return $result;
			}
			 public function getmusedepartment(){
			$query = $this->db->get('musedepartment');
			$result = $query->result();
			return $result;
			}

			 public function getmusedepartmentvalue($dep_id){
		  $sql    = "SELECT * FROM `musedepartment` WHERE `id`='$dep_id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;
		  }

		  public function getdepartment1($dep_id){
		  $sql    = "SELECT * FROM `department` WHERE `id`='$dep_id'";
				  $query  = $this->db->query($sql);
				  $result = $query->row();
		  return $result;
		  }

		  public function SearchEmployee($data){


		  if ($data['region'] != '' && $data['branch'] != '') {
			$em_region = $data['region'];$em_branch = $data['branch'];
			$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$em_region' AND `em_branch` = '$em_branch' ORDER BY `em_code` ASC";
		  }
		  else
		  {
			  if ($data['region'] != '') {
			  $em_region = $data['region'];
			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$em_region' ORDER BY `em_code` ASC";
			}

		  }
			if ($data['em_code'] != '') {
			$em_code = $data['em_code'];
			$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_code` = '$em_code' ORDER BY `em_code` DESC";
		  }



		  $query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		  }

		  public function get_count()
		  {
			 $this->db->where('status','RETIRED');
			 return $this->db->count_all('employee');
		  }
		  public function emselectPagination($limit,$start){
		  $this->db->where('status','ACTIVE');
		  $this->db->order_by('em_code','ASC');
		   $this->db->limit($limit, $start);
				$query = $this->db->get('employee');

				return $query->result();

		  }
		  public function emselectPagination1($limit,$start){
		  $this->db->where('status','RETIRED');
		  $this->db->order_by('em_code','ASC');
		   $this->db->limit($limit, $start);
				$query = $this->db->get('employee');

				return $query->result();

		  }
		  public function GetHODNumber($depid){

		  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE'  AND `dep_id` = '$depid' AND `em_role` = 'HOD' ORDER BY `em_code` DESC";
		  $query=$this->db->query($sql);
			  $result = $query->row();
			return $result;

		  }

		  

		  public function GetStaffByRoleEmid($emid,$RoleName){

		  $sql = "SELECT  `designation`.*, `employee`.* FROM `employee` 
		  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
		  WHERE `employee`.`status`='ACTIVE' AND `employee`.`em_id` = '$emid'
		   -- AND `employee`.`em_role` = '$RoleName' 
		  ORDER BY `employee`.`em_code` DESC";
		  $query=$this->db->query($sql);
			  $result = $query->row();
			return $result;

		  }

		 

		   public function GetStaffByRole($RoleName){

		   $sql = "SELECT  `designation`.*, `employee`.* FROM `employee` 
		  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
		  WHERE `employee`.`status`='ACTIVE'  AND `employee`.`em_role` = '$RoleName' 
		  ORDER BY `employee`.`em_code` ASC";
		  $query=$this->db->query($sql);
			  $result = $query->row();
			return $result;

		  }

		  public function agselect(){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  $em_branch = $basicinfo->em_branch;
		  $dep_id = $basicinfo->dep_id;


			$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region'  AND `em_role` = 'AGENT' ORDER BY `em_code` ASC";
		  

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}
		  public function emselect(){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  $em_branch = $basicinfo->em_branch;
		  $dep_id = $basicinfo->dep_id;

		  if ($this->session->userdata('user_type') == 'RM')
		  {
		  	if($region =="Dar es Salaam")
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` != 'AGENT'  AND `em_branch` != 'Post Head Office' AND `em_branch` != 'Posta Head Office' ORDER BY `em_code` ASC";
		  	}else
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` != 'AGENT' ORDER BY `em_code` ASC";
		     }
			  
		  	
		  	
		  }elseif ($this->session->userdata('user_type') == 'HOD')
		  {
			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `dep_id` = '$dep_id' AND `em_role` != 'AGENT' ORDER BY `em_code` ASC";
		  }elseif ($this->session->userdata('user_type') == 'SUPERVISOR'){

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region'  AND `em_branch` = '$em_branch' AND `dep_id` = '$dep_id'  ORDER BY `em_code` ASC";
		  }
		  else{

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_role` != 'AGENT' ORDER BY `em_code` ASC";
		  }

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}

		public function delivereselect(){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  $em_branch = $basicinfo->em_branch;
		  $dep_id = $basicinfo->dep_id;

		  if ($this->session->userdata('user_type') == 'RM'){

		  	if($region =="Dar es Salaam"){
		  		$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` = 'DERIVERER'  AND `em_branch` != 'Post Head Office' AND `em_branch` != 'Posta Head Office' OR `subuser_type` = 'deriver' ORDER BY `em_code` ASC";
		  	}else{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` = 'DERIVERER' OR `subuser_type` = 'deriver' ORDER BY `em_code` ASC";
		     }
			  
		  	
		  	
		  }elseif ($this->session->userdata('user_type') == 'HOD'){

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `dep_id` = '$dep_id' AND `em_role` = 'DERIVERER' OR `subuser_type` = 'deriver' ORDER BY `em_code` ASC";

		  }elseif ($this->session->userdata('user_type') == 'SUPERVISOR'){

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region'  AND `em_branch` = '$em_branch' AND `dep_id` = '$dep_id' AND `em_role` = 'DERIVERER' OR `subuser_type` = 'deriver'  ORDER BY `em_code` ASC";
		  }else{

			  // $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_role` = 'DERIVERER' OR `subuser_type` = 'deriver' and `em_region` = '$region'  group by `em_region` ORDER BY `em_code` ASC";

		  	 $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_role` = 'DERIVERER' 
			  AND `em_region` = '$region' UNION ALL SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `subuser_type` = 'deriver' ORDER BY `em_code` ASC";
			  
		  }

		  // echo $sql;die();

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}

		public function delivereselectByType($type){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  $em_branch = $basicinfo->em_branch;
		  $dep_id = $basicinfo->dep_id;

		  $sql = "select * from `employee` where `status`='ACTIVE' and `em_role` = 'DERIVERER' and `subuser_type` = '".$type."' order by `em_code` asc";

		  //echo $sql;die();

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}

		/*public function delivereselect(){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  $em_branch = $basicinfo->em_branch;
		  $dep_id = $basicinfo->dep_id;

		  if ($this->session->userdata('user_type') == 'RM')
		  {
		  	if($region =="Dar es Salaam")
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` = 'DERIVERER'  AND `em_branch` != 'Post Head Office' AND `em_branch` != 'Posta Head Office' ORDER BY `em_code` ASC";
		  	}else
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` = 'DERIVERER' ORDER BY `em_code` ASC";
		     }
			  
		  	
		  	
		  }elseif ($this->session->userdata('user_type') == 'HOD')
		  {
			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `dep_id` = '$dep_id' AND `em_role` = 'DERIVERER' ORDER BY `em_code` ASC";
		  }elseif ($this->session->userdata('user_type') == 'SUPERVISOR'){

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region'  AND `em_branch` = '$em_branch' AND `dep_id` = '$dep_id' AND `em_role` = 'DERIVERER'  ORDER BY `em_code` ASC";
		  }
		  else{

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_role` = 'DERIVERER' ORDER BY `em_code` ASC";
		  }

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}*/

		public function emselectRetired(){
			  $id = $this->session->userdata('user_login_id');
			  $basicinfo = $this->employee_model->GetBasic($id);
			  $region = $basicinfo->em_region;
			  $em_id = $basicinfo->em_id;

      	if ($this->session->userdata('user_type') == 'RM')
		  {
		  	if($region =="Dar es Salaam")
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='RETIRED' AND `em_region` = '$region'   AND `em_branch` != 'Post Head Office' AND `em_branch` != 'Posta Head Office' ORDER BY `em_code` DESC";
		  	}else
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='RETIRED' AND `em_region` = '$region' ORDER BY `em_code` DESC";
		     }
			  
		  }elseif ($this->session->userdata('user_type') == 'HOD')
		{
			$sql = "SELECT * FROM `employee` WHERE `status`='RETIRED' AND `em_region` = '$region' AND `dep_id` = '$basicinfo->dep_id' ORDER BY `em_code` DESC";
		}else{
			$sql = "SELECT * FROM `employee` WHERE `status`='RETIRED' ORDER BY `em_code` DESC";
		}


			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}
		public function emselectDischarge(){
			  $id = $this->session->userdata('user_login_id');
			  $basicinfo = $this->employee_model->GetBasic($id);
			  $region = $basicinfo->em_region;
			  $em_id = $basicinfo->em_id;

      	if ($this->session->userdata('user_type') == 'RM')
		  {
			  $sql = "SELECT * FROM `employee` WHERE `status`='DEATH' OR `status`='DISPLINARY' OR `status`='RESIGNATION' AND `em_region` = '$region' ORDER BY `em_code` DESC";
		  }elseif ($this->session->userdata('user_type') == 'HOD')
		{
			$sql = "SELECT * FROM `employee` WHERE `status`='DEATH' OR `status`='DISPLINARY' OR `status`='RESIGNATION' AND `em_region` = '$region' AND `dep_id` = '$basicinfo->dep_id' ORDER BY `em_code` DESC";
		}else{
			$sql = "SELECT * FROM `employee` WHERE `status`='DEATH' OR `status`='DISPLINARY' OR `status`='RESIGNATION' ORDER BY `em_code` DESC";
		}


			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}
	public function emselectAgent(){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  $em_branch = $basicinfo->em_branch;
		  $dep_id = $basicinfo->dep_id;

		  if ($this->session->userdata('user_type') == 'RM')
		  {
		  	if($region =="Dar es Salaam")
		  	{
		  		  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` = 'AGENT'
			  AND `em_branch` != 'Post Head Office' AND `em_branch` != 'Posta Head Office' 
			   ORDER BY `em_code` ASC";
		  	}else
		  	{
		  		  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `em_role` = 'AGENT'

			           ORDER BY `em_code` ASC";
		     }



			
		  }elseif ($this->session->userdata('user_type') == 'HOD')
		  {
			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_region` = '$region' AND `dep_id` = '$dep_id' AND `em_role` = 'AGENT' ORDER BY `em_code` ASC";
		  }elseif ($this->session->userdata('user_type') == 'SUPERVISOR'){

		  	if($region =="Dar es Salaam")
		  	{
		  		  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' 
		  		  AND `em_region` = '$region' 
		  		   AND `em_branch` = '$em_branch'
			  AND `em_branch` != 'Post Head Office' 
			  AND `em_branch` != 'Posta Head Office'
			  AND  `dep_id`='$dep_id'
			   ORDER BY `em_code` ASC";
		  	}else
		  	{
		  		  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE'
		  		   AND `em_region` = '$region' 
		  		    AND `em_branch` = '$em_branch'
		  		   AND  `dep_id`='$dep_id'
			           ORDER BY `em_code` ASC";
		     }

			 
		  }
		  else{

			  $sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_role` = 'AGENT' ORDER BY `em_code` ASC";
		  }

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}
		  public function emselectleave(){
		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;

			$sql = "SELECT * FROM `employee` WHERE `status`='ACTIVE' AND `em_id` = '$em_id'";
			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		  }
		  public function emselectByID($emid){
			$sql = "SELECT * FROM `employee`
			  WHERE `em_id`='$emid'";
			$query=$this->db->query($sql);
			$result = $query->row();
			return $result;
			}
		  public function emselectByID1($emid){
			$sql = "SELECT * FROM `employee`
			  WHERE `em_id`='$emid'";
			 $query=$this->db->query($sql);
			$result = $query->row();
			return $result;
		  }
		  public function leaveByID($emid){
			$sql = "SELECT * FROM `emp_leave`
			  WHERE `em_id`='$emid'";
			$query=$this->db->query($sql);
		  $result = $query->row();
		  return $result;
		  }
		  public function emselectByCode($emid){
			$sql = "SELECT * FROM `employee`
			  WHERE `em_code`='$emid'";
			$query=$this->db->query($sql);
			$result = $query->row();
			return $result;
			}
          public function getInvalidUser(){

			  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;
		  if ($this->session->userdata('user_type')=='RM') {


		  	if($region =="Dar es Salaam")
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='INACTIVE' AND `em_region` = '$region'   AND `em_branch` != 'Post Head Office' AND `em_branch` != 'Posta Head Office' ";
		  	}else
		  	{
		  		$sql = "SELECT * FROM `employee` WHERE `status`='INACTIVE' AND `em_region` = '$region' ";
		     }

		  }elseif ($this->session->userdata('user_type')=='HOD') {
			  $sql = "SELECT * FROM `employee`
			  WHERE `status`='INACTIVE' AND `em_region` = '$region' AND `dep_id` = '$basicinfo->dep_id'";
		  }
		  else{
			  $sql = "SELECT * FROM `employee`
			  WHERE `status`='INACTIVE'";
		  }

				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function Does_email_exists($email) {
				$user = $this->db->dbprefix('employee');
				$sql = "SELECT `em_email` FROM $user
				WHERE `em_email`='$email'";
				$result=$this->db->query($sql);
				if ($result->row()) {
					return $result->row();
				} else {
					return false;
				}
			}
			public function Does_PF_exists($eid) {
			$user = $this->db->dbprefix('employee');
				$sql = "SELECT `em_code` FROM $user
			WHERE `em_code`='$eid'";
			$result=$this->db->query($sql);
				if ($result->row()) {
					return $result->row();
				} else {
					return false;
				}
			}
			public function Add($data){
				$this->db->insert('employee',$data);
			}
			public function save_login_log($data){
				$this->db->insert('login_log',$data);
			}
			public function save_login_log2($data){
				$db2 = $this->load->database('otherdb', TRUE);
				$db2->insert('logs',$data);
			}

			public function Get_employee_muse_dept(){
				
			  $sql = "SELECT *
			  FROM `employee`
			  WHERE `muse_dept_id`='0' OR `muse_dept_id`='' OR `muse_dept_id` IS NULL";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;

			}

			public function Get_muse_dept_region($region){
				
			  $sql = "SELECT *
			  FROM `musedepartment`
			  WHERE `dep_name` LIKE '%$region%' ";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

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
			public function GetBasic2($id,$emcode){
				
			  $sql = "SELECT `employee`.*,
			  `designation`.*,
			  `department`.*
			  FROM `employee`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  WHERE `em_id`='$id' AND `em_code` = '$em_code'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			}

				public function GetBasic22($em_code){
				
			  $sql = "SELECT `employee`.*,
			  `designation`.*,
			  `department`.*
			  FROM `employee`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  WHERE  `em_code` = '$em_code'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			}

			
			public function GetBasic1($pfno){
				
			  $sql = "SELECT `employee`.*,
			  `designation`.*,
			  `department`.*
			  FROM `employee`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  WHERE `em_code`='$pfno'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			}
			public function getRegion($bra){
				
			  $sql = "SELECT `em_branch`.*,
			  `em_region`.*
			  FROM `em_branch`
			  LEFT JOIN `em_region` ON `em_region`.`region_id`=`em_branch`.`region_id`
			  WHERE `em_branch`.`branch_name`='$bra'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;

			}

			


			public function getInfo($emid){

			  $sql = "SELECT `employee`.*,
			  `designation`.*,
			  `department`.*
			  FROM `employee`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  WHERE `em_code`='$emid'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;

			}
			public function ProjectEmployee($id){
			  $sql = "SELECT `assign_task`.`assign_user`,
			  `employee`.`em_id`,`first_name`,`last_name`
			  FROM `assign_task`
			  LEFT JOIN `employee` ON `assign_task`.`assign_user`=`employee`.`em_id`
			  WHERE `assign_task`.`project_id`='$id' AND `user_type`='Team Head'";
			  $query=$this->db->query($sql);
			  $result = $query->result();
			  return $result;
			}
			public function GetperAddress($id){
			  $sql = "SELECT * FROM `address`
			  WHERE `emp_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetpreAddress($id){
			  $sql = "SELECT * FROM `address` WHERE `emp_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetEducation($id){
			  $sql = "SELECT * FROM `education`
			  WHERE `emp_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetEditEducation($eid){
			  $sql = "SELECT * FROM `education`
			  WHERE `id`='$eid'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetFamily($id){
			  $sql = "SELECT * FROM `em_familly`
			  WHERE `em_id`='$id'";
				$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
			}
			public function GetExperience($id){
			  $sql = "SELECT * FROM `emp_experience`
			  WHERE `emp_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetBankInfo($id){
			  $sql = "SELECT * FROM `bank_info`
			  WHERE `em_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetAllEmployee(){
			  $sql = "SELECT * FROM `employee`";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}

			public function desciplinaryfetch(){

		  $id = $this->session->userdata('user_login_id');
		  $basicinfo = $this->employee_model->GetBasic($id);
		  $region = $basicinfo->em_region;
		  $em_id = $basicinfo->em_id;

		  if ($this->session->userdata('user_type')=='RM') {
			   $sql = "SELECT `desciplinary`.*,
			  `employee`.`em_id`,`first_name`,`last_name`,`em_code`
			  FROM `desciplinary`
			  LEFT JOIN `employee` ON `desciplinary`.`em_id`=`employee`.`em_id`
			  WHERE  `employee`.`em_region` = '$region'";

			}elseif ($this->session->userdata('user_type')=='HOD') {

			  $sql = "SELECT `desciplinary`.*,
			  `employee`.`em_id`,`first_name`,`last_name`,`em_code`
			  FROM `desciplinary`
			  LEFT JOIN `employee` ON `desciplinary`.`em_id`=`employee`.`em_id`
			  WHERE  `employee`.`em_region` = '$region' AND `employee`.`dep_id` = '$basicinfo->dep_id' ";
		  }
			else{
			  $sql = "SELECT `desciplinary`.*,
			  `employee`.`em_id`,`first_name`,`last_name`,`em_code`
			  FROM `desciplinary`
			  LEFT JOIN `employee` ON `desciplinary`.`em_id`=`employee`.`em_id`";
			}
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
		
			
			public function getAllRequest(){

			  $sql = "SELECT `imprest_subsistence`.*,
			  `employee`.`em_id`,`first_name`,`last_name`,`em_code`,`dep_id`,`des_id`,
			  `details_of_safari`.*,
			  `details_of_imprest`.*,
			  `outside_tanzania`.*,
			  `receivable`.*
			  FROM `imprest_subsistence`
			  LEFT JOIN `employee` ON `imprest_subsistence`.`em_id`=`employee`.`em_id`
			  LEFT JOIN `details_of_safari` ON `imprest_subsistence`.`id_safari`=`details_of_safari`.`id`
			  LEFT JOIN `details_of_imprest` ON `imprest_subsistence`.`id_imprest`=`details_of_imprest`.`id`
			  LEFT JOIN `outside_tanzania` ON `imprest_subsistence`.`id_outside_tanzania`=`outside_tanzania`.`id`
			  LEFT JOIN `receivable` ON `imprest_subsistence`.`id_is`=`receivable`.`imprest_id`";

				 $query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function getImprestToBank($status){

			  $sql = "SELECT `imprest_subsistence`.*,
			  `employee`.`em_id`,`first_name`,`middle_name`,`last_name`,`em_code`,`dep_id`,`des_id`,
			  `details_of_safari`.*,
			  `details_of_imprest`.*,
			  `outside_tanzania`.*,
			  `receivable`.*,
			  `bank_info`.*
			  FROM `imprest_subsistence`
			  LEFT JOIN `employee` ON `imprest_subsistence`.`em_id`=`employee`.`em_id`
			  LEFT JOIN `details_of_safari` ON `imprest_subsistence`.`id_safari`=`details_of_safari`.`id`
			  LEFT JOIN `details_of_imprest` ON `imprest_subsistence`.`id_imprest`=`details_of_imprest`.`id`
			  LEFT JOIN `outside_tanzania` ON `imprest_subsistence`.`id_outside_tanzania`=`outside_tanzania`.`id`
			  LEFT JOIN `receivable` ON `imprest_subsistence`.`id_is`=`receivable`.`imprest_id`
			  LEFT JOIN `bank_info` ON `bank_info`.`em_id` = `imprest_subsistence`.`em_id`
			  WHERE `receivable`.`head_status` = '$status'";

				 $query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetLeaveiNfo($id,$year){
			  $sql = "SELECT `assign_leave`.*,
			  `leave_types`.`name`
			  FROM `assign_leave`
			  LEFT JOIN `leave_types` ON `assign_leave`.`type_id`=`leave_types`.`type_id`
			  WHERE `assign_leave`.`emp_id`='$id' AND `dateyear`='$year'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			
			public function GetReliefValue($id){
			  $sql = "SELECT * FROM `taxt_relief`
			  WHERE `em_id`='$id'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetAssuaranceValue($sid){
			  $sql = "SELECT * FROM `assuarance_infor`
			  WHERE `salary_id`='$sid'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetSundryValue($sid){
			  $month = date('m');
			  $year  = date('Y');
// 			  SELECT * FROM `non_tax_addition` WHERE `salary_id` = '1427' 
// AND ((MONTH(`end_month`) >= '$month' AND YEAR(`end_month`) >= '$year') 
// OR ((MONTH(`end_month`) <= '$month' AND YEAR(`end_month`) > '$year')))
			  $sql = "SELECT * FROM `non_tax_addition` WHERE `salary_id` = '$sid'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetCommulativePending($sid,$id){
			  $sql = "SELECT * FROM `emp_non_percent_deduction_permonth`
			  WHERE `salary_id`='$sid' AND `em_id` = '$id' AND `month` = 'April'";
				$query=$this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			
			
			public function getSalaryId($emid){
			  $sql = "SELECT * FROM `emp_salary`
			  WHERE `emp_id`='$emid'";
				$query=$this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function Update($data,$id){
				$this->db->where('em_id', $id);
				$this->db->update('employee',$data);
			}
			public function update_Non_Tax_Addition($data,$addid){
				$this->db->where('add_id', $addid);
				$this->db->update('non_tax_addition',$data);
			}
			public function Update_Emp_Assuarance($data,$assId){
				$this->db->where('assur_id', $assId);
				$this->db->update('assuarance_infor',$data);
			}
			public function Update_Counters($csup,$cId){
				$db2 = $this->load->database('otherdb', TRUE);
				$db2->where('counter_id', $cId);
				$db2->update('counters',$csup);
			}
			public function Update_Counters1($ssup,$lcId){
				$db2 = $this->load->database('otherdb', TRUE);
				$db2->where('counter_id', $lcId);
				$db2->update('counters',$ssup);
			}
			public function Update_Counters_Services($sup,$csId){
				$db2 = $this->load->database('otherdb', TRUE);
				$db2->where('cs_id', $csId);
				$db2->update('counter_services',$sup);
			}
			public function Update_Counters_Services1($sup,$lcId){
				$db2 = $this->load->database('otherdb', TRUE);
				$db2->where('counter_id', $lcId);
				$db2->update('counters',$sup);
			}
			public function Update_Counters_LcId($csupl,$lcId){
				$db2 = $this->load->database('otherdb', TRUE);
				$db2->where('counter_id', $lcId);
				$db2->update('counters',$csupl);
			}
			public function Update_Status($data1,$id){
				$this->db->where('em_id', $id);
				$this->db->update('employee',$data1);
			}
			public function Update_Jobassign($update,$emid){
				$this->db->where('em_id', $emid);
				$this->db->update('employee',$update);
			}
			public function reset_password1($pfnumber,$data){
				$this->db->where('em_code', $pfnumber);
				$this->db->update('employee',$data);
			}
			public function UpdateRetired($id){
			$sql= "UPDATE `employee` SET `status`='RETIRED' WHERE `id` = $id ";
			$query=$this->db->query($sql);
			}
			public function Update_Education($id,$data){
				$this->db->where('id', $id);
				$this->db->update('education',$data);
			}
			public function Update_BankInfo($id,$data){
				$this->db->where('id', $id);
				$this->db->update('bank_info',$data);
			}

			

			public function Update_ImprestSubsistence($imprest_id,$data1){
			$this->db->where('id_is', $imprest_id);
			$this->db->update('imprest_subsistence',$data1);
			}
			public function Update_Receivable($id_receive,$data){
			$this->db->where('id_receive', $id_receive);
			$this->db->update('receivable',$data);
			}
			public function UpdateParmanent_Address($id,$data){
				$this->db->where('id', $id);
				$this->db->update('address',$data);
			}
			public function Reset_Password($id,$data){
				$this->db->where('em_id', $id);
				$this->db->update('employee',$data);
			}
			public function Update_Experience($id,$data){
				$this->db->where('id', $id);
				$this->db->update('emp_experience',$data);
			}
			public function Update_Salary($sid,$data){
				$this->db->where('id', $sid);
				$this->db->update('emp_salary',$data);
			}
			public function Update_Deduction($did,$data){
				$this->db->where('de_id', $did);
				$this->db->update('deduction',$data);
			}
		public function Update_Family($id,$data){
			$this->db->where('family_Id', $id);
			$this->db->update('em_familly',$data);
		}
			public function Update_Addition($aid,$data){
				$this->db->where('addi_id', $aid);
				$this->db->update('addition',$data);
			}
			public function Update_Desciplinary($id,$data){
				$this->db->where('id', $id);
				$this->db->update('desciplinary',$data);
			}
			public function Update_Media($id,$data){
				$this->db->where('id', $id);
				$this->db->update('social_media',$data);
			}
			public function AddParmanent_Address($data){
				$this->db->insert('address',$data);
			}
			public function Add_education($data){
				$this->db->insert('education',$data);
			}
			public function saveReferee($data){
				$this->db->insert('referee',$data);
			}
			public function Add_Experience($data){
				$this->db->insert('emp_experience',$data);
			}
			public function save_servc_emp($data){
				$usertype = $this->session->userdata('user_type');

			    if ( $usertype== "SUPERVISOR") {
                  $this->db->insert('servc_emp',$data); 
			    } else {
			      $this->db->insert('servc_emp',$data);
			    }

			}
			public function Add_Desciplinary($data){
				$this->db->insert('desciplinary',$data);
			}
			public function Add_BankInfo($data){
				$this->db->insert('bank_info',$data);
			}
			public function GetEmployeeId($id){
				$sql = "SELECT `em_password` FROM `employee` WHERE `em_id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}

			public function getperson_BankInfo($id){
					$sql = "SELECT * FROM `bank_info` WHERE `id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}



			public function GetFileInfo($id){
				$sql = "SELECT * FROM `employee_file` WHERE `em_id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function GetSocialValue($id){
				$sql = "SELECT * FROM `social_media` WHERE `emp_id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetEduValue($id){
				$sql = "SELECT * FROM `education` WHERE `id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetExpValue($id){
				$sql = "SELECT * FROM `emp_experience` WHERE `id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function GetDesValue($id){
				$sql = "SELECT * FROM `desciplinary` WHERE `id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}
			public function get_referee_byEmId($id){
				$sql = "SELECT * FROM `referee` WHERE `emp_id`='$id'";
				$query = $this->db->query($sql);
				$result = $query->result();
				return $result;
			}
			public function depselect(){
			$query = $this->db->get('department');
			$result = $query->result();
			return $result;
			}
		  public function Add_Family($data){
			$this->db->insert('em_familly',$data);
		  }
			public function Add_Department($data){
			$this->db->insert('department',$data);
		  }

			public function Add_Designation($data){
			  $this->db->insert('designation',$data);
			}
			public function File_Upload($data){
			$this->db->insert('employee_file',$data);
		  }
			
		  
		  public function Add_Non_Tax_Addition($data){
			$this->db->insert('non_tax_addition',$data);
		  }
		  
		   public function Add_Emp_Percent($data){
			$this->db->insert('emp_percent_deduction',$data);
		  }
			public function Add_Addition($data1){
			$this->db->insert('addition',$data1);
		  }
			public function Add_Deduction($data2){
			$this->db->insert('deduction',$data2);
		  }
		  
			public function Add_Assign_Leave($data){
			$this->db->insert('assign_leave',$data);
		  }
			public function Insert_Media($data){
			$this->db->insert('social_media',$data);
		  }
		  public function Insert_Details_Of_Safari($data){
			$this->db->insert('details_of_safari',$data);
		  }
		  public function Insert_Details_Of_Interest($data){
			$this->db->insert('details_of_imprest',$data);
		  }
		  public function Insert_Outside_Tanzania($data){
			$this->db->insert('outside_tanzania',$data);
		  }
		  public function Insert_Imprest_Request_form($data){
				$this->db->insert('imprest_request_form',$data);
			}
		   public function Insert_Imprest($data){
			$this->db->insert('imprest_subsistence',$data);
		  }
		  public function Insert_Receivable($data){
			$this->db->insert('receivable',$data);
		  }
			public function desselect(){
			$query = $this->db->get('designation');
			$result = $query->result();
			return $result;
			}
			public function get_subrol_byEmId($id){
		 
          $basicinfo = $this->GetBasic($id);
          $sub_role = $basicinfo->em_sub_role;
         
          return $sub_role;
      }
		  public function DeletEmployee($em_id){
			  $this->db->delete('employee',array('id'=> $em_id));
		  }


		  	public function DeletEmployees($em_id,$data){
				$this->db->where('id', $em_id);
				$this->db->update('employee',$data);
			}




		  public function Delete_Othersdecuction($id){
			  $this->db->delete('others_deduction',array('others_id'=> $id));
		  }
		  
		  
		  
		  public function delete_Emp_Percent($dedid){
			  $this->db->delete('emp_percent_deduction',array('ded_id'=> $dedid));
		  }
		  
		  public function DeleteInfoBank($id){
			  $this->db->delete('bank_info',array('em_id'=> $id));
		  }
		  public function delete_experiences($id){
			  $this->db->delete('emp_experience',array('id'=> $id));
		  }
		  public function deletecummulative($id){
			  $this->db->delete('cummulative',array('salary_id'=> $id));
		  }
		  public function deletecummulativePercent($id){
			  $this->db->delete('cummulative_percent',array('salary_id'=> $id));
		  }
		  public function deleteNonPercent($id){
			  $this->db->delete('emp_non_percent_deduction',array('salary_id'=> $id));
		  }
		  public function deletePercent($id){
			  $this->db->delete('emp_percent_deduction',array('salary_id'=> $id));
		  }
		  public function deleteNonTax($id){
			  $this->db->delete('non_tax_addition',array('salary_id'=> $id));
		  }
		  
		  public function deleteOtherDeduction($id){
			  $this->db->delete('others_deduction',array('salary_id'=> $id));
		  }
		  public function deleteOtherDeductionMonth($emid){
			  $this->db->delete('others_deduction_permonth',array('emp_id'=> $emid));
		  }
		   public function deletepension_funds($id){
			  $this->db->delete('pension_funds',array('salary_id'=> $id));
		  }
		  public function deletepension_fund_contribution($id){
			  $this->db->delete('pension_fund_contribution',array('salary_id'=> $id));
		  }
		  public function deletepaysalary($emid){
			  $this->db->delete('pay_salary',array('em_id'=> $emid));
		  }
		  public function deleteempsalary($id){
			  $this->db->delete('emp_salary',array('id'=> $id));
		  }
		  public function delete_address($id){
			  $this->db->delete('address',array('id'=> $id));
		  }
		  public function deleteReferee($id){
			  $this->db->delete('referee',array('ref_id'=> $id));
		  }
		public function delete_person($id){
			$this->db->delete('em_familly',array('family_Id'=> $id));
		}
			public function DeletEdu($id){
			  $this->db->delete('education',array('id'=> $id));
		  }
			public function DeletEXP($id){
			  $this->db->delete('emp_experience',array('id'=> $id));
		  }
		  public function delete_servc_emp($emid){
			  $this->db->delete('servc_emp',array('emp_id'=> $emid));
		  }
			public function DeletDisiplinary($id){
			  $this->db->delete('desciplinary',array('id'=> $id));
		  }
		  public  function getExpenditure()
		  {
			  $id = $this->session->userdata('user_login_id');
			  $basicinfo = $this->employee_model->GetBasic($id);
			  $region = $basicinfo->em_region;
			  $dep_id = $basicinfo->dep_id;
				if ($this->session->userdata('user_type') == 'PMG' || $this->session->userdata('user_type') == 'GM')
				{
					$sql = "SELECT `imprest_request_form`.*,
			  `employee`.*,
			  `department`.*,
			  `designation`.*
			  FROM `imprest_request_form`
			  LEFT JOIN `employee` ON `employee`.`em_code`=`imprest_request_form`.`em_code`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`";
					$query=$this->db->query($sql);
					$result = $query->result();
					return $result;
				}else
				{
					$sql = "SELECT `imprest_request_form`.*,
			  `employee`.*,
			  `department`.*,
			  `designation`.*
			  FROM `imprest_request_form`
			  LEFT JOIN `employee` ON `employee`.`em_code`=`imprest_request_form`.`em_code`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  WHERE  `department`.`id`='$dep_id'";
					$query=$this->db->query($sql);
					$result = $query->result();
					return $result;
				}

		  }
		public  function getExpenditureById($expId)
		{
			$id = $this->session->userdata('user_login_id');
			$basicinfo = $this->employee_model->GetBasic($id);
			$region = $basicinfo->em_region;
			$dep_id = $basicinfo->dep_id;
			if ($this->session->userdata('user_type') == 'PMG' || $this->session->userdata('user_type') == 'GM') {

				$sql = "SELECT `imprest_request_form`.*,
			  `employee`.*,
			  `department`.*,
			  `designation`.*
			  FROM `imprest_request_form`
			  LEFT JOIN `employee` ON `employee`.`em_code`=`imprest_request_form`.`em_code`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  WHERE `imprest_request_form`.`exp_status`='NotApproved' OR `imprest_request_form`.`exp_status`='Approved'   AND `imprest_request_form`.`imp_id`='$expId' 
			  ORDER BY `imprest_request_form`.`imp_id` DESC";
			}
			else{

				$sql = "SELECT `imprest_request_form`.*,
			  `employee`.*,
			  `department`.*,
			  `designation`.*
			  FROM `imprest_request_form`
			  LEFT JOIN `employee` ON `employee`.`em_code`=`imprest_request_form`.`em_code`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  WHERE `imprest_request_form`.`exp_status`='NotApproved' OR `imprest_request_form`.`exp_status`='Approved'  AND `department`.`id`='$dep_id' AND `imprest_request_form`.`imp_id`='$expId' 
			  ORDER BY `imprest_request_form`.`imp_id` DESC";
			}

			$query = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}
		public  function getImprestRequestById($id)
		{
			$ids = $this->session->userdata('user_login_id');
			$basicinfo = $this->employee_model->GetBasic($id);
			$em_code = $basicinfo->em_code;
			$dep_id = $basicinfo->dep_id;

			$sql = "SELECT `imprest_request_form`.*,
			  `employee`.*,
			  `department`.*,
			  `designation`.*
			  FROM `imprest_request_form`
			  LEFT JOIN `employee` ON `employee`.`em_code`=`imprest_request_form`.`em_code`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  WHERE `imprest_request_form`.`em_code`='$em_code'
			  ORDER BY `imprest_request_form`.`imp_id` DESC";

			$query=$this->db->query($sql);
			$result = $query->result();
			return $result;
		}
		public  function getExpenditureCofirmById($expId)
		{
			$id = $this->session->userdata('user_login_id');
			$basicinfo = $this->employee_model->GetBasic($id);
			$region = $basicinfo->em_region;
			$dep_id = $basicinfo->dep_id;

			$sql = "SELECT `imprest_request_form`.*,
			  `employee`.*,
			  `department`.*,
			  `designation`.*
			  FROM `imprest_request_form`
			  LEFT JOIN `employee` ON `employee`.`em_code`=`imprest_request_form`.`em_code`
			  LEFT JOIN `department` ON `employee`.`dep_id`=`department`.`id`
			  LEFT JOIN `designation` ON `employee`.`des_id`=`designation`.`id`
			  WHERE `imprest_request_form`.`exp_status`='Approved' OR `imprest_request_form`.`exp_status`='NotApproved' AND `imprest_request_form`.`imp_id`='$expId' 
			  ";

			$query = $this->db->query($sql);
			$result = $query->row();
			return $result;
		}

		public function Update_Imprest_Request_form($data,$expId)
		{
			$this->db->where('imp_id', $expId);
			$this->db->update('imprest_request_form',$data);
		}
		public function Update_Details_Of_Safari($data,$safari_id)
		{
			$this->db->where('id', $safari_id);
			$this->db->update('details_of_safari',$data);
		}
		public function Update_Details_Of_Interest($data,$id_imprest)
		{
			$this->db->where('id', $id_imprest);
			$this->db->update('details_of_imprest',$data);
		}
		public function Update_Imprest($data,$imprest_id)
		{
			$this->db->where('id_is', $imprest_id);
			$this->db->update('imprest_subsistence',$data);
		}
		public function get_services_byEmId($id){
		  
          $sql = "SELECT `servc_emp`.*, `emp_services`.* 
          FROM `servc_emp` 
          LEFT JOIN `emp_services` ON `emp_services`.`serv_id`=`servc_emp`.`servc_id`
           WHERE `servc_emp`.`emp_id` = '$id'";
          $query  = $this->db->query($sql);
          $result = $query->result();
          return $result;
      }
	 public function get_services_byEmId12($id){
		  
		  $db2 = $this->load->database('otherdb', TRUE);
		  $tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');

          $sql = "SELECT `counter_services`.*, `emp_services`.* 
          FROM `counter_services` 
          LEFT JOIN `emp_services` ON `emp_services`.`serv_id`=`counter_services`.`serv_id`
           WHERE `counter_services`.`assign_to` = '$id' AND date(`counter_services`.`registered_date`) = '$date' AND `counter_services`.`assign_status` = 'Assign'";
          $query  = $db2->query($sql);
          $result = $query->result();
          return $result;
      }

      public function get_services_byEmId1($id){
		  
		  $db2 = $this->load->database('otherdb', TRUE);
		  $tz = 'Africa/Nairobi';
			$tz_obj = new DateTimeZone($tz);
			$today = new DateTime("now", $tz_obj);
			$date = $today->format('Y-m-d');

          $sql = "SELECT `counter_services`.*, `emp_services`.* 
          FROM `counter_services` 
          LEFT JOIN `emp_services` ON `emp_services`.`serv_id`=`counter_services`.`serv_id`
           WHERE `counter_services`.`assign_to` = '$id'  AND `counter_services`.`assign_status` = 'Assign'";
          $query  = $db2->query($sql);
          $result = $query->result();
          return $result;
      }

      public function check_services($id){
				$sql = "SELECT * FROM `servc_emp` WHERE `servc_id` = '$id'";
				$query = $this->db->query($sql);
				$result = $query->row();
				return $result;
			}

	// public function delete_servc_emp($servId,$id){
	// 		$this->db->delete('servc_emp',array('servc_id'=> $servId,'emp_id'=>$id));
	// 	}		
	}
?>
