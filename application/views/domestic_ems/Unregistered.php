<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unregistered extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('notice_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Control_Number_model');
        $this->load->model('Sms_model');
        $this->load->model('Box_Application_model');
        $this->load->model('unregistered_model');
        $this->load->model('Unregistered_model');
        $this->load->model('job_assign_model');
        $this->load->model('Bill_Customer_model');
        $this->load->model('Stamp_model');
        $this->load->model('billing_model');
    }
    
	public function Dashboard()
  {
    #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            
      $this->load->view('inlandMails/unregistered_dashboard');
      }else{
        redirect(base_url());
       }
  }

    public function small_packet()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            
            $this->load->view('inlandMails/small-packet-dashboard');
    }

    public function unregistered_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

              redirect(base_url('Unregistered/register_application_list'));

               }



              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = $this->unregistered_model->check_job_assign1($ids);
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
            if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
                     $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/unregistered_form',$data);
              } else {

             if (empty($checkJobAssign)) {
                   $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
                   $this->load->view('inlandMails/supervisor-sms-contact',$data);
               } else {

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);
                if(empty($id))
                {
                   $this->load->view('inlandMails/unregistered_form',$data);

                }else
                {
                   $this->load->view('inlandMails/unregistered_form2',$data);
                }
               

               }
             }
    }

    public function unregistered_bulk_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

            if($this->session->userdata('user_type') =='ACCOUNTANT' || $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

              redirect(base_url('Unregistered/register_application_list'));

               }



              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = $this->unregistered_model->check_job_assign1($ids);
              $data['I'] = $id = base64_decode($this->input->get('I'));
              $data['askfor'] = $this->input->get('AskFor');
            if ($this->session->userdata('user_type') == "ADMIN" || $this->session->userdata('user_type') == "ACCOUNTANT"|| $this->session->userdata('user_type') == "RM") {
                     $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/unregistered_bulk_form',$data);
              } else {

             if (empty($checkJobAssign)) {
                   $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
                   $this->load->view('inlandMails/supervisor-sms-contact',$data);
               } else {

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $data['custinfo'] = $this->Bill_Customer_model->get_bill_cust_details_info($id);
                if(empty($id))
                {
                   $this->load->view('inlandMails/unregistered_bulk_form',$data);

                }else
                {
                   $this->load->view('inlandMails/unregistered_bulk_form',$data);
                }
               

               }
             }
    }




    public function small_packet_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

              $ids = $this->session->userdata('user_login_id');
              $checkJobAssign = $this->unregistered_model->check_job_assign1($ids);
              // if (empty($checkJobAssign)) {
              //     echo "mussa";
              // } else {
              //     echo "mussa5";
              // }
              
            if ($this->session->userdata('user_type') == 'ADMIN' ) {
                     $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/small-packet-form',$data);
              } 
                elseif ($this->session->userdata('user_type') == 'RM' ||  $this->session->userdata('user_type') == "ACCOUNTANT") {
                     $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                     $this->load->view('inlandMails/small-packet-form',$data);
               //     $data['list'] = $this->unregistered_model->get_small_packets_application_list();
               //     $data['sum']  = $this->unregistered_model->get_small_packets_sum_register();
               // $this->load->view('inlandMails/small-packet-application-list',$data);
              } else {

             if (empty($checkJobAssign)) {
                   $data['message'] = "Please Contact your supervisor to assign a job/task for today date";
                   $this->load->view('inlandMails/supervisor-sms-contact',$data);
               } else {

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/small-packet-form',$data);

               }
             }
    }
    public function uregister_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $ad_fee = $this->input->post('ad_fee');

           

           if ($type == "Document"){
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
            if (empty($price)) {

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                <tr><td><b>Price:</b></td><td>0</td></tr>
                <tr><td><b>Total Price:</b></td><td>0</td></tr>
                </table>";

            }else{

                
                $emsprice = $price->price + $price->s_charge + $price->s_vat + $price->ad_fee;

                echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->price,2)."</td></tr>
                <tr><td><b>Registration Fee:</b></td><td>".number_format($price->s_charge,2)."</td></tr>
                <tr><td><b>Registration Vat:</b></td><td>".number_format($price->s_vat,2)."</td></tr>
                <tr><td><b>Ad Fee:</b></td><td>".number_format($price->ad_fee,2)."</td></tr>
                 <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
                </table>
                    <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                        ";
            }
               
            } else {

                $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
                if ($ad_fee == "adfee") {
                   $emsprice = $price->price + $price->s_charge + $price->s_vat + 1800;
                } else {
                    $emsprice = $price->price + $price->s_charge + $price->s_vat;
                }

                 if (empty($price)) {

                 echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th colspan='2'>Charges</th></tr>
                 <tr><td><b>Price:</b></td><td>0</td></tr>
                 <tr><td><b>Total Price:</b></td><td>0</td></tr>
                 </table>";

             }else{

                 echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                 <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
                <tr><td><b>Tariff:</b></td><td>".number_format($price->price,2)."</td></tr>
                 <tr><td><b>Registration Fee:</b></td><td>".number_format($price->s_charge,2)."</td></tr>
                 <tr><td><b>Registration Vat:</b></td><td>".number_format($price->s_vat,2)."</td></tr>
                  <tr><td><b>Total Price:</b></td><td>".number_format($emsprice,2)."</td></tr>
             </table>
                     <input type='hidden' name ='price1' value='$emsprice' class='price1'>
                         ";
                
             }
                
            }
    }
