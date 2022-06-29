<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('login_model');
        $this->load->model('payroll_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('organization_model');
		$this->load->model('Box_Application_model');
        //$this->load->library('pagination');
  
    }

   


    public function EndShift()
    {
        if ($this->session->userdata('user_login_access') != 1){

             $checkItemStatus = $this->unregistered_model->check_item_status($ids);
              $ids = $this->session->userdata('user_login_id');

             if (!empty($checkItemStatus)) {

                        $data['errormessage'] = "Shift Not End Propery Clear Item Either Payment Or Send To Backoffice";

                    }else{

                        $getCI =  $this->unregistered_model->check_job_assign($ids);
                        $task_id = $getCI->task_id;
                        $db2->set('status', 'OFF');//if 2 columns
                        $db2->where('task_id', $task_id);
                        $db2->update('taskjobassign');

                        $counter1 = $getCI->counter_id;
                        $csup1 = array();
                        $csup1 = array('c_status'=>'NotAssign');
                        $this->job_assign_model->Update_Counterss($csup1,$counter1);

                        //$data['message'] = "Successfull Shift End";

                        redirect('dashboard/dashboard');
                    }

        }
           
    }
    
	public function index()
	{
		if ($this->session->userdata('user_login_access') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('user_login_access') == 1)
          $data= array();
        redirect('employee/Employees');
	}
    public function Employees(){
        if($this->session->userdata('user_login_access') != False && $this->session->userdata('user_type') != 'DERIVERER' ) {
        

            $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/employees',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Retired_Employee(){
        if($this->session->userdata('user_login_access') != False) {

        	$data['employee'] = $this->employee_model->emselectRetired();
        $this->load->view('backend/employees',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function Agency_Employee(){
        if($this->session->userdata('user_login_access') != False) {

            $data['employee'] = $this->employee_model->emselectAgent();
        $this->load->view('backend/employees',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }        
    }
    public function GetBranch(){

      if ($this->input->post('region_id') != '') {
          
          echo $this->employee_model->GetBranchById($this->input->post('region_id'));
      }

}

public function GetBoxBranch(){

    if ($this->input->post('region_id') != '') {
        
        echo $this->employee_model->GetBoxBranchById($this->input->post('region_id'));
    }

}
public function GetBranch1()
{
      if ($this->input->post('region_id') != '') {

         $reg = $this->input->post('region_id');
         $acc =  $this->input->post('accno');
          //print_r($this->employee_model->GetBranchById1($reg,$acc));
          echo $this->employee_model->GetBranchById1($reg,$acc);
      }
}
   public function GetDistrict()
   {
      $region_id = $this->input->post('region_id',TRUE);  
      //run the query for the cities we specified earlier  
      echo $this->employee_model->GetDistrictById($region_id);
    }
    public function Add_employee(){
        if($this->session->userdata('user_login_access') != False) { 
            $data['region'] = $this->employee_model->regselect();
        $this->load->view('backend/add-employee',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }

	public function Save(){ 
    if($this->session->userdata('user_login_access') != False) {     
    $eid = $this->input->post('eid');    
    $id = $this->input->post('emid');    
	$fname = $this->input->post('fname');
    $mname = $this->input->post('mname');
	$lname = $this->input->post('lname');
    $emrand1 = substr($lname,0,3).rand(1000,2000); 
    $emrand = str_replace("'", '', $emrand1);
	$dept = $this->input->post('dept');
	$deg = $this->input->post('deg');
	$role = $this->input->post('role');
    $sub_role = $this->input->post('em_sub_role');
    $sect_role = $this->input->post('em_section_role');
	$gender = $this->input->post('gender');
    $marital_status = $this->input->post('marital_status');
	$contact = $this->input->post('contact');
	$dob =$this->input->post('dob');	
	$joindate = $this->input->post('joindate');	
  
    $day = date('d', strtotime($dob)); $month = date('m', strtotime($dob)); $year = date('Y', strtotime($dob));

    $leavedate =($year + 60).'-'.$month.'-'.$day;
	$username = $this->input->post('username');	
	$email = $this->input->post('email');
    $region = $this->input->post('region');	
    $branch = $this->input->post('branch');
	$password = sha1($contact);	
	$confirm = $this->input->post('confirm');	
	$nid = $this->input->post('nid');		
	$blood = $this->input->post('blood');		
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        // Validating Name Field
        $this->form_validation->set_rules('contact', 'contact', 'trim|required|min_length[10]|max_length[15]|xss_clean');
        /*validating email field*/
        $this->form_validation->set_rules('email', 'Email','trim|required|min_length[7]|max_length[100]|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender','required');
        $this->form_validation->set_rules('marital_status', 'Marital Status','required');
        $this->form_validation->set_rules('region', 'Region','required');
         $this->form_validation->set_rules('dept', 'Department','required');
          $this->form_validation->set_rules('deg', 'Designation','required');
        $this->form_validation->set_rules('eid', 'Employee PF Number','required');
        //$this->form_validation->set_rules('contact', 'Mobile Number', 'required|regex_match[/^[0-9]{13}$/]'); //{10} for 10 digits number
        //$this->form_validation->set_rules('email', 'Email', 'required|regex_match[/^[0-9]{12}$/]');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			} else {
                if($this->employee_model->Does_PF_exists($eid)){
                $this->session->set_flashdata('formdata','PF number is already Exist');
                echo "PF number is already Exist";
            }elseif($this->employee_model->Does_email_exists($email) && $password != $confirm){
                $this->session->set_flashdata('formdata','Email is already Exist or Check your password');
                echo "Email is already Exist or Check your password";
            }else {
                
            if($_FILES['image_url']['name']){

            $file_name = $_FILES['image_url']['name'];
			$fileSize = $_FILES["image_url"]["size"]/1024;
			$fileType = $_FILES["image_url"]["type"];
			$new_file_name='';
            $new_file_name .= $emrand;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "800",
                'max_width' => "800"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('image_url')) {
                echo $this->upload->display_errors();
			}
   
			else {
                $path = $this->upload->data();
                $img_url = $path['file_name'];
                $data = array();
                $data = array(
                    'em_id' => $emrand,
                    'em_code' => $eid,
                    'des_id' => $deg,
                    'dep_id' => $dept,
                    'first_name' => $fname,
                    'middle_name' => $mname,
                    'last_name' => $lname,
					'em_email' => $email,
					'em_password'=>$password,
					'em_role'=>'EMPLOYEE',
					'em_gender'=>$gender,
                    'marital_status'=>$marital_status,
                    'status'=>'ACTIVE',
                    'em_phone'=>$contact,
                    'em_birthday'=>$dob,
                    'em_joining_date'=>$joindate,
                    'em_contact_end'=>$leavedate,
                    'em_image'=>$img_url,
                    'em_region' => $region,
                    'em_branch' => $branch,
                    'em_nid'=>$nid,
                    'em_blood_group'=> $blood
                );
                if($id){
            $success = $this->employee_model->Update($data,$id); 
            #$this->session->set_flashdata('feedback','Successfully Updated');
            echo "Successfully Updated";
                } else {
            $success = $this->employee_model->Add($data);
            #$this->confirm_mail_send($email,$pass_hash);        
            #$this->session->set_flashdata('feedback','Successfully Created');
            echo "Successfully Added";                     
                }
			}
        } else {
                $data = array();
                $data = array(
                    'em_id' => $emrand,
                    'em_code' => $eid,
                    'des_id' => $deg,
                    'dep_id' => $dept,
                    'first_name' => $fname,
                    'middle_name' => $mname,
                    'last_name' => $lname,
					'em_email' => $email,
					'em_password'=>$password,
					'em_role'=>'EMPLOYEE',
					'em_gender'=>$gender,
                    'marital_status'=>$marital_status,
                    'status'=>'ACTIVE',
                    'em_phone'=>$contact,
                    'em_birthday'=>$dob,
                    'em_joining_date'=>$joindate,
                    'em_contact_end'=>$leavedate,
                    //'em_address'=>$address,
                    'em_region' => $region,
                    'em_branch' => $branch,
                    'em_nid'=>$nid,
                    'em_blood_group'=> $blood
                );
                if($id){
            $success = $this->employee_model->Update($data,$id); 
            #$this->session->set_flashdata('feedback','Successfully Updated');
            echo "Successfully Updated";        
            #redirect('employee/Add_employee'); 
                } else {
            $success = $this->employee_model->Add($data);
            #$this->confirm_mail_send($email,$pass_hash);        
            echo "Successfully Added";
            #redirect('employee/Add_employee');                     
                }
            }
            }
        }
        }
    else{
		redirect(base_url() , 'refresh');
	       }        
		}
	public function Update(){

    if($this->session->userdata('user_login_access') != False) {   

    $musedept = $this->input->post('musedept');
    $serveid = $this->input->post('serv_id');
    $serv_name = $this->input->post('serv_name'); 
    $eid = $this->input->post('eid');    
    $id = $this->input->post('emid');    
	$fname = $this->input->post('fname');
    $mname = $this->input->post('mname');
	$lname = $this->input->post('lname');
	$dept = $this->input->post('dept');
	$deg = $this->input->post('deg');
	$role = $this->input->post('role');
    $sub_role = $this->input->post('em_sub_role');
    $sect_role = $this->input->post('em_section_role');
	$gender = $this->input->post('gender');
    $marital_status=$this->input->post('marital_status');
	$contact = $this->input->post('contact');
	$dob = $this->input->post('dob');	
    $day = date('d', strtotime($dob)); $month = date('m', strtotime($dob)); $year = date('Y', strtotime($dob));

    $leavedate =($year + 60).'-'.$month.'-'.$day;
	$joindate = $this->input->post('joindate');	
	//$leavedate = $this->input->post('leavedate');	
	$username = $this->input->post('username');	
	$email = $this->input->post('email');	
	$password = $this->input->post('password');	
	$confirm = $this->input->post('confirm');	
	$address = $this->input->post('address');		
	$nid = $this->input->post('nid');		
	$status = $this->input->post('status');	
    $region = $this->input->post('region');	
    $branch = $this->input->post('branch');
	$blood = $this->input->post('blood');	
    $section = $this->input->post('section');
    $subuser_type = $this->input->post('subuser_type');


        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('contact', 'contact', 'trim|required|min_length[10]|max_length[15]|xss_clean');

        $this->form_validation->set_rules('email', 'Email','trim|required|min_length[7]|max_length[100]|xss_clean');
        
        $usertype = $this->session->userdata('user_type');
        if($this->session->userdata('user_type') == "ADMIN"){

           // $get = $this->organization_model->get_supervisorType($usertype);
            $this->employee_model->delete_servc_emp($id);

                for ($i=0; $i <@sizeof($serveid) ; $i++) { 
                
                     $data = array();
                     $data = array('servc_id'=>$serveid[$i],'emp_id'=>$id);
                     $success = $this->employee_model->save_servc_emp($data);
                }
        }else{
                 
            }

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			#redirect("employee/view?I=" .base64_encode($eid));
			} else {
            if($_FILES['image_url']['name']){
            $file_name = $_FILES['image_url']['name'];
			$fileSize = $_FILES["image_url"]["size"]/1024;
			$fileType = $_FILES["image_url"]["type"];
			$new_file_name='';
            $new_file_name .= $id;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "600",
                'max_width' => "600"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('image_url')) {
                echo $this->upload->display_errors();
                #redirect("employee/view?I=" .base64_encode($eid));
			}
   
			else {
            //$employee = $this->employee_model->GetBasic($id);
            //$checkimage = "./assets/images/users/$employee->em_image";
               // if(file_exists($checkimage)){
            	//unlink($checkimage);
				//}
                $path = $this->upload->data();
                $img_url = $path['file_name'];
                $data = array();
                $data = array(
                    'em_code' => $eid,
                    'des_id' => $deg,
                    'dep_id' => $dept,
                    'first_name' => $fname,
                    'middle_name' => $mname,
                    'last_name' => $lname,
					'em_email' => $email,
					'em_role'=>$role,
                    'em_sub_role'=>$sub_role,
                    'em_section_role'=>$sect_role,
					'em_gender'=>$gender,
                    'marital_status'=>$marital_status,
                    'status'=>'ACTIVE',
                    'em_phone'=>$contact,
                    'em_birthday'=>$dob,
                    'em_joining_date'=>$joindate,
                    'em_contact_end'=>$leavedate,
                    'em_image'=>$img_url,
                    'em_address'=>$address,
                    'em_nid'=> $nid,
                    'em_region'=> $region,
                    'em_branch'=> $branch,
                    'em_blood_group'=> $blood,
                    'job_assign'=>$serv_name,
                    'muse_dept_id'=>$musedept,
                    'assign_status'=>'Yes',
                    'sectionid'=>$section,
                    'subuser_type'=>$subuser_type
                );
                if($id){

            $success = $this->employee_model->Update($data,$id);
            $this->session->set_flashdata('feedback','Successfully Updated');
            echo "Successfully Updated ";

                }
			}
        } else {

                $data = array();
                $data = array(
                    'em_code' => $eid,
                    'des_id' => $deg,
                    'dep_id' => $dept,
                    'first_name' => $fname,
                    'middle_name' => $mname,
                    'last_name' => $lname,
					'em_email' => $email,
					'em_role'=>$role,
                    'em_sub_role'=>$sub_role,
                    'em_section_role'=>$sect_role,
					'em_gender'=>$gender,
                    'marital_status'=>$marital_status,
                    'status'=>'ACTIVE',
                    'em_phone'=>$contact,
                    'em_birthday'=>$dob,
                    'em_joining_date'=>$joindate,
                    'em_contact_end'=>$leavedate,
                    'em_address'=>$address,
                    'em_nid'=>$nid,
                    'em_region'=>$region,
                    'em_branch'=>$branch,
                    'em_blood_group'=> $blood,
                    'job_assign'=>$serv_name,
                    'muse_dept_id'=>$musedept,
                    'assign_status'=>'Yes',
                    'sectionid'=>$section,
                    'subuser_type'=>$subuser_type
                );

                if($id){
            $success = $this->employee_model->Update($data,$id); 
            $this->session->set_flashdata('feedback','Successfully Updated');
            echo "Successfully Updated";
                }
            }
        }
        }
    else{
		redirect(base_url() , 'refresh');
	       }        
		}




    public function view()
    {
        if($this->session->userdata('user_login_access') != False)
        {
            $id = base64_decode($this->input->get('I'));
            $emcode = base64_decode($this->input->get('emcode'));
            $data['basic'] = $this->employee_model->GetBasic($id);

        if ($data['basic']->sectionid)
        {
            $data['sectiondata'] = $this->employee_model->getDepartmentSections($departId='',$data['basic']->sectionid);
            $data['sectiondata'] = $data['sectiondata'][0];
        }

        // $data['permanent'] = $this->employee_model->GetperAddress($id);
        $data['present'] = $this->employee_model->GetpreAddress($id);
        $data['education'] = $this->employee_model->GetEducation($id);
        $data['family'] = $this->employee_model->GetFamily($id);
        $data['experience'] = $this->employee_model->GetExperience($id);
        $data['bankinfo'] = $this->employee_model->GetBankInfo($id);
        $data['fileinfo'] = $this->employee_model->GetFileInfo($id);
        $data['typevalue'] = $this->payroll_model->GetsalaryType();
        $data['leavetypes'] = $this->leave_model->GetleavetypeInfo();    
        $data['salaryvalue'] = $this->payroll_model->GetsalaryValue($id);
        $data['socialmedia'] = $this->employee_model->GetSocialValue($id);
        $data['service']=$this->organization_model->get_services();
        $data['sup_service']=$this->organization_model->get_services_super();
        
        $data['service2'] = $this->employee_model->get_services_byEmId($id); 
        $data['referee'] = $this->employee_model->get_referee_byEmId($id);
        $data['subrol'] = $this->employee_model->get_subrol_byEmId($id);

        $this->load->view('backend/employee_view',$data);

        }
    else{
		redirect(base_url() , 'refresh');
	}         
    }

    public function getDepartmentSections(){

        if($this->session->userdata('user_login_access') != False) {
            $departId = $this->input->post('departId');

            if ($departId) {
                
                $list = $this->employee_model->getDepartmentSections($departId); 

                if ($list) {
                    $response['status'] = 'Success';
                    $response['msg'] = $list;
                }else{
                    $response['status'] = 'Error';
                    $response['msg'] = 'No section found';
                }
            }

            print_r(json_encode($response));

        }else{
            redirect(base_url());
        }

    }

    public function getEmployeeBySection(){

        if($this->session->userdata('user_login_access') != False) {
            $sectionid = $this->input->post('sectionid');

            if ($sectionid) {
                
                $list = $this->employee_model->getEmployeeBySection($sectionid); 

                if ($list) {
                    $response['status'] = 'Success';
                    $response['msg'] = $list;
                }else{
                    $response['status'] = 'Error';
                    $response['msg'] = 'No section found';
                }
            }

            print_r(json_encode($response));

        }else{
            redirect(base_url());
        }

    }
    
    public function Parmanent_Address(){
        if($this->session->userdata('user_login_access') != False) {
        $type = $this->input->post('partype');
        $em_id = $this->input->post('emid');
        $paraddress = $this->input->post('paraddress');
        $parcity = $this->input->post('parcity');
        $parcountry = $this->input->post('parcountry');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('paraddress', 'address', 'trim|required|min_length[5]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			#redirect("employee/view?I=" .base64_encode($em_id));
			} else {
            $data = array();
                $data = array(
                    'emp_id' => $em_id,
                    'city' => $parcity,
                    'country' => $parcountry,
                    'address' => $paraddress,
                    'type' => $type
                );
            if(!empty($id)){
                $success = $this->employee_model->UpdateParmanent_Address($id,$data);
                $this->session->set_flashdata('feedback','Successfully Updated');
                echo "Successfully Updated";                
            } else {
                $success = $this->employee_model->AddParmanent_Address($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Added";
            }
                       
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}             
    }
    public function Present_Address(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $presaddress = $this->input->post('presaddress');
        $prescity = $this->input->post('prescity');
        $prescountry = $this->input->post('prescountry');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('presaddress', 'address', 'trim|required|min_length[5]|max_length[100]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			#redirect("employee/view?I=" .base64_encode($em_id));
			} else {
            $data = array();
                $data = array(
                    'emp_id' => $em_id,
                    'city' => $prescity,
                    'country' => $prescountry,
                    'address' => $presaddress,
                    'type' => 'Present'
                );
            if(empty($id)){
                $success = $this->employee_model->AddParmanent_Address($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Updated";
            } else {
                $success = $this->employee_model->UpdateParmanent_Address($id,$data);
                $this->session->set_flashdata('feedback','Successfully Updated');
                echo "Successfully Added";
            }
                       
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Add_Education(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $yearFrom = $this->input->post('yearFrom');
        $yearTo = $this->input->post('yearTo');
        $schoolname = $this->input->post('schoolname');
        $certification = $this->input->post('certification');
       
            $data = array();
                $data = array(
                    'emp_id' => $em_id,
                    'yearFrom' => $yearFrom,
                    'yearTo' => $yearTo,
                    'schoolname' => $schoolname,
                    'certification' => $certification
                );
            if(empty($id)){
                $success = $this->employee_model->Add_education($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Added";
            } else {
                $success = $this->employee_model->Update_Education($id,$data);
                #$this->session->set_flashdata('feedback','Successfully Updated');
                echo "Successfully Updated";
            }
              
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Save_Social(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $facebook = $this->input->post('facebook');
        $twitter = $this->input->post('twitter');
        $google = $this->input->post('google');
        $skype = $this->input->post('skype');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('facebook', 'company_name', 'trim|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			} else {
            $data = array();
                $data = array(
                    'emp_id' => $em_id,
                    'facebook' => $facebook,
                    'twitter' => $twitter,
                    'google_plus' => $google,
                    'skype_id' => $skype
                );
            if(empty($id)){
                $success = $this->employee_model->Insert_Media($data);
                echo "Successfully Added";
            } else {
                $success = $this->employee_model->Update_Media($id,$data);
                echo "Successfully Updated";
            }
                       
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Add_Experience(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $company = $this->input->post('company_name');
        $position = $this->input->post('position_name');
        $address = $this->input->post('address');
        $start = $this->input->post('work_duration');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('company_name', 'company_name', 'trim|required|min_length[5]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('position_name', 'position_name', 'trim|required|min_length[5]|max_length[250]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			#redirect("employee/view?I=" .base64_encode($em_id));
			} else {
            $data = array();
                $data = array(
                    'emp_id' => $em_id,
                    'exp_company' => $company,
                    'exp_com_position' => $position,
                    'exp_com_address' => $address,
                    'exp_workduration' => $start
                );
            if(empty($id)){
                $success = $this->employee_model->Add_Experience($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Updated";
            } else {
                $success = $this->employee_model->Update_Experience($id,$data);
                #$this->session->set_flashdata('feedback','Successfully Updated');
                echo "Successfully Updated";
            }
                       
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
	public function Discharge(){
        if($this->session->userdata('user_login_access') != False) {

        	$data['employee'] = $this->employee_model->emselectDischarge();
			$data['ask'] = 'Discharge';
        $this->load->view('backend/employees',$data);
        }

    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function add_Desciplinary(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $emid = $this->input->post('emid');
        $status = $this->input->post('status');
        $title = $this->input->post('title');
        $details = $this->input->post('details');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('title', 'title', 'trim|required|min_length[5]|max_length[150]|xss_clean');
        $this->form_validation->set_rules('details', 'details', 'trim|xss_clean');
		
		$getinfo = $this->employee_model->getInfo($emid);
		$em_id = $getinfo->em_id;

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			#redirect('Disciplinary');
			} else {
            $data = array();
                $data = array(
                    'em_id' => $em_id,
                    'action' => $status,
                    'title' => $title,
                    'description' => $details
                );
            if(empty($id)){
                $success = $this->employee_model->Add_Desciplinary($data);
                $this->session->set_flashdata('feedback','Successfully Added');
				$id = $em_id;
				$data1 = array();
				$data1 = array('status'=>$status);
				$this->employee_model->Update_Status($data1,$id);
                #redirect('employee/Disciplinary');
                echo "Successfully Added";
            } else {
                $success = $this->employee_model->Update_Desciplinary($id,$data);
                #$this->session->set_flashdata('feedback','Successfully Updated');
                #redirect("employee/view?I=" .base64_encode($em_id));
                echo "Successfully Updated";
            }
                       
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Add_bank_info(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('id');
        $em_id = $this->input->post('emid');
        $holder = $this->input->post('holder_name');
        $bank = $this->input->post('bank_name');
        $branch = $this->input->post('branch_name');
        $number = $this->input->post('account_number');
        $bank_code = $this->input->post('bank_code');
        $account = $this->input->post('account_type');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('holder_name', 'holder name', 'trim|required|min_length[5]|max_length[120]|xss_clean');
        $this->form_validation->set_rules('account_number', 'account name', 'trim|required|min_length[5]|max_length[120]|xss_clean');
        $this->form_validation->set_rules('branch_name', 'branch name', 'trim|required|min_length[5]|max_length[120]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			redirect("employee/view?I=" .base64_encode($em_id));
			} else {
            $data = array();
                $data = array(
                    'em_id' => $em_id,
                    'holder_name' => $holder,
                    'bank_name' => $bank,
                    'branch_name' => $branch,
                    'account_number' => $number,
                    'account_type' => $account,
                    'bank_code'=>$bank_code
                );
            if(empty($id)){
                $success = $this->employee_model->Add_BankInfo($data);
                #$this->session->set_flashdata('feedback','Successfully Added');
                #redirect("employee/view?I=" .base64_encode($em_id));
                echo "Successfully Added";
            } else {
                $success = $this->employee_model->Update_BankInfo($id,$data);
                #$this->session->set_flashdata('feedback','Successfully Updated');
                #redirect("employee/view?I=" .base64_encode($em_id));
                echo "Successfully Updated";
            }
                       
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Reset_Password_Hr(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('emid');
        $onep = $this->input->post('new1');
        $twop = $this->input->post('new2');
            if($onep == $twop){
                $data = array();

                 $modified_password = date("Y-m-d");
                //Password expires
                 $threeMOth = date('Y-m-d',strtotime('3 month'));


                $data = array(
                    'em_password'=> sha1($onep),
                    'last_modified_password'=> $modified_password,
                    'password_expires'=> $threeMOth
                );

        $success = $this->employee_model->Reset_Password($id,$data);
        #$this->session->set_flashdata('feedback','Successfully Updated');
        #redirect("employee/view?I=" .base64_encode($id));
                echo "Successfully Updated";
            } else {
        $this->session->set_flashdata('feedback','Please enter valid password');
        #redirect("employee/view?I=" .base64_encode($id)); 
                echo "Please enter valid password";
            }

        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Reset_Password(){
        if($this->session->userdata('user_login_access') != False) {
        $id = $this->input->post('emid');
        $oldp = sha1($this->input->post('old'));
        $onep = $this->input->post('new1');
        $twop = $this->input->post('new2');
        $pass = $this->employee_model->GetEmployeeId($id);
        if($pass->em_password == $oldp){
            if($onep == $twop){
                $data = array();

                 $modified_password = date("Y-m-d");
                //Password expires
                 $threeMOth = date('Y-m-d',strtotime('3 month'));

                $data = array(
                    'em_password'=> sha1($onep),
                    'last_modified_password'=> $modified_password,
                    'password_expires'=> $threeMOth
                );

        $success = $this->employee_model->Reset_Password($id,$data);
        $this->session->set_flashdata('feedback','Successfully Updated');
        #redirect("employee/view?I=" .base64_encode($id));
                echo "Successfully Updated";
            } else {
        $this->session->set_flashdata('feedback','Please enter valid password');
        #redirect("employee/view?I=" .base64_encode($id));
                echo "Please enter valid password";
            }
        } else {
            $this->session->set_flashdata('feedback','Please enter valid password');
            #redirect("employee/view?I=" .base64_encode($id));
            echo "Please enter valid password";
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Department(){
        if($this->session->userdata('user_login_access') != False) {
        $data['department'] = $this->employee_model->depselect();
        $this->load->view('backend/department',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Save_dep(){
        if($this->session->userdata('user_login_access') != False) {
       $dep = $this->input->post('department');
       $this->load->library('form_validation');
       $this->form_validation->set_error_delimiters();
       $this->form_validation->set_rules('department','department','trim|required|xss_clean');

       if ($this->form_validation->run() == FALSE) {
           echo validation_errors();
           redirect('employee/Department');
       }else{
        $data = array();
        $data = array('dep_name' => $dep);
        $success = $this->employee_model->Add_Department($data);
        #$this->session->set_flashdata('feedback','Successfully Added');
        #redirect('employee/Department');
       }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function Designation(){
        if($this->session->userdata('user_login_access') != False) {
        $data['designation'] = $this->employee_model->desselect();
        $this->load->view('backend/designation',$data);
        }
    else{
		redirect(base_url() , 'refresh');
	}            
    }
    public function Des_Save(){
        if($this->session->userdata('user_login_access') != False) {
        $des = $this->input->post('designation');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('designation','designation','trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            redirect('employee/Designation');
        }else{
            $data = array();
            $data = array('des_name' => $des);
            $success = $this->employee_model->Add_Designation($data);
            $this->session->set_flashdata('feedback','Successfully Added');
            redirect('employee/Designation');
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}
    }
    public function Assign_leave(){
        if($this->session->userdata('user_login_access') != False) {
        $emid = $this->input->post('em_id');
        $type = $this->input->post('typeid');
        $day = $this->input->post('noday');
        $year = $this->input->post('year');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('typeid','typeid','trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            #redirect('employee/Designation');
        }else{
            $data = array();
            $data = array(
                'emp_id' => $emid,
                'type_id' => $type,
                'day' => $day,
                'total_day' => '0',
                'year' => $year
            );
            $success = $this->employee_model->Add_Assign_Leave($data);
            echo "Successfully Added";
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}
    }
    public function Add_File(){
    if($this->session->userdata('user_login_access') != False) { 
    $em_id = $this->input->post('em_id');    		
    $filetitle = $this->input->post('title');    		
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('title', 'title', 'trim|required|min_length[10]|max_length[120]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			
			} else {
            if($_FILES['file_url']['name']){
            $file_name = $_FILES['file_url']['name'];
			$fileSize = $_FILES["file_url"]["size"]/1024;
			$fileType = $_FILES["file_url"]["type"];
			$new_file_name='';
            $new_file_name .= $file_name;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg|pdf|doc|docx|xml|text|txt",
                'overwrite' => False,
                'max_size' => "40480000"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('file_url')) {
                echo $this->upload->display_errors();
                #redirect("employee/view?I=" .base64_encode($em_id));
			}
   
			else {
                $path = $this->upload->data();
                $img_url = $path['file_name'];
                $data = array();
                $data = array(
                    'em_id' => $em_id,
                    'file_title' => $filetitle,
                    'file_url' => $img_url
                );
            $success = $this->employee_model->File_Upload($data); 
            #$this->session->set_flashdata('feedback','Successfully Updated');
            #redirect("employee/view?I=" .base64_encode($em_id));
                echo "Successfully Updated";
			}
        }
            
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
    public function educationbyib(){
        if($this->session->userdata('user_login_access') != False) {  
		$id= $this->input->get('id');
		$data['educationvalue'] = $this->employee_model->GetEduValue($id);
		echo json_encode($data);
        }
    else{
		redirect(base_url() , 'refresh');
	} 
        
    }
    public function experiencebyib(){
        if($this->session->userdata('user_login_access') != False) {  
		$id= $this->input->get('id');
		$data['expvalue'] = $this->employee_model->GetExpValue($id);
		echo json_encode($data);
        }
    else{
		redirect(base_url() , 'refresh');
	} 
        
    }
    public function DisiplinaryByID(){
        if($this->session->userdata('user_login_access') != False) {  
		$id= $this->input->get('id');
		$data['desipplinary'] = $this->employee_model->GetDesValue($id);
		echo json_encode($data);
        }
    else{
		redirect(base_url() , 'refresh');
	} 
        
    }
    public function EmployeeDelete($id){
        if($this->session->userdata('user_login_access') != False) {  
        $em_id= $id;

          $data = array();
                $data = array(
                    'status'=>'INACTIVE'
                );

                $success = $this->employee_model->DeletEmployees($em_id,$data);
        //$success = $this->employee_model->DeletEmployee($id);
        $data['employee'] = $this->employee_model->emselect();
        $this->load->view('backend/employees',$data);
        }
    else{
        redirect(base_url() , 'refresh');
    }
    } 
    public function EduvalueDelet(){
        if($this->session->userdata('user_login_access') != False) {  
		$id= $this->input->get('I');
		$success = $this->employee_model->DeletEdu($id);
		echo "Successfully Deleted";
        }
    else{
		redirect(base_url() , 'refresh');
	} 
    }
    public function EXPvalueDelet(){
        if($this->session->userdata('user_login_access') != False) {  
		$id= $this->input->get('id');
		$success = $this->employee_model->DeletEXP($id);
		echo "Successfully Deletd";
        }
    else{
		redirect(base_url() , 'refresh');
	} 
    }
    public function DeletDisiplinary(){
        if($this->session->userdata('user_login_access') != False) {  
		$id= $this->input->get('D');
		$success = $this->employee_model->DeletDisiplinary($id);
		#echo "Successfully Deletd";
            redirect('employee/Disciplinary');
        }
    else{
		redirect(base_url() , 'refresh');
	} 
    }
    public function Add_Salary(){
        if($this->session->userdata('user_login_access') != False) { 
        $sid = $this->input->post('sid');
        $aid = $this->input->post('aid');
        $did = $this->input->post('did');
        $em_id = $this->input->post('emid');
        $type = $this->input->post('typeid');
        $total = $this->input->post('total');
        $basic = $this->input->post('basic');
        $medical = $this->input->post('medical');
        $houserent = $this->input->post('houserent');
        $conveyance = $this->input->post('conveyance');
        $provident = $this->input->post('provident');
        $bima = $this->input->post('bima');
        $tax = $this->input->post('tax');
        $others = $this->input->post('others');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters();
        $this->form_validation->set_rules('total', 'total', 'trim|required|min_length[3]|max_length[10]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
			#redirect("employee/view?I=" .base64_encode($em_id));
			} else {
            $data = array();
                $data = array(
                    'emp_id' => $em_id,
                    'type_id' => $type,
                    'total' => $total
                );
            if(!empty($sid)){
                $success = $this->employee_model->Update_Salary($sid,$data);
                #$this->session->set_flashdata('feedback','Successfully Updated');
                #echo "Successfully Updated";
                #$success = $this->employee_model->Add_Salary($data);
                #$insertId = $this->db->insert_id();
                #$this->session->set_flashdata('feedback','Successfully Added');
                #echo "Successfully Added";
                if(!empty($aid)){
                $data1 = array();
                $data1 = array(
                    'salary_id' => $sid,
                    'basic' => $basic,
                    'medical' => $medical,
                    'house_rent' => $houserent,
                    'conveyance' => $conveyance
                );
                $success = $this->employee_model->Update_Addition($aid,$data1);                    
                }
                if(!empty($did)){
                 $data2 = array();
                $data2 = array(
                    'salary_id' => $sid,
                    'provident_fund' => $provident,
                    'bima' => $bima,
                    'tax' => $tax,
                    'others' => $others
                );
                $success = $this->employee_model->Update_Deduction($did,$data2);                    
                }

                echo "Successfully Updated";                
            } else {
                $success = $this->employee_model->Add_Salary($data);
                $insertId = $this->db->insert_id();
                #$this->session->set_flashdata('feedback','Successfully Added');
                #echo "Successfully Added";
                $data1 = array();
                $data1 = array(
                    'salary_id' => $insertId,
                    'basic' => $basic,
                    'medical' => $medical,
                    'house_rent' => $houserent,
                    'conveyance' => $conveyance
                );
                $success = $this->employee_model->Add_Addition($data1);
                $data2 = array();
                $data2 = array(
                    'salary_id' => $insertId,
                    'provident_fund' => $provident,
                    'bima' => $bima,
                    'tax' => $tax,
                    'others' => $others
                );
                $success = $this->employee_model->Add_Deduction($data2); 
                echo "Successfully Added";
            }           
        }
        }
    else{
		redirect(base_url() , 'refresh');
	}        
    }
	public function confirm_mail_send($email,$pass_hash){
		$config = Array( 
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.googlemail.com', 
		'smtp_port' => 465, 
		'smtp_user' => 'mail.imojenpay.com', 
		'smtp_pass' => ''
		); 		  
         $from_email = "imojenpay@imojenpay.com"; 
         $to_email = $email; 
   
         //Load email library 
         $this->load->library('email',$config); 
   
         $this->email->from($from_email, 'Dotdev'); 
         $this->email->to($to_email);
         $this->email->subject('Hr Syatem'); 
		 $message	 =	"Your Login Email:"."$email";
		 $message	.=	"Your Password :"."$pass_hash"; 
         $this->email->message($message); 
   
         //Send mail 
         if($this->email->send()){ 
         	$this->session->set_flashdata('feedback','Kindly check your email To reset your password');
		 }
         else {
         $this->session->set_flashdata("feedback","Error in sending Email."); 
		 }			
	}
    public function Inactive_Employee(){
        $data['employee'] = $this->employee_model->getInvalidUser();
        $this->load->view('backend/employees',$data);
    }
    public function Save_family()
    {
       if($this->session->userdata('user_login_access') != False) { 

            $id = $this->input->post('family_id');
            $first_name = $this->input->post('first_name');
            $middle_name = $this->input->post('middle_name');
            $last_name = $this->input->post('last_name');
		    $certname = substr($first_name,0,3).rand(1000,2000);
            $dateofbirth = $this->input->post('dob');
            $gender = $this->input->post('gender');
            $title = $this->input->post('title');
            $emid = $this->input->post('emid');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters();
            $this->form_validation->set_rules('first_name', 'first_name', 'trim|required|min_length[3]|max_length[150]|xss_clean');
            $this->form_validation->set_rules('middle_name', 'middle_name', 'trim|required|min_length[3]|max_length[150]|xss_clean');
            $this->form_validation->set_rules('last_name', 'last_name', 'trim|required|min_length[3]|max_length[150]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            echo validation_errors();
            #redirect("employee/view?I=" .base64_encode($em_id));
            } else {

			if($_FILES['image_url']['name']) {

				$file_name = $_FILES['image_url']['name'];
				$fileSize = $_FILES["image_url"]["size"] / 1024;
				$fileType = $_FILES["image_url"]["type"];
				$new_file_name = '';
				$new_file_name .= $certname;

				$config = array(
					'file_name' => $new_file_name,
					'upload_path' => "./assets/images/users",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => False,
					'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "800",
					'max_width' => "800"
				);

				$this->load->library('Upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('image_url')) {
					echo $this->upload->display_errors();
				}
				else{

					$path = $this->upload->data();
					$img_url = $path['file_name'];

					$data = array();
					$data = array(
						'first_name' =>$first_name,
						'middle_name' =>$middle_name,
						'last_name' =>$last_name,
						'dateofbirth' =>$dateofbirth,
						'gender' =>$gender,
						'title' =>$title,
						'em_id'=>$emid,
						'certificate'=>$img_url

					);
					if(empty($id)){
						$success = $this->employee_model->Add_Family($data);
						$this->session->set_flashdata('feedback','Successfully Added');
						echo "Successfully Added";
					} else {
						$success = $this->employee_model->Update_Family($id,$data);
						#$this->session->set_flashdata('feedback','Successfully Updated');
						echo "Successfully Updated";
					}
				}
			}else{
                
                $data = array();
                    $data = array(
                        'first_name' =>$first_name,
                        'middle_name' =>$middle_name,
                        'last_name' =>$last_name,
                        'dateofbirth' =>$dateofbirth,
                        'gender' =>$gender,
                        'title' =>$title,
                        'em_id'=>$emid

                    );
                    if(empty($id)){
                        $success = $this->employee_model->Add_Family($data);
                        $this->session->set_flashdata('feedback','Successfully Added');
                        echo "Successfully Added";
                    } else {
                        $success = $this->employee_model->Update_Family($id,$data);
                        #$this->session->set_flashdata('feedback','Successfully Updated');
                        echo "Successfully Updated";
                    }
            }
		}
    }
    else{
        redirect(base_url() , 'refresh');
       }
    }
    public function delete_person()
	{
		if ($this->session->userdata('user_login_access') != false){
			$id = $this->input->post('family_id');

			$this->employee_model->delete_person($id);
			echo 'Successfully Deleted';

		}else{
			redirect(base_url());
		}
	}
	public function edit_person()
	{
		if ($this->session->userdata('user_login_access') != false){

			$id = base64_decode($this->input->get('I'));

			$data['family'] = $this->employee_model->getFamilyById($id);

			$this->load->view('backend/edit_employee_person',$data);

		}
		else{
			redirect(base_url());
		}
	}
    public function Create_Salary()
    {
        if($this->session->userdata('user_login_access') != False) { 

            @$id = base64_decode($this->input->get('I'));
            $data['basic'] = $this->employee_model->GetBasic(@$id);
            $data['salaryvalue'] = $this->employee_model->GetsalaryValue(@$id);
            $data['taxttarif'] = $this->employee_model->GetReliefValue(@$id);
            $date['salaryScale'] = $this->payroll_model->GetSalaryScale();
            $data['bankinfo'] = $this->employee_model->GetBankInfo(@$id);
            @$sid = $data['salaryvalue']->id;
            $data['Assuarance'] = $this->employee_model->GetAssuaranceValue($sid);
            
            $data['commPending'] = $this->employee_model->GetCommulativePending($sid,$id);
            $data['commPension'] = $this->employee_model->GetCommulativePension($sid,$id);
            $data['PensionFund'] = $this->employee_model->getPensionFund($sid,$id);


            $this->load->view('payroll/create_salary',$data);
        }

    }
    public function Imprest()
    {
       if($this->session->userdata('user_login_access') != False) {

            $subAllowance   = $this->input->post('subsistence_allowance');
            $leaving_date   = $this->input->post('leaving_date');
            $returning_date = $this->input->post('date_returning');
            $place_visited  = $this->input->post('place_visited');
            $purpose_safari = $this->input->post('safari_purpose');
            $imp_id         = $this->input->post('imp_id');

            $number0 = $this->input->post('number0');
            $number1 = $this->input->post('number1');
            $number2 = $this->input->post('number2');
            $number3 = $this->input->post('number3');
            $number4 = $this->input->post('number4');
            $number5 = $this->input->post('number5');
            $number6 = $this->input->post('number6');

            $number7 = $this->input->post('number7');
            //$state_letter = $this->input->post('state_letter');
            $status = $this->input->post('status');
            $status2 = 'Not Approved';
            $comments = $this->input->post('comments');
            $emid = $this->input->post('emid');
            $emid2 = substr($emid,0,3).rand(1000,2000);

            if($_FILES['state_letter']['name']){

            $file_name = $_FILES['state_letter']['name'];
            $fileSize = $_FILES["state_letter"]["size"]/1024;
            $fileType = $_FILES["state_letter"]["type"];
            $new_file_name='';
            $new_file_name .= $emid2;

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "20240000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
                'max_height' => "800",
                'max_width' => "800"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('state_letter')) {
                echo $this->upload->display_errors();
            }
   
            else {
                
                $data = array();
                $data = array(
                    'leaving_date' =>$leaving_date,
                    'returning_date' =>$returning_date,
                    'place_visited' =>$place_visited,
                    'purporse_safari' =>$purpose_safari
                );

                $success = $this->employee_model->Insert_Details_Of_Safari($data);
                $insertId = $this->db->insert_id();

                $data = array();
                $data = array(
                    'number_of_days'=>$number0,
                    'sudsistence_amount'=>$number1,
                    'bus_train_fare'=>$number3,
                    'air_ticket'=>$number4,
                    'ac_code_vote'=>$number5,
                    'ac_code_vote_amount'=>$number6,
                    'foreign_20'=>$number2
                );

                $success = $this->employee_model->Insert_Details_Of_Interest($data);
                $insertId1 = $this->db->insert_id();

                $path = $this->upload->data();
                $state_letter = $path['file_name'];
                $data = array();
                $data = array(
                    'state_no'=>$number7,
                    'state_letter'=>$state_letter,
                    'isAssisted'=>$status,
                    'short_details'=>$comments
                );

                $success = $this->employee_model->Insert_Outside_Tanzania($data);
                $insertId2 = $this->db->insert_id();

                $data = array();
                $data = array(
                    'em_id' =>$emid,
                    'id_safari'=>$insertId,
                    'id_imprest'=>$insertId1,
                    'id_outside_tanzania'=>$insertId2,
                    'allowance_rate'=>$subAllowance,
                    'sub_status'=>$status2,
                    'registered_date'=> date('Y-m-d'),
					'imp_id'=>$imp_id
                );

                $success = $this->employee_model->Insert_Imprest($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Added";
       }
   }
   else{
                $data = array();
                $data = array(
                    'leaving_date' =>$leaving_date,
                    'returning_date' =>$returning_date,
                    'place_visited' =>$place_visited,
                    'purporse_safari' =>$purpose_safari
                );

                $success = $this->employee_model->Insert_Details_Of_Safari($data);
                $insertId = $this->db->insert_id();

                $data = array();
                $data = array(
                    'number_of_days'=>$number0,
                    'sudsistence_amount'=>$number1,
                    'bus_train_fare'=>$number3,
                    'air_ticket'=>$number4,
                    'ac_code_vote'=>$number5,
                    'ac_code_vote_amount'=>$number6,
                    'foreign_20'=>$number2
                );

                $success = $this->employee_model->Insert_Details_Of_Interest($data);
                $insertId1 = $this->db->insert_id();

                $path = $this->upload->data();
                $state_letter = $path['file_name'];
                $data = array();
                $data = array(
                    'state_no'=>$number7,
                    'state_letter'=>$state_letter,
                    'isAssisted'=>$status,
                    'short_details'=>$comments
                );

                $success = $this->employee_model->Insert_Outside_Tanzania($data);
                $insertId2 = $this->db->insert_id();

                $data = array();
                $data = array(
                    'em_id' =>$emid,
                    'id_safari'=>$insertId,
                    'id_imprest'=>$insertId1,
                    'id_outside_tanzania'=>$insertId2,
                    'allowance_rate'=>$subAllowance,
                    'sub_status'=>$status2,
                    'registered_date'=> date('Y-m-d'),
                    'imp_id'=>$imp_id
                );

                $success = $this->employee_model->Insert_Imprest($data);
                $this->session->set_flashdata('feedback','Successfully Added');
                echo "Successfully Added";
   }
  
}
       else{
        redirect(base_url() , 'refresh');
       }
    }
    public function Imprest_List()
    {
        if($this->session->userdata('user_login_access') != False) {

            $data['imprestList'] = $this->employee_model->getImprestList();
            $this->load->view('backend/imprestList',$data);
        }
    }
    public function Imprest_Bank()
    {
        if($this->session->userdata('user_login_access') != False) {
            $status = $this->input->get('status');

            $data['imprestList'] = $this->employee_model->getImprestToBank($status);

            
            $this->load->library('Pdf');
            $html= $this->load->view('backend/imprest_bank_sheet',$data,TRUE);
            $this->load->library('Pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4','potrait');
            $this->dompdf->render();
            $this->dompdf->stream('example.pdf', array("Attachment"=>0));

            foreach ($data['imprestList']->id_is as  $value) {
                $id_receive = $data['imprestList']->id_is;

            $data = array();
            $data = array('date2' =>date('Y-m-d'),'status'=>'Yes');
            $success = $this->employee_model->Update_Receivable($id_receive,$data);

            }
            //$this->load->view('backend/imprestList',$data);
        }
    }
    public function Imprest_Approved()
    {
        if($this->session->userdata('user_login_access') != False) {

            $data['imprestList'] = $this->employee_model->getImprestApproved();
            $this->load->view('backend/imprestList',$data);
        }
    }
    public function Imprest_Reject()
    {
        if($this->session->userdata('user_login_access') != False) {

			$emid = base64_decode($this->input->get('I'));
            $data['imprestList'] = $this->employee_model->getImprestRejected($emid);
			$this->load->view('backend/imprest_rejected',$data);
        }
    }
    public function Imprest_Approve()
    {
        if($this->session->userdata('user_login_access') != False) {

            $emid = base64_decode($this->input->get('I'));

            $data['imprestList'] = $this->employee_model->getImprestListById($emid);
          
             $this->load->view('backend/imprest_approve',$data);
            
           
        }
    }
    public function Imprest_ApproveO()
    {
        if($this->session->userdata('user_login_access') != False) {
            $id = $this->session->userdata('user_login_id');
            $basicinfo = $this->employee_model->GetBasic($id);
            $names =$basicinfo->em_code.' '. $basicinfo->first_name . ' ' .$basicinfo->last_name;
              

            $imprest_id = $this->input->post('id');
            $id_imprest = $this->input->post('imprest_id');
            $id_receive = $this->input->post('receive_id');
            $safari_id = $this->input->post('safari_id');
            $status = $this->input->post('status');
            $status1 = $this->input->post('status1');
            $status2 = $this->input->post('status2');
            $reason = $this->input->post('reason');

            if ($this->session->userdata('user_type')=='EMPLOYEE') {
                
            $subAllowance   = $this->input->post('subsistence_allowance');
            $leaving_date   = $this->input->post('leaving_date');
            $returning_date = $this->input->post('date_returning');
            $place_visited  = $this->input->post('place_visited');
            $purpose_safari = $this->input->post('safari_purpose');
            $imp_id         = $this->input->post('imp_id');

            $number0 = $this->input->post('number0');
            $number1 = $this->input->post('number1');
            $number2 = $this->input->post('number2');
            $number3 = $this->input->post('number3');
            $number4 = $this->input->post('number4');
            $number5 = $this->input->post('number5');
            $number6 = $this->input->post('number6');

            $number7 = $this->input->post('number7');
            //$state_letter = $this->input->post('state_letter');
            $status = $this->input->post('status');
            $status2 = 'Not Approved';
            $comments = $this->input->post('comments');
            $emid = $this->input->post('emid');
            $emid2 = substr($emid,0,3).rand(1000,2000);

            $data = array();
                $data = array(
                    'leaving_date' =>$leaving_date,
                    'returning_date' =>$returning_date,
                    'place_visited' =>$place_visited,
                    'purporse_safari' =>$purpose_safari
                );

                $success = $this->employee_model->Update_Details_Of_Safari($data,$safari_id);

                $data = array();
                $data = array(
                    'number_of_days'=>$number0,
                    'sudsistence_amount'=>$number1,
                    'bus_train_fare'=>$number3,
                    'air_ticket'=>$number4,
                    'ac_code_vote'=>$number5,
                    'ac_code_vote_amount'=>$number6,
                    'foreign_20'=>$number2
                );

                $success = $this->employee_model->Update_Details_Of_Interest($data,$id_imprest);

                $data = array();
                $data = array(
                    'allowance_rate'=>$subAllowance,
                    'sub_status'=>$status2
                );

                $success = $this->employee_model->Update_Imprest($data, $imprest_id);

                echo "Update Successfully";

            } 
            else {
                if (!empty($id_receive) && !empty($status1)) {
                $data = array();
               $data = array('hod' => $names,'date1' =>date('Y-m-d'),'hod_status'=>$status1);

            $success = $this->employee_model->Update_Receivable($id_receive,$data);
            echo "Successfully Updated";
            } elseif(!empty($id_receive) && !empty($status2)) {
                $data = array();
               $data = array('head_officer' => $names,'date2' =>date('Y-m-d'),'head_status'=>$status2,'reason'=>$reason);
               if ($status2 == 'Yes') {
                   $data1 = array();
                   $data1 = array('sub_status' => 'Approved');
               } else {
                   $data1 = array();
                   $data1 = array('sub_status' => 'Rejected');
               }

            $success = $this->employee_model->Update_ImprestSubsistence($imprest_id,$data1);
            $success = $this->employee_model->Update_Receivable($id_receive,$data);
            echo "Successfully Updated";
            }elseif(!empty($id_receive) && !empty($status)) {

               $data = array();
               $data = array('approved_by' => $names,'date' =>date('Y-m-d'),'status'=>$status);
               $success = $this->employee_model->Update_Receivable($id_receive,$data);
               echo "Successfully Updated";
            }
            else {
                $data = array();
               $data = array('imprest_id' =>$imprest_id,'hod_status' =>$status1,'reason' =>$reason, 'hod' => $names,'date' =>date('Y-m-d'));

            $success = $this->employee_model->Insert_Receivable($data);
            echo "Successfully Added";
            }
            
            }
             
        }

    }
    public function Search()
    {
        if($this->session->userdata('user_login_access') != False) {
            //echo "Nimefika kwaajili ya kusearch";
            $data['em_code'] = $this->input->get('em_code');
            $data['em_gender'] = $this->input->get('em_gender');
            $data['region'] = $this->input->get('region');
            $data['branch'] = $this->input->get('branch');

            $employee = $this->employee_model->SearchEmployee($data);
       echo "<thead>
                                            <tr>
                                                <th>Employee PF Number</th>
                                                <th>Employee Name</th>
                                                <th>Gender</th>
                                                <th>Region</th>
                                                <th>Branch </th>
                                                <th>Contact</th>
                                                <th>Retirement Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>" ;
                if (!empty($employee)) {
                    foreach ($employee as $value) {
                echo "<tr>
                    <td>$value->em_code</td>
                    <td>".$value->first_name.' '.$value->middle_name.' '.$value->last_name."</td>
                    <td>$value->em_gender</td>
                    <td>$value->em_region</td>
                    <td>$value->em_branch</td>
                    <td>$value->em_phone</td>
                    <td> ";
                    //$yearRetire=date('Y', strtotime($value->em_birthday)) + 60;
                                                        //$monhtOnly=date('m', strtotime($value->em_birthday));

                                                         //$yearNow = date('Y');
                                                         //$Monthnow = date('m');
                                                         //$yearDiff = date('Y', strtotime($value->em_birthday)) + 60 - date('Y');.
                                                         if ((date('Y', strtotime($value->em_birthday)) + 60 - date('Y')) <= 0) {
                                                            $monhtRemain = date('m', strtotime($value->em_birthday))-date('m');
                                                            if ($monhtRemain <= 0) {
                                                               $id = $value->id;
                                                               $this->employee_model->UpdateRetired($id);
                                                            } else {
                                                                 echo '<text style="color:red;">   '.$monhtRemain.'   '.'Months Remaining To Retire</text>' ;
                                                            }
                                                         } else {
                                                             echo $value->em_contact_end;
                                                         }
                         
                   echo "</td>
                    <td>
                    <a href='view?I=". base64_encode($value->em_id)."' class='btn btn-info btn-sm'><i class='fa fa-pencil-square-o'></i></a>
                    <a onclick='return confirm('Are you sure to delete this data?')' href='EmployeeDelete/".$value->id."' class='btn btn-danger btn-sm'><i class='fa fa-trash-o'></i></a>";
                    if ($this->session->userdata('user_type')=='ADMIN') {
                      echo  "&nbsp;<a href='Create_Salary?I=". base64_encode($value->em_id)."' class='btn btn-info btn-sm'><i class='fa fa-plus-square-o'></i>Add Salary</a>" ;
                    }
                  
                    "</td>
                </tr>";
            }
                } else {
                   echo "<tr><td colspan='8' style='text-align:center;color:red;'>Data Not Found</td></tr>";
                }
                
            
            
        }
    }
    public function expenditure()
	{
		if($this->session->userdata('user_login_access') != False) {
			$reff = $this->input->post('refference');
			$date = $this->input->post('date');
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$head_dep = $this->input->post('head_dep');
			$amount_request = $this->input->post('amount_request');
			$exp_sum = $this->input->post('exp_sum');
			$expenditure_type = $this->input->post('expenditure_type');
			$for = $this->input->post('for');
			$regards = $this->input->post('regards');
			$em_code = $this->input->post('em_code');

			$data = array();
			$data = array(
							'em_code'=>$em_code,
							'date_created'=>$date,
							'exp_from'=>$from,
							'exp_to'=>$to,
							'usf'=>$head_dep,
							'app_exp'=>$amount_request,
							'sum_exp'=>$exp_sum,
							'exp_type'=>$expenditure_type,
							'exp_for'=>$for,
							'regards'=>$regards,
							'exp_status'=>'NotApproved',
							'refferences'=>$reff
							);
			$this->employee_model->Insert_Imprest_Request_form($data);
			echo 'Successfully Added';
		}
		else{
			redirect(base_url());
		}
	}

	public function expenditure_not()
	{
		if($this->session->userdata('user_login_access') != False) {

			$data['implestExpenditure'] = $this->employee_model->getExpenditure();
			$this->load->view('backend/expenditure_not',$data);
		}else{
			redirect(base_url());
		}
	}
	public function expenditure_approve()
	{
		if($this->session->userdata('user_login_access') != False) {

			$id = base64_decode($this->input->get('I'));
			$data['basic'] = $this->employee_model->GetBasic($id);
			$expId = base64_decode($this->input->get('Exp'));
			$data['implestExpenditure'] = $this->employee_model->getExpenditureById($expId,$id);
			$this->load->view('backend/expenditure_approve',$data);

		}else{
			redirect(base_url());
		}
	}

	public function expenditure_confirm()
	{
		if($this->session->userdata('user_login_access') != False) {

			$expId = $this->input->post('imp_id');
			$status = $this->input->post('status');
			$reason = $this->input->post('reason');

			$reff = $this->input->post('refference');
			$date = $this->input->post('date');
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$head_dep = $this->input->post('head_dep');
			$amount_request = $this->input->post('amount_request');
			$exp_sum = $this->input->post('exp_sum');
			$expenditure_type = $this->input->post('expenditure_type');
			$for = $this->input->post('for');
			$regards = $this->input->post('regards');
			$em_code = $this->input->post('em_code');

			//echo $expId;
			if ($this->session->userdata('user_type') == 'HOD' || $this->session->userdata('user_type') == 'HOU')
			{
				$data = array();
				$data = array('reasons'=>$reason,'isHOD'=>$status);

				$this->employee_model->Update_Imprest_Request_form($data,$expId);

			}elseif ($this->session->userdata('user_type') == 'PMG' || $this->session->userdata('user_type') == 'GM')
			{
				if ($status == 'Yes')
				{
					$data = array();
					$data = array('exp_status'=>'Approved','reasons'=>$reason);
				}else
				{
					$data = array();
					$data = array('exp_status'=>'NotApproved','reasons'=>$reason);
				}
				$this->employee_model->Update_Imprest_Request_form($data,$expId);
			}else
			{

				$data = array();
				$data = array(
					'em_code'=>$em_code,
					'date_created'=>$date,
					'exp_from'=>$from,
					'exp_to'=>$to,
					'usf'=>$head_dep,
					'app_exp'=>$amount_request,
					'sum_exp'=>$exp_sum,
					'exp_type'=>$expenditure_type,
					'exp_for'=>$for,
					'regards'=>$regards,
					'exp_status'=>'NotApproved',
					'refferences'=>$reff
				);
				$this->employee_model->Update_Imprest_Request_form($data,$expId);
			}

			echo 'Successfull Updated';
			//redirect(base_url('employee/expenditure_not'));


		}else{
			redirect(base_url());
		}
	}
	public function  imprest_form()
	{
		if($this->session->userdata('user_login_access') != False) {
			$data['imp_id'] = base64_decode($this->input->get('imp_id'));
			$id = base64_decode($this->input->get('em_id'));
			$data['basic'] = $this->employee_model->GetBasic($id);
			$data['imprestList'] = $this->employee_model->getImprestListById2($id);
			$this->load->view('backend/imprest_form',$data);
		}else{
			redirect(base_url());
		}
	}
    public function  Add_Referee()
    {
        if($this->session->userdata('user_login_access') != False) {

           $emid = $this->input->post('emid');
           $fname = $this->input->post('fname');
           $mname = $this->input->post('mname');
           $lname = $this->input->post('lname');
           $occupation = $this->input->post('occupation');
           $email = $this->input->post('email');
           $mobile = $this->input->post('mobile');

           $data = array();
           $data = array('emp_id'=>$emid,'first_name'=>$fname,'middle_name'=>$mname,'last_name'=>$lname,'occupation'=>$occupation,'email'=>$email,'mobile'=>$mobile);

           $this->employee_model->saveReferee($data);

           echo "Successfully Added";

        }else{
            redirect(base_url());
        }
    }

    public function  Delete_Referee()
    {
        if($this->session->userdata('user_login_access') != False) {

           $id = $this->input->post('ref_id');
           
           $this->employee_model->deleteReferee($id);
           
           echo "Successfully Deleted";

        }else{
            redirect(base_url());
        }
    }

    public function  Edit_Education()
    {
        if($this->session->userdata('user_login_access') != False) {

           $eid = base64_decode($this->input->get('I'));
           $id = base64_decode($this->input->get('Ei'));

           $data['education'] = $this->employee_model->GetEducation($id);
           $data['editeducation'] = $this->employee_model->GetEditEducation($eid);
           $data['basic'] = $this->employee_model->GetBasic($id);

           $this->load->view('backend/edit_employee_education',$data);

        }else{
            redirect(base_url());
        }
    }

    public function  Password_reset()
    {
        if($this->session->userdata('user_login_access') != False) {

           $pfnumber =  $this->input->post('pfnumber');
           $password =  sha1($this->input->post('password'));
            
           $data = array();

            $modified_password = date("Y-m-d");
            //Password expires
             $threeMOth = date('Y-m-d',strtotime('3 month'));


           $data = array(
            'em_password'=>$password,
            'last_modified_password'=> $modified_password,
            'password_expires'=> $threeMOth
        );

           $this->employee_model->reset_password1($pfnumber,$data);

           echo "Successfuly Password Reset";

        }else{
            redirect(base_url());
        }
    }

    public function  delete_experience()
    {
        if($this->session->userdata('user_login_access') != False) {

           $id =  $this->input->post('expid');
           $this->employee_model->delete_experiences($id);
           echo "Successfuly Deleted";

        }else{
            redirect(base_url());
        }
    }

    public function  delete_address()
    {
        if($this->session->userdata('user_login_access') != False) {

           $id =  $this->input->post('addid');
           $this->employee_model->delete_address($id);
           echo "Successfuly Deleted";

        }else{
            redirect(base_url());
        }
    }

    public function  Assign_job()
    {
        if($this->session->userdata('user_login_access') != False) {

           $id = $this->input->post('empid');
           $job = $this->input->post('job');
                    $data = array();
                    $data = array('job_assign'=>$job,'assign_status'=>'Yes');
                    $this->employee_model->Update_Jobassign($data,$id);
           echo "Successfuly Job Assign";

        }else{
            redirect(base_url());
        }
    }
	
	public function  Assign_Service()
    {
        if($this->session->userdata('user_login_access') != False) {
			
			$data['emid']= base64_decode($this->input->get('I'));
			$id = base64_decode($this->input->get('I'));
			$data['service2'] = $this->employee_model->get_services_byEmId1($id); 
            //$data['service2'] = $this->employee_model->get_services_byEmId($id); 

             $this->load->view('backend/assign_job',$data);

        }else{
            redirect(base_url());
        }
    }
	
	public function  Assign_Service_Action()
    {
        if($this->session->userdata('user_login_access') != False) {
			
			$emid = $this->input->post('emid');
			$cId = $this->input->post('counter');
			$serveid = $this->input->post('serv_id');

             $zone_id = $this->input->post('zone_id');

           // echo json_encode($zone_id);
              $id = $this->session->userdata('user_login_id');

             for ($i=0; $i <@sizeof($zone_id) ; $i++) { 
                //echo "ZONE EMPLOY Saved";

                //delete previous zoneid za huyo mtu
                 $this->Box_Application_model->delete_zone_employee($emid);

                $get_region_byZone= $this->Box_Application_model->get_region_byZoneId($zone_id[$i]);
                foreach ($get_region_byZone as $key => $value) {
                    $getregionname= $this->Box_Application_model->get_region_name($value->region_code);
                    $cs = array();
                    $cs = array('zone_id'=>$value->zone_id,'zone_regioncode'=>$value->region_code,'region_name'=>$getregionname->region_name,'emid'=>$emid,'assign_by'=>$id,'assign_status'=>'Assign');
                     // $cs = array('zone_id'=>1,'zone_regioncode'=>1,'emid'=>1,'assign_to'=>1,'assign_status'=>'Assign');
                      $this->Box_Application_model->save_zone_employee($cs);

                     // echo "ZONE EMPLOY Saved";
                    
                }
                 
                 }


            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');

            $checkCounter = $this->Box_Application_model->check_counter_service($emid);
            $lcId = @$checkCounter->c_id;
           $csId = @$checkCounter->cs_id;

           $sup = array();
                  $sup = array('assign_status'=>'NotAssign');
                  $this->employee_model->Update_Counters_Services1($sup,$lcId);

                  $ssup = array();
                  $ssup = array('c_status'=>'NotAssign');
                  $this->employee_model->Update_Counters1($ssup,$lcId);

             $this->Box_Application_model->delete_servc_emp($emid);

    		 	 

                 for ($i=0; $i <@sizeof($serveid) ; $i++) { 
                 
					  $cs = array();
					  $cs = array('c_id'=>$cId,'serv_id'=>$serveid[$i],'assign_to'=>$emid,'assign_status'=>'Assign');
					  $this->Box_Application_model->save_counter_service($cs);

                 }

			          $csup = array();
					  $csup = array('c_status'=>'Assign');
					  $this->employee_model->Update_Counters($csup,$cId);

                      $update = array();
                      $update = array('assign_status'=>'Assign','date_assign'=>$date);
                      $this->employee_model->Update_Jobassign($update,$emid);
					 
					  echo "Services Saved Successfully";

        }else{
            redirect(base_url());
        }
    }

    public function  delete_salary()
    {
        if($this->session->userdata('user_login_access') != False) {
            $emid = base64_decode($this->input->get('I'));
            
           //$emid = $this->input->post('em_id');

           $salary_id = $this->employee_model->getSalaryId($emid);
           $id = $salary_id->id;

           //$this->employee_model->deletecummulative($id);
           //$this->employee_model->deletecummulativePercent($id);
           //$this->employee_model->deleteNonPercent($id);
           //$this->employee_model->deletePercent($id);
           //$this->employee_model->deleteNonTax($id);
           //$this->employee_model->deleteOtherDeduction($id);
           //$this->employee_model->deleteOtherDeductionMonth($emid);
           //$this->employee_model->deletepension_funds($id);
           //$this->employee_model->deletepension_fund_contribution($id);
           //$this->employee_model->deletepaysalary($emid);
           $this->employee_model->deleteempsalary($id);

           echo "Successfully Deleted";
        }else{
            redirect(base_url());
        }
    }
}
