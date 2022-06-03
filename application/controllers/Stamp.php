 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stamp extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Stamp_model');
        $this->load->model('Box_Application_model');
        $this->load->model('organization_model');
        $this->load->model('billing_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }


     public function Stamp_List()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->Stamp_model->get_stamp_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->Stamp_model->get_stamp_list();

           }


           
           $this->load->view('stamp/Stamp_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

      public function Stamp_cash_List()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->Stamp_model->get_stamp_cash_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->Stamp_model->get_stamp_cash_list();

           }


           
           $this->load->view('stamp/Stamp_cash_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

   

    
	public function Stamp_form()
    {
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Stamp/Stamp_List'));

         }
        elseif ($this->session->userdata('user_login_access') != false) {

       

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('stamp/Stamp_form',$data);
           
        
    }

}

public function Franking_Stamp_form()
    {
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Stamp/Franking_Stamp_List'));

         }
        elseif ($this->session->userdata('user_login_access') != false) {

       

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('stamp/Franking_Stamp_form',$data);
           
        
    }

}

 public function Franking_Stamp_List()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->Stamp_model->get_franking_stamp_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->Stamp_model->get_franking_stamp_list();

           }


           
           $this->load->view('stamp/Franking_Stamp_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

     public function Save_Franking_stamp()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $StampDetails = $this->input->post('StampDetails');
            $Currency = 'TZS';
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
            $serial    = 'Franking'.date("YmdHis").$source->reg_code;



             $data = array();
             $data = array(

            'serial'=>$serial,
            'StampDetails'=>$StampDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

            );

            //$this->Stamp_model->save_stamps($data);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('Stamp',$data);
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
            'paymentFor'=>'STAMP'

            );

            $this->Stamp_model->save_transactions($data1);



            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Sales Of Stamp';
            $serviceId = 'STAMP';
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Franking Machine STAMP,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Franking Machine STAMP,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('stamp/Stamp_control_number',$data);
            }else{
                redirect('Stamp/Franking_Stamp_List');
            }


        } else {
            redirect(base_url());
        }    
}

    public function bulk_Stamp_cash_form()
    {
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Stamp/Stamp_List'));

         }
        elseif ($this->session->userdata('user_login_access') != false) {

       

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('stamp/bulk-cash-form',$data);
           
        
    }

}



public function Register_Bulk_cash_stamp_Action()
{
    
if ($this->session->userdata('user_login_access') != False) {

 $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;


$Totalpaymentsamounts = $this->input->post('Totalpaymentsamounts');
$Totalpaymentsvalues = $this->input->post('Totalpaymentsvalues');

if(!empty($_POST['paymentsArray']))
{
    $myArray3 = $_POST['paymentsArray'];
    $paymentsArray    = json_decode($myArray3);

}


$name = $this->input->post('name');
$invoice = $this->input->post('invoice');

$source = $this->employee_model->get_code_source($o_region);

// $serial    = 'Stamp'.date("YmdHis").$source->reg_code;
$serial    = 'CASH'.$invoice;
$total = $Totalpaymentsamounts;
$paidamount = $Totalpaymentsamounts;

 if($Totalpaymentsamounts > 0 ) 
{
    if($Totalpaymentsvalues == 0){

    //echo json_encode($OutstandingArray);
    $type = $paymentsArray[0]->type;
    $unit =$paymentsArray[0]->unit;
     $quantity = $paymentsArray[0]->quantity;
    $total =$paymentsArray[0]->total;

     // echo 'type '.$type.' '.$unit.' '.$quantity.' '. $total. ' sawa 0 ';

     $data = array(

            'serial'=>$serial,
            'StampDetails'=>$type,
            'Customer_mobile'=>$unit,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $name,
            'Created_byId'=>$id,
            'stamp_number'=>$quantity

            );

            $this->Stamp_model->save_stamps($data);
             echo 'Successfully Saved';
    }
    else
    {
        
    foreach ($paymentsArray as $key => $variable) {

 $type = $variable->type;
    $unit =$variable->unit;
     $quantity = $variable->quantity;
    $total =$variable->total;

     // echo 'type '.$type.' '.$unit.' '.$quantity.' '. $total. ' sawa 10 ';

   
 $data = array(

            'serial'=>$serial,
            'StampDetails'=>$type,
            'Customer_mobile'=>$unit,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $name,
            'Created_byId'=>$id,
            'stamp_number'=>$quantity

            );

            $this->Stamp_model->save_stamps($data);
            

}
 echo 'Successfully Saved';

    }

   
    
}


}else{
redirect(base_url(), 'refresh');
}

}


    public function Save_stamp()
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
            $serial    = 'STAMP'.date("YmdHis").$source->reg_code;


             $data = array();
             $data = array(

            'serial'=>$serial,
            'StampDetails'=>$StampDetails,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'branch'=>$o_branch,
            'date_created'=>date("YmdHis"),
            'Operator'=> $user,
            'Created_byId'=>$info->em_code

            );

            $this->Stamp_model->save_stamps($data);

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
            'paymentFor'=>'STAMP'

            );

            $this->Stamp_model->save_transactions($data1);



            $paidamount = $Amount;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'Sales Of Stamp';
            $serviceId = 'STAMP';
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya STAMP,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya STAMP,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('stamp/Stamp_control_number',$data);
            }else{
                redirect('Stamp/Stamp_List');
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
       'service'=>$serviceId,
       'barcode'=>$mobile
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