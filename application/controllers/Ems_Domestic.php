<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ems_Domestic extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Box_Application_model');
        $this->load->model('billing_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Sms_model');
        $this->load->model('dashboard_model');
        $this->load->model('Pcum_model');
        $this->load->model('Parcel_model');
        $this->load->model('unregistered_model');
        $this->load->model('Supervisor_ViewModel');

    }
    
    public function cash_dashboard(){
        if ($this->session->userdata('user_login_access') != false) {

            $this->session->set_userdata('heading','Domestic Cash Dashboard');
            $this->load->view('domestic_ems/domestic-ems-dashboard');
        } else {
         redirect(base_url());
     }

 }

 public function mct_cash_dashboard(){
    if ($this->session->userdata('user_login_access') != false) {
        $this->session->set_userdata('heading','Domestic Cash Dashboard');
        $this->load->view('domestic_ems/mct_transactions');
    } else {
     redirect(base_url());
 }

}

public function mct_trans_results(){
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/mct_cash_dashboard');
        }

        $data['design'] = $this->employee_model->getdesignation();
        $results = $this->Box_Application_model->mct_transaction_list($fromdate,$todate,$status);
        if($results){
            $data['list'] = $this->Box_Application_model->mct_transaction_list($fromdate,$todate,$status);
            $this->load->view('domestic_ems/mct_transactions',$data);
        }
        else{
            $this->session->set_flashdata('message','Transcation not found, Please try again!');
            redirect("Ems_Domestic/mct_cash_dashboard");
        }

    }
    else{
        redirect(base_url());
    }
}


public function employee_view_reports()
{
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_reports',$data);

    }
    else{
        redirect(base_url());
    }
}

public function employee_smallpacket_delivery(){
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_deliver_smallpacket_report',$data);

    }
    else{
        redirect(base_url());
    }
}

public function employee_mail_view_reports()
{
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_mail_reports',$data);

    }
    else{
        redirect(base_url());
    }
}

public function deliver_int_report()
{
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_deliver_int_report',$data);

    }
    else{
        redirect(base_url());
    }
}

public function track_deliver_int_report()
{
    if ($this->session->userdata('user_login_access') != false){
        $emcode = base64_decode($this->input->get('I'));
        $this->session->set_userdata('getempcode',$emcode);
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/track_emp_deliver_int_report',$data);

    }
    else{
        redirect(base_url());
    }
}

public function track_mails_emp_report()
{
    if ($this->session->userdata('user_login_access') != false){
        $empid = base64_decode($this->input->get('I'));
        $this->session->set_userdata('getempid',$empid);
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/track_employee_mail_reports',$data);

    }
    else{
        redirect(base_url());
    }
}

public function track_ems_emp_report(){
    if ($this->session->userdata('user_login_access') != false){
        $empid = base64_decode($this->input->get('I'));
        $this->session->set_userdata('getempid',$empid);
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/track_emp_ems_report',$data);
    }
    else{
        redirect(base_url());
    }
}

public function track_emp_smallpacket_transaction(){
    if ($this->session->userdata('user_login_access') != false){
        $empid = base64_decode($this->input->get('I'));
        $this->session->set_userdata('getempid',$empid);
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/track_emp_deliver_smallpacket_report',$data);
    }
    else{
        redirect(base_url());
    }
}

public function track_mails_emp_trans_results(){
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');
        $empid = $this->input->post('empid');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/track_mails_emp_report');
        }

        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['design'] = $this->employee_model->getdesignation();
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['status'] = $status;
        $link = base64_encode($this->session->userdata('getempid'));


        if($status=="Paid" || $status="NotPaid"){

//Cash Transactions
            $results = $this->Box_Application_model->status_track_mail_emp_transaction($fromdate,$todate,$status,$empid);
            if($results){
                $data['cashlist'] = $this->Box_Application_model->status_track_mail_emp_transaction($fromdate,$todate,$status,$empid);
                $this->load->view('domestic_ems/track_employee_mail_reports',$data);
            }
            else{
                $this->session->set_flashdata('message','Transcation not found, Please try again!');
                redirect("Ems_Domestic/track_mails_emp_report/?I=$link");
            }

        }
        else{
//Bill Transactions
            $results = $this->Box_Application_model->track_mail_emp_transaction($fromdate,$todate,$status,$empid);
            if($results){
                $data['listbill'] = $this->Box_Application_model->track_mail_emp_transaction($fromdate,$todate,$status,$empid);
                $this->load->view('domestic_ems/track_employee_mail_reports',$data);
            }
            else{
                $this->session->set_flashdata('message','Transcation not found, Please try again!');
                redirect("Ems_Domestic/track_mails_emp_report/?I=$link");
            }
        }


    }
    else{
        redirect(base_url());
    }
}


public function track_deliver_smallpacket_trans_results(){
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');
        $empid = $this->input->post('empid');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/track_emp_smallpacket_transaction');
        }

        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['design'] = $this->employee_model->getdesignation();
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['status'] = $status;


        $results = $this->unregistered_model->track_employee_smallpacket_delivery_application_list($fromdate,$todate,$status,$empid);
        if($results){
            $data['list'] = $this->unregistered_model->track_employee_smallpacket_delivery_application_list($fromdate,$todate,$status,$empid);
            $this->load->view('domestic_ems/track_emp_deliver_smallpacket_report',$data);
        }
        else{
            echo $link = base64_encode($this->session->userdata('getempid'));
            $this->session->set_flashdata('message','Transcation not found, Please try again!');
            redirect("Ems_Domestic/track_emp_smallpacket_transaction?I=$link");
        }

    }
    else{
        redirect(base_url());
    }
}


public function track_ems_emp_trans_results(){
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');
        $empid = $this->input->post('empid');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/track_ems_emp_report');
        }

        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['design'] = $this->employee_model->getdesignation();
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['status'] = $status;
        echo $link = base64_encode($this->session->userdata('getempid'));


        if($status=="Paid" || $status=="NotPaid"){

//Cash Transactions
            $results = $this->Box_Application_model->track_ems_transaction_list($fromdate,$todate,$status,$empid);
            if($results){
                $data['cashlist'] = $this->Box_Application_model->track_ems_transaction_list($fromdate,$todate,$status,$empid);
                $this->load->view('domestic_ems/track_emp_ems_report',$data);
            }
            else{
                $this->session->set_flashdata('message','Transcation not found, Please try again!');
                redirect("Ems_Domestic/track_ems_emp_report/?I=$link");
            }

        }
        else{
//Bill Transactions
            $results = $this->Box_Application_model->track_ems_transaction_list($fromdate,$todate,$status,$empid);
            if($results){
                $data['listbill'] = $this->Box_Application_model->track_ems_transaction_list($fromdate,$todate,$status,$empid);
                $this->load->view('domestic_ems/track_emp_ems_report',$data);
            }
            else{
                $this->session->set_flashdata('message','Transcation not found, Please try again!');
                redirect("Ems_Domestic/track_ems_emp_report/?I=$link");
            }
        }


    }
    else{
        redirect(base_url());
    }
}

public function deliver_int_report_results()
{
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/deliver_int_report');
        }


        $empid = $this->session->userdata('user_login_id');
        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['status'] = $status;
        $results = $this->unregistered_model->emp_list_registered_international_list_search($fromdate,$todate,$status);
        $data['design'] = $this->employee_model->getdesignation();
        if($results){
            $data['list'] = $this->unregistered_model->emp_list_registered_international_list_search($fromdate,$todate,$status);
            $this->load->view('domestic_ems/employee_deliver_int_report',$data);
        }
        else
        {
            $this->session->set_flashdata('message','Please! Delivery international report not found, Please try again..');
            redirect('Ems_Domestic/deliver_int_report');
        }
    }
    else{
        redirect(base_url());
    }
}


public function deliver_smallpacket_report_results(){
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/employee_smallpacket_delivery');
        }


        $empid = $this->session->userdata('user_login_id');
        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['status'] = $status;
        $results = $this->unregistered_model->employee_smallpacket_delivery_application_list($fromdate,$todate,$status);
        $data['design'] = $this->employee_model->getdesignation();
        if($results){
            $data['list'] = $this->unregistered_model->employee_smallpacket_delivery_application_list($fromdate,$todate,$status);
            $this->load->view('domestic_ems/employee_deliver_smallpacket_report',$data);
        }
        else
        {
            $this->session->set_flashdata('message','Please! Small Packets Delivery report not found, Please try again..');
            redirect('Ems_Domestic/employee_smallpacket_delivery');
        }
    }
    else{
        redirect(base_url());
    }
}


public function track_deliver_int_report_results()
{
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));
        $status =  $this->input->post('status');
        $emcode =  $this->input->post('emcode');

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect($this->agent->referrer());
        }

        $data['info'] = $this->ContractModel->get_employee_info_by_emcode($emcode);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['status'] = $status;
        $results = $this->unregistered_model->track_emp_list_registered_international_list_search($fromdate,$todate,$status,$emcode);
        $data['design'] = $this->employee_model->getdesignation();
        if($results){
            $data['list'] = $this->unregistered_model->track_emp_list_registered_international_list_search($fromdate,$todate,$status,$emcode);
            $this->load->view('domestic_ems/track_emp_deliver_int_report',$data);
        }
        else
        {
            $this->session->set_flashdata('message','Please! Delivery international report not found, Please try again..');
            redirect($this->agent->referrer());
        }
    }
    else{
        redirect(base_url());
    }
}

public function employee_reports_dashboard()
{
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_reports_dashboard',$data);

    }
    else{
        redirect(base_url());
    }
}

public function employee_trans_bill_reports()
{
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_bill_trans_reports',$data);

    }
    else{
        redirect(base_url());
    }
}

public function employee_trans_mail_bill_reports()
{
    if ($this->session->userdata('user_login_access') != false){
        $data['design'] = $this->employee_model->getdesignation();
        $this->load->view('domestic_ems/employee_mail_trans_reports',$data);
    }
    else{
        redirect(base_url());
    }
}

public function employee_report_results()
{
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/employee_view_reports');
        }


        $empid = $this->session->userdata('user_login_id');
        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $results = $this->Box_Application_model->get_ems_employee_report($fromdate,$todate);
        $data['design'] = $this->employee_model->getdesignation();
        if($results){
            $data['emslist'] = $this->Box_Application_model->get_ems_employee_report($fromdate,$todate);
            $this->load->view('domestic_ems/employee_reports',$data);
        }
        else
        {
            $this->session->set_flashdata('message','Please! Cash Transactions report not found, Please try again..');
            $this->load->view('domestic_ems/employee_reports',$data);
        }
    }
    else{
        redirect(base_url());
    }
}


public function employee_report_mail_results()
{
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/employee_mail_view_reports');
        }


        $empid = $this->session->userdata('user_login_id');
        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $results = $this->Box_Application_model->get_cash_mail_employee_report($fromdate,$todate);
        $data['design'] = $this->employee_model->getdesignation();
        if($results){
            $data['emslist'] = $this->Box_Application_model->get_cash_mail_employee_report($fromdate,$todate);
            $this->load->view('domestic_ems/employee_mail_reports',$data);
        }
        else
        {
            $this->session->set_flashdata('message','Please! Cash Transactions report not found, Please try again..');
            $this->load->view('domestic_ems/employee_mail_reports',$data);
        }
    }
    else{
        redirect(base_url());
    }
}

public function employee_bill_report_results()
{
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/employee_trans_bill_reports');
        }


        $empid = $this->session->userdata('user_login_id');
        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['design'] = $this->employee_model->getdesignation();
        $results = $this->Box_Application_model->get_ems_employee_bill_report($fromdate,$todate);
        if($results){
            $data['emslist'] = $this->Box_Application_model->get_ems_employee_bill_report($fromdate,$todate);
            $this->load->view('domestic_ems/employee_bill_trans_reports',$data);
        }
        else{
            $this->session->set_flashdata('message','Please! Bill Transactions report not found, Please try again..');
            $this->load->view('domestic_ems/employee_bill_trans_reports',$data);  
        }
    }
    else{
        redirect(base_url());
    }
}

public function cancel_delivery_int_transaction(){
    $serial = $this->input->post('serial');
    $reason = $this->input->post('reason');

//Retrieve Transaction of serial number
    $info = $this->unregistered_model->get_delivery_int_transaction_list($serial);
//copy processing
    $trans = array();
    $trans = array(
        'serial'=>$serial,
        'paidamount'=>$info->paidamount,
        'CustomerID'=>$info->CustomerID,
        'Customer_mobile'=>$info->Customer_mobile,
        'region'=>$info->region,
        'district'=>$info->district,
        'transactionstatus'=>$info->transactionstatus,
        'bill_status'=>$info->bill_status,
        'billid'=>$info->billid,
        'paidamount'=>$info->paidamount,
        'PaymentFor'=>$info->PaymentFor,
        'status'=>$info->status,
        'Barcode'=>$info->Barcode,
        'cancel_reason'=>$reason
    );
    $db2 = $this->load->database('otherdb', TRUE); 
    $db2->insert('transactions_cancel',$trans);

    echo $link = base64_encode($this->session->userdata('getempcode'));
//Delete Transaction
    $result = $this->unregistered_model->delete_delivery_int_transaction_list($serial);
    if($result){
        $this->session->set_flashdata('message','Transcation has been Successfully cancelled');
        redirect("Ems_Domestic/track_deliver_int_report/?I=$link");
    }
    else{
        $this->session->set_flashdata('message','Transcation Unuccessfully cancelled, Please try again!');
        redirect("Ems_Domestic/track_deliver_int_report/?I=$link");
    }

}

public function update_delivery_int_transaction(){
    $serial = $this->input->post('serial');
    $item = $this->input->post('item');
    $mobile = $this->input->post('mobile');
//Retrieve Transaction of serial number
    $info = $this->unregistered_model->get_delivery_int_transaction_list($serial);
               //Update Transaction Table
    $trans = array();
    $trans = array(
        'Customer_mobile'=>$mobile
    );
    $this->unregistered_model->update_delivery_int_transactions($serial,$trans);
                //update international registered
    $inttrans = array();
    $inttrans = array(
        'Customer_mobile'=>$mobile,
        'item'=>$item
    );
    $this->unregistered_model->update_delivery_int_registered_transactions($serial,$inttrans);

//Send SMS To the new customer
    $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$info->billid.' Kwaajili ya huduma ya Registered International  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($info->paidamount,2).'';
    $this->send_sms($mobile,$sms);

//End of SMS
    echo $link = base64_encode($this->session->userdata('getempcode'));
    $this->session->set_flashdata('message','Transcation has been Successfully updated, SMS sent to the customer mobile');
    redirect("Ems_Domestic/track_deliver_int_report/?I=$link");
}


public function employee_report_trans_mail_results()
{
    if ($this->session->userdata('user_login_access') != false){
        $fromdate = date("Y-m-d",strtotime($this->input->post('fromdate')));
        $todate =  date("Y-m-d",strtotime($this->input->post('todate')));

        if($fromdate=='1970-01-01' || $todate=='1970-01-01'){
            redirect('Ems_Domestic/employee_trans_mail_bill_reports');
        }

        $empid = $this->session->userdata('user_login_id');
        $data['info'] = $this->ContractModel->get_employee_info($empid);
        $data['fromdate'] = $fromdate;
        $data['todate'] = $todate;
        $data['design'] = $this->employee_model->getdesignation();
        $results = $this->Box_Application_model->get_bill_mail_employee_report($fromdate,$todate);
        if($results){
            $data['emslist'] = $this->Box_Application_model->get_bill_mail_employee_report($fromdate,$todate);
            $this->load->view('domestic_ems/employee_mail_trans_reports',$data);
        }
        else{
            $this->session->set_flashdata('message','Please! Bill Transactions report not found, Please try again..');
            $this->load->view('domestic_ems/employee_mail_trans_reports',$data);  
        }
    }
    else{
        redirect(base_url());
    }
}


public function employee_report()
{
    if ($this->session->userdata('user_login_access') != false)
    {
   //$emid = base64_decode($this->input->get('I'));
        $date = $this->input->post('date');
        $emid = $this->input->post('emid');
        $month = $this->input->post('month');
        //echo 'user emid '.$emid;
        if(empty($emid)){

           $data['emid'] =$emid = $this->session->userdata('user_login_id');
           $getInfo = $this->employee_model->GetBasic($emid);
           $data['users'] =$users = 'PF.'.$getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
           $data['branch'] = $loc =' - '.$getInfo->em_branch;
     //echo 'login emid '.$emid;
       }else{ $data['emid'] =$emid;}
       if(empty($date)){
   // echo 'empty '.$date;
          $tz = 'Africa/Nairobi';
          $tz_obj = new DateTimeZone($tz);
          $today = new DateTime(null, $tz_obj);
          $data['date'] =$date = $today->format('Y-m-d');
          $data['date2'] =$date ;

      }else{
       $data['date'] =$date;
       $data['date2'] =$date2;

   // echo 'not empty '.$date;
   }



        //$date = date('Y-m-d h:i:s');

   $results=$this->supervisortrackjob($emid,$date);
   $data['emslist'] = @$results;
   $sumt=0;
   foreach (@$results as $key => $value) {
    $value = (object)$value;
    $sumt=$sumt + $value->paidamount;
}
$data['total'] = $sumt;


   //$data['emslist'] = $this->Box_Application_model->get_ems_list_pending_supervisor($emid);
$data['emselect'] = $this->employee_model->emselect();
$data['agselect'] = $this->employee_model->emselectAgent();
$this->load->view('domestic_ems/employee_reports',@$data);
}
else{
    redirect(base_url());
}
}

public function employee_report_search2()
{
    if ($this->session->userdata('user_login_access') != false)
    {
   //$emid = base64_decode($this->input->get('I'));
        $date = $this->input->post('date');
        $date2 = $this->input->post('date2');
        $emid = $this->input->post('emid');
        $month = $this->input->post('month');
       // echo 'user emid '.$emid;
        if(empty($emid)){

    //$emid = $this->session->userdata('user_login_id');
     //echo 'login emid '.$emid;
     //echo 'not empty '.$date;

           $data['emid'] = $emid=   $this->session->userdata('user_login_id');
           $getInfo = $this->employee_model->GetBasic($emid);
           $users = 'PF.'.$getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                    //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
           $loc =' - '.$getInfo->em_branch;
       }else{
           $data['emid'] =$emid;

           $getInfo = $this->employee_model->GetBasic($emid);
           $users = 'PF.'.$getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                    //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
           $loc =' - '.$getInfo->em_branch;

       }
       if(empty($date)){
    //echo 'empty '.$date;
          $tz = 'Africa/Nairobi';
          $tz_obj = new DateTimeZone($tz);
          $today = new DateTime(null, $tz_obj);
          $data['date'] =$date = $today->format('Y-m-d');
          $data['date2'] =$date2 = $today->format('Y-m-d');

      }else{
        $data['date'] =$date;
        $data['date2'] =$date2;

    //echo 'not empty '.$date;
    }

        //$date = date('Y-m-d h:i:s');

    $results= @$this->supervisortrackjob_search($emid,$date2);
    $data['emslist'] =$emslist= @$results;
    $sumt=0;
    foreach (@$results as $key => $value) {
        $value = (object)$value;
        $sumt=$sumt + $value->paidamount;
    }
    $data['total'] =$total= $sumt;
    @$paidamount = @$sumt;

    $data['emselect'] =$emselect= $this->employee_model->emselect();
    $data['agselect'] =$agselect= $this->employee_model->emselectAgent();


    echo
    "

    <table  class='table table-hover table-bordered' cellspacing='0' width='100%'>
    <tr style='font-size:22px ;'' >
    <th colspan='3'><b>Operator Name: </b>". @$users. "</th>
    <th colspan='3'><b>Office : </b>". @$getInfo->em_branch. "</th>

    </tr>
    <tr style='font-size:22px ;'' >
    <th colspan='2'><b>Date: </b></th>
    <th colspan='2'><b>From : </b>".@$date."</th>
    <th colspan='2'><b>To : </b>".@$date2."</th>

    </tr>
    <tr style='font-size:22px ;'' >
    <th colspan='6'><b>Cash Transactions: </b></th>

    </tr>
    <br><br><br>


    </table>


    <table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
    <thead>

    <tr>
    <th>SN</th>

    <th>Control Number</th>
    <th>Barcode Number</th>
    <th>Weight</th>

    <th>Destination</th>
    <th>Price</th>
    <th>Vat</th>
    <th>Total</th>

    </tr>
    </thead>

    <tbody>";
    if (!empty($results)) {
        $sn=1;
        foreach (@$results as $value) {$value = (object)$value;
    // <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            echo '<tr>
            <td style=" border: 1px solid black;"> '.$sn.' </td>
            <td>'.$value->billid.'</td>
            <td>'.@$value->Barcode.'</td>
            <td>'.@$value->weight.'</td>
            <td>'.$value->branch.'</td>
            <td>'.number_format(($value->paidamount-$value->paidamount*0.18),2).'</td>
            <td>'.number_format($value->paidamount*0.18,2).'</td>
            <td>'.number_format($value->paidamount,2).'</td>

            </tr>';
            $sn++;
        }

        echo "<tr style='font-size:22px ;'' >
        <td colspan='5'></td>
        <td ><b>". (@$sumt - @$sumt*0.18). " </b></td>
        <td ><b>". @$sumt*0.18. " </b></td>
        <td ><b>". @$sumt. " </b></td>

        </tr>";

    }else{
        echo "<tr>
        <td colspan='8' style='color:red;text-align:center;'>No Transaction on that Date</td></tr>";
    }
    echo" </tbody>

    </table>

    <br><br>
    ";

}else{
    redirect(base_url());

}
}

public function employee_report_word()
{
    if ($this->session->userdata('user_login_access') != false)
    {
   //$emid = base64_decode($this->input->get('I'));
        $date = $this->input->post('date');
        $date2 = $this->input->post('date2');
        $emid = $this->input->post('emid');
        $month = $this->input->post('month');
       // echo 'user emid '.$emid;
        if(empty($emid)){

    //$emid = $this->session->userdata('user_login_id');
     //echo 'login emid '.$emid;
     //echo 'not empty '.$date;

           $data['emid'] = $emid=   $this->session->userdata('user_login_id');
           $getInfo = $this->employee_model->GetBasic($emid);
           $users = 'PF.'.$getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                    //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
           $loc =' - '.$getInfo->em_branch;
       }else{
           $data['emid'] =$emid;

           $getInfo = $this->employee_model->GetBasic($emid);
           $users = 'PF.'.$getInfo->em_code . '   '.$getInfo->first_name.'   '.$getInfo->middle_name.'  '.$getInfo->last_name;
                    //$loc = $getInfo->em_region.' - '.$getInfo->em_branch;
           $loc =' - '.$getInfo->em_branch;

       }
       if(empty($date)){
    //echo 'empty '.$date;
          $tz = 'Africa/Nairobi';
          $tz_obj = new DateTimeZone($tz);
          $today = new DateTime(null, $tz_obj);
          $data['date'] =$date = $today->format('Y-m-d');
          $data['date2'] =$date2 = $today->format('Y-m-d');

      }else{
        $data['date'] =$date;
        $data['date2'] =$date2;

    //echo 'not empty '.$date;
    }

        //$date = date('Y-m-d h:i:s');

    $results= @$this->supervisortrackjob_search($emid,$date2);
    $data['emslist'] =$emslist= @$results;
    $sumt=0;
    foreach (@$results as $key => $value) {
        $value = (object)$value;
        $sumt=$sumt + $value->paidamount;
    }
    $data['total'] =$total= $sumt;
    @$paidamount = @$sumt;

    $data['emselect'] =$emselect= $this->employee_model->emselect();
    $data['agselect'] =$agselect= $this->employee_model->emselectAgent();

    header("Content-type: application/vnd.ms-word");  
           //header("Content-Disposition: attachment;Filename=".rand().".doc"); 
    header("Content-Disposition: attachment;Filename=".$getInfo->em_code.".doc");  
    header("Pragma: no-cache");  
    header("Expires: 0"); 


    echo '
    <link href="'.base_url().'assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="'.base_url().'assets/plugins/jquery/jquery.min.js"></script>';
    echo
    "

    <table  class='table table-hover table-bordered' cellspacing='0' width='100%'>
    <tr style='font-size:16px ;'' >
    <th colspan='4'><b>Operator Name: </b>". @$users. "</th>
    <th colspan='4'><b>Office : </b>". @$getInfo->em_branch. "</th>

    </tr>
    <tr style='font-size:16px ;'' >
    <th colspan='2'><b>Date: </b></th>
    <th colspan='3'><b>From : </b>".@$date."</th>
    <th colspan='3'><b>To : </b>".@$date2."</th>

    </tr>
    <tr style='font-size:17px ;'' >
    <th colspan='6'><b>Cash Transactions: </b></th>

    </tr>
    <br><br><br>


    </table>


    <table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
    <thead>

    <tr>
    <th>SN</th>

    <th>Control Number</th>
    <th>Barcode Number</th>
    <th>Weight</th>

    <th>Destination</th>
    <th>Price</th>
    <th>Vat</th>
    <th>Total</th>

    </tr>
    </thead>

    <tbody>";
    if (!empty($results)) {
        $sn=1;
        foreach (@$results as $value) {$value = (object)$value;
    // <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            echo '<tr>
            <td style=" border: 1px solid black;"> '.$sn.' </td>
            <td style=" border: 1px solid black;">'.$value->billid.'</td>
            <td style=" border: 1px solid black;">'.@$value->Barcode.'</td>
            <td style=" border: 1px solid black;">'.@$value->weight.'</td>
            <td style=" border: 1px solid black;">'.$value->branch.'</td>
            <td style=" border: 1px solid black;">'.number_format(($value->paidamount-$value->paidamount*0.18),2).'</td>
            <td style=" border: 1px solid black;">'.number_format($value->paidamount*0.18,2).'</td>
            <td style=" border: 1px solid black;">'.number_format($value->paidamount,2).'</td>

            </tr>';
            $sn++;
        }

        echo "<tr style='font-size:22px ;'' >
        <td colspan='5'></td>
        <td ><b>". (@$sumt - @$sumt*0.18). " </b></td>
        <td ><b>". @$sumt*0.18. " </b></td>
        <td ><b>". @$sumt. " </b></td>

        </tr>";

    }else{
        echo "<tr>
        <td colspan='8' style='color:red;text-align:center;'>No Transaction on that Date</td></tr>";
    }
    echo" </tbody>

    </table>

    <br><br>


    ";echo ' <script src="'.base_url().'assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="'.base_url().'assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="'.base_url().'assets/export/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>';

}else{
    redirect(base_url());

}
}

