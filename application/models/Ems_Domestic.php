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

    }
    
	public function cash_dashboard(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $this->session->set_userdata('heading','Domestic Cash Dashboard');
           $this->load->view('domestic_ems/domestic-ems-dashboard');
        } else {
           redirect(base_url());
        }
        
    }

    public function bill_dashboard(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $this->session->set_userdata('heading','Domestic Bill Dashboard');
            $this->load->view('domestic_ems/domestic-bill-dashboard');
        } else {
           redirect(base_url());
        }
        
    }

    public function Domestic_Category_Dashboard(){
        if ($this->session->userdata('user_login_access') != false) {
            
            $this->session->set_userdata('heading','Domestic Dashboard');
        
        $data['cash'] = $this->dashboard_model->get_ems_domestic_cash();
        $data['bill'] = $this->dashboard_model->get_ems_domestic_bill();
            $this->load->view('domestic_ems/domestic-category-dashboard',@$data);
        } else {
           redirect(base_url());
        }
        
    }

    public function document_parcel(){

        if ($this->session->userdata('user_login_access') != false) {
            
            $this->session->set_userdata('heading','Document / Parcel');

            $data['region'] = $this->employee_model->regselect();
            $data['total'] = $this->Box_Application_model->get_ems_sum();
            $data['ems_cat'] = $this->Box_Application_model->ems_cat();
            $data['region'] = $this->employee_model->regselect();
            $this->load->view('domestic_ems/document-parcel-form',$data);

        } else {
           redirect(base_url());
        }
        
    }

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

public function document_parcel_save()
{
if ($this->session->userdata('user_login_access') != false)
{

$emstype = $this->input->post('emsname');
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

 if ( $getPending == 10) {

     $data['message'] = "You Have 10 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
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
        'paymentFor'=>$PaymentFor
        // 'track_number'=>$trackno

     );

    $this->Box_Application_model->save_transactions($data);

     $paidamount = $totalPrice;
     $region = $o_region;
     $district = $o_branch;
     $renter   = $fullname;    //$emstype;
     $serviceId = 'EMS_POSTAGE';
     
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

//         //$serial1 = '995120555284';

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
        # code...
   }


    }else{
    redirect(base_url());
    }
}


public function document_parcel_bulk_save()
{
if ($this->session->userdata('user_login_access') != false)
{

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

     $data['message'] = "You Have 10 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
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


public function delete_ems_document_bulk_info()
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
                $update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
               $this->billing_model->update_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya EMS  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
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



    public function pcum_transactions_save()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Pcum');
            $this->session->set_userdata('list','Pcum_Transactions_List');
            
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

             
            
            $price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);
            $district_name =$this->dashboard_model->getPcumDistrict_ById($distid);
             $district_name =  $district_name->district_name ;

            $vat = $price->vat;
            $emsprice = $price->tarrif;
            $Total = $vat + $emsprice;

            $paidamount = $Total;
            $sender = array();
            $sender = array('weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'add_type'=>$addressT);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$district_name,'branch'=>$city,'add_type'=>$addressR);

            $db2->insert('receiver_info',$receiver);

            $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'CustomerID'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'PaymentFor'=>'PCUM'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('transactions',$trans);

            $renter   = $s_fname;
            $serviceId = 'EMS_POSTAGE';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $bagsNo = $source->reg_code . $source->reg_code;

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

                $this->billing_model->update_sender_info($last_id,$trackno);
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

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = @$this->Parcel_model->get_country_price($emsCat);
                $bagsNo = $source->reg_code . $source->reg_code;

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

                $this->billing_model->update_sender_info($last_id,$trackno);

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

  public function delete_pcum_bulk_info()
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




  public function pcum_bulk_transactions_save()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Pcum');
            $this->session->set_userdata('list','Pcum_Transactions_List');
            
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
        'transactionstatus'=>'POSTED',
        'bill_status'=>'PENDING',
        'paymentFor'=>'PCUM'

    );

   //echo json_encode($data22) ;

    $this->Box_Application_model->save_transactions($data22);

    $id = $emid = $this->session->userdata('user_login_id');

              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);


             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination District</b></th><th><b>Destination </b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
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


    }else{
        redirect(base_url());
    }
  }


