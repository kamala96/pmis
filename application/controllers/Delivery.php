 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Necta_model');
        $this->load->model('Box_Application_model');
        $this->load->model('billing_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }
    
	public function delivery_dashboard(){

        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('delivery/delivery-dashboard');

        }else{
            redirect(base_url());
        }

    }

    public function Save_necta_Info()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $r_name = $this->input->post('r_name');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');
            $s_fullname = $this->input->post('s_fullname');
            $s_rnumber = $this->input->post('rnumber');
            $s_address = $this->input->post('s_address');
            $s_mobile = $mobile = $this->input->post('s_mobile');
            $category = $this->input->post('category');
            $emstype = 'Document';
            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            $month = date('m');
            $day   = date('d');
            
            if ($category == "ACSEE") {

                if (($month >= "07" && $day == "01") || ($month <= "09" && $day == "30")) {
                   $price = 7500;
                }if(($month >= "10" && $day == "01") || ($month >= "10" && $day == "31")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
                
            } else {
                
                if (($month >= "01" && $day == "01") || ($month <= "03" && $day == "31")) {
                   $price = 7500;
                }elseif(($month >= "04" && $day == "01") || ($month <= "04" && $day == "30")){
                    $price = 8500;
                }else{
                    $this->load->view('domestic_ems/necta_form');
                }
            }
            
            $sender = array();
            $sender = array('ems_type'=>$category,'rnumber'=>$s_rnumber,'s_fullname'=>$s_fullname,'s_address'=>$s_address,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_name,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_phone,'r_region'=>$r_region,'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);

            //$this->Loan_Board_model->Save_Receiver_Info($data);

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = $source->reg_code.$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").$source->reg_code.$this->session->userdata('user_login_id');

             $data = array();
             $data = array(

            'serial'=>$serial,
            'paidamount'=>@$price,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'NECTA'

            );

            $this->Box_Application_model->save_transactions($data);

            $paidamount = @$price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'ems_necta';
            $serviceId = 'NECTA';
            $trackno = $bagsNo;
            $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
            $serial1 = $serial;

            if (@$transaction->controlno != '') {
                    # code...
                $update = array('billid'=>@$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr(@$transaction->controlno, 4);
                $trackNo = $bagsNo.$first4;

                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                // $this->Loan_Board_model->update_sender_international($last_id,$data);
                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                 $data['result'] ='KARIBU POSTA KIGANJANI ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2);

                 $sms = $total ='KARIBU POSTA KIGANJANI umepatiwa ankara namba hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS NECTA,Kiasi unachotakiwa kulipia ni TSH.'.number_format(@$price,2);

                $this->Sms_model->send_sms_trick($s_mobile,$sms);

                $this->load->view('domestic_ems/necta_control_number',$data);

            }

            
        } else {
            redirect(base_url());
        }    
}


    public function necta_transactions_list()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['inter'] = $this->Necta_model->get_necta_list();
           $data['sum'] = $this->Necta_model->get_necta_sum();

           $search = $this->input->post('search');
           $date = $this->input->post('date');
           $month = $this->input->post('month');
           $status = $this->input->post('status');

           if ($search == "search") {

              $data['inter'] = $this->Necta_model->get_necta_search($date,$month,$status);
              $data['sum'] = $this->Necta_model->get_sum_necta_search($date,$month,$status);

           }
           
           $this->load->view('domestic_ems/necta_application_list',$data);
        } else {
            redirect(base_url());
        }
        
    }
}