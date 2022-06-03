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
         $this->load->model('unregistered_model');
    }


    public function Save_Ems_Info(){
        if ($this->session->userdata('user_login_access') != false) {
           
            $barcode = $this->input->post('Barcode');
            $cat = $this->input->post('emstype');
            $country = $this->input->post('emsCat');
            $weight = $this->input->post('weight');
            $s_fname = $this->input->post('s_fname');
            $s_address = $this->input->post('s_address');
            $mobile = $this->input->post('s_mobile');
            $r_fname = $this->input->post('r_fname');
            $r_address = $this->input->post('r_address');
            $r_mobile = $this->input->post('r_mobile');
            $price = $this->input->post('price');

            $userid = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($userid);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
           
            $sender = array(
                'ems_type'=>$cat,
                'cat_type'=>'International',
                'weight'=>$weight,
                's_fullname'=>$s_fname,
                's_address'=>$s_address,
                's_mobile'=>$mobile,
                's_region'=>$o_region,
                's_district'=>$o_branch,
                'operator'=>$userid,
                'serial'=>$barcode);

            //saving of information of sender
            $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);

           
            $receiver = array(
                'from_id'=>$savedSenderInfoId,
                'fullname'=>$r_fname,
                'address'=>$r_address,
                'address'=>$s_address,
                'mobile'=>$r_mobile,
                'r_region'=>$country);

             //saving information of receiver
            $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);

            $source = $this->employee_model->get_code_source($o_region);

            $bagsNo = $source->reg_code;
            $serial    = 'EMSI'.date("YmdHis").$source->reg_code;

            //Saving transaction data
            $lastSavedId = $this->Box_Application_model->save_transactions(array(
                'Barcode'=>$barcode,
                'serial'=>$serial,
                'paidamount'=>$price,
                'CustomerID'=>$savedSenderInfoId,
                'Customer_mobile'=>$mobile,
                'region'=>$o_region,
                'district'=>$o_branch,
                'office_name'=>'Counter',
                'transactionstatus'=>'POSTED',
                'bill_status'=>'PENDING',
                'paymentFor'=>'EMS_INTERNATIONAL'));

            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = 'ems_international';
            $serviceId = 'EMS_POSTAGE';
            $trackno = '90'.$bagsNo;


            if ($lastSavedId) {
                $results['status'] = "Success";

                //Process controll number
                $transaction = $this->getBillGepgBillIdEMS($serial,$paidamount,$region,$district,$mobile,$renter,$serviceId,$trackno);
                

                $serial1 = $serial;//Serial number

                if ($transaction->controlno) {

                    $this->billing_model->update_transactions(array(
                        'billid'=>$transaction->controlno,
                        'bill_status'=>'SUCCESS'),$serial1);

                    //Creating controll number
                    $first4 = substr($transaction->controlno, 4);
                    $trackNo = '90'.$bagsNo.$first4;

                    //Update track number
                    $this->billing_model->update_sender_info($savedSenderInfoId,array('track_number'=>$trackNo));


                     $message ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                     //Sending message
                    $this->Sms_model->send_sms_trick($mobile,$message);

                    $results['message'] =  $message;

                }else{
                    $results['message'] = 'Item yako imeshasajiliwa ila control number aijatoka, wasiliana na wataalam wa ICT';
                }

                
            }else{
                $results['status'] = "Error";
                $results['message'] = 'Item yako aijasajiliwa, wasiliana na wataalam wa ICT';
            }

            print_r(json_encode($results));
        } else {
            redirect(base_url());
        }    
}
    
	
    public function OldSave_Ems_Info()
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
            'Barcode'=>$barcode,
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

                 $data['result'] ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                 $total ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$transaction->controlno.' Kwaajili ya huduma ya EMS,Kiasi unachotakiwa kulipia ni TSH.'.number_format($price,2);

                $this->Sms_model->send_sms_trick($mobile,$total);

                $this->load->view('ems/international_ems_control_number',$data);
            }else{
                redirect('Ems_International/Ems_International_Application_List');
            }


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



