<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Collection_Report extends CI_Controller {
	
	    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('kpi_model');
		$this->load->model('Mail_box_callnote_model');
	    $this->load->model('ContractModel');
	    $this->load->model('Collection_Model');
	    $this->load->model('Box_Application_model');
	    $this->load->model('ContractModel');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
    }
	


public function report(){
if ($this->session->userdata('user_login_access') != false){
$this->load->view('E_reports/collection_report');
}
else{
redirect(base_url());
}
}

public function consolidated(){
if ($this->session->userdata('user_login_access') != false){
$this->load->view('E_reports/consolidated_report');
}
else{
redirect(base_url());
}
}

public function print_consolidated_report(){
$empid =  $this->session->userdata('user_emid');
$data['info'] = $this->ContractModel->get_employee_info($empid);

//Input date
$data['fromdate'] = $fromdate = $this->input->post('fromdate');
$data['todate'] = $todate = $this->input->post('todate');

if(!empty($fromdate)){
$data['employeelist'] = $this->Collection_Model->supervisor_employee_list();
$this->load->view('E_reports/consolidated_report',$data);
} else {
redirect('Collection_Report/consolidated');
}

}


public function print_collection_report(){
$empid =  $this->session->userdata('user_emid');
$emcode = $this->session->userdata('user_emcode');
$data['info'] = $this->ContractModel->get_employee_info($empid);

//Input date
$data['fromdate'] = $fromdate = $this->input->post('fromdate');
$data['todate'] = $todate = $this->input->post('todate');

if(!empty($fromdate)){

//Collection Reports
////////EMS CASH AND BILL TRANSACTIONS
$data['emscashlist'] = $this->Collection_Model->get_ems_employee_report($fromdate,$todate,$empid);
$data['emsbilllist'] = $this->Collection_Model->get_ems_employee_bill_report($fromdate,$todate,$empid);

///////////MAILS CASH AND BILL TRANSACTIONS
$data['mailcashlist'] = $this->Collection_Model->get_cash_mail_employee_report($fromdate,$todate,$empid);
$data['mailbilllist'] = $this->Collection_Model->get_bill_mail_employee_report($fromdate,$todate,$empid);

////////// /Delivery Registered (RDP,FPL)
$data['deliveryintlist'] = $this->Collection_Model->emp_list_registered_international_list_search($fromdate,$todate,$empid);

////////////Small Packets Delivery (FGN)
$data['smallpacketlist'] = $this->Collection_Model->employee_smallpacket_delivery_application_list($fromdate,$todate,$empid);

/////Box
$data['boxtranslist'] = $this->Collection_Model->get_box_listt($fromdate,$todate,$emcode);

///Sales of stamp
$data['stamptranslist'] = $this->Collection_Model->get_stamp_list($fromdate,$todate,$emcode);

///Lock Replacement Transaction List
$data['locktranslist'] = $this->Collection_Model->get_Keydeposity_list($fromdate,$todate,$emcode);

////AuthorityCard Transaction List
$data['authoritetranslist'] = $this->Collection_Model->get_AuthorityCard_list($fromdate,$todate,$emcode);

////Internet 
$data['internettranslist'] = $this->Collection_Model->get_Internet_list($fromdate,$todate,$emcode);

 //$this->load->library('Pdf');
 $this->load->view('E_reports/collection_report',$data);
 //$this->dompdf->loadHtml($html);
 //$this->dompdf->setPaper('A4','potrait');
 //$this->dompdf->render();
 //ob_end_clean();
 //$this->dompdf->stream($reportcode, array("Attachment"=>0));
} else {
redirect('Collection_Report/report');
}

}

public function track_jobs_collection_report(){
$empid =  $this->input->post('empid');
$data['info'] = $this->ContractModel->get_employee_info($empid);
$emcode = $data['info']->em_code;

//Input date
$data['fromdate'] = $fromdate = $this->input->post('fromdate');
$data['todate'] = $todate = $this->input->post('todate');

if(!empty($fromdate)){

//Collection Reports
////////EMS CASH AND BILL TRANSACTIONS
$data['emscashlist'] = $this->Collection_Model->get_ems_employee_report($fromdate,$todate,$empid);
$data['emsbilllist'] = $this->Collection_Model->get_ems_employee_bill_report($fromdate,$todate,$empid);

///////////MAILS CASH AND BILL TRANSACTIONS
$data['mailcashlist'] = $this->Collection_Model->get_cash_mail_employee_report($fromdate,$todate,$empid);
$data['mailbilllist'] = $this->Collection_Model->get_bill_mail_employee_report($fromdate,$todate,$empid);

////////// /Delivery Registered (RDP,FPL)
$data['deliveryintlist'] = $this->Collection_Model->emp_list_registered_international_list_search($fromdate,$todate,$empid);

////////////Small Packets Delivery (FGN)
$data['smallpacketlist'] = $this->Collection_Model->employee_smallpacket_delivery_application_list($fromdate,$todate,$empid);

/////Box
$data['boxtranslist'] = $this->Collection_Model->get_box_listt($fromdate,$todate,$emcode);

///Sales of stamp
$data['stamptranslist'] = $this->Collection_Model->get_stamp_list($fromdate,$todate,$emcode);

///Lock Replacement Transaction List
$data['locktranslist'] = $this->Collection_Model->get_Keydeposity_list($fromdate,$todate,$emcode);

////AuthorityCard Transaction List
$data['authoritetranslist'] = $this->Collection_Model->get_AuthorityCard_list($fromdate,$todate,$emcode);

////Internet 
$data['internettranslist'] = $this->Collection_Model->get_Internet_list($fromdate,$todate,$emcode);

 //$this->load->library('Pdf');
 $this->load->view('E_reports/track_job_collection_report_by_supervisor',$data);
 //$this->dompdf->loadHtml($html);
 //$this->dompdf->setPaper('A4','potrait');
 //$this->dompdf->render();
 //ob_end_clean();
 //$this->dompdf->stream($reportcode, array("Attachment"=>0));
} else {
redirect($this->agent->referrer());
}

}

public function track_emp_collection_report(){
$empid = base64_decode($this->input->get('I'));
$data['empid'] = $empid;
$this->session->set_userdata('getempid',$empid);
$this->load->view('E_reports/track_job_collection_report_by_supervisor',$data);
}


	
}