<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class E_reports extends CI_Controller {
	
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
	    $this->load->model('E_reports_Model');
	    $this->load->model('Box_Application_model');
	    $this->load->model('ContractModel');
		
		if ($this->session->userdata('user_login_access') == false){
			redirect(base_ur());
		}
    }
	


    


public function ems_reports()
{
if ($this->session->userdata('user_login_access') != false){
$data['design'] = $this->employee_model->getdesignation();
$data['listbranch']= $this->E_reports_Model->get_supervisor_braches();
$this->load->view('E_reports/supervisor_ems_cash_reports',$data);

}
else{
redirect(base_url());
}
}

public function pending_invoice()
{
if ($this->session->userdata('user_login_access') != false){
$data['design'] = $this->employee_model->getdesignation();
$data['listregion']= $this->E_reports_Model->get_user_regions();
$this->load->view('E_reports/pending_invoice',$data);
}
else{
redirect(base_url());
}
}

public function mails_pending_invoice()
{
if ($this->session->userdata('user_login_access') != false){
$data['design'] = $this->employee_model->getdesignation();
$data['listregion']= $this->E_reports_Model->get_user_regions();
$this->load->view('E_reports/mails_pending_invoice',$data);
}
else{
redirect(base_url());
}
}

public function billing_invoice_dashboard(){
$this->load->view('E_reports/billing_invoice_dashboard');
}


public function print_pending_invoice()
{

$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
$todate =  date("Y-m-d",strtotime($this->input->post('todate')));
$region =  $this->input->post('region');
$status =  $this->input->post('status');

if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
    redirect('E_reports/pending_invoice');
}

$data['fromdate'] = $fromdate;
$data['todate'] = $todate;
$data['status'] = $status;

$results = $this->E_reports_Model->get_pending_invoice($fromdate,$todate,$status);
$data['design'] = $this->employee_model->getdesignation();
if($results){
 $data['emslist'] = $this->E_reports_Model->pending_invoice_all_region($region);
 $this->load->library('Pdf');
 $html= $this->load->view('E_reports/print_pending_invoice_summary',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('pending-invoice-report'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));
}
else
{
$this->session->set_flashdata('feedback','Invoice report not found, Please try again..');
redirect($this->agent->referrer());
}

}

public function mails_print_pending_invoice(){

$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
$todate =  date("Y-m-d",strtotime($this->input->post('todate')));
$region =  $this->input->post('region');
$status =  $this->input->post('status');

if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
    redirect('E_reports/mails_pending_invoice');
}

$data['fromdate'] = $fromdate;
$data['todate'] = $todate;
$data['status'] = $status;

$results = $this->E_reports_Model->mails_get_pending_invoice($fromdate,$todate,$status);
$data['design'] = $this->employee_model->getdesignation();
if($results){
 $data['emslist'] = $this->E_reports_Model->pending_invoice_all_region($region);
 $this->load->library('Pdf');
 $html= $this->load->view('E_reports/mails_print_pending_invoice_summary',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('pending-invoice-report'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));
}
else
{
$this->session->set_flashdata('feedback','Invoice report not found, Please try again..');
redirect($this->agent->referrer());
}

}


public function regions_revenue_ems_reports()
{
if ($this->session->userdata('user_login_access') != false){
$data['design'] = $this->employee_model->getdesignation();
$data['listbranch']= $this->E_reports_Model->get_regions();
$this->load->view('E_reports/regions_revenue_ems_reports',$data);

}
else{
redirect(base_url());
}
}

public function mail_reports()
{
if ($this->session->userdata('user_login_access') != false){
$data['design'] = $this->employee_model->getdesignation();
$this->load->view('E_reports/supervisor_mails_cash_reports',$data);

}
else{
redirect(base_url());
}
}

public function list_revenue_reports()
{
if ($this->session->userdata('user_login_access') != false){
$data['design'] = $this->employee_model->getdesignation();
$data['list'] = $this->E_reports_Model->list_download_history();
$this->load->view('E_reports/list_revenue_reports',$data);
}
else{
redirect(base_url());
}
}

//EMS

public function retrieve_ems_report()
{

$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
$todate =  date("Y-m-d",strtotime($this->input->post('todate')));
$branchid = $this->input->post('branch');

if($fromdate=='1970-01-01' || $todate=='1970-01-01' || $branchid==''){
    redirect('E_reports/ems_reports');
}

$data['fromdate'] = $fromdate;
$data['todate'] = $todate;
$results = $this->E_reports_Model->retrieve_branch($branchid);
$data['design'] = $this->employee_model->getdesignation();
$data['listbranch']= $this->E_reports_Model->get_supervisor_braches();
if($results){
$data['emslist'] = $this->E_reports_Model->retrieve_branch($branchid);
$this->load->view('E_reports/supervisor_ems_cash_reports',$data);
}
else
{
$this->session->set_flashdata('feedback','Please! report not found, Please try again..');
redirect($this->agent->referrer());
}

}
//END EMS