public function employee_report_search()
{
    if ($this->session->userdata('user_login_access') != false)
    {
   //$emid = base64_decode($this->input->get('I'));
        $date = $this->input->post('date');
    //$date2 = $this->input->post('date2');
        $emid = $this->input->post('emid');
        $month = $this->input->post('month');
       // echo 'user emid '.$emid;
        if(empty($emid)){

            $emid = $this->session->userdata('user_login_id');
            echo 'login emid '.$emid;
            echo 'not empty '.$date;
        }
        if(empty($date)){
    //echo 'empty '.$date;
          $tz = 'Africa/Nairobi';
          $tz_obj = new DateTimeZone($tz);
          $today = new DateTime(null, $tz_obj);
          $date = $today->format('Y-m-d');
          //$date2 = $today->format('Y-m-d');

      }else{

    //echo 'not empty '.$date;
      }


      
        //$date = date('Y-m-d h:i:s');

      $results= @$this->supervisortrackjob($emid,$date);
      $data['emslist'] =$emslist= @$results;
      $sumt=0;
      foreach (@$results as $key => $value) {
        $value = (object)$value;
        $sumt=$sumt + $value->paidamount;
    }
    $data['total'] =$total= $sumt;
    @$paidamount = @$sumt;

    $data['emselect'] =$emselect= $this->employee_model->emselect();
    $data['agselect'] =$agselect= $this->employee_model->emselectAgent();



    echo
    "<form method='POST' action='send_to_back_office'>
    <table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
    <thead>
    <tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
    <input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
    <label class='form-check-label' for='remember-me'>All</label>
    </div></th>
    <th></th>
    </tr>

    <tr>
    <th>Sender Name</th>
    <th>Registered Date</th>
    <th>Amount (Tsh.)</th>
    <th>Region Origin</th>
    <th>Branch Origin</th>
    <th>Destination</th>
    <th>Destination Branch</th>
    <th>Bill Number</th>
    <th>Tracking Number</th>
    <th>Barcode Number</th>
    <th>Transfer Status</th>
    <th style='text-align: right;''>Payment Status</th>
    <th>
    Item Status
    </th>
    <th>
    action
    </th>
    </tr>
    </thead>

    <tbody>";
    if (!empty($results)) {

        foreach ($results as $value) {$value = (object)$value;
    // <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
            echo '<tr>
            <td>'.$value->s_fullname.'</td>
            <td>'.$value->date_registered.'</td>
            <td>'.number_format($value->paidamount,2).'</td>
            <td>'.$value->s_region.'</td>
            <td>'.$value->s_district.'</td>
            <td>'.$value->r_region.'</td>
            <td>'.$value->branch.'</td>
            <td>';
            echo $value->billid;
    // if ($value->status == "Bill") {
    //  echo strtoupper($value->s_pay_type);
    // } else {
    //  echo $value->billid;
    // }

            echo "</td>
            <td>".$value->track_number."</td>
            <td>".@$value->Barcode."</td>
            <td>";
            if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
                echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Transfer</button>";
            }else{
                echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Pending To Transfer</button>";
            }
            echo"</td>
            <td style='text-align: right;'>";
            if($value->status == 'NotPaid'){
                echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
            }else{
                echo "<button class='btn btn-success btn-sm'>Paid</button>";
            }
            "</td></td>";
            echo "<td style = 'text-align:center;'>";
            echo "<div class='form-check'>";

            if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

                echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
                <label class='form-check-label' for='remember-me'></label>";

            }else{

                echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
                <label class='form-check-label' for='remember-me'></label>";
            }


            echo"</div>
            </td>
            <td style = 'text-align:center;'>
            <a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='".$value->sender_id."' data-receiver_id='".$value->receiver_id."' data-s_fullname='".$value->s_fullname."' data-s_address='".$value->s_address."' data-s_email='".$value->s_email."' data-s_mobile='".$value->s_mobile."' data-s_region='".$value->s_region."' data-r_fullname='".$value->fullname."' data-s_address='".$value->address."' data-r_email='".$value->email."' data-r_mobile='".$value->mobile."' data-r_region='".$value->r_region."'
            data-operator='"; $id = $value->operator;
            @$info = @$this->employee_model->GetBasic($id);
            echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
            </td>
            </tr>";
        }
    }else{
        echo "<tr>
        <td colspan='16' style='color:red;text-align:center;'>No Transaction of that Date</td></tr>";
    }
    echo" </tbody>

    </table>
    <input type='hidden' name='type' value='EMS'>
    <input type='hidden' class='id' name='emid' id='emid' value='$emid'>
    <br><br>
    <table style='width: 100%;'>
    <tr>
    <td colspan='' style='text-align: right;'></td>
    <td colspan=''></td>
    <td colspan=''>

    </td>

    <td colspan='12' style='text-align: right;'><button type='submit' class='btn btn-info'>Back Office >>> </button></td>
    </tr>
    </table>
    </form>

    <div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
    <div class='modal-dialog'>
    <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h2 class='modal-title'> Information</h2>
    </div>
    <div class='modal-body'>
    <div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
    <div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
    <div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
    <div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
    <div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
    <div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
    <br>
    <div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
    <div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
    <div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
    <div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
    <div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
    <div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
    <br>
    <div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
    <div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
    <div class='modal-dialog modal-lg'>

    <!-- Modal content-->
    <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    </div>
    <form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
    <div class='modal-body'>
    <div class='row'>
    <div class='col-md-12'>
    <h3>Step 3 of 4  - Reciever Personal Details</h3>
    </div>

    <div class='col-md-6'>
    <label>Full Name:</label>
    <input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
    </div>
    <div class='col-md-6'>
    <label>Address:</label>
    <input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
    </div>
    <div class='col-md-6'>
    <label>Email:</label>
    <input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
    </div>
    <div class='col-md-6'>
    <label>Mobile Number</label>
    <input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
    </div>
    <div class='col-md-6'>
    <label class='control-label'>Region</label>
    <select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
    <option value=''>--Select Region--</option>";
    $regionlist = @$this->employee_model->regselect();
    foreach($regionlist as $value){
        echo "<option value='$value->region_name'>$value->region_name</option>";
    }
    echo "</select>
    </div>
    <div class='col-md-6'>
    <label>Reciever Branch</label>
    <select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
    <option>--Select Branch--</option>
    </select>

    </div>

    </div>
    </div>
    <div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

    <input type='hidden' name='id' id='comid'>
    <button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
    <button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
    </div>
    </form>
    </div>
    <div class='modal-footer'>

    </div>

    </div>
    </div>
    <script>
    $(document).ready(function(){
        $('.getDetails1').click(function(){

            $('.sfname').html($(this).attr('data-s_fullname'));
            $('.saddress').html($(this).attr('data-s_address'));
            $('.semail').html($(this).attr('data-s_email'));
            $('.smobile').html($(this).attr('data-s_mobile'));
            $('.sregion').html($(this).attr('data-s_region'));
            $('.rfname').html($(this).attr('data-r_fullname'));
            $('.raddress').html($(this).attr('data-r_address'));
            $('.remail').html($(this).attr('data-r_email'));
            $('.rmobile').html($(this).attr('data-r_mobile'));
            $('.rregion').html($(this).attr('data-r_region'));
            $('.operator').html($(this).attr('data-operator'));
            $('#myModal1').modal();

            });
            });
            </script>
            <script type='text/javascript'>
            $(document).ready(function() {
                $('#checkAll3').change(function() {
                    if (this.checked) {
                        $('.checkSingle3').each(function() {
                            this.checked=true;
                            });
                            } else {
                                $('.checkSingle3').each(function() {
                                    this.checked=false;
                                    });
                                }
                                });

                                $('.checkSingle3').click(function () {
                                    if ($(this).is(':checked')) {
                                        var isAllChecked = 0;

                                        $('.checkSingle3').each(function() {
                                            if (!this.checked)
                                            isAllChecked = 1;
                                            });

                                            if (isAllChecked == 0) {
                                                $('#checkAll3').prop('checked', true);
                                            }
                                        }
                                        else {
                                            $('#checkAll3').prop('checked', false);
                                        }
                                        });
                                        });
                                        </script>
                                        <script>
                                        $(document).ready(function(){
                                            $('.myBtn').click(function(){

                                                var text1 = $(this).attr('data-sender_id');
                                                $('#comid').val(text1);
                                                $('#myModal').modal();
                                                });
                                                });
                                                </script>
                                                ";

                                            }
                                            else{
                                                redirect(base_url());
                                            }
                                        }


                                        public function employee_received_report()
                                        {
                                            if ($this->session->userdata('user_login_access') != false)
                                            {
   //$emid = base64_decode($this->input->get('I'));
                                                $date = $this->input->post('date');
                                                $emid = $this->input->post('emid');
                                                $month = $this->input->post('month');
        //echo 'user emid '.$emid;
                                                if(empty($emid)){

                                                    $emid = $this->session->userdata('user_login_id');
     //echo 'login emid '.$emid;
                                                }
                                                if(empty($date)){
   // echo 'empty '.$date;
                                                  $tz = 'Africa/Nairobi';
                                                  $tz_obj = new DateTimeZone($tz);
                                                  $today = new DateTime(null, $tz_obj);
                                                  $date = $today->format('Y-m-d');

                                              }else{

   // echo 'not empty '.$date;
                                              }



        //$date = date('Y-m-d h:i:s');

                                              $results=@$this->Employee_Rceived_trackjob($emid,$date);
                                              $data['emslist'] = @$results;
                                              $sumt=0;
                                              foreach (@$results as $key => $value) {
                                                $value = (object)$value;
                                                $sumt=$sumt + $value->paidamount;
                                            }
                                            $data['total'] = $sumt;


   //$data['emslist'] = $this->Box_Application_model->get_ems_list_pending_supervisor($emid);
                                            $data['emselect'] = $this->employee_model->emselect();
                                            $data['agselect'] = $this->employee_model->emselectAgent();
                                            $this->load->view('domestic_ems/employee_received_report',@$data);
                                        }
                                        else{
                                            redirect(base_url());
                                        }
                                    }

                                    public function employee_received_report_search()
                                    {
if ($this->session->userdata('user_login_access') != false) //item_received_by
{
   //$emid = base64_decode($this->input->get('I'));
    $date = $this->input->post('date');
    $emid = $this->input->post('emid');
    $month = $this->input->post('month');
       // echo 'user emid '.$emid;
    if(empty($emid)){

        $emid = $this->session->userdata('user_login_id');
        echo 'login emid '.$emid;
        echo 'not empty '.$date;
    }
    if(empty($date)){
    //echo 'empty '.$date;
      $tz = 'Africa/Nairobi';
      $tz_obj = new DateTimeZone($tz);
      $today = new DateTime(null, $tz_obj);
      $date = $today->format('Y-m-d');

  }else{

    //echo 'not empty '.$date;
  }



        //$date = date('Y-m-d h:i:s');

  $results= @$this->Employee_Rceived_trackjob($emid,$date);
  $data['emslist'] =$emslist= @$results;
  $sumt=0;
  foreach (@$results as $key => $value) {
    $value = (object)$value;
    $sumt=$sumt + $value->paidamount;
}
$data['total'] =$total= $sumt;
@$paidamount = @$sumt;

$data['emselect'] =$emselect= $this->employee_model->emselect();
$data['agselect'] =$agselect= $this->employee_model->emselectAgent();



echo
"<form method='POST' action='send_to_back_office'>
<table id='fromServer' class='display nowrap table table-hover table-striped table-bordered searchResult' cellspacing='0' width='100%'>
<thead>
<tr><th colspan='11'></th><th colspan=''><div class='form-check' style='padding-left:60px;' id='showCheck3'>
<input type='checkbox'  class='form-check-input' id='checkAll3' style=''>
<label class='form-check-label' for='remember-me'>All</label>
</div></th>
<th></th>
</tr>

<tr>
<th>Sender Name</th>
<th>Registered Date</th>
<th>Amount (Tsh.)</th>
<th>Region Origin</th>
<th>Branch Origin</th>
<th>Destination</th>
<th>Destination Branch</th>
<th>Bill Number</th>
<th>Tracking Number</th>
<th>Barcode Number</th>
<th>Transfer Status</th>
<th style='text-align: right;''>Payment Status</th>
<th>
Item Status
</th>
<th>
action
</th>
</tr>
</thead>

<tbody>";
if (!empty($results)) {

    foreach ($results as $value) {$value = (object)$value;
    // <td><a href='#' class='myBtn' data-sender_id='$value->sender_id'>$value->s_fullname</a></td>
        echo "<tr>
        <td>$value->s_fullname</td>
        <td>$value->date_registered</td>
        <td>".number_format($value->paidamount,2)."</td>
        <td>$value->s_region</td>
        <td>$value->s_district</td>
        <td>$value->r_region</td>
        <td>$value->branch</td>
        <td>";
        echo $value->billid;
    // if ($value->status == "Bill") {
    //  echo strtoupper($value->s_pay_type);
    // } else {
    //  echo $value->billid;
    // }

        echo "</td>
        <td>$value->track_number</td>
        <td>$value->Barcode</td>
        <td>";
        if ($value->office_name == 'Received' || $value->office_name == 'Despatch') {
            echo "<button type='button' class='btn btn-sm btn-success' disabled='disabled'>Successfully Received</button>";
        }else{
            echo "<button type='button' class='btn btn-sm btn-danger' disabled='disabled'> Backoffice</button>";
        }
        echo"</td>
        <td style='text-align: right;'>";
        if($value->status == 'NotPaid'){
            echo "<button class='btn btn-danger btn-sm'>Not Paid</button>";
        }else{
            echo "<button class='btn btn-success btn-sm'>Paid</button>";
        }
        "</td></td>";
        echo "<td style = 'text-align:center;'>";
        echo "<div class='form-check'>";

        if (($value->status == 'Paid' || $value->status == 'Bill') && $value->office_name == 'Counter'){

            echo "<input type='checkbox' name='I[]' class='form-check-input checkSingle3' id='remember-me' value='$value->id'>
            <label class='form-check-label' for='remember-me'></label>";

        }else{

            echo "<input type='checkbox' name='' class='form-check-input' disabled='disabled' style='padding-right:50px;' checked>
            <label class='form-check-label' for='remember-me'></label>";
        }


        echo"</div>
        </td>
        <td style = 'text-align:center;'>
        <a href='#' class='btn btn-info btn-sm getDetails1' data-sender_id='$value->sender_id' data-receiver_id='$value->receiver_id' data-s_fullname='$value->s_fullname' data-s_address='$value->s_address' data-s_email='$value->s_email' data-s_mobile='$value->s_mobile' data-s_region='$value->s_region' data-r_fullname='$value->fullname' data-s_address='$value->address' data-r_email='$value->email' data-r_mobile='$value->mobile' data-r_region='$value->r_region'
        data-operator='"; $id = $value->operator;
        @$info = @$this->employee_model->GetBasic($id);
        echo @$info->em_code.'  '.@$info->first_name.'  '.@$info->middle_name.'  '.@$info->last_name;  echo "'>Details</a>
        </td>
        </tr>";
    }
}else{
    echo "<tr>
    <td colspan='16' style='color:red;text-align:center;'>No Transaction of that Date</td></tr>";
}
echo" </tbody>

</table>
<input type='hidden' name='type' value='EMS'>
<input type='hidden' class='id' name='emid' id='emid' value='$emid'>
<br><br>
<table style='width: 100%;'>
<tr>
<td colspan='' style='text-align: right;'></td>
<td colspan=''></td>
<td colspan=''>

</td>

<td colspan='12' style='text-align: right;'><button type='submit' class='btn btn-info'></button></td>
</tr>
</table>
</form>

<div id='myModal1' class='modal fade' role='dialog' style='padding-top:200px; font-size:24px;'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class='modal-header'>
<button type='button' class='close' data-dismiss='modal'>&times;</button>
<h2 class='modal-title'> Information</h2>
</div>
<div class='modal-body'>
<div class='row'><div class='col-md-12'><b>Sender Information</b></div></div>
<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='sfname'></span></div></div>
<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='saddress'></span></div></div>
<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='semail'></span></div></div>
<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='smobile'></span></div></div>
<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='sregion'></span></div></div>
<br>
<div class='row'><div class='col-md-12'><b>Receiver Information</b></div></div>
<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='rfname'></span></div></div>
<div class='row'><div class='col-md-12'>address: &nbsp;&nbsp;<span class='raddress'></span></div></div>
<div class='row'><div class='col-md-12'>Email: &nbsp;&nbsp;<span class='remail'></span></div></div>
<div class='row'><div class='col-md-12'>Mobile: &nbsp;&nbsp;<span class='rmobile'></span></div></div>
<div class='row'><div class='col-md-12'>Region: &nbsp;&nbsp;<span class='rregion'></span></div></div>
<br>
<div class='row'><div class='col-md-12'><b>Service Operator</b></div></div>
<div class='row'><div class='col-md-12'>Fullname: &nbsp;&nbsp;<span class='operator'></span></div></div>
</div>
</div>
</div>
</div>
</div>
<div class='modal fade' id='myModal' role='dialog' style='padding-top: 100px;'>
<div class='modal-dialog modal-lg'>

<!-- Modal content-->
<div class='modal-content'>
<div class='modal-header'>
<button type='button' class='close' data-dismiss='modal'>&times;</button>
</div>
<form role='form' action='ems_action_receiver' method='post' onsubmit='disableButton()'>
<div class='modal-body'>
<div class='row'>
<div class='col-md-12'>
<h3>Step 3 of 4  - Reciever Personal Details</h3>
</div>

<div class='col-md-6'>
<label>Full Name:</label>
<input type='text' name='r_fname' id='r_fname' class='form-control' onkeyup='myFunction()' required='required'>
</div>
<div class='col-md-6'>
<label>Address:</label>
<input type='text' name='r_address' id='r_address' class='form-control' onkeyup='myFunction()' required='required'>
</div>
<div class='col-md-6'>
<label>Email:</label>
<input type='email' name='r_email' id='r_email' class='form-control' onkeyup='myFunction()'>
</div>
<div class='col-md-6'>
<label>Mobile Number</label>
<input type='mobile' name='r_mobile' id='r_mobile' class='form-control' onkeyup='myFunction()' required='required'>
</div>
<div class='col-md-6'>
<label class='control-label'>Region</label>
<select name='region_to' value='' class='form-control custom-select' required id='rec_region' onChange='getRecDistrict();' required='required'>
<option value=''>--Select Region--</option>";
$regionlist = @$this->employee_model->regselect();
foreach($regionlist as $value){
    echo "<option value='$value->region_name'>$value->region_name</option>";
}
echo "</select>
</div>
<div class='col-md-6'>
<label>Reciever Branch</label>
<select name='district' value='' class='form-control custom-select'  id='rec_dropp' required='required'>
<option>--Select Branch--</option>
</select>

</div>

</div>
</div>
<div class='' style='float: right;padding-right: 30px;padding-bottom: 10px;'>

<input type='hidden' name='id' id='comid'>
<button type='submit' class='btn btn-info pull-left'><span class='glyphicon glyphicon-remove'></span>Save Information</button>
<button type='submit' class='btn btn-warning pull-left' data-dismiss='modal'>Cancel</button>
</div>
</form>
</div>
<div class='modal-footer'>

</div>

</div>
</div>
<script>
$(document).ready(function(){
    $('.getDetails1').click(function(){

        $('.sfname').html($(this).attr('data-s_fullname'));
        $('.saddress').html($(this).attr('data-s_address'));
        $('.semail').html($(this).attr('data-s_email'));
        $('.smobile').html($(this).attr('data-s_mobile'));
        $('.sregion').html($(this).attr('data-s_region'));
        $('.rfname').html($(this).attr('data-r_fullname'));
        $('.raddress').html($(this).attr('data-r_address'));
        $('.remail').html($(this).attr('data-r_email'));
        $('.rmobile').html($(this).attr('data-r_mobile'));
        $('.rregion').html($(this).attr('data-r_region'));
        $('.operator').html($(this).attr('data-operator'));
        $('#myModal1').modal();

        });
        });
        </script>
        <script type='text/javascript'>
        $(document).ready(function() {
            $('#checkAll3').change(function() {
                if (this.checked) {
                    $('.checkSingle3').each(function() {
                        this.checked=true;
                        });
                        } else {
                            $('.checkSingle3').each(function() {
                                this.checked=false;
                                });
                            }
                            });

                            $('.checkSingle3').click(function () {
                                if ($(this).is(':checked')) {
                                    var isAllChecked = 0;

                                    $('.checkSingle3').each(function() {
                                        if (!this.checked)
                                        isAllChecked = 1;
                                        });

                                        if (isAllChecked == 0) {
                                            $('#checkAll3').prop('checked', true);
                                        }
                                    }
                                    else {
                                        $('#checkAll3').prop('checked', false);
                                    }
                                    });
                                    });
                                    </script>
                                    <script>
                                    $(document).ready(function(){
                                        $('.myBtn').click(function(){

                                            var text1 = $(this).attr('data-sender_id');
                                            $('#comid').val(text1);
                                            $('#myModal').modal();
                                            });
                                            });
                                            </script>
                                            ";

                                        }
                                        else{
                                            redirect(base_url());
                                        }
                                    }


                                    public function supervisortrackjob($emid,$date)
                                    {

                                        $year = date('Y',strtotime($date));
                                        $month = date('m',strtotime($date));
                                        $day = date('d',strtotime($date));


                                        $info = @$this->Box_Application_model->GetBasic($emid);
                                        $region = @$info->em_region;
                                        $branch = @$info->em_branch;

                                        $sumtotal=0;


                                        $getInfo = array();


                $type = 'EMS';//DomesticDocument
                $DB = 'transactions';
                $EMS =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);

                foreach (@$EMS as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','Ems_DomesticDocument',$value->Barcode);

                    $sumtotal =  $sumtotal + $value->paidamount;
                }

               $type = 'EMSBILLING';//ems posta global bill --  ems_bill_companies 3
               $DB = 'transactions';
               $EMSBILLING =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMSBILLING as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','ems_posta_global_bill',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'EMS_INTERNATIONAL';//ems international
               $DB = 'transactions';
               $EMS_INTERNATIONAL =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMS_INTERNATIONAL as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_INTERNATIONAL',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'LOAN BOARD';//Loan Board(HESLB)
               $DB = 'transactions';
               $loan_board =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);
               foreach (@$loan_board as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
                 $sumtotal =  $sumtotal + $value->paidamount;
             }



               $type = 'EMS_HESLB';//Loan Board(HESLB)
               $DB = 'transactions';
               $EMS_HESLB =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMS_HESLB as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'NECTA';//Necta
                $DB = 'transactions';
              // $NECTA =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
                $NECTA =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);
                //echo 'HIYO '.json_encode( $NECTA);
                foreach ($NECTA as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_NECTA',$value->Barcode);
             //echo ' HIYO2 '.json_encode( $getInfos);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }







                $type = 'EMS-CARGO';//Ems Cargo
                $DB = 'transactions';
                $EmsCargo =$this->Box_Application_model->get_details_per_date_by_emid_Senderss($type,$year,$month,$day,$emid,$DB);
                foreach (@$EmsCargo as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_Cargo',$value->Barcode);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }






                 $type = 'PCUM';//Pcum
                 $DB = 'transactions';
                 $PCUM =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial1($type,$year,$month,$day,$emid,$DB);
                 foreach (@$PCUM as $key => $value) {
                     $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                         $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                         $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                         $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                         $value->email,$value->mobile, 
                         $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_PCUM',$value->Barcode);
                     $sumtotal =  $sumtotal + $value->paidamount;
                 }



                 //MAIL



               $type = 'MAIL';//INTERNATIONALREGISTER -- 
               $DB = 'transactions';
               $DB1 = 'registered_international';
               @$info = $this->employee_model->GetBasic($emid);
               $emcode = @$info->em_code;
               $INTERNATIONALREGISTER =$this->Box_Application_model->get_details_per_date_by_emid_registered_international($type,$year,$month,$day,$emcode,$DB,$DB1);
               foreach (@$INTERNATIONALREGISTER as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'ONLINE',
                 '','', $value->s_mobile,$emid, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_INTERNATIONALREGISTER');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'register_billing';//REGISTEREDBILL 
               $DB = 'transactions';
               $DB1 = 'credit_customer';
               $register_billing =$this->Box_Application_model->get_details_per_date_by_emid_RegisterBill($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$register_billing as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_REGISTEREDBILL');
                $sumtotal =  $sumtotal + $value->paidamount;
            }




               $type = 'STAMP';//SALES OF STAMP 
               $DB = 'transactions';
               $DB1 = 'stamp';
               $STAMP=$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$STAMP as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'',
                 '','', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_STAMP');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'PBOX';//PRIVATE BOX RENTAL FEES --customer_details 2-haina operator
               $DB = 'transactions';
              // $BOX =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);


                 $type = 'AuthorityCard'; //--AuthorityCard
                 $DB = 'transactions';
                 $DB1 = 'authoritycard';

                 $AuthorityCard =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
                 foreach (@$AuthorityCard as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,'',
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, '', '',
                     '',$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_AuthorityCard');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }




                $type = 'KEYDEPOSITY';//KEYDEPOSITY
                $DB = 'transactions';
                $DB1 = 'keydeposity';
                $KEYDEPOSITY =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
                foreach (@$KEYDEPOSITY as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,'',
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, '', '',
                     '',$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_KEYDEPOSITY');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }


                

                $type = 'CARGO';//POSTSCARGO 
                $DB = 'transactions';
                $CARGO =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial($type,$year,$month,$day,$emid,$DB);
                foreach (@$CARGO as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_POSTSCARGO');
                 $sumtotal =  $sumtotal + $value->paidamount;
             }



              $type = 'COMM'; //COMMISSION AGENCY 1 -haina operator
              $DB = 'transactions';
              $DB1 = 'commission_agency'; 
              // $COMM =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);

                   $type = 'P';//PARKING  
                  // $DB = 'parking_transactions';
                   $DB1 = 'parking'; 
                   $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking($type,$year,$month,$day,$emid,$DB,$DB1);
                   foreach (@$parking_transactions as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     '','', '',$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
                     '','', 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Auto');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }

                @$id = @$emid;
                @$info = $this->Box_Application_model->GetBasic($id); 
                $fulloperatorName= " PF:". '   '.@$info->em_code.'   '.@$info->first_name. '   '. @$info->middle_name.' '.@$info->last_name.  '';

             $type = 'P';//PARKING  
             $DB = 'parking_transactions';
                   // $DB1 = 'parking'; 
             $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking2($type,$year,$month,$day,$emid,$DB,$DB1);
             foreach (@$parking_transactions as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', 'Dar es salaam', 'GPO',$fulloperatorName,
                 '','', '',$value->operator, '',
                 'Dar es salaam','GPO',$value->receiver_id, $fulloperatorName, '',
                 '','', 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Poss_bulk');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'INTERNET'; //INTERNET
               $DB = 'transactions';
               $DB1 = 'internet';
               $INTERNET =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$INTERNET as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'',
                 '','', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','INTERNET');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'POSTASHOP'; //post_shop
               $DB = 'transactions';
               $DB1 = 'post_shop';
               $POSTASHOP =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$POSTASHOP as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'',
                 '','', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTASHOP');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


                $type = 'POSTABUS';//postabus
                $DB = 'transactions';
                $DB1 = 'postabus';
                $POSTABUS =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
                foreach (@$POSTABUS as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,'',
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, '', '',
                     '',$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTABUS');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }







              $type = 'Register';//DOMESTICREGISTER
              $DB = 'register_transactions';
              $register_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
              foreach (@$register_transactions as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_DOMESTICREGISTER');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'Parcel';//PARCEL POST DOMESTIC
                $DB = 'register_transactions';
                $Parcel =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
                foreach (@$Parcel as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_DOMESTIC');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }


               $type = 'PInter';//PARCEL POST INTERNATIONAL
               $DB = 'parcel_international_transactions';
               $PInter =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
               foreach (@$PInter as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_INTERNATIONAL');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
               $DB = 'register_transactions';
               $DSmallPackets =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person($type,$year,$month,$day,$emid,$DB);
               foreach (@$DSmallPackets as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_DOMESTIC');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


                $type = 'Derivery';//SMALL PACKETS Derivery 
                $DB = 'derivery_transactions';
                $Derivery =$this->Box_Application_model->get_details_per_date_by_emid_Derivery($type,$year,$month,$day,$emid,$DB);
                foreach (@$Derivery as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_Derivery');
                 $sumtotal =  $sumtotal + $value->paidamount;
             }







                $type = 'Residential';//residential estate_information
                $DB = 'real_estate_transactions';
                $Residential =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
                foreach (@$Residential as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,'', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Residential');
                 $sumtotal =  $sumtotal + $value->paidamount;
             }


               $type = 'Land';//residential Land
               $DB = 'real_estate_transactions';
               $Land =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
               foreach (@$Land as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,'', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Land');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'Offices';//residential Offices
                $DB = 'real_estate_transactions';
                $Offices =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
                foreach (@$Offices as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,'', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Offices');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }




                return $getInfo;

            }

            public function supervisortrackjob_search($emid,$date,$date2)
            {

                $year = date('Y',strtotime($date));
                $month = date('m',strtotime($date));
                $day = date('d',strtotime($date));

                $year2 = date('Y',strtotime($date2));
                $month2 = date('m',strtotime($date2));
                $day2 = date('d',strtotime($date2));


                $info = @$this->Box_Application_model->GetBasic($emid);
                $region = @$info->em_region;
                $branch = @$info->em_branch;

                $sumtotal=0;


                $getInfo = array();
                

                $type = 'EMS';//DomesticDocument
                $DB = 'transactions';
                $EMS =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);

                foreach (@$EMS as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','Ems_DomesticDocument',$value->Barcode);

                    $sumtotal =  $sumtotal + $value->paidamount;
                }

               $type = 'EMSBILLING';//ems posta global bill --  ems_bill_companies 3
               $DB = 'transactions';
               $EMSBILLING =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$EMSBILLING as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','ems_posta_global_bill',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'EMS_INTERNATIONAL';//ems international
               $DB = 'transactions';
               $EMS_INTERNATIONAL =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$EMS_INTERNATIONAL as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_INTERNATIONAL',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'LOAN BOARD';//Loan Board(HESLB)
               $DB = 'transactions';
               $loan_board =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$loan_board as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
                 $sumtotal =  $sumtotal + $value->paidamount;
             }



               $type = 'EMS_HESLB';//Loan Board(HESLB)
               $DB = 'transactions';
               $EMS_HESLB =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$EMS_HESLB as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'NECTA';//Necta
                $DB = 'transactions';
              // $NECTA =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
                $NECTA =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                //echo 'HIYO '.json_encode( $NECTA);
                foreach ($NECTA as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_NECTA',$value->Barcode);
             //echo ' HIYO2 '.json_encode( $getInfos);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }







                $type = 'EMS-CARGO';//Ems Cargo
                $DB = 'transactions';
                $EmsCargo =$this->Box_Application_model->get_details_per_date_by_emid_Senderss22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                foreach (@$EmsCargo as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_Cargo',$value->Barcode);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }






                 $type = 'PCUM';//Pcum
                 $DB = 'transactions';
                 $PCUM =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                 foreach (@$PCUM as $key => $value) {
                     $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                         $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                         $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                         $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                         $value->email,$value->mobile, 
                         $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_PCUM',$value->Barcode);
                     $sumtotal =  $sumtotal + $value->paidamount;
                 }



                 //MAIL



               $type = 'MAIL';//INTERNATIONALREGISTER -- 
               $DB = 'transactions';
               $DB1 = 'registered_international';
               @$info = $this->employee_model->GetBasic($emid);
               $emcode = @$info->em_code;
               $INTERNATIONALREGISTER =$this->Box_Application_model->get_details_per_date_by_emid_registered_international22($type,$year,$month,$day,$year2,$month2,$day2,$emcode,$DB,$DB1);
               foreach (@$INTERNATIONALREGISTER as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'ONLINE',
                 '','', $value->s_mobile,$emid, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_INTERNATIONALREGISTER');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'register_billing';//REGISTEREDBILL 
               $DB = 'transactions';
               $DB1 = 'credit_customer';
               $register_billing =$this->Box_Application_model->get_details_per_date_by_emid_RegisterBill22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
               foreach (@$register_billing as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_REGISTEREDBILL');
                $sumtotal =  $sumtotal + $value->paidamount;
            }




               $type = 'STAMP';//SALES OF STAMP 
               $DB = 'transactions';
               $DB1 = 'stamp';
               $STAMP=$this->Box_Application_model->get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
               foreach (@$STAMP as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'',
                 '','', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_STAMP');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'PBOX';//PRIVATE BOX RENTAL FEES --customer_details 2-haina operator
               $DB = 'transactions';
              // $BOX =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);


                 $type = 'AuthorityCard'; //--AuthorityCard
                 $DB = 'transactions';
                 $DB1 = 'authoritycard';

                 $AuthorityCard =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
                 foreach (@$AuthorityCard as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,'',
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, '', '',
                     '',$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_AuthorityCard');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }




                $type = 'KEYDEPOSITY';//KEYDEPOSITY
                $DB = 'transactions';
                $DB1 = 'keydeposity';
                $KEYDEPOSITY =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
                foreach (@$KEYDEPOSITY as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,'',
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, '', '',
                     '',$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_KEYDEPOSITY');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }


                

                $type = 'CARGO';//POSTSCARGO 
                $DB = 'transactions';
                $CARGO =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                foreach (@$CARGO as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_POSTSCARGO');
                 $sumtotal =  $sumtotal + $value->paidamount;
             }



              $type = 'COMM'; //COMMISSION AGENCY 1 -haina operator
              $DB = 'transactions';
              $DB1 = 'commission_agency'; 
              // $COMM =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);

                   $type = 'P';//PARKING  
                  // $DB = 'parking_transactions';
                   $DB1 = 'parking'; 
                   $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking212($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
                   foreach (@$parking_transactions as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     '','', '',$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
                     '','', 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Auto');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }

                @$id = @$emid;
                @$info = $this->Box_Application_model->GetBasic($id); 
                $fulloperatorName= " PF:". '   '.@$info->em_code.'   '.@$info->first_name. '   '. @$info->middle_name.' '.@$info->last_name.  '';

             $type = 'P';//PARKING  
             $DB = 'parking_transactions';
                   // $DB1 = 'parking'; 
             $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
             foreach (@$parking_transactions as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', 'Dar es salaam', 'GPO',$fulloperatorName,
                 '','', '',$value->operator, '',
                 'Dar es salaam','GPO',$value->receiver_id, $fulloperatorName, '',
                 '','', 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Poss_bulk');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'INTERNET'; //INTERNET
               $DB = 'transactions';
               $DB1 = 'internet';
               $INTERNET =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
               foreach (@$INTERNET as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'',
                 '','', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','INTERNET');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'POSTASHOP'; //post_shop
               $DB = 'transactions';
               $DB1 = 'post_shop';
               $POSTASHOP =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
               foreach (@$POSTASHOP as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'',
                 '','', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTASHOP');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


                $type = 'POSTABUS';//postabus
                $DB = 'transactions';
                $DB1 = 'postabus';
                $POSTABUS =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB,$DB1);
                foreach (@$POSTABUS as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,'',
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, '', '',
                     '',$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTABUS');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }







              $type = 'Register';//DOMESTICREGISTER
              $DB = 'register_transactions';
              $register_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
              foreach (@$register_transactions as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_DOMESTICREGISTER');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'Parcel';//PARCEL POST DOMESTIC
                $DB = 'register_transactions';
                $Parcel =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                foreach (@$Parcel as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_DOMESTIC');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }


               $type = 'PInter';//PARCEL POST INTERNATIONAL
               $DB = 'parcel_international_transactions';
               $PInter =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$PInter as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_INTERNATIONAL');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
               $DB = 'register_transactions';
               $DSmallPackets =$this->Box_Application_model->get_details_per_date_by_emid_Sender_person22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$DSmallPackets as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_DOMESTIC');
                $sumtotal =  $sumtotal + $value->paidamount;
            }


                $type = 'Derivery';//SMALL PACKETS Derivery 
                $DB = 'derivery_transactions';
                $Derivery =$this->Box_Application_model->get_details_per_date_by_emid_Derivery22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                foreach (@$Derivery as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     '','', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_Derivery');
                 $sumtotal =  $sumtotal + $value->paidamount;
             }







                $type = 'Residential';//residential estate_information
                $DB = 'real_estate_transactions';
                $Residential =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                foreach (@$Residential as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,'', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Residential');
                 $sumtotal =  $sumtotal + $value->paidamount;
             }


               $type = 'Land';//residential Land
               $DB = 'real_estate_transactions';
               $Land =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
               foreach (@$Land as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,'', $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Land');
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'Offices';//residential Offices
                $DB = 'real_estate_transactions';
                $Offices =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate22($type,$year,$month,$day,$year2,$month2,$day2,$emid,$DB);
                foreach (@$Offices as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     '', $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,'', $value->s_mobile,$value->operator, '',
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Offices');
                    $sumtotal =  $sumtotal + $value->paidamount;
                }




                return $getInfo;

            }


            public function Employee_Rceived_trackjob($emid,$date)
            {

                $year = date('Y',strtotime($date));
                $month = date('m',strtotime($date));
                $day = date('d',strtotime($date));


                $info = @$this->Box_Application_model->GetBasic($emid);
                $region = @$info->em_region;
                $branch = @$info->em_branch;

                $sumtotal=0;


                $getInfo = array();
                

                $type = 'EMS';//DomesticDocument
                $DB = 'transactions';
                $EMS =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);

                foreach (@$EMS as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','Ems_DomesticDocument',$value->Barcode);

                    $sumtotal =  $sumtotal + $value->paidamount;
                }

               $type = 'EMSBILLING';//ems posta global bill --  ems_bill_companies 3
               $DB = 'transactions';
               $EMSBILLING =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMSBILLING as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','ems_posta_global_bill',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }


               $type = 'EMS_INTERNATIONAL';//ems international
               $DB = 'transactions';
               $EMS_INTERNATIONAL =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMS_INTERNATIONAL as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_INTERNATIONAL',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'LOAN BOARD';//Loan Board(HESLB)
               $DB = 'transactions';
               $loan_board =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);
               foreach (@$loan_board as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
                 $sumtotal =  $sumtotal + $value->paidamount;
             }



               $type = 'EMS_HESLB';//Loan Board(HESLB)
               $DB = 'transactions';
               $EMS_HESLB =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);
               foreach (@$EMS_HESLB as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_LOAN_BOARD',$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'NECTA';//Necta
                $DB = 'transactions';
              // $NECTA =$this->Reports_model->get_Paid_Report_list_for_search($type,$date,$month,$region,$DB);
                $NECTA =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);
                //echo 'HIYO '.json_encode( $NECTA);
                foreach ($NECTA as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_NECTA',$value->Barcode);
             //echo ' HIYO2 '.json_encode( $getInfos);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }







                $type = 'EMS-CARGO';//Ems Cargo
                $DB = 'transactions';
                $EmsCargo =$this->Box_Application_model->get_details_per_date_by_emid_Senderss1($type,$year,$month,$day,$emid,$DB);
                foreach (@$EmsCargo as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_Cargo',$value->Barcode);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }






                 $type = 'PCUM';//Pcum
                 $DB = 'transactions';
                 $PCUM =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial11($type,$year,$month,$day,$emid,$DB);
                 foreach (@$PCUM as $key => $value) {
                     $getInfo[] = $this->Supervisor_ViewModel->view_data1($value->sender_id,$value->date_registered,
                         $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                         $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                         $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                         $value->email,$value->mobile, 
                         $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','EMS_PCUM',@$value->Barcode);
                     $sumtotal =  $sumtotal + $value->paidamount;
                 }



                 //MAIL



               $type = 'MAIL';//INTERNATIONALREGISTER -- 
               $DB = 'transactions';
               $DB1 = 'registered_international';
               @$info = $this->employee_model->GetBasic($emid);
               $emcode = @$info->em_code;
               $INTERNATIONALREGISTER =$this->Box_Application_model->get_details_per_date_by_emid_registered_international1($type,$year,$month,$day,$emcode,$DB,$DB1);
               foreach (@$INTERNATIONALREGISTER as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,'ONLINE',
                 '','', $value->s_mobile,$emid, '',
                 $value->r_region,$value->branch,$value->receiver_id, '', '',
                 '',$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_INTERNATIONALREGISTER',@$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



               $type = 'register_billing';//REGISTEREDBILL 
               $DB = 'transactions';
               $DB1 = 'credit_customer';
               $register_billing =$this->Box_Application_model->get_details_per_date_by_emid_RegisterBill1($type,$year,$month,$day,$emid,$DB,$DB1);
               foreach (@$register_billing as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 '', $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, '',
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 $value->email,$value->mobile, 
                 $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_REGISTEREDBILL',@$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }




           //     $type = 'STAMP';//SALES OF STAMP 
           //      $DB = 'transactions';
           //      $DB1 = 'stamp';
           //    $STAMP=$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
           //     foreach (@$STAMP as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,'',
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, '', '',
           // '',$value->mobile, 
           // $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_STAMP');
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }



           //     $type = 'PBOX';//PRIVATE BOX RENTAL FEES --customer_details 2-haina operator
           //      $DB = 'transactions';
           //    // $BOX =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);


           //       $type = 'AuthorityCard'; //--AuthorityCard
           //        $DB = 'transactions';
           //        $DB1 = 'authoritycard';

           //    $AuthorityCard =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
           //     foreach (@$AuthorityCard as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,'',
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, '', '',
           // '',$value->mobile, 
           // $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_AuthorityCard');
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }




           //      $type = 'KEYDEPOSITY';//KEYDEPOSITY
           //        $DB = 'transactions';
           //     $DB1 = 'keydeposity';
           //    $KEYDEPOSITY =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
           //     foreach (@$KEYDEPOSITY as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,'',
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, '', '',
           // '',$value->mobile, 
           // $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_KEYDEPOSITY');
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }




                $type = 'CARGO';//POSTSCARGO 
                $DB = 'transactions';
                $CARGO =$this->Box_Application_model->get_details_per_date_by_emid_Sender_serial1($type,$year,$month,$day,$emid,$DB);
                foreach (@$CARGO as $key => $value) {
                 $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     $value->email,$value->mobile, 
                     $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','MAIL_POSTSCARGO',@$value->Barcode);
                 $sumtotal =  $sumtotal + $value->paidamount;
             }



          //     $type = 'COMM'; //COMMISSION AGENCY 1 -haina operator
          //         $DB = 'transactions';
          //           $DB1 = 'commission_agency'; 
          //     // $COMM =$this->Box_Application_model->get_details_per_date_by_emid_Sender($type,$year,$month,$day,$emid,$DB);

          //          $type = 'P';//PARKING  
          //         // $DB = 'parking_transactions';
          //          $DB1 = 'parking'; 
          //     $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking($type,$year,$month,$day,$emid,$DB,$DB1);
          //      foreach (@$parking_transactions as $key => $value) {
          //   $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
          //  '', $value->s_region, $value->s_district,$value->s_fullname,
          //  '','', '',$value->operator, '',
          //  $value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
          // '','', 
          //  $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Auto');
          //    $sumtotal =  $sumtotal + $value->paidamount;
          //   }

             @$id = @$emid;
             @$info = $this->Box_Application_model->GetBasic($id); 
             $fulloperatorName= " PF:". '   '.@$info->em_code.'   '.@$info->first_name. '   '. @$info->middle_name.' '.@$info->last_name.  '';

          //    $type = 'P';//PARKING  
          //         $DB = 'parking_transactions';
          //          // $DB1 = 'parking'; 
          //     $parking_transactions =$this->Box_Application_model->get_details_per_date_by_emid_Parking2($type,$year,$month,$day,$emid,$DB,$DB1);
          //      foreach (@$parking_transactions as $key => $value) {
          //   $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
          //  '', 'Dar es salaam', 'GPO',$fulloperatorName,
          //  '','', '',$value->operator, '',
          //  'Dar es salaam','GPO',$value->receiver_id, $fulloperatorName, '',
          // '','', 
          //  $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','parking_Poss_bulk');
          //    $sumtotal =  $sumtotal + $value->paidamount;
          //   }


           //     $type = 'INTERNET'; //INTERNET
           //        $DB = 'transactions';
           //        $DB1 = 'internet';
           //    $INTERNET =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
           //     foreach (@$INTERNET as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,'',
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, '', '',
           // '',$value->mobile, 
           // $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','INTERNET');
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }


           //     $type = 'POSTASHOP'; //post_shop
           //        $DB = 'transactions';
           //         $DB1 = 'post_shop';
           //    $POSTASHOP =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
           //    foreach (@$POSTASHOP as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,'',
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, '', '',
           // '',$value->mobile, 
           // $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTASHOP');
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }


           //      $type = 'POSTABUS';//postabus
           //        $DB = 'transactions';
           //         $DB1 = 'postabus';
           //    $POSTABUS =$this->Box_Application_model->get_details_per_date_by_emid_GENERAL1($type,$year,$month,$day,$emid,$DB,$DB1);
           //     foreach (@$POSTABUS as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,'',
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, '', '',
           // '',$value->mobile, 
           // $value->billid, $value->office_name, $value->status,$value->id, $value->paidamount,'','','','POSTABUS');
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }







              $type = 'Register';//DOMESTICREGISTER
              $DB = 'register_transactions';
              $register_transactions =@$this->Box_Application_model->get_details_per_date_by_emid_Sender_person1($type,$year,$month,$day,$emid,$DB);
              foreach (@$register_transactions as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_DOMESTICREGISTER',@$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }



                $type = 'Parcel';//PARCEL POST DOMESTIC
                $DB = 'register_transactions';
                $Parcel =@$this->Box_Application_model->get_details_per_date_by_emid_Sender_person1($type,$year,$month,$day,$emid,$DB);
                foreach (@$Parcel as $key => $value) {
                    $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                     $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                     $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                     $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                     '',$value->mobile, 
                     $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_DOMESTIC',@$value->Barcode);
                    $sumtotal =  $sumtotal + $value->paidamount;
                }


           //     $type = 'PInter';//PARCEL POST INTERNATIONAL
           //      $DB = 'parcel_international_transactions';
           //   $PInter =@$this->Box_Application_model->get_details_per_date_by_emid_Sender_person1($type,$year,$month,$day,$emid,$DB);
           //         foreach (@$PInter as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
           // $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
           // $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
           // '',$value->mobile, 
           // $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_PARCEL_POST_INTERNATIONAL',@$value->Barcode);
           //   $sumtotal =  $sumtotal + $value->paidamount;
           //  }



               $type = 'DSmallPackets';//SMALL PACKETS DOMESTIC 
               $DB = 'register_transactions';
               $DSmallPackets =@$this->Box_Application_model->get_details_per_date_by_emid_Sender_person1($type,$year,$month,$day,$emid,$DB);
               foreach (@$DSmallPackets as $key => $value) {
                $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
                 $value->track_number, $value->s_region, $value->s_district,$value->s_fullname,
                 $value->s_address,$value->s_email, $value->s_mobile,$value->operator, $value->s_status,
                 $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
                 '',$value->mobile, 
                 $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_DOMESTIC',@$value->Barcode);
                $sumtotal =  $sumtotal + $value->paidamount;
            }


           //      $type = 'Derivery';//SMALL PACKETS Derivery 
           //      $DB = 'derivery_transactions';
           //  $Derivery =$this->Box_Application_model->get_details_per_date_by_emid_Derivery($type,$year,$month,$day,$emid,$DB);
           //  foreach (@$Derivery as $key => $value) {
           // $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,$value->s_fullname,
           // '','', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, $value->fullname, '',
           // '',$value->mobile, 
           // $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','MAIL_SMALL_PACKETS_Derivery');
           //  $sumtotal =  $sumtotal + $value->paidamount;
           //  }







           //      $type = 'Residential';//residential estate_information
           //      $DB = 'real_estate_transactions';
           //      $Residential =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
           //       foreach (@$Residential as $key => $value) {
           // $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,$value->s_fullname,
           // $value->s_address,'', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
           // '',$value->mobile, 
           // $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Residential');
           //  $sumtotal =  $sumtotal + $value->paidamount;
           //  }


           //     $type = 'Land';//residential Land
           //      $DB = 'real_estate_transactions';
           //      $Land =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
           //      foreach (@$Land as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,$value->s_fullname,
           // $value->s_address,'', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
           // '',$value->mobile, 
           // $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Land');
           //  $sumtotal =  $sumtotal + $value->paidamount;
           //  }



           //      $type = 'Offices';//residential Offices
           //      $DB = 'real_estate_transactions';
           //       $Offices =$this->Box_Application_model->get_details_per_date_by_emid_RealEstate($type,$year,$month,$day,$emid,$DB);
           //       foreach (@$Offices as $key => $value) {
           //  $getInfo[] = $this->Supervisor_ViewModel->view_data($value->sender_id,$value->date_registered,
           // '', $value->s_region, $value->s_district,$value->s_fullname,
           // $value->s_address,'', $value->s_mobile,$value->operator, '',
           // $value->r_region,$value->branch,$value->receiver_id, $value->fullname, $value->address,
           // '',$value->mobile, 
           // $value->billid, '', $value->status,$value->id, $value->paidamount,'','','','Real_Estate_Offices');
           //  $sumtotal =  $sumtotal + $value->paidamount;
           //  }




            return $getInfo;

        }


        public function Emszero(){
            if ($this->session->userdata('user_login_access') != false) {

            // $this->session->set_userdata('heading','Domestic Cash Dashboard');
             $this->load->view('domestic_ems/emszero');
         } else {
             redirect(base_url());
         }

     }

     public function Emszero_List()
     {
        if ($this->session->userdata('user_login_access') != false) {

         $data['region'] = $this->employee_model->regselect();
         $date = $this->input->post('date');
         $month= $this->input->post('month');
         $region= $this->input->post('region');

         if (!empty($month) || !empty($date) ) {
            $data['list'] = $this->dashboard_model->get_EmsZero_list_search($date,$month,$region);


        } else 
        {

            $data['list'] = $this->dashboard_model->get_Emszero_list();

        }



        $this->load->view('domestic_ems/Emszero_List',$data);
    } else {
        redirect(base_url());
    }

}

public function Save_Emszero()
{
    if ($this->session->userdata('user_login_access') != false) {

        $custname = $this->input->post('custname');
        $Currency = $this->input->post('Currency');
        $Amount = $this->input->post('Amount');
        $price = $Amount;
        $mobile = $this->input->post('s_mobile');
        $invoiced = $this->input->post('invoiced');


        $id = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($id);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;

        $source = $this->employee_model->get_code_source($o_region);

        $bagsNo = $source->reg_code;
        $serial    = 'Emszero'.date("YmdHis").$source->reg_code;



        $data = array();
        $data = array(

            'serial'=>$serial,
            'customer'=>$custname,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

        );
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('emszero',$data);
        $last_id2 = $db2->insert_id();
        $emszeroid= (int)$last_id2.'000';

            //$this->dashboard_model->save_Emszero($data);

        $invoice = array();
        $invoice = array('invoice_details'=>$invoiced,'invoice_date'=>date("YmdHis"),'invcust_id'=>$emszeroid);
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('invoice',$invoice);
        $last_id = $db2->insert_id();


        $data1 = array();
        $data1 = array(

            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'PARCEL CHARGES'

        );

        $this->Box_Application_model->save_transactions($data1);



        $paidamount = $Amount;
        $region = $o_region;
        $district = $o_branch;

        $custname = $custname.'-ZERORATE';
        $renter   = $custname;
        $serviceId = 'EMS';
        $trackingno = '90'.$bagsNo;

        $transaction = $this->getBillGepgBillIdzerorate($serial,$paidamount,$district,$region,$mobile,$renter,$serviceId,$trackingno,$custname);

            // $transaction = $this->getBillGepgBillIdInternet($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
        $serial1 = $serial;

        if ($transaction->controlno != '') {
                    # code...

            $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
            $this->billing_model->update_transactions($update,$serial1);

            $first4 = substr($transaction->controlno, 4);
            $trackNo = '90'.$bagsNo.$first4;




            $data = array();
            $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

            $this->Box_Application_model->save_location($data);

            $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Ems,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

            $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Ems,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

            $this->Sms_model->send_sms_trick($mobile,$total);

            $this->load->view('domestic_ems/Emszero_control_number',$data);
        }else{
            redirect('domestic_ems/Emszero_List');
        }


    } else {
        redirect(base_url());
    }    
}

public function invoice_sheet_zero(){

    $acc_no = $this->input->get('cun');
//$month = $this->input->get('month');
    $data['cno'] = $controlno = $this->input->get('cn');
    $data['amount'] = $this->input->get('amount');

//get serial
    $trans = $this->Box_Application_model->get_trans($controlno);
    $serial = @$trans->serial;
    $data['custinfo'] = $emszero = $this->Box_Application_model->get_emszero($serial);
    $emszeroid= (int)$emszero->id.'000';
    $invoice = $this->Box_Application_model->get_invoice($emszeroid);

//get invoice
    if(!empty($invoice)){
    //invoice_details

        $data['invoice'] = $invoice->invoice_id;
        $data['invoiced'] = $invoice->invoice_details;

    }else{
    //create invoice
       $invoice = array();
       $invoice = array('invoice_details'=>'','invoice_date'=>date("YmdHis"),'invcust_id'=>@$emszeroid);
       $db2 = $this->load->database('otherdb', TRUE);
       $db2->insert('invoice',$invoice);
       $last_id = $db2->insert_id();
       $invoice2 = $this->Box_Application_model->get_invoice($emszeroid);

       $data['invoice'] = $invoice2->invoice_id;
       $data['invoiced'] = $invoice2->invoice_details;
   }


   $sign = array('controlno'=>$controlno,'idtype'=>'1','custid'=>@$data['custinfo']->id,'custname'=>@$data['custinfo']->customer,'msisdn'=>@$data['custinfo']->Customer_mobile,'service'=>'EFD');
   $url = "http://192.168.33.2/api/vfd/getSig.php";
   $ch = curl_init($url);
   $json = json_encode($sign);
   curl_setopt($ch, CURLOPT_URL, $url);
        // For xml, change the content-type.
   curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
   curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $response = curl_exec ($ch);
        $error    = curl_error($ch);
        $errno    = curl_errno($ch);
        curl_close ($ch);
        $data['signature'] = $signature = json_decode($response);


        $this->load->library('ciqrcode');

            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(224,255,255); // array, default is array(255,255,255)
            $config['white']        = array(70,130,180); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);

            $image_name = $data['qrcodename'] = $controlno .'.png'; 
            
            $params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; 
            $params['level'] = 'H'; 
            $params['size'] = 10;
            $params['savename'] = FCPATH.$config['imagedir'].$image_name; 
            $this->ciqrcode->generate($params);

            //$html=$this->load->view('domestic_ems/invoice_sheet_zero',$data);
            //$this->load->view('domestic_ems/invoice_sheet_zero',$data);

            $this->load->library('Pdf');
            $html= $this->load->view('domestic_ems/invoice_sheet_zero',$data,TRUE);              
            $this->load->library('Pdf');
            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4','potrait');
            $this->dompdf->render();
            $this->dompdf->stream($acc_no, array("Attachment"=>0));

        }

        public function getBillGepgBillIdzerorate($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$custname){

            $AppID = 'POSTAPORTAL';

            $data = array(
                'AppID'=>$AppID,
                'BillAmt'=>$paidamount,
                'serial'=>$serial,
                'District'=>$region,
                'Region'=>$district,
                'service'=>$serviceId,
                'item'=>$renter,
                'mobile'=>$mobile,
                'custname'=>$custname
            );

            $json = json_encode($data);
 //create logs
            $value = array();
            $value = array('item'=>$renter,'payload'=>$json);
            $log=json_encode($value);
            $lg = array(
             'response'=>$log,
             'serial'=>$serial,
             'type'=>'SendtoGEPG',
             'service'=>$serviceId,
             'barcode'=>$trackno
         );
            $this->Box_Application_model->save_logs($lg);

//create logs
            $value = array();
            $value = array('custname'=>$custname,'serviceid'=>$serviceId,'item'=>$renter,'serial'=>$serial);
            $log=json_encode($value);
            $lg = array(
             'response'=>$log
         );
            $this->Box_Application_model->save_logs($lg);

            $url = "http://192.168.33.2/payments/paymentAPI.php";
            $ch = curl_init($url);
            $json = json_encode($data);
            curl_setopt($ch, CURLOPT_URL, $url);
// For xml, change the content-type.
            curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
            curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

// Send to remote and return data to caller.
$response = curl_exec ($ch);
$error    = curl_error($ch);
$errno    = curl_errno($ch);
// print_r($result->controlno);
//print_r($response.$error);
curl_close ($ch);
$result = json_decode($response);
//print_r($result->controlno);
return $result;

//echo $result;
}

public function bill_dashboard(){
    if ($this->session->userdata('user_login_access') != false) {

        $this->session->set_userdata('heading','Domestic Bill Dashboard');
        $this->load->view('domestic_ems/domestic-bill-dashboard');
    } else {
     redirect(base_url());
 }

}

public function transfered_item_list(){

    $data['region'] = $this->employee_model->regselect();
    $this->load->view('domestic_ems/transfered_item');
}

public function Domestic_Category_Dashboard(){
    if ($this->session->userdata('user_login_access') != false) {

        $this->session->set_userdata('heading','Domestic Dashboard');
        
        //$data['cash'] = $this->dashboard_model->get_ems_domestic_cash();
        //$data['bill'] = $this->dashboard_model->get_ems_domestic_bill();
        $this->load->view('domestic_ems/domestic-category-dashboard',@$data);
    } else {
     redirect(base_url());
 }

}

// MODIFIED BY POSTA PROGRAMMERS

public function document_parcel()
{

    if ($this->session->userdata('user_login_access') != false) 
    {

        $this->session->set_userdata('heading','Document / Parcel');

        // $data['region'] = $this->employee_model->regselect();
        // $data['total'] = $this->Box_Application_model->get_ems_sum();
        // $data['ems_cat'] = $this->Box_Application_model->ems_cat();
        // $data['region'] = $this->employee_model->regselect();
        $this->load->view('domestic_ems/document-parcel-form');

    } 
    else 
    {
       redirect(base_url());
   }

}

public function document_parcel_ajax_select()
{ 
    if ($this->session->userdata('user_login_access') != false)
    {
        $ems_data = $this->Box_Application_model->ems_cat();
        $select = '<select name="emscattype" value="" class="form-control custom-select catid" id="tariffCat" required="required" onChange="getEMSType();"><option value="0" disabled selected>--Select Category--</option>';
        foreach($ems_data as $value)
        {            
            $select .= '<option value="'.$value->cat_id.'">'.$value->cat_name.'</option>';
        }
        $select .= '</select>';
        echo $select;

    } 
    else
    {
        echo null;
    }
}

public function document_parcel_ajax_regionList()
{ 
    if ($this->session->userdata('user_login_access') != false)
    {
        $region_list = $this->employee_model->regselect();
        $select = '<select name="region_to" value="" class="form-control custom-select region_to" id="rec_region" onChange="getRecDistrict();"> <option value="" disabled selected>--Select Region--</option>';
        foreach($region_list as $value)
        {            
            $select .= '<option value="'.$value->region_name.'">'.$value->region_name.'</option>';
        }
        $select .= '</select>';
        echo $select;
    } 
    else
    {
        echo null;
    }
}


// ENDS HERE

public function bulk_document_parcel(){

    if ($this->session->userdata('user_login_access') != false) {

        $this->session->set_userdata('heading','Bulk Document / Parcel');

        $data['region'] = $this->employee_model->regselect();
        $data['total'] = $this->Box_Application_model->get_ems_sum();
        $data['ems_cat'] = $this->Box_Application_model->ems_cat();
        $data['region'] = $this->employee_model->regselect();
        $this->load->view('domestic_ems/bulk-document-parcel-form',$data);

    } else {
     redirect(base_url());
 }

}

public function bulk_pcum(){

    if ($this->session->userdata('user_login_access') != false) {

        $this->session->set_userdata('heading','Bulk Pcum');

        $data['district'] = $this->dashboard_model->getdistrict();
        $data['region'] = $this->employee_model->regselect();
        $this->load->view('pcum/bulk-pcum-form',$data);

    } else {
     redirect(base_url());
 }

}


public function getnumber(){

    $getuniquelastnumber= $this->Box_Application_model->get_last_number();

            //check length
    if(empty($getuniquelastnumber) || is_null($getuniquelastnumber)){
        $number = 1;
        $nmbur = array();
        $nmbur = array('number'=>$number);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('tracknumber',$nmbur);

        $no_of_digit = 5;

        $length = strlen((string)$number);
        $numberk = '';
        for($i = $length;$i<$no_of_digit;$i++)
        {
            $numberk = '0'.$numberk;
        }

        $number=$numberk.$number;


    }else{
        $no_of_digit = 5;
        $numbers = @$getuniquelastnumber->number;
        $numbers=$numbers+1;
        $number = @$getuniquelastnumber->number;

        $length = strlen((string)$number);
        $numbera='';
        for($i = $length;$i<$no_of_digit;$i++)
        {
            $numbera = '0'.$numbera;
        }
        $number=$numbera.$numbers;


        $nmbur = array();
        $nmbur = array('number'=>$numbers);
        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('tracknumber',$nmbur);


    }

    return $number;
}


public function ems_document_parcel_save(){
    if ($this->session->userdata('user_login_access') != false){
        $userid = $this->session->userdata('user_login_id');

        $emstype = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $Barcode = strtoupper($this->input->post('Barcode'));
        $weight = $this->input->post('weight');

        //sender information
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $this->input->post('s_mobile');
        $s_addressType = $this->input->post('s_addressType');

        //receiver information
        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        $r_email = $this->input->post('r_email');
        $rec_region = $this->input->post('rec_region');
        $rec_district = $this->input->post('rec_dropp');
        $r_addressType = $this->input->post('r_addressType');

        $price = $this->input->post('price');

        //Staff information
        $info = $this->employee_model->GetBasic($userid);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

        //getting user or staff department section
        $staff_section = $this->employee_model->getEmpDepartmentSections($userid);

        $transactionstatus   = 'POSTED';
        $bill_status  = 'PENDING';
        $PaymentFor = 'EMS';
        $transactiondate = date("Y-m-d");
        $fullname  = $s_fname;

        $source_region = $this->employee_model->get_code_source($o_region);
        $destination_region = $this->employee_model->get_code_dest($rec_region);

        $number = $this->getnumber();
        $bagsNo = 'EE'.@$source_region->reg_code . @$destination_region->reg_code.$number.'TZ';
        $serial    = 'EMS'.date("YmdHis").$source_region->reg_code;
        $trackno = $bagsNo;

        //$getPending = $this->Box_Application_model->get_pending_task1($userid);

        // if ( $getPending == 100) {

        //     $results['status'] = "Error";
        //     $results['message'] = "You Have 100 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";

        //  } else {

        $db2 = $this->load->database('otherdb', TRUE);

            //Sender Information
        $sender = array(
            'ems_type'=>$emstype,
            'track_number'=>$trackno,
            'cat_type'=>$emsCat,
            'weight'=>$weight,
            's_fullname'=>$s_fname,
            's_address'=>$s_address,
            's_mobile'=>$s_mobile,
            's_region'=>$o_region,
            's_district'=>$o_branch,
            'operator'=>$info->em_id,
            'add_type'=>$s_addressType);

            //saving of information of sender
        $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);

            //Receiver information
        $receiver = array(
            'from_id'=>$savedSenderInfoId,
            'fullname'=>$r_fname,
            'address'=>$r_address,
            'mobile'=>$r_mobile,
            'r_region'=>$rec_region,
            'branch'=>$rec_district,
            'add_type'=>$r_addressType);

            //saving information of receiver
        $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);

            //Calculating Price
            //$priceData = $this->Box_Application_model->ems_catPriceWeight10($emsCat,$weight);

        $priceData['emsprice'] = $this->input->post('Dpprice');
        $priceData['vat'] = $this->input->post('Dpvat');
        $priceData['totalPrice'] = $this->input->post('DpTotalPrice');

            //Saving transaction data
        $lastSavedId = $this->Box_Application_model->save_transactions(array(
            'transactiondate'=>date("Y-m-d"),
            'serial'=>$serial,
            'paidamount'=>$priceData['totalPrice'],
            'CustomerID'=>$savedSenderInfoId,
            'Customer_mobile'=>$s_mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'Barcode'=>$Barcode,
            'paymentFor'=>$PaymentFor));


            //for One Man
        $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
        $trace_data = array(
            'emid'=>$userid,
            'transid'=>$lastSavedId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'Acceptance');

            //for trace data
        $this->Box_Application_model->tracing($trace_data);
            //--------------------


        if ($lastSavedId) {
           $results['status'] = "Success";
                 //$results['message'] = "Successfull saved";

                //process controll number
           $transaction = $this->Control_Number_model->get_control_number(
            $serial,
            $priceData['totalPrice'],
            $o_region,
            $o_branch,
            $s_mobile,
            $s_fname,'EMS_POSTAGE',$trackno);

           if ($transaction) {
                    //update controll number after getting from the GateWay
            $this->billing_model->update_transactions(array(
                'billid'=>$transaction->controlno,
                'bill_status'=>'SUCCESS'),$transaction->billid);


            $sms ="KARIBU POSTA KIGANJANI umepatiwa ankara namba ".@$transaction->controlno." Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.".number_format($priceData['totalPrice'],2);

                      // $total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.@$transaction->controlno ;

                      //Send message
            $this->Sms_model->send_sms_trick($s_mobile,$sms);

            $results['message'] = $sms;

        }else{
            $results['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
        }

    }

         //}

    print_r(json_encode($results));
}else{
    redirect(base_url());
}
}

public function Olddocument_parcel_save(){
    if ($this->session->userdata('user_login_access') != false){

        $emstype = $this->input->post('emsname');
        $Barcode = $this->input->post('Barcode');
        $emsCat = $this->input->post('emscattype');
        $weight = $this->input->post('weight');

        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";


        if(empty($sender_address) && empty($receiver_address)){

           $addressT = "physical";
           $addressR = "physical";
           $s_fname = $this->input->post('s_fname');
           $s_address = $this->input->post('s_address');
           $s_email = $this->input->post('s_email');
           $s_mobile = $mobile = $this->input->post('s_mobile');
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(empty($sender_address) ){
        $addressT = "physical";
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');
    }

    if (empty($receiver_address)) {

       $addressR = "physical";
       $r_fname = $this->input->post('r_fname');
       $r_address = $this->input->post('r_address');
       $r_mobile = $this->input->post('r_mobile');
       $r_email = $this->input->post('r_email');
       $rec_region = $this->input->post('region_to');
       $rec_dropp = $this->input->post('district');

   }
   if (!empty($sender_address)) {

      $addressT = "virtual";

      $phone =  $sender_address;


      $post = array(
          'box'=>$phone
      );


      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL,$target_url);
      curl_setopt($curl, CURLOPT_POST,1);
        //curl_setopt($curl, CURLOPT_POST, count($post));
      curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
      curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
        //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
      $result = curl_exec($curl);
      $answer = json_decode($result);
      // return $result;
      // curl_close($curl);

      $s_fname = $answer->full_name;
      $s_address = $answer->phone;
      $s_email = '';
      $s_mobile = $answer->phone;

  }if(!empty($receiver_address)){

    $addressR = "virtual";
    $phone =  $receiver_address;


    $post = array(
      'box'=>$phone
  );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$target_url);
    curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    $answer = json_decode($result);

    $r_fname = $answer->full_name;
    $r_address = $answer->phone;
    $r_mobile = $answer->phone;
    $r_email = '';
    $rec_region = $answer->region;
    $rec_dropp = $answer->post_office;

}

$id = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);
$o_region = $info->em_region;
$o_branch = $info->em_branch;

$transactionstatus   = 'POSTED';
$bill_status  = 'PENDING';
$PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;
$source = $this->employee_model->get_code_source($o_region);
$dest = $this->employee_model->get_code_dest($rec_region);

$number = $this->getnumber();
$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
$serial    = 'EMS'.date("YmdHis").$source->reg_code;
$trackno = $bagsNo;

$getPending = $this->Box_Application_model->get_pending_task1($id);

if ( $getPending == 100) {

   $data['message'] = "You Have 100 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
   $this->load->view('ems/control-number-form',$data);

} else {

   $sender = array();
   $sender = array('ems_type'=>$emstype,'track_number'=>$trackno,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'add_type'=>$addressT);

   $db2 = $this->load->database('otherdb', TRUE);
   $db2->insert('sender_info',$sender);
   $last_id = $db2->insert_id();



   $receiver = array();
   $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

   $db2->insert('receiver_info',$receiver);

     //get price by cat id and weight range;

   if($weight > 10){

       $weight10    = 10;
       $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

       $vat10       = $getPrice->vat;
       $price10     = $getPrice->tariff_price;
       $totalprice10 = $vat10 + $price10;

       $diff   =  $weight - $weight10;

       if ($diff <= 0.5) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + 2300;
           } else {
            $totalPrice = $totalprice10 + 3500;
        }

    } else {

       $whole   = floor($diff);
       $decimal = fmod($diff,1);
       if ($decimal == 0) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
           } else {
            $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
        }

    } else {

       if ($decimal <= 0.5) {

        if ($emsCat == 1) {
           $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
       } else {
           $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
       }

   } else {

    if ($emsCat == 1) {
        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
    } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
   }
}

}
}

}else{

   $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}

$mobile = $s_mobile;


$data = array(

    'transactiondate'=>date("Y-m-d"),
    'serial'=>$serial,
    'paidamount'=>$totalPrice,
    'CustomerID'=>$last_id,
    'Customer_mobile'=>$s_mobile,
    'region'=>$o_region,
    'district'=>$o_branch,
    'transactionstatus'=>'POSTED',
    'bill_status'=>'PENDING',
    'Barcode'=>strtoupper($Barcode),
    'paymentFor'=>$PaymentFor

);

$lastSavedId = $this->Box_Application_model->save_transactions($data);
     //---------------
    //Tracing data
$emid = $this->session->userdata('user_login_id');
    //getting user or staff department section
$staff_section = $this->employee_model->getEmpDepartmentSections($emid);


    //for One Man
$office_trance_name  = (!empty(@$staff_section[0]['name']))? @$staff_section[0]['name']:'Counter';

    //for tracing
$trace_data = array(
    'emid'=>$emid,
    'transid'=>$lastSavedId,
    'office_name'=>@$office_trance_name,
    'description'=>'Acceptance',
    'status'=>'Acceptance');

    //for trace data
$this->Box_Application_model->tracing($trace_data);
    //--------------------


$paidamount = $totalPrice;
$region = $o_region;
$district = $o_branch;
     $renter   = $fullname;    //$emstype;
     $serviceId = 'EMS_POSTAGE';

     //check before send if saved
     $chck = $this->Box_Application_model->get_senderinfo_senderID($last_id);
     if(!empty($chck)){


       $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

       $trackNo=$trackno;

       if (!empty($transaction)) {

        @$serial1 = $transaction->billid;
        $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
        $this->billing_model->update_transactions($update,$serial1);

        //$serial1 = '995120555284';

        // $first4 = substr(@$transaction->controlno, 4);
        // $trackNo = $bagsNo.$first4;
        // $data1 = array();
        // $data1 = array('track_number'=>$trackNo);

        // $this->billing_model->update_sender_info($last_id,$data1);

        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;
        $data = array();
        $data = array('track_no'=>$trackno,'location'=>$location,'user'=>$user,'event'=>'Counter');

        $this->Box_Application_model->save_location($data);
        $data['sms'] = $total = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara namba'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

        $total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.@$transaction->controlno ;

        $this->Sms_model->send_sms_trick($s_mobile,$sms);

        $this->load->view('domestic_ems/control-number-form',$data);

    }else{
       $transaction1 = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

       @$serial1 = $transaction1->billid;
       $update = array('billid'=>@$transaction1->controlno,'bill_status'=>'SUCCESS');
       $this->billing_model->update_transactions($update,$serial1);

         //$serial1 = '995120555284';

        // $first4 = substr(@$transaction1->controlno, 4);
        // $trackNo = $bagsNo.$first4;
        // $data1 = array();
        // $data1 = array('track_number'=>$trackNo);

        // $this->billing_model->update_sender_info($last_id,$data1);

       $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
       $location= $info->em_region.' - '.$info->em_branch;
       $data = array();
       $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

       $this->Box_Application_model->save_location($data);
       $data['sms'] = $total = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara namba'. ' '.@$transaction1->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

       $total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.@$transaction1->controlno ;

       $this->Sms_model->send_sms_trick($s_mobile,$sms);

       $this->load->view('domestic_ems/control-number-form',$data);

   }

}else{

   $data['sms'] = $total = $sms ='Please Input again NOt Saved Successfull ';

   $this->load->view('domestic_ems/control-number-form',$data);


}
        # code...
}


}else{
    redirect(base_url());
}
}

public function document_parcel_bulk_save(){
    if ($this->session->userdata('user_login_access') != false){
        $userid = $this->session->userdata('user_login_id');

        $Barcode = strtoupper($this->input->post('Barcode'));
        $emstype = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');
        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');

        $addressT = "physical";
        $addressR = "physical";

        //Sender information
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        // $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');

        //Receiver information
        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        // $r_email = $this->input->post('r_email');
        $rec_region = $this->input->post('region_to');
        $rec_dropp = $this->input->post('district');

        //Staff information
        $info = $this->employee_model->GetBasic($userid);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

        $transactionstatus   = 'POSTED';
        $bill_status  = 'PENDING';
        $PaymentFor = 'EMS';
        $transactiondate = date("Y-m-d");
        $fullname  = $s_fname;
        $source = $this->employee_model->get_code_source($o_region);
        $dest = $this->employee_model->get_code_dest($rec_region);

        $number = $this->getnumber();
        $bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
        //Track number
        $trackno = $bagsNo;

        $serial = $this->input->post('serial');

        if(empty($serial)){
         $serial    = 'EMS'.date("YmdHis").$source->reg_code;
     }

     $getPending = $this->Box_Application_model->get_pending_task1($userid);

        //Database
     $db2 = $this->load->database('otherdb', TRUE);

     if ($getPending == 100) {

        $results['status'] = "Error";
        $results['message'] = "You Have 100 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";

    } else {

            //Sender information
       $sender = array(
        'ems_type'=>$emstype,
        'track_number'=>$trackno,
        'cat_type'=>$emsCat,
        'weight'=>$weight,
        's_fullname'=>$s_fname,
        's_address'=>$s_address,
                // 's_email'=>$s_email,
        's_mobile'=>$s_mobile,
        's_region'=>$o_region,
        's_district'=>$o_branch,
        'operator'=>$info->em_id,
        'add_type'=>$addressT,
        'track_number'=>$trackno);

             //saving of information of sender
       $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);

            //Receiver information
       $receiver = array(
        'from_id'=>$savedSenderInfoId,
        'fullname'=>$r_fname,
        'address'=>$r_address,
                // 'email'=>$r_email,
        'mobile'=>$r_mobile,
        'r_region'=>$rec_region,
        'branch'=>$rec_dropp,'
        add_type'=>$addressR);

             //saving information of receiver
       $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);


             //Calculating Price
            //$priceData = $this->Box_Application_model->ems_catPriceWeight10($emsCat,$weight);
       $priceData['emsprice'] = $this->input->post('Dpprice');
       $priceData['vat'] = $this->input->post('Dpvat');
       $priceData['totalPrice'] = $this->input->post('DpTotalPrice');




            //Saving transaction data
       $lastSavedId = $this->Box_Application_model->save_transactions(array(
        'transactiondate'=>date("Y-m-d"),
        'serial'=>$serial,
        'paidamount'=>$priceData['totalPrice'],
        'CustomerID'=>$savedSenderInfoId,
        'Customer_mobile'=>$s_mobile,
        'region'=>$o_region,
        'district'=>$o_branch,
        'transactionstatus'=>'POSTED',
        'Barcode'=>$Barcode,
        'bill_status'=>'PENDING',
        'paymentFor'=>$PaymentFor
                // 'track_number'=>$trackno
    ));


       if ($lastSavedId) {
        $results['status'] = "Success";

                //Get list of bulk
        $listbulk= $this->unregistered_model->GetListbulkTrans($userid,$serial);


        $messageData =  "<table style='width:100%;' class='table table-bordered'>
        <tr style='width:100%;color:#3895D3;'><th><b>SN</b></th><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";

        $alltotal = 0;
        $sn = 0;

        foreach ($listbulk as $key => $value) {

          $alltotal = $alltotal + $value->paidamount;
          $sn ++;

          $messageData.= "<tr class='".$value->track_number." itemRow' style='width:100%;color:#343434;'><td>".$sn."</td><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td><td><button 
          data-senderid='".$value->CustomerID."' 
          data-trackno='".$value->track_number."' 
          data-itemAmount='".$value->paidamount."'  
          class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete</button></td></tr>";
      }


      $messageData .= " <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b><span id='balanceRemain'>".$alltotal."</span></b></td></tr>
      </table><input type='hidden' name ='senders' value=".$savedSenderInfoId." class='senders'>
      <input type='hidden' name ='serial' value=".$serial." class='serial'><input type='hidden' name ='operator' value=".$userid." class='operator'>";

      $results['messageData'] = $messageData;
  }else{
    $results['status'] = "Success";
    $results['message'] = "Item not saved";
}

}

print_r(json_encode($results));
}else{
    redirect(base_url());
}
}


public function Olddocument_parcel_bulk_save()
{
    if ($this->session->userdata('user_login_access') != false)
    {

        $Barcode = $this->input->post('Barcode');
        $emstype = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');


        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";


        if(empty($sender_address) && empty($receiver_address)){

           $addressT = "physical";
           $addressR = "physical";
           $s_fname = $this->input->post('s_fname');
           $s_address = $this->input->post('s_address');
           $s_email = $this->input->post('s_email');
           $s_mobile = $mobile = $this->input->post('s_mobile');
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(empty($sender_address) ){
        $addressT = "physical";
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');
    }

    if (empty($receiver_address)) {

       $addressR = "physical";
       $r_fname = $this->input->post('r_fname');
       $r_address = $this->input->post('r_address');
       $r_mobile = $this->input->post('r_mobile');
       $r_email = $this->input->post('r_email');
       $rec_region = $this->input->post('region_to');
       $rec_dropp = $this->input->post('district');

   }
   if (!empty($sender_address)) {

      $addressT = "virtual";

      $phone =  $sender_address;


      $post = array(
          'box'=>$phone
      );


      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL,$target_url);
      curl_setopt($curl, CURLOPT_POST,1);
        //curl_setopt($curl, CURLOPT_POST, count($post));
      curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
      curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
        //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
      $result = curl_exec($curl);
      $answer = json_decode($result);
      // return $result;
      // curl_close($curl);

      $s_fname = $answer->full_name;
      $s_address = $answer->phone;
      $s_email = '';
      $s_mobile = $answer->phone;

  }if(!empty($receiver_address)){

    $addressR = "virtual";
    $phone =  $receiver_address;


    $post = array(
      'box'=>$phone
  );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$target_url);
    curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    $answer = json_decode($result);

    $r_fname = $answer->full_name;
    $r_address = $answer->phone;
    $r_mobile = $answer->phone;
    $r_email = '';
    $rec_region = $answer->region;
    $rec_dropp = $answer->post_office;

}

$id = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);
$o_region = $info->em_region;
$o_branch = $info->em_branch;

$transactionstatus   = 'POSTED';
$bill_status  = 'PENDING';
$PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;
$source = $this->employee_model->get_code_source($o_region);
$dest = $this->employee_model->get_code_dest($rec_region);

$number = $this->getnumber();
$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

$serial = $this->input->post('serial');
if(empty($serial)){
 $serial    = 'EMS'.date("YmdHis").$source->reg_code;

}

$trackno = $bagsNo;

$getPending = $this->Box_Application_model->get_pending_task1($id);

if ( $getPending == 100) {

   $data['message'] = "You Have 100 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
   $this->load->view('ems/control-number-form',$data);

} else {

   $sender = array();
   $sender = array('ems_type'=>$emstype,'track_number'=>$trackno,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'add_type'=>$addressT,'track_number'=>$trackno);

   $db2 = $this->load->database('otherdb', TRUE);
   $db2->insert('sender_info',$sender);
   $last_id = $db2->insert_id();



   $receiver = array();
   $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

   $db2->insert('receiver_info',$receiver);

     //get price by cat id and weight range;

   if($weight > 10){

       $weight10    = 10;
       $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

       $vat10       = $getPrice->vat;
       $price10     = $getPrice->tariff_price;
       $totalprice10 = $vat10 + $price10;

       $diff   =  $weight - $weight10;

       if ($diff <= 0.5) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + 2300;
           } else {
            $totalPrice = $totalprice10 + 3500;
        }

    } else {

       $whole   = floor($diff);
       $decimal = fmod($diff,1);
       if ($decimal == 0) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
           } else {
            $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
        }

    } else {

       if ($decimal <= 0.5) {

        if ($emsCat == 1) {
           $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
       } else {
           $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
       }

   } else {

    if ($emsCat == 1) {
        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
    } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
   }
}

}
}

}else{

   $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}

$mobile = $s_mobile;


$data = array(

    'transactiondate'=>date("Y-m-d"),
    'serial'=>$serial,
    'paidamount'=>$totalPrice,
    'CustomerID'=>$last_id,
    'Customer_mobile'=>$s_mobile,
    'region'=>$o_region,
    'district'=>$o_branch,
    'transactionstatus'=>'POSTED',
    'Barcode'=>strtoupper($Barcode),
    'bill_status'=>'PENDING',
    'paymentFor'=>$PaymentFor
        // 'track_number'=>$trackno

);

$this->Box_Application_model->save_transactions($data);

$id = $emid = $this->session->userdata('user_login_id');
$sender_id=$last_id;
$operator=$emid;
$listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


echo "<table style='width:100%;' class='table table-bordered'>
<tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
$alltotal = 0;
foreach ($listbulk as $key => $value) { 

  $alltotal =$alltotal + $value->paidamount;
  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
  <td>


  <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

  </td></tr>";
}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
</table>
<input type='hidden' name ='senders' value=".$sender_id." class='senders'>
<input type='hidden' name ='serial' value=".$serial." class='serial'>
<input type='hidden' name ='operator' value=".$operator." class='operator'>

";


        # code...
}


}else{
    redirect(base_url());
}
}


public function tbs_tanzania_document_parcel_bill_bulk_save()
{
    if ($this->session->userdata('user_login_access') != false)
    {

        $Barcode = strtoupper($this->input->post('Barcode'));
        $emstype = $this->input->post('emstype');
        $emsname = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');
        $cbranch = $this->input->post('cbranch');

        $sender = $this->input->post('sender');
        $senderp = $this->input->post('sender');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";

//get sender
        $info = $this->Box_Application_model->get_customer_infos($sender);
        $type = $info->acc_no;
        $getSum = $this->Box_Application_model->getSumPostPaid($type);
        if(!empty($info) ){
            $addressT = "physical";
            $s_fname =$info->customer_name;
            $s_address = $info->customer_address;
            $s_email = $info->cust_email;
            $s_mobile = $info->cust_mobile;
        }


        if (empty($receiver_address)) {

           $addressR = "physical";
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(!empty($receiver_address)){

        $addressR = "virtual";
        $phone =  $receiver_address;


        $post = array(
          'box'=>$phone
      );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$target_url);
        curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($curl);
        $answer = json_decode($result);

        $r_fname = $answer->full_name;
        $r_address = $answer->phone;
        $r_mobile = $answer->phone;
        $r_email = '';
        $rec_region = $answer->region;
        $rec_dropp = $answer->post_office;

    }


 //$ebranch = $this->session->userdata('user_branch');
    if($cbranch=="Tarakea(holoholo)" || $cbranch=="Namanga" || $cbranch=="Mtukula" || $cbranch=="Tunduma" || $cbranch=="Kyela" || $cbranch=="Kyaka" || $cbranch=="Rusumo" || $cbranch=="Kabanga" || $cbranch=="Bukoba" || $cbranch=="Kagera HPO" || $cbranch=="Karagwe"){

      if($weight > 10){

       $weight10    = 10;
       $getPrice    = $this->Box_Application_model->special_ems_cus_price($weight10,$cbranch);

       $vat       = $getPrice->vat;
       $price     = $getPrice->tariff_price;
       $totalprice10 = $vat + $price;

       $diff   =  $weight - $weight10;

       if ($diff <= 0.5) {


        $totalPrice = $totalprice10 + 3540;


    } else {

       $whole   = floor($diff);
       $decimal = fmod($diff,1);
       if ($decimal == 0) {


        $totalPrice = $totalprice10 + ($whole*1000/500)*3540;


    } else {

       if ($decimal <= 0.5) {


           $totalPrice = $totalprice10 + ($whole*1000/500)*3540 + 3540;


       } else {


           $totalPrice = $totalprice10 + ($whole*1000/500)*3540 + 3540+3540;

       }

   }
}

}else{

   $price = $this->Box_Application_model->special_ems_cus_price($weight,$cbranch);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}

 //END IF

}
else 
{
  //OTHER 

  if($weight > 10){

   $weight10    = 10;
   $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

   $vat       = $getPrice->vat;
   $price     = $getPrice->tariff_price;
   $totalprice10 = $vat + $price;

   $diff   =  $weight - $weight10;

   if ($diff <= 0.5) {

       if ($emsCat == 1) {
           $totalPrice = $totalprice10 + 2300;
       } else {
        $totalPrice = $totalprice10 + 3500;
    }

} else {

   $whole   = floor($diff);
   $decimal = fmod($diff,1);
   if ($decimal == 0) {

       if ($emsCat == 1) {
           $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
       } else {
        $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
    }

} else {

   if ($decimal <= 0.5) {

    if ($emsCat == 1) {
       $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
   } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
   }

} else {

    if ($emsCat == 1) {
        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
    } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
   }
}

}
}

}else{

   $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
     //$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}


}
 //END OTHER

$ids = $this->session->userdata('user_login_id');
$infos = $this->employee_model->GetBasic($ids);
$o_regions = $infos->em_region;
$o_branchs = $infos->em_branch;
$users = $infos->em_code.'  '.$infos->first_name.' '.$infos->middle_name.' '.$infos->last_name;


$o_region = $info->customer_region;
$o_branch = $info->customer_branch;
$source = $this->employee_model->get_code_source($o_regions);
$dest = $this->employee_model->get_code_dest($rec_region);
$number = $this->getnumber();
$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

$serial = $this->input->post('serial');
if(empty($serial)){
 $serial    = 'EMS'.date("YmdHis").$source->reg_code;

}

$trackno = $bagsNo;




// $transactionstatus   = 'POSTED';
// $bill_status  = 'PENDING';
// $PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;


$id = $this->session->userdata('user_login_id');
$getPending = $this->Box_Application_model->get_pending_task1($id);

if ( $getPending == 100) {

   $data['message'] = "You Have Pending Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
   $this->load->view('ems/control-number-form',$data);

} else {

    $i = $this->employee_model->GetBasic($id);

    $dataSection = $this->employee_model->getEmpDepartmentSections($id);

    $acc_no = $info->acc_no;
    if($info->customer_type == "PostPaid"){

        if($info->price < $totalPrice){

            echo 'Umefikia Kiwango Cha mwisho cha Kukopeshwa';

        }else{

            $diff = $info->price - $totalPrice;
            $up = array();
            $up = array('price'=>$diff);
            $this->Box_Application_model->update_price1($up,$acc_no);


            $sender = array();
            $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

            $db2->insert('receiver_info',$receiver);


            $mobile = $s_mobile;


            $emid = $this->session->userdata('user_login_id');
        //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        //for One Man
            $office_one_name  = (!empty(@$staff_section[0]['name']))? @$staff_section[0]['name']:'Counter';

            //$office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';


            $data = array();

            $data = array(

                'serial'=>$serial,
                'paidamount'=>$totalPrice,
                'CustomerID'=>$last_id,
                'Customer_mobile'=>$info->cust_mobile,
                'region'=>$o_regions,
                'district'=>$o_branchs,
                'Barcode'=>strtoupper($Barcode),
                'transactionstatus'=>'POSTED',
                'office_name'=>@$office_one_name,
                'created_by'=>$emid,
                'bill_status'=>'BILLING',
                'paymentFor'=>'EMS',
                'status'=>'Bill',
                'customer_acc'=>$info->acc_no,
                'item_vat'=>$vat
            // 'item_price'=>$price

            );



            $lastTransId  = $this->Box_Application_model->save_transactions($data);


        //for One Man
            $office_trance_name  = (!empty(@$staff_section[0]['name']))? @$staff_section[0]['name']:'Counter';


            //for tracing
            $trace_data = array(
                'emid'=>$emid,
                'transid'=>$lastTransId,
                'office_name'=>@$office_trance_name,
                'description'=>'Acceptance',
                'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


            $id = $emid = $this->session->userdata('user_login_id');
            $sender_id=$last_id;
            $operator=$emid;
            $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
            <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
            $alltotal = 0;
            foreach ($listbulk as $key => $value) { 

              $alltotal =$alltotal + $value->paidamount;
              echo "<tr style='width:100%;color:#343434;' class='trans".$value->id."'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
              <td>


              <button data-transid=".$value->id." data-senderid=".$value->CustomerID."  class='btn btn-info Delete' onclick=Deletevalue(this); type='button'   id='Delete'>Delete </button>

              </td></tr>";
          }



          echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
          </table>
          <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
          <input type='hidden' name ='sender' value=".$senderp." class='sender'>
          <input type='hidden' name ='serial' value=".$serial." class='serial'>
          <input type='hidden' name ='operator' value=".$operator." class='operator'>

          ";






      }

  }else{



    if ($info->price <= 20000) {
        echo "Please Recharge Your Account";
    } else {

        $diff = $info->price - $price1;
        $up = array();
        $up = array('price'=>$diff);
        $this->Box_Application_model->update_price($up,$acc_no);

        $sender = array();
        $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();


        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

        $db2->insert('receiver_info',$receiver);

        $data = array();
        $data = array(

            'serial'=>$serial,
            'paidamount'=>$totalPrice,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$info->cust_mobile,
            'region'=>$o_regions,
            'district'=>$o_branchs,
            'Barcode'=>strtoupper($Barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'paymentFor'=>'EMS',
            'status'=>'Bill',
            'customer_acc'=>$info->acc_no,
            'item_vat'=>$vat

        );

        $this->Box_Application_model->save_transactions($data);


        $id = $emid = $this->session->userdata('user_login_id');
        $sender_id=$last_id;
        $operator=$emid;
        $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


        echo "<table style='width:100%;' class='table table-bordered'>
        <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
        $alltotal = 0;
        foreach ($listbulk as $key => $value) { 

          $alltotal =$alltotal + $value->paidamount;
          echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
          <td>


          <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

          </td></tr>";
      }



      echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
      </table>
      <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
      <input type='hidden' name ='sender' value=".$senderp." class='sender'>
      <input type='hidden' name ='serial' value=".$serial." class='serial'>
      <input type='hidden' name ='operator' value=".$operator." class='operator'>

      ";





  }

}

}


}else{
    redirect(base_url());
}
}


public function document_parcel_bill_bulk_save(){
    if ($this->session->userdata('user_login_access') != false){
        $Barcode = strtoupper($this->input->post('Barcode'));
        $emstype = $this->input->post('emstype');
        $emsname = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');
        $snTag = $this->input->post('snTag');


        $sender = $this->input->post('sender');
        $senderp = $this->input->post('sender');

        $addressT = "physical";
        $addressR = "physical";

         //get sender
        $customerInfo = $this->Box_Application_model->get_customer_infos($sender);

        $s_fname =$customerInfo->customer_name;
        $s_address = $customerInfo->customer_address;
        $s_email = $customerInfo->cust_email;
        $s_mobile = $customerInfo->cust_mobile;

        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        $r_email = $this->input->post('r_email');
        $rec_region = $this->input->post('region_to');
        $rec_dropp = $this->input->post('district');


        
        $type = $customerInfo->acc_no;
        $acc_no = $customerInfo->acc_no;
        $getSum = $this->Box_Application_model->getSumPostPaid($type);


         //Calculating Price
        //$priceData = $this->Box_Application_model->ems_catPriceWeight10($emsCat,$weight);
        $priceData['emsprice'] = $this->input->post('Dpprice');
        $priceData['vat'] = $this->input->post('Dpvat');
        $priceData['totalPrice'] = $this->input->post('DpTotalPrice');


        $userid = $this->session->userdata('user_login_id');
        $infos = $this->employee_model->GetBasic($userid);
        $o_regions = $infos->em_region;
        $o_branchs = $infos->em_branch;
        $users = $infos->em_code.'  '.$infos->first_name.' '.$infos->middle_name.' '.$infos->last_name;

        //Customer address
        $o_region = $customerInfo->customer_region;
        $o_branch = $customerInfo->customer_branch;

        $source = $this->employee_model->get_code_source($o_regions);
        $dest = $this->employee_model->get_code_dest($rec_region);
        $number = $this->getnumber();
        $bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

        $serial = $this->input->post('serial');

        if(empty($serial)){
            $serial    = 'EMS'.date("YmdHis").$source->reg_code;
        }

        $trackno = $bagsNo;
        //Database instance
        $db2 = $this->load->database('otherdb', TRUE);


        //$transactionstatus   = 'POSTED';
        // $bill_status  = 'PENDING';
        // $PaymentFor = 'EMS';
        $transactiondate = date("Y-m-d");
        $fullname  = $s_fname;

        //$getPending = $this->Box_Application_model->get_pending_task1($userid);

        //Getting staff section
        $dataSection = $this->employee_model->getEmpDepartmentSections($userid);

        //checking for pending
        if($customerInfo->customer_type == "PostPaid"){

            if($customerInfo->price < $priceData['totalPrice']){

                $results['status'] = "Error";
                $results['message'] = "Umefikia Kiwango Cha mwisho cha Kukopeshwa";

            }else{

                $diff = $customerInfo->price - $priceData['totalPrice'];
                $this->Box_Application_model->update_price1(array('price'=>$diff),$acc_no);


                $sender = array(
                    'ems_type'=>$emsname,
                    'cat_type'=>$emsCat,
                    'weight'=>$weight,
                    's_fullname'=>$customerInfo->customer_name,
                    's_address'=>$customerInfo->customer_address,
                    's_email'=>$customerInfo->cust_email,
                    's_mobile'=>$customerInfo->cust_mobile,
                    's_region'=>$o_regions,
                    's_district'=>$o_branchs,
                    'track_number'=>$trackno,
                    's_pay_type'=>$customerInfo->customer_type,
                    'bill_cust_acc'=>$customerInfo->acc_no,'operator'=>$infos->em_id);


                         //saving of information of sender
                $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);


                $receiver = array(
                    'from_id'=>$savedSenderInfoId,
                    'fullname'=>$r_fname,
                    'address'=>$r_address,
                    'email'=>$r_email,
                    'mobile'=>$r_mobile,
                    'r_region'=>$rec_region,
                    'branch'=>$rec_dropp);

                         //saving information of receiver
                $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);

                $mobile = $s_mobile;

                if (isset($dataSection[0]['name'])){
                    $data = array(
                        'office_name'=> $dataSection[0]['name'],
                        'serial'=>$serial,
                        'paidamount'=>$priceData['totalPrice'],
                        'CustomerID'=>$savedSenderInfoId,
                        'Customer_mobile'=>$customerInfo->cust_mobile,
                        'region'=>$o_regions,
                        'district'=>$o_branchs,
                        'Barcode'=>$Barcode,
                        'transactionstatus'=>'POSTED',
                        'bill_status'=>'BILLING',
                        'paymentFor'=>'EMS',
                        'status'=>'Bill',
                        'customer_acc'=>$customerInfo->acc_no,
                        'item_vat'=>$priceData['vat'],
                        'created_by'=>$userid
                                // 'item_price'=>$price
                    );

                }else{
                    $data = array(
                        'serial'=>$serial,
                        'paidamount'=>$priceData['totalPrice'],
                        'CustomerID'=>$savedSenderInfoId,
                        'Customer_mobile'=>$customerInfo->cust_mobile,
                        'region'=>$o_regions,
                        'district'=>$o_branchs,
                        'Barcode'=>$Barcode,
                        'transactionstatus'=>'POSTED',
                        'bill_status'=>'BILLING',
                        'paymentFor'=>'EMS',
                        'status'=>'Bill',
                        'customer_acc'=>$customerInfo->acc_no,
                        'item_vat'=>$priceData['vat'],
                        'created_by'=>$userid
                                // 'item_price'=>$price
                    );
                }

                $lastId = $this->Box_Application_model->save_transactions($data);

                        //for tracing
                $trace_data = array(
                    'emid'=>$userid,
                    'transid'=>$lastId,
                    'office_name'=>'Pickup',
                    'status'=>'Acceptance');

                        //saving the transaction
                $this->Box_Application_model->tracing($trace_data);


    ///////////////////////MCT API BILLING

                if($customerInfo->customer_name=="MCT" && $customerInfo->acc_no=="POSTPAID-1583"){
                 $Updatesign = array(
                    'weight'=>$weight,
                    'paidamount'=>$priceData['totalPrice'],
                    'sendername'=>$customerInfo->customer_name,
                    'senderregion'=>$o_regions,
                    'senderbranch'=>$o_branchs,
                    'barcode'=>$Barcode,
                    'receivername'=>$r_fname,
                    'receiverregion'=>$rec_region,
                    'receiverbranch'=>$rec_dropp
                );

                 $url = "https://mct.go.tz/oas/ems/get_acceptance_info.php";
                 $ch = curl_init($url);
                 $json = json_encode($Updatesign);
                 curl_setopt($ch, CURLOPT_URL, $url);
        // For xml, change the content-type.
                 curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
                 curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

        // Send to remote and return data to caller.
        $response = curl_exec ($ch);
        $error    = curl_error($ch);
        $errno    = curl_errno($ch);
        curl_close ($ch);
        $updatesign = json_decode($response);

    }
                        ///////////////END OF MCT API BILLING

                        //New retunr to the view
    $results['status'] = "Success";

    $tranDetails  = $this->Box_Application_model->transanctionsData($lastId);

    $counting = $snTag+1;


    if ($tranDetails) {
        $results['message'] = 'Successfully saved';
        $results['counter'] = $counting;

        $transactionData =  "<tr style='width:100%;color:#343434;' class='trans".$tranDetails[0]['id']." receiveRowTrans'>
        <td>".$tranDetails[0]['fullname']."</td>
        <td>".$tranDetails[0]['s_fullname']."</td>
        <td>".$tranDetails[0]['s_region']."</td>
        <td>".$tranDetails[0]['s_district']."</td>
        <td>".$tranDetails[0]['r_region']."</td>
        <td>".$tranDetails[0]['branch']."</td>
        <td>".$tranDetails[0]['Barcode']."</td>
        <td>".number_format($tranDetails[0]['paidamount'],2)."</td>
        <td>
        <button 
        data-transid=".$tranDetails[0]['id']." 
        data-serial=".$tranDetails[0]['serial']." 
        data-senderid=".$tranDetails[0]['CustomerID']."  class='btn btn-info Delete' onclick=Deletevalue(this); type='button'   id='Delete'>Delete </button>
        </td></tr>";

        $results['messageData'] = $transactionData;

    }else{
        $results['message'] = $transactionData;
    }

}

}else{

    if ($customerInfo->price <= 20000) {

        $results['status'] = "Error";
        $results['message'] = "Please Recharge Your Account";

    } else {
        $diff = $customerInfo->price - $priceData['totalPrice'];
        $this->Box_Application_model->update_price1(array('price'=>$diff),$acc_no);


        $sender = array(
            'ems_type'=>$emsname,
            'cat_type'=>$emsCat,
            'weight'=>$weight,
            's_fullname'=>$customerInfo->customer_name,
            's_address'=>$customerInfo->customer_address,
            's_email'=>$customerInfo->cust_email,
            's_mobile'=>$customerInfo->cust_mobile,
            's_region'=>$o_regions,
            's_district'=>$o_branchs,
            'track_number'=>$trackno,
            's_pay_type'=>$customerInfo->customer_type,
            'bill_cust_acc'=>$customerInfo->acc_no,'operator'=>$infos->em_id);


                     //saving of information of sender
        $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);


        $receiver = array(
            'from_id'=>$savedSenderInfoId,
            'fullname'=>$r_fname,
            'address'=>$r_address,
            'email'=>$r_email,
            'mobile'=>$r_mobile,
            'r_region'=>$rec_region,
            'branch'=>$rec_dropp);

                     //saving information of receiver
        $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);

        $mobile = $s_mobile;


        $data = array(
            'serial'=>$serial,
            'paidamount'=>$priceData['totalPrice'],
            'CustomerID'=>$savedSenderInfoId,
            'Customer_mobile'=>$customerInfo->cust_mobile,
            'region'=>$o_regions,
            'district'=>$o_branchs,
            'Barcode'=>$Barcode,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'paymentFor'=>'EMS',
            'status'=>'Bill',
            'customer_acc'=>$customerInfo->acc_no,
            'item_vat'=>$priceData['vat']);


        $lastId = $this->Box_Application_model->save_transactions($data);

                    //for tracing
        $trace_data = array(
            'emid'=>$userid,
            'transid'=>$lastId,
            'office_name'=>'Pickup',
            'status'=>'Acceptance');

                    //saving the transaction
        $this->Box_Application_model->tracing($trace_data);

                    //New retunr to the view

        $results['status'] = "Success";


        $tranDetails  = $this->Box_Application_model->transanctionsData($lastId);

        if ($tranDetails) {
            $results['message'] = 'Successfully saved';

            $transactionData =  "<tr style='width:100%;color:#343434;' class='trans".$tranDetails[0]['id']."'>
            <td>".$tranDetails[0]['fullname']."</td>
            <td>".$tranDetails[0]['s_fullname']."</td>
            <td>".$tranDetails[0]['s_region']."</td>
            <td>".$tranDetails[0]['s_district']."</td>
            <td>".$tranDetails[0]['r_region']."</td>
            <td>".$tranDetails[0]['branch']."</td>
            <td>".$tranDetails[0]['Barcode']."</td>
            <td>".number_format($tranDetails[0]['paidamount'],2)."</td>
            <td>
            <button data-transid=".$tranDetails[0]['id']."  class='btn btn-info Delete' onclick=Deletevalue(this); type='button'   id='Delete'>Delete </button>
            </td></tr>";

            $results['messageData'] = $transactionData;

        }else{
            $results['message'] = $transactionData;
        }

    }



}

print_r(json_encode($results));
}else{
    redirect(base_url());
}

}




public function Olddocument_parcel_bill_bulk_save()
{
    if ($this->session->userdata('user_login_access') != false)
    {

        $Barcode = $this->input->post('Barcode');
        $emstype = $this->input->post('emstype');
        $emsname = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');
        $acc_no = $this->input->post('acc_no');

        $sender = $this->input->post('sender');
        $senderp = $this->input->post('sender');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";

//get sender
        $info = $this->Box_Application_model->get_customer_infos($sender);
        $type = $info->acc_no;
        $getSum = $this->Box_Application_model->getSumPostPaid($type);
        if(!empty($info) ){
            $addressT = "physical";
            $s_fname =$info->customer_name;
            $s_address = $info->customer_address;
            $s_email = $info->cust_email;
            $s_mobile = $info->cust_mobile;
        }


        if (empty($receiver_address)) {

           $addressR = "physical";
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(!empty($receiver_address)){

        $addressR = "virtual";
        $phone =  $receiver_address;


        $post = array(
          'box'=>$phone
      );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$target_url);
        curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($curl);
        $answer = json_decode($result);

        $r_fname = $answer->full_name;
        $r_address = $answer->phone;
        $r_mobile = $answer->phone;
        $r_email = '';
        $rec_region = $answer->region;
        $rec_dropp = $answer->post_office;

    }

    if($weight > 10){

       $weight10    = 10;
       $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

       $vat       = $getPrice->vat;
       $price     = $getPrice->tariff_price;
       $totalprice10 = $vat + $price;

       $diff   =  $weight - $weight10;

       if ($diff <= 0.5) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + 2300;
           } else {
            $totalPrice = $totalprice10 + 3500;
        }

    } else {

       $whole   = floor($diff);
       $decimal = fmod($diff,1);
       if ($decimal == 0) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
           } else {
            $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
        }

    } else {

       if ($decimal <= 0.5) {

        if ($emsCat == 1) {
           $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
       } else {
           $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
       }

   } else {

    if ($emsCat == 1) {
        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
    } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
   }
}

}
}

}else{


   $ebranch = $this->session->userdata('user_branch');
   if($acc_no == "POSTPAID-1651"){
       if($ebranch=="Tarakea(holoholo)" || $ebranch=="Namanga" || $ebranch=="Mtukula" || $ebranch=="Tunduma" || $ebranch=="Kyaka"){
           $price = $this->Box_Application_model->special_ems_cus_price($weight);
       }
       else
       {
           $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
       }
   }
   else
   {
       $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   }

     //$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}

$ids = $this->session->userdata('user_login_id');
$infos = $this->employee_model->GetBasic($ids);
$o_regions = $infos->em_region;
$o_branchs = $infos->em_branch;
$users = $infos->em_code.'  '.$infos->first_name.' '.$infos->middle_name.' '.$infos->last_name;


$o_region = $info->customer_region;
$o_branch = $info->customer_branch;
$source = $this->employee_model->get_code_source($o_regions);
$dest = $this->employee_model->get_code_dest($rec_region);
$number = $this->getnumber();
$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

$serial = $this->input->post('serial');
if(empty($serial)){
 $serial    = 'EMS'.date("YmdHis").$source->reg_code;

}

$trackno = $bagsNo;




// $transactionstatus   = 'POSTED';
// $bill_status  = 'PENDING';
// $PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;


$id = $this->session->userdata('user_login_id');
$getPending = $this->Box_Application_model->get_pending_task1($id);

if ( $getPending == 100) {

   $data['message'] = "You Have Pending Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
   $this->load->view('ems/control-number-form',$data);

} else {

    $i = $this->employee_model->GetBasic($id);

    $dataSection = $this->employee_model->getEmpDepartmentSections($id);

    $acc_no = $info->acc_no;
    if($info->customer_type == "PostPaid"){

        if($info->price < $totalPrice){

            echo 'Umefikia Kiwango Cha mwisho cha Kukopeshwa';

        }else{

            $diff = $info->price - $totalPrice;
            $up = array();
            $up = array('price'=>$diff);
            $this->Box_Application_model->update_price1($up,$acc_no);


            $sender = array();
            $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

            $db2->insert('receiver_info',$receiver);


            $mobile = $s_mobile;


            $data = array();

            if (@$dataSection[0]['name']){

                $data = array(
                    'office_name'=> $dataSection[0]['name'],
                    'serial'=>$serial,
                    'paidamount'=>$totalPrice,
                    'CustomerID'=>$last_id,
                    'Customer_mobile'=>$info->cust_mobile,
                    'region'=>$o_regions,
                    'district'=>$o_branchs,
                    'Barcode'=>$Barcode,
                    'transactionstatus'=>'POSTED',
                    'bill_status'=>'BILLING',
                    'paymentFor'=>'EMS',
                    'status'=>'Bill',
                    'customer_acc'=>$info->acc_no,
                    'item_vat'=>$vat,
                    'created_by'=>$id
            // 'item_price'=>$price
                );

            }else{

                $data = array(

                    'serial'=>$serial,
                    'paidamount'=>$totalPrice,
                    'CustomerID'=>$last_id,
                    'Customer_mobile'=>$info->cust_mobile,
                    'region'=>$o_regions,
                    'district'=>$o_branchs,
                    'Barcode'=>strtoupper($Barcode),
                    'transactionstatus'=>'POSTED',
                    'bill_status'=>'BILLING',
                    'paymentFor'=>'EMS',
                    'status'=>'Bill',
                    'customer_acc'=>$info->acc_no,
                    'item_vat'=>$vat
            // 'item_price'=>$price

                );

            }

            $lastId = $this->Box_Application_model->save_transactions($data);

        //for tracing
            $trace_data = array(
                'emid'=>$id,
                'transid'=>$lastId,
                'office_name'=>'Pickup',
                'status'=>'Acceptance');

        //saving the transaction
            $this->Box_Application_model->tracing($trace_data);


            $id = $emid = $this->session->userdata('user_login_id');
            $sender_id=$last_id;
            $operator=$emid;
            $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
            <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
            $alltotal = 0;
            foreach ($listbulk as $key => $value) { 

              $alltotal =$alltotal + $value->paidamount;
              echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
              <td>


              <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

              </td></tr>";
          }



          echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
          </table>
          <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
          <input type='hidden' name ='sender' value=".$senderp." class='sender'>
          <input type='hidden' name ='serial' value=".$serial." class='serial'>
          <input type='hidden' name ='operator' value=".$operator." class='operator'>

          ";






      }

  }else{



    if ($info->price <= 20000) {
        echo "Please Recharge Your Account";
    } else {

        $diff = $info->price - $price1;
        $up = array();
        $up = array('price'=>$diff);
        $this->Box_Application_model->update_price($up,$acc_no);

        $sender = array();
        $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();


        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

        $db2->insert('receiver_info',$receiver);

        $data = array();
        $data = array(

            'serial'=>$serial,
            'paidamount'=>$totalPrice,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$info->cust_mobile,
            'region'=>$o_regions,
            'district'=>$o_branchs,
            'Barcode'=>strtoupper($Barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'paymentFor'=>'EMS',
            'status'=>'Bill',
            'customer_acc'=>$info->acc_no,
            'item_vat'=>$vat

        );

        $lastId = $this->Box_Application_model->save_transactions($data);

        $emid = $this->session->userdata('user_login_id');

        //for tracing
        $trace_data = array(
            'emid'=>$emid,
            'transid'=>$lastId,
            'office_name'=>'Pickup',
            'status'=>'Acceptance');

        //saving the transaction
        $this->Box_Application_model->tracing($trace_data);


        $id = $emid = $this->session->userdata('user_login_id');
        $sender_id=$last_id;
        $operator=$emid;
        $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


        echo "<table style='width:100%;' class='table table-bordered'>
        <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
        $alltotal = 0;
        foreach ($listbulk as $key => $value) { 

          $alltotal =$alltotal + $value->paidamount;
          echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
          <td>


          <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

          </td></tr>";
      }



      echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
      </table>
      <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
      <input type='hidden' name ='sender' value=".$senderp." class='sender'>
      <input type='hidden' name ='serial' value=".$serial." class='serial'>
      <input type='hidden' name ='operator' value=".$operator." class='operator'>

      ";





  }

}

}


}else{
    redirect(base_url());
}
}

