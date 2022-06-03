 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exedence extends CI_Controller {
    
        function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('employee_model');
        $this->load->model('Bill_Customer_model');
        $this->load->model('unregistered_model');
        $this->load->model('job_assign_model');
        $this->load->model('Sms_model');
        $this->load->model('Box_Application_model');
        $this->load->model('Control_Number_model');
        $this->load->model('ExedenceModel');
        $this->load->model('E_reports_Model');
        
        if ($this->session->userdata('user_login_access') == false){
            redirect(base_ur());
        }
    }

    public function nontechnical_dashboard(){
    $data['service'] = $this->ExedenceModel->get_excedence_service();
    $data['request'] = $this->ExedenceModel->get_excedence_request();
    $data['countpending'] = $this->ExedenceModel-> count_pending_issues();
    $data['countreceived'] = $this->ExedenceModel-> count_received_issues();
    $data['countsolved'] = $this->ExedenceModel-> count_solved_issues();
    $data['countclosed'] = $this->ExedenceModel-> count_closed_issues();
    $data['countcancelation'] = $this->ExedenceModel-> count_cancelation_issues();
    $data['getincidents'] = $this->ExedenceModel->get_incident_performance();
    $this->load->view('ExedenceManagement/nontechnical_dashboard',$data);
    }


    public function list_issues(){
    $data['listregion']= $this->E_reports_Model->get_all_regions();
    $data['request'] = $this->ExedenceModel->get_excedence_request();
    $this->load->view('ExedenceManagement/list_issues',$data);
    }

 public function search_issues(){
 $fromdate = $this->input->get('fromdate');
 $todate = $this->input->get('todate');
 $region = $this->input->get('region');
 $status = $this->input->get('status');
 $request = $this->input->get('request');
 $data['listregion']= $this->E_reports_Model->get_all_regions();
 $data['request'] = $this->ExedenceModel->get_excedence_request();
 $list = $this->ExedenceModel->find_issues($fromdate,$todate,$region,$status,$request);
 if(!empty($list)){
 $data['list'] = $this->ExedenceModel->find_issues($fromdate,$todate,$region,$status,$request);
 $this->load->view('ExedenceManagement/list_issues',$data);
} else {
$this->session->set_flashdata('feedback',"Results not found, Please try again!");
redirect("Exedence/list_issues");
}
}

public function accept_request(){
$issueid = base64_decode($this->input->get('I'));
$empid = $this->session->userdata('user_emid');
$receiveddate = date('Y-m-d');
$data = array();
$data = array('receivedby'=>$empid,'received_date'=>$receiveddate,'issue_status'=>'Received'); 
$this->ExedenceModel->update_issue($data,$issueid);

$this->session->set_flashdata('success','Request has been successfully Received!');
redirect($this->agent->referrer());
}

public function rm_confirm_request(){
$issueid = base64_decode($this->input->get('I'));
$status = base64_decode($this->input->get('S'));
$empid = $this->session->userdata('user_emid');
$receiveddate = date('Y-m-d');

$data = array();
$data = array('rm_code'=>$empid,'rm_approveddate'=>$receiveddate,'issue_status'=>$status); 
$this->ExedenceModel->update_issue($data,$issueid);

$this->session->set_flashdata('success','Request has been '.$status);
redirect($this->agent->referrer());
}

public function bop_confirm_request(){
$issueid = base64_decode($this->input->get('I'));
$status = base64_decode($this->input->get('S'));
$empid = $this->session->userdata('user_emid');
$receiveddate = date('Y-m-d');

$data = array();
$data = array('bop_code'=>$empid,'bop_approveddate'=>$receiveddate,'issue_status'=>$status); 
$this->ExedenceModel->update_issue($data,$issueid);

$this->session->set_flashdata('success','Request has been '.$status);
redirect($this->agent->referrer());
}

public function close_support(){
$issueid = base64_decode($this->input->get('I'));
$data = array();
$data = array('chart_status'=>'closed','issue_status'=>'Closed'); 
$this->ExedenceModel->update_issue($data,$issueid);

$this->session->set_flashdata('success','Support has been successfully Closed!');
redirect($this->agent->referrer());
}

public function solve_request(){
$issueid = $this->input->post('issueid');
$description = $this->input->post('desc');
$empid = $this->session->userdata('user_emid');
$solveddate = date('Y-m-d');

$data = array();
$data = array('solved_date'=>$solveddate,'issue_status'=>'Solved'); 
$this->ExedenceModel->update_issue($data,$issueid);

$Save = array();
$Save = array('solution_description'=>$description,'solvedby'=>$empid,'issueid'=>$issueid); 
$this->ExedenceModel->save_issue_solution($Save);

$this->session->set_flashdata('success','Request has been successfully Replied!');
redirect($this->agent->referrer());
}

public function reply_solution(){
$issueid = $this->input->post('issueid');
$description = $this->input->post('desc');
$empid = $this->session->userdata('user_emid');

$Save = array();
$Save = array('solution_description'=>$description,'solvedby'=>$empid,'issueid'=>$issueid); 
$this->ExedenceModel->save_issue_solution($Save);

$this->session->set_flashdata('success','Request has been successfully Replied!');
redirect($this->agent->referrer());
}

    public function save_issue(){
    $region = $this->session->userdata('user_region');
    $branch = $this->session->userdata('user_branch');
    $usertype = $this->session->userdata('user_type');
    $empid = $this->session->userdata('user_emid');
    $department = $this->session->userdata('departmentid');
    $designation = $this->session->userdata('designationid');

    $service = $this->input->post('service');
    $request = $this->input->post('request');
    $description = $this->input->post('desc');

    if($request=="Cancelation Incident"){
    $status ="PendingRequest";
    } else {
    $status = "Pending";
    }

   
    $data = array();
    $data = array('serviceid'=>$service,'description'=>$description,'region'=>$region,'branch'=>$branch,'usertype'=>$usertype,'department'=>$department,'designation'=>$designation,'createdby'=>$empid,'request_type'=>$request,'issue_status'=>$status);
    $this->ExedenceModel->save_issue($data);
    $this->session->set_flashdata('success','Your request has been successfully submitted!, Its take few minutes to get feedback');
    redirect($this->agent->referrer());
    }





}