//BILL INTERNATIONAL
public function bill_international_ems_bulk_save()
{
if ($this->session->userdata('user_login_access') != false)
{

            $barcode = $this->input->post('barcode');
            $emsCat = $this->input->post('boxtype');
            $emsname = $this->input->post('boxtype');
            $country = $this->input->post('country');
            $weight = $this->input->post('weight');
            $price = $this->input->post('price');
            $receiver_address = $this->input->post('r_mobilev');
            //$crdtid  = $this->input->post('crdtid');
            //$info = $this->Box_Application_model->get_customer_infos($crdtid);


$serial = $this->input->post('serial');

$sender = $this->input->post('sender');
$senderp = $this->input->post('sender');
$target_url = "http://192.168.33.7/api/virtual_box/";

//get sender information
$info = $this->Box_Application_model->get_customer_infos($sender);

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



$id = $this->session->userdata('user_login_id');
$infos = $this->Box_Application_model->GetBasic($id);
$o_regions = $infos->em_region;
$o_branchs = $infos->em_branch;


/*$transactionstatus   = 'POSTED';
$bill_status  = 'PENDING';
$fullname  = $s_fname;*/
$source = $this->employee_model->get_code_source($o_regions);
//$dest = $this->employee_model->get_code_dest($rec_region);

$number = $this->getnumber();
$bagsNo = 'EEI'.@$source->reg_code.@$number.'TZ';

$serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    =$barcode;// 'EMSI'.date("YmdHis").$source->reg_code;
               $serial    = 'EMSINT'.date("YmdHis").$source->reg_code;
            }


 $trackno = $bagsNo;

$id = $this->session->userdata('user_login_id');
$getPending = $this->Box_Application_model->get_pending_task1($id);

 if ( $getPending == 100) {

     $data['message'] = "You Have 10 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
          $this->load->view('ems/control-number-form',$data);

 } else {

    //////////////////////////
        $i = $this->employee_model->GetBasic($id);
        $acc_no = $info->acc_no;
        if($info->customer_type == "PostPaid"){

        if($info->price < $price){
            
            echo 'Umefikia Kiwango Cha mwisho cha Kukopeshwa';

        }
        else{

        $diff = $info->price - $price;
        $up = array();
        $up = array('price'=>$diff);
        $this->Box_Application_model->update_price1($up,$acc_no);

        
        $sender = array();
        $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id,'amount'=>$price);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();


        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$country);

        $db2->insert('receiver_info',$receiver);


         $mobile = $s_mobile;


     $data = array();
        $data = array(

            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$info->cust_mobile,
            'region'=>$o_regions,
            'district'=>$o_branchs,
            'Barcode'=>strtoupper($barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'paymentFor'=>'EMS_INTERNATIONAL',
            'status'=>'Bill',
            'customer_acc'=>$info->acc_no
            // 'item_price'=>$price

        );

        $this->Box_Application_model->save_transactions($data);

         $id = $emid = $this->session->userdata('user_login_id');
              $sender_id=$last_id;
              $operator=$emid;
               //$listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
               $listbulk= $this->unregistered_model->GetListemsIntrbulkTrans($operator,$serial);

             echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;

                  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->country_name."</td> <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
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
            //echo $info->acc_no;
        } else {
        
        $diff = $info->price - $price;
        $up = array();
        $up = array('price'=>$diff);
        $this->Box_Application_model->update_price($up,$acc_no);

        $sender = array();
        $sender = array('ems_type'=>$emsname,'cat_type'=>$emsCat,'weight'=>$weight,'s_fullname'=>$info->customer_name,'s_address'=>$info->customer_address,'s_email'=>$info->cust_email,'s_mobile'=>$info->cust_mobile,'s_region'=>$o_regions,'s_district'=>$o_branchs,'track_number'=>$trackno,'s_pay_type'=>$info->customer_type,'bill_cust_acc'=>$info->acc_no,'operator'=>$i->em_id,'amount'=>$price);

        $db2 = $this->load->database('otherdb', TRUE);
        $db2->insert('sender_info',$sender);
        $last_id = $db2->insert_id();


        $receiver = array();
        $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$country);

        $db2->insert('receiver_info',$receiver);

        $data = array();
        $data = array(

            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$info->cust_mobile,
            'region'=>$o_regions,
            'district'=>$o_branchs,
            'Barcode'=>strtoupper($barcode),
            'transactionstatus'=>'POSTED',
            'bill_status'=>'BILLING',
            'paymentFor'=>'EMS_INTERNATIONAL',
            'status'=>'Bill',
            'customer_acc'=>$info->acc_no

        );

        $this->Box_Application_model->save_transactions($data);

       
  $id = $emid = $this->session->userdata('user_login_id');
              $sender_id=$last_id;
              $operator=$emid;
               //$listbulk= $this->unregistered_model->GetListbulkTrans($operator,$serial);
              $listbulk= $this->unregistered_model->GetListemsIntrbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->country_name."</td>  <td>".$value->Barcode."</td><td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$sender_id." class='senders'>
                 <input type='hidden' name ='sender' value=".$senderp." class='sender'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";




        
        }

  }