public function delete_ems_document_bulk_info_data(){
    if ($this->session->userdata('user_login_access') != false){
        $transId = $this->input->post('transactionid');
        $senderid = $this->input->post('senderid');

        $this->unregistered_model->delete_bulk_bysenderid_info($senderid);

    }else{
        redirect(base_url());
    }

}


public function delete_ems_document_bulk_info(){
    if ($this->session->userdata('user_login_access') != false){
        $userid  = $this->session->userdata('user_login_id');
        $senderid = $this->input->post('senderid');
        //$serial = $this->input->post('serial');
        $serial = $this->input->post('trackno');
        $itemAmount = $this->input->post('itemAmount');//need to be minus coz it removed item;
        $balanceRemain = $this->input->post('balanceRemain');

        $this->unregistered_model->delete_bulk_bysenderid_info($senderid);

        $response['status'] = 'Success';
        $response['balance'] = (!empty($itemAmount))? $balanceRemain - $itemAmount:$balanceRemain;

        print_r(json_encode($response));

    }else{
        redirect(base_url());
    }
    
}



public function Olddelete_ems_document_bulk_info()
{


 $senderid = $this->input->post('senderid');
 $serial = $this->input->post('serial');
            //echo $senderid;
             // echo $serial;

           // $senderid = base64_decode($this->input->get('I')); 
           //  $serial = base64_decode($this->input->get('S')); 

 $this->unregistered_model->delete_bulk_bysenderid_info($senderid);

 $emid  = $this->session->userdata('user_login_id');
 $operator=$emid;
 $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


 echo "<table style='width:100%;' class='table table-bordered'>
 <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
 $alltotal = 0;
 foreach ($listbulk as $key => $value) { 

  $alltotal =$alltotal + $value->paidamount;
  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
  <td>


  <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

  </td></tr>";
}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
</table>
<input type='hidden' name ='senders' value=".$senderid." class='senders'>
<input type='hidden' name ='serial' value=".$serial." class='serial'>
<input type='hidden' name ='operator' value=".$operator." class='operator'>

";


          // $this->session->set_flashdata('success','Deleted Successfull');
}


