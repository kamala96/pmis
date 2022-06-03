 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterCancelation extends CI_Controller {
    
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
        $this->load->model('MasterCancelation_Model');
        $this->load->model('E_reports_Model');
        $this->load->model('ExedenceModel');
        
        if ($this->session->userdata('user_login_access') == false){
            redirect(base_ur());
        }
    }

    public function dashboard(){
    $this->load->view('MasterCancelation/dashboard');
    }

    public function find_transactiond(){
    $this->load->view('MasterCancelation/list_transactions');
    }

    public function find_transaction(){
    $code = $this->input->get('code');
    $emstranslist = $this->MasterCancelation_Model->transaction($code);
    if(!empty($emstranslist)){
    //Correct 
    $data['emstranslist'] = $this->MasterCancelation_Model->transaction($code);
    $this->load->view('MasterCancelation/dashboard',$data);
    } else {
    $mailtranslist = $this->MasterCancelation_Model->register_transaction($code);
    if(!empty($mailtranslist)){
    $data['mailtranslist'] = $this->MasterCancelation_Model->register_transaction($code);
    $this->load->view('MasterCancelation/dashboard',$data);
    } else {
    /////////Wrong Information
    $this->session->set_flashdata('feedback',"Barcode / Control Number not found, Please try again!");
    redirect("MasterCancelation/dashboard");
    }
    }
    }

    public function find_transaction_report(){
    $fromdate = $this->input->post('fromdate');
    $todate = $this->input->post('todate');
    $status = $this->input->post('status');
 
   
   $emstranslist = $this->MasterCancelation_Model->transaction_cancelation($fromdate,$todate);
   $mailtranslist = $this->MasterCancelation_Model->register_transaction_cancelation($fromdate,$todate);

    if(!empty($emstranslist) || !empty($dmailtranslist)){

    if($status=="EMS"){
     $data['emstranslist'] = $this->MasterCancelation_Model->transaction_cancelation($fromdate,$todate);
    $this->load->view('MasterCancelation/list_transactions',$data);
    } else {
     $data['mailtranslist'] = $this->MasterCancelation_Model->register_transaction_cancelation($fromdate,$todate);
      $this->load->view('MasterCancelation/list_transactions',$data);
    }

    } else {
    $this->session->set_flashdata('feedback',"Cancelation Report not found, Please try again!");
    redirect("MasterCancelation/find_transactiond");
    }

    
    }

    public function cancel_transaction(){
    $transid = $this->input->post('transid');
    $reason = $this->input->post('reason');
    $empid = $this->session->userdata('user_login_id');

    ///Fetch transaction data
    $info = $this->MasterCancelation_Model->get_transaction($transid);
    ///Copy Transaction
    

     $data = array();
     $data = array(
    'id'=>@$info->id,
    'transactiondate'=>@$info->transactiondate,
    'serial'=>@$info->serial,
    'CustomerID'=>@$info->CustomerID,
    'Customer_mobile'=>@$info->Customer_mobile,
    'region'=>@$info->region,
    'district'=>@$info->district,
    'transactionstatus'=>@$info->transactionstatus,
    'paymentdate'=>@$info->paymentdate,
    'bill_status'=>@$info->bill_status,
    'billid'=>@$info->billid,
    'receipt'=>@$info->receipt,
    'paidamount'=>@$info->paidamount,
    'paychannel'=>@$info->paychannel,
    'PaymentFor'=>@$info->PaymentFor,
    'status'=>@$info->status,
    'Barcode'=>@$info->Barcode,
    'cancel_reason'=>@$reason,
    'canceledby'=>@$empid);
    $this->MasterCancelation_Model->copy_transaction($data);


    ////Delete Transaction
    $this->MasterCancelation_Model->delete_transaction($transid);

    $this->session->set_flashdata('success',"Transaction has been canceled");
    redirect($this->agent->referrer());

    
    }

    public function cancel_register_transaction(){
    $transid = $this->input->post('transid');
    $reason = $this->input->post('reason');
    $empid = $this->session->userdata('user_login_id');

    ///Fetch transaction data
    $info = $this->MasterCancelation_Model->get_register_transaction($transid);
    ///Copy Transaction
    

     $data = array();
     $data = array(
    't_id'=>@$info->t_id,
    'transactiondate'=>@$info->transactiondate,
    'serial'=>@$info->serial,
    'register_id'=>@$info->register_id,
    'bill_status'=>@$info->bill_status,
    'transactionstatus'=>@$info->transactionstatus,
    'paymentdate'=>@$info->paymentdate,
    'billid'=>@$info->billid,
    'receipt'=>@$info->receipt,
    'paidamount'=>@$info->paidamount,
    'paychannel'=>@$info->paychannel,
    'status'=>@$info->status,
    'Barcode'=>@$info->Barcode,
    'cancel_reason'=>@$reason,
    'canceledby'=>@$empid);
    $this->MasterCancelation_Model->copy_register_transaction($data);


    ////Delete Transaction
    $this->MasterCancelation_Model->delete_register_transaction($transid);

    $this->session->set_flashdata('success',"Transaction has been canceled");
    redirect($this->agent->referrer());
    }
 

}