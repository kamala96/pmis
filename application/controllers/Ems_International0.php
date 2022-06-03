 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ems_International extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model');
        $this->load->model('employee_model');
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Ems_International_model');
        $this->load->model('Box_Application_model');
        $this->load->model('organization_model');
        $this->load->model('billing_model');
        $this->load->model('Sms_model');
        $this->load->helper('url');
    }
    
	
    public function Save_Ems_Info()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $barcode = $this->input->post('barcode');
             $cat = $this->input->post('emsname');
            $country = $this->input->post('country');
            $weight = $this->input->post('weight');
            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
            $s_email = $this->input->post('s_email');
            $mobile = $this->input->post('s_mobile');
            $r_fname = $this->input->post('r_fname');
            $r_address = $this->input->post('r_address');
            $r_email = $this->input->post('r_email');
            $r_mobile = $this->input->post('r_mobile');
            $price = $this->input->post('price');

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;

            
            $sender = array();
            $sender = array('ems_type'=>$cat,'cat_type'=>'International','weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'serial'=>$barcode);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();


            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'address'=>$s_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$country);

            $db2->insert('receiver_info',$receiver);

            $source = $this->employee_model->get_code_source($o_region);

            $bagsNo = $source->reg_code;
            $serial    = 'EMSI'.date("YmdHis").$source->reg_code;

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
            'paymentFor'=>'EMS_INTERNATIONAL'

            );

            $this->Box_Application_model->save_transactions($data);

            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'ems_international';
            $serviceId = 'EMS_POSTAGE';
            $trackno = '90'.$bagsNo;
            $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
            $serial1 = $serial;

            if ($transaction->controlno != '') {
                    # code...

                $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                $first4 = substr($transaction->controlno, 4);
                $trackNo = '90'.$bagsNo.$first4;

                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                 $data['result'] ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KINGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('ems/international_ems_control_number',$data);
            }else{
                redirect('Ems_International/Ems_International_Application_List');
            }


        } else {
            redirect(base_url());
        }    
}

    public function getBillGepgBillIdEMS($serial, $paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno)
    {

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

    public function International_Ems()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('ems/international_ems_application_form',$data);
           
        
    }
}

    public function Ems_International_Application_List()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');


           if (!empty($month) || !empty($date) ) {
                $data['inter'] = $this->Ems_International_model->get_ems_international_list_search($date,$month,$region);
               $data['sum'] = $this->Ems_International_model->get_ems_international_sum_sarch($date,$month,$region);
               

           } else {

               if ($this->session->userdata('user_type') == "ACCOUNTANT" || $this->session->userdata('user_type') == "ADMIN"  || $this->session->userdata('user_type') == "RM" || $this->session->userdata('user_type') == "BOP") {
                $data['inter'] = $this->Ems_International_model->get_ems_international_list_search($date,$month,$region);
               $data['sum'] = $this->Ems_International_model->get_ems_international_sum_sarch($date,$month,$region);
           }else{
            $data['inter'] = $this->Ems_International_model->get_ems_international_list();
               $data['sum'] = $this->Ems_International_model->get_ems_international_sum();
           }

           }
           
           $this->load->view('ems/ems_international_application_list',$data);
        } else {
            redirect(base_url());
        }
        
    }