public function save_bulk_ddocument_info(){
    if ($this->session->userdata('user_login_access') != false){
        //user information
        $userid  = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($userid);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;

         //Sender information
        $s_region = $this->input->post('s_region');
        $s_district = $this->input->post('s_district');
        $s_fullname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_mobile = $mobile = $this->input->post('s_mobile');
        $paidamount = $mobile = $this->input->post('paidamount');

        //Post data from the view passed
        $serial = $this->input->post('serial');
        $operator = $this->input->post('operator');

        //$paidamount = $alltotal;
        $region = $info->em_region;
        $district = $info->em_branch;
        $renter   =  $s_fullname;
        $serviceId = 'EMS_POSTAGE';
        $trackNo = $serial;
        $mobile = $s_mobile;

        //LoggedIn information
        $sender_region = $this->session->userdata('user_region');
        $sender_branch = $this->session->userdata('user_branch');

        //check payment amount
        if ($paidamount) {

            $postbill =  $this->Control_Number_model->get_control_number(
                $serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 

            if ($postbill) {
               $response['status'] = 'Success';

               $this->billing_model->update_transactions(
                array(
                    'billid'=>$postbill->controlno,
                    'bill_status'=>'SUCCESS'),$serial);

                //message for sending to the customer
               $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

                //process of sending message
               $this->Sms_model->send_sms_trick($mobile,$sms);

               $response['message'] = $sms;
           }

       }else{
        $response['status'] = 'Error';
        $response['message'] = 'Hakuna ela inayolipiwa kwa huduma';
    }

    print_r(json_encode($response));
}else{
    redirect(base_url());
}

}



public function Oldsave_bulk_ddocument_info(){



 $id  = $this->session->userdata('user_login_id');
 $info = $this->employee_model->GetBasic($id);
 $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
 $location= $info->em_region.' - '.$info->em_branch;
 $serial = $this->input->post('serial');
 $operator = $this->input->post('operator');
 $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
 $alltotal = 0;

 foreach ($listbulk as $key => $value) {

  $alltotal =$alltotal + $value->paidamount;


  $data = array();
  $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

  $this->Box_Application_model->save_location($data);
}




$paidamount = $alltotal;
$region = $listbulk[0]->s_region;
$district = $listbulk[0]->s_district;
$renter   =  $listbulk[0]->s_fullname;
$serviceId = 'EMS_POSTAGE';
$trackNo = $serial;
$mobile = $listbulk[0]->s_mobile;



$sender_region = $this->session->userdata('user_region');
$sender_branch = $this->session->userdata('user_branch');



$postbill =  $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 
//$this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

if (!empty($postbill->controlno)  ) {



    $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial);

                // $update = array();

                // $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                // $this->unregistered_model->update_register_transactions1($update,$serial);

    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

            //if (!empty($transaction->$controlno)) {

                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);

    try {
       $this->Sms_model->send_sms_trick($mobile,$sms);
   }
   catch (Exception $e) {
                               //echo json_encode($sms); 
   }                  

   echo json_encode($sms);
}else{

    $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 

                // $trackno = array();

                //@$serial = $repostbill->billid;
    $update = array();
    $update = array('billid'=>@$repostbill->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial);

    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   

    try {
       $this->Sms_model->send_sms_trick($mobile,$sms);
   }
   catch (Exception $e) {
                               //echo json_encode($sms); 
   }

   echo json_encode($sms); 
}


}

