 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ems_Cargo extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Ems_Cargo_model');
        $this->load->model('Box_Application_model'); 
        $this->load->model('billing_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Sms_model');
    }
        
	public function ems_cargo_form()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $this->load->view('ems_cargo/ems-cargo');
            
	}else{
        redirect(base_url());
    }
   
    }

    public function ems_cargo_transaction_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            
            $date = $this->input->post('date');
            $month = $this->input->post('month');
            $status = $this->input->post('status');
            $search = $this->input->post('search');

            if ($search == "search") {
               $data['cargo'] = $this->Ems_Cargo_model->get_ems_cargo_search($date,$month,$status);
               $data['sum']   = $this->Ems_Cargo_model->get_ems_cargo_sum_search($date,$month,$status);
            } else {
                $data['cargo'] = $this->Ems_Cargo_model->get_ems_cargo_list();
                $data['sum']   = $this->Ems_Cargo_model->get_ems_cargo_sum();
            }
            
            $this->load->view('ems_cargo/cargo_transactions_list',$data);
            
    }else{
        redirect(base_url());
    }
   
    }

    public function cargo_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $weight = $this->input->post('weight');

           if ($weight > 100) {
            
           $weight100 = 100;
           $price = $this->Ems_Cargo_model->ems_cargo_price_check100($weight100);

           if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                
                $emsprice = ($price->tarrif + $price->vat) + 35000;

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->tarrif+29661.02,2)."</td></tr>
                <tr><td><b>Vat:</b></td><td>".number_format($price->vat+5338.98,2)."</td></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";
            }


           } else {

            $price = $this->Ems_Cargo_model->ems_cargo_price_check($weight);
           
           
            if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                
                $emsprice = $price->tarrif + $price->vat;

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->tarrif,2)."</td></tr>
                <tr><td><b>Vat:</b></td><td>".number_format($price->vat,2)."</td></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";
            }

           }
            
        }else{
            redirect(base_url());
        }
       
        }


    public function ems_cargo_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            
            $weight = $this->input->post('weight');

            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
           
            // $mobile = $s_mobile = $this->input->post('s_mobile');
            // $s_email = $this->input->post('s_email');
            // $r_fname = $this->input->post('r_fname');
            // $r_address = $this->input->post('r_address');
            // $r_mobile = $this->input->post('r_mobile');
            // $r_email = $this->input->post('r_email');
            // $rec_region = $region_to = $this->input->post('region_to');
            // $district = $this->input->post('district');
            // $o_region = $sender_region = $this->session->userdata('user_region');



$sender_address = $this->input->post('s_mobilev');
$receiver_address = $this->input->post('r_mobilev');
$target_url = "http://192.168.33.7/api/virtual_box/";


if(empty($sender_address) && empty($receiver_address)){

 $addressT = "physical";
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

 $addressT = "physical";
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

$addressT = "virtual";
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



            $sender_branch = $this->session->userdata('user_branch');
             $sender_region = $o_region = $this->session->userdata('user_region');

            $serial    = 'ems-cargo'.date("YmdHis").$this->session->userdata('user_emid');
            $id = $emid = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);

            $source = $this->employee_model->get_code_source($o_region);
            $dest = $this->employee_model->get_code_dest($rec_region);

            $bagsNo = @$source->reg_code . @$dest->reg_code;
            
            $sender = array();
            $sender = array('weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$s_mobile,'s_region'=>$sender_region,'s_district'=>$sender_branch,'operator'=>$id,'add_type'=>$addressT);

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_info',$sender);
            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressT);

            $db2->insert('receiver_info',$receiver);

            if ($weight > 100) {

                $weight100 = 100;
                $price = $this->Ems_Cargo_model->ems_cargo_price_check100($weight100);

                $totalPrice = ($price->tarrif + $price->vat) + 35000;
                
            }else{

                $price = $this->Ems_Cargo_model->ems_cargo_price_check($weight);
                $totalPrice = $price->tarrif + $price->vat;
            }

            $data = array();
            $data = array(

                'transactiondate'=>date("Y-m-d"),
                'serial'=>$serial,
                'paidamount'=>$totalPrice,
                'CustomerID'=>$last_id,
                'Customer_mobile'=>$s_mobile,
                'region'=>$sender_region,
                'district'=>$sender_branch,
                'transactionstatus'=>'POSTED',
                'bill_status'=>'PENDING',
                'paymentFor'=>'EMS-CARGO'

            );

            $this->Box_Application_model->save_transactions($data);

            $paidamount = $totalPrice;
            $region = $sender_region;
            $district = $sender_branch;
            $renter   = 'ems-cargo';
            $serviceId = 'EMS_CARGO';
            $trackno = 00;
            $transaction = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$s_mobile,$renter,$serviceId,$trackno);
            

            if (!empty($transaction)) {

                @$serial1 = $transaction->billid;
                $update = array('billid'=>$transaction->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                //$serial1 = '995120555284';

                $first4 = substr($transaction->controlno, 4);
                $trackNo = $bagsNo.$first4;
                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $data['sms'] = $total = $sms ='KARIBU POSTA KINGANJANI umepatiwa ankara namba'. ' '.@$transaction->controlno.' Kwaajili ya huduma ya EMS-CARGO,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

                $total2 ='The amount to be paid for EMS-CARGO is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.$transaction->controlno ;

                 $this->Sms_model->send_sms_trick($s_mobile,$sms);

                $this->load->view('ems_cargo/control-number-form',$data);

             }else{

                $transaction1 = $this->Control_Number_model->get_control_number($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);

                @$serial1 = $transaction1->billid;
                $update = array('billid'=>$transaction1->controlno,'bill_status'=>'SUCCESS');
                $this->billing_model->update_transactions($update,$serial1);

                //$serial1 = '995120555284';

                $first4 = substr($transaction1->controlno, 4);
                $trackNo = $bagsNo.$first4;
                $data1 = array();
                $data1 = array('track_number'=>$trackNo);

                $this->billing_model->update_sender_info($last_id,$data1);

                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
                $data = array();
                $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);

                $data['sms'] = $total = $sms ='KARIBU POSTA KINGANJANI umepatiwa ankara namba'. ' '.@$transaction1->controlno.' Kwaajili ya huduma ya EMS-CARGO,Kiasi unachotakiwa kulipia ni TSH.'.number_format($totalPrice,2);

                $total2 ='The amount to be paid for EMS-CARGO is The TOTAL amount is '.' '.number_format($totalPrice,2).' Pay through this control number'.' '.$transaction1->controlno ;

                $this->Sms_model->send_sms_trick($s_mobile,$sms);

                $this->load->view('ems_cargo/control-number-form',$data);

            }

        }else{
            redirect(base_url());
        }
    }


}