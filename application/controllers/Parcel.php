 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parcel extends CI_Controller {


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

    public function Save_international_to_Registertransactions()
    {
        

            $list= $this->parcel_model->getParcInter();
            foreach ($list as $key => $value) {
                // code...

                 $trans = array();
            $trans = array(

            'serial'=>$value->serial,
            'paidamount'=>$value->paidamount,
            'register_id'=>$value->register_id,
            'transactionstatus'=>$value->transactionstatus,
             'Barcode'=>strtoupper($value->acc_no),
            'bill_status'=>$value->bill_status,
            'transactiondate'=>$value->transactiondate,
            'paymentdate'=>$value->paymentdate,
            'billid'=>$value->billid,
            'receipt'=>$value->receipt,
             'paychannel'=>$value->paychannel,
            'status'=>$value->status

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);

            }
            echo 'Successfully';           

        }
    
	public function international_parcel_form()
	{
		#Redirect to Admin dashboard after authentication
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/international_parcel_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){
            $data['country'] = $this->parcel_model->country_name();
			$this->load->view('parcel/parcel-international-form',$data);
	}else{
        redirect(base_url());
    }
  }

  public function international_bulk_parcel_form()
    {
        #Redirect to Admin dashboard after authentication
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/international_parcel_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){
            $data['country'] = $this->parcel_model->country_name();
            $this->load->view('parcel/parcel-post-international-bulk-form',$data);
    }else{
        redirect(base_url());
    }
  }


    public function bulk_parcel_post_application_form()
    {
        #Redirect to Admin dashboard after authentication
          if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/bulk_parcel_post_application_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){


              $data['region'] = $this->employee_model->regselect();
            $data['total'] = $this->Box_Application_model->get_ems_sum();
            $data['ems_cat'] = $this->Box_Application_model->ems_cat();
            $data['region'] = $this->employee_model->regselect();

            $data['country'] = $this->parcel_model->country_name();
            $this->load->view('parcel/bulk_parcel_post_application_form',$data);
    }else{
        redirect(base_url());
    }
  }


  public function bulk_parcel_post_application_list()
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
    
    $this->load->view('Parcel/bulk_parcel_post_application_list',$data);

}
else{
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

  public function parcel_price_vat_international_Additional()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            
            $emsCat = $this->input->post('tariffCat');
            $weight = $this->input->post('weight');
             $Additional = $this->input->post('Additional');

            
            if ($weight > 1) {
                $diff = $weight -1;

                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $total = number_format($getPrice->tarrif + $getPrice->vat + $diff*($getPrice->addition ),2);
                $tarrif = number_format($getPrice->tarrif,2);
                $vat = number_format($getPrice->vat,2);
            } else {
                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $total = $getPrice->tarrif + $getPrice->vat;
                $total = number_format($getPrice->tarrif + $getPrice->vat + $Additional,2);
                $tarrif = number_format($getPrice->tarrif,2);
                $vat = number_format($getPrice->vat,2);
            }
            
        if (empty($getPrice)) {

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>0</td></tr>
            <tr><td><b>Vat:</b></td><td>0</td></tr>
            <tr><td><b>Advice of Payment:</b></td><td>0</td></tr>
            <tr><td><b>Total Price:</b></td><td>0</td></tr>
            </table>";

        }else{

            echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
            <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
            <tr><td><b>Price:</b></td><td>$tarrif</td></tr>
            <tr><td><b>Vat:</b></td><td>$vat</td></tr>
            <tr><td><b>Advice of Payment:</b></td><td>$Additional</td></tr>
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
            
            $Item = $this->input->post('Item');
             $Additional = $this->input->post('Additional');
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
            $paidamount = $Total + $Additional;
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$paidamount,'operator'=>$emid,'sender_type'=>'Parcels-Inter','acc_no'=>$Item);
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
            'paidamount'=>$paidamount,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
             'Barcode'=>strtoupper($Item),
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);

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