public function save_bulk_bill_document_info(){



 $id  = $this->session->userdata('user_login_id');
 $info = $this->employee_model->GetBasic($id);
 $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
 $location= $info->em_region.' - '.$info->em_branch;
 $AskFor = $this->input->post('AskFor');
 $this->session->set_userdata('askfor',$AskFor);
 $serial = $this->input->post('serial');
 $operator = $this->input->post('operator');
 $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
 $alltotal = 0;

 foreach ($listbulk as $key => $value) {

  $alltotal =$alltotal + $value->paidamount;


  $data = array();
  $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

  $this->Box_Application_model->save_location($data);
}




$paidamount = @$alltotal;
$region = @$listbulk[0]->s_region;
$district = @$listbulk[0]->s_district;
$renter   =  @$listbulk[0]->s_fullname;
$serviceId = 'EMS_POSTAGE';
$trackNo = $serial;
$mobile = @$listbulk[0]->s_mobile;



$sender_region = $this->session->userdata('user_region');
$sender_branch = $this->session->userdata('user_branch');

echo "Successfully Saved";
        // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=EMS%20Postage'));


                // $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   




}



public function bulk_document_parcel_save()
{
    if ($this->session->userdata('user_login_access') != false)
    {

// $emstype = $this->input->post('emsname');
// $emsCat = $this->input->post('emscattype');
// $weight = $this->input->post('weight');

        $TotalNonweightamounts = $this->input->post('TotalNonweightamounts');
        $TotalNonweightvalues = $this->input->post('TotalNonweightvalues');
            //$OutstandingArray = $this->input->post('OutstandingArray');
            //$myArray2 = $_REQUEST['OutstandingArray'];
        if(!empty($_POST['NonweightArray']))
        {
            $myArray = $_POST['NonweightArray'];
            $NonweightArray    = json_decode($myArray);

        }

            //echo json_encode($NonweightArray);


        $sender_address = $this->input->post('s_mobilev');

        $target_url = "http://192.168.33.7/api/virtual_box/";


        if(empty($sender_address) ){

           $addressT = "physical";
           $s_fname = $this->input->post('s_fname');
           $s_address = $this->input->post('s_address');
           $s_email = $this->input->post('s_email');
           $s_mobile = $mobile = $this->input->post('s_mobile');


       }



       if (!empty($sender_address)) {

          $addressT = "virtual";

          $phone =  $sender_address;


          $post = array(
              'box'=>$phone
          );


          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL,$target_url);
          curl_setopt($curl, CURLOPT_POST,1);
        //curl_setopt($curl, CURLOPT_POST, count($post));
          curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
          curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
        //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
          curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
          $result = curl_exec($curl);
          $answer = json_decode($result);
      // return $result;
      // curl_close($curl);

          $s_fname = @$answer->full_name;
          $s_address = @$answer->phone;
          $s_email = '';
          $s_mobile = @$answer->phone;

      }





      $id = $this->session->userdata('user_login_id');
      $info = $this->employee_model->GetBasic($id);
      $o_region = $info->em_region;
      $o_branch = $info->em_branch;

      $transactionstatus   = 'POSTED';
      $bill_status  = 'PENDING';
      $PaymentFor = 'EMS';
      $transactiondate = date("Y-m-d");
      $fullname  = $s_fname;


      $getPending = $this->Box_Application_model->get_pending_task1($id);


      $source = $this->employee_model->get_code_source($o_region);
      $serial    = 'EMS'.date("YmdHis").$source->reg_code;
      $operator = $this->session->userdata('user_login_id');

//echo 'serial'.$serial;




      if($TotalNonweightamounts > 0 )
      {


        if($TotalNonweightvalues == 0){

    //echo json_encode($OutstandingArray);
//         $emstype = $this->input->post('emsname');
// $emsCat = $this->input->post('emscattype');
// $weight = $this->input->post('weight');

        //RECEIVER


            $receiver_address = $NonweightArray[0]->r_mobilev;
//echo $NonweightArray[0]->r_fname.' HIYO MOJA';//.$NonweightArray[0]->r_mobilev;




            if (empty($receiver_address)) {

               $addressR = "physical";
               $r_fname =$NonweightArray[0]->r_fname; 
               $r_address = $NonweightArray[0]->r_address;
               $r_mobile =$NonweightArray[0]->r_mobile; 
               $r_email = $NonweightArray[0]->r_email;
               $rec_region =$NonweightArray[0]->region_to; 
               $rec_dropp = $NonweightArray[0]->district;

           }

           if(!empty($receiver_address)){

            $addressR = "virtual";
            $phone =  $receiver_address;


            $post = array(
              'box'=>$phone
          );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL,$target_url);
            curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
            curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
            curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
            $result = curl_exec($curl);
            $answer = json_decode($result);

            $r_fname = @$answer->full_name;
            $r_address = @$answer->phone;
            $r_mobile = @$answer->phone;
            $r_email = '';
            $rec_region = @$answer->region;
            $rec_dropp = @$answer->post_office;



        }

        $dest = $this->employee_model->get_code_dest($rec_region);
        $bagsNo = @$source->reg_code . @$dest->reg_code;
        $operator = $this->session->userdata('user_login_id');


        $item = $NonweightArray[0]->item;
        $destination =$NonweightArray[0]->destination;
        $destinations =$NonweightArray[0]->destinations;


        $emstype =$destination;
        $emsCat = $destinations;
        $weight = $item;

        $randomNumber = rand(); 
        $first4 = substr(@$randomNumber, 4);
        $trackNo = $bagsNo.$first4;
        $track_number = $trackNo;
     //echo 'trackno '.$track_number;
     // echo 's_fullname'.$s_fname.' s_address '.$s_address.' s_email '.$s_email.' s_mobile'.$s_mobile.'s_region'.$o_region.'s_district'.$o_branch.'add_type'.$addressT;
     //echo 'track_number'.$track_number.'serial'.$serial.'operator'.$info->em_id;


        $sender = array();
        $sender = array('ems_type'=>$emstype,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'add_type'=>$addressT,'track_number'=>$track_number,'serial'=>$serial,'operator'=>$info->em_id);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();

     //echo 'saved  sender info';

      // $first4 = substr(@$transaction1->controlno, 4);
      //   $trackNo = $bagsNo.$first4;
      //   $data1 = array();
      //   $data1 = array('track_number'=>$trackNo);

      //   $this->billing_model->update_sender_info($last_id,$data1);

        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;
        $data = array();
        $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

        $this->Box_Application_model->save_location($data);




        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

        $db2->insert('receiver_info',$receiver);

     //get price by cat id and weight range;

        if($weight > 10){

           $weight10    = 10;
           $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

           $vat10       = $getPrice->vat;
           $price10     = $getPrice->tariff_price;
           $totalprice10 = $vat10 + $price10;

           $diff   =  $weight - $weight10;

           if ($diff <= 0.5) {

               if ($emsCat == 1) {
                   $totalPrice = $totalprice10 + 2300;
               } else {
                $totalPrice = $totalprice10 + 3500;
            }

        } else {

           $whole   = floor($diff);
           $decimal = fmod($diff,1);
           if ($decimal == 0) {

               if ($emsCat == 1) {
                   $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
               } else {
                $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
            }

        } else {

           if ($decimal <= 0.5) {

            if ($emsCat == 1) {
               $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
           } else {
               $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
           }

       } else {

        if ($emsCat == 1) {
            $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
        } else {
           $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
       }
   }

}
}

}else{

   $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}
$totalPrices= $totalPrice;
}
else 
{


    $totalPrices=0;
    foreach ($NonweightArray as $key => $variable) {

    //echo $variable->r_fname.' HIYO NYINGI';

                           //RECEIVER


        $receiver_address = $variable->r_mobilev;
                //echo $receiver_address.' SAFI';


        if (empty($receiver_address)) {

           $addressR = "physical";
           $r_fname =$variable->r_fname; 
           $r_address = $variable->r_address;
           $r_mobile =$variable->r_mobile; 
           $r_email = $variable->r_email;
           $rec_region =$variable->region_to; 
           $rec_dropp = $variable->district;

       }

       if(!empty($receiver_address)){

        $addressR = "virtual";
        $phone =  $receiver_address;


        $post = array(
          'box'=>$phone
      );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$target_url);
        curl_setopt($curl, CURLOPT_POST,1);
                    //curl_setopt($curl, CURLOPT_POST, count($post));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
                    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($curl);
        $answer = json_decode($result);

        $r_fname = @$answer->full_name;
        $r_address = @$answer->phone;
        $r_mobile = @$answer->phone;
        $r_email = '';
        $rec_region = @$answer->region;
        $rec_dropp = @$answer->post_office;

    }

                  //$source = $this->employee_model->get_code_source($o_region);
    $dest = $this->employee_model->get_code_dest($rec_region);

    $bagsNo = @$source->reg_code . @$dest->reg_code;
                //$serial    = 'EMS'.date("YmdHis").$source->reg_code;


    $item = $variable->item;
    $destination =$variable->destination;
    $destinations =$variable->destinations;

    $emstype =$destination;
    $emsCat = $destinations;
    $weight = $item;

                               // echo $emstype.' emstype';



                 // if ( $getPending == 10) {

                 //     $data['message'] = "You Have 10 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
                 //          $this->load->view('ems/control-number-form',$data);

                 // } else
    $randomNumber = rand(); 
    $first4 = substr(@$randomNumber, 4);
    $trackNo = $bagsNo.$first4;
    $track_number = $trackNo;
                     //echo $track_number.' trackno';


    $sender = array();
    $sender = array('ems_type'=>$emstype,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'add_type'=>$addressT,'track_number'=>$track_number,'serial'=>$serial);

    $db2 = $this->load->database('otherdb', TRUE);
    $db2->insert('sender_info',$sender);
    $last_id = $db2->insert_id();

                      // $first4 = substr(@$transaction1->controlno, 4);
                      //   $trackNo = $bagsNo.$first4;
                      //   $data1 = array();
                      //   $data1 = array('track_number'=>$trackNo);

                      //   $this->billing_model->update_sender_info($last_id,$data1);

    $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
    $location= $info->em_region.' - '.$info->em_branch;
    $data = array();
    $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

    $this->Box_Application_model->save_location($data);




    $receiver = array();
    $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

    $db2->insert('receiver_info',$receiver);

                     //get price by cat id and weight range;

    if($weight > 10){

       $weight10    = 10;
       $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

       $vat10       = $getPrice->vat;
       $price10     = $getPrice->tariff_price;
       $totalprice10 = $vat10 + $price10;

       $diff   =  $weight - $weight10;

       if ($diff <= 0.5) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + 2300;
           } else {
            $totalPrice = $totalprice10 + 3500;
        }

    } else {

       $whole   = floor($diff);
       $decimal = fmod($diff,1);
       if ($decimal == 0) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
           } else {
            $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
        }

    } else {

       if ($decimal <= 0.5) {

        if ($emsCat == 1) {
           $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
       } else {
           $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
       }

   } else {

    if ($emsCat == 1) {
        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
    } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
   }
}

}
}



}else{

   $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;


}