public function posts_cargo_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $tarrif = $this->input->post('destination');
           $item   = $this->input->post('itemtype');

           if ($type == "fooditem") {
               $price = $this->unregistered_model->food_item_price($weight);
           } elseif($type == "nonfooditem"){
               $price = $this->unregistered_model->nonfood_item_price($weight);
           }else{
               $price = $this->unregistered_model->nonweighed_item_price($item,$tarrif);
           }
           
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

    public function small_packet_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $ad_fee = $this->input->post('ad_fee');

            $price = $this->unregistered_model->small_packet_cat_price($type,$weight);

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

       }else{
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

    public function register_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $registerType = $this->input->post('emsname');
            $weight = $this->input->post('weight');
            $type = $this->input->post('emsname');


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

           



            $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');
            $askfor = $this->input->get('AskFor');
            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
            $accno = $this->input->post('acc_no');
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
            
            if ($type == "Document"){
               $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat + $price->ad_fee;
            } else {

                if ($ad_fee == "adfee") {
                   $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat + 1800;
                } else {
                    $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat;
                }
                
            }
            
            

            if ($askfor == "MAILS") {
              
              $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              $dest = $this->employee_model->get_code_dest($rec_region);


              $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              $bagsNo = $source->reg_code . $dest->reg_code;
              @$trackNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              $diffp = $price1-$paidamount;

              if ($diffp > 0) {
                
              $sender = array();
              $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$acc_no,'add_type'=>$addressT);
              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('sender_person_info',$sender);


              $last_id = $db2->insert_id();

              $receiver = array();
             $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile,'add_type'=>$addressR);

              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('receiver_register_info',$receiver);

              $save = array();
              $save = array('price'=>$diffp);
              $this->Bill_Customer_model->update_credit_bill_customer($save,$I);

              $trackno = array();
              $trackno = array('track_number'=>$trackNo,'payment_type'=>'Bill');
              $info = $this->employee_model->GetBasic($id);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
              $location= $info->em_region.' - '.$info->em_branch;
              $data = array();
              $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

              $this->Box_Application_model->save_location($data);
              $this->unregistered_model->update_sender_info($last_id,$trackno);


              } 
              
                    redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));

            } else {
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);

            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile,'add_type'=>$addressR);

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
            $db2->insert('register_transactions',$trans);

            $renter   = 'Register Postage';
            $serviceId = 'MAIL';
             $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              
              @$trackno = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';


           // $trackno = '009';

            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($rec_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

                $first4 = substr($postbill->controlno, 4);
                $trackNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ'; 
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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya '.$type.' Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($rec_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

                
                $first4 = substr($repostbill->controlno, 4);
                 //$number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              
               @$trackNo =  'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ'; 
                //$trackNo = $bagsNo.$first4;
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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya '.$type.' Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('inlandMails/control-number-form',$data);    
            }



            }
            
        }else{
            redirect(base_url());
        }
    }
    


public function register_sender_bulk_info()
{
        #Redirect to Admin dashboard after authentication
if ($this->session->userdata('user_login_access') == 1){

  $registerType = $this->input->post('emstype');
  $weight = $this->input->post('weight');
  $type = $this->input->post('emstype');


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

           
            $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');

            }
           

            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');

            //$askfor = $this->input->get('AskFor');
            $askfor = $this->input->post('askfor');

            $price1 = $this->input->post('price');
            $I = $this->input->post('crdtid');
            $accno = $this->input->post('acc_no');
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
            
            if ($type == "Document"){
               $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat + $price->ad_fee;
            } else {

                if ($ad_fee == "adfee") {
                   @$paidamount = @$Total = @$price->price + @$price->s_charge + $price->s_vat + 1800;
                } else {
                    $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat;
                }
                
            }
            

             $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              $dest = $this->employee_model->get_code_dest($rec_region);

             $number = $this->getnumber();
              //$bagsNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

              $bagsNo = $source->reg_code . $dest->reg_code;
              @$trackNo = 'RD'.@$source->reg_code . @$dest->reg_code.$number.'TZ';

            if ($askfor == "MAILS") {

              $diffp = $price1-$paidamount;

              if ($diffp > 0) {
                
              $sender = array();
              $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'acc_no'=>$acc_no,'add_type'=>$addressT,'track_number'=>$trackNo);
              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('sender_person_info',$sender);


              $last_id = $db2->insert_id();

              $receiver = array();
             $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile,'add_type'=>$addressR);

              $db2 = $this->load->database('otherdb', TRUE);
              $db2->insert('receiver_register_info',$receiver);

              $save = array();
              $save = array('price'=>$diffp);
              $this->Bill_Customer_model->update_credit_bill_customer($save,$I);

              $trackno = array();
              $trackno = array('track_number'=>$trackNo,'payment_type'=>'Bill');
              $info = $this->employee_model->GetBasic($id);
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
              $location= $info->em_region.' - '.$info->em_branch;
              $data = array();
              $data = array('track_no'=>$trackNo,'location'=>$location,'user'=>$user,'event'=>'Counter');

              $this->Box_Application_model->save_location($data);
              $this->unregistered_model->update_sender_info($last_id,$trackno);



              
           $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$Total,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);



              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id." type='button' id='Delete'>Delete </button></td></tr>";
                }

              
               
               echo" <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                 <input type='hidden' name ='serial' value='$serial' class='serial'>
                   
                        ";


              } 
              
                   // redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));

            }else {
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'add_type'=>$addressT,'track_number'=>$trackNo);
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);

            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$rec_region,'reciver_branch'=>$rec_dropp,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile,'add_type'=>$addressR);

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
            $db2->insert('register_transactions',$trans);


              $sender_id=$last_id;
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id." type='button' id='Delete'>Delete </button></td></tr>";
                }

              
               
               echo" <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";

                         // <input type='hidden' name ='serial' value='$emsprice' class='price1'>


            }
            
       
    }
  
}