public function save_bulk_pcum_info(){



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
            
            $date = $this->input->post('date');
            $month = $this->input->post('month');
            $status = $this->input->post('status');
            $search = $this->input->post('search');

            if ($search == "search") {
               $data['cargo'] = $this->Pcum_model->get_pcum_search($date,$month,$status);
               $data['sum']   = $this->Pcum_model->get_pcum_sum_search($date,$month,$status);
            } else {
                $data['cargo'] = $this->Pcum_model->get_pcum_list();
                $data['sum']   = $this->Pcum_model->get_pcum_sum();
            }
            
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

            $data = array();
            $data = array(

            'cust_name'=>$cust_name,
            'cust_address'=>$cust_address,
            'cust_mobile'=>$cust_mobile,
            'customer_region'=>$customer_region,
            'vrn'=>$vrn,
            'tin_number'=>$tin_number,
            'price'=>$price

            );

            $this->Pcum_model->save_pcum_customer($data);

            $this->load->view('domestic_ems/bill-customer-register-form');
            
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

             if (!empty($I)) {

                 $data['cargo'] = $this->Pcum_model->pcum_bill_transactions_by_customer($I);

               } else {

                 $data['cargo'] = $this->Pcum_model->pcum_bill_transactions();

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
            $data['cust_id']  = base64_decode($this->input->get('I'));

            $this->load->view('domestic_ems/pcum-bill-form',$data);
            
        }else{
            redirect(base_url());
        }
   
    }

    public function pcum_transactions_bill_save()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Pcum');
            $this->session->set_userdata('list','Pcum_Transactions_List');
            
            $weight = $this->input->post('weight');
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
            $price = $this->dashboard_model->pcum_price($weight,$zoneid,$city,$distid);

            $vat = $price->vat;
            $emsprice = $price->tarrif;
            $Total = $vat + $emsprice;
            $diff = $senderInfo->price - $Total;

            $update = array();
            $update = array('price'=>$diff);
            $db2->where('pcum_id',$senderInfo->pcum_id);
            $db2->update('pcum_bill',$update);

            $paidamount = $Total;
            $sender = array();
            $sender = array('weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$info->em_id,'service_type'=>'PCUM','amount'=>$Total,'bill_cust_acc'=>$custId);

           
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$o_region,'branch'=>$city);

            $db2->insert('receiver_info',$receiver);
            
            
            $this->Box_Application_model->save_location($data);

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
    $data['emselect'] = $this->employee_model->emselect();

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
    $data['emselect'] = $this->employee_model->emselect();

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
       
     }elseif($askfor == "PCUM"){
            $data['emslist'] = $this->Box_Application_model->get_pcum_list_delivered_Search($date,$month,$region);

    } else {
        $data['emslist'] = $this->Box_Application_model->get_mails_list_incoming();
    }
    
    $data['region'] = $this->employee_model->regselect();
    $data['emselect'] = $this->employee_model->emselect();

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
    $data['emselect'] = $this->employee_model->emselect();

    $this->load->view('ems/Assigned_item',$data);

 }


 public function Assign_To(){

    // $reasign = $this->input->post('reasign');
    $action = $this->input->post('action');
    $emid = $this->input->post('operator');
    $iid  = $this->input->post('I');
    $askfor  = $this->input->post('askfor');
     $data['askfor'] = $askfor;

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
            'service_type'=>$askfor
        );

        $this->Box_Application_model->update_delivery_info($data,$id);

        //$this->Box_Application_model->assigned_for_delivery($iid[$i]);

        
    }

    echo "Successful Reassigned Item";
}


    }else{

        if($action=='Assign'){
            if(empty($emid)){
                echo 'Please select Operator';

            }else{

                for ($i=0; $i <sizeof($iid) ; $i++) { 
        
        $data = array();
        $data = array(
            'em_id'=>$emid,
            'item_id'=>$iid[$i],
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
    $data['askFor'] =$AskFor;
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
}