public function save_International_bulk_transactions()
    {
        #Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1){
            
            $Additional = $this->input->post('Additional');
             $weight = $this->input->post('weight');
             $Item = $this->input->post('Item');

            $emsCat = $region_to = $this->input->post('tariffCat');
            $sender_region = $this->session->userdata('user_region');
            $sender_branch = $this->session->userdata('user_branch');

           
            $sender_address = $this->input->post('s_mobilev');
            $receiver_address = $this->input->post('r_mobilev');
            $target_url = "http://192.168.33.7/api/virtual_box/";


            if(empty($sender_address) ){

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
             // $rec_region = $this->input->post('region_to');
             // $rec_dropp = $this->input->post('district');

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



             $addressR = "physical";
             $r_fname = $this->input->post('r_fname');
             $r_address = $this->input->post('r_address');
             $r_mobile = $this->input->post('r_mobile');
             $r_email = $this->input->post('r_email');
             // $rec_region = $this->input->post('region_to');
             // $rec_dropp = $this->input->post('district');

            }


              $serial = $this->input->post('serial');
            if(empty($serial)){
               $serial    = 'PInter'.date("YmdHis").$this->session->userdata('user_emid');

               // $serial    = 'Register'.date("YmdHis").$this->session->userdata('user_emid');

            }



            $id = $emid = $this->session->userdata('user_login_id');
            //$serial    = 'PInter'.date("YmdHis").$id;
                $source = $this->employee_model->get_code_source($sender_region);
                //$dest = $this->employee_model->get_code_dest($region_to);
                //$bagsNo = $source->reg_code . $dest->reg_code;

                $number = $this->getnumber();
                //$bagsNo = $source->reg_code . $dest->reg_code;
                @$trackNo = 'CP'.@$source->reg_code . @$emsCat.$number.'TZ';





            
            if ($weight > 1) {
                $diff = $weight-1;

                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $Total = $getPrice->tarrif + $getPrice->vat + $diff*($getPrice->addition );
                
            } else {

                $getPrice    = $this->parcel_model->get_country_price($emsCat);
                $Total = $getPrice->tarrif + $getPrice->vat;
                
            }
            $paidamount = $Total + $Additional; 
            $sender = array();
            $sender = array('sender_fullname'=>$s_fname,'sender_address'=>$s_address,'sender_email'=>$s_email,'sender_mobile'=>$s_mobile,'sender_region'=>$sender_region,'sender_branch'=>$sender_branch,'register_weght'=>$weight,'register_price'=>$paidamount,'operator'=>$emid,'sender_type'=>'Parcels-Inter','track_number'=>$trackNo,'acc_no'=>$Item);
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
            'paidamount'=>$paidamount,
            'register_id'=>$last_id,
            'transactionstatus'=>'POSTED',
            'Barcode'=>strtoupper($Item),
            'bill_status'=>'PENDING'

            );

            $db2 = $this->load->database('otherdb', TRUE);
            $db2->insert('register_transactions',$trans);


            $sender_id=$last_id;
              $operator=$emid;
               $listbulk= $this->parcel_model->GetListbulkPacelInternational($operator,$serial);


              echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th><th><b>Item Number</b></th><th><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td> <td>".$value->acc_no."</td><td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td><td>
                    <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                    </td></tr>";
                }  

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                  <input type='hidden' name ='senders' value=".$sender_id." id='senders' class='senders'>
                   
                        ";




          
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



