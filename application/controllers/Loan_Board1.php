 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loan_Board extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Loan_Board_model');
        $this->load->model('Box_Application_model');
        $this->load->model('billing_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }
    
	public function Loan_info(){

        if ($this->session->userdata('user_login_access') != false) {

            $this->load->view('domestic_ems/loan_board_form');

        }else{
            redirect(base_url());
        }

    }

    public function Save_Heslb_Info()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $r_name = $this->input->post('r_name');
            $r_region = $this->input->post('r_region');
            $r_address = $this->input->post('r_address');
            $r_zipcode = $this->input->post('r_zipcode');
            $r_phone = $this->input->post('r_phone');
            $r_email = $this->input->post('r_email');
           
            $Weight = $this->input->post('Weight');
            $addtype = $this->input->post('addtype');
            $emstype = 'Document';

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
            $rec_region = "Dar es Salaam";
            $rec_branch = "GPO";

            $target_url = "http://192.168.33.7/api/virtual_box/";

            if ($addtype == "Physical") {
            $add = "physical";
            $s_fullname = $this->input->post('s_fullname');
            $s_address = $this->input->post('s_address');
            $mobile = $this->input->post('s_mobile');

            } else {
            
            $add = "virtual";
            $phone =  $mobile = $this->input->post('s_mobile');
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

            $s_fullname = $answer->full_name;
            $s_address = $answer->phone;
            $s_email = '';
            $phone = $s_address = $answer->phone;

            }
            

            if ($o_region == "Dar es Salaam") {
                
                if ($o_branch == "Mkuranga" || $o_branch == "Mafia" || $o_branch == "Kibiti" || $o_branch == "Kisarawe" || $o_branch == "Ikwiriri") {

            		$price = 16000;

            	}else{
            		$price = 8000;
            	}
                

            }elseif($o_region == "Mzizima"){

            	if ($o_branch == "Bagamoyo" || $o_branch == "Kibaha" || $o_branch == "Chalinze"  || $o_branch == "Mlandizi") {

            		$price = 16000;
            	}else{
                    $price = 8000;
                }
            } else {

                 $price = 16000;
            }

            $sender = array();
            $sender = array('ems_type'=>$emstype,'weight'=>$Weight,'s_fullname'=>$s_fullname,'s_address'=>$s_address,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'add_type'=>$add);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_name,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_phone,'r_region'=>$r_region,'branch'=>$rec_branch);

            $db2->insert('receiver_info',$receiver);

            //$this->Loan_Board_model->Save_Receiver_Info($data);

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = @$source->reg_code.$dest->reg_code;
            $serial    = 'EMS'.date("YmdHis").$id;

             $data = array();
             $data = array(

            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'LOAN BOARD'

            );

            $this->Box_Application_model->save_transactions($data);

            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'ems_heslb';
            $serviceId = 'EMS_POSTAGE';
            $trackno = $bagsNo;
            $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('ems/heslb_control_number',$data);

            }

            
        } else {
            redirect(base_url());
        }    
}

    public function getBillGepgBillIdEMS($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

    $AppID = 'POSTAPORTAL';

    $data = array(
    'AppID'=>$AppID,
    'BillAmt'=>$paidamount,
    'serial'=>$serial,
    'District'=>$district,
    'Region'=>$region,
    'service'=>$serviceId,
    'item'=>$renter,
    'mobile'=>$mobile,
    'trackno'=>$trackno
    );

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

    public function sendsms($mobile,$total)
    {
    $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($total);
    $urloutput=file_get_contents($url);
    return $urloutput;
    }

    public function loan_board_transactions_list()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['inter'] = $this->Loan_Board_model->get_loan_board_list();
           $data['sum'] = $this->Loan_Board_model->get_ems_loanboard_sum();

           $search = $this->input->post('search');
           $date = $this->input->post('date');
           $month = $this->input->post('month');
           $status = $this->input->post('status');

           if ($search == "search") {
              
              // $take = $this->Loan_Board_model->get_loan_board_search($date,$month,$status);
              
              // foreach ($take as $value) {

              //     $serial = $value->serial;
              //     $amount = $value->paidamount;
              //     $services = "EMS";
              //     $this->Loan_Board_model->getBillPaymentUpdate($serial,$amount);

              // }

              $data['inter'] = $this->Loan_Board_model->get_loan_board_search($date,$month,$status);
              $data['sum'] = $this->Loan_Board_model->get_sum_loanboard_search($date,$month,$status);

           }
           
           $this->load->view('domestic_ems/loan_board_application_list',$data);
        } else {
            redirect(base_url());
        }
        
    }
}