////

    
    }


    }else{
    redirect(base_url());
    }
}
//END BILL INTERNATIONAL


public function international_ems_bulk_save(){
    if ($this->session->userdata('user_login_access') != false){

        $barcode = $this->input->post('barcode');
        $cat = $this->input->post('emsname');
        $country = $this->input->post('country');
        $weight = $this->input->post('weight');
        $price = $this->input->post('price');
        $serial = $this->input->post('serial');
        $sender_address = $this->input->post('s_mobilev');
        $receiver_address = $this->input->post('r_mobilev');
        $snTag = $this->input->post('counterIterm');

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

        //Balance
        $balance = $this->input->post('balance');


        $userid = $this->session->userdata('user_login_id');
        $info = $this->employee_model->GetBasic($userid);
        $o_region = $info->em_region;
        $o_branch = $info->em_branch;


        $transactionstatus   = 'POSTED';
        $bill_status  = 'PENDING';
        $fullname  = $s_fname;
        $source = $this->employee_model->get_code_source($o_region);
        //$dest = $this->employee_model->get_code_dest($rec_region);

        $number = $this->getnumber();
        $bagsNo = 'EEI'.@$source->reg_code.@$number.'TZ';

        $serial = $this->input->post('serial');

        if(empty($serial)){
           $serial    = $barcode;// 'EMSI'.date("YmdHis").$source->reg_code;
        }

        $trackno = $bagsNo;

        $sender = array(
            'ems_type'=>$cat,
            'cat_type'=>'International',
            'weight'=>$weight,
            's_fullname'=>$s_fname,
            's_address'=>$s_address,
            's_mobile'=>$mobile,
            's_region'=>$o_region,
            's_district'=>$o_branch,
            'operator'=>$userid,
            'serial'=>$serial,
            'add_type'=>$addressT,
            'track_number'=>$trackno);


        //saving of information of sender
        $savedSenderInfoId = $this->Box_Application_model->saveSenderInfo($sender);

         $receiver = array(
            'from_id'=>$savedSenderInfoId,
            'fullname'=>$r_fname,
            'address'=>$r_address,
            'mobile'=>$r_mobile,
            'r_region'=>$country,
            'add_type'=>$addressR);

          //saving information of receiver
            $savedReceiverInfoId = $this->Box_Application_model->saveReceiverInfo($receiver);

             //Saving transaction data
            $lastSavedId = $this->Box_Application_model->save_transactions(array(
            'transactiondate'=>date("Y-m-d"),    
            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$savedSenderInfoId,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
            'Barcode'=>$barcode,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'EMS_INTERNATIONAL'));

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
                  <td>".$tranDetails[0]['country_name']."</td>
                  <td>".$tranDetails[0]['Barcode']."</td>
                  <td>".number_format($tranDetails[0]['paidamount'],2)."</td>
                  <td>
                  <input type='hidden' name ='serial' value=".$serial." class='serial'>
                  <button 
                  data-transid=".$tranDetails[0]['id']." 
                  data-serial=".$tranDetails[0]['serial']." 
                   data-item_amount=".$tranDetails[0]['paidamount']." 
                  data-senderid=".$tranDetails[0]['CustomerID']."  class='btn btn-info Delete' onclick='Deletevalue(this);' type='button'   id='Delete'>Delete </button>
                  </td></td>";

                  $results['messageData'] = $transactionData;
                
            }else{
                $results['status'] = "Error";

            }

            print_r(json_encode($results));
    }else{
        redirect(base_url());
    }

}


