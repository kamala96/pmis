 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imprest extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
		$this->load->model('imprest_model');
    }
    
	public function index()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
			$this->load->view('login');
	}
    public function expenditure_List()
	{
		if ($this->session->userdata('user_login_access') != false){

				$data['imprest_expenditure']= $this->imprest_model->getAllImprestExpenditure();
				$this->load->view('imprest/expenditure_list',$data);
		}else{
			redirect(base_url());
		}
	}
	public function expenditure_Application()
	{
		if ($this->session->userdata('user_login_access') != false){
			$id = $this->session->userdata('user_login_id');
			$data['basic'] = $this->employee_model->GetBasic($id);
			$year = date('Y');

			$getref = $this->imprest_model->getRefferences($year);

			$n = $getref->number + 1;
			$number = array();
			$number = array('number'=>$n,'year'=>date('Y'));
			$this->imprest_model->addRefferences($number);
			
			$data['reff'] = $this->imprest_model->getRefferences($year);

			$this->load->view('imprest/expenditure_application_form',$data);

		}else{
			redirect(base_url());
		}
	}
	public function add_expenditure()
	{
		if ($this->session->userdata('user_login_access') != false){

			$id = $this->session->userdata('user_login_id');
			$em_code = $id;
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
			$imp_id = $this->input->post('imp_id');

			if (empty($imp_id)) {

			$data = array();
			$data = array(
						'em_id'=>$em_code,
						'date_created'=>$date,
						'exp_from'=>$from,
						'exp_to'=>$to,
						'usf'=>$head_dep,
						'app_exp'=>$amount_request,
						'sum_exp'=>$exp_sum,
						'exp_type'=>$expenditure_type,
						'exp_for'=>$for,
						'refferences'=>$reff,
						'regards'=>$regards,
						'exp_status'=>'isNON'
			);
			$this->imprest_model->save_expenditure_request($data);
			echo 'Successfully Added';

			}else{

			$data = array();
			$data = array(
						'em_id'=>$em_code,
						'date_created'=>$date,
						'exp_from'=>$from,
						'exp_to'=>$to,
						'usf'=>$head_dep,
						'app_exp'=>$amount_request,
						'sum_exp'=>$exp_sum,
						'exp_type'=>$expenditure_type,
						'exp_for'=>$for,
						'refferences'=>$reff,
						'regards'=>$regards,
						'exp_status'=>'isNON'
			);
			$this->imprest_model->update_expenditure_request($imp_id,$data);
			echo 'Successfully Updated';
			}
			
		}else{
			redirect(base_url());
		}
	}
	public function verify_expenditure(){
    	if ($this->session->userdata('user_login_access') != false){

    		$id = base64_decode($this->input->get('I'));
    		$data['expenditure'] = $this->imprest_model->getImprestById($id);
    		$this->load->view('imprest/verify_expenditure',$data);

		}else{
    		redirect(base_url());
		}
	}
	
	public function update_expenditure_status(){

		if ($this->session->userdata('user_login_access') != false){

			$status = $this->input->post('status');
			$reason = $this->input->post('reason');
			$imp_id  = $this->input->post('imp_id');
			$id = $imp_id;
			$expenditure = $this->imprest_model->getImprestById($id);
			$check = $expenditure->exp_status;
			if ($this->session->userdata('user_type') == 'ACCOUNTANT'){

				if ($status == 'Approve') {
					
					$data = array();
					$data = array('exp_status' => 'isACC');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('exp_status' => 'isREJ');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Rejected";
				}

			}elseif ($this->session->userdata('user_type') == 'CRM') {

				if ($check == 'isACC') {

					if ($status == 'Approve') {
					
					$data = array();
					$data = array('exp_status' => 'isGMCRM');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('exp_status' => 'isREJ');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Rejected";
				}
				}else{
					echo "Please Wait For Accountant to Approve";
				}
				

			}elseif ($this->session->userdata('user_type') == 'BOP') {

				if ($check == 'isACC') {
					
					if ($status == 'Approve') {
					
					$data = array();
					$data = array('exp_status' => 'isGMBOP');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('exp_status' => 'isREJ');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Rejected";
				}

				}else{
					echo "Please Wait For Accountant to Approve";
				}
				

			}elseif ($this->session->userdata('user_type') == 'PMG') {

				if ($check == 'isGMCRM' || $check == 'isGMBOP' || $check == 'isPMG') {
					
					if ($status == 'Approve') {
					
					$data = array();
					$data = array('exp_status' => 'isPMG');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('exp_status' => 'isREJ');
					$this->imprest_model->update_status($imp_id,$data);
					echo "Successfully Rejected";
				}

				}else{
					echo "Please Wait For GMCRM/GMBOP to Approve";
				}
				
			}else{

				echo "Your not supposed to athorize";
			}


		}else{
			redirect(base_url());
		}
	}
	public function rejected_expenditure(){
		if ($this->session->userdata('user_login_access') != false){

			$id = base64_decode($this->input->get('I'));
			$data['expenditure'] = $this->imprest_model->getImprestById($id);
			$this->load->view('imprest/rejected_expenditure',$data);

		}else{
			redirect(base_url());
		}
	}

	public function cancel_imprest(){
		if ($this->session->userdata('user_login_access') != false){

			$id = $this->input->post('imp_id');

			$data = array();
			$data = array('exp_status'=>'isCAN');
			$this->imprest_model->cancelImprestById($id,$data);

			echo 'Successfully Canceled';
			

		}else{

			redirect(base_url());
		}
	}

	public function edit_expenditure(){
    	if ($this->session->userdata('user_login_access') != false){

    		$id = base64_decode($this->input->get('I'));
    		$data['expenditure'] = $this->imprest_model->getImprestById($id);
    		$this->load->view('imprest/edit_expenditure',$data);

		}else{
    		redirect(base_url());
		}
	}

	public function  imprest_subsistence_form()
	{
		if($this->session->userdata('user_login_access') != False) {
			$data['imp_id'] = base64_decode($this->input->get('I'));
			$id = base64_decode($this->input->get('em_id'));
			$data['basic'] = $this->employee_model->GetBasic($id);
			//$data['imprestList'] = $this->employee_model->getImprestListById2($id);
			$this->load->view('imprest/imprest_subsistence_form',$data);
		}else{
			redirect(base_url());
		}
	}

	public function  save_imprest_request()
	{
		if($this->session->userdata('user_login_access') != False) {
			
			$imp_id = $this->input->post('imp_id');
			$allowance = $this->input->post('subsistence_allowance');
			$leaving_date = $this->input->post('leaving_date');
			$date_returning = $this->input->post('date_returning');
			$place_visited = $this->input->post('place_visited');
			$safari_purpose = $this->input->post('safari_purpose');
			$days = $this->input->post('days');
			$sub_amount = $this->input->post('sub_amount');
			$inc_amount = $this->input->post('inc_amount');
			$fare_type = $this->input->post('fare_type');
			$fare_amount = $this->input->post('fare_amount');
			$vote_code = $this->input->post('vote_code');
			$vote_amount = $this->input->post('vote_amount');
			$imps_id       = $this->input->post('imps_id');
			$comments       = $this->input->post('comments');
			$state_letter   = $this->input->post('state_letter');
			$letter_no       = $this->input->post('letter_no');

            //check if have imprest not paid


	if (empty($imps_id)) {

			if($_FILES['state_letter']['name']){
            $file_name = $_FILES['state_letter']['name'];
			$fileSize = $_FILES["state_letter"]["size"]/1024;
			$fileType = $_FILES["state_letter"]["type"];
			$new_file_name='';
            $new_file_name .= 'subsistence'.rand(1000,2000);

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "40480000"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('state_letter')) {
                echo $this->upload->display_errors();
			}
   
			else {
                $path = $this->upload->data();
                $img_url = $path['file_name'];

                $data = array();
			    $data = array(
			    'imp_id'=>$imp_id,
				'rate_per_day'=>$leaving_date,
				'date_leaving'=>$leaving_date,
				'date_returning'=>$date_returning,
				'visited_place'=>$place_visited,
				'reason'=>$safari_purpose,
				'days'=>$days,
				'sub_amount'=>$sub_amount,
				'inc_amount'=>$inc_amount,
				'fare_type'=>$fare_type,
				'fare_amount'=>$fare_amount,
				'vote_code'=>$vote_code,
				'vote_amount'=>$vote_amount,
				'letter_no'=>$letter_no,
				'state_letter'=>$file_name,
				'comments'=>$comments,
				'imps_status'=>'isNON');

			$this->imprest_model->save_imprest_form_request($data);
			echo 'Successfully Added';

			}
        }else{

        	$data = array();
			$data = array(

				'imp_id'=>$imp_id,
				'rate_per_day'=>$leaving_date,
				'date_leaving'=>$leaving_date,
				'date_returning'=>$date_returning,
				'visited_place'=>$place_visited,
				'reason'=>$safari_purpose,
				'days'=>$days,
				'sub_amount'=>$sub_amount,
				'inc_amount'=>$inc_amount,
				'fare_type'=>$fare_type,
				'fare_amount'=>$fare_amount,
				'vote_code'=>$vote_code,
				'vote_amount'=>$vote_amount,
				'imps_status'=>'isNON');

			$this->imprest_model->save_imprest_form_request($data);
			echo 'Successfully Added';
        }
			

	}else{

			if($_FILES['state_letter']['name']){
            $file_name = $_FILES['state_letter']['name'];
			$fileSize = $_FILES["state_letter"]["size"]/1024;
			$fileType = $_FILES["state_letter"]["type"];
			$new_file_name='';
            $new_file_name .= 'subsistence'.rand(1000,2000);

            $config = array(
                'file_name' => $new_file_name,
                'upload_path' => "./assets/images/users",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => False,
                'max_size' => "40480000"
            );
    
            $this->load->library('Upload', $config);
            $this->upload->initialize($config);                
            if (!$this->upload->do_upload('state_letter')) {
                echo $this->upload->display_errors();
			}
   
			else {
                $path = $this->upload->data();
                $img_url = $path['file_name'];
				
				$path = $this->upload->data();
                $img_url = $path['file_name'];

                $data = array();
			    $data = array(

				'rate_per_day'=>$leaving_date,
				'date_leaving'=>$leaving_date,
				'date_returning'=>$date_returning,
				'visited_place'=>$place_visited,
				'reason'=>$safari_purpose,
				'days'=>$days,
				'sub_amount'=>$sub_amount,
				'inc_amount'=>$inc_amount,
				'fare_type'=>$fare_type,
				'fare_amount'=>$fare_amount,
				'vote_code'=>$vote_code,
				'vote_amount'=>$vote_amount,
				'letter_no'=>$letter_no,
				'state_letter'=>$file_name,
				'comments'=>$comments,
				'imps_status'=>'isNON');

				$this->imprest_model->edit_imprest_form_request($imps_id,$data);
				echo 'Successfully Updated';
			}

		}else{

			$data = array();
			$data = array(

				'rate_per_day'=>$leaving_date,
				'date_leaving'=>$leaving_date,
				'date_returning'=>$date_returning,
				'visited_place'=>$place_visited,
				'reason'=>$safari_purpose,
				'days'=>$days,
				'sub_amount'=>$sub_amount,
				'inc_amount'=>$inc_amount,
				'fare_type'=>$fare_type,
				'fare_amount'=>$fare_amount,
				'vote_code'=>$vote_code,
				'vote_amount'=>$vote_amount,
				'imps_status'=>'isNON');

				$this->imprest_model->edit_imprest_form_request($imps_id,$data);
				echo 'Successfully Updated';
		}	


	}
			

		}else{
			redirect(base_url());
		}
	}

	public function imprest_subsistence_List()
	{
		if ($this->session->userdata('user_login_access') != false){

				$data['imprest_expenditure']= $this->imprest_model->getAllImprestSubsistence();
				$this->load->view('imprest/imprest_susistence_list',$data);
		}else{
			redirect(base_url());
		}
	}

	public function cancel_imprest_subsistence()
	{
		if ($this->session->userdata('user_login_access') != false){

				$id = $this->input->post('imps_id');

				$data = array();
				$data = array('imps_status'=>'isCAN');
				$this->imprest_model->cancelImprestubsistenceById($id,$data);

				echo "Successfully Canceled";

		}else{
			redirect(base_url());
		}
	}

	public function edit_imprest_subsistence(){
    	if ($this->session->userdata('user_login_access') != false){

    		$id = base64_decode($this->input->get('I'));
    		$data['value'] = $this->imprest_model->getImprestSubsistenceById($id);
    		$this->load->view('imprest/imprest_subsistence_edit_form',$data);

		}else{
    		redirect(base_url());
		}
	}

	public function verify_imprest_subsistence(){
    	if ($this->session->userdata('user_login_access') != false){

    		$id = base64_decode($this->input->get('I'));
    		$data['value'] = $this->imprest_model->getImprestSubsistenceById($id);
    		$this->load->view('imprest/imprest_subsistence_verify_form',$data);

		}else{
    		redirect(base_url());
		}
	}

	public function verify_imprest_subsistence_status(){

		if ($this->session->userdata('user_login_access') != false){

			$status = $this->input->post('status');
			$reason = $this->input->post('reason');
			$imps_id  = $this->input->post('imps_id');
			$imp_id  = $this->input->post('imp_id');
			$id = $imps_id;
			$expenditure = $this->imprest_model->findImprestSubsistenceById($id);
			$check = $expenditure->imps_status;
			if ($this->session->userdata('user_type') == 'ACCOUNTANT'){

				if ($check == 'isPMG' || $check == 'isGMCRM' || $check == 'isGMBOP') {
					
					if ($status == 'Approve') {
					
					$data = array();
					$data = array('imps_status' => 'isACC');
					$this->imprest_model->update_status_imprest($imps_id,$data);

					$data1 = array();
					$data1 = array('exp_status' => 'isPAID');
					$this->imprest_model->update_status1($imp_id,$data1);

					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('imps_status' => 'isREJ');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Rejected";
				}
				}else{
				echo "Please Wait for PMG/GMCRM/GMBOP to Approve";
			}

			}elseif ($this->session->userdata('user_type') == 'HOD' || $this->session->userdata('user_type') == 'ADMIN') {


				if ($status == 'Approve') {
					
					$data = array();
					$data = array('imps_status' => 'isHOD');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('imps_status' => 'isREJ');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Rejected";
				}
				

			}elseif ($this->session->userdata('user_type') == 'CRM') {

				if ($check == 'isHOD') {
					if ($status == 'Approve') {
					
					$data = array();
					$data = array('imps_status' => 'isGMCRM');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('imps_status' => 'isREJ');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Rejected";
				}
				}else{

					echo 'Please Wait For HOD To Approve';
				}
				

			}elseif ($this->session->userdata('user_type') == 'BOP') {

					
				if ($check == 'isHOD') {
					if ($status == 'Approve') {
					
					$data = array();
					$data = array('imps_status' => 'isGMBOP');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('imps_status' => 'isREJ');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Rejected";
				}
				}else{

					echo 'Please Wait For HOD To Approve';
				}

				

			}elseif ($this->session->userdata('user_type') == 'PMG') {

					
				if ($check == 'isHOD') {

					if ($status == 'Approve') {
					
					$data = array();
					$data = array('imps_status' => 'isPMG');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Approved";

				}else{

					$data = array();
					$data = array('imps_status' => 'isREJ');
					$this->imprest_model->update_status_imprest($imps_id,$data);
					echo "Successfully Rejected";
				}

				}else{

					echo 'Please Wait For HOD To Approve';
				}

			}else{

				echo "Your not supposed to athorize";
			}


		}else{
			redirect(base_url());
		}
	}
}