$totalPrices= $totalPrices + $totalPrice;
}
}


$totalPrice = $totalPrices;

$mobile = $s_mobile;

$data = array(

    'transactiondate'=>date("Y-m-d"),
    'serial'=>$serial,
    'paidamount'=>$totalPrice,
    'CustomerID'=>$last_id,
    'Customer_mobile'=>$s_mobile,
    'region'=>$o_region,
    'district'=>$o_branch,
    'transactionstatus'=>'POSTED',
    'bill_status'=>'PENDING',
    'paymentFor'=>$PaymentFor

);

$this->Box_Application_model->save_transactions($data);

$paidamount = $totalPrice;
$region = $o_region;
$district = $o_branch;
$renter   = $emstype;
$serviceId = 'EMS_POSTAGE';
$trackno = $bagsNo;

      //check before send if saved
$chck = $this->Box_Application_model->get_senderinfo_senderID($last_id);
if(!empty($chck)){

   $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);


   if (!empty($transaction)) {

    @$serial1 = $transaction->billid;
    $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial1);

        //$serial1 = '995120555284';

       //  $first4 = substr(@$transaction->controlno, 4);
       //  $trackNo = $bagsNo.$first4;
       //  $data1 = array();
       //  $data1 = array('track_number'=>$trackNo);

       //  $this->billing_model->update_sender_info($last_id,$data1);

       //   $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
       // $location= $info->em_region.' - '.$info->em_branch;
       // $data = array();
       // $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

       // $this->Box_Application_model->save_location($data);
    $data['sms'] = $total = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara namba'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

    $total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.@$transaction->controlno ;

    $this->Sms_model->send_sms_trick($s_mobile,$sms);

    echo json_encode($sms);

         //$this->load->view('domestic_ems/control-number-form',$data);

}else{
   $transaction1 = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

   @$serial1 = $transaction1->billid;
   $update = array('billid'=>@$transaction1->controlno,'bill_status'=>'SUCCESS');
   $this->billing_model->update_transactions($update,$serial1);

//         //$serial1 = '995120555284';

       //  $first4 = substr(@$transaction1->controlno, 4);
       //  $trackNo = $bagsNo.$first4;
       //  $data1 = array();
       //  $data1 = array('track_number'=>$trackNo);

       //  $this->billing_model->update_sender_info($last_id,$data1);

       // $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
       // $location= $info->em_region.' - '.$info->em_branch;
       //  $data = array();
       //  $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

       // $this->Box_Application_model->save_location($data);
   $data['sms'] = $total = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara namba'. ' '.@$transaction1->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

   $total2 ='The amount to be paid for EMS is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.@$transaction1->controlno ;

   $this->Sms_model->send_sms_trick($s_mobile,$sms);

   echo json_encode($sms);

        //$this->load->view('domestic_ems/control-number-form',$data);

}
        # code...
}else{

   $data['sms'] = $total = $sms ='Please Input again Not Saved Successfull ';

   echo json_encode($sms);


}

}


}else{
    redirect(base_url());
}
}

public function document_parcel_List()
{
    if ($this->session->userdata('user_login_access') != false){

        $emid = base64_decode($this->input->get('I'));
        $data['region'] = $this->employee_model->regselect();
        $data['emselect'] = $this->employee_model->emselect();
        $data['agselect'] = $this->employee_model->agselect();

        if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP") {

            $date = $this->input->post('date');
            $date2 = $this->input->post('date2');
            $month = $this->input->post('month');
            $month = $this->input->post('month');
            $month2 = $this->input->post('month2');
            $year4 = $this->input->post('year');
            $region = $this->input->post('region');
            $type = $this->input->post('ems_type');

            $data['total'] = $this->Box_Application_model->get_ems_sumACC($region,$date,$date2,$month,$month2,$year4,$type);
            $data['emslist'] = $this->Box_Application_model->get_ems_listAcc($region,$date,$date2,$month,$month2,$year4,$type);

        } else {

            $date = $this->input->post('date');
            $month = $this->input->post('month');

            if (!empty($date) || !empty($month)) {
                $data['total'] = $this->Box_Application_model->get_ems_sumSearch($date,$month);
                $data['emslist'] = $this->Box_Application_model->get_ems_listSearch($date,$month);
            } else {
                $data['total'] = $this->Box_Application_model->get_ems_sum();
                $data['emslist'] = $this->Box_Application_model->get_ems_list();
            }
        }   

        $this->load->view('domestic_ems/domestic_pacel_application_list',$data);

    }
    else{
        redirect(base_url());
    }

}

public function bulk_document_parcel_List()
{
    if ($this->session->userdata('user_login_access') != false){

        $emid = base64_decode($this->input->get('I'));
        $data['region'] = $this->employee_model->regselect();
        $data['emselect'] = $this->employee_model->emselect();
        $data['agselect'] = $this->employee_model->agselect();

        if ($this->session->userdata('user_type') == "ACCOUNTANT-HQ" || $this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "BOP") {

            $date = $this->input->post('date');
            $date2 = $this->input->post('date2');
            $month = $this->input->post('month');
        //$month = $this->input->post('month');
            $month2 = $this->input->post('month2');
            $year4 = $this->input->post('year');
            $region = $this->input->post('region');
            $type = $this->input->post('ems_type');
            if(empty($region))
            {
                $region = 'Dar es Salaam';
                $type = 'EMS';
                $data['total'] = $this->Box_Application_model->get_ems_sumACCs02($region,$date,$date2,$month,$month2,$year4,$type);
                $data['emslist'] = $this->Box_Application_model->get_ems_bulk_list2($region,$date,$date2,$month,$month2,$year4,$type);

            }else
            {
               $data['total'] = $this->Box_Application_model->get_ems_sumACCs02($region,$date,$date2,$month,$month2,$year4,$type);
               $data['emslist'] = $this->Box_Application_model->get_ems_bulk_list2($region,$date,$date2,$month,$month2,$year4,$type);

           }



       } else {

        $date = $this->input->post('date');
        $month = $this->input->post('month');

        if (!empty($date) || !empty($month)) {
            $data['total'] = $this->Box_Application_model->get_ems_sumSearch2($date,$month);
            $data['emslist'] = $this->Box_Application_model->get_ems_listSearch2($date,$month);
        } else {
            $data['total'] = $this->Box_Application_model->get_ems_sum2();
            $data['emslist'] = $this->Box_Application_model->get_ems_list2();
        }
    }   
    
    $this->load->view('domestic_ems/bulk-domestic-pacel-application-list',$data);

}
else{
    redirect(base_url());
}

}

public function GetBulklist()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1)
    {

     $serial = $this->input->post('serial');
     $list = $this->Box_Application_model->get_ems_bulk_receiver_list($serial);

     $items = array();
     foreach ($list as $key => $value) {
            # code...
        array_push($items, $value->amount);

    }
    $total = array_sum($items);

    if (empty($list)) {
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
        <tr><th>Receiver Name</th><th>Track Number </th><th>Address</th><th>Region</th><th>Branch</th></tr>
        <tr><td colspan='5'>No Data available</td></tr>
        </table>";

    }else{
                //echo json_encode($list);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
        <tr><th>Receiver Name</th><th>Track Number </th><th>Address</th><th>Region</th><th>Branch</th></tr>";
        $rows ="";

        foreach ($list as $value) {

            $rows1 = "<tr><td>".$value->fullname."</td><td>".$value->track_number ."</td><td>".$value->address."</td><td>".$value->r_region."</td><td>".$value->branch."</td></tr>";

            $rows =$rows.$rows1;
        }
        echo $rows;

        echo  "<tr><td></td><td></td><td></td><td></td><td></td></tr>

        </table> ";
                // <tr><td></td><td><b>Total:</b></td><td>".number_format($total,2)."</td></tr>


    }
}

}



public function Generate_Report(){

    if ($this->session->userdata('user_login_access') != false) {

     $catType = $this->input->post('catType');
     $reportType = $this->input->post('reportType');
     $year = $this->input->post('year');
     $date1 = $this->input->post('date1');
     $month = $this->input->post('month');
     $month1 = $this->input->post('month1');
     $month2 = $this->input->post('month2');
     $date2 = $this->input->post('date2');
     $dairly = $this->input->post('dairly');
     if ($catType == 'Document' || $catType == 'Parcel' ) {

        $Type = "EMS";
        $arr[]= array();
        $getReport = $this->dashboard_model->generate_report_over_all($catType,$year,$Type,$date1,$date2,$reportType,$month1,$month2,$month,$dairly);


        foreach ($getReport as $value) {
           $arr[] = array(
               'label' => $value->year,
               'value' => $value->value
           );

       }

   }else {

     $getReport = $this->dashboard_model->generate_report_other_all($catType,$year,$date1,$date2,$reportType,$month1,$month2,$month,$dairly);


     foreach ($getReport as $value) {
       $arr[] = array(
           'label' => $value->year,
           'value' => $value->value
       );

   }

}



$data = json_encode($arr);
echo $data;    

} else {
 redirect(base_url());
}

}


public function Pcum(){

    if ($this->session->userdata('user_login_access') != false) {

        $this->session->set_userdata('heading','Pcum');
        $this->session->set_userdata('list','Pcum_Transactions_List');
        $data['district'] = $this->dashboard_model->getdistrict();

        $this->load->view('domestic_ems/pcum-price-form',$data);

    } else {
     redirect(base_url());
 }

}


public function get_Zones(){

  if ($this->input->post('districtid') != '') {

      $objid = $this->input->post('districtid');
          //$get = $this->kpi_model->GetGoalsById2($objid);
      echo $this->dashboard_model->GetZonesById($objid);
  }

}

public function get_Zones_City(){

  if ($this->input->post('districtid') != '') {

      $districtid = $this->input->post('districtid');
      $zoneid = $this->input->post('zoneid');
          //$get = $this->kpi_model->GetGoalsById2($objid);
      echo $this->dashboard_model->GetZonesCityById($zoneid,$districtid);
  }

}

public function Pcum_price_vat(){

    if ($this->session->userdata('user_login_access') != false) {

        $weight = $this->input->post('weight');
        $zoneid = $this->input->post('zoneid');
        $city = $this->input->post('city');
        $distid = $this->input->post('distid');

        $price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);

        if (empty($price)) {

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th colspan='2'>Charges</th></tr>
            <tr><td><b>Price:</b></td><td>0</td></tr>
            <tr><td><b>Vat:</b></td><td>0</td></tr>
            <tr><td><b>Total Price:</b></td><td>0</td></tr>
            </table>";

        }else{

            $vat = $price->vat;
            $emsprice = $price->tarrif;
            $totalPrice = $vat + $emsprice;

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th colspan='2' style=''>Charges</th></tr>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>".$emsprice."</td></tr>
            <tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
            <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice,2)."</td></tr>
            </table>";

        }
    }else{
        redirect(base_url());
    }
}



public function pcum_transactions_save(){
    if ($this->session->userdata('user_login_access') != false){
        $userid = $this->session->userdata('user_login_id');

        $emstype = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $tariffCatCity = $this->input->post('tariffCatCity');
        $boxtypeDistrict = $this->input->post('boxtypeDistrict');
        $Barcode = $this->input->post('Barcode');
        $weight = $this->input->post('weight');

        //sender information
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $this->input->post('s_mobile');
        $s_addressType = $this->input->post('s_addressType');

        //receiver information
        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        $r_email = $this->input->post('r_email');
        $rec_region = $this->input->post('rec_region');
        $rec_district = $this->input->post('rec_dropp');
        $r_addressType = $this->input->post('r_addressType');


        $add_type_receiver = $this->input->post('add_type_receiver');
        $add_type_sender = $this->input->post('add_type_sender');

        $price = $this->input->post('price');

        //Staff information
        $info = $this->employee_model->GetBasic($userid);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

        //getting user or staff department section
        $staff_section = $this->employee_model->getEmpDepartmentSections($userid);

        //Timing
        $tz = 'Africa/Nairobi';
        $tz_obj = new DateTimeZone($tz);
        $today = new DateTime("now", $tz_obj);
        $CurrentDate = $today->format('Y-m-d');
        $CurrentDateTime = $today->format('YmdHis');


        $transactiondate = $CurrentDate;
        $fullname  = $s_fname;

        $serial  = $serial1  = 'pCUM'.$CurrentDateTime.$userid;
        $source = $this->employee_model->get_code_source($o_region);
        $bagsNo = $source->reg_code . $source->reg_code;
        $number = $this->getnumber();
        @$trackNo = 'Pcum'.@$source->reg_code . @$source->reg_code.$number.'TZ';


        $source_region = $this->employee_model->get_code_source($o_region);
        $destination_region = $this->employee_model->get_code_dest($rec_region);
        

        $db2 = $this->load->database('otherdb', TRUE);

        //Sender Information
        $sender = array(
            'ems_type'=>$emstype,
            'track_number'=>$trackNo,
            'cat_type'=>$emsCat,
            'weight'=>$weight,
            's_fullname'=>$s_fname,
            's_address'=>$s_address,
            's_mobile'=>$s_mobile,
            's_region'=>$o_region,
            's_district'=>$o_branch,
            'operator'=>$info->em_id,
            'add_type'=>$add_type_sender);

        //saving of information of sender
        $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);

        //Receiver information
        $receiver = array(
            'from_id'=>$savedSenderInfoId,
            'fullname'=>$r_fname,
            'address'=>$r_address,
            'mobile'=>$r_mobile,
            'r_region'=>$rec_region,
            'branch'=>$rec_district,
            'add_type'=>$add_type_receiver);

        //saving information of receiver
        $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);

        //Calculating Price
        //$priceData = $this->Box_Application_model->ems_catPriceWeight10($emsCat,$weight);

        $price = $this->dashboard_model->pcum_price($weight,$emsCat,$tariffCatCity,$boxtypeDistrict);
        $district_name =$this->dashboard_model->getPcumDistrict_ById($boxtypeDistrict);
        $district_name =  $district_name->district_name ;

        $vat = $price->vat;
        $emsprice = $price->tarrif;
        $Total = $vat + $emsprice;

        /*$priceData['emsprice'] = $this->input->post('Dpprice');
        $priceData['vat'] = $this->input->post('Dpvat');
        $priceData['totalPrice'] = $this->input->post('DpTotalPrice');*/

        $priceData['emsprice'] = $emsprice;
        $priceData['vat'] = $vat;
        $priceData['totalPrice'] = $Total;

        //Saving transaction data
        $lastSavedId = $this->Box_Application_model->save_transactions(array(
            'serial'=>$serial,
            'paidamount'=>$Total,
            'CustomerID'=>$savedSenderInfoId,
            'Barcode'=>$Barcode,
            'transactionstatus'=>'POSTED',
            'office_name'=>'PCUM',
            'bill_status'=>'PENDING',
            'PaymentFor'=>'PCUM'));


            //for One Man
        $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
        $trace_data = array(
            'emid'=>$userid,
            'transid'=>$lastSavedId,
            'office_name'=>$office_trance_name,
            'description'=>'Acceptance',
            'status'=>'Acceptance');

            //for trace data
        $this->Box_Application_model->tracing($trace_data);
            //--------------------


        if ($lastSavedId) {
           $results['status'] = "Success";
                 //$results['message'] = "Successfull saved";

                //process controll number
           $transaction = $this->Control_Number_model->get_control_number(
            $serial,
            $priceData['totalPrice'],
            $o_region,
            $o_branch,
            $s_mobile,
            $s_fname,'PCUM',$trackNo);

           if ($transaction) {
                    //update controll number after getting from the GateWay
            $this->billing_model->update_transactions(array(
                'billid'=>$transaction->controlno,
                'bill_status'=>'SUCCESS'),$transaction->billid);


            $sms ="KARIBU POSTA KIGANJANI umepatiwa ankara namba ".@$transaction->controlno." Kwaajili ya huduma ya PCUM,Kiasi unachotakiwa kulipia ni TSH.".number_format($priceData['totalPrice'],2);

                      //Send message
            $this->Sms_model->send_sms_trick($s_mobile,$sms);

            $results['message'] = $sms;

        }else{
            $results['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
        }

    }

    print_r(json_encode($results));
}else{
    redirect(base_url());
}
}



public function Oldpcum_transactions_save()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $this->session->set_userdata('heading','Pcum');
        $this->session->set_userdata('list','Pcum_Transactions_List');

        $Barcode = $this->input->post('Barcode');
        $weight = $this->input->post('weight');
        $distid = $this->input->post('district1');
        $zoneid = $this->input->post('zone');
        $city = $this->input->post('city');




        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";


        if(empty($sender_address) && empty($receiver_address)){

           $addressT = "physical";
           $addressR = "physical";
           $s_fname = $this->input->post('s_fname');
           $s_address = $this->input->post('s_address');
           $s_email = $this->input->post('s_email');
           $s_mobile = $mobile = $this->input->post('s_mobile');
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(empty($sender_address)){
        $addressT = "physical";
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');
    }

    if (empty($receiver_address)) {

       $addressR = "physical";
       $r_fname = $this->input->post('r_fname');
       $r_address = $this->input->post('r_address');
       $r_mobile = $this->input->post('r_mobile');
       $r_email = $this->input->post('r_email');
       $rec_region = $this->input->post('region_to');
       $rec_dropp = $this->input->post('district');

   }
   if (!empty($sender_address)) {

    $addressT = "virtual";

    $phone =  $sender_address;


    $post = array(
      'box'=>$phone
  );


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$target_url);
    curl_setopt($curl, CURLOPT_POST,1);
        //curl_setopt($curl, CURLOPT_POST, count($post));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
        //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    $answer = json_decode($result);
      // return $result;
      // curl_close($curl);

    $s_fname = $answer->full_name;
    $s_address = $answer->phone;
    $s_email = '';
    $s_mobile = $answer->phone;

}if(!empty($receiver_address)){

    $addressR = "virtual";
    $phone =  $receiver_address;


    $post = array(
      'box'=>$phone
  );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$target_url);
    curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    $answer = json_decode($result);

    $r_fname = $answer->full_name;
    $r_address = $answer->phone;
    $r_mobile = $answer->phone;
    $r_email = '';
    $rec_region = $answer->region;
    $rec_dropp = $answer->post_office;

}


$sender_region = $o_region = $this->session->userdata('user_region');
$sender_branch = $o_branch = $this->session->userdata('user_branch');

$id = $emid = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);
$serial  = $serial1  = 'pCUM'.date("YmdHis").$id;


$source = $this->employee_model->get_code_source($sender_region);
$bagsNo = $source->reg_code . $source->reg_code;


$number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

@$trackNo = 'Pcum'.@$source->reg_code . @$source->reg_code.$number.'TZ';



$price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
$district_name =$this->dashboard_model->getPcumDistrict_ById($distid);
$district_name =  $district_name->district_name ;

$vat = $price->vat;
$emsprice = $price->tarrif;
$Total = $vat + $emsprice;

$paidamount = $Total;
$sender = array();
$sender = array('weight'=>$weight,'track_number'=>$trackNo,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'add_type'=>$addressT);

$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('sender_info',$sender);
$last_id = $db2->insert_id();

$receiver = array();
$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$district_name,'branch'=>$city,'add_type'=>$addressR);

$db2->insert('receiver_info',$receiver);


            //getting user or staff department section
$staff_section = $this->employee_model->getEmpDepartmentSections($id);
            //for One Man
$office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';


$trans = array();
$trans = array(

    'serial'=>$serial,
    'paidamount'=>$Total,
    'CustomerID'=>$last_id,
    'Barcode'=>strtoupper($Barcode),
    'office_name'=>$office_trance_name,
    'created_by'=>$id,
    'transactionstatus'=>'POSTED',
    'bill_status'=>'PENDING',
    'PaymentFor'=>'PCUM',
    'region'=>$sender_region,
    'district'=>$sender_branch
);

$db2 = $this->load->database('otherdb', TRUE);
            // $db2->insert('transactions',$trans);
$lastId = $this->Box_Application_model->save_transactions($trans);


            //for tracing
$trace_data = array(
    'emid'=>$id,
    'transid'=>$lastId,
    'office_name'=>$office_trance_name,
    'description'=>'Acceptance',
    'status'=>'Acceptance');

            //saving the transaction
$this->Box_Application_model->tracing($trace_data);


$info = $this->employee_model->GetBasic($id);
$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
$location= $info->em_region.' - '.$info->em_branch;
$data = array();
$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

$this->Box_Application_model->save_location($data);


$renter   = $s_fname;
$serviceId = 'PCUM';
$trackno = $trackNo;
$postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