public function save_parcel_international_application_bulk_info()
{

  $id  = $this->session->userdata('user_login_id');
   $info = $this->employee_model->GetBasic($id);
                $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;
   $serial = $this->input->post('serial');
   $operator = $this->input->post('operator');

   $listbulk= $this->parcel_model->GetListbulkPacelInternational($operator,$serial);
     $alltotal = 0;
     
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->paidamount;
   
                
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
               
                $serial = $postbill->billid;
                $update = array();
                $update = array('billid'=>$postbill->controlno,'bill_status'=>'SUCCESS');
                $this->parcel_model->update_parcel_international_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.$postbill->controlno.' Kwaajili ya huduma ya Parcels International ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);
           
            //if (!empty($transaction->$controlno)) {
                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
               // $this->load->view('inlandMails/control-number-form',$data);
                
               
               // $this->session->set_flashdata('success','Saved Successfull');
          
            }else{

                $repostbill = $this->Control_Number_model->get_control_number($serial,$paidamount,$sender_region,$sender_branch,$s_mobile,$renter,$serviceId,$trackno); 

              
               $serial = $repostbill->billid;
                $update = array();
                $update = array('billid'=>$repostbill->controlno,'bill_status'=>'SUCCESS');
                $this->parcel_model->update_parcel_international_transactions($update,$serial);

                $data['sms'] = $sms ='KARIBU POSTA KIGANJANI umepatiwa nambari ya malipo hii hapa'. ' '.@$repostbill->controlno.' Kwaajili ya huduma ya Parcels International ,Kiasi unachotakiwa kulipia ni TSH.'.number_format($paidamount,2);

                 $this->Sms_model->send_sms_trick($s_mobile,$sms);
                 echo $sms;
                //$this->load->view('inlandMails/control-number-form',$data);    

                 //$this->session->set_flashdata('success','Saved Successfull');
                  
            }

          

}