public function retrieve_region_ems_report()
{


$fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
$todate =  date("Y-m-d",strtotime($this->input->post('todate')));
$regionid = $this->input->post('region');

if($fromdate=='1970-01-01' || $todate=='1970-01-01' || $regionid==''){
    redirect('E_reports/regions_revenue_ems_reports');
}

$data['fromdate'] = $fromdate;
$data['todate'] = $todate;
$results = $this->E_reports_Model->retrieve_regions($regionid);
 $data['design'] = $this->employee_model->getdesignation();
 $data['listbranch']= $this->E_reports_Model->get_regions();
if($results){
$data['emslist'] = $this->E_reports_Model->retrieve_regions($regionid);
//$this->load->view('E_reports/regions_revenue_ems_reports',$data);

 $this->load->library('Pdf');
 // instantiate and use the dompdf class
 //$dompdf = new Dompdf();
 $html= $this->load->view('E_reports/download_regions_ems_revenue_report',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','landscape');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream('revenuereport'.date('d-m-Y').'.pdf', array("Attachment"=>FALSE));
 //file_put_contents('revenue-collection-report-'.date("Y-m-d").'.pdf', $this->dompdf->output());
//$randomdata = rand();
//$output = $this->dompdf->output();
//$fileName = 'EMS-revenue-collection-report-'.date("Y-m-d").'-'.$randomdata.'.pdf';
//file_put_contents('assets/revenue_collection_reports/'.$fileName, $output);

}
else
{
$this->session->set_flashdata('feedback','Please! report not found, Please try again..');
redirect($this->agent->referrer());
}

}


public function cron_ems_report()
{

$date = date("Y-m-d",strtotime($this->input->post('date')));
$fromdate =  date("Y-m-d",strtotime($this->input->post('fromdate')));
$todate =  date("Y-m-d",strtotime($this->input->post('todate')));
$month =  date("m",strtotime($this->input->post('month')));
$year =  date("Y",strtotime($this->input->post('month')));

$report =  $this->input->post('report');
$regionid = $this->input->post('region');

$data['emslist'] = $this->E_reports_Model->retrieve_regions($regionid);

$data['date'] = $date;
$data['fromdate'] = $fromdate;
$data['todate'] = $todate;
$data['month'] = $month;
$data['year'] = $year;
$data['report'] = $report;


 $this->load->library('Pdf');
 $html= $this->load->view('E_reports/download_regions_ems_revenue_report',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','landscape');
 $this->dompdf->render();
 ob_end_clean();
$randomdata = rand();
$output = $this->dompdf->output();
$fileName = 'EMS-revenue-collection-report-'.date("Y-m-d").'-'.$randomdata.'.pdf';
file_put_contents('assets/revenue_collection_reports/'.$fileName, $output);

echo "<a href=../assets/revenue_collection_reports/".$fileName."> Downlaod " .$fileName." </a> ";

//Download History
$this->E_reports_Model->download_history($fileName,$report);

}

public function summary_sheet_ems()
{
$empid =  $this->session->userdata('user_emid');
$acc_no = base64_decode($this->input->get('acc_no'));
$data['month'] = $month = $this->input->get('month');
$data['date'] = $date = $this->input->get('date');

$this->session->set_userdata('account',$acc_no);
$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
$data['emslist'] = $list=$this->E_reports_Model->get_credit_customer_list_byAccnoMonth($acc_no,$month,$date);
$data['info'] = $this->ContractModel->get_employee_info($empid);

 $this->load->library('Pdf');
 $html= $this->load->view('E_reports/ems_summary_bill_sheet',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream($acc_no, array("Attachment"=>0));
}

public function summary_sheet_ems_excel(){
$empid =  $this->session->userdata('user_emid');
$acc_no = base64_decode($this->input->get('acc_no'));
$data['month'] = $month = $this->input->get('month');
$data['date'] = $date = $this->input->get('date');

$this->session->set_userdata('account',$acc_no);
$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
$data['emslist'] = $list=$this->E_reports_Model->get_credit_customer_list_byAccnoMonth($acc_no,$month,$date);
$data['info'] = $this->ContractModel->get_employee_info($empid);


 $this->load->view('E_reports/ems_summary_bill_excel_sheet',$data);
}


public function summary_breakdown_ems(){
$empid =  $this->session->userdata('user_emid');
$acc_no = base64_decode($this->input->get('acc_no'));
$data['month'] = $month = $this->input->get('month');
$data['date'] = $date = $this->input->get('date');
$data['accno'] = $acc_no;

$this->session->set_userdata('account',$acc_no);
$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
$data['emslist'] = $this->E_reports_Model->breakdown_credit_customer_list_byAccnoMonth($acc_no,$month,$date);
$data['info'] = $this->ContractModel->get_employee_info($empid);

 $this->load->library('Pdf');
 $html= $this->load->view('E_reports/breakdown_ems_bill_sheet',$data,TRUE);
 $this->dompdf->loadHtml($html);
 $this->dompdf->setPaper('A4','potrait');
 $this->dompdf->render();
 ob_end_clean();
 $this->dompdf->stream($acc_no, array("Attachment"=>0));
}
	
	
public function summary_sheet_ems_excel_ttcl(){
$empid =  $this->session->userdata('user_emid');
$acc_no = base64_decode($this->input->get('acc_no'));
$data['month'] = $month = $this->input->get('month');
$data['date'] = $date = $this->input->get('date');

$this->session->set_userdata('account',$acc_no);
$data['custinfo'] = $this->Box_Application_model->get_bill_cust_details($acc_no);
$data['emslist'] = $list=$this->E_reports_Model->get_ttcl_credit_customer_list_byAccnoMonth($acc_no,$month,$date);
$data['info'] = $this->ContractModel->get_employee_info($empid);


 $this->load->view('E_reports/ems_summary_bill_excel__ttcl_sheet',$data);
}
	
	
}