if (!empty($postbill->controlno)) {



                // $first4 = substr($postbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);

                // $this->billing_model->update_sender_info($last_id,$trackno);
    $serial = $postbill->billid;
    $update = array();
    $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial1);

    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Pcum ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

            //if (!empty($transaction->$controlno)) {

    $this->load->view('domestic_ems/pcum-control-number-form',$data);

    $this->Sms_model->send_sms_trick($s_mobile,$sms);

}else{

    $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                // $source = $this->employee_model->get_code_source($sender_region);
                // $dest = @$this->Parcel_model->get_country_price($emsCat);
                // $bagsNo = $source->reg_code . $source->reg_code;

                // $first4 = substr($repostbill->controlno, 4);
                // $trackNo = $bagsNo.$first4;
                // $trackno = array();
                // $trackno = array('track_number'=>$trackNo);
                // $info = $this->employee_model->GetBasic($id);
                // $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                // $location= $info->em_region.' - '.$info->em_branch;
                // $data = array();
                // $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                // $this->Box_Application_model->save_location($data);

                // $this->billing_model->update_sender_info($last_id,$trackno);

    @$serial = $repostbill->billid;
    $update = array();
    $update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial1);

    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa ankara  ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Pcum ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
    $this->load->view('domestic_ems/pcum-control-number-form',$data);    
}

}else{
    redirect(base_url());
}
}


public function delete_pcum_bulk_info(){
    $senderid = $this->input->post('senderid');
    $serial = $this->input->post('serial');

    $this->unregistered_model->delete_bulk_bysenderid_info($senderid);

    //$emid  = $this->session->userdata('user_login_id');
    //$operator=$emid;

    $response['status'] = 'Success';

    print_r(json_encode($response));
}


public function Olddelete_pcum_bulk_info()
{


 $senderid = $this->input->post('senderid');
 $serial = $this->input->post('serial');
            //echo $senderid;
             // echo $serial;

           // $senderid = base64_decode($this->input->get('I')); 
           //  $serial = base64_decode($this->input->get('S')); 

 $this->unregistered_model->delete_bulk_bysenderid_info($senderid);

 $emid  = $this->session->userdata('user_login_id');
 $operator=$emid;
 $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


 echo "<table style='width:100%;' class='table table-bordered'>
 <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination District</b></th><th><b>Destination </b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
 $alltotal = 0;
 foreach ($listbulk as $key => $value) { 

  $alltotal =$alltotal + $value->paidamount;
  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
  <td>


  <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete' value=".$value->sender_id.">Delete </button>

  </td></tr>";
}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
</table>
<input type='hidden' name ='senders' value=".$senderid." class='senders'>
<input type='hidden' name ='serial' value=".$serial." class='serial'>
<input type='hidden' name ='operator' value=".$operator." class='operator'>

";


          // $this->session->set_flashdata('success','Deleted Successfull');
}



public function pcum_bulk_transactions_save(){
    if ($this->session->userdata('user_login_access') != false){
        $userid = $this->session->userdata('user_login_id');

        $weight = $this->input->post('weight');
        $Barcode = $this->input->post('Barcode');
        $distid = $this->input->post('district1');
        $zoneid = $this->input->post('zone');
        $city = $this->input->post('city');

        $Barcode = $this->input->post('Barcode');
        $emstype = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');
        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');

        $snTag = $this->input->post('counterIterm');

        $snTag = $this->input->post('counterIterm');

         //getting user or staff department section
        $staff_section = $this->employee_model->getEmpDepartmentSections($userid);

        $addressT = "physical";
        $addressR = "physical";

        //Sender information
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        // $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');

        //Receiver information
        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        // $r_email = $this->input->post('r_email');
        $rec_region = $this->input->post('region_to');
        $rec_dropp = $this->input->post('district');

        //Staff information
        $info = $this->employee_model->GetBasic($userid);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;

        $transactionstatus   = 'POSTED';
        $bill_status  = 'PENDING';
        $PaymentFor = 'EMS';
        $transactiondate = date("Y-m-d");
        $fullname  = $s_fname;
        $source = $this->employee_model->get_code_source($o_region);
        $dest = $this->employee_model->get_code_dest($rec_region);

        //Balance
        $balance = $this->input->post('balance');


        $serial = $this->input->post('serial');
        if(empty($serial)){
         $serial = 'pCUM'.date("YmdHis").$source->reg_code;
     }

     $number = $this->getnumber();
        //Track number
     @$trackNo = 'Pcum'.@$source->reg_code .$number.'TZ';

        //Database
     $db2 = $this->load->database('otherdb', TRUE);


     $price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
     $district_name =$this->dashboard_model->getPcumDistrict_ById($distid);
     $district_name =  $district_name->district_name;

        //Sender information
     $sender = array(
        'ems_type'=>$emstype,
        'track_number'=>$trackNo,
        'cat_type'=>$emsCat,
        'weight'=>$weight,
        's_fullname'=>$s_fname,
        's_address'=>$s_address,
        's_mobile'=>$s_mobile,
        's_region'=>$o_region,
        's_district'=>$o_branch,
        'operator'=>$info->em_id,
        'add_type'=>$addressT,
        'track_number'=>$trackNo);

            //saving of information of sender
     $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);

            //Receiver information
     $receiver = array(
        'from_id'=>$savedSenderInfoId,
        'fullname'=>$r_fname,
        'address'=>$r_address,
        'mobile'=>$r_mobile,
        'r_region'=>$district_name,
        'branch'=>$city,'
        add_type'=>$addressR);

             //saving information of receiver
     $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);


     $vat = $price->vat;
     $emsprice = $price->tarrif;
     $Total = $vat + $emsprice;

     $priceData['emsprice'] = $emsprice;
     $priceData['vat'] = $vat;
     $priceData['totalPrice'] = $Total;

            //Saving transaction data
     $lastSavedId = $this->Box_Application_model->save_transactions(array(
        'transactiondate'=>date("Y-m-d"),
        'serial'=>$serial,
        'paidamount'=>$priceData['totalPrice'],
        'CustomerID'=>$savedSenderInfoId,
        'Customer_mobile'=>$s_mobile,
        'region'=>$o_region,
        'district'=>$o_branch,
        'transactionstatus'=>'POSTED',
        'Barcode'=>$Barcode,
        'bill_status'=>'PENDING',
        'office_name'=>'PCUM',
        'paymentFor'=>'PCUM'
    ));


            //for One Man
     $office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

            //for tracing
     $trace_data = array(
        'emid'=>$userid,
        'transid'=>$lastSavedId,
        'office_name'=>$office_trance_name,
        'description'=>'Acceptance',
        'status'=>'Acceptance');

            //saving the transaction
     $this->Box_Application_model->tracing($trace_data);

     $counting = $snTag+1;

     if ($lastSavedId) {
        $results['status'] = "Success";
        $results['counter'] = $counting;


        $tranDetails  = $this->Box_Application_model->transanctionsData($lastSavedId);

                //total amount
        $results['balance'] = $tranDetails[0]['paidamount'] + $balance;

        $transactionData =  "<tr style='width:100%;color:#343434;' class='trans".$tranDetails[0]['id']." receiveRowTrans'>
        <td>".$tranDetails[0]['fullname']."</td>
        <td>".$tranDetails[0]['s_fullname']."</td>
        <td>".$tranDetails[0]['s_region']."</td>
        <td>".$tranDetails[0]['s_district']."</td>
        <td>".$tranDetails[0]['r_region']."</td>
        <td>".$tranDetails[0]['branch']."</td>
        <td>".$tranDetails[0]['Barcode']."</td>
        <td>".number_format($tranDetails[0]['paidamount'],2)."</td>
        <td>
        <input type='hidden' name ='serial' value=".$serial." class='serial'>
        <button 
        data-transid=".$tranDetails[0]['id']." 
        data-item_amount=".$tranDetails[0]['paidamount']." 
        data-serial=".$tranDetails[0]['serial']." 
        data-senderid=".$tranDetails[0]['CustomerID']."  class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
        </td></td>";

        $results['messageData'] = $transactionData;

    }else{
        $results['status'] = "Success";
        $results['message'] = "Item not saved";
    }

    print_r(json_encode($results));
}else{
    redirect(base_url());
}
}



public function Oldpcum_bulk_transactions_save()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $this->session->set_userdata('heading','Pcum');
        $this->session->set_userdata('list','Pcum_Transactions_List');

        $weight = $this->input->post('weight');
        $Barcode = $this->input->post('Barcode');
        $distid = $this->input->post('district1');
        $zoneid = $this->input->post('zone');
        $city = $this->input->post('city');




        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";


        if(empty($sender_address) && empty($receiver_address)){

           $addressT = "physical";
           $addressR = "physical";
           $s_fname = $this->input->post('s_fname');
           $s_address = $this->input->post('s_address');
           $s_email = $this->input->post('s_email');
           $s_mobile = $mobile = $this->input->post('s_mobile');
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(empty($sender_address)){
        $addressT = "physical";
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');
    }

    if (empty($receiver_address)) {

       $addressR = "physical";
       $r_fname = $this->input->post('r_fname');
       $r_address = $this->input->post('r_address');
       $r_mobile = $this->input->post('r_mobile');
       $r_email = $this->input->post('r_email');
       $rec_region = $this->input->post('region_to');
       $rec_dropp = $this->input->post('district');

   }
   if (!empty($sender_address)) {

    $addressT = "virtual";

    $phone =  $sender_address;


    $post = array(
      'box'=>$phone
  );


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$target_url);
    curl_setopt($curl, CURLOPT_POST,1);
        //curl_setopt($curl, CURLOPT_POST, count($post));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
        //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    $answer = json_decode($result);
      // return $result;
      // curl_close($curl);

    $s_fname = $answer->full_name;
    $s_address = $answer->phone;
    $s_email = '';
    $s_mobile = $answer->phone;

}if(!empty($receiver_address)){

    $addressR = "virtual";
    $phone =  $receiver_address;


    $post = array(
      'box'=>$phone
  );

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL,$target_url);
    curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
    curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($curl);
    $answer = json_decode($result);

    $r_fname = $answer->full_name;
    $r_address = $answer->phone;
    $r_mobile = $answer->phone;
    $r_email = '';
    $rec_region = $answer->region;
    $rec_dropp = $answer->post_office;

}


$sender_region = $o_region = $this->session->userdata('user_region');
$sender_branch = $o_branch = $this->session->userdata('user_branch');
$source = $this->employee_model->get_code_source($o_region);
$dest = $this->employee_model->get_code_dest($rec_region);

$id = $emid = $this->session->userdata('user_login_id');
$info = $this->employee_model->GetBasic($id);


$serial = $this->input->post('serial');
if(empty($serial)){
 $serial = 'pCUM'.date("YmdHis").$source->reg_code;

}

$number = $this->getnumber();

@$trackNo = 'Pcum'.@$source->reg_code .$number.'TZ';


          //  $serial  = $serial1  = 'pCUM'.date("YmdHis").$id;



$price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
$district_name =$this->dashboard_model->getPcumDistrict_ById($distid);
$district_name =  $district_name->district_name ;

$vat = $price->vat;
$emsprice = $price->tarrif;
$Total = $vat + $emsprice;

$paidamount = $Total;
$sender = array();
$sender = array('weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'track_number'=>$trackNo,'add_type'=>$addressT);

$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('sender_info',$sender);
$last_id = $db2->insert_id();

$receiver = array();
$receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$district_name,'branch'=>$city,'add_type'=>$addressR);

$db2->insert('receiver_info',$receiver);




$info = $this->employee_model->GetBasic($id);
$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
$location= $info->em_region.' - '.$info->em_branch;
$data = array();
$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

$this->Box_Application_model->save_location($data);



            // $trans = array();
            // $trans = array(

            // 'serial'=>$serial,
            // 'paidamount'=>$Total,
            // 'CustomerID'=>$last_id,
            // 'transactionstatus'=>'POSTED',
            // 'bill_status'=>'PENDING',
            // 'PaymentFor'=>'PCUM'

            // );

            // $db2 = $this->load->database('otherdb', TRUE);
            // $db2->insert('transactions',$trans);

            // $renter   = 'Pcum';
            // $serviceId = 'EMS_POSTAGE';
            // $trackno = '009';



$data22 = array(

    'transactiondate'=>date("Y-m-d"),
    'serial'=>$serial,
    'paidamount'=>$Total,
    'CustomerID'=>$last_id,
    'Customer_mobile'=>$s_mobile,
    'region'=>$o_region,
    'district'=>$o_branch,
    'Barcode'=>strtoupper($Barcode),
    'transactionstatus'=>'POSTED',
    'bill_status'=>'PENDING',
    'paymentFor'=>'PCUM'

);

   //echo json_encode($data22) ;

    // $this->Box_Application_model->save_transactions($data22);
$lastId = $this->Box_Application_model->save_transactions($data22);

$id = $emid = $this->session->userdata('user_login_id');


    //getting user or staff department section
$staff_section = $this->employee_model->getEmpDepartmentSections($id);

    //for One Man
$office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

    //for tracing
$trace_data = array(
    'emid'=>$id,
    'transid'=>$lastId,
    'office_name'=>$office_trance_name,
    'description'=>'Acceptance',
    'status'=>'Acceptance');

    //saving the transaction
$this->Box_Application_model->tracing($trace_data);





$sender_id=$last_id;
$operator=$emid;
$listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


echo "<table style='width:100%;' class='table table-bordered'>
<tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination District</b></th><th><b>Destination </b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
$alltotal = 0;
foreach ($listbulk as $key => $value) { 

  $alltotal =$alltotal + $value->paidamount;
  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td><td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
  <td>


  <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

  </td></tr>";
}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
</table>
<input type='hidden' name ='senders' value=".$sender_id." class='senders'>
<input type='hidden' name ='serial' value=".$serial." class='serial'>
<input type='hidden' name ='operator' value=".$operator." class='operator'>

";


}else{
    redirect(base_url());
}
}

public function save_bulk_pcum_info(){
    if ($this->session->userdata('user_login_access') != false){
        //user information
        $userid  = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($userid);

         //Sender information
        $s_region = $this->input->post('s_region');
        $s_district = $this->input->post('s_district');
        $s_fullname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
        $s_mobile =  $this->input->post('s_mobile');
        $paidamount  = $this->input->post('paidamount');

        //Post data from the view passed
        $serial = $this->input->post('serial');
        $operator = $this->input->post('operator');

        //$paidamount = $alltotal;
        $region = $info->em_region;
        $district = $info->em_branch;
        $renter   =  $s_fullname;
        $serviceId = 'EMS_POSTAGE';
        $trackNo = $serial;
        $mobile = $s_mobile;

        //LoggedIn information
        $sender_region = $this->session->userdata('user_region');
        $sender_branch = $this->session->userdata('user_branch');

        $response = array();

         //print_r($serial);
            //die();

        //check payment amount
        if ($paidamount) {

            // $postbill =  $this->getBillGepgBillIdEMS($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo);

            $postbill =  $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 

            if ($postbill) {
               $response['status'] = 'Success';

               $this->billing_model->update_transactions(
                array(
                    'billid'=>$postbill->controlno,
                    'bill_status'=>'SUCCESS'),$serial);

                //message for sending to the customer
               $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

                //process of sending message
               $this->Sms_model->send_sms_trick($mobile,$sms);

               $response['message'] = $sms;
           }

       }else{
        $response['status'] = 'Error';
        $response['message'] = 'Hakuna ela inayolipiwa kwa huduma';
    }

    print_r(json_encode($response));
}else{
    redirect(base_url());
}

}

public function Oldsave_bulk_pcum_info(){



 $id  = $this->session->userdata('user_login_id');
 $info = $this->employee_model->GetBasic($id);
 $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
 $location= $info->em_region.' - '.$info->em_branch;
 $serial = $this->input->post('serial');
 $operator = $this->input->post('operator');
 $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
 $alltotal = 0;

 foreach ($listbulk as $key => $value) {

  $alltotal =$alltotal + $value->paidamount;


  $data = array();
  $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

  $this->Box_Application_model->save_location($data);

}




$paidamount = $alltotal;
$region = $listbulk[0]->s_region;
$district = $listbulk[0]->s_district;
$renter   =  $listbulk[0]->s_fullname;
$serviceId = 'PCUM';
$trackNo = $serial;
$mobile = $listbulk[0]->s_mobile;



$sender_region = $this->session->userdata('user_region');
$sender_branch = $this->session->userdata('user_branch');

$postbill =  $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 
//$this->getBillGepgBillId($serial, $paidamount,$district,$region,$mobile,$renter,$serviceId);

if (!empty($postbill->controlno)  ) {



    $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial);

                // $update = array();

                // $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                // $this->unregistered_model->update_register_transactions1($update,$serial);

    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Pcum  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

            //if (!empty($transaction->$controlno)) {

                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);

    try {
       $this->Sms_model->send_sms_trick($mobile,$sms);
   }
   catch (Exception $e) {
                               //echo json_encode($sms); 
   }                  

   echo json_encode($sms);
}else{

    $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 

                // $trackno = array();

                //@$serial = $repostbill->billid;
    $update = array();
    $update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
    $this->billing_model->update_transactions($update,$serial);

    $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Pcum  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                //$this->load->view('inlandMails/posts-cargo-control-number-form',$data);   

    try {
       $this->Sms_model->send_sms_trick($mobile,$sms);
   }
   catch (Exception $e) {
                               //echo json_encode($sms); 
   }

   echo json_encode($sms); 
}


}






public function Pcum_Transactions_List()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

       $this->session->set_userdata('heading','Pcum');
       $this->session->set_userdata('list','Pcum_Transactions_List');

       $fromdate = $this->input->post('fromdate');
       $todate = $this->input->post('todate');

            //$date = $this->input->post('date');
            //$month = $this->input->post('month');
       $status = $this->input->post('status');
       $search = $this->input->post('search');

       if ($search == "search") {
         $data['cargo'] = $this->Pcum_model->get_pcum_transList($fromdate,$todate,$status);
               // $data['cargo'] = $this->Pcum_model->get_pcum_search($date,$month,$status);
               // $data['sum']   = $this->Pcum_model->get_pcum_sum_search($date,$month,$status);
         $data['sum']   = $this->Pcum_model->get_pcum_transListSum($fromdate,$todate);
     } else {
                // $data['cargo'] = $this->Pcum_model->get_pcum_list();
        $data['cargo'] = $this->Pcum_model->get_pcum_transList($fromdagte="",$todatge="",$status="");
        $data['sum']   = $this->Pcum_model->get_pcum_transListSum($fromdate="",$todate="");
                // $data['sum']   = $this->Pcum_model->get_pcum_sum();
    }

            /*if ($search == "search") {
               $data['cargo'] = $this->Pcum_model->get_pcum_search($date,$month,$status);
               $data['sum']   = $this->Pcum_model->get_pcum_sum_search($date,$month,$status);
            } else {
                $data['cargo'] = $this->Pcum_model->get_pcum_list();
                $data['sum']   = $this->Pcum_model->get_pcum_sum();
            }*/
            
            $this->load->view('domestic_ems/pcum-transactions-list',$data);
            
        }else{
            redirect(base_url());
        }

    }


    public function Pcum_Sent_delivery()
    {
        // `serial` LIKE '%$type2%'
        if ($this->session->userdata('user_login_access') != false)
        {
            $type = $this->input->post('type');
            $select = $this->input->post('I');
            $emid = $this->input->post('emid');
            $id = $this->session->userdata('user_emid');

            $tz = 'Africa/Nairobi';
            $tz_obj = new DateTimeZone($tz);
            $today = new DateTime("now", $tz_obj);
            $date = $today->format('Y-m-d');


            if (!empty($select)) {
                for ($i=0; $i <@sizeof($select) ; $i++) {

                    $id = $select[$i];

                    $checkPay = $this->Box_Application_model->check_payment($id,$type);

                    if ($checkPay->status == 'Paid' || $checkPay->status == 'Bill') {   

                        $data = array();
                        $data = array('office_name'=>'Back');

                        $this->Box_Application_model->update_back_office($id,$data);

            $this->Box_Application_model->transfer_for_delivery($id); //update item_status
        }

    }
    echo "Successfully Send For delivery";
}else{

    echo "Please select item to transfer";
}
# code...


}
else{
    redirect(base_url());
}
}

 // public function Pcum_Bill_Customer_edit()
 //    {
 //        #Redirect to Admin dashboard after authentication
 //        if ($this->session->userdata('user_login_access') !=false){
 //           $crdtid = base64_decode($this->input->get('I'));
 //           $data['askfor'] = $this->input->get('AskFor');
 //           $this->session->set_userdata('askfor',@$askfor);
 //           $data['edit'] = $this->Bill_Customer_model->get_customer_bill_credit_by_id($crdtid);
 //            $this->load->view('inlandMails/bill-customer-register-form',$data);

 //            }else{
 //                redirect(base_ur());
 //            }
 //    }


public function Pcum_Bill_Customer()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $cust_name = $this->input->post('cust_name');
        $cust_address = $this->input->post('cust_address');
        $cust_mobile = $this->input->post('cust_mobile');
        $customer_region = $this->input->post('customer_region');
        $vrn = $this->input->post('vrn');
        $tin_number = $this->input->post('tin_number');
        $price = $this->input->post('price');

        $AgreedWeight = $this->input->post('AgreedWeight');
        $Agreedprice = $this->input->post('Agreedprice');

        $pcum_id = $this->input->post('pcum_id');
        $result = array();
        if(!empty($pcum_id)){

            $data = array();
            $data = array(

                'cust_name'=>$cust_name,
                'cust_address'=>$cust_address,
                'cust_mobile'=>$cust_mobile,
                'customer_region'=>$customer_region,
                'vrn'=>$vrn,
                'tin_number'=>$tin_number,
                'price'=>$price,
                'AgreedWeight'=>$AgreedWeight,
                'Agreedprice'=>$Agreedprice

            );
            $this->Pcum_model->update_pcum_customer($data,$pcum_id);


            $result['credit'] = $this->Pcum_model->get_pcum_bill_cust_details_info($pcum_id);

        }else{

            $data = array();
            $data = array(

                'cust_name'=>$cust_name,
                'cust_address'=>$cust_address,
                'cust_mobile'=>$cust_mobile,
                'customer_region'=>$customer_region,
                'vrn'=>$vrn,
                'tin_number'=>$tin_number,
                'price'=>$price,
                'AgreedWeight'=>$AgreedWeight,
                'Agreedprice'=>$Agreedprice

            );

            $this->Pcum_model->save_pcum_customer($data);

        }


        $this->load->view('pcum/bill-customer-register-form',$result);

    }else{
        redirect(base_url());
    }

}

public function Pcum_Bill_Customer_List()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $data['bill'] = $this->Pcum_model->get_bill_customer_list();
        $this->load->view('domestic_ems/bill-customer-list',$data);

    }else{
        redirect(base_url());
    }

}

public function Pcum_Bill_Transactions_List()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $date = $this->input->post('date');
        $data['month'] = $month = $this->input->post('month');
        $search = $this->input->post('search');
        $I = base64_decode($this->input->get('I'));
        $data['I'] = $I;

        if ($search == "search") {

         if (!empty($I)) {

            $data['cargo'] = $this->Pcum_model->pcum_bill_transactions_search_by_customer($date,$month,$I);
            $data['sum']   = $this->Pcum_model->get_pcum_bill_sum_search_by_customer($date,$month,$I);

        } else {

            $data['cargo'] = $this->Pcum_model->pcum_bill_transactions_search($date,$month);
            $data['sum']   = $this->Pcum_model->get_pcum_bill_sum_search($date,$month);

        }

    } else {

      if(!empty($I)) {

       $data['cargo'] = $this->Pcum_model->pcum_bill_transactions_by_customer($I);
       $data['sum'] = $this->Pcum_model->pcum_bill_sum_transactions_by_customer($I);

   } else {

       $data['cargo'] = $this->Pcum_model->pcum_bill_transactions();
       $data['sum'] = $this->Pcum_model->pcum_sum_bill_transactions();

   }

}

$this->load->view('domestic_ems/pcum-bill-transactions-list',$data);

}else{
    redirect(base_url());
}

}

public function Bill_Customer_Transaction()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $this->session->set_userdata('heading','Pcum');
        $this->session->set_userdata('list','Pcum_Transactions_List');
        $data['district'] = $this->dashboard_model->getdistrict();
        $data['cust_id'] =$cust_id = base64_decode($this->input->get('I'));

            //$data['credit'] = $this->Pcum_model->get_pcum_bill_cust_details_info($cust_id);
        $data['custinfo'] = $this->Pcum_model->get_pcum_bill_cust_details_info($cust_id);
        $this->load->view('pcum/bulk-pcum-bill-form',$data);
            //$this->load->view('domestic_ems/pcum-bill-form',$data);

    }else{
        redirect(base_url());
    }

}


public function pcum_bulk_bill_transactions_save(){
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $this->session->set_userdata('heading','Pcum');
        $this->session->set_userdata('list','Pcum_Transactions_List');

        $weight = $this->input->post('weight');
        $Agreedprice = $this->input->post('Agreedprice');
        $AgreedWeight = $this->input->post('AgreedWeight');
        $Barcode = $this->input->post('Barcode');
        $distid = $this->input->post('district1');
        $zoneid = $this->input->post('zone');
        $city = $this->input->post('city');
        $custId = $this->input->post('cust_id');
        $senderInfo = $this->Pcum_model->get_customer_info($custId);






        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";


        if(empty($sender_address) && empty($receiver_address)){

           $addressT = "physical";
           $addressR = "physical";
           $s_fname = $this->input->post('s_fname');
           $s_address = $this->input->post('s_address');
 // $s_email = $this->input->post('s_email');
           $s_mobile = $mobile = $this->input->post('s_mobile');
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
 // $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(empty($sender_address)){
        $addressT = "physical";
        $s_fname = $this->input->post('s_fname');
        $s_address = $this->input->post('s_address');
 // $s_email = $this->input->post('s_email');
        $s_mobile = $mobile = $this->input->post('s_mobile');
    }

    if (empty($receiver_address)) {

       $addressR = "physical";
       $r_fname = $this->input->post('r_fname');
       $r_address = $this->input->post('r_address');
       $r_mobile = $this->input->post('r_mobile');
 // $r_email = $this->input->post('r_email');
       $rec_region = $this->input->post('region_to');
       $rec_dropp = $this->input->post('district');

   }



   $sender_region = $o_region = $this->session->userdata('user_region');
   $sender_branch = $o_branch = $this->session->userdata('user_branch');
   $source = $this->employee_model->get_code_source($o_region);
   $dest = $this->employee_model->get_code_dest($rec_region);

   $id = $emid = $this->session->userdata('user_login_id');
   $info = $this->employee_model->GetBasic($id);


   $serial = $this->input->post('serial');
   if(empty($serial)){
     $serial = 'pCUM'.date("YmdHis").$source->reg_code;

 }

 $number = $this->getnumber();

 @$trackNo = 'Pcum'.@$source->reg_code .$number.'TZ';


     //$price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
 $district_name =$this->dashboard_model->getPcumDistrict_ById($distid);
 $district_name =  $district_name->district_name ;

 if($AgreedWeight >= $weight){

    $price = $Agreedprice;
    $vat = $price * 18/100;
    $emsprice =$price + $vat;
    $Total = $emsprice;
    $diff = $senderInfo->price - $Total;

}else{

    $price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
    $vat = $price->vat;
    $emsprice = $price->tarrif;
    $Total = $vat + $emsprice;
    $diff = $senderInfo->price - $Total;

}


$paidamount = $Total;
$sender = array();
$sender = array(
    'weight'=>$weight,
    'track_number'=>$Barcode,
    'ems_type'=>'PCUM',
    'cat_type'=>'PCUM',
    's_fullname'=>$s_fname,
    's_address'=>$s_address,
    's_mobile'=>$mobile,
    's_region'=>$o_region,
    's_district'=>$o_branch,
    'operator'=>$info->em_id,
    'service_type'=>'PCUM',
    'amount'=>$Total,
    'bill_cust_acc'=>$custId,
    'add_type'=>$addressT,
    's_pay_type'=>'Bill');

$db2 = $this->load->database('otherdb', TRUE);
$db2->insert('sender_info',$sender);
$last_id = $db2->insert_id();

$updatePcum = array();
$updatePcum = array('price'=>$diff);
$db2->where('pcum_id',$custId);
$db2->update('pcum_bill',$updatePcum);

$receiver = array();
$receiver = array(
    'from_id'=>$last_id,
    'fullname'=>$r_fname,
    'address'=>$r_address,
    'mobile'=>$r_mobile,
    'r_region'=>$district_name,
    'branch'=>$city,
    'add_type'=>$addressR);

$db2->insert('receiver_info',$receiver);


$info = $this->employee_model->GetBasic($id);
$user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
$location= $info->em_region.' - '.$info->em_branch;
$data = array();
$data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

$this->Box_Application_model->save_location($data);

$id = $emid = $this->session->userdata('user_login_id');


    //getting user or staff department section
$staff_section = $this->employee_model->getEmpDepartmentSections($id);

    //for One Man
$office_trance_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name']:'Counter';

$data22 = array(
    'serial'=>$serial,
    'paidamount'=>$Total,
    'CustomerID'=>$last_id,
    'Customer_mobile'=>$s_mobile,
    'region'=>$o_region,
    'district'=>$o_branch,
    'Barcode'=>$Barcode,
    'item_vat'=>$vat,
    'item_price'=>$emsprice,
    'transactionstatus'=>'POSTED',
    'bill_status'=>'BILLING',
    'status'=>'Bill',
    'paymentFor'=>'PCUM',
    'office_name'=>$office_trance_name,
    'created_by'=>$id,
);

    // $this->Box_Application_model->save_transactions($data22);
$lastId = $this->Box_Application_model->save_transactions($data22);


    //for tracing
$trace_data = array(
    'emid'=>$id,
    'transid'=>$lastId,
    'office_name'=>$office_trance_name,
    'description'=>'Acceptance',
    'status'=>'Acceptance');

    //saving the transaction
$this->Box_Application_model->tracing($trace_data);

$sender_id=$last_id;
$operator=$emid;
$listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


echo "<table style='width:100%;' class='table table-bordered'>
<tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th>
<th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination District</b></th><th><b>Destination </b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
$alltotal = 0;
foreach ($listbulk as $key => $value) { 

  $alltotal =$alltotal + $value->paidamount;

  echo "<tr class='".$value->Barcode."' style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td><td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
  <td>


  <button  

  data-registerid='".$value->CustomerID."'
  data-barcodeno='".$value->Barcode."'
  data-item_amount='".$value->paidamount."'

  class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>

  </td></tr>";
}

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>




echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b><input type='text' id='totalAmount' readonly value='".$alltotal."'/></b></td></tr>
</table>
<input type='hidden' name ='senders' value=".$sender_id." class='senders'>
<input type='hidden' name ='serial' value=".$serial." class='serial'>
<input type='hidden' name ='operator' value=".$operator." class='operator'>

";


}else{
    redirect(base_url());
}
}