public function save_register_sender_bulk_info()
{

  $id  = $this->session->userdata('user_login_id');
   $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
   $serial = $this->input->post('serial');
   $operator = $this->input->post('operator');
    $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);
     $alltotal = 0;
     
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
   
                
                $data = array();
                $data = array('track_no'=>$value->track_number,'location'=>$location,'user'=>$user,'event'=>'Counter');

                $this->Box_Application_model->save_location($data);
              }

             
           $renter   = $listbulk[0]->sender_fullname;
            $serviceId = 'MAIL';
            $paidamount   = $alltotal;
            $sender_region = $listbulk[0]->sender_region;
            $sender_branch = $listbulk[0]->sender_branch;
             $s_mobile = $listbulk[0]->sender_mobile;
              $trackno   = $serial;
              //$type = $listbulk[0]->s_mobile;

            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {
               
                $update = array();
                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='<div>KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'</div>';
           
            //if (!empty($transaction->$controlno)) {
                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
               // $this->load->view('inlandMails/control-number-form',$data);
                
               
               // $this->session->set_flashdata('success','Saved Successfull');
          
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

              
                $update = array();
                $update = array('billid'=>@$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='<div>KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya  Register  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2).'</div>';

                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
                //$this->load->view('inlandMails/control-number-form',$data);    

                 //$this->session->set_flashdata('success','Saved Successfull');
                  
            }

          

}


public function delete_register_sender_bulk_info()
{


           $senderid = $this->input->post('senderid');
            $serial = $this->input->post('serial');
           $this->unregistered_model->delete_bulk_bysenderid($senderid);

               $emid  = $this->session->userdata('user_login_id');
              $operator=$emid;
              $listbulk= $this->unregistered_model->GetListbulkRD($operator,$serial);


             echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
                <tr><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Destination Branch</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->register_price;
                  echo "<tr><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td><td>".$value->reciver_branch."</td> <td>".$value->track_number."</td> <td>".number_format($value->register_price,2)."</td><td>
                   <button  class='btn btn-info ' value=".$value->sender_id." type='button' id='Delete'>Delete </button></td></tr>";
                }

              
               
               echo" <tr><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";


           $this->session->set_flashdata('success','Deleted Successfull');
}


    
public function register_sender_info2()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $registerType = $this->input->post('emsname');
            $weight = $this->input->post('weight');
            $type = $this->input->post('emsname');


$receiver_address = $this->input->post('r_mobilev');
$target_url = "http://192.168.33.7/api/virtual_box/";

$Is = $this->input->post('I');



