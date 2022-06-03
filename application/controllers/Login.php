<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model'); 
		$this->load->model('Box_Application_model');
  
    }
    
	public function index()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect(base_url() . 'dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
			$this->load->view('login');
	}
	public function Login_Auth(){	
	$response = array();
    //Recieving post input of email, password from request
    $email = $this->input->post('email');
    $password = sha1($this->input->post('password'));
	$remember = $this->input->post('remember');

	$keys = $this->input->get('key');
	$emails = $this->input->get('email');
	$roles = $this->input->get('role');



	if(empty($keys)){

		#Login input validation\
	$this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	$this->form_validation->set_rules('email', 'User Email', 'trim|xss_clean|required|min_length[7]');
	$this->form_validation->set_rules('password', 'Password', 'trim|xss_clean|required|min_length[6]');
	
	if($this->form_validation->run() == FALSE){
		$this->session->set_flashdata('feedback','UserEmail or Password is Invalid');
		redirect(base_url() . 'login', 'refresh');		
	}

	}else{
		$email =$emails;
		$remember = false;

		   $decryption_iv = '2354235322332234';
			// Store the decryption key
			$decryption_key = "Postapmis";
			$ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
			  
			// Use openssl_decrypt() function to decrypt the data
			$decryption=openssl_decrypt ($keys, $ciphering, 
			        $decryption_key, $options, $decryption_iv);



			if($email == $decryption){
			    $password= $keys;
			}


	}
	
	//else{

        //Validating login
        $login_status = $this->validate_login($email, $password ,$keys);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
        	if($remember){
        		setcookie('email',$email,time() + (86400 * 30));
        		setcookie('password',$this->input->post('password'),time() + (86400 * 30));
        		redirect(base_url() . 'login', 'refresh');
        		
        	} else {
        		if(isset($_COOKIE['email']))
        		{
        			setcookie('email',' ');
        		}
        		if(isset($_COOKIE['password']))
        		{
        			setcookie('password',' ');
        			
        		}  

        		redirect(base_url() . 'login', 'refresh');
        	}
        
        }
		else{
			$this->session->set_flashdata('feedback','UserEmail or Password is Invalid');
			redirect(base_url() . 'login', 'refresh');
		}

	//}
}
    //Validating login from request
    function validate_login($email = '', $password = '', $keys = '') {

        if(empty($keys)){
        	$credential = array('em_email' => $email, 'em_password' => $password,'status' => 'ACTIVE');
    		
    	}else{
    		if($password == $keys ){
    			$credential = array('em_email' => $email,'status' => 'ACTIVE');
    		}else{ $credential = array('em_email' => $email, 'em_password' => $password,'status' => 'ACTIVE'); }}

    		$query = $this->login_model->getUserForLogin($credential);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $this->session->set_userdata('user_login_access', '1');
            $this->session->set_userdata('user_login_id', $row->em_id);
            $this->session->set_userdata('name', $row->first_name);
            $this->session->set_userdata('email', $row->em_email);
            $this->session->set_userdata('user_image', $row->em_image);
            $this->session->set_userdata('user_type', $row->em_role);
            $this->session->set_userdata('user_emid', $row->em_id);
            $this->session->set_userdata('user_emcode', $row->em_code);
            $this->session->set_userdata('user_region', $row->em_region);
            $this->session->set_userdata('user_branch', $row->em_branch);
			$this->session->set_userdata('status', $row->assign_status);
			$this->session->set_userdata('date', $row->date_assign);
			$this->session->set_userdata('sub_user_type', $row->em_sub_role);
			$this->session->set_userdata('departmentid', $row->dep_id);
			$this->session->set_userdata('designationid', $row->des_id);

            $data = array();
            $data = array('em_id'=>$row->em_id,'first_name'=>$row->first_name,'middle_name'=>$row->middle_name,'last_name'=>$row->last_name,'date_created'=>date('Y-m-d'));
            $this->login_model->insert_activity($data);
            return 'success';
        }
	}
    /*Logout method*/
    function logout() {

    	$em_id = $this->session->userdata('user_emid');
    	$id = $this->session->userdata('user_login_id');
        $basicinfo = $this->employee_model->GetBasic($id);
    	$date  = date('Y-m-d');
    	date_default_timezone_set("Africa/Nairobi");
    	$logged_out = date('Y-m-d h:i:sa');
    	$data1 = array();
        $data1 = array('logout_time'=>date('Y-m-d h:i:sa'));
        
        $this->session->sess_destroy();
        $this->session->set_flashdata('feedback', 'logged_out');
        redirect(base_url(), 'refresh');
    }

	public function confirm_mail_send($email,$randcode){
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
         $this->email->subject('Confirm Your Account'); 
		 $message	 =	"Confirm Your Account";
		 $message	.=	"Click Here : ".base_url()."Confirm_Account?C=" . $randcode.'</br>'; 
         $this->email->message($message); 
   
         //Send mail 
         if($this->email->send()){ 
         	$this->session->set_flashdata('feedback','Kindly check your email To reset your password');
		 }
         else {
         $this->session->set_flashdata("feedback","Error in sending Email."); 
		 }			
	}
	public function verification_confirm(){
		$verifycode = $this->input->get('C');
		$userinfo = $this->login_model->GetuserInfoBycode($verifycode);
		if($userinfo){
    		$data = array();
    		$data = array(
    			'status'=>'ACTIVE',
				'confirm_code' => 0
    		);
    		$this->login_model->UpdateStatus($verifycode,$data);
    		if($this->db->affected_rows()){
			$this->session->set_flashdata('feedback','Your Account has been confirmed!! now login');
			$this->load->view('backend/login');
    		}			
		} else {
			$this->session->set_flashdata('feedback','Sorry your account has not been varified');
			$this->load->view('backend/login');  			
		}
	}
	public function forgotten_page(){
        $data=array();
        $data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
		$this->load->view('backend/forgot_password',$data);
	}
	public function forgot_password(){
		$email = $this->input->post('email');
		$checkemail = $this->login_model->Does_email_exists($email);
		if($checkemail){
			$randcode = md5(uniqid());
			$data=array();
			$data=array(
				'forgotten_code'=>$randcode
			);
			$updatedata = $this->login_model->UpdateKey($data,$email);
			$updateaffect = $this->db->affected_rows();
			if($updateaffect){
			$email=$this->input->post('email');	
			$this->send_mail($email,$randcode);
			$this->session->set_flashdata('feedback','Kindly check your email' .' '.$email. 'To reset your password');
			redirect('Retriev');				
			} else {
				
			}
		} 
		else {
			$this->session->set_flashdata('feedback','Please enter a valid email address!');
			redirect('Retriev');
		}
	}
      public function send_mail($email,$randcode) {
		$config = Array( 
		'protocol' => 'smtp', 
		'smtp_host' => 'ssl://smtp.googlemail.com', 
		'smtp_port' => 25, 
		'smtp_user' => 'mail.imojenpay.com', 
		'smtp_pass' => ''
		); 		  
         $from_email = "imojenpay@imojenpay.com"; 
         $to_email = $email; 
   
         //Load email library 
         $this->load->library('email',$config); 
   
         $this->email->from($from_email, 'Dotdev'); 
         $this->email->to($to_email);
         $this->email->subject('Reset your password!!Dotdev'); 
        $message	.=	"Your or someone request to reset your password" ."<br />";
		$message	.=	"Click  Here : ".base_url()."Reset_password?p=" . $randcode."<br />"; 
         $this->email->message($message); 
   
         //Send mail 
         if($this->email->send()){ 
         	$this->session->set_flashdata('feedback','Kindly check your email To reset your password');
		 }
         else {
         $this->session->set_flashdata("feedback","Error in sending Email."); 
		 }	
      }
	public function Reset_View(){
		$this->load->helper('form');
		$reset_key = $this->input->get('p');
		if($this->login_model->Does_Key_exists($reset_key)){
		$data['key']= $reset_key;
		$this->load->view('backend/reset_page',$data);
		} 
		else {
			$this->session->set_flashdata('feedback','Please enter a valid email address!');
			redirect('Retriev');
		}
	}
	public function Reset_password_validation(){
		$password = $this->input->post('password');
		$confirm = $this->input->post('confirm');
		$key = $this->input->post('reset_key');
		$userinfo = $this->login_model->GetUserInfo($key);
		
		if($password == $confirm){
			if($userinfo->password != sha1($password)){
			$data=array();
			$data = array(
				'forgotten_code'=> 0,
			    'password'=>sha1($password)
			    );
		$update = $this->login_model->UpdatePassword($key,$data);
		if($this->db->affected_rows()){
			$data['message'] = 'Successfully Updated your password!!';
		    $this->load->view('backend/login',$data);
		}
		} else {
         	$this->session->set_flashdata('feedback','You enter your old password.Please enter new password');
         	redirect('Reset_password?p='.$key);			
		}
		} else {
         	$this->session->set_flashdata('feedback','Password does not match');
         	redirect('Reset_password?p='.$key);
		}
	}	
	
}