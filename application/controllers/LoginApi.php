<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginApi extends CI_Controller {

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
  
    }
    
	public function login()
	{
		$getValue = json_decode( file_get_contents( 'php://input' ), true );
		$email = $getValue['email'];
		$password = sha1($getValue['password']);

		$authenticate = $this->login_model->getLoginDetails($email,$password);
		if (!empty($authenticate)) {
			
			$value = array('first_name'=>$authenticate->first_name,'last_name'=>$authenticate->last_name,'em_role'=>$authenticate->em_role,'em_id'=>$authenticate->em_id,'em_image'=>$authenticate->em_image);

			header('Content-Type: application/json');
            echo json_encode($value);
		}else{
			echo "error Login";
		}
	}
	
}