$info = $this->Box_Application_model->get_customer_infos($Is);
    


 $addressT = "physical";
 $s_fname = $info->customer_name;
 $s_address = $info->customer_address;
 $s_email = $info->cust_email;
 $s_mobile = $info->cust_mobile;


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





            $sender_region = $o_region = $this->session->userdata('user_region');
            $sender_branch = $o_branch = $this->session->userdata('user_branch');

            $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');
            $askfor = $this->input->get('AskFor');
            $price1 = $info->price;
            $I = $this->input->post('crdtid');
            $accno = $this->input->post('acc_no');
            $price = $this->unregistered_model->unregistered_cat_price($type,$weight);
            $i = $this->employee_model->GetBasic($id);
            
            if ($type == "Document"){
               $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat + $price->ad_fee;
            } else {

                if ($ad_fee == "adfee") {
                   $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat + 1800;
                } else {
                    $paidamount = $Total = $price->price + $price->s_charge + $price->s_vat;
                }
                
            }
            
            

            if ($askfor == "MAILS") {

              if($info->customer_type == "PostPaid"){

                if($info->price < $paidamount){
                  
                  echo 'Umefikia Kiwango Cha mwisho';

                }else{
              
              $rondom = substr(date('dHis'), 1);
              $billcode = '7';//bag code in tracking number
              $source = $this->employee_model->get_code_source($sender_region);
              $dest = $this->employee_model->get_code_dest($rec_region);
              $bagsNo = $source->reg_code . $dest->reg_code;
              @$trackingno = $bagsNo .$billcode.$billcode.$rondom;
              $diffp = $price1-$paidamount;
              $acc_no = $info->acc_no;

              if ($diffp > 0) {


                $diff = $info->price - $paidamount;
                //echo $diff;
    $up = array();
    $up = array('price'=>$diff);
    $this->Box_Application_model->update_price1($up,$acc_no);

    
    
    $sender = array();
    $sender = array('ems_type'=>$registerType,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$info->customer_region,'s_district'=>$info->customer_branch,'track_number'=>$trackingno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id);

    $db2 = $this->load->database('otherdb', TRUE);
    $db2->insert('sender_info',$sender);
    $last_id = $db2->insert_id();


               $receiver = array();
    $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$rec_region,'branch'=>$rec_dropp,'add_type'=>$addressR);

    $db2->insert('receiver_info',$receiver);

    

    $data = array();
    $data = array(

      'serial'=>$serial,
      'paidamount'=>$paidamount,
      'CustomerID'=>$last_id,
      'Customer_mobile'=>$info->cust_mobile,
      'region'=>$o_region,
      'district'=>$info->customer_branch,
      'transactionstatus'=>'POSTED',
      'bill_status'=>'BILLING',
      'paymentFor'=>'MAIL',
      'status'=>'Bill',
      'customer_acc'=>$info->acc_no,
      'item_vat'=>$price->s_vat,
      'item_price'=>$price->price

    );

    $this->Box_Application_model->save_transactions($data);
    echo "Successfully Saved";

              }
               //echo "NOT Saved"; 
              redirect(base_url('Bill_Customer/bill_customer_list?AskFor=MAILS'));

            } 
            }}
            
        }else{
            redirect(base_url());
        }
    }
    



     public function small_packet_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $registerType = $this->input->post('emsname');
            $weight = $this->input->post('weight');
            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            $s_mobile = $this->input->post('s_mobile');
            $s_email = $this->input->post('s_email');
            $r_fname = $this->input->post('r_fname');
            $r_address = $this->input->post('r_address');
            $r_mobile = $this->input->post('r_mobile');
            $o_region = $region_to = $this->input->post('region_to');
            $rec_region = $district = $this->input->post('district');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $serial    = 'DSmallPackets'.date("YmdHis").$this->session->userdata('user_emid');
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');

            $price = $this->unregistered_model->small_packet_cat_price($type,$weight);
            
            $paidamount = $Total = $price->tarrif + $price->vat ;
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Small-Packets');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

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
            $db2->insert('register_transactions',$trans);

            $renter   = 'Small Packets';
            $serviceId = 'MAIL';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($rec_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Small Packets  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/small-packets-control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($rec_region);
                $bagsNo = $source->reg_code . $dest->reg_code;

                
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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Small Packets  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('inlandMails/small-packets-control-number-form',$data);    
            }

        }else{
            redirect(base_url());
        }
    }
    public function posts_cargo_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $registerType = $this->input->post('emsname');
            $weight = $this->input->post('weight');
            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            $s_mobile = $this->input->post('s_mobile');
            $s_email = $this->input->post('s_email');
            $r_fname = $this->input->post('r_fname');
            $r_address = $this->input->post('r_address');
            $r_mobile = $this->input->post('r_mobile');
            $o_region = $region_to = $this->input->post('region_to');
            $rec_region = $district = $this->input->post('district');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');
            $tarrif = $this->input->post('destination');
            $item   = $this->input->post('itemtype');

           if ($type == "fooditem") {
               $price = $this->unregistered_model->food_item_price($weight);
           } elseif($type == "nonfooditem"){
               $price = $this->unregistered_model->nonfood_item_price($weight);
           }elseif($type == "hiringvehicles"){
               # code...
           }elseif($type == "nonweighed"){
               $price = $this->unregistered_model->nonweighed_item_price($item,$tarrif);
           }
            $Total = $price->tarrif + $price->vat;
            $paidamount =  $Total;
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$registerType,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Posts-Cargo');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

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
            $db2->insert('register_transactions',$trans);

            $renter   = 'Posts Cargo';
            $serviceId = 'MAIL';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/posts-cargo-control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                
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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Post Cargo  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('inlandMails/posts-cargo-control-number-form',$data);    
            }

        }else{
            redirect(base_url());
        }
    }
    public function register_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            //$data['list'] = $this->Unregistered_model->get_register_application_listed();
            //$data['sum']  = $this->unregistered_model->get_sum_register();
          $data['region'] = $this->employee_model->regselect();

             $data['list'] = $this->unregistered_model->get_register_application_list();
             $data['sum']  = $this->unregistered_model->get_sum_register();

            $check = $this->input->post('I');
            $search = $this->input->post('search');
            $db2 = $this->load->database('otherdb', TRUE);
            $ids = $this->session->userdata('user_login_id');

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

                  }elseif(!empty($search)) {
                    $date = $this->input->post('date');
                    $month = $this->input->post('month');
                    $status = $this->input->post('status');
                    $branch = $this->input->post('branch');
                     $region = $this->input->post('region');

                    $data['list'] = $this->unregistered_model->search_register_application_list($date,$month,$status,$branch,$region);
                    $data['sum']  = $this->unregistered_model->get_register_sum_search($date,$month,$status,$branch,$region);
                  }
                   $this->load->view('inlandMails/register-application-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}

public function small_packets_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->unregistered_model->get_small_packets_application_list();
            $data['sum']  = $this->unregistered_model->get_small_packets_sum_register();
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
                    
                $this->load->view('inlandMails/small-packet-application-list',$data);

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

                  }elseif(!empty($search)) {
                    $date = $this->input->post('date');
                    $month = $this->input->post('month');
                    $status = $this->input->post('status');
                    $branch = $this->input->post('branch');

                    $data['list'] = $this->unregistered_model->search_application_list_small_packets($date,$month,$status,$branch);
                    $data['sum']  = $this->unregistered_model->get_small_packets_sum_search($date,$month,$status,$branch);
                  }

                   $this->load->view('inlandMails/small-packet-application-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}
public function posts_cargo_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
           $data2 = $this->Unregistered_model->get_posts_cargo_application_listed();
             $getcargo =  $this->Unregistered_model->get_posts_cargo_application();
             $data['list2'] = $data2;
              $data['cargo'] = $getcargo;


          /* foreach ($data2 as $value)
           {

            $serial = $value->serial;

            $getcargo =  $this->Unregistered_model->get_posts_cargo_application($serial);
            $data['cargo'] = $getcargo;


           }*/

            //$data['sum']  = $this->unregistered_model->get_posts_cargo_sum_register();
           
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
                    
                $this->load->view('inlandMails/posts-cargo-application-list',$data);

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

                  }elseif(!empty($search)) {


              //$data2 = $this->Unregistered_model->get_posts_cargo_application_listed();
              $getcargo =  $this->Unregistered_model->get_posts_cargo_application();
             // $data['list2'] = $data2;
               $data['cargo'] = $getcargo;


                    $date = $this->input->post('date');
                    $month = $this->input->post('month');
                    $status = $this->input->post('status');
                    $branch = $this->input->post('branch');

                    // $data['list'] = $this->unregistered_model->search_application_list_posts_cargo($date,$month,$status,$branch);
                     $data['list2'] = $this->unregistered_model->search_application_list_posts_cargos($date,$month,$status,$branch);
                   // $data['sum']  = $this->unregistered_model->get_post_cargo_sum_search($date,$month,$status,$branch);
                  }
                   $this->load->view('inlandMails/posts-cargo-application-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}


public function posts_cargo_application_list1()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->unregistered_model->get_posts_cargo_application_list();
            $data['sum']  = $this->unregistered_model->get_posts_cargo_sum_register();
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
                    
                $this->load->view('inlandMails/posts-cargo-application-list',$data);

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

                  }elseif(!empty($search)) {
                    $date = $this->input->post('date');
                    $month = $this->input->post('month');
                    $status = $this->input->post('status');
                    $branch = $this->input->post('branch');

                    $data['list'] = $this->unregistered_model->search_application_list_posts_cargo($date,$month,$status,$branch);
                    $data['sum']  = $this->unregistered_model->get_post_cargo_sum_search($date,$month,$status,$branch);
                  }
                   $this->load->view('inlandMails/posts-cargo-application-list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}

    public function registered_domestic_dashboard()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $search  = $this->input->post('search');
            $type = $this->input->post('type');
            $check = $this->input->post('I');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $emid = $this->session->userdata('user_login_id');
            $service_type = $this->input->get('Ask_for');

            $this->session->set_userdata('service_type',$service_type);
            

            if (!empty($search)) {

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');
              $data['type'] = "BackReceive";

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['list'] = $this->unregistered_model->get_register_application_search_back($date,$month,$status);

            }elseif ($type == "receive") {
              
              
            if (!empty($check)) {

                for ($i=0; $i <@sizeof($check) ; $i++) {
                    $last_id = $check[$i];
                    $trackno = array();
                    $trackno = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_sender_info($last_id,$trackno);
                }

            $data['message'] = "Item Received";
            } else {
                $data['errormessage'] = "Please Select Atleast One Item To Receive";
            }

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['list'] = $this->unregistered_model->get_register_application_list_back();

            }elseif ($type == "bagclose") {
            
             if (!empty($check)) {

             //$id = $check[0];
             
                for ($i=0; $i <@sizeof($check) ; $i++) {

                 $id = $last_id = $check[$i];
                 $get = $this->unregistered_model->get_dest_region($id);
                 $rec_region = $get->receiver_region;
                 $rec_branch = $get->reciver_branch;
                 $source = $this->employee_model->get_code_source($sender_region);
                 $dest = $this->employee_model->get_code_dest($rec_region);
                 $number = rand(10000000,20000000);
                 

                 $angalia = $this->unregistered_model->get_bag_number_by_date($rec_region,$rec_branch);

                 if (empty($angalia)) {

                 $bagsNo = $source->reg_code . $dest->reg_code . $number;
                 $save = array();
                 $save = array(
                               'bag_number'=>$bagsNo,
                               'bag_origin_region'=>$sender_region,
                               'bag_branch_origin'=>$sender_branch,
                               'bag_region_to'=>$rec_region,
                               'bag_branch_to'=>$rec_branch,
                               'bag_created_by'=>$emid,
                               'service_category'=>$service_type
                               );
                 $this->unregistered_model->save_mails_bags($save);
                      
                      $trackno = array();
                      $trackno = array('sender_bag_number'=>$bagsNo,'sender_status'=>'Bag');
                      $this->unregistered_model->update_sender_info($last_id,$trackno);

                     $sum = $this->unregistered_model->get_sum_weight($bagsNo);
                     $weight = $sum->register_weght + $this->input->post('bagno');

                     $upbag = array();
                     $upbag = array('bag_weight'=>$weight);
                     $this->unregistered_model->update_bag_info($upbag,$bagsNo);


                 } else {


                      

                      $trackno = array();
                      $trackno = array('sender_bag_number'=>$angalia->bag_number,'sender_status'=>'Bag');
                      $this->unregistered_model->update_sender_info($last_id,$trackno);


                      $bagsNo =  $angalia->bag_number;
                      $sum = $this->unregistered_model->get_sum_weight($bagsNo);

                      $weight = $sum->register_weght + $angalia->bag_weight;
                      $upbag = array();
                      $upbag = array('bag_weight'=>$weight);
                      $this->unregistered_model->update_bag_info($upbag,$bagsNo);

                 }
              }

              $data['message'] = "Item Closed In Bag";
             
             } else {
                $data['errormessage'] = "Please Select Atleast One Item To Receive";
             }

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['list'] = $this->unregistered_model->get_register_application_list_back();

            } else {


              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['list'] = $this->unregistered_model->get_register_application_list_back();

            }
            
            $this->load->view('inlandMails/registered-domestic-dashboard',$data);

        }else{
                redirect(base_url());
            }
    }

    public function despatch_out()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');
              $search = $this->input->post('search');
              $this->session->set_userdata('despatch','Despout');
              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $this->session->set_userdata('service_type',$this->input->get('Ask_for'));

              if ($search == "search") {
                 $data['list'] = $this->unregistered_model->get_despatch_out_search($date,$month,$status);
              } else {
                 $data['list'] = $this->unregistered_model->get_despatch_list();
              }
              
              $this->load->view('inlandMails/despatch_out',$data);

        }else{
                redirect(base_url());
            }
    }
     public function despatch_in()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $date = $this->input->post('date');
              $month = $this->input->post('month');
              $status = $this->input->post('status');
              $search = $this->input->post('search');
              $this->session->set_userdata('despatch','Despin');

               $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $this->session->set_userdata('service_type',$this->input->get('Ask_for'));

              if ($search == "search") {
                 $data['list'] = $this->unregistered_model->get_despatch_in_search($date,$month,$status);
              } else {
                 $data['list'] = $this->unregistered_model->get_despatch_in_list();
              }
              
              $this->load->view('inlandMails/despatch_in',$data);

        }else{
                redirect(base_url());
            }
    }
    public function total_numbers_of_bags()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

              $search    = $this->input->post('search');
              $despatch  = $this->input->post('despatch');
              $check     = $this->input->post('I');

              $sender_region = $this->session->userdata('user_region');
              $sender_branch = $this->session->userdata('user_branch');
              $emid = $this->session->userdata('user_login_id');

              $data['ems'] = $this->unregistered_model->count_ems();
              $data['bags'] = $this->unregistered_model->count_bags();
              $data['despout'] = $this->unregistered_model->count_despatch();
              $data['despin'] = $this->unregistered_model->count_despatch_in();
              $data['recieved'] = $this->unregistered_model->count_item_received();

              $service_type = $this->input->get('Ask_for');

              if ($search == "search") {

                echo $date = $this->input->post('date');
                $month = $this->input->post('month');
                $status = $this->input->post('status');

                $data['list'] = $this->unregistered_model->get_number_of_bags_search($date,$month,$status);

              }elseif($despatch){

                if (empty($check)) {
                  $data['errormessage'] = "Please Select Atleast One Bag To Despatch";
                } else {
                
                //$id = $check[0];
                $transt = $this->input->post('transtype');
                $transname = $this->input->post('transname');
                $regno = $this->input->post('regno');
                $transcost = $this->input->post('transcost');

                //check in despatch number by date and region destionation

                for ($i=0; $i <sizeof($check) ; $i++) { 

                $id = $check[$i];
                $get = $this->unregistered_model->get_bag_destination_region($id);
                $rec_region = $get->bag_region_to;
                $branch_to  = $get->bag_branch_to;
                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($rec_region);
                $number = rand(10000000,20000000);
                $desp_no = $source->reg_code . $dest->reg_code . $number;

                //check in despatch number by date and region destionation
                $angalia = $this->unregistered_model->get_despatch_number_by_date($rec_region,$branch_to);
                
                 if (empty($angalia)) {
                  
                    $love = array();
                    $love = array(
                      'desp_no'=>$desp_no,
                      'origin_region'=>$sender_region,
                      'branch_origin'=>$sender_branch,
                      'region_to'=>$rec_region,
                      'branch_to'=>$branch_to,
                      'transport_type'=>$transt,
                      'transport_name'=>$transname,
                      'registration_number'=>$regno,
                      'transport_cost'=>$transcost,
                      'despatch_status'=>'Sent',
                      'despatch_by'=>$emid,
                      'service_type'=>$service_type
                    );

                    $this->unregistered_model->save_despatch_number($love);

                    $update = array();
                    $update = array('despatch_no'=>$desp_no,'bags_status'=>'isDespatch');

                    $this->unregistered_model->update_bags_info($update,$id);

                  } else {
                    
                    $update = array();
                    $update = array('despatch_no'=>$angalia->desp_no,'bags_status'=>'isDespatch');

                    $this->unregistered_model->update_bags_info($update,$id);

                  }
                  
                }

                $data['message'] = "Successfull Bags Despatch";

              }
                 
                $data['list'] = $this->unregistered_model->get_number_of_bags();

              }else{
                $data['list'] = $this->unregistered_model->get_number_of_bags();
              }
              
              
              
            $this->load->view('inlandMails/total_numbers_of_bags',$data);

        }else{
                redirect(base_url());
            }
    }

    public function receive_item_from_counter()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $check = $this->input->post('I');
            if (!empty($check)) {

                for ($i=0; $i <@sizeof($check) ; $i++) {
                    $last_id = $check[$i];
                    $trackno = array();
                    $trackno = array('sender_status'=>'BackReceive');
                    $this->unregistered_model->update_sender_info($last_id,$trackno);
                }
            $data['message'] = "Item Received";
            } else {
                $data['errormessage'] = "Please Select Atleast One Item To Receive";
            }
            
            $data['ems'] = $this->unregistered_model->count_ems();
            $data['list'] = $this->unregistered_model->get_register_application_list_back();
            $this->load->view('inlandMails/registered-domestic-dashboard',$data);
            
        }else{
                redirect(base_url());
        }
    }