public function Oldinternational_ems_bulk_save()
{
if ($this->session->userdata('user_login_access') != false)
{

            $barcode = $this->input->post('barcode');
             $cat = $this->input->post('emsname');
            $country = $this->input->post('country');
            $weight = $this->input->post('weight');
              $price = $this->input->post('price');

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
$fullname  = $s_fname;
$source = $this->employee_model->get_code_source($o_region);
//$dest = $this->employee_model->get_code_dest($rec_region);

$number = $this->getnumber();
$bagsNo = 'EEI'.@$source->reg_code.@$number.'TZ';

$serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    =$barcode;// 'EMSI'.date("YmdHis").$source->reg_code;

            }


 $trackno = $bagsNo;

$getPending = $this->Box_Application_model->get_pending_task1($id);

 if ( $getPending == 100) {

     $data['message'] = "You Have 10 Items ,Please Make Sure The Item is Paid And Transfer to Back Office";
          $this->load->view('ems/control-number-form',$data);

 } else {


     $sender = array();
     $sender = array();
            $sender = array('ems_type'=>$cat,'cat_type'=>'International','weight'=>$weight,'s_fullname'=>$s_fname,'s_address'=>$s_address,'s_email'=>$s_email,'s_mobile'=>$mobile,'s_region'=>$o_region,'s_district'=>$o_branch,'operator'=>$id,'serial'=>$serial,'add_type'=>$addressT,'track_number'=>$trackno);

    

     $db2 = $this->load->database('otherdb', TRUE);
     $db2->insert('sender_info',$sender);
     $last_id = $db2->insert_id();

 

     $receiver = array();
     $receiver = array('from_id'=>$last_id,'fullname'=>$r_fname,'address'=>$r_address,'email'=>$r_email,'mobile'=>$r_mobile,'r_region'=>$country,'add_type'=>$addressR);

     $db2->insert('receiver_info',$receiver);

     //get price by cat id and weight range;

    
     $mobile = $s_mobile;


      $data = array();
             $data = array(


            'transactiondate'=>date("Y-m-d"),    
            'serial'=>$serial,
            'paidamount'=>$price,
            'CustomerID'=>$last_id,
            'Customer_mobile'=>$mobile,
            'region'=>$o_region,
            'district'=>$o_branch,
             'Barcode'=>$barcode,
            'transactionstatus'=>'POSTED',
            'bill_status'=>'PENDING',
            'paymentFor'=>'EMS_INTERNATIONAL'

            );

            $this->Box_Application_model->save_transactions($data);

    

    

              $id = $emid = $this->session->userdata('user_login_id');
              $sender_id=$last_id;
              $operator=$emid;
               $listbulk= $this->unregistered_model->GetListemsIntrbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination </b></th></th><th><b>Barcode Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->country_name."</td> <td>".$value->Barcode."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>


                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
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

public function delete_ems_international_bulk_info(){
    $senderid = $this->input->post('senderid');
    $serial = $this->input->post('serial');

    $this->unregistered_model->delete_bulk_bysenderid_info($senderid);

    //$emid  = $this->session->userdata('user_login_id');
    //$operator=$emid;

    $response['status'] = 'Success';

    print_r(json_encode($response));
}


public function Olddelete_ems_international_bulk_info()
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
              $listbulk= $this->unregistered_model->GetListemsIntrbulkTrans($operator,$serial);


            echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination </b></th></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) { 

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->fullname."<td>".$value->s_fullname."<td>".$value->s_region."<td>".$value->s_district."</td><td>".$value->country_name."</td> <td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td>
                  <td>

                   
                   <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                  
                 </td></tr>";
                }

                // <a href='#' class='btn btn-info Delete' value=".$value->sender_id."  id='Delete' >Delete </a>

              // <button  class='btn btn-info ' value=".$value->sender_id."  id='Delete'>Delete </button>
                // <a href=".base_url()."unregistered/delete_register_sender_bulk_info?I=".base64_encode($value->senderp_id)."&&S=".base64_encode($value->serial)." class='btn btn-info'>Delete</a>
               

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='senders' value=".$senderid." class='senders'>
                 <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                   
                        ";


          // $this->session->set_flashdata('success','Deleted Successfull');
}


