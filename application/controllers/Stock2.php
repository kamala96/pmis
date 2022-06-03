	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Stock extends CI_Controller {


		function __construct() {
			parent::__construct();
			$this->load->database();
	    //$db2 = $this->load->database('otherdb', TRUE);
			$this->load->model('login_model');
			$this->load->model('dashboard_model'); 
			$this->load->model('employee_model'); 
			$this->load->model('notice_model');
			$this->load->model('settings_model');
			$this->load->model('leave_model');
			$this->load->model('billing_model');
			$this->load->model('organization_model');
			$this->load->model('Box_Application_model');
			$this->load->model('Stampbureau');
		}

			public function Stock()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				$data['region'] = $this->employee_model->regselect();
				$data['category'] = $this->billing_model->getAllCategory();
				$data['listItem'] = $this->billing_model->getAllCategoryBill();

				//$this->load->view('billing/Stock',$data);
				$this->load->view('Stock/Stock',$data);
			}
			else{
				redirect(base_url());
			}
		}

		public function Stocks()
		{
			if ($this->session->userdata('user_login_access') != false)
			{
				
        $data['philatel'] = $this->Stampbureau->philatelist();
				$this->load->view('Stock/StockList',$data);
			}
			else{
				redirect(base_url());
			}
		}

			

}