public function Ems_price_vat_international()
{
if ($this->session->userdata('user_login_access') != false)
{

$emsCat = $this->input->post('tariffCat');
$weight = $this->input->post('weight');
$emstype = $this->input->post('emstype');

$Getzone = $this->organization_model->get_zone_country($emsCat);
$zone    = $Getzone->zone_name;

    if ($weight > 10) {
      

        $weight10    = 10;
    $getPrice    = $this->organization_model->get_zone_country_price10($zone,$weight10,$emstype);

    //$vat10       = $getPrice->vat;
    //$price10     = $getPrice->tariff_price;
    $totalprice10 = $getPrice->zone_price;
    $diff   =  $weight - $weight10;

    if ($emstype == "Document") {

    if ($diff <= 0.5) {

        if ($zone == 'ZONE1') {
            $totalPrice = $totalprice10 + 4000;
        }if ($zone == 'ZONE2') {
            $totalPrice = $totalprice10 + 6100;
        }if ($zone == 'ZONE3') {
            $totalPrice = $totalprice10 + 7300;
        }if ($zone == 'ZONE4') {
            $totalPrice = $totalprice10 + 7600;
        }if ($zone == 'ZONE5') {
            $totalPrice = $totalprice10 + 8400;
        }if ($zone == 'ZONE6') {
            $totalPrice = $totalprice10 + 9800;
        }if ($zone == 'ZONE7') {
            $totalPrice = $totalprice10 + 9400;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($zone == 'ZONE1') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*4000;
                }if ($zone == 'ZONE2') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*6100;
                }if ($zone == 'ZONE3') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*7300;
                }if ($zone == 'ZONE4') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*7600;
                }if ($zone == 'ZONE5') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*8400;
                }if ($zone == 'ZONE6') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9800;
                }if ($zone == 'ZONE7') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9400;
                }
                

            } else {

                if ($decimal <= 0.5) {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*4000 + 4000;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6100 + 6100;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7300 + 7300;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7600 + 7600;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*8400 + 8400;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9800 + 9800;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9400 + 9400;
                    }

                } else {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*4000 + 4000 + 4000;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6100 + 6100 + 6100;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7300 + 7300 + 7300;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*7600 + 7600 + 7600;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*8400 + 8400 + 8400;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9800 + 9800 + 9800;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9400 + 9400 + 9400;
                    }
                }

            }
            $dvat = $totalPrice * 0.18;
         $dprice = $totalPrice - ($totalPrice * 0.18);
            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";
    }

    } else {

    if ($diff <= 0.5) {

        if ($zone == 'ZONE1') {
            $totalPrice = $totalprice10 + 5100;
        }if ($zone == 'ZONE2') {
            $totalPrice = $totalprice10 + 6900;
        }if ($zone == 'ZONE3') {
            $totalPrice = $totalprice10 + 9000;
        }if ($zone == 'ZONE4') {
            $totalPrice = $totalprice10 + 9100;
        }if ($zone == 'ZONE5') {
            $totalPrice = $totalprice10 + 9900;
        }if ($zone == 'ZONE6') {
            $totalPrice = $totalprice10 + 11000;
        }if ($zone == 'ZONE7') {
            $totalPrice = $totalprice10 + 16200;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);
        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";


    } else {

            $whole   = floor($diff);
            $decimal = fmod($diff,1);
            if ($decimal == 0) {

                if ($zone == 'ZONE1') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*5100;
                }if ($zone == 'ZONE2') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*6900;
                }if ($zone == 'ZONE3') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9000;
                }if ($zone == 'ZONE4') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9100;
                }if ($zone == 'ZONE5') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*9900;
                }if ($zone == 'ZONE6') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*11000;
                }if ($zone == 'ZONE7') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*16200;
                }
                

            } else {

                if ($decimal <= 0.5) {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*5100 + 5100;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6900 + 6900;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9000 + 9000;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9100 + 9100;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9900 + 9900;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*11000 + 11000;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*16200 + 16200;
                    }

                } else {

                    
                    if ($zone == 'ZONE1') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*5100 + 5100 + 5100;
                    }if ($zone == 'ZONE2') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*6900 + 6900 + 6900;
                    }if ($zone == 'ZONE3') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9000 + 9000 + 9000;
                    }if ($zone == 'ZONE4') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9100 + 9100 + 9100;
                    }if ($zone == 'ZONE5') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*9900 + 9900 + 9900;
                    }if ($zone == 'ZONE6') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*11000 + 11000 + 11000;
                    }if ($zone == 'ZONE7') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*16200 + 16200 + 16200;
                    }
                }

            }

            $dvat = $totalPrice * 0.18;
            $dprice = $totalPrice - ($totalPrice * 0.18);
            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";
    }
    }


    } else {
        
        $Getprice = $this->organization_model->get_zone_country_price($zone,$weight,$emstype);

        if (empty($Getprice)) {

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>0</td></tr>
            <tr><td><b>Vat:</b></td><td>0</td></tr>
            <tr><td><b>Total Price:</b></td><td>0</td></tr>
            </table>";

        }else{

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td><input type='text' name ='price1' value='$Getprice->zone_tariff' class='price1'></td></tr>
            <tr><td><b>Vat:</b></td><td><input type='text' name ='vat' value='$Getprice->zone_vat' class='price1'></td></tr>
            <tr><td><b>Total Price:</b></td><td><input type='text' name ='price' value='$Getprice->zone_price' class='price1'></td></tr>
            </table>";

        }
    }
    
   


}else{
redirect(base_url());
}
}
 public function Miscereneous()
 {
    if ($this->session->userdata('user_login_access') != false)
    {

    $type = 'EMS_INTERNATIONAL';
    $select = $this->input->post('I');
    $emid = $this->session->userdata('user_login_id');
    $id = $this->session->userdata('user_emid');
    $endshift = $this->input->post('endshift');
    $qr = $this->input->post('qr');

    $tz = 'Africa/Nairobi';
    $tz_obj = new DateTimeZone($tz);
    $today = new DateTime("now", $tz_obj);
    $date = $today->format('Y-m-d');

if (!empty($endshift)) {

        $id = $this->session->userdata('user_login_id');
        @$getCounter = @$this->Box_Application_model->get_counter_byEmId($id);
        @$cId = @$getCounter->counter_id;
        @$csId = @$getCounter->cs_id;
        @$getPending = @$this->Ems_International_model->get_pending_task_international($emid);
        @$check = @$this->Box_Application_model->getEndingDate($emid,$date);
        
        if (!empty($check)) {

            $this->session->set_flashdata('message','Shift already Ended');
            
            redirect(base_url('Ems_International/Ems_International_Application_List'),'refresh');
            
        }

        if (!empty($getPending)) {

            $update = array();
            $update = array('assign_status'=>'NotEnded','date_assign'=>$date);
            $this->employee_model->Update_Jobassign($update,$emid);
            $this->session->set_flashdata('message','Shift Not Ended,You Have Pending Item');
            
            redirect(base_url('Ems_International/Ems_International_Application_List'),'refresh');

        } else {

        $csup = array();
        $csup = array('c_status'=>'NotAssign');
        $this->employee_model->Update_Counters($csup,$cId);

        $sup = array();
        $sup = array('assign_status'=>'NotAssign');
        $this->employee_model->Update_Counters_Services($sup,$csId);

        $this->Box_Application_model->delete_servc_emp($emid);
        $data = array();
        $data = array('supervisee_name'=>$emid,'sup_status'=>'ShiftEnd');
        $this->Box_Application_model->Save_SupervisorJob($data);

        $update = array();
        $update = array('assign_status'=>'ShiftEnd','date_assign'=>$date);
        $this->employee_model->Update_Jobassign($update,$emid);

        $this->session->set_flashdata('message','Successfully Shift Ended');
            
            redirect(base_url('Ems_International/Ems_International_Application_List'),'refresh');

        }

}elseif(!empty($qr)){

    if (!empty($select)) {

    for ($i=0; $i <@sizeof($select) ; $i++) {

        $id = $select[$i];

        $checkPay = $this->Ems_International_model->check_payment_International($id,$type);

        $sid = $checkPay->CustomerID;

        $getTrack = $this->Box_Application_model->getTrackNo($sid);

        $data[] = $getTrack->track_number;
        
        }

        $url = "http://192.168.33.2/api/qr/test.php";
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
        curl_close ($ch);
        $result['mussa'] = $response;
        
        $this->load->view('billing/qrcode_list',$result);

    
}else{

    //echo "Please select item to transfer";
    $this->session->set_flashdata('message', "Please select item to create qr code");
    redirect(base_url('Ems_International/Ems_International_Application_List'),'refresh');
}

} else {
    

if (!empty($select)) {
    for ($i=0; $i <@sizeof($select) ; $i++) {

        $id = $select[$i];

        $checkPay = $this->Ems_International_model->check_payment_International($id,$type);

        if ($checkPay->status == 'Paid' || $checkPay->status == 'Bill') {

            $data = array();
            $data = array('office_name'=>'Back');

            $this->Box_Application_model->update_back_office($id,$data);
        }

    }
    
    $this->session->set_flashdata('message', "Successfully Send To Back Office");
    redirect(base_url('Ems_International/Ems_International_Application_List'),'refresh');

}else{

    $this->session->set_flashdata('message', "Please select item to transfer");
    redirect(base_url('Ems_International/Ems_International_Application_List'),'refresh');
}

}
    }else{
        redirect(base_url());
    }
    }


