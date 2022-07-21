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
		$this->load->helper(array('date','form', 'security'));
		$this->load->library('form_validation');

		$datetime = new DateTime();
		$this->today_date  = $datetime->format('Y-m-d');
	}

	public function index()
	{
		#Redirect to Admin dashboard after authentication
		if ($this->session->userdata('user_login_access') == 1)
			redirect(base_url() . 'dashboard');
		$data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
		$this->load->view('login_new');
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

				if($this->is_password_expired($row->last_modified_password))
				{
				// password expired
					$this->session->set_flashdata('error', 'Oops!, your password has expired, please reset it here.<br/><br/>');
					$this->session->set_flashdata('hint','New Password field must be at least 8 and not greater than 20  characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.');
					$this->session->set_userdata('password_reset_email', $row->em_email);
					redirect(base_url('login/change_password'), 'refresh');
				}
				else
				{
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
		// 	// Check id password expired
		// 	$date = date('Y-m-d');
		// 	$today_date = DateTime::createFromFormat('Y-m-d', $date);
		// 	$prev_date = DateTime::createFromFormat('Y-m-d', $row->last_modified_password);
		// 	$diffDays = $prev_date->diff($today_date)->format("%a");
		// 	if($diffDays >= 30)
		// 	{
		// 		unset($_SESSION);
		// 		//session_destroy();
		// 		$this->session->set_userdata('email', $row->em_email);
		// 		redirect(base_url('login/change_password'), 'refresh');
		// 	}
        //     $this->login_model->insert_activity($data);
        //     return 'success';
        // }
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

		private function is_password_expired($previous_date)
		{
			$date = date('Y-m-d');
			$today_date = DateTime::createFromFormat('Y-m-d', $date);
			$prev_date = DateTime::createFromFormat('Y-m-d', $previous_date);
			$diffDays = $prev_date->diff($today_date)->format("%a");

			if($diffDays >= 60)return TRUE;
			else return FALSE;
		}

		function change_password()
		{
			if($_SERVER['REQUEST_METHOD']=='POST')
			{
				$this->form_validation->set_rules('password_reset_email','User email missed','required|valid_email');
				$this->form_validation->set_rules('oldpassword','Old password','required');
				$this->form_validation->set_rules('newpassword','New Password','callback_valid_password');
				$this->form_validation->set_rules('passconfirm','Confirm New Password','required|matches[newpassword]');
				if($this->form_validation->run()==TRUE)
				{
					$reset_email = $this->security->xss_clean($this->input->post('password_reset_email'));

					$currentPassword = $this->security->xss_clean($this->input->post('oldpassword'));

					$newPassword = $this->security->xss_clean($this->input->post('newpassword'));

					$encryptCurrentPassword = sha1($currentPassword);

					if($currentPassword == $newPassword)
					{
						$this->session->set_flashdata('error','Oops!, your new password seems to be similar to the current one');
						redirect(base_url('login/change_password'));
					}
					else
					{
						$check = $this->login_model->is_current_password_available($encryptCurrentPassword, $reset_email);

						if($check==FALSE)
						{
							$this->session->set_flashdata('error','Oops!, your current password is not found, please catch up with our IT support team');
							redirect(base_url('login/change_password'));
						}
						else
						{
							$encrypted_new_password = sha1($newPassword);

							$update_password = $this->login_model->update_pmis_login_password($encrypted_new_password,$check['id'],$this->today_date);

							if($update_password)
							{
								$this->session->set_flashdata('feedback','Password changed Successfully');
								redirect(base_url('login'));
							}
							else
							{
								$this->session->set_flashdata('feedback','Password Not Changed');
								$this->load->view('login_change_password');
							}

						}
					}
				}
				else
				{
					$this->load->view('login_change_password');
				}
			}
			else
			{
				$this->load->view('login_change_password');
			}
		}




	/**
	 * Validate the password
	 *
	 * @param string $password
	 *
	 * @return bool
	 */
	public function valid_password($password = '')
	{
		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		$specialChars = preg_match('/[!@#$%^&*()\-_=+{};:,<.>§~]/', $password);

		if (empty($password))
		{
			$this->form_validation->set_message('valid_password', 'The {field} field is required.');

			return FALSE;
		}
		if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 6 || !strlen($password) >20 ) {
			$this->form_validation->set_message('valid_password', 'The {field} field must be at least 6 and not greater than 20  characters in length and should include at least one upper case letter, one number, and one special character.');

			return FALSE;
		}
		return 	TRUE;
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



	//reset password
	public function forgetpassword()
	{
		if($_SERVER['REQUEST_METHOD']=='POST')
		{
			$this->form_validation->ser_rules('email','Email','required');
			if($this->form_validation->run()==TRUE)
			{
				$email = $this->input->post('email');
				$validateEmail = $this->user_model->validateEmail($email);
				if($validateEmail!=false)
				{
					$row = $validateEmail;
					$user_id = $row->id;

					$string = time().$user_id.$email;
					$hash_string = hash('sha256',$string);
					$currentDate = date('Y-m-d H:i');
					$currentDate = date('Y-m-d H:i',strtotime($currentDate.'1 days'));
					$data = array(
						'hash_key'=>$hash_string,
						'hash_expiry'=>$hash_expiry,
					);

					$resetlink = base_url().'reset/password?hash='.$hash_string;
					$message = '<p>Your reset password link is here:</p>'.$resetlink;
					$subject = "Password Reset link";
					$sentStatus = $this->sendEmail($email,$subject,$message);
					if($sentStatus==true)
					{
						$this->login_model->updatePasswordhash($data,$email);
						$this->session->set_flashdata('success','Reset password link successfully sent');
						redirect(base_url('login/forgotpassword'));
					}
					else{
						$this->session->set_flashdata('error','Email sending error');
						$this->load->view('forget_password');
					}
				}
				else{
					$this->session->set_flashdata('error','invalid email');
					$this->load->view('forget_password');
				}
			}
			else
			{
				$this->load->view('forget_password');	
			}
		}
		else{
			$this->load->view('forget_password');
		}
		
	}
	
	public function sendEmail($email,$subject,$message)
	{

		/* use this on server */

    	/* $config = Array(
		      'mailtype' => 'html',
		      'charset' => 'iso-8859-1',
		      'wordwrap' => TRUE
	    	);
    	 */


	    	/*This email configuration for sending email by Google Email(Gmail Acccount) from localhost */
	    	$config = Array(
	    		'protocol' => 'smtp',
	    		'smtp_host' => 'ssl://smtp.googlemail.com',

	    		'smtp_port' => 465,
	      'smtp_user' => 'exampleEmail@gmail.com',  //gmail id
	      'smtp_pass' => '@@password',   //gmail password
	      
	      'mailtype' => 'html',
	      'charset' => 'iso-8859-1',
	      'wordwrap' => TRUE
	  );
	    	$this->load->library('email', $config);
	    	$this->email->set_newline("\r\n");
	    	$this->email->from('noreply');
	    	$this->email->to($email);
	    	$this->email->subject($subject);
	    	$this->email->message($message);

	    	if($this->email->send())
	    	{
	    		return true;
	    	}
	    	else
	    	{
	    		return false;
	    	}
	    }
	}