public function save_bulk_international_info(){
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

            $postbill =  $this->getBillGepgBillIdEMS($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo);


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


public function Oldsave_bulk_international_info(){



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



$postbill =  $this->getBillGepgBillIdEMS($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo); 
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

                $repostbill =  $this->getBillGepgBillIdEMS($serial,$paidamount,$sender_region,$sender_branch,$mobile,$renter,$serviceId,$trackNo);  

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

 public function International_bulk_Ems()
    {
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');

          //$country = $this->organization_model->countryselect();
           $data['country'] = $this->organization_model->countryselect();
           //$country = $countries->country_name;

      $this->load->view('ems/international_ems_bulk_form',$data);
           
        
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

public function Ems_price_vat_international(){
if ($this->session->userdata('user_login_access') != false) {

$emsCat = $this->input->post('tariffCat');
$weight = $this->input->post('weight');
$emstype = $this->input->post('emstype');

$Getzone = $this->organization_model->get_zone_country($emsCat);
$zone    = $Getzone->zone_name;

///////////////////START
$userregion =  $this->session->userdata('user_region');
if($userregion=="Kigoma" && $emstype=="Parcel" && $Getzone->country_name=="USA" || $userregion=="Rukwa" && $emstype=="Parcel" && $Getzone->country_name=="USA"){
//////////////GET NEW EMS INTERNATION PARCEL TARIFF
$gettariffinfo = $this->organization_model->get_ems_internation_special_tariff($weight);

        $totalPrice = $gettariffinfo->price;
        @$emsprice = (100*$totalPrice)/118;
        @$emsvat = @$totalPrice - @$emsprice;
        $finalemsprice = number_format($emsprice,2);
        $finalemsvat = number_format($emsvat,2);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr> <td><b>Price:</b></td> <td> $finalemsprice </td> </tr>
            <tr> <td><b>Vat:</b></td> <td> $finalemsvat </td> </tr>
            <tr><td><b>Total Price:</b></td><td><input id='totalPrice' type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";

} else {


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
        }if ($zone == 'ZONE8') {
            $totalPrice = $totalprice10 + 24400;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);

         ///////////////////
        @$emsprice = (100*$totalPrice)/118;
        @$emsvat = @$totalPrice - @$emsprice;
        $finalemsprice = number_format($emsprice,2);
        $finalemsvat = number_format($emsvat,2);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr> <td><b>Price:</b></td> <td> $finalemsprice </td> </tr>
            <tr> <td><b>Vat:</b></td> <td> $finalemsvat </td> </tr>
            <tr><td><b>Total Price:</b></td><td><input id='totalPrice' type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
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
                }if ($zone == 'ZONE8') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*24400;
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
                    }if ($zone == 'ZONE8') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*24400 + 24400;
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
                    }if ($zone == 'ZONE8') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*24400 + 24400 + 24400;
                    }
                }

            }
            $dvat = $totalPrice * 0.18;
         $dprice = $totalPrice - ($totalPrice * 0.18);

        ///////////////////
        @$emsprice = (100*$totalPrice)/118;
        @$emsvat = @$totalPrice - @$emsprice;
        $finalemsprice = number_format($emsprice,2);
        $finalemsvat = number_format($emsvat,2);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr> <td><b>Price:</b></td> <td> $finalemsprice </td> </tr>
            <tr> <td><b>Vat:</b></td> <td> $finalemsvat </td> </tr>
            <tr><td><b>Total Price:</b></td><td><input readonly id='totalPrice' type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
            </table>";
    }
   ///////////PARCEL
    } else {


    /////////////////////////START

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
        }if ($zone == 'ZONE8') {
            $totalPrice = $totalprice10 + 25200;
        }

        $dvat = $totalPrice * 0.18;
        $dprice = $totalPrice - ($totalPrice * 0.18);


         ///////////////////
        @$emsprice = (100*$totalPrice)/118;
        @$emsvat = @$totalPrice - @$emsprice;
        $finalemsprice = number_format($emsprice,2);
        $finalemsvat = number_format($emsvat,2);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr> <td><b>Price:</b></td> <td> $finalemsprice </td> </tr>
            <tr> <td><b>Vat:</b></td> <td> $finalemsvat </td> </tr>
            <tr><td><b>Total Price:</b></td><td><input readonly id='totalPrice' type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
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
                }if ($zone == 'ZONE8') {
                    $totalPrice = $totalprice10 + ($whole*1000/500)*25200;
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
                    }if ($zone == 'ZONE8') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*25200 + 25200;
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
                    }if ($zone == 'ZONE8') {
                        $totalPrice = $totalprice10 + ($whole*1000/500)*25200 + 25200 + 25200;
                    }
                }

            }

            $dvat = $totalPrice * 0.18;
            $dprice = $totalPrice - ($totalPrice * 0.18);

            
            ///////////////////
        @$emsprice = (100*$totalPrice)/118;
        @$emsvat = @$totalPrice - @$emsprice;
        $finalemsprice = number_format($emsprice,2);
        $finalemsvat = number_format($emsvat,2);

        echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr> <td><b>Price:</b></td> <td> $finalemsprice </td> </tr>
            <tr> <td><b>Vat:</b></td> <td> $finalemsvat </td> </tr>
            <tr><td><b>Total Price:</b></td><td><input readonly id='totalPrice' type='text' name ='price' value='$totalPrice' class='price1'></td></tr>
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
            <tr><td><b>Price:</b></td><td><input readonly type='text' name ='price1' value='$Getprice->zone_tariff' class='price1'></td></tr>
            <tr><td><b>Vat:</b></td><td><input readonly type='text' name ='vat' value='$Getprice->zone_vat' class='price1'></td></tr>
            <tr><td><b>Total Price:</b></td><td><input readonly id='totalPrice' type='text' name ='price' value='$Getprice->zone_price' class='price1'></td></tr>
            </table>";

        }
    }
    
   

}
} else{
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


    $date = $this->input->post('date');
   $month = $this->input->post('month'); 
   $region = $this->input->post('region'); 
   if(!empty($date) || !empty($month) || !empty($region)){
            $data['emslist1'] = $this->Ems_International_model->get_ems_international_back_list_Search($date,$month,$region);

        }else{
            $data['emslist1'] = $this->Ems_International_model->get_ems_international_back_list();

        }



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