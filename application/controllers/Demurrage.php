 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demurrage extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Demurrage_model');
        $this->load->model('Box_Application_model');
        $this->load->model('organization_model');
        $this->load->model('billing_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }

public function Demurrage(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $data['cash'] = $this->dashboard_model->get_ems_international();
            $this->session->set_userdata('heading','Demurrage Dashboard');
            $this->load->view('Demurrage/Demurrage-dashboard',$data);
            
        } else {
           redirect(base_url());
        }
        
    }
     public function Demurrage_List()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');
             $emid = $this->session->userdata('user_login_id');
           $basicinfo = $this->employee_model->GetBasic($emid);
            $data['department'] =$department = $basicinfo->dep_name;

           if($this->session->userdata('user_type') != "SUPER ADMIN" && $this->session->userdata('user_type') != "ADMIN" && $this->session->userdata('user_type') != "BOP" && $this->session->userdata('user_type') != "CRM" ){
          
            $region = $basicinfo->em_region;
            $branch = $basicinfo->em_branch;
           }

           if (!empty($month) || !empty($date) ) {
                $data['list'] = $this->Demurrage_model->get_Demurrage_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->Demurrage_model->get_Demurrage_list();

           }


           
           $this->load->view('Demurrage/Demurrage_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

   
   
    
	public function Demurrage_form()
    {
        if ($this->session->userdata('user_login_access') != false) {

        //     $tz = 'Africa/Nairobi';
		// $tz_obj = new DateTimeZone($tz);
		// $today = new DateTime("now", $tz_obj);
		// $YmdHis = date('YmdHis');
		// $Now = $today->format('YmdHis');
        // print_r($Now);
        // echo '<br />';
        // print_r($YmdHis);
        // die();

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('Demurrage/Demurrage_form',$data);
           
        
    }






}
    public function Save_Demurrage()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $DemurrageDetails = $this->input->post('DemurrageDetails');
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
            $serial    = 'Demurrage'.date("YmdHis").$source->reg_code;


             $data = array();
             $data = array(

            'serial'=>$serial,
            'item'=>$DemurrageDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

            );

            $this->Demurrage_model->save_Demurrages($data);

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
            'paymentFor'=>'Demurrage'

            );

            $this->Demurrage_model->save_transactions($data1);



            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Demurrage';
            $serviceId = 'Demurrage';
            $trackno = '90'.$bagsNo;
            $transaction = $this->getBillGepgBillIdDemurrage($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Demurrage,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Demurrage,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('Demurrage/Demurrage_control_number',$data);
            }else{
                redirect('Demurrage/Demurrage_List');
            }


        } else {
            redirect(base_url());
        }    
}

  
public function getBillGepgBillIdDemurrage($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno){

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

$json = json_encode($data);
 //create logs
     $value = array();
       $value = array('item'=>$renter,'payload'=>$json);
       $log=json_encode($value);
       $lg = array(
       'response'=>$log,
       'serial'=>$serial,
       'type'=>'SendtoGEPG',
       'service'=>$serviceId
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
    public function sendsms($mobile,$total)
    {
    $url = 'http://192.168.33.2/modules/otsms/process.php?msisdn='.$mobile.'&message='.urlencode($total);
    $urloutput=file_get_contents($url);
    return $urloutput;
    }

    
}