public function international_back_office(){

if ($this->session->userdata('user_login_access') != false)
{

$data['emslist1'] = $this->Ems_International_model->get_ems_international_back_list();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['ems'] = $this->Box_Application_model->count_ems();


$data['bags'] = $this->Box_Application_model->count_bags();
$this->load->view('ems/international_back_office',$data);
}
else{
redirect(base_url());
}

}

public function received_item_from_counter()
{
    $data['emid'] = $this->session->userdata('user_login_id');
$data['ems'] = $this->Box_Application_model->count_ems();
$data['emslist1'] = $this->Ems_International_model->get_item_received_list_international();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/received_item_from_counter_international',$data);
}

public function close_bags(){
    if ($this->session->userdata('user_login_access') != false)
{
    $select = $this->input->post('I');
    $region = $this->input->post('region');
    $district = $this->input->post('district');
    $weight = $this->input->post('weight');
    $id = $this->session->userdata('user_login_id');
    $info = $this->employee_model->GetBasic($id);
    $o_region = $info->em_region;
    $o_branch = $info->em_branch;
    $rec_region = $region;
    $emid = $info->em_id;
    $type = 'EMS';

    $source = $this->employee_model->get_code_source($o_region);
    $dest = $this->employee_model->get_code_dest($rec_region);
    $rondom = substr(date('dHis'), 1);
    $billcode = '5';//bag code in tracking number
    @$bagsNo = $source->reg_code . $dest->reg_code.$billcode.$rondom;

    if(!empty($select)){
        if(empty($region)){

    echo "Please Select Destination Region";
        
        }elseif(empty($weight)){
            
            echo "Please Fill Bag Weight";
        }else{

            $bag = array();
            $bag = array('bag_number'=>$bagsNo,'bag_weight'=>$weight,
            'service_type'=>'EMS','bag_region_from'=>$o_region,'bag_branch_from'=>$o_branch,'bag_created_by'=>$emid,'ems_category'=>'International');
            $this->Box_Application_model->save_bag($bag);

    for ($i=0; $i <@sizeof($select) ; $i++) {

        $id = $select[$i];

            $bag = array();
            $bag = array('bag_region'=>$region,'bag_branch'=>$district);
            $this->Box_Application_model->update_bag($bag,$bagsNo);

            $data = array();
            $data = array('isBagNo'=>$bagsNo,'bag_status'=>'isBag');
            $this->Box_Application_model->update_back_office($id,$data);

        
    }

        echo "Successfully Bag Close";


    }
    }else{
        
        echo "Please Select Atleast One Item To close";

    }
    
}
else{
redirect(base_url());
}
}
 public function ems_bags_list_international(){

$data['emsbags'] = $this->Ems_International_model->get_ems_bags_international_list();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/ems_bags_list_international',$data);
 }

 public function despatch_out(){

if ($this->session->userdata('user_login_access') != false)
{
$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['despatch'] = $this->Ems_International_model->get_despatch_out_list_international();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/despatch_out_international',$data);
}
else{
redirect(base_url());
}

}

public function despatch_in(){

if ($this->session->userdata('user_login_access') != false)
{

$data['emslist'] = $this->Box_Application_model->get_ems_back_list();
$data['despatchIn'] = $this->Ems_International_model->get_despatch_in_list_international();
$data['despatchInCount'] = $this->Box_Application_model->count_despatch_in();
$data['despatchCount'] = $this->Box_Application_model->count_despatch_out();
$data['ems'] = $this->Box_Application_model->count_ems();
$data['bags'] = $this->Box_Application_model->count_bags();

$this->load->view('ems/despatch_in_international',$data);
}
else{
redirect(base_url());
}

}

}