public function delete_international_pacel_sender_bulk_info()
{


           $senderid = $this->input->post('senderid');
            $serial = $this->input->post('serial');
            //echo $senderid;
             // echo $serial;

           // $senderid = base64_decode($this->input->get('I')); 
           //  $serial = base64_decode($this->input->get('S')); 

           $this->parcel_model->delete_bulk_international_bysenderid($senderid);

               $emid  = $this->session->userdata('user_login_id');
              $operator=$emid;
              $listbulk= $this->parcel_model->GetListbulkPacelInternational($operator,$serial);


              echo "<table style='width:100%;' class='table table-bordered'>
                <tr style='width:100%;color:#3895D3;'><th><b>Receiver</b></th><th><b>Sender</b></th><th><b>Region Origin</b></th><th><b>Branch Origin</b></th><th><b>Destination Region</b></th></th><th><b>Item Number</b><b>Track Number</b></th><th><b>Amount (Tsh.)</b></th><th>Action</th></tr>";
                $alltotal = 0;
                foreach ($listbulk as $key => $value) {

                  $alltotal =$alltotal + $value->paidamount;
                  echo "<tr style='width:100%;color:#343434;'><td>".$value->receiver_fullname."<td>".$value->sender_fullname."<td>".$value->sender_region."<td>".$value->sender_branch."</td><td>".$value->receiver_region."</td> <td>".$value->acc_no."</td><td>".$value->track_number."</td> <td>".number_format($value->paidamount,2)."</td><td>
                    <button  class='btn btn-info Delete' onclick=Deletevalue(); type='button'   id='Delete'>Delete </button>
                    </td></tr>";
                }  

              
               
               echo" <tr style='width:100%;color:#023020;'><td></td><td></td><td></td><td></td><td></td><td></td><td><b>Total Price:</b></td><td><b>".number_format($alltotal,2)."</b></td></tr>
                </table>
                <input type='hidden' name ='serial' value=".$serial." class='serial'>
                 <input type='hidden' name ='operator' value=".$operator." class='operator'>
                  <input type='hidden' name ='senders' value=".$senderid." id='senders' class='senders'>
                   
                        ";

          // $this->session->set_flashdata('success','Deleted Successfull');
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
             $data['region'] = $this->employee_model->regselect();

            if (!empty($check)) {

                if (!empty($this->input->post('backofice'))) {

                    for ($i=0; $i <@sizeof($check) ; $i++) {

                      $id = $check[$i];
                      $checkPay = $this->Parcel_model->check_paymentParcInter($id);
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

                 $this->load->view('parcel/parcels-international-application-list',$data);
                    
                // $this->load->view('inlandMails/register-application-list',$data);

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
                   
                $data['list'] = $this->parcel_model->search_application_list2($date,$month,$region,$branch,$status);
                $data['sum']  = $this->parcel_model->get_parcel_post_sum_search2($date,$month,$region,$branch,$status);
               }else
               {
                      $data['list'] = $this->parcel_model->search_application_list2($date,$month,$region,$branch,$status);
                          $data['sum']  = $this->parcel_model->get_parcel_post_sum_search2($date,$month,$region,$branch,$status);

               }

                    // $data['list'] = $this->parcel_model->search_application_list($date,$month,$region,$branch);
                    // $data['sum']  = $this->parcel_model->get_parcel_post_sum_search($date,$month,$region,$branch);
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
         if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/air_mails_domestic_application_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Air Mails Domestic Application');
            $this->load->view('parcel/air-mails-domestic-form');
        }else{
            redirect(base_url());
        }

    }

     public function air_mails_tariff_domestic_form(){
         if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/air_mails_domestic_application_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Air Mails Domestic Application');
            $this->load->view('parcel/air-mails-tarrif-domestic-form');
        }else{
            redirect(base_url());
        }

    }

      public function air_mails_Advertising_domestic_form(){
         if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/air_mails_domestic_advertising_application_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){

            $this->session->set_userdata('heading','Air Mails Advertising Application');
            $this->load->view('parcel/air_mails_Advertising_domestic_form');
        }else{
            redirect(base_url());
        }

    }

    public function air_mails_international_form(){
         if($this->session->userdata('user_type') =='ACCOUNTANT' ||
         $this->session->userdata('user_type') =='ACCOUNTANT-HQ'){ 

          redirect(base_url('Parcel/air_mails_international_application_list'));

         }
        elseif ($this->session->userdata('user_login_access') == 1){

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
           $status= $this->input->post('status');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->Parcel_model->get_air_mails_international_application_list_search($date,$month,$region,$status);
               

           } else 
           {

            $data['list'] = $this->Parcel_model->get_air_mails_international_application_list();

           }


           
           $this->load->view('parcel/air-mails-international_List',$data);
        } else {
            redirect(base_url());
        }
        
    }


     public function air_mails_domestic_advertising_application_list()
    {
        
        if ($this->session->userdata('user_login_access') != false) {

           $data['region'] = $this->employee_model->regselect();
           $date = $this->input->post('date');
           $month= $this->input->post('month');
           $region= $this->input->post('region');
            $status= $this->input->post('status');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->Parcel_model->get_air_mails_domestic_advertising_application_list_search($date,$month,$region,$status);
               

           } else 
           {

            $data['list'] = $this->Parcel_model->get_air_mails_domestic_advertising_application_list();

           }


           
           $this->load->view('parcel/air-mails-advertising-domestic_List',$data);
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
            $status= $this->input->post('status');

           if (!empty($month) || !empty($date) || !empty($region) ) {
                $data['list'] = $this->Parcel_model->get_air_mails_domestic_application_list_search($date,$month,$region,$status);
               

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



public function Save_air_mails_tariff_domestic()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $StampDetails = $this->input->post('StampDetails');
            $itemname = $this->input->post('StampDetails');
            $weight = $this->input->post('weight');
              $name = $this->input->post('name');
             $Currency = 'TZS';
            // $Amount = $this->input->post('Amount');
            // $price = $Amount;
            $mobile = $this->input->post('s_mobile');

            $type = 'Priority';
           $Totalprice =0;   $Totalvat = 0;
            if($itemname == 'Aerogramme'){
                 $price = $this->parcel_model->mail_tariff_noweight_price($itemname,$type);
                 $Totalprice =$price->tarrif; 
                    $Totalvat = $price->vat;
            }
            else if($itemname == 'Printed Matter/Book Post'){
                if($weight > 5){
                    $diff = $weight - 5;
                    if($diff > 15){ $diff = 15;}
                    $diffprice=0;
                    $diffvat=0;
                    if($type == 'Priority'){ $diffprice=(int)$diff * 3559;$diffvat=(int)$diff * 641;}
                    else{$diffprice=(int)$diff * 2119; $diffvat=(int)$diff * 381;}
                     $weight2=5;
                    $pricelist = $this->parcel_model->mail_tariff_price($itemname,$type,$weight2);
                    $Totalprice =$diffprice + $pricelist->tarrif; 
                    $Totalvat =$diffvat + $pricelist->vat; 

                }else{
                    $pricelist = $this->parcel_model->mail_tariff_price($itemname,$type,$weight);
                     $Totalprice =$pricelist->tarrif; 
                    $Totalvat = $pricelist->vat; 
                }
            }else{ 
                 if($itemname == 'Letters' && $weight > 2 ){ $weight = 2;}
                 if($itemname == 'News papers' && $weight > 3 ){ $weight = 3;}
                 if($itemname == 'Small packets/Sample/photocopy materials' && $weight > 1 ){ $weight = 1;}
                    if($itemname == 'Literature for the blind' && $weight > 10 ){ $weight = 10;}
                $pricelist = $this->parcel_model->mail_tariff_price($itemname,$type,$weight);
                    $Totalprice =$pricelist->tarrif; 
                    $Totalvat = $pricelist->vat; }



            $vat = $Totalvat;
            $mailprice = $Totalprice;
            $totalPrice = $vat + $mailprice;
            $price = $totalPrice;
          

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
             'Customer_name'=>$name,
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



            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $name;
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


public function Save_air_mails_advertising_domestic()
    {
        if ($this->session->userdata('user_login_access') != false) {
           
            $StampDetails = $this->input->post('StampDetails');
            //$StampDetails = $this->input->post('StampDetails');
             $Currency = 'TZS';
            // $Amount = $this->input->post('Amount');
            // $price = $Amount;
            $mobile = $this->input->post('s_mobile');
             $name = $this->input->post('name');
            $quantity = $this->input->post('quantity');
            $type = 'Priority';
            $pricelist = $this->parcel_model->advertising_mail_tariff_price($StampDetails,$type);

            $vat = $pricelist->vat;
            $mailprice = $pricelist->tarrif *  $quantity;
            $totalPrice = $vat + $mailprice;
            $price = $totalPrice;
          

            $id = $this->session->userdata('user_login_id');
            $info = $this->employee_model->GetBasic($id);
            $o_region = $info->em_region;
            $o_branch = $info->em_branch;
              $user = $info->em_code.'  '.$info->first_name.' '.$info->middle_name.' '.$info->last_name;
                $location= $info->em_region.' - '.$info->em_branch;

                 $source = $this->employee_model->get_code_source($o_region);

            $bagsNo = $source->reg_code;
            $serial    = 'MAIL'.'ADV'.date("YmdHis").$source->reg_code;


             $data = array();
             $data = array(

            'serial'=>$serial,
            'item'=>$StampDetails,
            'Customer_mobile'=>$mobile,
             'Customer_name'=>$name,
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
            $paidamount = $price;
            $region = $o_region;
            $district = $o_branch;
            $renter   = $name;
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

                $this->load->view('parcel/air-mails-advertising-control_number',$data);
            }else{
                redirect('Parcel/air_mails_domestic_advertising_application_list');
            }


        } else {
            redirect(base_url());
        }    
}



public function mailtarrif_price_vat()
{
if ($this->session->userdata('user_login_access') != false)
{
$itemname = $this->input->post('StampDetails');
$weight = $this->input->post('weight');
$acc_no = $this->input->post('acc_no');

$type = 'Priority';
 $Totalprice =0;   $Totalvat = 0;
 if($itemname == 'Aerogramme'){
                 $price = $this->parcel_model->mail_tariff_noweight_price($itemname,$type);
                 $Totalprice =$price->tarrif; 
                    $Totalvat = $price->vat;
            }
            else if($itemname == 'Printed Matter/Book Post'){
                if($weight > 5){
                    $diff = $weight - 5;
                    if($diff > 15){ $diff = 15;}
                    $diffprice=0;
                    $diffvat=0;
                    if($type == 'Priority'){ $diffprice=(int)$diff * 3559;$diffvat=(int)$diff * 641;}
                    else{$diffprice=(int)$diff * 2119; $diffvat=(int)$diff * 381;}
                     $weight2=5;
                    $price = $this->parcel_model->mail_tariff_price($itemname,$type,$weight2);
                    $Totalprice =$diffprice + $price->tarrif; 
                    $Totalvat =$diffvat + $price->vat; 

                }else{
                    $price = $this->parcel_model->mail_tariff_price($itemname,$type,$weight);
                     $Totalprice =$price->tarrif; 
                    $Totalvat = $price->vat; 
                }
            }else{ 
                if($itemname == 'Letters' && $weight > 2 ){ $weight = 2;}
                 if($itemname == 'News papers' && $weight > 3 ){ $weight = 3;}
                 if($itemname == 'Small packets/Sample/photocopy materials' && $weight > 1 ){ $weight = 1;}
                    if($itemname == 'Literature for the blind' && $weight > 10 ){ $weight = 10;}

                $price = $this->parcel_model->mail_tariff_price($itemname,$type,$weight);
                    $Totalprice =$price->tarrif; 
                    $Totalvat = $price->vat; }
//$price = $this->parcel_model->mail_tariff_price($itemname,$type,$weight);


if (empty($price)) {

    if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2'>Charges</th></tr>
    <tr><td><b>Price:</b></td><td>0</td></tr>
    <tr><td><b>Vat:</b></td><td>0</td></tr>
    <tr><td><b>Total Price:</b></td><td>0</td></tr>
    </table><br />";

}else{

    $vat = $Totalvat;
    $mailprice = $Totalprice;
    $totalPrice = $vat + $mailprice;
     
     if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".$mailprice."</td></tr>
    <tr><td><b>Vat:</b></td><td>".$vat."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />
        
            ";

            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$vat' class='price1'>
            // <input type='text' name ='price2' value='$emsprice' class='price1'>

}


}else{
redirect(base_url());
}
}




public function mailtarrif_advertising_price_vat()
{
if ($this->session->userdata('user_login_access') != false)
{
$itemname = $this->input->post('StampDetails');
$quantity = $this->input->post('quantity');
$acc_no = $this->input->post('acc_no');

$type = 'Priority';
$price = $this->parcel_model->advertising_mail_tariff_price($itemname,$type);


if (empty($price)) {

    if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2'>Charges</th></tr>
    <tr><td><b>Price:</b></td><td>0</td></tr>
    <tr><td><b>Quantity:</b></td><td>0</td></tr>
    <tr><td><b>Total Price:</b></td><td>0</td></tr>
    </table><br />";

}else{

    //$vat = $price->vat;
    $mailprice = $price->tarrif;
    $totalPrice =  $mailprice  *$quantity ;
     
     if($acc_no=="POSTPAID-1651"){ echo "TBS TANZANIA SPECIAL TARIFF";}
    echo "<table style='width:100%;color:#c31f26;' class='table table-bordered'>
    <tr><th colspan='2' style=''>Charges</th></tr>
    <tr><th>Description</th><th>Amount (Tsh.)</th></tr>
    <tr><td><b>Price:</b></td><td>".$mailprice."</td></tr>
    <tr><td><b>Quantity:</b></td><td>".$quantity."</td></tr>
    <tr><td><b>Total Price:</b></td><td>".number_format($totalPrice)."</td></tr>
    </table><br />
        
            ";

            // <input type='text' name ='price1' value='$totalPrice' class='price1'>
            // <input type='text' name ='vat' value='$vat' class='price1'>
            // <input type='text' name ='price2' value='$emsprice' class='price1'>

}


}else{
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