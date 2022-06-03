 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('billing_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('stock_model');
        $this->load->model('unregistered_model');
        $this->load->model('Box_Application_model');
    }
    
	public function Dashboard()
	{
		if ($this->session->userdata('user_login_access') != false)
            {
                $this->load->view('inlandMails/unregistered_dashboard');
            }
            else{
                redirect(base_url());
            }
	}

    

}