public function despatch_item()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $select = $this->input->post('I');
            $transtype = $this->input->post('transport_type');
            $transname = $this->input->post('transport_name');
            $reg_no = $this->input->post('reg_no');
            $o_region = $this->input->post('region');
            $district = $this->input->post('district');
            $transcost = $this->input->post('transport_cost');
            $sender_region = $this->session->userdata('user_region');
            $o_branch = $this->session->userdata('user_branch');
            $bagreg     = $this->input->post('region');
            $despatch     = $this->input->post('despatch');
            $source = $this->employee_model->get_code_source($sender_region);
            $dest = $this->employee_model->get_code_dest($o_region);
            $number = rand(100000000,200000000);
            $despatchNo = $source->reg_code . $dest->reg_code . $number;
            $emid = $this->session->userdata('user_login_id');

            if (!empty($select)) {
                
                $data = array();
                $data = array('desp_no'=>$despatchNo,'region_from'=>$sender_region,'branch_from'=>$o_branch,'transport_type'=>$transtype,'transport_name'=>$transname,'registration_number'=>$reg_no,'transport_cost'=>$transcost,'despatch_status'=>'Sent','region_to'=>$o_region,'branch_to'=>$district,'despatch_by'=>$emid);
                $this->unregistered_model->save_despatch_info_mails($data);
            } else {
                # code...
            }
            
            
        }else{
                redirect(base_url());
        }
    }
    public function bags_closed_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $data['ems'] = $this->unregistered_model->count_ems();
            $data['bags'] = $this->unregistered_model->count_bags();
            $data['recieved'] = $this->unregistered_model->count_item_received();
            $data['list'] = $this->unregistered_model->get_bags_list();
            $this->load->view('inlandMails/registered-bags_list',$data);

        }else{
                redirect(base_url());
            }
    }

    public function posts_cargo()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/posts-cargo-form',$data);
        }else{
            redirect(base_url());
        }
    }

    public function posts_cargo_bulk()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/posts-cargo-bulk',$data);
        }else{
            redirect(base_url());
        }
    }

    public function parcel_dashboard()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            
            $this->load->view('inlandMails/parcel-post-dashboard');
    }

     public function parcel_post_domestic_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $this->load->view('inlandMails/parcel-post-domestic-form',$data);

        }else{
            redirect(base_url());
        }

    }

    public function parcel_post_price()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

           $type = $this->input->post('tariffCat');
           $weight = $this->input->post('weight');
           $trans = $this->input->post('trans');

           if ($trans == "Land") {
               $price = $this->unregistered_model->parcel_post_land_cat_price($type,$weight);
           } else {
               $price = $this->unregistered_model->parcel_post_water_cat_price($type,$weight);
           }

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

       }else{
        redirect(base_url());
       }

    }

    public function parcel_post_sender_info()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

            $trans = $this->input->post('transport');
            $weight = $this->input->post('weight');
            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
            $type = $this->input->post('emsname');
            $s_mobile = $this->input->post('s_mobile');
            $s_email = $this->input->post('s_email');
            $r_fname = $this->input->post('r_fname');
            $r_address = $this->input->post('r_address');
            $r_mobile = $this->input->post('r_mobile');
            $o_region = $region_to = $this->input->post('region_to');
            $rec_region = $district = $this->input->post('district');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');
            $serial    = 'Parcel'.date("YmdHis").$this->session->userdata('user_emid');
            $id = $emid = $this->session->userdata('user_login_id');
            $ad_fee = $this->input->post('ad_fee');
            $tarrif = $this->input->post('destination');
            $item   = $this->input->post('itemtype');

            if ($trans == "Land") {
                   $price = $this->unregistered_model->parcel_post_land_cat_price($type,$weight);
            } else {
                   $price = $this->unregistered_model->parcel_post_water_cat_price($type,$weight);
            }
          
            $paidamount = $Total = $price->tarrif + $price->vat ;
            
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'register_type'=>$trans,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$Total,'operator'=>$emid,'sender_type'=>'Parcels-Post');
            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('sender_person_info',$sender);


            $last_id = $db2->insert_id();

            $receiver = array();
            $receiver = array('sender_id'=>$last_id,'r_address'=>$r_address,'receiver_region'=>$region_to,'reciver_branch'=>$district,'receiver_fullname'=>$r_fname,'receiver_mobile'=>$r_mobile);

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
            $db2->insert('register_transactions',$trans);

            $renter   = 'Parcel Post';
            $serviceId = 'MAIL';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/parcel-post-control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);

            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

                $source = $this->employee_model->get_code_source($sender_region);
                $dest = $this->employee_model->get_code_dest($region_to);
                $bagsNo = $source->reg_code . $dest->reg_code;

                
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
                $this->unregistered_model->update_register_transactions1($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$repostbill->controlno.' Kwaajili ya huduma ya Parcel Post  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
                $this->load->view('inlandMails/parcel-post-control-number-form',$data);    
            }

        }else{
            redirect(base_url());
        }
    }


    public function parcel_post_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            $data['list'] = $this->unregistered_model->get_parcel_post_application_list();
            $data['sum']  = $this->unregistered_model->get_parcel_post_sum_register();
            $check = $this->input->post('I');
            $db2 = $this->load->database('otherdb', TRUE);
            $ids = $this->session->userdata('user_login_id');
            $search = $this->input->post('search');

            $data['region'] = $this->employee_model->regselect();

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
                    
                $this->load->view('inlandMails/parcel_post_application_list',$data);

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
                    //$month = $this->input->post('month');
                    //$region = $this->input->post('region');
                    $branch = $this->input->post('branch');

                    $dates = $this->input->post('date');
                    $month = $this->input->post('month');
                    $status = $this->input->post('status');
                    //$branch = $this->input->post('branch');
                     $region = $this->input->post('region');
          

           if(!empty($dates) || !empty($month) || !empty($region) ) { 
                   
                $data['list'] = $this->unregistered_model->search_application_list($date,$month,$region,$branch,$status);
                $data['sum']  = $this->unregistered_model->get_parcel_post_sum_search($date,$month,$region,$branch,$status);
               }else
               {
                      $data['list'] = $this->unregistered_model->search_application_list($date,$month,$region,$branch,$status);
                          $data['sum']  = $this->unregistered_model->get_parcel_post_sum_search($date,$month,$region,$branch,$status);

               }

                    
                  }

                   $this->load->view('inlandMails/parcel_post_application_list',$data);
                }
            
    }else{

        redirect(base_url());
    }
}
  public function small_packet_derivery_form()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                $data['ems_cat'] = $this->Box_Application_model->ems_cat();
                $data['region'] = $this->employee_model->regselect();
                $this->load->view('inlandMails/small-packet-derivery-form',$data);

        }else{
            redirect(base_url());
        }

    }

    public function save_small_packets_derivery()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

               $ident = $this->input->post('ident');
               $name = $this->input->post('name');
               $paidamount = $this->input->post('amount');
               $sender_region = $this->session->userdata('user_region');
               $sender_branch = $this->session->userdata('user_branch');
               $emid = $this->session->userdata('user_login_id');
               $s_mobile = $this->input->post('mobile');


               $data = array();
               $data = array(
                'identifier'=>$ident,
                'customer_name'=>$name,
                'amount'=>$paidamount,
                'region'=>$sender_region,
                'branch'=>$sender_branch,
                'mobile'=>$s_mobile,
                'operator'=>$emid
                );
               
               $db2 = $this->load->database('otherdb', TRUE);
               $db2->insert('derivery_info',$data);

            $last_id = $db2->insert_id();

            $serial    = 'Derivery'.date("YmdHis").$this->session->userdata('user_emid');
            $trans = array();
            $trans = array(

            'serial'=>$serial,
            'paidamount'=>$paidamount,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('derivery_transactions',$trans);

            $renter   = 'Small Packets';
            $serviceId = 'MAIL';
            $trackno = '009';
            $postbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno);

            //$controlno = $transaction->controlno;

            if (!empty($postbill->controlno)) {

                $serial = $postbill->billid;
                $update = array();
                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->unregistered_model->update_delivery_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Small Packets  ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                
                $this->load->view('inlandMails/small-packets_delivery-control-number-form',$data);
                
                $this->Sms_model->send_sms_trick($s_mobile,$sms);

            }

        }else{
            redirect(base_url());
        }

    }

    public function small_packet_deriver_application_list()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

          $dates = $this->input->post('date');
                    $month = $this->input->post('month');
                    $status = $this->input->post('status');
                    //$branch = $this->input->post('branch');
                     $region = $this->input->post('region');
          $data['region'] = $this->employee_model->regselect();

           if(!empty($dates) || !empty($month) || !empty($region) ) {
                   
           $data['list'] = $this->unregistered_model->get_parcel_post_delivery_application_Searchlist($dates,$month,$status,$region);
           $data['sum']  = $this->unregistered_model->get_parcel_post_sum_Search_delivery($dates,$month,$status,$region);
         }else
         {
                 $data['list'] = $this->unregistered_model->get_parcel_post_delivery_application_list();
                 $data['sum']  = $this->unregistered_model->get_parcel_post_sum_delivery();

         }


                 
                $this->load->view('inlandMails/small_packet_deriver_application_list',$data);

        }else{
            redirect(base_url());
        }

    }


    public function bags_item_list_by_despatchno()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                  $data['ems'] = $this->unregistered_model->count_ems();
                  $data['bags'] = $this->unregistered_model->count_bags();
                  $data['despout'] = $this->unregistered_model->count_despatch();
                  $data['despin'] = $this->unregistered_model->count_despatch_in();

                  $despno = base64_decode($this->input->get('despno'));
                  $type = $this->input->get('type');

                  if ($type == "Despin") {
                     $data['list'] = $this->unregistered_model->get_bags_list_by_despatch($despno);
                  } else {
                    $data['list'] = $this->unregistered_model->get_bags_list_by_despatch_out($despno);
                  }
                  
                  $this->load->view('inlandMails/bags_item_list_by_despatchno',$data);

        }else{
            redirect(base_url());
        }

    }

    public function item_list_by_bag_no()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                  $data['ems'] = $this->unregistered_model->count_ems();
                  $data['bags'] = $this->unregistered_model->count_bags();
                  $data['despout'] = $this->unregistered_model->count_despatch();
                  $data['despin'] = $this->unregistered_model->count_despatch_in();

                  $bagno = base64_decode($this->input->get('bagno'));
                  $type = $this->input->get('type');
                  $receive = $this->input->post('type');
                  $data['bagno'] = base64_decode($this->input->get('bagno'));
                  $check = $this->input->post('I');
                  $emid = $this->session->userdata('user_login_id');

                  if ($receive == "receive") {
                   
                      if (!empty($check)) {

                       for ($i=0; $i <sizeof($check) ; $i++) { 
                         
                         $last_id = $check[$i];

                         $geting = $this->unregistered_model->get_bag_number_mails($last_id);
                         $bagsNo =  $geting->sender_bag_number;

                         $trackno = array();
                         $trackno = array('sender_status'=>'Received','sender_received_by'=>$emid);
                         $this->unregistered_model->update_sender_info($last_id,$trackno);

                         $upbag = array();
                         $upbag = array('bags_status'=>'isReceived','bag_received_by'=>$emid);
                         $this->unregistered_model->update_bag_info($upbag,$bagsNo);

                         $get =  $this->unregistered_model->get_despatch_number_mails($bagsNo);
                         $despno = $get->despatch_no;

                         $updes = array();
                         $updes = array('despatch_status'=>'Received','received_by'=>$emid);
                         $this->unregistered_model->update_despatch_info($updes,$despno);

                       }

                       $data['message'] = "Successfull Item Received";
                      } else {
                        $data['errormessage'] = "Please Select Atleast One Item to Received";
                      }
                      

                  } 
                  
                  if ($type == "Despin") {
                    $data['list'] = $this->unregistered_model->get_register_application_list_back_by_bagno($bagno);
                  } else {
                    $data['list'] = $this->unregistered_model->get_register_application_list_back_by_bagno_out($bagno);
                  }
                  $this->load->view('inlandMails/item_list_by_bag_no',$data);

        }else{
            redirect(base_url());
        }

    }

    public function domestic_item_ready_to_deliver()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                $search = $this->input->post('search');
                $names   = $this->input->post('names');
                $number   = $this->input->post('number');

                if (!empty($search)) {
                  $data['list'] = $this->unregistered_model->get_register_application_list_received_seach($names,$number);
                } else {
                  $data['list'] = $this->unregistered_model->get_register_application_list_received();
                }
                
                 $this->load->view('inlandMails/domestic_item_ready_to_deliver',$data);

        }else{
            redirect(base_url());
        }

    }

    public function deliverer_information()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                $data['sender_id'] = base64_decode($this->input->get('sender_id'));
                $name = $this->input->post('name');
                $identity = $this->input->post('identity');
                $isnumber = $this->input->post('isnumber');
                $phone = $this->input->post('phone');
                $last_id = $this->input->post('sender_id');
                $emid = $this->session->userdata('user_login_id');
                $service_type = $this->session->userdata('service_type');


                $save = array();
                $save = array('deliverer_name '=>$name,
                  'identity'=>$identity,
                  'identityno'=>$isnumber,
                  'd_status'=>'Yes',
                  'sender_id'=>$last_id,
                  'operator'=>$emid,
                  'phone'=>$phone,
                  'service_type'=>$service_type
              );

                $this->unregistered_model->save_delivery_infomation($save);

                $data['message'] = "Successfull Saved";

                $trackno = array();
                $trackno = array('sender_status'=>'Derivery');
                $this->unregistered_model->update_sender_info($last_id,$trackno);

              $this->load->view('inlandMails/deliverer-information-form',$data);

        }else{
            redirect(base_url());
        }
    }


    public function details_information()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){

                $id = base64_decode($this->input->get('sender_id'));
                $data['info'] = $this->unregistered_model->get_delivery_info($id);
              
                $this->load->view('inlandMails/deliver-details-information',$data);

        }else{
            redirect(base_url());
        }

    }



     public function registered_international_List()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->unregistered_model->get_registered_international_list_search($date,$month,$region);
               

           } else 
           {

            $data['list'] = $this->unregistered_model->get_registered_international_list();

           }


           
           $this->load->view('inlandMails/registered_international_List',$data);
        } else {
            redirect(base_url());
        }
        
    }

   

    
  public function registered_international_form()
    {
        if ($this->session->userdata('user_login_access') != false) {

                  if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Unregistered/registered_international_List'));

         }

           //$data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           //$data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('inlandMails/registered_international_form');
           
        
    }
  }





 public function Save_registered_international()
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

            $this->unregistered_model->Save_registered_international1($data);

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
            $trackno = '009'.$bagsNo;
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Registered International,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya Registered International,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('inlandMails/registered_international_control_number',$data);
            }else{
                redirect('Unregistered/registered_international_list');
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