 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

 require(APPPATH.'/libraries/REST_Controller.php');
class Posta extends REST_Controller {


    function __construct() {
        parent::__construct();
        //$this->load->database();
        //$this->load->model('login_model');
       // $this->load->model('dashboard_model');
        //$this->load->model('employee_model');
        //$this->load->model('notice_model');
        //$this->load->model('settings_model');
        //$this->load->model('leave_model');
    }
    
	public function test()
	{
		echo 'Mussa Johanes';
	}
    
}