public function bil_save_bulk_pcum_info(){
 $id  = $this->session->userdata('user_login_id');
 $info = $this->employee_model->GetBasic($id);
 $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
 $location= $info->em_region.' - '.$info->em_branch;
 $serial = $this->input->post('serial');
 $operator = $this->input->post('operator');
 $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
 $alltotal = 0;


 foreach ($listbulk as $key => $value) {

  $alltotal =$alltotal + $value->paidamount;
  $s_mobile = $value->s_mobile;


  $data = array();
  $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

  $this->Box_Application_model->save_location($data);


  $sms ='KARIBU POSTA KIGANJANI umepatiwa track number hii hapa'. ' '.$value->track_number.' Kwaajili ya huduma ya Pcum'.'';
  $this->Sms_model->send_sms_trick($s_mobile,$sms);

}




$paidamount = $alltotal;
$region = $listbulk[0]->s_region;
$district = $listbulk[0]->s_district;
$renter   =  $listbulk[0]->s_fullname;
$serviceId = 'PCUM';
$trackNo = $serial;
$mobile = $listbulk[0]->s_mobile;



$sender_region = $this->session->userdata('user_region');
$sender_branch = $this->session->userdata('user_branch');
}

public function pcum_transactions_bill_save()
{
        #Redirect to Admin dashboard after authentication
    if ($this->session->userdata('user_login_access') == 1){

        $this->session->set_userdata('heading','Pcum');
        $this->session->set_userdata('list','Pcum_Transactions_List');

        $weight = $this->input->post('weight');
        $barcode = $this->input->post('barcode');
        $distid = $this->input->post('district');
        $zoneid = $this->input->post('zone');
        $city = $this->input->post('city');
        $custId = $this->input->post('cust_id');
        $senderInfo = $this->Pcum_model->get_customer_info($custId);

        $s_fname = $senderInfo->cust_name;
        $s_address = $senderInfo->cust_address;
        $s_mobile = $mobile = $senderInfo->cust_mobile;
        $s_email = '';
        $r_fname = $this->input->post('r_fname');
        $r_address = $this->input->post('r_address');
        $r_mobile = $this->input->post('r_mobile');
        $r_email = $this->input->post('r_email');
        $sender_region = $o_region = $this->session->userdata('user_region');
        $sender_branch = $o_branch = $this->session->userdata('user_branch');
        $id = $emid = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($id);
        $db2 = $this->load->database('otherdb', TRUE);

        if($senderInfo->AgreedWeight >= $weight){

            $price = $senderInfo->Agreedprice;
            $vat = 0;
            $emsprice =$price ;
            $Total = $price;
            $diff = $senderInfo->price - $Total;

        }else{

            $price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
            $vat = $price->vat;
            $emsprice = $price->tarrif;
            $Total = $vat + $emsprice;
            $diff = $senderInfo->price - $Total;

        }




        $update = array();
        $update = array('price'=>$diff);
        $db2->where('pcum_id',$senderInfo->pcum_id);
        $db2->update('pcum_bill',$update);

        $source = $this->employee_model->get_code_source($sender_region);
        $dest = $this->employee_model->get_code_dest($sender_region);
        $number = $this->getnumber();
        $bagsNo = 'Pcum'.@$source->reg_code . @$dest->reg_code.$number.'TZ';
        $trackingno =$bagsNo;

        $paidamount = $Total;
        $sender = array();
        $sender = array('weight'=>$weight,'track_number'=>$barcode,'ems_type'=>'PCUM','cat_type'=>'PCUM','s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'service_type'=>'PCUM','amount'=>$Total,'bill_cust_acc'=>$custId);


        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();

        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$o_region,'branch'=>$city);

        $db2->insert('receiver_info',$receiver);



        $info = $this->employee_model->GetBasic($id);
        $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
        $location= $info->em_region.' - '.$info->em_branch;
        $data = array();
        $data = array('track_no'=>$trackingno,'location'=>$location,'user'=>$user,'event'=>'Counter');

        $this->Box_Application_model->save_location($data);

        $serial    = 'Pcum'.date("YmdHis").$source->reg_code;


        $data22 = array(
            'serial'=>$serial,
            'paidamount'=>$Total,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$s_mobile,
            'region'=>$o_region,
            'Barcode'=>$barcode,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'status'=>'Bill',
            'paymentFor'=>'PCUM'
        );

        $this->Box_Application_model->save_transactions($data22);






        redirect(base_url('Ems_Domestic/Pcum_Bill_Transactions_List'));

    }else{
        redirect(base_url());
    }
}

public function invoice_sheet()
{
    if ($this->session->userdata('user_login_access') != false)
    {

    //$data['id'] = base64_decode($this->input->get('I'));
        $acc_no = $custId = $I = $this->input->get('acc_no');
        $data['month'] = $month = $this->input->get('month');
    //$cun = $this->input->get('cun');
        $date = '';

        $data['custinfo'] = $this->Pcum_model->get_customer_info($custId);
        $data['emslist'] = $this->Pcum_model->pcum_bill_transactions_search_by_customer($date,$month,$I);
        $data['sum']   = $this->Pcum_model->get_pcum_bill_sum_search_by_customer($date,$month,$I);

        $data['invoice'] = rand(10000,20000);


     // foreach ($data['emslist'] as $value) {
     //            $id = $value->id;
     //            $update1 = array();
     //             $update1 = array('isBill_Id'=>'Ye');
     //            $this->billing_model->update_transactionsere($update1,$id);
     // }

        $paidamount = $data['sum']->total;
        $credit_id = $data['custinfo']->pcum_id;
        $sender_branch = $this->session->userdata('user_branch');
        $sender_region = $this->session->userdata('user_region');
        $s_mobile = $data['custinfo']->cust_mobile;

        $serial1 = $serial = "Ems_billing".date("YmdHis").$this->session->userdata('user_emid');

        $renter   = 'Ems Postage';
        $serviceId = 'EMS_POSTAGE';
        $trackno = '009';
        $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);


        $sign = array('controlno'=>$postbill->controlno,'idtype'=>'1','custid'=>$data['custinfo']->tin_number,'custname'=>$data['custinfo']->cust_name,'msisdn'=>$data['custinfo']->cust_mobile,'service'=>'EFD');
        $url = "http://192.168.33.2/api/vfd/getSig.php";
        $ch = curl_init($url);
        $json = json_encode($sign);
        curl_setopt($ch, CURLOPT_URL, $url);
            // For xml, change the content-type.
        curl_setopt ($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // ask for results to be returned

            // Send to remote and return data to caller.
            $response = curl_exec ($ch);
            $error    = curl_error($ch);
            $errno    = curl_errno($ch);
            curl_close ($ch);
            $data['signature'] = $signature = json_decode($response);

            $trans = array();
            $trans = array(

                'serial'=>$serial,
                'paidamount'=>$paidamount,
                'CustomerID'=>$credit_id,
                'transactionstatus'=>'POSTED',
                'bill_status'=>'PENDING',
                'customer_acc'=>$acc_no,
                'PaymentFor'=>'PCUM-BILL',
                'invoice_number'=>rand(10000,20000),
                'invoice_month'=>$month
            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('transactions',$trans);

            $update = array();
            $update = array('billid'=>@$postbill->controlno,'bill_status'=>'SUCCESS');
            $this->billing_model->update_transactions($update,$serial1);
            $data['cno'] = $controlno = @$postbill->controlno;

            $this->load->library('ciqrcode');

                $config['cacheable']    = true; //boolean, the default is true
                $config['cachedir']     = './assets/'; //string, the default is application/cache/
                $config['errorlog']     = './assets/'; //string, the default is application/logs/
                $config['imagedir']     = './assets/images/'; //direktori penyimpanan qr code
                $config['quality']      = true; //boolean, the default is true
                $config['size']         = '1024'; //interger, the default is 1024
                $config['black']        = array(224,255,255); // array, default is array(255,255,255)
                $config['white']        = array(70,130,180); // array, default is array(0,0,0)
                $this->ciqrcode->initialize($config);

                $image_name = $data['qrcodename'] = $controlno .'.png'; 

                $params['data'] = 'https://verify.tra.go.tz/'.$signature->desc; 
                $params['level'] = 'H'; 
                $params['size'] = 10;
                $params['savename'] = FCPATH.$config['imagedir'].$image_name; 
                $this->ciqrcode->generate($params);
                $this->load->view('billing/invoice_sheet',$data);

                $this->load->library('Pdf');
                $html= $this->load->view('billing/invoice_sheet',$data,TRUE);
                $this->load->library('Pdf');
                $this->dompdf->loadHtml($html);
                $this->dompdf->setPaper('A4','potrait');
                $this->dompdf->render();
                $this->dompdf->stream($acc_no, array("Attachment"=>0));

            }
            else{
                redirect(base_url());
            }
        }

        public function Incoming_Item(){

    //$data['total'] = $this->Box_Application_model->get_ems_sum();
            $trackno = $this->input->post('trackNo');
            $askfor = $this->input->get('AskFor');
            $data['askfor'] = $askfor;
            if ($askfor == "EMS") {
             $data['emslist'] = $this->Box_Application_model->get_ems_list_incoming();
         }elseif($askfor == "PCUM"){
            $data['emslist'] = $this->Box_Application_model->get_pcum_list_incoming_for_delivery();
        } else {
            $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
        }

        $data['region'] = $this->employee_model->regselect();
        $data['emselect'] = $this->employee_model->delivereselect();

        $this->load->view('ems/incoming_item',$data);

    }

    public function Incoming_Exchange(){

    //$data['total'] = $this->Box_Application_model->get_ems_sum();
        $date = $this->input->post('date');
        $month = $this->input->post('month');   

   //$region = $this->input->post('region');

        $trackno = $this->input->post('trackNo');
        $askfor = $this->input->get('AskFor');
        $data['askfor'] = $askfor;
        if ($askfor == "EMS") {
            if(!empty($date) || !empty($month) ){
                $data['emslist'] = $this->Box_Application_model->get_ems_list_exchange_Search($date,$month);

            }else{
                $data['emslist'] = $this->Box_Application_model->get_ems_list_exchange();

            }

        } else {
            $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
        }


        $data['region'] = $this->employee_model->regselect();
        $data['emselect'] = $this->employee_model->emselect();

        $this->load->view('ems/incoming_item_exchange',$data);

    }

    public function Sent_ToIps(){


       $date = $this->input->post('date');
       $month = $this->input->post('month');   

   // $region = $this->input->post('region');
    //$data['total'] = $this->Box_Application_model->get_ems_sum();
       $trackno = $this->input->post('trackNo');
       $askfor = $this->input->get('AskFor');
       $data['askfor'] = $askfor;
       if ($askfor == "EMS") {
        if(!empty($date) || !empty($month) ){
            $data['emslist'] = $this->Box_Application_model->sent_ips_ems_list_exchange_Search($date,$month);

        }else{
            $data['emslist'] = $this->Box_Application_model->get_ems_list_sent_toIps();

        }

    } else {
        $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
    }
    
    $data['region'] = $this->employee_model->regselect();
    $data['emselect'] = $this->employee_model->emselect();

    $this->load->view('ems/sent_to_ips',$data);

}




public function Delivered_Item(){

    $date = $this->input->post('date');
    $month = $this->input->post('month');   

    $region = $this->input->post('region');

    //$data['total'] = $this->Box_Application_model->get_ems_sum();
    $trackno = $this->input->post('trackNo');
    $askfor = $this->input->get('AskFor');
    $data['askfor'] = $askfor;
    if ($askfor == "EMS") {
        if(!empty($date) || !empty($month) || !empty($region)){
            $data['emslist'] = $this->Box_Application_model->get_ems_list_delivered_Search($date,$month,$region);

        }else{
            $data['emslist'] = $this->Box_Application_model->get_ems_list_delivered();

        }

    }elseif($askfor == "PCUM"){
        $data['emslist'] = $this->Box_Application_model->get_pcum_list_delivered_Search($date,$month,$region);

    } else {
        $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
    }
    
    $data['region'] = $this->employee_model->regselect();
    $data['emselect'] = $this->employee_model->delivereselect();

    $this->load->view('ems/Delivered_item',$data);

}



public function Delivered_Item_Search(){

    $date = $this->input->post('date');
    $month = $this->input->post('month');   

    $region = $this->input->post('region');

    $type = $this->input->post('askfor');


    //$data['total'] = $this->Box_Application_model->get_ems_sum();
    // $trackno = $this->input->post('trackNo');
    $type = $this->input->get('AskFor');
    $data['askfor'] = $type;
    if ($type == "EMS") {
        if(!empty($date) || !empty($month) || !empty($region)){
            $data['emslist'] = $this->Box_Application_model->get_ems_list_delivered_Search($date,$month,$region);

        }else{
            $data['emslist'] = $this->Box_Application_model->get_ems_list_delivered();

        }

    }elseif($type == "PCUM"){
        $data['emslist'] = $this->Box_Application_model->get_pcum_list_delivered_Search($date,$month,$region);

    } else {
        $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
    }
    
    $data['region'] = $this->employee_model->regselect();
    $data['emselect'] = $this->employee_model->delivereselect();

    $this->load->view('ems/Delivered_item_search',@$data);

}

public function Assigned_Delivery_Item(){

    //$data['total'] = $this->Box_Application_model->get_ems_sum();
    $trackno = $this->input->post('trackNo');
    $askfor = $this->input->get('AskFor');
    $data['askfor'] = $askfor;
    if ($askfor == "EMS") {
     $data['emslist'] = $this->Box_Application_model->get_ems_list_assignedfor_delivery();
 }elseif ($askfor == "PCUM") {
     $data['emslist'] = $this->Box_Application_model->get_pcum_list_assignedfor_delivery();
 }  else {
    $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
}

$data['region'] = $this->employee_model->regselect();
$data['emselect'] = $this->employee_model->delivereselect();

$this->load->view('ems/Assigned_item',$data);

}


public function Assign_To(){

    // $reasign = $this->input->post('reasign');
    $action = $this->input->post('action');
    $emid = $this->input->post('operator');
    $iid  = $this->input->post('I');
    $askfor  = $this->input->post('askfor');
    $data['askfor'] = $askfor;

      //$serial = 'serial'.;
    $serial    = 'serial'.date("YmdHis");

    if($action=='reasign'){

       if(empty($emid)){
        echo 'Please select Operator';

    }else{

        for ($i=0; $i <sizeof($iid) ; $i++) { 

            $id=$iid[$i];

            $data = array();
            $data = array(
                'em_id'=>$emid,
                'item_id'=>$iid[$i],
                'serial'=>$serial,
                'service_type'=>$askfor
            );

            $this->Box_Application_model->update_delivery_info($data,$id);

        //$this->Box_Application_model->assigned_for_delivery($iid[$i]);


        }

        echo "Successful Reassigned Item";
    }


}else{

    if($action=='Assign'){
        $serial    = 'serial'.date("YmdHis");
        if(empty($emid)){
            echo 'Please select Operator';

        }else{

            for ($i=0; $i <sizeof($iid) ; $i++) { 

                $data = array();
                $data = array(
                    'em_id'=>$emid,
                    'item_id'=>$iid[$i],
                    'serial'=>$serial,
                    'service_type'=>$askfor
                );

                $this->Box_Application_model->save_delivery_info($data);

                $this->Box_Application_model->assigned_for_delivery($iid[$i]);

            }




        }

        echo "Successful Assign Item";


    }else{

       if($action=='Return'){

           for ($i=0; $i <sizeof($iid) ; $i++) {
               $id=$iid[$i];
               $this->Box_Application_model->transfer_back_tosorting($id);
           }


       }

   }



}






}


public function Send_Ips()
{
    if ($this->session->userdata('user_login_access') != false)
    {
   //c $action = $this->input->post('action');
        $select = $this->input->post('I');



        if(!empty($select)){

            for ($i=0; $i <@sizeof($select) ; $i++) {

             $id = $select[$i];

             $this->Box_Application_model->transfer_to_Ips($id);

         }

         echo 'Successfully Sent To Ips ';
            //echo json_encode($$ec);


     }
     else{

        echo 'Please Select Atleast One Item To Send ';

    }
    

}
else{
    redirect(base_url());
}
}





public function get_delivery_info(){

   $sndid = $this->input->get('senderid');
   $AskFor = $this->input->get('AskFor');

    // $sndid = $this->input->post('senderid');
    // $AskFor = $this->input->post('AskFor');
    //echo $AskFor;

   $data['askFor'] =$AskFor;
   $service_type = $this->input->get('AskFor');

   $this->session->set_userdata('service_type',$service_type);
   $data['hovyo'] = $this->Box_Application_model->get_delivery_info_by_id($sndid);

   $this->load->view('domestic_ems/delivery_info',$data);
}

public function getVirtualBoxInfo(){

  $phone = $this->input->post('phone');
  $target_url = "http://192.168.33.7/api/virtual_box/";

  $post = array(
      'box'=>$phone
  );


  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL,$target_url);
  curl_setopt($curl, CURLOPT_POST,1);
        //curl_setopt($curl, CURLOPT_POST, count($post));
  curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
  curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
        //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
  curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($curl, CURLOPT_VERBOSE,true);
  $result = curl_exec($curl);
        // if(!$result){
        //     die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        // }
  $answer = json_decode($result);


  echo "<table style='width:100%;' class='table table-bordered'>

  <tr><td><b><h4>Name:</h4></b></td><td><h4>".@$answer->full_name."</h4></td></tr>
  <tr><td><b><h4>Address:</h4></b></td><td><h4>".@$answer->phone."</h4></td></tr>

  <tr><td><b><h4>Post Office:</h4></b></td><td><h4>".@$answer->post_office."</h4></td></tr>
  <tr><td><b><h4>Region:</h4></b></td><td><h4>".@$answer->region."</h4></td></tr>

  </table>";

  curl_close($curl);

}



public function embassy_italy_document_parcel_bill_bulk_save()
{
    if ($this->session->userdata('user_login_access') != false)
    {

        $Barcode = strtoupper($this->input->post('Barcode'));
        $emstype = $this->input->post('emstype');
        $emsname = $this->input->post('emstype');
        $emsCat = $this->input->post('emsCat');
        $weight = $this->input->post('weight');
        $serial = $this->input->post('serial');
        $cbranch = $this->input->post('cbranch');

        $sender = $this->input->post('sender');
        $senderp = $this->input->post('sender');
        $receiver_address = $this->input->post('r_mobilev');
        $target_url = "http://192.168.33.7/api/virtual_box/";

//get sender
        $info = $this->Box_Application_model->get_customer_infos($sender);
        $type = $info->acc_no;
        $getSum = $this->Box_Application_model->getSumPostPaid($type);
        if(!empty($info) ){
            $addressT = "physical";
            $s_fname =$info->customer_name;
            $s_address = $info->customer_address;
            $s_email = $info->cust_email;
            $s_mobile = $info->cust_mobile;
        }


        if (empty($receiver_address)) {

           $addressR = "physical";
           $r_fname = $this->input->post('r_fname');
           $r_address = $this->input->post('r_address');
           $r_mobile = $this->input->post('r_mobile');
           $r_email = $this->input->post('r_email');
           $rec_region = $this->input->post('region_to');
           $rec_dropp = $this->input->post('district');

       }

       if(!empty($receiver_address)){

        $addressR = "virtual";
        $phone =  $receiver_address;


        $post = array(
          'box'=>$phone
      );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$target_url);
        curl_setopt($curl, CURLOPT_POST,1);
    //curl_setopt($curl, CURLOPT_POST, count($post));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));
        curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("SMARTPOSTA-Api-Key: kkqqdEJt.6bc0IQff2zetZDfTlfcdtaBBSvcUIgS2"));
    //curl_setopt ($curl, CURLOPT_HTTPHEADER, Array("Content-Length: 0"));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($curl);
        $answer = json_decode($result);

        $r_fname = $answer->full_name;
        $r_address = $answer->phone;
        $r_mobile = $answer->phone;
        $r_email = '';
        $rec_region = $answer->region;
        $rec_dropp = $answer->post_office;

    }


 //$ebranch = $this->session->userdata('user_branch');
    if($emstype=="Document" && $emsCat==1){

        $totalPrice = 80000;
        $emsprice = (100*$totalPrice)/118; 
        $vat = $totalPrice - $emsprice;

    } elseif ($emstype=="Document" && $emsCat==2) {

        $totalPrice = 60000;
        $emsprice = (100*$totalPrice)/118; 
        $vat = $totalPrice - $emsprice;

    } else  {
  //OTHER 

      if($weight > 10){

       $weight10    = 10;
       $getPrice    = $this->Box_Application_model->ems_cat_price10($emsCat,$weight10);

       $vat       = $getPrice->vat;
       $price     = $getPrice->tariff_price;
       $totalprice10 = $vat + $price;

       $diff   =  $weight - $weight10;

       if ($diff <= 0.5) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + 2300;
           } else {
            $totalPrice = $totalprice10 + 3500;
        }

    } else {

       $whole   = floor($diff);
       $decimal = fmod($diff,1);
       if ($decimal == 0) {

           if ($emsCat == 1) {
               $totalPrice = $totalprice10 + ($whole*1000/500)*2300;
           } else {
            $totalPrice = $totalprice10 + ($whole*1000/500)*3500;
        }

    } else {

       if ($decimal <= 0.5) {

        if ($emsCat == 1) {
           $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300;
       } else {
           $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500;
       }

   } else {

    if ($emsCat == 1) {
        $totalPrice = $totalprice10 + ($whole*1000/500)*2300 + 2300+2300;
    } else {
       $totalPrice = $totalprice10 + ($whole*1000/500)*3500 + 3500+3500;
   }
}

}
}

} else {

   $price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
     //$price = $this->Box_Application_model->ems_cat_price($emsCat,$weight);
   $vat = $price->vat;
   $emsprice = $price->tariff_price;
   $totalPrice = $vat + $emsprice;
}


}
 //END OTHER

$ids = $this->session->userdata('user_login_id');
$infos = $this->employee_model->GetBasic($ids);
$o_regions = $infos->em_region;
$o_branchs = $infos->em_branch;
$users = $infos->em_code.'  '.$infos->first_name.' '.$infos->middle_name.' '.$infos->last_name;


$o_region = $info->customer_region;
$o_branch = $info->customer_branch;
$source = $this->employee_model->get_code_source($o_regions);
$dest = $this->employee_model->get_code_dest($rec_region);
$number = $this->getnumber();
$bagsNo = 'EE'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

$serial = $this->input->post('serial');
if(empty($serial)){
 $serial    = 'EMS'.date("YmdHis").$source->reg_code;

}

$trackno = $bagsNo;




// $transactionstatus   = 'POSTED';
// $bill_status  = 'PENDING';
// $PaymentFor = 'EMS';
$transactiondate = date("Y-m-d");
$fullname  = $s_fname;


$id = $this->session->userdata('user_login_id');
$getPending = $this->Box_Application_model->get_pending_task1($id);

if ( $getPending == 100) {

   $data['message'] = "You Have Pending Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
   $this->load->view('ems/control-number-form',$data);

} else {

    $i = $this->employee_model->GetBasic($id);

    $dataSection = $this->employee_model->getEmpDepartmentSections($id);

    $acc_no = $info->acc_no;
    if($info->customer_type == "PostPaid"){

        if($info->price < $totalPrice){

            echo 'Umefikia Kiwango Cha mwisho cha Kukopeshwa';

        }else{

            $diff = $info->price - $totalPrice;
            $up = array();
            $up = array('price'=>$diff);
            $this->Box_Application_model->update_price1($up,$acc_no);


            $sender = array();
            $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

            $db2->insert('receiver_info',$receiver);


            $mobile = $s_mobile;


            $emid = $this->session->userdata('user_login_id');
        //getting user or staff department section
            $staff_section = $this->employee_model->getEmpDepartmentSections($emid);

        //for One Man
            $office_one_name  = (!empty(@$staff_section[0]['name']))? @$staff_section[0]['name']:'Counter';

            //$office_one_name  = (!empty($staff_section[0]['name']))? $staff_section[0]['name'].' receive':'Counter';


            $data = array();

            $data = array(

                'serial'=>$serial,
                'paidamount'=>$totalPrice,
                'CustomerID'=>$last_id,
                'Customer_mobile'=>$info->cust_mobile,
                'region'=>$o_regions,
                'district'=>$o_branchs,
                'Barcode'=>strtoupper($Barcode),
                'transactionstatus'=>'POSTED',
                'office_name'=>@$office_one_name,
                'created_by'=>$emid,
                'bill_status'=>'BILLING',
                'paymentFor'=>'EMS',
                'status'=>'Bill',
                'customer_acc'=>$info->acc_no,
                'item_vat'=>$vat
            // 'item_price'=>$price

            );



            $lastTransId  = $this->Box_Application_model->save_transactions($data);


        //for One Man
            $office_trance_name  = (!empty(@$staff_section[0]['name']))? @$staff_section[0]['name']:'Counter';


            //for tracing
            $trace_data = array(
                'emid'=>$emid,
                'transid'=>$lastTransId,
                'office_name'=>@$office_trance_name,
                'description'=>'Acceptance',
                'status'=>'IN');

            //for trace data
            $this->Box_Application_model->tracing($trace_data);


            $id = $emid = $this->session->userdata('user_login_id');
            $sender_id=$last_id;
            $operator=$emid;
            $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
            <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
            $alltotal = 0;
            foreach ($listbulk as $key => $value) { 

              $alltotal =$alltotal + $value->paidamount;
              echo "<tr style='width:100%;color:#343434;' class='trans".$value->id."'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
              <td>


              <button data-transid=".$value->id." data-senderid=".$value->CustomerID."  class='btn btn-info Delete' onclick=Deletevalue(this); type='button'   id='Delete'>Delete </button>

              </td></tr>";
          }



          echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
          </table>
          <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
          <input type='hidden' name ='sender' value=".$senderp." class='sender'>
          <input type='hidden' name ='serial' value=".$serial." class='serial'>
          <input type='hidden' name ='operator' value=".$operator." class='operator'>

          ";






      }

  }else{



    if ($info->price <= 20000) {
        echo "Please Recharge Your Account";
    } else {

        $diff = $info->price - $price1;
        $up = array();
        $up = array('price'=>$diff);
        $this->Box_Application_model->update_price($up,$acc_no);

        $sender = array();
        $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();


        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp);

        $db2->insert('receiver_info',$receiver);

        $data = array();
        $data = array(

            'serial'=>$serial,
            'paidamount'=>$totalPrice,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$info->cust_mobile,
            'region'=>$o_regions,
            'district'=>$o_branchs,
            'Barcode'=>strtoupper($Barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'paymentFor'=>'EMS',
            'status'=>'Bill',
            'customer_acc'=>$info->acc_no,
            'item_vat'=>$vat

        );

        $this->Box_Application_model->save_transactions($data);


        $id = $emid = $this->session->userdata('user_login_id');
        $sender_id=$last_id;
        $operator=$emid;
        $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


        echo "<table style='width:100%;' class='table table-bordered'>
        <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
        $alltotal = 0;
        foreach ($listbulk as $key => $value) { 

          $alltotal =$alltotal + $value->paidamount;
          echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->r_region."</td><td>".$value->branch."</td> <td>".$value->track_number."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
          <td>


          <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>

          </td></tr>";
      }



      echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
      </table>
      <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
      <input type='hidden' name ='sender' value=".$senderp." class='sender'>
      <input type='hidden' name ='serial' value=".$serial." class='serial'>
      <input type='hidden' name ='operator' value=".$operator." class='operator'>

      ";





  }

}

}


}else{
    redirect(base_url());
}
}





      /// ********* SEND SMS FUNCTION ************
function send_sms($s_mobile,$sms)
{
   $mobile = trim($s_mobile);
   $mobile = str_replace(array(' ','-'), '',  $mobile);
   $mobile = '255'.substr($mobile, -9);
   $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($sms);

   $urloutput=file_get_contents($url);


}
}