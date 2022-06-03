 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parcel2 extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('Parcel_model');
        $this->load->model('parcel_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Box_Application_model');
        $this->load->model('unregistered_model');
         $this->load->model('Sms_model');
         $this->load->model('Stamp_model');
          $this->load->model('billing_model');
    }
    
	public function international_parcel_form()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['country'] = $this->parcel_model->country_name();
			$this->load->view('parcel/parcel-international-form',$data);
	}else{
        redirect(base_url());
    }
  }

  public function parcel_price_vat_international()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            
            $emsCat = $this->input->post('tariffCat');
            $weight = $this->input->post('weight');

            
            if ($weight > 1) {
                $diff = $weight -1;

                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $total = number_format($getPrice->tarrif + $getPrice->vat + $diff*($getPrice->addition ),2);
                $tarrif = number_format($getPrice->tarrif,2);
                $vat = number_format($getPrice->vat,2);
            } else {
                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $total = $getPrice->tarrif + $getPrice->vat;
                $total = number_format($getPrice->tarrif + $getPrice->vat,2);
                $tarrif = number_format($getPrice->tarrif,2);
                $vat = number_format($getPrice->vat,2);
            }
            
        if (empty($getPrice)) {

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>0</td></tr>
            <tr><td><b>Vat:</b></td><td>0</td></tr>
            <tr><td><b>Total Price:</b></td><td>0</td></tr>
            </table>";

        }else{

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>$tarrif</td></tr>
            <tr><td><b>Vat:</b></td><td>$vat</td></tr>
            <tr><td><b>Total Price:</b></td><td>$total</td></tr>
            </table>";

        }
    }else{
        redirect(base_url());
    }
  }

  public function save_transactions()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            
            $weight = $this->input->post('weight');
            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
            $s_mobile = $this->input->post('s_mobile');
            $s_email = $this->input->post('s_email');
            $r_fname = $this->input->post('r_fname');
            $r_address = $this->input->post('r_address');
            $r_mobile = $this->input->post('r_mobile');
            $emsCat = $region_to = $this->input->post('country');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $id = $emid = $this->session->userdata('user_login_id');
            $serial    = 'PInter'.date("YmdHis").$id;
            
            if ($weight > 1) {
                $diff = $weight-1;

                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $Total = $getPrice->tarrif + $getPrice->vat + $diff*($getPrice->addition );
                
            } else {

                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $Total = $getPrice->tarrif + $getPrice->vat;
                
            }
            $paidamount = $Total;
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Parcels-Inter');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$getPrice->country,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('receiver_register_info',$receiver);

            $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('parcel_international_transactions',$trans);

            $renter   = 'Parcels International';
            $serviceId = 'MAIL';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->parcel_model->get_country_price($emsCat);
                $bagsNo = $source->reg_code . $dest->tarrif_id;

                $first4 = substr($postbill->controlno, 4);
                $trackNo = $bagsNo.$first4;
                $trackno = array();
                $trackno = array('track_number'=>$trackNo);
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $this->unregistered_model->update_sender_info($last_id,$trackno);
                $serial = $postbill->billid;
                $update = array();
                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->parcel_model->update_parcel_international_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Parcels International ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('parcel/parcels-international-control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->parcel_model->get_country_price($emsCat);
                $bagsNo = $source->reg_code . $dest->tarrif_id;

                
                $first4 = substr($repostbill->controlno, 4);
                $trackNo = $bagsNo.$first4;
                $trackno = array();
                $trackno = array('track_number'=>$trackNo);
                $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $this->unregistered_model->update_sender_info($last_id,$trackno);

                @$serial = $repostbill->billid;
                $update = array();
                $update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->parcel_model->update_parcel_international_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Parcels International Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('parcel/parcels-international-control-number-form',$data);    
            }

    }else{
        redirect(base_url());
    }
  }

  public function international_parcel_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->parcel_model->get_parcel_international_application_list();
            $data['sum']  = $this->parcel_model->get_sum_parcel_international();
            $check = $this->input->post('I');
            $db2 = $this->load->database('otherdb', TRUE);
            $ids = $this->session->userdata('user_login_id');
            $search = $this->input->post('search');
            if (!empty($check)) {

                if (!empty($this->input->post('backofice'))) {

                    for ($i=0; $i <@sizeof($check) ; $i++) {

                      $id = $check[$i];
                      $checkPay = $this->unregistered_model->check_payment($id);
                        if (!empty($checkPay)) {
                        $last_id = $check[$i];
                        $trackno = array();
                        $trackno = array('sender_status'=>'Back');
                        $this->unregistered_model->update_sender_info($last_id,$trackno);
                        $data['message'] = "Successfull Sent To Back Office";
                    }else{
                        $data['errormessage'] = "Please Some Item Not Paid";
                    }
                    
                }
                    
                $this->load->view('inlandMails/register-application-list',$data);

                }elseif (!empty($this->input->post('qrcode'))) {
                
                for ($i=0; $i <@sizeof($check) ; $i++) {

                $id = $check[$i];
                $checkPay = $this->unregistered_model->check_payment($id);
                        if (!empty($checkPay)) {
                           $getTrack = $this->unregistered_model->getTrackNo($id);
                           $data1[] = $getTrack->track_number;
                        } else{
                            $data1[] = '';
                        }
                }

                $url = "http://192.168.33.2/api/qr/test.php";
                $ch = curl_init($url);
                $json = json_encode($data1);
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
                $result['mussa'] = $response;
                
                $this->load->view('inlandMails/qrcode_list',$result);

                }
                }else{

                if(!empty($this->input->post('shiftend'))){

                    $checkItemStatus = $this->unregistered_model->check_item_status($ids);
                    if (!empty($checkItemStatus)) {

                        $data['errormessage'] = "Shift Not End Propery Clear Item Either Payment Or Send To Backoffice";

                    }else{

                        $getCI =  $this->unregistered_model->check_job_assign($ids);
                        $task_id = $getCI->task_id;
                        $db2->set('status', 'OFF');//if 2 columns
                        $db2->where('task_id', $task_id);
                        $db2->update('taskjobassign');

                        $counter1 = $getCI->counter_id;
                        $csup1 = array();
                        $csup1 = array('c_status'=>'NotAssign');
                        $this->job_assign_model->Update_Counterss($csup1,$counter1);

                        //$data['message'] = "Successfull Shift End";

                        redirect('dashboard/dashboard');
                    }

                  }elseif (!empty($search)) {

                    $date = $this->input->post('date');
                    $month = $this->input->post('month');
                    $region = $this->input->post('region');
                    $branch = $this->input->post('branch');

                    $data['list'] = $this->parcel_model->search_application_list($date,$month,$region,$branch);
                    $data['sum']  = $this->parcel_model->get_parcel_post_sum_search($date,$month,$region,$branch);
                  }
                   $this->load->view('parcel/parcels-international-application-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}

    public function air_mails_dashboard(){
        if ($this->session->userdata('user_login_access') == 1){
            $this->load->view('parcel/air-mails-dashboard');
        }else{
            redirect(base_url());
        }

    }


    public function air_mails_domestic_form(){
        if ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Air Mails Domestic Application');
            $this->load->view('parcel/air-mails-domestic-form');
        }else{
            redirect(base_url());
        }

    }

    public function air_mails_international_form(){
        if ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Air Mails International Application');

  
            $this->load->view('parcel/air-mails-international-form');
        }else{
            redirect(base_url());
        }

    }

     public function air_mails_international_application_list()
    {
        
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) ) {
                $data['list'] = $this->Parcel_model->get_air_mails_international_application_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->Parcel_model->get_air_mails_international_application_list();

           }


           
           $this->load->view('parcel/air-mails-international_List',$data);
        } else {
            redirect(base_url());
        }
        
    }


     public function air_mails_domestic_application_list()
    {
        
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) ) {
                $data['list'] = $this->Parcel_model->get_air_mails_domestic_application_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->Parcel_model->get_air_mails_domestic_application_list();

           }


           
           $this->load->view('parcel/air-mails-domestic_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

 public function Save_air_mails_international()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $StampDetails = $this->input->post('StampDetails');
            $Currency = $this->input->post('Currency');
            $Amount = $this->input->post('Amount');
            $price = $Amount;
            $mobile = $this->input->post('s_mobile');
          

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;

                 $source = $this->employee_model->get_code_source($o_region);

            $bagsNo = $source->reg_code;
            $serial    = 'MAIL'.date("YmdHis").$source->reg_code;


             $data = array();
             $data = array(

            'serial'=>$serial,
            'item'=>$StampDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

            );

            $this->Parcel_model->save_air_mails_international($data);

$data1 = array();
             $data1 = array(

            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'MAIL'

            );

            $this->Stamp_model->save_transactions($data1);



            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Sales Of MAIL';
            $serviceId = 'MAIL';
            $trackno = '90'.$bagsNo;
            $transaction = $this->getBillGepgBillIdStamp($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya MAIL,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya MAIL,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('parcel/air-mails-international-control_number',$data);
            }else{
                redirect('Parcel/air_mails_international_application_list');
            }


        } else {
            redirect(base_url());
        }    
}


 public function Save_air_mails_domestic()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $StampDetails = $this->input->post('StampDetails');
            $Currency = $this->input->post('Currency');
            $Amount = $this->input->post('Amount');
            $price = $Amount;
            $mobile = $this->input->post('s_mobile');
          

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;

                 $source = $this->employee_model->get_code_source($o_region);

            $bagsNo = $source->reg_code;
            $serial    = 'MAIL'.date("YmdHis").$source->reg_code;


             $data = array();
             $data = array(

            'serial'=>$serial,
            'item'=>$StampDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

            );

            $this->Parcel_model->Save_air_mails_domestic($data);

$data1 = array();
             $data1 = array(

            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'MAIL'

            );

            $this->Stamp_model->save_transactions($data1);



            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Sales Of MAIL';
            $serviceId = 'MAIL';
            $trackno = '90'.$bagsNo;
            $transaction = $this->getBillGepgBillIdStamp($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya MAIL,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya MAIL,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('parcel/air-mails-domestic-control_number',$data);
            }else{
                redirect('Parcel/air_mails_domestic_application_list');
            }


        } else {
            redirect(base_url());
        }    
}


public function getBillGepgBillIdStamp($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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

public function getBillGepgBillId($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId){

$AppID = 'POSTAPORTAL';

$data = array(
'AppID'=>$AppID,
'BillAmt'=>$paidamount,
'serial'=>$serial,
'District'=>$district,
'Region'=>$region,
'service'=>$serviceId,
'item'=>$renter,
'mobile'=>$mobile
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

    
}